<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Tenant;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class InitialSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Roles
        $adminRole = Role::firstOrCreate(
        ['slug' => 'super_admin'],
        [
            'name' => 'Super Admin',
            'description' => 'Full system access',
        ]
        );

        $tenantAdminRole = Role::firstOrCreate(
        ['slug' => 'tenant_admin'],
        [
            'name' => 'Tenant Admin',
            'description' => 'Manage tenant surveys',
        ]
        );

        // 2. Permissions
        $permissions = [
            ['name' => 'Manage Surveys', 'slug' => 'surveys.manage'],
            ['name' => 'View Analytics', 'slug' => 'analytics.view'],
            ['name' => 'Manage Users', 'slug' => 'users.manage'],
        ];

        foreach ($permissions as $perm) {
            $p = Permission::firstOrCreate(['slug' => $perm['slug']], $perm);

            if (!$adminRole->permissions()->where('slug', $p->slug)->exists()) {
                $adminRole->permissions()->attach($p->id);
            }

            if ($perm['slug'] !== 'users.manage') {
                if (!$tenantAdminRole->permissions()->where('slug', $p->slug)->exists()) {
                    $tenantAdminRole->permissions()->attach($p->id);
                }
            }
        }

        // 3. Create 2 Users

        // User 1: Super Admin
        $superAdmin = User::firstOrCreate(
        ['email' => 'superadmin@survei.test'],
        [
            'uuid' => (string)Str::uuid(),
            'name' => 'Super Administrator',
            'password' => Hash::make('Password123!'),
        ]
        );

        if (!$superAdmin->roles()->where('slug', $adminRole->slug)->exists()) {
            $superAdmin->roles()->attach($adminRole->id);
        }

        // User 2: Admin Instansi
        $tenantAdmin = User::firstOrCreate(
        ['email' => 'petugas@bandung.go.id'],
        [
            'uuid' => (string)Str::uuid(),
            'name' => 'Petugas Admin Wilayah',
            'password' => Hash::make('Password123!'),
        ]
        );

        if (!$tenantAdmin->roles()->where('slug', $tenantAdminRole->slug)->exists()) {
            $tenantAdmin->roles()->attach($tenantAdminRole->id);
        }

        // 4. Primary Tenant
        $tenant = Tenant::firstOrCreate(
        ['slug' => 'dpmptsp-bandung'],
        [
            'uuid' => (string)Str::uuid(),
            'name' => 'DPMPTSP Kota Bandung',
            'status' => 'active',
        ]
        );

        // Attach Petugas to DPMPTSP
        if (!$tenant->users()->where('user_id', $tenantAdmin->id)->exists()) {
            $tenant->users()->attach($tenantAdmin->id, ['roles' => json_encode(['tenant_admin'])]);
        }
    }
}