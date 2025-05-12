<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-blue-50 border-b border-gray-200 font-sans">
                    <h1 class="text-2xl font-semibold text-gray-800">הגדרות חשבון</h1>
                    <p class="mt-1 text-gray-600">נהל את הגדרות החשבון שלך</p>
                </div>

                <div class="p-6 bg-white border-b border-gray-200 font-sans">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- תפריט צד -->
                        <div class="col-span-1">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <nav class="space-y-2">
                                    <a href="#profile" class="flex items-center px-3 py-2 text-sm font-medium text-blue-700 bg-blue-100 rounded-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        פרטים אישיים
                                    </a>
                                    <a href="#security" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                        אבטחה וסיסמה
                                    </a>
                                    <a href="#notification" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                        </svg>
                                        התראות
                                    </a>
                                    <a href="#payment" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                        </svg>
                                        אמצעי תשלום
                                    </a>
                                </nav>
                            </div>
                        </div>

                        <!-- תוכן ההגדרות -->
                        <div class="col-span-2">
                            <div id="profile" class="bg-white rounded-lg border border-gray-200 p-6">
                                <h2 class="text-lg font-medium text-gray-900 mb-4">פרטים אישיים</h2>

                                <form>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <label for="firstName" class="block text-sm font-medium text-gray-700 mb-1">שם פרטי</label>
                                            <input type="text" id="firstName" name="firstName" class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400" value="ישראל">
                                        </div>
                                        <div>
                                            <label for="lastName" class="block text-sm font-medium text-gray-700 mb-1">שם משפחה</label>
                                            <input type="text" id="lastName" name="lastName" class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400" value="ישראלי">
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">כתובת דוא"ל</label>
                                        <input type="email" id="email" name="email" class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400" value="israel@example.com">
                                    </div>

                                    <div class="mb-4">
                                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">מספר טלפון</label>
                                        <input type="tel" id="phone" name="phone" class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400" value="050-1234567">
                                    </div>

                                    <div>
                                        <button type="submit" class="bg-blue-600 text-white rounded-md px-4 py-2 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400">שמור שינויים</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
