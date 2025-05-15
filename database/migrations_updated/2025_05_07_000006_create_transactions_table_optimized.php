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
     * - Added string length limits
     * - Added indexes on searchable fields (transaction_id, status)
     * - Added softDeletes for financial record keeping
     * - Added composite index for common filtering patterns
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->string('transaction_id', 100)->nullable()->index();
            $table->string('provider', 50); // Payment gateway provider (e.g., cardcom, tranzila, pelecard)
            $table->string('method', 30)->default('credit_card'); // Payment method
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('ILS');
            $table->enum('status', ['pending', 'completed', 'failed', 'refunded', 'cancelled'])
                ->default('pending')
                ->index();
            $table->text('error_message')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes(); // Add softDeletes for financial record keeping

            // Add composite index for common filtering patterns
            $table->index(['status', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
