<x-filament::section>
    <div class="p-4 bg-primary-50 dark:bg-primary-800/20 rounded-xl border border-primary-200 dark:border-primary-800">
        <div class="flex items-center gap-4">
            <div class="flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-medium text-primary-900 dark:text-primary-400">NM DigitalHub Admin Panel</h3>
                <p class="text-sm text-primary-700 dark:text-primary-300">
                    Built with Laravel {{ app()->version() }} and Filament 3. Need help? Contact your system administrator.
                </p>
            </div>
        </div>
    </div>
</x-filament::section>
<x-filament::section>
    <div class="p-4 bg-primary-50 dark:bg-primary-800/20 rounded-xl border border-primary-200 dark:border-primary-800">
        <div class="flex items-center gap-4">
            <div class="flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-medium text-primary-900 dark:text-primary-400">NM DigitalHUB Admin Panel</h3>
                <p class="text-sm text-primary-700 dark:text-primary-300">
                    Built with Laravel {{ app()->version() }} and Filament 3.
                </p>
            </div>
        </div>
    </div>
</x-filament::section>
<x-filament::section>
    <div class="flex items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold tracking-tight">
                {{ config('app.name') }} System Information
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Application and environment statistics
            </p>
        </div>
        <div class="shrink-0">
            <x-filament::icon-button
                icon="heroicon-o-information-circle"
                label="View more information"
                href="{{ route('filament.admin.pages.dashboard') }}"
            />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-3 lg:grid-cols-4 mt-4">
        <x-filament::card>
            <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Laravel Version
            </div>
            <div class="text-3xl font-semibold">
                {{ app()->version() }}
            </div>
        </x-filament::card>

        <x-filament::card>
            <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
                PHP Version
            </div>
            <div class="text-3xl font-semibold">
                {{ PHP_VERSION }}
            </div>
        </x-filament::card>

        <x-filament::card>
            <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Environment
            </div>
            <div class="text-3xl font-semibold">
                {{ app()->environment() }}
            </div>
        </x-filament::card>

        <x-filament::card>
            <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Database
            </div>
            <div class="text-3xl font-semibold">
                {{ config('database.default') }}
            </div>
        </x-filament::card>
    </div>
</x-filament::section>
