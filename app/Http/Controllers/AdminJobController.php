<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Company;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use function Ramsey\Uuid\v1;

class AdminJobController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show', 'browse']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get categories for filter
        $categories = Category::active()->ordered()->get();

        // Get jobs with relationships
        $jobs = Job::with(['company', 'category', 'user'])
            ->withCount('applications')
            ->latest()
            ->paginate(10);

        // Provide stats data
        $stats = [
            'total' => Job::count(),
            'active' => Job::where('is_active', '1')->count(),
            'inactive' => Job::where('is_active', '!=', '1')->count(),
            'applications' => \App\Models\Application::count(),
        ];

        return view('admin.jobs.index', compact('jobs', 'stats', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::active()->ordered()->get();
        $companies = Company::where('user_id', auth()->id())->get();
        return view('admin.jobs.create', compact('categories', 'companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation rules
        $rules = [
            'company_id' => 'required|exists:companies,id',
            'category_id' => 'required|exists:categories,id',
            'job_title' => 'required|string|max:255',
            'job_description' => 'required|string|min:50',
            'requirement' => 'required|string|min:50',
            'location' => 'required|string|max:255',
            'experience_minimum' => 'required|integer|min:0',
            'experience_maximum' => 'required|integer|min:0|gte:experience_minimum',
            'experience_unit' => 'required|in:years,months',
            'role' => 'required|string|max:255',
            'employment_type' => 'required|in:full-time,part-time,contract,freelance,internship',
            'salary_minimum' => 'required|integer|min:0',
            'salary_maximum' => 'required|integer|min:0|gte:salary_minimum',
            'salary_currency' => 'required|in:USD,BDT,EUR,GBP',
            'key_skills' => 'required|string|min:3',
            'positions_available' => 'required|integer|min:1|max:100',
            'application_deadline' => 'nullable|date|after:today',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        // Custom messages
        $messages = [
            'company_id.required' => 'Please select a company',
            'category_id.required' => 'Please select a category',
            'salary_maximum.gte' => 'Maximum salary must be greater than or equal to minimum salary',
            'experience_maximum.gte' => 'Maximum experience must be greater than or equal to minimum experience',
            'application_deadline.after' => 'Application deadline must be a future date',
        ];

        $validated = $request->validate($rules, $messages);

        try {
            return DB::transaction(function () use ($validated, $request) {
                // Authorization check
                $company = Company::findOrFail($validated['company_id']);

                if ($company->user_id !== auth()->id()) {
                    throw new \Exception('You are not authorized to post jobs for this company.');
                }

                // Handle file upload
                if ($request->hasFile('logo')) {
                    $validated['logo'] = $request->file('logo')->store('company-logos', 'public');
                }

                // Create job with additional fields
                $job = Job::create([
                    ...$validated,
                    'user_id' => auth()->id(),
                    'is_active' => true,
                ]);

                return redirect()->route('admin.jobs.index')
                    ->with('success', 'Job posted successfully! It will be live after review.');
            });
        } catch (\Exception $e) {
            Log::error('Job creation error: ' . $e->getMessage());

            $errorMessage = $e->getMessage();
            if (str_contains($errorMessage, 'Unauthorized') || str_contains($errorMessage, 'authorized')) {
                return back()->with('error', 'You are not authorized to perform this action.')->withInput();
            }

            return back()->with('error', 'Failed to create job. Please try again.')->withInput();
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Job $job)
    {
        // Load the job with necessary relationships
        $job->load(['company', 'category', 'user', 'applications']);

        // Load applications count
        $job->loadCount('applications');

        // Calculate application statistics
        $applicationStats = [
            'total' => $job->applications_count,
            'pending' => $job->applications->where('status', 'pending')->count(),
            'accepted' => $job->applications->where('status', 'accepted')->count(),
            'rejected' => $job->applications->where('status', 'rejected')->count(),
            'reviewed' => $job->applications->where('status', 'reviewed')->count(),
        ];

        return view('admin.jobs.show', compact('job', 'applicationStats'));
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Job $job)
    {
        // Allow admin to edit any job, restrict others to their own jobs
        if (!auth()->user()->isAdmin() && $job->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::all();
        $companies = auth()->user()->isAdmin()
            ? Company::all()
            : Company::where('user_id', auth()->id())->get();

        return view('admin.jobs.edit', compact('job', 'categories', 'companies'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Job $job)
    {
        // Allow admin to edit any job, restrict others to their own jobs
        if (!auth()->user()->isAdmin() && $job->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // If it's just a status update (from the activate/deactivate buttons)
        if ($request->has('status')) {
            try {
                $status = $request->status;

                // Update job status and related fields
                $updateData = ['status' => $status];

                // Set is_active based on status
                $updateData['is_active'] = $status === 'active';

                // Set published_at if activating
                if ($status === 'active' && !$job->published_at) {
                    $updateData['published_at'] = now();
                }

                // Set accepting_applications based on status
                $updateData['accepting_applications'] = in_array($status, ['active', 'pending']);

                $job->update($updateData);

                return redirect()->route('admin.jobs.show', $job)
                    ->with('success', 'Job status updated successfully!');
            } catch (\Exception $e) {
                Log::error('Job status update error: ' . $e->getMessage());
                return back()->with('error', 'Failed to update job status. Please try again.');
            }
        }

        // Full update with validation (your existing code for editing the entire job)
        $rules = [
            'company_id' => 'required|exists:companies,id',
            'category_id' => 'required|exists:categories,id',
            'job_title' => 'required|string|max:255',
            'job_description' => 'required|string|min:50',
            'requirement' => 'required|string|min:50',
            'location' => 'required|string|max:255',
            'experience_minimum' => 'required|integer|min:0',
            'experience_maximum' => 'required|integer|min:0|gte:experience_minimum',
            'experience_unit' => 'required|in:years,months',
            'role' => 'required|string|max:255',
            'employment_type' => 'required|in:full-time,part-time,contract,freelance,internship',
            'salary_minimum' => 'required|integer|min:0',
            'salary_maximum' => 'required|integer|min:0|gte:salary_minimum',
            'salary_currency' => 'required|in:USD,BDT,EUR,GBP',
            'key_skills' => 'required|string|min:3',
            'positions_available' => 'required|integer|min:1|max:100',
            'application_deadline' => 'nullable|date|after:today',
            'status' => 'sometimes|in:draft,active,pending,expired,closed',
            'published_at' => 'nullable|date|after_or_equal:today',
            'expires_at' => 'nullable|date|after:published_at',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        // Custom validation messages
        $messages = [
            'experience_maximum.gte' => 'Maximum experience must be greater than or equal to minimum experience',
            'salary_maximum.gte' => 'Maximum salary must be greater than or equal to minimum salary',
            'application_deadline.after' => 'Application deadline must be a future date',
            'published_at.after_or_equal' => 'Publish date must be today or in the future',
            'expires_at.after' => 'Expiry date must be after publish date',
        ];

        $validated = $request->validate($rules, $messages);

        try {
            return DB::transaction(function () use ($validated, $request, $job) {
                // Authorization logic
                if (auth()->user()->isAdmin()) {
                    // Admin can update any job with any company - no restrictions
                } else {
                    // Regular user must own both the job AND the company
                    if ($job->user_id !== auth()->id()) {
                        throw new \Exception('You are not authorized to update this job.');
                    }

                    $company = Company::findOrFail($validated['company_id']);
                    if ($company->user_id !== auth()->id()) {
                        throw new \Exception('You are not authorized to use this company.');
                    }
                }

                // Handle file upload
                if ($request->hasFile('logo')) {
                    // Delete old logo if exists
                    if ($job->logo) {
                        Storage::disk('public')->delete($job->logo);
                    }
                    $validated['logo'] = $request->file('logo')->store('company-logos', 'public');
                } else {
                    // Keep existing logo if no new file uploaded
                    unset($validated['logo']);
                }

                // Handle status and publish date logic
                if (isset($validated['status'])) {
                    $status = $validated['status'];
                    $publishedAt = $validated['published_at'] ?? null;

                    // Auto-set published_at based on status
                    if ($status === 'active' && !$publishedAt) {
                        $validated['published_at'] = now();
                    } elseif ($status === 'draft') {
                        $validated['published_at'] = null;
                    }
                }

                // Update job with the validated data
                $job->update($validated);

                return redirect()->route('admin.jobs.show', $job)
                    ->with('success', 'Job updated successfully!');
            });
        } catch (\Exception $e) {
            Log::error('Job update error: ' . $e->getMessage());

            $errorMessage = $e->getMessage();
            if (str_contains($errorMessage, 'Unauthorized') || str_contains($errorMessage, 'authorized')) {
                return back()->with('error', $errorMessage)->withInput();
            }

            return back()->with('error', 'Failed to update job. Please try again.')->withInput();
        }
    }

    /**
     * Display jobs listing for job seekers to apply
     */
    public function browse(Request $request)
    {
        $query = Job::with(['company', 'category'])
            ->active()
            ->withCount('applications');

        // Apply filters (your existing filter logic)
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('job_title', 'like', '%' . $request->search . '%')
                    ->orWhere('job_description', 'like', '%' . $request->search . '%')
                    ->orWhere('key_skills', 'like', '%' . $request->search . '%')
                    ->orWhereHas('company', function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->search . '%');
                    });
            });
        }

        // ... rest of your filter logic

        // Apply sorting
        switch ($request->get('sort', 'newest')) {
            case 'salary_high':
                $query->orderByRaw('(salary_minimum + salary_maximum) / 2 DESC');
                break;
            case 'salary_low':
                $query->orderBy('salary_minimum', 'ASC');
                break;
            case 'deadline':
                $query->orderBy('application_deadline', 'ASC');
                break;
            case 'newest':
            default:
                $query->latest();
                break;
        }

        $jobs = $query->paginate(12);

        // Get featured jobs (only if column exists)
        try {
            $featuredJobs = Job::with('company')
                ->active()
                ->where(function ($query) {
                    // Temporary: Use high salary jobs as featured until migration is run
                    $query->where('salary_minimum', '>=', 80000)
                        ->orWhereHas('company', function ($q) {
                            $q->where('is_verified', true);
                        });
                })
                ->latest()
                ->take(3)
                ->get();
        } catch (\Exception $e) {
            // Fallback if is_featured column doesn't exist yet
            $featuredJobs = collect();
        }

        // Get popular categories
        $popularCategories = Category::active()
            ->withCount(['jobs' => function ($query) {
                $query->active();
            }])
            ->orderBy('jobs_count', 'desc')
            ->take(5)
            ->get();

        // Get counts
        $remoteJobsCount = Job::active()->where('location', 'like', '%remote%')->count();

        try {
            $featuredJobsCount = Job::active()->featured()->count();
        } catch (\Exception $e) {
            $featuredJobsCount = 0;
        }

        return view('jobs.browse', compact(
            'jobs',
            'featuredJobs',
            'popularCategories',
            'remoteJobsCount',
            'featuredJobsCount'
        ));
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $job)
    {
        // Check if user owns the job
        if ($job->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Delete logo if exists
        if ($job->logo) {
            Storage::delete('public/' . $job->logo);
        }

        $job->delete();

        return redirect()->route('jobs.createdJob')->with('success', 'Job Deleted Successfully');
    }
}
