@extends('layouts.dashboard')

@section('title', __('messages.new_investment'))

@section('header')
    <div class="ml-4 flex items-center w-full">
        <div class="flex-1 min-w-0">
            <h1 class="text-xl sm:text-2xl font-semibold text-gray-900 truncate">
                {{ __('messages.new_investment') }}
            </h1>
        </div>
    </div>
@endsection

@section('content')
<div class="py-6">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow rounded-lg">
            <form action="{{ route('investments.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 p-6">
                @csrf

                <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                    <!-- Colonne de gauche -->
                    <div class="space-y-6">
                        <div>
                            <label for="operator" class="block text-sm font-medium text-gray-700">{{ __('messages.operator') }} *</label>
                            <select id="operator" name="operator" required
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">{{ __('messages.select_operator') }}</option>
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
                            <label for="investment_type" class="block text-sm font-medium text-gray-700">{{ __('messages.investment_type') }} *</label>
                            <select id="investment_type" name="investment_type" required
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">{{ __('messages.select_type') }}</option>
                                @foreach(\App\Models\Investment::getInvestmentTypes() as $type)
                                    <option value="{{ $type }}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="last_name" class="block text-sm font-medium text-gray-700">{{ __('messages.last_name') }} *</label>
                            <input type="text" id="last_name" name="last_name" required
                                   value="{{ old('last_name', $user->nom ?? '') }}"
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label for="first_name" class="block text-sm font-medium text-gray-700">{{ __('messages.first_name') }} *</label>
                            <input type="text" id="first_name" name="first_name" required
                                   value="{{ old('first_name', $user->prenom ?? '') }}"
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700">{{ __('messages.address') }} *</label>
                            <textarea id="address" name="address" rows="3" required
                                      class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('address', $user->adresse ?? '') }}</textarea>
                        </div>
                    </div>

                    <!-- Colonne de droite -->
                    <div class="space-y-6">
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">{{ __('messages.phone_number') }} *</label>
                            <input type="tel" id="phone" name="phone" required
                                   value="{{ old('phone', $user->telephone ?? '') }}"
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label for="id_number" class="block text-sm font-medium text-gray-700">{{ __('messages.id_number') }} *</label>
                            <input type="text" id="id_number" name="id_number" required
                                   value="{{ old('id_number', $user->numero_piece ?? '') }}"
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label for="id_photo" class="block text-sm font-medium text-gray-700">{{ __('messages.id_photo') }} *</label>
                            <input type="file" id="id_photo" name="id_photo" accept="image/*" required
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <p class="mt-1 text-sm text-gray-500">{{ __('messages.accepted_formats') }}</p>
                        </div>

                        <div>
                            <label for="transaction_phone" class="block text-sm font-medium text-gray-700">{{ __('messages.transaction_phone') }} *</label>
                            <input type="tel" id="transaction_phone" name="transaction_phone" required
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700">{{ __('messages.amount') }} *</label>
                            <input type="number" id="amount" name="amount" step="0.01" min="0" required
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <p id="amount-error" class="mt-1 text-sm text-red-600 hidden"></p>
                            <p id="amount-info" class="mt-1 text-sm text-gray-500"></p>
                        </div>

                        <div>
                            <label for="transaction_proof" class="block text-sm font-medium text-gray-700">{{ __('messages.transaction_proof') }} *</label>
                            <input type="file" id="transaction_proof" name="transaction_proof" accept="image/*" required
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <p class="mt-1 text-sm text-gray-500">{{ __('messages.accepted_formats') }}</p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between mt-8">
                    <a href="{{ route('investments.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg text-sm font-medium transition-colors flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        {{ __('messages.back') }}
                    </a>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg text-sm font-medium transition-colors flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                        {{ __('messages.submit_request') }}
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
    const investmentTypeSelect = document.querySelector('select[name="investment_type"]');
    const amountInput = document.querySelector('input[name="amount"]');
    const amountError = document.getElementById('amount-error');
    const amountInfo = document.getElementById('amount-info');

    // Pré-sélectionner le type d'investissement si passé en paramètre
    const urlParams = new URLSearchParams(window.location.search);
    const preselectedType = urlParams.get('type');
    if (preselectedType && investmentTypeSelect) {
        investmentTypeSelect.value = preselectedType;
        // Déclencher l'événement change pour valider le montant
        const event = new Event('change', { bubbles: true });
        investmentTypeSelect.dispatchEvent(event);
    }

    // Plages d'investissement en Ariary
    const investmentRanges = {
        'Silver': {
            min: 224200,
            max: 2237200,
            minUsd: 50,
            maxUsd: 499
        },
        'Gold': {
            min: 2241700,
            max: 3133800,
            minUsd: 500,
            maxUsd: 699
        },
        'Platinum': {
            min: 3138300,
            max: 4478800,
            minUsd: 700,
            maxUsd: 999
        },
        'Diamond': {
            min: 4483000,
            max: null,
            minUsd: 1000,
            maxUsd: null
        }
    };

    console.log('Éléments trouvés:', {
        operatorSelect: operatorSelect,
        operatorMessage: operatorMessage,
        operatorText: operatorText,
        investmentTypeSelect: investmentTypeSelect,
        amountInput: amountInput,
        amountError: amountError,
        amountInfo: amountInfo
    });

    // Fonction pour valider le montant selon le type
    function validateAmountForType() {
        const selectedType = investmentTypeSelect.value;
        const amount = parseFloat(amountInput.value);

        if (!selectedType) {
            amountError.classList.add('hidden');
            amountInfo.textContent = '';
            return true;
        }

        const range = investmentRanges[selectedType];

        if (!range) {
            amountError.classList.add('hidden');
            amountInfo.textContent = '';
            return true;
        }

        if (amount < range.min) {
            amountError.textContent = `{{ __('messages.amount_minimum_for_type') }} ${range.min.toLocaleString('fr-FR')} Ar (${range.minUsd} USD)`;
            amountError.classList.remove('hidden');
            amountInput.classList.add('border-red-500');
            return false;
        }

        if (range.max && amount > range.max) {
            amountError.textContent = `{{ __('messages.amount_maximum_for_type') }} ${range.max.toLocaleString('fr-FR')} Ar (${range.maxUsd} USD)`;
            amountError.classList.remove('hidden');
            amountInput.classList.add('border-red-500');
            return false;
        }

        amountError.classList.add('hidden');
        amountInput.classList.remove('border-red-500');

        if (range.max) {
            amountInfo.textContent = `{{ __('messages.range') }} ${range.min.toLocaleString('fr-FR')} - ${range.max.toLocaleString('fr-FR')} Ar (${range.minUsd} - ${range.maxUsd} USD)`;
        } else {
            amountInfo.textContent = `{{ __('messages.minimum') }} ${range.min.toLocaleString('fr-FR')} Ar (${range.minUsd} USD)`;
        }

        return true;
    }

    // Événement pour le changement d'opérateur
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
                    operatorText.textContent = `{{ __('messages.send_money_to') }} ${operatorPhones[selectedOperator]}{{ __('messages.in_the_name_of') }} Harifidy Razafindranaivo{{ __('messages.then_follow_instructions') }}`;
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
    }

    // Événement pour le changement de type d'investissement
    if (investmentTypeSelect && amountInput) {
        investmentTypeSelect.addEventListener('change', function() {
            console.log('Type d\'investissement changé:', this.value);
            validateAmountForType();
        });

        // Validation lors de la saisie du montant
        amountInput.addEventListener('input', function() {
            validateAmountForType();
        });

        // Validation initiale
        validateAmountForType();
    }

    if (!operatorSelect || !operatorMessage || !operatorText || !investmentTypeSelect || !amountInput) {
        console.error('Certains éléments n\'ont pas été trouvés');
    }
});
</script>
@endpush
@endsection
