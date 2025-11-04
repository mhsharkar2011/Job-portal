<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Applications Card -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                        <i class="fa-solid fa-paper-plane text-white text-sm"></i>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Applications</dt>
                        <dd class="text-lg font-semibold text-gray-900">
                            {{ $totalApplications ?? 0 }}
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-3">
            <div class="text-sm">
                <a href="{{ route('applications.myApplications') }}" class="font-medium text-blue-600 hover:text-blue-900">
                    View all applications
                </a>
            </div>
        </div>
    </div>

    <!-- Pending Applications Card -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center">
                        <i class="fa-solid fa-clock text-white text-sm"></i>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Pending</dt>
                        <dd class="text-lg font-semibold text-gray-900">
                            {{ $pendingApplications ?? 0 }}
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-3">
            <div class="text-sm text-gray-600">
                Under review
            </div>
        </div>
    </div>

    <!-- Accepted Applications Card -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                        <i class="fa-solid fa-check text-white text-sm"></i>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Accepted</dt>
                        <dd class="text-lg font-semibold text-gray-900">
                            {{ $acceptedApplications ?? 0 }}
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-3">
            <div class="text-sm text-green-600 font-medium">
                Congratulations!
            </div>
        </div>
    </div>

    <!-- Under Review Card -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center">
                        <i class="fa-solid fa-eye text-white text-sm"></i>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Under Review</dt>
                        <dd class="text-lg font-semibold text-gray-900">
                            {{ $underReviewApplications ?? 0 }}
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-3">
            <div class="text-sm text-purple-600">
                Being evaluated
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity Grid -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Recent Applications -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Recent Applications</h3>
        </div>
        <div class="divide-y divide-gray-200">
            @forelse(($recentApplications ?? []) as $application)
                <div class="px-6 py-4 hover:bg-gray-50 transition-colors duration-150">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <h4 class="text-sm font-semibold text-gray-900">{{ $application->job->job_title ?? 'N/A' }}</h4>
                            <p class="text-sm text-gray-500 mt-1">{{ $application->job->company_name ?? 'N/A' }}</p>
                            <div class="flex items-center mt-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if(($application->status ?? '') === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif(($application->status ?? '') === 'accepted') bg-green-100 text-green-800
                                    @elseif(($application->status ?? '') === 'rejected') bg-red-100 text-red-800
                                    @elseif(($application->status ?? '') === 'under_review') bg-blue-100 text-blue-800
                                    @elseif(($application->status ?? '') === 'shortlisted') bg-indigo-100 text-indigo-800
                                    @elseif(($application->status ?? '') === 'interview') bg-purple-100 text-purple-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ $application->formatted_status ?? ucfirst($application->status ?? 'Unknown') }}
                                </span>
                                <span class="ml-2 text-xs text-gray-500">
                                    {{ $application->created_at->diffForHumans() ?? 'N/A' }}
                                </span>
                            </div>
                        </div>
                        <div class="ml-4 flex-shrink-0">
                            @if(isset($application->job))
                                <a href="{{ route('jobs.show', $application->job) }}"
                                   class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                    View Job
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-6 py-8 text-center">
                    <i class="fa-solid fa-file-circle-question text-gray-300 text-4xl mb-3"></i>
                    <p class="text-gray-500">No applications yet</p>
                    <a href="{{ route('jobs.browse') }}" class="inline-block mt-2 text-blue-600 hover:text-blue-900 font-medium">
                        Browse jobs
                    </a>
                </div>
            @endforelse
        </div>
        @if(isset($recentApplications) && $recentApplications->count() > 0)
            <div class="bg-gray-50 px-6 py-3 border-t border-gray-200">
                <a href="{{ route('applications.myApplications') }}" class="text-sm font-medium text-blue-600 hover:text-blue-900">
                    View all applications
                </a>
            </div>
        @endif
    </div>

    <!-- Featured Jobs -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Featured Jobs</h3>
        </div>
        <div class="divide-y divide-gray-200">
            @forelse(($featuredJobs ?? []) as $job)
                <div class="px-6 py-4 hover:bg-gray-50 transition-colors duration-150">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <h4 class="text-sm font-semibold text-gray-900">{{ $job->job_title ?? 'N/A' }}</h4>
                            <p class="text-sm text-gray-500 mt-1">{{ $job->company_name ?? 'N/A' }} • {{ $job->location ?? 'N/A' }}</p>
                            <div class="flex items-center mt-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ $job->employment_type ?? 'N/A' }}
                                </span>
                                <span class="ml-2 text-xs text-gray-500">
                                    {{ $job->applications_count ?? 0 }} applicants
                                </span>
                            </div>
                        </div>
                        <div class="ml-4 flex-shrink-0">
                            <a href="{{ route('jobs.show', $job) }}"
                               class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                Apply
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-6 py-8 text-center">
                    <i class="fa-solid fa-briefcase text-gray-300 text-4xl mb-3"></i>
                    <p class="text-gray-500">No featured jobs available</p>
                </div>
            @endforelse
        </div>
        <div class="bg-gray-50 px-6 py-3 border-t border-gray-200">
            <a href="{{ route('jobs.browse') }}" class="text-sm font-medium text-blue-600 hover:text-blue-900">
                Browse all jobs
            </a>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="mt-8">
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('jobs.browse') }}"
                   class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-colors duration-200">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                            <i class="fa-solid fa-search text-white"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-sm font-semibold text-gray-900">Browse Jobs</h4>
                        <p class="text-sm text-gray-500 mt-1">Find new opportunities</p>
                    </div>
                </a>

                <a href="{{ route('applications.myApplications') }}"
                   class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-green-500 hover:bg-green-50 transition-colors duration-200">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center">
                            <i class="fa-solid fa-list text-white"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-sm font-semibold text-gray-900">My Applications</h4>
                        <p class="text-sm text-gray-500 mt-1">Track your applications</p>
                    </div>
                </a>

                <a href="{{ route('profile.edit') }}"
                   class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-purple-500 hover:bg-purple-50 transition-colors duration-200">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-purple-500 rounded-full flex items-center justify-center">
                            <i class="fa-solid fa-user text-white"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-sm font-semibold text-gray-900">Update Profile</h4>
                        <p class="text-sm text-gray-500 mt-1">Edit your resume & details</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
