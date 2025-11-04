@extends('layouts.app')

@section('title', 'Job Categories - ' . config('app.name'))

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Browse Job Categories</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Explore jobs by category. Find your perfect opportunity in your field of expertise.
            </p>
        </div>

        <!-- Popular Categories -->
        @if($popularCategories->count() > 0)
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Popular Categories</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($popularCategories as $category)
                    <a href="{{ route('categories.show', $category) }}"
                       class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-all duration-200 transform hover:-translate-y-1 group">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-lg flex items-center justify-center text-white text-xl"
                                 style="background-color: {{ $category->color }}">
                                {!! $category->icon_html !!}
                            </div>
                            <span class="text-2xl font-bold text-gray-900 group-hover:text-blue-600">
                                {{ $category->active_jobs_count }}
                            </span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2 group-hover:text-blue-600">
                            {{ $category->name }}
                        </h3>
                        @if($category->description)
                            <p class="text-gray-600 text-sm line-clamp-2">{{ $category->description }}</p>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
        @endif

        <!-- All Categories -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">All Categories</h2>
            </div>
            <div class="p-6">
                @if($categories->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($categories as $category)
                            <div class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-all duration-200 group">
                                <div class="flex-shrink-0 w-12 h-12 rounded-lg flex items-center justify-center text-white mr-4"
                                     style="background-color: {{ $category->color }}">
                                    {!! $category->icon_html !!}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <a href="{{ route('categories.show', $category) }}"
                                       class="text-lg font-medium text-gray-900 hover:text-blue-600 transition-colors duration-200 block truncate">
                                        {{ $category->name }}
                                    </a>
                                    <div class="flex items-center text-sm text-gray-500 mt-1">
                                        <span class="mr-3">{{ $category->active_jobs_count }} jobs</span>
                                        @if($category->description)
                                            <span class="truncate">{{ $category->description }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex-shrink-0 ml-4">
                                    <i class="fa-solid fa-chevron-right text-gray-400 group-hover:text-blue-600 transition-colors duration-200"></i>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fa-solid fa-folder-open text-gray-300 text-6xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No categories available</h3>
                        <p class="text-gray-500">Check back later for new categories.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Call to Action -->
        <div class="mt-12 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg shadow-lg p-8 text-center text-white">
            <h2 class="text-2xl font-bold mb-4">Can't Find Your Category?</h2>
            <p class="text-blue-100 mb-6 max-w-2xl mx-auto">
                We're constantly adding new categories. In the meantime, browse all available jobs or contact us to suggest a new category.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('jobs.browse') }}"
                   class="bg-white text-blue-600 hover:bg-blue-50 px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                    Browse All Jobs
                </a>
                <a href="{{ route('contact') }}"
                   class="border border-white text-white hover:bg-white hover:text-blue-600 px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                    Suggest a Category
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endpush
