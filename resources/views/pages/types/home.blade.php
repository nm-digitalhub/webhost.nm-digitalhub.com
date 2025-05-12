@extends('layouts.app')

@section('content')
<!-- Language Switcher (Example placement - adjust as needed in your layout) -->
<div class="py-4 text-center">
    <a href="{{ route('lang.switch', 'he') }}" class="{{ app()->getLocale() == 'he' ? 'font-bold text-primary' : 'text-gray-600 hover:text-primary' }}">עברית</a> |
    <a href="{{ route('lang.switch', 'en') }}" class="{{ app()->getLocale() == 'en' ? 'font-bold text-primary' : 'text-gray-600 hover:text-primary' }}">English</a>
</div>

<!-- Success Message Display -->
@if(session('message'))
<div class="px-4 pt-16 pb-0 mx-auto sm:px-6 lg:px-8 max-w-7xl">
    <div class="relative px-4 py-3 text-green-700 border border-green-400 rounded bg-green-50" role="alert">
        <span class="block sm:inline">{{ session('message') }}</span>
        <span class="absolute top-0 bottom-0 {{ app()->getLocale() == 'he' ? 'left-0' : 'right-0' }} px-4 py-3">
            <svg class="w-6 h-6 text-green-500 fill-current" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <title>{{ __('home.close') }}</title>
                <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
            </svg>
        </span>
    </div>
</div>
@endif

<!-- Hero Section -->
<section class="px-4 pt-16 pb-16 mx-auto sm:px-6 lg:px-8 max-w-7xl">
    <div class="text-center">
        <h1 class="text-4xl sm:text-5xl font-bold tracking-tight text-[#0D1E3C] {{ app()->getLocale() == 'he' ? 'font-heebo' : 'font-inter' }}" style="font-size: 32px;">
            {{ $page->title }}
        </h1>
        
        @if(isset($metadata['hero']['subtitle']))
        <p class="mt-3 max-w-md mx-auto text-base sm:text-lg md:mt-5 md:text-xl text-[#0F2F5] {{ app()->getLocale() == 'he' ? 'font-heebo' : 'font-inter' }}" style="font-size: 18px;">
            {{ $metadata['hero']['subtitle'] }}
        </p>
        @endif

        <!-- Search Bar -->
        <div class="max-w-xl mx-auto mt-10">
            <form action="{{ route('search') }}" method="GET" class="flex flex-col shadow-md sm:flex-row">
                <input
                    id="domain-search-input"
                    type="text"
                    name="name"
                    placeholder="{{ __('home.search_placeholder') }}"
                    class="flex-1 py-3 px-4 border-0 focus:ring-2 focus:ring-[#006CC] focus:outline-none {{ app()->getLocale() == 'he' ? 'rounded-t-lg sm:rounded-r-lg sm:rounded-tl-none' : 'rounded-t-lg sm:rounded-l-lg sm:rounded-tr-none' }}"
                    style="{{ app()->getLocale() == 'en' ? 'border-radius: 12px 0 0 12px;' : '' }}"
                    required
                    aria-label="{{ __('home.search_aria_label') }}"
                    dir="{{ app()->getLocale() == 'he' ? 'rtl' : 'ltr' }}"
                >
                <button
                    id="search-domain-button"
                    type="submit"
                    class="w-full sm:w-auto mt-2 sm:mt-0 px-6 py-3 bg-[#006CC] hover:bg-[#0F2F5] text-white font-bold transition-all duration-150 ease-in uppercase {{ app()->getLocale() == 'he' ? 'rounded-b-lg sm:rounded-l-lg sm:rounded-br-none font-heebo' : 'rounded-b-lg sm:rounded-r-lg sm:rounded-bl-none font-inter' }}"
                    style="{{ app()->getLocale() == 'en' ? 'border-radius: 0 12px 12px 0;' : '' }}"
                    aria-label="{{ __('home.search_button_aria_label') }}"
                >
                    {{ __('home.search_button') }}
                </button>
            </form>
        </div>
    </div>
</section>

<!-- Main Content -->
<div class="prose max-w-none px-4 py-4 mx-auto sm:px-6 lg:px-8 max-w-7xl">
    {!! $page->content !!}
</div>

<!-- Feature Cards Section -->
@if(isset($metadata['features']) && is_array($metadata['features']))
<section class="px-4 py-16 mx-auto sm:px-6 lg:px-8 max-w-7xl">
    <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
        @foreach($metadata['features'] as $feature)
        <div class="feature-card bg-[#F0F2F5] rounded-xl p-6 shadow-md hover:shadow-lg transition-all duration-150">
            @if(isset($feature['icon']))
            <div class="flex justify-center mb-6">
                <svg class="h-16 w-16 text-[#006CC]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    @if($feature['icon'] == 'server')
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                    @elseif($feature['icon'] == 'processor')
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                    @elseif($feature['icon'] == 'globe')
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                    @elseif($feature['icon'] == 'cloud')
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                    @else
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    @endif
                </svg>
            </div>
            @endif
            
            <h3 class="text-xl font-bold text-[#0D1E3C] text-center mb-3 {{ app()->getLocale() == 'he' ? 'font-heebo' : 'font-inter' }}">
                {{ $feature['title'] ?? 'Feature' }}
            </h3>
            
            <p class="text-[#0F2F5] text-center mb-6 {{ app()->getLocale() == 'he' ? 'font-heebo' : 'font-inter' }}" style="font-size: 16px;">
                {{ $feature['description'] ?? '' }}
            </p>
            
            @if(isset($feature['cta_text']) && isset($feature['cta_url']))
            <div class="flex justify-center">
                <a href="{{ $feature['cta_url'] }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-[#006CC] hover:bg-[#0F2F5] transition-all duration-150 ease-in uppercase {{ app()->getLocale() == 'he' ? 'font-heebo' : 'font-inter' }}">
                    {{ $feature['cta_text'] }}
                </a>
            </div>
            @endif
        </div>
        @endforeach
    </div>
</section>
@endif

<!-- Dynamic Sections from Metadata -->
@foreach($metadata as $sectionKey => $sectionContent)
    @if(is_array($sectionContent) && !in_array($sectionKey, ['hero', 'features']))
        <section class="px-4 py-16 mx-auto sm:px-6 lg:px-8 max-w-7xl">
            @if(isset($sectionContent['title']))
                <h2 class="text-3xl font-bold text-center text-[#0D1E3C] mb-12 {{ app()->getLocale() == 'he' ? 'font-heebo' : 'font-inter' }}" style="font-size: 32px;">
                    {{ $sectionContent['title'] }}
                </h2>
            @endif
            
            @if(isset($sectionContent['content']))
                <div class="prose max-w-none">
                    {!! $sectionContent['content'] !!}
                </div>
            @endif
        </section>
    @endif
@endforeach
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