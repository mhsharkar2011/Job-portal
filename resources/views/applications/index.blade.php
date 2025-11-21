<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="p-6">
                    <!-- Header -->
                    <div class="mb-8">
                        <h1 class="text-2xl font-bold text-gray-900">
                            @if ($job)
                                Applications for: {{ $job->job_title }}
                            @else
                                All Applications
                            @endif
                        </h1>
                        <p class="text-gray-600 mt-2">Manage and review job applications</p>
                    </div>

                    <!-- Statistics Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
                        <div class="bg-white rounded-lg shadow border border-gray-200 p-6 text-center">
                            <div class="text-2xl font-bold text-blue-600">{{ $data['totalApplications'] }}</div>
                            <div class="text-gray-600 text-sm mt-1">Total</div>
                        </div>
                        <div class="bg-white rounded-lg shadow border border-yellow-200 p-6 text-center">
                            <div class="text-2xl font-bold text-yellow-600">{{ $data['totalPending'] }}</div>
                            <div class="text-gray-600 text-sm mt-1">Pending</div>
                        </div>
                        <div class="bg-white rounded-lg shadow border border-blue-200 p-6 text-center">
                            <div class="text-2xl font-bold text-blue-600">{{ $data['totalReviewed'] }}</div>
                            <div class="text-gray-600 text-sm mt-1">Reviewed</div>
                        </div>
                        <div class="bg-white rounded-lg shadow border border-green-200 p-6 text-center">
                            <div class="text-2xl font-bold text-green-600">{{ $data['totalAccepted'] }}</div>
                            <div class="text-gray-600 text-sm mt-1">Accepted</div>
                        </div>
                        <div class="bg-white rounded-lg shadow border border-red-200 p-6 text-center">
                            <div class="text-2xl font-bold text-red-600">{{ $data['totalRejected'] }}</div>
                            <div class="text-gray-600 text-sm mt-1">Rejected</div>
                        </div>
                    </div>
                    <!-- Applications Table -->
                    @if ($applications->count() > 0)
                        <div class="relative overflow-x-auto shadow-md rounded-lg">
                            <table class="w-full text-sm text-left text-gray-700">
                                <thead class="text-xs text-gray-800 uppercase bg-gray-50 border-b">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 font-semibold">
                                            Applicant
                                        </th>
                                        <th scope="col" class="px-6 py-3 font-semibold">
                                            Contact
                                        </th>
                                        <th scope="col" class="px-6 py-3 font-semibold">
                                            Experience
                                        </th>
                                        <th scope="col" class="px-6 py-3 font-semibold">
                                            Status
                                        </th>
                                        <th scope="col" class="px-6 py-3 font-semibold">
                                            Applied Date
                                        </th>
                                        <th scope="col" class="px-6 py-3 font-semibold text-center">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($applications as $application)
                                        <tr class="bg-white border-b hover:bg-gray-50 transition-colors duration-200">
                                            <!-- Applicant Info -->
                                            <td class="px-6 py-4">
                                                <div class="flex items-center space-x-3">
                                                    <div
                                                        class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                                        <span class="text-sm font-medium text-blue-800">
                                                            {{ substr($application->full_name, 0, 1) }}
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <div class="font-medium text-gray-900">
                                                            {{ $application->full_name }}</div>
                                                        @if ($application->skills_array)
                                                            <div class="text-xs text-gray-500 mt-1">
                                                                @foreach (array_slice($application->skills_array, 0, 2) as $skill)
                                                                    <span
                                                                        class="inline-block bg-gray-100 px-2 py-1 rounded mr-1">{{ $skill }}</span>
                                                                @endforeach
                                                                @if (count($application->skills_array) > 2)
                                                                    <span
                                                                        class="text-gray-400">+{{ count($application->skills_array) - 2 }}
                                                                        more</span>
                                                                @endif
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- Contact Info -->
                                            <td class="px-6 py-4">
                                                <div class="space-y-1">
                                                    <div class="flex items-center text-sm text-gray-900">
                                                        <i class="fa-solid fa-envelope mr-2 text-gray-400"></i>
                                                        {{ $application->email }}
                                                    </div>
                                                    @if ($application->phone)
                                                        <div class="flex items-center text-sm text-gray-600">
                                                            <i class="fa-solid fa-phone mr-2 text-gray-400"></i>
                                                            {{ $application->phone }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>

                                            <!-- Experience -->
                                            <td class="px-6 py-4">
                                                @if ($application->experience_years)
                                                    <span
                                                        class="inline-flex items-center px-3 py-1 bg-purple-100 text-purple-800 text-sm font-medium rounded-full">
                                                        <i class="fa-solid fa-briefcase mr-1"></i>
                                                        {{ $application->experience_years }} years
                                                    </span>
                                                @else
                                                    <span class="text-gray-400 text-sm">Not specified</span>
                                                @endif
                                            </td>

                                            <!-- Status -->
                                            <td class="px-6 py-4">
                                                <form action="{{ route('applications.updateStatus', $application) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <select name="status" onchange="this.form.submit()"
                                                        class="text-sm border border-gray-300 rounded-lg px-3 py-1 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                                                                {{ $application->status === 'accepted' ? 'bg-green-100 text-green-800' : '' }}
                                                                {{ $application->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                                {{ $application->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}
                                                                {{ $application->status === 'under_review' ? 'bg-blue-100 text-blue-800' : '' }}
                                                                {{ $application->status === 'shortlisted' ? 'bg-indigo-100 text-indigo-800' : '' }}
                                                                {{ $application->status === 'interview' ? 'bg-purple-100 text-purple-800' : '' }}">
                                                        @foreach (App\Models\Application::getStatusOptions() as $value => $label)
                                                            <option value="{{ $value }}"
                                                                {{ $application->status === $value ? 'selected' : '' }}>
                                                                {{ $label }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </form>
                                            </td>

                                            <!-- Applied Date -->
                                            <td class="px-6 py-4">
                                                <div class="flex flex-col">
                                                    <span class="text-sm font-medium text-gray-900">
                                                        {{ $application->created_at }}
                                                    </span>

                                                </div>
                                            </td>

                                            <!-- Actions -->
                                            <td class="px-6 py-4">
                                                <div class="flex items-center justify-center space-x-3">
                                                    <!-- View Resume -->
                                                    @if ($application->resume_path)
                                                        <a href="{{ asset('storage/' . $application->resume_path) }}"
                                                            target="_blank"
                                                            class="text-blue-600 hover:text-blue-900 transition-colors duration-200"
                                                            title="View Resume">
                                                            <i class="fa-solid fa-file-pdf text-lg"></i>
                                                        </a>
                                                    @endif

                                                    <!-- View Cover Letter -->
                                                    @if ($application->cover_letter_path)
                                                        <a href="{{ asset('storage/' . $application->cover_letter_path) }}"
                                                            target="_blank"
                                                            class="text-green-600 hover:text-green-900 transition-colors duration-200"
                                                            title="View Cover Letter">
                                                            <i class="fa-solid fa-file-lines text-lg"></i>
                                                        </a>
                                                    @endif

                                                    <!-- Delete Application -->
                                                    <form method="POST"
                                                        action="{{ route('applications.destroy', $application) }}"
                                                        class="inline"
                                                        onsubmit="return confirm('Are you sure you want to delete this application?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="text-red-600 hover:text-red-900 transition-colors duration-200"
                                                            title="Delete Application">
                                                            <i class="fa-regular fa-trash-can text-lg"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $applications->links() }}
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="text-center py-12">
                            <div class="text-gray-400 mb-4">
                                <i class="fa-solid fa-users text-6xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No applications yet</h3>
                            <p class="text-gray-600 mb-6">No one has applied to this job posting yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
