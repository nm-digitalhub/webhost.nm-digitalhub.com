<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h1 class="text-2xl font-semibold mb-4">שירותי אחסון אתרים</h1>
                <p class="mb-6">בחר את חבילת האחסון המושלמת לאתר שלך עם שירות אמין ומהיר.</p>

                <!-- חבילות אחסון -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                    <!-- חבילה בסיסית -->
                    <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        <div class="bg-blue-50 p-4 border-b border-gray-200">
                            <h3 class="text-xl font-bold text-center text-blue-700">חבילה בסיסית</h3>
                            <div class="text-center mt-2">
                                <span class="text-3xl font-bold">₪19.99</span>
                                <span class="text-gray-500 text-sm">/חודש</span>
                            </div>
                        </div>
                        <div class="p-6">
                            <ul class="space-y-3">
                                <li class="flex items-center">
                                    <svg class="h-5 w-5 text-green-500 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>5GB שטח אחסון</span>
                                </li>
                                <li class="flex items-center">
                                    <svg class="h-5 w-5 text-green-500 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>1 אתר</span>
                                </li>
                                <li class="flex items-center">
                                    <svg class="h-5 w-5 text-green-500 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>תעבורה חודשית: 10GB</span>
                                </li>
                                <li class="flex items-center">
                                    <svg class="h-5 w-5 text-green-500 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>10 כתובות אימייל</span>
                                </li>
                            </ul>
                            <button wire:click="selectPlan('basic')" class="mt-6 w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition-colors duration-300">
                                בחר חבילה
                            </button>
                        </div>
                    </div>

                    <!-- חבילה מתקדמת -->
                    <div class="border border-blue-500 rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-300 relative">
                        <div class="absolute top-0 left-0 right-0 bg-blue-600 text-white text-center text-xs font-bold py-1">
                            החבילה המומלצת
                        </div>
                        <div class="bg-blue-100 p-4 border-b border-blue-200 pt-7">
                            <h3 class="text-xl font-bold text-center text-blue-800">חבילה מתקדמת</h3>
                            <div class="text-center mt-2">
                                <span class="text-3xl font-bold">₪39.99</span>
                                <span class="text-gray-500 text-sm">/חודש</span>
                            </div>
                        </div>
                        <div class="p-6">
                            <ul class="space-y-3">
                                <li class="flex items-center">
                                    <svg class="h-5 w-5 text-green-500 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>20GB שטח אחסון</span>
                                </li>
                                <li class="flex items-center">
                                    <svg class="h-5 w-5 text-green-500 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>5 אתרים</span>
                                </li>
                                <li class="flex items-center">
                                    <svg class="h-5 w-5 text-green-500 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>תעבורה חודשית: ללא הגבלה</span>
                                </li>
                                <li class="flex items-center">
                                    <svg class="h-5 w-5 text-green-500 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>30 כתובות אימייל</span>
                                </li>
                                <li class="flex items-center">
                                    <svg class="h-5 w-5 text-green-500 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>SSL חינם</span>
                                </li>
                            </ul>
                            <button wire:click="selectPlan('premium')" class="mt-6 w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition-colors duration-300">
                                בחר חבילה
                            </button>
                        </div>
                    </div>

                    <!-- חבילה עסקית -->
                    <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        <div class="bg-blue-50 p-4 border-b border-gray-200">
                            <h3 class="text-xl font-bold text-center text-blue-700">חבילה עסקית</h3>
                            <div class="text-center mt-2">
                                <span class="text-3xl font-bold">₪89.99</span>
                                <span class="text-gray-500 text-sm">/חודש</span>
                            </div>
                        </div>
                        <div class="p-6">
                            <ul class="space-y-3">
                                <li class="flex items-center">
                                    <svg class="h-5 w-5 text-green-500 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>50GB שטח אחסון</span>
                                </li>
                                <li class="flex items-center">
                                    <svg class="h-5 w-5 text-green-500 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>אתרים ללא הגבלה</span>
                                </li>
                                <li class="flex items-center">
                                    <svg class="h-5 w-5 text-green-500 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>תעבורה חודשית: ללא הגבלה</span>
                                </li>
                                <li class="flex items-center">
                                    <svg class="h-5 w-5 text-green-500 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>אימייל ללא הגבלה</span>
                                </li>
                                <li class="flex items-center">
                                    <svg class="h-5 w-5 text-green-500 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>גיבוי יומי</span>
                                </li>
                            </ul>
                            <button wire:click="selectPlan('business')" class="mt-6 w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition-colors duration-300">
                                בחר חבילה
                            </button>
                        </div>
                    </div>
                </div>

                <!-- מאפיינים נוספים -->
                <div class="mt-16">
                    <h2 class="text-xl font-semibold mb-6">למה לבחור באחסון שלנו?</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="flex flex-col items-center text-center p-4">
                            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium mb-2">מהירות טעינה</h3>
                            <p class="text-gray-600">שרתים מהירים עם SSD וטכנולוגיית קאשינג מתקדמת לביצועים מעולים.</p>
                        </div>
                        <div class="flex flex-col items-center text-center p-4">
                            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium mb-2">אבטחה מתקדמת</h3>
                            <p class="text-gray-600">הגנת DDoS, סריקות אבטחה קבועות וגיבויים אוטומטיים לשמירה על המידע שלך.</p>
                        </div>
                        <div class="flex flex-col items-center text-center p-4">
                            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium mb-2">תמיכה 24/7</h3>
                            <p class="text-gray-600">צוות תמיכה מקצועי זמין 24 שעות ביממה, 7 ימים בשבוע לכל שאלה או בעיה.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
