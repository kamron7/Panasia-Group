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
        Schema::create('news', function (Blueprint $table) {
            $table->id();

            $table->integer('cat_id')->default(0);
            $table->string('group', 255)->default('');
            $table->boolean('status')->default(true);

            $table->json('title')->nullable();
            $table->json('content')->nullable();
            $table->json('short_content')->nullable();
            $table->json('video_code')->nullable();

            $table->json('images')->nullable();

            $table->boolean('options')->default(false);
            $table->string('alias')->nullable();
            $table->text('keywords')->nullable();
            $table->text('description')->nullable();
            $table->integer('views')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
