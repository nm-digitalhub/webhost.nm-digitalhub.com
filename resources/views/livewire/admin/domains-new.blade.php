<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-blue-50 border-b border-gray-200 font-sans">
                    <h1 class="text-2xl font-semibold text-gray-800">הוספת דומיין חדש</h1>
                    <p class="mt-1 text-gray-600">הוסף דומיין חדש למערכת</p>
                </div>

                <div class="p-6 bg-white border-b border-gray-200 font-sans">
                    <form wire:submit.prevent="submit">
                        <div class="mb-4">
                            <label for="domain_name" class="block text-sm font-medium text-gray-700 mb-1">שם הדומיין</label>
                            <input type="text" id="domain_name" wire:model="name" class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400" placeholder="לדוגמה: example.com">
                            <p class="mt-1 text-sm text-gray-500">הזן את שם הדומיין ללא www</p>
                            @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="domain_type" class="block text-sm font-medium text-gray-700 mb-1">סוג הדומיין</label>
                            <select id="domain_type" wire:model="domain_type" class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                                <option value="new">רישום דומיין חדש</option>
                                <option value="transfer">העברת דומיין קיים</option>
                                <option value="external">הוספת דומיין חיצוני</option>
                            </select>
                            @error('domain_type') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="client" class="block text-sm font-medium text-gray-700 mb-1">שייך ללקוח</label>
                            <select id="client" wire:model="client_id" class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                                <option value="">בחר לקוח...</option>
                                @foreach($clients ?? [] as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }} ({{ $client->email }})</option>
                                @endforeach
                            </select>
                            @error('client_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="period" class="block text-sm font-medium text-gray-700 mb-1">תקופת רישום</label>
                            <select id="period" wire:model="period" class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                                <option value="1">שנה אחת</option>
                                <option value="2">שנתיים</option>
                                <option value="3">3 שנים</option>
                                <option value="5">5 שנים</option>
                                <option value="10">10 שנים</option>
                            </select>
                            @error('period') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="nameservers" class="block text-sm font-medium text-gray-700 mb-1">שרתי שמות (Nameservers)</label>
                            <div class="space-y-2">
                                <input type="text" id="nameserver1" wire:model="nameserver1" class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400" placeholder="ns1.example.com" value="ns1.webhost.nm-digitalhub.com">
                                <input type="text" id="nameserver2" wire:model="nameserver2" class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400" placeholder="ns2.example.com" value="ns2.webhost.nm-digitalhub.com">
                            </div>
                            @error('nameserver1') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            @error('nameserver2') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex justify-between">
                            <a href="{{ route('admin.domains') }}" class="bg-gray-300 text-gray-800 rounded-md px-4 py-2 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-400">ביטול</a>
                            <button type="submit" class="bg-blue-600 text-white rounded-md px-4 py-2 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400">הוסף דומיין</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
