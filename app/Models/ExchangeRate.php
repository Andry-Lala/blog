<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExchangeRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'currency_from',
        'currency_to',
        'rate',
        'effective_date',
        'is_active',
        'notes',
        'user_id',
    ];

    protected $casts = [
        'rate' => 'decimal:4',
        'effective_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtenir le taux de change actif USD vers MGA
     */
    public static function getCurrentRate(): ?float
    {
        return self::where('currency_from', 'USD')
            ->where('currency_to', 'MGA')
            ->where('is_active', true)
            ->latest('effective_date')
            ->value('rate');
    }

    /**
     * Définir le nouveau taux de change et désactiver l'ancien
     */
    public static function setNewRate(float $rate, int $userId, ?string $notes = null): self
    {
        // Désactiver tous les anciens taux
        self::where('currency_from', 'USD')
            ->where('currency_to', 'MGA')
            ->update(['is_active' => false]);

        // Créer le nouveau taux
        return self::create([
            'currency_from' => 'USD',
            'currency_to' => 'MGA',
            'rate' => $rate,
            'effective_date' => now(),
            'is_active' => true,
            'notes' => $notes,
            'user_id' => $userId,
        ]);
    }
}
