<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ── User Management ──────────────────────────────────────────────────────
        $userManagementPermission = Permission::create(['name' => 'user-management']);
        Permission::create(['name' => 'role-list',        'parent_id' => $userManagementPermission->id]);
        Permission::create(['name' => 'role-create',      'parent_id' => $userManagementPermission->id]);
        Permission::create(['name' => 'role-edit',        'parent_id' => $userManagementPermission->id]);
        Permission::create(['name' => 'role-delete',      'parent_id' => $userManagementPermission->id]);
        Permission::create(['name' => 'role-show',        'parent_id' => $userManagementPermission->id]);
        Permission::create(['name' => 'permission-list',  'parent_id' => $userManagementPermission->id]);
        Permission::create(['name' => 'permission-create','parent_id' => $userManagementPermission->id]);
        Permission::create(['name' => 'permission-edit',  'parent_id' => $userManagementPermission->id]);
        Permission::create(['name' => 'permission-delete','parent_id' => $userManagementPermission->id]);
        Permission::create(['name' => 'permission-show',  'parent_id' => $userManagementPermission->id]);
        Permission::create(['name' => 'user-list',        'parent_id' => $userManagementPermission->id]);
        Permission::create(['name' => 'user-create',      'parent_id' => $userManagementPermission->id]);
        Permission::create(['name' => 'user-delete',      'parent_id' => $userManagementPermission->id]);
        Permission::create(['name' => 'user-edit',        'parent_id' => $userManagementPermission->id]);
        Permission::create(['name' => 'user-show',        'parent_id' => $userManagementPermission->id]);

        // ── Settings ─────────────────────────────────────────────────────────────
        $settingPerm = Permission::create(['name' => 'setting-management']);
        Permission::create(['name' => 'setting-list', 'parent_id' => $settingPerm->id]);
        Permission::create(['name' => 'setting-edit', 'parent_id' => $settingPerm->id]);

        // ── Destinations ─────────────────────────────────────────────────────────
        $destPerm = Permission::create(['name' => 'destination-management']);
        Permission::create(['name' => 'destination-list',   'parent_id' => $destPerm->id]);
        Permission::create(['name' => 'destination-create', 'parent_id' => $destPerm->id]);
        Permission::create(['name' => 'destination-edit',   'parent_id' => $destPerm->id]);
        Permission::create(['name' => 'destination-delete', 'parent_id' => $destPerm->id]);
        Permission::create(['name' => 'destination-show',   'parent_id' => $destPerm->id]);

        // ── Tours ─────────────────────────────────────────────────────────────────
        $tourPerm = Permission::create(['name' => 'tour-management']);
        Permission::create(['name' => 'tour-list',   'parent_id' => $tourPerm->id]);
        Permission::create(['name' => 'tour-create', 'parent_id' => $tourPerm->id]);
        Permission::create(['name' => 'tour-edit',   'parent_id' => $tourPerm->id]);
        Permission::create(['name' => 'tour-delete', 'parent_id' => $tourPerm->id]);
        Permission::create(['name' => 'tour-show',   'parent_id' => $tourPerm->id]);

        // ── Reviews ───────────────────────────────────────────────────────────────
        $reviewPerm = Permission::create(['name' => 'review-management']);
        Permission::create(['name' => 'review-list',    'parent_id' => $reviewPerm->id]);
        Permission::create(['name' => 'review-show',    'parent_id' => $reviewPerm->id]);
        Permission::create(['name' => 'review-approve', 'parent_id' => $reviewPerm->id]);
        Permission::create(['name' => 'review-delete',  'parent_id' => $reviewPerm->id]);

        // ── Gallery ───────────────────────────────────────────────────────────────
        $galleryPerm = Permission::create(['name' => 'gallery-management']);
        Permission::create(['name' => 'gallery-list',   'parent_id' => $galleryPerm->id]);
        Permission::create(['name' => 'gallery-create', 'parent_id' => $galleryPerm->id]);
        Permission::create(['name' => 'gallery-edit',   'parent_id' => $galleryPerm->id]);
        Permission::create(['name' => 'gallery-delete', 'parent_id' => $galleryPerm->id]);

        // ── Blog Categories ───────────────────────────────────────────────────────
        $blogCatPerm = Permission::create(['name' => 'blog-category-management']);
        Permission::create(['name' => 'blog-category-list',   'parent_id' => $blogCatPerm->id]);
        Permission::create(['name' => 'blog-category-create', 'parent_id' => $blogCatPerm->id]);
        Permission::create(['name' => 'blog-category-edit',   'parent_id' => $blogCatPerm->id]);
        Permission::create(['name' => 'blog-category-delete', 'parent_id' => $blogCatPerm->id]);

        // ── Blog Posts ────────────────────────────────────────────────────────────
        $blogPerm = Permission::create(['name' => 'blog-management']);
        Permission::create(['name' => 'blog-list',   'parent_id' => $blogPerm->id]);
        Permission::create(['name' => 'blog-create', 'parent_id' => $blogPerm->id]);
        Permission::create(['name' => 'blog-edit',   'parent_id' => $blogPerm->id]);
        Permission::create(['name' => 'blog-delete', 'parent_id' => $blogPerm->id]);
        Permission::create(['name' => 'blog-show',   'parent_id' => $blogPerm->id]);

        // ── Enquiries ─────────────────────────────────────────────────────────────
        $enquiryPerm = Permission::create(['name' => 'enquiry-management']);
        Permission::create(['name' => 'enquiry-list',   'parent_id' => $enquiryPerm->id]);
        Permission::create(['name' => 'enquiry-show',   'parent_id' => $enquiryPerm->id]);
        Permission::create(['name' => 'enquiry-reply',  'parent_id' => $enquiryPerm->id]);
        Permission::create(['name' => 'enquiry-delete', 'parent_id' => $enquiryPerm->id]);

        // ── Assign all permissions to Super Admin & Admin ──────────────────────
        $superAdmin = Role::create(['guard_name' => 'web', 'name' => config('constants.super_admin_role_name')]);
        $superAdmin->givePermissionTo(Permission::all());

        $adminRole = Role::create(['guard_name' => 'web', 'name' => config('constants.admin_role_name')]);
        $adminRole->givePermissionTo(Permission::all());
    }
}
