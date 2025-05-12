<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl font-semibold mb-4">{{ __('Order New Hosting Package') }}</h1>

                    <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-400 p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ltr:ml-3 rtl:mr-3">
                                <p class="text-sm text-blue-700 dark:text-blue-300">
                                    {{ __('Select from our range of hosting packages and configure your new hosting account.') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-500 transition">
                            <div class="text-center">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">{{ __('Basic') }}</h3>
                                <div class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                                    $4.99<span class="text-sm font-normal text-gray-600 dark:text-gray-400">/{{ __('month') }}</span>
                                </div>
                                <p class="text-gray-600 dark:text-gray-400 mb-6">{{ __('Perfect for personal websites') }}</p>
                                <button type="button" wire:click="selectPlan('basic')" class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">
                                    {{ __('Select') }}
                                </button>
                            </div>
                            <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-4">
                                <ul class="space-y-3">
                                    <li class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <p class="ltr:ml-3 rtl:mr-3 text-sm text-gray-700 dark:text-gray-300">10 GB SSD Storage</p>
                                    </li>
                                    <li class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <p class="ltr:ml-3 rtl:mr-3 text-sm text-gray-700 dark:text-gray-300">1 Website</p>
                                    </li>
                                    <li class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <p class="ltr:ml-3 rtl:mr-3 text-sm text-gray-700 dark:text-gray-300">Free SSL Certificate</p>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md border border-blue-500 dark:border-blue-500 relative hover:shadow-lg transition">
                            <div class="absolute top-0 right-0 px-3 py-1 bg-blue-500 text-white text-xs font-semibold rounded-bl-lg">
                                {{ __('POPULAR') }}
                            </div>
                            <div class="text-center">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">{{ __('Premium') }}</h3>
                                <div class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                                    $9.99<span class="text-sm font-normal text-gray-600 dark:text-gray-400">/{{ __('month') }}</span>
                                </div>
                                <p class="text-gray-600 dark:text-gray-400 mb-6">{{ __('Ideal for small businesses') }}</p>
                                <button type="button" wire:click="selectPlan('premium')" class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">
                                    {{ __('Select') }}
                                </button>
                            </div>
                            <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-4">
                                <ul class="space-y-3">
                                    <li class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <p class="ltr:ml-3 rtl:mr-3 text-sm text-gray-700 dark:text-gray-300">25 GB SSD Storage</p>
                                    </li>
                                    <li class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <p class="ltr:ml-3 rtl:mr-3 text-sm text-gray-700 dark:text-gray-300">10 Websites</p>
                                    </li>
                                    <li class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <p class="ltr:ml-3 rtl:mr-3 text-sm text-gray-700 dark:text-gray-300">Free SSL Certificate</p>
                                    </li>
                                    <li class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <p class="ltr:ml-3 rtl:mr-3 text-sm text-gray-700 dark:text-gray-300">24/7 Support</p>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-500 transition">
                            <div class="text-center">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">{{ __('Business') }}</h3>
                                <div class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                                    $19.99<span class="text-sm font-normal text-gray-600 dark:text-gray-400">/{{ __('month') }}</span>
                                </div>
                                <p class="text-gray-600 dark:text-gray-400 mb-6">{{ __('For growing businesses') }}</p>
                                <button type="button" wire:click="selectPlan('business')" class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">
                                    {{ __('Select') }}
                                </button>
                            </div>
                            <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-4">
                                <ul class="space-y-3">
                                    <li class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <p class="ltr:ml-3 rtl:mr-3 text-sm text-gray-700 dark:text-gray-300">100 GB SSD Storage</p>
                                    </li>
                                    <li class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <p class="ltr:ml-3 rtl:mr-3 text-sm text-gray-700 dark:text-gray-300">Unlimited Websites</p>
                                    </li>
                                    <li class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <p class="ltr:ml-3 rtl:mr-3 text-sm text-gray-700 dark:text-gray-300">Free SSL Certificate</p>
                                    </li>
                                    <li class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <p class="ltr:ml-3 rtl:mr-3 text-sm text-gray-700 dark:text-gray-300">Priority Support</p>
                                    </li>
                                    <li class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <p class="ltr:ml-3 rtl:mr-3 text-sm text-gray-700 dark:text-gray-300">Daily Backups</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div id="configuration" class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-lg border border-gray-200 dark:border-gray-700 mb-6">
                        <div class="px-4 py-5 sm:px-6 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Configure Your Hosting') }}
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="text-center py-10 text-gray-500 dark:text-gray-400">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ __('No plan selected') }}</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('Select a hosting plan to continue configuration.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
