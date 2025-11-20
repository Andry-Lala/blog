<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SessionService
{
    /**
     * Détruire complètement toutes les sessions d'un utilisateur
     *
     * @param int $userId
     * @return void
     */
    public static function destroyAllUserSessions($userId)
    {
        // Supprimer toutes les sessions de cet utilisateur dans la base de données
        DB::table('sessions')
            ->where('user_id', $userId)
            ->delete();

        // Nettoyer également la session courante
        Session::flush();
    }

    /**
     * Vérifier si une session est valide
     *
     * @param string $sessionId
     * @return bool
     */
    public static function isSessionValid($sessionId)
    {
        return DB::table('sessions')
            ->where('id', $sessionId)
            ->where('last_activity', '>', time() - config('session.lifetime', 60) * 60)
            ->exists();
    }

    /**
     * Nettoyer les sessions expirées
     *
     * @return int Nombre de sessions nettoyées
     */
    public static function cleanupExpiredSessions()
    {
        $expiredTime = time() - config('session.lifetime', 60) * 60;

        return DB::table('sessions')
            ->where('last_activity', '<', $expiredTime)
            ->delete();
    }
}
