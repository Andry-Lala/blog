@extends('layouts.dashboard')

@section('title', 'Mes informations')

@section('header')
    <h1 class="ml-4 text-2xl font-semibold text-gray-900 dark:text-white">Mes informations</h1>
@endsection

@section('content')
<div class="py-6">
    <div class="px-4 sm:px-6 lg:px-8">
        <!-- Welcome section -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                Bon retour, {{ $user->prenom }} {{ $user->nom }}!
            </h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Consultez et gérez vos informations personnelles.
            </p>
        </div>

        <!-- User Information Card -->
        <div class="mb-8 bg-white dark:bg-gray-800 shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Vos informations</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Basic Info -->
                    <div class="space-y-3">
                        <h4 class="text-sm font-medium text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-600 pb-2">Informations de base</h4>
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500 dark:text-gray-400">Code client:</span>
                                <span class="text-gray-900 dark:text-white font-medium">{{ $user->code_utilisateur }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500 dark:text-gray-400">Nom d'utilisateur:</span>
                                <span class="text-gray-900 dark:text-white">{{ $user->username }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500 dark:text-gray-400">Email:</span>
                                <span class="text-gray-900 dark:text-white">{{ $user->email }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500 dark:text-gray-400">Téléphone:</span>
                                <span class="text-gray-900 dark:text-white">{{ $user->telephone ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500 dark:text-gray-400">Statut:</span>
                                <span>
                                    @if($user->statut)
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">Vérifié</span>
                                    @else
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100">En attente de validation</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Personal Info -->
                    <div class="space-y-3">
                        <h4 class="text-sm font-medium text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-600 pb-2">Informations personnelles</h4>
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500 dark:text-gray-400">Date de naissance:</span>
                                <span class="text-gray-900 dark:text-white">{{ $user->date_naissance ? $user->date_naissance->format('d/m/Y') : '-' }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500 dark:text-gray-400">Lieu de naissance:</span>
                                <span class="text-gray-900 dark:text-white">{{ $user->lieu_naissance ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500 dark:text-gray-400">Nationalité:</span>
                                <span class="text-gray-900 dark:text-white">{{ $user->nationalite ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500 dark:text-gray-400">Profession:</span>
                                <span class="text-gray-900 dark:text-white">{{ $user->profession ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500 dark:text-gray-400">Adresse:</span>
                                <span class="text-gray-900 dark:text-white text-xs">{{ $user->adresse ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Identity Info -->
                    <div class="space-y-3">
                        <h4 class="text-sm font-medium text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-600 pb-2">Pièce d'identité</h4>
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500 dark:text-gray-400">Type de pièce:</span>
                                <span class="text-gray-900 dark:text-white">{{ $user->piece_identite ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500 dark:text-gray-400">Numéro de pièce:</span>
                                <span class="text-gray-900 dark:text-white">{{ $user->numero_piece ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500 dark:text-gray-400">Date de délivrance:</span>
                                <span class="text-gray-900 dark:text-white">{{ $user->date_delivrance ? $user->date_delivrance->format('d/m/Y') : '-' }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500 dark:text-gray-400">Lieu de délivrance:</span>
                                <span class="text-gray-900 dark:text-white">{{ $user->lieu_delivrance ?? '-' }}</span>
                            </div>
                            @if($user->date_validation)
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500 dark:text-gray-400">Validé le:</span>
                                    <span class="text-gray-900 dark:text-white">{{ $user->date_validation->format('d/m/Y H:i') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                @if($user->notes)
                    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-2">Notes</h4>
                        <p class="text-sm text-gray-700 dark:text-gray-300">{{ $user->notes }}</p>
                    </div>
                @endif
<!-- Action Buttons -->
<div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
    <div class="flex flex-wrap gap-3">
        <a href="{{ route('dashboard') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Retour
        </a>
        <a href="{{ route('clients.show', $user) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
            </svg>
            Modifier
        </a>

    </div>
</div>
            </div>
        </div>
    </div>
</div>
@endsection
