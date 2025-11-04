@extends('layouts.app')

@section('title', 'Edit ' . $company->name . ' - ' . config('app.name'))

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Edit Company</h1>
            <p class="text-gray-600">Update your company profile information</p>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('companies.update', $company) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Basic Information -->
                    <div class="md:col-span-2">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4 pb-2 border-b">Basic Information</h2>
                    </div>

                    <!-- Company Name -->
                    <div class="md:col-span-2">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Company Name *</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $company->name) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                               required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Industry -->
                    <div>
                        <label for="industry" class="block text-sm font-medium text-gray-700 mb-2">Industry *</label>
                        <select id="industry" name="industry"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('industry') border-red-500 @enderror"
                                required>
                            <option value="">Select Industry</option>
                            <option value="Technology" {{ old('industry', $company->industry) == 'Technology' ? 'selected' : '' }}>Technology</option>
                            <option value="Healthcare" {{ old('industry', $company->industry) == 'Healthcare' ? 'selected' : '' }}>Healthcare</option>
                            <option value="Finance" {{ old('industry', $company->industry) == 'Finance' ? 'selected' : '' }}>Finance</option>
                            <option value="Education" {{ old('industry', $company->industry) == 'Education' ? 'selected' : '' }}>Education</option>
                            <option value="Manufacturing" {{ old('industry', $company->industry) == 'Manufacturing' ? 'selected' : '' }}>Manufacturing</option>
                            <option value="Retail" {{ old('industry', $company->industry) == 'Retail' ? 'selected' : '' }}>Retail</option>
                            <option value="Hospitality" {{ old('industry', $company->industry) == 'Hospitality' ? 'selected' : '' }}>Hospitality</option>
                            <option value="Construction" {{ old('industry', $company->industry) == 'Construction' ? 'selected' : '' }}>Construction</option>
                            <option value="Transportation" {{ old('industry', $company->industry) == 'Transportation' ? 'selected' : '' }}>Transportation</option>
                            <option value="Other" {{ old('industry', $company->industry) == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('industry')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Location -->
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Location *</label>
                        <input type="text" id="location" name="location" value="{{ old('location', $company->location) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('location') border-red-500 @enderror"
                               placeholder="e.g., New York, NY" required>
                        @error('location')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Contact Information -->
                    <div class="md:col-span-2 mt-4">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4 pb-2 border-b">Contact Information</h2>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $company->email) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror"
                               placeholder="company@example.com">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone', $company->phone) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('phone') border-red-500 @enderror"
                               placeholder="+1 (555) 123-4567">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Website -->
                    <div class="md:col-span-2">
                        <label for="website" class="block text-sm font-medium text-gray-700 mb-2">Website</label>
                        <input type="url" id="website" name="website" value="{{ old('website', $company->website) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('website') border-red-500 @enderror"
                               placeholder="https://example.com">
                        @error('website')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Current Media Preview -->
                    @if($company->logo || $company->banner)
                    <div class="md:col-span-2">
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Current Media</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @if($company->logo)
                            <div>
                                <p class="text-sm font-medium text-gray-700 mb-2">Current Logo</p>
                                <img src="{{ $company->logo_url }}" alt="Current logo" class="w-32 h-32 rounded-lg object-cover border">
                            </div>
                            @endif
                            @if($company->banner)
                            <div>
                                <p class="text-sm font-medium text-gray-700 mb-2">Current Banner</p>
                                <img src="{{ $company->banner_url }}" alt="Current banner" class="w-full h-32 rounded-lg object-cover border">
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Media Uploads -->
                    <div class="md:col-span-2 mt-4">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4 pb-2 border-b">Update Media</h2>
                    </div>

                    <!-- Logo -->
                    <div>
                        <label for="logo" class="block text-sm font-medium text-gray-700 mb-2">New Logo</label>
                        <input type="file" id="logo" name="logo"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('logo') border-red-500 @enderror"
                               accept="image/*">
                        <p class="mt-1 text-sm text-gray-500">Leave empty to keep current logo</p>
                        @error('logo')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Banner -->
                    <div>
                        <label for="banner" class="block text-sm font-medium text-gray-700 mb-2">New Banner</label>
                        <input type="file" id="banner" name="banner"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('banner') border-red-500 @enderror"
                               accept="image/*">
                        <p class="mt-1 text-sm text-gray-500">Leave empty to keep current banner</p>
                        @error('banner')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Company Status -->
                    <div class="md:col-span-2">
                        <div class="flex items-center">
                            <input type="checkbox" id="is_active" name="is_active" value="1"
                                   {{ old('is_active', $company->is_active) ? 'checked' : '' }}
                                   class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <label for="is_active" class="ml-2 block text-sm text-gray-900">
                                Company profile is active and visible to job seekers
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-8 flex justify-end space-x-4">
                    <a href="{{ route('companies.show', $company) }}"
                       class="px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-md hover:bg-gray-50 transition-colors duration-200">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition-colors duration-200">
                        Update Company
                    </button>
                </div>
            </form>

            <!-- Delete Company -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <div class="bg-red-50 rounded-lg p-4">
                    <h3 class="text-lg font-medium text-red-800 mb-2">Danger Zone</h3>
                    <p class="text-red-700 mb-4">Once you delete a company, there is no going back. Please be certain.</p>
                    <form action="{{ route('companies.destroy', $company) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this company? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-md transition-colors duration-200">
                            Delete Company
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush
