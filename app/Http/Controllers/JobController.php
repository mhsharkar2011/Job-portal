<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Company;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use function Ramsey\Uuid\v1;

class JobController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show', 'browse']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobs = Job::withCount('applications')
            ->with(['applications' => function ($query) {
                if (auth()->check()) {
                    $query->where('user_id', auth()->id());
                }
            }])
            ->latest()
            ->paginate(12);

        return view('jobs.index', compact('jobs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::active()->ordered()->get();
        $companies = Company::where('user_id', auth()->id())->get();
        return view('jobs.create', compact('categories', 'companies'));
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
                    'user_id' => auth()->id(),
                    'category_id' => $validated['category_id'],
                    'company_id' => $validated['company_id'],
                    'job_title' => $validated['job_title'],
                    'job_description' => $validated['job_description'],
                    'requirement' => $validated['requirement'],
                    'location' => $validated['location'],
                    'experience_minimum' => $validated['experience_minimum'],
                    'experience_maximum' => $validated['experience_maximum'],
                    'experience_unit' => $validated['experience_unit'],
                    'role' => $validated['role'],
                    'employment_type' => $validated['employment_type'],
                    'salary_minimum' => $validated['salary_minimum'],
                    'salary_maximum' => $validated['salary_maximum'],
                    'salary_currency' => $validated['salary_currency'],
                    'key_skills' => $validated['key_skills'],
                    'positions_available' => $validated['positions_available'],
                    'positions_filled' => 0, // Default value
                    'accepting_applications' => true, // Default value
                    'is_active' => true, // Default value
                    'published_at' => now(), // Current timestamp
                    'application_deadline' => $validated['application_deadline'] ?? null,
                    'is_featured' => false, // Default value
                    'is_urgent' => false, // Default value
                    'featured_until' => null, // Default value
                    'logo' => $validated['logo'] ?? null,
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

    // Created Job for UI
    // public function created()
    // {
    //     $jobs = Job::with('company')->get();
    //     return view('jobs.created-job', compact('jobs'));
    // }

    /**
     * Display the specified resource.
     */
    public function show(Job $job)
    {
        // Eager load relationships
        $job->load(['company', 'category', 'user', 'applications']);

        // Get related jobs (same category)
        $relatedJobs = Job::where('category_id', $job->category_id)
            ->where('id', '!=', $job->id)
            ->where('is_active', true)
            ->with(['company', 'category'])
            ->latest()
            ->take(4)
            ->get();

        return view('jobs.show', compact('job', 'relatedJobs'));
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
     * Show the form for editing the specified resource.
     */
    public function edit(Job $job)
    {
        // Check if user owns the job
        if ($job->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::all();
        $companies = Company::where('user_id', auth()->id())->get();

        return view('admin.jobs.edit', compact('job', 'categories', 'companies'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Job $job)
    {
        // Check if user owns the job
        if ($job->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Use the same validation rules as store (make fields nullable if needed for update)
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

        $validated = $request->validate($rules);

        try {
            return DB::transaction(function () use ($validated, $request, $job) {
                // Authorization check for company
                $company = Company::findOrFail($validated['company_id']);
                if ($company->user_id !== auth()->id()) {
                    throw new \Exception('You are not authorized to update jobs for this company.');
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

                // Update job
                $job->update($validated);

                return redirect()->route('jobs.createdJob')
                    ->with('success', 'Job updated successfully!');
            });
        } catch (\Exception $e) {
            Log::error('Job update error: ' . $e->getMessage());
            return back()->with('error', 'Failed to update job. Please try again.')->withInput();
        }
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
