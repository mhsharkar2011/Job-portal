<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::withCount('activeJobs')
            ->ordered()
            ->paginate(20);

        return view('categories.index', compact('categories'));
    }

    /**
     * Display categories for public view.
     */
    public function browse()
    {
        $categories = Category::active()
            ->popular()
            ->withCount('activeJobs')
            ->get();

        $popularCategories = Category::active()
            ->popular(8)
            ->withCount('activeJobs')
            ->get();

        return view('categories.browse', compact('categories', 'popularCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:7|starts_with:#',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        try {
            // Generate slug from name
            $validated['slug'] = Str::slug($validated['name']);

            Category::create($validated);

            return redirect()->route('categories.index')
                ->with('success', 'Category created successfully!');

        } catch (\Exception $e) {
            Log::error('Category creation error: ' . $e->getMessage());
            return back()->with('error', 'Failed to create category. Please try again.')->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $jobs = $category->activeJobs()
            ->with(['company', 'category'])
            ->latest()
            ->paginate(12);

        $relatedCategories = Category::active()
            ->where('id', '!=', $category->id)
            ->popular(6)
            ->get();

        return view('categories.show', compact('category', 'jobs', 'relatedCategories'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')->ignore($category->id)
            ],
            'description' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:7|starts_with:#',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        try {
            // Update slug if name changed
            if ($category->name !== $validated['name']) {
                $validated['slug'] = Str::slug($validated['name']);
            }

            $category->update($validated);

            return redirect()->route('categories.index')
                ->with('success', 'Category updated successfully!');

        } catch (\Exception $e) {
            Log::error('Category update error: ' . $e->getMessage());
            return back()->with('error', 'Failed to update category. Please try again.')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            // Check if category has jobs
            if ($category->jobs()->exists()) {
                return back()->with('error', 'Cannot delete category that has jobs. Please reassign jobs first.');
            }

            $category->delete();

            return redirect()->route('categories.index')
                ->with('success', 'Category deleted successfully!');

        } catch (\Exception $e) {
            Log::error('Category deletion error: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete category. Please try again.');
        }
    }

    /**
     * Get categories for dropdown (API)
     */
    public function getCategories(Request $request)
    {
        $categories = Category::active()
            ->ordered()
            ->get(['id', 'name']);

        return response()->json($categories);
    }
}
