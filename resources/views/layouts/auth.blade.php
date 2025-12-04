<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Authentification') - Unicorn Madagascar</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/blog-logo.jpeg') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        // Protection de base contre l'accès non autorisé après déconnexion
        (function() {
            'use strict';

            // Vérifier si l'utilisateur accède à cette page depuis l'historique
            window.addEventListener('pageshow', function(event) {
                if (event.persisted) {
                    // Page chargée depuis le cache, forcer rechargement
                    window.location.reload(true);
                }
            });

            // Empêcher la navigation arrière vers les pages protégées
            history.pushState(null, null, location.href);
            window.addEventListener('popstate', function(event) {
                history.pushState(null, null, location.href);
            });

            // Nettoyer tout stockage local au chargement
            try {
                if (window.location.search.includes('forced=1')) {
                    localStorage.clear();
                    sessionStorage.clear();
                }
            } catch (e) {
                console.warn('Impossible de nettoyer le stockage:', e);
            }
        })();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

</head>

<body class="bg-gray-50 text-gray-900">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full space-y-8">
            <!-- Header with language switcher -->
            <div class="text-center relative">
                <div class="absolute top-0 right-0">
                    <div x-data="{ languageOpen: false }" class="relative">
                        <!-- Language selector button -->
                        <button @click="languageOpen = !languageOpen"
                                data-language-button
                                class="flex items-center space-x-2 p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
                            </svg>
                            <span class="text-sm font-medium">{{ strtoupper(app()->getLocale()) }}</span>
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Dropdown panel -->
                        <div x-show="languageOpen"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             @click.away="languageOpen = false"
                             class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                            <div class="py-1" role="menu">
                                <!-- French -->
                                <a href="{{ route('language.switch', 'fr') }}"
                                   data-locale="fr"
                                   data-no-jquery="true"
                                   class="{{ app()->getLocale() === 'fr' ? 'bg-blue-50 text-blue-900' : 'text-gray-700 hover:bg-gray-100' }} w-full text-left px-4 py-2 text-sm font-medium flex items-center space-x-3"
                                   role="menuitem">
                                    <span class="text-lg">🇫🇷</span>
                                    <span>Français</span>
                                    @if(app()->getLocale() === 'fr')
                                        <svg class="h-4 w-4 text-blue-600 ml-auto" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    @endif
                                </a>

                                <!-- English -->
                                <a href="{{ route('language.switch', 'en') }}"
                                   data-locale="en"
                                   data-no-jquery="true"
                                   class="{{ app()->getLocale() === 'en' ? 'bg-blue-50 text-blue-900' : 'text-gray-700 hover:bg-gray-100' }} w-full text-left px-4 py-2 text-sm font-medium flex items-center space-x-3"
                                   role="menuitem">
                                    <span class="text-lg">🇬🇧</span>
                                    <span>English</span>
                                    @if(app()->getLocale() === 'en')
                                        <svg class="h-4 w-4 text-blue-600 ml-auto" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    @endif
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-center mb-4">
                    <img src="{{ asset('images/blog-logo.jpeg') }}" alt="Unicorn Madagascar" class="h-12 w-auto rounded mr-2">
                    <span class="text-xl font-semibold text-gray-800">Unicorn Madagascar</span>
                </div>
                <p class="mt-2 text-sm text-gray-600">
                    @yield('subtitle')
                </p>
            </div>

            <!-- Flash messages -->
            @if (session('status'))
                <div
                    class="bg-green-50 border border-green-200 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-600">{{ session('status') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    {{ $error }} @if (!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Main content -->
            @yield('content')
        </div>
    </div>
</body>

</html>
