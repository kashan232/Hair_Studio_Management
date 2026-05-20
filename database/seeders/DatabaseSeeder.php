<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Roles
        $roles = [
            ['name' => 'Super Admin', 'slug' => 'super-admin'],
            ['name' => 'Admin', 'slug' => 'admin'],
            ['name' => 'Receptionist', 'slug' => 'receptionist'],
            ['name' => 'Hairstylist', 'slug' => 'hairstylist'],
        ];

        $insertedRoles = [];
        foreach ($roles as $role) {
            $insertedRoles[$role['slug']] = DB::table('roles')->insertGetId([
                'name' => $role['name'],
                'slug' => $role['slug'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 2. Seed Permissions
        $permissions = [
            ['name' => 'Manage Users', 'slug' => 'manage-users', 'description' => 'Can create, edit, and delete system users.'],
            ['name' => 'Manage Roles & Permissions', 'slug' => 'manage-roles', 'description' => 'Can configure permissions assigned to roles.'],
            ['name' => 'Manage Chairs', 'slug' => 'manage-chairs', 'description' => 'Can manage physical chair availability.'],
            ['name' => 'Manage Bookings', 'slug' => 'manage-bookings', 'description' => 'Can manage chair reservations.'],
            ['name' => 'View Revenue & Analytics', 'slug' => 'view-revenue', 'description' => 'Can access financial reports and earnings.'],
            ['name' => 'View Reports', 'slug' => 'view-reports', 'description' => 'Can view stylist utilization and checkins.'],
        ];

        $insertedPermissions = [];
        foreach ($permissions as $p) {
            $insertedPermissions[$p['slug']] = DB::table('permissions')->insertGetId([
                'name' => $p['name'],
                'slug' => $p['slug'],
                'description' => $p['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 3. Assign Permissions to Roles (pivot table)
        // Super Admin gets all permissions
        foreach ($insertedPermissions as $pId) {
            DB::table('role_permission')->insert([
                'role_id' => $insertedRoles['super-admin'],
                'permission_id' => $pId
            ]);
        }

        // Admin gets most permissions except managing roles
        $adminPermissions = ['manage-users', 'manage-chairs', 'manage-bookings', 'view-revenue', 'view-reports'];
        foreach ($adminPermissions as $slug) {
            DB::table('role_permission')->insert([
                'role_id' => $insertedRoles['admin'],
                'permission_id' => $insertedPermissions[$slug]
            ]);
        }

        // Receptionist gets bookings and view-only permissions
        $receptionistPermissions = ['manage-bookings', 'manage-chairs', 'view-reports'];
        foreach ($receptionistPermissions as $slug) {
            DB::table('role_permission')->insert([
                'role_id' => $insertedRoles['receptionist'],
                'permission_id' => $insertedPermissions[$slug]
            ]);
        }

        // Hairstylist gets booking controls
        $stylistPermissions = ['manage-bookings'];
        foreach ($stylistPermissions as $slug) {
            DB::table('role_permission')->insert([
                'role_id' => $insertedRoles['hairstylist'],
                'permission_id' => $insertedPermissions[$slug]
            ]);
        }

        // 4. Seed Super Admin User
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt('123456'),
            'role_id' => $insertedRoles['super-admin'],
            'role' => 'super_admin', // keep legacy string temporarily
            'designation' => 'Super Admin',
            'joining_date' => '2026-05-19',
            'status' => 1,
        ]);
    }
}
