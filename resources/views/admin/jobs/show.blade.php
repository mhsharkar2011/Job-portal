<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="md:flex md:items-center md:justify-between mb-8">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                        {{ $job->title }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">
                        Job Details & Applications
                    </p>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4 space-x-3">
                    <a href="{{ route('admin.jobs.edit', $job) }}"
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fa-solid fa-pencil mr-2"></i>
                        Edit Job
                    </a>
                    <a href="{{ route('admin.jobs.index') }}"
                       class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fa-solid fa-arrow-left mr-2"></i>
                        Back to Jobs
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Job Details -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Basic Information -->
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Job Information
                            </h3>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Company</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $job->company->name ?? 'No Company' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Category</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $job->category->name ?? 'No Category' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Location</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $job->location }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Employment Type</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ ucfirst(str_replace('-', ' ', $job->employment_type)) }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Salary Range</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $job->salary_currency }} {{ number_format($job->salary_min) }} - {{ number_format($job->salary_max) }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Positions Available</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $job->positions_available }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Experience Required</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $job->experience_min }} - {{ $job->experience_max }} {{ $job->experience_unit }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Application Deadline</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $job->apply_by_date ? $job->apply_by_date->format('M d, Y') : 'No deadline' }}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Job Description -->
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Job Description
                            </h3>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <div class="prose max-w-none">
                                <p class="text-sm text-gray-900 whitespace-pre-line">{{ $job->description }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Requirements -->
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Requirements & Qualifications
                            </h3>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <div class="prose max-w-none">
                                <p class="text-sm text-gray-900 whitespace-pre-line">{{ $job->requirements }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Status & Actions -->
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Status & Actions
                            </h3>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <div class="mb-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                    @if($job->status === 'active') bg-green-100 text-green-800
                                    @elseif($job->status === 'draft') bg-gray-100 text-gray-800
                                    @elseif($job->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($job->status === 'expired') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($job->status) }}
                                </span>
                            </div>

                            <div class="space-y-3">
                                <form action="{{ route('admin.jobs.update', $job) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="active">
                                    <button type="submit"
                                            class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        <i class="fa-solid fa-check mr-2"></i>
                                        Activate Job
                                    </button>
                                </form>

                                <form action="{{ route('admin.jobs.update', $job) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="inactive">
                                    <button type="submit"
                                            class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        <i class="fa-solid fa-pause mr-2"></i>
                                        Deactivate Job
                                    </button>
                                </form>

                                <form action="{{ route('admin.jobs.destroy', $job) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this job?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        <i class="fa-solid fa-trash mr-2"></i>
                                        Delete Job
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Application Statistics -->
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Applications
                            </h3>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <dl class="grid grid-cols-2 gap-4">
                                <div class="text-center">
                                    <dt class="text-sm font-medium text-gray-500">Total</dt>
                                    <dd class="text-lg font-semibold text-gray-900">{{ $applicationStats['total'] ?? 0 }}</dd>
                                </div>
                                <div class="text-center">
                                    <dt class="text-sm font-medium text-gray-500">Pending</dt>
                                    <dd class="text-lg font-semibold text-gray-900">{{ $applicationStats['pending'] ?? 0 }}</dd>
                                </div>
                                <div class="text-center">
                                    <dt class="text-sm font-medium text-gray-500">Accepted</dt>
                                    <dd class="text-lg font-semibold text-gray-900">{{ $applicationStats['accepted'] ?? 0 }}</dd>
                                </div>
                                <div class="text-center">
                                    <dt class="text-sm font-medium text-gray-500">Rejected</dt>
                                    <dd class="text-lg font-semibold text-gray-900">{{ $applicationStats['rejected'] ?? 0 }}</dd>
                                </div>
                            </dl>
                            <div class="mt-4 text-center">
                                <a href="{{ route('admin.applications.index', $job) }}"
                                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <i class="fa-solid fa-list mr-2"></i>
                                    View All Applications
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Job Meta Information -->
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Meta Information
                            </h3>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Posted By</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $job->user->name ?? 'Unknown User' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Posted On</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $job->created_at->format('M d, Y') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $job->updated_at->format('M d, Y') }}</dd>
                                </div>
                                @if($job->published_at)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Published On</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $job->published_at->format('M d, Y') }}</dd>
                                </div>
                                @endif
                                @if($job->expires_at)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Expires On</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $job->expires_at->format('M d, Y') }}</dd>
                                </div>
                                @endif
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
