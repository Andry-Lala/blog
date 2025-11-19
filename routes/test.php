<?php

use Illuminate\Support\Facades\Route;

Route::get('/test-notification', function () {
    $user = \App\Models\User::find(1);

    if ($user) {
        $notification = \App\Models\Notification::createForUser(
            $user->id,
            'Test de notification',
            'Ceci est une notification de test pour diagnostiquer le problème.',
            'info'
        );

        return response()->json([
            'success' => true,
            'notification_id' => $notification->id,
            'message' => 'Notification de test créée avec succès'
        ]);
    } else {
        return response()->json([
            'success' => false,
            'message' => 'Utilisateur avec ID 1 non trouvé'
        ]);
    }
});
