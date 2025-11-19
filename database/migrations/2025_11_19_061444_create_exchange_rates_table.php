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
        Schema::create('exchange_rates', function (Blueprint $table) {
            $table->id();
            $table->string('currency_from', 3)->default('USD'); // Devise source
            $table->string('currency_to', 3)->default('MGA'); // Devise cible (Ariary)
            $table->decimal('rate', 10, 4); // Taux de change avec 4 décimales
            $table->date('effective_date'); // Date d'effet du taux
            $table->boolean('is_active')->default(true); // Si ce taux est actuellement actif
            $table->text('notes')->nullable(); // Notes sur le taux
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // Admin qui a modifié le taux
            $table->timestamps();

            $table->index(['currency_from', 'currency_to', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exchange_rates');
    }
};
