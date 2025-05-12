<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h1 class="text-2xl font-semibold mb-4">Search</h1>

                <div class="mb-6">
                    <form wire:submit.prevent="search">
                        <div class="flex items-center">
                            <input wire:model="query" type="text" class="flex-1 rounded-l-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" placeholder="Search for domains...">
                            <button type="submit" class="rounded-r-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Search
                            </button>
                        </div>
                    </form>
                </div>

                <div>
                    @if ($query)
                        <p>Search results for: {{ $query }}</p>
                        <!-- Results would appear here -->
                    @else
                        <p>Enter a domain name to search for availability.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
