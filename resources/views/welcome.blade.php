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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .hero-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .job-card:hover {
            transform: translateY(-5px);
            transition: all 0.3s ease;
        }
        .stat-card {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        .employer-card {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
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
                         <a href="{{ route('home') }}">
                       <h1 class="text-3xl font-bold text-gray-400">Job <span class="text-blue-600 dark:text-blue-500">Portal</span> </h1>
                    </a>
                    </div>
                </div>

                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="#features" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">Features</a>
                        <a href="#jobs" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">Browse Jobs</a>
                        <a href="#employers" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">For Employers</a>
                    </div>
                </div>

                <div class="flex items-center">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-300">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-300 ml-4">
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
                <p class="text-xl md:text-2xl mb-8 opacity-90">
                    Discover thousands of job opportunities from top companies
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4 mb-12">
                    <a href="{{ auth()->check() ? route('jobs.browse') : route('register') }}"
                       class="bg-yellow-400 hover:bg-yellow-500 text-gray-900 px-8 py-4 rounded-lg font-bold text-lg transition duration-300 transform hover:scale-105">
                       <i class="fas fa-search mr-2"></i>Find Jobs
                    </a>
                    <a href="{{ auth()->check() ? route('jobs.create') : route('register') }}"
                       class="bg-transparent hover:bg-white hover:text-blue-600 border-2 border-white px-8 py-4 rounded-lg font-bold text-lg transition duration-300">
                       <i class="fas fa-briefcase mr-2"></i>Post a Job
                    </a>
                </div>

                <!-- Quick Stats -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
                    <div class="bg-white bg-opacity-20 rounded-lg p-6 backdrop-blur-sm">
                        <div class="text-3xl font-bold mb-2">{{ $jobs->count() }}+</div>
                        <div class="text-blue-100">Active Jobs</div>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-lg p-6 backdrop-blur-sm">
                        <div class="text-3xl font-bold mb-2">100+</div>
                        <div class="text-blue-100">Companies</div>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-lg p-6 backdrop-blur-sm">
                        <div class="text-3xl font-bold mb-2">500+</div>
                        <div class="text-blue-100">Success Stories</div>
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
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-search text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Smart Job Search</h3>
                    <p class="text-gray-600">Advanced filters and search to find jobs that match your skills and preferences.</p>
                </div>

                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-bolt text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Quick Apply</h3>
                    <p class="text-gray-600">Apply to multiple jobs with just one click using your saved profile.</p>
                </div>

                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-chart-line text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Track Applications</h3>
                    <p class="text-gray-600">Monitor your application status and get real-time updates from employers.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest Jobs Section -->
    <section id="jobs" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Latest Job Opportunities</h2>
                <p class="text-xl text-gray-600">Discover new career opportunities from top companies</p>
            </div>

            @if($jobs->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    @foreach($jobs->take(6) as $job)
                        <div class="bg-white rounded-lg shadow-md job-card border border-gray-200">
                            <div class="p-6">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex items-center space-x-3">
                                        @if($job->logo)
                                            <img src="{{ asset('storage/' . $job->logo) }}"
                                                 alt="{{ $job->company_name }}"
                                                 class="w-12 h-12 rounded-lg object-cover">
                                        @else
                                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                                <span class="text-lg font-bold text-blue-600">
                                                    {{ substr($job->company_name, 0, 1) }}
                                                </span>
                                            </div>
                                        @endif
                                        <div>
                                            <h3 class="font-semibold text-gray-900">{{ $job->company_name }}</h3>
                                            <p class="text-sm text-gray-500">{{ $job->location }}</p>
                                        </div>
                                    </div>
                                    <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Active</span>
                                </div>

                                <h4 class="text-xl font-bold text-gray-900 mb-2">{{ $job->job_title }}</h4>
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                    {{ Str::limit($job->job_description, 100) }}
                                </p>

                                <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                                    <span>{{ $job->employment_type }}</span>
                                    <span>{{ $job->created_at->diffForHumans() }}</span>
                                </div>

                                <div class="flex justify-between items-center">
                                    @if($job->salary_minimum && $job->salary_maximum)
                                        <span class="text-green-600 font-semibold">
                                            ${{ number_format($job->salary_minimum) }} - ${{ number_format($job->salary_maximum) }}
                                        </span>
                                    @endif
                                    <a href="{{ auth()->check() ? route('jobs.show', $job) : route('login') }}"
                                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-300">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-center">
                    <a href="{{ auth()->check() ? route('jobs.browse') : route('register') }}"
                       class="bg-gray-900 hover:bg-black text-white px-8 py-3 rounded-lg font-semibold transition duration-300 inline-flex items-center">
                        View All Jobs
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-briefcase text-gray-300 text-6xl mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">No jobs available at the moment</h3>
                    <p class="text-gray-500">Check back later for new opportunities</p>
                </div>
            @endif
        </div>
    </section>

    <!-- For Employers Section -->
    <section id="employers" class="py-16 bg-white">
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
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span class="text-gray-700">Post jobs in minutes</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span class="text-gray-700">Receive quality applications</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span class="text-gray-700">Manage candidates easily</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span class="text-gray-700">Track application status</span>
                        </li>
                    </ul>
                    <a href="{{ auth()->check() ? route('jobs.create') : route('register') }}"
                       class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold transition duration-300 inline-flex items-center">
                        Post a Job for Free
                        <i class="fas fa-rocket ml-2"></i>
                    </a>
                </div>
                <div class="relative">
                    <div class="bg-blue-50 rounded-2xl p-8">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-white rounded-lg p-4 shadow-sm">
                                <i class="fas fa-users text-blue-600 text-2xl mb-2"></i>
                                <h4 class="font-semibold text-gray-900">Quality Candidates</h4>
                            </div>
                            <div class="bg-white rounded-lg p-4 shadow-sm">
                                <i class="fas fa-bolt text-yellow-600 text-2xl mb-2"></i>
                                <h4 class="font-semibold text-gray-900">Fast Hiring</h4>
                            </div>
                            <div class="bg-white rounded-lg p-4 shadow-sm">
                                <i class="fas fa-chart-bar text-green-600 text-2xl mb-2"></i>
                                <h4 class="font-semibold text-gray-900">Analytics</h4>
                            </div>
                            <div class="bg-white rounded-lg p-4 shadow-sm">
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
                        <li><a href="#" class="hover:text-white transition duration-300">Browse Jobs</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">Career Advice</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">Resume Builder</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-semibold mb-4">For Employers</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition duration-300">Post a Job</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">Browse Candidates</a></li>
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
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Add some interactive features
        $(document).ready(function() {
            // Animate stats counter
            $('.stat-card').each(function() {
                $(this).prop('Counter',0).animate({
                    Counter: $(this).text()
                }, {
                    duration: 2000,
                    easing: 'swing',
                    step: function (now) {
                        $(this).text(Math.ceil(now));
                    }
                });
            });
        });
    </script>
</body>
</html>
