<?php

namespace App\Console\Commands;

use Database\Seeders\CreateRolesAndSetAdminSeeder;
use Illuminate\Console\Command;

class SetupRolesAndAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:roles-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup roles (Super-Admin, Admin, Support, Client) and assign Admin role to admin@nm-digitalhub.com';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Setting up roles and admin user...');

        $seeder = new CreateRolesAndSetAdminSeeder;
        $seeder->setCommand($this);
        $seeder->run();

        $this->info('Roles and admin user setup completed successfully!');
        $this->info('Admin user can now access the Filament admin panel at /admin');

        return Command::SUCCESS;
    }
}
