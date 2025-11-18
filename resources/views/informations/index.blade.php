@extends('layouts.dashboard')

@section('title', 'Mes informations')

@section('header')
    <div class="ml-4 flex items-center">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Mes informations</h1>
    </div>
@endsection

@section('content')
<div class="py-6">
    <div class="px-4 sm:px-6 lg:px-8">
        <!-- Welcome section -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                Bon retour, {{ $user->prenom }} {{ $user->nom }}!
            </h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Consultez et gérez vos informations personnelles.
            </p>
        </div>

        <!-- Actions Header -->
        <div class="mb-6 flex items-center justify-between">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Détails de vos informations</h3>
            <div class="flex space-x-3">
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

        <!-- User Information Card -->
        <div class="mb-8 bg-white dark:bg-gray-800 shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Vos informations</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Basic Information -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-4">Informations de base</h4>
                        <dl class="space-y-3">
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600 dark:text-gray-400">Code client</dt>
                                <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->code_utilisateur }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600 dark:text-gray-400">Nom d'utilisateur</dt>
                                <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->username }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600 dark:text-gray-400">Email</dt>
                                <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->email }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600 dark:text-gray-400">Téléphone</dt>
                                <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->telephone ?? '-' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600 dark:text-gray-400">Statut</dt>
                                <dd>
                                    @if($user->statut)
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">Vérifié</span>
                                    @else
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100">En attente de validation</span>
                                    @endif
                                </dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Personal Information -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-4">Informations personnelles</h4>
                        <dl class="space-y-3">
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600 dark:text-gray-400">Date de naissance</dt>
                                <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->date_naissance ? $user->date_naissance->format('d/m/Y') : '-' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600 dark:text-gray-400">Lieu de naissance</dt>
                                <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->lieu_naissance ?? '-' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600 dark:text-gray-400">Nationalité</dt>
                                <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->nationalite ?? '-' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600 dark:text-gray-400">Profession</dt>
                                <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->profession ?? '-' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600 dark:text-gray-400">Adresse</dt>
                                <dd class="text-sm font-medium text-gray-900 dark:text-white text-xs">{{ $user->adresse ?? '-' }}</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Identity Information -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-4">Pièce d'identité</h4>
                        <dl class="space-y-3">
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600 dark:text-gray-400">Type de pièce</dt>
                                <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->piece_identite ?? '-' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600 dark:text-gray-400">Numéro de pièce</dt>
                                <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->numero_piece ?? '-' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600 dark:text-gray-400">Date de délivrance</dt>
                                <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->date_delivrance ? $user->date_delivrance->format('d/m/Y') : '-' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600 dark:text-gray-400">Lieu de délivrance</dt>
                                <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->lieu_delivrance ?? '-' }}</dd>
                            </div>
                            @if($user->date_validation)
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-600 dark:text-gray-400">Validé le</dt>
                                    <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->date_validation->format('d/m/Y H:i') }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                </div>

                @if($user->notes)
                    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-2">Notes</h4>
                        <p class="text-sm text-gray-700 dark:text-gray-300">{{ $user->notes }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
