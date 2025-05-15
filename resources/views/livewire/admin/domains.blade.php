<div>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="mb-4 text-2xl font-semibold">{{ __('Domain Management') }}</h1>

                    <div class="p-4 mb-6 border-l-4 border-blue-400 bg-blue-50 dark:bg-blue-900/20">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ms-3">
                                <p class="text-sm text-blue-700 dark:text-blue-300">
                                    {{ __('Manage all registered domains, renewals, and DNS records.') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-3">
                        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">
                            <h3 class="mb-2 text-lg font-semibold">{{ __('Active Domains') }}</h3>
                            <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">0</p>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('Total domains registered') }}</p>
                        </div>

                        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">
                            <h3 class="mb-2 text-lg font-semibold">{{ __('Expiring Soon') }}</h3>
                            <p class="text-3xl font-bold text-yellow-600 dark:text-yellow-400">0</p>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('Domains expiring in 30 days') }}</p>
                        </div>

                        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">
                            <h3 class="mb-2 text-lg font-semibold">{{ __('Total Revenue') }}</h3>
                            <p class="text-3xl font-bold text-green-600 dark:text-green-400">$0</p>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('From domain registrations') }}</p>
                        </div>
                    </div>

                    <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">
                        <div class="px-4 py-5 border-b border-gray-200 sm:px-6 bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100">
                                {{ __('All Domains') }}
                            </h3>
                        </div>
                        <div class="p-6">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-gray-500 uppercase text-start dark:text-gray-300">
                                            {{ __('Domain Name') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-gray-500 uppercase text-start dark:text-gray-300">
                                            {{ __('Client') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-gray-500 uppercase text-start dark:text-gray-300">
                                            {{ __('Registration Date') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-gray-500 uppercase text-start dark:text-gray-300">
                                            {{ __('Expiry Date') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-gray-500 uppercase text-start dark:text-gray-300">
                                            {{ __('Status') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-gray-500 uppercase text-end dark:text-gray-300">
                                            {{ __('Actions') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                    <tr>
                                        <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                            {{ __('No domains found in the system.') }}
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
