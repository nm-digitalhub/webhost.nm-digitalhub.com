<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'he' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'NM-DigitalHUB') }} - Admin Panel - @yield('title', 'Dashboard')</title>
    <meta name="description" content="NM-DigitalHUB Admin Dashboard">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite('resources/css/app.css')
    @vite('resources/css/admin.css')

    <!-- Scripts -->
    @vite('resources/js/app.js')
    @vite('resources/js/admin.js')

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to bottom right, #f9fafb, #eef1f5);
            color: #111827;
        }
        [dir="rtl"] .rtl-flip {
            transform: scaleX(-1);
        }
        #language-dropdown {
            transition: all 0.2s ease-in-out;
            transform-origin: top right;
        }
    </style>

    @stack('styles')

    @livewireStyles
</head>
<body class="antialiased">
    <div class="flex h-screen overflow-hidden bg-gray-100">
        <!-- Sidebar -->
        <div id="sidebar" class="fixed inset-y-0 left-0 z-30 w-64 bg-[#0B1120] text-white transform transition-transform duration-300 ease-in-out md:translate-x-0">
            <div class="flex items-center justify-between h-16 px-4 bg-[#0A0F1A] border-b border-gray-800">
                <div class="flex items-center">
                    <img class="w-8 h-8 mr-2 rounded-full" src="{{ asset('images/admin-avatar.svg') }}" alt="Admin">
                    <span class="text-[#0084FF] font-bold text-xl">NM</span>
                    <span class="text-lg font-medium text-white">Digital<span class="font-bold">HUB</span></span>
                </div>
                <button id="close-sidebar" class="p-2 rounded-md lg:hidden hover:bg-gray-800 hover:scale-[1.02] transition-transform duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="py-4">
                <div class="px-4 py-2 text-xs text-gray-400 uppercase">
                    Main
                </div>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-[#1C2635] hover:text-white hover:scale-[1.02] transition-transform duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-[#1C2635] text-white' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Dashboard
                </a>

                <div class="px-4 py-2 mt-4 text-xs text-gray-400 uppercase">
                    Domains & Hosting
                </div>
                <a href="{{ route('admin.domains') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-[#1C2635] hover:text-white hover:scale-[1.02] transition-transform duration-200 {{ request()->routeIs('admin.domains*') ? 'bg-[#1C2635] text-white' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                    </svg>
                    Domain Management
                </a>
                <a href="{{ route('admin.hosting') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-[#1C2635] hover:text-white hover:scale-[1.02] transition-transform duration-200 {{ request()->routeIs('admin.hosting*') ? 'bg-[#1C2635] text-white' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                    </svg>
                    Hosting Plans
                </a>
                <a href="{{ route('admin.vps') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-[#1C2635] hover:text-white hover:scale-[1.02] transition-transform duration-200 {{ request()->routeIs('admin.vps*') ? 'bg-[#1C2635] text-white' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                    </svg>
                    VPS Solutions
                </a>

                <div class="px-4 py-2 mt-4 text-xs text-gray-400 uppercase">
                    Users & Billing
                </div>
                <a href="{{ route('admin.users') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-[#1C2635] hover:text-white hover:scale-[1.02] transition-transform duration-200 {{ request()->routeIs('admin.users*') ? 'bg-[#1C2635] text-white' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    Users
                </a>
                <a href="{{ route('admin.invoices') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-[#1C2635] hover:text-white hover:scale-[1.02] transition-transform duration-200 {{ request()->routeIs('admin.invoices*') ? 'bg-[#1C2635] text-white' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    Invoices
                </a>
                <a href="{{ route('admin.payment-gateways') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-[#1C2635] hover:text-white hover:scale-[1.02] transition-transform duration-200 {{ request()->routeIs('admin.payment-gateways*') ? 'bg-[#1C2635] text-white' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                    Payment Gateways
                </a>
                <a href="{{ route('admin.webhook-logs') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-[#1C2635] hover:text-white hover:scale-[1.02] transition-transform duration-200 {{ request()->routeIs('admin.webhook-logs*') ? 'bg-[#1C2635] text-white' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    Webhook Logs
                </a>

                <div class="px-4 py-2 mt-4 text-xs text-gray-400 uppercase">
                    Settings
                </div>
                <a href="{{ route('admin.settings') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-[#1C2635] hover:text-white hover:scale-[1.02] transition-transform duration-200 {{ request()->routeIs('admin.settings*') ? 'bg-[#1C2635] text-white' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    General Settings
                </a>
                <a href="{{ route('admin.translations') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-[#1C2635] hover:text-white hover:scale-[1.02] transition-transform duration-200 {{ request()->routeIs('admin.translations*') ? 'bg-[#1C2635] text-white' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
                    </svg>
                    Translations
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto md:ml-64">
            <!-- Top Navigation -->
            <div class="sticky top-0 z-20 shadow-sm bg-white/80 backdrop-blur-md">
                <div class="flex items-center justify-between h-16 px-4">
                    <button id="open-sidebar" class="p-2 rounded-md lg:hidden hover:bg-gray-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <button id="language-dropdown-button" class="flex items-center text-gray-700 focus:outline-none">
                                <span class="mr-1">{{ strtoupper(app()->getLocale()) }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div id="language-dropdown" class="absolute right-0 z-50 hidden w-32 mt-2 bg-white rounded-md shadow-lg">
                                <a href="{{ route('language.switch', ['locale' => 'en']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">English</a>
                                <a href="{{ route('language.switch', ['locale' => 'he']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Hebrew</a>
                            </div>
                        </div>

                        <div class="relative">
                            <button id="user-dropdown-button" class="flex items-center text-gray-700 focus:outline-none">
                                <img class="w-8 h-8 mr-2 rounded-full" src="{{ asset('images/admin-avatar.svg') }}" alt="Admin">
                                <span class="hidden mr-1 md:inline-block">Admin</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div id="user-dropdown" class="absolute right-0 z-50 hidden w-48 mt-2 bg-white rounded-md shadow-lg">
                                <a href="{{ route('admin.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Your Profile</a>
                                <a href="{{ route('admin.settings') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                                <div class="border-t border-gray-100"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                        Sign out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <div class="p-6">
                @if (session('success'))
                <div class="p-4 mb-6 text-green-700 bg-green-100 border-l-4 border-green-500" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
                @endif

                @if (session('error'))
                <div class="p-4 mb-6 text-red-700 bg-red-100 border-l-4 border-red-500" role="alert">
                    <p>{{ session('error') }}</p>
                </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    @livewireScripts

    @stack('scripts')

    <script>
        // Sidebar toggle for mobile
        document.getElementById('open-sidebar').addEventListener('click', function() {
            document.getElementById('sidebar').classList.remove('-translate-x-full');
        });

        document.getElementById('close-sidebar').addEventListener('click', function() {
            document.getElementById('sidebar').classList.add('-translate-x-full');
        });

        // Language dropdown toggle
        document.getElementById('language-dropdown-button').addEventListener('click', function() {
            document.getElementById('language-dropdown').classList.toggle('hidden');
        });

        // User dropdown toggle
        document.getElementById('user-dropdown-button').addEventListener('click', function() {
            document.getElementById('user-dropdown').classList.toggle('hidden');
        });

        // Close dropdowns when clicking outside
        window.addEventListener('click', function(e) {
            if (!document.getElementById('language-dropdown-button').contains(e.target)) {
                document.getElementById('language-dropdown').classList.add('hidden');
            }

            if (!document.getElementById('user-dropdown-button').contains(e.target)) {
                document.getElementById('user-dropdown').classList.add('hidden');
            }
        });
    </script>
</body>
</html>
