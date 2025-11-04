@extends('layouts.app')

@section('title', $category->name . ' Jobs - ' . config('app.name'))

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <!-- Breadcrumb -->
        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-sm text-gray-500">
                <li><a href="{{ route('home') }}" class="hover:text-blue-600">Home</a></li>
                <li><i class="fa-solid fa-chevron-right text-xs"></i></li>
                <li><a href="{{ route('categories.browse') }}" class="hover:text-blue-600">Categories</a></li>
                <li><i class="fa-solid fa-chevron-right text-xs"></i></li>
                <li class="text-gray-900">{{ $category->name }}</li>
            </ol>
        </nav>

        <!-- Category Header -->
        <div class="bg-white rounded-lg shadow-md p-8 mb-8 text-center">
            <div class="flex justify-center mb-4">
                <div class="w-20 h-20 rounded-2xl flex items-center justify-center text-white text-2xl"
                     style="background-color: {{ $category->color }}">
                    {!! $category->icon_html !!}
                </div>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $category->name }} Jobs</h1>
            @if($category->description)
                <p class="text-xl text-gray-600 max-w-3xl mx-auto mb-6">{{ $category->description }}</p>
            @endif
            <div class="flex flex-wrap justify-center gap-6 text-sm text-gray-500">
                <span class="flex items-center">
                    <i class="fa-solid fa-briefcase mr-2"></i>
                    {{ $jobs->total() }} jobs available
                </span>
                <span class="flex items-center">
                    <i class="fa-solid fa-clock mr-2"></i>
                    Updated daily
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-3">
                <!-- Jobs Section -->
                <div class="mb-8">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Available Jobs</h2>
                        <div class="text-sm text-gray-600">
                            Showing {{ $jobs->firstItem() ?? 0 }}-{{ $jobs->lastItem() ?? 0 }} of {{ $jobs->total() }} jobs
                        </div>
                    </div>

                    @if($jobs->count() > 0)
                        <div class="space-y-4">
                            @foreach($jobs as $job)
                                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow duration-200 border-l-4"
                                     style="border-left-color: {{ $category->color }}">
                                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                                        <div class="flex-1">
                                            <h3 class="text-xl font-semibold text-gray-900 mb-2">
                                                <a href="{{ route('jobs.show', $job) }}" class="hover:text-blue-600">
                                                    {{ $job->job_title }}
                                                </a>
                                            </h3>
                                            <div class="flex flex-wrap items-center text-gray-600 gap-4 mb-3">
                                                @if($job->company)
                                                    <span class="flex items-center">
                                                        <i class="fa-solid fa-building mr-2"></i>
                                                        {{ $job->company->name }}
                                                    </span>
                                                @endif
                                                <span class="flex items-center">
                                                    <i class="fa-solid fa-location-dot mr-2"></i>
                                                    {{ $job->location }}
                                                </span>
                                                <span class="flex items-center">
                                                    <i class="fa-solid fa-clock mr-2"></i>
                                                    {{ $job->created_at->diffForHumans() }}
                                                </span>
                                            </div>
                                            <div class="flex flex-wrap gap-2">
                                                <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded-full">
                                                    {{ ucfirst(str_replace('-', ' ', $job->employment_type)) }}
                                                </span>
                                                @if($job->salary_minimum && $job->salary_maximum)
                                                    <span class="px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full">
                                                        ${{ number_format($job->salary_minimum) }} - ${{ number_format($job->salary_maximum) }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="mt-4 lg:mt-0 lg:ml-6">
                                            <a href="{{ route('jobs.show', $job) }}"
                                               class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                                                Apply Now
                                                <i class="fa-solid fa-arrow-right ml-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-8">
                            {{ $jobs->links() }}
                        </div>
                    @else
                        <div class="bg-white rounded-lg shadow-md p-12 text-center">
                            <i class="fa-solid fa-briefcase text-gray-300 text-6xl mb-4"></i>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">No Jobs Available</h3>
                            <p class="text-gray-600 mb-6">There are no active jobs in this category at the moment.</p>
                            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                                <a href="{{ route('jobs.browse') }}"
                                   class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                                    Browse All Jobs
                                </a>
                                <a href="{{ route('categories.browse') }}"
                                   class="inline-flex items-center px-6 py-3 border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium rounded-lg transition-colors duration-200">
                                    View Other Categories
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Category Info -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Category Information</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Jobs:</span>
                            <span class="font-semibold">{{ $jobs->total() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status:</span>
                            <span class="font-semibold {{ $category->is_active ? 'text-green-600' : 'text-red-600' }}">
                                {{ $category->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Related Categories -->
                @if($relatedCategories->count() > 0)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Related Categories</h3>
                    <div class="space-y-3">
                        @foreach($relatedCategories as $related)
                            <a href="{{ route('categories.show', $related) }}"
                               class="flex items-center p-3 rounded-lg hover:bg-gray-50 transition-colors duration-200 group">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center text-white text-sm mr-3"
                                     style="background-color: {{ $related->color }}">
                                    {!! $related->icon_html !!}
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-gray-900 group-hover:text-blue-600">
                                        {{ $related->name }}
                                    </h4>
                                    <p class="text-xs text-gray-500">{{ $related->active_jobs_count }} jobs</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Newsletter Signup -->
                <div class="bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg shadow-md p-6 text-white">
                    <h3 class="text-lg font-semibold mb-2">Get Job Alerts</h3>
                    <p class="text-blue-100 text-sm mb-4">Receive the latest {{ $category->name }} jobs in your inbox</p>
                    <form class="space-y-3">
                        <input type="email" placeholder="Enter your email"
                               class="w-full px-3 py-2 rounded text-gray-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                        <button type="submit"
                                class="w-full bg-white text-blue-600 hover:bg-blue-50 py-2 rounded text-sm font-medium transition-colors duration-200">
                            Subscribe
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush
