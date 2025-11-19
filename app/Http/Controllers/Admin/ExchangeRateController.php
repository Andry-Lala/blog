<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExchangeRate;
use App\Models\InvestmentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExchangeRateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Afficher le tableau de bord des taux de change et types d'investissement
     */
    public function index()
    {
        $currentRate = ExchangeRate::getCurrentRate();
        $exchangeRates = ExchangeRate::with('user')
            ->orderBy('effective_date', 'desc')
            ->paginate(10);

        $investmentTypes = InvestmentType::orderBy('sort_order')->get();

        return view('admin.exchange-rates.index', compact('currentRate', 'exchangeRates', 'investmentTypes'));
    }

    /**
     * Mettre à jour le taux de change
     */
    public function updateRate(Request $request)
    {
        $request->validate([
            'rate' => 'required|numeric|min:0.0001|max:99999.9999',
            'notes' => 'nullable|string|max:500',
        ]);

        $newRate = ExchangeRate::setNewRate(
            $request->rate,
            Auth::id(),
            $request->notes
        );

        return redirect()->route('admin.exchange-rates.index')
            ->with('success', 'Le taux de change a été mis à jour avec succès.');
    }

    /**
     * Mettre à jour un type d'investissement
     */
    public function updateInvestmentType(Request $request, InvestmentType $investmentType)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'min_amount_usd' => 'required|numeric|min:0.01',
            'max_amount_usd' => 'nullable|numeric|min:0.01',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        // Vérifier que max_amount_usd est supérieur à min_amount_usd si fourni
        if ($request->filled('max_amount_usd') && $request->max_amount_usd <= $request->min_amount_usd) {
            return redirect()->back()
                ->withErrors(['max_amount_usd' => 'Le montant maximum doit être supérieur au montant minimum.'])
                ->withInput();
        }

        $investmentType->update($request->all());

        return redirect()->route('admin.exchange-rates.index')
            ->with('success', 'Le type d\'investissement a été mis à jour avec succès.');
    }

    /**
     * Créer un nouveau type d'investissement
     */
    public function storeInvestmentType(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:investment_types,slug',
            'min_amount_usd' => 'required|numeric|min:0.01',
            'max_amount_usd' => 'nullable|numeric|min:0.01',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        // Vérifier que max_amount_usd est supérieur à min_amount_usd si fourni
        if ($request->filled('max_amount_usd') && $request->max_amount_usd <= $request->min_amount_usd) {
            return redirect()->back()
                ->withErrors(['max_amount_usd' => 'Le montant maximum doit être supérieur au montant minimum.'])
                ->withInput();
        }

        InvestmentType::create($request->all());

        return redirect()->route('admin.exchange-rates.index')
            ->with('success', 'Le type d\'investissement a été créé avec succès.');
    }

    /**
     * Supprimer un type d'investissement
     */
    public function destroyInvestmentType(InvestmentType $investmentType)
    {
        // Vérifier s'il existe des investissements avec ce type
        if ($investmentType->investments()->count() > 0) {
            return redirect()->back()
                ->withErrors(['error' => 'Impossible de supprimer ce type d\'investissement car il est utilisé par des investissements existants.']);
        }

        $investmentType->delete();

        return redirect()->route('admin.exchange-rates.index')
            ->with('success', 'Le type d\'investissement a été supprimé avec succès.');
    }

    /**
     * API pour obtenir les montants actuels en Ariary
     */
    public function getCurrentRates()
    {
        $currentRate = ExchangeRate::getCurrentRate();
        $investmentTypes = InvestmentType::getActiveTypes();

        $rates = [];
        foreach ($investmentTypes as $type) {
            $amountsInAriary = $type->getAmountsInAriary();
            $rates[$type->name] = [
                'min_ariary' => $amountsInAriary['min_ariary'],
                'max_ariary' => $amountsInAriary['max_ariary'],
                'min_usd' => $type->min_amount_usd,
                'max_usd' => $type->max_amount_usd,
            ];
        }

        return response()->json([
            'current_rate' => $currentRate,
            'rates' => $rates,
        ]);
    }
}
