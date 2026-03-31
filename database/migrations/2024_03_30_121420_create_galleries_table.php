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
        Schema::create('gallery', function (Blueprint $table) {
            $table->id();

            $table->json('title')->nullable();
            $table->json('content')->nullable();
            $table->boolean('status')->default(true);
            $table->json('images')->nullable();
            $table->string('alias')->nullable();
            $table->integer('sort_order')->default(0);
            $table->text('keywords')->nullable();
            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gallery');
    }
};
