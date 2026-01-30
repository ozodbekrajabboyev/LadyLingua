<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('translator_language', function (Blueprint $table) {
            $table->id();
            $table->foreignId('translator_portfolio_id')
                ->constrained('translator_portfolios')
                ->onDelete('cascade');
            $table->foreignId('available_language_id')
                ->constrained('available_languages')
                ->onDelete('cascade');
            $table->enum('proficiency_level', ['beginner', 'intermediate', 'advanced', 'native'])
                ->default('intermediate');
            $table->timestamps();

            // Prevent duplicate entries
            $table->unique(['translator_portfolio_id', 'available_language_id'], 'translator_lang_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('translator_language');
    }
};
