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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('employer_id')->constrained('users')->onDelete('cascade');
            // Relationships
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('company_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');

            // Job details
            $table->string('job_title');
            $table->text('job_description');
            $table->text('requirement');
            $table->string('location');

            // Experience
            $table->integer('experience_minimum')->default(0);
            $table->integer('experience_maximum')->default(0);
            $table->enum('experience_unit', ['years', 'months'])->default('years');

            // Job classification
            $table->string('role');
            $table->enum('employment_type', ['full-time', 'part-time', 'contract', 'freelance', 'internship']);

            // Salary information
            $table->integer('salary_minimum')->default(0);
            $table->integer('salary_maximum')->default(0);
            $table->enum('salary_currency', ['BDT', 'USD', 'EUR', 'GBP'])->default('BDT');

            // Skills and requirements
            $table->text('key_skills')->nullable();

            // Position management
            $table->integer('positions_available')->default(1);
            $table->integer('positions_filled')->default(0);
            $table->boolean('accepting_applications')->default(true);

            // Job status
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_urgent')->default(false);
            $table->timestamp('featured_until')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('application_deadline')->nullable();

            // Timestamps
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index(['user_id', 'is_active']);
            $table->index('company_id');
            $table->index('category_id');
            $table->index(['employment_type', 'is_active']);
            $table->index(['location', 'is_active']);
            $table->index(['published_at', 'expires_at']);
            $table->index('accepting_applications');
            $table->index('application_deadline');
            $table->index(['is_featured', 'is_active']);
            $table->index(['is_urgent', 'is_active']);
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
