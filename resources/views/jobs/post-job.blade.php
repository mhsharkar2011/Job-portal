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

                    <form action="{{ route('jobs.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Company Name -->
                        <div class="mb-6">
                            <label for="company_name" class="block mb-2 text-sm font-medium text-gray-700">
                                Company Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="company_name" id="company_name"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   value="{{ old('company_name') }}" required>
                            @error('company_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Job Title -->
                        <div class="mb-6">
                            <label for="job_title" class="block mb-2 text-sm font-medium text-gray-700">
                                Job Title <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="job_title" id="job_title"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   value="{{ old('job_title') }}" required>
                            @error('job_title')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Job Description -->
                        <div class="mb-6">
                            <label for="job_description" class="block mb-2 text-sm font-medium text-gray-700">
                                Job Description <span class="text-red-500">*</span>
                            </label>
                            <textarea name="job_description" id="job_description" rows="4"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                      required>{{ old('job_description') }}</textarea>
                            @error('job_description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Requirement -->
                        <div class="mb-6">
                            <label for="requirement" class="block mb-2 text-sm font-medium text-gray-700">
                                Requirements <span class="text-red-500">*</span>
                            </label>
                            <textarea name="requirement" id="requirement" rows="4"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                      required>{{ old('requirement') }}</textarea>
                            @error('requirement')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Location -->
                        <div class="mb-6">
                            <label for="location" class="block mb-2 text-sm font-medium text-gray-700">
                                Location <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="location" id="location"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   value="{{ old('location') }}" required>
                            @error('location')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Experience -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            <div>
                                <label for="experience_minimum" class="block mb-2 text-sm font-medium text-gray-700">
                                    Min Experience <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="experience_minimum" id="experience_minimum"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       value="{{ old('experience_minimum') }}" min="0" required>
                                @error('experience_minimum')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="experience_maximum" class="block mb-2 text-sm font-medium text-gray-700">
                                    Max Experience <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="experience_maximum" id="experience_maximum"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       value="{{ old('experience_maximum') }}" min="0" required>
                                @error('experience_maximum')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="experience_unit" class="block mb-2 text-sm font-medium text-gray-700">
                                    Experience Unit <span class="text-red-500">*</span>
                                </label>
                                <select name="experience_unit" id="experience_unit"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                    <option value="">Select Unit</option>
                                    <option value="years" {{ old('experience_unit') == 'years' ? 'selected' : '' }}>Years</option>
                                    <option value="months" {{ old('experience_unit') == 'months' ? 'selected' : '' }}>Months</option>
                                </select>
                                @error('experience_unit')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Role -->
                        <div class="mb-6">
                            <label for="role" class="block mb-2 text-sm font-medium text-gray-700">
                                Role <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="role" id="role"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   value="{{ old('role') }}" required>
                            @error('role')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Industry Type -->
                        <div class="mb-6">
                            <label for="industry_type" class="block mb-2 text-sm font-medium text-gray-700">
                                Industry Type <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="industry_type" id="industry_type"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   value="{{ old('industry_type') }}" required>
                            @error('industry_type')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Positions Available -->
                        <div class="mb-6">
                            <label for="positions_available" class="block mb-2 text-sm font-medium text-gray-700">
                                Number of Positions Available <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="positions_available" id="positions_available"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   value="{{ old('positions_available', 1) }}" min="1" required>
                            @error('positions_available')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Salary Range -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            <div>
                                <label for="salary_minimum" class="block mb-2 text-sm font-medium text-gray-700">
                                    Minimum Salary <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="salary_minimum" id="salary_minimum"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       value="{{ old('salary_minimum') }}" required>
                                @error('salary_minimum')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="salary_maximum" class="block mb-2 text-sm font-medium text-gray-700">
                                    Maximum Salary <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="salary_maximum" id="salary_maximum"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       value="{{ old('salary_maximum') }}" required>
                                @error('salary_maximum')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="salary_currency" class="block mb-2 text-sm font-medium text-gray-700">
                                    Currency <span class="text-red-500">*</span>
                                </label>
                                <select name="salary_currency" id="salary_currency"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                    <option value="">Select Currency</option>
                                    <option value="USD" {{ old('salary_currency') == 'USD' ? 'selected' : '' }}>USD ($)</option>
                                    <option value="BDT" {{ old('salary_currency') == 'BDT' ? 'selected' : '' }}>BDT (৳)</option>
                                    <option value="EUR" {{ old('salary_currency') == 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                                    <option value="GBP" {{ old('salary_currency') == 'GBP' ? 'selected' : '' }}>GBP (£)</option>
                                </select>
                                @error('salary_currency')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Employment Type -->
                        <div class="mb-6">
                            <label for="employment_type" class="block mb-2 text-sm font-medium text-gray-700">
                                Employment Type <span class="text-red-500">*</span>
                            </label>
                            <select name="employment_type" id="employment_type"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="">Select Employment Type</option>
                                <option value="full-time" {{ old('employment_type') == 'full-time' ? 'selected' : '' }}>Full Time</option>
                                <option value="part-time" {{ old('employment_type') == 'part-time' ? 'selected' : '' }}>Part Time</option>
                                <option value="contract" {{ old('employment_type') == 'contract' ? 'selected' : '' }}>Contract</option>
                                <option value="freelance" {{ old('employment_type') == 'freelance' ? 'selected' : '' }}>Freelance</option>
                                <option value="internship" {{ old('employment_type') == 'internship' ? 'selected' : '' }}>Internship</option>
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
                                   placeholder="Enter skills separated by commas (e.g., PHP, Laravel, JavaScript)" required>
                            @error('key_skills')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Logo Upload -->
                        <div class="mb-6">
                            <label for="logo" class="block mb-2 text-sm font-medium text-gray-700">
                                Company Logo
                            </label>
                            <input type="file" name="logo" id="logo"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            @error('logo')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg transition-colors duration-200">
                            Post Job
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
