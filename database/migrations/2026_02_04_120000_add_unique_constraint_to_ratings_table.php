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
        Schema::table('ratings', function (Blueprint $table) {
            // Add unique constraint to prevent duplicate ratings
            $table->unique(['user_id', 'translation_id'], 'unique_user_translation_rating');

            // Add performance indexes
            $table->index(['translation_id', 'created_at'], 'idx_translation_created');
            $table->index(['stars'], 'idx_stars');

            // Add validation constraints
            $table->integer('stars')->change()->comment('Rating from 1 to 5 stars');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ratings', function (Blueprint $table) {
            $table->dropUnique('unique_user_translation_rating');
            $table->dropIndex('idx_translation_created');
            $table->dropIndex('idx_stars');
        });
    }
};
