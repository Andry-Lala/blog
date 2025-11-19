<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InvestmentType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'min_amount_usd',
        'max_amount_usd',
        'description',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'min_amount_usd' => 'decimal:2',
        'max_amount_usd' => 'decimal:2',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function investments(): HasMany
    {
        return $this->hasMany(Investment::class, 'investment_type', 'name');
    }

    /**
     * Obtenir tous les types d'investissement actifs triés par ordre
     */
    public static function getActiveTypes()
    {
        return self::where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Obtenir les montants en Ariary en fonction du taux de change actuel
     */
    public function getAmountsInAriary(): array
    {
        $rate = ExchangeRate::getCurrentRate() ?? 4484; // Taux par défaut si non défini

        return [
            'min_ariary' => $this->min_amount_usd * $rate,
            'max_ariary' => $this->max_amount_usd ? $this->max_amount_usd * $rate : null,
        ];
    }

    /**
     * Vérifier si un montant est valide pour ce type d'investissement
     */
    public function isValidAmount(float $amount): bool
    {
        $amountsInAriary = $this->getAmountsInAriary();
        $minAmount = $amountsInAriary['min_ariary'];
        $maxAmount = $amountsInAriary['max_ariary'];

        return $amount >= $minAmount && ($maxAmount === null || $amount <= $maxAmount);
    }

    /**
     * Obtenir les plages d'investissement pour tous les types actifs
     */
    public static function getInvestmentRanges(): array
    {
        $ranges = [];
        $types = self::getActiveTypes();

        foreach ($types as $type) {
            $amountsInAriary = $type->getAmountsInAriary();
            $ranges[$type->name] = [
                'min' => $type->min_amount_usd,
                'max' => $type->max_amount_usd,
                'min_ariary' => $amountsInAriary['min_ariary'],
                'max_ariary' => $amountsInAriary['max_ariary'],
            ];
        }

        return $ranges;
    }
}
