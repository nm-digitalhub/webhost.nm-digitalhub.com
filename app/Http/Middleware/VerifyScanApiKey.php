<?php

declare(strict_types=1);

namespace App\Http\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyScanApiKey
{
    public function handle(Request $request, Closure $next)
    {
        $providedKey = $request->header('X-API-KEY');
        $validKey = env('SCAN_API_KEY');

        if (empty($providedKey)) {
            return response()->json(['error' => 'API key missing'], 400);
        }

        if ($providedKey !== $validKey) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
