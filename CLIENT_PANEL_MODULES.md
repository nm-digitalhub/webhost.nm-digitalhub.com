# Client Panel Modules System

This document explains the client panel module system implemented for the NM-DigitalHUB application.

## Overview

The client panel module system provides a flexible, database-driven approach to managing the client panel interface. It allows administrators to control which modules and features are visible to clients, and to customize the appearance and behavior of the client panel without code changes.

## Key Components

### Database Tables

1. **client_modules** - Stores information about available modules in the client panel
   - Contains fields for name, slug, icon, enabled status, position, route, etc.
   - Supports metadata as JSON for extended configuration
   - Can store role restrictions to limit visibility based on user roles

2. **client_pages** - Stores dynamic pages that can be displayed within the client panel
   - Contains fields for title, content, layout, visibility settings
   - Can be linked to specific modules
   - Supports SEO metadata (title, description, keywords)
   - Can be shown in the menu with specific positioning

3. **impersonation_logs** - Tracks admin impersonation sessions for audit purposes
   - Records who impersonated whom, when, and for how long
   - Stores reason for impersonation and IP address for security

### Services

1. **ModuleInstaller** - Service for installing and configuring client panel modules
   - General client module installation 
   - Specialized methods for standard modules (support, billing, domains)
   - Handles configuration, routing, and dependencies

2. **ImpersonationService** - Service for handling admin-to-client impersonation
   - Secure switching between admin and client accounts
   - Session management to track who is impersonating whom
   - Audit logging of all impersonation activities

### Controllers

- **ClientController** - Central controller for client panel functionality
  - Dashboard and core sections (Profile, Settings, Statistics)
  - Dynamic page display
  - Ajax handlers for interactive features

### UI Components

- **client-dynamic-sidebar.blade.php** - Renders navigation based on available modules
  - Filters modules based on user permissions
  - Organizes modules by section and position
  - Displays appropriate icons and labels

- **client-impersonation-banner.blade.php** - Shows admin impersonation warning
  - Visible only during active impersonation
  - Provides quick exit back to admin account
  - Displays security warning to admins

## Usage

### Installing a Module

Modules can be installed using the ModuleInstaller service:

```php
$moduleInstaller = app(ModuleInstaller::class);

// Install a basic module
$result = $moduleInstaller->installClientPanelModule(
    'Module Name',
    'module-slug',
    'heroicon-o-chart-bar',
    'page',
    [
        'position' => 10,
        'route_name' => 'client.module-slug',
        'description' => 'Module description here',
    ]
);

// Or use pre-configured modules
$moduleInstaller->installSupportModuleForClientPanel();
$moduleInstaller->installBillingModuleForClientPanel();
$moduleInstaller->installDomainsModuleForClientPanel();
```

### Adding a Custom Page

Pages can be created in the database and linked to modules:

```php
ClientPage::create([
    'title' => 'Custom Page Title',
    'slug' => 'custom-page-slug',
    'content' => '<h1>Custom Page Content</h1><p>This is a custom page.</p>',
    'layout' => 'default',
    'visibility' => 'public',
    'status' => 'published',
    'show_in_menu' => true,
    'menu_position' => 10,
    'module_id' => $moduleId, // Optional link to a module
]);
```

### Admin Impersonation

Admins can impersonate client accounts using the ImpersonationService:

```php
$impersonationService = app(ImpersonationService::class);
$client = User::find($id);

// Start impersonation
$impersonationService->impersonate($client, 'Support case #12345');

// Check if current session is impersonating
if ($impersonationService->isImpersonating()) {
    // Get impersonator (admin) user
    $admin = $impersonationService->getImpersonator();
}

// Stop impersonation
$impersonationService->stopImpersonating();
```

## Benefits

1. **Dynamic configuration** - No code changes required to add or modify client panel sections
2. **Role-based access** - Fine-grained control over what different users can see
3. **Centralized management** - All client panel configuration is stored in the database
4. **Better support tools** - Admins can impersonate clients to provide better assistance
5. **Audit trail** - All admin actions are logged for security and compliance

## Implementation Notes

- All database tables use Laravel's migration system
- Blade directives (`@impersonating`, `@role`) make templates cleaner
- View composers inject dynamic module data into templates
- Boot methods register service providers automatically 
- Seeders create default modules for initial setup