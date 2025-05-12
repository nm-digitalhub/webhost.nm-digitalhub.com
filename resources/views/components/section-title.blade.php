<div class="md:col-span-1 flex justify-between">
    <div class="px-4 sm:px-0">
        <h3 class="text-lg font-medium text-gray-900">{{ $title }}</h3>
<div class="text-center mb-12">
    <h2 class="text-3xl font-bold text-[#0D1E3C] mb-2 font-inter" style="font-size: 32px;">
        {{ $title }}
    </h2>
    @if(isset($subtitle))
        <p class="mt-2 max-w-md mx-auto text-base text-[#0F2F5] font-inter" style="font-size: 18px;">
            {{ $subtitle }}
        </p>
    @endif
</div>
        <p class="mt-1 text-sm text-gray-600">
            {{ $description }}
        </p>
    </div>

    <div class="px-4 sm:px-0">
        {{ $aside ?? '' }}
    </div>
</div>
