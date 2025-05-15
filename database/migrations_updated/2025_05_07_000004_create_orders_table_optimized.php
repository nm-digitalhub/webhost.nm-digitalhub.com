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
     * - Added string length limits for all string fields
     * - Added indexes on searchable and filterable fields
     * - Added softDeletes for order record management
     * - Added index on status field for common filtering
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('order_number', 50)->unique()->index();
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled', 'refunded', 'failed'])
                ->default('pending')
                ->index();
            $table->decimal('total', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->string('currency', 3)->default('ILS');

            // Billing Information with proper length limits
            $table->string('billing_name', 100)->nullable();
            $table->string('billing_email', 191)->nullable();
            $table->string('billing_phone', 20)->nullable();
            $table->string('billing_address', 191)->nullable();
            $table->string('billing_city', 100)->nullable();
            $table->string('billing_state', 100)->nullable();
            $table->string('billing_zip', 20)->nullable();
            $table->string('billing_country', 2)->nullable();

            $table->text('notes')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Add composite index for common order filtering
            $table->index(['status', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
