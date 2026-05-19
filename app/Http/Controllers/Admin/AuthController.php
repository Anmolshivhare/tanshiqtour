<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\UserHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\LoginRequest;
use App\Http\Requests\Admin\User\UpdatePasswordRequest;
use App\Http\Requests\Admin\User\UpdateUserProfileRequest;
use App\Repositories\UserRepository;
use DB;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        // $this->middleware(['permission:edit-user-profile'], ['only' => ['edit', 'update']]);
    }

    /**
     * function to open the login view
     *
     * @return void
     */
    public function loginView()
    {
        return view('admin.auth.login');
    }

    /**
     * Handling login request.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        $remember_me = $request->has('remember_me') ? true : false;
        if (auth()->attempt($credentials, $remember_me)) {
            if (auth()->user()->status == config('constants.in_active_status_value')) {
                auth()->guard('web')->logout();
                $request->session()->invalidate();

                return redirect('admin/login')->with('error', trans('app.auth.login.inactive_access'));
            }
            $request->session()->regenerate();
            return redirect()->intended('admin/dashboard');
        } else {
            return redirect()->back()->with('error', trans('app.auth.login.invalid_login_detail'))->withInput();
        }
    }


    /**
     * Log the user out of the application.
     */
    public function logout(Request $request): RedirectResponse
    {
        auth()->guard('web')->logout();
        $request->session()->invalidate();
        return redirect('/admin/login');
    }

    /**
     * Handle the edit profile.
     *
     * Validates and edit the user's profile information.
     */
    public function editProfile()
    {
        $loggedInUser = UserHelper::getLoggedInUser()->id;
        $user = $this->userRepository->getDataById($loggedInUser);
        return view('admin.auth.profile', compact('user'));
    }


    /**
     * Handle the change password.
     *
     * Validates and user change password.
     */
    public function changePassword()
    {
        return view('admin.auth.change-password');
    }

    /**
     * Handle the update password request.
     *
     * Validates and updates the user's password.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(UpdateUserProfileRequest $request, $id)
    {

        try {
            $user = $this->userRepository->getDataById($id);
            if (!$user) {
                return redirect()->back()->with('error', __('labels.user_not_found'))->withInput();
            }
            $roleId = optional($user->roles->first())->id;
            $requestData = $this->userRepository->getDataFromRequest($request);
            if ($request->hasFile('profile_pic')) {
                $user = $this->userRepository->getDataById($id);
                $destinationPath = 'profile_images';
                $filename = $user->profile_pic;
                if (!empty($user->profile_pic)) {
                    UserHelper::deleteImage($destinationPath, $filename);
                }
                $requestData['profile_pic'] = basename(UserHelper::uploadImage($request->file('profile_pic'), $destinationPath));
            }
            DB::beginTransaction();
            $this->userRepository->updateData($id, $requestData);
            DB::commit();
            return redirect('admin/dashboard')->with('message', trans('app.data_updated', ['action' => __('labels.user_profile')]));
        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', $exception->getMessage())->withInput();
        }
    }


    public function updatePassword(UpdatePasswordRequest $request)
    {
        $requestData = $this->userRepository->getDataFromRequest($request);
        $requestData = ['password' => $requestData['password']];
        try {
            DB::beginTransaction();
            $userId = UserHelper::getLoggedInUser()->id;
            $this->userRepository->updateData($userId, $requestData);
            DB::commit();
            return redirect('admin/dashboard')->with('message', trans('app.data_updated', ['action' => __('labels.password')]));
        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', $exception->getMessage())->withInput();
        }
    }
}
