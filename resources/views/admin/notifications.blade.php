@extends('layouts.app')

@section('title', 'Notifications - Thrift Platform')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Notifications</h1>
        <p class="mt-2 text-gray-600">View all your notifications and messages</p>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="p-8 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 1015 15.172V17z" />
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No notifications</h3>
            <p class="text-gray-600 mb-4">You're all caught up! You'll see notifications here when someone shows interest in your products.</p>
            <a href="{{ route('admin.dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition duration-150">
                Back to Dashboard
            </a>
        </div>
    </div>
</div>
@endsection
