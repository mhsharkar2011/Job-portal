<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'name' => 'Super Admin',
                'slug' => 'super-admin',
                'description' => 'Has full system access',
                'is_default' => false,
                'is_active' => true,
                'permissions' => ['*']
            ],
            [
                'name' => 'Admin',
                'slug' => 'admin',
                'description' => 'Administrative access',
                'is_default' => false,
                'is_active' => true,
                'permissions' => ['users.read', 'users.create', 'users.update']
            ],
            [
                'name' => 'User',
                'slug' => 'user',
                'description' => 'Regular user',
                'is_default' => true,
                'is_active' => true,
                'permissions' => ['profile.read', 'profile.update']
            ]
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['slug' => $role['slug']],
                array_merge($role, [
                    'updated_at' => now() // Always update the timestamp
                ])
            );
        }

        $this->command->info('Successfully seeded/updated roles.');
    }
}
