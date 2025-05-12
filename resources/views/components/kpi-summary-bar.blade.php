<div {{ $attributes->merge(['class' => 'nm-kpi-summary']) }}>
    <div class="p-2 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
        <div class="flex items-center justify-between mb-2">
            <h3 class="text-sm font-medium text-gray-900 dark:text-white">{{ __('System Overview') }}</h3>
            <span class="text-xs text-gray-500 dark:text-gray-400">{{ now()->format('d/m/Y H:i') }}</span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
            <div class="flex items-center p-2 bg-primary-50 dark:bg-primary-900/20 rounded-lg">
                <div class="flex-shrink-0 bg-primary-100 dark:bg-primary-800 p-2 rounded-md">
                    <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <div class="{{ app()->getLocale() === 'he' ? 'mr-3' : 'ml-3' }}">
                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                        {{ \App\Models\User::count() }} {{ __('Users') }}
                    </p>
                    <div class="flex items-center">
                        <div class="system-indicator">
                            <span class="system-indicator-dot status-ok"></span>
                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ __('Active') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="flex items-center p-2 bg-success-50 dark:bg-success-900/20 rounded-lg">
                <div class="flex-shrink-0 bg-success-100 dark:bg-success-800 p-2 rounded-md">
                    <svg class="w-5 h-5 text-success-600 dark:text-success-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <div class="{{ app()->getLocale() === 'he' ? 'mr-3' : 'ml-3' }}">
                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                        {{ \App\Models\Module::where('enabled', true)->count() }} {{ __('Modules') }}
                    </p>
                    <div class="flex items-center">
                        <div class="system-indicator">
                            <span class="system-indicator-dot status-ok"></span>
                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ __('Active') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="flex items-center p-2 bg-warning-50 dark:bg-warning-900/20 rounded-lg">
                <div class="flex-shrink-0 bg-warning-100 dark:bg-warning-800 p-2 rounded-md">
                    <svg class="w-5 h-5 text-warning-600 dark:text-warning-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="{{ app()->getLocale() === 'he' ? 'mr-3' : 'ml-3' }}">
                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                        {{ __('System Health') }}
                    </p>
                    <div class="flex items-center">
                        <div class="system-indicator">
                            <span class="system-indicator-dot status-warning"></span>
                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ __('Check Issues') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="flex items-center p-2 bg-info-50 dark:bg-info-900/20 rounded-lg">
                <div class="flex-shrink-0 bg-info-100 dark:bg-info-800 p-2 rounded-md">
                    <svg class="w-5 h-5 text-info-600 dark:text-info-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <div class="{{ app()->getLocale() === 'he' ? 'mr-3' : 'ml-3' }}">
                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                        {{ \App\Models\GenerationLog::count() }} {{ __('Generations') }}
                    </p>
                    <div class="flex items-center">
                        <div class="system-indicator">
                            <span class="system-indicator-dot status-ok"></span>
                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ __('All Time') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>