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
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'telephone' => ['nullable', 'string', 'max:20'],
            'adresse' => ['nullable', 'string', 'max:500'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = User::create([
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'telephone' => $validated['telephone'] ?? null,
            'adresse' => $validated['adresse'] ?? null,
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
