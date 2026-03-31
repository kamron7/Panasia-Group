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
        Schema::create('video', function (Blueprint $table) {
            $table->id();

            $table->json('title')->nullable();
            $table->boolean('status')->default(true);

            $table->json('files')->nullable();
            $table->string('img', 255)->nullable();
            $table->tinyInteger('type')->default(0);
            $table->json('code')->nullable();
            $table->json('content')->nullable();
            $table->integer('sort_order')->default(0);
            $table->string('alias', 255)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video');
    }
};
