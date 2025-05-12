<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * This migration adds foreign key constraints that couldn't be added earlier
     * due to table creation order dependencies.
     */
    public function up(): void
    {
        // Add products.plan_id foreign key now that plans table exists
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'plan_id') && 
                Schema::hasTable('plans') && 
                !$this->hasForeignKey('products', 'products_plan_id_foreign')) {
                $table->foreign('plan_id')
                      ->references('id')
                      ->on('plans')
                      ->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if ($this->hasForeignKey('products', 'products_plan_id_foreign')) {
                $table->dropForeign(['plan_id']);
            }
        });
    }
    
    /**
     * Helper method to check if a foreign key exists
     */
    protected function hasForeignKey(string $table, string $foreignKey): bool
    {
        try {
            $schema = \DB::select("SELECT * 
                FROM information_schema.TABLE_CONSTRAINTS 
                WHERE CONSTRAINT_TYPE = 'FOREIGN KEY' 
                AND TABLE_SCHEMA = DATABASE() 
                AND TABLE_NAME = '{$table}' 
                AND CONSTRAINT_NAME = '{$foreignKey}'");
            return !empty($schema);
        } catch (\Exception) {
            return false;
        }
    }
};