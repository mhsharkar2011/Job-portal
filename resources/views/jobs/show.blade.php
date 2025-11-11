@extends('layouts.app')

@section('title', $job->job_title . ' - ' . config('app.name'))

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- Breadcrumb -->
        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-sm text-gray-500">
                <li><a href="{{ route('dashboard') }}" class="hover:text-blue-600">Dashboard</a></li>
                <li><i class="fa-solid fa-chevron-right text-xs"></i></li>
                <li><a href="{{ route('jobs.browse') }}" class="hover:text-blue-600">Jobs</a></li>
                <li><i class="fa-solid fa-chevron-right text-xs"></i></li>
                <li class="text-gray-900">{{ Str::limit($job->job_title, 30) }}</li>
            </ol>
        </nav>

        <!-- Job Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $job->job_title }}</h1>

                    <div class="flex flex-wrap items-center text-gray-600 mb-4 gap-4">
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

                    <!-- Job Tags -->
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded-full">
                            {{ ucfirst(str_replace('-', ' ', $job->employment_type)) }}
                        </span>
                        @if($job->salary_minimum && $job->salary_maximum)
                            <span class="px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full">
                                {{ $job->salary_currency }} {{ number_format($job->salary_minimum) }} - {{ number_format($job->salary_maximum) }}
                            </span>
                        @endif
                        @if($job->category)
                            <span class="px-3 py-1 bg-purple-100 text-purple-800 text-sm rounded-full">
                                {{ $job->category->name }}
                            </span>
                        @endif
                        <span class="px-3 py-1 bg-orange-100 text-orange-800 text-sm rounded-full">
                            {{ $job->experience_minimum }}-{{ $job->experience_maximum }} {{ $job->experience_unit }}
                        </span>
                    </div>
                </div>

                <!-- Company Logo -->
                @if($job->company && $job->company->logo)
                    <div class="flex-shrink-0">
                        <img src="{{ asset('storage/' . $job->company->logo) }}"
                             alt="{{ $job->company->name }} logo"
                             class="w-20 h-20 rounded-lg object-cover border">
                    </div>
                @endif
            </div>

            <!-- Apply Button -->
            <div class="mt-6 flex flex-wrap gap-4">
                <a href="{{ route('applications.create', $job) }}"
                   class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                    <i class="fa-solid fa-paper-plane mr-2"></i>
                    Apply for this Job
                </a>

                @auth
                    @if(auth()->id() === $job->user_id)
                        <div class="flex gap-2">
                            <a href="{{ route('jobs.edit', $job) }}"
                               class="inline-flex items-center px-4 py-3 border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium rounded-lg transition-colors duration-200">
                                <i class="fa-solid fa-edit mr-2"></i>
                                Edit Job
                            </a>
                            <form action="{{ route('jobs.destroy', $job) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this job?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center px-4 py-3 border border-red-300 hover:bg-red-50 text-red-700 font-medium rounded-lg transition-colors duration-200">
                                    <i class="fa-solid fa-trash mr-2"></i>
                                    Delete Job
                                </button>
                            </form>
                        </div>
                    @else
                        <button class="inline-flex items-center px-4 py-3 border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium rounded-lg transition-colors duration-200">
                            <i class="fa-regular fa-bookmark mr-2"></i>
                            Save Job
                        </button>
                    @endif
                @endauth
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Job Description -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Job Description</h2>
                    <div class="prose max-w-none text-gray-700 whitespace-pre-line">
                        {{ $job->job_description }}
                    </div>
                </div>

                <!-- Requirements -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Requirements</h2>
                    <div class="prose max-w-none text-gray-700 whitespace-pre-line">
                        {{ $job->requirement }}
                    </div>
                </div>

                <!-- Key Skills -->
                @if($job->key_skills)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Key Skills</h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach(explode(',', $job->key_skills) as $skill)
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm">
                                {{ trim($skill) }}
                            </span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Job Overview -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Job Overview</h3>
                    <div class="space-y-3">
                        @if($job->salary_minimum && $job->salary_maximum)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Salary:</span>
                            <span class="font-medium text-green-600">
                                {{ $job->salary_currency }} {{ number_format($job->salary_minimum) }} - {{ number_format($job->salary_maximum) }}
                            </span>
                        </div>
                        @endif

                        <div class="flex justify-between">
                            <span class="text-gray-600">Employment Type:</span>
                            <span class="font-medium">{{ ucfirst(str_replace('-', ' ', $job->employment_type)) }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-600">Location:</span>
                            <span class="font-medium">{{ $job->location }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-600">Experience:</span>
                            <span class="font-medium">
                                {{ $job->experience_minimum }}-{{ $job->experience_maximum }} {{ $job->experience_unit }}
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-600">Role:</span>
                            <span class="font-medium">{{ $job->role }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-600">Industry:</span>
                            <span class="font-medium">{{ $job->industry_type }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-600">Positions:</span>
                            <span class="font-medium">{{ $job->positions_available }}</span>
                        </div>

                        @if($job->application_deadline)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Application Deadline:</span>
                            <span class="font-medium {{ $job->application_deadline->isPast() ? 'text-red-600' : 'text-green-600' }}">
                                {{ $job->application_deadline->format('M j, Y') }}
                            </span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Company Info -->
                @if($job->company)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Company Information</h3>
                    <div class="flex items-start mb-4">
                        @if($job->company->logo)
                            <img src="{{ asset('storage/' . $job->company->logo) }}"
                                 alt="{{ $job->company->name }} logo"
                                 class="w-12 h-12 rounded-lg object-cover mr-3 border">
                        @endif
                        <div>
                            <h4 class="font-semibold text-gray-900">{{ $job->company->name }}</h4>
                            @if($job->company->industry)
                                <p class="text-sm text-gray-600">{{ $job->company->industry }}</p>
                            @endif
                        </div>
                    </div>

                    @if($job->company->website)
                        <a href="{{ $job->company->website }}"
                           target="_blank"
                           class="inline-flex items-center text-blue-600 hover:text-blue-800 text-sm mb-2">
                            <i class="fa-solid fa-globe mr-2"></i>
                            Visit Website
                        </a>
                    @endif

                    @if($job->company->email)
                        <div class="flex items-center text-gray-600 text-sm mb-1">
                            <i class="fa-solid fa-envelope mr-2"></i>
                            {{ $job->company->email }}
                        </div>
                    @endif

                    @if($job->company->phone)
                        <div class="flex items-center text-gray-600 text-sm">
                            <i class="fa-solid fa-phone mr-2"></i>
                            {{ $job->company->phone }}
                        </div>
                    @endif
                </div>
                @endif

                <!-- Share Job -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Share This Job</h3>
                    <div class="flex space-x-3">
                        <a href="#" class="text-blue-600 hover:text-blue-800">
                            <i class="fa-brands fa-facebook fa-lg"></i>
                        </a>
                        <a href="#" class="text-blue-400 hover:text-blue-600">
                            <i class="fa-brands fa-twitter fa-lg"></i>
                        </a>
                        <a href="#" class="text-blue-700 hover:text-blue-900">
                            <i class="fa-brands fa-linkedin fa-lg"></i>
                        </a>
                        <a href="#" class="text-gray-800 hover:text-gray-600">
                            <i class="fa-brands fa-whatsapp fa-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Jobs -->
        @if($relatedJobs->count() > 0)
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Related Jobs</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($relatedJobs as $relatedJob)
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow duration-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">
                        <a href="{{ route('jobs.show', $relatedJob) }}" class="hover:text-blue-600">
                            {{ $relatedJob->job_title }}
                        </a>
                    </h3>
                    <p class="text-gray-600 mb-2">
                        {{ $relatedJob->company->name }} • {{ $relatedJob->location }}
                    </p>
                    <div class="flex items-center justify-between">
                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded">
                            {{ ucfirst(str_replace('-', ' ', $relatedJob->employment_type)) }}
                        </span>
                        <span class="text-sm text-gray-500">{{ $relatedJob->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
