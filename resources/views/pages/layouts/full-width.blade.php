@extends('layouts.app')

@section('content')
<div class="px-4 py-12 sm:px-6 lg:px-8 max-w-full mx-auto">
    <article class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <h1 class="text-3xl font-bold mb-6 text-center">{{ $page->title }}</h1>
            
            <div class="prose prose-blue max-w-none">
                {!! $page->content !!}
            </div>
        </div>
    </article>
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