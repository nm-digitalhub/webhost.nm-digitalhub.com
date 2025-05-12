@extends('layouts.admin-layout') {{-- Assuming this is the correct admin layout --}}

@section('title', __('admin.dashboard.title')) {{-- Localized title --}}

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('admin.dashboard.header') }}</h1>
        <div class="inline-flex space-x-2 rtl:space-x-reverse">
            {{-- Display current date, format might need localization if required --}}
            <span class="text-sm text-gray-500 dark:text-gray-400">{{ now()->format('d/m/Y') }}</span>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
        <!-- Users Card -->
        <div class="p-5 bg-white rounded-lg shadow dark:bg-gray-800">
            <div class="flex items-center">
                <div class="p-3 text-indigo-500 bg-indigo-100 rounded-full dark:bg-indigo-900 dark:text-indigo-300">
                    {{-- User Icon --}}
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div class="{{ app()->getLocale() == 'he' ? 'mr-4' : 'ml-4' }}">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ __('admin.dashboard.stats.active_users') }}</p>
                    {{-- Assuming $userCount is passed from the controller --}}
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $userCount ?? 0 }}</p>
                </div>
            </div>
            <div class="mt-4">
                {{-- Assuming 'admin.users.index' route exists --}}
                <a href="{{ route('admin.users.index') }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300">{{ __('admin.dashboard.stats.view_all_users') }}</a>
            </div>
        </div>

        <!-- Services Card -->
        <div class="p-5 bg-white rounded-lg shadow dark:bg-gray-800">
            <div class="flex items-center">
                <div class="p-3 text-green-500 bg-green-100 rounded-full dark:bg-green-900 dark:text-green-300">
                    {{-- Service Icon --}}
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                 <div class="{{ app()->getLocale() == 'he' ? 'mr-4' : 'ml-4' }}">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ __('admin.dashboard.stats.active_services') }}</p>
                    {{-- Assuming $activeServices is passed from the controller --}}
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $activeServices ?? 0 }}</p>
                </div>
            </div>
            <div class="mt-4">
                 {{-- Assuming 'admin.services.index' route exists --}}
                <a href="{{ route('admin.services.index') }}" class="text-sm text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300">{{ __('admin.dashboard.stats.view_all_services') }}</a>
            </div>
        </div>

        <!-- Revenue Card -->
        <div class="p-5 bg-white rounded-lg shadow dark:bg-gray-800">
            <div class="flex items-center">
                <div class="p-3 text-blue-500 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">
                    {{-- Revenue Icon --}}
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                 <div class="{{ app()->getLocale() == 'he' ? 'mr-4' : 'ml-4' }}">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ __('admin.dashboard.stats.total_revenue') }}</p>
                    {{-- Assuming $totalRevenue is passed from the controller --}}
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ app()->getLocale() == 'he' ? '₪' : '$' }}{{ number_format($totalRevenue ?? 0, 2) }}</p>
                </div>
            </div>
            <div class="mt-4">
                 {{-- Assuming 'admin.invoices.reports' route exists --}}
                <a href="{{ route('admin.invoices.reports') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">{{ __('admin.dashboard.stats.view_revenue_reports') }}</a>
            </div>
        </div>

        <!-- Tickets Card -->
        <div class="p-5 bg-white rounded-lg shadow dark:bg-gray-800">
            <div class="flex items-center">
                <div class="p-3 text-yellow-500 bg-yellow-100 rounded-full dark:bg-yellow-900 dark:text-yellow-300">
                    {{-- Ticket Icon --}}
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                    </svg>
                </div>
                 <div class="{{ app()->getLocale() == 'he' ? 'mr-4' : 'ml-4' }}">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ __('admin.dashboard.stats.open_tickets') }}</p>
                    {{-- Assuming $openTickets is passed from the controller --}}
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $openTickets ?? 0 }}</p>
                </div>
            </div>
            <div class="mt-4">
                 {{-- Assuming 'admin.tickets.open' route exists --}}
                <a href="{{ route('admin.tickets.open') }}" class="text-sm text-yellow-600 dark:text-yellow-400 hover:text-yellow-800 dark:hover:text-yellow-300">{{ __('admin.dashboard.stats.view_open_tickets') }}</a>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <!-- Recent Customers -->
        <div class="bg-white rounded-lg shadow dark:bg-gray-800">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('admin.dashboard.recent_customers.title') }}</h2>
            </div>
            <div class="p-6">
                {{-- Assuming $recentCustomers is passed from the controller --}}
                @isset($recentCustomers)
                <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($recentCustomers as $customer)
                    <li class="flex items-center py-4">
                        <img class="w-10 h-10 rounded-full" src="{{ $customer->profile_photo_url ?? '/default-avatar.png' }}" alt="{{ $customer->name }}">
                        <div class="{{ app()->getLocale() == 'he' ? 'mr-4' : 'ml-4' }} flex-1">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $customer->name }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $customer->created_at->diffForHumans() }}</p>
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $customer->email }}</p>
                        </div>
                        {{-- Assuming 'admin.users.show' route exists --}}
                        <a href="{{ route('admin.users.show', $customer) }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300">
                            {{ __('admin.dashboard.actions.view') }}
                        </a>
                    </li>
                    @empty
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('admin.dashboard.recent_customers.none') }}</p>
                    @endforelse
                </ul>
                @else
                 <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('admin.dashboard.recent_customers.none') }}</p>
                @endisset
            </div>
            <div class="px-6 py-3 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('admin.users.index') }}" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('admin.dashboard.recent_customers.view_all') }}</a>
            </div>
        </div>

        <!-- Recent Invoices -->
        <div class="bg-white rounded-lg shadow dark:bg-gray-800">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('admin.dashboard.recent_invoices.title') }}</h2>
            </div>
            <div class="p-6">
                 {{-- Assuming $recentInvoices is passed from the controller --}}
                @isset($recentInvoices)
                <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($recentInvoices as $invoice)
                    <li class="py-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ __('admin.dashboard.recent_invoices.invoice_number', ['number' => $invoice->invoice_number]) }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $invoice->user->name ?? __('admin.dashboard.unknown_user') }}</p>
                            </div>
                            <div class="flex items-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ app()->getLocale() == 'he' ? 'ml-2' : 'mr-2' }}
                                    {{ $invoice->status === 'paid' ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' :
                                       ($invoice->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100' :
                                       'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100') }}">
                                    {{ __('admin.dashboard.recent_invoices.status.' . $invoice->status) }} {{-- Assumes keys like 'paid', 'pending', 'cancelled' exist --}}
                                </span>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ app()->getLocale() == 'he' ? '₪' : '$' }}{{ number_format($invoice->amount, 2) }}</span>
                            </div>
                        </div>
                    </li>
                     @empty
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('admin.dashboard.recent_invoices.none') }}</p>
                    @endforelse
                </ul>
                 @else
                 <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('admin.dashboard.recent_invoices.none') }}</p>
                @endisset
            </div>
            <div class="px-6 py-3 border-t border-gray-200 dark:border-gray-700">
                {{-- Assuming 'admin.invoices.index' route exists --}}
                <a href="{{ route('admin.invoices.index') }}" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('admin.dashboard.recent_invoices.view_all') }}</a>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow dark:bg-gray-800">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('admin.dashboard.quick_actions.title') }}</h2>
        </div>
        <div class="grid grid-cols-1 gap-4 p-6 md:grid-cols-3">
            {{-- Assuming 'admin.users.create' route exists --}}
            <a href="{{ route('admin.users.create') }}" class="flex items-center p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-700 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                <div class="p-3 rounded-full bg-indigo-100 dark:bg-indigo-900 text-indigo-500 dark:text-indigo-300 {{ app()->getLocale() == 'he' ? 'ml-4' : 'mr-4' }}">
                    {{-- Add User Icon --}}
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ __('admin.dashboard.quick_actions.add_user.title') }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('admin.dashboard.quick_actions.add_user.description') }}</p>
                </div>
            </a>

            {{-- Assuming 'admin.services.create' route exists --}}
            <a href="{{ route('admin.services.create') }}" class="flex items-center p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-700 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                <div class="p-3 rounded-full bg-green-100 dark:bg-green-900 text-green-500 dark:text-green-300 {{ app()->getLocale() == 'he' ? 'ml-4' : 'mr-4' }}">
                     {{-- Add Service Icon --}}
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ __('admin.dashboard.quick_actions.add_service.title') }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('admin.dashboard.quick_actions.add_service.description') }}</p>
                </div>
            </a>

            {{-- Assuming 'admin.invoices.create' route exists --}}
            <a href="{{ route('admin.invoices.create') }}" class="flex items-center p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-700 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-500 dark:text-blue-300 {{ app()->getLocale() == 'he' ? 'ml-4' : 'mr-4' }}">
                     {{-- Create Invoice Icon --}}
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ __('admin.dashboard.quick_actions.create_invoice.title') }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('admin.dashboard.quick_actions.create_invoice.description') }}</p>
                </div>
            </a>
        </div>
    </div>

    <!-- System Status / Expiring Soon (Example) -->
    {{-- This section seems specific and might need dynamic data from the controller --}}
    <div class="bg-white rounded-lg shadow dark:bg-gray-800">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('admin.dashboard.system_status.title') }}</h2>
        </div>
        <div class="grid grid-cols-1 gap-6 p-6 md:grid-cols-2">
            {{-- Example: Active Services by Category (Requires data like $servicesByCategory) --}}
            <div>
                <h3 class="mb-4 text-sm font-medium text-gray-900 dark:text-white">{{ __('admin.dashboard.system_status.services_by_category') }}</h3>
                <div class="space-y-4">
                    {{-- Loop through categories if data is available --}}
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('admin.dashboard.system_status.categories.hosting') }}</span>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ __('admin.dashboard.system_status.active_count', ['count' => $servicesByCategory['hosting'] ?? 0]) }}</span>
                    </div>
                     <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('admin.dashboard.system_status.categories.domains') }}</span>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ __('admin.dashboard.system_status.active_count', ['count' => $servicesByCategory['domains'] ?? 0]) }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('admin.dashboard.system_status.categories.vps') }}</span>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ __('admin.dashboard.system_status.active_count', ['count' => $servicesByCategory['vps'] ?? 0]) }}</span>
                    </div>
                     <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('admin.dashboard.system_status.categories.ssl') }}</span>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ __('admin.dashboard.system_status.active_count', ['count' => $servicesByCategory['ssl'] ?? 0]) }}</span>
                    </div>
                </div>
            </div>

            {{-- Example: Expiring Soon (Requires data like $expiringSoon) --}}
            <div>
                <h3 class="mb-4 text-sm font-medium text-gray-900 dark:text-white">{{ __('admin.dashboard.system_status.expiring_soon') }}</h3>
                <div class="space-y-2">
                    {{-- Loop through expiring items if data is available --}}
                    @isset($expiringSoon)
                        @foreach($expiringSoon as $type => $count)
                            @if($count > 0)
                            <div class="p-3 border-l-4 border-yellow-400 bg-yellow-50 dark:bg-yellow-900/20 dark:border-yellow-700">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        {{-- Warning Icon --}}
                                        <svg class="w-5 h-5 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                    </div>
                                    <div class="{{ app()->getLocale() == 'he' ? 'mr-3' : 'ml-3' }}">
                                        <p class="text-sm text-yellow-800 dark:text-yellow-200">
                                            <span class="font-medium">{{ __('admin.dashboard.system_status.expiring_types.' . $type) }}:</span>
                                            {{ trans_choice('admin.dashboard.system_status.expiring_message', $count, ['count' => $count, 'days' => 14]) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    @else
                     <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('admin.dashboard.system_status.none_expiring') }}</p>
                    @endisset
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Additional JavaScript for dashboard functionality
    console.log('Admin dashboard loaded successfully');
</script>
@endpush
