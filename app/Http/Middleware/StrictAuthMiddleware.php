<?php

namespace App\Http\Middleware;

use App\Services\SessionService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class StrictAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vérification stricte de l'authentification
        if (!Auth::check()) {
            // Nettoyer les sessions expirées
            SessionService::cleanupExpiredSessions();

            // Si c'est une requête AJAX, retourner une réponse JSON
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'error' => 'Non authentifié',
                    'redirect' => route('login'),
                    'message' => 'Votre session a expiré. Veuillez vous reconnecter.'
                ], 401);
            }

            // Pour les requêtes normales, rediriger immédiatement vers login
            // avec un message clair et forcer le rechargement complet
            return redirect()->route('login')
                ->with('error', 'Votre session a expiré. Veuillez vous reconnecter.')
                ->header('Cache-Control', 'no-cache, no-store, must-revalidate, max-age=0')
                ->header('Pragma', 'no-cache')
                ->header('Expires', 'Thu, 01 Jan 1970 00:00:00 GMT');
        }

        // Vérification supplémentaire de la validité de la session courante
        $currentSessionId = Session::getId();
        if ($currentSessionId && !SessionService::isSessionValid($currentSessionId)) {
            // Session invalide, détruire et rediriger
            Session::flush();
            Auth::logout();

            return redirect()->route('login')
                ->with('error', 'Session invalide détectée. Veuillez vous reconnecter.')
                ->header('Cache-Control', 'no-cache, no-store, must-revalidate, max-age=0')
                ->header('Pragma', 'no-cache')
                ->header('Expires', 'Thu, 01 Jan 1970 00:00:00 GMT');
        }

        // Régénérer l'ID de session pour prévenir les fixations de session
        // mais sans régénérer le token CSRF pour éviter les problèmes
        session()->regenerate(false);

        // Ajouter des en-têtes pour empêcher la mise en cache de la réponse
        $response = $next($request);
        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', 'Thu, 01 Jan 1970 00:00:00 GMT');

        return $response;
    }
}
