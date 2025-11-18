@extends('layouts.dashboard')

@section('title', 'Détails du Client')

@section('header')
    <div class="ml-4 flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Détails du Client</h1>
        <div class="flex space-x-3">
            @if(Auth::user()->role === 'administrateur')
                <a href="{{ route('clients.edit', $client) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Modifier
                </a>
            @endif
            <a href="{{ route('dashboard') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Retour
            </a>
        </div>
    </div>
@endsection

@section('content')
<div class="py-6">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Informations de base -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Informations de base</h3>
                </div>
                <div class="p-6">
                    <dl class="space-y-4">
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Code Client</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $client->code_utilisateur }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nom</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $client->nom }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Prénom</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $client->prenom }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nom d'utilisateur</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $client->username }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $client->email }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Téléphone</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $client->telephone ?? '-' }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Adresse</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $client->adresse ?? '-' }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Statut</dt>
                            <dd>
                                @if($client->statut)
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">Vérifié</span>
                                @else
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100">En attente de validation</span>
                                @endif
                            </dd>
                        </div>
                        @if($client->date_validation)
                            <div class="flex justify-between">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Date de validation</dt>
                                <dd class="text-sm text-gray-900 dark:text-white">{{ $client->date_validation->format('d/m/Y H:i') }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Validé par</dt>
                                <dd class="text-sm text-gray-900 dark:text-white">{{ $client->validatedBy ? $client->validatedBy->nom . ' ' . $client->validatedBy->prenom : '-' }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>
            </div>

            <!-- Informations personnelles -->
            <div class="space-y-6">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Informations personnelles</h3>
                    </div>
                    <div class="p-6">
                        <dl class="space-y-4">
                            <div class="flex justify-between">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Date de naissance</dt>
                                <dd class="text-sm text-gray-900 dark:text-white">{{ $client->date_naissance ? $client->date_naissance->format('d/m/Y') : '-' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Lieu de naissance</dt>
                                <dd class="text-sm text-gray-900 dark:text-white">{{ $client->lieu_naissance ?? '-' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nationalité</dt>
                                <dd class="text-sm text-gray-900 dark:text-white">{{ $client->nationalite ?? '-' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Profession</dt>
                                <dd class="text-sm text-gray-900 dark:text-white">{{ $client->profession ?? '-' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Pièce d'identité</h3>
                    </div>
                    <div class="p-6">
                        <dl class="space-y-4">
                            <div class="flex justify-between">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Type de pièce</dt>
                                <dd class="text-sm text-gray-900 dark:text-white">{{ $client->piece_identite ?? '-' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Numéro de pièce</dt>
                                <dd class="text-sm text-gray-900 dark:text-white">{{ $client->numero_piece ?? '-' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Date de délivrance</dt>
                                <dd class="text-sm text-gray-900 dark:text-white">{{ $client->date_delivrance ? $client->date_delivrance->format('d/m/Y') : '-' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Lieu de délivrance</dt>
                                <dd class="text-sm text-gray-900 dark:text-white">{{ $client->lieu_delivrance ?? '-' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        @if($client->notes)
            <div class="mt-6 bg-white dark:bg-gray-800 shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Notes</h3>
                </div>
                <div class="p-6">
                    <p class="text-sm text-gray-700 dark:text-gray-300">{{ $client->notes }}</p>
                </div>
            </div>
        @endif

        @if(Auth::user()->role === 'administrateur')
            <div class="mt-6 bg-white dark:bg-gray-800 shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Actions d'administration</h3>
                </div>
                <div class="p-6">
                    <div class="flex flex-wrap gap-3">
                        @if($client->statut)
                            <form action="{{ route('clients.unverify', $client) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors"
                                        onclick="return confirm('Êtes-vous sûr de vouloir dévérifier ce client?')">
                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Dévérifier le client
                                </button>
                            </form>
                        @else
                            <form action="{{ route('clients.verify', $client) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors"
                                        onclick="return confirm('Êtes-vous sûr de vouloir vérifier ce client?')">
                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Vérifier le client
                                </button>
                            </form>
                        @endif

                        <form action="{{ route('clients.destroy', $client) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors"
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce client? Cette action est irréversible.')">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Supprimer le client
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
