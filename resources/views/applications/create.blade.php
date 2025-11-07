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

                    <!-- Success/Error Messages -->
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
                            <h4 class="font-semibold mb-2">Please fix the following errors:</h4>
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('applications.store', $job) }}" method="POST" enctype="multipart/form-data"
                        id="applicationForm">
                        @csrf

                        <div class="space-y-8">
                            <!-- Personal Information Section -->
                            <div class="border-b border-gray-200 pb-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Personal Information</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">
                                            Full Name <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="full_name" id="full_name"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm"
                                            value="{{ old('full_name', auth()->user()->name ?? '') }}"
                                            placeholder="Enter your full name" required>
                                        @error('full_name')
                                            <p class="text-red-500 text-sm mt-2 flex items-center">
                                                <i class="fas fa-exclamation-circle mr-1"></i>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                            Email <span class="text-red-500">*</span>
                                        </label>
                                        <input type="email" name="email" id="email"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm"
                                            value="{{ old('email', auth()->user()->email ?? '') }}"
                                            placeholder="Enter your email" required>
                                        @error('email')
                                            <p class="text-red-500 text-sm mt-2 flex items-center">
                                                <i class="fas fa-exclamation-circle mr-1"></i>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Information Section -->
                            <div class="border-b border-gray-200 pb-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact Information</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                            Phone Number <span class="text-red-500">*</span>
                                        </label>
                                        <input type="tel" name="phone" id="phone"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm"
                                            value="{{ old('phone', auth()->user()->phone ?? '') }}"
                                            placeholder="+1 (555) 123-4567" required>
                                        @error('phone')
                                            <p class="text-red-500 text-sm mt-2 flex items-center">
                                                <i class="fas fa-exclamation-circle mr-1"></i>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="experience_years"
                                            class="block text-sm font-medium text-gray-700 mb-2">
                                            Years of Experience <span class="text-red-500">*</span>
                                        </label>
                                        <input type="number" name="experience_years" id="experience_years"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm"
                                            value="{{ old('experience_years') }}"
                                            placeholder="Enter years of experience" min="0" max="50"
                                            required>
                                        @error('experience_years')
                                            <p class="text-red-500 text-sm mt-2 flex items-center">
                                                <i class="fas fa-exclamation-circle mr-1"></i>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Address Section -->
                            <div class="border-b border-gray-200 pb-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Address</h3>
                                <div>
                                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                                        Full Address
                                    </label>
                                    <textarea name="address" id="address" rows="3"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm"
                                        placeholder="Enter your complete address">{{ old('address', auth()->user()->address ?? '') }}</textarea>
                                    @error('address')
                                        <p class="text-red-500 text-sm mt-2 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Professional Information Section -->
                            <div class="border-b border-gray-200 pb-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Professional Information</h3>

                                <!-- Skills -->
                                <div class="mb-6">
                                    <label for="skills" class="block text-sm font-medium text-gray-700 mb-2">
                                        Skills <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="skills" id="skills"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm"
                                        value="{{ old('skills') }}"
                                        placeholder="PHP, Laravel, JavaScript, MySQL, React, etc." required>
                                    <p class="text-sm text-gray-500 mt-2 flex items-center">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Separate multiple skills with commas
                                    </p>
                                    @error('skills')
                                        <p class="text-red-500 text-sm mt-2 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Education -->
                                <div>
                                    <label for="education" class="block text-sm font-medium text-gray-700 mb-2">
                                        Education <span class="text-red-500">*</span>
                                    </label>
                                    <textarea name="education" id="education" rows="4"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm"
                                        placeholder="Example:&#10;Bachelor of Science in Computer Science - University of Example (2018-2022)&#10;GPA: 3.8/4.0"
                                        required>{{ old('education') }}</textarea>
                                    @error('education')
                                        <p class="text-red-500 text-sm mt-2 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Documents Section -->
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
                                        <p class="text-sm text-gray-500 mt-2 flex items-center">
                                            <i class="fas fa-info-circle mr-1"></i>
                                            PDF, DOC, DOCX (Max: 2MB)
                                        </p>
                                        @error('resume')
                                            <p class="text-red-500 text-sm mt-2 flex items-center">
                                                <i class="fas fa-exclamation-circle mr-1"></i>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="cover_letter"
                                            class="block text-sm font-medium text-gray-700 mb-2">
                                            Cover Letter
                                        </label>
                                        <input type="file" name="cover_letter" id="cover_letter"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                            accept=".pdf,.doc,.docx">
                                        <p class="text-sm text-gray-500 mt-2 flex items-center">
                                            <i class="fas fa-info-circle mr-1"></i>
                                            PDF, DOC, DOCX (Max: 2MB)
                                        </p>
                                        @error('cover_letter')
                                            <p class="text-red-500 text-sm mt-2 flex items-center">
                                                <i class="fas fa-exclamation-circle mr-1"></i>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Information -->
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                                <h3 class="text-lg font-semibold text-blue-900 mb-2 flex items-center">
                                    <i class="fas fa-lightbulb mr-2"></i>
                                    Application Tips
                                </h3>
                                <ul class="text-blue-800 text-sm space-y-1 list-disc list-inside">
                                    <li>Make sure your resume is up-to-date and tailored to this position</li>
                                    <li>Highlight skills that match the job requirements</li>
                                    <li>Double-check your contact information for accuracy</li>
                                    <li>Consider adding a cover letter to stand out from other applicants</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div
                            class="mt-8 flex flex-col sm:flex-row justify-between items-center gap-4 pt-6 border-t border-gray-200">
                            <a href="{{ route('jobs.show', $job) }}"
                                class="w-full sm:w-auto px-8 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200 flex items-center justify-center">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Back to Job
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

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('applicationForm');
            const submitBtn = document.getElementById('submitBtn');
            const resumeInput = document.getElementById('resume');
            const coverLetterInput = document.getElementById('cover_letter');

            // File validation
            function validateFile(input, maxSize = 2) {
                if (input.files.length > 0) {
                    const file = input.files[0];
                    const fileSize = file.size / 1024 / 1024; // MB
                    const allowedTypes = ['application/pdf', 'application/msword',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
                    ];

                    if (!allowedTypes.includes(file.type)) {
                        alert('Please select a valid file type (PDF, DOC, or DOCX)');
                        input.value = '';
                        return false;
                    }

                    if (fileSize > maxSize) {
                        alert(`File size must be less than ${maxSize}MB`);
                        input.value = '';
                        return false;
                    }
                }
                return true;
            }

            resumeInput.addEventListener('change', function() {
                validateFile(this);
            });

            coverLetterInput.addEventListener('change', function() {
                validateFile(this);
            });

            // Form submission handler
            form.addEventListener('submit', function(e) {
                const requiredFields = form.querySelectorAll('[required]');
                let valid = true;

                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        valid = false;
                        field.classList.add('border-red-500');
                    } else {
                        field.classList.remove('border-red-500');
                    }
                });

                if (!valid) {
                    e.preventDefault();
                    alert('Please fill in all required fields.');
                    return;
                }

                // Change button state
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Submitting...';
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            });

            // Real-time validation
            const inputs = form.querySelectorAll('input, textarea');
            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    if (this.value.trim()) {
                        this.classList.remove('border-red-500');
                        this.classList.add('border-green-300');
                    } else {
                        this.classList.remove('border-green-300');
                    }
                });
            });
        });
    </script>
@endpush

<style>
    /* Custom styles for better visual feedback */
    input:focus,
    textarea:focus,
    select:focus {
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .border-green-300 {
        border-color: #86efac;
    }

    /* Smooth transitions */
    * {
        transition: all 0.2s ease-in-out;
    }
</style>
