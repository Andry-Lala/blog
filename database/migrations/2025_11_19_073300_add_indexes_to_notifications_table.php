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
        Schema::table('notifications', function (Blueprint $table) {
            // Index pour optimiser les requêtes sur les notifications non lues par utilisateur
            $table->index(['user_id', 'is_read', 'created_at'], 'notifications_user_read_created_index');

            // Index pour optimiser les requêtes polymorphiques
            $table->index(['related_type', 'related_id'], 'notifications_related_index');

            // Index pour optimiser le tri par date
            $table->index('created_at', 'notifications_created_at_index');

            // Index pour optimiser les requêtes par type
            $table->index('type', 'notifications_type_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropIndex('notifications_user_read_created_index');
            $table->dropIndex('notifications_related_index');
            $table->dropIndex('notifications_created_at_index');
            $table->dropIndex('notifications_type_index');
        });
    }
};
