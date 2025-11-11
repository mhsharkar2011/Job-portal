<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="md:flex md:items-center md:justify-between mb-6">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                        Applications for "{{ $job->job_title }}"
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">
                        {{ $job->company->name }} • {{ $job->location }}
                    </p>
                </div>
                <div class="mt-4 flex space-x-3 md:mt-0 md:ml-4">
                    <a href="{{ route('admin.jobs.show', $job) }}"
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fa-solid fa-arrow-left mr-2"></i>
                        Back to Job
                    </a>
                </div>
            </div>

            <!-- Applications List -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Applications ({{ $applications->total() }})
                    </h3>
                </div>

                @if($applications->count() > 0)
                    <ul class="divide-y divide-gray-200">
                        @foreach($applications as $application)
                            <li class="px-4 py-4 sm:px-6 hover:bg-gray-50">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h4 class="text-sm font-semibold text-gray-900">
                                                    {{ $application->full_name }}
                                                </h4>
                                                <p class="text-sm text-gray-500 mt-1">
                                                    {{ $application->email }} • {{ $application->phone }}
                                                </p>
                                                <div class="mt-2 flex items-center space-x-4">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                        @if($application->status === 'pending') bg-yellow-100 text-yellow-800
                                                        @elseif($application->status === 'reviewed') bg-blue-100 text-blue-800
                                                        @elseif($application->status === 'accepted') bg-green-100 text-green-800
                                                        @elseif($application->status === 'rejected') bg-red-100 text-red-800
                                                        @else bg-gray-100 text-gray-800 @endif">
                                                        {{ ucfirst($application->status) }}
                                                    </span>
                                                    <span class="text-sm text-gray-500">
                                                        Applied {{ $application->created_at->diffForHumans() }}
                                                    </span>
                                                    <span class="text-sm text-gray-500">
                                                        Experience: {{ $application->experience_years }} years
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ml-4 flex-shrink-0 flex space-x-2">
                                        <a href="{{ route('admin.applications.show', $application) }}"
                                           class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded text-blue-700 bg-blue-100 hover:bg-blue-200">
                                            <i class="fa-solid fa-eye mr-1"></i>
                                            View
                                        </a>
                                        <a href="{{ route('admin.applications.download-resume', $application) }}"
                                           class="inline-flex items-center px-3 py-1 border border-gray-300 text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50">
                                            <i class="fa-solid fa-download mr-1"></i>
                                            Resume
                                        </a>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>

                    <!-- Pagination -->
                    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                        {{ $applications->links() }}
                    </div>
                @else
                    <div class="px-4 py-12 text-center">
                        <i class="fa-solid fa-file-circle-question text-gray-300 text-5xl mb-4"></i>
                        <p class="text-gray-500 text-lg font-medium">No applications found</p>
                        <p class="text-gray-400 text-sm mt-1">This job doesn't have any applications yet</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
