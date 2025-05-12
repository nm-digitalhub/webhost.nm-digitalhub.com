<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'he' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'NM-DigitalHUB') }} - @yield('title', 'Client Portal')</title>
    <meta name="description" content="NM-DigitalHUB Client Portal">
    
    @yield('meta')

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite('resources/css/app.css')

    <!-- Scripts -->
    @vite('resources/js/app.js')

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F9FAFB;
            color: #111827;
        }
        [dir="rtl"] .rtl-flip {
            transform: scaleX(-1);
        }
    </style>

    @livewireStyles
</head>
<body class="antialiased">
    <!-- Impersonation Banner - always at the top -->
    @include('layouts.client-impersonation-banner')
    
    <div class="flex h-screen overflow-hidden bg-gray-100">
        <!-- Sidebar -->
        <div id="sidebar" class="fixed inset-y-0 left-0 z-30 w-64 bg-white shadow transform transition-transform duration-300 ease-in-out md:translate-x-0 {{ app()->getLocale() === 'he' ? 'right-0 left-auto -translate-x-full md:translate-x-0' : '-translate-x-full md:translate-x-0' }}">
            <div class="flex items-center justify-between h-16 px-4 border-b border-gray-200">
                <div class="flex items-center">
                    <svg width="30" height="30" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" class="mr-2">
                        <path d="M20 20 L40 60 L60 20 L80 60" stroke="#0084FF" stroke-width="6" fill="none"/>
                        <circle cx="20" cy="20" r="5" fill="#00CCFF"/>
                        <circle cx="60" cy="20" r="5" fill="#00CCFF"/>
                        <circle cx="80" cy="60" r="5" fill="#00CCFF"/>
                    </svg>
                    <span class="text-[#0084FF] font-bold text-xl">NM</span>
                    <span class="text-lg font-medium text-gray-800">Digital<span class="font-bold">HUB</span></span>
                </div>
                <button id="close-sidebar" class="p-2 rounded-md lg:hidden hover:bg-gray-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="px-2 py-4">
                <!-- Dynamic Sidebar Navigation -->
                @include('layouts.client-dynamic-sidebar')
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex flex-col flex-1 md:pl-64 {{ app()->getLocale() === 'he' ? 'md:pr-64 md:pl-0' : '' }}">
            <!-- Top Navigation -->
            <div class="sticky top-0 z-10 bg-white shadow">
                <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center flex-1">
                        <button id="open-sidebar" class="p-2 -ml-2 rounded-md md:hidden hover:bg-gray-100 {{ app()->getLocale() === 'he' ? 'mr-2 ml-0' : '-ml-2' }}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>

                        <div class="hidden sm:flex">
                            <div class="relative mx-4 rounded-md shadow-sm">
                                <input type="text" class="block w-full py-2 pl-10 pr-3 text-sm placeholder-gray-500 bg-gray-100 border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500" placeholder="Search...">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <!-- Language Switcher -->
                        <div class="relative mx-3">
                            <a href="{{ route('lang.switch', app()->getLocale() === 'en' ? 'he' : 'en') }}" class="flex items-center">
                                <span class="mr-1 text-xs font-medium text-gray-500 uppercase">{{ app()->getLocale() === 'en' ? 'He' : 'En' }}</span>
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129" />
                                </svg>
                            </a>
                        </div>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'he' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'NM-DigitalHUB') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Livewire Styles -->
    @livewireStyles
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">
        <!-- Impersonation Banner -->
        @include('layouts.client-impersonation-banner')

        <div class="flex h-screen bg-gray-100">
            <!-- Sidebar -->
            <div class="sidebar hidden md:block md:w-64 bg-indigo-800 text-white transition-all duration-300 ease-in-out">
                <div class="p-6">
                    <a href="{{ route('client.dashboard') }}" class="text-white flex items-center space-x-3">
                        <img src="{{ asset('img/logo-white.svg') }}" alt="Logo" class="h-8 w-auto">
                        <span class="text-xl font-bold">NM-DigitalHUB</span>
                    </a>
                </div>
                
                @include('layouts.client-dynamic-sidebar')
            </div>

            <!-- Main Content -->
            <div class="flex-1 overflow-y-auto">
                <!-- Top Navigation -->
                <nav class="bg-white shadow-sm sticky top-0 z-10">
                    <div class="mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="flex justify-between h-16">
                            <div class="flex items-center">
                                <!-- Mobile menu button -->
                                <button type="button" class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" id="mobile-menu-button">
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    </svg>
                                </button>
                                <div class="md:hidden ml-3">
                                    <img src="{{ asset('img/logo.svg') }}" alt="Logo" class="h-8 w-auto">
                                </div>
                            </div>

                            <div class="flex items-center">
                                <!-- User Dropdown -->
                                <div class="ml-3 relative">
                                    <x-dropdown align="right" width="48">
                                        <x-slot name="trigger">
                                            <button class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 focus:outline-none transition duration-150 ease-in-out">
                                                <div>{{ Auth::user()->name }}</div>
                                                <div class="ml-1">
                                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            </button>
                                        </x-slot>

                                        <x-slot name="content">
                                            <x-dropdown-link :href="route('client.profile')">
                                                {{ __('Profile') }}
                                            </x-dropdown-link>

                                            <x-dropdown-link :href="route('client.settings')">
                                                {{ __('Settings') }}
                                            </x-dropdown-link>

                                            <!-- Authentication -->
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <x-dropdown-link :href="route('logout')"
                                                        onclick="event.preventDefault();
                                                                this.closest('form').submit();">
                                                    {{ __('Log Out') }}
                                                </x-dropdown-link>
                                            </form>
                                        </x-slot>
                                    </x-dropdown>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>

                <!-- Page Content -->
                <main>
                    {{ $slot }}
                </main>
            </div>
        </div>
    </div>

    <!-- Mobile Sidebar (hidden by default) -->
    <div class="fixed inset-0 z-40 hidden md:hidden" id="mobile-sidebar">
        <div class="fixed inset-0 bg-gray-600 bg-opacity-75"></div>
        
        <div class="relative flex-1 flex flex-col max-w-xs w-full bg-indigo-800 text-white">
            <div class="absolute top-0 right-0 -mr-12 pt-2">
                <button type="button" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" id="close-sidebar-button">
                    <span class="sr-only">Close sidebar</span>
                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <div class="p-6">
                <a href="{{ route('client.dashboard') }}" class="text-white flex items-center space-x-3">
                    <img src="{{ asset('img/logo-white.svg') }}" alt="Logo" class="h-8 w-auto">
                    <span class="text-xl font-bold">NM-DigitalHUB</span>
                </a>
            </div>
            
            @include('layouts.client-dynamic-sidebar')
        </div>
    </div>

    <!-- Livewire Scripts -->
    @livewireScripts
    
    <script>
        // Mobile menu toggle script
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            document.getElementById('mobile-sidebar').classList.remove('hidden');
        });
        
        document.getElementById('close-sidebar-button').addEventListener('click', function() {
            document.getElementById('mobile-sidebar').classList.add('hidden');
        });
    </script>
</body>
</html>
                        <!-- Notifications Dropdown -->
                        <div class="relative">
                            <button class="p-1 text-gray-500 rounded-full hover:bg-gray-100 hover:text-gray-600 focus:outline-none">
                                <span class="sr-only">View notifications</span>
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                            </button>
                        </div>

                        <!-- Profile Dropdown -->
                        <div class="relative ml-3">
                            <button id="profile-dropdown-button" class="flex items-center max-w-xs text-sm bg-white rounded-full focus:outline-none">
                                <span class="sr-only">Open user menu</span>
                                <img class="w-8 h-8 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=0D8ABC&color=fff" alt="User profile picture">
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <main class="flex-1 min-h-screen bg-gray-100">
                <div class="py-6">
                    <div class="px-4 sm:px-6 lg:px-8">
                        @if (session('success'))
                            <div class="p-4 mb-6 rounded-md bg-green-50">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-green-800">
                                            {{ session('success') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="p-4 mb-6 rounded-md bg-red-50">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-red-800">
                                            {{ session('error') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (session('warning'))
                            <div class="p-4 mb-6 rounded-md bg-yellow-50">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-yellow-800">
                                            {{ session('warning') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile sidebar toggle
            const openSidebarButton = document.getElementById('open-sidebar');
            const closeSidebarButton = document.getElementById('close-sidebar');
            const sidebar = document.getElementById('sidebar');

            if (openSidebarButton && closeSidebarButton && sidebar) {
                openSidebarButton.addEventListener('click', function() {
                    sidebar.classList.remove('-translate-x-full');
                });

                closeSidebarButton.addEventListener('click', function() {
                    sidebar.classList.add('-translate-x-full');
                });
            }

            // Profile dropdown
            const profileDropdownButton = document.getElementById('profile-dropdown-button');
            if (profileDropdownButton) {
                profileDropdownButton.addEventListener('click', function() {
                    // Toggle profile dropdown implementation can be added here
                });
            }
        });
    </script>

    @livewireScripts
    @stack('scripts')
</body>
</html>