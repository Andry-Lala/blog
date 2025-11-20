<?php

namespace App\Http\Middleware;

use App\Services\SessionService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class ForceAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Nettoyer les sessions expirées à chaque requête
        SessionService::cleanupExpiredSessions();

        // Vérification ULTIME de l'authentification
        if (!Auth::check()) {
            // Forcer la destruction de toute session résiduelle
            Session::flush();

            // Si c'est une requête AJAX, retourner une réponse JSON immédiate
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'error' => 'Session expirée',
                    'redirect' => route('login'),
                    'message' => 'Votre session a expiré. Veuillez vous reconnecter.',
                    'force_logout' => true
                ], 401);
            }

            // Pour les requêtes normales, rediriger immédiatement vers login
            // avec un message clair et forcer le rechargement complet
            return redirect()->route('login')
                ->with('error', 'Votre session a expiré. Veuillez vous reconnecter.')
                ->header('Cache-Control', 'no-cache, no-store, must-revalidate, max-age=0, private')
                ->header('Pragma', 'no-cache')
                ->header('Expires', 'Thu, 01 Jan 1970 00:00:00 GMT')
                ->header('X-Frame-Options', 'DENY')
                ->header('X-Content-Type-Options', 'nosniff')
                ->header('Clear-Site-Data', '"cache", "cookies", "storage", "executionContexts"');
        }

        // Vérification supplémentaire de la validité de la session courante
        $currentSessionId = Session::getId();
        if ($currentSessionId && !SessionService::isSessionValid($currentSessionId)) {
            // Session invalide détectée, détruire immédiatement
            Session::flush();
            Auth::logout();

            return redirect()->route('login')
                ->with('error', 'Session invalide détectée. Veuillez vous reconnecter.')
                ->header('Cache-Control', 'no-cache, no-store, must-revalidate, max-age=0, private')
                ->header('Pragma', 'no-cache')
                ->header('Expires', 'Thu, 01 Jan 1970 00:00:00 GMT')
                ->header('X-Frame-Options', 'DENY')
                ->header('X-Content-Type-Options', 'nosniff')
                ->header('Clear-Site-Data', '"cache", "cookies", "storage", "executionContexts"');
        }

        // Vérification supplémentaire : s'assurer que l'utilisateur est bien associé à cette session
        $userId = Auth::id();
        if ($userId && $currentSessionId) {
            $sessionData = DB::table('sessions')
                ->where('id', $currentSessionId)
                ->first();

            // Si la session existe mais n'a pas le bon user_id, c'est une tentative d'accès non autorisé
            if ($sessionData && $sessionData->user_id != $userId) {
                Session::flush();
                Auth::logout();

                return redirect()->route('login')
                    ->with('error', 'Session corrompue détectée. Veuillez vous reconnecter.')
                    ->header('Cache-Control', 'no-cache, no-store, must-revalidate, max-age=0, private')
                    ->header('Pragma', 'no-cache')
                    ->header('Expires', 'Thu, 01 Jan 1970 00:00:00 GMT')
                    ->header('Clear-Site-Data', '"cache", "cookies", "storage", "executionContexts"');
            }
        }

        // Régénérer l'ID de session pour prévenir les fixations de session
        // mais uniquement si nécessaire pour éviter les problèmes de concurrence
        if (!session()->has('session_regenerated_recently')) {
            session()->regenerate(false);
            session()->put('session_regenerated_recently', true);
        }

        // Ajouter des en-têtes pour empêcher TOUTE forme de mise en cache
        $response = $next($request);
        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0, private, no-transform');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', 'Thu, 01 Jan 1970 00:00:00 GMT');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Vary', '*');
        $response->headers->set('Referrer-Policy', 'no-referrer');

        return $response;
    }
}
