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
                            <select
                                class="appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2 pr-8 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                <option>All Status</option>
                                <option>Pending</option>
                                <option>Reviewed</option>
                                <option>Accepted</option>
                                <option>Rejected</option>
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
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
                <!-- Total Applications Card -->
                <div
                    class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white transform hover:-translate-y-1 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-medium">Total Applications</p>
                            <p class="text-3xl font-bold mt-2">{{ $data['totalApplications'] }}</p>
                        </div>
                        <div class="bg-blue-400 bg-opacity-20 p-3 rounded-lg">
                            <i class="fas fa-users text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 text-sm text-blue-100">
                        <i class="fas fa-arrow-up mr-1"></i> 12% from last month
                    </div>
                </div>

                <!-- Pending Card -->
                <div
                    class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl shadow-lg p-6 text-white transform hover:-translate-y-1 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-yellow-100 text-sm font-medium">Pending Review</p>
                            <p class="text-3xl font-bold mt-2">{{ $data['totalPending'] }}</p>
                        </div>
                        <div class="bg-yellow-400 bg-opacity-20 p-3 rounded-lg">
                            <i class="fas fa-clock text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 text-sm text-yellow-100">
                        <i class="fas fa-exclamation-circle mr-1"></i> Needs attention
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
                        <i class="fas fa-check mr-1"></i> 20% of total
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
                        <i class="fas fa-arrow-up mr-1"></i> 8% success rate
                    </div>
                </div>

                <!-- Rejected Card -->
                <div
                    class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl shadow-lg p-6 text-white transform hover:-translate-y-1 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-red-100 text-sm font-medium">Rejected</p>
                            <p class="text-3xl font-bold mt-2">{{ $data['totalRejected'] }}</p>
                        </div>
                        <div class="bg-red-400 bg-opacity-20 p-3 rounded-lg">
                            <i class="fas fa-times-circle text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 text-sm text-red-100">
                        <i class="fas fa-chart-line mr-1"></i> 15% of total
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
                                            <i class="fas fa-phone mr-2"></i>
                                            Contact
                                        </div>
                                    </th>
                                    <th class="py-4 px-6 text-left">
                                        <div
                                            class="flex items-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            <i class="fas fa-briefcase mr-2"></i>
                                            Experience
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
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($applications as $application)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
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
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="font-medium text-gray-900">{{ $application->full_name }}
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

                                        <!-- Experience -->
                                        <td class="py-4 px-6">
                                            @if ($application->experience_years)
                                                <div
                                                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-50 to-purple-100 rounded-lg">
                                                    <div
                                                        class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center mr-3">
                                                        <i class="fas fa-briefcase text-white"></i>
                                                    </div>
                                                    <div>
                                                        <div class="font-bold text-gray-900">
                                                            {{ $application->experience_years }} years</div>
                                                        <div class="text-xs text-purple-600">Experience</div>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-gray-400 italic">Not specified</span>
                                            @endif
                                        </td>

                                        <!-- Status -->
                                        <td class="py-4 px-6">
                                            <form action="{{ route('admin.applicants.update-status', $application) }}"
                                                method="POST" class="relative group">
                                                @csrf
                                                @method('PUT')
                                                <div class="relative">
                                                    <select name="status" onchange="this.form.submit()"
                                                        class="appearance-none w-full px-4 py-2 pr-8 rounded-lg border border-gray-200 bg-white text-sm font-medium focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200
                                                            {{ $application->status === 'pending' ? 'bg-yellow-50 text-yellow-700 border-yellow-200' : '' }}
                                                            {{ $application->status === 'accepted' ? 'bg-green-50 text-green-700 border-green-200' : '' }}
                                                            {{ $application->status === 'rejected' ? 'bg-red-50 text-red-700 border-red-200' : '' }}
                                                            {{ $application->status === 'under_reviewed' ? 'bg-blue-50 text-blue-700 border-blue-200' : '' }}
                                                            {{ $application->status === 'shortlisted' ? 'bg-indigo-50 text-indigo-700 border-indigo-200' : '' }}
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
                                                    {{ $application->created_at->format('d') }} {{ $application->created_at->format('M') }} {{ $application->created_at->format('h:i A') }}
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

                                                <button
                                                    class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-gray-50 text-gray-600 hover:bg-gray-100 hover:text-gray-700 transition-all duration-200 group"
                                                    title="View Details">
                                                    <i
                                                        class="fas fa-eye group-hover:scale-110 transition-transform"></i>
                                                </button>

                                                <form method="POST"
                                                    action="{{ route('applications.destroy', $application) }}"
                                                    class="inline"
                                                    onsubmit="return confirm('Are you sure you want to delete this application?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
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
</x-app-layout>
