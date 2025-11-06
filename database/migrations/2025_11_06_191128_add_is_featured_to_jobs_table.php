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
        Schema::table('jobs', function (Blueprint $table) {
            $table->boolean('is_featured')->default(false)->after('is_active');
            $table->boolean('is_urgent')->default(false)->after('is_featured');
            $table->timestamp('featured_until')->nullable()->after('is_urgent');

            // Index for better performance
            $table->index(['is_featured', 'is_active']);
            $table->index(['is_urgent', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropColumn(['is_featured', 'is_urgent', 'featured_until']);
            $table->dropIndex(['is_featured', 'is_active']);
            $table->dropIndex(['is_urgent', 'is_active']);
        });
    }
};
