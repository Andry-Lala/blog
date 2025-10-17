@extends('layouts.auth')

@section('title', 'Connexion')

@section('subtitle', 'Connectez-vous à votre compte')

@section('content')
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-8 max-w-md mx-auto">
        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Username/Email -->
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Nom d'utilisateur ou Email
                </label>
                <div class="mt-1">
                    <input id="username" name="username" type="text" autocomplete="username" required
                        value="{{ old('username') }}"
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white">
                </div>
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Mot de passe
                </label>
                <div class="mt-1">
                    <input id="password" name="password" type="password" autocomplete="current-password" required
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white">
                </div>
            </div>

            <!-- Remember me -->
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox"
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 rounded">
                    <label for="remember" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">
                        Se souvenir de moi
                    </label>
                </div>

                @if (Route::has('password.request'))
                    <div class="text-sm">
                        <a href="{{ route('password.request') }}"
                            class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">
                            Mot de passe oublié?
                        </a>
                    </div>
                @endif
            </div>

            <!-- Submit button -->
            <div>
                <button type="submit"
                    class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                    </span>
                    Se connecter
                </button>
            </div>

            <!-- Register link -->
            <div class="text-center">
                <span class="text-sm text-gray-600 dark:text-gray-400">
                    Pas encore de compte?
                    <a href="{{ route('register') }}"
                        class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">
                        S'inscrire
                    </a>
                </span>
            </div>
        </form>
    </div>
@endsection
