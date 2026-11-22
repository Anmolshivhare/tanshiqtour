<?php

namespace App\Http\Controllers\Front;

use App\Helpers\UserHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Front\FrontLoginRequest;
use App\Http\Requests\Front\FrontRegisterRequest;
use App\Http\Requests\Front\FrontProfileRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use DB;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class FrontAuthController extends Controller
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /** Route a Book Now click through sign-in before opening the tour details. */
    public function bookNow(string $slug): RedirectResponse
    {
        $detailsUrl = route('front.tour-details', ['slug' => $slug]);

        if ($this->userRepository->isFrontAuthenticated()) {
            return redirect()->to($detailsUrl);
        }

        return redirect()->route('front.login', ['redirect' => $detailsUrl]);
    }

    /**
     * Show login form
     */
    public function showLogin(Request $request)
    {
        // Store intended URL for redirect after login
        if ($request->has('redirect')) {
            session(['url.intended' => $request->get('redirect')]);
        }

        if ($this->userRepository->isFrontAuthenticated()) {
            return redirect()->intended(route('home'));
        }

        return view('front.auth.login');
    }

    /**
     * Handle login
     */
    public function login(FrontLoginRequest $request): RedirectResponse
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        $remember = $request->has('remember_me');

        if ($this->userRepository->attemptFrontLogin($credentials, $remember)) {
            if ($this->userRepository->currentFrontUser()->status == config('constants.in_active_status_value')) {
                $this->userRepository->logoutFrontUser();
                $request->session()->invalidate();
                return redirect()->route('front.login')->with('error', trans('app.auth.login.inactive_access'));
            }

            $request->session()->regenerate();
            return redirect()->intended(route('home'))->with('message', 'Welcome back!');
        }

        return redirect()->back()->with('error', 'Invalid email or password.')->withInput();
    }

    /** Start the Google OAuth authorization flow. */
    public function redirectToGoogle(Request $request): RedirectResponse
    {
        if (!config('services.google.client_id') || !config('services.google.client_secret') || !config('services.google.redirect')) {
            return redirect()->route('front.login')->with('error', 'Google sign-in is not configured yet.');
        }

        return Socialite::driver('google')->scopes(['openid', 'email', 'profile'])
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    /** Complete Google OAuth and sign in or create a customer account. */
    public function handleGoogleCallback(Request $request): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $googleProfile = $googleUser->getRaw();
            $email = Str::lower((string) $googleUser->getEmail());

            if (!$googleUser->getId() || !$email || !filter_var($email, FILTER_VALIDATE_EMAIL)
                || !($googleProfile['verified_email'] ?? $googleProfile['email_verified'] ?? false)) {
                return redirect()->route('front.login')->with('error', 'Google did not provide a verified email address.');
            }

            $user = DB::transaction(function () use ($googleUser, $email) {
                $user = User::where('google_id', $googleUser->getId())->first()
                    ?? User::whereRaw('LOWER(email) = ?', [$email])->first();

                if ($user && $user->google_id && $user->google_id !== $googleUser->getId()) {
                    throw new Exception('This email is linked to a different Google account.');
                }

                if (!$user) {
                    $user = User::create([
                        'name' => $googleUser->getName() ?: $email,
                        'email' => $email,
                        'google_id' => $googleUser->getId(),
                        'password' => null,
                        'is_email_verified' => true,
                        'email_verified_at' => now(),
                        'status' => config('constants.active_status_value', 1),
                    ]);
                    $user->assignRole(config('constants.customer_role_name', 'Customer'));
                } else {
                    $user->google_id = $googleUser->getId();
                    $user->is_email_verified = true;
                    $user->email_verified_at ??= now();
                    $user->save();
                }

                // The app's profile views expect a locally stored filename, not a remote URL.
                if (empty($user->profile_pic) && $googleUser->getAvatar()) {
                    $avatar = Http::timeout(10)->get($googleUser->getAvatar());
                    if ($avatar->successful() && str_starts_with((string) $avatar->header('Content-Type'), 'image/')) {
                        $filename = 'google_' . $user->id . '.jpg';
                        Storage::disk('public')->put('profile_images/' . $filename, $avatar->body());
                        $user->profile_pic = $filename;
                        $user->save();
                    }
                }

                return $user;
            });

            if ((string) $user->status === (string) config('constants.in_active_status_value')) {
                return redirect()->route('front.login')->with('error', trans('app.auth.login.inactive_access'));
            }

            // Keep Google sign-ins persistent across browser restarts.
            $this->userRepository->loginFrontUser($user, true);
            $request->session()->regenerate();

            return redirect()->intended(route('home'))->with('message', 'Signed in with Google successfully!');
        } catch (Exception $e) {
            report($e);
            return redirect()->route('front.login')->with('error', 'Google sign-in failed. Please try again.');
        }
    }

    /**
     * Show registration form
     */
    public function showRegister()
    {
        if ($this->userRepository->isFrontAuthenticated()) {
            return redirect()->route('home');
        }

        return view('front.auth.register');
    }

    /**
     * Handle registration
     */
    public function register(FrontRegisterRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            // Create user with customer role
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone_no' => $request->phone,
                'password' => Hash::make($request->password),
                'status' => config('constants.active_status_value', 1),
            ]);

            // Assign customer role
            $user->assignRole(config('constants.customer_role_name', 'customer'));

            DB::commit();

            // Auto login
            $this->userRepository->loginFrontUser($user);
            $request->session()->regenerate();

            return redirect()->intended(route('home'))->with('message', 'Registration successful! Welcome!');

        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Registration failed. Please try again.')->withInput();
        }
    }

    /**
     * Show profile edit form
     */
    public function showProfile()
    {
        if (!$this->userRepository->isFrontAuthenticated()) {
            return redirect()->route('front.login');
        }

        $user = $this->userRepository->currentFrontUser();
        return view('front.auth.profile', compact('user'));
    }

    /**
     * Update profile
     */
    public function updateProfile(FrontProfileRequest $request): RedirectResponse
    {
        try {
            $user = $this->userRepository->currentFrontUser();

            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'phone_no' => $request->phone,
                'address' => $request->address,
            ];

            $destinationPath = 'profile_images';

            // Handle cropped image (base64) - priority over file upload
            if ($request->filled('cropped_image')) {
                // Decode base64 image
                $croppedImage = $request->cropped_image;

                // Extract image data from base64 string
                if (preg_match('/^data:image\/(\w+);base64,/', $croppedImage, $matches)) {
                    $imageType = $matches[1];
                    $imageData = substr($croppedImage, strpos($croppedImage, ',') + 1);
                    $imageData = base64_decode($imageData);

                    // Validate image size (max 2MB)
                    if (strlen($imageData) > 2 * 1024 * 1024) {
                        return redirect()->back()->with('error', 'Image size cannot exceed 2MB.')->withInput();
                    }

                    // Validate mime type
                    $allowedTypes = ['jpeg', 'jpg', 'png'];
                    if (!in_array($imageType, $allowedTypes)) {
                        return redirect()->back()->with('error', 'Invalid image format. Allowed: jpeg, png, webp.')->withInput();
                    }

                    // Delete old image if exists
                    if (!empty($user->profile_pic)) {
                        UserHelper::deleteImage($destinationPath, $user->profile_pic);
                    }

                    // Generate unique filename
                    $fileName = 'profile_' . $user->id . '_' . time() . '.' . ($imageType === 'jpeg' ? 'jpg' : $imageType);

                    // Save image
                    Storage::disk('public')->put($destinationPath . '/' . $fileName, $imageData);

                    $data['profile_pic'] = $fileName;
                }
            }
            // Handle regular file upload (fallback)
            elseif ($request->hasFile('profile_pic')) {
                // Delete old image if exists
                if (!empty($user->profile_pic)) {
                    UserHelper::deleteImage($destinationPath, $user->profile_pic);
                }

                $data['profile_pic'] = basename(UserHelper::uploadImage($request->file('profile_pic'), $destinationPath));
            }

            DB::beginTransaction();
            $user->update($data);
            DB::commit();

            return redirect()->route('front.profile')->with('message', 'Profile updated successfully!');

        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update profile. Please try again.')->withInput();
        }
    }

    /**
     * Handle logout
     */
    public function logout(Request $request): RedirectResponse
    {
        $this->userRepository->logoutFrontUser();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('message', 'You have been logged out.');
    }
}
