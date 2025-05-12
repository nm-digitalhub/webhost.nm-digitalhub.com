<x-filament-panels::layouts.base :title="$title">
    @vite('resources/css/app.css')

    <div class="min-h-screen bg-secondary rtl flex flex-col font-sans">
   
        <header class="bg-white shadow px-6 py-4 flex justify-between items-center">
            <a href="{{ url('/') }}" class="flex items-center gap-2 rtl:gap-0 rtl:space-x-reverse">
                <img src="{{ asset('images/logo.svg') }}" class="w-10 h-10" alt="Logo">
                <span class="text-xl font-bold text-primary">NM-DigitalHUB.com</span>
            </a>
            @livewire('filament-panels::topbar')
        </header>

        <div class="flex flex-1 overflow-hidden">
            <x-filament-panels::layouts.sidebar />

            <main class="flex-1 p-6 overflow-y-auto">
                {{ $slot }}
            </main>
        </div>

        <footer class="text-center py-4 text-sm text-secondary">
            &copy; {{ date('Y') }} NM-DigitalHUB. כל הזכויות שמורות.
        </footer>
    </div>
</x-filament-panels::layouts.base>