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
        // Drop the existing jobs table if it exists
        Schema::dropIfExists('jobs');

        // Create new jobs table with proper structure
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();

            // User relationship
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');

            // Company information
            $table->string('company_name');
            $table->string('logo')->nullable();

            // Job details
            $table->string('job_title');
            $table->text('job_description');
            $table->text('requirement');
            $table->string('location');

            // Experience
            $table->integer('experience_minimum')->default(0);
            $table->integer('experience_maximum')->default(0);
            $table->string('experience_unit')->default('years'); // years or months

            // Job classification
            $table->string('role');
            $table->string('industry_type');
            $table->string('employment_type'); // full-time, part-time, contract, etc.

            // Salary information
            $table->integer('salary_minimum')->default(0);
            $table->integer('salary_maximum')->default(0);
            $table->string('salary_currency')->default('USD');

            // Skills and requirements
            $table->text('key_skills')->nullable();

            // Position management
            $table->integer('positions_available')->default(1);
            $table->integer('positions_filled')->default(0);
            $table->boolean('accepting_applications')->default(true);

            // Job status
            $table->boolean('is_active')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->timestamp('expires_at')->nullable();

            // Timestamps
            $table->timestamps();
            $table->softDeletes();

            // Indexes for better performance
            $table->index(['user_id', 'is_active']);
            $table->index('category_id');
            $table->index(['employment_type', 'is_active']);
            $table->index(['location', 'is_active']);
            $table->index(['published_at', 'expires_at']);
            $table->index('accepting_applications');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
