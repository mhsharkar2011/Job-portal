<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="md:flex md:items-center md:justify-between mb-8">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                        Role Management
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">
                        Manage user roles and permissions across the system
                    </p>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4 space-x-3">
                    <a href="{{ route('admin.roles.create') }}"
                       class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fa-solid fa-plus mr-2"></i>
                        Create Role
                    </a>
                    <a href="{{ route('admin.roles.reports') }}"
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fa-solid fa-chart-bar mr-2"></i>
                        View Reports
                    </a>
                </div>
            </div>

            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-100 rounded-md p-3">
                                <i class="fa-solid fa-shield-alt text-blue-600 text-xl"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Roles</dt>
                                    <dd class="text-lg font-semibold text-gray-900">{{ $roles->total() }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-100 rounded-md p-3">
                                <i class="fa-solid fa-users text-green-600 text-xl"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Users</dt>
                                    <dd class="text-lg font-semibold text-gray-900">{{ $totalUsers }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-purple-100 rounded-md p-3">
                                <i class="fa-solid fa-key text-purple-600 text-xl"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Active Roles</dt>
                                    <dd class="text-lg font-semibold text-gray-900">{{ $roles->where('is_active', true)->count() }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-orange-100 rounded-md p-3">
                                <i class="fa-solid fa-star text-orange-600 text-xl"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Default Roles</dt>
                                    <dd class="text-lg font-semibold text-gray-900">{{ $roles->where('is_default', true)->count() }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Roles List -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        All Roles ({{ $roles->total() }})
                    </h3>
                </div>

                @if($roles->count() > 0)
                    <ul class="divide-y divide-gray-200">
                        @foreach($roles as $role)
                            <li class="px-4 py-4 sm:px-6 hover:bg-gray-50">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between">
                                            <div class="flex-1">
                                                <h4 class="text-lg font-semibold text-gray-900 truncate">
                                                    {{ $role->name }}
                                                    <span class="ml-2 text-sm font-normal text-gray-500">({{ $role->slug }})</span>
                                                </h4>
                                                <p class="text-sm text-gray-600 mt-1">
                                                    {{ $role->description }}
                                                </p>
                                                <div class="mt-3 flex items-center space-x-4">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                        @if($role->is_default) bg-green-100 text-green-800
                                                        @else bg-gray-100 text-gray-800 @endif">
                                                        {{ $role->is_default ? 'Default Role' : 'Custom Role' }}
                                                    </span>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                        @if($role->is_active) bg-blue-100 text-blue-800
                                                        @else bg-red-100 text-red-800 @endif">
                                                        {{ $role->is_active ? 'Active' : 'Inactive' }}
                                                    </span>
                                                    <span class="text-sm text-gray-500">
                                                        <i class="fa-solid fa-users mr-1"></i>
                                                        {{ $role->users_count }} users
                                                    </span>
                                                    <span class="text-sm text-gray-500">
                                                        <i class="fa-solid fa-key mr-1"></i>
                                                        {{ count($role->permissions ?? []) }} permissions
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ml-4 flex-shrink-0 flex space-x-2">
                                        <a href="{{ route('admin.roles.show', $role) }}"
                                           class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded text-blue-700 bg-blue-100 hover:bg-blue-200">
                                            <i class="fa-solid fa-eye mr-1"></i>
                                            View
                                        </a>
                                        <a href="{{ route('admin.roles.edit', $role) }}"
                                           class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded text-gray-700 bg-white hover:bg-gray-50">
                                            <i class="fa-solid fa-pencil mr-1"></i>
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.roles.destroy', $role) }}" method="POST"
                                              onsubmit="return confirm('Are you sure you want to delete this role? This action cannot be undone.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded text-red-700 bg-white hover:bg-red-50
                                                           {{ in_array($role->slug, ['admin', 'employer', 'job-seeker']) || $role->users_count > 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                                    {{ in_array($role->slug, ['admin', 'employer', 'job-seeker']) || $role->users_count > 0 ? 'disabled' : '' }}>
                                                <i class="fa-solid fa-trash mr-1"></i>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>

                    <!-- Pagination -->
                    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                        {{ $roles->links() }}
                    </div>
                @else
                    <div class="px-4 py-12 text-center">
                        <i class="fa-solid fa-shield-alt text-gray-300 text-5xl mb-4"></i>
                        <p class="text-gray-500 text-lg font-medium">No roles found</p>
                        <p class="text-gray-400 text-sm mt-1">Create your first role to get started</p>
                        <a href="{{ route('admin.roles.create') }}"
                           class="mt-4 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                            <i class="fa-solid fa-plus mr-2"></i>
                            Create Role
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
