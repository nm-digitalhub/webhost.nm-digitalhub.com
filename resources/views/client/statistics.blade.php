@extends('layouts.client')

@section('title', 'Statistics')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6 mb-6">
    <h1 class="text-2xl font-bold mb-4">{{ __('Service Statistics') }}</h1>
    
    <p class="mb-6 text-gray-600">{{ __('Review usage statistics for all your services.') }}</p>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Domains Stats Card -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-6 border border-blue-200">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-blue-700">{{ __('Domain Statistics') }}</h2>
                <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                </svg>
            </div>
            
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div class="text-center">
                    <div class="text-3xl font-bold text-blue-600">{{ $stats['domains']['total'] }}</div>
                    <div class="text-sm text-gray-600">{{ __('Total Domains') }}</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-blue-600">{{ $stats['domains']['active'] }}</div>
                    <div class="text-sm text-gray-600">{{ __('Active Domains') }}</div>
                </div>
                <div class="text-center col-span-2">
                    <div class="text-3xl font-bold text-amber-500">{{ $stats['domains']['expiring_soon'] }}</div>
                    <div class="text-sm text-gray-600">{{ __('Expiring Soon') }}</div>
                </div>
            </div>
            
            <div class="mt-4">
                <a href="{{ route('client.domains') }}" class="inline-block w-full text-center px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">{{ __('View Domains') }}</a>
            </div>
        </div>
        
        <!-- Hosting Stats Card -->
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-6 border border-green-200">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-green-700">{{ __('Hosting Statistics') }}</h2>
                <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                </svg>
            </div>
            
            <div class="mb-4">
                <div class="mb-3">
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-600">{{ __('Disk Usage') }}</span>
                        <span class="text-gray-800">{{ $stats['hosting']['disk_usage']['used'] }} GB / {{ $stats['hosting']['disk_usage']['total'] }} GB</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: {{ ($stats['hosting']['disk_usage']['used'] / $stats['hosting']['disk_usage']['total']) * 100 }}%"></div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-600">{{ __('Bandwidth Usage') }}</span>
                        <span class="text-gray-800">{{ $stats['hosting']['bandwidth_usage']['used'] }} GB / {{ $stats['hosting']['bandwidth_usage']['total'] }} GB</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: {{ ($stats['hosting']['bandwidth_usage']['used'] / $stats['hosting']['bandwidth_usage']['total']) * 100 }}%"></div>
                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <div class="text-3xl font-bold text-green-600">{{ $stats['hosting']['uptime'] }}%</div>
                    <div class="text-sm text-gray-600">{{ __('Uptime') }}</div>
                </div>
            </div>
            
            <div class="mt-4">
                <a href="{{ route('client.hosting') }}" class="inline-block w-full text-center px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 transition">{{ __('View Hosting') }}</a>
            </div>
        </div>
        
        <!-- VPS Stats Card -->
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-6 border border-purple-200">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-purple-700">{{ __('VPS Statistics') }}</h2>
                <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
            </div>
            
            <div class="mb-3">
                <div class="flex justify-between text-sm mb-1">
                    <span class="text-gray-600">{{ __('CPU Usage (Last 24h avg)') }}</span>
                    <span class="text-gray-800">{{ array_sum($stats['vps']['cpu_usage']['data']) / count($stats['vps']['cpu_usage']['data']) }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-purple-500 h-2 rounded-full" style="width: {{ array_sum($stats['vps']['cpu_usage']['data']) / count($stats['vps']['cpu_usage']['data']) }}%"></div>
                </div>
            </div>
            
            <div class="mb-3">
                <div class="flex justify-between text-sm mb-1">
                    <span class="text-gray-600">{{ __('RAM Usage (Last 24h avg)') }}</span>
                    <span class="text-gray-800">{{ array_sum($stats['vps']['ram_usage']['data']) / count($stats['vps']['ram_usage']['data']) }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-purple-500 h-2 rounded-full" style="width: {{ array_sum($stats['vps']['ram_usage']['data']) / count($stats['vps']['ram_usage']['data']) }}%"></div>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <div class="text-3xl font-bold text-purple-600">{{ $stats['vps']['total'] }}</div>
                <div class="text-sm text-gray-600">{{ __('Active VPS Servers') }}</div>
            </div>
            
            <div class="mt-4">
                <a href="{{ route('client.vps') }}" class="inline-block w-full text-center px-4 py-2 bg-purple-500 text-white rounded hover:bg-purple-600 transition">{{ __('View VPS') }}</a>
            </div>
        </div>
    </div>
    
    <div class="border-t border-gray-200 pt-6">
        <h2 class="text-xl font-semibold mb-4">{{ __('Domain Traffic (Last 6 Months)') }}</h2>
        
        <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
            <div class="h-64 flex items-center justify-center">
                <!-- This would be a chart in a real application -->
                <p class="text-gray-500">{{ __('Traffic chart visualization would be here') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection