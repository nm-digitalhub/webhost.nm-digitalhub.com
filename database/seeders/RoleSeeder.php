<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // יצירת הרשאה
        $permission = Permission::firstOrCreate(['name' => 'manage users']);

        // יצירת תפקיד אדמין
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // שיוך ההרשאה לתפקיד
        $adminRole->givePermissionTo($permission);
    }
}
