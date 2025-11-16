<x-app-layout>
    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="p-6 md:p-8">
                    <!-- Header -->
                    <div class="mb-8">
                        <h2 class="text-3xl font-bold text-gray-900">Assign Role to User</h2>
                        <p class="text-gray-600 mt-2">Assign or change user roles in bulk</p>
                    </div>

                    <!-- Display Success/Error Messages -->
                    @if (session('success'))
                        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Display Validation Errors -->
                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Quick Stats -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <div class="text-blue-900 font-semibold">Total Users</div>
                            <div class="text-2xl font-bold text-blue-700">{{ $users->count() }}</div>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg">
                            <div class="text-green-900 font-semibold">Available Roles</div>
                            <div class="text-2xl font-bold text-green-700">{{ $roles->count() }}</div>
                        </div>
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <div class="text-purple-900 font-semibold">Active Roles</div>
                            <div class="text-2xl font-bold text-purple-700">{{ $roles->where('is_active', true)->count() }}</div>
                        </div>
                    </div>

                    <!-- Assign Role Form -->
                    <form action="{{ route('admin.users.assign-role') }}" method="POST">
                        @csrf

                        <!-- User Selection -->
                        <div class="mb-6">
                            <label for="user_id" class="block mb-3 text-lg font-medium text-gray-700">
                                Select User <span class="text-red-500">*</span>
                            </label>
                            <select name="user_id" id="user_id" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-base">
                                <option value="">Choose a User</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}"
                                            data-current-roles="{{ $user->current_roles }}"
                                            {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                        <span class="text-gray-500">({{ $user->email }})</span>
                                        - {{ $user->current_roles }}
                                    </option>
                                @endforeach
                            </select>
                            <div id="current-roles-display" class="mt-2 p-3 bg-gray-50 rounded-lg hidden">
                                <strong>Current Roles:</strong> <span id="roles-text"></span>
                            </div>
                        </div>

                        <!-- Role Selection -->
                        <div class="mb-6">
                            <label for="role_id" class="block mb-3 text-lg font-medium text-gray-700">
                                Select Role <span class="text-red-500">*</span>
                            </label>
                            <select name="role_id" id="role_id" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-base">
                                <option value="">Choose a Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}"
                                            {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                        <span class="text-gray-500">({{ $role->users_count }} users)</span>
                                        @if(!$role->is_active)
                                            <span class="text-red-500"> - INACTIVE</span>
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-sm text-gray-500 mt-2">
                                Inactive roles can still be assigned but may not grant full permissions.
                            </p>
                        </div>

                        <!-- Action Type -->
                        <div class="mb-6">
                            <label class="block mb-3 text-lg font-medium text-gray-700">
                                Assignment Type
                            </label>
                            <div class="space-y-3">
                                <label class="flex items-center">
                                    <input type="radio" name="assignment_type" value="assign" checked
                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="ml-3 text-gray-700">
                                        <strong>Assign Role</strong> - Add this role to user's existing roles
                                    </span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="assignment_type" value="replace"
                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="ml-3 text-gray-700">
                                        <strong>Replace Roles</strong> - Remove all existing roles and assign only this role
                                    </span>
                                </label>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                            <button type="submit"
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition-colors duration-200 flex items-center justify-center text-base">
                                <i class="fa-solid fa-user-plus mr-2"></i>
                                Assign Role to User
                            </button>
                            <a href="{{ route('admin.roles.index') }}"
                                class="flex-1 border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium py-3 px-6 rounded-lg transition-colors duration-200 text-center text-base">
                                <i class="fa-solid fa-arrow-left mr-2"></i>
                                Back to Roles
                            </a>
                        </div>
                    </form>

                    <!-- Quick Links -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <a href="{{ route('admin.users.index') }}"
                               class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 text-center">
                                <i class="fa-solid fa-users text-blue-600 text-xl mb-2"></i>
                                <div class="font-medium text-gray-900">Manage Users</div>
                                <div class="text-sm text-gray-500">View all users</div>
                            </a>
                            <a href="{{ route('admin.roles.create') }}"
                               class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 text-center">
                                <i class="fa-solid fa-plus text-green-600 text-xl mb-2"></i>
                                <div class="font-medium text-gray-900">Create New Role</div>
                                <div class="text-sm text-gray-500">Add custom roles</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userSelect = document.getElementById('user_id');
            const rolesDisplay = document.getElementById('current-roles-display');
            const rolesText = document.getElementById('roles-text');

            userSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const currentRoles = selectedOption.getAttribute('data-current-roles');

                if (currentRoles && this.value !== '') {
                    rolesText.textContent = currentRoles;
                    rolesDisplay.classList.remove('hidden');
                } else {
                    rolesDisplay.classList.add('hidden');
                }
            });

            // Trigger change on page load if there's a selected value
            if (userSelect.value) {
                userSelect.dispatchEvent(new Event('change'));
            }
        });
    </script>
    @endpush
</x-app-layout>
