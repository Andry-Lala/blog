@extends('layouts.dashboard')

@section('title', 'Modifier un Client')

@section('header')
    <div class="ml-4 flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900 ">Modifier le Client</h1>
        <a href="{{ route('clients.show', $client) }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Retour
        </a>
    </div>
@endsection

@section('content')
<div class="py-6">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="bg-white   shadow rounded-lg">
            <form action="{{ route('clients.update', $client) }}" method="POST" class="p-6">
                @csrf
                @method('PATCH')
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Informations de base -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900   mb-6 pb-2 border-b border-gray-200  ">Informations de base</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="nom" class="block text-sm font-medium text-gray-700  ">Nom *</label>
                                <input type="text" 
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300   rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500     @error('nom') border-red-500 @enderror" 
                                       id="nom" name="nom" value="{{ old('nom', $client->nom) }}" required>
                                @error('nom')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="prenom" class="block text-sm font-medium text-gray-700  ">Prénom *</label>
                                <input type="text" 
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300   rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500     @error('prenom') border-red-500 @enderror" 
                                       id="prenom" name="prenom" value="{{ old('prenom', $client->prenom) }}" required>
                                @error('prenom')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="username" class="block text-sm font-medium text-gray-700  ">Nom d'utilisateur *</label>
                                <input type="text" 
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300   rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500     @error('username') border-red-500 @enderror" 
                                       id="username" name="username" value="{{ old('username', $client->username) }}" required>
                                @error('username')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700  ">Email *</label>
                                <input type="email" 
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300   rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500     @error('email') border-red-500 @enderror" 
                                       id="email" name="email" value="{{ old('email', $client->email) }}" required>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="telephone" class="block text-sm font-medium text-gray-700  ">Téléphone</label>
                                <input type="text" 
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300   rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500     @error('telephone') border-red-500 @enderror" 
                                       id="telephone" name="telephone" value="{{ old('telephone', $client->telephone) }}">
                                @error('telephone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="adresse" class="block text-sm font-medium text-gray-700  ">Adresse</label>
                                <textarea 
                                          class="mt-1 block w-full px-3 py-2 border border-gray-300   rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500     @error('adresse') border-red-500 @enderror" 
                                          id="adresse" name="adresse" rows="3">{{ old('adresse', $client->adresse) }}</textarea>
                                @error('adresse')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Informations personnelles -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900   mb-6 pb-2 border-b border-gray-200  ">Informations personnelles</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="date_naissance" class="block text-sm font-medium text-gray-700  ">Date de naissance</label>
                                <input type="date" 
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300   rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500     @error('date_naissance') border-red-500 @enderror" 
                                       id="date_naissance" name="date_naissance" value="{{ old('date_naissance', $client->date_naissance?->format('Y-m-d')) }}">
                                @error('date_naissance')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="lieu_naissance" class="block text-sm font-medium text-gray-700  ">Lieu de naissance</label>
                                <input type="text" 
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300   rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500     @error('lieu_naissance') border-red-500 @enderror" 
                                       id="lieu_naissance" name="lieu_naissance" value="{{ old('lieu_naissance', $client->lieu_naissance) }}">
                                @error('lieu_naissance')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="nationalite" class="block text-sm font-medium text-gray-700  ">Nationalité</label>
                                <input type="text" 
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300   rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500     @error('nationalite') border-red-500 @enderror" 
                                       id="nationalite" name="nationalite" value="{{ old('nationalite', $client->nationalite) }}">
                                @error('nationalite')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="profession" class="block text-sm font-medium text-gray-700  ">Profession</label>
                                <input type="text" 
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300   rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500     @error('profession') border-red-500 @enderror" 
                                       id="profession" name="profession" value="{{ old('profession', $client->profession) }}">
                                @error('profession')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <h3 class="text-lg font-medium text-gray-900   mb-6 mt-8 pb-2 border-b border-gray-200  ">Pièce d'identité</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="piece_identite" class="block text-sm font-medium text-gray-700  ">Type de pièce</label>
                                <select 
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300   rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500     @error('piece_identite') border-red-500 @enderror" 
                                        id="piece_identite" name="piece_identite">
                                    <option value="">Sélectionner...</option>
                                    <option value="CNI" {{ old('piece_identite', $client->piece_identite) == 'CNI' ? 'selected' : '' }}>CNI</option>
                                    <option value="Passeport" {{ old('piece_identite', $client->piece_identite) == 'Passeport' ? 'selected' : '' }}>Passeport</option>
                                    <option value="Permis" {{ old('piece_identite', $client->piece_identite) == 'Permis' ? 'selected' : '' }}>Permis</option>
                                </select>
                                @error('piece_identite')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="numero_piece" class="block text-sm font-medium text-gray-700  ">Numéro de pièce</label>
                                <input type="text" 
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300   rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500     @error('numero_piece') border-red-500 @enderror" 
                                       id="numero_piece" name="numero_piece" value="{{ old('numero_piece', $client->numero_piece) }}">
                                @error('numero_piece')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="date_delivrance" class="block text-sm font-medium text-gray-700  ">Date de délivrance</label>
                                <input type="date" 
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300   rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500     @error('date_delivrance') border-red-500 @enderror" 
                                       id="date_delivrance" name="date_delivrance" value="{{ old('date_delivrance', $client->date_delivrance?->format('Y-m-d')) }}">
                                @error('date_delivrance')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="lieu_delivrance" class="block text-sm font-medium text-gray-700  ">Lieu de délivrance</label>
                                <input type="text" 
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300   rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500     @error('lieu_delivrance') border-red-500 @enderror" 
                                       id="lieu_delivrance" name="lieu_delivrance" value="{{ old('lieu_delivrance', $client->lieu_delivrance) }}">
                                @error('lieu_delivrance')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mot de passe -->
                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-900   mb-6 pb-2 border-b border-gray-200  ">Mot de passe</h3>
                    <p class="text-sm text-gray-600   mb-4">Laissez vide si vous ne souhaitez pas modifier le mot de passe</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700  ">Nouveau mot de passe</label>
                            <input type="password" 
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300   rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500     @error('password') border-red-500 @enderror" 
                                   id="password" name="password">
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700  ">Confirmer le mot de passe</label>
                            <input type="password" 
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300   rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500     @error('password_confirmation') border-red-500 @enderror" 
                                   id="password_confirmation" name="password_confirmation">
                            @error('password_confirmation')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                <div class="mt-8">
                    <label for="notes" class="block text-sm font-medium text-gray-700  ">Notes</label>
                    <textarea 
                              class="mt-1 block w-full px-3 py-2 border border-gray-300   rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500     @error('notes') border-red-500 @enderror" 
                              id="notes" name="notes" rows="3">{{ old('notes', $client->notes) }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="mt-8 flex justify-end space-x-4">
                    <a href="{{ route('clients.show', $client) }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg text-sm font-medium transition-colors">
                        Annuler
                    </a>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg text-sm font-medium transition-colors">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection