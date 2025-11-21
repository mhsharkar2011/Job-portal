<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{


    public function index(Job $job)
    {
        // Application statistics
        $data = [
            'totalPending' => Application::pending()->count(),
            'totalReviewed' => Application::reviewed()->count(),
            'totalAccepted' => Application::accepted()->count(),
            'totalRejected' => Application::rejected()->count(),
            'totalApplications' => Application::count(),
        ];

        $applications = Application::with(['job', 'job.company'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('applications.index', compact('applications', 'job', 'data'));
    }


    public function adminApplicationIndex(Job $job)
    {
        // Application statistics
        $data = [
            'totalPending' => Application::pending()->count(),
            'totalReviewed' => Application::reviewed()->count(),
            'totalAccepted' => Application::accepted()->count(),
            'totalRejected' => Application::rejected()->count(),
            'totalApplications' => Application::count(),
        ];
        // Build query for applications
        $applicationsQuery = Application::with(['job', 'job.company']);

        // Filter by specific job if provided
        // if ($job) {
        //     $applicationsQuery->where('job_id', $job->id);
        // }

        $applications = $applicationsQuery->latest()->paginate(10);

        return view('applications.index', compact( 'applications','job','data'));
    }


    public function create(Job $job)
    {
        // Check if user already applied
        $existingApplication = Application::where('job_id', $job->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($existingApplication) {
            return redirect()->route('jobs.show', $job)
                ->with('error', 'You have already applied for this job.');
        }

        // Check if job is active
        if (!$job->is_active) {
            return redirect()->route('jobs.show', $job)
                ->with('error', 'This job is no longer accepting applications.');
        }

        return view('applications.create', compact('job'));
    }

    public function store(Request $request, Job $job)
    {
        // Check if user already applied
        $existingApplication = Application::where('job_id', $job->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($existingApplication) {
            return redirect()->route('jobs.show', $job)
                ->with('error', 'You have already applied for this job.');
        }

        // Check if job is active
        if (!$job->is_active) {
            return redirect()->route('jobs.show', $job)
                ->with('error', 'This job is no longer accepting applications.');
        }

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'experience_years' => 'required|integer|min:0|max:50',
            'address' => 'nullable|string|max:500',
            'skills' => 'required|string|max:1000',
            'education' => 'required|string|max:1000',
            'resume' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'cover_letter' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        try {
            DB::transaction(function () use ($validated, $request, $job) {
                // Handle file uploads
                $resumePath = $request->file('resume')->store('applications/resumes', 'public');

                $coverLetterPath = null;
                if ($request->hasFile('cover_letter')) {
                    $coverLetterPath = $request->file('cover_letter')->store('applications/cover_letters', 'public');
                }

                // Create application
                Application::create([
                    'job_id' => $job->id,
                    'user_id' => auth()->id(),
                    'full_name' => $validated['full_name'],
                    'email' => $validated['email'],
                    'phone' => $validated['phone'],
                    'experience_years' => $validated['experience_years'],
                    'address' => $validated['address'],
                    'skills' => $validated['skills'],
                    'education' => $validated['education'],
                    'resume_path' => $resumePath,
                    'cover_letter_path' => $coverLetterPath,
                    'status' => 'pending',
                ]);
            });

            return redirect()->route('jobs.show', $job)
                ->with('success', 'Application submitted successfully! We will review your application and get back to you soon.');
        } catch (\Exception $e) {
            Log::error('Application submission error: ' . $e->getMessage());

            // Clean up uploaded files if any
            if (isset($resumePath)) {
                Storage::disk('public')->delete($resumePath);
            }
            if (isset($coverLetterPath)) {
                Storage::disk('public')->delete($coverLetterPath);
            }

            return back()->with('error', 'Failed to submit application. Please try again.')->withInput();
        }
    }

    public function show(Application $application)
    {
        // Authorization - user can only view their own applications
        if ($application->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $application->load(['job.company', 'user']);

        return view('applications.show', compact('application'));
    }

    public function adminApplicationShow(Application $application)
    {
        // Authorization - user can only view their own applications
        if (auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $application->load(['job.company', 'user']);

        return view('applications.show', compact('application'));
    }


    public function applicationUpdateStatus(Request $request, Application $application)
    {
        $validated = $request->validate([
            // 'status' => 'required|in:pending,under_review,shortlisted,interview,accepted,rejected',
            'status' => 'required|in:pending,reviewed,accepted,rejected',
            'notes' => 'nullable|string',
        ]);

        $application->update($validated);

        return redirect()->route('admin.applications.index', $application)
            ->with('success', 'Application status updated successfully.');
    }


    public function destroy(Application $application)
    {
        // Authorization - user can only delete their own applications
        if ($application->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Only allow deletion of pending applications
        if ($application->status !== 'pending') {
            return back()->with('error', 'You can only withdraw pending applications.');
        }

        try {
            DB::transaction(function () use ($application) {
                // Delete files from storage
                if ($application->resume_path) {
                    Storage::disk('public')->delete($application->resume_path);
                }
                if ($application->cover_letter_path) {
                    Storage::disk('public')->delete($application->cover_letter_path);
                }

                // Delete application
                $application->delete();
            });

            return redirect()->route('applications.index')
                ->with('success', 'Application withdrawn successfully.');
        } catch (\Exception $e) {
            Log::error('Application deletion error: ' . $e->getMessage());
            return back()->with('error', 'Failed to withdraw application. Please try again.');
        }
    }

    // Employer methods to manage applications
    public function employerIndex()
    {
        $applications = Application::with(['job', 'user'])
            ->whereHas('job', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->latest()
            ->paginate(10);

        return view('applications.employer-index', compact('applications'));
    }

    public function employerShow(Application $application)
    {
        // Authorization - employer can only view applications for their jobs
        if ($application->job->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $application->load(['job', 'user']);

        return view('applications.employer-show', compact('application'));
    }

    public function updateStatus(Request $request, Application $application)
    {
        // Authorization - employer can only update status for their jobs
        if ($application->job->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'status' => 'required|in:reviewed,accepted,rejected',
            'notes' => 'nullable|string|max:1000',
        ]);

        try {
            $application->update([
                'status' => $validated['status'],
                'notes' => $validated['notes'] ?? $application->notes,
            ]);

            return back()->with('success', 'Application status updated successfully.');
        } catch (\Exception $e) {
            Log::error('Application status update error: ' . $e->getMessage());
            return back()->with('error', 'Failed to update application status.');
        }
    }

    // Method to view applications for a specific job
    public function jobApplications(Job $job)
    {
        // Authorization - only job owner can view applications
        if ($job->user_id !== auth()->id()) { // Changed to user_id
            abort(403, 'Unauthorized action.');
        }

        $applications = Application::with(['user'])
            ->where('job_id', $job->id)
            ->latest()
            ->paginate(10);

        return view('applications.index', compact('job', 'applications'));
    }

    public function downloadResume(Application $application)
    {
        // Authorization - only job owner can download resumes
        if ($application->job->user_id !== auth()->id()) { // Changed to user_id
            abort(403, 'Unauthorized action.');
        }

        if (!Storage::disk('public')->exists($application->resume_path)) {
            abort(404, 'Resume file not found.');
        }

        return Storage::disk('public')->download($application->resume_path);
    }

    public function downloadCoverLetter(Application $application)
    {
        // Authorization - only job owner can download cover letters
        if ($application->job->user_id !== auth()->id()) { // Changed to user_id
            abort(403, 'Unauthorized action.');
        }

        if (!$application->cover_letter_path || !Storage::disk('public')->exists($application->cover_letter_path)) {
            abort(404, 'Cover letter file not found.');
        }

        return Storage::disk('public')->download($application->cover_letter_path);
    }
}
