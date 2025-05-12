<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateRolesAndSetAdminSeeder extends Seeder
{
    /**
     * Run the seeder to create roles and assign the admin user.
     */
    public function run(): void
    {
        // Create roles
        $roles = [
            'Super-Admin',
            'Admin',
            'Support',
            'Client'
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
            $this->command->info("Role '{$role}' created successfully.");
        }

        // Create basic permissions (optional)
        $permissions = [
            'manage-users',
            'view-dashboard',
            'manage-settings',
            'manage-content',
            'manage-billing',
            'view-support',
            'create-tickets',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign permissions to roles
        $superAdminRole = Role::where('name', 'Super-Admin')->first();
        $adminRole = Role::where('name', 'Admin')->first();
        $supportRole = Role::where('name', 'Support')->first();
        $clientRole = Role::where('name', 'Client')->first();

        // Give all permissions to Super-Admin
        $superAdminRole->syncPermissions(Permission::all());
        
        // Give most permissions to Admin
        $adminRole->syncPermissions(Permission::whereNotIn('name', ['manage-billing'])->get());
        
        // Give support-related permissions to Support
        $supportRole->syncPermissions(['view-dashboard', 'view-support', 'create-tickets']);
        
        // Give client permissions
        $clientRole->syncPermissions(['view-dashboard', 'create-tickets']);

        // Find or create admin user
        $user = User::where('email', 'admin@nm-digitalhub.com')->first();

        if (!$user) {
            $user = User::create([
                'name' => 'KALFA Netanel Mevorach',
                'email' => 'admin@nm-digitalhub.com',
                'password' => Hash::make('13579Net!!@!!')
            ]);
            $this->command->info('Admin user created successfully.');
        } else {
            $user->name = 'KALFA Netanel Mevorach';
            $user->password = Hash::make('13579Net!!@!!');
            $user->save();
            $this->command->info('Admin user updated successfully.');
        }

        // Set is_admin flag to true
        $user->is_admin = true;
        $user->save();
        
        // Clear any previous roles and assign Admin role
        $user->syncRoles(['Admin']);

        $this->command->info('Admin user assigned the Admin role and is_admin flag set to true.');
        $this->command->info('Roles and admin user setup completed successfully.');
    }
}