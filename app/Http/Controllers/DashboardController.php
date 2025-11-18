<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Statistiques pour le tableau de bord
        $totalInvestments = Investment::count();
        $totalAmount = Investment::sum('amount');
        $pendingInvestments = Investment::where('status', 'Envoyé')->count();
        $validatedInvestments = Investment::where('status', 'Validé')->count();

        // Statistiques pour l'utilisateur connecté
        $userInvestments = Investment::where('user_id', $user->id)->count();
        $userTotalAmount = Investment::where('user_id', $user->id)->sum('amount');

        // Investissements récents de l'utilisateur connecté
        $userRecentInvestments = Investment::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Données pour le graphique des investissements par mois pour l'utilisateur connecté
        $dbDriver = config('database.default');

        if ($dbDriver === 'sqlite') {
            $userMonthlyInvestments = Investment::selectRaw('strftime("%m", created_at) as month, strftime("%Y", created_at) as year, status, COUNT(*) as count')
                ->where('user_id', $user->id)
                ->whereRaw('strftime("%Y", created_at) = ?', [date('Y')])
                ->groupByRaw('strftime("%m", created_at), strftime("%Y", created_at), status')
                ->orderByRaw('strftime("%Y", created_at), strftime("%m", created_at)')
                ->get();
        } else {
            $userMonthlyInvestments = Investment::selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, status, COUNT(*) as count')
                ->where('user_id', $user->id)
                ->whereYear('created_at', date('Y'))
                ->groupByRaw('MONTH(created_at), YEAR(created_at), status')
                ->orderByRaw('YEAR(created_at), MONTH(created_at)')
                ->get();
        }

        // Préparer les données pour le graphique de l'utilisateur
        $chartLabels = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'];
        $userValidatedData = array_fill(0, 12, 0);
        $userPendingData = array_fill(0, 12, 0);

        foreach ($userMonthlyInvestments as $investment) {
            $monthIndex = $investment->month - 1; // Les mois sont 1-12, on veut 0-11
            if ($investment->status === 'Validé') {
                $userValidatedData[$monthIndex] = $investment->count;
            } elseif ($investment->status === 'Envoyé') {
                $userPendingData[$monthIndex] = $investment->count;
            }
        }

        // Statistiques supplémentaires pour l'utilisateur
        $userPendingCount = Investment::where('user_id', $user->id)->where('status', 'Envoyé')->count();
        $userProcessingCount = Investment::where('user_id', $user->id)->where('status', 'En cours de traitement')->count();
        $userValidatedCount = Investment::where('user_id', $user->id)->where('status', 'Validé')->count();
        $userRejectedCount = Investment::where('user_id', $user->id)->where('status', 'Rejeté')->count();

        // Pour les administrateurs, garder les données globales
        $recentInvestments = null;
        $recentClients = null;
        $chartLabels = null;
        $validatedData = null;
        $pendingData = null;
        $validatedAmountData = null;
        $pendingAmountData = null;
        $totalClients = null;
        $totalValidatedAmount = null;
        $totalPendingAmount = null;
        $totalProcessingAmount = null;
        $totalRejectedAmount = null;

        if ($user->role === 'administrateur') {
            // Investissements récents globaux
            $recentInvestments = Investment::with('user:id,nom,prenom')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            // Clients récents
            $recentClients = User::where('role', 'client')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            // Données pour le graphique global - nombre d'investissements
            if ($dbDriver === 'sqlite') {
                $monthlyInvestments = Investment::selectRaw('strftime("%m", created_at) as month, strftime("%Y", created_at) as year, status, COUNT(*) as count')
                    ->whereRaw('strftime("%Y", created_at) = ?', [date('Y')])
                    ->groupByRaw('strftime("%m", created_at), strftime("%Y", created_at), status')
                    ->orderByRaw('strftime("%Y", created_at), strftime("%m", created_at)')
                    ->get();

                // Données pour le graphique global - montants des investissements
                $monthlyAmounts = Investment::selectRaw('strftime("%m", created_at) as month, strftime("%Y", created_at) as year, status, SUM(amount) as total')
                    ->whereRaw('strftime("%Y", created_at) = ?', [date('Y')])
                    ->groupByRaw('strftime("%m", created_at), strftime("%Y", created_at), status')
                    ->orderByRaw('strftime("%Y", created_at), strftime("%m", created_at)')
                    ->get();
            } else {
                $monthlyInvestments = Investment::selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, status, COUNT(*) as count')
                    ->whereYear('created_at', date('Y'))
                    ->groupByRaw('MONTH(created_at), YEAR(created_at), status')
                    ->orderByRaw('YEAR(created_at), MONTH(created_at)')
                    ->get();

                // Données pour le graphique global - montants des investissements
                $monthlyAmounts = Investment::selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, status, SUM(amount) as total')
                    ->whereYear('created_at', date('Y'))
                    ->groupByRaw('MONTH(created_at), YEAR(created_at), status')
                    ->orderByRaw('YEAR(created_at), MONTH(created_at)')
                    ->get();
            }

            $chartLabels = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'];
            $validatedData = array_fill(0, 12, 0);
            $pendingData = array_fill(0, 12, 0);
            $validatedAmountData = array_fill(0, 12, 0);
            $pendingAmountData = array_fill(0, 12, 0);

            foreach ($monthlyInvestments as $investment) {
                $monthIndex = $investment->month - 1;
                if ($investment->status === 'Validé') {
                    $validatedData[$monthIndex] = $investment->count;
                } elseif ($investment->status === 'Envoyé') {
                    $pendingData[$monthIndex] = $investment->count;
                }
            }

            foreach ($monthlyAmounts as $amount) {
                $monthIndex = $amount->month - 1;
                if ($amount->status === 'Validé') {
                    $validatedAmountData[$monthIndex] = $amount->total;
                } elseif ($amount->status === 'Envoyé') {
                    $pendingAmountData[$monthIndex] = $amount->total;
                }
            }

            // Statistiques globales supplémentaires pour l'administrateur
            $totalClients = User::where('role', 'client')->count();
            $totalValidatedAmount = Investment::where('status', 'Validé')->sum('amount');
            $totalPendingAmount = Investment::where('status', 'Envoyé')->sum('amount');
            $totalProcessingAmount = Investment::where('status', 'En cours de traitement')->sum('amount');
            $totalRejectedAmount = Investment::where('status', 'Rejeté')->sum('amount');
        }

        return view('dashboard.index', compact(
            'user',
            'totalInvestments',
            'totalAmount',
            'pendingInvestments',
            'validatedInvestments',
            'userInvestments',
            'userTotalAmount',
            'userRecentInvestments',
            'recentInvestments',
            'recentClients',
            'chartLabels',
            'validatedData',
            'pendingData',
            'userValidatedData',
            'userPendingData',
            'userPendingCount',
            'userProcessingCount',
            'userValidatedCount',
            'userRejectedCount',
            'validatedAmountData',
            'pendingAmountData',
            'totalClients',
            'totalValidatedAmount',
            'totalPendingAmount',
            'totalProcessingAmount',
            'totalRejectedAmount'
        ));
    }
}
