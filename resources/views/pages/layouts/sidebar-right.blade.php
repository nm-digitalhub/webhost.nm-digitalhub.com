@extends('layouts.app')

@section('content')
<div class="py-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <div class="flex flex-col lg:flex-row gap-8">
        <article class="lg:w-2/3 bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h1 class="text-3xl font-bold mb-6">{{ $page->title }}</h1>
                
                <div class="prose prose-blue max-w-none">
                    {!! $page->content !!}
                </div>
            </div>
        </article>
        
        <aside class="lg:w-1/3">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 sticky top-8">
                @if(isset($metadata['sidebar_title']))
                <h3 class="text-xl font-semibold mb-4">{{ $metadata['sidebar_title'] }}</h3>
                @endif
                
                @if(isset($metadata['sidebar_content']))
                <div class="prose prose-sm">
                    {!! $metadata['sidebar_content'] !!}
                </div>
                @endif
                
                @if(isset($metadata['sidebar_cta']))
                <div class="mt-6">
                    <a href="{{ $metadata['sidebar_cta_url'] ?? '#' }}" class="inline-block w-full px-4 py-2 bg-[#0084FF] hover:bg-[#00457C] text-white font-medium rounded-md text-center transition-colors">
                        {{ $metadata['sidebar_cta'] }}
                    </a>
                </div>
                @endif
            </div>
        </aside>
    </div>
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