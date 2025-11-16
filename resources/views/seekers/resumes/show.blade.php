<x-app-layout>
    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header with Actions -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $resume->title ?? 'My Resume' }}</h1>
                    <p class="text-gray-600 mt-2">Last updated {{ $resume->updated_at->format('F j, Y') }}</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('seeker.resumes.edit', $resume) }}"
                       class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Resume
                    </a>
                    <button onclick="window.print()"
                            class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <i class="fas fa-print mr-2"></i>
                        Print
                    </button>
                    <a href="{{ route('dashboard') }}"
                       class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back
                    </a>
                </div>
            </div>

            <!-- Resume Content -->
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <!-- Personal Information Section -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-8 text-white">
                    <div class="flex items-center space-x-6">
                        @if($resume->user->profile_photo_path)
                            <img src="{{ Storage::url($resume->user->profile_photo_path) }}"
                                 alt="{{ $resume->user->name }}"
                                 class="w-24 h-24 rounded-full border-4 border-white shadow-lg">
                        @else
                            <div class="w-24 h-24 bg-white bg-opacity-20 rounded-full flex items-center justify-center border-4 border-white">
                                <span class="text-2xl font-bold">{{ strtoupper(substr($resume->user->name, 0, 1)) }}</span>
                            </div>
                        @endif
                        <div class="flex-1">
                            <h2 class="text-3xl font-bold">{{ $resume->user->name }}</h2>
                            <p class="text-blue-100 text-lg mt-1">{{ $resume->title ?? 'Professional' }}</p>
                            <div class="flex flex-wrap gap-4 mt-3 text-blue-100">
                                @if($resume->user->email)
                                    <div class="flex items-center">
                                        <i class="fas fa-envelope mr-2"></i>
                                        {{ $resume->user->email }}
                                    </div>
                                @endif
                                @if($resume->user->phone)
                                    <div class="flex items-center">
                                        <i class="fas fa-phone mr-2"></i>
                                        {{ $resume->user->phone }}
                                    </div>
                                @endif
                                @if($resume->user->address)
                                    <div class="flex items-center">
                                        <i class="fas fa-map-marker-alt mr-2"></i>
                                        {{ $resume->user->address }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-6 space-y-8">
                    <!-- Professional Summary -->
                    @if($resume->summary)
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 border-b-2 border-blue-600 pb-2 mb-4">
                            <i class="fas fa-user mr-2 text-blue-600"></i>
                            Professional Summary
                        </h3>
                        <p class="text-gray-700 leading-relaxed">{{ $resume->summary }}</p>
                    </div>
                    @endif

                    <!-- Skills Section -->
                    @if($resume->skills && count($resume->skills) > 0)
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 border-b-2 border-blue-600 pb-2 mb-4">
                            <i class="fas fa-tools mr-2 text-blue-600"></i>
                            Skills & Expertise
                        </h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($resume->skills as $skill)
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                                    {{ $skill }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Work Experience -->
                    @if($resume->experience && count($resume->experience) > 0)
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 border-b-2 border-blue-600 pb-2 mb-4">
                            <i class="fas fa-briefcase mr-2 text-blue-600"></i>
                            Work Experience
                        </h3>
                        <div class="space-y-6">
                            @foreach($resume->experience as $experience)
                                <div class="border-l-4 border-blue-500 pl-4">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="text-lg font-semibold text-gray-900">{{ $experience['position'] ?? 'Position' }}</h4>
                                            <p class="text-blue-600 font-medium">{{ $experience['company'] ?? 'Company' }}</p>
                                        </div>
                                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">
                                            {{ $experience['start_date'] ?? '' }} - {{ $experience['end_date'] ?? 'Present' }}
                                        </span>
                                    </div>
                                    @if(isset($experience['description']))
                                        <p class="text-gray-600 mt-2">{{ $experience['description'] }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Education -->
                    @if($resume->education && count($resume->education) > 0)
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 border-b-2 border-blue-600 pb-2 mb-4">
                            <i class="fas fa-graduation-cap mr-2 text-blue-600"></i>
                            Education
                        </h3>
                        <div class="space-y-6">
                            @foreach($resume->education as $education)
                                <div class="border-l-4 border-green-500 pl-4">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="text-lg font-semibold text-gray-900">{{ $education['degree'] ?? 'Degree' }}</h4>
                                            <p class="text-green-600 font-medium">{{ $education['institution'] ?? 'Institution' }}</p>
                                        </div>
                                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">
                                            {{ $education['year'] ?? '' }}
                                        </span>
                                    </div>
                                    @if(isset($education['description']))
                                        <p class="text-gray-600 mt-2">{{ $education['description'] }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Certifications (Optional) -->
                    @if($resume->certifications && count($resume->certifications) > 0)
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 border-b-2 border-blue-600 pb-2 mb-4">
                            <i class="fas fa-award mr-2 text-blue-600"></i>
                            Certifications
                        </h3>
                        <div class="space-y-3">
                            @foreach($resume->certifications as $certification)
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-700">{{ $certification['name'] ?? 'Certification' }}</span>
                                    <span class="text-gray-500 text-sm">{{ $certification['year'] ?? '' }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Languages (Optional) -->
                    @if($resume->languages && count($resume->languages) > 0)
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 border-b-2 border-blue-600 pb-2 mb-4">
                            <i class="fas fa-language mr-2 text-blue-600"></i>
                            Languages
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($resume->languages as $language)
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-700">{{ $language['name'] ?? 'Language' }}</span>
                                    <span class="text-gray-500 text-sm capitalize">{{ $language['proficiency'] ?? '' }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 text-center">
                    <div class="text-2xl font-bold text-blue-600">{{ $resume->skills ? count($resume->skills) : 0 }}</div>
                    <div class="text-gray-600 text-sm">Skills Listed</div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 text-center">
                    <div class="text-2xl font-bold text-green-600">{{ $resume->experience ? count($resume->experience) : 0 }}</div>
                    <div class="text-gray-600 text-sm">Experiences</div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 text-center">
                    <div class="text-2xl font-bold text-purple-600">{{ $resume->education ? count($resume->education) : 0 }}</div>
                    <div class="text-gray-600 text-sm">Education Entries</div>
                </div>
            </div>

            <!-- Download Section -->
            <div class="mt-8 bg-blue-50 rounded-lg p-6 text-center">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Ready to Apply?</h3>
                <p class="text-gray-600 mb-4">Download your resume or share it with potential employers.</p>
                <div class="flex justify-center space-x-4">
                    <button class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <i class="fas fa-download mr-2"></i>
                        Download PDF
                    </button>
                    <button class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <i class="fas fa-share-alt mr-2"></i>
                        Share Resume
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background: white !important;
            }
            .bg-gradient-to-r {
                background: #2563eb !important;
            }
        }
    </style>
    @endpush
</x-app-layout>
