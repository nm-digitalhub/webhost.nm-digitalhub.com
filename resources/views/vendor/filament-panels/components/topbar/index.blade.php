@props(['navigation'])

<div
    {{
        $attributes->class([
            'fi-topbar sticky top-0 z-20 overflow-x-clip shadow-md',
            'fi-topbar-with-navigation' => filament()->hasTopNavigation(),
        ])
    }}
>
    <nav
        class="flex h-16 items-center gap-x-4 bg-white px-6 shadow-sm ring-1 ring-gray-100 dark:bg-gray-900 dark:ring-white/10 rtl flex-row-reverse"
    >
        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::TOPBAR_START) }}

        {{-- כפתורי פתיחה/סגירה של סיידבר במובייל --}}
        @if (filament()->hasNavigation())
            <x-filament::icon-button
                color="gray"
                icon="heroicon-o-bars-3"
                x-on:click="$store.sidebar.open()"
                x-show="! $store.sidebar.isOpen"
                class="lg:hidden"
            />

            <x-filament::icon-button
                color="gray"
                icon="heroicon-o-x-mark"
                x-on:click="$store.sidebar.close()"
                x-show="$store.sidebar.isOpen"
                class="lg:hidden"
            />
        @endif

        {{-- לוגו עם מיתוג --}}
        <div class="me-6 hidden lg:flex items-center">
            <a href="{{ url('/') }}" class="flex items-center gap-2">
                <img src="{{ asset('images/logo.svg') }}" class="w-8 h-8 rtl-flip" alt="Logo" />
                <span class="text-[#006CC9] font-bold text-lg">NM-DigitalHUB</span>
            </a>
        </div>

        {{-- תפריטי ניווט בקבוצות --}}
        @if (filament()->hasNavigation())
            <ul class="hidden lg:flex items-center gap-x-6 text-sm font-medium text-[#0D1E3C]">
                @foreach ($navigation as $group)
                    @foreach ($group->getItems() as $item)
                        <x-filament-panels::topbar.item
                            :active="$item->isActive()"
                            :icon="$item->getIcon()"
                            :url="$item->getUrl()"
                        >
                            {{ $item->getLabel() }}
                        </x-filament-panels::topbar.item>
                    @endforeach
                @endforeach
            </ul>
        @endif

        {{-- צד ימין של הטופבר --}}
        <div class="ms-auto flex items-center gap-x-4">
            {{-- חיפוש גלובלי --}}
            @if (filament()->isGlobalSearchEnabled())
                @livewire(Filament\Livewire\GlobalSearch::class)
            @endif

            {{-- התראות ופרופיל משתמש --}}
            @if (filament()->auth()->check())
                @if (filament()->hasDatabaseNotifications())
                    @livewire(Filament\Livewire\DatabaseNotifications::class, [
                        'lazy' => filament()->hasLazyLoadedDatabaseNotifications(),
                    ])
                @endif

                <x-filament-panels::user-menu />
            @endif
        </div>

        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::TOPBAR_END) }}
    </nav>
</div>