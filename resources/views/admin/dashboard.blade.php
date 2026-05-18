@extends('layouts.app')

@section('title', 'Admin Dashboard - Thrift Platform')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>
        <p class="mt-2 text-gray-600">Welcome to your seller dashboard</p>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-1">
                    <p class="text-gray-600 text-sm font-medium">Total Products</p>
                    @php
                        $totalProducts = Auth::user()->products()->count() ?? 0;
                    @endphp
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalProducts }}</p>
                </div>
                <div class="bg-blue-100 rounded-lg p-3">
                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-1">
                    <p class="text-gray-600 text-sm font-medium">Active Listings</p>
                    @php
                        $activeProducts = Auth::user()->products()->where('status', 'active')->count() ?? 0;
                    @endphp
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $activeProducts }}</p>
                </div>
                <div class="bg-green-100 rounded-lg p-3">
                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-1">
                    <p class="text-gray-600 text-sm font-medium">Pending Items</p>
                    @php
                        $pendingProducts = Auth::user()->products()->where('status', 'inactive')->count() ?? 0;
                    @endphp
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $pendingProducts }}</p>
                </div>
                <div class="bg-yellow-100 rounded-lg p-3">
                    <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 1015 15.172V17z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-1">
                    <p class="text-gray-600 text-sm font-medium">Sold Items</p>
                    @php
                        $soldProducts = Auth::user()->products()->where('status', 'sold')->count() ?? 0;
                    @endphp
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $soldProducts }}</p>
                </div>
                <div class="bg-purple-100 rounded-lg p-3">
                    <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Quick Actions</h2>
            <div class="space-y-3">
                <a href="{{ route('admin.products.create') }}" class="block w-full text-center bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition duration-150">
                    Add New Product
                </a>
                <a href="{{ route('admin.products.index') }}" class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition duration-150">
                    Manage Products
                </a>
                <a href="{{ route('admin.notifications') }}" class="block w-full text-center bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg font-medium transition duration-150">
                    View Notifications
                </a>
                <a href="{{ route('admin.settings') }}" class="block w-full text-center bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition duration-150">
                    Settings
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Getting Started</h2>
            <div class="space-y-3 text-sm text-gray-600">
                <p><strong>Welcome to Thrift Platform!</strong></p>
                <p>Start by adding your first product to your store. You can manage all your listings and track sales from this dashboard.</p>
                <p class="mt-4">For help and support, contact us anytime.</p>
            </div>
        </div>
    </div>
</div>
@endsection
