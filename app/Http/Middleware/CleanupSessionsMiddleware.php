<?php

namespace App\Http\Middleware;

use App\Services\SessionService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CleanupSessionsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Nettoyer automatiquement toutes les sessions expirées ou invalides
        SessionService::cleanupExpiredSessions();

        // Si l'utilisateur est authentifié, vérifier sa session courante
        if (Auth::check()) {
            $currentSessionId = session()->getId();
            if ($currentSessionId && !SessionService::isSessionValid($currentSessionId)) {
                // Session invalide détectée, détruire immédiatement
                Session::flush();
                Auth::logout();

                return redirect()->route('login')
                    ->with('error', 'Session invalide détectée. Veuillez vous reconnecter.')
                    ->header('Cache-Control', 'no-cache, no-store, must-revalidate, max-age=0, private')
                    ->header('Pragma', 'no-cache')
                    ->header('Expires', 'Thu, 01 Jan 1970 00:00:00 GMT');
            }
        }

        return $next($request);
    }
}
