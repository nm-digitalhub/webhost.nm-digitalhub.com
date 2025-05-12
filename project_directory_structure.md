# Project Directory Structure: NM-DigitalHUB (Laravel 12)

## /app
- **Http**
  - Controllers
    - Admin
    - Client
    - API
  - Middleware
- **Livewire**
  - Admin
    - Dashboard.php
    - Plans.php
    - Hosting.php
    - Users.php
    - Invoices.php
  - Client
    - Dashboard.php
    - Hosting.php
    - Domains.php
    - Invoices.php
    - SupportNew.php
- **Models**
  - Domain.php
  - Invoice.php
- **Filament**
  - Resources
    - DomainResource.php
    - PlanResource.php
    - InvoiceResource.php
  - Pages
    - Dashboard.php
    - Settings.php
  - Widgets
    - OverviewChart.php
    - StatisticsWidget.php

---

## /resources/views
- **layouts**
  - client.blade.php
  - admin.blade.php
  - public.blade.php
- **livewire**
  - **admin**
    - dashboard.blade.php
    - hosting.blade.php
    - invoices.blade.php
    - plans.blade.php
    - users.blade.php
  - **client**
    - dashboard.blade.php
    - domains.blade.php
    - hosting.blade.php
    - invoices.blade.php
    - support-new.blade.php
- **components**
  - navbar.blade.php
  - footer.blade.php
- **errors**
  - 404.blade.php
- welcome.blade.php

---

## /routes
- web.php
- auth.php
- web_impersonation.php
- api.php
- console.php

---

## /config
- app.php
- auth.php
- database.php
- livewire.php
- filament.php
- jwt.php