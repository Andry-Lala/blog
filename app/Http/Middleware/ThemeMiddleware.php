<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThemeMiddleware
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
        // Vérifier si le thème est demandé dans la requête
        if ($request->has('theme')) {
            $theme = $request->get('theme');

            // Valider le thème
            if (in_array($theme, ['light', 'dark'])) {
                // Sauvegarder le thème en session
                session(['theme' => $theme]);

                // Si l'utilisateur est connecté, sauvegarder aussi en base de données
                if (Auth::check()) {
                    $user = Auth::user();
                    if ($user) {
                        $user->theme = $theme;
                        $user->save();
                    }
                }
            }
        }

        return $next($request);
    }
}
