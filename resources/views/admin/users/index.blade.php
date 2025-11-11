<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            User Management
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                <i class="fas fa-users text-white text-lg"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Total Users</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $users->total() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <i class="fas fa-briefcase text-white text-lg"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Employers</p>
                                <p class="text-2xl font-semibold text-gray-900">
                                    {{ $users->where('role', 'employer')->count() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                                <i class="fas fa-user-graduate text-white text-lg"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Job Seekers</p>
                                <p class="text-2xl font-semibold text-gray-900">
                                    {{ $users->where('role', 'job_seeker')->count() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                                <i class="fas fa-user-shield text-white text-lg"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Admins</p>
                                <p class="text-2xl font-semibold text-gray-900">
                                    {{ $users->where('role', 'admin')->count() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters and Search -->
            <div class="bg-white shadow-sm rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('admin.users.index') }}">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <!-- Search Input -->
                            <div>
                                <label for="search"
                                    class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                                <input type="text" name="search" id="search" value="{{ request('search') }}"
                                    placeholder="Search by name or email..."
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <!-- Role Filter -->
                            <div>
                                <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                                <select name="role" id="role"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">All Roles</option>
                                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin
                                    </option>
                                    <option value="employer" {{ request('role') == 'employer' ? 'selected' : '' }}>
                                        Employer</option>
                                    <option value="job_seeker" {{ request('role') == 'job_seeker' ? 'selected' : '' }}>
                                        Job Seeker</option>
                                </select>
                            </div>

                            <!-- Status Filter -->
                            <div>
                                <label for="status"
                                    class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <select name="status" id="status"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">All Status</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>
                                        Inactive</option>
                                </select>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-end space-x-2">
                                <button type="submit"
                                    class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200">
                                    <i class="fas fa-filter mr-2"></i>Filter
                                </button>
                                <a href="{{ route('admin.users.index') }}"
                                    class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition duration-200">
                                    <i class="fas fa-redo mr-2"></i>Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Users Table -->
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900">Users List</h3>
                        <div class="text-sm text-gray-500">
                            Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }}
                            results
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    User
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Role
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Stats
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Registered
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($users as $user)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                @if ($user->profile_photo_path)
                                                    <img class="h-10 w-10 rounded-full object-cover"
                                                        src="{{ Storage::url($user->profile_photo_path) }}"
                                                        alt="{{ $user->name }}">
                                                @else
                                                    <div
                                                        class="h-10 w-10 bg-gray-300 rounded-full flex items-center justify-center">
                                                        <span class="text-gray-600 font-medium text-sm">
                                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $user->name }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $user->email }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $roleColors = [
                                                'admin' => 'bg-purple-100 text-purple-800',
                                                'employer' => 'bg-green-100 text-green-800',
                                                'job_seeker' => 'bg-blue-100 text-blue-800',
                                            ];
                                            $colorClass = $roleColors[$user->role] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span
                                            class="px-2 py-1 text-xs font-medium rounded-full {{ $colorClass }} capitalize">
                                            {{ str_replace('_', ' ', $user->role) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div class="space-y-1">
                                            @if ($user->role === 'employer')
                                                <div class="flex items-center">
                                                    <i class="fas fa-briefcase text-gray-400 mr-2 text-xs"></i>
                                                    <span>{{ $user->jobs_count }} jobs posted</span>
                                                </div>
                                            @elseif($user->role === 'job_seeker')
                                                <div class="flex items-center">
                                                    <i class="fas fa-file-alt text-gray-400 mr-2 text-xs"></i>
                                                    <span>{{ $user->applications_count }} applications</span>
                                                </div>
                                            @else
                                                <div class="text-gray-400 text-xs">System Administrator</div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($user->is_active)
                                            <span
                                                class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                                Active
                                            </span>
                                        @else
                                            <span
                                                class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">
                                                Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div class="flex flex-col">
                                            <span>{{ $user->created_at->format('M j, Y') }}</span>
                                            <span
                                                class="text-xs text-gray-400">{{ $user->created_at->diffForHumans() }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <a href="{{ route('admin.users.show', $user) }}"
                                                class="text-blue-600 hover:text-blue-900 transition duration-150"
                                                title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.users.edit', $user) }}"
                                                class="text-green-600 hover:text-green-900 transition duration-150"
                                                title="Edit User">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @if ($user->id !== auth()->id())
                                                <form action="{{ route('admin.users.destroy', $user) }}"
                                                    method="POST" class="inline"
                                                    onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-600 hover:text-red-900 transition duration-150"
                                                        title="Delete User">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-gray-400 cursor-not-allowed"
                                                    title="Cannot delete your own account">
                                                    <i class="fas fa-trash"></i>
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <i class="fas fa-users text-gray-300 text-4xl mb-4"></i>
                                            <h3 class="text-lg font-medium text-gray-900 mb-2">No users found</h3>
                                            <p class="text-gray-500 mb-4">No users match your current filters.</p>
                                            <a href="{{ route('admin.users.index') }}"
                                                class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200">
                                                Clear Filters
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($users->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .pagination {
                display: flex;
                justify-content: center;
                list-style: none;
                padding: 0;
                margin: 0;
            }

            .pagination li {
                margin: 0 2px;
            }

            .pagination li a,
            .pagination li span {
                display: block;
                padding: 8px 12px;
                border: 1px solid #d1d5db;
                border-radius: 6px;
                text-decoration: none;
                color: #374151;
                transition: all 0.2s;
            }

            .pagination li a:hover {
                background-color: #f3f4f6;
            }

            .pagination li.active span {
                background-color: #3b82f6;
                color: white;
                border-color: #3b82f6;
            }

            .pagination li.disabled span {
                color: #9ca3af;
                background-color: #f9fafb;
                border-color: #d1d5db;
            }
        </style>
    @endpush
</x-app-layout>
