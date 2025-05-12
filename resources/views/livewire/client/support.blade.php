<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-blue-50 border-b border-gray-200 font-sans">
                    <h1 class="text-2xl font-semibold text-gray-800">פניות תמיכה</h1>
                    <p class="mt-1 text-gray-600">צפה בכל פניות התמיכה שלך</p>
                </div>

                <div class="p-6 bg-white border-b border-gray-200 font-sans">
                    <div class="flex justify-between items-center mb-4">
                        <a href="{{ route('client.support-new') }}" class="bg-blue-600 text-white rounded-md px-4 py-2 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400">פנייה חדשה</a>
                        <div class="flex space-x-2 space-x-reverse">
                            <select class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                                <option>הכל</option>
                                <option>פתוח</option>
                                <option>בטיפול</option>
                                <option>סגור</option>
                            </select>
                            <input type="text" placeholder="חיפוש..." class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                        </div>
                    </div>

                    <table class="min-w-full divide-y divide-gray-200 bg-blue-900 text-blue-100 font-sans">
                        <thead class="bg-blue-400 text-blue-900">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider">מספר פניה</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider">נושא</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider">עדיפות</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider">סטטוס</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider">תאריך</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider">פעולות</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-blue-50">
                            <tr class="hover:bg-blue-100 bg-green-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">12345</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">בעיה בהתחברות</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-orange-600">בינונית</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-700">פתוח</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">01/06/2024</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    <button class="text-blue-600 hover:text-blue-800">צפה</button>
                                </td>
                            </tr>
                            <tr class="hover:bg-blue-100 bg-yellow-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">12346</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">שדרוג שירות</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">נמוכה</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-yellow-700">בטיפול</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">02/06/2024</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    <button class="text-blue-600 hover:text-blue-800">צפה</button>
                                </td>
                            </tr>
                            <tr class="hover:bg-blue-100 bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">12347</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">בקשת החזר</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600">גבוהה</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-700">סגור</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">03/06/2024</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    <button class="text-blue-600 hover:text-blue-800">צפה</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
