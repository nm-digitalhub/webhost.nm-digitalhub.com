@extends('layouts.client')

@section('title', 'Client Panel Modules')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6 mb-6">
    <h1 class="text-2xl font-bold mb-4">Client Panel Modules</h1>
    
    <p class="mb-6 text-gray-600">This page shows all installed client panel modules available to your account.</p>
    
    <div class="mb-8">
        <h2 class="text-xl font-semibold mb-4">Installed Modules</h2>
        
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Icon</th>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Route</th>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Position</th>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($modules as $module)
                    <tr>
                        <td class="py-3 px-4 whitespace-nowrap">
                            <div class="font-medium text-gray-900">{{ $module->name }}</div>
                            <div class="text-sm text-gray-500">{{ $module->description }}</div>
                        </td>
                        <td class="py-3 px-4 whitespace-nowrap text-sm text-gray-500">
                            {{ ucfirst($module->type) }}
                        </td>
                        <td class="py-3 px-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="flex items-center">
                                @if(str_starts_with($module->icon, 'heroicon-'))
                                    <span class="text-blue-500 mr-2">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        </svg>
                                    </span>
                                @endif
                                <span>{{ $module->icon }}</span>
                            </div>
                        </td>
                        <td class="py-3 px-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $module->route_name ?: '-' }}
                        </td>
                        <td class="py-3 px-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $module->position }}
                        </td>
                        <td class="py-3 px-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Enabled
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-3 px-4 text-center text-sm text-gray-500">
                            No modules found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div>
        <h2 class="text-xl font-semibold mb-4">Available Pages in Menu</h2>
        
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Slug</th>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Module</th>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Visibility</th>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Position</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($menuPages as $page)
                    <tr>
                        <td class="py-3 px-4 whitespace-nowrap">
                            <div class="font-medium text-gray-900">{{ $page->title }}</div>
                        </td>
                        <td class="py-3 px-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $page->slug }}
                        </td>
                        <td class="py-3 px-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $page->module ? $page->module->name : '-' }}
                        </td>
                        <td class="py-3 px-4 whitespace-nowrap text-sm text-gray-500">
                            {{ ucfirst($page->visibility) }}
                        </td>
                        <td class="py-3 px-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $page->menu_position }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-3 px-4 text-center text-sm text-gray-500">
                            No menu pages found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection