<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\Company;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'admin@mail.com')->first();
        $companies = Company::all();
        $categories = Category::all();

        if ($companies->isEmpty() || $categories->isEmpty()) {
            $this->command->error('Please run CompanySeeder and CategorySeeder first!');
            return;
        }

        $jobs = [
            [
                'user_id' => $user->id,
                'company_id' => $companies->first()->id,
                'category_id' => $categories->first()->id,
                'job_title' => 'Senior Software Engineer',
                'job_description' => 'We are looking for a skilled Senior Software Engineer to join our dynamic team. You will be responsible for developing and maintaining high-quality software solutions, collaborating with cross-functional teams, and contributing to architectural decisions.',
                'requirement' => 'Bachelor\'s degree in Computer Science or related field. 5+ years of experience in software development. Proficiency in JavaScript, Python, or Java. Experience with cloud platforms (AWS, Azure, or GCP). Strong understanding of software architecture and design patterns.',
                'location' => 'San Francisco, CA',
                'experience_minimum' => 5,
                'experience_maximum' => 8,
                'experience_unit' => 'years',
                'role' => 'Software Development',
                'employment_type' => 'full-time',
                'salary_minimum' => 120000,
                'salary_maximum' => 160000,
                'salary_currency' => 'USD',
                'key_skills' => 'JavaScript, Python, AWS, React, Node.js',
                'positions_available' => 2,
                'application_deadline' => Carbon::now()->addDays(30),
                'is_active' => true,
                'published_at' => now(),
            ],
            [
                'user_id' => $user->id,
                'company_id' => $companies->first()->id,
                'category_id' => $categories->first()->id,
                'job_title' => 'Registered Nurse',
                'job_description' => 'Join our healthcare team as a Registered Nurse. You will provide exceptional patient care, administer medications, monitor patient conditions, and collaborate with healthcare professionals to ensure the best outcomes.',
                'requirement' => 'Valid RN license. BSN degree preferred. 2+ years of nursing experience. BLS and ACLS certification. Excellent communication and critical thinking skills.',
                'location' => 'Boston, MA',
                'experience_minimum' => 2,
                'experience_maximum' => 5,
                'experience_unit' => 'years',
                'role' => 'Healthcare',
                'employment_type' => 'full-time',
                'salary_minimum' => 65000,
                'salary_maximum' => 85000,
                'salary_currency' => 'USD',
                'key_skills' => 'Patient Care, Medication Administration, Critical Thinking, Communication',
                'positions_available' => 5,
                'application_deadline' => Carbon::now()->addDays(21),
                'is_active' => true,
                'published_at' => now(),
            ],
            // Add more job entries as needed
        ];

        foreach ($jobs as $job) {
            Job::create($job);
        }

        $this->command->info('Successfully seeded ' . count($jobs) . ' jobs.');
    }
}
