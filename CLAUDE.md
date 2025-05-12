# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

NM-DigitalHUB is a Laravel-based web hosting management system with a focus on code generation features. The system uses Laravel, Filament admin panel, Jetstream authentication, and Spatie permission management.

## Development Commands

```bash
# Install dependencies
composer install
npm install

# Run migrations with test data
php artisan migrate:fresh --seed

# Start development server
php artisan serve

# Compile assets
npm run dev

# Run tests
php artisan test

# Clear application cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Generate IDE helper files
php artisan ide-helper:generate
php artisan ide-helper:models
```

## Code Architecture

### Key Components

1. **Authentication & User Management**
   - Uses Laravel Jetstream for authentication
   - Role-based access control via Spatie permissions
   - Admin roles with specialized permissions

2. **Filament Admin Panel**
   - Custom admin panel built with Filament
   - Resource management (users, domains, plans, etc.)
   - Code generation interface

3. **Code Generation System**
   - `Generator` model configures templates for code generation
   - `GeneratorService` handles code creation via Artisan commands
   - `GenerationLog` tracks generation history
   - Support for generating Models, Resources, Pages, and Widgets

4. **Client/Admin Separation**
   - Separate interfaces for admin and client users
   - Client dashboard for service management
   - Admin dashboard for system management

### Important Design Patterns

1. **Service Layer Pattern**
   - Business logic encapsulated in service classes (e.g., `GeneratorService`)
   - Controllers remain thin and delegate to services

2. **Repository Pattern**
   - Eloquent models with relationships
   - Resource classes for admin CRUD operations

3. **Role-Based Authorization**
   - Middleware checks for role permissions
   - User model uses HasRoles trait

## Code Generation System

The code generation system is a key feature that provides:

1. **Template Management**
   - Create and store code generation templates
   - Configure models, resources, pages, and widgets

2. **Code Preview**
   - Preview generated code before creation
   - Syntax highlighting for review

3. **File Management**
   - Target path selection
   - Overwrite confirmation for existing files

4. **Activity Logging**
   - Track who generated what code
   - Record success/failure status

## Multi-Language Support

The system includes translations for English and Hebrew, with support for additional languages. Text in the admin interface uses Hebrew for labels and English for technical terms.

## Database Structure

Key tables:
- users: User accounts with role relationships
- roles: User roles (admin, client, etc.)
- permissions: Granular permissions for roles
- generators: Code generation templates
- generation_logs: History of code generation
- products: Service products offered to clients

## Working With Views

Views use Laravel Blade templates with:
- Livewire components for reactive interfaces
- Tailwind CSS for styling
- Alpine.js for client-side interactions

When modifying views, maintain the existing pattern of:
- Separate admin/client views
- Component-based design
- RTL language support
# Summary instructions

When you are using compact, please focus on test output and code changes
