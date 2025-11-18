<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThemeController extends Controller
{
    /**
     * Switch the theme for the authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function switch(Request $request)
    {
        $validated = $request->validate([
            'theme' => 'required|string|in:light,dark',
        ]);

        $theme = $validated['theme'];

        // Save to session
        session(['theme' => $theme]);

        // Save to database if user is authenticated
        if (Auth::check()) {
            /** @var User $user */
            $user = Auth::user();
            $user->theme = $theme;
            $user->save();
        }

        return response()->json(['success' => true, 'theme' => $theme]);
    }
}
