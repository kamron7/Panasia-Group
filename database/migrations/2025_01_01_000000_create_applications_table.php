<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Public project fields
            $t->string('org');
            $t->string('brand');
            $t->unsignedBigInteger('category_id')->nullable()->index();
            $t->string('city')->nullable();
            $t->text('about');
            $t->string('link')->nullable();

            // Contact snapshot (hidden from non-admins)
            $t->string('contact_name');
            $t->string('email');
            $t->string('phone');

            // Statuses
            $t->enum('status', ['draft', 'submitted', 'precheck', 'accepted', 'rejected', 'needs_more'])
                ->default('draft')->index();
            $t->timestamp('submitted_at')->nullable();
            $t->timestamp('reviewed_at')->nullable();
            $t->timestamp('deadline_at')->nullable();

            // Counters / extras
            $t->unsignedInteger('files_count')->default(0);
            $t->unsignedTinyInteger('submit_attempts')->default(0); // how many times user pressed "Отправить"
            $t->boolean('subscribe')->default(true);
            $t->json('meta')->nullable(); // free-form future flags/notes

            // Admin-only notes
            $t->text('admin_notes')->nullable();

            $t->timestamps();
            $t->softDeletes();

            $t->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
