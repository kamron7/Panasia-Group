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
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();

            $table->string('fio'); // Full name
            $table->string('phone'); // Phone number
            $table->text('message'); // Message

            // Optional fields
            $table->string('email')->nullable();   // Email
            $table->string('address')->nullable(); // Address
            $table->string('file')->nullable();    // Uploaded file path

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
