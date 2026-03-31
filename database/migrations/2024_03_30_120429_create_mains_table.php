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
        Schema::create('main', function (Blueprint $table) {
            $table->id();

            $table->integer('cat_id')->default(0);
            $table->json('files')->nullable();
            $table->string('group', 255);
            $table->boolean('status')->default(true);

            $table->json('title')->nullable();
            $table->json('content')->nullable();
            $table->json('short_content')->nullable();

            $table->string('alias', 255)->nullable();
            $table->text('keywords')->nullable();
            $table->text('description')->nullable();
            $table->string('options', 255)->nullable();
            $table->string('options2', 255)->nullable();

            $table->integer('sort_order')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('main');
    }
};
