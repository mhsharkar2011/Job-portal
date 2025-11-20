<x-app-layout>
    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="p-6 md:p-8">
                    <!-- Header -->
                    <div class="mb-8 text-center">
                        <h2 class="text-3xl font-bold text-gray-900">Apply for {{ $job->job_title }}</h2>
                        <p class="text-gray-600 mt-2 text-lg">{{ $job->company->name }} • {{ $job->location }}</p>
                        <div class="mt-4 flex flex-wrap justify-center gap-2">
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-medium rounded-full">
                                {{ ucfirst($job->employment_type) }}
                            </span>
                            <span class="px-3 py-1 bg-green-100 text-green-800 text-sm font-medium rounded-full">
                                {{ $job->experience_minimum }}-{{ $job->experience_maximum }}
                                {{ $job->experience_unit }} exp
                            </span>
                            <span class="px-3 py-1 bg-purple-100 text-purple-800 text-sm font-medium rounded-full">
                                {{ $job->salary_currency }} {{ number_format($job->salary_minimum) }} -
                                {{ number_format($job->salary_maximum) }}
                            </span>
                        </div>
                    </div>

                    <!-- Application Form -->
                    <!-- In your apply.blade.php -->
                    <form action="{{ route('seeker.application.save', $job) }}" method="POST"
                        enctype="multipart/form-data" id="applicationForm">
                        @csrf

                        @if ($errors->any())
                            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                                <h4 class="font-semibold mb-2">Please fix the following errors:</h4>
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <div class="space-y-6">
                            <!-- Personal Information -->
                            <div class="border-b border-gray-200 pb-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Personal Information</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">
                                            Full Name <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="full_name" id="full_name"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm"
                                            value="{{ old('full_name', auth()->user()->name) }}"
                                            placeholder="Enter your full name" required>
                                    </div>
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                            Email <span class="text-red-500">*</span>
                                        </label>
                                        <input type="email" name="email" id="email"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm"
                                            value="{{ old('email', auth()->user()->email) }}"
                                            placeholder="Enter your email" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Information -->
                            <div class="border-b border-gray-200 pb-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact Information</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                            Phone Number
                                        </label>
                                        <input type="tel" name="phone" id="phone"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm"
                                            value="{{ old('phone', auth()->user()->phone) }}"
                                            placeholder="+1 (555) 123-4567">
                                    </div>
                                    <div>
                                        <label for="experience_years"
                                            class="block text-sm font-medium text-gray-700 mb-2">
                                            Years of Experience
                                        </label>
                                        <input type="number" name="experience_years" id="experience_years"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm"
                                            value="{{ old('experience_years') }}"
                                            placeholder="Enter years of experience" min="0" max="50">
                                    </div>
                                </div>
                            </div>

                            <!-- Professional Information -->
                            <div class="border-b border-gray-200 pb-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Professional Information</h3>

                                <div class="mb-6">
                                    <label for="skills" class="block text-sm font-medium text-gray-700 mb-2">
                                        Skills
                                    </label>
                                    <input type="text" name="skills" id="skills"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm"
                                        value="{{ old('skills') }}"
                                        placeholder="PHP, Laravel, JavaScript, MySQL, React, etc.">
                                    <p class="text-sm text-gray-500 mt-2">
                                        Separate multiple skills with commas
                                    </p>
                                </div>

                                <div>
                                    <label for="education" class="block text-sm font-medium text-gray-700 mb-2">
                                        Education
                                    </label>
                                    <textarea name="education" id="education" rows="4"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm"
                                        placeholder="Example:&#10;Bachelor of Science in Computer Science - University of Example (2018-2022)&#10;GPA: 3.8/4.0">{{ old('education') }}</textarea>
                                </div>
                            </div>

                            <!-- Documents -->
                            <div class="border-b border-gray-200 pb-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Documents</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="resume" class="block text-sm font-medium text-gray-700 mb-2">
                                            Resume <span class="text-red-500">*</span>
                                        </label>
                                        <input type="file" name="resume" id="resume"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                            accept=".pdf,.doc,.docx" required>
                                        <p class="text-sm text-gray-500 mt-2">
                                            PDF, DOC, DOCX (Max: 2MB)
                                        </p>
                                    </div>
                                    <div>
                                        <label for="cover_letter" class="block text-sm font-medium text-gray-700 mb-2">
                                            Cover Letter
                                        </label>
                                        <input type="file" name="cover_letter" id="cover_letter"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                            accept=".pdf,.doc,.docx">
                                        <p class="text-sm text-gray-500 mt-2">
                                            PDF, DOC, DOCX (Max: 2MB)
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Address -->
                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                                    Address
                                </label>
                                <textarea name="address" id="address" rows="3"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm"
                                    placeholder="Enter your complete address">{{ old('address', auth()->user()->address) }}</textarea>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div
                            class="mt-8 flex flex-col sm:flex-row justify-between items-center gap-4 pt-6 border-t border-gray-200">
                            <a href="{{ route('seeker.jobs.index') }}"
                                class="w-full sm:w-auto px-8 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200 flex items-center justify-center">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Back to Jobs
                            </a>
                            <button type="submit" id="submitBtn"
                                class="w-full sm:w-auto px-8 py-3 bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 text-white font-medium rounded-lg transition-colors duration-200 focus:outline-none flex items-center justify-center">
                                <i class="fas fa-paper-plane mr-2"></i>
                                Submit Application
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
