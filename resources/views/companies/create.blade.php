@extends('layouts.app')

@section('title', 'Add Company - ' . config('app.name'))

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Add Your Company</h1>
            <p class="text-gray-600">Create a company profile to start posting jobs and attracting talent</p>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('companies.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Basic Information -->
                    <div class="md:col-span-2">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4 pb-2 border-b">Basic Information</h2>
                    </div>

                    <!-- Company Name -->
                    <div class="md:col-span-2">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Company Name *</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
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
                            <option value="Technology" {{ old('industry') == 'Technology' ? 'selected' : '' }}>Technology</option>
                            <option value="Healthcare" {{ old('industry') == 'Healthcare' ? 'selected' : '' }}>Healthcare</option>
                            <option value="Finance" {{ old('industry') == 'Finance' ? 'selected' : '' }}>Finance</option>
                            <option value="Education" {{ old('industry') == 'Education' ? 'selected' : '' }}>Education</option>
                            <option value="Manufacturing" {{ old('industry') == 'Manufacturing' ? 'selected' : '' }}>Manufacturing</option>
                            <option value="Retail" {{ old('industry') == 'Retail' ? 'selected' : '' }}>Retail</option>
                            <option value="Hospitality" {{ old('industry') == 'Hospitality' ? 'selected' : '' }}>Hospitality</option>
                            <option value="Construction" {{ old('industry') == 'Construction' ? 'selected' : '' }}>Construction</option>
                            <option value="Transportation" {{ old('industry') == 'Transportation' ? 'selected' : '' }}>Transportation</option>
                            <option value="Other" {{ old('industry') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('industry')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Location -->
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Location *</label>
                        <input type="text" id="location" name="location" value="{{ old('location') }}"
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
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror"
                               placeholder="company@example.com">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('phone') border-red-500 @enderror"
                               placeholder="+1 (555) 123-4567">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Website -->
                    <div class="md:col-span-2">
                        <label for="website" class="block text-sm font-medium text-gray-700 mb-2">Website</label>
                        <input type="url" id="website" name="website" value="{{ old('website') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('website') border-red-500 @enderror"
                               placeholder="https://example.com">
                        @error('website')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address Details -->
                    <div class="md:col-span-2">
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                        <input type="text" id="address" name="address" value="{{ old('address') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('address') border-red-500 @enderror"
                               placeholder="123 Main Street">
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 mb-2">City</label>
                        <input type="text" id="city" name="city" value="{{ old('city') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('city') border-red-500 @enderror">
                        @error('city')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="state" class="block text-sm font-medium text-gray-700 mb-2">State/Province</label>
                        <input type="text" id="state" name="state" value="{{ old('state') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('state') border-red-500 @enderror">
                        @error('state')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="country" class="block text-sm font-medium text-gray-700 mb-2">Country</label>
                        <input type="text" id="country" name="country" value="{{ old('country') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('country') border-red-500 @enderror">
                        @error('country')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-2">Postal Code</label>
                        <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('postal_code') border-red-500 @enderror">
                        @error('postal_code')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Company Details -->
                    <div class="md:col-span-2 mt-4">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4 pb-2 border-b">Company Details</h2>
                    </div>

                    <!-- About Company -->
                    <div class="md:col-span-2">
                        <label for="about" class="block text-sm font-medium text-gray-700 mb-2">About Company</label>
                        <textarea id="about" name="about" rows="5"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('about') border-red-500 @enderror"
                                  placeholder="Describe your company, mission, values, and what makes you unique...">{{ old('about') }}</textarea>
                        @error('about')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Employees Count -->
                    <div>
                        <label for="employees_count" class="block text-sm font-medium text-gray-700 mb-2">Number of Employees</label>
                        <select id="employees_count" name="employees_count"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Range</option>
                            <option value="1" {{ old('employees_count') == '1' ? 'selected' : '' }}>1-10</option>
                            <option value="11" {{ old('employees_count') == '11' ? 'selected' : '' }}>11-50</option>
                            <option value="51" {{ old('employees_count') == '51' ? 'selected' : '' }}>51-200</option>
                            <option value="201" {{ old('employees_count') == '201' ? 'selected' : '' }}>201-500</option>
                            <option value="501" {{ old('employees_count') == '501' ? 'selected' : '' }}>501-1000</option>
                            <option value="1001" {{ old('employees_count') == '1001' ? 'selected' : '' }}>1000+</option>
                        </select>
                    </div>

                    <!-- Founded Year -->
                    <div>
                        <label for="founded_year" class="block text-sm font-medium text-gray-700 mb-2">Founded Year</label>
                        <input type="number" id="founded_year" name="founded_year" value="{{ old('founded_year') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               min="1900" max="{{ date('Y') }}">
                    </div>

                    <!-- Media Uploads -->
                    <div class="md:col-span-2 mt-4">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4 pb-2 border-b">Media</h2>
                    </div>

                    <!-- Logo -->
                    <div>
                        <label for="logo" class="block text-sm font-medium text-gray-700 mb-2">Company Logo</label>
                        <input type="file" id="logo" name="logo"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('logo') border-red-500 @enderror"
                               accept="image/*">
                        <p class="mt-1 text-sm text-gray-500">Recommended: 400x400px, PNG or JPG</p>
                        @error('logo')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Banner -->
                    <div>
                        <label for="banner" class="block text-sm font-medium text-gray-700 mb-2">Company Banner</label>
                        <input type="file" id="banner" name="banner"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('banner') border-red-500 @enderror"
                               accept="image/*">
                        <p class="mt-1 text-sm text-gray-500">Recommended: 1200x300px, PNG or JPG</p>
                        @error('banner')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Social Media -->
                    <div class="md:col-span-2 mt-4">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4 pb-2 border-b">Social Media</h2>
                    </div>

                    <!-- Facebook -->
                    <div>
                        <label for="facebook_url" class="block text-sm font-medium text-gray-700 mb-2">Facebook</label>
                        <input type="url" id="facebook_url" name="facebook_url" value="{{ old('facebook_url') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="https://facebook.com/yourcompany">
                    </div>

                    <!-- Twitter -->
                    <div>
                        <label for="twitter_url" class="block text-sm font-medium text-gray-700 mb-2">Twitter</label>
                        <input type="url" id="twitter_url" name="twitter_url" value="{{ old('twitter_url') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="https://twitter.com/yourcompany">
                    </div>

                    <!-- LinkedIn -->
                    <div>
                        <label for="linkedin_url" class="block text-sm font-medium text-gray-700 mb-2">LinkedIn</label>
                        <input type="url" id="linkedin_url" name="linkedin_url" value="{{ old('linkedin_url') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="https://linkedin.com/company/yourcompany">
                    </div>

                    <!-- Instagram -->
                    <div>
                        <label for="instagram_url" class="block text-sm font-medium text-gray-700 mb-2">Instagram</label>
                        <input type="url" id="instagram_url" name="instagram_url" value="{{ old('instagram_url') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="https://instagram.com/yourcompany">
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-8 flex justify-end space-x-4">
                    <a href="{{ route('companies.index') }}"
                       class="px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-md hover:bg-gray-50 transition-colors duration-200">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition-colors duration-200">
                        Create Company
                    </button>
                </div>
            </form>
        </div>

        <!-- Help Text -->
        <div class="mt-6 bg-blue-50 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fa-solid fa-lightbulb text-blue-400 text-xl"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">Tips for a great company profile</h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <ul class="list-disc list-inside space-y-1">
                            <li>Use a high-quality logo and banner image</li>
                            <li>Write a compelling "About Us" section</li>
                            <li>Include accurate contact information</li>
                            <li>Add your social media links to increase engagement</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush
