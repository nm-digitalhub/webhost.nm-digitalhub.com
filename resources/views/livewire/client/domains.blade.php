<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-semibold mb-4">{{ __('Domain Management') }}</h1>

                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700">
                                    {{ __('Manage all your domain names, renewals, and DNS settings from this dashboard.') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                            <h3 class="font-semibold text-lg mb-2">{{ __('Active Domains') }}</h3>
                            <p class="text-3xl font-bold text-blue-600">0</p>
                            <p class="text-gray-500 text-sm mt-1">{{ __('Domains under management') }}</p>
                        </div>

                        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                            <h3 class="font-semibold text-lg mb-2">{{ __('Expiring Soon') }}</h3>
                            <p class="text-3xl font-bold text-yellow-600">0</p>
                            <p class="text-gray-500 text-sm mt-1">{{ __('Domains expiring in 30 days') }}</p>
                        </div>

                        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                            <h3 class="font-semibold text-lg mb-2">{{ __('Available for Registration') }}</h3>
                            <a href="{{ route('client.domains.check') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-300 disabled:opacity-25 transition mt-2">
                                {{ __('Check Domain') }}
                            </a>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-md rounded-lg border border-gray-200">
                        <div class="px-4 py-5 sm:px-6 bg-gray-50 border-b border-gray-200">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                {{ __('Your Domains') }}
                            </h3>
                        </div>
                        <div class="p-6">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Domain Name') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Expiry Date') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Auto Renew') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Status') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Actions') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr>
                                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                            {{ __('No domains found. Get started by registering a new domain.') }}
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
