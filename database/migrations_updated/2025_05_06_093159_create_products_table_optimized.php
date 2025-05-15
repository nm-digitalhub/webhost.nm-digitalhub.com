<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * Optimized version with:
     * - Consolidated both product migrations
     * - Added string length limits
     * - Added indexes on searchable and filterable fields
     * - Properly implemented softDeletes (already in original)
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 100)->unique();
            $table->text('description')->nullable();
            $table->string('short_description', 191)->nullable();
            $table->string('sku', 50)->nullable()->index();
            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->string('currency', 3)->default('ILS');
            $table->foreignId('plan_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('type', ['hosting', 'domain', 'vps', 'addon', 'service'])->default('hosting')->index();
            $table->boolean('is_active')->default(true)->index();
            $table->boolean('is_featured')->default(false)->index();
            $table->string('image', 191)->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Add useful composite index for common filtering patterns
            $table->index(['is_active', 'type', 'is_featured']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
