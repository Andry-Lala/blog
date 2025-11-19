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
        $notifications = $user->notifications()
            ->with(['related'])
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
    public function getUnread(): JsonResponse
    {
        $user = Auth::user();
        $unreadNotifications = Notification::getUnreadForUser($user->id);
        $unreadCount = Notification::getUnreadCountForUser($user->id);

        return response()->json([
            'notifications' => $unreadNotifications,
            'count' => $unreadCount
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
    public function show($id): JsonResponse
    {
        $notification = Notification::where('user_id', Auth::id())
            ->with(['related'])
            ->findOrFail($id);

        // Marquer comme lue si ce n'est pas déjà le cas
        if (!$notification->is_read) {
            $notification->markAsRead();
        }

        return response()->json([
            'notification' => $notification,
            'unread_count' => Notification::getUnreadCountForUser(Auth::id())
        ]);
    }

    /**
     * Créer une notification (utilisé par d'autres contrôleurs)
     */
    public static function createNotification($userId, string $title, string $message, string $type = 'info', $relatedType = null, $relatedId = null, array $data = []): Notification
    {
        return Notification::createForUser($userId, $title, $message, $type, $relatedType, $relatedId, $data);
    }
}
