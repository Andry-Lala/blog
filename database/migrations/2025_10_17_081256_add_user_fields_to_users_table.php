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
        Schema::table('users', function (Blueprint $table) {
            $table->string('nom')->nullable();
            $table->string('prenom')->nullable();
            $table->string('code_utilisateur')->unique()->nullable();
            $table->text('adresse')->nullable();
            $table->string('telephone')->nullable();
            $table->string('username')->unique()->nullable();
            $table->enum('role', ['client', 'administrateur'])->default('client');
            $table->boolean('statut')->default(false);

            $table->dropColumn('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'nom',
                'prenom',
                'code_utilisateur',
                'adresse',
                'telephone',
                'username',
                'role',
                'statut',
            ]);
            $table->string('name');
        });
    }
};
