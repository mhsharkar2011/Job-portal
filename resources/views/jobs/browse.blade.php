<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Header with Stats -->
                    <div class="mb-8">
                        <h1 class="text-3xl font-bold text-gray-900">Available Jobs</h1>
                        <p class="text-gray-600 mt-2">Find your next career opportunity from our listed positions</p>
                        <div class="flex flex-wrap gap-4 mt-4">
                            <div class="bg-blue-50 px-4 py-2 rounded-lg">
                                <span class="text-blue-800 font-semibold">
                                    {{ $jobs->where('accepting_applications', true)->count() }} Jobs Accepting Applications
                                </span>
                            </div>
                            <div class="bg-green-50 px-4 py-2 rounded-lg">
                                <span class="text-green-800 font-semibold">
                                    {{ $jobs->sum('remaining_positions') }} Total Positions Available
                                </span>
                            </div>
                            @auth
                                <div class="bg-purple-50 px-4 py-2 rounded-lg">
                                    <span class="text-purple-800 font-semibold">Welcome, {{ auth()->user()->name }}!</span>
                                </div>
                            @endauth
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach ($jobs as $job)
                            <div class="transition-all duration-300 hover:scale-105 border border-gray-200 rounded-lg shadow-sm hover:shadow-lg bg-white">
                                <figure class="flex flex-col p-6 rounded-lg h-full">
                                    <!-- Header Section -->
                                    <div class="mb-4 flex justify-between items-start">
                                        @if($job->is_accepting_applications)
                                            <span class="bg-green-500 px-3 py-1 rounded text-white text-sm font-bold">
                                                {{ $job->remaining_positions }} Position(s)
                                            </span>
                                        @else
                                            <span class="bg-red-500 px-3 py-1 rounded text-white text-sm font-bold">
                                                Filled
                                            </span>
                                        @endif
                                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-medium">
                                            {{ $job->applications_count }} applicants
                                        </span>
                                    </div>

                                    <!-- Company Logo and Name -->
                                    <div class="flex items-center mb-4">
                                        <div class="flex-shrink-0 mr-3">
                                            @if($job->logo)
                                                <img src="{{ asset('storage/' . $job->logo) }}"
                                                     alt="{{ $job->company_name }} logo"
                                                     class="rounded h-10 w-10 object-cover border border-gray-200">
                                            @else
                                                <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center border border-gray-300">
                                                    <span class="text-sm font-medium text-gray-600">
                                                        {{ substr($job->company_name, 0, 1) }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-semibold text-gray-900">{{ $job->company_name }}</h3>
                                            <p class="text-xs text-gray-500">{{ $job->location }}</p>
                                        </div>
                                    </div>

                                    <!-- Job Details Section -->
                                    <div class="flex-grow">
                                        <div class="mb-4">
                                            <h2 class="text-lg font-bold text-gray-800 line-clamp-2 mb-2">{{ $job->job_title }}</h2>
                                            <p class="text-sm text-gray-600 line-clamp-3 mb-3">{{ Str::limit($job->job_description, 100) }}</p>

                                            <!-- Job Meta Information -->
                                            <div class="space-y-2 mb-4">
                                                <div class="flex items-center text-sm text-gray-600">
                                                    <i class="fa-solid fa-location-dot mr-2 text-gray-400"></i>
                                                    <span>{{ $job->location }}</span>
                                                </div>
                                                <div class="flex items-center text-sm text-gray-600">
                                                    <i class="fa-solid fa-briefcase mr-2 text-gray-400"></i>
                                                    <span>{{ $job->employment_type }}</span>
                                                </div>
                                                @if($job->salary_minimum && $job->salary_maximum)
                                                <div class="flex items-center text-sm text-gray-600">
                                                    <i class="fa-solid fa-money-bill-wave mr-2 text-gray-400"></i>
                                                    <span>${{ number_format($job->salary_minimum) }} - ${{ number_format($job->salary_maximum) }}</span>
                                                </div>
                                                @endif

                                                <!-- Positions Information -->
                                                <div class="flex items-center text-sm {{ $job->remaining_positions > 0 ? 'text-green-600' : 'text-red-600' }}">
                                                    <i class="fa-solid fa-users mr-2"></i>
                                                    <span>
                                                        {{ $job->remaining_positions }} of {{ $job->positions_available }} positions available
                                                    </span>
                                                </div>
                                            </div>

                                            <!-- Key Skills -->
                                            @if($job->key_skills)
                                                <div class="mb-4">
                                                    <div class="flex flex-wrap gap-1">
                                                        @foreach(array_slice(explode(',', $job->key_skills), 0, 3) as $skill)
                                                            <span class="inline-block bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs">
                                                                {{ trim($skill) }}
                                                            </span>
                                                        @endforeach
                                                        @if(count(explode(',', $job->key_skills)) > 3)
                                                            <span class="inline-block bg-gray-100 text-gray-500 px-2 py-1 rounded text-xs">
                                                                +{{ count(explode(',', $job->key_skills)) - 3 }} more
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Posted Date -->
                                    <div class="mb-4">
                                        <div class="flex items-center text-xs text-gray-500">
                                            <i class="fa-regular fa-clock mr-1"></i>
                                            <span>Posted {{ $job->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                                        <!-- Apply Button -->
                                        @auth
                                            @if(auth()->user()->role === 'job_seeker')
                                                <!-- Check if user already applied -->
                                                @if($job->applications->where('user_id', auth()->id())->count() > 0)
                                                    <button class="flex items-center px-4 py-2 bg-green-100 text-green-700 rounded-lg cursor-not-allowed" disabled>
                                                        <i class="fa-solid fa-check mr-2"></i>
                                                        Applied
                                                    </button>
                                                @elseif($job->is_accepting_applications)
                                                    <a href="{{ route('applications.create', $job) }}"
                                                       class="flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200">
                                                        <i class="fa-solid fa-paper-plane mr-2"></i>
                                                        Apply Now
                                                    </a>
                                                @else
                                                    <button class="flex items-center px-4 py-2 bg-red-100 text-red-700 rounded-lg cursor-not-allowed" disabled>
                                                        <i class="fa-solid fa-times mr-2"></i>
                                                        Position Filled
                                                    </button>
                                                @endif
                                            @else
                                                <a href="{{ route('jobs.show', $job) }}"
                                                   class="flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors duration-200">
                                                    <i class="fa-solid fa-eye mr-2"></i>
                                                    View Job
                                                </a>
                                            @endif
                                        @else
                                            @if($job->is_accepting_applications)
                                                <a href="{{ route('login') }}"
                                                   class="flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200">
                                                    <i class="fa-solid fa-paper-plane mr-2"></i>
                                                    Apply Now
                                                </a>
                                            @else
                                                <button class="flex items-center px-4 py-2 bg-red-100 text-red-700 rounded-lg cursor-not-allowed" disabled>
                                                    <i class="fa-solid fa-times mr-2"></i>
                                                    Position Filled
                                                </a>
                                            @endif
                                        @endauth

                                        <!-- Quick Actions -->
                                        <div class="flex space-x-2">
                                            <button class="text-gray-400 hover:text-blue-500 p-2 transition-all duration-300 hover:scale-110"
                                                    title="Save Job"
                                                    onclick="saveJob({{ $job->id }})">
                                                <i class="fa-regular fa-bookmark"></i>
                                            </button>
                                            <button class="text-gray-400 hover:text-green-500 p-2 transition-all duration-300 hover:scale-110"
                                                    title="Share Job">
                                                <i class="fa-solid fa-share-nodes"></i>
                                            </button>
                                        </div>
                                    </div>
                                </figure>
                            </div>
                        @endforeach
                    </div>

                    <!-- Empty State -->
                    @if($jobs->count() === 0)
                        <div class="text-center py-12">
                            <div class="text-gray-400 mb-4">
                                <i class="fa-solid fa-briefcase text-6xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No jobs available</h3>
                            <p class="text-gray-600 mb-6">Check back later for new job opportunities.</p>
                        </div>
                    @endif

                    <!-- Pagination -->
                    @if(method_exists($jobs, 'hasPages') && $jobs->hasPages())
                        <div class="mt-8">
                            {{ $jobs->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function saveJob(jobId) {
            fetch(`/jobs/${jobId}/save`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Job saved successfully!');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    </script>
    @endpush
</x-app-layout>
