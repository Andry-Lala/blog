<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\InvestmentType;
use App\Models\ExchangeRate;

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
        return InvestmentType::getActiveTypes()->pluck('name')->toArray();
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
        return InvestmentType::getInvestmentRanges();
    }

    public static function getMinAmountForType(string $type): ?float
    {
        $investmentType = InvestmentType::where('name', $type)->where('is_active', true)->first();
        if (!$investmentType) {
            return null;
        }

        $amountsInAriary = $investmentType->getAmountsInAriary();
        return $amountsInAriary['min_ariary'];
    }

    public static function getMaxAmountForType(string $type): ?float
    {
        $investmentType = InvestmentType::where('name', $type)->where('is_active', true)->first();
        if (!$investmentType) {
            return null;
        }

        $amountsInAriary = $investmentType->getAmountsInAriary();
        return $amountsInAriary['max_ariary'];
    }

    public static function isValidAmountForType(string $type, float $amount): bool
    {
        $investmentType = InvestmentType::where('name', $type)->where('is_active', true)->first();
        if (!$investmentType) {
            return false;
        }

        return $investmentType->isValidAmount($amount);
    }
}
