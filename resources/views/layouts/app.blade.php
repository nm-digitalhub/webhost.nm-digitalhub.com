<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'he' ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @hasSection('meta')
            @yield('meta')
        @else
            <title>{{ config('app.name', 'NM-DigitalHUB') }}</title>
            <meta name="description" content="NM-DigitalHUB provides reliable web hosting, domain registration, VPS and cloud solutions for businesses of all sizes.">
        @endif

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <!-- Navigation Bar -->
        <nav class="bg-white shadow-lg">
            <div class="px-4 mx-auto max-w-7xl">
                <div class="flex justify-between">
                    <div class="flex space-x-7">
                        <div>
                            <!-- Website Logo -->
                            <a href="{{ route('home') }}" class="flex items-center py-4">
                                <span class="text-lg font-semibold text-gray-800">NM-DigitalHUB</span>
                            </a>
                        </div>
                        <!-- Primary Navigation Menu -->
                        <div class="items-center hidden space-x-1 md:flex">
                            <a href="{{ route('domains') }}" class="px-2 py-4 text-gray-500 transition duration-300 hover:text-blue-500">Domains</a>
                            <a href="{{ route('hosting') }}" class="px-2 py-4 text-gray-500 transition duration-300 hover:text-blue-500">Hosting</a>
                            <a href="{{ route('vps') }}" class="px-2 py-4 text-gray-500 transition duration-300 hover:text-blue-500">VPS</a>
                        </div>
                    </div>
                    <!-- Secondary Navigation Menu -->
                    <div class="items-center hidden space-x-3 md:flex">
                        @auth
                            <a href="{{ route('dashboard') }}" class="px-4 py-2 text-white transition duration-300 bg-blue-600 rounded hover:bg-blue-700">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="px-4 py-2 text-gray-800 transition duration-300 hover:text-blue-500">Log In</a>
                            <a href="{{ route('register') }}" class="px-4 py-2 text-white transition duration-300 bg-blue-600 rounded hover:bg-blue-700">Sign Up</a>
                        @endauth
                    </div>
                    <!-- Mobile Menu Button -->
                    <div class="flex items-center md:hidden">
                        <button class="mobile-menu-button">
                            <svg class="w-6 h-6 text-gray-500 hover:text-blue-500" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                <path d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Mobile Menu -->
            <div class="hidden mobile-menu md:hidden">
                <a href="{{ route('domains') }}" class="block px-4 py-2 text-sm text-gray-500 hover:bg-blue-50">Domains</a>
                <a href="{{ route('hosting') }}" class="block px-4 py-2 text-sm text-gray-500 hover:bg-blue-50">Hosting</a>
                <a href="{{ route('vps') }}" class="block px-4 py-2 text-sm text-gray-500 hover:bg-blue-50">VPS</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-500 hover:bg-blue-50">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="block px-4 py-2 text-sm text-gray-500 hover:bg-blue-50">Log In</a>
                    <a href="{{ route('register') }}" class="block px-4 py-2 text-sm text-gray-500 hover:bg-blue-50">Sign Up</a>
                @endauth
            </div>
        </nav>

        <div class="min-h-screen">
            @hasSection('content')
                @yield('content')
            @else
                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white shadow">
                        <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content from $slot -->
                <main>
                    {{ $slot ?? '' }}
                </main>
            @endif
        </div>

        <!-- Footer -->
        <footer class="py-12 text-white bg-gray-800">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-8 md:grid-cols-4">
                    <div>
                        <h3 class="mb-4 text-lg font-semibold">NM-DigitalHUB</h3>
                        <p class="text-gray-400">Your one-stop solution for domains, hosting, and VPS services.</p>
                    </div>
                    <div>
                        <h4 class="mb-4 font-semibold text-md">Services</h4>
                        <ul class="space-y-2">
                            <li><a href="{{ route('domains') }}" class="text-gray-400 transition hover:text-white">Domains</a></li>
                            <li><a href="{{ route('hosting') }}" class="text-gray-400 transition hover:text-white">Web Hosting</a></li>
                            <li><a href="{{ route('vps') }}" class="text-gray-400 transition hover:text-white">VPS Hosting</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="mb-4 font-semibold text-md">Company</h4>
                        <ul class="space-y-2">
                            <li><a href="{{ route('home') }}#about" class="text-gray-400 transition hover:text-white">About Us</a></li>
                            <li><a href="{{ route('home') }}#contact" class="text-gray-400 transition hover:text-white">Contact</a></li>
                            <li><a href="{{ route('home') }}#faq" class="text-gray-400 transition hover:text-white">FAQ</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="mb-4 font-semibold text-md">Legal</h4>
                        <ul class="space-y-2">
                            <li><a href="{{ route('terms') }}" class="text-gray-400 transition hover:text-white">Terms of Service</a></li>
                            <li><a href="{{ route('policy') }}" class="text-gray-400 transition hover:text-white">Privacy Policy</a></li>
                        </ul>
                    </div>
                </div>
                <div class="pt-8 mt-8 text-center text-gray-400 border-t border-gray-700">
                    <p>&copy; {{ date('Y') }} NM-DigitalHUB. All rights reserved.</p>
                </div>
            </div>
        </footer>

        <script>
            // Mobile menu toggle
            document.addEventListener('DOMContentLoaded', function() {
                const btn = document.querySelector('.mobile-menu-button');
                const menu = document.querySelector('.mobile-menu');

                btn.addEventListener('click', function() {
                    menu.classList.toggle('hidden');
                });
            });
        </script>
    </body>
</html>
