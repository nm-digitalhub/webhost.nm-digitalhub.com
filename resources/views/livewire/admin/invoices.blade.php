<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl font-semibold mb-4">{{ __('Invoice Management') }}</h1>

                    <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-400 p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ltr:ml-3 rtl:mr-3">
                                <p class="text-sm text-blue-700 dark:text-blue-300">
                                    {{ __('Manage all customer invoices, payments, and transaction history.') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
                            <h3 class="font-semibold text-lg mb-2">{{ __('Total Revenue') }}</h3>
                            <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">$0</p>
                            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">{{ __('All time earnings') }}</p>
                        </div>

                        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
                            <h3 class="font-semibold text-lg mb-2">{{ __('This Month') }}</h3>
                            <p class="text-3xl font-bold text-green-600 dark:text-green-400">$0</p>
                            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">{{ __('Current month revenue') }}</p>
                        </div>

                        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
                            <h3 class="font-semibold text-lg mb-2">{{ __('Pending') }}</h3>
                            <p class="text-3xl font-bold text-yellow-600 dark:text-yellow-400">$0</p>
                            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">{{ __('Unpaid invoices') }}</p>
                        </div>

                        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
                            <h3 class="font-semibold text-lg mb-2">{{ __('Overdue') }}</h3>
                            <p class="text-3xl font-bold text-red-600 dark:text-red-400">$0</p>
                            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">{{ __('Late payments') }}</p>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-lg border border-gray-200 dark:border-gray-700 mb-6">
                        <div class="px-4 py-5 sm:px-6 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">
                                    {{ __('Recent Invoices') }}
                                </h3>
                                <div class="flex space-x-3 rtl:space-x-reverse">
                                    <button type="button" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                        {{ __('Filter') }}
                                    </button>
                                    <button type="button" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">
                                        {{ __('Create Invoice') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            {{ __('Invoice #') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            {{ __('Client') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            {{ __('Amount') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            {{ __('Date') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            {{ __('Due Date') }}
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
                                        <td colspan="7" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                            {{ __('No invoices found in the system.') }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-lg border border-gray-200 dark:border-gray-700">
                            <div class="px-4 py-5 sm:px-6 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">
                                    {{ __('Payment Methods') }}
                                </h3>
                            </div>
                            <div class="p-6">
                                <div class="text-center py-10 text-gray-500 dark:text-gray-400">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ __('No payment methods configured') }}</h3>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('Set up payment gateways to accept payments online.') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-lg border border-gray-200 dark:border-gray-700">
                            <div class="px-4 py-5 sm:px-6 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">
                                    {{ __('Revenue Breakdown') }}
                                </h3>
                            </div>
                            <div class="p-6">
                                <div class="text-center py-10 text-gray-500 dark:text-gray-400">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ __('No revenue data available') }}</h3>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('Revenue breakdown will appear once you have processed payments.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
