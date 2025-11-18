<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Investment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'operator',
        'investment_type',
        'last_name',
        'first_name',
        'address',
        'phone',
        'id_number',
        'id_photo',
        'transaction_phone',
        'amount',
        'transaction_proof',
        'status',
        'admin_notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function getOperators(): array
    {
        return ['Orange', 'Yas', 'Airtel'];
    }

    public static function getInvestmentTypes(): array
    {
        return ['Silver', 'Gold', 'Platinum', 'Diamond'];
    }

    public static function getOperatorPhone(string $operator): string
    {
        return match ($operator) {
            'Orange' => '+261 32 30 793 54',
            'Yas' => '+261 38 27 114 48',
            'Airtel' => '+261 33 93 070 74',
            default => '',
        };
    }

    public static function getStatuses(): array
    {
        return ['Envoyé', 'En cours de traitement', 'Validé', 'Rejeté'];
    }

    public static function getInvestmentRanges(): array
    {
        return [
            'Silver' => [
                'min' => 50,
                'max' => 499,
                'min_ariary' => 224200,
                'max_ariary' => 2237200
            ],
            'Gold' => [
                'min' => 500,
                'max' => 699,
                'min_ariary' => 2241700,
                'max_ariary' => 3133800
            ],
            'Platinum' => [
                'min' => 700,
                'max' => 999,
                'min_ariary' => 3138300,
                'max_ariary' => 4478800
            ],
            'Diamond' => [
                'min' => 1000,
                'max' => null,
                'min_ariary' => 4483000,
                'max_ariary' => null
            ]
        ];
    }

    public static function getMinAmountForType(string $type): ?float
    {
        $ranges = self::getInvestmentRanges();
        return $ranges[$type]['min_ariary'] ?? null;
    }

    public static function getMaxAmountForType(string $type): ?float
    {
        $ranges = self::getInvestmentRanges();
        return $ranges[$type]['max_ariary'] ?? null;
    }

    public static function isValidAmountForType(string $type, float $amount): bool
    {
        $ranges = self::getInvestmentRanges();
        if (!isset($ranges[$type])) {
            return false;
        }

        $minAmount = $ranges[$type]['min_ariary'];
        $maxAmount = $ranges[$type]['max_ariary'];

        return $amount >= $minAmount && ($maxAmount === null || $amount <= $maxAmount);
    }
}
