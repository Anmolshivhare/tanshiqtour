<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = User::updateOrCreate(
            ['email' => 'sadmin@admin.com'],
            [
                'name' => 'super admin',
                'date_of_birth' => '1996-11-14',
                'password' => 'Admin@123',
                'phone_no' => '01234567847',
                'profile_pic' => null,
                'status' => config('constants.active_status_value'),
            ]
        );
        $superAdmin->assignRole(config('constants.super_admin_role_name'));

        $admin = User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'admin',
                'date_of_birth' => '1998-11-14',
                'password' => 'Admin@123',
                'phone_no' => '0123456789',
                'profile_pic' => null,
                'status' => config('constants.active_status_value'),
            ]
        );
        $admin->assignRole(config('constants.admin_role_name'));
    }
}
