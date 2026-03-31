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
        Schema::create('menu', function (Blueprint $table) {
            $table->id();

            $table->integer('cat_id')->default(0);
            $table->boolean('status')->default(true);
            $table->json('files')->nullable();

            $table->json('title')->nullable();
            $table->json('content')->nullable();
            $table->json('short_content')->nullable();
            $table->integer('sort_order')->default(0);

            $table->string('alias', 255)->nullable();
            $table->string('inner_link', 255)->nullable();
            $table->string('external_link', 255)->nullable();
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
        Schema::dropIfExists('menu');
    }
};
