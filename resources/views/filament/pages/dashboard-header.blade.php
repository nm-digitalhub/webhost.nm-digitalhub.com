<x-kpi-summary-bar/>
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight md:text-3xl">
                {{ config('app.name') }} Dashboard
            </h1>
            <p class="mt-2 text-lg text-gray-600 dark:text-gray-400">
                Welcome to the admin dashboard for {{ config('app.name') }}.
            </p>
        </div>
        
        <div class="hidden space-x-4 sm:flex">
            @if(auth()->user()->hasRole('admin'))
                <x-filament::button
                    color="success"
                    icon="heroicon-o-plus"
                    href="{{ route('filament.admin.resources.users.create') }}"
                >
                    Add User
                </x-filament::button>
            @endif
            
            <x-filament::button
                icon="heroicon-o-clipboard-document-list"
                href="{{ route('filament.admin.pages.dashboard') }}"
            >
                View Reports
            </x-filament::button>
        </div>
    </div>
    
    <div class="mt-4 border-t border-gray-200 dark:border-gray-800 pt-4">
        <p class="text-sm text-gray-500 dark:text-gray-400">
            Last login: {{ auth()->user()->updated_at->format('F j, Y, g:i a') }}
        </p>
    </div>
</div>
<div class="mb-4">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold tracking-tight md:text-2xl">
                {{ __('Welcome to NM-DigitalHUB Admin') }}
            </h2>
            
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                {{ __('Monitor your system metrics and manage resources efficiently') }}
            </p>
        </div>
        
        <div class="flex items-center gap-4">
            <div class="hidden md:flex items-center gap-2">
                <span class="text-sm text-gray-500 dark:text-gray-400">{{ __('Server Time') }}:</span>
                <span class="text-sm font-medium">{{ now()->format('H:i') }}</span>
            </div>
            
            <!-- Mobile responsive action buttons -->
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('admin.dashboard') }}" class="filament-button filament-button-size-sm inline-flex items-center justify-center gap-1 font-medium rounded-lg border transition-colors focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-8 px-3 text-sm text-gray-800 bg-white border-gray-300 hover:bg-gray-50 dark:text-white dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                    <x-heroicon-o-arrow-path class="w-4 h-4"/>
                    <span class="hidden sm:inline">{{ __('Refresh') }}</span>
                </a>
                
                <a href="{{ route('admin.settings') }}" class="filament-button filament-button-size-sm inline-flex items-center justify-center gap-1 font-medium rounded-lg border transition-colors focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-8 px-3 text-sm text-gray-800 bg-white border-gray-300 hover:bg-gray-50 dark:text-white dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                    <x-heroicon-o-cog-6-tooth class="w-4 h-4"/>
                    <span class="hidden sm:inline">{{ __('Settings') }}</span>
                </a>
            </div>
        </div>
    </div>
</div>