<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class permissionsSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'manage users',
            'view dashboard',
            'edit settings',
            'create posts',
            'delete posts',
            'mail.manage',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'web');
        }

        $this->command->info('Permissions seeded successfully.');
    }
}
