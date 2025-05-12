# NM-DigitalHUB UI Interface Map

Generated on: 2025-05-06 14:55:19

## Routes

### Public Routes

| URI | Methods | Name | Controller | Middleware |
|-----|---------|------|------------|------------|
| _debugbar/open | GET, HEAD | debugbar.openhandler | OpenHandlerController@handle | Barryvdh\Debugbar\Middleware\DebugbarEnabled |
| _debugbar/clockwork/{id} | GET, HEAD | debugbar.clockwork | OpenHandlerController@clockwork | Barryvdh\Debugbar\Middleware\DebugbarEnabled |
| _debugbar/assets/stylesheets | GET, HEAD | debugbar.assets.css | AssetController@css | Barryvdh\Debugbar\Middleware\DebugbarEnabled |
| _debugbar/assets/javascript | GET, HEAD | debugbar.assets.js | AssetController@js | Barryvdh\Debugbar\Middleware\DebugbarEnabled |
| _debugbar/cache/{key}/{tags?} | DELETE | debugbar.cache.delete | CacheController@delete | Barryvdh\Debugbar\Middleware\DebugbarEnabled |
| _debugbar/queries/explain | POST | debugbar.queries.explain | QueriesController@explain | Barryvdh\Debugbar\Middleware\DebugbarEnabled |
| login | GET, HEAD | login | AuthenticatedSessionController@create | web, guest |
| login | POST |  | AuthenticatedSessionController@store | web, guest |
| logout | POST | logout | AuthenticatedSessionController@destroy | web, auth |
| forgot-password | GET, HEAD | password.request | PasswordResetLinkController@create | web, guest |
| reset-password/{token} | GET, HEAD | password.reset | NewPasswordController@create | web, guest |
| forgot-password | POST | password.email | PasswordResetLinkController@store | web, guest |
| reset-password | POST | password.store | NewPasswordController@store | web, guest |
| register | GET, HEAD | register | RegisteredUserController@create | web, guest |
| register | POST |  | RegisteredUserController@store | web, guest |
| user/profile-information | PUT | user-profile-information.update | ProfileInformationController@update | web, auth:web |
| user/password | PUT | user-password.update | PasswordController@update | web, auth:web |
| user/confirm-password | GET, HEAD | password.confirm | ConfirmablePasswordController@show | web, auth:web |
| user/confirmed-password-status | GET, HEAD | password.confirmation | ConfirmedPasswordStatusController@show | web, auth:web |
| user/confirm-password | POST | password.confirm.store | ConfirmablePasswordController@store | web, auth:web |
| two-factor-challenge | GET, HEAD | two-factor.login | TwoFactorAuthenticatedSessionController@create | web, guest:web |
| two-factor-challenge | POST | two-factor.login.store | TwoFactorAuthenticatedSessionController@store | web, guest:web, throttle:two-factor |
| user/two-factor-authentication | POST | two-factor.enable | TwoFactorAuthenticationController@store | web, auth:web, password.confirm |
| user/confirmed-two-factor-authentication | POST | two-factor.confirm | ConfirmedTwoFactorAuthenticationController@store | web, auth:web, password.confirm |
| user/two-factor-authentication | DELETE | two-factor.disable | TwoFactorAuthenticationController@destroy | web, auth:web, password.confirm |
| user/two-factor-qr-code | GET, HEAD | two-factor.qr-code | TwoFactorQrCodeController@show | web, auth:web, password.confirm |
| user/two-factor-secret-key | GET, HEAD | two-factor.secret-key | TwoFactorSecretKeyController@show | web, auth:web, password.confirm |
| user/two-factor-recovery-codes | GET, HEAD | two-factor.recovery-codes | RecoveryCodeController@index | web, auth:web, password.confirm |
| user/two-factor-recovery-codes | POST |  | RecoveryCodeController@store | web, auth:web, password.confirm |
| user/profile | GET, HEAD | profile.show | UserProfileController@show | web, auth:sanctum, Laravel\Jetstream\Http\Middleware\AuthenticateSession |
| sanctum/csrf-cookie | GET, HEAD | sanctum.csrf-cookie | CsrfCookieController@show | web |
| livewire/update | POST | livewire.update | HandleRequests@handleUpdate | web |
| livewire/livewire.js | GET, HEAD |  | FrontendAssets@returnJavaScriptAsFile |  |
| livewire/livewire.min.js.map | GET, HEAD |  | FrontendAssets@maps |  |
| livewire/upload-file | POST | livewire.upload-file | FileUploadController@handle |  |
| livewire/preview-file/{filename} | GET, HEAD | livewire.preview-file | FilePreviewController@handle |  |
| api/scan-code | GET, HEAD |  | CodeScanController@scan | api, App\Http\Middleware\VerifyScanApiKey |
| api/scan-files | GET, HEAD |  | FileScanController@scanFiles | api |
| lang/{locale} | GET, HEAD | lang.switch | LanguageController@switchLang | web, App\Http\Middleware\SetLocale |
| / | GET, HEAD | home | HomeController@index | web, App\Http\Middleware\SetLocale |
| home | GET, HEAD, POST, PUT, PATCH, DELETE, OPTIONS |  | N/A | web, App\Http\Middleware\SetLocale |
| search | POST | search | HomeController@search | web, App\Http\Middleware\SetLocale |
| domains | GET, HEAD | domains | HomeController@domains | web, App\Http\Middleware\SetLocale |
| hosting | GET, HEAD | hosting | HomeController@hosting | web, App\Http\Middleware\SetLocale |
| vps | GET, HEAD | vps | HomeController@vps | web, App\Http\Middleware\SetLocale |
| cloud | GET, HEAD | cloud | HomeController@cloud | web, App\Http\Middleware\SetLocale |
| contact | POST | contact.submit | HomeController@contactSubmit | web, App\Http\Middleware\SetLocale |
| terms | GET, HEAD | terms | HomeController@terms | web, App\Http\Middleware\SetLocale |
| policy | GET, HEAD | policy | HomeController@policy | web, App\Http\Middleware\SetLocale |
| dashboard | GET, HEAD | dashboard | HomeController@dashboard | web, App\Http\Middleware\SetLocale, auth, verified |
| profile | GET, HEAD | profile | HomeController@profile | web, App\Http\Middleware\SetLocale, auth, verified |
| settings | GET, HEAD | settings | HomeController@settings | web, App\Http\Middleware\SetLocale, auth, verified |
| profile/edit | GET, HEAD | profile.edit | ProfileController@edit | web, App\Http\Middleware\SetLocale, auth |
| profile | PATCH | profile.update | ProfileController@update | web, App\Http\Middleware\SetLocale, auth |
| profile | DELETE | profile.destroy | ProfileController@destroy | web, App\Http\Middleware\SetLocale, auth |
| client/dashboard | GET, HEAD | client.dashboard | N/A | web, App\Http\Middleware\SetLocale, auth, App\Http\Middleware\IsClient |
| client/domains | GET, HEAD | client.domains | N/A | web, App\Http\Middleware\SetLocale, auth, App\Http\Middleware\IsClient |
| client/domains/check | GET, HEAD | client.domains.check | N/A | web, App\Http\Middleware\SetLocale, auth, App\Http\Middleware\IsClient |
| client/hosting | GET, HEAD | client.hosting | N/A | web, App\Http\Middleware\SetLocale, auth, App\Http\Middleware\IsClient |
| client/hosting/new | GET, HEAD | client.hosting.new | N/A | web, App\Http\Middleware\SetLocale, auth, App\Http\Middleware\IsClient |
| client/vps | GET, HEAD | client.vps | N/A | web, App\Http\Middleware\SetLocale, auth, App\Http\Middleware\IsClient |
| client/invoices | GET, HEAD | client.invoices | N/A | web, App\Http\Middleware\SetLocale, auth, App\Http\Middleware\IsClient |
| client/settings | GET, HEAD | client.settings | N/A | web, App\Http\Middleware\SetLocale, auth, App\Http\Middleware\IsClient |
| client/support | GET, HEAD | client.support | N/A | web, App\Http\Middleware\SetLocale, auth, App\Http\Middleware\IsClient |
| client/support/new | GET, HEAD | client.support.new | N/A | web, App\Http\Middleware\SetLocale, auth, App\Http\Middleware\IsClient |
| verify-email | GET, HEAD | verification.notice | N/A | web, auth |
| verify-email/{id}/{hash} | GET, HEAD | verification.verify | N/A | web, auth, signed, throttle:6,1 |
| email/verification-notification | POST | verification.send | EmailVerificationNotificationController@store | web, auth, throttle:6,1 |
| confirm-password | GET, HEAD | user.password.confirm | ConfirmablePasswordController@show | web, auth |
| confirm-password | POST |  | ConfirmablePasswordController@store | web, auth |
| password | PUT | password.update | PasswordController@update | web, auth |

### Admin Routes

| URI | Methods | Name | Controller | Middleware |
|-----|---------|------|------------|------------|
| filament/exports/{export}/download | GET, HEAD | filament.exports.download | N/A | filament.actions |
| filament/imports/{import}/failed-rows/download | GET, HEAD | filament.imports.failed-rows.download | N/A | filament.actions |
| admin/logout | POST | filament.admin.auth.logout | N/A | panel:admin, Illuminate\Cookie\Middleware\EncryptCookies, Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse, Illuminate\Session\Middleware\StartSession, Filament\Http\Middleware\AuthenticateSession, Illuminate\View\Middleware\ShareErrorsFromSession, Illuminate\Foundation\Http\Middleware\VerifyCsrfToken, Illuminate\Routing\Middleware\SubstituteBindings, Filament\Http\Middleware\DisableBladeIconComponents, Filament\Http\Middleware\DispatchServingFilamentEvent, Filament\Http\Middleware\Authenticate |
| admin | GET, HEAD | filament.admin.pages.dashboard | N/A | panel:admin, Illuminate\Cookie\Middleware\EncryptCookies, Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse, Illuminate\Session\Middleware\StartSession, Filament\Http\Middleware\AuthenticateSession, Illuminate\View\Middleware\ShareErrorsFromSession, Illuminate\Foundation\Http\Middleware\VerifyCsrfToken, Illuminate\Routing\Middleware\SubstituteBindings, Filament\Http\Middleware\DisableBladeIconComponents, Filament\Http\Middleware\DispatchServingFilamentEvent, Filament\Http\Middleware\Authenticate |
| admin/users | GET, HEAD | filament.admin.resources.users.index | N/A | panel:admin, Illuminate\Cookie\Middleware\EncryptCookies, Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse, Illuminate\Session\Middleware\StartSession, Filament\Http\Middleware\AuthenticateSession, Illuminate\View\Middleware\ShareErrorsFromSession, Illuminate\Foundation\Http\Middleware\VerifyCsrfToken, Illuminate\Routing\Middleware\SubstituteBindings, Filament\Http\Middleware\DisableBladeIconComponents, Filament\Http\Middleware\DispatchServingFilamentEvent, Filament\Http\Middleware\Authenticate |
| admin/users/create | GET, HEAD | filament.admin.resources.users.create | N/A | panel:admin, Illuminate\Cookie\Middleware\EncryptCookies, Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse, Illuminate\Session\Middleware\StartSession, Filament\Http\Middleware\AuthenticateSession, Illuminate\View\Middleware\ShareErrorsFromSession, Illuminate\Foundation\Http\Middleware\VerifyCsrfToken, Illuminate\Routing\Middleware\SubstituteBindings, Filament\Http\Middleware\DisableBladeIconComponents, Filament\Http\Middleware\DispatchServingFilamentEvent, Filament\Http\Middleware\Authenticate |
| admin/users/{record}/edit | GET, HEAD | filament.admin.resources.users.edit | N/A | panel:admin, Illuminate\Cookie\Middleware\EncryptCookies, Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse, Illuminate\Session\Middleware\StartSession, Filament\Http\Middleware\AuthenticateSession, Illuminate\View\Middleware\ShareErrorsFromSession, Illuminate\Foundation\Http\Middleware\VerifyCsrfToken, Illuminate\Routing\Middleware\SubstituteBindings, Filament\Http\Middleware\DisableBladeIconComponents, Filament\Http\Middleware\DispatchServingFilamentEvent, Filament\Http\Middleware\Authenticate |
| admin/roles | GET, HEAD | filament.admin.resources.roles.index | N/A | panel:admin, Illuminate\Cookie\Middleware\EncryptCookies, Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse, Illuminate\Session\Middleware\StartSession, Filament\Http\Middleware\AuthenticateSession, Illuminate\View\Middleware\ShareErrorsFromSession, Illuminate\Foundation\Http\Middleware\VerifyCsrfToken, Illuminate\Routing\Middleware\SubstituteBindings, Filament\Http\Middleware\DisableBladeIconComponents, Filament\Http\Middleware\DispatchServingFilamentEvent, Filament\Http\Middleware\Authenticate |
| admin/roles/create | GET, HEAD | filament.admin.resources.roles.create | N/A | panel:admin, Illuminate\Cookie\Middleware\EncryptCookies, Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse, Illuminate\Session\Middleware\StartSession, Filament\Http\Middleware\AuthenticateSession, Illuminate\View\Middleware\ShareErrorsFromSession, Illuminate\Foundation\Http\Middleware\VerifyCsrfToken, Illuminate\Routing\Middleware\SubstituteBindings, Filament\Http\Middleware\DisableBladeIconComponents, Filament\Http\Middleware\DispatchServingFilamentEvent, Filament\Http\Middleware\Authenticate |
| admin/roles/{record}/edit | GET, HEAD | filament.admin.resources.roles.edit | N/A | panel:admin, Illuminate\Cookie\Middleware\EncryptCookies, Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse, Illuminate\Session\Middleware\StartSession, Filament\Http\Middleware\AuthenticateSession, Illuminate\View\Middleware\ShareErrorsFromSession, Illuminate\Foundation\Http\Middleware\VerifyCsrfToken, Illuminate\Routing\Middleware\SubstituteBindings, Filament\Http\Middleware\DisableBladeIconComponents, Filament\Http\Middleware\DispatchServingFilamentEvent, Filament\Http\Middleware\Authenticate |
| admin/generators | GET, HEAD | filament.admin.resources.generators.index | N/A | panel:admin, Illuminate\Cookie\Middleware\EncryptCookies, Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse, Illuminate\Session\Middleware\StartSession, Filament\Http\Middleware\AuthenticateSession, Illuminate\View\Middleware\ShareErrorsFromSession, Illuminate\Foundation\Http\Middleware\VerifyCsrfToken, Illuminate\Routing\Middleware\SubstituteBindings, Filament\Http\Middleware\DisableBladeIconComponents, Filament\Http\Middleware\DispatchServingFilamentEvent, Filament\Http\Middleware\Authenticate |
| admin/generators/create | GET, HEAD | filament.admin.resources.generators.create | N/A | panel:admin, Illuminate\Cookie\Middleware\EncryptCookies, Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse, Illuminate\Session\Middleware\StartSession, Filament\Http\Middleware\AuthenticateSession, Illuminate\View\Middleware\ShareErrorsFromSession, Illuminate\Foundation\Http\Middleware\VerifyCsrfToken, Illuminate\Routing\Middleware\SubstituteBindings, Filament\Http\Middleware\DisableBladeIconComponents, Filament\Http\Middleware\DispatchServingFilamentEvent, Filament\Http\Middleware\Authenticate |
| admin/generators/{record}/edit | GET, HEAD | filament.admin.resources.generators.edit | N/A | panel:admin, Illuminate\Cookie\Middleware\EncryptCookies, Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse, Illuminate\Session\Middleware\StartSession, Filament\Http\Middleware\AuthenticateSession, Illuminate\View\Middleware\ShareErrorsFromSession, Illuminate\Foundation\Http\Middleware\VerifyCsrfToken, Illuminate\Routing\Middleware\SubstituteBindings, Filament\Http\Middleware\DisableBladeIconComponents, Filament\Http\Middleware\DispatchServingFilamentEvent, Filament\Http\Middleware\Authenticate |
| admin/generators/{record}/generate | GET, HEAD | filament.admin.resources.generators.generate | N/A | panel:admin, Illuminate\Cookie\Middleware\EncryptCookies, Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse, Illuminate\Session\Middleware\StartSession, Filament\Http\Middleware\AuthenticateSession, Illuminate\View\Middleware\ShareErrorsFromSession, Illuminate\Foundation\Http\Middleware\VerifyCsrfToken, Illuminate\Routing\Middleware\SubstituteBindings, Filament\Http\Middleware\DisableBladeIconComponents, Filament\Http\Middleware\DispatchServingFilamentEvent, Filament\Http\Middleware\Authenticate |
| admin/generation-logs | GET, HEAD | filament.admin.resources.generation-logs.index | N/A | panel:admin, Illuminate\Cookie\Middleware\EncryptCookies, Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse, Illuminate\Session\Middleware\StartSession, Filament\Http\Middleware\AuthenticateSession, Illuminate\View\Middleware\ShareErrorsFromSession, Illuminate\Foundation\Http\Middleware\VerifyCsrfToken, Illuminate\Routing\Middleware\SubstituteBindings, Filament\Http\Middleware\DisableBladeIconComponents, Filament\Http\Middleware\DispatchServingFilamentEvent, Filament\Http\Middleware\Authenticate |
| admin/generation-logs/create | GET, HEAD | filament.admin.resources.generation-logs.create | N/A | panel:admin, Illuminate\Cookie\Middleware\EncryptCookies, Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse, Illuminate\Session\Middleware\StartSession, Filament\Http\Middleware\AuthenticateSession, Illuminate\View\Middleware\ShareErrorsFromSession, Illuminate\Foundation\Http\Middleware\VerifyCsrfToken, Illuminate\Routing\Middleware\SubstituteBindings, Filament\Http\Middleware\DisableBladeIconComponents, Filament\Http\Middleware\DispatchServingFilamentEvent, Filament\Http\Middleware\Authenticate |
| admin/generation-logs/{record}/edit | GET, HEAD | filament.admin.resources.generation-logs.edit | N/A | panel:admin, Illuminate\Cookie\Middleware\EncryptCookies, Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse, Illuminate\Session\Middleware\StartSession, Filament\Http\Middleware\AuthenticateSession, Illuminate\View\Middleware\ShareErrorsFromSession, Illuminate\Foundation\Http\Middleware\VerifyCsrfToken, Illuminate\Routing\Middleware\SubstituteBindings, Filament\Http\Middleware\DisableBladeIconComponents, Filament\Http\Middleware\DispatchServingFilamentEvent, Filament\Http\Middleware\Authenticate |
| admin/products | GET, HEAD | filament.admin.resources.products.index | N/A | panel:admin, Illuminate\Cookie\Middleware\EncryptCookies, Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse, Illuminate\Session\Middleware\StartSession, Filament\Http\Middleware\AuthenticateSession, Illuminate\View\Middleware\ShareErrorsFromSession, Illuminate\Foundation\Http\Middleware\VerifyCsrfToken, Illuminate\Routing\Middleware\SubstituteBindings, Filament\Http\Middleware\DisableBladeIconComponents, Filament\Http\Middleware\DispatchServingFilamentEvent, Filament\Http\Middleware\Authenticate |
| admin/products/create | GET, HEAD | filament.admin.resources.products.create | N/A | panel:admin, Illuminate\Cookie\Middleware\EncryptCookies, Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse, Illuminate\Session\Middleware\StartSession, Filament\Http\Middleware\AuthenticateSession, Illuminate\View\Middleware\ShareErrorsFromSession, Illuminate\Foundation\Http\Middleware\VerifyCsrfToken, Illuminate\Routing\Middleware\SubstituteBindings, Filament\Http\Middleware\DisableBladeIconComponents, Filament\Http\Middleware\DispatchServingFilamentEvent, Filament\Http\Middleware\Authenticate |
| admin/products/{record}/edit | GET, HEAD | filament.admin.resources.products.edit | N/A | panel:admin, Illuminate\Cookie\Middleware\EncryptCookies, Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse, Illuminate\Session\Middleware\StartSession, Filament\Http\Middleware\AuthenticateSession, Illuminate\View\Middleware\ShareErrorsFromSession, Illuminate\Foundation\Http\Middleware\VerifyCsrfToken, Illuminate\Routing\Middleware\SubstituteBindings, Filament\Http\Middleware\DisableBladeIconComponents, Filament\Http\Middleware\DispatchServingFilamentEvent, Filament\Http\Middleware\Authenticate |
| admin/dashboard | GET, HEAD | admin.dashboard | N/A | web, App\Http\Middleware\SetLocale, auth, App\Http\Middleware\IsAdmin |
| admin/users-legacy | GET, HEAD | admin.admin.users.legacy | N/A | web, App\Http\Middleware\SetLocale, auth, App\Http\Middleware\IsAdmin |
| admin/domains | GET, HEAD | admin.domains | N/A | web, App\Http\Middleware\SetLocale, auth, App\Http\Middleware\IsAdmin |
| admin/hosting | GET, HEAD | admin.hosting | N/A | web, App\Http\Middleware\SetLocale, auth, App\Http\Middleware\IsAdmin |
| admin/vps | GET, HEAD | admin.vps | N/A | web, App\Http\Middleware\SetLocale, auth, App\Http\Middleware\IsAdmin |
| admin/invoices | GET, HEAD | admin.invoices | N/A | web, App\Http\Middleware\SetLocale, auth, App\Http\Middleware\IsAdmin |
| admin/plans | GET, HEAD | admin.plans | N/A | web, App\Http\Middleware\SetLocale, auth, App\Http\Middleware\IsAdmin |
| admin/orders | GET, HEAD | admin.orders | N/A | web, App\Http\Middleware\SetLocale, auth, App\Http\Middleware\IsAdmin |
| admin/tickets | GET, HEAD | admin.tickets | N/A | web, App\Http\Middleware\SetLocale, auth, App\Http\Middleware\IsAdmin |
| admin/settings | GET, HEAD | admin.settings | N/A | web, App\Http\Middleware\SetLocale, auth, App\Http\Middleware\IsAdmin |

## Views

| View Name | Path | Title | Extends | Components |
|-----------|------|-------|---------|------------|
| Domains.php | Domains.php | N/A | N/A |  |
| Hosting.php | Hosting.php | N/A | N/A |  |
| Search.php | Search.php | N/A | N/A |  |
| Vps.php | Vps.php | N/A | N/A |  |
| admin.dashboard | admin/dashboard.blade.php | N/A | layouts.admin-layout |  |
| api.api-token-manager | api/api-token-manager.blade.php | N/A | N/A | form-section, slot, slot, slot, label, input, input-error, label, checkbox, slot, action-message, button, section-border, action-section, slot, slot, slot, dialog-modal, slot, slot, input, slot, secondary-button, dialog-modal, slot, slot, checkbox, slot, secondary-button, button, confirmation-modal, slot, slot, slot, secondary-button, danger-button |
| api.index | api/index.blade.php | N/A | N/A | app-layout, slot |
| auth.confirm-password | auth/confirm-password.blade.php | N/A | N/A | guest-layout, input-label, text-input, input-error, primary-button |
| auth.forgot-password | auth/forgot-password.blade.php | N/A | N/A | guest-layout, auth-session-status, input-label, text-input, input-error, primary-button |
| auth.login | auth/login.blade.php | N/A | N/A | guest-layout, auth-session-status, input-label, text-input, input-error, input-label, text-input, input-error, primary-button |
| auth.register | auth/register.blade.php | N/A | N/A | guest-layout, logo-with-text, input-label, text-input, input-error, input-label, text-input, input-error, input-label, text-input, input-error, input-label, text-input, input-error, primary-button |
| auth.reset-password | auth/reset-password.blade.php | N/A | N/A | guest-layout, input-label, text-input, input-error, input-label, text-input, input-error, input-label, text-input, input-error, primary-button |
| auth.verify-email | auth/verify-email.blade.php | N/A | N/A | guest-layout, primary-button |
| client.dashboard | client/dashboard.blade.php | לוח בקרה ללקוח | layouts.client |  |
| coming-soon | coming-soon.blade.php | {{ ucfirst($page) }} - NM-DigitalHUB | N/A |  |
| components.action-message | components/action-message.blade.php | N/A | N/A |  |
| components.action-section | components/action-section.blade.php | N/A | N/A | section-title, slot, slot |
| components.application-logo | components/application-logo.blade.php | N/A | N/A |  |
| components.auth-session-status | components/auth-session-status.blade.php | N/A | N/A |  |
| components.authentication-card-logo | components/authentication-card-logo.blade.php | N/A | N/A |  |
| components.authentication-card | components/authentication-card.blade.php | N/A | N/A |  |
| components.banner | components/banner.blade.php | N/A | N/A |  |
| components.button | components/button.blade.php | N/A | N/A |  |
| components.checkbox | components/checkbox.blade.php | N/A | N/A |  |
| components.confirmation-modal | components/confirmation-modal.blade.php | N/A | N/A | modal |
| components.confirms-password | components/confirms-password.blade.php | N/A | N/A | dialog-modal, slot, slot, input, input-error, slot, secondary-button, button |
| components.danger-button | components/danger-button.blade.php | N/A | N/A |  |
| components.dialog-modal | components/dialog-modal.blade.php | N/A | N/A | modal |
| components.dropdown-link | components/dropdown-link.blade.php | N/A | N/A |  |
| components.dropdown | components/dropdown.blade.php | N/A | N/A |  |
| components.feature-card | components/feature-card.blade.php | N/A | N/A |  |
| components.form-section | components/form-section.blade.php | N/A | N/A | section-title, slot, slot |
| components.guest-layout | components/guest-layout.blade.php | {{ isset($title) ? $title : config('app.name', 'NM-DigitalHUB') }} | N/A |  |
| components.hosting-plan | components/hosting-plan.blade.php | N/A | N/A |  |
| components.input-error | components/input-error.blade.php | N/A | N/A |  |
| components.input-label | components/input-label.blade.php | N/A | N/A |  |
| components.input | components/input.blade.php | N/A | N/A |  |
| components.label | components/label.blade.php | N/A | N/A |  |
| components.logo-with-text | components/logo-with-text.blade.php | N/A | N/A | logo |
| components.logo | components/logo.blade.php | N/A | N/A |  |
| components.modal | components/modal.blade.php | N/A | N/A |  |
| components.nav-link | components/nav-link.blade.php | N/A | N/A |  |
| components.navbar | components/navbar.blade.php | N/A | N/A | logo-with-text |
| components.primary-button | components/primary-button.blade.php | N/A | N/A |  |
| components.responsive-nav-link | components/responsive-nav-link.blade.php | N/A | N/A |  |
| components.search-form | components/search-form.blade.php | N/A | N/A |  |
| components.secondary-button | components/secondary-button.blade.php | N/A | N/A |  |
| components.section-border | components/section-border.blade.php | N/A | N/A |  |
| components.section-title | components/section-title.blade.php | N/A | N/A |  |
| components.switchable-team | components/switchable-team.blade.php | N/A | N/A | dynamic-component |
| components.text-input | components/text-input.blade.php | N/A | N/A |  |
| components.validation-errors | components/validation-errors.blade.php | N/A | N/A |  |
| components.welcome | components/welcome.blade.php | N/A | N/A | application-logo |
| dashboard | dashboard.blade.php | N/A | N/A | app-layout, slot |
| domains | domains.blade.php | N/A | layouts.app |  |
| emails.team-invitation | emails/team-invitation.blade.php | N/A | N/A | mail::message, mail::button', ['url' => route('register |
| filament.resources.generator-resource.pages.generate-code | filament/resources/generator-resource/pages/generate-code.blade.php | N/A | N/A | filament-panels, filament, filament, filament, filament, filament, filament, filament |
| home | home.blade.php | {{ __('home.close') }} | layouts.app |  |
| hosting | hosting.blade.php | N/A | layouts.app |  |
| lang.he.activity.php | lang/he/activity.php | N/A | N/A |  |
| layouts.admin | layouts/admin.blade.php | {{ config('app.name', 'NM-DigitalHUB') }} - Admin Panel - @yield('title', 'Dashboard') | N/A |  |
| layouts.app | layouts/app.blade.php | {{ config('app.name', 'NM-DigitalHUB') }} | N/A |  |
| layouts.client-layout | layouts/client-layout.blade.php | {{ config('app.name', 'NM-DigitalHUB') }} - @yield('title', 'לוח בקרה') | N/A |  |
| layouts.client | layouts/client.blade.php | {{ config('app.name', 'NM-DigitalHUB') }} - @yield('title', 'Client Portal') | N/A |  |
| layouts.guest | layouts/guest.blade.php | {{ config('app.name', 'NM DigitalHUB') }} | N/A |  |
| layouts.navigation | layouts/navigation.blade.php | N/A | N/A |  |
| livewire.admin.dashboard | livewire/admin/dashboard.blade.php | N/A | N/A |  |
| livewire.admin.domain-card | livewire/admin/domain-card.blade.php | N/A | N/A |  |
| livewire.admin.domains-new | livewire/admin/domains-new.blade.php | N/A | N/A |  |
| livewire.admin.layout | livewire/admin/layout.blade.php | N/A | N/A |  |
| livewire.admin.orders | livewire/admin/orders.blade.php | N/A | N/A |  |
| livewire.admin.plans | livewire/admin/plans.blade.php | N/A | N/A |  |
| livewire.admin.tickets | livewire/admin/tickets.blade.php | N/A | N/A |  |
| livewire.auth.confirm-password | livewire/auth/confirm-password.blade.php | N/A | N/A |  |
| livewire.auth.forgot-password | livewire/auth/forgot-password.blade.php | N/A | N/A |  |
| livewire.auth.register | livewire/auth/register.blade.php | N/A | N/A |  |
| livewire.auth.reset-password | livewire/auth/reset-password.blade.php | N/A | N/A |  |
| livewire.auth.verify-email | livewire/auth/verify-email.blade.php | N/A | N/A |  |
| livewire.client.dashboard | livewire/client/dashboard.blade.php | N/A | N/A |  |
| livewire.domains | livewire/domains.blade.php | N/A | N/A |  |
| livewire.hosting | livewire/hosting.blade.php | N/A | N/A |  |
| livewire.search | livewire/search.blade.php | N/A | N/A |  |
| navigation-menu | navigation-menu.blade.php | N/A | N/A | nav-link, dropdown, slot, slot, dropdown-link, dropdown-link, switchable-team, dropdown, slot, slot, dropdown-link, dropdown-link, dropdown-link, responsive-nav-link, responsive-nav-link, responsive-nav-link, responsive-nav-link, responsive-nav-link, responsive-nav-link, switchable-team |
| policy | policy.blade.php | N/A | N/A | guest-layout, authentication-card-logo |
| profile.edit | profile/edit.blade.php | N/A | N/A | app-layout, slot |
| profile.partials.delete-user-form | profile/partials/delete-user-form.blade.php | N/A | N/A | danger-button, modal, input-label, text-input, input-error, secondary-button, danger-button |
| profile.partials.update-password-form | profile/partials/update-password-form.blade.php | N/A | N/A | input-label, text-input, input-error, input-label, text-input, input-error, input-label, text-input, input-error, primary-button |
| profile.partials.update-profile-information-form | profile/partials/update-profile-information-form.blade.php | N/A | N/A | input-label, text-input, input-error, input-label, text-input, input-error, primary-button |
| terms | terms.blade.php | N/A | N/A | guest-layout, authentication-card-logo |
| vendor.filament-panels.components.avatar.tenant | vendor/filament-panels/components/avatar/tenant.blade.php | N/A | N/A | filament |
| vendor.filament-panels.components.avatar.user | vendor/filament-panels/components/avatar/user.blade.php | N/A | N/A | filament |
| vendor.filament-panels.components.form.actions | vendor/filament-panels/components/form/actions.blade.php | N/A | N/A | filament |
| vendor.filament-panels.components.form.index | vendor/filament-panels/components/form/index.blade.php | N/A | N/A |  |
| vendor.filament-panels.components.global-search.actions | vendor/filament-panels/components/global-search/actions.blade.php | N/A | N/A |  |
| vendor.filament-panels.components.global-search.field | vendor/filament-panels/components/global-search/field.blade.php | N/A | N/A | filament, filament |
| vendor.filament-panels.components.global-search.index | vendor/filament-panels/components/global-search/index.blade.php | N/A | N/A | filament-panels, filament-panels |
| vendor.filament-panels.components.global-search.no-results-message | vendor/filament-panels/components/global-search/no-results-message.blade.php | N/A | N/A |  |
| vendor.filament-panels.components.global-search.result-group | vendor/filament-panels/components/global-search/result-group.blade.php | N/A | N/A | filament-panels |
| vendor.filament-panels.components.global-search.result | vendor/filament-panels/components/global-search/result.blade.php | N/A | N/A | filament-panels |
| vendor.filament-panels.components.global-search.results-container | vendor/filament-panels/components/global-search/results-container.blade.php | N/A | N/A | filament-panels, filament-panels |
| vendor.filament-panels.components.header.index | vendor/filament-panels/components/header/index.blade.php | N/A | N/A | filament, filament |
| vendor.filament-panels.components.header.simple | vendor/filament-panels/components/header/simple.blade.php | N/A | N/A | filament-panels |
| vendor.filament-panels.components.layout.base | vendor/filament-panels/components/layout/base.blade.php | {{ filled($title) ? "{$title} - " : null }} {{ $brandName }} | N/A |  |
| vendor.filament-panels.components.layout.index | vendor/filament-panels/components/layout/index.blade.php | N/A | N/A | filament-panels, filament-panels, filament-panels |
| vendor.filament-panels.components.layout.simple | vendor/filament-panels/components/layout/simple.blade.php | N/A | N/A | filament-panels, filament-panels |
| vendor.filament-panels.components.layouts.app | vendor/filament-panels/components/layouts/app.blade.php | N/A | N/A | filament-panels, filament-panels |
| vendor.filament-panels.components.logo | vendor/filament-panels/components/logo.blade.php | N/A | N/A |  |
| vendor.filament-panels.components.page.index | vendor/filament-panels/components/page/index.blade.php | N/A | N/A | filament-panels, slot, slot, filament-panels, filament-panels, filament-panels, filament-widgets, filament-widgets, filament-panels, filament-actions, filament-panels |
| vendor.filament-panels.components.page.simple | vendor/filament-panels/components/page/simple.blade.php | N/A | N/A | filament-panels, filament-actions |
| vendor.filament-panels.components.page.sub-navigation.select | vendor/filament-panels/components/page/sub-navigation/select.blade.php | N/A | N/A | filament, filament |
| vendor.filament-panels.components.page.sub-navigation.sidebar | vendor/filament-panels/components/page/sub-navigation/sidebar.blade.php | N/A | N/A | filament-panels |
| vendor.filament-panels.components.page.sub-navigation.tabs | vendor/filament-panels/components/page/sub-navigation/tabs.blade.php | N/A | N/A | filament, filament, slot, filament, filament, filament, slot, filament, slot |
| vendor.filament-panels.components.page.unsaved-data-changes-alert | vendor/filament-panels/components/page/unsaved-data-changes-alert.blade.php | N/A | N/A |  |
| vendor.filament-panels.components.resources.relation-managers | vendor/filament-panels/components/resources/relation-managers.blade.php | N/A | N/A | filament, filament |
| vendor.filament-panels.components.resources.tabs | vendor/filament-panels/components/resources/tabs.blade.php | N/A | N/A | filament, filament |
| vendor.filament-panels.components.sidebar.group | vendor/filament-panels/components/sidebar/group.blade.php | N/A | N/A | filament, filament, filament, slot, filament, filament, filament, filament, filament-panels, slot, slot |
| vendor.filament-panels.components.sidebar.index | vendor/filament-panels/components/sidebar/index.blade.php | N/A | N/A | filament, filament, filament-panels, filament-panels |
| vendor.filament-panels.components.sidebar.item | vendor/filament-panels/components/sidebar/item.blade.php | N/A | N/A | filament, filament, filament-panels |
| vendor.filament-panels.components.tenant-menu | vendor/filament-panels/components/tenant-menu.blade.php | N/A | N/A | filament, slot, filament-panels, filament, filament, filament, filament, filament, filament, filament, filament, filament, filament |
| vendor.filament-panels.components.theme-switcher.button | vendor/filament-panels/components/theme-switcher/button.blade.php | N/A | N/A | filament |
| vendor.filament-panels.components.theme-switcher.index | vendor/filament-panels/components/theme-switcher/index.blade.php | N/A | N/A | filament-panels, filament-panels, filament-panels |
| vendor.filament-panels.components.topbar.database-notifications-trigger | vendor/filament-panels/components/topbar/database-notifications-trigger.blade.php | N/A | N/A | filament |
| vendor.filament-panels.components.topbar.index | vendor/filament-panels/components/topbar/index.blade.php | N/A | N/A | filament, filament, filament-panels, filament-panels |
| vendor.filament-panels.components.topbar.item | vendor/filament-panels/components/topbar/item.blade.php | N/A | N/A | filament, filament, filament |
| vendor.filament-panels.components.unsaved-action-changes-alert | vendor/filament-panels/components/unsaved-action-changes-alert.blade.php | N/A | N/A |  |
| vendor.filament-panels.components.user-menu | vendor/filament-panels/components/user-menu.blade.php | N/A | N/A | filament, slot, filament-panels, filament, filament-panels, filament, filament, filament, filament-panels, filament, filament, filament, filament |
| vendor.filament-panels.pages.auth.edit-profile | vendor/filament-panels/pages/auth/edit-profile.blade.php | N/A | N/A | dynamic-component, filament-panels, filament-panels |
| vendor.filament-panels.pages.auth.email-verification.email-verification-prompt | vendor/filament-panels/pages/auth/email-verification/email-verification-prompt.blade.php | N/A | N/A | filament-panels |
| vendor.filament-panels.pages.auth.login | vendor/filament-panels/pages/auth/login.blade.php | N/A | N/A | filament-panels, slot, filament-panels, filament-panels |
| vendor.filament-panels.pages.auth.password-reset.request-password-reset | vendor/filament-panels/pages/auth/password-reset/request-password-reset.blade.php | N/A | N/A | filament-panels, slot, filament-panels, filament-panels |
| vendor.filament-panels.pages.auth.password-reset.reset-password | vendor/filament-panels/pages/auth/password-reset/reset-password.blade.php | N/A | N/A | filament-panels, filament-panels, filament-panels |
| vendor.filament-panels.pages.auth.register | vendor/filament-panels/pages/auth/register.blade.php | N/A | N/A | filament-panels, slot, filament-panels, filament-panels |
| vendor.filament-panels.pages.dashboard | vendor/filament-panels/pages/dashboard.blade.php | N/A | N/A | filament-panels, filament-widgets |
| vendor.filament-panels.pages.tenancy.edit-tenant-profile | vendor/filament-panels/pages/tenancy/edit-tenant-profile.blade.php | N/A | N/A | filament-panels, filament-panels, filament-panels |
| vendor.filament-panels.pages.tenancy.register-tenant | vendor/filament-panels/pages/tenancy/register-tenant.blade.php | N/A | N/A | filament-panels, filament-panels, filament-panels |
| vendor.filament-panels.resources.pages.create-record | vendor/filament-panels/resources/pages/create-record.blade.php | N/A | N/A | filament-panels, filament-panels, filament-panels, filament-panels |
| vendor.filament-panels.resources.pages.edit-record | vendor/filament-panels/resources/pages/edit-record.blade.php | N/A | N/A | filament-panels, filament-panels, filament-panels, filament-panels, slot, filament-panels |
| vendor.filament-panels.resources.pages.list-records | vendor/filament-panels/resources/pages/list-records.blade.php | N/A | N/A | filament-panels, filament-panels |
| vendor.filament-panels.resources.pages.manage-related-records | vendor/filament-panels/resources/pages/manage-related-records.blade.php | N/A | N/A | filament-panels, filament-panels, filament-panels |
| vendor.filament-panels.resources.pages.view-record | vendor/filament-panels/resources/pages/view-record.blade.php | N/A | N/A | filament-panels, filament-panels, slot |
| vendor.filament-panels.resources.relation-manager | vendor/filament-panels/resources/relation-manager.blade.php | N/A | N/A | filament-panels, filament-panels |
| vendor.filament-panels.widgets.account-widget | vendor/filament-panels/widgets/account-widget.blade.php | N/A | N/A | filament-widgets, filament, filament-panels, filament |
| vendor.filament-panels.widgets.filament-info-widget | vendor/filament-panels/widgets/filament-info-widget.blade.php | N/A | N/A | filament-widgets, filament, filament, filament, slot |
| vps | vps.blade.php | N/A | layouts.app |  |

## Models

| Model | Class | Relationships |
|-------|-------|---------------|
| GenerationLog | App\Models\GenerationLog | user (belongsTo), generator (belongsTo) |
| Generator | App\Models\Generator | generationLogs (hasMany) |
| Product | App\Models\Product |  |
| User | App\Models\User | canAccessPanel (hasMany), generationLogs (hasMany), tokens (morphMany), tokenCan (morphMany), tokenCant (morphMany), createToken (morphMany), generateTokenString (morphMany), currentAccessToken (morphMany), withAccessToken (morphMany), notifications (morphMany), readNotifications (morphMany), unreadNotifications (morphMany), bootHasRoles (morphTo), getRoleClass (morphTo), roles (morphTo), scopeRole (morphTo), scopeWithoutRole (morphTo), assignRole (morphTo), removeRole (morphTo), syncRoles (morphTo), hasRole (morphTo), hasAnyRole (morphTo), hasAllRoles (morphTo), hasExactRoles (morphTo), getDirectPermissions (morphTo), getRoleNames (morphTo), bootHasPermissions (morphTo), getPermissionClass (morphTo), getWildcardClass (morphTo), permissions (morphTo), scopePermission (morphTo), scopeWithoutPermission (morphTo), filterPermission (morphTo), hasPermissionTo (morphTo), checkPermissionTo (morphTo), hasAnyPermission (morphTo), hasAllPermissions (morphTo), hasDirectPermission (morphTo), getPermissionsViaRoles (morphTo), getAllPermissions (morphTo), givePermissionTo (morphTo), forgetWildcardPermissionIndex (morphTo), syncPermissions (morphTo), revokePermissionTo (morphTo), getPermissionNames (morphTo), forgetCachedPermissions (morphTo), hasAllDirectPermissions (morphTo), hasAnyDirectPermission (morphTo) |

## Filament Resources

| Resource | Model | Navigation Group | Icon |
|----------|-------|------------------|------|
| GenerationLogResource | GenerationLog | ניהול מערכת | heroicon-o-document-text |
| GeneratorResource | Generator | ניהול מערכת | heroicon-o-cog-6-tooth |
| ProductResource | Product | N/A | heroicon-o-rectangle-stack |

## Livewire Components

| Component | Class | View |
|-----------|-------|------|
| DomainCard | App\Livewire\Admin\DomainCard | livewire.admin.domain-card |
| DomainsNew | App\Livewire\Admin\DomainsNew | livewire.admin.domains-new |
| ConfirmPassword | App\Livewire\Auth\ConfirmPassword | livewire.auth.confirm-password |
| ForgotPassword | App\Livewire\Auth\ForgotPassword | livewire.auth.forgot-password |
| Login | App\Livewire\Auth\Login | livewire.auth.login |
| Register | App\Livewire\Auth\Register | livewire.auth.register |
| ResetPassword | App\Livewire\Auth\ResetPassword | livewire.auth.reset-password |
| VerifyEmail | App\Livewire\Auth\VerifyEmail | livewire.auth.verify-email |

## Recommendations

### Missing View Components

The following components are referenced in views but may not exist:

- form-section
- slot
- input-error
- action-message
- section-border
- action-section
- dialog-modal
- secondary-button
- confirmation-modal
- danger-button
- app-layout
- guest-layout
- input-label
- text-input
- primary-button
- auth-session-status
- logo-with-text
- section-title
- dynamic-component
- application-logo
- mail::message
- mail::button', ['url' => route('register
- filament-panels
- filament
- nav-link
- dropdown-link
- switchable-team
- responsive-nav-link
- authentication-card-logo
- filament-widgets
- filament-actions

### Unused Models

The following models do not have corresponding Filament resources:

- User

### Potentially Unused Views

The following views may not be directly referenced by routes or other views:

- Domains.php
- Hosting.php
- Search.php
- Vps.php
- admin.dashboard
- api.api-token-manager
- api.index
- auth.confirm-password
- auth.forgot-password
- auth.login
- auth.register
- auth.reset-password
- auth.verify-email
- client.dashboard
- coming-soon
- dashboard
- domains
- emails.team-invitation
- filament.resources.generator-resource.pages.generate-code
- home
- hosting
- lang.he.activity.php
- layouts.admin
- layouts.client-layout
- layouts.guest
- layouts.navigation
- livewire.admin.dashboard
- livewire.admin.layout
- livewire.admin.orders
- livewire.admin.plans
- livewire.admin.tickets
- livewire.client.dashboard
- livewire.domains
- livewire.hosting
- livewire.search
- navigation-menu
- policy
- profile.edit
- terms
- vendor.filament-panels.components.avatar.tenant
- vendor.filament-panels.components.avatar.user
- vendor.filament-panels.components.form.actions
- vendor.filament-panels.components.form.index
- vendor.filament-panels.components.global-search.actions
- vendor.filament-panels.components.global-search.field
- vendor.filament-panels.components.global-search.index
- vendor.filament-panels.components.global-search.no-results-message
- vendor.filament-panels.components.global-search.result-group
- vendor.filament-panels.components.global-search.result
- vendor.filament-panels.components.global-search.results-container
- vendor.filament-panels.components.header.index
- vendor.filament-panels.components.header.simple
- vendor.filament-panels.components.layout.base
- vendor.filament-panels.components.layout.index
- vendor.filament-panels.components.layout.simple
- vendor.filament-panels.components.layouts.app
- vendor.filament-panels.components.logo
- vendor.filament-panels.components.page.index
- vendor.filament-panels.components.page.simple
- vendor.filament-panels.components.page.sub-navigation.select
- vendor.filament-panels.components.page.sub-navigation.sidebar
- vendor.filament-panels.components.page.sub-navigation.tabs
- vendor.filament-panels.components.page.unsaved-data-changes-alert
- vendor.filament-panels.components.resources.relation-managers
- vendor.filament-panels.components.resources.tabs
- vendor.filament-panels.components.sidebar.group
- vendor.filament-panels.components.sidebar.index
- vendor.filament-panels.components.sidebar.item
- vendor.filament-panels.components.tenant-menu
- vendor.filament-panels.components.theme-switcher.button
- vendor.filament-panels.components.theme-switcher.index
- vendor.filament-panels.components.topbar.database-notifications-trigger
- vendor.filament-panels.components.topbar.index
- vendor.filament-panels.components.topbar.item
- vendor.filament-panels.components.unsaved-action-changes-alert
- vendor.filament-panels.components.user-menu
- vendor.filament-panels.pages.auth.edit-profile
- vendor.filament-panels.pages.auth.email-verification.email-verification-prompt
- vendor.filament-panels.pages.auth.login
- vendor.filament-panels.pages.auth.password-reset.request-password-reset
- vendor.filament-panels.pages.auth.password-reset.reset-password
- vendor.filament-panels.pages.auth.register
- vendor.filament-panels.pages.dashboard
- vendor.filament-panels.pages.tenancy.edit-tenant-profile
- vendor.filament-panels.pages.tenancy.register-tenant
- vendor.filament-panels.resources.pages.create-record
- vendor.filament-panels.resources.pages.edit-record
- vendor.filament-panels.resources.pages.list-records
- vendor.filament-panels.resources.pages.manage-related-records
- vendor.filament-panels.resources.pages.view-record
- vendor.filament-panels.resources.relation-manager
- vendor.filament-panels.widgets.account-widget
- vendor.filament-panels.widgets.filament-info-widget
- vps

### Views Without Titles

The following views do not have explicit title tags or section declarations:

- Domains.php
- Hosting.php
- Search.php
- Vps.php
- admin.dashboard
- api.api-token-manager
- api.index
- auth.confirm-password
- auth.forgot-password
- auth.login
- auth.register
- auth.reset-password
- auth.verify-email
- dashboard
- domains
- emails.team-invitation
- filament.resources.generator-resource.pages.generate-code
- hosting
- lang.he.activity.php
- livewire.admin.dashboard
- livewire.admin.domain-card
- livewire.admin.domains-new
- livewire.admin.layout
- livewire.admin.orders
- livewire.admin.plans
- livewire.admin.tickets
- livewire.auth.confirm-password
- livewire.auth.forgot-password
- livewire.auth.register
- livewire.auth.reset-password
- livewire.auth.verify-email
- livewire.client.dashboard
- livewire.domains
- livewire.hosting
- livewire.search
- navigation-menu
- policy
- profile.edit
- profile.partials.delete-user-form
- profile.partials.update-password-form
- profile.partials.update-profile-information-form
- terms
- vendor.filament-panels.components.avatar.tenant
- vendor.filament-panels.components.avatar.user
- vendor.filament-panels.components.form.actions
- vendor.filament-panels.components.form.index
- vendor.filament-panels.components.global-search.actions
- vendor.filament-panels.components.global-search.field
- vendor.filament-panels.components.global-search.index
- vendor.filament-panels.components.global-search.no-results-message
- vendor.filament-panels.components.global-search.result-group
- vendor.filament-panels.components.global-search.result
- vendor.filament-panels.components.global-search.results-container
- vendor.filament-panels.components.header.index
- vendor.filament-panels.components.header.simple
- vendor.filament-panels.components.layout.index
- vendor.filament-panels.components.layout.simple
- vendor.filament-panels.components.layouts.app
- vendor.filament-panels.components.logo
- vendor.filament-panels.components.page.index
- vendor.filament-panels.components.page.simple
- vendor.filament-panels.components.page.sub-navigation.select
- vendor.filament-panels.components.page.sub-navigation.sidebar
- vendor.filament-panels.components.page.sub-navigation.tabs
- vendor.filament-panels.components.page.unsaved-data-changes-alert
- vendor.filament-panels.components.resources.relation-managers
- vendor.filament-panels.components.resources.tabs
- vendor.filament-panels.components.sidebar.group
- vendor.filament-panels.components.sidebar.index
- vendor.filament-panels.components.sidebar.item
- vendor.filament-panels.components.tenant-menu
- vendor.filament-panels.components.theme-switcher.button
- vendor.filament-panels.components.theme-switcher.index
- vendor.filament-panels.components.topbar.database-notifications-trigger
- vendor.filament-panels.components.topbar.index
- vendor.filament-panels.components.topbar.item
- vendor.filament-panels.components.unsaved-action-changes-alert
- vendor.filament-panels.components.user-menu
- vendor.filament-panels.pages.auth.edit-profile
- vendor.filament-panels.pages.auth.email-verification.email-verification-prompt
- vendor.filament-panels.pages.auth.login
- vendor.filament-panels.pages.auth.password-reset.request-password-reset
- vendor.filament-panels.pages.auth.password-reset.reset-password
- vendor.filament-panels.pages.auth.register
- vendor.filament-panels.pages.dashboard
- vendor.filament-panels.pages.tenancy.edit-tenant-profile
- vendor.filament-panels.pages.tenancy.register-tenant
- vendor.filament-panels.resources.pages.create-record
- vendor.filament-panels.resources.pages.edit-record
- vendor.filament-panels.resources.pages.list-records
- vendor.filament-panels.resources.pages.manage-related-records
- vendor.filament-panels.resources.pages.view-record
- vendor.filament-panels.resources.relation-manager
- vendor.filament-panels.widgets.account-widget
- vendor.filament-panels.widgets.filament-info-widget
- vps

### Routes Without Names

The following routes do not have explicit names, which may make URL generation more difficult:

- login (POST)
- register (POST)
- user/two-factor-recovery-codes (POST)
- livewire/livewire.js (GET, HEAD)
- livewire/livewire.min.js.map (GET, HEAD)
- api/scan-code (GET, HEAD)
- api/scan-files (GET, HEAD)
- home (GET, HEAD, POST, PUT, PATCH, DELETE, OPTIONS)
- confirm-password (POST)

### Structure Recommendations

- Consider organizing routes into smaller, more focused groups
- Controller 'App\Http\Controllers\HomeController' has 12 routes. Consider breaking it into smaller, more focused controllers

## Cross-Relation Table

This table shows connections between different components of the application.

### Models to Resources

| Model | Resource | Navigation Group |
|-------|----------|------------------|
| GenerationLog | GenerationLogResource | ניהול מערכת |
| Generator | GeneratorResource | ניהול מערכת |
| Product | ProductResource | N/A |
| User | None | N/A |

### Routes to Controllers

| Route | HTTP Methods | Controller | Method |
|-------|--------------|------------|--------|
| _debugbar/open | GET, HEAD | OpenHandlerController | handle |
| _debugbar/clockwork/{id} | GET, HEAD | OpenHandlerController | clockwork |
| _debugbar/assets/stylesheets | GET, HEAD | AssetController | css |
| _debugbar/assets/javascript | GET, HEAD | AssetController | js |
| _debugbar/cache/{key}/{tags?} | DELETE | CacheController | delete |
| _debugbar/queries/explain | POST | QueriesController | explain |
| filament/exports/{export}/download | GET, HEAD | N/A | N/A |
| filament/imports/{import}/failed-rows/download | GET, HEAD | N/A | N/A |
| admin/logout | POST | N/A | N/A |
| admin | GET, HEAD | N/A | N/A |
| admin/users | GET, HEAD | N/A | N/A |
| admin/users/create | GET, HEAD | N/A | N/A |
| admin/users/{record}/edit | GET, HEAD | N/A | N/A |
| admin/roles | GET, HEAD | N/A | N/A |
| admin/roles/create | GET, HEAD | N/A | N/A |
| admin/roles/{record}/edit | GET, HEAD | N/A | N/A |
| admin/generators | GET, HEAD | N/A | N/A |
| admin/generators/create | GET, HEAD | N/A | N/A |
| admin/generators/{record}/edit | GET, HEAD | N/A | N/A |
| admin/generators/{record}/generate | GET, HEAD | N/A | N/A |
| admin/generation-logs | GET, HEAD | N/A | N/A |
| admin/generation-logs/create | GET, HEAD | N/A | N/A |
| admin/generation-logs/{record}/edit | GET, HEAD | N/A | N/A |
| admin/products | GET, HEAD | N/A | N/A |
| admin/products/create | GET, HEAD | N/A | N/A |
| admin/products/{record}/edit | GET, HEAD | N/A | N/A |
| login | GET, HEAD | AuthenticatedSessionController | create |
| login | POST | AuthenticatedSessionController | store |
| logout | POST | AuthenticatedSessionController | destroy |
| forgot-password | GET, HEAD | PasswordResetLinkController | create |
| reset-password/{token} | GET, HEAD | NewPasswordController | create |
| forgot-password | POST | PasswordResetLinkController | store |
| reset-password | POST | NewPasswordController | store |
| register | GET, HEAD | RegisteredUserController | create |
| register | POST | RegisteredUserController | store |
| user/profile-information | PUT | ProfileInformationController | update |
| user/password | PUT | PasswordController | update |
| user/confirm-password | GET, HEAD | ConfirmablePasswordController | show |
| user/confirmed-password-status | GET, HEAD | ConfirmedPasswordStatusController | show |
| user/confirm-password | POST | ConfirmablePasswordController | store |
| two-factor-challenge | GET, HEAD | TwoFactorAuthenticatedSessionController | create |
| two-factor-challenge | POST | TwoFactorAuthenticatedSessionController | store |
| user/two-factor-authentication | POST | TwoFactorAuthenticationController | store |
| user/confirmed-two-factor-authentication | POST | ConfirmedTwoFactorAuthenticationController | store |
| user/two-factor-authentication | DELETE | TwoFactorAuthenticationController | destroy |
| user/two-factor-qr-code | GET, HEAD | TwoFactorQrCodeController | show |
| user/two-factor-secret-key | GET, HEAD | TwoFactorSecretKeyController | show |
| user/two-factor-recovery-codes | GET, HEAD | RecoveryCodeController | index |
| user/two-factor-recovery-codes | POST | RecoveryCodeController | store |
| user/profile | GET, HEAD | UserProfileController | show |
| sanctum/csrf-cookie | GET, HEAD | CsrfCookieController | show |
| livewire/update | POST | HandleRequests | handleUpdate |
| livewire/livewire.js | GET, HEAD | FrontendAssets | returnJavaScriptAsFile |
| livewire/livewire.min.js.map | GET, HEAD | FrontendAssets | maps |
| livewire/upload-file | POST | FileUploadController | handle |
| livewire/preview-file/{filename} | GET, HEAD | FilePreviewController | handle |
| api/scan-code | GET, HEAD | CodeScanController | scan |
| api/scan-files | GET, HEAD | FileScanController | scanFiles |
| lang/{locale} | GET, HEAD | LanguageController | switchLang |
| / | GET, HEAD | HomeController | index |
| home | GET, HEAD, POST, PUT, PATCH, DELETE, OPTIONS | N/A | N/A |
| search | POST | HomeController | search |
| domains | GET, HEAD | HomeController | domains |
| hosting | GET, HEAD | HomeController | hosting |
| vps | GET, HEAD | HomeController | vps |
| cloud | GET, HEAD | HomeController | cloud |
| contact | POST | HomeController | contactSubmit |
| terms | GET, HEAD | HomeController | terms |
| policy | GET, HEAD | HomeController | policy |
| dashboard | GET, HEAD | HomeController | dashboard |
| profile | GET, HEAD | HomeController | profile |
| settings | GET, HEAD | HomeController | settings |
| profile/edit | GET, HEAD | ProfileController | edit |
| profile | PATCH | ProfileController | update |
| profile | DELETE | ProfileController | destroy |
| admin/dashboard | GET, HEAD | N/A | N/A |
| admin/users-legacy | GET, HEAD | N/A | N/A |
| admin/domains | GET, HEAD | N/A | N/A |
| admin/hosting | GET, HEAD | N/A | N/A |
| admin/vps | GET, HEAD | N/A | N/A |
| admin/invoices | GET, HEAD | N/A | N/A |
| admin/plans | GET, HEAD | N/A | N/A |
| admin/orders | GET, HEAD | N/A | N/A |
| admin/tickets | GET, HEAD | N/A | N/A |
| admin/settings | GET, HEAD | N/A | N/A |
| client/dashboard | GET, HEAD | N/A | N/A |
| client/domains | GET, HEAD | N/A | N/A |
| client/domains/check | GET, HEAD | N/A | N/A |
| client/hosting | GET, HEAD | N/A | N/A |
| client/hosting/new | GET, HEAD | N/A | N/A |
| client/vps | GET, HEAD | N/A | N/A |
| client/invoices | GET, HEAD | N/A | N/A |
| client/settings | GET, HEAD | N/A | N/A |
| client/support | GET, HEAD | N/A | N/A |
| client/support/new | GET, HEAD | N/A | N/A |
| verify-email | GET, HEAD | N/A | N/A |
| verify-email/{id}/{hash} | GET, HEAD | N/A | N/A |
| email/verification-notification | POST | EmailVerificationNotificationController | store |
| confirm-password | GET, HEAD | ConfirmablePasswordController | show |
| confirm-password | POST | ConfirmablePasswordController | store |
| password | PUT | PasswordController | update |

### Livewire Components to Views

| Component | View | Used in Routes |
|-----------|------|----------------|
| DomainCard | livewire.admin.domain-card | None |
| DomainsNew | livewire.admin.domains-new | None |
| ConfirmPassword | livewire.auth.confirm-password | None |
| ForgotPassword | livewire.auth.forgot-password | None |
| Login | livewire.auth.login | None |
| Register | livewire.auth.register | None |
| ResetPassword | livewire.auth.reset-password | None |
| VerifyEmail | livewire.auth.verify-email | None |

