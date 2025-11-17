<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50/30 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="text-center mb-12">
                <div class="relative inline-block">
                    <h1 class="text-4xl font-bold text-gray-900 mb-4">Edit Job Posting</h1>
                    <div class="absolute -bottom-2 left-0 right-0 h-1 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full"></div>
                </div>
                <p class="text-xl text-gray-600 mt-6 max-w-2xl mx-auto">
                    Update your job posting to attract the best candidates
                </p>
            </div>

            <!-- Main Form Card -->
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 overflow-hidden">
                <div class="p-8">

                    <!-- Validation Errors -->
                    @if ($errors->any())
                        <div class="mb-8 bg-red-50 border border-red-200 rounded-xl p-6">
                            <div class="flex items-center mb-3">
                                <i class="fa-solid fa-circle-exclamation text-red-500 text-xl mr-3"></i>
                                <h3 class="text-lg font-semibold text-red-800">Please fix the following errors:</h3>
                            </div>
                            <ul class="list-disc list-inside text-red-700 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.jobs.update', $job->id) }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        @method('PUT')

                        <!-- Basic Information Section -->
                        <div class="mb-12">
                            <div class="flex items-center mb-8">
                                <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg">
                                    <i class="fa-solid fa-info-circle text-white text-xl"></i>
                                </div>
                                <div class="ml-4">
                                    <h2 class="text-2xl font-bold text-gray-900">Basic Information</h2>
                                    <p class="text-gray-600">Essential details about the job position</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Company Selection -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                                        Company <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fa-solid fa-building text-gray-400"></i>
                                        </div>
                                        <select name="company_id"
                                                class="block w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-200 @error('company_id') border-red-500 @enderror"
                                                required>
                                            <option value="">Select a Company</option>
                                            @foreach ($companies as $company)
                                                <option value="{{ $company->id }}"
                                                    {{ old('company_id', $job->company_id) == $company->id ? 'selected' : '' }}>
                                                    {{ $company->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('company_id')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <div class="mt-3">
                                        <a href="{{ route('companies.create') }}"
                                            class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 transition-colors duration-200">
                                            <i class="fa-solid fa-plus mr-2"></i>
                                            Don't see your company? Add a new one
                                        </a>
                                    </div>
                                </div>

                                <!-- Category Selection -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                                        Job Category <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fa-solid fa-folder text-gray-400"></i>
                                        </div>
                                        <select name="category_id"
                                                class="block w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-200 @error('category_id') border-red-500 @enderror"
                                                required>
                                            <option value="">Select Job Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('category_id', $job->category_id) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('category_id')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Job Title -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                                        Job Title <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fa-solid fa-briefcase text-gray-400"></i>
                                        </div>
                                        <input type="text" name="job_title"
                                               value="{{ old('job_title', $job->job_title) }}"
                                               class="block w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-200"
                                               placeholder="e.g., Senior Software Engineer" required>
                                    </div>
                                    @error('job_title')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Job Description -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                                        Job Description <span class="text-red-500">*</span>
                                    </label>
                                    <textarea name="job_description" rows="6"
                                              class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-200 resize-none"
                                              placeholder="Describe the role, responsibilities, and what you're looking for in a candidate..." required>{{ old('job_description', $job->job_description) }}</textarea>
                                    @error('job_description')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Requirements -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                                        Requirements & Qualifications <span class="text-red-500">*</span>
                                    </label>
                                    <textarea name="requirement" rows="6"
                                              class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-200 resize-none"
                                              placeholder="List the required skills, experience, and qualifications..." required>{{ old('requirement', $job->requirement) }}</textarea>
                                    @error('requirement')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Location -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                                        Job Location <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fa-solid fa-location-dot text-gray-400"></i>
                                        </div>
                                        <input type="text" name="location"
                                               value="{{ old('location', $job->location) }}"
                                               class="block w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-200"
                                               placeholder="e.g., New York, NY or Remote" required>
                                    </div>
                                    @error('location')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Experience & Role Section -->
                        <div class="mb-12">
                            <div class="flex items-center mb-8">
                                <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg">
                                    <i class="fa-solid fa-chart-line text-white text-xl"></i>
                                </div>
                                <div class="ml-4">
                                    <h2 class="text-2xl font-bold text-gray-900">Experience & Role</h2>
                                    <p class="text-gray-600">Define the experience requirements and role details</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Experience Requirements -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700 mb-4">
                                        Experience Requirements <span class="text-red-500">*</span>
                                    </label>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                        <div>
                                            <label class="block text-sm text-gray-600 mb-3">Minimum Experience</label>
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <i class="fa-solid fa-arrow-down text-gray-400"></i>
                                                </div>
                                                <input type="number" name="experience_minimum"
                                                       value="{{ old('experience_minimum', $job->experience_minimum) }}"
                                                       class="block w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-200"
                                                       min="0" max="50" required>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm text-gray-600 mb-3">Maximum Experience</label>
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <i class="fa-solid fa-arrow-up text-gray-400"></i>
                                                </div>
                                                <input type="number" name="experience_maximum"
                                                       value="{{ old('experience_maximum', $job->experience_maximum) }}"
                                                       class="block w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-200"
                                                       min="0" max="50" required>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm text-gray-600 mb-3">Period</label>
                                            <select name="experience_unit"
                                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-200"
                                                    required>
                                                <option value="years"
                                                    {{ old('experience_unit', $job->experience_unit) == 'years' ? 'selected' : '' }}>
                                                    Years
                                                </option>
                                                <option value="months"
                                                    {{ old('experience_unit', $job->experience_unit) == 'months' ? 'selected' : '' }}>
                                                    Months
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Role & Positions -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                                        Role <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fa-solid fa-user-tie text-gray-400"></i>
                                        </div>
                                        <input type="text" name="role"
                                               value="{{ old('role', $job->role) }}"
                                               class="block w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-200"
                                               placeholder="e.g., Software Engineer, Marketing Manager" required>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                                        Positions Available <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fa-solid fa-users text-gray-400"></i>
                                        </div>
                                        <input type="number" name="positions_available"
                                               value="{{ old('positions_available', $job->positions_available) }}"
                                               class="block w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-200"
                                               min="1" max="100" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Salary & Employment Section -->
                        <div class="mb-12">
                            <div class="flex items-center mb-8">
                                <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg">
                                    <i class="fa-solid fa-money-bill-wave text-white text-xl"></i>
                                </div>
                                <div class="ml-4">
                                    <h2 class="text-2xl font-bold text-gray-900">Salary & Employment</h2>
                                    <p class="text-gray-600">Compensation and employment details</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Salary Information -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700 mb-4">
                                        Salary Information <span class="text-red-500">*</span>
                                    </label>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                        <div>
                                            <label class="block text-sm text-gray-600 mb-3">Minimum Salary</label>
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <i class="fa-solid fa-dollar-sign text-gray-400"></i>
                                                </div>
                                                <input type="number" name="salary_minimum"
                                                       value="{{ old('salary_minimum', $job->salary_minimum) }}"
                                                       class="block w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-200"
                                                       placeholder="0" required>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm text-gray-600 mb-3">Maximum Salary</label>
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <i class="fa-solid fa-dollar-sign text-gray-400"></i>
                                                </div>
                                                <input type="number" name="salary_maximum"
                                                       value="{{ old('salary_maximum', $job->salary_maximum) }}"
                                                       class="block w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-200"
                                                       placeholder="0" required>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm text-gray-600 mb-3">Currency</label>
                                            <select name="salary_currency"
                                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-200"
                                                    required>
                                                <option value="">Select Currency</option>
                                                <option value="USD"
                                                    {{ old('salary_currency', $job->salary_currency) == 'USD' ? 'selected' : '' }}>
                                                    USD ($)
                                                </option>
                                                <option value="BDT"
                                                    {{ old('salary_currency', $job->salary_currency) == 'BDT' ? 'selected' : '' }}>
                                                    BDT (৳)
                                                </option>
                                                <option value="EUR"
                                                    {{ old('salary_currency', $job->salary_currency) == 'EUR' ? 'selected' : '' }}>
                                                    EUR (€)
                                                </option>
                                                <option value="GBP"
                                                    {{ old('salary_currency', $job->salary_currency) == 'GBP' ? 'selected' : '' }}>
                                                    GBP (£)
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Employment Type -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                                        Employment Type <span class="text-red-500">*</span>
                                    </label>
                                    <select name="employment_type"
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-200"
                                            required>
                                        <option value="">Select Employment Type</option>
                                        <option value="full-time"
                                            {{ old('employment_type', $job->employment_type) == 'full-time' ? 'selected' : '' }}>
                                            Full Time
                                        </option>
                                        <option value="part-time"
                                            {{ old('employment_type', $job->employment_type) == 'part-time' ? 'selected' : '' }}>
                                            Part Time
                                        </option>
                                        <option value="contract" {{ old('employment_type', $job->employment_type) == 'contract' ? 'selected' : '' }}>
                                            Contract
                                        </option>
                                        <option value="freelance"
                                            {{ old('employment_type', $job->employment_type) == 'freelance' ? 'selected' : '' }}>
                                            Freelance
                                        </option>
                                        <option value="internship"
                                            {{ old('employment_type', $job->employment_type) == 'internship' ? 'selected' : '' }}>
                                            Internship
                                        </option>
                                    </select>
                                </div>

                                <!-- Key Skills -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                                        Key Skills <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fa-solid fa-tools text-gray-400"></i>
                                        </div>
                                        <input type="text" name="key_skills"
                                               value="{{ old('key_skills', $job->key_skills) }}"
                                               class="block w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-200"
                                               placeholder="Enter skills separated by commas (e.g., PHP, Laravel, JavaScript, MySQL)"
                                               required>
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500">Separate multiple skills with commas</p>
                                </div>

                                <!-- Application Deadline -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                                        Application Deadline
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fa-solid fa-calendar-day text-gray-400"></i>
                                        </div>
                                        <input type="date" name="application_deadline"
                                               value="{{ old('application_deadline', $job->application_deadline ? \Carbon\Carbon::parse($job->application_deadline)->format('Y-m-d') : '') }}"
                                               class="block w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-200"
                                               min="{{ date('Y-m-d') }}">
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500">Leave empty if there's no specific deadline</p>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="pt-8 border-t border-gray-200">
                            <div class="flex flex-col sm:flex-row gap-4">
                                <button type="submit"
                                        class="flex-1 inline-flex items-center justify-center px-8 py-4 border border-transparent text-lg font-semibold rounded-xl text-white bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                                    <i class="fa-solid fa-floppy-disk mr-3"></i>
                                    Update Job Posting
                                </button>
                                <a href="{{ route('jobs.show', $job->id) }}"
                                   class="flex-1 inline-flex items-center justify-center px-8 py-4 border-2 border-gray-300 text-lg font-semibold rounded-xl text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 shadow-sm hover:shadow-md">
                                    <i class="fa-solid fa-times mr-3"></i>
                                    Cancel
                                </a>
                                <button type="button"
                                        onclick="confirmDelete({{ $job->id }})"
                                        class="flex-1 inline-flex items-center justify-center px-8 py-4 border border-transparent text-lg font-semibold rounded-xl text-white bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                                    <i class="fa-solid fa-trash mr-3"></i>
                                    Delete Job
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Delete Form -->
                    <form id="delete-form-{{ $job->id }}" action="{{ route('jobs.destroy', $job->id) }}" method="POST" class="hidden">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@push('scripts')
    <script>
        function confirmDelete(jobId) {
            if (confirm('Are you sure you want to delete this job posting? This action cannot be undone.')) {
                document.getElementById('delete-form-' + jobId).submit();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Set minimum date for application deadline to today
            const deadlineInput = document.querySelector('input[name="application_deadline"]');
            if (deadlineInput) {
                const today = new Date().toISOString().split('T')[0];
                deadlineInput.min = today;
            }

            // Experience validation
            const minExpInput = document.querySelector('input[name="experience_minimum"]');
            const maxExpInput = document.querySelector('input[name="experience_maximum"]');

            if (minExpInput && maxExpInput) {
                maxExpInput.addEventListener('change', function() {
                    if (parseInt(minExpInput.value) > parseInt(maxExpInput.value)) {
                        maxExpInput.setCustomValidity(
                            'Maximum experience must be greater than or equal to minimum experience');
                    } else {
                        maxExpInput.setCustomValidity('');
                    }
                });

                minExpInput.addEventListener('change', function() {
                    if (parseInt(minExpInput.value) > parseInt(maxExpInput.value)) {
                        minExpInput.setCustomValidity(
                            'Minimum experience must be less than or equal to maximum experience');
                    } else {
                        minExpInput.setCustomValidity('');
                    }
                });
            }

            // Salary validation
            const minSalaryInput = document.querySelector('input[name="salary_minimum"]');
            const maxSalaryInput = document.querySelector('input[name="salary_maximum"]');

            if (minSalaryInput && maxSalaryInput) {
                maxSalaryInput.addEventListener('change', function() {
                    if (parseInt(minSalaryInput.value) > parseInt(maxSalaryInput.value)) {
                        maxSalaryInput.setCustomValidity(
                            'Maximum salary must be greater than or equal to minimum salary');
                    } else {
                        maxSalaryInput.setCustomValidity('');
                    }
                });
            }
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
