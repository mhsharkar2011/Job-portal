@props(['role', 'title', 'actions' => []])

@if(auth()->user()->hasRole($role))
<div class="mb-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-900">{{ $title }} Dashboard</h2>
        <div class="flex space-x-3">
            {{ $actions }}
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        {{ $stats }}
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{ $content }}
    </div>
</div>
@endif  
