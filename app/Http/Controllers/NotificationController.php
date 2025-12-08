<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Afficher la liste des notifications de l'utilisateur
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Optimisation : charger uniquement les champs nécessaires
        // et utiliser eager loading sélectif
        $notifications = $user->notifications()
            ->select(['id', 'user_id', 'title', 'message', 'type', 'is_read', 'related_type', 'related_id', 'created_at'])
            ->when($request->get('unread_only'), function ($query) {
                return $query->where('is_read', false);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Traduire les titres et messages des notifications
        $notifications->getCollection()->transform(function ($notification) {
            $notification->title = $this->translateNotificationText($notification->title);
            $notification->message = $this->translateNotificationText($notification->message);
            return $notification;
        });

        if ($request->ajax()) {
            return view('notifications.partials.notification-list', compact('notifications'))->render();
        }

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Obtenir les notifications non lues pour l'utilisateur connecté
     */
    public function getUnread(Request $request)
    {
        $user = Auth::user();

        // Optimisation : requête directe avec cache pour le compteur
        $unreadCount = cache()->remember(
            "user_unread_notifications_{$user->id}",
            now()->addMinutes(5),
            function () use ($user) {
                return $user->notifications()->where('is_read', false)->count();
            }
        );

        // Optimisation : charger uniquement les champs nécessaires
        $unreadNotifications = $user->notifications()
            ->select(['id', 'title', 'message', 'type', 'created_at'])
            ->where('is_read', false)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($notification) {
                // Traduire les titres et messages si nécessaire
                $notification->title = $this->translateNotificationText($notification->title);
                $notification->message = $this->translateNotificationText($notification->message);
                return $notification;
            });

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'notifications' => $unreadNotifications,
                'count' => $unreadCount
            ]);
        }

        return view('notifications.index', [
            'notifications' => $unreadNotifications
        ]);
    }

    /**
     * Marquer une notification comme lue
     */
    public function markAsRead($id): JsonResponse
    {
        $notification = Notification::where('user_id', Auth::id())
            ->findOrFail($id);

        $notification->markAsRead();

        return response()->json([
            'success' => true,
            'message' => __('messages.notification_marked_as_read'),
            'unread_count' => Notification::getUnreadCountForUser(Auth::id())
        ]);
    }

    /**
     * Marquer toutes les notifications comme lues
     */
    public function markAllAsRead(): JsonResponse
    {
        Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json([
            'success' => true,
            'message' => __('messages.mark_all_read'),
            'unread_count' => 0
        ]);
    }

    /**
     * Supprimer une notification
     */
    public function destroy($id): JsonResponse
    {
        $notification = Notification::where('user_id', Auth::id())
            ->findOrFail($id);

        $notification->delete();

        return response()->json([
            'success' => true,
            'message' => __('messages.notification_deleted'),
            'unread_count' => Notification::getUnreadCountForUser(Auth::id())
        ]);
    }

    /**
     * Obtenir les détails d'une notification
     */
    public function show($id, Request $request)
    {
        $user = Auth::user();

        // Optimisation : charger uniquement les champs nécessaires
        // et utiliser eager loading conditionnel
        $notification = $user->notifications()
            ->select(['id', 'user_id', 'title', 'message', 'type', 'is_read', 'related_type', 'related_id', 'data', 'created_at', 'updated_at'])
            ->when(true, function ($query) {
                // Charger la relation related uniquement si nécessaire
                return $query->with(['related' => function ($query) {
                    $query->select(['id', 'name', 'title']); // Charger uniquement les champs nécessaires
                }]);
            })
            ->findOrFail($id);

        // Marquer comme lue si ce n'est pas déjà le cas (avec optimisation)
        if (!$notification->is_read) {
            $notification->update(['is_read' => true]);

            // Invalider le cache du compteur de notifications non lues
            cache()->forget("user_unread_notifications_{$user->id}");
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'notification' => $notification,
                'unread_count' => cache()->remember(
                    "user_unread_notifications_{$user->id}",
                    now()->addMinutes(5),
                    function () use ($user) {
                        return $user->notifications()->where('is_read', false)->count();
                    }
                )
            ]);
        }

        return view('notifications.show', compact('notification'));
    }

    /**
     * Créer une notification (utilisé par d'autres contrôleurs)
     */
    public static function createNotification($userId, string $title, string $message, string $type = 'info', $relatedType = null, $relatedId = null, array $data = []): Notification
    {
        return Notification::createForUser($userId, $title, $message, $type, $relatedType, $relatedId, $data);
    }

    /**
     * Traduire le texte des notifications si nécessaire
     */
    private function translateNotificationText($text)
    {
        // Toujours essayer de retraduire complètement les notifications existantes
        // pour forcer la traduction selon la langue actuelle

        // Si c'est un tableau avec clé et paramètres (nouveau format)
        if (is_array($text) && isset($text['key'])) {
            return __($text['key'], $text['params'] ?? []);
        }

        // Vérifier si le texte est une clé de traduction
        if (is_string($text) && str_starts_with($text, 'messages.')) {
            return __($text);
        }

        // Pour les anciennes notifications déjà traduites, forcer la retraduction complète
        if (is_string($text) && !str_starts_with($text, 'messages.')) {
            // Essayer de détecter le type de notification et retraduire complètement
            $currentLocale = app()->getLocale();

            // Détecter les patterns communs et retraduire selon la langue
            if (preg_match('/investissement/i', $text)) {
                if (preg_match('/créé|created/i', $text)) {
                    return __('messages.notification_investment_created');
                }
                if (preg_match('/approuvé|approved/i', $text)) {
                    return __('messages.notification_investment_approved');
                }
                if (preg_match('/rejeté|rejected/i', $text)) {
                    return __('messages.notification_investment_rejected');
                }
                if (preg_match('/traitement|processing/i', $text)) {
                    return __('messages.notification_investment_processing');
                }
            }

            if (preg_match('/compte|account/i', $text)) {
                if (preg_match('/vérifié|verified/i', $text)) {
                    return __('messages.notification_user_verified');
                }
                if (preg_match('/non vérifié|unverified/i', $text)) {
                    return __('messages.notification_user_unverified');
                }
                if (preg_match('/inscrit|registered/i', $text)) {
                    return __('messages.notification_new_user_registered');
                }
                if (preg_match('/mise à jour|update/i', $text)) {
                    return __('messages.notification_user_updated');
                }
            }

            // Si aucun pattern détecté, retourner une traduction générique
            return __('messages.notification_investment_updated');
        }

        // Si le texte contient des variables, essayer de traduire
        if (is_string($text) && preg_match('/\{[^}]+\}/', $text)) {
            // Pour les messages avec variables, on retourne le texte tel quel
            // car il a déjà été traduit lors de la création
            return $text;
        }

        return $text;
    }
}
