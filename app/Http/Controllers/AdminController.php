<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Job;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function dashboard()
    {
        // System overview statistics
        $stats = [
            'totalUsers' => User::count(),
            'totalEmployers' => User::where('role', 'employer')->count(),
            'totalJobSeekers' => User::where('role', 'job_seeker')->count(),
            'totalJobs' => Job::count(),
            'activeJobs' => Job::where('is_active', true)->count(),
            'totalApplications' => Application::count(),
            'pendingApplications' => Application::where('status', 'pending')->count(),
            'todaysApplications' => Application::whereDate('created_at', today())->count(),
            'todaysRegistrations' => User::whereDate('created_at', today())->count(),
        ];

        // Recent activity
        $recentUsers = User::withCount(['jobs', 'applications'])
            ->latest()
            ->take(5)
            ->get();

        $recentJobs = Job::withCount('applications')
            ->with('user')
            ->latest()
            ->take(5)
            ->get();

        $recentApplications = Application::with(['job', 'user'])
            ->latest()
            ->take(5)
            ->get();

        // Monthly registration stats for chart
        $monthlyRegistrations = User::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as count'),
                DB::raw('role')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month', 'role')
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentUsers',
            'recentJobs',
            'recentApplications',
            'monthlyRegistrations'
        ));
    }

    public function users(Request $request)
    {
        $query = User::query();

        // Search filter
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        // Role filter
        if ($request->has('role') && $request->role) {
            $query->where('role', $request->role);
        }

        // Status filter
        if ($request->has('status') && $request->status) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $users = $query->withCount(['jobs', 'applications'])
            ->latest()
            ->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function userShow(User $user)
    {
        $user->loadCount(['jobs', 'applications']);

        if ($user->role === 'employer') {
            $user->load(['jobs' => function($query) {
                $query->withCount('applications')->latest();
            }]);
        } elseif ($user->role === 'job_seeker') {
            $user->load(['applications' => function($query) {
                $query->with('job')->latest();
            }]);
        }

        return view('admin.users.show', compact('user'));
    }

    public function userEdit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function userUpdate(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,employer,job_seeker',
            'is_active' => 'boolean',
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'User updated successfully.');
    }

    public function userDestroy(User $user)
    {
        // Prevent admin from deleting themselves
        if ($user->id === auth()->id()) {
            return redirect()->back()
                ->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    public function jobs(Request $request)
    {
        $query = Job::with(['user', 'applications']);

        // Search filter
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('job_title', 'like', '%' . $request->search . '%')
                  ->orWhere('company_name', 'like', '%' . $request->search . '%');
            });
        }

        // Status filter
        if ($request->has('status') && $request->status) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $jobs = $query->withCount('applications')
            ->latest()
            ->paginate(10);

        return view('admin.jobs.index', compact('jobs'));
    }

    public function jobShow(Job $job)
    {
        $job->load(['user', 'applications.user']);

        return view('admin.jobs.show', compact('job'));
    }

    public function jobEdit(Job $job)
    {
        return view('admin.jobs.edit', compact('job'));
    }

    public function jobUpdate(Request $request, Job $job)
    {
        $validated = $request->validate([
            'job_title' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'employment_type' => 'required|string|max:255',
            'salary_range' => 'nullable|string|max:255',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'is_active' => 'boolean',
        ]);

        $job->update($validated);

        return redirect()->route('admin.jobs.show', $job)
            ->with('success', 'Job updated successfully.');
    }

    public function jobDestroy(Job $job)
    {
        $job->delete();

        return redirect()->route('admin.jobs.index')
            ->with('success', 'Job deleted successfully.');
    }

    public function applications(Request $request)
    {
        $query = Application::with(['job', 'user']);

        // Status filter
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Search filter
        if ($request->has('search') && $request->search) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })->orWhereHas('job', function($q) use ($request) {
                $q->where('job_title', 'like', '%' . $request->search . '%');
            });
        }

        $applications = $query->latest()
            ->paginate(10);

        return view('admin.applications.index', compact('applications'));
    }

    public function applicationShow(Application $application)
    {
        $application->load(['job', 'user']);

        return view('admin.applications.show', compact('application'));
    }

    public function applicationUpdateStatus(Request $request, Application $application)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,under_review,shortlisted,interview,accepted,rejected',
            'notes' => 'nullable|string',
        ]);

        $application->update($validated);

        return redirect()->route('admin.applications.show', $application)
            ->with('success', 'Application status updated successfully.');
    }

    public function settings()
    {
        return view('admin.settings');
    }

    public function updateSettings(Request $request)
    {
        // Add your settings validation and update logic here
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_email' => 'required|email',
            'jobs_auto_approve' => 'boolean',
            'applications_auto_confirm' => 'boolean',
        ]);

        // Update settings in database or config
        // This is a basic example - you might want to use a settings table

        return redirect()->route('admin.settings')
            ->with('success', 'Settings updated successfully.');
    }

    public function reports()
    {
        // Generate various reports
        $popularJobs = Job::withCount('applications')
            ->orderBy('applications_count', 'desc')
            ->take(10)
            ->get();

        $topEmployers = User::where('role', 'employer')
            ->withCount('jobs')
            ->orderBy('jobs_count', 'desc')
            ->take(10)
            ->get();

        $applicationStats = Application::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();

        return view('admin.reports', compact(
            'popularJobs',
            'topEmployers',
            'applicationStats'
        ));
    }
}
