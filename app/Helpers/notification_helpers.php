<?php

if (!function_exists('getNotificationLink')) {
    /**
     * Obtenir le lien vers l'élément lié à une notification
     */
    function getNotificationLink($notification)
    {
        if (!$notification->related_type || !$notification->related_id) {
            return '#';
        }

        switch ($notification->related_type) {
            case 'App\\Models\\Investment':
                return route('investments.show', $notification->related_id);
            case 'App\\Models\\User':
                return route('clients.show', $notification->related_id);
            default:
                return '#';
        }
    }
}

if (!function_exists('createNotificationForInvestment')) {
    /**
     * Créer une notification pour un investissement
     */
    function createNotificationForInvestment($userId, $investment, $action, $message = null)
    {
        $title = match($action) {
            'created' => 'Nouvel investissement créé',
            'approved' => 'Investissement approuvé',
            'rejected' => 'Investissement rejeté',
            'processing' => 'Investissement en cours de traitement',
            default => 'Mise à jour d\'investissement'
        };

        if (!$message) {
            $message = match($action) {
                'created' => "Votre investissement de {$investment->amount} Ar a été créé avec succès.",
                'approved' => "Votre investissement de {$investment->amount} Ar a été approuvé.",
                'rejected' => "Votre investissement de {$investment->amount} Ar a été rejeté.",
                'processing' => "Votre investissement de {$investment->amount} Ar est en cours de traitement.",
                default => "Votre investissement a été mis à jour."
            };
        }

        $type = match($action) {
            'approved' => 'success',
            'rejected' => 'error',
            'processing' => 'warning',
            'created' => 'info',
            default => 'info'
        };

        return \App\Models\Notification::createForUser(
            $userId,
            $title,
            $message,
            $type,
            'App\\Models\\Investment',
            $investment->id
        );
    }
}

if (!function_exists('createNotificationForUser')) {
    /**
     * Créer une notification pour un utilisateur
     */
    function createNotificationForUser($userId, $user, $action, $message = null)
    {
        $title = match($action) {
            'verified' => 'Compte vérifié',
            'unverified' => 'Compte non vérifié',
            'registered' => 'Nouveau client inscrit',
            default => 'Mise à jour du compte'
        };

        if (!$message) {
            $message = match($action) {
                'verified' => 'Votre compte a été vérifié avec succès.',
                'unverified' => 'Votre compte n\'est plus vérifié.',
                'registered' => "Un nouveau client {$user->prenom} {$user->nom} s'est inscrit.",
                default => 'Votre compte a été mis à jour.'
            };
        }

        $type = match($action) {
            'verified' => 'success',
            'unverified' => 'warning',
            'registered' => 'info',
            default => 'info'
        };

        return \App\Models\Notification::createForUser(
            $userId,
            $title,
            $message,
            $type,
            'App\\Models\\User',
            $user->id
        );
    }
}
