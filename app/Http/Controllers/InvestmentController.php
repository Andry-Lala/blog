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
            $investments = Investment::with('user')->latest()->paginate(10);

            return view('investments.admin.index', compact('investments'));
        }

        $investments = Investment::where('user_id', $user->id)->latest()->paginate(10);

        return view('investments.index', compact('investments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('investments.create');
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

        // Generate PDF content (you can use a library like DomPDF here)
        // For now, we'll create a simple HTML invoice that can be printed
        $pdfContent = view('investments.invoice', compact('investment'))->render();

        // Store the PDF temporarily (optional)
        $pdfPath = "investments/invoice_{$investment->id}.pdf";
        Storage::put($pdfPath, $pdfContent);

        // Return the PDF as download
        return response($pdfContent)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', "attachment; filename=invoice_{$investment->id}.pdf");
    }
}
