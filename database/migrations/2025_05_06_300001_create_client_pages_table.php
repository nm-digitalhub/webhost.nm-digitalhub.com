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
        Schema::create('client_pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content')->nullable();
            $table->string('layout')->nullable()->default('default');
            $table->enum('visibility', ['public', 'private', 'role_restricted'])->default('private');
            $table->boolean('is_dynamic')->default(true);
            $table->string('status')->default('published');
            $table->json('metadata')->nullable();
            $table->json('role_restrictions')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->boolean('show_in_menu')->default(false);
            $table->integer('menu_position')->default(0);
            $table->string('menu_icon')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_pages');
    }
};