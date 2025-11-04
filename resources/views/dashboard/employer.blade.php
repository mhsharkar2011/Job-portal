<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Total Jobs Card -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                        <i class="fa-solid fa-briefcase text-white text-sm"></i>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Jobs Posted</dt>
                        <dd class="text-lg font-semibold text-gray-900">{{ $totalJobs }}</dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-3">
            <div class="text-sm">
                <a href="{{ route('jobs.index') }}" class="font-medium text-blue-600 hover:text-blue-900">
                    View all jobs
                </a>
            </div>
        </div>
    </div>

    <!-- Total Applications Card -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                        <i class="fa-solid fa-users text-white text-sm"></i>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Applications</dt>
                        <dd class="text-lg font-semibold text-gray-900">{{ $totalApplications }}</dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-3">
            <div class="text-sm">
                <span class="text-gray-600">Across all job postings</span>
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
                        <dt class="text-sm font-medium text-gray-500 truncate">Pending Review</dt>
                        <dd class="text-lg font-semibold text-gray-900">{{ $pendingApplications }}</dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-3">
            <div class="text-sm">
                <a href="{{ route('jobs.applicants', 'all') }}" class="font-medium text-blue-600 hover:text-blue-900">
                    Review applications
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity Grid -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Recent Jobs -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Recent Job Postings</h3>
        </div>
        <div class="divide-y divide-gray-200">
            @forelse($recentJobs as $job)
                <div class="px-6 py-4 hover:bg-gray-50 transition-colors duration-150">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <h4 class="text-sm font-semibold text-gray-900">{{ $job->job_title }}</h4>
                            <p class="text-sm text-gray-500 mt-1">{{ $job->company_name }}</p>
                            <div class="flex items-center mt-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $job->applications_count }} applications
                                </span>
                                <span class="ml-2 text-xs text-gray-500">
                                    {{ $job->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                        <div class="ml-4 flex-shrink-0">
                            <a href="{{ route('jobs.applicants', $job) }}"
                               class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                View
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-6 py-8 text-center">
                    <i class="fa-solid fa-briefcase text-gray-300 text-4xl mb-3"></i>
                    <p class="text-gray-500">No jobs posted yet</p>
                    <a href="{{ route('jobs.create') }}" class="inline-block mt-2 text-blue-600 hover:text-blue-900 font-medium">
                        Post your first job
                    </a>
                </div>
            @endforelse
        </div>
        @if($recentJobs->count() > 0)
            <div class="bg-gray-50 px-6 py-3 border-t border-gray-200">
                <a href="{{ route('jobs.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-900">
                    View all jobs
                </a>
            </div>
        @endif
    </div>

    <!-- Recent Applications -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Recent Applications</h3>
        </div>
        <div class="divide-y divide-gray-200">
            @forelse($recentApplications as $application)
                <div class="px-6 py-4 hover:bg-gray-50 transition-colors duration-150">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <h4 class="text-sm font-semibold text-gray-900">{{ $application->full_name }}</h4>
                            <p class="text-sm text-gray-500 mt-1">Applied for {{ $application->job->job_title }}</p>
                            <div class="flex items-center mt-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($application->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($application->status === 'accepted') bg-green-100 text-green-800
                                    @elseif($application->status === 'rejected') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($application->status) }}
                                </span>
                                <span class="ml-2 text-xs text-gray-500">
                                    {{ $application->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                        <div class="ml-4 flex-shrink-0">
                            <a href="{{ route('jobs.applicants', $application->job) }}"
                               class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                Review
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-6 py-8 text-center">
                    <i class="fa-solid fa-users text-gray-300 text-4xl mb-3"></i>
                    <p class="text-gray-500">No applications yet</p>
                </div>
            @endforelse
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
                <a href="{{ route('jobs.create') }}"
                   class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-colors duration-200">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                            <i class="fa-solid fa-plus text-white"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-sm font-semibold text-gray-900">Post New Job</h4>
                        <p class="text-sm text-gray-500 mt-1">Create a new job listing</p>
                    </div>
                </a>

                <a href="{{ route('jobs.index') }}"
                   class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-green-500 hover:bg-green-50 transition-colors duration-200">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center">
                            <i class="fa-solid fa-list text-white"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-sm font-semibold text-gray-900">Manage Jobs</h4>
                        <p class="text-sm text-gray-500 mt-1">View all your job postings</p>
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
                        <p class="text-sm text-gray-500 mt-1">Edit company information</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
