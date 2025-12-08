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
        // Stocker les clés de traduction plutôt que le texte traduit
        $title = match($action) {
            'created' => 'messages.notification_investment_created',
            'approved' => 'messages.notification_investment_approved',
            'rejected' => 'messages.notification_investment_rejected',
            'processing' => 'messages.notification_investment_processing',
            'default' => 'messages.notification_investment_updated'
        };

        if (!$message) {
            // Stocker la clé et les données pour traduction dynamique
            $message = [
                'key' => match($action) {
                    'created' => 'messages.notification_investment_created_message',
                    'approved' => 'messages.notification_investment_approved_message',
                    'rejected' => 'messages.notification_investment_rejected_message',
                    'processing' => 'messages.notification_investment_processing_message',
                    'default' => 'messages.notification_investment_updated_message'
                },
                'params' => ['amount' => $investment->amount]
            ];
        }

        $type = match($action) {
            'approved' => 'success',
            'rejected' => 'error',
            'processing' => 'warning',
            'created' => 'info',
            'default' => 'info'
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
        // Stocker les clés de traduction plutôt que le texte traduit
        $title = match($action) {
            'verified' => 'messages.notification_user_verified',
            'unverified' => 'messages.notification_user_unverified',
            'registered' => 'messages.notification_new_user_registered',
            'default' => 'messages.notification_user_updated'
        };

        if (!$message) {
            // Stocker la clé et les données pour traduction dynamique
            $message = [
                'key' => match($action) {
                    'verified' => 'messages.notification_user_verified_message',
                    'unverified' => 'messages.notification_user_unverified_message',
                    'registered' => 'messages.notification_new_user_registered_message',
                    'default' => 'messages.notification_user_updated_message'
                },
                'params' => match($action) {
                    'registered' => ['firstName' => $user->prenom, 'lastName' => $user->nom],
                    'default' => []
                }
            ];
        }

        $type = match($action) {
            'verified' => 'success',
            'unverified' => 'warning',
            'registered' => 'info',
            'default' => 'info'
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
