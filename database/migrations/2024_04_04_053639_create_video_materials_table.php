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
        Schema::create('video_materials', function (Blueprint $table) {
            $table->id();

            $table->boolean('status')->default(true);
            $table->string('group');

            $table->json('title')->nullable();
            $table->json('content')->nullable();
            $table->json('video_code')->nullable();

            $table->json('images')->nullable();
            $table->string('img')->nullable();

            $table->string('alias')->nullable();
            $table->text('keywords')->nullable();
            $table->text('description')->nullable();
            $table->integer('views')->default(0);

            $table->integer('sort_order')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_materials');
    }
};
