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
                'name' => 'Admin',
                'slug' => 'admin',
                'description' => 'Administrator with full access'
            ],
            [
                'name' => 'Employer',
                'slug' => 'employer',
                'description' => 'Can post and manage jobs'
            ],
            [
                'name' => 'Job Seeker',
                'slug' => 'job-seeker',
                'description' => 'Can apply for jobs'
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['slug' => $role['slug']],
                $role
            );
        }

        $this->command->info('Successfully seeded/updated roles.');
    }
}
