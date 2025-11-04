<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create employer user
        User::firstOrCreate(
            ['email' => 'employer@jobportal.test'],
            [
                'name' => 'Employer User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // Create job seeker user
        User::firstOrCreate(
            ['email' => 'seeker@jobportal.test'],
            [
                'name' => 'Job Seeker',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // Create admin user
        User::firstOrCreate(
            ['email' => 'admin@jobportal.test'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Successfully seeded users.');
    }
}
