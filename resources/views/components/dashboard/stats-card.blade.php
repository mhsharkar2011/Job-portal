@props([
    'title',
    'value' => 0,
    'icon' => 'fa-chart-line',
    'color' => 'blue',
    'link' => null,
    'linkText' => 'View details',
    'iconBg' => null
])

@php
    $colors = [
        'blue' => ['bg' => 'bg-blue-500', 'text' => 'text-blue-600', 'hover' => 'text-blue-900', 'light' => 'bg-blue-50'],
        'green' => ['bg' => 'bg-green-500', 'text' => 'text-green-600', 'hover' => 'text-green-900', 'light' => 'bg-green-50'],
        'purple' => ['bg' => 'bg-purple-500', 'text' => 'text-purple-600', 'hover' => 'text-purple-900', 'light' => 'bg-purple-50'],
        'yellow' => ['bg' => 'bg-yellow-500', 'text' => 'text-yellow-600', 'hover' => 'text-yellow-900', 'light' => 'bg-yellow-50'],
        'red' => ['bg' => 'bg-red-500', 'text' => 'text-red-600', 'hover' => 'text-red-900', 'light' => 'bg-red-50'],
        'orange' => ['bg' => 'bg-orange-500', 'text' => 'text-orange-600', 'hover' => 'text-orange-900', 'light' => 'bg-orange-50'],
    ];
    $colorConfig = $colors[$color] ?? $colors['blue'];
    $iconBackground = $iconBg ?? $colorConfig['bg'];
@endphp

<div class="bg-white overflow-hidden shadow rounded-lg">
    <div class="p-5">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 {{ $iconBackground }} rounded-full flex items-center justify-center">
                    <i class="fa-solid {{ $icon }} text-white text-sm"></i>
                </div>
            </div>
            <div class="ml-5 w-0 flex-1">
                <dl>
                    <dt class="text-sm font-medium text-gray-500 truncate">{{ $title }}</dt>
                    <dd class="text-lg font-semibold text-gray-900">{{ $value }}</dd>
                </dl>
            </div>
        </div>
    </div>
    @if($link)
    <div class="bg-gray-50 px-5 py-3">
        <div class="text-sm">
            <a href="{{ $link }}" class="font-medium {{ $colorConfig['text'] }} hover:{{ $colorConfig['hover'] }}">
                {{ $linkText }}
            </a>
        </div>
    </div>
    @endif
</div>
