<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    dir="{{ __('filament-panels::layout.direction') ?? 'ltr' }}"
    @class([
        'filament-panels-layout',
        'dark' => filament()->hasDarkModeForced(),
    ])
>
    <head>
        {{ \Filament\Support\Facades\FilamentView::renderHook('panels::head.start') }}

        <meta charset="utf-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        @if ($favicon = filament()->getFavicon())
            <link rel="icon" href="{{ $favicon }}" />
        @endif

        <title>
            {{ filled($title = strip_tags($title ?? '')) ? "{$title} - " : null }}
            {{ strip_tags(filament()->getBrandName()) }}
        </title>

        {{ \Filament\Support\Facades\FilamentView::renderHook('panels::styles.before') }}

        <style>
            [x-cloak=''] {
                display: none !important;
            }
        </style>

        @filamentStyles
        {{ filament()->getTheme()->getHtml() }}
        {{ filament()->getFontHtml() }}

        <style>
            :root {
                --font-family: {!! filament()->getFontFamily() !!};
                --sidebar-width: {{ filament()->getSidebarWidth() }};
                --collapsed-sidebar-width: {{ filament()->getCollapsedSidebarWidth() }};
            }
        </style>

        {{ \Filament\Support\Facades\FilamentView::renderHook('panels::styles.after') }}

        @if (! filament()->hasDarkMode())
            <script>
                localStorage.setItem('theme', 'light')
            </script>
        @elseif (filament()->hasDarkModeForced())
            <script>
                localStorage.setItem('theme', 'dark')
            </script>
        @else
            <script>
                const theme = localStorage.getItem('theme') ?? @js(filament()->getDefaultThemeMode()->value)

                if (
                    theme === 'dark' ||
                    (theme === 'system' &&
                        window.matchMedia('(prefers-color-scheme: dark)')
                            .matches)
                ) {
                    document.documentElement.classList.add('dark')
                }
            </script>
        @endif

        {{ \Filament\Support\Facades\FilamentView::renderHook('panels::head.end') }}
    </head>

    <body
        @class([
            'filament-panels-body bg-gray-50 font-normal text-gray-950 antialiased dark:bg-gray-950 dark:text-white',
        ])
    >
        {{ \Filament\Support\Facades\FilamentView::renderHook('panels::body.start') }}

        {{ $slot }}

        @livewire(Filament\Livewire\Notifications::class)

        {{ \Filament\Support\Facades\FilamentView::renderHook('panels::scripts.before') }}

        @filamentScripts(withCore: true)

        {{ \Filament\Support\Facades\FilamentView::renderHook('panels::scripts.after') }}

        {{ \Filament\Support\Facades\FilamentView::renderHook('panels::body.end') }}
    </body>
</html>
