<nav class="px-2 mt-5 space-y-1">
    <!-- Dashboard - Always first item -->
    <a href="{{ route('client.dashboard') }}" class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('client.dashboard') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
        <svg class="{{ request()->routeIs('client.dashboard') ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-500' }} mr-3 h-6 w-6 rtl-flip" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
        </svg>
        דף הבית
    </a>

    <!-- Dynamic Client Modules -->
    @if(isset($clientModules) && count($clientModules) > 0)
        @php
            $currentSectionId = null;
        @endphp

        @foreach($clientModules as $module)
            @if($module->type === 'section')
                @if($currentSectionId !== null)
                    <!-- Close previous section with a divider -->
                    <div class="my-4 border-t border-gray-200"></div>
                @endif
                
                <!-- Section Header -->
                <div class="px-2 pt-3 pb-1">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        {{ $module->name }}
                    </h3>
                </div>
                
                @php
                    $currentSectionId = $module->id;
                @endphp
            @elseif($module->type === 'page')
                <!-- Page/Route Module -->
                @if($module->route_name)
                    <a href="{{ route($module->route_name) }}" class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs($module->route_name) ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        @if($module->icon)
                            <!-- If we have an icon defined -->
                            <i class="{{ $module->icon }} {{ request()->routeIs($module->route_name) ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-500' }} mr-3 h-6 w-6 rtl-flip"></i>
                        @else
                            <!-- Default icon -->
                            <svg class="{{ request()->routeIs($module->route_name) ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-500' }} mr-3 h-6 w-6 rtl-flip" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        @endif
                        {{ $module->name }}
                    </a>
                @endif
            @elseif($module->type === 'link')
                <!-- External Link Module -->
                @if(isset($module->metadata['url']))
                    <a href="{{ $module->metadata['url'] }}" target="{{ $module->metadata['target'] ?? '_self' }}" class="group flex items-center px-2 py-2 text-base font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                        @if($module->icon)
                            <i class="{{ $module->icon }} text-gray-400 group-hover:text-gray-500 mr-3 h-6 w-6 rtl-flip"></i>
                        @else
                            <svg class="text-gray-400 group-hover:text-gray-500 mr-3 h-6 w-6 rtl-flip" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                        @endif
                        {{ $module->name }}
                    </a>
                @endif
            @endif
        @endforeach
    @endif

    <!-- Additional menu pages -->
    @if(isset($menuPages) && count($menuPages) > 0)
        <div class="my-4 border-t border-gray-200"></div>
        <div class="px-2 pt-3 pb-1">
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                עמודים נוספים
            </h3>
        </div>

        @foreach($menuPages as $page)
            <a href="{{ route('client.pages.show', $page->slug) }}" class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->is('client/pages/'.$page->slug) ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                @if($page->menu_icon)
                    <i class="{{ $page->menu_icon }} {{ request()->is('client/pages/'.$page->slug) ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-500' }} mr-3 h-6 w-6 rtl-flip"></i>
                @else
                    <svg class="{{ request()->is('client/pages/'.$page->slug) ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-500' }} mr-3 h-6 w-6 rtl-flip" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                @endif
                {{ $page->title }}
            </a>
        @endforeach
    @endif

    <!-- Settings section - always last -->
    <div class="my-4 border-t border-gray-200"></div>
    
    @impersonating
        <!-- Show impersonation status and exit button -->
        <div class="bg-red-100 text-red-800 px-3 py-2 rounded-md mb-3">
            <div class="font-semibold">מצב התחזות פעיל</div>
            <p class="text-xs">אתה מתחזה למשתמש זה</p>
            <form method="POST" action="{{ route('impersonate.stop') }}" class="mt-2">
                @csrf
                <button type="submit" class="px-3 py-1 bg-red-200 text-red-800 text-xs rounded hover:bg-red-300">
                    חזור לחשבון שלך
                </button>
            </form>
        </div>
    @endimpersonating

    <a href="{{ route('client.profile') }}" class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('client.profile') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
        <svg class="{{ request()->routeIs('client.profile') ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-500' }} mr-3 h-6 w-6 rtl-flip" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
        </svg>
        הפרופיל שלי
    </a>
<nav class="mt-5 px-3 space-y-1">
    <a href="{{ route('client.dashboard') }}" class="{{ request()->routeIs('client.dashboard') ? 'bg-indigo-900 text-white' : 'text-indigo-100 hover:bg-indigo-700' }} group flex items-center px-3 py-2 text-sm font-medium rounded-md">
        <svg class="mr-3 flex-shrink-0 h-6 w-6 text-indigo-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
        </svg>
        {{ __('Dashboard') }}
    </a>

    <a href="{{ route('client.domains') }}" class="{{ request()->routeIs('client.domains*') ? 'bg-indigo-900 text-white' : 'text-indigo-100 hover:bg-indigo-700' }} group flex items-center px-3 py-2 text-sm font-medium rounded-md">
        <svg class="mr-3 flex-shrink-0 h-6 w-6 text-indigo-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
        </svg>
        {{ __('Domains') }}
    </a>

    <a href="{{ route('client.hosting') }}" class="{{ request()->routeIs('client.hosting*') ? 'bg-indigo-900 text-white' : 'text-indigo-100 hover:bg-indigo-700' }} group flex items-center px-3 py-2 text-sm font-medium rounded-md">
        <svg class="mr-3 flex-shrink-0 h-6 w-6 text-indigo-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
        </svg>
        {{ __('Hosting') }}
    </a>

    <a href="{{ route('client.vps') }}" class="{{ request()->routeIs('client.vps*') ? 'bg-indigo-900 text-white' : 'text-indigo-100 hover:bg-indigo-700' }} group flex items-center px-3 py-2 text-sm font-medium rounded-md">
        <svg class="mr-3 flex-shrink-0 h-6 w-6 text-indigo-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
        </svg>
        {{ __('VPS') }}
    </a>

    <a href="{{ route('client.invoices') }}" class="{{ request()->routeIs('client.invoices*') ? 'bg-indigo-900 text-white' : 'text-indigo-100 hover:bg-indigo-700' }} group flex items-center px-3 py-2 text-sm font-medium rounded-md">
        <svg class="mr-3 flex-shrink-0 h-6 w-6 text-indigo-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        {{ __('Invoices') }}
    </a>

    <a href="{{ route('client.support') }}" class="{{ request()->routeIs('client.support*') ? 'bg-indigo-900 text-white' : 'text-indigo-100 hover:bg-indigo-700' }} group flex items-center px-3 py-2 text-sm font-medium rounded-md">
        <svg class="mr-3 flex-shrink-0 h-6 w-6 text-indigo-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>
        {{ __('Support') }}
    </a>

    <a href="{{ route('client.settings') }}" class="{{ request()->routeIs('client.settings*') ? 'bg-indigo-900 text-white' : 'text-indigo-100 hover:bg-indigo-700' }} group flex items-center px-3 py-2 text-sm font-medium rounded-md">
        <svg class="mr-3 flex-shrink-0 h-6 w-6 text-indigo-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        {{ __('Settings') }}
    </a>
</nav>
    <a href="{{ route('client.settings') }}" class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('client.settings') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
        <svg class="{{ request()->routeIs('client.settings') ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-500' }} mr-3 h-6 w-6 rtl-flip" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        הגדרות
    </a>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="flex items-center px-2 py-2 text-base font-medium text-gray-600 rounded-md group hover:bg-gray-50 hover:text-gray-900">
            <svg class="w-6 h-6 mr-3 text-gray-400 group-hover:text-gray-500 rtl-flip" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
            התנתק
        </a>
    </form>
</nav>