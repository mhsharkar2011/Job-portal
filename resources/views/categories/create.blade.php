@extends('layouts.app')

@section('title', 'Create Category - ' . config('app.name'))

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Create New Category</h1>
            <p class="text-gray-600">Add a new job category to organize your job listings</p>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf

                <div class="space-y-6">
                    <!-- Basic Information -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 mb-4 pb-2 border-b">Basic Information</h2>

                        <!-- Category Name -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Category Name *</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                                   placeholder="e.g., Software Development"
                                   required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea id="description" name="description" rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror"
                                      placeholder="Brief description of this category...">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Appearance -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 mb-4 pb-2 border-b">Appearance</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Icon -->
                            <div>
                                <label for="icon" class="block text-sm font-medium text-gray-700 mb-2">Icon</label>
                                <input type="text" id="icon" name="icon" value="{{ old('icon') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('icon') border-red-500 @enderror"
                                       placeholder="fa-solid fa-code">
                                <p class="mt-1 text-sm text-gray-500">
                                    Font Awesome class (e.g., fa-solid fa-code)
                                </p>
                                @error('icon')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror

                                <!-- Icon Preview -->
                                <div class="mt-3 p-3 bg-gray-50 rounded-lg">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Icon Preview</label>
                                    <div class="flex items-center space-x-4">
                                        <div id="iconPreview" class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center text-white">
                                            <i class="fa-solid fa-folder"></i>
                                        </div>
                                        <div class="text-sm text-gray-600">
                                            <p>This is how the icon will appear</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Color -->
                            <div>
                                <label for="color" class="block text-sm font-medium text-gray-700 mb-2">Color</label>
                                <div class="flex items-center space-x-3">
                                    <input type="color" id="color" name="color" value="{{ old('color', '#3B82F6') }}"
                                           class="w-16 h-10 border border-gray-300 rounded-md cursor-pointer @error('color') border-red-500 @enderror">
                                    <input type="text" id="colorText" value="{{ old('color', '#3B82F6') }}"
                                           class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                           placeholder="#3B82F6" readonly>
                                </div>
                                <p class="mt-1 text-sm text-gray-500">
                                    Choose a color for this category
                                </p>
                                @error('color')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Settings -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 mb-4 pb-2 border-b">Settings</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Sort Order -->
                            <div>
                                <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">Sort Order</label>
                                <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('sort_order') border-red-500 @enderror"
                                       min="0" max="999">
                                <p class="mt-1 text-sm text-gray-500">
                                    Lower numbers appear first
                                </p>
                                @error('sort_order')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                <div class="space-y-2">
                                    <div class="flex items-center">
                                        <input type="checkbox" id="is_active" name="is_active" value="1"
                                               {{ old('is_active', true) ? 'checked' : '' }}
                                               class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        <label for="is_active" class="ml-2 block text-sm text-gray-900">
                                            Active (visible to users)
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-8 flex justify-end space-x-4">
                    <a href="{{ route('categories.index') }}"
                       class="px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-md hover:bg-gray-50 transition-colors duration-200">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition-colors duration-200">
                        Create Category
                    </button>
                </div>
            </form>
        </div>

        <!-- Help Section -->
        <div class="mt-6 bg-blue-50 rounded-lg p-6">
            <h3 class="text-lg font-medium text-blue-800 mb-3">Category Tips</h3>
            <div class="space-y-2 text-sm text-blue-700">
                <p><strong>Naming:</strong> Use clear, descriptive names that job seekers will understand.</p>
                <p><strong>Icons:</strong> Use Font Awesome icons (e.g., "fa-solid fa-code" for development).</p>
                <p><strong>Colors:</strong> Choose distinct colors to help differentiate categories.</p>
                <p><strong>Sort Order:</strong> Use sort order to prioritize important categories.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Icon preview update
    const iconInput = document.getElementById('icon');
    const iconPreview = document.getElementById('iconPreview');

    iconInput.addEventListener('input', function() {
        const iconClass = this.value.trim();
        if (iconClass) {
            iconPreview.innerHTML = `<i class="${iconClass}"></i>`;
        } else {
            iconPreview.innerHTML = '<i class="fa-solid fa-folder"></i>';
        }
    });

    // Color picker sync
    const colorPicker = document.getElementById('color');
    const colorText = document.getElementById('colorText');

    colorPicker.addEventListener('input', function() {
        colorText.value = this.value;
        iconPreview.style.backgroundColor = this.value;
    });

    colorText.addEventListener('input', function() {
        const color = this.value;
        if (/^#[0-9A-F]{6}$/i.test(color)) {
            colorPicker.value = color;
            iconPreview.style.backgroundColor = color;
        }
    });

    // Update icon preview color initially
    iconPreview.style.backgroundColor = colorPicker.value;
});
</script>
@endpush
