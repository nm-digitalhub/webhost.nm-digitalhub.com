@extends('layouts.app')

@section('content')
<div class="pt-32 pb-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <div class="text-center">
        <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold tracking-tight text-[#111827]">
            {{ $page->title }}
        </h1>
        <p class="mt-3 max-w-md mx-auto text-base sm:text-lg md:mt-5 md:text-xl text-gray-500">
            {{ $metadata['subtitle'] ?? 'Scalable cloud solutions for your business.' }}
        </p>
    </div>

    <!-- Main Content -->
    <div class="mt-10 prose max-w-none">
        {!! $page->content !!}
    </div>

    <!-- Cloud Solutions -->
    @if(isset($metadata['cloud_solutions']) && is_array($metadata['cloud_solutions']))
    <div class="mt-16 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($metadata['cloud_solutions'] as $solution)
        <div class="bg-white rounded-xl p-8 shadow-lg border border-gray-200">
            @if(isset($solution['icon']))
            <div class="flex justify-center mb-6">
                <svg class="h-16 w-16 text-[#0084FF]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    @if($solution['icon'] == 'cloud')
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                    @elseif($solution['icon'] == 'server')
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                    @elseif($solution['icon'] == 'database')
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                    @elseif($solution['icon'] == 'shield')
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    @else
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    @endif
                </svg>
            </div>
            @endif
            
            <h2 class="text-2xl font-bold text-center mb-4">{{ $solution['title'] }}</h2>
            <p class="text-gray-600 text-center mb-6">{{ $solution['description'] }}</p>
            
            @if(isset($solution['features']) && is_array($solution['features']))
            <ul class="space-y-3 mb-8">
                @foreach($solution['features'] as $feature)
                <li class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-2 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>{{ $feature }}</span>
                </li>
                @endforeach
            </ul>
            @endif
            
            @if(isset($solution['price']))
            <p class="text-xl font-bold text-center text-[#0084FF] mb-6">
                {{ $solution['price'] }}
                @if(isset($solution['price_period']))
                <span class="text-sm text-gray-500">{{ $solution['price_period'] }}</span>
                @endif
            </p>
            @endif
            
            <div class="text-center">
                <a href="{{ $solution['cta_url'] ?? '#' }}" class="inline-block px-6 py-3 bg-[#0084FF] hover:bg-[#00457C] text-white font-medium rounded-md transition-colors uppercase w-full">
                    {{ $solution['cta_text'] ?? 'Learn More' }}
                </a>
            </div>
        </div>
        @endforeach
    </div>
    @endif
    
    <!-- Testimonials Section -->
    @if(isset($metadata['testimonials']) && is_array($metadata['testimonials']))
    <div class="mt-20 bg-gray-50 rounded-xl py-12 px-4 sm:px-8">
        <h2 class="text-3xl font-bold text-center mb-12">{{ $metadata['testimonials_title'] ?? 'What Our Customers Say' }}</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($metadata['testimonials'] as $testimonial)
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="flex items-center mb-4">
                    @if(isset($testimonial['avatar']))
                    <img src="{{ $testimonial['avatar'] }}" alt="{{ $testimonial['name'] }}" class="w-12 h-12 rounded-full mr-4">
                    @endif
                    <div>
                        <h3 class="font-semibold">{{ $testimonial['name'] }}</h3>
                        <p class="text-gray-500 text-sm">{{ $testimonial['company'] }}</p>
                    </div>
                </div>
                <p class="text-gray-600 italic">"{{ $testimonial['quote'] }}"</p>
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