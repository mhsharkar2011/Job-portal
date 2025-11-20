<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class SeekerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Job $job)
    {
        $applications = Application::with(['job', 'job.company'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('seekers.jobs.index', compact('applications', 'job'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Job $job)
    {
        // Check if user already applied
        $existingApplication = $job->applications()
            ->where('user_id', auth()->id())
            ->first();

        if ($existingApplication) {
            return redirect()->route('seeker.jobs.index')
                ->with('error', 'You have already applied for this job.');
        }

        // Check if job is still accepting applications
        if (!$job->is_active || !$job->accepting_applications) {
            return redirect()->route('seeker.jobs.index')
                ->with('error', 'This job is no longer accepting applications.');
        }

        // Check if application deadline has passed
        if ($job->application_deadline && $job->application_deadline->isPast()) {
            return redirect()->route('seeker.jobs.index')
                ->with('error', 'The application deadline for this job has passed.');
        }

        return view('seekers.jobs.apply', compact('job'));
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * Store a new job application (Enhanced Version)
     */
    public function store(Request $request, Job $job)
    {
        // Debug: Log the request data
        Log::info('Application submission started', [
            'job_id' => $job->id,
            'user_id' => auth()->id(),
            'request_data' => $request->except(['_token', 'resume', 'cover_letter'])
        ]);

        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to apply for this job.');
        }

        // Check if user is a job seeker
        if (!auth()->user()->isSeeker()) {
            return redirect()->route('seeker.jobs.index')
                ->with('error', 'Only job seekers can apply for jobs.');
        }

        // Check if user already applied for this job
        $existingApplication = Application::where('job_id', $job->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($existingApplication) {
            return redirect()->route('seeker.jobs.index')
                ->with('error', 'You have already applied for this job.');
        }

        // Check if job is active
        if (!$job->is_active) {
            return redirect()->route('seeker.jobs.index')
                ->with('error', 'This job is no longer accepting applications.');
        }

        // Validate the application data - MATCHES YOUR MIGRATION
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20', // nullable
            'experience_years' => 'nullable|integer|min:0|max:50', // nullable
            'address' => 'nullable|string|max:500', // nullable
            'skills' => 'nullable|string|max:1000', // nullable
            'education' => 'nullable|string|max:1000', // nullable
            'resume' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'cover_letter' => 'nullable|file|mimes:pdf,doc,docx|max:2048', // nullable
        ], [
            'resume.required' => 'Please upload your resume.',
            'resume.mimes' => 'Resume must be a PDF, DOC, or DOCX file.',
            'resume.max' => 'Resume must not exceed 2MB.',
            'cover_letter.mimes' => 'Cover letter must be a PDF, DOC, or DOCX file.',
            'cover_letter.max' => 'Cover letter must not exceed 2MB.',
        ]);

        try {
            DB::transaction(function () use ($validated, $request, $job) {
                // Handle resume file upload
                $resumeFileName = 'resume_' . auth()->id() . '_' . time() . '.' . $request->file('resume')->getClientOriginalExtension();
                $resumePath = $request->file('resume')->storeAs('applications/resumes', $resumeFileName, 'public');

                // Handle cover letter file upload if provided
                $coverLetterPath = null;
                if ($request->hasFile('cover_letter') && $request->file('cover_letter')->isValid()) {
                    $coverLetterFileName = 'cover_letter_' . auth()->id() . '_' . time() . '.' . $request->file('cover_letter')->getClientOriginalExtension();
                    $coverLetterPath = $request->file('cover_letter')->storeAs('applications/cover_letters', $coverLetterFileName, 'public');
                }

                // Debug: Log data before creating application
                Log::info('Creating application with data:', [
                    'job_id' => $job->id,
                    'user_id' => auth()->id(),
                    'full_name' => $validated['full_name'],
                    'email' => $validated['email'],
                    'phone' => $validated['phone'] ?? null,
                    'experience_years' => $validated['experience_years'] ?? null,
                    'address' => $validated['address'] ?? null,
                    'skills' => $validated['skills'] ?? null,
                    'education' => $validated['education'] ?? null,
                    'resume_path' => $resumePath,
                    'cover_letter_path' => $coverLetterPath,
                ]);

                // Create the application
                $application = Application::create([
                    'job_id' => $job->id,
                    'user_id' => auth()->id(),
                    'full_name' => trim($validated['full_name']),
                    'email' => trim($validated['email']),
                    'phone' => isset($validated['phone']) ? trim($validated['phone']) : null,
                    'experience_years' => $validated['experience_years'] ?? null,
                    'address' => isset($validated['address']) ? trim($validated['address']) : null,
                    'skills' => isset($validated['skills']) ? trim($validated['skills']) : null,
                    'education' => isset($validated['education']) ? trim($validated['education']) : null,
                    'resume_path' => $resumePath,
                    'cover_letter_path' => $coverLetterPath,
                    'status' => 'pending',
                    // notes is nullable and will be null by default
                ]);

                // Debug: Log successful creation
                Log::info('Application created successfully', [
                    'application_id' => $application->id,
                    'job_id' => $job->id,
                    'user_id' => auth()->id()
                ]);

                // Update applications count for the job if the column exists
                if (Schema::hasColumn('jobs', 'applications_count')) {
                    $job->increment('applications_count');
                }
            });

            return redirect()->route('seeker.my-applications')
                ->with('success', 'Application submitted successfully! We will review your application and get back to you soon.');
        } catch (\Exception $e) {
            Log::error('Job application submission failed', [
                'error' => $e->getMessage(),
                'job_id' => $job->id,
                'user_id' => auth()->id(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->with('error', 'Failed to submit application: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Pre-application validation checks
     */
    private function preApplicationChecks(Job $job)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to apply for this job.');
        }

        if (!auth()->user()->isSeeker()) {
            return redirect()->route('seeker.jobs.index')
                ->with('error', 'Only job seekers can apply for jobs.');
        }

        // Check for existing application
        if (Application::where('job_id', $job->id)->where('user_id', auth()->id())->exists()) {
            return redirect()->route('seeker.jobs.index')
                ->with('error', 'You have already applied for this job.');
        }

        // Check job status
        if (!$job->is_active) {
            return redirect()->route('seeker.jobs.index')
                ->with('error', 'This job is no longer accepting applications.');
        }

        // Check application deadline
        if ($job->application_deadline && $job->application_deadline->isPast()) {
            return redirect()->route('seeker.jobs.index')
                ->with('error', 'The application deadline for this job has passed.');
        }

        return null;
    }

    /**
     * Handle file upload
     */
    private function uploadFile($file, $type)
    {
        if (!$file || !$file->isValid()) {
            throw new \Exception("Invalid {$type} file.");
        }

        $fileName = $type . '_' . auth()->id() . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs("applications/{$type}", $fileName, 'public');

        if (!$path) {
            throw new \Exception("Failed to upload {$type} file.");
        }

        return $path;
    }

    /**
     * Format phone number
     */
    private function formatPhone($phone)
    {
        // Remove all non-numeric characters except +
        $phone = preg_replace('/[^\d+]/', '', $phone);

        // Ensure it starts with +
        if (!str_starts_with($phone, '+')) {
            $phone = '+' . $phone;
        }

        return $phone;
    }

    /**
     * Format skills string
     */
    private function formatSkills($skills)
    {
        $skillsArray = array_map('trim', explode(',', $skills));
        $skillsArray = array_filter($skillsArray); // Remove empty values
        $skillsArray = array_unique($skillsArray); // Remove duplicates
        $skillsArray = array_slice($skillsArray, 0, 15); // Limit to 15 skills

        return implode(', ', $skillsArray);
    }

    /**
     * Update job statistics
     */
    private function updateJobStats(Job $job)
    {
        // Update applications count if column exists
        if (Schema::hasColumn('jobs', 'applications_count')) {
            $job->increment('applications_count');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Job $job)
    {
        // Load relationships
        $job->load(['company', 'category', 'user']);

        // Get related jobs with multiple criteria
        $relatedJobs = Job::with(['company', 'category'])
            ->where('is_active', true)
            ->where('id', '!=', $job->id)
            ->where(function ($query) use ($job) {
                // Same category
                $query->where('category_id', $job->category_id)
                    // Or similar skills
                    ->orWhere('key_skills', 'like', '%' . explode(',', $job->key_skills)[0] . '%')
                    // Or same company
                    ->orWhere('company_id', $job->company_id);
            })
            ->latest()
            ->take(6)
            ->get();

        return view('jobs.show', compact('job', 'relatedJobs'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function applications()
    {

        $applications = Application::with(['job', 'job.company'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('seekers.jobs.my-applications', compact('applications'));
    }
}
