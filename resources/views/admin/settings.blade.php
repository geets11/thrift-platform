@extends('layouts.app')

@section('title', 'Settings - Thrift Platform')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Settings</h1>
        <p class="mt-2 text-gray-600">Manage your seller account settings</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Settings Navigation -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow p-6">
                <nav class="space-y-2">
                    <a href="#profile" class="block px-4 py-2 text-blue-600 bg-blue-50 rounded-lg font-medium">
                        Profile Settings
                    </a>
                    <a href="#store" class="block px-4 py-2 text-gray-600 hover:bg-gray-50 rounded-lg font-medium">
                        Store Settings
                    </a>
                    <a href="#payment" class="block px-4 py-2 text-gray-600 hover:bg-gray-50 rounded-lg font-medium">
                        Payment Methods
                    </a>
                    <a href="#privacy" class="block px-4 py-2 text-gray-600 hover:bg-gray-50 rounded-lg font-medium">
                        Privacy & Security
                    </a>
                </nav>
            </div>
        </div>

        <!-- Settings Content -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6" id="profile">Profile Settings</h2>
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-2">Store Name</label>
                        <input type="text" value="{{ Auth::user()->name }}" disabled class="w-full border border-gray-300 rounded-lg px-4 py-2 text-gray-700 bg-gray-50">
                        <p class="mt-1 text-sm text-gray-500">Your store name as displayed to buyers</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-2">Email Address</label>
                        <input type="email" value="{{ Auth::user()->email }}" disabled class="w-full border border-gray-300 rounded-lg px-4 py-2 text-gray-700 bg-gray-50">
                        <p class="mt-1 text-sm text-gray-500">Contact information for your account</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-2">Phone Number</label>
                        <input type="tel" value="{{ Auth::user()->phone ?? 'Not provided' }}" disabled class="w-full border border-gray-300 rounded-lg px-4 py-2 text-gray-700 bg-gray-50">
                        <p class="mt-1 text-sm text-gray-500">Optional - for buyer inquiries</p>
                    </div>

                    <div class="pt-4 border-t border-gray-200">
                        <a href="{{ route('profile.edit') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition duration-150">
                            Edit Profile
                        </a>
                    </div>
                </div>
            </div>

            <!-- Other Settings Cards -->
            <div class="mt-8 bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6" id="store">Store Information</h2>
                <p class="text-gray-600 mb-4">Your store is active and ready to receive orders. Manage your products from the admin dashboard.</p>
                <a href="{{ route('admin.products.index') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-medium transition duration-150">
                    Manage Products
                </a>
            </div>

            <!-- Account Actions -->
            <div class="mt-8 bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Account Actions</h2>
                <div class="space-y-4">
                    <button class="block w-full text-left px-4 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 font-medium text-gray-900">
                        Change Password
                    </button>
                    <button class="block w-full text-left px-4 py-3 border border-red-300 text-red-600 rounded-lg hover:bg-red-50 font-medium">
                        Deactivate Store
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
