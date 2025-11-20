<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
                'phone' => '01733172007',
                'address' => 'Mirpur-11',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // Get the categories that were created by CategorySeeder
        $softwareCategory = Category::where('name', 'Software Development')->first();
        $designCategory = Category::where('name', 'Design & Creative')->first();
        $marketingCategory = Category::where('name', 'Marketing')->first();

        // If categories don't exist yet, create them
        if (!$softwareCategory) {
            $softwareCategory = Category::create([
                'name' => 'Software Development',
                'description' => 'Jobs related to software engineering, programming, and development',
                'icon' => 'fa-solid fa-code',
                'color' => '#3B82F6',
                'sort_order' => 1,
            ]);
        }

        if (!$designCategory) {
            $designCategory = Category::create([
                'name' => 'Design & Creative',
                'description' => 'Graphic design, UI/UX, and creative roles',
                'icon' => 'fa-solid fa-palette',
                'color' => '#EF4444',
                'sort_order' => 2,
            ]);
        }

        $companies = [
            [
                'user_id' => 3,
                'category_id' => $softwareCategory->id,
                'name' => 'TechCorp Solutions',
                'email' => 'careers@techcorp.com',
                'phone' => '+1 (555) 123-4567',
                'website' => 'https://techcorp.com',
                'about' => 'TechCorp Solutions is a leading technology company specializing in enterprise software solutions, cloud computing, and digital transformation services. We help businesses innovate and grow through cutting-edge technology.',
                'location' => 'San Francisco, CA',
                'address' => '123 Tech Avenue',
                'city' => 'San Francisco',
                'state' => 'California',
                'country' => 'USA',
                'postal_code' => '94105',
                'employees_range' => 501,
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
                'category_id' => $designCategory->id,
                'name' => 'Fareast Knitting and Dyeing Industry Limited',
                'email' => 'info@fekdil.com',
                'phone' => '+1 (555) 234-5678',
                'website' => 'https://fareastknit.com/',
                'about' => 'Our main asset is our people, without whom Far East would not be where it is today, nor could it continue to remain as a market leader. We take utmost care to ensure that our workers are well compensated and that they have an excellent work environment. The workers are provided with free meals, in-house medical facility as well as a child-care facility.',
                'location' => 'Denver, CO',
                'address' => '456 Green Street',
                'city' => 'Denver',
                'state' => 'Colorado',
                'country' => 'USA',
                'postal_code' => '80202',
                'employees_range' => 201,
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
            Company::firstOrCreate(
                ['email' => $company['email']],
                $company
            );
        }

        $this->command->info('Successfully seeded ' . count($companies) . ' companies.');
    }
}
