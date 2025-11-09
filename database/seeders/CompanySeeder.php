<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create a default user for companies
        $user = User::firstOrCreate(
            ['email' => 'employer@jobportal.test'],
            [
                'name' => 'Employer User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $companies = [
            [
                'user_id' => $user->id,
                'name' => 'TechCorp Solutions',
                'email' => 'careers@techcorp.com',
                'phone' => '+1 (555) 123-4567',
                'website' => 'https://techcorp.com',
                'about' => 'TechCorp Solutions is a leading technology company specializing in enterprise software solutions, cloud computing, and digital transformation services. We help businesses innovate and grow through cutting-edge technology.',
                'industry' => 'Technology',
                'location' => 'San Francisco, CA',
                'address' => '123 Tech Avenue',
                'city' => 'San Francisco',
                'state' => 'California',
                'country' => 'USA',
                'postal_code' => '94105',
                'employees_count' => 501,
                'founded_year' => 2010,
                'facebook_url' => 'https://facebook.com/techcorp',
                'twitter_url' => 'https://twitter.com/techcorp',
                'linkedin_url' => 'https://linkedin.com/company/techcorp',
                'instagram_url' => 'https://instagram.com/techcorp',
                'is_verified' => true,
                'is_active' => true,
            ],
            [
                'user_id' => $user->id,
                'name' => 'Fareast Knitting and Dyeing Industry Limited',
                'email' => 'info@fekdil.com',
                'phone' => '+1 (555) 234-5678',
                'website' => 'https://fareastknit.com/',
                'about' => 'Our main asset is our people, without whom Far East would not be where it is today, nor could it continue to remain as a market leader. We take utmost care to ensure that our workers are well compensated and that they have an excellent work environment. The workers are provided with free meals, in-house medical facility as well as a child-care facility.',
                'industry' => 'Gurment',
                'location' => 'Denver, CO',
                'address' => '456 Green Street',
                'city' => 'Denver',
                'state' => 'Colorado',
                'country' => 'USA',
                'postal_code' => '80202',
                'employees_count' => 201,
                'founded_year' => 2015,
                'facebook_url' => 'https://facebook.com/greenenergy',
                'twitter_url' => 'https://twitter.com/greenenergy',
                'linkedin_url' => 'https://linkedin.com/company/greenenergy',
                'instagram_url' => 'https://instagram.com/greenenergy',
                'is_verified' => true,
                'is_active' => true,
            ],
        ];

        foreach ($companies as $company) {
            Company::create($company);
        }

        $this->command->info('Successfully seeded ' . count($companies) . ' companies.');
    }
}
