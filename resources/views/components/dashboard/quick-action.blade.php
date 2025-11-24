@props([
    'title',
    'description',
    'link',
    'icon' => 'fa-cog',
    'color' => 'blue'
])

@php
    $colors = [
        'blue' => ['bg' => 'bg-blue-500', 'border' => 'border-blue-500', 'hover' => 'bg-blue-50'],
        'green' => ['bg' => 'bg-green-500', 'border' => 'border-green-500', 'hover' => 'bg-green-50'],
        'purple' => ['bg' => 'bg-purple-500', 'border' => 'border-purple-500', 'hover' => 'bg-purple-50'],
        'orange' => ['bg' => 'bg-orange-500', 'border' => 'border-orange-500', 'hover' => 'bg-orange-50'],
    ];
    $colorConfig = $colors[$color] ?? $colors['blue'];
@endphp

<a href="{{ $link }}"
   class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-{{ $color }}-500 hover:{{ $colorConfig['hover'] }} transition-colors duration-200">
    <div class="flex-shrink-0">
        <div class="w-10 h-10 {{ $colorConfig['bg'] }} rounded-full flex items-center justify-center">
            <i class="fa-solid {{ $icon }} text-white"></i>
        </div>
    </div>
    <div class="ml-4">
        <h4 class="text-sm font-semibold text-gray-900">{{ $title }}</h4>
        <p class="text-sm text-gray-500 mt-1">{{ $description }}</p>
    </div>
</a>
