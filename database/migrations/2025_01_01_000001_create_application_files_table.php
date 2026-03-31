<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('application_files', function (Blueprint $t) {
            $t->id();
            $t->foreignId('application_id')->constrained()->cascadeOnDelete();
            $t->foreignId('uploaded_by')->constrained('users')->cascadeOnDelete();

            $t->string('original_name');
            $t->string('stored_name');
            $t->string('mime')->nullable();
            $t->unsignedBigInteger('size')->default(0);
            $t->string('disk')->default('public');
            $t->string('path'); // storage path (without disk)
            $t->timestamps();

            $t->index(['application_id','created_at']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('application_files');
    }
};

