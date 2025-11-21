<div class="flex h-screen bg-gray-50">
    <!-- Simple Sidebar -->
    <div class="w-64 bg-white shadow-md border-r border-gray-200">
        <!-- Logo -->
        <div class="p-6 border-b border-gray-200">
            <h1 class="text-xl font-bold text-gray-800">JobPortal</h1>
        </div>
        @php
            $user = Auth::user();
            $isSeeker = $user->isSeeker();
            $isEmployer = $user->isEmployer();
            $isAdmin = $user->isAdmin();
        @endphp
        <!-- Navigation -->
        <nav class="p-4 space-y-2">
            <a href="{{ route('dashboard') }}"
                class="block py-2 px-4 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded transition {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600' : '' }}">
                Dashboard
            </a>
            @auth
                @if (auth()->user()->isSeeker())
                    <a href="{{ route('jobs.index') }}"
                        class="block py-2 px-4 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded transition {{ request()->is('jobs*') ? 'bg-blue-50 text-blue-600' : '' }}">
                        Browse Jobs
                    </a>
                    <a href="{{ route('seeker.my-applications') }}"
                        class="block py-2 px-4 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded transition {{ request()->is('seeker/applications*') ? 'bg-blue-50 text-blue-600' : '' }}">
                        My Applications
                    </a>
                @elseif($isEmployer || $isAdmin)
                    <a href="{{ route('companies.index') }}"
                        class="block py-2 px-4 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded transition {{ request()->is('companies*') ? 'bg-blue-50 text-blue-600' : '' }}">
                        Companies
                    </a>
                    <a href="{{ route('jobs.index') }}"
                        class="block py-2 px-4 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded transition {{ request()->is('jobs*') ? 'bg-blue-50 text-blue-600' : '' }}">
                        All Jobs
                    </a>
                    <a href="{{ route('jobs.create') }}"
                        class="block py-2 px-4 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded transition {{ request()->is('jobs/create') ? 'bg-blue-50 text-blue-600' : '' }}">
                        Post a Job
                    </a>
                @endif
            @endauth
        </nav>

        <!-- User Info -->
        <div class="absolute bottom-0 w-64 p-4 border-t border-gray-200">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm">
                    {{ strtoupper(substr(Auth::user()?->name, 0, 1)) }}
                </div>
                <span class="text-sm text-gray-700">{{ Auth::user()?->name }}</span>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1">
        <main class="p-6">
            {{ $slot }}
        </main>
    </div>
</div>
