<!-- Admin Stats Grid -->
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
                <a href="{{ route('admin.applications.index') }}" class="font-medium text-blue-600 hover:text-blue-900">
                    Manage all applications
                </a>
            </div>
        </div>
    </div>

    <!-- Total Jobs Card -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                        <i class="fa-solid fa-briefcase text-white text-sm"></i>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Jobs</dt>
                        <dd class="text-lg font-semibold text-gray-900">
                            {{ $totalJobs ?? 0 }}
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-3">
            <div class="text-sm">
                <a href="{{ route('admin.jobs.index') }}" class="font-medium text-green-600 hover:text-green-900">
                    Manage jobs
                </a>
            </div>
        </div>
    </div>

    <!-- Total Users Card -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center">
                        <i class="fa-solid fa-users text-white text-sm"></i>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Users</dt>
                        <dd class="text-lg font-semibold text-gray-900">
                            {{ $totalUsers ?? 0 }}
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-3">
            <div class="text-sm">
                <a href="{{ route('admin.users.index') }}" class="font-medium text-purple-600 hover:text-purple-900">
                    Manage users
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
                        <dt class="text-sm font-medium text-gray-500 truncate">Pending Review</dt>
                        <dd class="text-lg font-semibold text-gray-900">
                            {{ $pendingApplications ?? 0 }}
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-3">
            <div class="text-sm">
                <a href="{{ route('admin.applications.index', ['status' => 'pending']) }}" class="font-medium text-yellow-600 hover:text-yellow-900">
                    Review pending
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Admin Dashboard Grid -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Recent Applications -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">Recent Applications</h3>
                <a href="{{ route('admin.applications.index') }}" class="text-sm text-blue-600 hover:text-blue-900 font-medium">
                    View all
                </a>
            </div>
        </div>
        <div class="divide-y divide-gray-200">
            @forelse(($recentApplications ?? []) as $application)
                <div class="px-6 py-4 hover:bg-gray-50 transition-colors duration-150">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="flex items-start justify-between">
                                <h4 class="text-sm font-semibold text-gray-900">{{ $application->job->job_title ?? 'N/A' }}</h4>
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
                            </div>
                            <p class="text-sm text-gray-500 mt-1">{{ $application->user->name ?? 'N/A' }} • {{ $application->job->company_name ?? 'N/A' }}</p>
                            <div class="flex items-center mt-2">
                                <span class="text-xs text-gray-500">
                                    Applied {{ $application->created_at->diffForHumans() ?? 'N/A' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-6 py-8 text-center">
                    <i class="fa-solid fa-file-circle-question text-gray-300 text-4xl mb-3"></i>
                    <p class="text-gray-500">No applications yet</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Recent Jobs -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">Recent Jobs</h3>
                <a href="{{ route('admin.jobs.index') }}" class="text-sm text-blue-600 hover:text-blue-900 font-medium">
                    View all
                </a>
            </div>
        </div>
        <div class="divide-y divide-gray-200">
            @forelse(($recentJobs ?? []) as $job)
                <div class="px-6 py-4 hover:bg-gray-50 transition-colors duration-150">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="flex items-start justify-between">
                                <h4 class="text-sm font-semibold text-gray-900">{{ $job->job_title ?? 'N/A' }}</h4>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $job->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $job->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-500 mt-1">{{ $job->company_name ?? 'N/A' }} • {{ $job->location ?? 'N/A' }}</p>
                            <div class="flex items-center mt-2 space-x-4">
                                <span class="text-xs text-gray-500">
                                    {{ $job->applications_count ?? 0 }} applications
                                </span>
                                <span class="text-xs text-gray-500">
                                    Created {{ $job->created_at->diffForHumans() ?? 'N/A' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-6 py-8 text-center">
                    <i class="fa-solid fa-briefcase text-gray-300 text-4xl mb-3"></i>
                    <p class="text-gray-500">No jobs posted yet</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- System Overview -->
<div class="mt-8">
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">System Overview</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Employers Stats -->
                <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                                <i class="fa-solid fa-building text-white"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-sm font-semibold text-gray-900">Employers</h4>
                            <p class="text-2xl font-bold text-blue-600">{{ $totalEmployers ?? 0 }}</p>
                            <p class="text-xs text-gray-500 mt-1">Registered companies</p>
                        </div>
                    </div>
                </div>

                <!-- Job Seekers Stats -->
                <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center">
                                <i class="fa-solid fa-user-graduate text-white"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-sm font-semibold text-gray-900">Job Seekers</h4>
                            <p class="text-2xl font-bold text-green-600">{{ $totalJobSeekers ?? 0 }}</p>
                            <p class="text-xs text-gray-500 mt-1">Active candidates</p>
                        </div>
                    </div>
                </div>

                <!-- Active Jobs Stats -->
                <div class="bg-purple-50 p-4 rounded-lg border border-purple-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-purple-500 rounded-full flex items-center justify-center">
                                <i class="fa-solid fa-bullhorn text-white"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-sm font-semibold text-gray-900">Active Jobs</h4>
                            <p class="text-2xl font-bold text-purple-600">{{ $activeJobs ?? 0 }}</p>
                            <p class="text-xs text-gray-500 mt-1">Currently listed</p>
                        </div>
                    </div>
                </div>

                <!-- Today's Applications -->
                <div class="bg-orange-50 p-4 rounded-lg border border-orange-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-orange-500 rounded-full flex items-center justify-center">
                                <i class="fa-solid fa-chart-line text-white"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-sm font-semibold text-gray-900">Today's Applications</h4>
                            <p class="text-2xl font-bold text-orange-600">{{ $todaysApplications ?? 0 }}</p>
                            <p class="text-xs text-gray-500 mt-1">New applications</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Admin Quick Actions -->
<div class="mt-8">
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('admin.jobs.create') }}"
                   class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-colors duration-200">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                            <i class="fa-solid fa-plus text-white"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-sm font-semibold text-gray-900">Create Job</h4>
                        <p class="text-sm text-gray-500 mt-1">Post a new job listing</p>
                    </div>
                </a>

                <a href="{{ route('admin.applications.index') }}"
                   class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-green-500 hover:bg-green-50 transition-colors duration-200">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center">
                            <i class="fa-solid fa-tasks text-white"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-sm font-semibold text-gray-900">Manage Applications</h4>
                        <p class="text-sm text-gray-500 mt-1">Review all applications</p>
                    </div>
                </a>

                <a href="{{ route('admin.users.index') }}"
                   class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-purple-500 hover:bg-purple-50 transition-colors duration-200">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-purple-500 rounded-full flex items-center justify-center">
                            <i class="fa-solid fa-users-cog text-white"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-sm font-semibold text-gray-900">User Management</h4>
                        <p class="text-sm text-gray-500 mt-1">Manage all users</p>
                    </div>
                </a>

                <a href="{{ route('admin.settings') }}"
                   class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-orange-500 hover:bg-orange-50 transition-colors duration-200">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-orange-500 rounded-full flex items-center justify-center">
                            <i class="fa-solid fa-cog text-white"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-sm font-semibold text-gray-900">System Settings</h4>
                        <p class="text-sm text-gray-500 mt-1">Configure system</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

