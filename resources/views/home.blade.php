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
        {{-- Consider making the close button text translatable too --}}
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
        {{-- Conditional font class based on locale --}}
        <h1 class="text-4xl sm:text-5xl font-bold tracking-tight text-[#0D1E3C] {{ app()->getLocale() == 'he' ? 'font-heebo' : 'font-inter' }}" style="font-size: 32px;">
            {{ __('home.hero_title') }}
        </h1>
        <p class="mt-3 max-w-md mx-auto text-base sm:text-lg md:mt-5 md:text-xl text-[#0F2F5] {{ app()->getLocale() == 'he' ? 'font-heebo' : 'font-inter' }}" style="font-size: 18px;">
            {{ __('home.hero_subtitle') }}
        </p>

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

<!-- Feature Cards Section -->
<section class="px-4 py-16 mx-auto sm:px-6 lg:px-8 max-w-7xl">
    <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Shared Hosting Card -->
        <div class="feature-card bg-[#F0F2F5] rounded-xl p-6 shadow-md hover:shadow-lg transition-all duration-150">
            <div class="flex justify-center mb-6">
                <svg class="h-16 w-16 text-[#006CC]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-[#0D1E3C] text-center mb-3 {{ app()->getLocale() == 'he' ? 'font-heebo' : 'font-inter' }}">{{ __('home.features.shared.title') }}</h3>
            <p class="text-[#0F2F5] text-center mb-6 {{ app()->getLocale() == 'he' ? 'font-heebo' : 'font-inter' }}" style="font-size: 16px;">
                {{ __('home.features.shared.description') }}
            </p>
            <div class="flex justify-center">
                <a href="{{ route('hosting') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-[#006CC] hover:bg-[#0F2F5] transition-all duration-150 ease-in uppercase {{ app()->getLocale() == 'he' ? 'font-heebo' : 'font-inter' }}" aria-label="{{ __('home.features.shared.cta_aria_label') }}">
                    {{ __('home.features.shared.cta') }}
                </a>
            </div>
        </div>

        <!-- VPS Hosting Card -->
        <div class="feature-card bg-[#F0F2F5] rounded-xl p-6 shadow-md hover:shadow-lg transition-all duration-150">
            <div class="flex justify-center mb-6">
                <svg class="h-16 w-16 text-[#006CC]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-[#0D1E3C] text-center mb-3 {{ app()->getLocale() == 'he' ? 'font-heebo' : 'font-inter' }}">{{ __('home.features.vps.title') }}</h3>
            <p class="text-[#0F2F5] text-center mb-6 {{ app()->getLocale() == 'he' ? 'font-heebo' : 'font-inter' }}" style="font-size: 16px;">
                {{ __('home.features.vps.description') }}
            </p>
            <div class="flex justify-center">
                <a href="{{ route('vps') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-[#006CC] hover:bg-[#0F2F5] transition-all duration-150 ease-in uppercase {{ app()->getLocale() == 'he' ? 'font-heebo' : 'font-inter' }}" aria-label="{{ __('home.features.vps.cta_aria_label') }}">
                    {{ __('home.features.vps.cta') }}
                </a>
            </div>
        </div>

        <!-- Domain Registration Card -->
        <div class="feature-card bg-[#F0F2F5] rounded-xl p-6 shadow-md hover:shadow-lg transition-all duration-150">
            <div class="flex justify-center mb-6">
                <svg class="h-16 w-16 text-[#006CC]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-[#0D1E3C] text-center mb-3 {{ app()->getLocale() == 'he' ? 'font-heebo' : 'font-inter' }}">{{ __('home.features.domains.title') }}</h3>
            <p class="text-[#0F2F5] text-center mb-6 {{ app()->getLocale() == 'he' ? 'font-heebo' : 'font-inter' }}" style="font-size: 16px;">
                {{ __('home.features.domains.description') }}
            </p>
            <div class="flex justify-center">
                <a href="{{ route('domains') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-[#006CC] hover:bg-[#0F2F5] transition-all duration-150 ease-in uppercase {{ app()->getLocale() == 'he' ? 'font-heebo' : 'font-inter' }}" aria-label="{{ __('home.features.domains.cta_aria_label') }}">
                    {{ __('home.features.domains.cta') }}
                </a>
            </div>
        </div>

        <!-- Cloud Solutions Card -->
        <div class="feature-card bg-[#F0F2F5] rounded-xl p-6 shadow-md hover:shadow-lg transition-all duration-150">
            <div class="flex justify-center mb-6">
                <svg class="h-16 w-16 text-[#006CC]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-[#0D1E3C] text-center mb-3 {{ app()->getLocale() == 'he' ? 'font-heebo' : 'font-inter' }}">{{ __('home.features.cloud.title') }}</h3>
            <p class="text-[#0F2F5] text-center mb-6 {{ app()->getLocale() == 'he' ? 'font-heebo' : 'font-inter' }}" style="font-size: 16px;">
                {{ __('home.features.cloud.description') }}
            </p>
            <div class="flex justify-center">
                {{-- Assuming 'cloud' route exists --}}
                <a href="{{ route('cloud') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-[#006CC] hover:bg-[#0F2F5] transition-all duration-150 ease-in uppercase {{ app()->getLocale() == 'he' ? 'font-heebo' : 'font-inter' }}" aria-label="{{ __('home.features.cloud.cta_aria_label') }}">
                    {{ __('home.features.cloud.cta') }}
                </a>
            </div>
        </div>
    </div>
</section>

@if(isset($featuredDomains) && count($featuredDomains) > 0)
<section class="py-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto bg-[#F0F2F5]">
    <h2 class="text-3xl font-bold text-center text-[#0D1E3C] mb-12 {{ app()->getLocale() == 'he' ? 'font-heebo' : 'font-inter' }}" style="font-size: 32px;">{{ __('home.featured_domains.title') }}</h2>
    <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
        @foreach($featuredDomains as $domain)
            <div class="p-6 text-center transition-all duration-150 bg-white rounded-lg shadow-md hover:shadow-lg">
                <h3 class="text-xl font-semibold text-[#0D1E3C] {{ app()->getLocale() == 'he' ? 'font-heebo' : 'font-inter' }}">{{ $domain }}</h3>
                <p class="mt-3 text-[#0F2F5] {{ app()->getLocale() == 'he' ? 'font-heebo' : 'font-inter' }}" style="font-size: 16px;">{{ __('home.featured_domains.description') }}</p>
                <div class="mt-4">
                    <a href="{{ route('search', ['name' => $domain]) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-[#006CC] hover:text-[#0F2F5] transition-colors {{ app()->getLocale() == 'he' ? 'font-heebo' : 'font-inter' }}" aria-label="{{ __('home.featured_domains.cta_aria_label', ['domain' => $domain]) }}">
                        {{ __('home.featured_domains.cta') }}
                        <svg class="{{ app()->getLocale() == 'he' ? 'mr-1' : 'ml-1' }} w-5 h-5 {{ app()->getLocale() == 'he' ? 'rtl:rotate-180' : '' }}" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endif

<!-- Pricing Section -->
<section class="px-4 py-16 mx-auto sm:px-6 lg:px-8 max-w-7xl">
    <div class="mb-12 text-center">
        <h2 class="text-3xl font-bold text-[#0D1E3C] {{ app()->getLocale() == 'he' ? 'font-heebo' : 'font-inter' }}">{{ __('home.pricing.title') }}</h2>
        <p class="mt-4 text-xl text-[#0F2F5] {{ app()->getLocale() == 'he' ? 'font-heebo' : 'font-inter' }}">{{ __('home.pricing.subtitle') }}</p>
    </div>

    <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
        <!-- Basic Plan -->
        <div class="overflow-hidden transition-all duration-150 bg-white rounded-lg shadow-md hover:shadow-lg">
            <div class="bg-[#F0F2F5] p-6 text-center border-b">
                <h3 class="text-2xl font-bold text-[#0D1E3C] {{ app()->getLocale() == 'he' ? 'font-heebo' : 'font-inter' }}">{{ __('home.pricing.basic.name') }}</h3>
                <div class="mt-4">
                    <span class="text-4xl font-bold text-[#006CC]">{{ app()->getLocale() == 'he' ? '₪' : '$' }}{{ __('home.pricing.basic.price') }}</span>
                    <span class="text-[#0F2F5]">{{ __('home.pricing.per_month') }}</span>
                </div>
            </div>
            <div class="p-6">
                <ul class="space-y-4">
                    @foreach (__('home.pricing.basic.features') as $feature)
                    <li class="flex items-center">
                        <svg class="h-5 w-5 text-green-500 {{ app()->getLocale() == 'he' ? 'ml-2' : 'mr-2' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="text-[#0F2F5] {{ app()->getLocale() == 'he' ? 'font-heebo' : 'font-inter' }}">{{ $feature }}</span>
                    </li>
                    @endforeach
                </ul>
                <div class="mt-8">
                    <a href="{{ route('hosting') }}" class="block w-full text-center px-4 py-2 rounded-md bg-[#006CC] hover:bg-[#0F2F5] text-white font-medium transition-colors {{ app()->getLocale() == 'he' ? 'font-heebo' : 'font-inter' }}">
                        {{ __('home.pricing.cta') }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Business Plan -->
        <div class="bg-white rounded-lg shadow-xl border-2 border-[#006CC] relative transform md:scale-105">
             <div class="absolute inset-x-0 top-0 flex justify-center transform -translate-y-1/2">
                <span class="inline-flex items-center px-4 py-1 rounded-full text-xs font-semibold bg-[#006CC] text-white {{ app()->getLocale() == 'he' ? 'font-heebo' : 'font-inter' }}">
                    {{ __('home.pricing.popular') }}
                </span>
            </div>
            <div class="bg-[#F0F2F5] p-6 text-center border-b">
                <h3 class="text-2xl font-bold text-[#0D1E3C] {{ app()->getLocale() == 'he' ? 'font-heebo' : 'font-inter' }}">{{ __('home.pricing.business.name') }}</h3>
                <div class="mt-4">
                    <span class="text-4xl font-bold text-[#006CC]">{{ app()->getLocale() == 'he' ? '₪' : '$' }}{{ __('home.pricing.business.price') }}</span>
                    <span class="text-[#0F2F5]">{{ __('home.pricing.per_month') }}</span>
                </div>
            </div>
            <div class="p-6">
                <ul class="space-y-4">
                     @foreach (__('home.pricing.business.features') as $feature)
                    <li class="flex items-center">
                        <svg class="h-5 w-5 text-green-500 {{ app()->getLocale() == 'he' ? 'ml-2' : 'mr-2' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="text-[#0F2F5] {{ app()->getLocale() == 'he' ? 'font-heebo' : 'font-inter' }}">{{ $feature }}</span>
                    </li>
                    @endforeach
                </ul>
                <div class="mt-8">
                    <a href="{{ route('hosting') }}" class="block w-full text-center px-4 py-2 rounded-md bg-[#006CC] hover:bg-[#0F2F5] text-white font-medium transition-colors {{ app()->getLocale() == 'he' ? 'font-heebo' : 'font-inter' }}">
                        {{ __('home.pricing.cta') }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Premium Plan -->
        <div class="overflow-hidden transition-all duration-150 bg-white rounded-lg shadow-md hover:shadow-lg">
            <div class="bg-[#F0F2F5] p-6 text-center border-b">
                <h3 class="text-2xl font-bold text-[#0D1E3C] {{ app()->getLocale() == 'he' ? 'font-heebo' : 'font-inter' }}">{{ __('home.pricing.premium.name') }}</h3>
                <div class="mt-4">
                    <span class="text-4xl font-bold text-[#006CC]">{{ app()->getLocale() == 'he' ? '₪' : '$' }}{{ __('home.pricing.premium.price') }}</span>
                    <span class="text-[#0F2F5]">{{ __('home.pricing.per_month') }}</span>
                </div>
            </div>
            <div class="p-6">
                <ul class="space-y-4">
                     @foreach (__('home.pricing.premium.features') as $feature)
                    <li class="flex items-center">
                        <svg class="h-5 w-5 text-green-500 {{ app()->getLocale() == 'he' ? 'ml-2' : 'mr-2' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="text-[#0F2F5] {{ app()->getLocale() == 'he' ? 'font-heebo' : 'font-inter' }}">{{ $feature }}</span>
                    </li>
                    @endforeach
                </ul>
                <div class="mt-8">
                    <a href="{{ route('hosting') }}" class="block w-full text-center px-4 py-2 rounded-md bg-[#006CC] hover:bg-[#0F2F5] text-white font-medium transition-colors {{ app()->getLocale() == 'he' ? 'font-heebo' : 'font-inter' }}">
                        {{ __('home.pricing.cta') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="py-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto bg-[#F0F2F5]">
    <div class="mb-12 text-center">
        <h2 class="text-3xl font-bold text-[#0D1E3C] {{ app()->getLocale() == 'he' ? 'font-heebo' : 'font-inter' }}">{{ __('home.contact.title') }}</h2>
        <p class="mt-4 text-xl text-[#0F2F5] {{ app()->getLocale() == 'he' ? 'font-heebo' : 'font-inter' }}">{{ __('home.contact.subtitle') }}</p>
    </div>

    <div class="grid grid-cols-1 gap-12 lg:grid-cols-2">
        <div>
            <form action="{{ route('contact.submit') }}" method="POST">
                @csrf
                <div class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-[#0D1E3C] {{ app()->getLocale() == 'he' ? 'font-heebo' : 'font-inter' }}">{{ __('home.contact.name_label') }}</label>
                        <input type="text" id="name" name="name" required class="mt-1 block w-full px-4 py-3 border-gray-300 rounded-md shadow-sm focus:ring-[#006CC] focus:border-[#006CC] {{ app()->getLocale() == 'he' ? 'font-heebo' : 'font-inter' }}">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-[#0D1E3C] {{ app()->getLocale() == 'he' ? 'font-heebo' : 'font-inter' }}">{{ __('home.contact.email_label') }}</label>
                        <input type="email" id="email" name="email" required class="mt-1 block w-full px-4 py-3 border-gray-300 rounded-md shadow-sm focus:ring-[#006CC] focus:border-[#006CC] {{ app()->getLocale() == 'he' ? 'font-heebo' : 'font-inter' }}">
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-medium text-[#0D1E3C] {{ app()->getLocale() == 'he' ? 'font-heebo' : 'font-inter' }}">{{ __('home.contact.message_label') }}</label>
                        <textarea id="message" name="message" rows="4" required class="mt-1 block w-full px-4 py-3 border-gray-300 rounded-md shadow-sm focus:ring-[#006CC] focus:border-[#006CC] {{ app()->getLocale() == 'he' ? 'font-heebo' : 'font-inter' }}"></textarea>
                    </div>
                    <div>
                        <button type="submit" class="w-full px-6 py-3 bg-[#006CC] hover:bg-[#0F2F5] text-white font-medium rounded-md transition-colors {{ app()->getLocale() == 'he' ? 'font-heebo' : 'font-inter' }}">
                            {{ __('home.contact.submit_button') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="p-8 bg-white rounded-lg shadow-md">
            <h3 class="text-xl font-bold text-[#0D1E3C] mb-6 {{ app()->getLocale() == 'he' ? 'font-heebo' : 'font-inter' }}">{{ __('home.contact.details_title') }}</h3>
            <div class="space-y-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-[#006CC]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>
                    <div class="{{ app()->getLocale() == 'he' ? 'mr-4' : 'ml-4' }}">
                        <p class="text-[#0D1E3C] font-medium {{ app()->getLocale() == 'he' ? 'font-heebo' : 'font-inter' }}">{{ __('home.contact.phone_label') }}</p>
                        <p class="mt-1 text-[#0F2F5] {{ app()->getLocale() == 'he' ? 'font-heebo' : 'font-inter' }}">{{ __('home.contact.phone_number') }}</p>
                    </div>
                </div>

                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-[#006CC]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                     <div class="{{ app()->getLocale() == 'he' ? 'mr-4' : 'ml-4' }}">
                        <p class="text-[#0D1E3C] font-medium {{ app()->getLocale() == 'he' ? 'font-heebo' : 'font-inter' }}">{{ __('home.contact.email_label_info') }}</p>
                        <p class="mt-1 text-[#0F2F5] {{ app()->getLocale() == 'he' ? 'font-heebo' : 'font-inter' }}">{{ __('home.contact.email_address') }}</p>
                    </div>
                </div>

                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-[#006CC]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                     <div class="{{ app()->getLocale() == 'he' ? 'mr-4' : 'ml-4' }}">
                        <p class="text-[#0D1E3C] font-medium {{ app()->getLocale() == 'he' ? 'font-heebo' : 'font-inter' }}">{{ __('home.contact.address_label') }}</p>
                        <p class="mt-1 text-[#0F2F5] {{ app()->getLocale() == 'he' ? 'font-heebo' : 'font-inter' }}">{{ __('home.contact.address_details') }}</p>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <h4 class="text-lg font-medium text-[#0D1E3C] mb-4 {{ app()->getLocale() == 'he' ? 'font-heebo' : 'font-inter' }}">{{ __('home.contact.hours_title') }}</h4>
                <ul class="space-y-2 text-[#0F2F5] {{ app()->getLocale() == 'he' ? 'font-heebo' : 'font-inter' }}">
                    @foreach (__('home.contact.hours_details') as $line)
                        <li>{{ $line }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>
@endsection
