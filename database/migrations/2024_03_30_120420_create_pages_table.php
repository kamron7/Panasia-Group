<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();

            $table->json('files')->nullable();
            $table->boolean('status')->default(true);

            $table->json('title')->nullable();
            $table->json('content')->nullable();
            $table->json('short_content')->nullable();
            $table->json('html_content')->nullable();

            $table->string('options', 255)->nullable();

            $table->timestamps();
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
