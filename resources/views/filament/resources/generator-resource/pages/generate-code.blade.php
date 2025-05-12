<x-filament-panels::page>
    <x-filament::section>
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold tracking-tight">
                מחולל קוד: {{ $record->name }} ({{ ucfirst($record->type) }})
            </h2>
            <div class="flex space-x-4 space-x-reverse">
                <x-filament::button 
                    color="primary"
                    wire:click="generate"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="generate">צור קוד</span>
                    <span wire:loading wire:target="generate">מייצר...</span>
                </x-filament::button>
                
                @if($showPreview)
                    <x-filament::button 
                        color="gray"
                        wire:click="hidePreview">
                        הסתר תצוגה מקדימה
                    </x-filament::button>
                @else
                    <x-filament::button 
                        color="gray"
                        wire:click="showPreview">
                        הצג תצוגה מקדימה
                    </x-filament::button>
                @endif
                
                <x-filament::button 
                    color="success"
                    wire:click="downloadCode"
                    wire:loading.attr="disabled">
                    הורד קובץ
                </x-filament::button>
            </div>
        </div>

        <div class="mt-4 space-y-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <div>
                    <h3 class="text-lg font-semibold mb-2">פרטי המחולל</h3>
                    <dl class="mt-4 grid grid-cols-1 gap-y-4 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">סוג</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($record->type) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">שם</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $record->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Namespace</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $generationData['namespace'] ?? $record->namespace }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">נתיב קובץ</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $filePath }}</dd>
                        </div>
                        @if($isFileExists)
                            <div class="col-span-2">
                                <dt class="text-sm font-medium text-red-500">שים לב!</dt>
                                <dd class="mt-1 text-sm text-red-500">הקובץ כבר קיים במערכת. יצירת קוד חדש תדרוס את הקובץ הקיים.</dd>
                            </div>
                        @endif
                    </dl>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-2">הגדרות נוספות</h3>
                    <dl class="mt-4 grid grid-cols-1 gap-y-4 sm:grid-cols-2">
                        @if($record->type === 'model')
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Extends</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ class_basename($generationData['extends'] ?? '') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Fillable</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $record->fillable ? 'כן' : 'לא' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Timestamps</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $record->timestamps ? 'כן' : 'לא' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Soft Deletes</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $record->soft_deletes ? 'כן' : 'לא' }}</dd>
                            </div>
                        @elseif($record->type === 'resource' || $record->type === 'page' || $record->type === 'widget')
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Label</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $record->label }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Icon</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $record->icon }}</dd>
                            </div>
                            @if($record->type === 'resource' || $record->type === 'page')
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Navigation Group</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $record->group }}</dd>
                                </div>
                            @endif
                        @endif
                    </dl>
                </div>
            </div>
            
            @if($showPreview)
                <div class="mt-6">
                    <h3 class="text-lg font-semibold mb-2">תצוגה מקדימה של הקוד</h3>
                    <div class="relative mt-2">
                        <div class="overflow-hidden bg-gray-950 text-gray-200 rounded-lg">
                            <pre class="language-php p-4 text-sm overflow-auto" style="max-height: 500px;"><code>{{ $code }}</code></pre>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </x-filament::section>
    
    @if($showConfirmOverwrite)
        <div class="fixed inset-0 flex items-center justify-center bg-gray-900/50 z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
                <h3 class="text-lg font-medium text-gray-900">אישור דריסת קובץ</h3>
                <div class="mt-2">
                    <p class="text-sm text-gray-500">
                        הקובץ <strong>{{ basename($filePath) }}</strong> כבר קיים. האם אתה בטוח שברצונך לדרוס אותו?
                    </p>
                </div>
                <div class="mt-4 flex justify-end space-x-3 space-x-reverse">
                    <x-filament::button 
                        color="gray"
                        wire:click="cancelOverwrite"
                        wire:loading.attr="disabled">
                        ביטול
                    </x-filament::button>
                    <x-filament::button 
                        color="danger"
                        wire:click="confirmOverwrite"
                        wire:loading.attr="disabled">
                        כן, דרוס את הקובץ
                    </x-filament::button>
                </div>
            </div>
        </div>
    @endif
</x-filament-panels::page>