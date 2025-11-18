<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
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
