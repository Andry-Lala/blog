<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Switch the application language.
     *
     * @param string $locale
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function switch(Request $request, $locale)
    {
        // Validate the locale
        $supportedLocales = ['en', 'fr'];

        if (!in_array($locale, $supportedLocales)) {
            // Fallback to default locale if invalid
            $locale = config('app.locale', 'en');
        }

        // Store the locale in session
        Session::put('locale', $locale);

        // Set the locale for current request
        App::setLocale($locale);

        // Check if it's an AJAX request
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'locale' => $locale,
                'message' => $locale === 'fr' ? 'Langue changée en français' : 'Language changed to English'
            ]);
        }

        // Redirect back to previous page for non-AJAX requests
        return redirect()->back();
    }
}
