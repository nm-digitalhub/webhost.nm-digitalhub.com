@impersonating
    <div class="bg-red-600 text-white py-2 px-4 fixed top-0 left-0 right-0 z-50">
        <div class="container mx-auto flex items-center justify-between">
            <div class="flex items-center">
                <svg class="h-5 w-5 text-red-300 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span>
                    אתה מתחזה כרגע למשתמש <strong>{{ auth()->user()->name }}</strong>. 
                    משתמש זה אינו יודע שאתה צופה מחשבונו.
                </span>
            </div>
            <form method="POST" action="{{ route('impersonate.stop') }}">
                @csrf
                <button type="submit" class="bg-white text-red-600 px-3 py-1 rounded text-sm hover:bg-red-100">
                    חזרה לחשבון המנהל
                </button>
            </form>
        </div>
    </div>
    <div class="h-10"></div>
@endimpersonating