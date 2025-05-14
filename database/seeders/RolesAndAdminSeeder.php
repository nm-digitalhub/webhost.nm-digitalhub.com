<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndAdminSeeder extends Seeder
{
    public function run(): void
    {
        // יצירת הרשאות בסיסיות
        $permissions = ['manage users', 'view dashboard', 'edit settings'];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'web');
        }

        // יצירת תפקיד admin והקצאת הרשאות
        $adminRole = Role::findOrCreate('admin', 'web');
        $adminRole->syncPermissions($permissions);

        // עדכון משתמש קיים עם תפקיד admin
        $user = User::where('email', 'admin@nm-digitalhub.com')->first();

        if ($user) {
            $user->name = 'KALFA Netanel Mevorach';
            $user->password = Hash::make('13579Net!!@!!');
            $user->assignRole($adminRole);
            $user->save();
            $this->command->info('Admin user updated and assigned the admin role.');
        } else {
            $this->command->error('Admin user not found.');
        }
    }
}
