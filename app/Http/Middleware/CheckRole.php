<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request and check if user has the required role.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!$request->user() || !$request->user()->hasRole($role)) {
            return redirect()->route('dashboard')->with('error', 'אין לך הרשאה לגשת לעמוד זה.');
        }

        return $next($request);
    }
}