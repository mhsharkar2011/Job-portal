<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50/30 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="mb-12 text-center">
                <div class="relative inline-block">
                    <h1 class="text-4xl font-bold text-gray-900 mb-4">Jobs Management</h1>
                    <div class="absolute -bottom-2 left-0 right-0 h-1 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full"></div>
                </div>
                <p class="text-xl text-gray-600 mt-6 max-w-2xl mx-auto">
                    Manage and monitor all job postings across your platform with ease
                </p>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <!-- Total Jobs -->
                <div class="group bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 p-6 hover:shadow-xl hover:scale-105 transition-all duration-300">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-4 shadow-lg">
                            <i class="fa-solid fa-briefcase text-white text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Total Jobs</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['total'] ?? 0 }}</p>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <div class="flex items-center text-sm text-green-600">
                            <i class="fa-solid fa-arrow-up mr-1"></i>
                            <span>12% increase</span>
                        </div>
                    </div>
                </div>

                <!-- Active Jobs -->
                <div class="group bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 p-6 hover:shadow-xl hover:scale-105 transition-all duration-300">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-4 shadow-lg">
                            <i class="fa-solid fa-check-circle text-white text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Active Jobs</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['active'] ?? 0 }}</p>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <div class="flex items-center text-sm text-green-600">
                            <i class="fa-solid fa-eye mr-1"></i>
                            <span>Live now</span>
                        </div>
                    </div>
                </div>

                <!-- Inactive Jobs -->
                <div class="group bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 p-6 hover:shadow-xl hover:scale-105 transition-all duration-300">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl p-4 shadow-lg">
                            <i class="fa-solid fa-pause-circle text-white text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Inactive Jobs</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['inactive'] ?? 0 }}</p>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <div class="flex items-center text-sm text-orange-600">
                            <i class="fa-solid fa-clock mr-1"></i>
                            <span>Need attention</span>
                        </div>
                    </div>
                </div>

                <!-- Total Applications -->
                <div class="group bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 p-6 hover:shadow-xl hover:scale-105 transition-all duration-300">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-4 shadow-lg">
                            <i class="fa-solid fa-file-lines text-white text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Applications</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['applications'] ?? 0 }}</p>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <div class="flex items-center text-sm text-purple-600">
                            <i class="fa-solid fa-users mr-1"></i>
                            <span>Total candidates</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="grid grid-cols-1 xl:grid-cols-4 gap-8">
                <!-- Filters Sidebar -->
                <div class="xl:col-span-1">
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 p-6 sticky top-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-bold text-gray-900">Filters</h3>
                            <button type="button"
                                    onclick="resetFilters()"
                                    class="text-sm text-gray-500 hover:text-gray-700 transition-colors duration-200 flex items-center">
                                <i class="fa-solid fa-rotate-right mr-1"></i>
                                Reset
                            </button>
                        </div>

                        <form method="GET" action="{{ route('admin.jobs.index') }}" class="space-y-6">
                            <!-- Search -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Search Jobs</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fa-solid fa-search text-gray-400"></i>
                                    </div>
                                    <input type="text"
                                           name="search"
                                           value="{{ request('search') }}"
                                           class="block w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-200"
                                           placeholder="Job title, company...">
                                </div>
                            </div>

                            <!-- Status -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Status</label>
                                <div class="space-y-2">
                                    @foreach(['active', 'inactive', 'draft', 'pending'] as $status)
                                        <label class="flex items-center cursor-pointer group">
                                            <input type="radio" name="status" value="{{ $status }}"
                                                   {{ request('status') == $status ? 'checked' : '' }}
                                                   class="hidden peer">
                                            <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:border-blue-500 peer-checked:bg-blue-500 flex items-center justify-center transition-all duration-200 group-hover:border-blue-400">
                                                <div class="w-2 h-2 bg-white rounded-full peer-checked:block hidden"></div>
                                            </div>
                                            <span class="ml-3 text-sm text-gray-700 capitalize peer-checked:text-blue-600 peer-checked:font-medium transition-colors duration-200">
                                                {{ $status }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Category -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Category</label>
                                <select name="category_id"
                                        class="block w-full py-3 px-4 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-200">
                                    <option value="">All Categories</option>
                                    @foreach($categories ?? [] as $category)
                                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Date Range -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Date Posted</label>
                                <input type="date"
                                       name="date_from"
                                       value="{{ request('date_from') }}"
                                       class="block w-full py-3 px-4 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-200">
                            </div>

                            <button type="submit"
                                    class="w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold py-3 px-4 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                                <i class="fa-solid fa-filter mr-2"></i>
                                Apply Filters
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Jobs List -->
                <div class="xl:col-span-3">
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 overflow-hidden">
                        <!-- Header -->
                        <div class="px-6 py-5 border-b border-gray-100/50 bg-gradient-to-r from-white to-gray-50/50">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900">Job Postings</h3>
                                    <p class="text-sm text-gray-500 mt-1">{{ $jobs->total() }} jobs found</p>
                                </div>
                                <div class="mt-3 sm:mt-0 flex items-center space-x-3">
                                    <span class="text-sm text-gray-500">Sort by:</span>
                                    <select class="text-sm border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm py-2 px-3 transition-colors duration-200">
                                        <option>Newest First</option>
                                        <option>Most Applications</option>
                                        <option>Recently Updated</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Jobs List -->
                        @if($jobs->count() > 0)
                            <div class="divide-y divide-gray-100/50">
                                @foreach($jobs as $job)
                                    <div class="p-6 hover:bg-white/50 transition-all duration-300 group">
                                        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between">
                                            <!-- Job Info with Company Logo -->
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-start space-x-4">
                                                    <!-- Company Logo -->
                                                    <div class="flex-shrink-0">
                                                        @if($job->company && $job->company->logo)
                                                            <img src="{{ asset('storage/' . $job->company->logo) }}"
                                                                 alt="{{ $job->company->name }}"
                                                                 class="w-16 h-16 rounded-2xl object-cover border-2 border-white shadow-lg group-hover:scale-105 transition-transform duration-300">
                                                        @else
                                                            <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform duration-300">
                                                                <i class="fa-solid fa-building text-white text-xl"></i>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <!-- Job Details -->
                                                    <div class="flex-1 min-w-0">
                                                        <div class="flex items-start justify-between">
                                                            <div class="flex-1">
                                                                <h4 class="text-xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors duration-200">
                                                                    {{ $job->title }}
                                                                </h4>
                                                                <p class="text-lg text-gray-600 mt-1 font-medium">
                                                                    {{ $job->company->name ?? 'No Company' }}
                                                                </p>
                                                                <p class="text-sm text-gray-500 mt-1 flex items-center">
                                                                    <i class="fa-solid fa-location-dot mr-2 text-gray-400"></i>
                                                                    {{ $job->location }}
                                                                </p>

                                                                <!-- Meta Information -->
                                                                <div class="flex flex-wrap items-center gap-3 mt-4">
                                                                    <!-- Status Badge -->
                                                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold shadow-sm
                                                                        @if($job->status === 'active') bg-green-100 text-green-800 border border-green-200
                                                                        @elseif($job->status === 'draft') bg-gray-100 text-gray-800 border border-gray-200
                                                                        @elseif($job->status === 'pending') bg-yellow-100 text-yellow-800 border border-yellow-200
                                                                        @elseif($job->status === 'expired') bg-red-100 text-red-800 border border-red-200
                                                                        @else bg-gray-100 text-gray-800 border border-gray-200 @endif">
                                                                        <i class="fa-solid fa-circle mr-1.5 text-xs"></i>
                                                                        {{ ucfirst($job->status) }}
                                                                    </span>

                                                                    <!-- Employment Type -->
                                                                    <span class="inline-flex items-center text-sm text-gray-600 bg-white/50 px-3 py-1.5 rounded-lg border border-gray-200">
                                                                        <i class="fa-solid fa-clock mr-2 text-gray-400"></i>
                                                                        {{ ucfirst(str_replace('-', ' ', $job->employment_type)) }}
                                                                    </span>

                                                                    <!-- Applications -->
                                                                    <span class="inline-flex items-center text-sm text-gray-600 bg-white/50 px-3 py-1.5 rounded-lg border border-gray-200">
                                                                        <i class="fa-solid fa-users mr-2 text-gray-400"></i>
                                                                        {{ $job->applications_count ?? 0 }} applications
                                                                    </span>

                                                                    <!-- Salary -->
                                                                    @if($job->salary_minimum && $job->salary_maximum)
                                                                        <span class="inline-flex items-center text-sm text-gray-600 bg-white/50 px-3 py-1.5 rounded-lg border border-gray-200">
                                                                            <i class="fa-solid fa-money-bill-wave mr-2 text-gray-400"></i>
                                                                            ${{ number_format($job->salary_minimum) }} - ${{ number_format($job->salary_maximum) }}
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Right Side Info & Actions -->
                                            <div class="mt-4 lg:mt-0 lg:ml-6 flex flex-col items-end space-y-3">
                                                <!-- Category & Posted Date -->
                                                <div class="text-right">
                                                    <span class="inline-block px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-sm font-medium border border-blue-200">
                                                        {{ $job->category->name ?? 'No Category' }}
                                                    </span>
                                                    <p class="text-sm text-gray-500 mt-2 flex items-center justify-end">
                                                        <i class="fa-solid fa-calendar mr-2"></i>
                                                        {{ $job->created_at->diffForHumans() }}
                                                    </p>
                                                    <p class="text-sm text-gray-500 mt-1">
                                                        by <span class="font-medium text-gray-700">{{ $job->user->name ?? 'Unknown User' }}</span>
                                                    </p>
                                                </div>

                                                <!-- Action Buttons -->
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('admin.jobs.show', $job) }}"
                                                       class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg hover:from-blue-600 hover:to-blue-700 shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                                                        <i class="fa-solid fa-eye mr-2"></i>
                                                        View Details
                                                    </a>
                                                    <button class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 shadow-sm">
                                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Pagination -->
                            <div class="px-6 py-4 border-t border-gray-100/50 bg-gradient-to-r from-white to-gray-50/50">
                                {{ $jobs->links() }}
                            </div>
                        @else
                            <!-- Empty State -->
                            <div class="text-center py-16">
                                <div class="mx-auto w-32 h-32 bg-gradient-to-br from-gray-100 to-gray-200 rounded-3xl flex items-center justify-center mb-6 shadow-lg">
                                    <i class="fa-solid fa-briefcase text-gray-400 text-5xl"></i>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-3">No jobs found</h3>
                                <p class="text-gray-500 max-w-md mx-auto mb-8 text-lg">
                                    No job postings match your current filters. Try adjusting your search criteria.
                                </p>
                                <a href="{{ route('admin.jobs.index') }}"
                                   class="inline-flex items-center px-8 py-4 text-base font-semibold text-white bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl hover:from-blue-600 hover:to-blue-700 shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                                    <i class="fa-solid fa-refresh mr-3"></i>
                                    Clear all filters
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function resetFilters() {
            document.querySelector('input[name="search"]').value = '';
            document.querySelectorAll('input[name="status"]').forEach(radio => radio.checked = false);
            document.querySelector('select[name="category_id"]').value = '';
            document.querySelector('input[name="date_from"]').value = '';

            window.location.href = "{{ route('admin.jobs.index') }}";
        }

        // Auto-submit form when filters change
        document.addEventListener('DOMContentLoaded', function() {
            const filters = document.querySelectorAll('input[name="status"], select[name="category_id"]');
            filters.forEach(filter => {
                filter.addEventListener('change', function() {
                    this.form.submit();
                });
            });
        });
    </script>
    @endpush

    <style>
        .bg-gradient-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .shadow-glow {
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.1);
        }

        .hover-lift:hover {
            transform: translateY(-2px);
        }
    </style>
</x-app-layout>
