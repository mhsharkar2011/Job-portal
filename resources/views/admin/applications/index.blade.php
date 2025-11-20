<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="md:flex md:items-center md:justify-between mb-8">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                        Applications Management
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">
                        Manage all job applications across the platform
                    </p>
                </div>
            </div>

            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-100 rounded-md p-3">
                                <i class="fa-solid fa-file-lines text-blue-600 text-xl"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total</dt>
                                    <dd class="text-lg font-semibold text-gray-900">{{ $stats['total'] ?? 0 }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-100 rounded-md p-3">
                                <i class="fa-solid fa-clock text-yellow-600 text-xl"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Pending</dt>
                                    <dd class="text-lg font-semibold text-gray-900">{{ $stats['pending'] ?? 0 }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-100 rounded-md p-3">
                                <i class="fa-solid fa-eye text-blue-600 text-xl"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Reviewed</dt>
                                    <dd class="text-lg font-semibold text-gray-900">{{ $stats['reviewed'] ?? 0 }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-100 rounded-md p-3">
                                <i class="fa-solid fa-check text-green-600 text-xl"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Accepted</dt>
                                    <dd class="text-lg font-semibold text-gray-900">{{ $stats['accepted'] ?? 0 }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-red-100 rounded-md p-3">
                                <i class="fa-solid fa-times text-red-600 text-xl"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Rejected</dt>
                                    <dd class="text-lg font-semibold text-gray-900">{{ $stats['rejected'] ?? 0 }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Filters</h3>
                </div>
                <div class="p-6">
                    <form method="GET" action="{{ route('admin.applications.index') }}">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                                <input type="text" name="search" id="search" value="{{ request('search') }}"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Search by name, email, skills...">
                            </div>
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select name="status" id="status"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">All Statuses</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                        Pending</option>
                                    <option value="reviewed" {{ request('status') == 'reviewed' ? 'selected' : '' }}>
                                        Reviewed</option>
                                    <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>
                                        Accepted</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>
                                        Rejected</option>
                                </select>
                            </div>
                            <div>
                                <label for="date_from" class="block text-sm font-medium text-gray-700">From Date</label>
                                <input type="date" name="date_from" id="date_from"
                                    value="{{ request('date_from') }}"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label for="date_to" class="block text-sm font-medium text-gray-700">To Date</label>
                                <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                        <div class="mt-4 flex space-x-3">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <i class="fa-solid fa-filter mr-2"></i>
                                Apply Filters
                            </button>
                            <a href="{{ route('admin.applications.index') }}"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <i class="fa-solid fa-refresh mr-2"></i>
                                Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Applications List -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Applications ({{ $applications->total() }})
                    </h3>
                </div>

                @if ($applications->count() > 0)
                    <ul class="divide-y divide-gray-200">
                        @foreach ($applications as $application)
                            <li class="px-4 py-4 sm:px-6 hover:bg-gray-50">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h4 class="text-sm font-semibold text-gray-900 truncate">
                                                    {{ $application->user->name ?? 'N/A' }}
                                                </h4>
                                                <p class="text-sm text-gray-500 mt-1">
                                                    {{ $application->user->email }} • {{ $application->user->phone }}
                                                </p>
                                                <div class="mt-2 flex items-center space-x-4">
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                        @if ($application->status === 'pending') bg-yellow-100 text-yellow-800
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
                                            <div class="ml-4 flex-shrink-0">
                                                <p class="text-sm font-medium text-gray-900">
                                                    {{ $application->job->job_title }}
                                                </p>
                                                <div class="flex items-center space-x-3">
                                                    <!-- Company Logo -->
                                                    @if ($application->job->company->logo)
                                                        <img src="{{ asset('storage/' . $application->job->company->logo) }}"
                                                            alt="{{ $application->job->company->name }} Logo"
                                                            class="w-10 h-10 rounded-lg object-cover border border-gray-200">
                                                    @else
                                                        <div
                                                            class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 text-sm font-semibold">
                                                            {{ substr($application->job->company->name, 0, 1) }}
                                                        </div>
                                                    @endif

                                                    <!-- Company Info -->
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-900">
                                                            {{ $application->job->company->name }}</p>
                                                        <p class="text-xs text-gray-500">
                                                            {{ $application->job->company->category->name ?? 'N/A' }}</p>
                                                    </div>
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
                                        <a href="{{ route('admin.applications.download', $application) }}"
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
                        <p class="text-gray-400 text-sm mt-1">No applications match your current filters</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
