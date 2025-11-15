<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Resume;
use App\Models\State;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ResumeController extends Controller
{
    public function create()
    {
        // Check if user already has a resume
        if (Auth::user()->resume) {
            return redirect()->route('seeker.resumes.edit', Auth::user()->resume->id)
                ->with('info', 'You already have a resume. Redirected to edit page.');
        }

        return view('seeker.resumes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->all();

        // Create resume for the authenticated user
        $resume = Auth::user()->resume()->create($validated);

        return redirect()->route('seeker.resumes.show', $resume->id)
            ->with('success', 'Resume created successfully!');
    }

    public function show(Resume $resume)
    {
        // Ensure user can only view their own resume
        if ($resume->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('seekers.resumes.show', compact('resume'));
    }

    public function edit(Resume $resume)
    {
        // Ensure user can only edit their own resume
        $countries = Country::all();
        $states = State::all();
        if ($resume->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('seekers.resumes.edit', compact('resume', 'countries', 'states'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Resume $resume)
    {
        // Ensure user can only update their own resume
        if ($resume->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->all();

        $resume->update($validated);

        return redirect()->route('seeker.resumes.show', $resume->id)->with('success', 'Resume updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resume $resume)
    {
        //
    }

    public function getStates()
    {
        $country_id = request('country');
        $states = State::where('country_id', $country_id)->get();
        return view('resumes.edit', compact('states'));
    }

    public function download(Resume $resume)
    {
        // Ensure user can only download their own resume
        if ($resume->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        try {
            // Generate PDF
            $pdf = Pdf::loadView('seeker.resumes.download', compact('resume'));

            // Set paper size and orientation
            $pdf->setPaper('A4', 'portrait');

            // Optional: Set additional options
            $pdf->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'dpi' => 150,
                'defaultFont' => 'Arial',
            ]);

            // Generate filename
            $filename = 'resume_' . str_replace(' ', '_', $resume->user->name) . '_' . date('Y-m-d') . '.pdf';

            // Download PDF
            return $pdf->download($filename);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to generate PDF: ' . $e->getMessage());
        }
    }

    /**
     * Stream PDF for preview
     */
    public function preview(Resume $resume)
    {
        // Ensure user can only preview their own resume
        if ($resume->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $pdf = Pdf::loadView('seeker.resumes.pdf', compact('resume'));
        return $pdf->stream('resume_preview.pdf');
    }

    /**
     * Save PDF to storage
     */
    public function savePdf(Resume $resume)
    {
        // Ensure user can only save their own resume
        if ($resume->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $pdf = Pdf::loadView('seeker.resumes.pdf', compact('resume'));

            $filename = 'resumes/resume_' . $resume->id . '_' . time() . '.pdf';
            Storage::disk('public')->put($filename, $pdf->output());

            // Update resume with file path if needed
            $resume->update(['resume_file' => $filename]);

            return redirect()->back()
                ->with('success', 'Resume PDF saved successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to save PDF: ' . $e->getMessage());
        }
    }
}
