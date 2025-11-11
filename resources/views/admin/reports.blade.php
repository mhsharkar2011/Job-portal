<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Analytics & Reports
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Date Range Filter -->
            <div class="bg-white shadow-sm rounded-lg mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Report Period</h3>
                </div>
                <div class="p-6">
                    <form method="GET" action="{{ route('admin.reports') }}"
                        class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                        <div class="flex-1">
                            <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                            <input type="date" name="start_date" id="start_date"
                                value="{{ $startDate ?? now()->subDays(30)->format('Y-m-d') }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div class="flex-1">
                            <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                            <input type="date" name="end_date" id="end_date"
                                value="{{ $endDate ?? now()->format('Y-m-d') }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div class="flex items-end">
                            <button type="submit"
                                class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150">
                                <i class="fas fa-filter mr-2"></i>Apply Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Key Metrics -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <!-- Applications Card -->
                <div class="bg-white shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Total Applications</p>
                                <p class="text-2xl font-semibold text-gray-900">
                                    {{ number_format($totalApplications ?? 0) }}</p>
                            </div>
                            <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                                <i class="fas fa-file-alt text-blue-600 text-xl"></i>
                            </div>
                        </div>
                        <div class="mt-2">
                            @php
                                $appGrowth = $applicationsGrowth ?? 0;
                            @endphp
                            <span class="text-sm font-medium {{ $appGrowth >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                <i class="fas fa-arrow-{{ $appGrowth >= 0 ? 'up' : 'down' }} mr-1"></i>
                                {{ number_format(abs($appGrowth), 1) }}%
                            </span>
                            <span class="text-sm text-gray-500 ml-2">vs previous period</span>
                        </div>
                    </div>
                </div>

                <!-- Jobs Card -->
                <div class="bg-white shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Total Jobs</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ number_format($totalJobs ?? 0) }}</p>
                            </div>
                            <div class="flex-shrink-0 bg-green-100 rounded-lg p-3">
                                <i class="fas fa-briefcase text-green-600 text-xl"></i>
                            </div>
                        </div>
                        <div class="mt-2">
                            @php
                                $jobGrowth = $jobsGrowth ?? 0;
                            @endphp
                            <span class="text-sm font-medium {{ $jobGrowth >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                <i class="fas fa-arrow-{{ $jobGrowth >= 0 ? 'up' : 'down' }} mr-1"></i>
                                {{ number_format(abs($jobGrowth), 1) }}%
                            </span>
                            <span class="text-sm text-gray-500 ml-2">vs previous period</span>
                        </div>
                    </div>
                </div>

                <!-- Users Card -->
                <div class="bg-white shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Total Users</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ number_format($totalUsers ?? 0) }}
                                </p>
                            </div>
                            <div class="flex-shrink-0 bg-purple-100 rounded-lg p-3">
                                <i class="fas fa-users text-purple-600 text-xl"></i>
                            </div>
                        </div>
                        <div class="mt-2">
                            @php
                                $userGrowth = $usersGrowth ?? 0;
                            @endphp
                            <span
                                class="text-sm font-medium {{ $userGrowth >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                <i class="fas fa-arrow-{{ $userGrowth >= 0 ? 'up' : 'down' }} mr-1"></i>
                                {{ number_format(abs($userGrowth), 1) }}%
                            </span>
                            <span class="text-sm text-gray-500 ml-2">vs previous period</span>
                        </div>
                    </div>
                </div>

                <!-- Active Jobs Card -->
                <div class="bg-white shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Active Jobs</p>
                                <p class="text-2xl font-semibold text-gray-900">
                                    {{ number_format($jobStats->active ?? 0) }}</p>
                            </div>
                            <div class="flex-shrink-0 bg-yellow-100 rounded-lg p-3">
                                <i class="fas fa-bullseye text-yellow-600 text-xl"></i>
                            </div>
                        </div>
                        <div class="mt-2 text-sm text-gray-500">
                            {{ number_format($jobStats->inactive ?? 0) }} inactive
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Application Status Distribution -->
                <div class="bg-white shadow-sm rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Application Status Distribution</h3>
                    </div>
                    <div class="p-6">
                        @if (isset($statusDistribution) && $statusDistribution->count() > 0)
                            <div class="space-y-4">
                                @foreach ($statusDistribution as $status)
                                    @php
                                        $percentage =
                                            ($totalApplications ?? 0) > 0
                                                ? ($status->count / $totalApplications) * 100
                                                : 0;
                                        $statusColors = [
                                            'pending' => 'bg-yellow-500',
                                            'under_review' => 'bg-blue-500',
                                            'shortlisted' => 'bg-purple-500',
                                            'interview' => 'bg-indigo-500',
                                            'accepted' => 'bg-green-500',
                                            'rejected' => 'bg-red-500',
                                        ];
                                        $colorClass = $statusColors[$status->status] ?? 'bg-gray-500';
                                    @endphp
                                    <div>
                                        <div class="flex justify-between text-sm text-gray-600 mb-1">
                                            <span
                                                class="capitalize">{{ str_replace('_', ' ', $status->status) }}</span>
                                            <span>{{ $status->count }} ({{ number_format($percentage, 1) }}%)</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="h-2 rounded-full {{ $colorClass }}"
                                                style="width: {{ $percentage }}%"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <i class="fas fa-chart-pie text-gray-300 text-4xl mb-4"></i>
                                <p class="text-gray-500">No application data available for the selected period.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- User Distribution -->
                <div class="bg-white shadow-sm rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">User Distribution</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div>
                                <div class="flex justify-between text-sm text-gray-600 mb-1">
                                    <span>Employers</span>
                                    <span>{{ $userStats->employers ?? 0 }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="h-2 rounded-full bg-green-500"
                                        style="width: {{ ($totalUsers ?? 0) > 0 ? (($userStats->employers ?? 0) / $totalUsers) * 100 : 0 }}%">
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-sm text-gray-600 mb-1">
                                    <span>Job Seekers</span>
                                    <span>{{ $userStats->job_seekers ?? 0 }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="h-2 rounded-full bg-blue-500"
                                        style="width: {{ ($totalUsers ?? 0) > 0 ? (($userStats->job_seekers ?? 0) / $totalUsers) * 100 : 0 }}%">
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-sm text-gray-600 mb-1">
                                    <span>Admins</span>
                                    <span>{{ $userStats->admins ?? 0 }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="h-2 rounded-full bg-purple-500"
                                        style="width: {{ ($totalUsers ?? 0) > 0 ? (($userStats->admins ?? 0) / $totalUsers) * 100 : 0 }}%">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Popular Jobs -->
                <div class="bg-white shadow-sm rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Most Popular Jobs</h3>
                    </div>
                    <div class="p-6">
                        @if (isset($popularJobs) && $popularJobs->count() > 0)
                            <div class="space-y-4">
                                @foreach ($popularJobs as $job)
                                    <div
                                        class="flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-150">
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-sm font-medium text-gray-900 truncate">
                                                {{ $job->job_title ?? 'Untitled Job' }}</h4>
                                            <p class="text-sm text-gray-500 truncate">
                                                {{ $job->company_name ?? 'No Company' }}</p>
                                        </div>
                                        <div class="ml-4 flex-shrink-0">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                <i class="fas fa-users mr-1"></i>
                                                {{ $job->applications_count ?? 0 }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <i class="fas fa-briefcase text-gray-300 text-4xl mb-4"></i>
                                <p class="text-gray-500">No job data available for the selected period.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Top Employers -->
                <div class="bg-white shadow-sm rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Top Employers</h3>
                    </div>
                    <div class="p-6">
                        @if (isset($topEmployers) && $topEmployers->count() > 0)
                            <div class="space-y-4">
                                @foreach ($topEmployers as $employer)
                                    <div
                                        class="flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-150">
                                        <div class="flex items-center space-x-3">
                                            @if ($employer->profile_photo_path)
                                                <img class="h-8 w-8 rounded-full object-cover"
                                                    src="{{ Storage::url($employer->profile_photo_path) }}"
                                                    alt="{{ $employer->name }}">
                                            @else
                                                <div
                                                    class="h-8 w-8 bg-gray-300 rounded-full flex items-center justify-center">
                                                    <span class="text-gray-600 font-medium text-xs">
                                                        {{ strtoupper(substr($employer->name ?? 'U', 0, 1)) }}
                                                    </span>
                                                </div>
                                            @endif
                                            <div>
                                                <h4 class="text-sm font-medium text-gray-900">
                                                    {{ $employer->name ?? 'Unknown User' }}</h4>
                                                <p class="text-xs text-gray-500">{{ $employer->email ?? 'No email' }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="ml-4 flex space-x-2">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-briefcase mr-1"></i>
                                                {{ $employer->jobs_count ?? 0 }}
                                            </span>
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                <i class="fas fa-file-alt mr-1"></i>
                                                {{ $employer->applications_count ?? 0 }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <i class="fas fa-users text-gray-300 text-4xl mb-4"></i>
                                <p class="text-gray-500">No employer data available for the selected period.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
