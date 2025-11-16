<!-- My Resume Dropdown -->
<div class="relative" x-data="{ resumeDropdown: false }">
    <button @click="resumeDropdown = !resumeDropdown"
            class="inline-flex items-center px-3 py-2 text-gray-600 hover:text-blue-600 text-sm font-medium rounded-lg transition-all hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
        <i class="fa-solid fa-file-lines mr-2"></i>
        Resume
        <i class="fa-solid fa-chevron-down ml-1 text-xs transition-transform duration-200"
           :class="{ 'rotate-180': resumeDropdown }"></i>
    </button>

    <!-- Dropdown Menu -->
    <div x-show="resumeDropdown"
         @click.away="resumeDropdown = false"
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-50">

        <!-- Create Resume -->
        <a href="{{ route('seeker.resumes.create') }}"
           class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors duration-150 group">
            <i class="fa-solid fa-plus-circle mr-3 text-gray-400 group-hover:text-blue-600"></i>
            Create New Resume
        </a>

        <!-- View/Edit Resume -->
        @auth
            @php
                $user = auth()->user();
                $hasResume = $user->resume ?? false;
            @endphp
            @if($hasResume)
                <a href="{{ route('seeker.resumes.edit', $user->resume->id) }}"
                   class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors duration-150 group">
                    <i class="fa-solid fa-edit mr-3 text-gray-400 group-hover:text-blue-600"></i>
                    Edit My Resume
                </a>

                <a href="{{ route('seeker.resumes.show', $user->resume->id) }}"
                   class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors duration-150 group">
                    <i class="fa-solid fa-eye mr-3 text-gray-400 group-hover:text-blue-600"></i>
                    View Resume
                </a>
            @else
                <div class="flex items-center px-4 py-2 text-sm text-gray-400 cursor-not-allowed">
                    <i class="fa-solid fa-edit mr-3"></i>
                    Edit Resume
                    <span class="ml-2 text-xs bg-gray-100 text-gray-500 px-2 py-1 rounded">No resume</span>
                </div>
            @endif
        @endauth

        <div class="border-t border-gray-100 my-1"></div>

        <!-- Print & Download Section -->
        @auth
            @if($hasResume)
                <!-- Print Resume -->
                <button onclick="printResume()"
                        class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 transition-colors duration-150 group">
                    <i class="fa-solid fa-print mr-3 text-gray-400 group-hover:text-green-600"></i>
                    Print Resume
                </button>

                <!-- Download as PDF -->
                <button onclick="downloadResume()"
                        class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-700 transition-colors duration-150 group">
                    <i class="fa-solid fa-download mr-3 text-gray-400 group-hover:text-purple-600"></i>
                    Download PDF
                </button>

                <!-- Share Resume -->
                <button onclick="shareResume()"
                        class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors duration-150 group">
                    <i class="fa-solid fa-share-alt mr-3 text-gray-400 group-hover:text-blue-600"></i>
                    Share Resume
                </button>
            @else
                <!-- Disabled actions when no resume -->
                <div class="flex items-center px-4 py-2 text-sm text-gray-400 cursor-not-allowed">
                    <i class="fa-solid fa-print mr-3"></i>
                    Print Resume
                </div>
                <div class="flex items-center px-4 py-2 text-sm text-gray-400 cursor-not-allowed">
                    <i class="fa-solid fa-download mr-3"></i>
                    Download PDF
                </div>
                <div class="flex items-center px-4 py-2 text-sm text-gray-400 cursor-not-allowed">
                    <i class="fa-solid fa-share-alt mr-3"></i>
                    Share Resume
                </div>
            @endif
        @endauth

        <!-- Resume Statistics -->
        @auth
            @if($hasResume)
                <div class="border-t border-gray-100 mt-2 pt-2 px-4">
                    <div class="text-xs text-gray-500 mb-1">Resume Status</div>
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-green-600 font-medium">Complete</span>
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full">100%</span>
                    </div>
                </div>
            @else
                <div class="border-t border-gray-100 mt-2 pt-2 px-4">
                    <div class="text-xs text-gray-500 mb-1">Resume Status</div>
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-yellow-600">Not Created</span>
                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full">0%</span>
                    </div>
                </div>
            @endif
        @endauth
    </div>
</div>

@push('scripts')
<script>
function printResume() {
    // You can implement print functionality here
    // For now, redirect to print-friendly resume page
    @if(isset($user) && $user->resume)
        window.open("{{ route('seeker.resumes.show', $user->resume->id) }}?print=true", '_blank');
    @else
        alert('Please create a resume first.');
    @endif
}

function downloadResume() {
    // Implement PDF download functionality
    @if(isset($user) && $user->resume)
        // This would typically call your backend to generate PDF
        window.location.href = "{{ route('seeker.resumes.download', $user->resume->id) }}";
    @else
        alert('Please create a resume first.');
    @endif
}

function shareResume() {
    // Implement share functionality
    @if(isset($user) && $user->resume)
        if (navigator.share) {
            navigator.share({
                title: 'My Resume - {{ $user->name }}',
                text: 'Check out my professional resume',
                url: "{{ route('seeker.resumes.show', $user->resume->id) }}"
            })
            .then(() => console.log('Successful share'))
            .catch((error) => console.log('Error sharing:', error));
        } else {
            // Fallback: copy to clipboard
            const url = "{{ route('seeker.resumes.show', $user->resume->id) }}";
            navigator.clipboard.writeText(url).then(() => {
                alert('Resume link copied to clipboard!');
            });
        }
    @else
        alert('Please create a resume first.');
    @endif
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    const dropdowns = document.querySelectorAll('[x-data]');
    dropdowns.forEach(dropdown => {
        if (!dropdown.contains(event.target)) {
            if (dropdown.__x && dropdown.__x.$data.resumeDropdown) {
                dropdown.__x.$data.resumeDropdown = false;
            }
        }
    });
});
</script>
@endpush
