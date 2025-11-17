<x-app-layout>
    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="p-6 md:p-8">
                    <!-- Header -->
                    <div class="mb-8">
                        <h3 class="text-3xl font-bold text-gray-900">Post a Job</h3>
                        <p class="text-gray-600 mt-2">Fill in the details below to create a new job posting</p>
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

                    <form action="{{ route('jobs.store') }}" method="POST" enctype="multipart/form-data"
                        autocomplete="off">
                        @csrf

                        <!-- Company Selection -->
                        <div class="mb-6">
                            <label for="company_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Select Company <span class="text-red-500">*</span>
                            </label>
                            <select id="company_id" name="company_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('company_id') border-red-500 @enderror"
                                required>
                                <option value="">Select a Company</option>
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}"
                                        {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                        {{ $company->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('company_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <div class="mt-2">
                                <a href="{{ route('companies.create') }}"
                                    class="text-sm text-blue-600 hover:text-blue-800 inline-flex items-center">
                                    <i class="fa-solid fa-plus mr-1"></i>
                                    Don't see your company? Add a new one
                                </a>
                            </div>
                        </div>

                        <!-- Category -->
                        <div class="mb-6">
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Category <span class="text-red-500">*</span>
                            </label>
                            <select  name="category_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('category_id') border-red-500 @enderror"
                                required>
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Job Title -->
                        <div class="mb-6">
                            <label for="job_title" class="block mb-2 text-sm font-medium text-gray-700">
                                Job Title <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="job_title" id="job_title"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                value="{{ old('job_title') }}" placeholder="e.g., Senior Software Engineer" required>
                            @error('job_title')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Job Description -->
                        <div class="mb-6">
                            <label for="job_description" class="block mb-2 text-sm font-medium text-gray-700">
                                Job Description <span class="text-red-500">*</span>
                            </label>
                            <textarea name="job_description" id="job_description" rows="5"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Describe the role, responsibilities, and what you're looking for in a candidate..." required>{{ old('job_description') }}</textarea>
                            @error('job_description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Requirements -->
                        <div class="mb-6">
                            <label for="requirement" class="block mb-2 text-sm font-medium text-gray-700">
                                Requirements & Qualifications <span class="text-red-500">*</span>
                            </label>
                            <textarea name="requirement" id="requirement" rows="5"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="List the required skills, experience, and qualifications..." required>{{ old('requirement') }}</textarea>
                            @error('requirement')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Location -->
                        <div class="mb-6">
                            <label for="location" class="block mb-2 text-sm font-medium text-gray-700">
                                Job Location <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="location" id="location"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                value="{{ old('location') }}" placeholder="e.g., New York, NY or Remote" required>
                            @error('location')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Experience Section -->
                        <div class="mb-6">
                            <label class="block mb-4 text-sm font-medium text-gray-700">
                                Experience Requirements <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="experience_minimum" class="block mb-2 text-sm text-gray-600">
                                        Minimum Experience
                                    </label>
                                    <input type="number" name="experience_minimum" id="experience_minimum"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        value="{{ old('experience_minimum', 0) }}" min="0" max="50"
                                        required>
                                    @error('experience_minimum')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="experience_maximum" class="block mb-2 text-sm text-gray-600">
                                        Maximum Experience
                                    </label>
                                    <input type="number" name="experience_maximum" id="experience_maximum"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        value="{{ old('experience_maximum', 5) }}" min="0" max="50"
                                        required>
                                    @error('experience_maximum')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="experience_unit" class="block mb-2 text-sm text-gray-600">
                                        Period
                                    </label>
                                    <select name="experience_unit" id="experience_unit"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                        <option value="years"
                                            {{ old('experience_unit', 'years') == 'years' ? 'selected' : '' }}>
                                            Years
                                        </option>
                                        <option value="months"
                                            {{ old('experience_unit') == 'months' ? 'selected' : '' }}>
                                            Months
                                        </option>
                                    </select>
                                    @error('experience_unit')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Role & Positions -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="role" class="block mb-2 text-sm font-medium text-gray-700">
                                    Role <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="role" id="role"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    value="{{ old('role') }}"
                                    placeholder="e.g., Software Engineer, Marketing Manager" required>
                                @error('role')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="positions_available" class="block mb-2 text-sm font-medium text-gray-700">
                                    Positions Available <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="positions_available" id="positions_available"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    value="{{ old('positions_available', 1) }}" min="1" max="100"
                                    required>
                                @error('positions_available')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Salary Range -->
                        <div class="mb-6">
                            <label class="block mb-4 text-sm font-medium text-gray-700">
                                Salary Information <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="salary_minimum" class="block mb-2 text-sm text-gray-600">
                                        Minimum Salary
                                    </label>
                                    <input type="number" name="salary_minimum" id="salary_minimum"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        value="{{ old('salary_minimum') }}" placeholder="0" required>
                                    @error('salary_minimum')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="salary_maximum" class="block mb-2 text-sm text-gray-600">
                                        Maximum Salary
                                    </label>
                                    <input type="number" name="salary_maximum" id="salary_maximum"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        value="{{ old('salary_maximum') }}" placeholder="0" required>
                                    @error('salary_maximum')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="salary_currency" class="block mb-2 text-sm text-gray-600">
                                        Currency
                                    </label>
                                    <select name="salary_currency" id="salary_currency"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                        <option value="">Select Currency</option>
                                        <option value="USD"
                                            {{ old('salary_currency', 'USD') == 'USD' ? 'selected' : '' }}>
                                            USD ($)
                                        </option>
                                        <option value="BDT"
                                            {{ old('salary_currency') == 'BDT' ? 'selected' : '' }}>
                                            BDT (৳)
                                        </option>
                                        <option value="EUR"
                                            {{ old('salary_currency') == 'EUR' ? 'selected' : '' }}>
                                            EUR (€)
                                        </option>
                                        <option value="GBP"
                                            {{ old('salary_currency') == 'GBP' ? 'selected' : '' }}>
                                            GBP (£)
                                        </option>
                                    </select>
                                    @error('salary_currency')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Employment Type -->
                        <div class="mb-6">
                            <label for="employment_type" class="block mb-2 text-sm font-medium text-gray-700">
                                Employment Type <span class="text-red-500">*</span>
                            </label>
                            <select name="employment_type" id="employment_type"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                                <option value="">Select Employment Type</option>
                                <option value="full-time"
                                    {{ old('employment_type', 'full-time') == 'full-time' ? 'selected' : '' }}>
                                    Full Time
                                </option>
                                <option value="part-time"
                                    {{ old('employment_type') == 'part-time' ? 'selected' : '' }}>
                                    Part Time
                                </option>
                                <option value="contract" {{ old('employment_type') == 'contract' ? 'selected' : '' }}>
                                    Contract
                                </option>
                                <option value="freelance"
                                    {{ old('employment_type') == 'freelance' ? 'selected' : '' }}>
                                    Freelance
                                </option>
                                <option value="internship"
                                    {{ old('employment_type') == 'internship' ? 'selected' : '' }}>
                                    Internship
                                </option>
                            </select>
                            @error('employment_type')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Key Skills -->
                        <div class="mb-6">
                            <label for="key_skills" class="block mb-2 text-sm font-medium text-gray-700">
                                Key Skills <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="key_skills" id="key_skills"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                value="{{ old('key_skills') }}"
                                placeholder="Enter skills separated by commas (e.g., PHP, Laravel, JavaScript, MySQL)"
                                required>
                            <p class="text-sm text-gray-500 mt-1">Separate multiple skills with commas</p>
                            @error('key_skills')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Application Deadline -->
                        <div class="mb-6">
                            <label for="application_deadline" class="block mb-2 text-sm font-medium text-gray-700">
                                Application Deadline
                            </label>
                            <input type="date" name="application_deadline" id="application_deadline"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                value="{{ old('application_deadline') }}" min="{{ date('Y-m-d') }}">
                            <p class="text-sm text-gray-500 mt-1">Leave empty if there's no specific deadline</p>
                            @error('application_deadline')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Form Actions -->
                        <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                            <button type="submit"
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition-colors duration-200 flex items-center justify-center">
                                <i class="fa-solid fa-paper-plane mr-2"></i>
                                Post Job
                            </button>
                            <a href="{{ route('jobs.browse') }}"
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
{{--
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Set minimum date for application deadline to today
            const deadlineInput = document.getElementById('application_deadline');
            if (deadlineInput) {
                const today = new Date().toISOString().split('T')[0];
                deadlineInput.min = today;
            }

            // Experience validation
            const minExpInput = document.getElementById('experience_minimum');
            const maxExpInput = document.getElementById('experience_maximum');

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
            const minSalaryInput = document.getElementById('salary_minimum');
            const maxSalaryInput = document.getElementById('salary_maximum');

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
@endpush --}}
