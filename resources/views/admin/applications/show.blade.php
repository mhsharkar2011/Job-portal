<x-app-layout>
    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="md:flex md:items-center md:justify-between mb-6">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                        Application Details
                    </h2>
                    <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
                        <div class="mt-2 flex items-center text-sm text-gray-500">
                            <i class="fa-solid fa-calendar mr-1"></i>
                            Applied {{ $application->created_at->format('M j, Y') }}
                        </div>
                        <div class="mt-2 flex items-center text-sm text-gray-500">
                            <i class="fa-solid fa-clock mr-1"></i>
                            {{ $application->created_at->diffForHumans() }}
                        </div>
                        <div class="mt-2 flex items-center text-sm">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'reviewed' => 'bg-blue-100 text-blue-800',
                                    'accepted' => 'bg-green-100 text-green-800',
                                    'rejected' => 'bg-red-100 text-red-800',
                                ];
                                $colorClass = $statusColors[$application->status] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="px-2 py-1 rounded-full text-xs font-medium {{ $colorClass }} capitalize">
                                {{ $application->status }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="mt-4 flex space-x-3 md:mt-0 md:ml-4">
                    <a href="{{ route('admin.applications.index') }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fa-solid fa-arrow-left mr-2"></i>
                        Back to List
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Applicant Information -->
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Applicant Information
                            </h3>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Full Name</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $application->full_name ?? 'Not provided' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $application->email ?? 'Not provided' }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Phone</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $application->phone ?? 'Not provided' }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Experience</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $application->experience_years ?? 0 }}
                                        years</dd>
                                </div>
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">Address</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $application->address ?? 'Not provided' }}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Professional Information -->
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Professional Information
                            </h3>
                        </div>
                        <div class="px-4 py-5 sm:p-6 space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Skills</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $application->skills ?? 'Not provided' }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Education</dt>
                                <dd class="mt-1 text-sm text-gray-900 whitespace-pre-line">
                                    {{ $application->education ?? 'Not provided' }}</dd>
                            </div>
                            @if ($application->cover_letter)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Cover Letter</dt>
                                    <dd class="mt-1 text-sm text-gray-900 whitespace-pre-line">
                                        {{ $application->cover_letter }}</dd>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Job Information -->
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Job Information
                            </h3>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Job Title</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        @if ($application->job)
                                            <a href="{{ route('admin.jobs.show', $application->job->id) }}"
                                                class="text-blue-600 hover:text-blue-900">
                                                {{ $application->job->title ?? $application->job->job_title }}
                                            </a>
                                        @else
                                            <span class="text-red-500">Job not found</span>
                                        @endif
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Company</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        @if ($application->job && $application->job->company)
                                            {{ $application->job->company->name }}
                                        @else
                                            <span class="text-red-500">Company not found</span>
                                        @endif
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Location</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $application->job->location ?? 'Not specified' }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Employment Type</dt>
                                    <dd class="mt-1 text-sm text-gray-900 capitalize">
                                        {{ $application->job ? str_replace('_', ' ', $application->job->employment_type) : 'Not specified' }}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Status Update -->
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Application Status
                            </h3>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <form action="{{ route('admin.applications.update-status', $application) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="space-y-4">
                                    <div>
                                        <label for="status"
                                            class="block text-sm font-medium text-gray-700">Status</label>
                                        <select name="status" id="status"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                            <option value="pending"
                                                {{ $application->status == 'pending' ? 'selected' : '' }}>Pending
                                            </option>
                                            <option value="reviewed"
                                                {{ $application->status == 'reviewed' ? 'selected' : '' }}>Reviewed
                                            </option>
                                            <option value="accepted"
                                                {{ $application->status == 'accepted' ? 'selected' : '' }}>Accepted
                                            </option>
                                            <option value="rejected"
                                                {{ $application->status == 'rejected' ? 'selected' : '' }}>Rejected
                                            </option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="admin_notes" class="block text-sm font-medium text-gray-700">Admin
                                            Notes</label>
                                        <textarea name="admin_notes" id="admin_notes" rows="4"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                            placeholder="Add any notes about this application...">{{ old('admin_notes', $application->admin_notes ?? $application->notes) }}</textarea>
                                    </div>
                                    <button type="submit"
                                        class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                                        <i class="fa-solid fa-save mr-2"></i>
                                        Update Status
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Documents -->
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Documents
                            </h3>
                        </div>
                        <div class="px-4 py-5 sm:p-6 space-y-3">
                            @if ($application->resume_path || $application->resume)
                                <a href="{{ $application->resume_path ? Storage::url($application->resume_path) : '#' }}"
                                    target="_blank"
                                    class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                                    <i class="fa-solid fa-download mr-2"></i>
                                    Download Resume
                                </a>
                            @else
                                <button disabled
                                    class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-400 bg-gray-100 cursor-not-allowed">
                                    <i class="fa-solid fa-download mr-2"></i>
                                    No Resume Available
                                </button>
                            @endif

                            @if ($application->cover_letter_path)
                                <a href="{{ Storage::url($application->cover_letter_path) }}" target="_blank"
                                    class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                                    <i class="fa-solid fa-download mr-2"></i>
                                    Download Cover Letter
                                </a>
                            @endif
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
                            <form action="{{ route('admin.applications.destroy', $application) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this application? This action cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150 ease-in-out">
                                    <i class="fa-solid fa-trash mr-2"></i>
                                    Delete Application
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Add some interactivity
            document.addEventListener('DOMContentLoaded', function() {
                const statusSelect = document.getElementById('status');
                const statusIndicator = document.querySelector('.mt-2 .px-2');

                if (statusSelect && statusIndicator) {
                    statusSelect.addEventListener('change', function() {
                        // Update the status indicator color based on selection
                        const statusColors = {
                            'pending': 'bg-yellow-100 text-yellow-800',
                            'reviewed': 'bg-blue-100 text-blue-800',
                            'accepted': 'bg-green-100 text-green-800',
                            'rejected': 'bg-red-100 text-red-800'
                        };

                        // Remove all color classes
                        statusIndicator.className = statusIndicator.className.replace(/bg-\w+-\d+ text-\w+-\d+/,
                            '');
                        // Add new color class
                        statusIndicator.classList.add(...statusColors[this.value].split(' '));
                        // Update text
                        statusIndicator.textContent = this.value;
                    });
                }
            });
        </script>
    @endpush
</x-app-layout>
