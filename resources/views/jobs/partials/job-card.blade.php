<div class="job-card bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden
            {{ $job->is_featured ? 'featured-job border-l-4 border-l-yellow-400' : '' }}
            {{ $job->is_urgent ? 'urgent-job border-l-4 border-l-red-400' : '' }}"
     data-job-id="{{ $job->id }}">

    <!-- Job Header -->
    <div class="p-6 border-b border-gray-100">
        <div class="flex justify-between items-start mb-4">
            <!-- Status Badges -->
            <div class="flex items-center gap-2">
                @if($job->is_featured)
                <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1">
                    <i class="fa-solid fa-star text-yellow-500"></i>
                    Featured
                </span>
                @endif
                @if($job->is_urgent)
                <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1">
                    <i class="fa-solid fa-clock text-red-500"></i>
                    Urgent
                </span>
                @endif
                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-medium">
                    {{ $job->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>

            <!-- Applicants Count -->
            <span class="bg-blue-50 text-blue-700 px-3 py-1 rounded-full text-xs font-medium flex items-center gap-1">
                <i class="fa-solid fa-users"></i>
                {{ $job->applications_count ?? 0 }} applicants
            </span>
        </div>

        <!-- Company Info -->
        <div class="flex items-center gap-4 mb-4">
            @if($job->company && $job->company->logo)
            <img src="{{ $job->company->logo_url }}"
                 alt="{{ $job->company->name }}"
                 class="w-12 h-12 rounded-xl object-cover border border-gray-200">
            @else
            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center border border-gray-200">
                <i class="fa-solid fa-building text-white text-lg"></i>
            </div>
            @endif
            <div class="flex-1 min-w-0">
                <h3 class="font-semibold text-gray-900 text-lg truncate">{{ $job->company->name ?? 'Company' }}</h3>
                <div class="flex items-center gap-2 text-sm text-gray-600 mt-1">
                    <i class="fa-solid fa-location-dot text-gray-400"></i>
                    <span class="truncate">{{ $job->location }}</span>
                </div>
            </div>
        </div>

        <!-- Job Title -->
        <h2 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 hover:text-blue-600 transition-colors">
            <a href="{{ route('jobs.show', $job) }}">{{ $job->job_title }}</a>
        </h2>

        <!-- Job Description -->
        <p class="text-gray-600 text-sm line-clamp-3 mb-4 leading-relaxed">
            {{ Str::limit(strip_tags($job->job_description), 120) }}
        </p>
    </div>

    <!-- Job Details -->
    <div class="p-6">
        <!-- Meta Information -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <!-- Employment Type -->
            <div class="flex items-center gap-3 text-sm text-gray-600">
                <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-briefcase text-blue-600 text-sm"></i>
                </div>
                <div>
                    <div class="text-xs text-gray-500">Type</div>
                    <div class="font-medium text-gray-900 capitalize">{{ str_replace('-', ' ', $job->employment_type) }}</div>
                </div>
            </div>

            <!-- Experience -->
            <div class="flex items-center gap-3 text-sm text-gray-600">
                <div class="w-8 h-8 bg-green-50 rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-chart-line text-green-600 text-sm"></i>
                </div>
                <div>
                    <div class="text-xs text-gray-500">Experience</div>
                    <div class="font-medium text-gray-900">
                        {{ $job->experience_minimum }}-{{ $job->experience_maximum }} {{ $job->experience_unit }}
                    </div>
                </div>
            </div>

            <!-- Salary -->
            @if($job->salary_minimum && $job->salary_maximum)
            <div class="flex items-center gap-3 text-sm text-gray-600">
                <div class="w-8 h-8 bg-purple-50 rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-money-bill-wave text-purple-600 text-sm"></i>
                </div>
                <div>
                    <div class="text-xs text-gray-500">Salary</div>
                    <div class="font-medium text-gray-900">
                        {{ $job->salary_currency }} {{ number_format($job->salary_minimum) }} - {{ number_format($job->salary_maximum) }}
                    </div>
                </div>
            </div>
            @endif

            <!-- Category -->
            @if($job->category)
            <div class="flex items-center gap-3 text-sm text-gray-600">
                <div class="w-8 h-8 bg-orange-50 rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-tag text-orange-600 text-sm"></i>
                </div>
                <div>
                    <div class="text-xs text-gray-500">Category</div>
                    <div class="font-medium text-gray-900">{{ $job->category->name }}</div>
                </div>
            </div>
            @endif
        </div>

        <!-- Key Skills -->
        @if($job->key_skills)
        <div class="mb-4">
            <div class="flex flex-wrap gap-2">
                @foreach(array_slice(explode(',', $job->key_skills), 0, 4) as $skill)
                <span class="inline-block bg-gray-100 text-gray-700 px-3 py-1.5 rounded-lg text-xs font-medium border border-gray-200">
                    {{ trim($skill) }}
                </span>
                @endforeach
                @if(count(explode(',', $job->key_skills)) > 4)
                <span class="inline-block bg-gray-50 text-gray-500 px-3 py-1.5 rounded-lg text-xs font-medium border border-gray-200">
                    +{{ count(explode(',', $job->key_skills)) - 4 }} more
                </span>
                @endif
            </div>
        </div>
        @endif

        <!-- Posted Date & Deadline -->
        <div class="flex flex-wrap items-center justify-between gap-3 text-xs text-gray-500 mb-4">
            <div class="flex items-center gap-1">
                <i class="fa-regular fa-clock"></i>
                <span>Posted {{ $job->created_at->diffForHumans() }}</span>
            </div>
            @if($job->application_deadline)
            <div class="flex items-center gap-1
                {{ $job->application_deadline->isPast() ? 'text-red-500' : 'text-green-500' }}">
                <i class="fa-solid fa-hourglass-end"></i>
                <span>
                    {{ $job->application_deadline->isPast() ? 'Closed' : 'Closes ' . $job->application_deadline->diffForHumans() }}
                </span>
            </div>
            @endif
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
            <!-- Apply Button -->
            <div class="flex-1">
                @auth
                    @if(auth()->user()->isSeeker())
                        <!-- Check if user already applied -->
                        @if($job->applications->where('user_id', auth()->id())->count() > 0)
                            <button class="apply-button flex items-center gap-2 px-6 py-3 bg-green-100 text-green-700 rounded-xl font-semibold text-sm cursor-not-allowed w-full justify-center transition-colors" disabled>
                                <i class="fa-solid fa-check"></i>
                                Applied
                            </button>
                        @else
                            <a href="{{ route('seeker.jobs.apply', $job->id) }}"
                               class="apply-button flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-xl font-semibold text-sm w-full justify-center transition-all shadow-sm hover:shadow-md">
                                <i class="fa-solid fa-paper-plane"></i>
                                Quick Apply
                            </a>
                        @endif
                    @else
                        <a href="{{ route('seeker.jobs.show', $job) }}"
                           class="flex items-center gap-2 px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-semibold text-sm w-full justify-center transition-colors">
                            <i class="fa-solid fa-eye"></i>
                            View Details
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}"
                       class="flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-xl font-semibold text-sm w-full justify-center transition-all shadow-sm hover:shadow-md">
                        <i class="fa-solid fa-paper-plane"></i>
                        Apply Now
                    </a>
                @endauth
            </div>

            <!-- Quick Actions -->
            <div class="flex items-center gap-1 ml-4">
                <!-- Save Button -->
                <button onclick="saveJob({{ $job->id }})"
                        class="save-button flex items-center justify-center w-10 h-10 text-gray-400 hover:text-blue-500 rounded-lg hover:bg-blue-50 transition-all duration-300"
                        title="Save Job">
                    <i class="fa-regular fa-bookmark text-lg"></i>
                </button>

                <!-- Share Button -->
                <button onclick="shareJob({{ $job->id }})"
                        class="flex items-center justify-center w-10 h-10 text-gray-400 hover:text-green-500 rounded-lg hover:bg-green-50 transition-all duration-300"
                        title="Share Job">
                    <i class="fa-solid fa-share-nodes text-lg"></i>
                </button>
            </div>
        </div>
    </div>
</div>
