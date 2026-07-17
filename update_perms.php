<?php

$newPermissions = [
    ['name' => 'Manage Coupons', 'slug' => 'manage-coupons', 'description' => 'Can create, edit, and delete coupons.'],
    ['name' => 'Manage Packages', 'slug' => 'manage-packages', 'description' => 'Can configure packages.'],
    ['name' => 'Manage Pricing', 'slug' => 'manage-pricing', 'description' => 'Can set up pricing and slots.'],
    ['name' => 'View Permissions', 'slug' => 'view-permissions', 'description' => 'Can view system permissions.'],
];

foreach ($newPermissions as $p) {
    if (!\Illuminate\Support\Facades\DB::table('permissions')->where('slug', $p['slug'])->exists()) {
        $pId = \Illuminate\Support\Facades\DB::table('permissions')->insertGetId([
            'name' => $p['name'],
            'slug' => $p['slug'],
            'description' => $p['description'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // Give these new permissions to super-admin
        $superAdmin = \Illuminate\Support\Facades\DB::table('roles')->where('slug', 'super-admin')->first();
        if ($superAdmin) {
            \Illuminate\Support\Facades\DB::table('role_permission')->insert([
                'role_id' => $superAdmin->id,
                'permission_id' => $pId
            ]);
        }
    }
}
echo "Permissions added successfully.\n";
