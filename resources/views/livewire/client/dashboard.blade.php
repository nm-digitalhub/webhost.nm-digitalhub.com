<div>
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">לוח בקרה ללקוח</h1>
        <p class="mt-1 text-sm text-gray-500">ניהול השירותים, הדומיינים והחשבוניות שלך</p>
    </div>

    <!-- סיכום חשבון -->
    <div class="grid grid-cols-1 gap-5 mt-6 sm:grid-cols-2 lg:grid-cols-4">
        <div class="p-4 transition-shadow rounded-lg shadow-sm bg-white hover:shadow-lg">
            <div class="flex items-start justify-between">
                <div class="flex flex-col space-y-2">
                    <span class="text-gray-400">דומיינים פעילים</span>
                    <span class="text-lg font-semibold">{{ $activeDomains }}</span>
                </div>
                <div class="p-2 rounded-md bg-blue-50 text-blue-500">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                    </svg>
                </div>
            </div>
            <div class="mt-1">
                <a href="{{ route('client.domain.index') }}" class="text-sm text-blue-500 hover:text-blue-600">צפה בכל הדומיינים</a>
            </div>
        </div>

        <div class="p-4 transition-shadow rounded-lg shadow-sm bg-white hover:shadow-lg">
            <div class="flex items-start justify-between">
                <div class="flex flex-col space-y-2">
                    <span class="text-gray-400">חבילות אחסון</span>
                    <span class="text-lg font-semibold">{{ $activeHosting }}</span>
                </div>
                <div class="p-2 rounded-md bg-green-50 text-green-500">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                    </svg>
                </div>
            </div>
            <div class="mt-1">
                <a href="{{ route('client.hosting.index') }}" class="text-sm text-blue-500 hover:text-blue-600">צפה בחבילות אחסון</a>
            </div>
                    </div>
            
                    <div class="p-4 transition-shadow rounded-lg shadow-sm bg-white hover:shadow-lg">
            <div class="flex items-start justify-between">
                <div class="flex flex-col space-y-2">
                    <span class="text-gray-400">שרתים וירטואליים</span>
                    <span class="text-lg font-semibold">{{ $activeVps }}</span>
                </div>
                <div class="p-2 rounded-md bg-purple-50 text-purple-500">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                    </svg>
                </div>
            </div>
            <div class="mt-1">
                <a href="{{ route('client.vps.index') }}" class="text-sm text-blue-500 hover:text-blue-600">הוסף שרת וירטואלי</a>
            </div>
        </div>

        <div class="p-4 transition-shadow rounded-lg shadow-sm bg-white hover:shadow-lg">
            <div class="flex items-start justify-between">
                <div class="flex flex-col space-y-2">
                    <span class="text-gray-400">חשבוניות לתשלום</span>
                    <span class="text-lg font-semibold">{{ $pendingInvoices }}</span>
                </div>
                <div class="p-2 rounded-md bg-red-50 text-red-500">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>
            <div class="mt-1">
                <a href="{{ route('client.invoice.index') }}" class="text-sm text-blue-500 hover:text-blue-600">צפה בחשבוניות</a>
            </div>
        </div>
    </div>

    <!-- פירוט שירותים -->
    <div class="grid grid-cols-1 gap-5 mt-8 lg:grid-cols-2">
        <!-- דומיינים -->
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-900">הדומיינים שלי</h2>
                <a href="{{ route('client.domains') }}" class="text-sm font-medium text-blue-500 hover:text-blue-600">כל הדומיינים</a>
            </div>

            <div class="space-y-3">
                @forelse($domains as $domain)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <h3 class="font-medium">{{ $domain->name }}</h3>
                            <p class="text-xs text-gray-500">מועד חידוש: {{ $domain->renewal_date->format('d/m/Y') }}</p>
                        </div>
                        <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">{{ $domain->status }}</span>
                    </div>
                @empty
                    <div class="text-center p-4 text-gray-500">
                        אין דומיינים להצגה
                    </div>
                @endforelse
            </div>
        </div>

        <!-- חשבוניות אחרונות -->
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-900">חשבוניות אחרונות</h2>
                <a href="{{ route('client.invoices') }}" class="text-sm font-medium text-blue-500 hover:text-blue-600">כל החשבוניות</a>
            </div>

            <div class="space-y-3">
                @forelse($invoices as $invoice)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <h3 class="font-medium">חשבונית #{{ $invoice->number }}</h3>
                            <p class="text-xs text-gray-500">{{ $invoice->date->format('d/m/Y') }} - {{ $invoice->description }}</p>
                        </div>
                        <div class="flex items-center space-x-3 space-x-reverse">
                            <span class="text-sm font-medium">₪{{ number_format($invoice->amount, 2) }}</span>
                            <span class="px-2 py-1 text-xs font-medium {{ $invoice->status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} rounded-full">
                                {{ $invoice->status === 'paid' ? 'שולם' : 'לא שולם' }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="text-center p-4 text-gray-500">
                        אין חשבוניות להצגה
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- פעולות מהירות -->
    <div class="mt-8 bg-white p-6 rounded-lg shadow-sm">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">פעולות מהירות</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('client.domain.check') }}" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                <div class="p-2 rounded-md bg-blue-100 text-blue-500 ml-3">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-medium">בדיקת זמינות דומיין</h3>
                    <p class="text-sm text-gray-500">בדוק אם דומיין פנוי לרישום</p>
                </div>
            </a>
    
            <a href="{{ route('client.hosting.create') }}" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                <div class="p-2 rounded-md bg-green-100 text-green-500 ml-3">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-medium">הזמנת חבילת אחסון</h3>
                    <p class="text-sm text-gray-500">בחר חבילת אחסון חדשה</p>
                </div>
            </a>
    
            <a href="{{ route('client.support.create') }}" class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                <div class="p-2 rounded-md bg-purple-100 text-purple-500 ml-3">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-medium">פתיחת קריאת שירות</h3>
                    <p class="text-sm text-gray-500">צור קשר עם התמיכה הטכנית</p>
                </div>
            </a>
        </div>
    </div>

    <!-- עצות מהירות -->
    <div class="bg-blue-50 p-4 rounded-lg mt-8">
        <div class="flex">
            <div class="shrink-0">
                <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="mr-3">
                <h3 class="text-sm font-medium text-blue-800">טיפ מהיר</h3>
                <div class="mt-1 text-sm text-blue-700">
                    <p>
                        כדאי לוודא שהדומיינים שלך מוגדרים לחידוש אוטומטי כדי למנוע הפרעות בשירות.
                        <a href="{{ route('client.setting.index') }}" class="font-semibold underline">עדכן הגדרות חידוש</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
