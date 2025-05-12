<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl font-semibold mb-4">{{ __('Hosting Management') }}</h1>

                    <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-400 p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ltr:ml-3 rtl:mr-3">
                                <p class="text-sm text-blue-700 dark:text-blue-300">
                                    {{ __('Manage all hosting accounts, servers, and resources.') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
                            <h3 class="font-semibold text-lg mb-2">{{ __('Active Accounts') }}</h3>
                            <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">0</p>
                            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">{{ __('Total hosting accounts') }}</p>
                        </div>

                        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
                            <h3 class="font-semibold text-lg mb-2">{{ __('Storage Used') }}</h3>
                            <p class="text-3xl font-bold text-yellow-600 dark:text-yellow-400">0 GB</p>
                            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">{{ __('Of total available storage') }}</p>
                        </div>

                        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
                            <h3 class="font-semibold text-lg mb-2">{{ __('Monthly Revenue') }}</h3>
                            <p class="text-3xl font-bold text-green-600 dark:text-green-400">$0</p>
                            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">{{ __('From hosting packages') }}</p>
                        </div>
                    </div>

                    <div class="flex flex-col md:flex-row gap-6 mb-6">
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 flex-1">
                            <h3 class="font-semibold text-lg mb-4">{{ __('Server Status') }}</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-700 dark:text-gray-300">{{ __('Web Server 1') }}</span>
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">{{ __('Online') }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-700 dark:text-gray-300">{{ __('Database Server') }}</span>
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">{{ __('Online') }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-700 dark:text-gray-300">{{ __('Email Server') }}</span>
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">{{ __('Online') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 flex-1">
                            <h3 class="font-semibold text-lg mb-4">{{ __('Package Distribution') }}</h3>
                            <div class="flex flex-col space-y-2">
                                <div>
                                    <div class="flex justify-between mb-1">
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Basic') }}</span>
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">0%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2 dark:bg-gray-700">
                                        <div class="bg-blue-600 h-2 rounded-full" style="width: 0%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between mb-1">
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Premium') }}</span>
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">0%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2 dark:bg-gray-700">
                                        <div class="bg-blue-600 h-2 rounded-full" style="width: 0%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between mb-1">
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Business') }}</span>
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">0%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2 dark:bg-gray-700">
                                        <div class="bg-blue-600 h-2 rounded-full" style="width: 0%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="px-4 py-5 sm:px-6 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">
                                    {{ __('All Hosting Accounts') }}
                                </h3>
                                <button type="button" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">
                                    {{ __('Add Account') }}
                                </button>
                            </div>
                        </div>
                        <div class="p-6">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            {{ __('Account/Domain') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            {{ __('Client') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            {{ __('Package') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            {{ __('Creation Date') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            {{ __('Status') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            {{ __('Actions') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    <tr>
                                        <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                            {{ __('No hosting accounts found in the system.') }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
