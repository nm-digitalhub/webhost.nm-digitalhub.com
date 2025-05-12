<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Role;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:create-admin {email?} {name?} {password?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'יצירת משתמש מנהל חדש';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email') ?? $this->ask('מה האימייל של המנהל?');
        $name = $this->argument('name') ?? $this->ask('מה השם של המנהל?');
        $password = $this->argument('password') ?? $this->secret('מה הסיסמה של המנהל?');
        
        // בדיקה אם המשתמש כבר קיים
        $existingUser = User::where('email', $email)->first();
        
        if ($existingUser) {
            if ($this->confirm("משתמש עם האימייל {$email} כבר קיים. האם ברצונך להפוך אותו למנהל?")) {
                $user = $existingUser;
            } else {
                $this->error('הפעולה בוטלה.');
                return;
            }
        } else {
            // יצירת משתמש חדש
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'email_verified_at' => now(),
            ]);
            
            $this->info('משתמש חדש נוצר בהצלחה.');
        }
        
        // יצירת תפקיד admin אם לא קיים
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        
        // הקצאת תפקיד למשתמש
        $user->assignRole('admin');
        
        $this->info("המשתמש {$name} ({$email}) הוגדר כמנהל בהצלחה.");
    }
}