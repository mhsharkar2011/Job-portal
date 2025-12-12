<x-app-layout>
    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <div class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Job Applications
                        </h1>
                        <p class="text-gray-600 mt-1">Manage and track all job applications</p>
                    </div>
                    <div class="mt-4 sm:mt-0 flex items-center space-x-3">
                        <!-- Filter Dropdown -->
                        <div class="relative">
                            <select id="statusFilter" onchange="filterApplications()"
                                class="appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2 pr-8 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                <option value="">All Status</option>
                                <option value="pending">Pending</option>
                                <option value="under_reviewed">Under Review</option>
                                <option value="shortlisted">Shortlisted</option>
                                <option value="interview">Interview</option>
                                <option value="accepted">Accepted</option>
                                <option value="rejected">Rejected</option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                                <i class="fas fa-chevron-down text-sm"></i>
                            </div>
                        </div>

                        <!-- Export Button -->
                        <button
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:ring-2 focus:ring-blue-500 transition-all duration-200">
                            <i class="fas fa-download mr-2"></i>
                            Export
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Statistics Cards - Updated with all statuses -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-7 gap-4 mb-8">
                <!-- Total Applications Card -->
                <div
                    class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white transform hover:-translate-y-1 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-medium">Total</p>
                            <p class="text-3xl font-bold mt-2">{{ $data['totalApplications'] }}</p>
                        </div>
                        <div class="bg-blue-400 bg-opacity-20 p-3 rounded-lg">
                            <i class="fas fa-users text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 text-sm text-blue-100">
                        <i class="fas fa-chart-bar mr-1"></i> All applications
                    </div>
                </div>

                <!-- Pending Card -->
                <div
                    class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl shadow-lg p-6 text-white transform hover:-translate-y-1 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-yellow-100 text-sm font-medium">Pending</p>
                            <p class="text-3xl font-bold mt-2">{{ $data['totalPending'] }}</p>
                        </div>
                        <div class="bg-yellow-400 bg-opacity-20 p-3 rounded-lg">
                            <i class="fas fa-clock text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 text-sm text-yellow-100">
                        <i class="fas fa-exclamation-circle mr-1"></i> Needs review
                    </div>
                </div>

                <!-- Reviewed Card -->
                <div
                    class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl shadow-lg p-6 text-white transform hover:-translate-y-1 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-indigo-100 text-sm font-medium">Reviewed</p>
                            <p class="text-3xl font-bold mt-2">{{ $data['totalReviewed'] }}</p>
                        </div>
                        <div class="bg-indigo-400 bg-opacity-20 p-3 rounded-lg">
                            <i class="fas fa-eye text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 text-sm text-indigo-100">
                        <i class="fas fa-check mr-1"></i> Under review
                    </div>
                </div>

                <!-- Shortlisted Card -->
                <div
                    class="bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl shadow-lg p-6 text-white transform hover:-translate-y-1 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-pink-100 text-sm font-medium">Shortlisted</p>
                            <p class="text-3xl font-bold mt-2">
                                {{ \App\Models\Application::where('status', 'shortlisted')->count() }}
                            </p>
                        </div>
                        <div class="bg-pink-400 bg-opacity-20 p-3 rounded-lg">
                            <i class="fas fa-star text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 text-sm text-pink-100">
                        <i class="fas fa-filter mr-1"></i> Top candidates
                    </div>
                </div>

                <!-- Interview Card -->
                <div
                    class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white transform hover:-translate-y-1 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-purple-100 text-sm font-medium">Interview</p>
                            <p class="text-3xl font-bold mt-2">
                                {{ \App\Models\Application::where('status', 'interview')->count() }}
                            </p>
                        </div>
                        <div class="bg-purple-400 bg-opacity-20 p-3 rounded-lg">
                            <i class="fas fa-calendar-alt text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 text-sm text-purple-100">
                        <i class="fas fa-video mr-1"></i> Scheduled
                    </div>
                </div>

                <!-- Accepted Card -->
                <div
                    class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white transform hover:-translate-y-1 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-100 text-sm font-medium">Accepted</p>
                            <p class="text-3xl font-bold mt-2">{{ $data['totalAccepted'] }}</p>
                        </div>
                        <div class="bg-green-400 bg-opacity-20 p-3 rounded-lg">
                            <i class="fas fa-check-circle text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 text-sm text-green-100">
                        <i class="fas fa-trophy mr-1"></i> Hired
                    </div>
                </div>

                <!-- Rejected Card -->
                <div
                    class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl shadow-lg p-6 text-white transform hover:-translate-y-1 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-red-100 text-sm font-medium">Rejected</p>
                            <p class="text-3xl font-bold mt-2">{{ $data['totalReviewed'] }}</p>
                        </div>
                        <div class="bg-red-400 bg-opacity-20 p-3 rounded-lg">
                            <i class="fas fa-times-circle text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 text-sm text-red-100">
                        <i class="fas fa-chart-line mr-1"></i> Not selected
                    </div>
                </div>
            </div>

            <!-- Applications Table Card -->
            @if ($applications->count() > 0)
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-8">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-gray-900">Recent Applications</h2>
                            <span class="text-sm text-gray-500">{{ $applications->total() }} total applications</span>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="py-4 px-6 text-left">
                                        <div
                                            class="flex items-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            <i class="fas fa-user mr-2"></i>
                                            Applicant
                                        </div>
                                    </th>
                                    <th class="py-4 px-6 text-left">
                                        <div
                                            class="flex items-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            <i class="fas fa-briefcase mr-2"></i>
                                            Job
                                        </div>
                                    </th>
                                    <th class="py-4 px-6 text-left">
                                        <div
                                            class="flex items-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            <i class="fas fa-phone mr-2"></i>
                                            Contact
                                        </div>
                                    </th>
                                    <th class="py-4 px-6 text-left">
                                        <div
                                            class="flex items-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            <i class="fas fa-flag mr-2"></i>
                                            Status
                                        </div>
                                    </th>
                                    <th class="py-4 px-6 text-left">
                                        <div
                                            class="flex items-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            <i class="fas fa-calendar mr-2"></i>
                                            Applied Date
                                        </div>
                                    </th>
                                    <th class="py-4 px-6 text-left">
                                        <div
                                            class="flex items-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            <i class="fas fa-cog mr-2"></i>
                                            Actions
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100" id="applicationsTable">
                                @foreach ($applications as $application)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150 application-row"
                                        data-status="{{ $application->status }}">
                                        <!-- Applicant -->
                                        <td class="py-4 px-6">
                                            <div class="flex items-center">
                                                <div class="relative">
                                                    <div
                                                        class="w-12 h-12 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center text-white font-bold shadow-md">
                                                        {{ substr($application->full_name, 0, 1) }}
                                                    </div>
                                                    @if ($application->status === 'accepted')
                                                        <div
                                                            class="absolute -top-1 -right-1 w-5 h-5 bg-green-500 rounded-full border-2 border-white flex items-center justify-center">
                                                            <i class="fas fa-check text-xs text-white"></i>
                                                        </div>
                                                    @elseif($application->status === 'shortlisted')
                                                        <div
                                                            class="absolute -top-1 -right-1 w-5 h-5 bg-pink-500 rounded-full border-2 border-white flex items-center justify-center">
                                                            <i class="fas fa-star text-xs text-white"></i>
                                                        </div>
                                                    @elseif($application->status === 'interview')
                                                        <div
                                                            class="absolute -top-1 -right-1 w-5 h-5 bg-purple-500 rounded-full border-2 border-white flex items-center justify-center">
                                                            <i class="fas fa-calendar-alt text-xs text-white"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="font-medium text-gray-900">
                                                        {{ $application->full_name }}
                                                    </div>
                                                    <div class="flex flex-wrap gap-1 mt-1">
                                                        @if ($application->skills_array)
                                                            @foreach (array_slice($application->skills_array, 0, 2) as $skill)
                                                                <span
                                                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                                    {{ $skill }}
                                                                </span>
                                                            @endforeach
                                                            @if (count($application->skills_array) > 2)
                                                                <span
                                                                    class="text-xs text-gray-500">+{{ count($application->skills_array) - 2 }}</span>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Job Info -->
                                        <td class="py-4 px-6">
                                            @if ($application->job)
                                                <div>
                                                    <div class="font-medium text-gray-900">
                                                        {{ $application->job->title }}</div>
                                                    <div class="text-sm text-gray-600">
                                                        {{ $application->job->company->name ?? 'N/A' }}</div>
                                                    <div class="text-xs text-gray-500 mt-1">
                                                        {{ $application->experience_years }} years exp</div>
                                                </div>
                                            @else
                                                <span class="text-gray-400 italic">Job not found</span>
                                            @endif
                                        </td>

                                        <!-- Contact -->
                                        <td class="py-4 px-6">
                                            <div class="space-y-2">
                                                <div class="flex items-center text-sm text-gray-700">
                                                    <div
                                                        class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center mr-3">
                                                        <i class="fas fa-envelope text-gray-500"></i>
                                                    </div>
                                                    <a href="mailto:{{ $application->email }}"
                                                        class="hover:text-blue-600 transition-colors">
                                                        {{ $application->email }}
                                                    </a>
                                                </div>
                                                @if ($application->phone)
                                                    <div class="flex items-center text-sm text-gray-700">
                                                        <div
                                                            class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center mr-3">
                                                            <i class="fas fa-phone text-gray-500"></i>
                                                        </div>
                                                        {{ $application->phone }}
                                                    </div>
                                                @endif
                                            </div>
                                        </td>

                                        <!-- Status -->
                                        <td class="py-4 px-6">
                                            <form action="{{ route('admin.applicants.update-status', $application) }}"
                                                method="POST" class="status-form">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="application_id"
                                                    value="{{ $application->id }}">

                                                <div class="relative">
                                                    <select name="status"
                                                        onchange="updateStatus(this, '{{ $application->id }}')"
                                                        data-old-value="{{ $application->status }}"
                                                        class="appearance-none w-full px-4 py-2 pr-8 rounded-lg border border-gray-200 bg-white text-sm font-medium focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200
                                                                {{ $application->status === 'pending' ? 'bg-yellow-50 text-yellow-700 border-yellow-200' : '' }}
                                                                {{ $application->status === 'accepted' ? 'bg-green-50 text-green-700 border-green-200' : '' }}
                                                                {{ $application->status === 'rejected' ? 'bg-red-50 text-red-700 border-red-200' : '' }}
                                                                {{ $application->status === 'under_reviewed' ? 'bg-blue-50 text-blue-700 border-blue-200' : '' }}
                                                                {{ $application->status === 'shortlisted' ? 'bg-pink-50 text-pink-700 border-pink-200' : '' }}
                                                                {{ $application->status === 'interview' ? 'bg-purple-50 text-purple-700 border-purple-200' : '' }}">
                                                        @foreach (App\Models\Application::getStatusOptions() as $value => $label)
                                                            <option value="{{ $value }}"
                                                                {{ $application->status === $value ? 'selected' : '' }}>
                                                                {{ $label }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div
                                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                                                        <i class="fas fa-chevron-down text-sm"></i>
                                                    </div>
                                                </div>
                                            </form>
                                        </td>

                                        <!-- Applied Date -->
                                        <td class="py-4 px-6">
                                            <div class="inline-flex flex-col items-center p-3 bg-gray-50 rounded-lg">
                                                <div class="text-lg font-bold text-gray-900">
                                                    {{ $application->created_at->format('d') }}
                                                </div>
                                                <div class="text-xs text-gray-600 uppercase">
                                                    {{ $application->created_at->format('M') }}
                                                </div>
                                                <div class="text-xs text-gray-500 mt-1">
                                                    {{ $application->created_at->format('h:i A') }}
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Actions -->
                                        <td class="py-4 px-6">
                                            <div class="flex items-center space-x-2">
                                                @if ($application->resume_path)
                                                    <a href="{{ asset('storage/' . $application->resume_path) }}"
                                                        target="_blank"
                                                        class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 hover:text-blue-700 transition-all duration-200 group"
                                                        title="View Resume">
                                                        <i
                                                            class="fas fa-file-pdf group-hover:scale-110 transition-transform"></i>
                                                    </a>
                                                @endif

                                                @if ($application->cover_letter_path)
                                                    <a href="{{ asset('storage/' . $application->cover_letter_path) }}"
                                                        target="_blank"
                                                        class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-green-50 text-green-600 hover:bg-green-100 hover:text-green-700 transition-all duration-200 group"
                                                        title="View Cover Letter">
                                                        <i
                                                            class="fas fa-file-lines group-hover:scale-110 transition-transform"></i>
                                                    </a>
                                                @endif

                                                <!-- Add Interview Notes Button (only for interview status) -->
                                                @if ($application->status === 'interview' || $application->status === 'shortlisted')
                                                    <button
                                                        onclick="showInterviewModal('{{ $application->id }}', '{{ $application->full_name }}')"
                                                        class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-purple-50 text-purple-600 hover:bg-purple-100 hover:text-purple-700 transition-all duration-200 group"
                                                        title="Add Interview Notes">
                                                        <i
                                                            class="fas fa-notes-medical group-hover:scale-110 transition-transform"></i>
                                                    </button>
                                                @endif

                                                <!-- View Details Button -->
                                                <a href="{{ route('admin.applicants.show', $application) }}"
                                                    class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-gray-50 text-gray-600 hover:bg-gray-100 hover:text-gray-700 transition-all duration-200 group"
                                                    title="View Details">
                                                    <i
                                                        class="fas fa-eye group-hover:scale-110 transition-transform"></i>
                                                </a>

                                                <!-- Delete Button -->
                                                <form method="POST"
                                                    action="{{ route('applications.destroy', $application) }}"
                                                    class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        onclick="confirmDelete('{{ $application->id }}')"
                                                        class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 transition-all duration-200 group"
                                                        title="Delete Application">
                                                        <i
                                                            class="fas fa-trash group-hover:scale-110 transition-transform"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-12 text-center">
                    <div class="max-w-md mx-auto">
                        <div
                            class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-users text-4xl text-gray-400"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">No applications yet</h3>
                        <p class="text-gray-600 mb-6">No one has applied to this job posting yet. Applications will
                            appear here once candidates start applying.</p>
                        <div class="space-x-3">
                            <button
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200">
                                <i class="fas fa-share mr-2"></i>
                                Share Job Posting
                            </button>
                            <button
                                class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200">
                                <i class="fas fa-sync mr-2"></i>
                                Refresh
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Pagination -->
            @if ($applications->hasPages())
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 px-6 py-4">
                    {{ $applications->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Interview Notes Modal -->
    <div id="interviewModal"
        class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900" id="modalTitle">Interview Notes</h3>
                    <button onclick="closeInterviewModal()" class="text-gray-400 hover:text-gray-500">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="mt-2">
                    <input type="hidden" id="modalApplicationId">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Candidate</label>
                        <p class="text-gray-900 font-medium" id="modalCandidateName"></p>
                    </div>
                    <div class="mb-4">
                        <label for="interviewDate" class="block text-sm font-medium text-gray-700 mb-2">Interview
                            Date</label>
                        <input type="datetime-local" id="interviewDate" name="interview_date"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="mb-4">
                        <label for="interviewNotes" class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                        <textarea id="interviewNotes" name="interview_notes" rows="4"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Add interview notes, feedback, or next steps..."></textarea>
                    </div>
                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" onclick="closeInterviewModal()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md transition-colors">
                            Cancel
                        </button>
                        <button type="button" onclick="saveInterviewNotes()"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md transition-colors">
                            Save Notes
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            /* Custom scrollbar */
            .overflow-x-auto::-webkit-scrollbar {
                height: 6px;
            }

            .overflow-x-auto::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 3px;
            }

            .overflow-x-auto::-webkit-scrollbar-thumb {
                background: #cbd5e1;
                border-radius: 3px;
            }

            .overflow-x-auto::-webkit-scrollbar-thumb:hover {
                background: #94a3b8;
            }

            /* Smooth transitions */
            select,
            button,
            a {
                transition: all 0.2s ease-in-out;
            }

            /* Status-specific styles */
            .status-pending {
                background-color: #fef3c7;
                color: #92400e;
                border-color: #fbbf24;
            }

            .status-under_reviewed {
                background-color: #dbeafe;
                color: #1e40af;
                border-color: #60a5fa;
            }

            .status-shortlisted {
                background-color: #fce7f3;
                color: #9d174d;
                border-color: #f472b6;
            }

            .status-interview {
                background-color: #f3e8ff;
                color: #5b21b6;
                border-color: #a855f7;
            }

            .status-accepted {
                background-color: #d1fae5;
                color: #065f46;
                border-color: #10b981;
            }

            .status-rejected {
                background-color: #fee2e2;
                color: #991b1b;
                border-color: #f87171;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            // Status update function
            function updateStatus(selectElement, applicationId) {
                const oldValue = selectElement.getAttribute('data-old-value');
                const newValue = selectElement.value;

                // Confirmation messages
                const confirmMessages = {
                    'pending': 'Are you sure you want to mark this as pending?',
                    'under_reviewed': 'Are you sure you want to mark this as under review?',
                    'shortlisted': 'Are you sure you want to shortlist this candidate?',
                    'interview': 'Are you sure you want to schedule an interview?',
                    'accepted': 'Are you sure you want to accept this application?',
                    'rejected': 'Are you sure you want to reject this application?'
                };

                // Show confirmation
                if (confirm(confirmMessages[newValue] || 'Update status?')) {
                    // Update old value
                    selectElement.setAttribute('data-old-value', newValue);

                    // Submit the form
                    const form = selectElement.closest('form');

                    // Add loading state
                    const originalContent = selectElement.innerHTML;
                    selectElement.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Updating...';
                    selectElement.disabled = true;

                    // Submit via AJAX
                    fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                status: newValue,
                                _method: 'PUT'
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            // Restore select
                            selectElement.innerHTML = originalContent;
                            selectElement.disabled = false;

                            if (data.success) {
                                // Update UI classes
                                const statusClasses = {
                                    'pending': 'bg-yellow-50 text-yellow-700 border-yellow-200',
                                    'under_reviewed': 'bg-blue-50 text-blue-700 border-blue-200',
                                    'shortlisted': 'bg-pink-50 text-pink-700 border-pink-200',
                                    'interview': 'bg-purple-50 text-purple-700 border-purple-200',
                                    'accepted': 'bg-green-50 text-green-700 border-green-200',
                                    'rejected': 'bg-red-50 text-red-700 border-red-200'
                                };

                                // Remove all status classes
                                const classList = selectElement.className.split(' ');
                                const filteredClasses = classList.filter(cls =>
                                    !cls.includes('bg-') || !cls.includes('text-') || !cls.includes('border-'));
                                selectElement.className = filteredClasses.join(' ') + ' ' + statusClasses[newValue];

                                // Show success message
                                showNotification('Status updated successfully!', 'success');

                                // Update badge icon if needed
                                updateStatusBadge(applicationId, newValue);

                            } else {
                                showNotification(data.message || 'Failed to update status', 'error');
                                selectElement.value = oldValue;
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            selectElement.innerHTML = originalContent;
                            selectElement.disabled = false;
                            selectElement.value = oldValue;
                            showNotification('Failed to update status', 'error');
                        });
                } else {
                    selectElement.value = oldValue;
                }
            }

            function updateStatusBadge(applicationId, newStatus) {
                const badge = document.querySelector(`tr[data-application-id="${applicationId}"] .status-badge`);
                if (badge) {
                    const badgeClasses = {
                        'pending': 'bg-yellow-100 text-yellow-800',
                        'under_reviewed': 'bg-blue-100 text-blue-800',
                        'shortlisted': 'bg-pink-100 text-pink-800',
                        'interview': 'bg-purple-100 text-purple-800',
                        'accepted': 'bg-green-100 text-green-800',
                        'rejected': 'bg-red-100 text-red-800'
                    };

                    badge.className = badge.className.replace(/bg-\w+-\d+ text-\w+-\d+/g, '') + ' ' + badgeClasses[newStatus];
                    badge.textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);
                }
            }

            function showNotification(message, type = 'info') {
                // Create notification element
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 z-50 px-4 py-3 rounded-lg shadow-lg text-white transform transition-all duration-300 ${
                    type === 'success' ? 'bg-green-500' :
                    type === 'error' ? 'bg-red-500' : 'bg-blue-500'
                }`;
                notification.innerHTML = `
                    <div class="flex items-center">
                        <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-triangle' : 'info-circle'} mr-2"></i>
                        <span>${message}</span>
                    </div>
                `;

                document.body.appendChild(notification);

                // Remove after 3 seconds
                setTimeout(() => {
                    notification.remove();
                }, 3000);
            }

            function confirmDelete(applicationId) {
                if (confirm('Are you sure you want to delete this application? This action cannot be undone.')) {
                    // Find and submit the delete form
                    const form = document.querySelector(`form[action*="/applications/${applicationId}"]`);
                    if (form) {
                        form.submit();
                    }
                }
            }

            function filterApplications() {
                const filterValue = document.getElementById('statusFilter').value;
                const rows = document.querySelectorAll('.application-row');

                rows.forEach(row => {
                    if (!filterValue || row.getAttribute('data-status') === filterValue) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }

            // Interview modal functions
            function showInterviewModal(applicationId, candidateName) {
                document.getElementById('modalApplicationId').value = applicationId;
                document.getElementById('modalCandidateName').textContent = candidateName;
                document.getElementById('interviewModal').classList.remove('hidden');
            }

            function closeInterviewModal() {
                document.getElementById('interviewModal').classList.add('hidden');
                document.getElementById('interviewDate').value = '';
                document.getElementById('interviewNotes').value = '';
            }

            function saveInterviewNotes() {
                const applicationId = document.getElementById('modalApplicationId').value;
                const interviewDate = document.getElementById('interviewDate').value;
                const interviewNotes = document.getElementById('interviewNotes').value;

                // Save via AJAX
                fetch(`/admin/applicants/${applicationId}/interview-notes`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            interview_date: interviewDate,
                            interview_notes: interviewNotes
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showNotification('Interview notes saved successfully!', 'success');
                            closeInterviewModal();
                        } else {
                            showNotification(data.message || 'Failed to save notes', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('Failed to save notes', 'error');
                    });
            }

            // Initialize on page load
            document.addEventListener('DOMContentLoaded', function() {
                // Set initial filter if URL has status parameter
                const urlParams = new URLSearchParams(window.location.search);
                const statusParam = urlParams.get('status');
                if (statusParam) {
                    document.getElementById('statusFilter').value = statusParam;
                    filterApplications();
                }

                // Set old values for all status selects
                document.querySelectorAll('select[name="status"]').forEach(select => {
                    select.setAttribute('data-old-value', select.value);
                });
            });
        </script>
    @endpush
</x-app-layout>
