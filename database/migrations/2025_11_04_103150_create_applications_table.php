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

            // Applicant Information
            $table->string('full_name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->text('address')->nullable();

            // Application Documents
            $table->string('resume')->nullable(); // Path to resume file
            $table->string('cover_letter')->nullable(); // Path to cover letter file

            // Application Status
            $table->enum('status', [
                'pending',
                'under_review',
                'shortlisted',
                'interview',
                'rejected',
                'accepted'
            ])->default('pending');

            // Additional Information
            $table->text('skills')->nullable(); // JSON or comma separated skills
            $table->integer('experience_years')->nullable();
            $table->text('education')->nullable();
            $table->text('custom_questions')->nullable(); // JSON for custom application questions

            // Timestamps
            $table->timestamps();

            // Indexes for better performance
            $table->index(['job_id', 'status']);
            $table->index(['user_id', 'job_id']);
            $table->index('status');
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
