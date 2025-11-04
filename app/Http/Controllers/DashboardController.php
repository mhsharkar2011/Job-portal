<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Application;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->role === 'employer') {
            return $this->employerDashboard();
        } else {
            return $this->jobSeekerDashboard();
        }
    }

    private function employerDashboard()
    {
        $user = auth()->user();

        // Get employer's jobs
        $employerJobs = Job::where('user_id', $user->id);

        // Calculate statistics
        $totalJobs = $employerJobs->count();
        $totalApplications = Application::whereHas('job', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->count();

        $pendingApplications = Application::whereHas('job', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('status', 'pending')->count();

        // Get recent data
        $recentJobs = $employerJobs->withCount('applications')
                                  ->latest()
                                  ->take(5)
                                  ->get();

        $recentApplications = Application::whereHas('job', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with('job')
          ->latest()
          ->take(5)
          ->get();

        return view('dashboard', compact(
            'totalJobs',
            'totalApplications',
            'pendingApplications',
            'recentJobs',
            'recentApplications'
        ));
    }

    private function jobSeekerDashboard()
    {
        $user = auth()->user();

        // Get job seeker's applications
        $userApplications = Application::where('user_id', $user->id);

        // Calculate statistics - make sure these variable names match what's used in the blade file
        $totalApplications = $userApplications->count();
        $pendingApplications = $userApplications->where('status', 'pending')->count();
        $acceptedApplications = $userApplications->where('status', 'accepted')->count();
        $underReviewApplications = $userApplications->where('status', 'under_review')->count();

        // Get recent data
        $recentApplications = $userApplications->with('job')
                                ->latest()
                                ->take(5)
                                ->get();

        $featuredJobs = Job::withCount('applications')
                          ->latest()
                          ->take(6)
                          ->get();

        return view('dashboard', compact(
            'totalApplications',
            'pendingApplications',
            'acceptedApplications',
            'underReviewApplications',
            'recentApplications',
            'featuredJobs'
        ));
    }
}
