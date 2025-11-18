<?php

namespace App\Http\Controllers;

use App\Models\Investment;
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

        Investment::create([
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

        return redirect()->route('investments.index')
            ->with('success', 'L\'investissement a été rejeté.');
    }
}
