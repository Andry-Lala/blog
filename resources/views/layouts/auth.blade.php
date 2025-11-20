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
</head>

<body class="bg-gray-50 text-gray-900">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full space-y-8">
            <!-- Header -->
            <div class="text-center">
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
