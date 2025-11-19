<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'message',
        'type',
        'is_read',
        'related_type',
        'related_id',
        'data',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'data' => 'array',
    ];

    /**
     * Obtenir l'utilisateur propriétaire de la notification
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Marquer la notification comme lue (avec invalidation de cache)
     */
    public function markAsRead(): bool
    {
        $result = $this->update(['is_read' => true]);

        // Invalider le cache du compteur de notifications non lues
        if ($result) {
            cache()->forget("user_unread_notifications_{$this->user_id}");
        }

        return $result;
    }

    /**
     * Marquer la notification comme non lue (avec invalidation de cache)
     */
    public function markAsUnread(): bool
    {
        $result = $this->update(['is_read' => false]);

        // Invalider le cache du compteur de notifications non lues
        if ($result) {
            cache()->forget("user_unread_notifications_{$this->user_id}");
        }

        return $result;
    }

    /**
     * Obtenir l'élément lié (polymorphique)
     */
    public function related()
    {
        return $this->morphTo('related', 'related_type', 'related_id');
    }

    /**
     * Créer une notification pour un utilisateur (avec invalidation de cache)
     */
    public static function createForUser($userId, string $title, string $message, string $type = 'info', $relatedType = null, $relatedId = null, array $data = []): self
    {
        $notification = self::create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'related_type' => $relatedType,
            'related_id' => $relatedId,
            'data' => $data,
        ]);

        // Invalider le cache du compteur de notifications non lues
        cache()->forget("user_unread_notifications_{$userId}");

        return $notification;
    }

    /**
     * Obtenir les notifications non lues pour un utilisateur (optimisé)
     */
    public static function getUnreadForUser($userId, $limit = null)
    {
        $query = self::where('user_id', $userId)
            ->where('is_read', false)
            ->select(['id', 'title', 'message', 'type', 'related_type', 'related_id', 'created_at'])
            ->orderBy('created_at', 'desc');

        if ($limit) {
            $query->limit($limit);
        }

        return $query->get();
    }

    /**
     * Obtenir le nombre de notifications non lues pour un utilisateur (avec cache)
     */
    public static function getUnreadCountForUser($userId): int
    {
        return cache()->remember(
            "user_unread_notifications_{$userId}",
            now()->addMinutes(5),
            function () use ($userId) {
                return self::where('user_id', $userId)
                    ->where('is_read', false)
                    ->count();
            }
        );
    }

    /**
     * Obtenir l'icône en fonction du type de notification
     */
    public function getIconAttribute(): string
    {
        return match($this->type) {
            'success' => 'fas fa-check-circle text-green-500',
            'error' => 'fas fa-exclamation-circle text-red-500',
            'warning' => 'fas fa-exclamation-triangle text-yellow-500',
            'info' => 'fas fa-info-circle text-blue-500',
            default => 'fas fa-bell text-gray-500',
        };
    }

    /**
     * Obtenir la couleur de fond en fonction du type de notification
     */
    public function getBgColorAttribute(): string
    {
        return match($this->type) {
            'success' => 'bg-green-50 border-green-200 dark:bg-green-900/20 dark:border-green-800',
            'error' => 'bg-red-50 border-red-200 dark:bg-red-900/20 dark:border-red-800',
            'warning' => 'bg-yellow-50 border-yellow-200 dark:bg-yellow-900/20 dark:border-yellow-800',
            'info' => 'bg-blue-50 border-blue-200 dark:bg-blue-900/20 dark:border-blue-800',
            default => 'bg-gray-50 border-gray-200 dark:bg-gray-900/20 dark:border-gray-800',
        };
    }
}
