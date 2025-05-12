<x-filament::page>
    <div class="space-y-6">
        <!-- File Information Header -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-primary-600 dark:text-primary-400">
                        {{ $fileInfo['filename'] ?? 'Unknown File' }}
                    </h2>
                    
                    <div class="flex items-center space-x-2 rtl:space-x-reverse">
                        <span class="px-3 py-1 text-xs rounded-full 
                            {{ $isGenerated ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                            {{ $isGenerated ? 'מחולל' : 'ידני' }}
                        </span>
                        
                        <span class="px-3 py-1 text-xs rounded-full bg-primary-100 text-primary-800 dark:bg-primary-900 dark:text-primary-300">
                            {{ $getComponentType }}
                        </span>
                    </div>
                </div>
                
                <div class="mt-2 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                        <x-heroicon-m-document class="w-4 h-4 mr-1" />
                        <span>{{ $path }}</span>
                    </div>
                    
                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                        <x-heroicon-m-calendar class="w-4 h-4 mr-1" />
                        <span>{{ $getFormattedLastModified }}</span>
                    </div>
                    
                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                        <x-heroicon-m-document-text class="w-4 h-4 mr-1" />
                        <span>{{ $getFormattedFileSize }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Code Editor -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
            <div class="border-b border-gray-200 dark:border-gray-700 px-6 py-3 flex items-center justify-between">
                <h3 class="text-md font-medium text-gray-700 dark:text-gray-300">
                    {{ $isEditable ? 'עריכת קוד' : 'צפייה בקוד' }}
                </h3>
                
                @if($isEditable)
                <div class="flex space-x-2 rtl:space-x-reverse">
                    <button type="button" wire:click="saveFile" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        <x-heroicon-s-check class="w-4 h-4 mr-1" />
                        שמור שינויים
                    </button>
                </div>
                @endif
            </div>
            
            <div class="p-0 relative">
                @if($isEditable)
                    <div class="relative h-[60vh] font-mono text-sm" dir="ltr">
                        <textarea
                            wire:model="editedContent"
                            class="absolute inset-0 w-full h-full p-4 bg-gray-900 text-gray-100 font-mono text-sm outline-none resize-none"
                            spellcheck="false"
                        ></textarea>
                    </div>
                @else
                    <div class="relative h-[60vh] overflow-auto" dir="ltr">
                        <pre class="p-4 bg-gray-900 text-gray-100 font-mono text-sm h-full overflow-auto"><code>{{ $fileContent }}</code></pre>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex justify-between">
            <a href="{{ route('filament.admin.resources.module-managers.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                <x-heroicon-s-arrow-left class="w-4 h-4 mr-2 rtl:mr-0 rtl:ml-2 rtl:rotate-180" />
                חזרה לרשימת הרכיבים
            </a>
            
            @if($isGenerated)
            <a href="{{ route('filament.admin.resources.generators.edit', ['record' => \App\Models\Generator::where('target_path', $path)->orWhere('target_path', base_path($path))->first()]) }}" 
                target="_blank" 
                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-warning-600 hover:bg-warning-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-warning-500">
                <x-heroicon-s-pencil-square class="w-4 h-4 mr-2 rtl:mr-0 rtl:ml-2" />
                ערוך במחולל
            </a>
            @endif
        </div>
    </div>
    
    <!-- JavaScript to enhance code editing experience -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('codeEditor', () => ({
                lineNumbers: true,
                init() {
                    // Add line numbers if enabled
                    if (this.lineNumbers) {
                        this.addLineNumbers();
                    }
                },
                addLineNumbers() {
                    const codeElement = this.$refs.code;
                    const lines = codeElement.textContent.split('\n');
                    const numbersElement = document.createElement('div');
                    numbersElement.classList.add('line-numbers');
                    
                    for (let i = 1; i <= lines.length; i++) {
                        const numberElement = document.createElement('span');
                        numberElement.textContent = i;
                        numbersElement.appendChild(numberElement);
                    }
                    
                    codeElement.parentNode.insertBefore(numbersElement, codeElement);
                    codeElement.parentNode.classList.add('has-line-numbers');
                }
            }))
        })
    </script>
    
    <!-- Optional: CSS for styling the code editor with line numbers -->
    <style>
        .has-line-numbers {
            display: flex;
        }
        
        .line-numbers {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            padding: 1rem 0.5rem 1rem 0;
            background-color: #1e2022;
            color: #606468;
            user-select: none;
            text-align: right;
        }
        
        .line-numbers span {
            font-size: 0.875rem;
            line-height: 1.25rem;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
            padding: 0 0.5rem;
        }
    </style>
</x-filament::page>