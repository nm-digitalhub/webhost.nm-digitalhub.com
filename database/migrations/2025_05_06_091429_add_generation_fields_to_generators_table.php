<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('generators', function (Blueprint $table) {
            $table->string('namespace')->nullable()->after('description');
            $table->string('extends')->nullable()->after('namespace');
            $table->string('implements')->nullable()->after('extends');
            $table->string('traits')->nullable()->after('implements');
            $table->boolean('fillable')->default(true)->after('traits');
            $table->text('fields')->nullable()->after('fillable');
            $table->boolean('timestamps')->default(true)->after('fields');
            $table->boolean('soft_deletes')->default(false)->after('timestamps');
            $table->text('relations')->nullable()->after('soft_deletes');
            $table->string('group')->nullable()->after('relations');
            $table->string('icon')->nullable()->after('group');
            $table->string('label')->nullable()->after('icon');
            $table->boolean('preview_before_generate')->default(true)->after('label');
            $table->boolean('confirm_overwrite')->default(true)->after('preview_before_generate');
            $table->string('target_path')->nullable()->after('confirm_overwrite');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('generators', function (Blueprint $table) {
            $table->dropColumn([
                'namespace',
                'extends',
                'implements',
                'traits',
                'fillable',
                'fields',
                'timestamps',
                'soft_deletes',
                'relations',
                'group',
                'icon',
                'label',
                'preview_before_generate',
                'confirm_overwrite',
                'target_path',
            ]);
        });
    }
};
