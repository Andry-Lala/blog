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
     * Marquer la notification comme lue
     */
    public function markAsRead(): bool
    {
        return $this->update(['is_read' => true]);
    }

    /**
     * Marquer la notification comme non lue
     */
    public function markAsUnread(): bool
    {
        return $this->update(['is_read' => false]);
    }

    /**
     * Obtenir l'élément lié (polymorphique)
     */
    public function related()
    {
        if (!$this->related_type || !$this->related_id) {
            return null;
        }

        try {
            $class = $this->related_type;
            if (class_exists($class)) {
                return $class::find($this->related_id);
            }
        } catch (\Exception $e) {
            return null;
        }

        return null;
    }

    /**
     * Créer une notification pour un utilisateur
     */
    public static function createForUser($userId, string $title, string $message, string $type = 'info', $relatedType = null, $relatedId = null, array $data = []): self
    {
        return self::create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'related_type' => $relatedType,
            'related_id' => $relatedId,
            'data' => $data,
        ]);
    }

    /**
     * Obtenir les notifications non lues pour un utilisateur
     */
    public static function getUnreadForUser($userId)
    {
        return self::where('user_id', $userId)
            ->where('is_read', false)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Obtenir le nombre de notifications non lues pour un utilisateur
     */
    public static function getUnreadCountForUser($userId): int
    {
        return self::where('user_id', $userId)
            ->where('is_read', false)
            ->count();
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
