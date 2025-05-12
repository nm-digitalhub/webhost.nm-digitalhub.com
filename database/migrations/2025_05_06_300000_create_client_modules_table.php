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
        Schema::create('client_modules', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('icon')->nullable();
            $table->boolean('enabled')->default(true);
            $table->integer('position')->default(0);
            $table->enum('type', ['section', 'page', 'link'])->default('page');
            $table->string('layout')->nullable();
            $table->string('route_name')->nullable();
            $table->string('component_class')->nullable();
            $table->string('description')->nullable();
            $table->json('metadata')->nullable();
            $table->json('role_restrictions')->nullable();
            $table->json('permissions')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_modules');
    }
};