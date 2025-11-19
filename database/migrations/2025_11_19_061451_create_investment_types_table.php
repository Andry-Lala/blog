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
        Schema::create('investment_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nom du type (Silver, Gold, Platinum, Diamond)
            $table->string('slug')->unique(); // Slug pour l'URL
            $table->decimal('min_amount_usd', 10, 2); // Montant minimum en USD
            $table->decimal('max_amount_usd', 10, 2)->nullable(); // Montant maximum en USD (nullable pour illimité)
            $table->text('description')->nullable(); // Description du type d'investissement
            $table->boolean('is_active')->default(true); // Si ce type est actif
            $table->integer('sort_order')->default(0); // Ordre d'affichage
            $table->timestamps();

            $table->index(['is_active', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investment_types');
    }
};
