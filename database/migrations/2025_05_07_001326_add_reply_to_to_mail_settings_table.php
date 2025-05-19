<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('mail_settings', function (Blueprint $table) {
            $table->string('reply_to_address')->nullable()->after('from_name');
            $table->string('reply_to_name')->nullable()->after('reply_to_address');
            $table->boolean('use_no_reply')->default(false)->after('reply_to_name');
            $table->string('default_language')->default('he')->after('use_no_reply');
            $table->string('signature')->nullable()->after('default_language');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mail_settings', function (Blueprint $table) {
            $table->dropColumn([
                'reply_to_address',
                'reply_to_name',
                'use_no_reply',
                'default_language',
                'signature',
            ]);
        });
    }
};
