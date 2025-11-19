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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('message');
            $table->string('type')->default('info'); // info, success, warning, error
            $table->boolean('is_read')->default(false);
            $table->string('related_type')->nullable(); // investment, client, etc.
            $table->unsignedBigInteger('related_id')->nullable(); // ID de l'élément lié
            $table->json('data')->nullable(); // Données supplémentaires en JSON
            $table->timestamps();

            $table->index(['user_id', 'is_read']);
            $table->index(['related_type', 'related_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
