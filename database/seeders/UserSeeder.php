<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Use DB transaction to ensure roles are created first
        DB::transaction(function () {
            // Create roles first
            $roles = [
                ['name' => 'Administrator', 'slug' => 'admin', 'description' => 'System administrator'],
                ['name' => 'Employer', 'slug' => 'employer', 'description' => 'Company employer who posts jobs'],
                ['name' => 'Job Seeker', 'slug' => 'job-seeker', 'description' => 'Job seeker who applies for jobs'],
            ];

            foreach ($roles as $roleData) {
                Role::firstOrCreate(
                    ['slug' => $roleData['slug']],
                    $roleData
                );
            }

            // Get the roles after creation
            $adminRole = Role::where('slug', 'admin')->first();
            $employerRole = Role::where('slug', 'employer')->first();
            $seekerRole = Role::where('slug', 'job-seeker')->first();

            // Create employer user
            $employer = User::firstOrCreate(
                ['email' => 'employer@jobportal.test'],
                [
                    'name' => 'Employer User',
                    'phone' => '01733172007',
                    'address' => 'Mirpur-11',
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ]
            );
            $employer->roles()->attach($employerRole->id);

            // Create job seeker user
            $seeker = User::firstOrCreate(
                ['email' => 'seeker@jobportal.test'],
                [
                    'name' => 'Job Seeker',
                    'phone' => '01733172006',
                    'address' => 'Mirpur,Kalshi',
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ]
            );
            $seeker->roles()->attach($seekerRole->id);

            // Create admin user
            $admin = User::firstOrCreate(
                ['email' => 'admin@mail.com'],
                [
                    'name' => 'Administrator',
                    'phone' => '01332523325',
                    'address' => 'Gulshan-1',
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ]
            );
            $admin->roles()->attach($adminRole->id);
        });

        $this->command->info('Successfully seeded users with roles.');
    }
}
