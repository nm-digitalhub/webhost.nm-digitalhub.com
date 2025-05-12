# NM-DigitalHUB Roles and Admin Setup

This document explains how to set up roles and assign the Admin role to a specific user in the NM-DigitalHUB application.

## Available Roles

The following roles have been created:

1. **Super-Admin**: Has access to all permissions
2. **Admin**: Has access to most permissions except for billing management
3. **Support**: Has access to view dashboard and support-related features
4. **Client**: Has limited access to view dashboard and create tickets

## Admin User

The admin user has been created with the following credentials:

- **Name**: KALFA Netanel Mevorach
- **Email**: admin@nm-digitalhub.com
- **Password**: 13579Net!!@!!
- **Role**: Admin
- **is_admin**: true (for Filament access)

## How to Run the Setup

### Option 1: Run the dedicated command

```bash
php artisan setup:roles-admin
```

This command will:
- Create all the necessary roles
- Create or update the admin user
- Set the admin's is_admin flag to true
- Assign the Admin role to the admin user

### Option 2: Run the seeder directly

```bash
php artisan db:seed --class=Database\\Seeders\\CreateRolesAndSetAdminSeeder
```

### Option 3: Run all seeders

This will run all seeders including our roles and admin seeder:

```bash
php artisan db:seed
```

## Verification

After running any of the setup options above, you can verify that the roles have been created and the admin user has been assigned the Admin role:

```bash
# Check roles
php artisan tinker
>>> Spatie\Permission\Models\Role::all()->pluck('name');

# Check admin user
>>> App\Models\User::where('email', 'admin@nm-digitalhub.com')->first()->getRoleNames();
>>> App\Models\User::where('email', 'admin@nm-digitalhub.com')->first()->is_admin;
```

## Accessing the Admin Panel

The admin user can now access the Filament admin panel at:

```
/admin
```

Login with:
- Email: admin@nm-digitalhub.com
- Password: 13579Net!!@!!