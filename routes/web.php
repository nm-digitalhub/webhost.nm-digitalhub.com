<?php

use App\Http\Controllers\Client\DomainController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HostingController;
use App\Http\Controllers\ImpersonationController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsClient;
use App\Http\Middleware\SetLocale;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Admin\DomainCard;
use App\Livewire\Admin\Domains as AdminDomains;
use App\Livewire\Admin\DomainsNew;
use App\Livewire\Admin\Hosting as AdminHosting;
use App\Livewire\Admin\Invoices as AdminInvoices;
use App\Livewire\Admin\Orders;
use App\Livewire\Admin\Plans;
use App\Livewire\Admin\Settings as AdminSettings;
use App\Livewire\Admin\Tickets as AdminTickets;
use App\Livewire\Admin\Users;
use App\Livewire\Admin\Vps as AdminVps;
use App\Livewire\Client\Dashboard as ClientDashboard;
use App\Livewire\Client\DomainCheck;
use App\Livewire\Client\Domains;
use App\Livewire\Client\Invoices;
use App\Livewire\Client\Settings;
use App\Livewire\Client\Vps;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

// נתיבים ציבוריים (ללא לוקליזציה)
Route::view('/policy', 'policy')->name('policy');
Route::view('/terms', 'terms')->name('terms');

// Middleware עבור נתיבים מאומתים
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::view('/profile', 'profile.show')->name('profile.show');
    Route::view('/hosting', 'hosting')->name('hosting');
    Route::view('/domains', 'domains')->name('domains');
});

// נתיבי לוקליזציה ודפים ציבוריים
Route::middleware([SetLocale::class])->group(function () {
    Route::get('/lang/{locale}', [LanguageController::class, 'switchLang'])->name('lang.switch');
    Route::get('/', [PageController::class, 'home'])->name('home');
    Route::redirect('/home', '/');

    Route::post('/search', [HomeController::class, 'search'])->middleware('throttle:30,1')->name('search');
    Route::get('/domains', [PageController::class, 'servicePage'])->name('service.domains')->defaults('type', 'domains');
    Route::get('/hosting', [HostingController::class, 'index'])->name('hosting');
    Route::get('/vps', [PageController::class, 'servicePage'])->name('service.vps')->defaults('type', 'vps');
    Route::get('/cloud', [PageController::class, 'servicePage'])->name('service.cloud')->defaults('type', 'cloud');
    Route::post('/contact', [HomeController::class, 'contactSubmit'])->middleware('throttle:5,1')->name('contact.submit');
    Route::get('/domains', [DomainController::class, 'index'])->name('domains');
Route::get('/support/report', function (\Illuminate\Http\Request $request) {
    return view('support.report', [
        'errorCode' => $request->input('error'),
    ]);
})->name('support.report');
    // נתיבים מאומתים
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
        Route::get('/settings', [HomeController::class, 'settings'])->name('settings');
Route::post('/support/submit', function (\Illuminate\Http\Request $request) {
    // כאן תוכל לשמור DB או לשלוח מייל
    Log::error('User reported error ' . $request->error_code . ': ' . $request->message);

    return redirect('/')->with('status', 'Thank you for your report. Our team will review it.');
})->name('support.submit');
        // נתיבי פרופיל
        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/', [HomeController::class, 'profile'])->name('index');
            Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
            Route::patch('/', [ProfileController::class, 'update'])->name('update');
            Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
        });

        // נתיבי מנהל
        Route::middleware([IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
            Route::get('/dashboard', AdminDashboard::class)->name('dashboard');
            Route::get('/users-legacy', Users::class)->name('users.legacy');
            Route::get('/domains', AdminDomains::class)->name('domains');
            Route::get('/domains/new', DomainsNew::class)->name('domains.new');
            Route::get('/hosting', AdminHosting::class)->name('hosting');
            Route::get('/vps', AdminVps::class)->name('vps');
            Route::get('/invoices', AdminInvoices::class)->name('invoices');
            Route::get('/plans', Plans::class)->name('plans');
            Route::get('/orders', Orders::class)->name('orders');
            Route::get('/tickets', AdminTickets::class)->name('tickets');
            Route::get('/settings', AdminSettings::class)->name('settings');
            Route::get('/domain-card', DomainCard::class)->name('domain-card');
        });

        // נתיבי לקוח
        Route::middleware([IsClient::class])->prefix('client')->name('client.')->group(function () {
            Route::get('/dashboard', ClientDashboard::class)->name('dashboard');
            Route::get('/domains', Domains::class)->name('domains');
            Route::get('/check', DomainCheck::class)->name('check');
            Route::get('/vps', Vps::class)->name('vps');
            Route::get('/invoices', Invoices::class)->name('invoices');
            Route::get('/settings', Settings::class)->name('settings');
        });
    });

    // התחזות למשתמש (חייב להיות מותר על ידי מדיניות)
    Route::middleware(['can:impersonate-users'])->group(function () {
        Route::post('/impersonate/{userId}', [ImpersonationController::class, 'impersonate'])
            ->name('impersonate.start');
    });

    // הפסקת התחזות
    Route::post('/stop-impersonating', [ImpersonationController::class, 'stopImpersonating'])
        ->name('impersonate.stop');
});

// Admin routes
Route::middleware(['web', 'auth', 'IsAdmin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', AdminDashboard::class)->name('admin.dashboard');
    Route::get('/users', Users::class)->name('admin.users');
    // ...add more admin Livewire routes as needed...
});

// Client routes
Route::middleware(['web', 'auth', 'IsClient'])->prefix('client')->group(function () {
    Route::get('/dashboard', ClientDashboard::class)->name('client.dashboard');
    // ...add more client Livewire routes as needed...
});

// Home route
Route::get('/', [HomeController::class, 'index'])->name('home');

// נתיב נלכד-הכל
Route::fallback(fn () => response()->view('errors.404', [], 404));
