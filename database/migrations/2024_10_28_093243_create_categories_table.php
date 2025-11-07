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
        // Create the categories table if it doesn't exist
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('guard')->nullable();
            $table->string('category_name')->nullable();
            $table->string('category_slug')->nullable();
            $table->string('status')->default(1);
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
