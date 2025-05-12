<x-filament::section>
    <div class="flex items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="relative">
                @if(auth()->user()->avatar)
                    <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}" class="w-16 h-16 rounded-full">
                @else
                    <div class="flex items-center justify-center w-16 h-16 text-2xl font-bold text-white bg-primary-600 rounded-full">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                @endif
                <div class="absolute bottom-0 right-0 w-4 h-4 bg-success-500 border-2 border-white dark:border-gray-900 rounded-full"></div>
            </div>
            <div>
                <h2 class="text-xl font-bold">Welcome back, {{ auth()->user()->name }}!</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ auth()->user()->email }}</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <x-filament::button
                href="{{ route('filament.admin.pages.dashboard') }}"
                color="gray"
                outlined
            >
                Dashboard
            </x-filament::button>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-filament::button
                    type="submit"
                    color="danger"
                    outlined
                >
                    Logout
                </x-filament::button>
            </form>
        </div>
    </div>
</x-filament::section>
<x-filament::section>
    <div class="flex items-center gap-4">
        <div class="flex-shrink-0">
            @if(auth()->user() && auth()->user()->avatar)
                <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}" class="w-12 h-12 rounded-full">
            @else
                <div class="flex items-center justify-center w-12 h-12 text-lg font-bold text-white bg-primary-600 rounded-full">
                    {{ auth()->user() ? substr(auth()->user()->name, 0, 1) : 'U' }}
                </div>
            @endif
        </div>
        <div>
            <h2 class="text-lg font-medium">Welcome, {{ auth()->user() ? auth()->user()->name : 'User' }}!</h2>
            <p class="text-sm text-gray-500">{{ auth()->user() ? auth()->user()->email : 'guest@example.com' }}</p>
        </div>
    </div>
</x-filament::section>
<x-filament::section>
    <div class="flex items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold tracking-tight">
                Welcome, {{ auth()->user()->name }}!
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Your account overview and quick actions
            </p>
        </div>
        <div class="shrink-0">
            <x-filament::icon-button
                icon="heroicon-o-user-circle"
                label="View profile"
                href="{{ route('filament.admin.pages.dashboard') }}"
            />
        </div>
    </div>

    <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
        <x-filament::card class="flex items-center justify-between">
            <div>
                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    Role
                </div>
                <div class="text-xl font-semibold">
                    @if(auth()->user()->roles->count() > 0)
                        {{ auth()->user()->roles->pluck('name')->join(', ') }}
                    @else
                        User
                    @endif
                </div>
            </div>
            <x-filament::icon
                icon="heroicon-o-identification"
                class="h-8 w-8 text-primary-500"
            />
        </x-filament::card>

        <x-filament::card class="flex items-center justify-between">
            <div>
                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    Email
                </div>
                <div class="text-xl font-semibold truncate max-w-[200px]">
                    {{ auth()->user()->email }}
                </div>
            </div>
            <x-filament::icon
                icon="heroicon-o-envelope"
                class="h-8 w-8 text-primary-500"
            />
        </x-filament::card>

        <x-filament::card class="flex items-center justify-between">
            <div>
                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    Account created
                </div>
                <div class="text-xl font-semibold">
                    {{ auth()->user()->created_at->diffForHumans() }}
                </div>
            </div>
            <x-filament::icon
                icon="heroicon-o-calendar"
                class="h-8 w-8 text-primary-500"
            />
        </x-filament::card>
    </div>
</x-filament::section>
