<nav x-data="{ mobileMenuOpen: false }" class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-40">
    <div class="max-w-9xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Left: Logo and Main Navigation -->
            <div class="flex items-center space-x-8">
                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                        <i class="fa-solid fa-briefcase text-white text-sm"></i>
                    </div>
                    <span class="text-xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors">
                        JobPortal
                    </span>
                </a>

                <!-- Primary Navigation -->
                <div class="hidden lg:flex items-center space-x-1">

                     <a href="{{ route('categories.index') }}"
                       class="px-4 py-2 text-sm font-medium rounded-lg transition-all
                              {{ request()->is('categories*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                        <i class="fa-solid fa-tags mr-2"></i>
                        Categories
                    </a>
                    <a href="{{ route('companies.index') }}"
                       class="px-4 py-2 text-sm font-medium rounded-lg transition-all
                              {{ request()->is('companies*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                        <i class="fa-solid fa-building mr-2"></i>
                        Companies
                    </a>

                     <a href="{{ route('jobs.create') }}"
                       class="px-4 py-2 text-sm font-medium rounded-lg transition-all
                              {{ request()->is('auth/jobs/create') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                        <i class="fa-solid fa-plus mr-2"></i>
                        Post Job
                    </a>
                </div>
            </div>

            <!-- Right: User Actions -->
            <div class="flex items-center space-x-3">
                <!-- Quick Actions -->
                <div class="hidden md:flex items-center space-x-2">
                    <!-- Post Job Button -->

                    <div class="hidden lg:flex items-center space-x-1">
                    <a href="{{ route('jobs.index') }}"
                       class="px-4 py-2 text-sm font-medium rounded-lg transition-all
                              {{ request()->is('jobs*') || (request()->is('jobs') && !request()->is('jobs/*/edit') && !request()->is('jobs/create')) ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                        <i class="fa-solid fa-magnifying-glass mr-2"></i>
                        Browse Jobs
                    </a>
                    </div>


                    <!-- My Resume -->
                    <a href="{{ route('resumes.edit', Auth::id()) }}"
                       class="inline-flex items-center px-3 py-2 text-gray-600 hover:text-blue-600 text-sm font-medium rounded-lg transition-all hover:bg-gray-100">
                        <i class="fa-solid fa-file-lines mr-2"></i>
                        Resume
                    </a>

                    <!-- Mobile Filter Toggle (Hidden on desktop) -->
                    <button id="mobileNavFilterToggle"
                            class="lg:hidden flex items-center space-x-2 px-3 py-2 text-gray-600 hover:text-blue-600 hover:bg-gray-100 rounded-lg transition-all">
                        <i class="fa-solid fa-sliders"></i>
                        <span class="text-sm font-medium">Filters</span>
                        <span class="bg-blue-100 text-blue-600 text-xs rounded-full px-2 py-1">
                            {{ $totalJobs ?? '0' }}
                        </span>
                    </button>
                </div>

                <!-- User Menu -->
                <div class="relative" x-data="{ userMenuOpen: false }">
                    <button @click="userMenuOpen = !userMenuOpen"
                            class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-100 transition-all focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white text-sm font-semibold shadow-sm">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="hidden lg:block text-left">
                            <div class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-gray-500">Account</div>
                        </div>
                        <i class="fa-solid fa-chevron-down text-xs text-gray-400 transition-transform"
                           :class="{ 'rotate-180': userMenuOpen }"></i>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="userMenuOpen"
                         @click.away="userMenuOpen = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-lg border border-gray-200 py-2 z-50 overflow-hidden">

                        <!-- User Info -->
                        <div class="px-4 py-3 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-blue-100">
                            <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                            <p class="text-sm text-gray-600 truncate">{{ Auth::user()->email }}</p>
                        </div>

                        <!-- Menu Items -->
                        <div class="py-2">
                            <a href="{{ route('jobs.createdJob') }}"
                               class="flex items-center space-x-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-all group">
                                <i class="fa-solid fa-briefcase w-4 text-gray-400 group-hover:text-blue-600"></i>
                                <span>My Job Posts</span>
                            </a>
                            <a href="{{ route('jobs.appliedJob') }}"
                               class="flex items-center space-x-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-all group">
                                <i class="fa-solid fa-file-circle-check w-4 text-gray-400 group-hover:text-blue-600"></i>
                                <span>Applications</span>
                            </a>
                            <a href="{{ route('companies.index') }}"
                               class="flex items-center space-x-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-all group">
                                <i class="fa-solid fa-building w-4 text-gray-400 group-hover:text-blue-600"></i>
                                <span>My Companies</span>
                            </a>
                        </div>

                        <!-- Settings -->
                        <div class="border-t border-gray-100 pt-2">
                            <a href="{{ route('profile.edit') }}"
                               class="flex items-center space-x-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-all group">
                                <i class="fa-solid fa-user-edit w-4 text-gray-400 group-hover:text-blue-600"></i>
                                <span>Edit Profile</span>
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                        class="flex items-center space-x-3 w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-all group">
                                    <i class="fa-solid fa-right-from-bracket w-4"></i>
                                    <span>Sign Out</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Mobile menu and filter buttons -->
                <div class="flex items-center space-x-1 lg:hidden">
                    <!-- Mobile Filter Toggle -->
                    <button id="mobileNavFilterToggle"
                            class="flex items-center space-x-1 p-2 text-gray-600 hover:text-blue-600 hover:bg-gray-100 rounded-lg transition-all">
                        <i class="fa-solid fa-sliders"></i>
                        <span class="bg-blue-100 text-blue-600 text-xs rounded-full w-5 h-5 flex items-center justify-center ml-1">
                            {{ $totalJobs ?? '0' }}
                        </span>
                    </button>

                    <!-- Mobile menu button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen"
                            class="flex items-center justify-center w-10 h-10 text-gray-600 hover:text-blue-600 hover:bg-gray-100 rounded-lg transition-all">
                        <i class="fa-solid fa-bars" x-show="!mobileMenuOpen"></i>
                        <i class="fa-solid fa-xmark" x-show="mobileMenuOpen"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div x-show="mobileMenuOpen"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-75"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="lg:hidden border-t border-gray-200 bg-white py-3 space-y-1 shadow-lg">
            <a href="{{ route('jobs.index') }}"
               class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-700 rounded-lg transition-all"
               @click="mobileMenuOpen = false">
                <i class="fa-solid fa-magnifying-glass w-5"></i>
                <span class="font-medium">Browse Jobs</span>
            </a>
            <a href="{{ route('companies.index') }}"
               class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-700 rounded-lg transition-all"
               @click="mobileMenuOpen = false">
                <i class="fa-solid fa-building w-5"></i>
                <span class="font-medium">Companies</span>
            </a>
            <a href="{{ route('categories.browse') }}"
               class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-700 rounded-lg transition-all"
               @click="mobileMenuOpen = false">
                <i class="fa-solid fa-tags w-5"></i>
                <span class="font-medium">Categories</span>
            </a>

            <!-- Quick Actions -->
            <div class="border-t border-gray-200 pt-2">
                <a href="{{ route('jobs.create') }}"
                   class="flex items-center space-x-3 px-4 py-3 text-green-700 hover:bg-green-50 rounded-lg transition-all"
                   @click="mobileMenuOpen = false">
                    <i class="fa-solid fa-plus w-5"></i>
                    <span class="font-medium">Post a Job</span>
                </a>
                <a href="{{ route('resumes.edit', Auth::id()) }}"
                   class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-700 rounded-lg transition-all"
                   @click="mobileMenuOpen = false">
                    <i class="fa-solid fa-file-lines w-5"></i>
                    <span class="font-medium">My Resume</span>
                </a>
                <a href="{{ route('jobs.createdJob') }}"
                   class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-700 rounded-lg transition-all"
                   @click="mobileMenuOpen = false">
                    <i class="fa-solid fa-briefcase w-5"></i>
                    <span class="font-medium">My Job Posts</span>
                </a>
                <a href="{{ route('jobs.appliedJob') }}"
                   class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-700 rounded-lg transition-all"
                   @click="mobileMenuOpen = false">
                    <i class="fa-solid fa-file-circle-check w-5"></i>
                    <span class="font-medium">Applied Jobs</span>
                </a>
            </div>

            <!-- User Section -->
            <div class="border-t border-gray-200 pt-2">
                <a href="{{ route('profile.edit') }}"
                   class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-700 rounded-lg transition-all"
                   @click="mobileMenuOpen = false">
                    <i class="fa-solid fa-user-edit w-5"></i>
                    <span class="font-medium">Edit Profile</span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="flex items-center space-x-3 w-full px-4 py-3 text-red-600 hover:bg-red-50 rounded-lg transition-all text-left"
                            @click="mobileMenuOpen = false">
                        <i class="fa-solid fa-right-from-bracket w-5"></i>
                        <span class="font-medium">Sign Out</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mobile filter toggle functionality
    const mobileFilterButtons = document.querySelectorAll('#mobileNavFilterToggle');

    mobileFilterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');

            if (sidebar && backdrop) {
                // Open sidebar
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
                document.body.style.overflow = 'hidden';

                // Close mobile menu if open
                const mobileMenu = document.querySelector('[x-data]');
                if (mobileMenu && mobileMenu.__x) {
                    mobileMenu.__x.$data.mobileMenuOpen = false;
                }
            }
        });
    });

    // Close mobile menu when clicking on filter items
    document.querySelectorAll('#jobSearchForm input, #jobSearchForm select, #jobSearchForm button').forEach(element => {
        element.addEventListener('click', function() {
            const mobileMenu = document.querySelector('[x-data]');
            if (mobileMenu && mobileMenu.__x && window.innerWidth < 1024) {
                mobileMenu.__x.$data.mobileMenuOpen = false;
            }
        });
    });
});
</script>
