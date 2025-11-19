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
            ->get();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'notifications' => $unreadNotifications,
                'count' => $unreadCount
            ]);
        }

        return view('notifications.index', [
            'notifications' => $unreadNotifications->paginate(10)
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
            'message' => 'Notification marquée comme lue',
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
            'message' => 'Toutes les notifications ont été marquées comme lues',
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
            'message' => 'Notification supprimée',
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
}
