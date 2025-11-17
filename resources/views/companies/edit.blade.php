@extends('layouts.app')

@section('title', 'Edit Company - ' . config('app.name'))

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50/30 py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="text-center mb-12">
                <div class="relative inline-block">
                    <h1 class="text-4xl font-bold text-gray-900 mb-4">Edit Company Profile</h1>
                    <div
                        class="absolute -bottom-2 left-0 right-0 h-1 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full">
                    </div>
                </div>
                <p class="text-xl text-gray-600 mt-6 max-w-2xl mx-auto">
                    Update your company information to attract the best talent
                </p>
            </div>

            <!-- Main Content -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

                <!-- Sidebar Navigation -->
                <div class="lg:col-span-1">
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 p-6 sticky top-6">
                        <div class="flex items-center space-x-4 mb-6">
                            @if ($company->logo)
                                <img src="{{ asset('storage/' . $company->logo) }}" alt="{{ $company->name }}"
                                    class="w-16 h-16 rounded-2xl object-cover border-2 border-white shadow-lg">
                            @else
                                <div
                                    class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg">
                                    <i class="fa-solid fa-building text-white text-xl"></i>
                                </div>
                            @endif
                            <div>
                                <h3 class="font-bold text-gray-900">{{ $company->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $company->category->name ?? 'No Category' }}</p>
                            </div>
                        </div>

                        <nav class="space-y-2">
                            <a href="#basic-info"
                                class="flex items-center px-3 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg transition-colors duration-200">
                                <i class="fa-solid fa-building mr-3"></i>
                                Basic Information
                            </a>
                            <a href="#contact-info"
                                class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                                <i class="fa-solid fa-address-card mr-3"></i>
                                Contact Information
                            </a>
                            <a href="#company-details"
                                class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                                <i class="fa-solid fa-info-circle mr-3"></i>
                                Company Details
                            </a>
                            <a href="#media"
                                class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                                <i class="fa-solid fa-images mr-3"></i>
                                Media & Branding
                            </a>
                            <a href="#social-media"
                                class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                                <i class="fa-solid fa-share-nodes mr-3"></i>
                                Social Media
                            </a>
                        </nav>

                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fa-solid fa-calendar mr-2"></i>
                                Last updated {{ $company->updated_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Section -->
                <div class="lg:col-span-3">
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 overflow-hidden">

                        <form action="{{ route('companies.update', $company) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Basic Information Section -->
                            <div id="basic-info" class="p-8 border-b border-gray-100/50">
                                <div class="flex items-center mb-6">
                                    <div
                                        class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg">
                                        <i class="fa-solid fa-building text-white text-xl"></i>
                                    </div>
                                    <div class="ml-4">
                                        <h2 class="text-2xl font-bold text-gray-900">Basic Information</h2>
                                        <p class="text-gray-600">Essential details about your company</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Company Name -->
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-semibold text-gray-700 mb-3">Company Name *</label>
                                        <input type="text" name="name" value="{{ old('name', $company->name) }}"
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-200 @error('name') border-red-500 @enderror"
                                            required>
                                        @error('name')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Category -->
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-semibold text-gray-700 mb-3">Category *</label>
                                        <select name="category_id"
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-200 @error('category_id') border-red-500 @enderror"
                                            required>
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('category_id', $company->category_id) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Location -->
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-semibold text-gray-700 mb-3">Location *</label>
                                        <input type="text" name="location"
                                            value="{{ old('location', $company->location) }}"
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-200 @error('location') border-red-500 @enderror"
                                            required>
                                        @error('location')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Information Section -->
                            <div id="contact-info" class="p-8 border-b border-gray-100/50">
                                <div class="flex items-center mb-6">
                                    <div
                                        class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg">
                                        <i class="fa-solid fa-address-card text-white text-xl"></i>
                                    </div>
                                    <div class="ml-4">
                                        <h2 class="text-2xl font-bold text-gray-900">Contact Information</h2>
                                        <p class="text-gray-600">How people can reach your company</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Email -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-3">Email Address</label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fa-solid fa-envelope text-gray-400"></i>
                                            </div>
                                            <input type="email" name="email"
                                                value="{{ old('email', $company->email) }}"
                                                class="block w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-200 @error('email') border-red-500 @enderror"
                                                placeholder="company@example.com">
                                        </div>
                                        @error('email')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Phone -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-3">Phone Number</label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fa-solid fa-phone text-gray-400"></i>
                                            </div>
                                            <input type="tel" name="phone"
                                                value="{{ old('phone', $company->phone) }}"
                                                class="block w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-200 @error('phone') border-red-500 @enderror"
                                                placeholder="+1 (555) 123-4567">
                                        </div>
                                        @error('phone')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Website -->
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-semibold text-gray-700 mb-3">Website</label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fa-solid fa-globe text-gray-400"></i>
                                            </div>
                                            <input type="url" name="website"
                                                value="{{ old('website', $company->website) }}"
                                                class="block w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-200 @error('website') border-red-500 @enderror"
                                                placeholder="https://example.com">
                                        </div>
                                        @error('website')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Address -->
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-semibold text-gray-700 mb-3">Full Address</label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fa-solid fa-map-marker-alt text-gray-400"></i>
                                            </div>
                                            <input type="text" name="address"
                                                value="{{ old('address', $company->address) }}"
                                                class="block w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-200 @error('address') border-red-500 @enderror"
                                                placeholder="123 Main Street">
                                        </div>
                                        @error('address')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- City, State, Country, Postal Code -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-3">City</label>
                                        <input type="text" name="city" value="{{ old('city', $company->city) }}"
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-200">
                                    </div>

                                    <div>
                                        <label
                                            class="block text-sm font-semibold text-gray-700 mb-3">State/Province</label>
                                        <input type="text" name="state" value="{{ old('state', $company->state) }}"
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-200">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-3">Country</label>
                                        <input type="text" name="country"
                                            value="{{ old('country', $company->country) }}"
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-200">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-3">Postal Code</label>
                                        <input type="text" name="postal_code"
                                            value="{{ old('postal_code', $company->postal_code) }}"
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-200">
                                    </div>
                                </div>
                            </div>

                            <!-- Company Details Section -->
                            <div id="company-details" class="p-8 border-b border-gray-100/50">
                                <div class="flex items-center mb-6">
                                    <div
                                        class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg">
                                        <i class="fa-solid fa-info-circle text-white text-xl"></i>
                                    </div>
                                    <div class="ml-4">
                                        <h2 class="text-2xl font-bold text-gray-900">Company Details</h2>
                                        <p class="text-gray-600">Tell your company's story</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- About Company -->
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-semibold text-gray-700 mb-3">About Company</label>
                                        <textarea name="about" rows="6"
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-200 resize-none">{{ old('about', $company->about) }}</textarea>
                                        <p class="mt-2 text-sm text-gray-500">Describe your company's mission, values, and
                                            what makes you unique</p>
                                    </div>

                                    <!-- Employees Count -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-3">Number of
                                            Employees</label>
                                        <select name="employees_count"
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-200">
                                            <option value="">Select Range</option>
                                            <option value="1"
                                                {{ old('employees_count', $company->employees_count) == '1' ? 'selected' : '' }}>
                                                1-10</option>
                                            <option value="11"
                                                {{ old('employees_count', $company->employees_count) == '11' ? 'selected' : '' }}>
                                                11-50</option>
                                            <option value="51"
                                                {{ old('employees_count', $company->employees_count) == '51' ? 'selected' : '' }}>
                                                51-200</option>
                                            <option value="201"
                                                {{ old('employees_count', $company->employees_count) == '201' ? 'selected' : '' }}>
                                                201-500</option>
                                            <option value="501"
                                                {{ old('employees_count', $company->employees_count) == '501' ? 'selected' : '' }}>
                                                501-1000</option>
                                            <option value="1001"
                                                {{ old('employees_count', $company->employees_count) == '1001' ? 'selected' : '' }}>
                                                1000+</option>
                                        </select>
                                    </div>

                                    <!-- Founded Year -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-3">Founded Year</label>
                                        <input type="number" name="founded_year"
                                            value="{{ old('founded_year', $company->founded_year) }}"
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-200"
                                            min="1900" max="{{ date('Y') }}" placeholder="e.g., 2020">
                                    </div>
                                </div>
                            </div>

                            <!-- Media Section -->
                            <div id="media" class="p-8 border-b border-gray-100/50">
                                <div class="flex items-center mb-6">
                                    <div
                                        class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center shadow-lg">
                                        <i class="fa-solid fa-images text-white text-xl"></i>
                                    </div>
                                    <div class="ml-4">
                                        <h2 class="text-2xl font-bold text-gray-900">Media & Branding</h2>
                                        <p class="text-gray-600">Upload your company logo and banner</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <!-- Logo Upload -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-4">Company Logo</label>
                                        <div class="flex items-center space-x-6">
                                            @if ($company->logo)
                                                <div class="relative group">
                                                    <img src="{{ asset('storage/' . $company->logo) }}"
                                                        alt="{{ $company->name }}"
                                                        class="w-24 h-24 rounded-2xl object-cover border-2 border-white shadow-lg">
                                                    <div
                                                        class="absolute inset-0 bg-black bg-opacity-50 rounded-2xl flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                                        <span class="text-white text-xs font-medium">Current</span>
                                                    </div>
                                                </div>
                                            @else
                                                <div
                                                    class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center border-2 border-dashed border-gray-300">
                                                    <i class="fa-solid fa-building text-gray-400 text-2xl"></i>
                                                </div>
                                            @endif
                                            <div class="flex-1">
                                                <input type="file" name="logo"
                                                    class="w-full px-3 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-200"
                                                    accept="image/*">
                                                <p class="mt-2 text-sm text-gray-500">Recommended: 400x400px, PNG or JPG
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Banner Upload -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-4">Company
                                            Banner</label>
                                        <div class="flex items-center space-x-6">
                                            @if ($company->banner)
                                                <div class="relative group">
                                                    <img src="{{ asset('storage/' . $company->banner) }}"
                                                        alt="{{ $company->name }} Banner"
                                                        class="w-32 h-20 rounded-xl object-cover border-2 border-white shadow-lg">
                                                    <div
                                                        class="absolute inset-0 bg-black bg-opacity-50 rounded-xl flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                                        <span class="text-white text-xs font-medium">Current</span>
                                                    </div>
                                                </div>
                                            @else
                                                <div
                                                    class="w-32 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-xl flex items-center justify-center border-2 border-dashed border-gray-300">
                                                    <i class="fa-solid fa-image text-gray-400 text-xl"></i>
                                                </div>
                                            @endif
                                            <div class="flex-1">
                                                <input type="file" name="banner"
                                                    class="w-full px-3 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-200"
                                                    accept="image/*">
                                                <p class="mt-2 text-sm text-gray-500">Recommended: 1200x300px, PNG or JPG
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Social Media Section -->
                            <div id="social-media" class="p-8">
                                <div class="flex items-center mb-6">
                                    <div
                                        class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-pink-500 to-pink-600 rounded-2xl flex items-center justify-center shadow-lg">
                                        <i class="fa-solid fa-share-nodes text-white text-xl"></i>
                                    </div>
                                    <div class="ml-4">
                                        <h2 class="text-2xl font-bold text-gray-900">Social Media</h2>
                                        <p class="text-gray-600">Connect your social media profiles</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @foreach ([['icon' => 'fa-facebook', 'color' => 'blue', 'name' => 'facebook_url', 'placeholder' => 'https://facebook.com/yourcompany'], ['icon' => 'fa-twitter', 'color' => 'sky', 'name' => 'twitter_url', 'placeholder' => 'https://twitter.com/yourcompany'], ['icon' => 'fa-linkedin', 'color' => 'blue', 'name' => 'linkedin_url', 'placeholder' => 'https://linkedin.com/company/yourcompany'], ['icon' => 'fa-instagram', 'color' => 'pink', 'name' => 'instagram_url', 'placeholder' => 'https://instagram.com/yourcompany']] as $social)
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                                <i
                                                    class="fa-brands {{ $social['icon'] }} text-{{ $social['color'] }}-500 mr-2"></i>
                                                {{ ucfirst(str_replace('_url', '', $social['name'])) }}
                                            </label>
                                            <div class="relative">
                                                <div
                                                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <i class="fa-solid fa-link text-gray-400"></i>
                                                </div>
                                                <input type="url" name="{{ $social['name'] }}"
                                                    value="{{ old($social['name'], $company->{$social['name']}) }}"
                                                    class="block w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-200"
                                                    placeholder="{{ $social['placeholder'] }}">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="px-8 py-6 bg-gradient-to-r from-white to-gray-50/50 border-t border-gray-100/50">
                                <div class="flex flex-col sm:flex-row gap-4 justify-end">
                                    <a href="{{ route('companies.show', $company) }}"
                                        class="inline-flex items-center justify-center px-8 py-3 border-2 border-gray-300 text-base font-semibold rounded-xl text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 shadow-sm hover:shadow-md">
                                        <i class="fa-solid fa-times mr-2"></i>
                                        Cancel
                                    </a>
                                    <button type="submit"
                                        class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-semibold rounded-xl text-white bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                                        <i class="fa-solid fa-floppy-disk mr-2"></i>
                                        Update Company
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Smooth scrolling for navigation
            document.addEventListener('DOMContentLoaded', function() {
                const navLinks = document.querySelectorAll('a[href^="#"]');

                navLinks.forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const targetId = this.getAttribute('href');
                        const targetElement = document.querySelector(targetId);

                        if (targetElement) {
                            targetElement.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        }
                    });
                });
            });
        </script>
    @endpush

    <style>
        .backdrop-blur-sm {
            backdrop-filter: blur(8px);
        }

        .bg-white\/80 {
            background-color: rgba(255, 255, 255, 0.8);
        }

        .border-white\/20 {
            border-color: rgba(255, 255, 255, 0.2);
        }
    </style>
@endsection
