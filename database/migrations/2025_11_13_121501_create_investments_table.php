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
        Schema::create('investments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('operator'); // Orange, Yas, Airtel
            $table->string('investment_type'); // Lite, Premium, Gold
            $table->string('last_name');
            $table->string('first_name');
            $table->text('address');
            $table->string('phone');
            $table->string('id_number'); // CIN or Passeport
            $table->string('id_photo'); // file path
            $table->string('transaction_phone');
            $table->decimal('amount', 10, 2);
            $table->string('transaction_proof'); // file path
            $table->string('status')->default('Envoyé'); // Envoyé, En cours de traitement, Validé, Rejeté
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investments');
    }
};
