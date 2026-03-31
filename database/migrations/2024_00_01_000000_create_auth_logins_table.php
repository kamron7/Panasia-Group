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
        Schema::create('auth_logins', function (Blueprint $table) {
            $table->id();

            $table->integer('attempt')->default(0);
            $table->string('ip_address');

            $table->boolean('ban')->default(false);
            $table->timestamp('ban_time')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auth_logins');
    }
};
