<x-adminDashboard-layout>

</x-adminDashboard-layout>
<!-- Admin Dashboard -->
<x-dashboard.role-section role="admin" title="Admin">
    <x-slot name="actions">
        <a href="{{ route('admin.settings') }}" class="btn btn-secondary">System Settings</a>
    </x-slot>

    <x-slot name="stats">
        <x-dashboard.stats-card
            title="Total Applications"
            :value="$totalApplications"
            icon="fa-paper-plane"
            color="blue"
            :link="route('admin.applications.index')"
            linkText="Manage all applications"
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
            :link="route('admin.applications.index', ['status' => 'pending'])"
            linkText="Review pending"
        />
    </x-slot>

    <x-slot name="content">
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
                    <!-- Application item content remains the same -->
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
                    <!-- Job item content remains the same -->
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
        <a href="{{ route('auth.jobs.create') }}" class="btn btn-primary">Post New Job</a>
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
            :link="route('employer.applications.index')"
            linkText="Manage applications"
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
            :link="route('employer.applications.index', ['status' => 'pending'])"
            linkText="Review applications"
        />
    </x-slot>

    <x-slot name="content">
        <!-- Employer-specific content -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Recent Job Applications</h3>
            </div>
            <!-- Employer application list -->
        </div>

        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">My Job Posts</h3>
            </div>
            <!-- Employer job list -->
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
        <!-- Job Seeker-specific content -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">My Applications</h3>
            </div>
            <!-- Seeker application list -->
        </div>

        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Recommended Jobs</h3>
            </div>
            <!-- Recommended jobs list -->
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
                        :link="route('admin.applications.index')"
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
                        :link="route('employer.applications.index')"
                        icon="fa-tasks"
                        color="green"
                    />

                    <x-dashboard.quick-action
                        title="My Company"
                        description="Update company profile"
                        :link="route('employer.company.edit')"
                        icon="fa-building"
                        color="purple"
                    />
                @elseif(auth()->user()->isJobSeeker())
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
