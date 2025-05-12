<div class="flex min-h-screen font-sans">
    <!-- Sidebar -->
    <aside class="hidden w-64 p-4 space-y-4 font-sans text-white bg-gradient-to-b from-blue-900 to-teal-600 md:block">
        <div class="mb-6 text-xl font-bold">
            @if (file_exists(public_path('logo.svg')))
                {!! file_get_contents(public_path('logo.svg')) !!}
            @else
                <span class="text-teal-300">NM DigitalHub</span>
            @endif
        </div>
        <nav class="space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 hover:text-teal-300 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-900 rounded px-2' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6" />
                </svg>
                Dashboard
            </a>
            <a href="{{ route('admin.users') }}" class="flex items-center gap-2 hover:text-teal-300 {{ request()->routeIs('admin.users') ? 'bg-gray-900 rounded px-2' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m0-5a4 4 0 110-8 4 4 0 010 8z" />
                </svg>
                Users
            </a>
            <a href="{{ route('admin.plans') }}" class="flex items-center gap-2 hover:text-teal-300 {{ request()->routeIs('admin.plans') ? 'bg-gray-900 rounded px-2' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 1.343-3 3v6h6v-6c0-1.657-1.343-3-3-3z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8V6m0 0a2 2 0 012 2v2m-4-2a2 2 0 012-2z" />
                </svg>
                Plans
            </a>
            <a href="{{ route('admin.orders') }}" class="flex items-center gap-2 hover:text-teal-300 {{ request()->routeIs('admin.orders') ? 'bg-gray-900 rounded px-2' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h10M5 20h14" />
                </svg>
                Orders
            </a>
            <a href="{{ route('admin.tickets') }}" class="flex items-center gap-2 hover:text-teal-300 {{ request()->routeIs('admin.tickets') ? 'bg-gray-900 rounded px-2' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Support
            </a>
            <a href="{{ route('admin.settings') }}" class="flex items-center gap-2 hover:text-teal-300 {{ request()->routeIs('admin.settings') ? 'bg-gray-900 rounded px-2' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Settings
            </a>
            <a href="{{ route('logout') }}" class="flex items-center gap-2 mt-8 text-red-400 hover:text-red-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 11-4 0v-1m0-8v-1a2 2 0 114 0v1" />
                </svg>
                Logout
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6 text-gray-900 bg-gray-100 dark:bg-gray-900 dark:text-white font-sans">
        {{ $slot }}
    </main>
</div>
