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
            'created' => __('messages.notification_investment_created'),
            'approved' => __('messages.notification_investment_approved'),
            'rejected' => __('messages.notification_investment_rejected'),
            'processing' => __('messages.notification_investment_processing'),
            default => __('messages.notification_investment_updated')
        };

        if (!$message) {
            $message = match($action) {
                'created' => __('messages.notification_investment_created_message', ['amount' => $investment->amount]),
                'approved' => __('messages.notification_investment_approved_message', ['amount' => $investment->amount]),
                'rejected' => __('messages.notification_investment_rejected_message', ['amount' => $investment->amount]),
                'processing' => __('messages.notification_investment_processing_message', ['amount' => $investment->amount]),
                default => __('messages.notification_investment_updated_message')
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
            'verified' => __('messages.notification_user_verified'),
            'unverified' => __('messages.notification_user_unverified'),
            'registered' => __('messages.notification_new_user_registered'),
            default => __('messages.notification_user_updated')
        };

        if (!$message) {
            $message = match($action) {
                'verified' => __('messages.notification_user_verified_message'),
                'unverified' => __('messages.notification_user_unverified_message'),
                'registered' => __('messages.notification_new_user_registered_message', ['firstName' => $user->prenom, 'lastName' => $user->nom]),
                default => __('messages.notification_user_updated_message')
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
