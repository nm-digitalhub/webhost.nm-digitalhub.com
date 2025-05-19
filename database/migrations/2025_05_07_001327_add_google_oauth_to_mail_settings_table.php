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
            $table->boolean('oauth_mode_enabled')->default(false)->after('is_active');
            $table->string('google_client_id')->nullable()->after('oauth_mode_enabled');
            $table->string('google_client_secret')->nullable()->after('google_client_id');
            $table->string('google_redirect_uri')->nullable()->after('google_client_secret');
            $table->string('google_json_path')->nullable()->after('google_redirect_uri');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mail_settings', function (Blueprint $table) {
            $table->dropColumn([
                'oauth_mode_enabled',
                'google_client_id',
                'google_client_secret',
                'google_redirect_uri',
                'google_json_path',
            ]);
        });
    }
};
