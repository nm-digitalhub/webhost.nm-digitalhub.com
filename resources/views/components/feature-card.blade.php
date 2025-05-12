<div class="feature-card bg-[#F0F2F5] rounded-xl p-6 shadow-md hover:shadow-lg transition-all duration-150">
    <div class="flex justify-center mb-6">
        <div class="h-16 w-16 text-[#006CC]">
            {{ $icon }}
        </div>
    </div>
    <h3 class="text-xl font-bold text-[#0D1E3C] text-center mb-3 font-inter">{{ $title }}</h3>
    <p class="text-[#0F2F5] text-center mb-6 font-inter" style="font-size: 16px;">
        {{ $description }}
    </p>
    @if(isset($link) && isset($linkText))
        <div class="flex justify-center">
            <a href="{{ $link }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-[#006CC] hover:bg-[#0F2F5] transition-all duration-150 ease-in uppercase" aria-label="{{ $linkText }}">
                {{ $linkText }}
            </a>
        </div>
    @endif
</div>
