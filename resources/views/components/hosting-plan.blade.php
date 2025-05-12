<div class="bg-white rounded-lg shadow-lg overflow-hidden transform transition-all duration-200 hover:scale-105">
    @if(isset($featured) && $featured)
        <div class="bg-[#006CC] text-white text-center py-2 font-bold">
            <span>המומלץ ביותר</span>
        </div>
    @endif

    <div class="p-6">
        <h3 class="text-xl font-bold text-[#0D1E3C] mb-2">{{ $title }}</h3>
        <div class="text-3xl font-bold text-[#006CC] mb-4">
            ₪{{ $price }}<span class="text-sm text-gray-500 font-normal">/חודש</span>
        </div>

        <p class="text-[#0F2F5] mb-6">{{ $description }}</p>

        <ul class="mb-8 space-y-2">
            @foreach($features as $feature)
                <li class="flex items-center">
                    <svg class="h-5 w-5 text-[#006CC] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>{{ $feature }}</span>
                </li>
            @endforeach
        </ul>

        <a href="{{ $link ?? '#' }}" class="block w-full py-3 px-4 text-center bg-[#006CC] hover:bg-[#0F2F5] text-white font-medium rounded-md transition-colors">
            {{ $buttonText ?? 'הזמן עכשיו' }}
        </a>
    </div>
</div>
