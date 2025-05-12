<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;

class CreateAdminUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create {--interactive}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user with administrator privileges through an interactive questionnaire';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('==========================================');
        $this->info('   Create Administrator User - Questionnaire   ');
        $this->info('==========================================');
        
        // Determine if we should run in interactive mode
        $interactive = $this->option('interactive') || $this->confirm('Would you like to run in interactive mode?', true);
        
        if ($interactive) {
            return $this->runInteractiveQuestionnaire();
        } else {
            return $this->promptForRequiredFields();
        }
    }
    
    /**
     * Run the interactive questionnaire with detailed explanations
     */
    protected function runInteractiveQuestionnaire()
    {
        $this->info("\n💼 Welcome to the Administrator Creation Wizard");
        $this->info("This wizard will guide you through creating a new admin user with full system access.\n");
        
        // Step 1: User details
        $this->info("📝 Step 1: Basic Information");
        $this->line("First, we'll need some basic information about the new administrator.");
        
        $name = $this->askWithValidation('Full Name', ['required', 'string', 'max:255'], 
            'Please provide the administrator\'s full name (e.g., "John Smith")');
            
        $email = $this->askWithValidation('Email Address', ['required', 'string', 'email', 'max:255', 'unique:users,email'], 
            'Enter a valid and unique email address for the administrator');
            
        $password = $this->secretWithValidation('Password', [
                'required', 
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],
            'Create a strong password (min 8 chars, mixed case, numbers, symbols)'
        );
        
        $confirmPassword = $this->secret('Confirm Password');
        
        if ($password !== $confirmPassword) {
            $this->error('Passwords do not match!');
            return 1;
        }
        
        // Step 2: Role selection
        $this->info("\n👑 Step 2: Administrative Role");
        $this->line("Next, let's select which type of administrator access to grant.");
        
        // Get available roles from the database
        $availableRoles = Role::pluck('name')->toArray();
        
        // Make sure 'admin' role exists
        if (!in_array('admin', $availableRoles)) {
            $availableRoles[] = 'admin';
        }
        
        // Ensure 'Super-Admin' role exists
        if (!in_array('Super-Admin', $availableRoles)) {
            $availableRoles[] = 'Super-Admin';
        }
        
        $role = $this->choice(
            'Select the administrative role to assign',
            $availableRoles,
            in_array('admin', $availableRoles) ? 'admin' : 0
        );
        
        // Step 3: Review & Confirm
        $this->info("\n🔍 Step 3: Review Information");
        $this->line("Please review the administrator information below:");
        
        $this->table(
            ['Field', 'Value'],
            [
                ['Name', $name],
                ['Email', $email],
                ['Password', '********'],
                ['Role', $role],
            ]
        );
        
        if (!$this->confirm('Is the information correct? Create this administrator?', true)) {
            $this->info('Administrator creation cancelled.');
            return 0;
        }
        
        // Create the user
        return $this->createAdminUser($name, $email, $password, $role);
    }
    
    /**
     * Simplified flow with just required fields
     */
    protected function promptForRequiredFields()
    {
        $name = $this->ask('Name');
        $email = $this->ask('Email');
        $password = $this->secret('Password');
        $role = $this->choice('Role', ['admin', 'Super-Admin'], 'admin');
        
        return $this->createAdminUser($name, $email, $password, $role);
    }
    
    /**
     * Create the admin user in the database
     */
    protected function createAdminUser($name, $email, $password, $role)
    {
        try {
            // Create or find the specified role
            Role::firstOrCreate(['name' => $role]);
            
            // Create the user
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'is_admin' => true, // Set the is_admin flag
            ]);
            
            // Assign the role
            $user->assignRole($role);
            
            $this->info("\n✅ Administrator Created Successfully!");
            $this->line("Name: $name");
            $this->line("Email: $email");
            $this->line("Role: $role");
            $this->line("\nThe administrator can now log in at " . config('app.url') . "/admin");
            
            return 0;
        } catch (\Exception $e) {
            $this->error("\n❌ Error creating administrator: " . $e->getMessage());
            return 1;
        }
    }
    
    /**
     * Ask a question with validation
     */
    protected function askWithValidation($question, $rules, $help = null)
    {
        if ($help) {
            $this->line("  <fg=gray>$help</>");
        }
        
        $value = $this->ask($question);
        
        $validator = Validator::make(['value' => $value], [
            'value' => $rules
        ]);
        
        if ($validator->fails()) {
            $this->error($validator->errors()->first('value'));
            return $this->askWithValidation($question, $rules, $help);
        }
        
        return $value;
    }
    
    /**
     * Ask for a secret with validation
     */
    protected function secretWithValidation($question, $rules, $help = null)
    {
        if ($help) {
            $this->line("  <fg=gray>$help</>");
        }
        
        $value = $this->secret($question);
        
        $validator = Validator::make(['value' => $value], [
            'value' => $rules
        ]);
        
        if ($validator->fails()) {
            $this->error($validator->errors()->first('value'));
            return $this->secretWithValidation($question, $rules, $help);
        }
        
        return $value;
    }
}