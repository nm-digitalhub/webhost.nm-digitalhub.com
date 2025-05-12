<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-blue-50 border-b border-gray-200 font-sans">
                    <h1 class="text-2xl font-semibold text-gray-800">פנייה חדשה לתמיכה</h1>
                    <p class="mt-1 text-gray-600">צור פנייה חדשה לצוות התמיכה שלנו</p>
                </div>

                <div class="p-6 bg-white border-b border-gray-200 font-sans">
                    <form wire:submit.prevent="createTicket">
                        <div class="mb-4">
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">נושא</label>
                            <input type="text" id="subject" wire:model="subject" class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400" placeholder="הזן כותרת קצרה לפנייתך">
                            @error('subject') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="priority" class="block text-sm font-medium text-gray-700 mb-1">עדיפות</label>
                            <select id="priority" wire:model="priority" class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                                <option value="low">נמוכה</option>
                                <option value="medium">בינונית</option>
                                <option value="high">גבוהה</option>
                            </select>
                            @error('priority') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">תוכן הפנייה</label>
                            <textarea id="message" wire:model="message" rows="6" class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400" placeholder="תאר את הבעיה או הבקשה שלך בפירוט"></textarea>
                            @error('message') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex justify-between">
                            <a href="{{ route('client.support') }}" class="bg-gray-300 text-gray-800 rounded-md px-4 py-2 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-400">חזרה</a>
                            <button type="submit" class="bg-blue-600 text-white rounded-md px-4 py-2 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400">שלח פנייה</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
