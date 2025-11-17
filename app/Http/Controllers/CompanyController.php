<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Company;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalCompanies = Company::count('is_active');
        $companies = Company::with(['user', 'jobs'])
            ->active()
            ->latest()
            ->paginate(12);

        return view('companies.index', compact('companies', 'totalCompanies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::active()->ordered()->get();
        return view('companies.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->all();

        try {
            // Handle logo upload
            if ($request->hasFile('logo')) {
                $validated['logo'] = $request->file('logo')->store('companies/logos', 'public');
            }

            // Handle banner upload
            if ($request->hasFile('banner')) {
                $validated['banner'] = $request->file('banner')->store('companies/banners', 'public');
            }

            // Set user ID and active status
            $validated['user_id'] = Auth::id();
            $validated['is_active'] = true;

            $company = Company::create($validated);

            return redirect()->route('admin.company.show', $company)
                ->with('success', 'Company created successfully!');
        } catch (\Exception $e) {
            Log::error('Company creation error: ' . $e->getMessage());
            return back()->with('error', 'Failed to create company. Please try again.')->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        $company->load(['user', 'activeJobs' => function ($query) {
            $query->with('category')->latest();
        }]);

        return view('companies.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        // FIXED: Use Auth::id() instead of hardcoded 1
        if ($company->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::active()->ordered()->get();

        return view('companies.edit', compact('company', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        // Authorization check - user must own the company
        if ($company->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id', // FIXED: Added category_id
            'name' => 'required|string|max:255|unique:companies,name,' . $company->id . ',id,user_id,' . Auth::id(), // FIXED: Unique per user
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'about' => 'nullable|string|min:50|max:1000',
            'location' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'employees_count' => 'nullable|integer|min:1',
            'founded_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'facebook_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'is_active' => 'sometimes|boolean',
        ]);

        try {
            // Handle logo upload
            if ($request->hasFile('logo')) {
                // Delete old logo
                if ($company->logo) {
                    Storage::delete('public/' . $company->logo);
                }
                $validated['logo'] = $request->file('logo')->store('companies/logos', 'public');
            }

            // Handle banner upload
            if ($request->hasFile('banner')) {
                // Delete old banner
                if ($company->banner) {
                    Storage::delete('public/' . $company->banner);
                }
                $validated['banner'] = $request->file('banner')->store('companies/banners', 'public');
            }

            $company->update($validated);

            return redirect()->route('companies.show', $company)
                ->with('success', 'Company updated successfully!');
        } catch (\Exception $e) {
            Log::error('Company update error: ' . $e->getMessage());
            return back()->with('error', 'Failed to update company. Please try again.')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        // Authorization check - user must own the company
        if ($company->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        try {
            // Delete logo and banner files
            if ($company->logo) {
                Storage::delete('public/' . $company->logo);
            }
            if ($company->banner) {
                Storage::delete('public/' . $company->banner);
            }

            $company->delete();

            return redirect()->route('companies.index')
                ->with('success', 'Company deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Company deletion error: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete company. Please try again.');
        }
    }

    /**
     * Display user's companies
     */
    public function myCompanies()
    {
        $companies = Company::where('user_id', Auth::id())
            ->withCount('jobs')
            ->latest()
            ->paginate(12);

        return view('companies.my-companies', compact('companies'));
    }

    public function jobs(Job $job)
    {
        $jobs = Job::all();
        return view('companies.jobs', compact('jobs'));
    }
}
