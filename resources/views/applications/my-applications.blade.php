<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="p-6">
                    <!-- Header -->
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">My Applications</h2>
                        <p class="text-gray-600 mt-2">Track your job applications and their status</p>

                        <!-- Stats Cards -->
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-6">
                            <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fa-solid fa-paper-plane text-blue-600 text-xl"></i>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-blue-600">Total Applications</p>
                                        <p class="text-2xl font-bold text-blue-900">{{ $applications->total() }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-100">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fa-solid fa-clock text-yellow-600 text-xl"></i>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-yellow-600">Pending</p>
                                        <p class="text-2xl font-bold text-yellow-900">
                                            {{ $applications->where('status', 'pending')->count() }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-green-50 p-4 rounded-lg border border-green-100">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fa-solid fa-check text-green-600 text-xl"></i>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-green-600">Accepted</p>
                                        <p class="text-2xl font-bold text-green-900">
                                            {{ $applications->where('status', 'accepted')->count() }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-purple-50 p-4 rounded-lg border border-purple-100">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fa-solid fa-eye text-purple-600 text-xl"></i>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-purple-600">Under Review</p>
                                        <p class="text-2xl font-bold text-purple-900">
                                            {{ $applications->where('status', 'under_review')->count() }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Applications Table -->
                    <div class="relative overflow-x-auto shadow-md rounded-lg">
                        <table class="w-full text-sm text-left text-gray-700">
                            <thead class="text-sm text-gray-800 uppercase bg-gray-50 border-b">
                                <tr>
                                    <th scope="col" class="px-6 py-4 font-semibold">
                                        Job Details
                                    </th>
                                    <th scope="col" class="px-6 py-4 font-semibold">
                                        Company
                                    </th>
                                    <th scope="col" class="px-6 py-4 font-semibold">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-4 font-semibold">
                                        Applied Date
                                    </th>
                                    <th scope="col" class="px-6 py-4 font-semibold text-center">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($applications as $application)
                                    <tr class="bg-white border-b hover:bg-gray-50 transition-colors duration-200">
                                        <!-- Job Details -->
                                        <td class="px-6 py-4">
                                            <div class="flex items-start space-x-3">
                                                @if ($application->job->logo)
                                                    <img src="{{ asset('storage/' . $application->job->logo) }}"
                                                        alt="{{ $application->job->company_name }} logo"
                                                        class="w-12 h-12 rounded-lg object-cover border border-gray-200">
                                                @else
                                                    <div
                                                        class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center border border-gray-300">
                                                        <span class="text-lg font-semibold text-gray-600">
                                                            {{ substr($application->job->company_name, 0, 1) }}
                                                        </span>
                                                    </div>
                                                @endif
                                                <div class="flex-1">
                                                    <h3 class="font-semibold text-gray-900 text-base">
                                                        {{ $application->job->job_title }}
                                                    </h3>
                                                    <div class="mt-2 space-y-1">
                                                        <div class="flex items-center text-sm text-gray-600">
                                                            <i class="fa-solid fa-location-dot mr-2 text-gray-400"></i>
                                                            <span>{{ $application->job->location }}</span>
                                                        </div>
                                                        <div class="flex items-center text-sm text-gray-600">
                                                            <i class="fa-solid fa-briefcase mr-2 text-gray-400"></i>
                                                            <span>{{ $application->job->employment_type }}</span>
                                                        </div>
                                                        @if ($application->job->salary_minimum && $application->job->salary_maximum)
                                                            <div class="flex items-center text-sm text-gray-600">
                                                                <i
                                                                    class="fa-solid fa-money-bill-wave mr-2 text-gray-400"></i>
                                                                <span>${{ number_format($application->job->salary_minimum) }}
                                                                    -
                                                                    ${{ number_format($application->job->salary_maximum) }}</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Company -->
                                        <td class="px-6 py-4">
                                            <div class="text-sm">
                                                <p class="font-medium text-gray-900">
                                                    {{ $application->job->company_name }}</p>
                                                <p class="text-gray-500 mt-1">{{ $application->email }}</p>
                                                @if ($application->phone)
                                                    <p class="text-gray-500">{{ $application->phone }}</p>
                                                @endif
                                            </div>
                                        </td>

                                        <!-- Status -->
                                        <td class="px-6 py-4">
                                            <div class="flex flex-col space-y-2">
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                                    @if ($application->status === 'accepted') bg-green-100 text-green-800 border border-green-200
                                                    @elseif($application->status === 'rejected')
                                                        bg-red-100 text-red-800 border border-red-200
                                                    @elseif($application->status === 'pending')
                                                        bg-yellow-100 text-yellow-800 border border-yellow-200
                                                    @elseif($application->status === 'under_review')
                                                        bg-blue-100 text-blue-800 border border-blue-200
                                                    @elseif($application->status === 'shortlisted')
                                                        bg-indigo-100 text-indigo-800 border border-indigo-200
                                                    @elseif($application->status === 'interview')
                                                        bg-purple-100 text-purple-800 border border-purple-200
                                                    @else
                                                        bg-gray-100 text-gray-800 border border-gray-200 @endif">
                                                    <i
                                                        class="fa-solid fa-circle text-xs mr-2
                                                        @if ($application->status === 'accepted') text-green-500
                                                        @elseif($application->status === 'rejected') text-red-500
                                                        @elseif($application->status === 'pending') text-yellow-500
                                                        @elseif($application->status === 'under_review') text-blue-500
                                                        @elseif($application->status === 'shortlisted') text-indigo-500
                                                        @elseif($application->status === 'interview') text-purple-500
                                                        @else text-gray-500 @endif"></i>
                                                    {{ $application->formatted_status }}
                                                </span>

                                                @if ($application->status === 'accepted')
                                                    <div class="flex items-center text-xs text-green-600 font-medium">
                                                        <i class="fa-solid fa-check mr-1"></i>
                                                        Congratulations! Contact the employer for next steps.
                                                    </div>
                                                @elseif($application->status === 'interview')
                                                    <div class="flex items-center text-xs text-purple-600 font-medium">
                                                        <i class="fa-solid fa-calendar mr-1"></i>
                                                        Interview scheduled
                                                    </div>
                                                @elseif($application->status === 'shortlisted')
                                                    <div class="flex items-center text-xs text-indigo-600 font-medium">
                                                        <i class="fa-solid fa-star mr-1"></i>
                                                        You've been shortlisted
                                                    </div>
                                                @endif
                                            </div>
                                        </td>

                                        <!-- Applied Date -->
                                        <td class="px-6 py-4">
                                            <div class="flex flex-col">
                                                <span class="text-sm font-medium text-gray-900">
                                                    {{ $application->created_at->format('M d, Y') }}
                                                </span>
                                                <span class="text-xs text-gray-500">
                                                    {{ $application->created_at->format('h:i A') }}
                                                </span>
                                                <span class="text-xs text-gray-400 mt-1">
                                                    {{ $application->created_at->diffForHumans() }}
                                                </span>
                                            </div>
                                        </td>

                                        <!-- Actions -->
                                        <td class="px-6 py-4">
                                            <div class="flex flex-col space-y-2 items-center">
                                                <!-- View Job Button -->
                                                <a href="{{ route('jobs.show', $application->job->id) }}"
                                                    class="w-full flex items-center justify-center px-3 py-2 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition-colors duration-200 text-sm font-medium"
                                                    title="View Job Details">
                                                    <i class="fa-solid fa-eye mr-2"></i>
                                                    View Job
                                                </a>

                                                <!-- Documents -->
                                                <div class="flex space-x-2 w-full">
                                                    @if ($application->resume)
                                                        <a href="{{ asset('storage/' . $application->resume) }}"
                                                            target="_blank"
                                                            class="flex-1 flex items-center justify-center px-2 py-2 bg-green-50 text-green-700 rounded-lg hover:bg-green-100 transition-colors duration-200 text-xs"
                                                            title="View Resume">
                                                            <i class="fa-solid fa-file-pdf mr-1"></i>
                                                            Resume
                                                        </a>
                                                    @endif

                                                    @if ($application->cover_letter)
                                                        <a href="{{ asset('storage/' . $application->cover_letter) }}"
                                                            target="_blank"
                                                            class="flex-1 flex items-center justify-center px-2 py-2 bg-purple-50 text-purple-700 rounded-lg hover:bg-purple-100 transition-colors duration-200 text-xs"
                                                            title="View Cover Letter">
                                                            <i class="fa-solid fa-file-lines mr-1"></i>
                                                            Cover Letter
                                                        </a>
                                                    @endif
                                                </div>

                                                <!-- Withdraw Button -->
                                                <form method="POST"
                                                    action="{{ route('applications.destroy', $application->id) }}"
                                                    class="w-full"
                                                    onsubmit="return confirm('Are you sure you want to withdraw this application? This action cannot be undone.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="w-full flex items-center justify-center px-3 py-2 bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition-colors duration-200 text-sm font-medium"
                                                        title="Withdraw Application">
                                                        <i class="fa-solid fa-trash-can mr-2"></i>
                                                        Withdraw
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center">
                                            <div class="text-gray-400 mb-4">
                                                <i class="fa-solid fa-file-circle-question text-6xl"></i>
                                            </div>
                                            <h3 class="text-lg font-medium text-gray-900 mb-2">No applications yet</h3>
                                            <p class="text-gray-600 mb-6">You haven't applied to any jobs yet. Start
                                                exploring opportunities!</p>
                                            <a href="{{ route('jobs.browse') }}"
                                                class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                                                <i class="fa-solid fa-briefcase mr-2"></i>
                                                Browse Jobs
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if (method_exists($applications, 'hasPages') && $applications->hasPages())
                        <div class="mt-6">
                            {{ $applications->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Add any custom JavaScript here if needed
            document.addEventListener('DOMContentLoaded', function() {
                // You can add interactive features here
                console.log('My Applications page loaded');
            });
        </script>
    @endpush
</x-app-layout>
