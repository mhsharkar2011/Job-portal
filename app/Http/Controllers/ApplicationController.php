<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the applications for a specific job.
     */
    public function index(Job $job)
    {
        $applications = $job->applications()->with('user')->latest()->paginate(10);
        return view('applications.index', compact('job', 'applications'));
    }

    /**
     * Show the form for creating a new application.
     */
    public function create(Job $job)
    {
        return view('applications.create', compact('job'));
    }

    /**
     * Store a newly created application.
     */
  public function store(Request $request, Job $job)
    {
        // Check if job is still accepting applications
        if (!$job->is_accepting_applications) {
            return back()->with('error', 'This job is no longer accepting applications.');
        }

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'resume' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'cover_letter' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'skills' => 'nullable|string',
            'experience_years' => 'nullable|integer|min:0',
            'education' => 'nullable|string',
        ]);

        // Handle file uploads
        if ($request->hasFile('resume')) {
            $validated['resume'] = $request->file('resume')->store('resumes', 'public');
        }

        if ($request->hasFile('cover_letter')) {
            $validated['cover_letter'] = $request->file('cover_letter')->store('cover_letters', 'public');
        }

        // Create application
        $application = $job->applications()->create([
            ...$validated,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('jobs.show', $job)
            ->with('success', 'Application submitted successfully!');
    }

    /**
     * Update the application status.
     */
 public function updateStatus(Request $request, Application $application)
    {
        $request->validate([
            'status' => 'required|in:pending,under_review,shortlisted,interview,rejected,accepted',
        ]);

        $oldStatus = $application->status;
        $application->update(['status' => $request->status]);

        // If application is accepted, fill a position
        if ($request->status === 'accepted' && $oldStatus !== 'accepted') {
            $application->job->fillPosition();
        }

        // If application was accepted but now rejected, release the position
        if ($request->status !== 'accepted' && $oldStatus === 'accepted') {
            $application->job->releasePosition();
        }

        return back()->with('success', 'Application status updated successfully!');
    }

    /**
     * Remove the specified application.
     */
    public function destroy(Application $application)
    {
        // Delete associated files
        if ($application->resume) {
            Storage::disk('public')->delete($application->resume);
        }
        if ($application->cover_letter) {
            Storage::disk('public')->delete($application->cover_letter);
        }

        $application->delete();

        return back()->with('success', 'Application deleted successfully!');
    }


     public function myApplications()
    {
        $applications = Application::with('job')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('applications.my-applications', compact('applications'));
    }
}
