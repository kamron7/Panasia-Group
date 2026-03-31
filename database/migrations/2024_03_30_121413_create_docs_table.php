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
        Schema::create('docs', function (Blueprint $table) {
            $table->id();

            $table->string('group', 255);
            $table->integer('cat_id')->default(0);
            $table->string('alias')->nullable();
            $table->json('title')->nullable();
            $table->json('content')->nullable();
            $table->boolean('status')->default(true);
            $table->json('files')->nullable();
            $table->integer('sort_order')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('docs');
    }
};
