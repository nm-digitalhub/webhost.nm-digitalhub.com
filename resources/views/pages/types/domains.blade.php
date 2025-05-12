@extends('layouts.app')

@section('content')
<div class="pt-32 pb-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <div class="text-center">
        <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold tracking-tight text-[#111827]">
            {{ $page->title }}
        </h1>
        <p class="mt-3 max-w-md mx-auto text-base sm:text-lg md:mt-5 md:text-xl text-gray-500">
            {{ $metadata['subtitle'] ?? 'Find the perfect domain name for your business or project.' }}
        </p>
    </div>

    <!-- Search Bar -->
    <div class="mt-10 max-w-xl mx-auto">
        <form action="{{ route('search') }}" method="GET" class="flex flex-col sm:flex-row shadow-md">
            <input
                id="domain-search-input"
                type="text"
                name="name"
                placeholder="{{ __('home.search_placeholder') }}"
                class="flex-1 py-3 px-4 rounded-t-lg sm:rounded-l-lg sm:rounded-tr-none border-0 focus:ring-2 focus:ring-[#0084FF] focus:outline-none"
                required
            >
            <button
                id="search-domain-button"
                type="submit"
                class="w-full sm:w-auto mt-2 sm:mt-0 px-6 py-3 bg-[#0084FF] hover:bg-[#00457C] text-white font-medium rounded-b-lg sm:rounded-r-lg sm:rounded-bl-none transition-colors uppercase"
                aria-label="{{ __('home.search_button_aria_label') }}"
            >
                {{ __('home.search_button') }}
            </button>
        </form>
    </div>

    <!-- Main Content -->
    <div class="mt-10 prose max-w-none">
        {!! $page->content !!}
    </div>

    <!-- Domain Pricing Table -->
    @if(isset($metadata['pricing_table']) && is_array($metadata['pricing_table']))
    <div class="mt-16">
        <h2 class="text-2xl font-bold text-center mb-8">{{ $metadata['pricing_title'] ?? 'Domain Pricing' }}</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg shadow-md">
                <thead>
                    <tr class="bg-gray-100 border-b">
                        <th class="py-4 px-6 text-left text-gray-700">{{ $metadata['pricing_columns']['extension'] ?? 'Domain Extension' }}</th>
                        <th class="py-4 px-6 text-center text-gray-700">{{ $metadata['pricing_columns']['registration'] ?? 'Registration' }}</th>
                        <th class="py-4 px-6 text-center text-gray-700">{{ $metadata['pricing_columns']['renewal'] ?? 'Renewal' }}</th>
                        <th class="py-4 px-6 text-center text-gray-700">{{ $metadata['pricing_columns']['transfer'] ?? 'Transfer' }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($metadata['pricing_table'] as $domain)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-4 px-6 font-medium">{{ $domain['extension'] }}</td>
                        <td class="py-4 px-6 text-center">{{ $domain['registration'] }}</td>
                        <td class="py-4 px-6 text-center">{{ $domain['renewal'] }}</td>
                        <td class="py-4 px-6 text-center">{{ $domain['transfer'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
    
    <!-- Domain Cards -->
    @if(isset($metadata['domain_cards']) && is_array($metadata['domain_cards']))
    <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($metadata['domain_cards'] as $card)
        <div class="bg-gray-50 p-6 rounded-lg">
            <h3 class="text-xl font-semibold mb-3">{{ $card['title'] }}</h3>
            <p class="text-gray-600 mb-4">{{ $card['description'] }}</p>
            <span class="block text-[#0084FF] font-bold">{{ $card['price'] }}</span>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection

@if($page->meta_title || $page->meta_description || $page->meta_keywords)
@section('meta')
    @if($page->meta_title)
    <title>{{ $page->meta_title }}</title>
    <meta property="og:title" content="{{ $page->meta_title }}">
    @endif
    
    @if($page->meta_description)
    <meta name="description" content="{{ $page->meta_description }}">
    <meta property="og:description" content="{{ $page->meta_description }}">
    @endif
    
    @if($page->meta_keywords)
    <meta name="keywords" content="{{ $page->meta_keywords }}">
    @endif
@endsection
@endif