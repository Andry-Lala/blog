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
            $table->date('date_naissance')->nullable();
            $table->string('lieu_naissance')->nullable();
            $table->string('nationalite')->nullable();
            $table->string('profession')->nullable();
            $table->string('piece_identite')->nullable();
            $table->string('numero_piece')->nullable();
            $table->date('date_delivrance')->nullable();
            $table->string('lieu_delivrance')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('date_validation')->nullable();
            $table->unsignedBigInteger('valide_par')->nullable();

            $table->foreign('valide_par')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['valide_par']);
            $table->dropColumn([
                'date_naissance',
                'lieu_naissance',
                'nationalite',
                'profession',
                'piece_identite',
                'numero_piece',
                'date_delivrance',
                'lieu_delivrance',
                'notes',
                'date_validation',
                'valide_par',
            ]);
        });
    }
};
