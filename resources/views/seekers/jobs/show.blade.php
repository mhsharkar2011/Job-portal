<x-app-layout>


    @php
        // Quick fix for undefined variable
        if (!isset($relatedJobs)) {
            $relatedJobs = collect();
        }
    @endphp
    
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Job Details -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden mb-8">
                <div class="p-6 md:p-8">
                    <!-- Job header -->
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">{{ $job->job_title }}</h1>
                            <p class="text-gray-600 mt-2 text-lg">{{ $job->company->name }} • {{ $job->location }}</p>
                        </div>
                        <div class="text-right">
                            <span
                                class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                                {{ $job->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>

                    <!-- Job meta information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
                                <i class="fa-solid fa-briefcase text-blue-600"></i>
                            </div>
                            <div>
                                <div class="text-sm text-gray-500">Type</div>
                                <div class="font-medium text-gray-900 capitalize">
                                    {{ str_replace('-', ' ', $job->employment_type) }}</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center">
                                <i class="fa-solid fa-chart-line text-green-600"></i>
                            </div>
                            <div>
                                <div class="text-sm text-gray-500">Experience</div>
                                <div class="font-medium text-gray-900">
                                    {{ $job->experience_minimum }}-{{ $job->experience_maximum }}
                                    {{ $job->experience_unit }}
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center">
                                <i class="fa-solid fa-money-bill-wave text-purple-600"></i>
                            </div>
                            <div>
                                <div class="text-sm text-gray-500">Salary</div>
                                <div class="font-medium text-gray-900">
                                    {{ $job->salary_currency }} {{ number_format($job->salary_minimum) }} -
                                    {{ number_format($job->salary_maximum) }}
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-orange-50 rounded-lg flex items-center justify-center">
                                <i class="fa-solid fa-users text-orange-600"></i>
                            </div>
                            <div>
                                <div class="text-sm text-gray-500">Positions</div>
                                <div class="font-medium text-gray-900">{{ $job->positions_available }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Job description -->
                    <div class="prose max-w-none mb-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Job Description</h3>
                        <div class="text-gray-700 leading-relaxed">
                            {!! nl2br(e($job->job_description)) !!}
                        </div>
                    </div>

                    <!-- Requirements -->
                    <div class="prose max-w-none mb-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Requirements</h3>
                        <div class="text-gray-700 leading-relaxed">
                            {!! nl2br(e($job->requirement)) !!}
                        </div>
                    </div>

                    <!-- Skills -->
                    @if ($job->key_skills)
                        <div class="mb-6">
                            <h3 class="text-xl font-semibold text-gray-900 mb-4">Key Skills</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach (explode(',', $job->key_skills) as $skill)
                                    <span
                                        class="inline-block bg-blue-100 text-blue-800 px-3 py-2 rounded-lg text-sm font-medium">
                                        {{ trim($skill) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Action buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                        @auth
                            @if (auth()->user()->isSeeker())
                                <a href="{{ route('seeker.jobs.apply', $job) }}"
                                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200 text-center">
                                    Apply Now
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}"
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200 text-center">
                                Login to Apply
                            </a>
                        @endauth

                        <a href="{{ route('jobs.index') }}"
                            class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 px-6 rounded-lg transition-colors duration-200 text-center">
                            Back to Jobs
                        </a>
                    </div>
                </div>
            </div>

            <!-- Related Jobs Section -->
            @php
                $relatedJobs = $relatedJobs ?? collect();
            @endphp

            @if ($relatedJobs->count() > 0)
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <div class="p-6 md:p-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Related Jobs</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($relatedJobs as $relatedJob)
                                <div
                                    class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow duration-200">
                                    <h4 class="font-semibold text-gray-900 mb-2">
                                        <a href="{{ route('jobs.show', $relatedJob) }}" class="hover:text-blue-600">
                                            {{ $relatedJob->job_title }}
                                        </a>
                                    </h4>
                                    <p class="text-gray-600 text-sm mb-2">{{ $relatedJob->company->name }}</p>
                                    <p class="text-gray-500 text-sm">{{ $relatedJob->location }}</p>
                                    <div class="mt-3 flex items-center justify-between">
                                        <span class="text-sm text-gray-500">{{ $relatedJob->employment_type }}</span>
                                        <a href="{{ route('jobs.show', $relatedJob) }}"
                                            class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
