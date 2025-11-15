<x-app-layout>
    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Simple Header -->
            <div class="bg-white shadow-sm rounded-lg p-6 mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $resume->title ?? 'My Resume' }}</h1>
                        <p class="text-gray-600">Created by {{ $resume->user->name }}</p>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('seeker.resumes.edit', $resume) }}"
                           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Edit
                        </a>
                        <a href="{{ route('dashboard') }}"
                           class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                            Back
                        </a>
                    </div>
                </div>
            </div>

            <!-- Resume Content -->
            <div class="bg-white shadow-sm rounded-lg p-6 space-y-6">
                <!-- Display all resume data -->
                @foreach($resume->getAttributes() as $key => $value)
                    @if(!in_array($key, ['id', 'user_id', 'created_at', 'updated_at']) && $value)
                        <div>
                            <h3 class="font-semibold text-gray-900 capitalize">{{ str_replace('_', ' ', $key) }}</h3>
                            <p class="text-gray-700 mt-1">{{ $value }}</p>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
