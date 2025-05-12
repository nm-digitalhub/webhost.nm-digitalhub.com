@extends('layouts.app')

@section('content')
<div class="pt-32 pb-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <div class="text-center">
        <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold tracking-tight text-[#111827]">
            {{ $page->title }}
        </h1>
        <p class="mt-3 max-w-md mx-auto text-base sm:text-lg md:mt-5 md:text-xl text-gray-500">
            {{ $metadata['subtitle'] ?? 'Choose the perfect hosting solution for your website.' }}
        </p>
    </div>

    <!-- Main Content -->
    <div class="mt-10 prose max-w-none">
        {!! $page->content !!}
    </div>

    <!-- Hosting Plans -->
    @if(isset($metadata['hosting_plans']) && is_array($metadata['hosting_plans']))
    <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach($metadata['hosting_plans'] as $index => $plan)
        <div class="bg-white rounded-xl p-8 shadow-lg {{ $plan['popular'] ?? false ? 'border-2 border-[#0084FF] relative' : '' }}">
            @if(isset($plan['popular']) && $plan['popular'])
            <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-[#0084FF] text-white px-4 py-1 rounded-full text-sm font-medium">
                {{ __('home.pricing.popular') }}
            </div>
            @endif
            
            <h2 class="text-2xl font-bold text-center mb-4">{{ $plan['name'] }}</h2>
            <p class="text-4xl font-bold text-center text-[#0084FF] mb-6">{{ $plan['price'] }}<span class="text-sm text-gray-500">{{ $plan['price_period'] ?? '/mo' }}</span></p>
            
            <ul class="space-y-3 mb-8">
                @foreach($plan['features'] as $feature)
                <li class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>{{ $feature }}</span>
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