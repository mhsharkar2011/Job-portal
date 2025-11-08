<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Welcome Section -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">
                    Welcome back, {{ auth()->user()->name }}!
                </h1>
                <p class="text-gray-600 mt-2">
                    @if (auth()->user()->role === 'employer')
                        Here's what's happening with your job postings today.
                    @else
                        Your job search journey at a glance.
                    @endif
                </p>
            </div>

            @if (auth()->user()->role === 'admin')
                <!-- Admin Dashboard -->
                @include('dashboard.admin')
            @elseif (auth()->user()->role === 'employer')
                <!-- Employer Dashboard -->
                @include('dashboard.employer')
            @else
                <!-- Job Seeker Dashboard -->
                @include('dashboard.job-seeker')
            @endif
        </div>
    </div>
</x-app-layout>
