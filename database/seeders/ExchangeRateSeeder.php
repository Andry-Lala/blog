<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ExchangeRate;
use App\Models\InvestmentType;

class ExchangeRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer le taux de change initial
        ExchangeRate::create([
            'currency_from' => 'USD',
            'currency_to' => 'MGA',
            'rate' => 4484.0,
            'effective_date' => now(),
            'is_active' => true,
            'notes' => 'Taux de change initial',
        ]);

        // Créer les types d'investissement initiaux
        $investmentTypes = [
            [
                'name' => 'Silver',
                'slug' => 'silver',
                'min_amount_usd' => 50,
                'max_amount_usd' => 499,
                'description' => 'Pack d\'investissement Silver pour les débutants',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Gold',
                'slug' => 'gold',
                'min_amount_usd' => 500,
                'max_amount_usd' => 699,
                'description' => 'Pack d\'investissement Gold pour les investisseurs intermédiaires',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Platinum',
                'slug' => 'platinum',
                'min_amount_usd' => 700,
                'max_amount_usd' => 999,
                'description' => 'Pack d\'investissement Platinum pour les investisseurs expérimentés',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Diamond',
                'slug' => 'diamond',
                'min_amount_usd' => 1000,
                'max_amount_usd' => null,
                'description' => 'Pack d\'investissement Diamond pour les investisseurs premium',
                'is_active' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($investmentTypes as $type) {
            InvestmentType::create($type);
        }
    }
}
