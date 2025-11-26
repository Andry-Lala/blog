<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Investment;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin')->except(['show', 'edit', 'update']);
    }

    /**
     * Display a listing of clients.
     */
    public function index(Request $request)
    {
        $query = Client::clients();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                    ->orWhere('prenom', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhere('code_utilisateur', 'like', "%{$search}%");
            });
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut === 'verified');
        }

        $clients = $query->latest()->paginate(10);

        return view('clients.index', compact('clients'));
    }

    /**
     * Display clients with their investment totals for admin.
     */
    public function adminIndex(Request $request)
    {
        $query = Client::clients()->with('investments');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                    ->orWhere('prenom', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhere('code_utilisateur', 'like', "%{$search}%");
            });
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut === 'verified');
        }

        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'total_investments_desc':
                    $query->orderByDesc(
                        Investment::selectRaw('COALESCE(SUM(amount), 0)')
                            ->whereColumn('user_id', 'users.id')
                            ->where('status', 'Validé')
                    );
                    break;
                case 'total_investments_asc':
                    $query->orderBy(
                        Investment::selectRaw('COALESCE(SUM(amount), 0)')
                            ->whereColumn('user_id', 'users.id')
                            ->where('status', 'Validé')
                    );
                    break;
                case 'name_asc':
                    $query->orderBy('nom', 'asc')->orderBy('prenom', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('nom', 'desc')->orderBy('prenom', 'desc');
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }

        $clients = $query->paginate(15);

        // Calculate statistics
        $totalClients = Client::clients()->count();
        $verifiedClients = Client::clients()->where('statut', true)->count();
        $totalInvestments = Investment::where('status', 'Validé')->sum('amount');
        $totalInvestmentsCount = Investment::where('status', 'Validé')->count();

        return view('clients.admin.index', compact(
            'clients',
            'totalClients',
            'verifiedClients',
            'totalInvestments',
            'totalInvestmentsCount'
        ));
    }

    /**
     * Show the form for creating a new client.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created client.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'telephone' => ['nullable', 'string', 'max:20'],
            'adresse' => ['nullable', 'string', 'max:500'],
            'date_naissance' => ['nullable', 'date'],
            'lieu_naissance' => ['nullable', 'string', 'max:255'],
            'nationalite' => ['nullable', 'string', 'max:255'],
            'profession' => ['nullable', 'string', 'max:255'],
            'piece_identite' => ['nullable', 'string', 'max:255'],
            'numero_piece' => ['nullable', 'string', 'max:255'],
            'date_delivrance' => ['nullable', 'date'],
            'lieu_delivrance' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $client = Client::create([
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'telephone' => $validated['telephone'] ?? null,
            'adresse' => $validated['adresse'] ?? null,
            'date_naissance' => $validated['date_naissance'] ?? null,
            'lieu_naissance' => $validated['lieu_naissance'] ?? null,
            'nationalite' => $validated['nationalite'] ?? null,
            'profession' => $validated['profession'] ?? null,
            'piece_identite' => $validated['piece_identite'] ?? null,
            'numero_piece' => $validated['numero_piece'] ?? null,
            'date_delivrance' => $validated['date_delivrance'] ?? null,
            'lieu_delivrance' => $validated['lieu_delivrance'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'password' => Hash::make($validated['password']),
            'role' => 'client',
            'statut' => false,
            'code_utilisateur' => $this->generateCodeUtilisateur(),
        ]);

        // Notifier les administrateurs du nouveau client
        $admins = \App\Models\User::where('role', 'administrateur')->get();
        foreach ($admins as $admin) {
            Notification::createForUser(
                $admin->id,
                'Nouveau client inscrit',
                "Un nouveau client {$validated['prenom']} {$validated['nom']} s'est inscrit sur la plateforme.",
                'info',
                'App\\Models\\User',
                $client->id
            );
        }

        return redirect()->route('clients.show', $client)
            ->with('success', 'Client créé avec succès.');
    }

    /**
     * Display the specified client.
     */
    public function show(Client $client)
    {
        if (Auth::user()->role !== 'administrateur' && Auth::id() !== $client->id) {
            abort(403);
        }

        return view('clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified client.
     */
    public function edit(Client $client)
    {
        if (Auth::user()->role !== 'administrateur' && Auth::id() !== $client->id) {
            abort(403);
        }

        return view('clients.edit', compact('client'));
    }

    /**
     * Update the specified client.
     */
    public function update(Request $request, Client $client)
    {
        if (Auth::user()->role !== 'administrateur' && Auth::id() !== $client->id) {
            abort(403);
        }

        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,'.$client->id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$client->id],
            'telephone' => ['nullable', 'string', 'max:20'],
            'adresse' => ['nullable', 'string', 'max:500'],
            'date_naissance' => ['nullable', 'date'],
            'lieu_naissance' => ['nullable', 'string', 'max:255'],
            'nationalite' => ['nullable', 'string', 'max:255'],
            'profession' => ['nullable', 'string', 'max:255'],
            'piece_identite' => ['nullable', 'string', 'max:255'],
            'numero_piece' => ['nullable', 'string', 'max:255'],
            'date_delivrance' => ['nullable', 'date'],
            'lieu_delivrance' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        $client->update([
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'telephone' => $validated['telephone'] ?? null,
            'adresse' => $validated['adresse'] ?? null,
            'date_naissance' => $validated['date_naissance'] ?? null,
            'lieu_naissance' => $validated['lieu_naissance'] ?? null,
            'nationalite' => $validated['nationalite'] ?? null,
            'profession' => $validated['profession'] ?? null,
            'piece_identite' => $validated['piece_identite'] ?? null,
            'numero_piece' => $validated['numero_piece'] ?? null,
            'date_delivrance' => $validated['date_delivrance'] ?? null,
            'lieu_delivrance' => $validated['lieu_delivrance'] ?? null,
            'notes' => $validated['notes'] ?? null,
        ]);

        if (! empty($validated['password'])) {
            $client->update(['password' => Hash::make($validated['password'])]);
        }

        return redirect()->route('clients.show', $client)
            ->with('success', 'Client mis à jour avec succès.');
    }

    /**
     * Remove the specified client.
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('clients.index')
            ->with('success', 'Client supprimé avec succès.');
    }

    /**
     * Verify a client.
     */
    public function verify(Client $client)
    {
        $client->update([
            'statut' => true,
            'date_validation' => now(),
            'valide_par' => Auth::id(),
        ]);

        // Notifier le client de sa vérification
        Notification::createForUser(
            $client->id,
            'Compte vérifié',
            'Félicitations ! Votre compte a été vérifié avec succès. Vous pouvez maintenant effectuer des investissements.',
            'success',
            'App\\Models\\User',
            $client->id
        );

        return redirect()->route('clients.show', $client)
            ->with('success', 'Client vérifié avec succès.');
    }

    /**
     * Unverify a client.
     */
    public function unverify(Client $client)
    {
        $client->update([
            'statut' => false,
            'date_validation' => null,
            'valide_par' => null,
        ]);

        // Notifier le client de sa dévérification
        Notification::createForUser(
            $client->id,
            'Compte dévérifié',
            'Votre compte n\'est plus vérifié. Veuillez contacter l\'administrateur pour plus d\'informations.',
            'warning',
            'App\\Models\\User',
            $client->id
        );

        return redirect()->route('clients.show', $client)
            ->with('success', 'Client dévérifié avec succès.');
    }

    /**
     * Generate a unique client code.
     */
    private function generateCodeUtilisateur(): string
    {
        do {
            $code = 'CLI-'.str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
        } while (Client::where('code_utilisateur', $code)->exists());

        return $code;
    }
}
