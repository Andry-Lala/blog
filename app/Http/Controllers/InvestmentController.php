<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class InvestmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin) {
            // Récupérer les clients avec leurs investissements validés regroupés
            $clientsWithInvestments = \App\Models\User::where('role', 'client')
                ->with(['investments' => function($query) {
                    $query->where('status', 'Validé')
                          ->select('user_id', 'amount', 'created_at', 'id', 'investment_type', 'operator');
                }])
                ->get()
                ->map(function ($client) {
                    $validatedInvestments = $client->investments;
                    $totalAmount = $validatedInvestments->sum('amount');
                    $investmentCount = $validatedInvestments->count();

                    return [
                        'id' => $client->id,
                        'first_name' => $client->first_name,
                        'last_name' => $client->last_name,
                        'email' => $client->email,
                        'total_validated_amount' => $totalAmount,
                        'validated_investments_count' => $investmentCount,
                        'last_investment_date' => $validatedInvestments->max('created_at'),
                        'investments' => $validatedInvestments
                    ];
                })
                ->filter(function ($client) {
                    return $client['validated_investments_count'] > 0;
                })
                ->sortByDesc('total_validated_amount')
                ->values();

            return view('investments.admin.index', compact('clientsWithInvestments'));
        }

        $investments = Investment::where('user_id', $user->id)->latest()->paginate(10);

        return view('investments.index', compact('investments'));
    }

    /**
     * Display investment history for the authenticated client.
     */
    public function history()
    {
        $user = Auth::user();

        // Récupérer tous les investissements du client avec pagination
        $investments = Investment::where('user_id', $user->id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Calculer les statistiques
        $totalInvestments = Investment::where('user_id', $user->id)->sum('amount');
        $validatedInvestments = Investment::where('user_id', $user->id)->where('status', 'Validé')->sum('amount');
        $pendingInvestments = Investment::where('user_id', $user->id)->where('status', 'Envoyé')->sum('amount');
        $processingInvestments = Investment::where('user_id', $user->id)->where('status', 'En cours de traitement')->sum('amount');
        $rejectedInvestments = Investment::where('user_id', $user->id)->where('status', 'Rejeté')->sum('amount');

        $statistics = [
            'total_investments' => $totalInvestments,
            'validated_investments' => $validatedInvestments,
            'pending_investments' => $pendingInvestments,
            'processing_investments' => $processingInvestments,
            'rejected_investments' => $rejectedInvestments,
            'total_count' => Investment::where('user_id', $user->id)->count(),
            'validated_count' => Investment::where('user_id', $user->id)->where('status', 'Validé')->count(),
            'pending_count' => Investment::where('user_id', $user->id)->where('status', 'Envoyé')->count(),
            'processing_count' => Investment::where('user_id', $user->id)->where('status', 'En cours de traitement')->count(),
            'rejected_count' => Investment::where('user_id', $user->id)->where('status', 'Rejeté')->count(),
        ];

        return view('investments.history', compact('investments', 'statistics'));
    }

    /**
     * Display investment summary for administrators.
     */
    public function summary()
    {
        // Vérifier que l'utilisateur est un administrateur
        if (!Auth::user()->isAdmin) {
            abort(403, 'Accès non autorisé.');
        }

        // Récupérer tous les clients avec leurs investissements
        $clientsWithInvestments = \App\Models\User::where('role', 'client')
            ->with(['investments' => function($query) {
                $query->selectRaw('user_id, SUM(amount) as total_amount, COUNT(*) as investment_count')
                    ->where('status', 'Validé')
                    ->groupBy('user_id');
            }])
            ->get();

        return view('investments.summary', compact('clientsWithInvestments'));
    }

    /**
     * Display investments for a specific user (admin only).
     */
    public function userInvestments($userId)
    {
        // Vérifier que l'utilisateur est un administrateur
        if (!Auth::user()->isAdmin) {
            abort(403, 'Accès non autorisé.');
        }

        // Récupérer l'utilisateur
        $user = \App\Models\User::findOrFail($userId);

        // Récupérer tous les investissements de l'utilisateur
        $investments = Investment::where('user_id', $userId)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Calculer les statistiques pour cet utilisateur
        $totalInvestments = Investment::where('user_id', $userId)->sum('amount');
        $validatedInvestments = Investment::where('user_id', $userId)->where('status', 'Validé')->sum('amount');
        $pendingInvestments = Investment::where('user_id', $userId)->where('status', 'Envoyé')->sum('amount');
        $processingInvestments = Investment::where('user_id', $userId)->where('status', 'En cours de traitement')->sum('amount');
        $rejectedInvestments = Investment::where('user_id', $userId)->where('status', 'Rejeté')->sum('amount');

        $statistics = [
            'total_investments' => $totalInvestments,
            'validated_investments' => $validatedInvestments,
            'pending_investments' => $pendingInvestments,
            'processing_investments' => $processingInvestments,
            'rejected_investments' => $rejectedInvestments,
            'total_count' => Investment::where('user_id', $userId)->count(),
            'validated_count' => Investment::where('user_id', $userId)->where('status', 'Validé')->count(),
            'pending_count' => Investment::where('user_id', $userId)->where('status', 'Envoyé')->count(),
            'processing_count' => Investment::where('user_id', $userId)->where('status', 'En cours de traitement')->count(),
            'rejected_count' => Investment::where('user_id', $userId)->where('status', 'Rejeté')->count(),
        ];

        return view('investments.admin.user-investments', compact('investments', 'statistics', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        return view('investments.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'operator' => ['required', Rule::in(Investment::getOperators())],
            'investment_type' => ['required', Rule::in(Investment::getInvestmentTypes())],
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'id_number' => 'required|string|max:255',
            'id_photo' => 'required|file|image|max:2048',
            'transaction_phone' => 'required|string|max:20',
            'amount' => 'required|numeric|min:0',
            'transaction_proof' => 'required|file|image|max:2048',
        ]);

        $idPhotoPath = $request->file('id_photo')->store('investments/id_photos', 'public');
        $transactionProofPath = $request->file('transaction_proof')->store('investments/transaction_proofs', 'public');

        $investment = Investment::create([
            'user_id' => Auth::id(),
            'operator' => $request->operator,
            'investment_type' => $request->investment_type,
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'address' => $request->address,
            'phone' => $request->phone,
            'id_number' => $request->id_number,
            'id_photo' => $idPhotoPath,
            'transaction_phone' => $request->transaction_phone,
            'amount' => $request->amount,
            'transaction_proof' => $transactionProofPath,
            'status' => 'Envoyé',
        ]);

        // Créer une notification pour le client
        Notification::createForUser(
            Auth::id(),
            'Investissement reçu',
            "Votre demande d'investissement de {$request->amount} Ar a été reçue et est en attente de validation.",
            'info',
            'App\\Models\\Investment',
            $investment->id
        );

        // Créer une notification pour les administrateurs
        $admins = \App\Models\User::where('role', 'administrateur')->get();
        foreach ($admins as $admin) {
            Notification::createForUser(
                $admin->id,
                'Nouvel investissement',
                "Un nouvel investissement de {$request->amount} Ar a été soumis par " . Auth::user()->first_name . ' ' . Auth::user()->last_name,
                'info',
                'App\\Models\\Investment',
                $investment->id
            );
        }

        return redirect()->route('investments.index')
            ->with('success', 'Votre demande d\'investissement a été soumise avec succès.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Investment $investment)
    {
        if (! Auth::user()->isAdmin) {
            abort(403);
        }

        $request->validate([
            'admin_notes' => 'nullable|string',
        ]);

        $investment->update([
            'status' => 'En cours de traitement',
            'admin_notes' => $request->admin_notes,
        ]);

        // Notifier le client
        Notification::createForUser(
            $investment->user_id,
            'Investissement en cours de traitement',
            "Votre investissement de {$investment->amount} Ar est maintenant en cours de traitement.",
            'warning',
            'App\\Models\\Investment',
            $investment->id
        );

        return redirect()->route('investments.show', $investment)
            ->with('success', 'La demande a été mise en cours de traitement.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Investment $investment)
    {
        if (Auth::id() !== $investment->user_id && ! Auth::user()->isAdmin) {
            abort(403);
        }

        return view('investments.show', compact('investment'));
    }

    /**
     * Approve the investment.
     */
    public function approve(Request $request, Investment $investment)
    {
        if (! Auth::user()->isAdmin) {
            abort(403);
        }

        $request->validate([
            'admin_notes' => 'nullable|string',
        ]);

        $investment->update([
            'status' => 'Validé',
            'admin_notes' => $request->admin_notes,
        ]);

        // Notifier le client
        Notification::createForUser(
            $investment->user_id,
            'Investissement approuvé',
            "Félicitations ! Votre investissement de {$investment->amount} Ar a été approuvé avec succès.",
            'success',
            'App\\Models\\Investment',
            $investment->id
        );

        return redirect()->route('investments.index')
            ->with('success', 'L\'investissement a été approuvé avec succès.');
    }

    /**
     * Reject the investment.
     */
    public function reject(Request $request, Investment $investment)
    {
        if (! Auth::user()->isAdmin) {
            abort(403);
        }

        $request->validate([
            'admin_notes' => 'required|string',
        ]);

        $investment->update([
            'status' => 'Rejeté',
            'admin_notes' => $request->admin_notes,
        ]);

        // Notifier le client
        Notification::createForUser(
            $investment->user_id,
            'Investissement rejeté',
            "Votre investissement de {$investment->amount} Ar a été rejeté. Motif : " . $request->admin_notes,
            'error',
            'App\\Models\\Investment',
            $investment->id
        );

        return redirect()->route('investments.index')
            ->with('success', 'L\'investissement a été rejeté.');
    }

    /**
     * Generate PDF invoice for the investment.
     */
    public function generateInvoice(Investment $investment)
    {
        if (Auth::id() !== $investment->user_id && !Auth::user()->isAdmin) {
            abort(403);
        }

        // Generate HTML invoice content
        $htmlContent = view('investments.invoice', compact('investment'))->render();

        // Return the HTML as response for now (can be converted to PDF later with DomPDF)
        return response($htmlContent)
            ->header('Content-Type', 'text/html')
            ->header('Content-Disposition', "inline; filename=facture_{$investment->id}.html");
    }
}
