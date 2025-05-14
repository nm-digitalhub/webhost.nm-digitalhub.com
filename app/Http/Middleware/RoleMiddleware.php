<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  mixed  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // אם המשתמש לא מחובר, החזר לדף ההתחברות
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        // אם לא הועבר תפקיד, המשך כרגיל
        if ($roles === []) {
            return $next($request);
        }

        // בדוק אם למשתמש יש אחד מהתפקידים שהועברו
        if (auth()->user()->hasAnyRole($roles)) {
            return $next($request);
        }

        // אם אין למשתמש הרשאה, החזר שגיאה
        return redirect()->route('dashboard')
            ->with('error', 'אין לך הרשאה לגשת לעמוד זה.');
    }
}
