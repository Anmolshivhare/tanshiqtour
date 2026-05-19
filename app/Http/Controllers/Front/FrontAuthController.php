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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class FrontAuthController extends Controller
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
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

        if (Auth::check()) {
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

        if (Auth::attempt($credentials, $remember)) {
            if (Auth::user()->status == config('constants.in_active_status_value')) {
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                return redirect()->route('front.login')->with('error', trans('app.auth.login.inactive_access'));
            }

            $request->session()->regenerate();
            return redirect()->intended(route('home'))->with('message', 'Welcome back!');
        }

        return redirect()->back()->with('error', 'Invalid email or password.')->withInput();
    }

    /**
     * Show registration form
     */
    public function showRegister()
    {
        if (Auth::check()) {
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
            Auth::login($user);

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
        if (!Auth::check()) {
            return redirect()->route('front.login');
        }

        $user = Auth::user();
        return view('front.auth.profile', compact('user'));
    }

    /**
     * Update profile
     */
    public function updateProfile(FrontProfileRequest $request): RedirectResponse
    {
        try {
            $user = Auth::user();

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
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('message', 'You have been logged out.');
    }
}
