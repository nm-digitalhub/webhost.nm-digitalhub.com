<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl font-semibold mb-4">{{ __('System Settings') }}</h1>

                    <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-400 p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ltr:ml-3 rtl:mr-3">
                                <p class="text-sm text-blue-700 dark:text-blue-300">
                                    {{ __('Configure system-wide settings for NM-DigitalHUB platform.') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div x-data="{ activeTab: 'general' }">
                        <div class="border-b border-gray-200 dark:border-gray-700">
                            <nav class="-mb-px flex space-x-8 rtl:space-x-reverse overflow-x-auto">
                                <button @click="activeTab = 'general'" :class="{ 'border-blue-500 text-blue-600 dark:text-blue-400': activeTab === 'general', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300': activeTab !== 'general' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                    {{ __('General') }}
                                </button>
                                <button @click="activeTab = 'appearance'" :class="{ 'border-blue-500 text-blue-600 dark:text-blue-400': activeTab === 'appearance', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300': activeTab !== 'appearance' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                    {{ __('Appearance') }}
                                </button>
                                <button @click="activeTab = 'email'" :class="{ 'border-blue-500 text-blue-600 dark:text-blue-400': activeTab === 'email', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300': activeTab !== 'email' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                    {{ __('Email') }}
                                </button>
                                <button @click="activeTab = 'payment'" :class="{ 'border-blue-500 text-blue-600 dark:text-blue-400': activeTab === 'payment', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300': activeTab !== 'payment' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                    {{ __('Payment') }}
                                </button>
                                <button @click="activeTab = 'api'" :class="{ 'border-blue-500 text-blue-600 dark:text-blue-400': activeTab === 'api', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300': activeTab !== 'api' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                    {{ __('API Integrations') }}
                                </button>
                                <button @click="activeTab = 'security'" :class="{ 'border-blue-500 text-blue-600 dark:text-blue-400': activeTab === 'security', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300': activeTab !== 'security' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                    {{ __('Security') }}
                                </button>
                            </nav>
                        </div>

                        <div class="mt-6">
                            <!-- General Settings Tab -->
                            <div x-show="activeTab === 'general'" class="space-y-6">
                                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-lg border border-gray-200 dark:border-gray-700">
                                    <div class="px-4 py-5 sm:px-6 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">
                                            {{ __('Company Information') }}
                                        </h3>
                                    </div>
                                    <div class="p-6">
                                        <form wire:submit.prevent="saveGeneralSettings" class="space-y-4">
                                            <div>
                                                <label for="company_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Company Name') }}</label>
                                                <input type="text" wire:model="company_name" id="company_name" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-800 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="NM-DigitalHUB">
                                            </div>
                                            <div>
                                                <label for="company_address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Address') }}</label>
                                                <textarea wire:model="company_address" id="company_address" rows="3" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-800 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="123 Business St, City, Country"></textarea>
                                            </div>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <label for="company_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Email') }}</label>
                                                    <input type="email" wire:model="company_email" id="company_email" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-800 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="contact@example.com">
                                                </div>
                                                <div>
                                                    <label for="company_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Phone') }}</label>
                                                    <input type="text" wire:model="company_phone" id="company_phone" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-800 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="+1 (123) 456-7890">
                                                </div>
                                            </div>
                                            <div>
                                                <label for="company_vat" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('VAT/Tax Number') }}</label>
                                                <input type="text" wire:model="company_vat" id="company_vat" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-800 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="VAT123456789">
                                            </div>
                                            <div class="flex justify-end">
                                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">
                                                    {{ __('Save Changes') }}
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-lg border border-gray-200 dark:border-gray-700">
                                    <div class="px-4 py-5 sm:px-6 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">
                                            {{ __('System Defaults') }}
                                        </h3>
                                    </div>
                                    <div class="p-6">
                                        <form wire:submit.prevent="saveSystemDefaults" class="space-y-4">
                                            <div>
                                                <label for="default_language" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Default Language') }}</label>
                                                <select wire:model="default_language" id="default_language" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-800 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                    <option value="en">English</option>
                                                    <option value="he">Hebrew</option>
                                                    <option value="ar">Arabic</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label for="default_currency" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Default Currency') }}</label>
                                                <select wire:model="default_currency" id="default_currency" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-800 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                    <option value="USD">USD - US Dollar</option>
                                                    <option value="EUR">EUR - Euro</option>
                                                    <option value="ILS">ILS - Israeli Shekel</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label for="date_format" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Date Format') }}</label>
                                                <select wire:model="date_format" id="date_format" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-800 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                    <option value="Y-m-d">YYYY-MM-DD</option>
                                                    <option value="d/m/Y">DD/MM/YYYY</option>
                                                    <option value="m/d/Y">MM/DD/YYYY</option>
                                                </select>
                                            </div>
                                            <div class="flex justify-end">
                                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">
                                                    {{ __('Save Changes') }}
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Appearance Settings Tab -->
                            <div x-show="activeTab === 'appearance'" class="space-y-6">
                                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-lg border border-gray-200 dark:border-gray-700">
                                    <div class="px-4 py-5 sm:px-6 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">
                                            {{ __('Theme Configuration') }}
                                        </h3>
                                    </div>
                                    <div class="p-6">
                                        <form wire:submit.prevent="saveAppearanceSettings" class="space-y-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Color Scheme') }}</label>
                                                <div class="grid grid-cols-3 gap-4">
                                                    <label class="relative flex cursor-pointer rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 p-4 shadow-sm focus:outline-none">
                                                        <input type="radio" wire:model="color_scheme" value="blue" class="sr-only" aria-labelledby="color-scheme-blue">
                                                        <span class="flex flex-1">
                                                            <span class="flex flex-col">
                                                                <span id="color-scheme-blue" class="block text-sm font-medium text-gray-900 dark:text-white">{{ __('Blue') }}</span>
                                                                <span class="mt-1 flex items-center text-sm text-gray-500 dark:text-gray-400">{{ __('Default') }}</span>
                                                                <span class="mt-2 h-2 w-full rounded-full bg-blue-600"></span>
                                                            </span>
                                                        </span>
                                                    </label>
                                                    <label class="relative flex cursor-pointer rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 p-4 shadow-sm focus:outline-none">
                                                        <input type="radio" wire:model="color_scheme" value="green" class="sr-only" aria-labelledby="color-scheme-green">
                                                        <span class="flex flex-1">
                                                            <span class="flex flex-col">
                                                                <span id="color-scheme-green" class="block text-sm font-medium text-gray-900 dark:text-white">{{ __('Green') }}</span>
                                                                <span class="mt-1 flex items-center text-sm text-gray-500 dark:text-gray-400">{{ __('Eco-friendly') }}</span>
                                                                <span class="mt-2 h-2 w-full rounded-full bg-green-600"></span>
                                                            </span>
                                                        </span>
                                                    </label>
                                                    <label class="relative flex cursor-pointer rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 p-4 shadow-sm focus:outline-none">
                                                        <input type="radio" wire:model="color_scheme" value="purple" class="sr-only" aria-labelledby="color-scheme-purple">
                                                        <span class="flex flex-1">
                                                            <span class="flex flex-col">
                                                                <span id="color-scheme-purple" class="block text-sm font-medium text-gray-900 dark:text-white">{{ __('Purple') }}</span>
                                                                <span class="mt-1 flex items-center text-sm text-gray-500 dark:text-gray-400">{{ __('Creative') }}</span>
                                                                <span class="mt-2 h-2 w-full rounded-full bg-purple-600"></span>
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div>
                                                <label for="default_theme" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Default Theme') }}</label>
                                                <select wire:model="default_theme" id="default_theme" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-800 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                    <option value="light">{{ __('Light') }}</option>
                                                    <option value="dark">{{ __('Dark') }}</option>
                                                    <option value="system">{{ __('System Default') }}</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label for="direction" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Direction') }}</label>
                                                <select wire:model="direction" id="direction" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-800 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                    <option value="ltr">{{ __('Left to Right (LTR)') }}</option>
                                                    <option value="rtl">{{ __('Right to Left (RTL)') }}</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label for="logo_upload" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Upload Logo') }}</label>
                                                <div class="flex items-center">
                                                    <input type="file" wire:model="logo" id="logo_upload" class="sr-only">
                                                    <label for="logo_upload" class="relative cursor-pointer rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500 dark:focus:ring-offset-gray-800">
                                                        <span class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-200 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">{{ __('Choose file') }}</span>
                                                    </label>
                                                    <p class="ltr:ml-3 rtl:mr-3 text-sm text-gray-500 dark:text-gray-400">
                                                        {{ __('PNG, JPG, SVG up to 1MB') }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="flex justify-end">
                                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">
                                                    {{ __('Save Changes') }}
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Other tabs similar structure -->
                            <div x-show="activeTab === 'email' || activeTab === 'payment' || activeTab === 'api' || activeTab === 'security'" class="space-y-6">
                                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-lg border border-gray-200 dark:border-gray-700">
                                    <div class="px-4 py-5 sm:px-6 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">
                                            {{ __('Configuration') }}
                                        </h3>
                                    </div>
                                    <div class="p-6">
                                        <div class="text-center py-10 text-gray-500 dark:text-gray-400">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                                            </svg>
                                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ __('Configuration Coming Soon') }}</h3>
                                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('This section is under development and will be available soon.') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
