<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\SessionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Try to find user by username or email
        $user = User::where('username', $credentials['username'])
            ->orWhere('email', $credentials['username'])
            ->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors([
                'username' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
            ])->onlyInput('username');
        }

        if ($user->role === 'client' && ! $user->statut) {
            return back()->withErrors([
                'username' => 'Votre compte n\'a pas encore été validé par un administrateur.',
            ])->onlyInput('username');
        }

        Auth::login($user, $request->boolean('remember'));

        $request->session()->regenerate();

        // Redirection dynamique
        if ($request->has('redirect')) {
            return redirect($request->redirect);
        }

        return redirect()->intended(route('dashboard'));
    }

    /**
     * Show the registration form.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'nom' => ['required', 'string', 'min:2', 'max:255', 'regex:/^[a-zA-ZÀ-ÿ\s\-\'\.]+$/'],
            'prenom' => ['required', 'string', 'min:2', 'max:255', 'regex:/^[a-zA-ZÀ-ÿ\s\-\'\.]+$/'],
            'username' => ['required', 'string', 'min:3', 'max:255', 'unique:users', 'regex:/^[a-zA-Z0-9_\-\.]+$/'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'telephone' => ['required', 'string', 'min:10', 'max:20', 'regex:/^[+]?[0-9\s\-\(\)]+$/'],
            'adresse' => ['required', 'string', 'min:5', 'max:500'],
            'date_naissance' => ['nullable', 'date', 'before:today', 'after:1900-01-01'],
            'lieu_naissance' => ['nullable', 'string', 'min:2', 'max:255'],
            'nationalite' => ['nullable', 'string', 'min:2', 'max:255'],
            'profession' => ['nullable', 'string', 'min:2', 'max:255'],
            'piece_identite' => ['required', 'string', 'in:CIN,Passeport,Permis'],
            'numero_piece' => ['required', 'string', 'min:5', 'max:50'],
            'date_delivrance' => ['required', 'date', 'before_or_equal:today', 'after:1900-01-01'],
            'lieu_delivrance' => ['required', 'string', 'min:2', 'max:255'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'password' => ['required', 'string', 'min:8', 'confirmed', Password::defaults()],
        ], [
            'nom.required' => 'Le nom est obligatoire.',
            'nom.min' => 'Le nom doit contenir au moins 2 caractères.',
            'nom.regex' => 'Le nom ne peut contenir que des lettres, espaces, tirets et apostrophes.',
            'prenom.required' => 'Le prénom est obligatoire.',
            'prenom.min' => 'Le prénom doit contenir au moins 2 caractères.',
            'prenom.regex' => 'Le prénom ne peut contenir que des lettres, espaces, tirets et apostrophes.',
            'username.required' => 'Le nom d\'utilisateur est obligatoire.',
            'username.min' => 'Le nom d\'utilisateur doit contenir au moins 3 caractères.',
            'username.unique' => 'Ce nom d\'utilisateur est déjà utilisé.',
            'username.regex' => 'Le nom d\'utilisateur ne peut contenir que des lettres, chiffres, tirets, points et underscores.',
            'email.required' => 'L\'email est obligatoire.',
            'email.email' => 'Veuillez entrer une adresse email valide.',
            'email.unique' => 'Cet email est déjà utilisé.',
            'telephone.required' => 'Le téléphone est obligatoire.',
            'telephone.min' => 'Le numéro de téléphone doit contenir au moins 10 caractères.',
            'telephone.regex' => 'Veuillez entrer un numéro de téléphone valide.',
            'adresse.required' => 'L\'adresse est obligatoire.',
            'adresse.min' => 'L\'adresse doit contenir au moins 5 caractères.',
            'date_naissance.before' => 'La date de naissance doit être antérieure à aujourd\'hui.',
            'date_naissance.after' => 'La date de naissance doit être postérieure au 1er janvier 1900.',
            'piece_identite.in' => 'Veuillez sélectionner un type de pièce valide.',
            'numero_piece.min' => 'Le numéro de pièce doit contenir au moins 5 caractères.',
            'date_delivrance.before_or_equal' => 'La date de délivrance ne peut pas être postérieure à aujourd\'hui.',
            'lieu_delivrance.min' => 'Le lieu de délivrance doit contenir au moins 2 caractères.',
            'piece_identite.required' => 'Le type de pièce d\'identité est obligatoire.',
            'piece_identite.in' => 'Veuillez sélectionner un type de pièce valide.',
            'numero_piece.required' => 'Le numéro de pièce d\'identité est obligatoire.',
            'numero_piece.min' => 'Le numéro de pièce doit contenir au moins 5 caractères.',
            'date_delivrance.required' => 'La date de délivrance est obligatoire.',
            'date_delivrance.before_or_equal' => 'La date de délivrance ne peut pas être postérieure à aujourd\'hui.',
            'lieu_delivrance.required' => 'Le lieu de délivrance est obligatoire.',
            'lieu_delivrance.min' => 'Le lieu de délivrance doit contenir au moins 2 caractères.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        ]);

        $user = User::create([
            'nom' => trim($validated['nom']),
            'prenom' => trim($validated['prenom']),
            'username' => trim($validated['username']),
            'email' => strtolower(trim($validated['email'])),
            'telephone' => trim($validated['telephone']),
            'adresse' => trim($validated['adresse']),
            'date_naissance' => $validated['date_naissance'] ?? null,
            'lieu_naissance' => trim($validated['lieu_naissance'] ?? ''),
            'nationalite' => trim($validated['nationalite'] ?? ''),
            'profession' => trim($validated['profession'] ?? ''),
            'piece_identite' => $validated['piece_identite'] ?? null,
            'numero_piece' => trim($validated['numero_piece'] ?? ''),
            'date_delivrance' => $validated['date_delivrance'] ?? null,
            'lieu_delivrance' => trim($validated['lieu_delivrance'] ?? ''),
            'notes' => trim($validated['notes'] ?? ''),
            'password' => Hash::make($validated['password']),
            'role' => 'client',
            'statut' => false,
            'code_utilisateur' => $this->generateCodeUtilisateur(),
        ]);

        return redirect()->route('login')
            ->with('success', 'Votre compte a été créé avec succès. Veuillez attendre la validation par un administrateur avant de pouvoir vous connecter.');
    }

    /**
     * Log the user out.
     */
    public function logout(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            // Détruire TOUTES les sessions de cet utilisateur (sur tous les appareils)
            SessionService::destroyAllUserSessions($user->id);

            // Nettoyer les sessions expirées
            SessionService::cleanupExpiredSessions();

            // Forcer la déconnexion de l'utilisateur courant
            Auth::logout();

            // Invalider complètement la session courante
            Session::invalidate();

            // Régénérer le token CSRF pour éviter toute réutilisation
            $request->session()->regenerateToken();
        }

        // Rediriger vers la page de connexion avec un message et en-têtes anti-cache complets
        return redirect()->route('login')
            ->with('status', 'Vous avez été déconnecté avec succès sur tous vos appareils.')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate, max-age=0, private')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Thu, 01 Jan 1970 00:00:00 GMT')
            ->header('Clear-Site-Data', '"cache", "cookies", "storage", "executionContexts"')
            ->header('X-Frame-Options', 'DENY')
            ->header('X-Content-Type-Options', 'nosniff');
    }

    /**
     * Generate a unique client code.
     */
    private function generateCodeUtilisateur(): string
    {
        do {
            $code = 'CLI-'.str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
        } while (User::where('code_utilisateur', $code)->exists());

        return $code;
    }
}
