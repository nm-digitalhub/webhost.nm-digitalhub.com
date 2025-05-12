# NM-DigitalHUB - Project Structure (Laravel 12)

## /app
├── Http
│   ├── Controllers
│   │   ├── Api
│   │   ├── Auth
│   │   ├── Admin
│   │   ├── Client
│   │   ├── Controller.php
│   │   ├── HomeController.php
│   │   ├── PageController.php
│   │   ├── AdminController.php
│   │   ├── ClientController.php
│   │   ├── ProfileController.php
│   │   ├── LanguageController.php
│   │   ├── GoogleOAuthController.php
│   │   └── ImpersonationController.php
│   └── Middleware
├── Livewire
│   ├── Auth
│   ├── Admin
│   │   ├── Dashboard.php
│   │   ├── Domains.php
│   │   ├── DomainsNew.php
│   │   ├── DomainCard.php
│   │   ├── Hosting.php
│   │   ├── Invoices.php
│   │   ├── Orders.php
│   │   ├── Plans.php
│   │   ├── Settings.php
│   │   ├── Tickets.php
│   │   ├── Users.php
│   │   ├── Vps.php
│   │   └── AdminLayout.php
│   └── Client
│       ├── Dashboard.php
│       ├── Domains.php
│       ├── DomainCheck.php
│       ├── Hosting.php
│       ├── HostingNew.php
│       ├── Invoices.php
│       ├── Settings.php
│       ├── Support.php
│       ├── SupportNew.php
│       └── Vps.php
├── Filament
│   ├── Resources
│   │   ├── UserResource.php
│   │   ├── DomainResource.php
│   │   ├── HostingResource.php
│   │   ├── InvoiceResource.php
│   │   └── PlanResource.php
│   ├── Pages
│   │   ├── Dashboard.php
│   │   └── Settings.php
│   └── Widgets
│       ├── StatsOverview.php
│       └── LatestOrders.php
├── Models
│   ├── User.php
│   ├── Domain.php
│   ├── Hosting.php
│   ├── Invoice.php
│   ├── Plan.php
│   └── Ticket.php
└── Providers

## /resources/views
├── layouts
│   ├── admin.blade.php
│   ├── client.blade.php
│   └── public.blade.php
├── livewire
│   ├── admin
│   │   ├── dashboard.blade.php
│   │   ├── domains.blade.php
│   │   ├── domains-new.blade.php
│   │   ├── domain-card.blade.php
│   │   ├── hosting.blade.php
│   │   ├── invoices.blade.php
│   │   ├── orders.blade.php
│   │   ├── plans.blade.php
│   │   ├── settings.blade.php
│   │   ├── tickets.blade.php
│   │   ├── users.blade.php
│   │   └── vps.blade.php
│   └── client
│       ├── dashboard.blade.php
│       ├── domains.blade.php
│       ├── domain-check.blade.php
│       ├── hosting.blade.php
│       ├── hosting-new.blade.php
│       ├── invoices.blade.php
│       ├── settings.blade.php
│       ├── support.blade.php
│       ├── support-new.blade.php
│       └── vps.blade.php
├── components
│   ├── navbar.blade.php
│   ├── sidebar.blade.php
│   ├── footer.blade.php
│   └── notifications.blade.php
├── vendor
│   └── filament-panels
│       └── components
│           └── layout
│               └── index.blade.php
├── errors
│   ├── 404.blade.php
│   └── 500.blade.php
└── welcome.blade.php

## /routes
├── web.php
├── auth.php
├── web_impersonation.php
└── api.php

## /config
├── app.php
├── auth.php
├── database.php
├── filament.php
├── livewire.php
└── services.php