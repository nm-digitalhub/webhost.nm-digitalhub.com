@extends('layouts.app')

@section('content')
<div class="pt-32 pb-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <div class="text-center">
        <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold tracking-tight text-[#111827]">
            {{ $page->title }}
        </h1>
        <p class="mt-3 max-w-md mx-auto text-base sm:text-lg md:mt-5 md:text-xl text-gray-500">
            {{ $metadata['subtitle'] ?? 'Virtual Private Servers with full root access and dedicated resources.' }}
        </p>
    </div>

    <!-- Main Content -->
    <div class="mt-10 prose max-w-none">
        {!! $page->content !!}
    </div>

    <!-- VPS Plans -->
    @if(isset($metadata['vps_plans']) && is_array($metadata['vps_plans']))
    <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach($metadata['vps_plans'] as $index => $plan)
        <div class="bg-white rounded-xl p-8 shadow-lg {{ $plan['popular'] ?? false ? 'border-2 border-[#0084FF] relative' : '' }}">
            @if(isset($plan['popular']) && $plan['popular'])
            <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-[#0084FF] text-white px-4 py-1 rounded-full text-sm font-medium">
                {{ __('home.pricing.popular') }}
            </div>
            @endif
            
            <h2 class="text-2xl font-bold text-center mb-4">{{ $plan['name'] }}</h2>
            <p class="text-4xl font-bold text-center text-[#0084FF] mb-6">{{ $plan['price'] }}<span class="text-sm text-gray-500">{{ $plan['price_period'] ?? '/mo' }}</span></p>
            
            <ul class="space-y-3 mb-8">
                @foreach($plan['specs'] as $spec)
                <li class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>{{ $spec }}</span>
                </li>
                @endforeach
            </ul>
            
            <div class="text-center">
                <a href="{{ $plan['cta_url'] ?? '#' }}" class="inline-block px-6 py-3 bg-[#0084FF] hover:bg-[#00457C] text-white font-medium rounded-md transition-colors uppercase w-full">
                    {{ $plan['cta_text'] ?? 'Get Started' }}
                </a>
            </div>
        </div>
        @endforeach
    </div>
    @endif
    
    <!-- Additional Sections -->
    @if(isset($metadata['features_section']))
    <div class="mt-20 px-4 py-8 bg-gray-50 rounded-xl">
        <h2 class="text-3xl font-bold text-center mb-10">{{ $metadata['features_section']['title'] ?? 'VPS Features' }}</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($metadata['features_section']['features'] as $feature)
            <div class="p-6 bg-white rounded-lg shadow-sm">
                <h3 class="text-xl font-semibold mb-4">{{ $feature['title'] }}</h3>
                <p class="text-gray-600">{{ $feature['description'] }}</p>
            </div>
            @endforeach
        </div>
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