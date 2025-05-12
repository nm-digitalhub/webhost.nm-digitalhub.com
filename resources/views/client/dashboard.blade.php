@extends('layouts.client')
@extends('layouts.client')

@section('title', 'לוח בקרה ללקוח')

@section('content')
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
                <span class="text-lg font-semibold">{{ $activeDomains ?? 3 }}</span>
            </div>
            <div class="p-2 rounded-md bg-blue-50 text-blue-500">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                </svg>
            </div>
        </div>
        <div class="mt-1">
            <a href="{{ route('client.domains') }}" class="text-sm text-blue-500 hover:text-blue-600">צפה בכל הדומיינים</a>
        </div>
    </div>

    <div class="p-4 transition-shadow rounded-lg shadow-sm bg-white hover:shadow-lg">
        <div class="flex items-start justify-between">
            <div class="flex flex-col space-y-2">
                <span class="text-gray-400">חבילות אחסון</span>
                <span class="text-lg font-semibold">{{ $activeHosting ?? 1 }}</span>
            </div>
            <div class="p-2 rounded-md bg-green-50 text-green-500">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                </svg>
            </div>
        </div>
        <div class="mt-1">
            <a href="{{ route('client.hosting') }}" class="text-sm text-blue-500 hover:text-blue-600">צפה בחבילות אחסון</a>
        </div>
    </div>

    <div class="p-4 transition-shadow rounded-lg shadow-sm bg-white hover:shadow-lg">
        <div class="flex items-start justify-between">
            <div class="flex flex-col space-y-2">
                <span class="text-gray-400">שרתים וירטואליים</span>
                <span class="text-lg font-semibold">{{ $activeVps ?? 0 }}</span>
            </div>
            <div class="p-2 rounded-md bg-purple-50 text-purple-500">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                </svg>
            </div>
        </div>
        <div class="mt-1">
            <a href="{{ route('client.vps') }}" class="text-sm text-blue-500 hover:text-blue-600">הוסף שרת וירטואלי</a>
        </div>
    </div>

    <div class="p-4 transition-shadow rounded-lg shadow-sm bg-white hover:shadow-lg">
        <div class="flex items-start justify-between">
            <div class="flex flex-col space-y-2">
                <span class="text-gray-400">חשבוניות לתשלום</span>
                <span class="text-lg font-semibold">{{ $pendingInvoices ?? 1 }}</span>
            </div>
            <div class="p-2 rounded-md bg-red-50 text-red-500">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
        </div>
        <div class="mt-1">
            <a href="{{ route('client.invoices') }}" class="text-sm text-blue-500 hover:text-blue-600">צפה בחשבוניות</a>
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
            @forelse($domains ?? [] as $domain)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div>
                        <h3 class="font-medium">{{ $domain->name }}</h3>
                        <p class="text-xs text-gray-500">מועד חידוש: {{ $domain->renewal_date->format('d/m/Y') }}</p>
                    </div>
                    <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">{{ $domain->status }}</span>
                </div>
            @empty
                <!-- דוגמה לנתונים קבועים אם אין נתונים אמיתיים -->
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div>
                        <h3 class="font-medium">example.co.il</h3>
                        <p class="text-xs text-gray-500">מועד חידוש: 15/10/2023</p>
                    </div>
                    <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">פעיל</span>
                </div>

                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div>
                        <h3 class="font-medium">mysite.co.il</h3>
                        <p class="text-xs text-gray-500">מועד חידוש: 02/12/2023</p>
                    </div>
                    <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">פעיל</span>
                </div>

                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div>
                        <h3 class="font-medium">mynewdomain.com</h3>
                        <p class="text-xs text-gray-500">מועד חידוש: 25/05/2024</p>
                    </div>
                    <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">פעיל</span>
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
            @forelse($invoices ?? [] as $invoice)
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
                <!-- דוגמה לנתונים קבועים אם אין נתונים אמיתיים -->
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div>
                        <h3 class="font-medium">חשבונית #1234</h3>
                        <p class="text-xs text-gray-500">01/06/2023 - חידוש אחסון</p>
                    </div>
                    <div class="flex items-center space-x-3 space-x-reverse">
                        <span class="text-sm font-medium">₪149.00</span>
                        <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">לא שולם</span>
                    </div>
                </div>

                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div>
                        <h3 class="font-medium">חשבונית #1233</h3>
                        <p class="text-xs text-gray-500">15/05/2023 - חידוש דומיין</p>
                    </div>
                    <div class="flex items-center space-x-3 space-x-reverse">
                        <span class="text-sm font-medium">₪59.00</span>
                        <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">שולם</span>
                    </div>
                </div>

                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div>
                        <h3 class="font-medium">חשבונית #1232</h3>
                        <p class="text-xs text-gray-500">01/05/2023 - חידוש אחסון</p>
                    </div>
                    <div class="flex items-center space-x-3 space-x-reverse">
                        <span class="text-sm font-medium">₪149.00</span>
                        <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">שולם</span>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- פעולות מהירות -->
<div class="mt-8 bg-white p-6 rounded-lg shadow-sm">
    <h2 class="text-xl font-semibold text-gray-900 mb-4">פעולות מהירות</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="{{ route('client.domains.check') }}" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
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

        <a href="{{ route('client.hosting.new') }}" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
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

        <a href="{{ route('client.support.new') }}" class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
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
                    <a href="{{ route('client.settings') }}" class="font-semibold underline">עדכן הגדרות חידוש</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // קוד JavaScript נוסף ספציפי לדף הלקוח
    document.addEventListener('DOMContentLoaded', function() {
        console.log('דשבורד לקוח נטען');

        // לוגיקת JavaScript נוספת יכולה להיות כאן
    });
</script>
@endpush
@section('title', 'לוח בקרה ללקוח')

@section('content')
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
                <span class="text-lg font-semibold">3</span>
            </div>
            <div class="p-2 rounded-md bg-blue-50 text-blue-500">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                </svg>
            </div>
        </div>
        <div class="mt-1">
            <a href="{{ route('client.domains') }}" class="text-sm text-blue-500 hover:text-blue-600">צפה בכל הדומיינים</a>
        </div>
    </div>

    <div class="p-4 transition-shadow rounded-lg shadow-sm bg-white hover:shadow-lg">
        <div class="flex items-start justify-between">
            <div class="flex flex-col space-y-2">
                <span class="text-gray-400">חבילות אחסון</span>
                <span class="text-lg font-semibold">1</span>
            </div>
            <div class="p-2 rounded-md bg-green-50 text-green-500">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                </svg>
            </div>
        </div>
        <div class="mt-1">
            <a href="{{ route('client.hosting') }}" class="text-sm text-blue-500 hover:text-blue-600">צפה בחבילות אחסון</a>
        </div>
    </div>

    <div class="p-4 transition-shadow rounded-lg shadow-sm bg-white hover:shadow-lg">
        <div class="flex items-start justify-between">
            <div class="flex flex-col space-y-2">
                <span class="text-gray-400">שרתים וירטואליים</span>
                <span class="text-lg font-semibold">0</span>
            </div>
            <div class="p-2 rounded-md bg-purple-50 text-purple-500">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                </svg>
            </div>
        </div>
        <div class="mt-1">
            <a href="{{ route('client.vps') }}" class="text-sm text-blue-500 hover:text-blue-600">הוסף שרת וירטואלי</a>
        </div>
    </div>

    <div class="p-4 transition-shadow rounded-lg shadow-sm bg-white hover:shadow-lg">
        <div class="flex items-start justify-between">
            <div class="flex flex-col space-y-2">
                <span class="text-gray-400">חשבוניות לתשלום</span>
                <span class="text-lg font-semibold">1</span>
            </div>
            <div class="p-2 rounded-md bg-red-50 text-red-500">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
        </div>
        <div class="mt-1">
            <a href="{{ route('client.invoices') }}" class="text-sm text-blue-500 hover:text-blue-600">צפה בחשבוניות</a>
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
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <div>
                    <h3 class="font-medium">example.co.il</h3>
                    <p class="text-xs text-gray-500">מועד חידוש: 15/10/2023</p>
                </div>
                <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">פעיל</span>
            </div>

            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <div>
                    <h3 class="font-medium">mysite.co.il</h3>
                    <p class="text-xs text-gray-500">מועד חידוש: 02/12/2023</p>
                </div>
                <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">פעיל</span>
            </div>

            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <div>
                    <h3 class="font-medium">mynewdomain.com</h3>
                    <p class="text-xs text-gray-500">מועד חידוש: 25/05/2024</p>
                </div>
                <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">פעיל</span>
            </div>
        </div>
    </div>

    <!-- חשבוניות אחרונות -->
    <div class="bg-white p-6 rounded-lg shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-gray-900">חשבוניות אחרונות</h2>
            <a href="{{ route('client.invoices') }}" class="text-sm font-medium text-blue-500 hover:text-blue-600">כל החשבוניות</a>
        </div>

        <div class="space-y-3">
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <div>
                    <h3 class="font-medium">חשבונית #1234</h3>
                    <p class="text-xs text-gray-500">01/06/2023 - חידוש אחסון</p>
                </div>
                <div class="flex items-center space-x-3 space-x-reverse">
                    <span class="text-sm font-medium">₪149.00</span>
                    <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">לא שולם</span>
                </div>
            </div>

            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <div>
                    <h3 class="font-medium">חשבונית #1233</h3>
                    <p class="text-xs text-gray-500">15/05/2023 - חידוש דומיין</p>
                </div>
                <div class="flex items-center space-x-3 space-x-reverse">
                    <span class="text-sm font-medium">₪59.00</span>
                    <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">שולם</span>
                </div>
            </div>

            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <div>
                    <h3 class="font-medium">חשבונית #1232</h3>
                    <p class="text-xs text-gray-500">01/05/2023 - חידוש אחסון</p>
                </div>
                <div class="flex items-center space-x-3 space-x-reverse">
                    <span class="text-sm font-medium">₪149.00</span>
                    <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">שולם</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- פעולות מהירות -->
<div class="mt-8 bg-white p-6 rounded-lg shadow-sm">
    <h2 class="text-xl font-semibold text-gray-900 mb-4">פעולות מהירות</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="{{ route('client.domains.check') }}" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
            <div class="p-2 rounded-md bg-blue-100 text-blue-500 mr-3">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <div>
                <h3 class="font-medium">בדיקת זמינות דומיין</h3>
                <p class="text-sm text-gray-500">בדוק אם דומיין פנוי לרישום</p>
            </div>
        </a>

        <a href="{{ route('client.hosting.new') }}" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
            <div class="p-2 rounded-md bg-green-100 text-green-500 mr-3">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
            </div>
            <div>
                <h3 class="font-medium">הזמנת חבילת אחסון</h3>
                <p class="text-sm text-gray-500">בחר חבילת אחסון חדשה</p>
            </div>
        </a>

        <a href="{{ route('client.support.new') }}" class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
            <div class="p-2 rounded-md bg-purple-100 text-purple-500 mr-3">
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
                    <a href="{{ route('client.settings') }}" class="font-semibold underline">עדכן הגדרות חידוש</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // קוד JavaScript נוסף ספציפי לדף הלקוח, אם נדרש
</script>
@endpush

<!-- Service Overview -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                </svg>
            </div>
            <div class="mr-3">
                <p class="text-sm font-medium text-gray-500">הדומיינים שלי</p>
                <p class="text-lg font-semibold text-gray-900">{{ $domains ?? 2 }}</p>
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('client.domains') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500">נהל דומיינים &rarr;</a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                </svg>
            </div>
            <div class="mr-3">
                <p class="text-sm font-medium text-gray-500">אחסון אתרים</p>
                <p class="text-lg font-semibold text-gray-900">{{ $hosting ?? 1 }}</p>
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('client.hosting') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500">נהל אחסון &rarr;</a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
            <div class="mr-3">
                <p class="text-sm font-medium text-gray-500">חשבוניות</p>
                <p class="text-lg font-semibold text-gray-900">{{ $invoices ?? 3 }}</p>
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('client.invoices') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500">צפה בחשבוניות &rarr;</a>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-lg shadow mb-8">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-medium text-gray-900">פעולות מהירות</h2>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('domains') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                רישום דומיין חדש
            </a>
            <a href="{{ route('hosting') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                הוסף אחסון אתרים
            </a>
            <a href="{{ route('profile.show') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700">
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                עדכן פרטים אישיים
            </a>
        </div>
    </div>
</div>

<!-- My Services -->
<div class="bg-white rounded-lg shadow mb-8">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-medium text-gray-900">השירותים שלי</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">שם שירות</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">סוג</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">סטטוס</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">תאריך חידוש</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">פעולות</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">example-domain.com</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">דומיין</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">פעיל</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        15/12/2024
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="#" class="text-indigo-600 hover:text-indigo-900 ml-2">נהל</a>
                        <a href="#" class="text-green-600 hover:text-green-900 ml-2">חדש</a>
                    </td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">Basic Hosting</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">אחסון אתרים</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">פעיל</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        23/07/2024
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="#" class="text-indigo-600 hover:text-indigo-900 ml-2">נהל</a>
                        <a href="#" class="text-yellow-600 hover:text-yellow-900">שדרג</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-gray-200">
        <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-500">צפה בכל השירותים &rarr;</a>
    </div>
</div>

<!-- Recent Invoices -->
<div class="bg-white rounded-lg shadow">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-medium text-gray-900">חשבוניות אחרונות</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">מס' חשבונית</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">תאריך</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">סכום</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">סטטוס</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">פעולות</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">#INV-001</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">01/06/2023</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">₪99.00</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">שולם</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="#" class="text-indigo-600 hover:text-indigo-900">צפה</a>
                    </td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">#INV-002</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">15/05/2023</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">₪179.00</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">שולם</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="#" class="text-indigo-600 hover:text-indigo-900">צפה</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-gray-200">
        <a href="{{ route('client.invoices') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500">צפה בכל החשבוניות &rarr;</a>
    </div>
</div>
@endsection
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">לוח בקרה ללקוח</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-white dark:bg-gray-700 p-4 rounded-lg shadow">
                            <h4 class="font-medium text-lg mb-2">ההזמנות שלי</h4>
                            <p class="text-gray-500 dark:text-gray-400 mb-4">צפייה בהזמנות הקודמות והנוכחיות</p>
                            <a href="#" class="text-indigo-600 dark:text-indigo-400 hover:underline">צפייה בהזמנות</a>
                        </div>

                        <div class="bg-white dark:bg-gray-700 p-4 rounded-lg shadow">
                            <h4 class="font-medium text-lg mb-2">פרטי חשבון</h4>
                            <p class="text-gray-500 dark:text-gray-400 mb-4">ניהול פרטי החשבון שלך</p>
                            <a href="{{ route('profile.edit') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">עריכת פרטים</a>
                        </div>

                        <div class="bg-white dark:bg-gray-700 p-4 rounded-lg shadow">
                            <h4 class="font-medium text-lg mb-2">תמיכה</h4>
                            <p class="text-gray-500 dark:text-gray-400 mb-4">יצירת קשר עם התמיכה</p>
                            <a href="#" class="text-indigo-600 dark:text-indigo-400 hover:underline">פתיחת פניה</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@section('title', 'Client Dashboard')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-semibold text-gray-900">My Dashboard</h1>
    <p class="mt-1 text-sm text-gray-500">Overview of your services and account.</p>
</div>

<!-- Stats Overview -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-500">Active Domains</p>
                <p class="text-lg font-semibold text-gray-900">{{ $stats['activeDomains'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-500">Hosting Plans</p>
                <p class="text-lg font-semibold text-gray-900">{{ $stats['activeHostingPlans'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-500">VPS Servers</p>
                <p class="text-lg font-semibold text-gray-900">{{ $stats['activeVpsServers'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-500">Pending Invoices</p>
                <p class="text-lg font-semibold text-gray-900">{{ $stats['pendingInvoices'] }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Quick Action Buttons -->
<div class="flex flex-wrap gap-4 mb-8">
    <a href="{{ route('client.domains') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        Register New Domain
    </a>
    <a href="{{ route('client.invoices') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
        </svg>
        View Invoices
    </a>
    <a href="{{ route('client.payment-methods') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
        </svg>
        Manage Payment Methods
    </a>
</div>

<!-- Services Overview -->
<div class="bg-white rounded-lg shadow mb-8">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-lg font-medium text-gray-900">My Services</h2>
        <div class="flex space-x-2">
            <button type="button" class="filter-btn inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-gray-700 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 active" data-filter="all">
                All
            </button>
            <button type="button" class="filter-btn inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-gray-700 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500" data-filter="domain">
                Domains
            </button>
            <button type="button" class="filter-btn inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-gray-700 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500" data-filter="hosting">
                Hosting
            </button>
            <button type="button" class="filter-btn inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-gray-700 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500" data-filter="vps">
                VPS
            </button>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expires</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Auto Renewal</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($services as $service)
                <tr class="service-row" data-type="{{ $service['type'] }}">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            @if($service['type'] === 'domain')
                            <div class="flex-shrink-0 h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                </svg>
                            </div>
                            @elseif($service['type'] === 'hosting')
                            <div class="flex-shrink-0 h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                                <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2"></path>
                                </svg>
                            </div>
                            @elseif($service['type'] === 'vps')
                            <div class="flex-shrink-0 h-8 w-8 rounded-full bg-purple-100 flex items-center justify-center">
                                <svg class="h-5 w-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                                </svg>
                            </div>
                            @endif
                            <div class="ml-3">
