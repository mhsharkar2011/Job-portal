@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
        <p class="text-gray-600 mt-2">Welcome back, {{ auth()->user()->name }}!</p>
    </div>

    <!-- Admin Dashboard -->
    <x-dashboard.role-section role="admin" title="Admin">
        <x-slot name="actions">
            <a href="{{ route('admin.roles.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 text-sm font-medium transition-colors duration-200">
                System Settings
            </a>
        </x-slot>

        <x-slot name="stats">
            <x-dashboard.stats-card
                title="Total Applicant"
                :value="$totalApplications"
                icon="fa-paper-plane"
                color="blue"
                :link="route('admin.applicants.index')"
                linkText="Manage all applicants"
            />

            <x-dashboard.stats-card
                title="Total Jobs"
                :value="$totalJobs ?? 0"
                icon="fa-briefcase"
                color="green"
                :link="route('jobs.index')"
                linkText="Manage jobs"
            />

            <x-dashboard.stats-card
                title="Total Users"
                :value="$totalUsers ?? 0"
                icon="fa-users"
                color="purple"
                :link="route('admin.users.index')"
                linkText="Manage users"
            />

            <x-dashboard.stats-card
                title="Pending Review"
                :value="$pendingApplications ?? 0"
                icon="fa-clock"
                color="yellow"
                :link="route('admin.applicants.index', ['status' => 'pending'])"
                linkText="Review pending"
            />
        </x-slot>

        <x-slot name="content">
            <!-- Recent Applications -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">Recent Applications</h3>
                        <a href="{{ route('admin.applicants.index') }}" class="text-sm text-blue-600 hover:text-blue-900 font-medium">
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
                                    <p class="text-sm text-gray-500 mt-1">{{ $application->user->name ?? 'N/A' }} • {{ $application->job->company->name ?? 'N/A' }}</p>
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
                        <a href="{{ route('jobs.index') }}" class="text-sm text-blue-600 hover:text-blue-900 font-medium">
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
                                    <p class="text-sm text-gray-500 mt-1">{{ $job->company->name ?? 'N/A' }} • {{ $job->location ?? 'N/A' }}</p>
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
                            <p class="text-gray-500">No jobs posted</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </x-slot>
    </x-dashboard.role-section>

    <!-- Employer Dashboard -->
    <x-dashboard.role-section role="employer" title="Employer">
        <x-slot name="actions">
            <a href="{{ route('auth.jobs.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm font-medium transition-colors duration-200">
                Post New Job
            </a>
        </x-slot>

        <x-slot name="stats">
            <x-dashboard.stats-card
                title="My Jobs"
                :value="$employerJobsCount ?? 0"
                icon="fa-briefcase"
                color="blue"
                :link="route('employer.jobs.index')"
                linkText="View all jobs"
            />

            <x-dashboard.stats-card
                title="Applications"
                :value="$employerApplicationsCount ?? 0"
                icon="fa-paper-plane"
                color="green"
                :link="route('employer.applicants.index')"
                linkText="Manage applicants"
            />

            <x-dashboard.stats-card
                title="Active Jobs"
                :value="$activeEmployerJobs ?? 0"
                icon="fa-bullhorn"
                color="purple"
                :link="route('employer.jobs.index', ['status' => 'active'])"
                linkText="View active"
            />

            <x-dashboard.stats-card
                title="Pending Review"
                :value="$pendingEmployerApplications ?? 0"
                icon="fa-clock"
                color="yellow"
                :link="route('employer.applicants.index', ['status' => 'pending'])"
                linkText="Review applicants"
            />
        </x-slot>

        <x-slot name="content">
            <!-- Employer-specific content would go here -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Recent Job Applications</h3>
                </div>
                <div class="p-6 text-center text-gray-500">
                    <i class="fa-solid fa-users text-gray-300 text-4xl mb-3"></i>
                    <p>Employer application list content</p>
                </div>
            </div>

            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">My Job Posts</h3>
                </div>
                <div class="p-6 text-center text-gray-500">
                    <i class="fa-solid fa-briefcase text-gray-300 text-4xl mb-3"></i>
                    <p>Employer job list content</p>
                </div>
            </div>
        </x-slot>
    </x-dashboard.role-section>

    <!-- Job Seeker Dashboard -->
    <x-dashboard.role-section role="job_seeker" title="Job Seeker">
        <x-slot name="stats">
            <x-dashboard.stats-card
                title="Applications Sent"
                :value="$seekerApplicationsCount ?? 0"
                icon="fa-paper-plane"
                color="blue"
                :link="route('seeker.applications.index')"
                linkText="View applications"
            />

            <x-dashboard.stats-card
                title="Pending"
                :value="$pendingSeekerApplications ?? 0"
                icon="fa-clock"
                color="yellow"
            />

            <x-dashboard.stats-card
                title="Accepted"
                :value="$acceptedSeekerApplications ?? 0"
                icon="fa-check"
                color="green"
            />

            <x-dashboard.stats-card
                title="Interviews"
                :value="$interviewSeekerApplications ?? 0"
                icon="fa-calendar"
                color="purple"
            />
        </x-slot>

        <x-slot name="content">
            <!-- Job Seeker-specific content would go here -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">My Applications</h3>
                </div>
                <div class="p-6 text-center text-gray-500">
                    <i class="fa-solid fa-file-lines text-gray-300 text-4xl mb-3"></i>
                    <p>Seeker application list content</p>
                </div>
            </div>

            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Recommended Jobs</h3>
                </div>
                <div class="p-6 text-center text-gray-500">
                    <i class="fa-solid fa-magnifying-glass text-gray-300 text-4xl mb-3"></i>
                    <p>Recommended jobs content</p>
                </div>
            </div>
        </x-slot>
    </x-dashboard.role-section>

    <!-- Quick Actions Section (Role-based) -->
    <div class="mt-8">
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    @if(auth()->user()->isAdmin())
                        <x-dashboard.quick-action
                            title="Create Job"
                            description="Post a new job listing"
                            :link="route('auth.jobs.create')"
                            icon="fa-plus"
                            color="blue"
                        />

                        <x-dashboard.quick-action
                            title="Manage Applications"
                            description="Review all applications"
                            :link="route('admin.applicants.index')"
                            icon="fa-tasks"
                            color="green"
                        />

                        <x-dashboard.quick-action
                            title="User Management"
                            description="Manage all users"
                            :link="route('admin.users.index')"
                            icon="fa-users-cog"
                            color="purple"
                        />

                        <x-dashboard.quick-action
                            title="System Settings"
                            description="Configure system"
                            :link="route('admin.roles.index')"
                            icon="fa-cog"
                            color="orange"
                        />
                    @elseif(auth()->user()->isEmployer())
                        <x-dashboard.quick-action
                            title="Post New Job"
                            description="Create a job listing"
                            :link="route('auth.jobs.create')"
                            icon="fa-plus"
                            color="blue"
                        />

                        <x-dashboard.quick-action
                            title="View Applications"
                            description="Manage job applications"
                            :link="route('employer.applicants.index')"
                            icon="fa-tasks"
                            color="green"
                        />

                        <x-dashboard.quick-action
                            title="My Company"
                            description="Update company profile"
                            :link="route('employer.company.edit', ['company' => auth()->user()->company->id ?? 1])"
                            icon="fa-building"
                            color="purple"
                        />
                    @elseif(auth()->user()->isSeeker())
                        <x-dashboard.quick-action
                            title="Browse Jobs"
                            description="Find new opportunities"
                            :link="route('jobs.index')"
                            icon="fa-search"
                            color="blue"
                        />

                        <x-dashboard.quick-action
                            title="My Profile"
                            description="Update resume and profile"
                            :link="route('seeker.profile.edit')"
                            icon="fa-user-edit"
                            color="green"
                        />

                        <x-dashboard.quick-action
                            title="Applications"
                            description="View my applications"
                            :link="route('seeker.applications.index')"
                            icon="fa-tasks"
                            color="purple"
                        />
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
