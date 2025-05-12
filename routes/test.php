<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\ClientController;

/*
|--------------------------------------------------------------------------
| Test Routes
|--------------------------------------------------------------------------
|
| These routes are for testing purposes only and should not be included
| in the production environment. They can be included in local development
| by uncommenting the require statement in web.php.
|
*/

// Module installer test routes
Route::middleware(['auth', 'client'])
    ->prefix('client')
    ->name('client.')
    ->group(function () {
        Route::get('/modules', [ClientController::class, 'showModules'])
            ->name('modules');

        // Add other test routes here
    });
