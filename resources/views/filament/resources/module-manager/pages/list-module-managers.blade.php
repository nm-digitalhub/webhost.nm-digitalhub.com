<x-filament::page>
    <div class="space-y-6">
        <!-- Filters and Controls -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <!-- Filter Controls -->
            <div class="flex flex-wrap gap-2">
                <div class="relative">
                    <select 
                        wire:model.live="componentFilters.type" 
                        class="block appearance-none w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 hover:border-gray-400 dark:hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
                    >
                        <option value="">כל הסוגים</option>
                        <option value="resources">Resources</option>
                        <option value="pages">Pages</option>
                        <option value="widgets">Widgets</option>
                        <option value="livewire">Livewire</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 dark:text-gray-300">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>
                
                <div class="relative">
                    <select 
                        wire:model.live="componentFilters.source" 
                        class="block appearance-none w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 hover:border-gray-400 dark:hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
                    >
                        <option value="">כל המקורות</option>
                        <option value="generated">מחולל</option>
                        <option value="manual">ידני</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 dark:text-gray-300">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>
                
                <div class="relative">
                    <select 
                        wire:model.live="componentFilters.exists" 
                        class="block appearance-none w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 hover:border-gray-400 dark:hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
                    >
                        <option value="">כל הסטטוסים</option>
                        <option value="1">קיים</option>
                        <option value="0">חסר</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 dark:text-gray-300">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>
                
                <button 
                    wire:click="clearFilters" 
                    class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-gray-200 rounded hover:bg-gray-300 dark:hover:bg-gray-500 transition"
                >
                    נקה פילטרים
                </button>
            </div>
            
            <!-- View Controls -->
            <div class="flex items-center gap-2">
                <span class="text-sm text-gray-600 dark:text-gray-400">סך הכל: {{ $componentCount['total'] }} רכיבים</span>
                
                <div class="ml-2 flex rounded-md shadow-sm">
                    <button 
                        wire:click="$set('viewMode', 'table')" 
                        class="{{ $viewMode === 'table' ? 'bg-primary-600 text-white' : 'bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200' }} relative inline-flex items-center rounded-l-md px-3 py-2 text-sm font-semibold ring-1 ring-inset ring-gray-300 dark:ring-gray-600 focus:z-10"
                    >
                        <x-heroicon-s-table-cells class="w-4 h-4 mr-1" />
                        טבלה
                    </button>
                    <button 
                        wire:click="$set('viewMode', 'category')" 
                        class="{{ $viewMode === 'category' ? 'bg-primary-600 text-white' : 'bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200' }} relative -ml-px inline-flex items-center rounded-r-md px-3 py-2 text-sm font-semibold ring-1 ring-inset ring-gray-300 dark:ring-gray-600 focus:z-10"
                    >
                        <x-heroicon-s-view-columns class="w-4 h-4 mr-1" />
                        קטגוריות
                    </button>
                </div>
            </div>
        </div>
        
        @if($viewMode === 'category')
            <!-- Category View -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                <!-- Tabs -->
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <nav class="-mb-px flex" aria-label="Tabs">
                        <button 
                            wire:click="setActiveTab('resources')"
                            class="{{ $activeTab === 'resources' ? 'border-primary-500 text-primary-600 dark:text-primary-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:border-gray-600' }} w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm"
                        >
                            <span class="flex items-center justify-center">
                                <x-heroicon-o-cube class="w-5 h-5 mr-2" />
                                Resources
                                <span class="ml-2 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-2 py-0.5 rounded-full text-xs font-medium">
                                    {{ $componentCount['resources'] }}
                                </span>
                            </span>
                        </button>
                        
                        <button 
                            wire:click="setActiveTab('pages')"
                            class="{{ $activeTab === 'pages' ? 'border-primary-500 text-primary-600 dark:text-primary-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:border-gray-600' }} w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm"
                        >
                            <span class="flex items-center justify-center">
                                <x-heroicon-o-document-text class="w-5 h-5 mr-2" />
                                Pages
                                <span class="ml-2 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-2 py-0.5 rounded-full text-xs font-medium">
                                    {{ $componentCount['pages'] }}
                                </span>
                            </span>
                        </button>
                        
                        <button 
                            wire:click="setActiveTab('widgets')"
                            class="{{ $activeTab === 'widgets' ? 'border-primary-500 text-primary-600 dark:text-primary-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:border-gray-600' }} w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm"
                        >
                            <span class="flex items-center justify-center">
                                <x-heroicon-o-puzzle-piece class="w-5 h-5 mr-2" />
                                Widgets
                                <span class="ml-2 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-2 py-0.5 rounded-full text-xs font-medium">
                                    {{ $componentCount['widgets'] }}
                                </span>
                            </span>
                        </button>
                        
                        <button 
                            wire:click="setActiveTab('livewire')"
                            class="{{ $activeTab === 'livewire' ? 'border-primary-500 text-primary-600 dark:text-primary-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:border-gray-600' }} w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm"
                        >
                            <span class="flex items-center justify-center">
                                <x-heroicon-o-bolt class="w-5 h-5 mr-2" />
                                Livewire
                                <span class="ml-2 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-2 py-0.5 rounded-full text-xs font-medium">
                                    {{ $componentCount['livewire'] }}
                                </span>
                            </span>
                        </button>
                    </nav>
                </div>
                
                <!-- Tab Content -->
                <div class="p-6">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-right text-sm font-semibold text-gray-900 dark:text-gray-100">
                                        שם הרכיב
                                    </th>
                                    <th scope="col" class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900 dark:text-gray-100">
                                        נתיב
                                    </th>
                                    <th scope="col" class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900 dark:text-gray-100">
                                        קיים
                                    </th>
                                    <th scope="col" class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900 dark:text-gray-100">
                                        מקור
                                    </th>
                                    <th scope="col" class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900 dark:text-gray-100">
                                        עודכן
                                    </th>
                                    <th scope="col" class="relative py-3.5 pl-3 pr-4">
                                        <span class="sr-only">פעולות</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-900">
                                @forelse($activeTabComponents as $component)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-primary-600 dark:text-primary-400">
                                            {{ $component['name'] }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400 font-mono">
                                            {{ Str::limit($component['path'], 40) }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">
                                            @if($component['exists'])
                                                <span class="inline-flex items-center rounded-full bg-green-100 dark:bg-green-900 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:text-green-300">
                                                    <x-heroicon-s-check-circle class="w-4 h-4 mr-1" />
                                                    קיים
                                                </span>
                                            @else
                                                <span class="inline-flex items-center rounded-full bg-red-100 dark:bg-red-900 px-2.5 py-0.5 text-xs font-medium text-red-800 dark:text-red-300">
                                                    <x-heroicon-s-x-circle class="w-4 h-4 mr-1" />
                                                    חסר
                                                </span>
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">
                                            @if($component['is_generated'])
                                                <span class="inline-flex items-center rounded-full bg-blue-100 dark:bg-blue-900 px-2.5 py-0.5 text-xs font-medium text-blue-800 dark:text-blue-300">
                                                    מחולל
                                                </span>
                                            @else
                                                <span class="inline-flex items-center rounded-full bg-gray-100 dark:bg-gray-800 px-2.5 py-0.5 text-xs font-medium text-gray-800 dark:text-gray-300">
                                                    ידני
                                                </span>
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">
                                            {{ \Illuminate\Support\Carbon::parse($component['last_modified'])->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium">
                                            <div class="flex justify-end space-x-2 rtl:space-x-reverse">
                                                <a href="{{ $component['edit_url'] }}" target="_blank" class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300">
                                                    <x-heroicon-s-eye class="w-5 h-5" />
                                                </a>
                                                
                                                @if($component['is_generated'])
                                                    <a href="{{ $component['generator_url'] }}" target="_blank" class="text-warning-600 hover:text-warning-900 dark:text-warning-400 dark:hover:text-warning-300">
                                                        <x-heroicon-s-pencil-square class="w-5 h-5" />
                                                    </a>
                                                @endif
                                                
                                                <a href="{{ route('filament.admin.resources.module-managers.view-code', ['path' => $component['path']]) }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-300">
                                                    <x-heroicon-s-code-bracket class="w-5 h-5" />
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                            לא נמצאו רכיבים מסוג זה
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            <!-- Table View -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-right text-sm font-semibold text-gray-900 dark:text-gray-100 cursor-pointer"
                                    wire:click="toggleSort('name')">
                                    <div class="flex items-center">
                                        <span>שם הרכיב</span>
                                        @if($componentSort['column'] === 'name')
                                            @if($componentSort['direction'] === 'asc')
                                                <x-heroicon-s-chevron-up class="w-4 h-4 mr-1" />
                                            @else
                                                <x-heroicon-s-chevron-down class="w-4 h-4 mr-1" />
                                            @endif
                                        @endif
                                    </div>
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900 dark:text-gray-100 cursor-pointer"
                                    wire:click="toggleSort('type')">
                                    <div class="flex items-center">
                                        <span>סוג</span>
                                        @if($componentSort['column'] === 'type')
                                            @if($componentSort['direction'] === 'asc')
                                                <x-heroicon-s-chevron-up class="w-4 h-4 mr-1" />
                                            @else
                                                <x-heroicon-s-chevron-down class="w-4 h-4 mr-1" />
                                            @endif
                                        @endif
                                    </div>
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900 dark:text-gray-100">
                                    נתיב
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900 dark:text-gray-100">
                                    סטטוס
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900 dark:text-gray-100 cursor-pointer"
                                    wire:click="toggleSort('last_modified')">
                                    <div class="flex items-center">
                                        <span>עודכן</span>
                                        @if($componentSort['column'] === 'last_modified')
                                            @if($componentSort['direction'] === 'asc')
                                                <x-heroicon-s-chevron-up class="w-4 h-4 mr-1" />
                                            @else
                                                <x-heroicon-s-chevron-down class="w-4 h-4 mr-1" />
                                            @endif
                                        @endif
                                    </div>
                                </th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4">
                                    <span class="sr-only">פעולות</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-900">
                            @forelse($sortedFilteredComponents as $component)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-primary-600 dark:text-primary-400">
                                        {{ $component['name'] }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm">
                                        @php
                                            $typeColors = [
                                                'resources' => 'bg-primary-100 text-primary-800 dark:bg-primary-900 dark:text-primary-300',
                                                'pages' => 'bg-success-100 text-success-800 dark:bg-success-900 dark:text-success-300',
                                                'widgets' => 'bg-warning-100 text-warning-800 dark:bg-warning-900 dark:text-warning-300',
                                                'livewire' => 'bg-danger-100 text-danger-800 dark:bg-danger-900 dark:text-danger-300',
                                            ];
                                            
                                            $typeLabels = [
                                                'resources' => 'Resource',
                                                'pages' => 'Page',
                                                'widgets' => 'Widget',
                                                'livewire' => 'Livewire',
                                            ];
                                        @endphp
                                        
                                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $typeColors[$component['type']] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                            {{ $typeLabels[$component['type']] ?? ucfirst($component['type']) }}
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400 font-mono">
                                        {{ Str::limit($component['path'], 30) }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">
                                        <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                            @if($component['exists'])
                                                <span class="inline-flex items-center rounded-full bg-green-100 dark:bg-green-900 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:text-green-300">
                                                    <x-heroicon-s-check-circle class="w-4 h-4 mr-1" />
                                                    קיים
                                                </span>
                                            @else
                                                <span class="inline-flex items-center rounded-full bg-red-100 dark:bg-red-900 px-2.5 py-0.5 text-xs font-medium text-red-800 dark:text-red-300">
                                                    <x-heroicon-s-x-circle class="w-4 h-4 mr-1" />
                                                    חסר
                                                </span>
                                            @endif
                                            
                                            @if($component['is_generated'])
                                                <span class="inline-flex items-center rounded-full bg-blue-100 dark:bg-blue-900 px-2.5 py-0.5 text-xs font-medium text-blue-800 dark:text-blue-300">
                                                    מחולל
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">
                                        {{ \Illuminate\Support\Carbon::parse($component['last_modified'])->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2 rtl:space-x-reverse">
                                            <a href="{{ $component['edit_url'] }}" target="_blank" class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300">
                                                <x-heroicon-s-eye class="w-5 h-5" />
                                            </a>
                                            
                                            @if($component['is_generated'])
                                                <a href="{{ $component['generator_url'] }}" target="_blank" class="text-warning-600 hover:text-warning-900 dark:text-warning-400 dark:hover:text-warning-300">
                                                    <x-heroicon-s-pencil-square class="w-5 h-5" />
                                                </a>
                                            @endif
                                            
                                            <a href="{{ route('filament.admin.resources.module-managers.view-code', ['path' => $component['path']]) }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-300">
                                                <x-heroicon-s-code-bracket class="w-5 h-5" />
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                        לא נמצאו רכיבים העונים לקריטריונים
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</x-filament::page>