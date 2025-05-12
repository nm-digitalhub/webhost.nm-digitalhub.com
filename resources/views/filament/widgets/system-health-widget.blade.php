<x-filament::section>
    <x-slot name="heading">
        System Health Status
    </x-slot>
    
    <x-slot name="description">
        Real-time monitoring of system components
    </x-slot>
    
    <div class="space-y-4">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
            @foreach ($healthChecks as $check)
                <div class="flex items-start p-4 bg-white rounded-lg shadow dark:bg-gray-800 border-l-4
                    @if($check['status'] === 'passing')
                        border-success-500 dark:border-success-400
                    @elseif($check['status'] === 'warning')
                        border-warning-500 dark:border-warning-400
                    @else
                        border-danger-500 dark:border-danger-400
                    @endif
                ">
                    <div class="flex-shrink-0 p-2 rounded-md
                        @if($check['status'] === 'passing')
                            text-success-500 bg-success-100 dark:bg-success-900/20 dark:text-success-400
                        @elseif($check['status'] === 'warning')
                            text-warning-500 bg-warning-100 dark:bg-warning-900/20 dark:text-warning-400
                        @else
                            text-danger-500 bg-danger-100 dark:bg-danger-900/20 dark:text-danger-400
                        @endif
                    ">
                        @if(isset($check['icon']))
                            <x-dynamic-component :component="$check['icon']" class="w-5 h-5" />
                        @elseif($check['status'] === 'passing')
                            <x-heroicon-o-check-circle class="w-5 h-5" />
                        @elseif($check['status'] === 'warning')
                            <x-heroicon-o-exclamation-triangle class="w-5 h-5" />
                        @else
                            <x-heroicon-o-x-circle class="w-5 h-5" />
                        @endif
                    </div>
                    
                    <div class="ms-3 rtl:me-3 rtl:ms-0">
                        <h3 class="text-sm font-medium text-gray-900 dark:text-white">
                            {{ $check['name'] }}
                        </h3>
                        <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            {{ $check['message'] }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="flex justify-end">
            <x-filament::button
                color="gray"
                icon="heroicon-o-arrow-path"
                wire:click="$refresh"
                wire:loading.attr="disabled"
                size="sm"
            >
                <span wire:loading.class="opacity-50">
                    Refresh Status
                </span>
            </x-filament::button>
        </div>
    </div>
</x-filament::section>