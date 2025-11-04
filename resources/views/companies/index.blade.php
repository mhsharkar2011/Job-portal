@extends('layouts.app')

@section('title', 'Companies - ' . config('app.name'))

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Companies</h1>
            <p class="text-gray-600">Discover amazing companies hiring right now</p>
        </div>

        <!-- Search and Filter -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <input type="text" id="search" placeholder="Search companies..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="industry" class="block text-sm font-medium text-gray-700 mb-1">Industry</label>
                    <select id="industry" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Industries</option>
                        <option value="Technology">Technology</option>
                        <option value="Healthcare">Healthcare</option>
                        <option value="Finance">Finance</option>
                        <option value="Education">Education</option>
                        <option value="Manufacturing">Manufacturing</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition-colors duration-200">
                        Search
                    </button>
                </div>
            </div>
        </div>

        <!-- Companies Grid -->
        @if($companies->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($companies as $company)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-200">
                        <!-- Company Banner -->
                        @if($company->banner)
                            <div class="h-32 bg-cover bg-center" style="background-image: url('{{ $company->banner_url }}')"></div>
                        @else
                            <div class="h-32 bg-gradient-to-r from-blue-500 to-purple-600"></div>
                        @endif

                        <div class="p-6">
                            <!-- Company Logo and Name -->
                            <div class="flex items-center mb-4">
                                @if($company->logo)
                                    <img src="{{ $company->logo_url }}" alt="{{ $company->name }} logo"
                                         class="w-16 h-16 rounded-lg object-cover border mr-4">
                                @else
                                    <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center mr-4">
                                        <i class="fa-solid fa-building text-gray-400 text-xl"></i>
                                    </div>
                                @endif
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-900">{{ $company->name }}</h3>
                                    <p class="text-gray-600">{{ $company->industry }}</p>
                                </div>
                            </div>

                            <!-- Company Info -->
                            <div class="space-y-2 mb-4">
                                @if($company->location)
                                    <div class="flex items-center text-gray-600">
                                        <i class="fa-solid fa-location-dot mr-2 w-4"></i>
                                        <span class="text-sm">{{ $company->location }}</span>
                                    </div>
                                @endif
                                @if($company->website)
                                    <div class="flex items-center text-gray-600">
                                        <i class="fa-solid fa-globe mr-2 w-4"></i>
                                        <span class="text-sm">{{ parse_url($company->website, PHP_URL_HOST) }}</span>
                                    </div>
                                @endif
                                @if($company->jobs_count > 0)
                                    <div class="flex items-center text-gray-600">
                                        <i class="fa-solid fa-briefcase mr-2 w-4"></i>
                                        <span class="text-sm">{{ $company->jobs_count }} open positions</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Company Description -->
                            @if($company->about)
                                <p class="text-gray-700 text-sm mb-4 line-clamp-2">
                                    {{ Str::limit($company->about, 120) }}
                                </p>
                            @endif

                            <!-- Action Buttons -->
                            <div class="flex space-x-2">
                                <a href="{{ route('companies.show', $company) }}"
                                   class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-4 rounded-md transition-colors duration-200 text-sm">
                                    View Company
                                </a>
                                @auth
                                    @if(auth()->id() === $company->user_id)
                                        <a href="{{ route('companies.edit', $company) }}"
                                           class="bg-gray-600 hover:bg-gray-700 text-white py-2 px-3 rounded-md transition-colors duration-200 text-sm">
                                            <i class="fa-solid fa-edit"></i>
                                        </a>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $companies->links() }}
            </div>
        @else
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <i class="fa-solid fa-building text-gray-300 text-6xl mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No Companies Found</h3>
                <p class="text-gray-600 mb-6">There are no companies to display at the moment.</p>
                @auth
                    <a href="{{ route('companies.create') }}"
                       class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition-colors duration-200">
                        <i class="fa-solid fa-plus mr-2"></i>
                        Add Your Company
                    </a>
                @endauth
            </div>
        @endif
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
