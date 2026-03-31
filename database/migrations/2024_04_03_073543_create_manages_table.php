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
        Schema::create('manages', function (Blueprint $table) {
            $table->id();

            $table->integer('cat_id')->default(0);
            $table->string('group', 255);
            $table->json('title')->nullable();
            $table->json('post')->nullable();
            $table->json('reception')->nullable();
            $table->string('phone', 25)->nullable();
            $table->boolean('status')->default(true);
            $table->json('images')->nullable();
            $table->string('alias')->nullable();
            $table->integer('sort_order')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manages');
    }
};
