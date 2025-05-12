<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImpersonationController;

// Admin impersonation routes (Super-Admin only)
Route::middleware(['auth', 'role:Super-Admin'])
    ->prefix('admin/impersonation')
    ->name('admin.impersonation.')
    ->group(function () {
        Route::get('/sessions', [ImpersonationController::class, 'activeSessions'])
            ->name('sessions');

        Route::post('/end-all', [ImpersonationController::class, 'endAllSessions'])
            ->name('end-all');
    });

// Impersonate a user (must be allowed via policy)
Route::middleware(['auth', 'can:impersonate-users'])->group(function () {
    Route::post('/impersonate/{userId}', [ImpersonationController::class, 'impersonate'])
        ->name('impersonate.start');
});

// Stop impersonating - any authenticated user
Route::middleware(['auth'])->group(function () {
    Route::post('/stop-impersonating', [ImpersonationController::class, 'stopImpersonating'])
        ->name('impersonate.stop');
});