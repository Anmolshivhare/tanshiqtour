<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserRepository extends BaseRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * function to get the data from the request
     *
     * @param mixed $request
     * @return mixed
     */
    public function getDataFromRequest($request)
    {
        return $request->only(
            [
                'name',
                'email',
                'date_of_birth',
                'address',
                'password',
                'old_password',
                'phone_no',
                'date_of_birth',
                'address',
                'profile_pic',
                'gender',
                'role',
                'status',
            ]
        );
    }

    public function attemptFrontLogin(array $credentials, bool $remember = false): bool
    {
        return Auth::guard('web')->attempt($credentials, $remember);
    }

    public function currentFrontUser(): ?User
    {
        return Auth::guard('web')->user();
    }

    public function isFrontAuthenticated(): bool
    {
        return Auth::guard('web')->check();
    }

    public function loginFrontUser(User $user, bool $remember = false): void
    {
        Auth::guard('web')->login($user, $remember);
    }

    public function logoutFrontUser(): void
    {
        Auth::guard('web')->logout();
    }
}
