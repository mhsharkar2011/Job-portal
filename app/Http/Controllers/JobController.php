<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use function Ramsey\Uuid\v1;

class JobController extends Controller
{
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
     * Display jobs listing for job seekers to apply
     */
    public function browse()
    {
        $jobs = Job::withCount('applications')
            ->with(['applications' => function ($query) {
                if (auth()->check()) {
                    $query->where('user_id', auth()->id());
                }
            }])
            ->latest()
            ->paginate(12);

        return view('jobs.browse', compact('jobs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jobs.post-job');
    }

    /**
     * Store a newly created resource in storage.
     */
  public function store(Request $request)
{
    $validated = $request->validate([
        'company_name' => 'required|string|max:255',
        'job_title' => 'required|string|max:255',
        'job_description' => 'required|string|min:50',
        'requirement' => 'required|string|min:50',
        'location' => 'required|string|max:255',
        'experience_minimum' => 'required|integer|min:0',
        'experience_maximum' => 'required|integer|min:0|gte:experience_minimum',
        'experience_unit' => 'required|in:years,months',
        'role' => 'required|string|max:255',
        'industry_type' => 'required|string|max:255',
        'employment_type' => 'required|in:full-time,part-time,contract,freelance,internship',
        'salary_minimum' => 'required|integer|min:0',
        'salary_maximum' => 'required|integer|min:0|gte:salary_minimum',
        'salary_currency' => 'required|in:USD,BDT,EUR,GBP',
        'key_skills' => 'required|string|min:3',
        'positions_available' => 'required|integer|min:1|max:100',
        'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    try {
        // Handle file upload
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('company-logos', 'public');
        }

        // Set additional fields
        $validated['user_id'] = auth()->id();
        $validated['is_active'] = true;

        // Create the job
        $job = Job::create($validated);

        return redirect()->route('jobs.createdJob')
            ->with('success', 'Job posted successfully! It will be live after review.');

    } catch (\Exception $e) {
        \Log::error('Job creation error: ' . $e->getMessage());
        return back()->with('error', 'Failed to create job. Please try again.')->withInput();
    }
}


    // Created Job for UI
    public function created()
    {
        $jobs = Job::all();
        return view('jobs.created-job', compact('jobs'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Job $job)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Job $job)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Job $job)
    {
        $input = $request->except('logo');
        if ($job->logo && $request->hasFile('logo')) {
            Storage::delete('public/jobs/logo/' . $job->logo);
            $job->logo = null;
        }

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $filename = $job->id . '-' . $job->job_title . '-' . date('Ymd') . '.' . $logo->getClientOriginalExtension();
            $logo->storeAs('public/jobs/logos', $filename);
            $job->logo = $filename;
            $job->save();
        }
        $job->update($input);
        return redirect()->route('jobs.createdJob')->with('success', 'Job Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $job)
    {
        $job->delete();

        return redirect()->route('jobs.appliedJob')->with('success', 'Job Deleted Successfully');
    }
}
