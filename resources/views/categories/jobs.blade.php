<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="p-6">
                    <!-- Header -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">Jobs in {{ $category->name }}</h2>
                                <p class="text-gray-600 mt-2">Browse all job postings in this category</p>
                            </div>
                            <a href="{{ route('categories.index') }}"
                               class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200">
                                <i class="fa-solid fa-arrow-left mr-2"></i>
                                Back to Categories
                            </a>
                        </div>
                    </div>

                    <!-- Jobs Count -->
                    <div class="mb-6">
                        <p class="text-lg text-gray-700">
                            <span class="font-semibold">{{ $jobs->total() }}</span>
                            job(s) found in this category
                        </p>
                    </div>

                    <!-- Jobs Table -->
                    <div class="relative overflow-x-auto shadow-md rounded-lg">
                        <table class="w-full text-sm text-left text-gray-700">
                            <thead class="text-sm text-gray-800 uppercase bg-gray-50 border-b">
                                <tr>
                                    <th scope="col" class="px-6 py-4 font-semibold">#</th>
                                    <th scope="col" class="px-6 py-4 font-semibold">Company Name</th>
                                    <th scope="col" class="px-6 py-4 font-semibold">Job Title</th>
                                    <th scope="col" class="px-6 py-4 font-semibold">Applicants</th>
                                    <th scope="col" class="px-6 py-4 font-semibold">Date Posted</th>
                                    <th scope="col" class="px-6 py-4 font-semibold text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $count = 1; ?>
                                @foreach ($jobs as $job)
                                    <tr class="bg-white border-b hover:bg-gray-50 transition-colors duration-200">
                                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                            {{ $count++ }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center space-x-3">
                                                @if ($job->logo)
                                                    <img src="{{ asset('storage/' . $job->logo) }}"
                                                        alt="{{ $job->company_name }} logo"
                                                        class="w-8 h-8 rounded-full object-cover">
                                                @else
                                                    <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                                                        <span class="text-xs font-medium text-gray-500">
                                                            {{ substr($job->company_name, 0, 1) }}
                                                        </span>
                                                    </div>
                                                @endif
                                                <span class="font-medium text-gray-900">{{ $job->company_name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="font-medium text-gray-900">{{ $job->job_title }}</span>
                                            <p class="text-xs text-gray-500 mt-1 line-clamp-1">
                                                {{ Str::limit($job->job_description, 50) }}
                                            </p>
                                        </td>
                                        <td class="px-6 py-4">
                                            <a href="{{ route('jobs.applicants', $job) }}"
                                                class="flex items-center space-x-2 text-blue-600 hover:text-blue-900 transition-colors duration-200">
                                                <span class="inline-flex items-center justify-center w-8 h-8 bg-blue-100 text-blue-800 text-sm font-medium rounded-full">
                                                    {{ $job->applications_count }}
                                                </span>
                                                <span class="text-sm">View Applicants</span>
                                            </a>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex flex-col">
                                                <span class="text-sm font-medium text-gray-900">
                                                    {{ $job->created_at->format('M d, Y') }}
                                                </span>
                                                <span class="text-xs text-gray-500">
                                                    {{ $job->created_at->format('h:i A') }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center justify-center space-x-3">
                                                <!-- View Button -->
                                                <a href="{{ route('jobs.show', $job->id) }}"
                                                    class="text-blue-600 hover:text-blue-900 transition-colors duration-200"
                                                    title="View Job">
                                                    <i class="fa-solid fa-eye text-sm"></i>
                                                </a>

                                                <!-- View Applicants Button -->
                                                <a href="{{ route('jobs.applicants', $job->id) }}"
                                                    class="text-green-600 hover:text-green-900 transition-colors duration-200"
                                                    title="View Applicants">
                                                    <i class="fa-solid fa-users text-sm"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Empty State -->
                    @if ($jobs->isEmpty())
                        <div class="text-center py-12">
                            <div class="text-gray-400 mb-4">
                                <i class="fa-solid fa-briefcase text-6xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No jobs in this category</h3>
                            <p class="text-gray-600 mb-6">There are currently no job postings in this category.</p>
                            <a href="{{ route('jobs.create') }}"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                                <i class="fa-solid fa-plus mr-2"></i>
                                Post a Job
                            </a>
                        </div>
                    @endif

                    <!-- Pagination -->
                    @if($jobs->hasPages())
                        <div class="mt-6">
                            {{ $jobs->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
