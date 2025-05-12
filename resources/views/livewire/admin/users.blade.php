<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl font-semibold mb-4">{{ __('User Management') }}</h1>

                    <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-400 p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ltr:ml-3 rtl:mr-3">
                                <p class="text-sm text-blue-700 dark:text-blue-300">
                                    {{ __('Manage users, permissions, and access rights to the system.') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
                            <h3 class="font-semibold text-lg mb-2">{{ __('Total Users') }}</h3>
                            <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">0</p>
                            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">{{ __('Registered accounts') }}</p>
                        </div>

                        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
                            <h3 class="font-semibold text-lg mb-2">{{ __('Active Users') }}</h3>
                            <p class="text-3xl font-bold text-green-600 dark:text-green-400">0</p>
                            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">{{ __('Users active in last 30 days') }}</p>
                        </div>

                        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
                            <h3 class="font-semibold text-lg mb-2">{{ __('Admins') }}</h3>
                            <p class="text-3xl font-bold text-purple-600 dark:text-purple-400">0</p>
                            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">{{ __('Users with admin privileges') }}</p>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="px-4 py-5 sm:px-6 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">
                                    {{ __('All Users') }}
                                </h3>
                                <button type="button" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">
                                    {{ __('Add User') }}
                                </button>
                            </div>
                        </div>
                        <div class="p-6">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            {{ __('Name') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            {{ __('Email') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            {{ __('Role') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            {{ __('Last Login') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            {{ __('Actions') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    <tr>
                                        <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                            {{ __('No users found in the system.') }}
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
