<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-9xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <div class="flex-1">
                        <h1 class="text-3xl lg:text-4xl font-bold text-gray-900">Find Your Dream Job</h1>
                        <p class="text-gray-600 mt-2 text-lg">Discover opportunities that match your skills and
                            aspirations</p>

                        <!-- Quick Stats -->
                        <div class="flex flex-wrap gap-4 mt-4">
                            <div class="bg-blue-50 px-4 py-2 rounded-lg border border-blue-100">
                                <span class="text-blue-800 font-semibold">{{ $jobs->total() }} Jobs Available</span>
                            </div>
                            @if ($featuredJobsCount > 0)
                                <div class="bg-yellow-50 px-4 py-2 rounded-lg border border-yellow-100">
                                    <span class="text-yellow-800 font-semibold">{{ $featuredJobsCount }} Featured
                                        Jobs</span>
                                </div>
                            @endif
                            @if ($remoteJobsCount > 0)
                                <div class="bg-green-50 px-4 py-2 rounded-lg border border-green-100">
                                    <span class="text-green-800 font-semibold">{{ $remoteJobsCount }} Remote Jobs</span>
                                </div>
                            @endif
                            @auth
                                <div class="bg-purple-50 px-4 py-2 rounded-lg border border-purple-100">
                                    <span class="text-purple-800 font-semibold">Welcome, {{ auth()->user()->name }}!</span>
                                </div>
                            @endauth
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="flex items-center gap-3 mt-4 lg:mt-0">
                        <!-- Sort Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                class="flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-lg bg-white hover:bg-gray-50 transition-colors">
                                <i class="fa-solid fa-sort text-gray-600"></i>
                                <span class="text-sm font-medium text-gray-700">Sort</span>
                                <i class="fa-solid fa-chevron-down text-xs text-gray-400"></i>
                            </button>
                            <div x-show="open" @click.away="open = false"
                                class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-10">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}"
                                    class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 {{ request('sort') == 'newest' ? 'bg-blue-50 text-blue-700' : '' }}">
                                    <i class="fa-solid fa-clock w-4"></i>
                                    <span>Newest First</span>
                                </a>
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'salary_high']) }}"
                                    class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 {{ request('sort') == 'salary_high' ? 'bg-blue-50 text-blue-700' : '' }}">
                                    <i class="fa-solid fa-money-bill-wave w-4"></i>
                                    <span>Salary: High to Low</span>
                                </a>
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'salary_low']) }}"
                                    class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 {{ request('sort') == 'salary_low' ? 'bg-blue-50 text-blue-700' : '' }}">
                                    <i class="fa-solid fa-money-bill-1-wave w-4"></i>
                                    <span>Salary: Low to High</span>
                                </a>
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'deadline']) }}"
                                    class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 {{ request('sort') == 'deadline' ? 'bg-blue-50 text-blue-700' : '' }}">
                                    <i class="fa-solid fa-hourglass-end w-4"></i>
                                    <span>Application Deadline</span>
                                </a>
                            </div>
                        </div>

                        <!-- View Toggle -->
                        <div class="flex border border-gray-300 rounded-lg bg-white overflow-hidden">
                            <button id="gridView" class="p-2 border-r border-gray-300 bg-blue-50 text-blue-600">
                                <i class="fa-solid fa-grid-2"></i>
                            </button>
                            <button id="listView" class="p-2 text-gray-600 hover:text-blue-600">
                                <i class="fa-solid fa-list"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Active Filters -->
                @if (request()->anyFilled(['search', 'location', 'category_id', 'employment_type', 'salary_range', 'remote_ok']))
                    <div class="mt-4 p-4 bg-white rounded-lg border border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-medium text-gray-700">Active Filters:</span>
                                <div class="flex flex-wrap gap-2">
                                    @if (request('search'))
                                        <span
                                            class="inline-flex items-center gap-1 bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                                            Search: "{{ request('search') }}"
                                            <button onclick="removeFilter('search')" class="hover:text-blue-600">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </span>
                                    @endif
                                    @if (request('location'))
                                        <span
                                            class="inline-flex items-center gap-1 bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">
                                            Location: {{ request('location') }}
                                            <button onclick="removeFilter('location')" class="hover:text-green-600">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </span>
                                    @endif
                                    @if (request('category_id') && $categories->find(request('category_id')))
                                        <span
                                            class="inline-flex items-center gap-1 bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm">
                                            Category: {{ $categories->find(request('category_id'))->name }}
                                            <button onclick="removeFilter('category_id')" class="hover:text-purple-600">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </span>
                                    @endif
                                    @if (request('employment_type'))
                                        @foreach (request('employment_type') as $type)
                                            <span
                                                class="inline-flex items-center gap-1 bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-sm">
                                                {{ ucfirst($type) }}
                                                <button
                                                    onclick="removeArrayFilter('employment_type', '{{ $type }}')"
                                                    class="hover:text-orange-600">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </button>
                                            </span>
                                        @endforeach
                                    @endif
                                    @if (request('remote_ok'))
                                        <span
                                            class="inline-flex items-center gap-1 bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm">
                                            Remote Only
                                            <button onclick="removeFilter('remote_ok')" class="hover:text-teal-600">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <a href="{{ route('jobs.browse') }}"
                                class="text-sm text-red-600 hover:text-red-700 font-medium">
                                Clear All
                            </a>
                        </div>
                    </div>
                @endif
            </div>
            <!-- Featured Jobs Banner -->
            @if ($featuredJobs->count() > 0)
                <div class="mb-8">
                    <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-2xl font-bold mb-2">🌟 Featured Opportunities</h2>
                                <p class="text-blue-100">Top companies are hiring now</p>
                            </div>
                            <div class="hidden lg:block">
                                <i class="fa-solid fa-star text-4xl text-yellow-300"></i>
                            </div>
                        </div>

                        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($featuredJobs as $featuredJob)
                                <div
                                    class="bg-white bg-opacity-10 backdrop-blur-sm rounded-xl p-4 border border-white border-opacity-20">
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="flex items-center gap-3">
                                            @if ($featuredJob->company && $featuredJob->company->logo)
                                                <img src="{{ $featuredJob->company->logo_url }}"
                                                    alt="{{ $featuredJob->company->name }}"
                                                    class="w-10 h-10 rounded-lg object-cover">
                                            @else
                                                <div
                                                    class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                                                    <i class="fa-solid fa-building text-white"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <h3 class="font-semibold text-white">{{ $featuredJob->job_title }}</h3>
                                                <p class="text-blue-100 text-sm">
                                                    {{ $featuredJob->company->name ?? 'Company' }}
                                                </p>
                                            </div>
                                        </div>
                                        <span
                                            class="bg-yellow-400 text-blue-900 px-2 py-1 rounded-full text-xs font-bold">
                                            Featured
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-4 text-sm text-blue-100 mb-3">
                                        <span class="flex items-center gap-1">
                                            <i class="fa-solid fa-location-dot"></i>
                                            {{ $featuredJob->location }}
                                        </span>
                                        @if ($featuredJob->salary_minimum)
                                            <span class="flex items-center gap-1">
                                                <i class="fa-solid fa-money-bill-wave"></i>
                                                ${{ number_format($featuredJob->salary_minimum) }}+
                                            </span>
                                        @endif
                                    </div>
                                    <a href="{{ route('jobs.show', $featuredJob) }}"
                                        class="w-full bg-white text-blue-600 hover:bg-blue-50 py-2 px-4 rounded-lg font-semibold text-sm text-center block transition-colors">
                                        View Job
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Main Content -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Main Jobs Grid -->
                <div class="lg:col-span-3">
                    <!-- Jobs Grid/List View -->
                    <div id="jobsContainer" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-2 gap-6">
                        @foreach ($jobs as $job)
                            @include('jobs.partials.job-card', ['job' => $job])
                        @endforeach
                    </div>

                    <!-- Empty State -->
                    @if ($jobs->count() === 0)
                        <div class="text-center py-16 bg-white rounded-2xl border border-gray-200">
                            <div class="text-gray-300 mb-4">
                                <i class="fa-solid fa-briefcase text-8xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">No jobs found</h3>
                            <p class="text-gray-600 mb-6 max-w-md mx-auto">
                                @if (request()->anyFilled(['search', 'location', 'category_id']))
                                    Try adjusting your filters or search terms to see more results.
                                @else
                                    There are currently no job openings. Check back later for new opportunities.
                                @endif
                            </p>
                            @if (request()->anyFilled(['search', 'location', 'category_id']))
                                <a href="{{ route('jobs.browse') }}"
                                    class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-colors">
                                    <i class="fa-solid fa-refresh"></i>
                                    Clear Filters
                                </a>
                            @endif
                        </div>
                    @endif

                    <!-- Pagination -->
                    @if ($jobs->hasPages())
                        <div class="mt-12 bg-white rounded-2xl border border-gray-200 p-6">
                            <div class="flex items-center justify-between">
                                <div class="text-sm text-gray-600">
                                    Showing {{ $jobs->firstItem() ?? 0 }} to {{ $jobs->lastItem() ?? 0 }} of
                                    {{ $jobs->total() }} results
                                </div>
                                <div class="flex gap-2">
                                    {{ $jobs->links() }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right Sidebar -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Quick Apply Widget -->
                    <div class="bg-white rounded-2xl border border-gray-200 p-6">
                        <h3 class="font-semibold text-gray-900 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-bolt text-yellow-500"></i>
                            Quick Apply
                        </h3>
                        <p class="text-sm text-gray-600 mb-4">Upload your resume and apply faster to multiple jobs</p>
                        @auth
                            @if (auth()->user()->role === 'job_seeker')
                                <a href="{{ route('resumes.edit', Auth::id()) }}"
                                    class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white py-3 px-4 rounded-lg font-semibold text-sm text-center block transition-all shadow-sm hover:shadow-md">
                                    Update Resume
                                </a>
                            @else
                                <button
                                    class="w-full bg-gray-100 text-gray-500 py-3 px-4 rounded-lg font-semibold text-sm cursor-not-allowed">
                                    Employer Account
                                </button>
                            @endif
                        @else
                            <div class="space-y-3">
                                <a href="{{ route('register') }}"
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-lg font-semibold text-sm text-center block transition-colors">
                                    Create Account
                                </a>
                                <a href="{{ route('login') }}"
                                    class="w-full border border-gray-300 text-gray-700 hover:bg-gray-50 py-3 px-4 rounded-lg font-semibold text-sm text-center block transition-colors">
                                    Sign In
                                </a>
                            </div>
                        @endauth
                    </div>

                    <!-- Job Alerts -->
                    <div class="bg-white rounded-2xl border border-gray-200 p-6">
                        <h3 class="font-semibold text-gray-900 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-bell text-blue-500"></i>
                            Job Alerts
                        </h3>
                        <p class="text-sm text-gray-600 mb-4">Get notified when new jobs match your criteria</p>
                        <form class="space-y-3">
                            <input type="email" placeholder="Your email"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg font-semibold text-sm transition-colors">
                                Create Alert
                            </button>
                        </form>
                    </div>

                    <!-- Popular Categories -->
                    <div class="bg-white rounded-2xl border border-gray-200 p-6">
                        <h3 class="font-semibold text-gray-900 mb-4">Popular Categories</h3>
                        <div class="space-y-2">
                            @foreach ($popularCategories as $category)
                                <a href="{{ route('jobs.browse', ['category_id' => $category->id]) }}"
                                    class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition-colors group">
                                    <span
                                        class="text-sm text-gray-700 group-hover:text-blue-600">{{ $category->name }}</span>
                                    <span
                                        class="bg-blue-100 text-blue-600 text-xs px-2 py-1 rounded-full">{{ $category->jobs_count }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // View Toggle
            const gridView = document.getElementById('gridView');
            const listView = document.getElementById('listView');
            const jobsContainer = document.getElementById('jobsContainer');

            gridView.addEventListener('click', () => {
                jobsContainer.className = 'grid grid-cols-1 md:grid-cols-2 xl:grid-cols-2 gap-6';
                gridView.className = 'p-2 border-r border-gray-300 bg-blue-50 text-blue-600';
                listView.className = 'p-2 text-gray-600 hover:text-blue-600';
            });

            listView.addEventListener('click', () => {
                jobsContainer.className = 'grid grid-cols-1 gap-6';
                listView.className = 'p-2 border-r border-gray-300 bg-blue-50 text-blue-600';
                gridView.className = 'p-2 text-gray-600 hover:text-blue-600';
            });

            // Filter Management
            function removeFilter(filterName) {
                const url = new URL(window.location.href);
                url.searchParams.delete(filterName);
                window.location.href = url.toString();
            }

            function removeArrayFilter(filterName, value) {
                const url = new URL(window.location.href);
                const values = url.searchParams.getAll(filterName + '[]');
                const newValues = values.filter(v => v !== value);

                url.searchParams.delete(filterName + '[]');
                newValues.forEach(v => url.searchParams.append(filterName + '[]', v));

                window.location.href = url.toString();
            }

            // Quick Apply Functionality
            function quickApply(jobId) {
                if (!{{ auth()->check() ? 'true' : 'false' }}) {
                    window.location.href = '{{ route('login') }}';
                    return;
                }

                // Show loading state
                const applyBtn = document.querySelector(`[data-job-id="${jobId}"] .apply-button`);
                const originalContent = applyBtn.innerHTML;
                applyBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i>Applying...';
                applyBtn.disabled = true;


                fetch(`/jobs/${jobId}/quick-apply`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update UI
                            const applyBtn = document.querySelector(`[data-job-id="${jobId}"] .apply-button`);
                            if (applyBtn) {
                                applyBtn.innerHTML = '<i class="fa-solid fa-check mr-2"></i>Applied';
                                applyBtn.className =
                                    'apply-button flex items-center gap-2 px-6 py-3 bg-green-100 text-green-700 rounded-xl font-semibold text-sm cursor-not-allowed w-full justify-center transition-colors';
                                applyBtn.onclick = null;

                                applyBtn.disabled = true;
                                showNotification('Application submitted successfully!', 'success');
                            }
                        } else {
                            applyBtn.innerHTML = originalContent;
                            applyBtn.disabled = false;
                            showNotification(data.message || 'Error applying to job', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        applyBtn.innerHTML = originalContent;
                        applyBtn.disabled = false;
                        showNotification('Error applying to job', 'error');
                    });
            }

            function showNotification(message, type) {
                // Implement notification system
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 ${
                type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
            }`;
                notification.textContent = message;
                document.body.appendChild(notification);

                setTimeout(() => {
                    notification.remove();
                }, 3000);
            }

            // Save Job Functionality
            function saveJob(jobId) {
                if (!{{ auth()->check() ? 'true' : 'false' }}) {
                    window.location.href = '{{ route('login') }}';
                    return;
                }

                const saveBtn = document.querySelector(`[data-job-id="${jobId}"] .save-button`);
                const originalIcon = saveBtn.innerHTML;

                fetch(`/jobs/${jobId}/save`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showNotification('Job saved successfully!', 'success');
                            // Update save button
                            const saveBtn = document.querySelector(`[data-job-id="${jobId}"] .save-button`);
                            if (saveBtn) {
                                saveBtn.innerHTML = '<i class="fa-solid fa-bookmark text-blue-500"></i>';
                                saveBtn.title = 'Saved';
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('Error saving job', 'error');
                    });
            }
        </script>
    @endpush

    @push('styles')
        <style>
            .job-card {
                transition: all 0.3s ease;
            }

            .job-card:hover {
                transform: translateY(-4px);
            }

            .featured-job {
                border-left: 4px solid #f59e0b;
            }

            .urgent-job {
                border-left: 4px solid #ef4444;
            }
        </style>
    @endpush
</x-app-layout>
