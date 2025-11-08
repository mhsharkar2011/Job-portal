<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Application;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            // You can add logic here to determine which admin view to show
            // For example, based on URL parameters or user preferences
            if (request()->has('view') && request('view') === 'settings') {
                return $this->adminDashboardSettings();
            } else {
                return $this->adminDashboardApplications();
            }
        } elseif ($user->role === 'employer') {
            return $this->employerDashboard();
        } else {
            return $this->jobSeekerDashboard();
        }
    }

    // Admin Dashboard - Applications View
    private function adminDashboardApplications()
    {
        // Admin sees ALL applications, not just their own
        $totalApplications = Application::count();
        $totalJobs = Job::count();
        $totalUsers = User::count();
        $pendingApplications = Application::where('status', 'pending')->count();

        // Additional admin stats
        $totalEmployers = User::where('role', 'employer')->count();
        $totalJobSeekers = User::where('role', 'job_seeker')->count();
        $activeJobs = Job::where('is_active', true)->count();
        $todaysApplications = Application::whereDate('created_at', today())->count();

        // Get recent data from entire system
        $recentJobs = Job::withCount('applications')
            ->latest()
            ->take(5)
            ->get();

        $recentApplications = Application::with(['job', 'user'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalApplications',
            'totalJobs',
            'totalUsers',
            'pendingApplications',
            'totalEmployers',
            'totalJobSeekers',
            'activeJobs',
            'todaysApplications',
            'recentJobs',
            'recentApplications'
        ));
    }

    // Admin Dashboard - Settings View
    private function adminDashboardSettings()
    {
        // System-wide statistics for settings view
        $totalUsers = User::count();
        $totalJobs = Job::count();
        $totalApplications = Application::count();
        $pendingApplications = Application::where('status', 'pending')->count();

        // System health metrics
        $activeJobs = Job::where('is_active', true)->count();
        $inactiveJobs = Job::where('is_active', false)->count();
        $recentRegistrations = User::whereDate('created_at', '>=', now()->subDays(7))->count();

        // Recent system activity
        $recentJobs = Job::withCount('applications')
            ->latest()
            ->take(5)
            ->get();

        $recentUsers = User::latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalUsers',
            'totalJobs',
            'totalApplications',
            'pendingApplications',
            'activeJobs',
            'inactiveJobs',
            'recentRegistrations',
            'recentJobs',
            'recentUsers'
        ));
    }

    private function employerDashboard()
    {
        $user = auth()->user();

        // Get employer's jobs
        $employerJobs = Job::where('user_id', $user->id);

        // Calculate statistics
        $totalJobs = $employerJobs->count();
        $totalApplications = Application::whereHas('job', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->count();

        $pendingApplications = Application::whereHas('job', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('status', 'pending')->count();

        // Additional employer stats
        $acceptedApplications = Application::whereHas('job', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('status', 'accepted')->count();

        $underReviewApplications = Application::whereHas('job', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('status', 'under_review')->count();

        // Get recent data
        $recentJobs = $employerJobs->withCount('applications')
            ->latest()
            ->take(5)
            ->get();

        $recentApplications = Application::whereHas('job', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with(['job', 'user'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalJobs',
            'totalApplications',
            'pendingApplications',
            'acceptedApplications',
            'underReviewApplications',
            'recentJobs',
            'recentApplications'
        ));
    }

    private function jobSeekerDashboard()
    {
        $user = auth()->user();

        // Get job seeker's applications
        $userApplications = Application::where('user_id', $user->id);

        // Calculate statistics
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
            ->where('is_active', true)
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
