<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'he' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'NM-DigitalHUB') }} - @yield('title', 'לוח בקרה')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles

    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Heebo', sans-serif;
            /* Tailwind apply for bg color by mode */
            @apply bg-gray-50 dark:bg-[#0d1117];
        }
        [x-cloak] { display: none !important; }
    </style>

    @stack('styles')
</head>
<body class="font-sans antialiased text-gray-800 bg-gray-50 dark:bg-gray-900 dark:text-gray-200">
    <div class="flex min-h-screen">
        <!-- Sidebar Navigation -->
        <aside x-data="{ open: false }" @click.away="open = false"
               class="fixed top-0 right-0 z-20 w-64 h-screen transition-transform transform lg:translate-x-0 lg:relative lg:shadow-none rtl:left-0 rtl:right-auto"
               :class="{'translate-x-0 shadow-xl': open, 'translate-x-full rtl:-translate-x-full': !open}">
            <div class="h-full overflow-y-auto bg-white shadow-lg dark:bg-gray-800">
                <!-- Logo -->
                <div class="flex items-center justify-between px-6 py-4">
                    <a href="{{ route('client.dashboard') }}" class="flex items-center">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8">
                        <span class="text-xl font-semibold text-blue-600 ms-2 dark:text-blue-400">DigitalHUB</span>
                    </a>
                    <button @click="open = false" class="text-gray-500 lg:hidden hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Navigation Links -->
                <nav class="px-3 mt-5">
                    <a href="{{ route('client.dashboard') }}" class="group flex items-center px-3 py-2 rounded-md mb-1 {{ request()->routeIs('client.dashboard') ? 'bg-blue-500 text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-blue-100 dark:hover:bg-blue-800 hover:text-blue-600 dark:hover:text-blue-300' }}">
                        <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span>לוח בקרה</span>
                    </a>
                    <a href="{{ route('client.services') }}" class="group flex items-center px-3 py-2 rounded-md mb-1 {{ request()->routeIs('client.services*') ? 'bg-blue-500 text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-blue-100 dark:hover:bg-blue-800 hover:text-blue-600 dark:hover:text-blue-300' }}">
                        <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        <span>השירותים שלי</span>
                    </a>
                    <a href="{{ route('client.invoices') }}" class="group flex items-center px-3 py-2 rounded-md mb-1 {{ request()->routeIs('client.invoices*') ? 'bg-blue-500 text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-blue-100 dark:hover:bg-blue-800 hover:text-blue-600 dark:hover:text-blue-300' }}">
                        <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <span>חשבוניות</span>
                    </a>
                    <a href="{{ route('client.tickets') }}" class="group flex items-center px-3 py-2 rounded-md mb-1 {{ request()->routeIs('client.tickets*') ? 'bg-blue-500 text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-blue-100 dark:hover:bg-blue-800 hover:text-blue-600 dark:hover:text-blue-300' }}">
                        <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                        </svg>
                        <span>תמיכה</span>
                    </a>
                </nav>

                <!-- User Profile -->
                <div class="px-3 py-4 mt-auto border-t border-gray-200 dark:border-gray-700">
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center w-full px-3 py-2 text-left rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
                            <img src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}" class="w-8 h-8 mr-2 rounded-full">
                            <div class="flex-1 min-w-0">
                                <span class="block text-sm font-medium truncate">{{ auth()->user()->name }}</span>
                                <span class="block text-xs text-gray-500 truncate dark:text-gray-400">{{ auth()->user()->email }}</span>
                            </div>
                            <svg class="w-5 h-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false" x-cloak
                             class="absolute right-0 z-10 w-full mb-1 bg-white rounded-md shadow-lg bottom-full dark:bg-gray-800">
                            <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                פרופיל
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full px-4 py-2 text-sm text-right text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    התנתק
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1">
            <!-- Top Navigation Bar -->
            <div class="bg-white shadow-sm dark:bg-gray-800">
                <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Mobile Menu Button -->
                            <button @click="open = true" class="inline-flex items-center p-2 text-gray-500 rounded-md lg:hidden hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 focus:outline-none">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>

                            <div class="flex items-center flex-shrink-0 lg:hidden">
                                <a href="{{ route('client.dashboard') }}">
                                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8">
                                </a>
                            </div>
                        </div>

                        <div class="flex lg:items-center">
                            <!-- Theme Switcher -->
                            <button x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }"
                                    x-init="$watch('darkMode', val => { localStorage.setItem('darkMode', val); if (val) { document.documentElement.classList.add('dark') } else { document.documentElement.classList.remove('dark') } })"
                                    @click="darkMode = !darkMode"
                                    class="p-2 ml-0 text-gray-500 rounded-full hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 lg:ml-2">
                                <svg x-show="!darkMode" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <svg x-show="darkMode" x-cloak class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                                </svg>
                            </button>

                            <!-- Notifications -->
                            <div x-data="{ open: false }" class="relative ml-3">
                                <button @click="open = !open" class="relative p-2 text-gray-500 rounded-full hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                    <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-500 rounded-full">3</span>
                                </button>
                                <div x-show="open" @click.away="open = false" x-cloak
                                     class="absolute right-0 z-10 mt-2 origin-top-right bg-white rounded-md shadow-lg w-80 dark:bg-gray-800 ring-1 ring-black ring-opacity-5">
                                    <div class="p-3 border-b border-gray-200 dark:border-gray-700">
                                        <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300">התראות</h3>
                                    </div>
                                    <div class="overflow-y-auto max-h-72">
                                        <a href="#" class="block px-4 py-3 text-sm text-gray-700 border-b border-gray-200 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 dark:border-gray-700">
                                            <div class="font-medium">חידוש שירות</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">שירות האחסון שלך יתחדש בעוד 3 ימים</div>
                                            <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">לפני שעה</div>
                                        </a>
                                        <a href="#" class="block px-4 py-3 text-sm text-gray-700 border-b border-gray-200 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 dark:border-gray-700">
                                            <div class="font-medium">חשבונית חדשה</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">נוצרה חשבונית חדשה #INV-2023-05</div>
                                            <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">לפני יומיים</div>
                                        </a>
                                        <a href="#" class="block px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <div class="font-medium">עדכון למערכת</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">המערכת תעבור תחזוקה מתוכננת ב-15/6</div>
                                            <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">לפני 3 ימים</div>
                                        </a>
                                    </div>
                                    <div class="p-2 border-t border-gray-200 dark:border-gray-700">
                                        <a href="#" class="block text-sm font-medium text-center text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                            הצג את כל ההתראות
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <div class="py-6">
                <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div class="px-4 py-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
                        @yield('content')
                    </div>
                </div>
            </div>
        </main>
    </div>

    @stack('modals')
    @livewireScripts
    @stack('scripts')
</body>
</html>
