<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // צור משתמש admin אם לא קיים
        $adminEmail = 'admin@nm-digitalhub.com';

        $existingAdmin = DB::table('users')->where('email', $adminEmail)->first();
        if (! $existingAdmin) {
            $userId = DB::table('users')->insertGetId([
                'name' => 'Admin',
                'email' => $adminEmail,
                'password' => Hash::make('password'), // מומלץ לשנות זאת
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $userId = $existingAdmin->id;
        }

        // צור תפקיד admin אם לא קיים
        $role = DB::table('roles')->where('name', 'admin')->first();
        if (! $role) {
            $roleId = DB::table('roles')->insertGetId([
                'name' => 'admin',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $roleId = $role->id;
        }

        // שייך את המשתמש לתפקיד אם עדיין לא משויך
        $alreadyLinked = DB::table('model_has_roles')->where([
            ['role_id', '=', $roleId],
            ['model_type', '=', \App\Models\User::class],
            ['model_id', '=', $userId],
        ])->exists();

        if (! $alreadyLinked) {
            DB::table('model_has_roles')->insert([
                'role_id' => $roleId,
                'model_type' => \App\Models\User::class,
                'model_id' => $userId,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // לא מוחקים משתמש admin או תפקיד admin לצורכי בטיחות
    }
};
