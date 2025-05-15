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
     * - Consolidated both page-related migrations
     * - Added string length limits
     * - Added indexes on searchable and filterable fields
     * - SoftDeletes already properly implemented
     * - Added composite indexes for common filtering patterns
     */
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->string('slug', 100)->unique();
            $table->string('type', 50)->default('standard')->index();
            $table->string('language', 5)->default('en')->index();
            $table->longText('content')->nullable();
            $table->string('meta_title', 100)->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords', 191)->nullable();
            $table->boolean('is_published')->default(false)->index();
            $table->string('layout', 50)->default('default');
            $table->integer('order')->default(0)->index();
            $table->string('featured_image', 191)->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('pages')->nullOnDelete();
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Add composite index for common filtering patterns
            $table->index(['is_published', 'language', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
