<x-filament-panels::page>
    <x-filament::section>
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
            <x-filament::card>
                <div class="flex items-center gap-4">
                    <div class="p-2 bg-primary-100 dark:bg-primary-600/20 rounded-lg">
                        <x-heroicon-o-chart-bar class="w-8 h-8 text-primary-600 dark:text-primary-500" />
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total Users</p>
                        <p class="text-2xl font-bold">{{ \App\Models\User::count() }}</p>
                    </div>
                </div>
            </x-filament::card>

            <x-filament::card>
                <div class="flex items-center gap-4">
                    <div class="p-2 bg-success-100 dark:bg-success-600/20 rounded-lg">
                        <x-heroicon-o-document-text class="w-8 h-8 text-success-600 dark:text-success-500" />
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Active Projects</p>
                        <p class="text-2xl font-bold">5</p>
                    </div>
                </div>
            </x-filament::card>

            <x-filament::card>
                <div class="flex items-center gap-4">
                    <div class="p-2 bg-warning-100 dark:bg-warning-600/20 rounded-lg">
                        <x-heroicon-o-server class="w-8 h-8 text-warning-600 dark:text-warning-500" />
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Server Status</p>
                        <p class="text-2xl font-bold">Active</p>
                    </div>
                </div>
            </x-filament::card>

            <x-filament::card>
                <div class="flex items-center gap-4">
                    <div class="p-2 bg-danger-100 dark:bg-danger-600/20 rounded-lg">
                        <x-heroicon-o-clock class="w-8 h-8 text-danger-600 dark:text-danger-500" />
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Response Time</p>
                        <p class="text-2xl font-bold">120ms</p>
                    </div>
                </div>
            </x-filament::card>
        </div>
    </x-filament::section>

    <x-filament::section>
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <x-filament::card>
                <h2 class="text-lg font-medium">Recent Activities</h2>

                <div class="mt-4 space-y-4">
                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                        <div class="flex items-center gap-3">
                            <div class="p-1.5 bg-primary-100 dark:bg-primary-600/20 rounded-full">
                                <x-heroicon-o-user class="w-4 h-4 text-primary-600 dark:text-primary-500" />
                            </div>
                            <div>
                                <p class="text-sm font-medium">New user registered</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">john.doe@example.com</p>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">10 minutes ago</p>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                        <div class="flex items-center gap-3">
                            <div class="p-1.5 bg-success-100 dark:bg-success-600/20 rounded-full">
                                <x-heroicon-o-check-circle class="w-4 h-4 text-success-600 dark:text-success-500" />
                            </div>
                            <div>
                                <p class="text-sm font-medium">Project completed</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Website Migration</p>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">1 hour ago</p>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                        <div class="flex items-center gap-3">
                            <div class="p-1.5 bg-warning-100 dark:bg-warning-600/20 rounded-full">
                                <x-heroicon-o-exclamation class="w-4 h-4 text-warning-600 dark:text-warning-500" />
                            </div>
                            <div>
                                <p class="text-sm font-medium">Server warning</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">High memory usage</p>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">3 hours ago</p>
                    </div>
                </div>
            </x-filament::card>
<x-filament-panels::page>
    <x-filament::section>
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
            <x-filament::card>
                <div class="flex items-center gap-4">
                    <div class="p-2 bg-primary-100 dark:bg-primary-600/20 rounded-lg">
                        <x-heroicon-o-chart-bar class="w-8 h-8 text-primary-600 dark:text-primary-500" />
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total Users</p>
                        <p class="text-2xl font-bold">{{ \App\Models\User::count() }}</p>
                    </div>
                </div>
            </x-filament::card>

            <x-filament::card>
                <div class="flex items-center gap-4">
                    <div class="p-2 bg-success-100 dark:bg-success-600/20 rounded-lg">
                        <x-heroicon-o-document-text class="w-8 h-8 text-success-600 dark:text-success-500" />
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">System Status</p>
                        <p class="text-2xl font-bold">Active</p>
                    </div>
                </div>
            </x-filament::card>

            <x-filament::card>
                <div class="flex items-center gap-4">
                    <div class="p-2 bg-warning-100 dark:bg-warning-600/20 rounded-lg">
                        <x-heroicon-o-server class="w-8 h-8 text-warning-600 dark:text-warning-500" />
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Server Status</p>
                        <p class="text-2xl font-bold">Online</p>
                    </div>
                </div>
            </x-filament::card>

            <x-filament::card>
                <div class="flex items-center gap-4">
                    <div class="p-2 bg-danger-100 dark:bg-danger-600/20 rounded-lg">
                        <x-heroicon-o-clock class="w-8 h-8 text-danger-600 dark:text-danger-500" />
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Response Time</p>
                        <p class="text-2xl font-bold">120ms</p>
                    </div>
                </div>
            </x-filament::card>
        </div>
    </x-filament::section>

    <x-filament::section>
        <h2 class="text-xl font-bold mb-4">Welcome to NM DigitalHUB Admin</h2>
        <p class="text-gray-500">This is your administration dashboard for the NM DigitalHUB platform.</p>
    </x-filament::section>
</x-filament-panels::page>
            <x-filament::card>
                <h2 class="text-lg font-medium">System Information</h2>

                <div class="mt-4 space-y-3">
                    <div class="flex justify-between">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Laravel Version</p>
                        <p class="text-sm font-medium">{{ app()->version() }}</p>
                    </div>

                    <div class="flex justify-between">
                        <p class="text-sm text-gray-500 dark:text-gray-400">PHP Version</p>
                        <p class="text-sm font-medium">{{ phpversion() }}</p>
                    </div>

                    <div class="flex justify-between">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Database</p>
                        <p class="text-sm font-medium">{{ config('database.default') }}</p>
                    </div>

                    <div class="flex justify-between">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Environment</p>
                        <p class="text-sm font-medium">{{ config('app.env') }}</p>
                    </div>

                    <div class="flex justify-between">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Debug Mode</p>
                        <p class="text-sm font-medium">{{ config('app.debug') ? 'Enabled' : 'Disabled' }}</p>
                    </div>
                </div>
            </x-filament::card>
        </div>
    </x-filament::section>
</x-filament-panels::page>
