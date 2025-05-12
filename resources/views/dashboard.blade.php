<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    <div class="mb-6">
                        <h3 class="text-lg font-medium mb-2">{{ __("You're logged in!") }}</h3>
                        <p>ברוך הבא, {{ auth()->user()->name }}</p>
                    </div>
                    
                    <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg">
                        <h3 class="font-medium mb-2">התפקידים שלך:</h3>
                        <div class="flex flex-wrap gap-2 mb-4">
                            @forelse(auth()->user()->roles as $role)
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                                    {{ $role->name }}
                                </span>
                            @empty
                                <span class="text-gray-500">אין תפקידים מוגדרים</span>
                            @endforelse
                        </div>
                    
                        <div class="mt-4">
                            <h3 class="font-medium mb-2">לוח בקרה לפי תפקיד:</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                                @if(auth()->user()->hasRole('admin'))
                                    <a href="{{ route('admin.dashboard') }}" 
                                       class="block p-4 bg-indigo-100 dark:bg-indigo-900 hover:bg-indigo-200 dark:hover:bg-indigo-800 rounded-lg">
                                        <h4 class="text-lg font-medium text-indigo-800 dark:text-indigo-200">לוח בקרה למנהל</h4>
                                        <p class="text-indigo-600 dark:text-indigo-300">ניהול המערכת ומשתמשים</p>
                                    </a>
                                @endif
                    
                                @if(auth()->user()->hasRole('client'))
                                    <a href="{{ route('client.dashboard') }}" 
                                       class="block p-4 bg-green-100 dark:bg-green-900 hover:bg-green-200 dark:hover:bg-green-800 rounded-lg">
                                        <h4 class="text-lg font-medium text-green-800 dark:text-green-200">לוח בקרה ללקוח</h4>
                                        <p class="text-green-600 dark:text-green-300">צפייה בהזמנות ונתונים</p>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
