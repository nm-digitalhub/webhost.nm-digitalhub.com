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
        Schema::create('generators', function (Blueprint $table) {
            $table->id();

            // שם המחולל
            $table->string('name')->unique();

            // סוג הקובץ שיווצר (model, resource, page, widget)
            $table->enum('type', ['model', 'resource', 'page', 'widget']);

            // תיאור חופשי
            $table->text('description')->nullable();

            // חותמות זמן
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('generators');
    }
};
