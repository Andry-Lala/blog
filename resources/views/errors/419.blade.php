@extends('layouts.auth')

@section('title', 'Session expirée')

@section('subtitle', 'Votre session a expiré')

@section('content')
    <div class="bg-white shadow rounded-lg p-8 max-w-md mx-auto">
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Session expirée</h3>
            <p class="text-sm text-gray-600 mb-6">
                Votre session a expiré pour des raisons de sécurité. Veuillez vous reconnecter pour continuer.
            </p>
            <div class="space-y-3">
                <a href="{{ route('login') }}" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-400">
                    Se reconnecter
                </a>
                <a href="{{ url('/') }}" class="w-full flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-400">
                    Retour à l'accueil
                </a>
            </div>
        </div>
    </div>
@endsection
