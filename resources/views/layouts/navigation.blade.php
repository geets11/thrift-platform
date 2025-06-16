<nav class="bg-white shadow-sm border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center">
                    <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <span class="ml-2 text-xl font-bold text-gray-900">ThriftPlatform</span>
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('shop.index') }}" class="text-gray-700 hover:text-green-600 px-3 py-2 text-sm font-medium transition duration-150 ease-in-out">
                    Shop
                </a>
                <a href="{{ route('categories.index') }}" class="text-gray-700 hover:text-green-600 px-3 py-2 text-sm font-medium transition duration-150 ease-in-out">
                    Categories
                </a>
                <a href="{{ route('about') }}" class="text-gray-700 hover:text-green-600 px-3 py-2 text-sm font-medium transition duration-150 ease-in-out">
                    About
                </a>
                <a href="{{ route('contact') }}" class="text-gray-700 hover:text-green-600 px-3 py-2 text-sm font-medium transition duration-150 ease-in-out">
                    Contact
                </a>
            </div>

            <!-- Right Side -->
            <div class="flex items-center space-x-4">
                <!-- Cart -->
                <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-700 hover:text-green-600 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.1 5M7 13l-1.1 5m0 0h9.1M17 13v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6" />
                    </svg>
                    @if(session('cart_count', 0) > 0)
                        <span class="absolute -top-1 -right-1 bg-green-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                            {{ session('cart_count', 0) }}
                        </span>
                    @endif
                </a>

                <!-- Authentication -->
                @auth
                    <x-user-menu :user="auth()->user()" />
                @else
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-green-600 px-3 py-2 text-sm font-medium transition duration-150 ease-in-out">
                            Sign In
                        </a>
                        <a href="{{ route('register') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-150 ease-in-out">
                            Sign Up
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    <!-- Mobile menu (hidden by default) -->
    <div class="md:hidden" x-data="{ open: false }">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <a href="{{ route('shop.index') }}" class="text-gray-700 hover:text-green-600 block px-3 py-2 text-base font-medium">Shop</a>
            <a href="{{ route('categories.index') }}" class="text-gray-700 hover:text-green-600 block px-3 py-2 text-base font-medium">Categories</a>
            <a href="{{ route('about') }}" class="text-gray-700 hover:text-green-600 block px-3 py-2 text-base font-medium">About</a>
            <a href="{{ route('contact') }}" class="text-gray-700 hover:text-green-600 block px-3 py-2 text-base font-medium">Contact</a>
        </div>
    </div>
</nav>