<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('ref')->unique();
            $table->string('pickup');     // club title chosen
            $table->date('pickup_date');
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->unsignedInteger('items_count')->default(0);
            $table->unsignedBigInteger('total')->default(0); // store UZS as integer (no fractions)
            $table->json('items');         // normalized items (see controller)
            $table->string('status')->default('new'); // new|confirmed|cancelled etc.
            $table->timestamps();

            $table->index(['pickup_date', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
