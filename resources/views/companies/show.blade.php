@extends('layouts.app')

@section('title', $company->name . ' - ' . config('app.name'))

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- Company Header -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
            <!-- Banner -->
            @if($company->banner)
                <div class="h-48 bg-cover bg-center" style="background-image: url('{{ $company->banner_url }}')"></div>
            @else
                <div class="h-48 bg-gradient-to-r from-blue-500 to-purple-600"></div>
            @endif

            <div class="p-6">
                <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between">
                    <div class="flex items-start space-x-6">
                        <!-- Logo -->
                        @if($company->logo)
                            <img src="{{ $company->logo_url }}" alt="{{ $company->name }} logo"
                                 class="w-24 h-24 rounded-lg object-cover border-4 border-white -mt-16 bg-white">
                        @else
                            <div class="w-24 h-24 bg-gray-200 rounded-lg border-4 border-white -mt-16 flex items-center justify-center">
                                <i class="fa-solid fa-building text-gray-400 text-3xl"></i>
                            </div>
                        @endif

                        <!-- Company Info -->
                        <div class="flex-1">
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $company->name }}</h1>
                            <div class="flex flex-wrap items-center text-gray-600 gap-4 mb-3">
                                @if($company->industry)
                                    <span class="flex items-center">
                                        <i class="fa-solid fa-industry mr-2"></i>
                                        {{ $company->industry }}
                                    </span>
                                @endif
                                @if($company->location)
                                    <span class="flex items-center">
                                        <i class="fa-solid fa-location-dot mr-2"></i>
                                        {{ $company->location }}
                                    </span>
                                @endif
                                @if($company->founded_year)
                                    <span class="flex items-center">
                                        <i class="fa-solid fa-calendar mr-2"></i>
                                        Founded {{ $company->founded_year }}
                                    </span>
                                @endif
                            </div>

                            <!-- Tags -->
                            <div class="flex flex-wrap gap-2">
                                @if($company->is_verified)
                                    <span class="px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full flex items-center">
                                        <i class="fa-solid fa-check-circle mr-1"></i>
                                        Verified
                                    </span>
                                @endif
                                @if($company->employees_count)
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded-full">
                                        {{ $company->employees_count }}+ employees
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex space-x-3 mt-4 lg:mt-0">
                        @auth
                            @if(auth()->id() === $company->user_id)
                                <a href="{{ route('companies.edit', $company) }}"
                                   class="inline-flex items-center px-4 py-2 border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium rounded-md transition-colors duration-200">
                                    <i class="fa-solid fa-edit mr-2"></i>
                                    Edit
                                </a>
                            @endif
                        @endauth

                        @if($company->website)
                            <a href="{{ $company->website }}" target="_blank"
                               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition-colors duration-200">
                                <i class="fa-solid fa-globe mr-2"></i>
                                Website
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- About Company -->
                @if($company->about)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">About Us</h2>
                    <div class="prose max-w-none text-gray-700 whitespace-pre-line">
                        {{ $company->about }}
                    </div>
                </div>
                @endif

                <!-- Contact Information -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Contact Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if($company->email)
                        <div class="flex items-center">
                            <i class="fa-solid fa-envelope text-gray-400 mr-3 w-5"></i>
                            <div>
                                <p class="text-sm text-gray-600">Email</p>
                                <a href="mailto:{{ $company->email }}" class="text-blue-600 hover:text-blue-800">
                                    {{ $company->email }}
                                </a>
                            </div>
                        </div>
                        @endif

                        @if($company->phone)
                        <div class="flex items-center">
                            <i class="fa-solid fa-phone text-gray-400 mr-3 w-5"></i>
                            <div>
                                <p class="text-sm text-gray-600">Phone</p>
                                <a href="tel:{{ $company->phone }}" class="text-blue-600 hover:text-blue-800">
                                    {{ $company->phone }}
                                </a>
                            </div>
                        </div>
                        @endif

                        @if($company->website)
                        <div class="flex items-center">
                            <i class="fa-solid fa-globe text-gray-400 mr-3 w-5"></i>
                            <div>
                                <p class="text-sm text-gray-600">Website</p>
                                <a href="{{ $company->website }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                    {{ parse_url($company->website, PHP_URL_HOST) }}
                                </a>
                            </div>
                        </div>
                        @endif

                        @if($company->full_address)
                        <div class="flex items-start">
                            <i class="fa-solid fa-location-dot text-gray-400 mr-3 w-5 mt-1"></i>
                            <div>
                                <p class="text-sm text-gray-600">Address</p>
                                <p class="text-gray-900">{{ $company->full_address }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Social Links -->
                @if($company->facebook_url || $company->twitter_url || $company->linkedin_url || $company->instagram_url)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Follow Us</h2>
                    <div class="flex space-x-4">
                        @if($company->facebook_url)
                            <a href="{{ $company->facebook_url }}" target="_blank"
                               class="w-10 h-10 bg-blue-600 hover:bg-blue-700 text-white rounded-full flex items-center justify-center transition-colors duration-200">
                                <i class="fa-brands fa-facebook-f"></i>
                            </a>
                        @endif
                        @if($company->twitter_url)
                            <a href="{{ $company->twitter_url }}" target="_blank"
                               class="w-10 h-10 bg-blue-400 hover:bg-blue-500 text-white rounded-full flex items-center justify-center transition-colors duration-200">
                                <i class="fa-brands fa-twitter"></i>
                            </a>
                        @endif
                        @if($company->linkedin_url)
                            <a href="{{ $company->linkedin_url }}" target="_blank"
                               class="w-10 h-10 bg-blue-700 hover:bg-blue-800 text-white rounded-full flex items-center justify-center transition-colors duration-200">
                                <i class="fa-brands fa-linkedin-in"></i>
                            </a>
                        @endif
                        @if($company->instagram_url)
                            <a href="{{ $company->instagram_url }}" target="_blank"
                               class="w-10 h-10 bg-pink-600 hover:bg-pink-700 text-white rounded-full flex items-center justify-center transition-colors duration-200">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                        @endif
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Company Stats -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Company Stats</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Open Positions</span>
                            <span class="font-semibold text-blue-600">{{ $company->activeJobs->count() }}</span>
                        </div>
                        @if($company->employees_count)
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Employees</span>
                            <span class="font-semibold text-gray-900">{{ $company->employees_count }}+</span>
                        </div>
                        @endif
                        @if($company->founded_year)
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Founded</span>
                            <span class="font-semibold text-gray-900">{{ $company->founded_year }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Status</span>
                            <span class="font-semibold {{ $company->is_active ? 'text-green-600' : 'text-red-600' }}">
                                {{ $company->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Open Positions -->
                @if($company->activeJobs->count() > 0)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Open Positions</h3>
                    <div class="space-y-3">
                        @foreach($company->activeJobs->take(5) as $job)
                        <div class="border-l-4 border-blue-500 pl-4 py-1">
                            <a href="{{ route('jobs.show', $job) }}" class="font-medium text-gray-900 hover:text-blue-600 block">
                                {{ $job->job_title }}
                            </a>
                            <div class="flex items-center text-sm text-gray-600 mt-1">
                                <span class="mr-3">{{ $job->location }}</span>
                                <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded text-xs">
                                    {{ ucfirst(str_replace('-', ' ', $job->employment_type)) }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @if($company->activeJobs->count() > 5)
                        <a href="{{ route('jobs.browse') }}?company={{ $company->id }}"
                           class="block text-center mt-4 text-blue-600 hover:text-blue-800 font-medium">
                            View All Positions
                        </a>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush
