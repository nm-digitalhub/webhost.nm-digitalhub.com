<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            permissionsSeeder::class,
            // RolesAndAdminSeeder::class, // Commented out as we're using the new seeder
            CreateRolesAndSetAdminSeeder::class, // Our new seeder for roles and admin
            PageSeeder::class,
            ClientModulesSeeder::class, // Install client panel modules
            ModulesSeeder::class, // Seed available system modules
            GeneratorsSeeder::class, // Seed generator templates for code generation
        ]);
    }
}
