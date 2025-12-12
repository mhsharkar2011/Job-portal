<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Job;
use App\Models\Application;
use App\Models\Company;
use App\Models\Role;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function adminDashboard()
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
        $data = [
            'totalApplications' => Application::count(),
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

        // Pass ALL required variables to the view
        return view('dashboards.admin', $data);
    }

    // Admin User Management -----------------------------------------------------------------------------------
    public function index(Request $request)
    {
        $query = User::query();

        // Search filter
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        // Role filter - using role relationship
        if ($request->filled('role')) {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('name', $request->role);
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

        $users = $query->with(['roles'])
            ->withCount(['jobs', 'applications'])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // Get available roles for filter dropdown
        $availableRoles = Role::pluck('name', 'name');

        return view('admin.users.index', compact('users', 'availableRoles'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'password' => 'required|min:8|confirmed',
            'roles' => 'required|array|min:1',
            'roles.*' => 'exists:roles,id',
        ]);

        try {
            DB::transaction(function () use ($request) {
                // Create user
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'password' => Hash::make($request->password),
                    'email_verified_at' => $request->email_verified ? now() : null,
                ]);

                // Assign roles
                $user->roles()->sync($request->roles);

                // If email is not verified and you want to send verification, uncomment:
                // if (!$request->email_verified) {
                //     event(new Registered($user));
                // }
            });

            return redirect()->route('admin.users.index')
                ->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            Log::error('User creation error: ' . $e->getMessage());
            return back()->with('error', 'Failed to create user. Please try again.')
                ->withInput();
        }
    }

    public function show(User $user)
    {
        // Load counts and roles relationship
        $user->loadCount(['jobs', 'applications', 'roles']);
        $user->load('roles');

        // Get the primary role (first role assigned to user)
        $primaryRole = $user->roles->first();
        $roleName = $primaryRole ? $primaryRole->name : 'No Role';
        $roleSlug = $primaryRole ? $primaryRole->slug : null;

        // Load data based on user's primary role
        if ($roleSlug === 'admin') {
            $user->load([
                'jobs' => function ($query) {
                    $query->withCount('applications')->latest();
                },
                'applications'
            ]);

            // Add admin-specific statistics
            $stats = [
                'total_users' => User::count(),
                'total_jobs' => Job::count(),
                'total_applications' => Application::count(),
                'total_companies' => Company::count(),
                'pending_jobs' => Job::where('is_active', '0')->count(),
                'active_jobs' => Job::where('is_active', '1')->count(),
            ];

            return view('admin.users.show', compact('user', 'stats', 'roleName'));
        } elseif ($roleSlug === 'employer') {
            $user->load([
                'jobs' => function ($query) {
                    $query->withCount('applications')
                        ->with(['category', 'company'])
                        ->latest();
                },
                'company'
            ]);

            // Add employer-specific statistics
            $user->active_jobs_count = $user->jobs->where('status', 'active')->count();
            $user->draft_jobs_count = $user->jobs->where('status', 'draft')->count();
            $user->total_applications_received = $user->jobs->sum('applications_count');
        } elseif ($roleSlug === 'job-seeker') {
            $user->load([
                'applications' => function ($query) {
                    $query->with([
                        'job' => function ($jobQuery) {
                            $jobQuery->with(['company', 'category']);
                        }
                    ])->latest();
                },
                'resume',
                'appliedJobs' => function ($query) {
                    $query->with(['company', 'category']);
                }
            ]);

            // Add seeker-specific statistics
            $user->application_stats = [
                'total' => $user->applications_count,
                'pending' => $user->applications->where('status', 'pending')->count(),
                'accepted' => $user->applications->where('status', 'accepted')->count(),
                'rejected' => $user->applications->where('status', 'rejected')->count(),
            ];
        } else {
            // For users with no role or other roles
            $user->load(['jobs', 'applications']);
        }

        return view('admin.users.show', compact('user', 'roleName'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'profile_photo_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'remove_photo' => 'nullable|boolean',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
            'is_active' => 'required|boolean',
        ]);

        try {
            DB::beginTransaction();

            // Handle profile photo
            if ($request->hasFile('profile_photo_path')) {
                // Delete old photo if exists
                if ($user->profile_photo_path) {
                    Storage::delete($user->profile_photo_path);
                }

                $avatarName = 'user_' . date('Y-m-d-H-i-s') . '_' . uniqid() . '.' . $request->file('profile_photo_path')->getClientOriginalExtension();
                // Store new photo
                $path = $request->file('profile_photo_path')->storeAs('profile-photos', $avatarName, 'public');
                $validated['profile_photo_path'] = $path;
            }

            // Handle photo removal
            if ($request->boolean('remove_photo') && $user->profile_photo_path) {
                Storage::delete($user->profile_photo_path);
                $validated['profile_photo_path'] = null;
            }

            // Update user basic information
            $user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'profile_photo_path' => $validated['profile_photo_path'] ?? $user->profile_photo_path,
                'is_active' => $validated['is_active'],
            ]);

            // Sync roles
            $user->roles()->sync($request->roles);

            DB::commit();

            return redirect()->route('admin.users.show', $user)
                ->with('success', 'User updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Failed to update user: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(User $user)
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

    // User Management end --------------------------------------------------------

    // Job Management

    public function adminJobShow() {}

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
    // Applications ---------------------------------------------------------------------
    public function adminApplicantIndex(Request $request)
    {
        $query = Application::with(['job', 'user']);

        // Status filter
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Search filter
        if ($request->has('search') && $request->search) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })->orWhereHas('job', function ($q) use ($request) {
                $q->where('job_title', 'like', '%' . $request->search . '%');
            });
        }
        // Get role IDs for faster queries
        $employerRole = Role::where('slug', 'employer')->first();
        $seekerRole = Role::where('slug', 'job-seeker')->first();
        $stats = [
            'totalApplications' => Application::count(),
            'totalJobs' => Job::count(),
            'totalUsers' => User::count(),
            'totalEmployers' => $employerRole ? $employerRole->users()->count() : 0,
            'totalJobSeekers' => $seekerRole ? $seekerRole->users()->count() : 0,
            'activeJobs' => Job::where('is_active', true)->count(),
            'totalPending' => Application::where('status', 'pending')->count(),
            'totalReview' => Application::where('status', 'reviewed')->count(),
            'totalAccepted' => Application::where('status', 'accepted')->count(),
            'totalRejected' => Application::where('status', 'rejected')->count(),
            // 'recentJobs' => $recentJobs,
            // 'recentUsers' => $recentUsers,
            // 'monthlyRegistrations' => $monthlyRegistrations,
            // 'recentApplications' => $recentApplications,
        ];

        $applications = $query->latest()
            ->paginate(10);

        return view('admin.applications.index', $stats, compact('applications'));
    }

    public function adminApplicantShow(Application $application)
    {
        $application->load(['job', 'user']);

        return view('admin.applications.show', compact('application'));
    }

    public function adminApplicantUpdateStatus(Request $request, Application $application)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,reviewed,accepted,rejected',
            'notes' => 'nullable|string',
        ]);

        $application->update($validated);

        return redirect()->route('admin.applicants.index', $application)
            ->with('success', 'Application status updated successfully.');
    }

    // Download Reports
    public function applicationsDownload()
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

    public function adminApplicantDestroy(Job $job)
    {
        $job->delete();

        return redirect()->route('admin.jobs.index')
            ->with('success', 'Job deleted successfully.');
    }

    // Admin Setting -----------------------------------------------------------------
    public function settings()
    {
        return view('admin.settings.create');
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

    // Admin Reports
    public function reports(Request $request)
    {
        try {
            // Date range filters with safe defaults
            $startDate = $request->input('start_date', now()->subDays(30)->format('Y-m-d'));
            $endDate = $request->input('end_date', now()->format('Y-m-d'));

            // Convert to Carbon instances for queries
            $startDateCarbon = \Carbon\Carbon::parse($startDate)->startOfDay();
            $endDateCarbon = \Carbon\Carbon::parse($endDate)->endOfDay();

            // Application Statistics
            $applicationStats = Application::select('status', DB::raw('COUNT(*) as count'))
                ->whereBetween('created_at', [$startDateCarbon, $endDateCarbon])
                ->groupBy('status')
                ->get();

            $totalApplications = Application::whereBetween('created_at', [$startDateCarbon, $endDateCarbon])->count();

            // Calculate growth rate safely
            $previousApplications = Application::whereBetween('created_at', [
                $startDateCarbon->copy()->subDays(30),
                $endDateCarbon->copy()->subDays(30)
            ])->count();

            $applicationsGrowth = $this->calculateGrowthRate($previousApplications, $totalApplications);

            // Job Statistics
            $jobStats = Job::select(
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN is_active = 1 THEN 1 ELSE 0 END) as active'),
                DB::raw('SUM(CASE WHEN is_active = 0 THEN 1 ELSE 0 END) as inactive')
            )
                ->whereBetween('created_at', [$startDateCarbon, $endDateCarbon])
                ->first();

            $totalJobs = $jobStats->total ?? 0;

            $previousJobs = Job::whereBetween('created_at', [
                $startDateCarbon->copy()->subDays(30),
                $endDateCarbon->copy()->subDays(30)
            ])->count();

            $jobsGrowth = $this->calculateGrowthRate($previousJobs, $totalJobs);

            // User Statistics
            $userStats = User::select(
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN role = "employer" THEN 1 ELSE 0 END) as employers'),
                DB::raw('SUM(CASE WHEN role = "job_seeker" THEN 1 ELSE 0 END) as job_seekers'),
                DB::raw('SUM(CASE WHEN role = "admin" THEN 1 ELSE 0 END) as admins')
            )
                ->whereBetween('created_at', [$startDateCarbon, $endDateCarbon])
                ->first();

            $totalUsers = $userStats->total ?? 0;

            $previousUsers = User::whereBetween('created_at', [
                $startDateCarbon->copy()->subDays(30),
                $endDateCarbon->copy()->subDays(30)
            ])->count();

            $usersGrowth = $this->calculateGrowthRate($previousUsers, $totalUsers);

            // Popular Jobs (by application count)
            $popularJobs = Job::withCount(['applications' => function ($query) use ($startDateCarbon, $endDateCarbon) {
                $query->whereBetween('created_at', [$startDateCarbon, $endDateCarbon]);
            }])
                ->with('user')
                ->orderBy('applications_count', 'desc')
                ->take(10)
                ->get();

            // Top Employers (by job count)
            $topEmployers = User::where('role', 'employer')
                ->withCount(['jobs' => function ($query) use ($startDateCarbon, $endDateCarbon) {
                    $query->whereBetween('created_at', [$startDateCarbon, $endDateCarbon]);
                }])
                ->withCount(['applications' => function ($query) use ($startDateCarbon, $endDateCarbon) {
                    $query->whereBetween('created_at', [$startDateCarbon, $endDateCarbon]);
                }])
                ->having('jobs_count', '>', 0)
                ->orderBy('jobs_count', 'desc')
                ->take(10)
                ->get();

            // Application Status Distribution
            $statusDistribution = Application::select('status', DB::raw('COUNT(*) as count'))
                ->whereBetween('created_at', [$startDateCarbon, $endDateCarbon])
                ->groupBy('status')
                ->get();

            // Ensure all variables have safe defaults
            $data = [
                'applicationStats' => $applicationStats,
                'totalApplications' => $totalApplications,
                'applicationsGrowth' => $applicationsGrowth,
                'jobStats' => $jobStats,
                'totalJobs' => $totalJobs,
                'jobsGrowth' => $jobsGrowth,
                'userStats' => $userStats,
                'totalUsers' => $totalUsers,
                'usersGrowth' => $usersGrowth,
                'popularJobs' => $popularJobs,
                'topEmployers' => $topEmployers,
                'statusDistribution' => $statusDistribution,
                'startDate' => $startDate,
                'endDate' => $endDate,
            ];

            return view('admin.reports', $data);
        } catch (\Exception $e) {
            // Fallback with default values if anything fails
            return view('admin.reports', [
                'applicationStats' => collect(),
                'totalApplications' => 0,
                'applicationsGrowth' => 0,
                'jobStats' => (object) ['total' => 0, 'active' => 0, 'inactive' => 0],
                'totalJobs' => 0,
                'jobsGrowth' => 0,
                'userStats' => (object) ['total' => 0, 'employers' => 0, 'job_seekers' => 0, 'admins' => 0],
                'totalUsers' => 0,
                'usersGrowth' => 0,
                'popularJobs' => collect(),
                'topEmployers' => collect(),
                'statusDistribution' => collect(),
                'startDate' => now()->subDays(30)->format('Y-m-d'),
                'endDate' => now()->format('Y-m-d'),
            ]);
        }
    }

    private function calculateGrowthRate($previous, $current)
    {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }

        return (($current - $previous) / $previous) * 100;
    }
}
