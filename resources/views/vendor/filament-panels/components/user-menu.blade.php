@php
    $user = filament()->auth()->user();
    $items = filament()->getUserMenuItems();

    $profileItem = $items['profile'] ?? $items['account'] ?? null;
    $profileItemUrl = $profileItem?->getUrl();
    $profilePage = filament()->getProfilePage();
    $hasProfileItem = filament()->hasProfile() || filled($profileItemUrl);

    $logoutItem = $items['logout'] ?? null;
    $items = \Illuminate\Support\Arr::except($items, ['account', 'logout', 'profile']);
@endphp

<x-filament::dropdown
    placement="bottom-end"
    teleport
    :attributes="$attributes->class(['fi-user-menu'])"
>
    <x-slot name="trigger">
        <button type="button" class="shrink-0" aria-label="{{ __('filament-panels::layout.actions.open_user_menu.label') }}">
            <x-filament-panels::avatar.user :user="$user" />
        </button>
    </x-slot>

    {{-- כרטיס פרופיל בראש התפריט --}}
    @if ($hasProfileItem)
        <x-filament::dropdown.header class="bg-primary text-white px-4 py-3 flex items-center gap-3">
            <x-filament-panels::avatar.user :user="$user" class="w-10 h-10" />
            <div class="text-sm leading-tight">
                <div class="font-bold">{{ filament()->getUserName($user) }}</div>
                <div class="text-xs text-white/80">{{ $user->email }}</div>
            </div>
        </x-filament::dropdown.header>
    @endif

    {{-- מעבר לדף פרופיל --}}
    @if ($profileItem?->isVisible() ?? true)
        <x-filament::dropdown.list>
            <x-filament::dropdown.list.item
                :color="$profileItem?->getColor()"
                :icon="$profileItem?->getIcon() ?? 'heroicon-m-user-circle'"
                :href="$profileItemUrl ?? filament()->getProfileUrl()"
                :target="($profileItem?->shouldOpenUrlInNewTab() ?? false) ? '_blank' : null"
                tag="a"
            >
                {{ $profileItem?->getLabel() ?? __('filament-panels::layout.actions.profile.label') }}
            </x-filament::dropdown.list.item>
        </x-filament::dropdown.list>
    @endif

    {{-- מעבר בין מצב כהה/בהיר --}}
    @if (filament()->hasDarkMode() && !filament()->hasDarkModeForced())
        <x-filament::dropdown.list>
            <x-filament-panels::theme-switcher />
        </x-filament::dropdown.list>
    @endif

    {{-- קישורים נוספים (הגדרות וכו׳) --}}
    <x-filament::dropdown.list>
        @foreach ($items as $item)
            @php $itemPostAction = $item->getPostAction(); @endphp
            <x-filament::dropdown.list.item
                :action="$itemPostAction"
                :color="$item->getColor()"
                :href="$item->getUrl()"
                :icon="$item->getIcon()"
                :method="filled($itemPostAction) ? 'post' : null"
                :tag="filled($itemPostAction) ? 'form' : 'a'"
                :target="$item->shouldOpenUrlInNewTab() ? '_blank' : null"
            >
                {{ $item->getLabel() }}
            </x-filament::dropdown.list.item>
        @endforeach
    </x-filament::dropdown.list>

    {{-- כפתור יציאה --}}
    <x-filament::dropdown.list>
        <x-filament::dropdown.list.item
            :action="$logoutItem?->getUrl() ?? filament()->getLogoutUrl()"
            :color="$logoutItem?->getColor()"
            :icon="$logoutItem?->getIcon() ?? 'heroicon-m-arrow-left-on-rectangle'"
            method="post"
            tag="form"
        >
            {{ $logoutItem?->getLabel() ?? __('filament-panels::layout.actions.logout.label') }}
        </x-filament::dropdown.list.item>
    </x-filament::dropdown.list>
</x-filament::dropdown>