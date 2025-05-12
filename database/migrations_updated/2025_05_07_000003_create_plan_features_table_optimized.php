<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Optimized version with:
     * - Added string length limits
     * - Added indexes on filterable fields
     * - Added composite index for ordering and highlighted features
     */
    public function up(): void
    {
        Schema::create('plan_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_id')->constrained()->cascadeOnDelete();
            $table->string('name', 100);
            $table->string('value', 191)->nullable();
            $table->boolean('is_highlighted')->default(false)->index();
            $table->integer('sort_order')->default(0)->index();
            $table->timestamps();
            
            // Add composite index for common filtering
            $table->index(['plan_id', 'is_highlighted']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_features');
    }
};