<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class SetupAdminRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:setup {email?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set up the admin role for a user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email') ?? 'admin@nm-digitalhub.com';

        // יצירת תפקיד admin אם הוא לא קיים
        Role::firstOrCreate(['name' => 'admin']);

        // מציאת המשתמש
        $user = User::where('email', $email)->first();

        if (! $user) {
            $this->error("User with email {$email} not found!");

            return 1;
        }

        // הקצאת תפקיד admin למשתמש
        $user->assignRole('admin');

        // עדכון שדה ה-type של המשתמש
        $user->type = 'admin';
        $user->save();

        $this->info("Admin role assigned to {$email} successfully!");

        return 0;
    }
}
