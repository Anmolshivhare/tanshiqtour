<?php

namespace App\Repositories;

use App\Models\User;

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
}