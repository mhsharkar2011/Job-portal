<?php
// app/Http/Controllers/HomeController.php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Category;
use App\Models\Job;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller
{
    public function welcome()
    {
        $companies = Company::withCount('jobs')
            ->where('is_active', true)
            ->orderBy('jobs_count', 'ASC')
            ->limit(16)
            ->get();

        $categories = Category::withCount('jobs')
            ->where('is_active', true)
            ->orderBy('jobs_count', 'desc')
            ->get();

        $jobs = Job::with(['company', 'category'])
            ->where('is_active', true)
            ->where('application_deadline', '>', now())
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        $totalJobs = Job::where('is_active', true)->count();
        $totalCompanies = Company::where('is_active', true)->count();
        $newJobs = Job::where('is_active', true)->where('created_at', '>=', now()->subWeek())->count();

        return view('welcome', compact(
            'categories',
            'companies',
            'totalCompanies',
            'jobs',
            'totalJobs',
            'newJobs'
        ));
    }

    public function indexJobs()
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
    public function showJob(Job $job)
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

    public function browseJobs(Request $request)
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
}
