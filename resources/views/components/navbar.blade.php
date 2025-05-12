<nav {{ $attributes->merge(['class' => 'bg-white shadow-md px-6 py-4 rtl:text-right ltr:text-left']) }}>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <x-logo-with-text />
            </div>
            <div class="flex items-center rtl:space-x-reverse space-x-4 flex-nowrap overflow-x-auto">
                {{ $slot }}
            </div>
        </div>
    </div>
</nav>
