<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Priorité: 1. Session, 2. Cookie, 3. Préférence du navigateur, 4. Locale par défaut
        $locale = null;

        // Vérifier d'abord la session
        if (Session::has('locale')) {
            $locale = Session::get('locale');
        }
        // Ensuite, vérifier le cookie
        elseif ($request->cookie('locale')) {
            $locale = $request->cookie('locale');
            // Synchroniser avec la session
            Session::put('locale', $locale);
        }
        // Enfin, utiliser la préférence du navigateur si disponible
        elseif ($request->header('Accept-Language')) {
            $browserLocale = substr($request->header('Accept-Language'), 0, 2);
            if (in_array($browserLocale, ['en', 'fr'])) {
                $locale = $browserLocale;
                Session::put('locale', $locale);
            }
        }

        // Appliquer la locale si elle est valide
        if ($locale && in_array($locale, ['en', 'fr'])) {
            App::setLocale($locale);

            // Mettre à jour le cookie pour une durée de 30 jours
            cookie()->queue('locale', $locale, 43200); // 30 jours en minutes
        }

        return $next($request);
    }
}
