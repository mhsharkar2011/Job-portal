<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="md:flex md:items-center md:justify-between mb-8">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                        {{ $role->name }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">
                        Role Details & User Assignments
                    </p>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4 space-x-3">
                    <a href="{{ route('admin.roles.edit', $role) }}"
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fa-solid fa-pencil mr-2"></i>
                        Edit Role
                    </a>
                    <a href="{{ route('admin.roles.index') }}"
                       class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fa-solid fa-arrow-left mr-2"></i>
                        Back to Roles
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Role Details -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Basic Information -->
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Role Information
                            </h3>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Role Name</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $role->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Slug</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $role->slug }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Description</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $role->description ?? 'No description' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                                    <dd class="mt-1">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($role->is_active) bg-green-100 text-green-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ $role->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Default Role</dt>
                                    <dd class="mt-1">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($role->is_default) bg-blue-100 text-blue-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ $role->is_default ? 'Yes' : 'No' }}
                                        </span>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Users Count</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $role->users_count }} users</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Created</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $role->created_at->format('M d, Y') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $role->updated_at->format('M d, Y') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Permissions -->
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Permissions ({{ count($role->permissions ?? []) }})
                            </h3>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            @if($role->permissions && count($role->permissions) > 0)
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                    @foreach($role->permissions as $permission)
                                        <div class="flex items-center">
                                            <i class="fa-solid fa-check text-green-500 mr-2"></i>
                                            <span class="text-sm text-gray-700">
                                                {{ $availablePermissions[$permission] ?? $permission }}
                                                @if($permission === '*')
                                                    <span class="text-xs text-red-600 font-medium ml-1">(All Permissions)</span>
                                                @endif
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500 text-sm">No specific permissions assigned.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Quick Actions -->
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Quick Actions
                            </h3>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <div class="space-y-3">
                                <a href="{{ route('admin.roles.edit', $role) }}"
                                   class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <i class="fa-solid fa-pencil mr-2"></i>
                                    Edit Role
                                </a>

                                @if(!in_array($role->slug, ['admin', 'employer', 'job-seeker']) && $role->users_count === 0)
                                <form action="{{ route('admin.roles.destroy', $role) }}" method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this role? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        <i class="fa-solid fa-trash mr-2"></i>
                                        Delete Role
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Role Statistics -->
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Statistics
                            </h3>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <dl class="space-y-3">
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Total Users</dt>
                                    <dd class="text-sm text-gray-900">{{ $role->users_count }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Permissions</dt>
                                    <dd class="text-sm text-gray-900">{{ count($role->permissions ?? []) }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Role Type</dt>
                                    <dd class="text-sm text-gray-900">
                                        @if($role->is_default)
                                            <span class="text-green-600">Default</span>
                                        @else
                                            <span class="text-blue-600">Custom</span>
                                        @endif
                                    </dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                                    <dd class="text-sm text-gray-900">
                                        @if($role->is_active)
                                            <span class="text-green-600">Active</span>
                                        @else
                                            <span class="text-red-600">Inactive</span>
                                        @endif
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Users with this Role -->
            <div class="mt-8 bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Users with this Role ({{ $role->users_count }})
                    </h3>
                </div>
                @if($role->users_count > 0)
                    <ul class="divide-y divide-gray-200">
                        @foreach($role->users as $user)
                            <li class="px-4 py-4 sm:px-6 hover:bg-gray-50">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            @if($user->profile_photo_path)
                                                <img class="h-10 w-10 rounded-full" src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="">
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                    <span class="text-gray-600 font-medium">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                            <div class="text-xs text-gray-400 mt-1">
                                                Member since {{ $user->created_at->format('M d, Y') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        @if($user->jobs_count > 0)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $user->jobs_count }} jobs
                                            </span>
                                        @endif
                                        @if($user->applications_count > 0)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 ml-2">
                                                {{ $user->applications_count }} applications
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="px-4 py-8 text-center">
                        <i class="fa-solid fa-users text-gray-300 text-4xl mb-3"></i>
                        <p class="text-gray-500">No users assigned to this role yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
