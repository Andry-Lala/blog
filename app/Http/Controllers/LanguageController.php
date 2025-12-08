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

        // Store in cookie for persistence (30 days)
        cookie()->queue('locale', $locale, 43200); // 30 days in minutes

        // Check if it's an AJAX request
        if ($request->ajax() || $request->wantsJson()) {
            // Forcer la mise à jour des notifications pour qu'elles se retraduisent
            if (auth()->check()) {
                // Vider le cache des notifications pour forcer la retraduction
                $userId = auth()->id();
                cache()->forget("user_unread_notifications_{$userId}");

                // Invalider tous les caches de notifications
                for ($i = 1; $i <= 10; $i++) {
                    cache()->forget("user_unread_notifications_{$userId}_page_{$i}");
                }
            }

            return response()->json([
                'success' => true,
                'locale' => $locale,
                'reload' => true,
                'message' => $locale === 'fr' ? 'Langue changée en français' : 'Language changed to English',
                'force_notification_refresh' => true
            ])->withCookie(cookie('locale', $locale, 43200));
        }

        // Redirect back to previous page for non-AJAX requests
        return redirect()->back()->withCookie(cookie('locale', $locale, 43200));
    }

    /**
     * Fournir les traductions pour JavaScript
     */
    public function getTranslations()
    {
        $translations = [
            'no_notifications' => __('messages.no_notifications'),
            'just_now' => __('messages.just_now'),
            'minutes_ago' => __('messages.minutes_ago'),
            'hours_ago' => __('messages.hours_ago'),
            'days_ago' => __('messages.days_ago')
        ];

        return response()->json($translations);
    }
}
