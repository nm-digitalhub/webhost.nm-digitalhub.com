@extends('layouts.client')

@section('title', $page->meta_title ?? $page->title)

@section('meta')
    @if($page->meta_description)
        <meta name="description" content="{{ $page->meta_description }}">
    @endif
    
    @if($page->meta_keywords)
        <meta name="keywords" content="{{ $page->meta_keywords }}">
    @endif
@endsection

@section('content')
    <div class="container mx-auto py-6">
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="p-6">
                <h1 class="text-2xl font-bold mb-6">{{ $page->title }}</h1>
                
                @impersonating
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                        <p class="font-bold">אתה מתחזה למשתמש זה!</p>
                        <p>אתה צופה כרגע בדף לקוח כמשתמש אחר. <a href="{{ route('impersonate.stop') }}" onclick="event.preventDefault(); document.getElementById('impersonation-form').submit();" class="underline">לחץ כאן כדי לחזור לחשבון שלך</a>.</p>
                        <form id="impersonation-form" action="{{ route('impersonate.stop') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                @endimpersonating
                
                <div class="prose prose-blue max-w-none">
                    {!! $page->content !!}
                </div>
            </div>
        </div>
    </div>
@endsection