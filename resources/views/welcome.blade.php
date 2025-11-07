<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'JobPortal') }} - Find Your Dream Job</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .hero-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
</head>

<body class="antialiased bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <a href="{{ route('welcome') }}">
                            <h1 class="text-2xl font-bold text-gray-800">
                                Job<span class="text-blue-600">Portal</span>
                            </h1>
                        </a>
                    </div>
                </div>

                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="#features"
                            class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition duration-300">Features</a>
                        <a href="#companies"
                            class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition duration-300">Companies</a>
                        <a href="#categories"
                            class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition duration-300">Categories</a>
                        <a href="#jobs"
                            class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition duration-300">Browse
                            Jobs</a>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-300">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition duration-300">
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-300">
                                Sign Up
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-gradient text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">
                    Find Your Dream
                    <span class="text-yellow-300">Job</span>
                </h1>
                <p class="text-xl md:text-2xl mb-8 opacity-90 max-w-3xl mx-auto">
                    Discover thousands of job opportunities from top companies worldwide
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4 mb-12">
                    <a href="{{ auth()->check() ? route('jobs.index') : route('register') }}"
                        class="bg-yellow-400 hover:bg-yellow-500 text-gray-900 px-8 py-4 rounded-lg font-bold text-lg transition duration-300 transform hover:scale-105 shadow-lg">
                        <i class="fas fa-search mr-2"></i>Find Jobs
                    </a>
                    <a href="{{ auth()->check() ? route('jobs.create') : route('register') }}"
                        class="bg-transparent hover:bg-white hover:text-blue-600 border-2 border-white px-8 py-4 rounded-lg font-bold text-lg transition duration-300 shadow-lg">
                        <i class="fas fa-briefcase mr-2"></i>Post a Job
                    </a>
                </div>

                <!-- Quick Stats -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
                    <div
                        class="bg-white bg-opacity-20 rounded-lg p-6 backdrop-blur-sm border border-white border-opacity-30">
                        <div class="text-3xl font-bold mb-2">{{ $totalJobs }}+</div>
                        <div class="text-blue-100">Active Jobs</div>
                    </div>
                    <div
                        class="bg-white bg-opacity-20 rounded-lg p-6 backdrop-blur-sm border border-white border-opacity-30">
                        <div class="text-3xl font-bold mb-2">{{ $totalCompanies }}</div>
                        <div class="text-blue-100">Companies</div>
                    </div>
                    <div
                        class="bg-white bg-opacity-20 rounded-lg p-6 backdrop-blur-sm border border-white border-opacity-30">
                        <div class="text-3xl font-bold mb-2">{{ $newJobs }}</div>
                        <div class="text-blue-100">New This Week</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Why Choose Our Platform?</h2>
                <p class="text-xl text-gray-600">Everything you need to find the perfect job or candidate</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center p-6 hover:transform hover:scale-105 transition duration-300">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-search text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Smart Job Search</h3>
                    <p class="text-gray-600">Advanced filters and search to find jobs that match your skills and
                        preferences.</p>
                </div>

                <div class="text-center p-6 hover:transform hover:scale-105 transition duration-300">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-bolt text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Quick Apply</h3>
                    <p class="text-gray-600">Apply to multiple jobs with just one click using your saved profile.</p>
                </div>

                <div class="text-center p-6 hover:transform hover:scale-105 transition duration-300">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-chart-line text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Track Applications</h3>
                    <p class="text-gray-600">Monitor your application status and get real-time updates from employers.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Companies Section -->
    <section id="companies" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Featured Companies</h2>
                <p class="text-xl text-gray-600">Explore jobs from our partner companies</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @if (isset($companies) && count($companies) > 0)
                    @foreach ($companies as $company)
                        <div
                            class="bg-white rounded-lg shadow-md hover:shadow-xl transition duration-300 border border-gray-200">
                            <div class="p-6 text-center">
                                <div class="mb-4 flex justify-center">
                                    @if ($company->logo)
                                        <img src="{{ $company->logo_url }}" alt="{{ $company->name }} logo"
                                            class="w-16 h-16 rounded-lg object-cover border mr-4">
                                    @else
                                        <div
                                            class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center mr-4">
                                            <i class="fa-solid fa-building text-gray-400 text-xl"></i>
                                        </div>
                                    @endif
                                </div>
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $company->name }}</h3>
                                <p class="text-gray-600 mb-4">
                                    {{ $company->jobs_count ?? 0 }} Open Positions
                                </p>
                                <a href="{{ route('company.jobs', $company->id) }}"
                                    class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition duration-300">
                                    View Jobs
                                </a>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-span-full text-center py-12">
                        <i class="fas fa-building text-gray-300 text-6xl mb-4"></i>
                        <p class="text-gray-600 text-lg mb-4">No companies available at the moment.</p>
                        <a href="{{ route('companies.index') }}"
                            class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-3 rounded-lg font-medium transition duration-300">
                            Browse All Companies
                        </a>
                    </div>
                @endif
            </div>

            <div class="text-center">
                <a href="{{ route('companies.index') }}"
                    class="inline-block bg-white hover:bg-gray-100 text-blue-600 border border-blue-600 px-8 py-3 rounded-lg font-semibold transition duration-300">
                    View All Companies
                </a>
            </div>
        </div>
    </section>

    <!-- Job Categories Section -->
    <section id="categories" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Job Categories</h2>
                <p class="text-xl text-gray-600">Find jobs by category</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 mb-8">
                @if (isset($categories) && count($categories) > 0)
                    @foreach ($categories as $category)
                        <a href="{{ route('category.jobs', $category->slug) }}"
                            class="bg-gray-50 hover:bg-blue-600 hover:text-white border border-gray-200 rounded-xl p-4 text-center transition duration-300 transform hover:scale-105">
                            <div class="mb-2">
                                <i class="fas fa-folder text-blue-600 text-xl group-hover:text-white"></i>
                            </div>
                            <h6 class="font-semibold text-sm mb-1">{{ $category->name }}</h6>
                            <small class="text-gray-500 group-hover:text-blue-100">
                                ({{ $category->jobs_count ?? 0 }} jobs)
                            </small>
                        </a>
                    @endforeach
                @else
                    <div class="col-span-full text-center py-8">
                        <i class="fas fa-tags text-gray-300 text-5xl mb-4"></i>
                        <p class="text-gray-600">No categories available.</p>
                    </div>
                @endif
            </div>

            <div class="text-center">
                <a href="{{ route('categories.index') }}"
                    class="inline-block bg-white hover:bg-gray-100 text-blue-600 border border-blue-600 px-8 py-3 rounded-lg font-semibold transition duration-300">
                    Browse All Categories
                </a>
            </div>
        </div>
    </section>

    <!-- Latest Jobs Section -->
    <section id="jobs" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Latest Job Opportunities</h2>
                <p class="text-xl text-gray-600">Recently posted jobs</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                @if (isset($jobs) && count($jobs) > 0)
                    @foreach ($jobs as $job)
                        <div
                            class="bg-white rounded-lg shadow-md hover:shadow-xl transition duration-300 border border-gray-200">
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-4">
                                    <h3 class="text-xl font-semibold text-gray-900">{{ $job->title }}</h3>
                                    <span class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full font-medium">
                                        {{ $job->type }}
                                    </span>
                                </div>

                                <div class="space-y-2 mb-4">
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-building mr-2 text-blue-500"></i>
                                        <span>Company: </span>
                                        <a href="{{ route('company.jobs', $job->company_id) }}"
                                            class="ml-1 text-blue-600 hover:text-blue-800 font-medium">
                                            {{ $job->company->name }}
                                        </a>
                                    </div>

                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-tag mr-2 text-green-500"></i>
                                        <span>Category: </span>
                                        <a href="{{ route('category.jobs', $job->category->slug) }}"
                                            class="ml-1 text-blue-600 hover:text-blue-800 font-medium">
                                            {{ $job->category->name }}
                                        </a>
                                    </div>

                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-map-marker-alt mr-2 text-red-500"></i>
                                        <span>Location: {{ $job->location }}</span>
                                    </div>
                                </div>

                                <div class="flex justify-between items-center">
                                    <span class="text-green-600 font-bold text-lg">
                                        ${{ number_format($job->salary) }}
                                    </span>
                                    <a href="{{ route('jobs.show', $job->id) }}"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-300">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-span-full text-center py-12">
                        <i class="fas fa-briefcase text-gray-300 text-6xl mb-4"></i>
                        <p class="text-gray-600 text-lg mb-4">No jobs available at the moment.</p>
                        <a href="{{ route('jobs.index') }}"
                            class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition duration-300">
                            Browse All Jobs
                        </a>
                    </div>
                @endif
            </div>

            <div class="text-center">
                <a href="{{ route('jobs.index') }}"
                    class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold transition duration-300">
                    View All Job Opportunities
                </a>
            </div>
        </div>
    </section>

    <!-- For Employers Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">Hire the Best Talent</h2>
                    <p class="text-lg text-gray-600 mb-6">
                        Connect with qualified candidates and find the perfect fit for your company.
                        Our platform makes hiring efficient and effective.
                    </p>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3 text-lg"></i>
                            <span class="text-gray-700">Post jobs in minutes</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3 text-lg"></i>
                            <span class="text-gray-700">Receive quality applications</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3 text-lg"></i>
                            <span class="text-gray-700">Manage candidates easily</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3 text-lg"></i>
                            <span class="text-gray-700">Track application status</span>
                        </li>
                    </ul>
                    <a href="{{ auth()->check() ? route('jobs.create') : route('register') }}"
                        class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold transition duration-300">
                        <i class="fas fa-rocket mr-2"></i>Post a Job for Free
                    </a>
                </div>
                <div class="relative">
                    <div class="bg-blue-50 rounded-2xl p-8">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-white rounded-lg p-4 shadow-sm text-center">
                                <i class="fas fa-users text-blue-600 text-2xl mb-2"></i>
                                <h4 class="font-semibold text-gray-900">Quality Candidates</h4>
                            </div>
                            <div class="bg-white rounded-lg p-4 shadow-sm text-center">
                                <i class="fas fa-bolt text-yellow-600 text-2xl mb-2"></i>
                                <h4 class="font-semibold text-gray-900">Fast Hiring</h4>
                            </div>
                            <div class="bg-white rounded-lg p-4 shadow-sm text-center">
                                <i class="fas fa-chart-bar text-green-600 text-2xl mb-2"></i>
                                <h4 class="font-semibold text-gray-900">Analytics</h4>
                            </div>
                            <div class="bg-white rounded-lg p-4 shadow-sm text-center">
                                <i class="fas fa-shield-alt text-purple-600 text-2xl mb-2"></i>
                                <h4 class="font-semibold text-gray-900">Secure Platform</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center mb-4">
                        <i class="fas fa-briefcase text-2xl text-blue-400 mr-2"></i>
                        <span class="text-xl font-bold">{{ config('app.name', 'JobPortal') }}</span>
                    </div>
                    <p class="text-gray-400">
                        Connecting talent with opportunity. Find your dream job or your next great hire.
                    </p>
                </div>

                <div>
                    <h4 class="text-lg font-semibold mb-4">For Job Seekers</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="{{ route('jobs.index') }}"
                                class="hover:text-white transition duration-300">Browse Jobs</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">Career Advice</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">Resume Builder</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-semibold mb-4">For Employers</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="{{ route('jobs.create') }}"
                                class="hover:text-white transition duration-300">Post a Job</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">Browse Candidates</a>
                        </li>
                        <li><a href="#" class="hover:text-white transition duration-300">Pricing</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-semibold mb-4">Contact Us</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-2"></i>
                            <span>support@jobportal.com</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone mr-2"></i>
                            <span>+1 (555) 123-4567</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            <span>New York, NY</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} {{ config('app.name', 'JobPortal') }}. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add hover effects for interactive elements
        document.addEventListener('DOMContentLoaded', function() {
            const jobCards = document.querySelectorAll('.job-card, .bg-white.rounded-lg');
            jobCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px)';
                });
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });
    </script>
</body>

</html>
