<!-- Sidebar Backdrop -->
<div id="sidebarBackdrop" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden transition-opacity duration-300"></div>

<!-- Sidebar -->
<aside id="sidebar"
       class="fixed lg:sticky top-0 left-0 lg:left-auto z-50 w-80 bg-white border-r border-gray-200 h-screen lg:h-[calc(100vh-4rem)] transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out overflow-y-auto scrollbar-hide">

    <!-- Mobile Header -->
    <div class="lg:hidden flex items-center justify-between p-4 border-b border-gray-200 bg-white">
        <div>
            <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fa-solid fa-sliders mr-2 text-blue-600"></i>
                Filter Jobs
            </h2>
            <p class="text-sm text-gray-600 mt-1">Find your perfect match</p>
        </div>
        <button id="closeSidebar" class="p-2 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100 transition-colors">
            <i class="fa-solid fa-xmark text-xl"></i>
        </button>
    </div>

    <div class="p-6">
        <!-- Desktop Header (Hidden on mobile) -->
        <div class="mb-6 hidden lg:block">
            <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fa-solid fa-sliders mr-2 text-blue-600"></i>
                Filter Jobs
            </h2>
            <p class="text-sm text-gray-600 mt-1">Find your perfect match</p>
        </div>

        <!-- Search Form -->
        <form id="jobSearchForm" action="{{ route('jobs.index') }}" method="GET" class="space-y-6">
            <!-- Keyword Search -->
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">What</label>
                <div class="relative">
                    <input type="text"
                           id="search"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Job title, keywords..."
                           class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm lg:text-base">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
            </div>

            <!-- Location -->
            <div>
                <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Where</label>
                <div class="relative">
                    <input type="text"
                           id="location"
                           name="location"
                           value="{{ request('location') }}"
                           placeholder="City, state, or remote"
                           class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm lg:text-base">
                    <i class="fa-solid fa-location-dot absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
            </div>

            <!-- Category -->
            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                <select id="category_id"
                        name="category_id"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all bg-white text-sm lg:text-base">
                    <option value="">All Categories</option>
                    @foreach($categories ?? [] as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }} ({{ $category->jobs_count }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Employment Type -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">Job Type</label>
                <div class="space-y-2">
                    @foreach(['full-time', 'part-time', 'contract', 'freelance', 'internship'] as $type)
                        <label class="flex items-center group cursor-pointer">
                            <input type="checkbox"
                                   name="employment_type[]"
                                   value="{{ $type }}"
                                   {{ in_array($type, request('employment_type', [])) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 transition-all group-hover:border-blue-400 w-4 h-4">
                            <span class="ml-3 text-sm text-gray-700 group-hover:text-gray-900 capitalize">
                                {{ str_replace('-', ' ', $type) }}
                            </span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Salary Range -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">Salary Range</label>
                <div class="space-y-2">
                    @foreach([
                        ['value' => '0-50000', 'label' => '$0 - $50k'],
                        ['value' => '50000-100000', 'label' => '$50k - $100k'],
                        ['value' => '100000-150000', 'label' => '$100k - $150k'],
                        ['value' => '150000+', 'label' => '$150k+']
                    ] as $range)
                        <label class="flex items-center group cursor-pointer">
                            <input type="radio"
                                   name="salary_range"
                                   value="{{ $range['value'] }}"
                                   {{ request('salary_range') == $range['value'] ? 'checked' : '' }}
                                   class="text-blue-600 focus:ring-blue-500 transition-all group-hover:border-blue-400">
                            <span class="ml-3 text-sm text-gray-700 group-hover:text-gray-900">
                                {{ $range['label'] }}
                            </span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Remote Work -->
            <div class="flex items-center">
                <input type="checkbox"
                       id="remote_ok"
                       name="remote_ok"
                       value="1"
                       {{ request('remote_ok') ? 'checked' : '' }}
                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 transition-all w-4 h-4">
                <label for="remote_ok" class="ml-3 text-sm text-gray-700 cursor-pointer">
                    Remote jobs only
                </label>
            </div>

            <!-- Action Buttons -->
            <div class="flex space-x-3 pt-4">
                <button type="submit"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-lg font-medium transition-all shadow-sm hover:shadow-md text-sm lg:text-base">
                    Apply Filters
                </button>
                <a href="{{ route('jobs.index') }}"
                   class="inline-flex items-center px-4 py-3 border border-gray-300 text-gray-700 hover:bg-gray-50 rounded-lg font-medium transition-all text-sm lg:text-base">
                    Clear
                </a>
            </div>

            <!-- Mobile Apply Button (Sticky at bottom) -->
            <div class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 p-4 shadow-lg">
                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-lg font-medium transition-all shadow-sm hover:shadow-md text-base">
                    Show Results ({{ $totalJobs ?? '0' }} jobs)
                </button>
            </div>
        </form>

        <!-- Quick Stats -->
        <div class="mt-8 pt-6 border-t border-gray-200 lg:block hidden">
            <h3 class="text-sm font-medium text-gray-700 mb-3">Job Market</h3>
            <div class="grid grid-cols-2 gap-4 text-center">
                <div class="bg-blue-50 rounded-lg p-3">
                    <div class="text-lg font-semibold text-blue-700">{{ $totalJobs ?? '0' }}</div>
                    <div class="text-xs text-blue-600">Total Jobs</div>
                </div>
                <div class="bg-green-50 rounded-lg p-3">
                    <div class="text-lg font-semibold text-green-700">{{ $remoteJobs ?? '0' }}</div>
                    <div class="text-xs text-green-600">Remote</div>
                </div>
            </div>
        </div>
    </div>
</aside>

<!-- Mobile Filter Toggle Button -->
<div class="lg:hidden fixed bottom-6 right-6 z-40">
    <button id="mobileFilterToggle"
            class="w-14 h-14 bg-blue-600 hover:bg-blue-700 text-white rounded-full shadow-lg flex items-center justify-center transition-all hover:shadow-xl transform hover:scale-105">
        <i class="fa-solid fa-sliders text-xl"></i>
        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-6 h-6 flex items-center justify-center shadow-sm">
            {{ $totalJobs ?? '0' }}
        </span>
    </button>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const sidebarBackdrop = document.getElementById('sidebarBackdrop');
    const mobileFilterToggle = document.getElementById('mobileFilterToggle');
    const closeSidebar = document.getElementById('closeSidebar');
    const jobSearchForm = document.getElementById('jobSearchForm');

    // Toggle sidebar
    function openSidebar() {
        sidebar.classList.remove('-translate-x-full');
        sidebarBackdrop.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebarFunc() {
        sidebar.classList.add('-translate-x-full');
        sidebarBackdrop.classList.add('hidden');
        document.body.style.overflow = '';
    }

    // Event listeners
    if (mobileFilterToggle) {
        mobileFilterToggle.addEventListener('click', openSidebar);
    }

    if (closeSidebar) {
        closeSidebar.addEventListener('click', closeSidebarFunc);
    }

    if (sidebarBackdrop) {
        sidebarBackdrop.addEventListener('click', closeSidebarFunc);
    }

    // Close sidebar on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeSidebarFunc();
        }
    });

    // Auto-close sidebar on form submit (mobile)
    if (jobSearchForm) {
        jobSearchForm.addEventListener('submit', function() {
            if (window.innerWidth < 1024) {
                setTimeout(closeSidebarFunc, 300);
            }
        });
    }

    // Close sidebar when clicking on internal links (mobile)
    document.querySelectorAll('#jobSearchForm a').forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth < 1024) {
                closeSidebarFunc();
            }
        });
    });

    // Auto-submit on some filter changes (desktop)
    if (window.innerWidth >= 1024) {
        document.querySelectorAll('#category_id, [name="salary_range"]').forEach(element => {
            element.addEventListener('change', function() {
                jobSearchForm.submit();
            });
        });
    }
});

// Update mobile filter badge count
function updateFilterBadge(count) {
    const badge = document.querySelector('#mobileFilterToggle span');
    if (badge) {
        badge.textContent = count;
    }
}
</script>

<style>
/* Smooth scrolling */
.scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}

/* Ensure proper spacing on mobile */
@media (max-width: 1023px) {
    #sidebar {
        height: 100vh;
        top: 0;
    }

    /* Add padding to form for mobile bottom button */
    #jobSearchForm {
        padding-bottom: 80px;
    }
}

/* Improve touch targets on mobile */
@media (max-width: 768px) {
    input, select, button {
        font-size: 16px; /* Prevents zoom on iOS */
    }

    .checkbox-lg {
        width: 20px;
        height: 20px;
    }
}
</style>
