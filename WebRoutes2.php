<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\{
    AuthenticatedSessionController,
    BillingController,
    Client\ClientController,
    Client\DomainController,
    Client\SupportController,
    DashboardController,
    GoogleOAuthController,
    HomeController,
    LanguageController,
    PageController,
    ProfileController
};
use App\Http\Middleware\{IsAdmin, IsClient, SetLocale};
use App\Livewire\Admin\{
    Dashboard as AdminDashboard,
    Users,
    Domains as AdminDomains,
    DomainsNew,
    Hosting as AdminHosting,
    Vps as AdminVps,
    Invoices as AdminInvoices,
    Plans,
    Orders,
    Tickets as AdminTickets,
    Settings as AdminSettings
};
use App\Livewire\Client\{
    Dashboard as ClientDashboard,
    Domains,
    DomainCheck,
    Hosting,
    HostingNew,
    Vps,
    Invoices,
    Settings,
    Support,
    SupportNew
};

// Default Home Route
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Middleware for Authenticated Routes
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

// Public Pages
Route::view('/policy', 'policy')->name('policy');
Route::view('/terms', 'terms')->name('terms');

// Localization and Public Pages
Route::middleware([SetLocale::class])->group(function () {
    Route::get('/lang/{locale}', [LanguageController::class, 'switchLang'])->name('lang.switch');
    Route::get('/', [PageController::class, 'home'])->name('home');
    Route::redirect('/home', '/');

    Route::post('/search', [HomeController::class, 'search'])->middleware('throttle:30,1')->name('search');
    Route::get('/domains', [PageController::class, 'servicePage'])->name('service.domains')->defaults('type', 'domains');
    Route::get('/hosting', [PageController::class, 'servicePage'])->name('service.hosting')->defaults('type', 'hosting');
    Route::get('/vps', [PageController::class, 'servicePage'])->name('service.vps')->defaults('type', 'vps');
    Route::get('/cloud', [PageController::class, 'servicePage'])->name('service.cloud')->defaults('type', 'cloud');
    Route::post('/contact', [HomeController::class, 'contactSubmit'])->middleware('throttle:5,1')->name('contact.submit');
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->middleware('throttle:10,1')->name('login');
    Route::get('/terms', [PageController::class, 'terms'])->name('terms');
    Route::get('/policy', [PageController::class, 'policy'])->name('policy');

    Route::prefix('oauth/google')->name('oauth.google.')->middleware('throttle:10,1')->group(function () {
        Route::get('/redirect', [GoogleOAuthController::class, 'redirect'])->name('redirect');
        Route::get('/callback', [GoogleOAuthController::class, 'callback'])->name('callback');
    });

    // Authenticated Routes
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
        Route::get('/settings', [HomeController::class, 'settings'])->name('settings');

        // Profile Routes
        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/', [HomeController::class, 'profile'])->name('index');
            Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
            Route::patch('/', [ProfileController::class, 'update'])->name('update');
            Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
        });

        // Admin Routes
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
        });

        // Client Routes
        Route::middleware([IsClient::class])->prefix('client')->name('client.')->group(function () {
            Route::get('/dashboard', ClientDashboard::class)->name('dashboard');

            // Domain Management
            Route::prefix('domains')->name('domains.')->group(function () {
                Route::get('/', Domains::class)->name('index');
                Route::get('/check', DomainCheck::class)->name('check');
                Route::get('/search', [DomainController::class, 'domainSearch'])->name('search');
                Route::get('/dns-management', [DomainController::class, 'dnsManagement'])->name('dns-management');
            });

            // Hosting Management
            Route::prefix('hosting')->name('hosting.')->group(function () {
                Route::get('/', Hosting::class)->name('index');
                Route::get('/new', HostingNew::class)->name('new');
            });

            Route::get('/vps', Vps::class)->name('vps');
            Route::get('/invoices', Invoices::class)->name('invoices');
            Route::get('/settings', Settings::class)->name('settings');
            Route::get('/profile', [ClientController::class, 'profile'])->name('profile');
            Route::get('/payment-methods', [ClientController::class, 'paymentMethods'])->name('payment-methods');
            Route::get('/statistics', [ClientController::class, 'statistics'])->name('statistics');
            Route::get('/subscriptions', [BillingController::class, 'subscriptions'])->name('subscriptions');

            // Support
            Route::prefix('support')->name('support.')->group(function () {
                Route::get('/', Support::class)->name('index');
                Route::get('/new', SupportNew::class)->name('new');
                Route::get('/tickets', [SupportController::class, 'tickets'])->name('tickets');
                Route::get('/knowledge-base', [SupportController::class, 'knowledgeBase'])->name('knowledge-base');
            });

            Route::post('/toggle-auto-renewal', [ClientController::class, 'toggleAutoRenewal'])->middleware('throttle:10,1')->name('toggle-auto-renewal');
            Route::post('/update-currency', [ClientController::class, 'updateCurrency'])->middleware('throttle:10,1')->name('update-currency');
            Route::get('/pages/{slug}', [ClientController::class, 'showPage'])->name('pages.show');
        });
    });

    require base_path('/routes/auth.php');
    require base_path('/routes/web_impersonation.php');

    // Catch-all Page Routes
    Route::get('/page/{slug}', [PageController::class, 'show'])->where('slug', '[a-z0-9-]+')->name('pages.show');
});

// Catch-all Fallback
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});