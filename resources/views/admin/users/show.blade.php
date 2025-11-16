<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            User Details
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header with Back Button -->
            <div class="mb-6">
                <a href="{{ route('admin.users.index') }}"
                    class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-900 transition duration-150">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Users List
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- User Information Card -->
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    User Information
                                </h3>
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.users.edit', $user) }}"
                                        class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150">
                                        <i class="fas fa-edit mr-1"></i>
                                        Edit
                                    </a>
                                    @if ($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150">
                                                <i class="fas fa-trash mr-1"></i>
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <div class="flex items-start space-x-6">
                                <!-- User Avatar -->
                                <div class="flex-shrink-0">
                                    @if ($user->profile_photo_path)
                                        <img class="h-24 w-24 rounded-full object-cover border-2 border-gray-200"
                                            src="{{ Storage::url($user->profile_photo_path) }}"
                                            alt="{{ $user->name }}">
                                    @else
                                        <div
                                            class="h-24 w-24 bg-gray-300 rounded-full flex items-center justify-center border-2 border-gray-200">
                                            <span class="text-gray-600 font-bold text-2xl">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <!-- User Details -->
                                <div class="flex-1">
                                    <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Full Name</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $user->name }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $user->email }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Roles</dt>
                                            <dd class="mt-1">
                                                <div class="flex flex-wrap gap-1">
                                                    @foreach ($user->roles as $role)
                                                        @php
                                                            $roleColors = [
                                                                'admin' => 'bg-purple-100 text-purple-800',
                                                                'employer' => 'bg-green-100 text-green-800',
                                                                'job-seeker' => 'bg-blue-100 text-blue-800',
                                                                'candidate' => 'bg-blue-100 text-blue-800',
                                                                'user' => 'bg-gray-100 text-gray-800',
                                                            ];
                                                            $colorClass = $roleColors[$role->name] ?? 'bg-gray-100 text-gray-800';
                                                        @endphp
                                                        <span
                                                            class="px-2 py-1 text-xs font-medium rounded-full {{ $colorClass }} capitalize">
                                                            {{ str_replace('_', ' ', $role->name) }}
                                                        </span>
                                                    @endforeach
                                                    @if($user->roles->isEmpty())
                                                        <span class="text-sm text-gray-500">No roles assigned</span>
                                                    @endif
                                                </div>
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                                            <dd class="mt-1">
                                                @if ($user->is_active)
                                                    <span
                                                        class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                                        Active
                                                    </span>
                                                @else
                                                    <span
                                                        class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">
                                                        Inactive
                                                    </span>
                                                @endif
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Email Verified</dt>
                                            <dd class="mt-1">
                                                @if ($user->email_verified_at)
                                                    <span
                                                        class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                                        Verified {{ $user->email_verified_at->format('M j, Y') }}
                                                    </span>
                                                @else
                                                    <span
                                                        class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">
                                                        Not Verified
                                                    </span>
                                                @endif
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Last Login</dt>
                                            <dd class="mt-1 text-sm text-gray-900">
                                                {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}
                                            </dd>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <dt class="text-sm font-medium text-gray-500">Registered</dt>
                                            <dd class="mt-1 text-sm text-gray-900">
                                                {{ $user->created_at->format('F j, Y \a\t g:i A') }}
                                                <span
                                                    class="text-gray-500">({{ $user->created_at->diffForHumans() }})</span>
                                            </dd>
                                        </div>
                                        @if ($user->phone)
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Phone</dt>
                                                <dd class="mt-1 text-sm text-gray-900">{{ $user->phone }}</dd>
                                            </div>
                                        @endif
                                        @if ($user->address)
                                            <div class="sm:col-span-2">
                                                <dt class="text-sm font-medium text-gray-500">Address</dt>
                                                <dd class="mt-1 text-sm text-gray-900">{{ $user->address }}</dd>
                                            </div>
                                        @endif
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Role-Specific Content -->
                    @if ($user->hasRole('employer'))
                        <!-- Employer's Jobs -->
                        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    Posted Jobs ({{ $user->jobs_count }})
                                </h3>
                            </div>
                            <div class="px-4 py-5 sm:p-6">
                                @if ($user->jobs_count > 0)
                                    <div class="space-y-4">
                                        @foreach ($user->jobs as $job)
                                            <div
                                                class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition duration-150">
                                                <div class="flex justify-between items-start">
                                                    <div class="flex-1">
                                                        <h4 class="text-lg font-medium text-gray-900">
                                                            <a href="{{ route('jobs.show', $job) }}"
                                                               class="hover:text-blue-600 transition duration-150">
                                                                {{ $job->job_title }}
                                                            </a>
                                                        </h4>
                                                        <p class="text-sm text-gray-600 mt-1">
                                                            {{ $job->company->name ?? $job->company_name }} • {{ $job->location }}
                                                        </p>
                                                        <div
                                                            class="mt-2 flex items-center space-x-4 text-sm text-gray-500">
                                                            <span class="flex items-center">
                                                                <i class="fas fa-briefcase mr-1"></i>
                                                                {{ $job->employment_type }}
                                                            </span>
                                                            <span class="flex items-center">
                                                                <i class="fas fa-users mr-1"></i>
                                                                {{ $job->applications_count ?? 0 }} applications
                                                            </span>
                                                            <span class="flex items-center">
                                                                <i class="fas fa-clock mr-1"></i>
                                                                {{ $job->created_at->diffForHumans() }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="ml-4">
                                                        @if ($job->is_active)
                                                            <span
                                                                class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                                                Active
                                                            </span>
                                                        @else
                                                            <span
                                                                class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">
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
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    @if ($user->hasRole('job-seeker') || $user->hasRole('candidate'))
                        <!-- Job Seeker's Applications -->
                        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    Job Applications ({{ $user->applications_count }})
                                </h3>
                            </div>
                            <div class="px-4 py-5 sm:p-6">
                                @if ($user->applications_count > 0)
                                    <div class="space-y-4">
                                        @foreach ($user->applications as $application)
                                            <div
                                                class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition duration-150">
                                                <div class="flex justify-between items-start">
                                                    <div class="flex-1">
                                                        <h4 class="text-lg font-medium text-gray-900">
                                                            <a href="{{ route('jobs.show', $application->job) }}"
                                                               class="hover:text-blue-600 transition duration-150">
                                                                {{ $application->job->job_title }}
                                                            </a>
                                                        </h4>
                                                        <p class="text-sm text-gray-600 mt-1">
                                                            {{ $application->job->company->name ?? $application->job->company_name }} •
                                                            {{ $application->job->location }}
                                                        </p>
                                                        <div
                                                            class="mt-2 flex items-center space-x-4 text-sm text-gray-500">
                                                            <span class="flex items-center">
                                                                <i class="fas fa-calendar mr-1"></i>
                                                                Applied
                                                                {{ $application->created_at->format('M j, Y') }}
                                                            </span>
                                                            <span class="flex items-center">
                                                                <i class="fas fa-clock mr-1"></i>
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
                                                        <span
                                                            class="px-2 py-1 text-xs font-medium rounded-full {{ $statusClass }} capitalize">
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
                                        <p class="text-gray-500">No job applications yet.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Quick Stats -->
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                User Statistics
                            </h3>
                        </div>
                        <div class="px-4 py-5 sm:p-6 space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-500">Total Jobs</span>
                                <span class="text-lg font-semibold text-gray-900">{{ $user->jobs_count ?? 0 }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-500">Total Applications</span>
                                <span
                                    class="text-lg font-semibold text-gray-900">{{ $user->applications_count ?? 0 }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-500">Member Since</span>
                                <span class="text-sm text-gray-900">{{ $user->created_at->format('M Y') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-500">Account Age</span>
                                <span class="text-sm text-gray-900">{{ $user->created_at->diffInDays() }} days</span>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Recent Activity
                            </h3>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <div class="space-y-3">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 bg-blue-100 rounded-full p-2">
                                        <i class="fas fa-user-plus text-blue-600 text-sm"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Account Created</p>
                                        <p class="text-sm text-gray-500">{{ $user->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>

                                @if ($user->email_verified_at)
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 bg-green-100 rounded-full p-2">
                                            <i class="fas fa-check-circle text-green-600 text-sm"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">Email Verified</p>
                                            <p class="text-sm text-gray-500">
                                                {{ $user->email_verified_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                @endif

                                @if ($user->last_login_at)
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 bg-purple-100 rounded-full p-2">
                                            <i class="fas fa-sign-in-alt text-purple-600 text-sm"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">Last Login</p>
                                            <p class="text-sm text-gray-500">
                                                {{ $user->last_login_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                @endif

                                @if($user->jobs_count > 0)
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 bg-orange-100 rounded-full p-2">
                                            <i class="fas fa-briefcase text-orange-600 text-sm"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">Jobs Posted</p>
                                            <p class="text-sm text-gray-500">{{ $user->jobs_count }} jobs</p>
                                        </div>
                                    </div>
                                @endif

                                @if($user->applications_count > 0)
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 bg-indigo-100 rounded-full p-2">
                                            <i class="fas fa-file-alt text-indigo-600 text-sm"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">Applications Submitted</p>
                                            <p class="text-sm text-gray-500">{{ $user->applications_count }} applications</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Danger Zone -->
                    @if ($user->id !== auth()->id())
                        <div class="bg-white shadow overflow-hidden sm:rounded-lg border border-red-200">
                            <div class="px-4 py-5 sm:px-6 border-b border-red-200 bg-red-50">
                                <h3 class="text-lg leading-6 font-medium text-red-900">
                                    Danger Zone
                                </h3>
                            </div>
                            <div class="px-4 py-5 sm:p-6">
                                <p class="text-sm text-red-600 mb-4">
                                    Once you delete a user, there is no going back. Please be certain.
                                </p>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                    onsubmit="return confirm('Are you absolutely sure you want to delete this user? This action cannot be undone and will permanently delete all associated data.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150">
                                        <i class="fas fa-trash mr-2"></i>
                                        Delete User Account
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-yellow-800">
                                        Current User
                                    </h3>
                                    <div class="mt-2 text-sm text-yellow-700">
                                        <p>This is your own account. You cannot delete it from here.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
