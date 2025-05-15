<?php

declare(strict_types=1);

namespace App\Http\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsClient
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check() || ! auth()->user()->hasRole('client')) {
            return redirect()->route('dashboard')->with('error', 'אזור זה מוגבל ללקוחות בלבד.');
        }

        return $next($request);
    }
}
