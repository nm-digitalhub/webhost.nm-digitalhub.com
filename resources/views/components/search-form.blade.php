<form action="{{ route('search') }}" method="GET" class="flex flex-col sm:flex-row shadow-md">
    <input
        id="domain-search-input"
        type="text"
        name="name"
        placeholder="{{ $placeholder ?? 'חפש את הדומיין שלך...' }}"
        class="flex-1 py-3 px-4 rounded-t-lg sm:rounded-r-lg sm:rounded-tl-none border-0 focus:ring-2 focus:ring-[#006CC] focus:outline-none"
        style="border-radius: 0 12px 12px 0;"
        required
        aria-label="שדה חיפוש דומיין"
    >
    <button
        id="search-domain-button"
        type="submit"
        class="w-full sm:w-auto mt-2 sm:mt-0 px-6 py-3 bg-[#006CC] hover:bg-[#0F2F5] text-white font-bold rounded-b-lg sm:rounded-l-lg sm:rounded-br-none transition-all duration-150 ease-in uppercase"
        style="border-radius: 12px 0 0 12px;"
        aria-label="כפתור חיפוש"
    >
        {{ $buttonText ?? 'חפש' }}
    </button>
</form>
