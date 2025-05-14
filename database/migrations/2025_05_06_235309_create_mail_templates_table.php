<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mail_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('subject');
            $table->text('body');
            $table->json('variables')->nullable();
            $table->string('layout')->default('default');
            $table->string('lang')->default('he');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Insert default welcome template
        DB::table('mail_templates')->insert([
            'name' => 'user_welcome',
            'subject' => 'Welcome to '.config('app.name'),
            'body' => 'Hello {{ name }},

Your account was created successfully.  
Login: {{ email }}  
Password: {{ password }}

Thank you for joining us!',
            'variables' => json_encode(['name', 'email', 'password']),
            'layout' => 'default',
            'lang' => 'en',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert Hebrew version
        DB::table('mail_templates')->insert([
            'name' => 'user_welcome_he',
            'subject' => 'ברוך הבא ל-'.config('app.name'),
            'body' => 'שלום {{ name }},

החשבון שלך נוצר בהצלחה.  
שם משתמש: {{ email }}  
סיסמה: {{ password }}

תודה שהצטרפת אלינו!',
            'variables' => json_encode(['name', 'email', 'password']),
            'layout' => 'default',
            'lang' => 'he',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mail_templates');
    }
};
