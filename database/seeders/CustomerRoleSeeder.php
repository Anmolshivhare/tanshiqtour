<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class CustomerRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create customer management permissions
        $customerManagementPermission = Permission::firstOrCreate(['name' => 'customer-management']);
        Permission::firstOrCreate(['name' => 'customer-list', 'parent_id' => $customerManagementPermission->id]);
        Permission::firstOrCreate(['name' => 'customer-show', 'parent_id' => $customerManagementPermission->id]);

        // Create customer role (no admin permissions)
        $customerRole = Role::firstOrCreate([
            'guard_name' => 'web',
            'name' => config('constants.customer_role_name', 'customer')
        ]);

        // Assign customer management permissions to admin roles
        $adminRoles = Role::whereIn('name', [
            config('constants.super_admin_role_name'),
            config('constants.admin_role_name')
        ])->get();

        foreach ($adminRoles as $adminRole) {
            $adminRole->givePermissionTo(['customer-management', 'customer-list', 'customer-show']);
        }
    }
}
