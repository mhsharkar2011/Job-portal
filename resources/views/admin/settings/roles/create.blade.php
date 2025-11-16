<x-app-layout>
    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="p-6 md:p-8">
                    <!-- Header -->
                    <div class="mb-8">
                        <h3 class="text-3xl font-bold text-gray-900">Create New Role</h3>
                        <p class="text-gray-600 mt-2">Define a new role with specific permissions</p>
                    </div>

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

                    <form action="{{ route('admin.roles.store') }}" method="POST">
                        @csrf

                        <!-- Basic Information -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-700">
                                    Role Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="name" id="name"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    value="{{ old('name') }}" placeholder="e.g., Content Manager" required>
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="slug" class="block mb-2 text-sm font-medium text-gray-700">
                                    Role Slug <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="slug" id="slug"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    value="{{ old('slug') }}" placeholder="e.g., content-manager" required>
                                <p class="text-sm text-gray-500 mt-1">Unique identifier for the role (lowercase, hyphens)</p>
                                @error('slug')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-6">
                            <label for="description" class="block mb-2 text-sm font-medium text-gray-700">
                                Description
                            </label>
                            <textarea name="description" id="description" rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Describe the purpose and capabilities of this role...">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Permissions -->
                        <div class="mb-6">
                            <label class="block mb-4 text-sm font-medium text-gray-700">
                                Permissions <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($permissions as $permission => $label)
                                    <div class="flex items-center">
                                        <input type="checkbox" name="permissions[]" id="permission-{{ $permission }}"
                                            value="{{ $permission }}"
                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                            {{ old('permissions') && in_array($permission, old('permissions')) ? 'checked' : '' }}>
                                        <label for="permission-{{ $permission }}" class="ml-3 text-sm text-gray-700">
                                            {{ $label }}
                                            @if($permission === '*')
                                                <span class="text-xs text-red-600 font-medium">(Super Admin)</span>
                                            @endif
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('permissions')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Settings -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="is_default" value="1"
                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                        {{ old('is_default') ? 'checked' : '' }}>
                                    <span class="ml-3 text-sm text-gray-700">Set as default role for new users</span>
                                </label>
                                <p class="text-sm text-gray-500 mt-1">New users will automatically get this role</p>
                            </div>

                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="is_active" value="1"
                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                        {{ old('is_active', true) ? 'checked' : '' }}>
                                    <span class="ml-3 text-sm text-gray-700">Active</span>
                                </label>
                                <p class="text-sm text-gray-500 mt-1">Inactive roles cannot be assigned to users</p>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                            <button type="submit"
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition-colors duration-200 flex items-center justify-center">
                                <i class="fa-solid fa-save mr-2"></i>
                                Create Role
                            </button>
                            <a href="{{ route('admin.roles.index') }}"
                                class="flex-1 border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium py-3 px-6 rounded-lg transition-colors duration-200 text-center">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
