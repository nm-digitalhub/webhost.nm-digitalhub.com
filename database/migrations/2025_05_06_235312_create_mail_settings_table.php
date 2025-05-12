<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mail_settings', function (Blueprint $table) {
            $table->id();
            $table->string('driver')->default('smtp');
            $table->string('host')->nullable();
            $table->string('port')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->string('encryption')->nullable();
            $table->string('from_address')->nullable();
            $table->string('from_name')->nullable();
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
        
        // Insert default settings
        DB::table('mail_settings')->insert([
            'driver' => 'smtp',
            'host' => 'smtp.mailtrap.io',
            'port' => '2525',
            'username' => '',
            'password' => '',
            'encryption' => 'tls',
            'from_address' => 'noreply@example.com',
            'from_name' => config('app.name'),
            'is_active' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mail_settings');
    }
};
