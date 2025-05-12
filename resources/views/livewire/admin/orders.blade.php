<div class="font-sans">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-blue-50 border-b border-gray-200">
                    <h1 class="text-2xl font-semibold text-gray-800">הזמנות</h1>

                    <div class="mt-6">
                        <div class="flex justify-between items-center mb-4">
                            <div class="relative">
                                <input type="text" placeholder="חיפוש לפי מספר הזמנה או לקוח" class="border rounded-lg py-2 px-4 w-80 pl-10 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <select class="border rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">כל הסטטוסים</option>
                                    <option value="pending">בהמתנה</option>
                                    <option value="processing">בטיפול</option>
                                    <option value="completed">הושלם</option>
                                    <option value="cancelled">בוטל</option>
                                </select>
                            </div>
                        </div>

                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-blue-400 text-blue-900">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider">מספר הזמנה</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider">לקוח</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider">תאריך</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider">סכום</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider">סטטוס</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider">פעולות</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 font-sans">
                                <tr class="hover:bg-blue-100 bg-green-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#10001</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">ישראל ישראלי</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">05/05/2025</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">₪199.00</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">הושלם</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium text-blue-700">
                                        <a href="#" class="hover:text-blue-900">צפייה</a>
                                    </td>
                                </tr>
                                <tr class="hover:bg-blue-100 bg-yellow-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#10002</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">יעקב כהן</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">04/05/2025</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">₪99.00</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">בטיפול</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium text-blue-700">
                                        <a href="#" class="hover:text-blue-900">צפייה</a>
                                    </td>
                                </tr>
                                <tr class="hover:bg-blue-100 bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#10003</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">שרה לוי</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">03/05/2025</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">₪349.00</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">בוטל</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium text-blue-700">
                                        <a href="#" class="hover:text-blue-900">צפייה</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-blue-50 border-b border-gray-200 font-sans">
                    <h1 class="text-2xl font-semibold text-gray-800">הזמנות</h1>
                </div>

                <div class="p-6 bg-white border-b border-gray-200 font-sans">
                    <div class="flex justify-between items-center mb-4">
                        <input type="text" placeholder="חיפוש..." class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                        <select class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                            <option>הכל</option>
                            <option>חדש</option>
                            <option>בעיבוד</option>
                            <option>הושלם</option>
                            <option>בוטל</option>
                        </select>
                        <button class="bg-blue-600 text-white rounded-md px-4 py-2 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400">חפש</button>
                    </div>

                    <table class="min-w-full divide-y divide-gray-200 bg-blue-900 text-blue-100 font-sans">
                        <thead class="bg-blue-400 text-blue-900">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider">מספר הזמנה</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider">לקוח</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider">מוצר</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider">סכום</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider">סטטוס</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider">תאריך</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-blue-50">
                            <tr class="hover:bg-blue-100 bg-green-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">10001</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">ישראל ישראלי</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">חבילת אחסון בסיסית</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">₪99</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-700">הושלם</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">01/06/2024</td>
                            </tr>
                            <tr class="hover:bg-blue-100 bg-yellow-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">10002</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">דוד לוי</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">שרת VPS</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">₪199</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-yellow-700">בעיבוד</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">03/06/2024</td>
                            </tr>
                            <tr class="hover:bg-blue-100 bg-red-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">10003</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">יעקב כהן</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">דומיין חדש</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">₪59</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-red-700">בוטל</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">05/06/2024</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>