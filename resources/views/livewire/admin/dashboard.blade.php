
<div class="font-sans">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">לוח ניהול מנהל המערכת</h1>
        <p class="mt-1 text-sm text-gray-500">סטטיסטיקה, נתונים ופעילות אחרונה במערכת</p>
    </div>

    <!-- סיכום סטטיסטיקה -->
    <div class="grid grid-cols-1 gap-5 mt-6 sm:grid-cols-2 lg:grid-cols-5">

            <div class="p-4 transition-shadow rounded-lg shadow-sm bg-white hover:shadow-lg">
            <div class="flex items-start justify-between">
                <div class="flex flex-col space-y-2">
                    <span class="text-gray-400">דומיינים פעילים</span>
                    <span class="text-lg font-semibold">{{ $stats['activeDomains'] }}</span>
                </div>
                <div class="p-2 rounded-md bg-blue-50 text-blue-500">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                    </svg>
                </div>
            </div>
            <div class="mt-1">
                <a href="{{ route('admin.domains') }}" class="text-sm text-blue-500 hover:text-blue-600">צפה בכל הדומיינים</a>
            </div>
        </div>

        <div class="p-4 transition-shadow rounded-lg shadow-sm bg-white hover:shadow-lg">
            <div class="flex items-start justify-between">
                <div class="flex flex-col space-y-2">
                    <span class="text-gray-400">חבילות אחסון</span>
                    <span class="text-lg font-semibold">{{ $stats['activeHostingPlans'] }}</span>
                </div>
                <div class="p-2 rounded-md bg-green-50 text-green-500">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                    </svg>
                </div>
            </div>
            <div class="mt-1">
                <a href="{{ route('admin.hosting') }}" class="text-sm text-blue-500 hover:text-blue-600">צפה בחבילות אחסון</a>
            </div>
        </div>

        <div class="p-4 transition-shadow rounded-lg shadow-sm bg-white hover:shadow-lg">
            <div class="flex items-start justify-between">
                <div class="flex flex-col space-y-2">
                    <span class="text-gray-400">שרתים וירטואליים</span>
                    <span class="text-lg font-semibold">{{ $stats['activeVpsServers'] }}</span>
                </div>
                <div class="p-2 rounded-md bg-purple-50 text-purple-500">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                    </svg>
                </div>
            </div>
            <div class="mt-1">
                <a href="{{ route('admin.vps') }}" class="text-sm text-blue-500 hover:text-blue-600">ניהול שרתים</a>
            </div>
        </div>

        <div class="p-4 transition-shadow rounded-lg shadow-sm bg-white hover:shadow-lg">
            <div class="flex items-start justify-between">
                <div class="flex flex-col space-y-2">
                    <span class="text-gray-400">הכנסה כוללת</span>
                    <span class="text-lg font-semibold">${{ number_format($stats['totalRevenue'], 2) }}</span>
                </div>
                <div class="p-2 rounded-md bg-green-50 text-green-600">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-1">
                <a href="{{ route('admin.invoices') }}" class="text-sm text-blue-500 hover:text-blue-600">דוחות כספיים</a>
            </div>
        </div>

        <div class="p-4 transition-shadow rounded-lg shadow-sm bg-white hover:shadow-lg">
            <div class="flex items-start justify-between">
                <div class="flex flex-col space-y-2">
                    <span class="text-gray-400">חשבוניות ממתינות</span>
                    <span class="text-lg font-semibold">{{ $stats['pendingInvoices'] }}</span>
                </div>
                <div class="p-2 rounded-md bg-red-50 text-red-500">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>
            <div class="mt-1">
                <a href="{{ route('admin.invoices') }}?status=pending" class="text-sm text-blue-500 hover:text-blue-600">צפה בחשבוניות</a>
            </div>
        </div>
    </div>

    <!-- פעולות מהירות -->
    <div class="grid grid-cols-1 gap-5 mt-8 lg:grid-cols-3">
        <div class="col-span-2">
            <div class="bg-white p-6 rounded-lg shadow-sm mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold text-gray-900">פעולות מהירות</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <a href="{{ route('admin.domains.new') }}" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                        <div class="p-2 rounded-md bg-blue-100 text-blue-500 ml-3">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-medium">הוספת דומיין</h3>
                            <p class="text-sm text-gray-500">רישום דומיין חדש</p>
                        </div>
                    </a>

                    <a href="{{ route('admin.users.new') }}" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                        <div class="p-2 rounded-md bg-green-100 text-green-500 ml-3">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-medium">הוספת לקוח</h3>
                            <p class="text-sm text-gray-500">יצירת לקוח חדש</p>
                        </div>
                    </a>

                    <a href="{{ route('admin.invoices.new') }}" class="flex items-center p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors">
                        <div class="p-2 rounded-md bg-yellow-100 text-yellow-500 ml-3">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-medium">יצירת חשבונית</h3>
                            <p class="text-sm text-gray-500">הוספת חשבונית חדשה</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-span-1">
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-6 rounded-lg shadow-sm text-white">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-semibold mb-2">סיכום מערכת</h2>
                    <svg class="h-8 w-8 text-white opacity-75" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <div class="mt-4 space-y-3">
                    <div class="flex justify-between">
                        <span class="text-blue-100">סה״כ לקוחות</span>
                        <span class="font-semibold">{{ $stats['totalCustomers'] ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-blue-100">הזמנות חדשות</span>
                        <span class="font-semibold">{{ $stats['newOrders'] ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-blue-100">פניות תמיכה פתוחות</span>
                        <span class="font-semibold">{{ $stats['openTickets'] ?? 0 }}</span>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-blue-400">
                    <a href="{{ route('admin.reports') }}" class="text-sm text-white hover:text-blue-100 flex justify-between items-center">
                        <span>צפה בדוחות מפורטים</span>
                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- פעילות אחרונה -->
    <div class="mt-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-gray-900">פעילות אחרונה במערכת</h2>
                <a href="#" class="px-3 py-1 text-sm text-blue-600 bg-blue-100 rounded-md hover:bg-blue-200">ייצוא לקובץ</a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">סוג</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">פרטים</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">משתמש</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">סכום</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">תאריך</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">פעולות</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($recentActivities as $activity)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ str_contains($activity['type'], 'domain') ? 'bg-blue-100 text-blue-800' :
                                           (str_contains($activity['type'], 'hosting') ? 'bg-green-100 text-green-800' :
                                           (str_contains($activity['type'], 'vps') ? 'bg-purple-100 text-purple-800' :
                                           (str_contains($activity['type'], 'invoice') ? 'bg-yellow-100 text-yellow-800' :
                                           'bg-gray-100 text-gray-800'))) }}">
                                        {{ __('activity.'.$activity['type']) }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">
                                    @if(isset($activity['domain']))
                                        <span class="block">דומיין: <span class="font-medium">{{ $activity['domain'] }}</span></span>
                                    @endif
                                    @if(isset($activity['plan']))
                                        <span class="block">חבילה: <span class="font-medium">{{ $activity['plan'] }}</span></span>
                                    @endif
                                    @if(isset($activity['invoice']))
                                        <span class="block">חשבונית: <span class="font-medium">{{ $activity['invoice'] }}</span></span>
                                    @endif
                                    @if(isset($activity['from']))
                                        <span class="block">שדרוג: <span class="font-medium">{{ $activity['from'] }}</span> ל-<span class="font-medium">{{ $activity['to'] }}</span></span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-800">
                                    {{ $activity['user'] }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    ${{ number_format($activity['amount'], 2) }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($activity['date'])->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="flex space-x-2 space-x-reverse">
                                        <button class="text-blue-600 hover:text-blue-900">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
