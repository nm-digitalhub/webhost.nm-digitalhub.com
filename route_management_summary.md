# Routes Summary

## Web Routes

### Public Routes
- `/` → Welcome page
- `/lang/{locale}` → `LanguageController@switchLang` - Language switching
- `/login` → Authentication page
- `/terms` → `PageController@terms` - Terms page
- `/policy` → `PageController@policy` - Policy page
- `/domains` → `PageController@servicePage` - Domains service page
- `/hosting` → `PageController@servicePage` - Hosting service page
- `/vps` → `PageController@servicePage` - VPS service page
- `/cloud` → `PageController@servicePage` - Cloud service page
- `/page/{slug}` → `PageController@show` - Dynamic content pages

### Authenticated Routes
- `/dashboard` → `HomeController@dashboard` - User dashboard
- `/settings` → `HomeController@settings` - User settings

### Profile Routes
- `/profile` → `HomeController@profile` - User profile
- `/profile/edit` → `ProfileController@edit` - Edit profile
- `/profile` (PATCH) → `ProfileController@update` - Update profile
- `/profile` (DELETE) → `ProfileController@destroy` - Delete profile

### Admin Routes (Middleware: IsAdmin)
- `/admin/dashboard` → `App\Livewire\Admin\Dashboard` - Admin dashboard
- `/admin/users-legacy` → `App\Livewire\Admin\Users` - Users management
- `/admin/domains` → `App\Livewire\Admin\Domains` - Domains management
- `/admin/domains/new` → `App\Livewire\Admin\DomainsNew` - Create new domain
- `/admin/hosting` → `App\Livewire\Admin\Hosting` - Hosting management
- `/admin/vps` → `App\Livewire\Admin\Vps` - VPS management
- `/admin/invoices` → `App\Livewire\Admin\Invoices` - Invoices management
- `/admin/plans` → `App\Livewire\Admin\Plans` - Plans management
- `/admin/orders` → `App\Livewire\Admin\Orders` - Orders management
- `/admin/tickets` → `App\Livewire\Admin\Tickets` - Support tickets
- `/admin/settings` → `App\Livewire\Admin\Settings` - Admin settings

### Client Routes (Middleware: IsClient)
- `/client/dashboard` → `App\Livewire\Client\Dashboard` - Client dashboard
- `/client/domains` → `App\Livewire\Client\Domains` - Client domains
- `/client/domains/check` → `App\Livewire\Client\DomainCheck` - Check domain availability
- `/client/domains/search` → `DomainController@domainSearch` - Search domains
- `/client/domains/dns-management` → `DomainController@dnsManagement` - DNS management
- `/client/hosting` → `App\Livewire\Client\Hosting` - Client hosting
- `/client/hosting/new` → `App\Livewire\Client\HostingNew` - Order new hosting
- `/client/vps` → `App\Livewire\Client\Vps` - Client VPS
- `/client/invoices` → `App\Livewire\Client\Invoices` - Client invoices
- `/client/settings` → `App\Livewire\Client\Settings` - Client settings
- `/client/profile` → `ClientController@profile` - Client profile
- `/client/payment-methods` → `ClientController@paymentMethods` - Payment methods
- `/client/statistics` → `ClientController@statistics` - Client statistics
- `/client/subscriptions` → `BillingController@subscriptions` - Subscriptions
- `/client/support` → `App\Livewire\Client\Support` - Support tickets
- `/client/support/new` → `App\Livewire\Client\SupportNew` - Create new ticket
- `/client/support/tickets` → `SupportController@tickets` - Support tickets
- `/client/support/knowledge-base` → `SupportController@knowledgeBase` - Knowledge base

## Route Issues and Recommendations

1. **Duplicate Routes**: 
   - `/dashboard` defined both as a route closure and a controller method in `HomeController`
   - `/terms` and `/policy` have duplicate definitions

2. **Potential 404 Issues**:
   - Ensure all referenced controllers and methods exist 
   - Confirm all Livewire components have corresponding class implementations

3. **Route Protection**:
   - All client and admin routes are properly protected by middleware
   - Confirm that the `IsAdmin` and `IsClient` middleware are correctly implemented

4. **Route Naming Consistency**:
   - Most routes follow the naming convention of `[area].[entity].[action]`
   - Some routes could be more consistently named (e.g., `users-legacy` vs standardized naming)

5. **Missing API Routes**:
   - Current implementation seems focused on web routes
   - API routes may need to be added for any client-side JavaScript functionality