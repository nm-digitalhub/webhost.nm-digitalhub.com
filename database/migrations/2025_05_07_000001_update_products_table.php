<?php

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
        Schema::table('products', function (Blueprint $table) {
            // Only add columns that don't exist yet
            if (!Schema::hasColumn('products', 'type')) {
                $table->enum('type', ['hosting', 'domain', 'vps', 'addon', 'service'])->default('hosting');
            }

            if (!Schema::hasColumn('products', 'is_active')) {
                $table->boolean('is_active')->default(true);
            }

            if (!Schema::hasColumn('products', 'is_featured')) {
                $table->boolean('is_featured')->default(false);
            }

            if (!Schema::hasColumn('products', 'image')) {
                $table->string('image')->nullable();
            }

            if (!Schema::hasColumn('products', 'metadata')) {
                $table->json('metadata')->nullable();
            }

            if (!Schema::hasColumn('products', 'deleted_at')) {
                $table->softDeletes();
            }

            // We'll skip the foreign key constraint since plans table will be created later
            // It will be handled by our optimization migration
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Only drop columns we added
            $columnsToCheck = [
                'type', 'is_active', 'is_featured', 'image', 'metadata', 'deleted_at'
            ];
            
            $columnsToDrop = [];
            foreach ($columnsToCheck as $column) {
                if (Schema::hasColumn('products', $column)) {
                    $columnsToDrop[] = $column;
                }
            }
            
            if ($columnsToDrop !== []) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};