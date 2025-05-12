# Setup Instructions for Public Page Editor Connector

This document explains how to set up the Public Page Editor Connector that links public-facing Blade views to editable CMS models in the admin panel.

## Setup Steps

1. Run the migration to add the new fields to the pages table:

```bash
php artisan migrate
```

2. Run the seeder to populate the database with initial page content:

```bash
php artisan db:seed --class=PageSeeder
```

3. Clear all caches:

```bash
php artisan optimize:clear
```

## Features

The Public Page Editor Connector provides the following features:

1. **Dynamic Page Content:** All public pages (home, domains, hosting, VPS, cloud, terms, policy) now pull content from the database.

2. **Admin Panel Integration:** Pages can be edited through the Filament admin panel.

3. **Multilingual Support:** Pages support both English and Hebrew languages.

4. **SEO Optimization:** Pages include meta title, description, and keywords fields.

5. **Flexible Layouts:** Pages can use different layouts (default, full-width, sidebar-left, sidebar-right).

6. **Structured Content:** Metadata JSON field allows for structured content like pricing tables, feature cards, etc.

7. **Parent-Child Relationships:** Pages can have parent-child relationships.

8. **Fallback Mechanism:** If a page isn't found in the database, the system falls back to static views.

## Usage

### Editing Pages

1. Log in to the admin panel.
2. Navigate to the "Pages" section.
3. Edit an existing page or create a new one.
4. Set the page type, language, and other attributes.
5. Fill in the content and metadata as needed.
6. Save the page.

### Adding New Pages

1. Create a new page in the admin panel.
2. Set the slug, type, and language.
3. The page will be accessible at `/page/{slug}`.

### Creating Page Templates

To create a new page template:

1. Create a Blade file in `/resources/views/pages/types/` or `/resources/views/pages/layouts/`.
2. Use `$page` and `$metadata` variables to access page content.
3. Update the PageResource form to include the new template option.

## Troubleshooting

If pages aren't displaying correctly:

1. Check that the seeder has run successfully.
2. Ensure the route configuration is correct.
3. Verify that the page is published (`is_published` is set to true).
4. Look for language mismatches (check that pages exist for the current locale).
5. Clear caches with `php artisan optimize:clear`.