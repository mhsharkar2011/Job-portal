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
        Schema::create('applications', function (Blueprint $table) {
             $table->id();
        $table->foreignId('job_id')->constrained()->onDelete('cascade');
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('full_name');
        $table->string('email');
        $table->string('phone')->nullable();
        $table->integer('experience_years')->nullable();
        $table->text('address')->nullable();
        $table->text('skills')->nullable();
        $table->text('education')->nullable();
        $table->string('resume_path');
        $table->string('cover_letter_path')->nullable();
        $table->enum('status', ['pending', 'reviewed', 'accepted', 'rejected'])->default('pending');
        $table->text('notes')->nullable();
        $table->timestamps();

        // Prevent duplicate applications
        $table->unique(['job_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
