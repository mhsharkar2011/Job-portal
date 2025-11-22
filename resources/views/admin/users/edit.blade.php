<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit User
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <div class="mb-6">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-4">
                        <li>
                            <a href="{{ route('dashboard') }}"
                                class="text-gray-400 hover:text-gray-500 transition duration-150">
                                <i class="fas fa-home"></i>
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-gray-400 text-xs mx-4"></i>
                                <a href="{{ route('admin.users.index') }}"
                                    class="text-sm font-medium text-gray-500 hover:text-gray-700 transition duration-150">
                                    Users
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-gray-400 text-xs mx-4"></i>
                                <a href="{{ route('admin.users.show', $user) }}"
                                    class="text-sm font-medium text-gray-500 hover:text-gray-700 transition duration-150">
                                    {{ $user->name }}
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-gray-400 text-xs mx-4"></i>
                                <span class="text-sm font-medium text-gray-400">Edit</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Form -->
                <div class="lg:col-span-2">
                    <form action="{{ route('admin.users.update', $user) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    Edit User Information
                                </h3>
                                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                    Update the user's details and permissions.
                                </p>
                            </div>

                            <div class="px-4 py-5 sm:p-6 space-y-6">
                                <!-- Profile Photo Upload -->
                                <div>
                                    <h4 class="text-md font-medium text-gray-900 mb-4">Profile Photo</h4>
                                    <div class="flex items-center space-x-6">
                                        <!-- Current Photo -->
                                        <div class="flex-shrink-0">
                                            <div class="relative">
                                                @if ($user->profile_photo_path)
                                                    <img id="currentPhoto"
                                                        class="h-24 w-24 rounded-full object-cover border-2 border-gray-200"
                                                        src="{{ Storage::url($user->profile_photo_path) }}"
                                                        alt="{{ $user->name }}">
                                                @else
                                                    <div id="currentPhoto"
                                                        class="h-24 w-24 bg-gray-300 rounded-full flex items-center justify-center border-2 border-gray-200">
                                                        <span class="text-gray-600 font-bold text-2xl">
                                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                                        </span>
                                                    </div>
                                                @endif
                                                <!-- Photo Preview -->
                                                <img id="photoPreview"
                                                    class="h-24 w-24 rounded-full object-cover border-2 border-blue-200 hidden"
                                                    alt="Photo preview">
                                            </div>
                                        </div>

                                        <!-- Upload Controls -->
                                        <div class="flex-1">
                                            <div class="space-y-4">
                                                <div>
                                                    <label for="profile_photo"
                                                        class="block text-sm font-medium text-gray-700">
                                                        Upload New Photo
                                                    </label>
                                                    <div class="mt-1 flex items-center">
                                                        <input type="file" name="profile_photo" id="profile_photo"
                                                            accept="image/*" class="hidden"
                                                            onchange="previewPhoto(event)">
                                                        <label for="profile_photo"
                                                            class="cursor-pointer inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                                                            <i class="fas fa-upload mr-2"></i>
                                                            Choose File
                                                        </label>
                                                        <span id="fileName" class="ml-3 text-sm text-gray-500">No file
                                                            chosen</span>
                                                    </div>
                                                    @error('profile_photo')
                                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                    @enderror
                                                    <p class="mt-1 text-xs text-gray-500">
                                                        JPG, PNG, GIF up to 2MB. Recommended: 256x256 pixels.
                                                    </p>
                                                </div>

                                                <!-- Remove Photo Option -->
                                                @if ($user->profile_photo_path)
                                                    <div class="flex items-center">
                                                        <input type="checkbox" name="remove_photo" id="remove_photo"
                                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                                        <label for="remove_photo"
                                                            class="ml-2 block text-sm text-gray-700">
                                                            Remove current photo
                                                        </label>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Basic Information -->
                                <div class="border-t border-gray-200 pt-6">
                                    <h4 class="text-md font-medium text-gray-900 mb-4">Basic Information</h4>
                                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                        <!-- Name -->
                                        <div class="sm:col-span-3">
                                            <label for="name" class="block text-sm font-medium text-gray-700">
                                                Full Name *
                                            </label>
                                            <div class="mt-1">
                                                <input type="text" name="name" id="name"
                                                    value="{{ old('name', $user->name) }}" required
                                                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('name') border-red-300 @enderror">
                                                @error('name')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Email -->
                                        <div class="sm:col-span-3">
                                            <label for="email" class="block text-sm font-medium text-gray-700">
                                                Email Address *
                                            </label>
                                            <div class="mt-1">
                                                <input type="email" name="email" id="email"
                                                    value="{{ old('email', $user->email) }}" required
                                                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('email') border-red-300 @enderror">
                                                @error('email')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Phone -->
                                        <div class="sm:col-span-3">
                                            <label for="phone" class="block text-sm font-medium text-gray-700">
                                                Phone Number
                                            </label>
                                            <div class="mt-1">
                                                <input type="tel" name="phone" id="phone"
                                                    value="{{ old('phone', $user->phone) }}"
                                                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('phone') border-red-300 @enderror">
                                                @error('phone')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Address -->
                                        <div class="sm:col-span-3">
                                            <label for="address" class="block text-sm font-medium text-gray-700">
                                                Address
                                            </label>
                                            <div class="mt-1">
                                                <input type="text" name="address" id="address"
                                                    value="{{ old('address', $user->address) }}"
                                                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('address') border-red-300 @enderror">
                                                @error('address')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Account Settings -->
                                <div class="border-t border-gray-200 pt-6">
                                    <h4 class="text-md font-medium text-gray-900 mb-4">Account Settings</h4>
                                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                        <!-- Role -->
                                        <!-- Roles -->
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Roles</label>
                                            <div class="space-y-2">
                                                @foreach ($roles as $role)
                                                    <label class="flex items-center">
                                                        <input type="checkbox" name="roles[]"
                                                            value="{{ $role->id }}"
                                                            {{ $user->roles->contains($role->id) ? 'checked' : '' }}
                                                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                                        <span
                                                            class="ml-2 text-sm text-gray-700">{{ $role->name }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>

                                        <!-- Status -->
                                        <div class="sm:col-span-3">
                                            <label for="is_active" class="block text-sm font-medium text-gray-700">
                                                Account Status
                                            </label>
                                            <div class="mt-1">
                                                <select name="is_active" id="is_active"
                                                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('is_active') border-red-300 @enderror">
                                                    <option value="1"
                                                        {{ old('is_active', $user->is_active) ? 'selected' : '' }}>
                                                        Active</option>
                                                    <option value="0"
                                                        {{ !old('is_active', $user->is_active) ? 'selected' : '' }}>
                                                        Inactive</option>
                                                </select>
                                                @error('is_active')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Email Verification Status -->
                                        <div class="sm:col-span-6">
                                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                                <div>
                                                    <h5 class="text-sm font-medium text-gray-900">Email Verification
                                                    </h5>
                                                    <p class="text-sm text-gray-500">
                                                        @if ($user->email_verified_at)
                                                            Verified on
                                                            {{ $user->email_verified_at->format('M j, Y') }}
                                                        @else
                                                            Email not verified
                                                        @endif
                                                    </p>
                                                </div>
                                                <div>
                                                    @if ($user->email_verified_at)
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                            <i class="fas fa-check-circle mr-1"></i>
                                                            Verified
                                                        </span>
                                                    @else
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                            <i class="fas fa-exclamation-triangle mr-1"></i>
                                                            Unverified
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Password Reset Section -->
                                <div class="border-t border-gray-200 pt-6">
                                    <h4 class="text-md font-medium text-gray-900 mb-4">Password Management</h4>
                                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-key text-yellow-400"></i>
                                            </div>
                                            <div class="ml-3">
                                                <h5 class="text-sm font-medium text-yellow-800">
                                                    Password Reset
                                                </h5>
                                                <div class="mt-2 text-sm text-yellow-700">
                                                    <p>To reset this user's password, use the "Forgot Password" feature
                                                        on the login page.</p>
                                                    <p class="mt-1">The user will receive an email with password
                                                        reset instructions.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6 border-t border-gray-200">
                                <div class="flex justify-end space-x-3">
                                    <a href="{{ route('admin.users.show', $user) }}"
                                        class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                                        <i class="fas fa-times mr-2"></i>
                                        Cancel
                                    </a>
                                    <button type="submit"
                                        class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                                        <i class="fas fa-save mr-2"></i>
                                        Update User
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- User Summary -->
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                User Summary
                            </h3>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <div class="flex items-center space-x-4 mb-4">
                                @if ($user->profile_photo_path)
                                    <img class="h-16 w-16 rounded-full object-cover"
                                        src="{{ Storage::url($user->profile_photo_path) }}"
                                        alt="{{ $user->name }}">
                                @else
                                    <div class="h-16 w-16 bg-gray-300 rounded-full flex items-center justify-center">
                                        <span class="text-gray-600 font-bold text-xl">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </span>
                                    </div>
                                @endif
                                <div>
                                    <h4 class="text-lg font-medium text-gray-900">{{ $user->name }}</h4>
                                    <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                    <p class="text-xs text-gray-400">ID: {{ $user->id }}</p>
                                </div>
                            </div>

                            <div class="space-y-3 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Role:</span>
                                    <span
                                        class="font-medium capitalize">{{ str_replace('_', ' ', $user->role) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Status:</span>
                                    <span class="font-medium">
                                        @if ($user->is_active)
                                            <span class="text-green-600">Active</span>
                                        @else
                                            <span class="text-red-600">Inactive</span>
                                        @endif
                                    </span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Member Since:</span>
                                    <span class="font-medium">{{ $user->created_at->format('M j, Y') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Last Login:</span>
                                    <span class="font-medium">
                                        {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Quick Actions
                            </h3>
                        </div>
                        <div class="px-4 py-5 sm:p-6 space-y-3">
                            <a href="{{ route('admin.users.show', $user) }}"
                                class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                                <i class="fas fa-eye mr-2"></i>
                                View Profile
                            </a>

                            @if ($user->role === 'employer' && $user->jobs_count > 0)
                                <a href="{{ route('admin.jobs.index') }}?user={{ $user->id }}"
                                    class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                                    <i class="fas fa-briefcase mr-2"></i>
                                    View Jobs ({{ $user->jobs_count }})
                                </a>
                            @endif

                            @if ($user->role === 'job_seeker' && $user->applications_count > 0)
                                <a href="{{ route('admin.applications.index') }}?user={{ $user->id }}"
                                    class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                                    <i class="fas fa-file-alt mr-2"></i>
                                    View Applications ({{ $user->applications_count }})
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Danger Zone -->
                    @if ($user->id !== auth()->id())
                        <div class="bg-white shadow overflow-hidden sm:rounded-lg border border-red-200">
                            <div class="px-4 py-5 sm:px-6 border-b border-red-200 bg-red-50">
                                <h3 class="text-lg leading-6 font-medium text-red-900">
                                    Danger Zone
                                </h3>
                            </div>
                            <div class="px-4 py-5 sm:p-6">
                                <p class="text-sm text-red-600 mb-4">
                                    Permanently delete this user account. This action cannot be undone.
                                </p>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                    onsubmit="return confirm('Are you absolutely sure? This will permanently delete the user and all associated data.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150">
                                        <i class="fas fa-trash mr-2"></i>
                                        Delete User Account
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-yellow-800">
                                        Current User
                                    </h3>
                                    <div class="mt-2 text-sm text-yellow-700">
                                        <p>You are editing your own account. Some actions may be restricted.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function previewPhoto(event) {
                const input = event.target;
                const fileName = document.getElementById('fileName');
                const currentPhoto = document.getElementById('currentPhoto');
                const photoPreview = document.getElementById('photoPreview');

                if (input.files && input.files[0]) {
                    const file = input.files[0];
                    fileName.textContent = file.name;

                    // Validate file type
                    const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
                    if (!validTypes.includes(file.type)) {
                        alert('Please select a valid image file (JPEG, PNG, GIF).');
                        input.value = '';
                        fileName.textContent = 'No file chosen';
                        return;
                    }

                    // Validate file size (2MB)
                    if (file.size > 2 * 1024 * 1024) {
                        alert('File size must be less than 2MB.');
                        input.value = '';
                        fileName.textContent = 'No file chosen';
                        return;
                    }

                    const reader = new FileReader();

                    reader.onload = function(e) {
                        // Show preview and hide current photo
                        photoPreview.src = e.target.result;
                        photoPreview.classList.remove('hidden');
                        currentPhoto.classList.add('hidden');
                    };

                    reader.readAsDataURL(file);
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                // Handle remove photo checkbox
                const removePhotoCheckbox = document.getElementById('remove_photo');
                const photoInput = document.getElementById('profile_photo');
                const currentPhoto = document.getElementById('currentPhoto');
                const photoPreview = document.getElementById('photoPreview');

                if (removePhotoCheckbox) {
                    removePhotoCheckbox.addEventListener('change', function() {
                        if (this.checked) {
                            photoInput.disabled = true;
                            photoPreview.classList.add('hidden');
                            currentPhoto.classList.add('hidden');
                        } else {
                            photoInput.disabled = false;
                            currentPhoto.classList.remove('hidden');
                        }
                    });
                }

                // Add real-time validation or other interactive features
                const emailInput = document.getElementById('email');
                const nameInput = document.getElementById('name');

                if (emailInput) {
                    emailInput.addEventListener('blur', function() {
                        if (this.value && !this.value.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
                            this.classList.add('border-red-300');
                        } else {
                            this.classList.remove('border-red-300');
                        }
                    });
                }

                // Show confirmation before leaving page if form has changes
                let formChanged = false;
                const form = document.querySelector('form');
                const initialFormData = new FormData(form);

                form.addEventListener('change', function() {
                    formChanged = true;
                });

                form.addEventListener('submit', function() {
                    formChanged = false;
                });

                window.addEventListener('beforeunload', function(e) {
                    if (formChanged) {
                        e.preventDefault();
                        e.returnValue = 'You have unsaved changes. Are you sure you want to leave?';
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
