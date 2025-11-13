
       <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <!-- Total Jobs -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                <i class="fas fa-briefcase text-white text-lg"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Total Jobs</p>
                                <p class="text-2xl font-semibold text-gray-900">
                                    {{ $totalJobs ?? 1 }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Applications -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <i class="fas fa-file-alt text-white text-lg"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Total Applications</p>
                                <p class="text-2xl font-semibold text-gray-900">
                                    {{ $totalApplications ?? 0 }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Applications -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                                <i class="fas fa-clock text-white text-lg"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Pending Applications</p>
                                <p class="text-2xl font-semibold text-gray-900">
                                    {{ $pendingApplications ?? 0 }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Accepted Applications -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                                <i class="fas fa-check-circle text-white text-lg"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Accepted Applications</p>
                                <p class="text-2xl font-semibold text-gray-900">
                                    {{ $acceptedApplications ?? 0 }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Jobs -->
                <div class="bg-white shadow-sm rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Recent Jobs</h3>
                    </div>
                    <div class="p-6">
                        @if(isset($recentJobs) && $recentJobs->count() > 0)
                            <div class="space-y-4">
                                @foreach($recentJobs as $job)
                                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition duration-150">
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1">
                                                <h4 class="text-lg font-medium text-gray-900">{{ $job->job_title }}</h4>
                                                <p class="text-sm text-gray-600 mt-1">{{ $job->company_name }} • {{ $job->location }}</p>
                                                <div class="mt-2 flex items-center space-x-4 text-sm text-gray-500">
                                                    <span class="flex items-center">
                                                        <i class="fas fa-users mr-1"></i>
                                                        {{ $job->applications_count }} applications
                                                    </span>
                                                    <span class="flex items-center">
                                                        <i class="fas fa-clock mr-1"></i>
                                                        {{ $job->created_at->diffForHumans() }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                @if($job->is_active)
                                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                                        Active
                                                    </span>
                                                @else
                                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">
                                                        Inactive
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <i class="fas fa-briefcase text-gray-300 text-4xl mb-4"></i>
                                <p class="text-gray-500">No jobs posted yet.</p>
                                <a href="{{ route('jobs.create') }}" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-150">
                                    Post Your First Job
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Recent Applications -->
                <div class="bg-white shadow-sm rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Recent Applications</h3>
                    </div>
                    <div class="p-6">
                        @if(isset($recentApplications) && $recentApplications->count() > 0)
                            <div class="space-y-4">
                                @foreach($recentApplications as $application)
                                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition duration-150">
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1">
                                                <h4 class="text-lg font-medium text-gray-900">{{ $application->user->name ?? 'Applicant' }}</h4>
                                                <p class="text-sm text-gray-600 mt-1">Applied for {{ $application->job->job_title ?? 'Job' }}</p>
                                                <div class="mt-2 flex items-center space-x-4 text-sm text-gray-500">
                                                    <span class="flex items-center">
                                                        <i class="fas fa-calendar mr-1"></i>
                                                        {{ $application->created_at->diffForHumans() }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                @php
                                                    $statusColors = [
                                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                                        'under_review' => 'bg-blue-100 text-blue-800',
                                                        'shortlisted' => 'bg-purple-100 text-purple-800',
                                                        'interview' => 'bg-indigo-100 text-indigo-800',
                                                        'accepted' => 'bg-green-100 text-green-800',
                                                        'rejected' => 'bg-red-100 text-red-800',
                                                    ];
                                                    $statusClass = $statusColors[$application->status] ?? 'bg-gray-100 text-gray-800';
                                                @endphp
                                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $statusClass }} capitalize">
                                                    {{ str_replace('_', ' ', $application->status) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <i class="fas fa-file-alt text-gray-300 text-4xl mb-4"></i>
                                <p class="text-gray-500">No applications yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mt-6 bg-white shadow-sm rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="{{ route('jobs.create') }}"
                           class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-200 transition duration-150">
                            <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                                <i class="fas fa-plus text-blue-600 text-lg"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-900">Post New Job</h4>
                                <p class="text-sm text-gray-500">Create a new job listing</p>
                            </div>
                        </a>

                        <a href="{{ route('jobs.index') }}"
                           class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-green-50 hover:border-green-200 transition duration-150">
                            <div class="flex-shrink-0 bg-green-100 rounded-lg p-3">
                                <i class="fas fa-briefcase text-green-600 text-lg"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-900">Manage Jobs</h4>
                                <p class="text-sm text-gray-500">View and edit your jobs</p>
                            </div>
                        </a>

                        <a href="{{ route('applications.myApplications') }}"
                           class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-purple-50 hover:border-purple-200 transition duration-150">
                            <div class="flex-shrink-0 bg-purple-100 rounded-lg p-3">
                                <i class="fas fa-users text-purple-600 text-lg"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-900">View Applications</h4>
                                <p class="text-sm text-gray-500">Manage job applications</p>

                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

