@extends('layouts.auth')

@section('title', 'Inscription')

@section('subtitle', 'Créez votre compte client')

@section('content')
<div class="bg-white shadow rounded-lg w-full max-w-7xl mx-auto">
    <form method="POST" action="{{ route('register') }}" class="p-8">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Informations de base -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-6 pb-2 border-b border-gray-200">Informations de base</h3>

                <div class="space-y-4">
                    <div>
                        <label for="nom" class="block text-sm font-medium text-gray-600">Nom *</label>
                        <input type="text"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 @error('nom') border-red-500 @enderror"
                               id="nom" name="nom" value="{{ old('nom') }}" required>
                        @error('nom')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="prenom" class="block text-sm font-medium text-gray-600">Prénom *</label>
                        <input type="text"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 @error('prenom') border-red-500 @enderror"
                               id="prenom" name="prenom" value="{{ old('prenom') }}" required>
                        @error('prenom')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-600">Nom d'utilisateur *</label>
                        <input type="text"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 @error('username') border-red-500 @enderror"
                               id="username" name="username" value="{{ old('username') }}" required>
                        @error('username')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-600">Email *</label>
                        <input type="email"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 @error('email') border-red-500 @enderror"
                               id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="telephone" class="block text-sm font-medium text-gray-600">Téléphone</label>
                        <input type="text"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 @error('telephone') border-red-500 @enderror"
                               id="telephone" name="telephone" value="{{ old('telephone') }}">
                        @error('telephone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="adresse" class="block text-sm font-medium text-gray-600">Adresse</label>
                        <textarea
                                  class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 @error('adresse') border-red-500 @enderror"
                                  id="adresse" name="adresse" rows="3">{{ old('adresse') }}</textarea>
                        @error('adresse')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Informations personnelles -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-6 pb-2 border-b border-gray-200">Informations personnelles</h3>

                <div class="space-y-4">
                    <div>
                        <label for="date_naissance" class="block text-sm font-medium text-gray-600">Date de naissance</label>
                        <input type="date"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 @error('date_naissance') border-red-500 @enderror"
                               id="date_naissance" name="date_naissance" value="{{ old('date_naissance') }}">
                        @error('date_naissance')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="lieu_naissance" class="block text-sm font-medium text-gray-600">Lieu de naissance</label>
                        <input type="text"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 @error('lieu_naissance') border-red-500 @enderror"
                               id="lieu_naissance" name="lieu_naissance" value="{{ old('lieu_naissance') }}">
                        @error('lieu_naissance')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nationalite" class="block text-sm font-medium text-gray-600">Nationalité</label>
                        <input type="text"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 @error('nationalite') border-red-500 @enderror"
                               id="nationalite" name="nationalite" value="{{ old('nationalite') }}">
                        @error('nationalite')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="profession" class="block text-sm font-medium text-gray-600">Profession</label>
                        <input type="text"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 @error('profession') border-red-500 @enderror"
                               id="profession" name="profession" value="{{ old('profession') }}">
                        @error('profession')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <h3 class="text-lg font-medium text-gray-900 mb-6 mt-8 pb-2 border-b border-gray-200">Pièce d'identité</h3>

                <div class="space-y-4">
                    <div>
                        <label for="piece_identite" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Type de pièce</label>
                        <select
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 @error('piece_identite') border-red-500 @enderror"
                                id="piece_identite" name="piece_identite">
                            <option value="">Sélectionner...</option>
                            <option value="CNI" {{ old('piece_identite') == 'CNI' ? 'selected' : '' }}>CNI</option>
                            <option value="Passeport" {{ old('piece_identite') == 'Passeport' ? 'selected' : '' }}>Passeport</option>
                            <option value="Permis" {{ old('piece_identite') == 'Permis' ? 'selected' : '' }}>Permis</option>
                        </select>
                        @error('piece_identite')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="numero_piece" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Numéro de pièce</label>
                        <input type="text"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 @error('numero_piece') border-red-500 @enderror"
                               id="numero_piece" name="numero_piece" value="{{ old('numero_piece') }}">
                        @error('numero_piece')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="date_delivrance" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date de délivrance</label>
                        <input type="date"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 @error('date_delivrance') border-red-500 @enderror"
                               id="date_delivrance" name="date_delivrance" value="{{ old('date_delivrance') }}">
                        @error('date_delivrance')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="lieu_delivrance" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Lieu de délivrance</label>
                        <input type="text"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 @error('lieu_delivrance') border-red-500 @enderror"
                               id="lieu_delivrance" name="lieu_delivrance" value="{{ old('lieu_delivrance') }}">
                        @error('lieu_delivrance')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Mot de passe -->
        <div class="mt-8">
            <h3 class="text-lg font-medium text-gray-900 mb-6 pb-2 border-b border-gray-200">Mot de passe</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-600">Mot de passe *</label>
                    <input type="password"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 @error('password') border-red-500 @enderror"
                           id="password" name="password" required>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-600">Confirmer le mot de passe *</label>
                    <input type="password"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 @error('password_confirmation') border-red-500 @enderror"
                           id="password_confirmation" name="password_confirmation" required>
                    @error('password_confirmation')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Notes -->
        <div class="mt-8">
            <label for="notes" class="block text-sm font-medium text-gray-600">Notes</label>
            <textarea
                      class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 @error('notes') border-red-500 @enderror"
                      id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
            @error('notes')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Actions -->
        <div class="mt-8 space-y-4">
            <button
                type="submit"
                class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-400"
            >
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
                Créer mon compte
            </button>

            <!-- Login link -->
            <div class="text-center">
                <span class="text-sm text-gray-500">
                    Déjà un compte?
                    <a href="{{ route('login') }}" class="font-medium text-blue-500 hover:text-blue-600">
                        Se connecter
                    </a>
                </span>
            </div>
        </div>
    </form>
</div>
@endsection
