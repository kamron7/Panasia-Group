<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 45);
            $table->text('user_agent')->nullable();
            $table->text('referrer')->nullable();
            $table->string('path');
            $table->string('device')->nullable();
            $table->string('platform')->nullable();
            $table->string('browser')->nullable();
            $table->boolean('is_robot')->default(false);
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->timestamps();

            $table->index('created_at');
            $table->index('path');
        });
    }

    public function down()
    {
        Schema::dropIfExists('visits');
    }
};
