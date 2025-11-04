@extends('layouts.app')

@section('title', 'My Companies - ' . config('app.name'))

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">My Companies</h1>
                    <p class="text-gray-600">Manage your company profiles</p>
                </div>
                <a href="{{ route('companies.create') }}"
                   class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition-colors duration-200">
                    <i class="fa-solid fa-plus mr-2"></i>
                    Add Company
                </a>
            </div>
        </div>

        @if($companies->count() > 0)
            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center">
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <i class="fa-solid fa-building text-blue-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Companies</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $companies->total() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center">
                        <div class="p-2 bg-green-100 rounded-lg">
                            <i class="fa-solid fa-briefcase text-green-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Active Jobs</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $companies->sum('jobs_count') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Companies Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($companies as $company)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-200">
                        <!-- Company Header -->
                        <div class="relative">
                            @if($company->banner)
                                <div class="h-32 bg-cover bg-center" style="background-image: url('{{ $company->banner_url }}')"></div>
                            @else
                                <div class="h-32 bg-gradient-to-r from-blue-500 to-purple-600"></div>
                            @endif

                            <!-- Status Badge -->
                            <div class="absolute top-3 right-3">
                                @if($company->is_active)
                                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Active</span>
                                @else
                                    <span class="px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full">Inactive</span>
                                @endif
                            </div>
                        </div>

                        <div class="p-6">
                            <!-- Company Info -->
                            <div class="flex items-center mb-4">
                                @if($company->logo)
                                    <img src="{{ $company->logo_url }}" alt="{{ $company->name }} logo"
                                         class="w-12 h-12 rounded-lg object-cover border mr-4">
                                @else
                                    <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center mr-4">
                                        <i class="fa-solid fa-building text-gray-400"></i>
                                    </div>
                                @endif
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $company->name }}</h3>
                                    <p class="text-sm text-gray-600">{{ $company->industry }}</p>
                                </div>
                            </div>

                            <!-- Company Stats -->
                            <div class="space-y-2 mb-4">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Jobs Posted:</span>
                                    <span class="font-medium">{{ $company->jobs_count }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Location:</span>
                                    <span class="font-medium">{{ $company->location }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Created:</span>
                                    <span class="font-medium">{{ $company->created_at->format('M j, Y') }}</span>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex space-x-2">
                                <a href="{{ route('companies.show', $company) }}"
                                   class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-3 rounded-md transition-colors duration-200 text-sm">
                                    View
                                </a>
                                <a href="{{ route('companies.edit', $company) }}"
                                   class="bg-gray-600 hover:bg-gray-700 text-white py-2 px-3 rounded-md transition-colors duration-200 text-sm">
                                    <i class="fa-solid fa-edit"></i>
                                </a>
                                <a href="{{ route('jobs.create') }}?company={{ $company->id }}"
                                   class="bg-green-600 hover:bg-green-700 text-white py-2 px-3 rounded-md transition-colors duration-200 text-sm">
                                    <i class="fa-solid fa-plus"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $companies->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <i class="fa-solid fa-building text-gray-300 text-6xl mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No Companies Yet</h3>
                <p class="text-gray-600 mb-6">Get started by creating your first company profile.</p>
                <a href="{{ route('companies.create') }}"
                   class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition-colors duration-200">
                    <i class="fa-solid fa-plus mr-2"></i>
                    Create Your First Company
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush
