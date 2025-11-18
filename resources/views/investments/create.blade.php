@extends('layouts.dashboard')

@section('title', 'Nouvel Investissement')

@section('header')
    <div class="ml-4 flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Nouvel Investissement</h1>
        <a href="{{ route('investments.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
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
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
            <form action="{{ route('investments.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 p-6">
                @csrf

                <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                    <!-- Colonne de gauche -->
                    <div class="space-y-6">
                        <div>
                            <label for="operator" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Opérateur *</label>
                            <select id="operator" name="operator" required
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                <option value="">Sélectionner un opérateur</option>
                                @foreach(\App\Models\Investment::getOperators() as $operator)
                                    <option value="{{ $operator }}">{{ $operator }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div id="operator-message" class="hidden mt-2 bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-lg">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-blue-800" id="operator-text"></p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="investment_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Type d'investissement *</label>
                            <select id="investment_type" name="investment_type" required
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                <option value="">Sélectionner un type</option>
                                @foreach(\App\Models\Investment::getInvestmentTypes() as $type)
                                    <option value="{{ $type }}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nom *</label>
                            <input type="text" id="last_name" name="last_name" required
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                        </div>

                        <div>
                            <label for="first_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Prénom *</label>
                            <input type="text" id="first_name" name="first_name" required
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                        </div>

                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Adresse *</label>
                            <textarea id="address" name="address" rows="3" required
                                      class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"></textarea>
                        </div>
                    </div>

                    <!-- Colonne de droite -->
                    <div class="space-y-6">
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Numéro de téléphone *</label>
                            <input type="tel" id="phone" name="phone" required
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                        </div>

                        <div>
                            <label for="id_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Numéro de la pièce d'identité (CIN ou Passeport) *</label>
                            <input type="text" id="id_number" name="id_number" required
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                        </div>

                        <div>
                            <label for="id_photo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Photo de la pièce d'identité *</label>
                            <input type="file" id="id_photo" name="id_photo" accept="image/*" required
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Formats acceptés: JPG, PNG, GIF (Max: 2MB)</p>
                        </div>

                        <div>
                            <label for="transaction_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Numéro de téléphone utilisé pour la transaction *</label>
                            <input type="tel" id="transaction_phone" name="transaction_phone" required
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                        </div>

                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Montant *</label>
                            <input type="number" id="amount" name="amount" step="0.01" min="0" required
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                        </div>

                        <div>
                            <label for="transaction_proof" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Capture de la transaction *</label>
                            <input type="file" id="transaction_proof" name="transaction_proof" accept="image/*" required
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Formats acceptés: JPG, PNG, GIF (Max: 2MB)</p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between mt-8">
                    <a href="{{ route('investments.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg text-sm font-medium transition-colors flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Retour
                    </a>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg text-sm font-medium transition-colors flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                        Soumettre la demande
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Attendre que le DOM soit complètement chargé
window.addEventListener('load', function() {
    console.log('Script exécuté après chargement complet');

    // Sélecteurs plus robustes
    const operatorSelect = document.querySelector('select[name="operator"]');
    const operatorMessage = document.getElementById('operator-message');
    const operatorText = document.getElementById('operator-text');

    console.log('Éléments trouvés:', {
        operatorSelect: operatorSelect,
        operatorMessage: operatorMessage,
        operatorText: operatorText
    });

    if (operatorSelect && operatorMessage && operatorText) {
        operatorSelect.addEventListener('change', function() {
            console.log('Opérateur changé:', this.value);
            const selectedOperator = this.value;

            if (selectedOperator) {
                const operatorPhones = {
                    'Orange': '+261 32 30 793 54',
                    'Yas': '+261 38 27 114 48',
                    'Airtel': '+261 33 93 070 74'
                };

                if (operatorPhones[selectedOperator]) {
                    operatorText.textContent = `Veuillez envoyer l'argent au numéro ${operatorPhones[selectedOperator]} et suivre les instructions jusqu'à confirmation de l'envoi.`;
                    operatorMessage.classList.remove('hidden');
                    operatorMessage.classList.add('block');
                    console.log('Message affiché pour:', selectedOperator);
                } else {
                    operatorMessage.classList.add('hidden');
                    console.log('Opérateur non trouvé:', selectedOperator);
                }
            } else {
                operatorMessage.classList.add('hidden');
                console.log('Aucun opérateur sélectionné');
            }
        });
    } else {
        console.error('Certains éléments n\'ont pas été trouvés');
    }
});
</script>
@endpush
@endsection
