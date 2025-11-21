<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Application;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        try {
            // Check user role with fallback
            $role = $user->role ?? 'job-seeker';

            switch ($role) {
                case 'admin':
                    return $this->getAdminDashboard();
                case 'employer':
                    return $this->getEmployerDashboard();
                default:
                    return $this->getJobSeekerDashboard();
            }
        } catch (\Exception $e) {
            // Fallback to basic dashboard if anything fails
            return $this->getBasicDashboard();
        }
    }

    private function getAdminDashboard()
    {
       // Get role IDs for faster queries
        $employerRole = Role::where('slug', 'employer')->first();
        $seekerRole = Role::where('slug', 'job-seeker')->first();

        // Recent activity
        $recentUsers = User::with(['roles', 'jobs', 'applications'])
            ->withCount(['jobs', 'applications'])
            ->latest()
            ->take(5)
            ->get();

        // Recent jobs with application counts
        $recentJobs = Job::with(['company', 'category', 'user'])
            ->withCount('applications')
            ->latest()
            ->take(10)
            ->get();

        $recentApplications = Application::with(['job.company', 'job', 'user'])
            ->latest()
            ->take(5)
            ->get();

        // Monthly registration stats for chart
        $monthlyRegistrations = User::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->get();
 // System overview statistics
        $stats = [
        // 'totalApplications' => Application::count(),
        'totalJobs' => Job::count(),
        'totalUsers' => User::count(),
        'totalEmployers' => $employerRole ? $employerRole->users()->count() : 0,
        'totalJobSeekers' => $seekerRole ? $seekerRole->users()->count() : 0,
        'activeJobs' => Job::where('is_active', true)->count(),
        'pendingApplications' => Application::where('status', 'pending')->count(),
        'todaysApplications' => Application::whereDate('created_at', today())->count(),
        'recentJobs' => $recentJobs,
        'recentUsers' => $recentUsers,
        'monthlyRegistrations' => $monthlyRegistrations,
        'recentApplications' => $recentApplications,
    ];

        $recentData = [
            'recentJobs' => $recentJobs,
            'recentApplications' => $recentApplications,
        ];

        return view('dashboard', array_merge($stats, $recentData));
    }

    private function getEmployerDashboard()
    {
        $user = auth()->user();

        $stats = [
            'totalJobs' => Job::where('user_id', $user->id)->count(),
            'totalApplications' => Application::whereHas('job', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->count(),
            'pendingApplications' => Application::whereHas('job', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->where('status', 'pending')->count(),
        ];

        $recentData = [
            'recentJobs' => Job::where('user_id', $user->id)->withCount('applications')->latest()->take(5)->get(),
            'recentApplications' => Application::whereHas('job', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->with(['job', 'user'])->latest()->take(5)->get(),
        ];

        return view('dashboard', array_merge($stats, $recentData));
    }

    private function getJobSeekerDashboard()
    {
        $user = auth()->user();

        $stats = [
            'totalApplications' => Application::where('user_id', $user->id)->count(),
            'pendingApplications' => Application::where('user_id', $user->id)->where('status', 'pending')->count(),
            'acceptedApplications' => Application::where('user_id', $user->id)->where('status', 'accepted')->count(),
        ];

        $recentData = [
            'recentApplications' => Application::where('user_id', $user->id)->with(['job.company'])->latest()->take(5)->get(),
            'featuredJobs' => Job::with(['company'])->where('is_active', true)->latest()->take(6)->get(),
        ];

        return view('dashboard', array_merge($stats, $recentData));
    }

    private function getBasicDashboard()
    {
        // Basic dashboard data that should always work
        $data = [
            'user' => auth()->user(),
            'totalJobs' => Job::where('is_active', true)->count(),
        ];

        return view('dashboard', $data);
    }
}
