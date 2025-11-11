<x-app-layout>
    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="md:flex md:items-center md:justify-between mb-6">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                        {{ $job->job_title }}
                    </h2>
                    <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
                        <div class="mt-2 flex items-center text-sm text-gray-500">
                            <i class="fa-solid fa-building mr-1"></i>
                            {{ $job->company->name }}
                        </div>
                        <div class="mt-2 flex items-center text-sm text-gray-500">
                            <i class="fa-solid fa-location-dot mr-1"></i>
                            {{ $job->location }}
                        </div>
                        <div class="mt-2 flex items-center text-sm text-gray-500">
                            <i class="fa-solid fa-calendar mr-1"></i>
                            Posted {{ $job->created_at->format('M j, Y') }}
                        </div>
                    </div>
                </div>
                <div class="mt-4 flex space-x-3 md:mt-0 md:ml-4">
                    <a href="{{ route('admin.jobs.index') }}"
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fa-solid fa-arrow-left mr-2"></i>
                        Back to List
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Job Details -->
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Job Details
                            </h3>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Job Title</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $job->job_title }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Company</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $job->company->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Location</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $job->location }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Employment Type</dt>
                                    <dd class="mt-1 text-sm text-gray-900 capitalize">{{ str_replace('-', ' ', $job->employment_type) }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Category</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $job->category->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Experience</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $job->experience_minimum }} - {{ $job->experience_maximum }} {{ $job->experience_unit }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Salary Range</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $job->salary_currency }} {{ number_format($job->salary_minimum) }} - {{ number_format($job->salary_maximum) }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Positions Available</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $job->positions_available }}</dd>
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
                                <p class="text-sm text-gray-900 whitespace-pre-line">{{ $job->job_description }}</p>
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
                                <p class="text-sm text-gray-900 whitespace-pre-line">{{ $job->requirement }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Skills -->
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Key Skills
                            </h3>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <div class="flex flex-wrap gap-2">
                                @foreach(explode(',', $job->key_skills) as $skill)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ trim($skill) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Status Update -->
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Job Status
                            </h3>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <form action="{{ route('admin.jobs.update-status', $job) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="space-y-4">
                                    <div>
                                        <label for="is_active" class="block text-sm font-medium text-gray-700">Status</label>
                                        <select name="is_active" id="is_active"
                                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                            <option value="1" {{ $job->is_active ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ !$job->is_active ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="admin_notes" class="block text-sm font-medium text-gray-700">Admin Notes</label>
                                        <textarea name="admin_notes" id="admin_notes" rows="4"
                                                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                                  placeholder="Add any notes about this job...">{{ $job->admin_notes }}</textarea>
                                    </div>
                                    <button type="submit"
                                            class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <i class="fa-solid fa-save mr-2"></i>
                                        Update Status
                                    </button>
                                </div>
                            </form>
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
                                    <dd class="text-lg font-semibold text-gray-900">{{ $applicationStats['total'] }}</dd>
                                </div>
                                <div class="text-center">
                                    <dt class="text-sm font-medium text-gray-500">Pending</dt>
                                    <dd class="text-lg font-semibold text-yellow-600">{{ $applicationStats['pending'] }}</dd>
                                </div>
                                <div class="text-center">
                                    <dt class="text-sm font-medium text-gray-500">Reviewed</dt>
                                    <dd class="text-lg font-semibold text-blue-600">{{ $applicationStats['reviewed'] }}</dd>
                                </div>
                                <div class="text-center">
                                    <dt class="text-sm font-medium text-gray-500">Accepted</dt>
                                    <dd class="text-lg font-semibold text-green-600">{{ $applicationStats['accepted'] }}</dd>
                                </div>
                            </dl>
                            <a href="{{ route('admin.jobs.applications', $job) }}"
                               class="mt-4 w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <i class="fa-solid fa-file-lines mr-2"></i>
                                View All Applications
                            </a>
                        </div>
                    </div>

                    <!-- Job Poster -->
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Job Poster
                            </h3>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                        <span class="text-sm font-medium text-gray-700">
                                            {{ substr($job->user->name, 0, 1) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-sm font-semibold text-gray-900">{{ $job->user->name }}</h4>
                                    <p class="text-sm text-gray-500">{{ $job->user->email }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Danger Zone -->
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg border border-red-200">
                        <div class="px-4 py-5 sm:px-6 border-b border-red-200 bg-red-50">
                            <h3 class="text-lg leading-6 font-medium text-red-900">
                                Danger Zone
                            </h3>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <form action="{{ route('admin.jobs.destroy', $job) }}" method="POST"
                                  onsubmit="return confirm('Are you sure you want to delete this job? This will also delete all associated applications. This action cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    <i class="fa-solid fa-trash mr-2"></i>
                                    Delete Job
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
