<?php
// app/Http/Controllers/HomeController.php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Category;
use App\Models\Job;

class HomeController extends Controller
{
    public function welcome()
    {
        $companies = Company::withCount('jobs')
            ->where('is_active', true)
            ->orderBy('jobs_count', 'ASC')
            ->limit(16)
            ->get();

        $categories = Category::withCount('jobs')
            ->where('is_active', true)
            ->orderBy('jobs_count', 'desc')
            ->get();

        $jobs = Job::with(['company', 'category'])
            ->where('is_active', true)
            ->where('application_deadline', '>', now())
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        $totalJobs = Job::where('is_active', true)->count();
        $totalCompanies = Company::where('is_active', true)->count();
        $newJobs = Job::where('is_active', true)->where('created_at', '>=', now()->subWeek())->count();

        return view('welcome', compact(
            'categories',
            'companies',
            'totalCompanies',
            'jobs',
            'totalJobs',
            'newJobs'
        ));
    }
}
