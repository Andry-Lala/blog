@extends('layouts.auth')

@section('title', __('messages.register'))

@section('subtitle', __('messages.create_account'))

@section('content')
<div class="bg-white shadow rounded-lg w-full max-w-7xl mx-auto">
    <form method="POST" action="{{ route('register') }}" class="p-8">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Informations de base -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-6 pb-2 border-b border-gray-200">{{ __('messages.basic_information') }}</h3>

                <div class="space-y-4">
                    <div>
                        <label for="nom" class="block text-sm font-medium text-gray-600">{{ __('messages.last_name') }} *</label>
                        <input type="text"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 @error('nom') border-red-500 @enderror"
                               id="nom" name="nom" value="{{ old('nom') }}" required minlength="2" maxlength="255"
                               pattern="[a-zA-ZÀ-ÿ\s\-\'\.]+" placeholder="{{ __('messages.name_placeholder') }}">
                        @error('nom')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="prenom" class="block text-sm font-medium text-gray-600">{{ __('messages.first_name') }} *</label>
                        <input type="text"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 @error('prenom') border-red-500 @enderror"
                               id="prenom" name="prenom" value="{{ old('prenom') }}" required minlength="2" maxlength="255"
                               pattern="[a-zA-ZÀ-ÿ\s\-\'\.]+" placeholder="{{ __('messages.firstname_placeholder') }}">
                        @error('prenom')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-600">{{ __('messages.username') }} *</label>
                        <input type="text"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 @error('username') border-red-500 @enderror"
                               id="username" name="username" value="{{ old('username') }}" required minlength="3" maxlength="255"
                               pattern="[a-zA-Z0-9_\-\.]+" placeholder="{{ __('messages.username_placeholder') }}">
                        @error('username')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-600">{{ __('messages.email') }} *</label>
                        <input type="email"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 @error('email') border-red-500 @enderror"
                               id="email" name="email" value="{{ old('email') }}" required maxlength="255"
                               placeholder="{{ __('messages.email_placeholder') }}">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="telephone" class="block text-sm font-medium text-gray-600">{{ __('messages.phone') }} *</label>
                        <input type="tel"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 @error('telephone') border-red-500 @enderror"
                               id="telephone" name="telephone" value="{{ old('telephone') }}"
                               required minlength="10" maxlength="20" pattern="[+]?[0-9\s\-\(\)]+"
                               placeholder="{{ __('messages.phone_placeholder') }}">
                        @error('telephone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="adresse" class="block text-sm font-medium text-gray-600">{{ __('messages.address') }} *</label>
                        <textarea
                                  class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 @error('adresse') border-red-500 @enderror"
                                  id="adresse" name="adresse" rows="3" required minlength="5" maxlength="500"
                                  placeholder="{{ __('messages.address_placeholder') }}">{{ old('adresse') }}</textarea>
                        @error('adresse')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Informations personnelles -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-6 pb-2 border-b border-gray-200">{{ __('messages.personal_information') }}</h3>

                <div class="space-y-4">
                    <div>
                        <label for="date_naissance" class="block text-sm font-medium text-gray-600">{{ __('messages.birth_date') }}</label>
                        <input type="date"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 @error('date_naissance') border-red-500 @enderror"
                               id="date_naissance" name="date_naissance" value="{{ old('date_naissance') }}"
                               max="{{ date('Y-m-d') }}" min="1900-01-01">
                        @error('date_naissance')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="lieu_naissance" class="block text-sm font-medium text-gray-600">{{ __('messages.birth_place') }}</label>
                        <input type="text"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 @error('lieu_naissance') border-red-500 @enderror"
                               id="lieu_naissance" name="lieu_naissance" value="{{ old('lieu_naissance') }}"
                               minlength="2" maxlength="255" placeholder="Antananarivo">
                        @error('lieu_naissance')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nationalite" class="block text-sm font-medium text-gray-600">{{ __('messages.nationality') }}</label>
                        <input type="text"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 @error('nationalite') border-red-500 @enderror"
                               id="nationalite" name="nationalite" value="{{ old('nationalite') }}"
                               minlength="2" maxlength="255" placeholder="Malagasy">
                        @error('nationalite')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="profession" class="block text-sm font-medium text-gray-600">{{ __('messages.profession') }}</label>
                        <input type="text"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 @error('profession') border-red-500 @enderror"
                               id="profession" name="profession" value="{{ old('profession') }}"
                               minlength="2" maxlength="255" placeholder="Développeur">
                        @error('profession')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <h3 class="text-lg font-medium text-black mb-6 mt-8 pb-2 border-b border-gray-200">{{ __('messages.identity_document') }}</h3>

                <div class="space-y-4">
                    <div>
                        <label for="piece_identite" class="block text-sm font-medium text-black">{{ __('messages.document_type') }} *</label>
                        <select
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 @error('piece_identite') border-red-500 @enderror"
                                id="piece_identite" name="piece_identite" required>
                            <option value="">Sélectionner...</option>
                            <option value="CIN" {{ old('piece_identite') == 'CIN' ? 'selected' : '' }}>CIN (Carte d'Identité Nationale)</option>
                            <option value="Passeport" {{ old('piece_identite') == 'Passeport' ? 'selected' : '' }}>Passeport</option>
                            <option value="Permis" {{ old('piece_identite') == 'Permis' ? 'selected' : '' }}>Permis</option>
                        </select>
                        @error('piece_identite')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="numero_piece" class="block text-sm font-medium text-black">{{ __('messages.document_number') }} *</label>
                        <input type="text"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 @error('numero_piece') border-red-500 @enderror"
                               id="numero_piece" name="numero_piece" value="{{ old('numero_piece') }}"
                               required minlength="5" maxlength="50" placeholder="1234567890123">
                        @error('numero_piece')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="date_delivrance" class="block text-sm font-medium text-black">{{ __('messages.issue_date') }} *</label>
                        <input type="date"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 @error('date_delivrance') border-red-500 @enderror"
                               id="date_delivrance" name="date_delivrance" value="{{ old('date_delivrance') }}"
                               required max="{{ date('Y-m-d') }}" min="1900-01-01">
                        @error('date_delivrance')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="lieu_delivrance" class="block text-sm font-medium text-black">{{ __('messages.issue_place') }} *</label>
                        <input type="text"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 @error('lieu_delivrance') border-red-500 @enderror"
                               id="lieu_delivrance" name="lieu_delivrance" value="{{ old('lieu_delivrance') }}"
                               required minlength="2" maxlength="255" placeholder="Antananarivo">
                        @error('lieu_delivrance')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Mot de passe -->
        <div class="mt-8">
            <h3 class="text-lg font-medium text-gray-900 mb-6 pb-2 border-b border-gray-200">{{ __('messages.password_section') }}</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-600">{{ __('messages.password') }} *</label>
                    <input type="password"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 @error('password') border-red-500 @enderror"
                           id="password" name="password" required minlength="8"
                           pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}"
                           title="{{ __('messages.password_helper') }}">
                    <div class="mt-2 text-xs text-gray-500">
                        <p>{{ __('messages.password_requirements') }}</p>
                        <ul class="list-disc list-inside mt-1">
                            <li>{{ __('messages.at_least_8_chars') }}</li>
                            <li>{{ __('messages.one_uppercase') }}</li>
                            <li>{{ __('messages.one_lowercase') }}</li>
                            <li>{{ __('messages.one_number') }}</li>
                            <li>{{ __('messages.one_special') }}</li>
                        </ul>
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-600">{{ __('messages.confirm_password') }} *</label>
                    <input type="password"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 @error('password_confirmation') border-red-500 @enderror"
                           id="password_confirmation" name="password_confirmation" required minlength="8">
                    @error('password_confirmation')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Notes -->
        <div class="mt-8">
            <label for="notes" class="block text-sm font-medium text-gray-600">{{ __('messages.notes') }}</label>
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
                {{ __('messages.create_my_account') }}
            </button>

            <!-- Login link -->
            <div class="text-center">
                <span class="text-sm text-gray-500">
                    {{ __('messages.already_have_account') }}
                    <a href="{{ route('login') }}" class="font-medium text-blue-500 hover:text-blue-600">
                        {{ __('messages.sign_in') }}
                    </a>
                </span>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const password = document.getElementById('password');
    const passwordConfirmation = document.getElementById('password_confirmation');
    const telephone = document.getElementById('telephone');
    const email = document.getElementById('email');
    const username = document.getElementById('username');

    // Validation en temps réel du mot de passe
    function validatePassword(password) {
        const minLength = password.length >= 8;
        const hasUpperCase = /[A-Z]/.test(password);
        const hasLowerCase = /[a-z]/.test(password);
        const hasNumbers = /\d/.test(password);
        const hasSpecialChar = /[@$!%*?&]/.test(password);

        return {
            minLength,
            hasUpperCase,
            hasLowerCase,
            hasNumbers,
            hasSpecialChar,
            isValid: minLength && hasUpperCase && hasLowerCase && hasNumbers && hasSpecialChar
        };
    }

    // Afficher les exigences du mot de passe
    if (password) {
        password.addEventListener('input', function() {
            const validation = validatePassword(this.value);
            const requirementsDiv = this.parentElement.querySelector('.text-xs.text-gray-500');

            if (requirementsDiv) {
                const requirements = requirementsDiv.querySelectorAll('li');
                requirements[0].style.color = validation.minLength ? '#10b981' : '#6b7280';
                requirements[1].style.color = validation.hasUpperCase ? '#10b981' : '#6b7280';
                requirements[2].style.color = validation.hasLowerCase ? '#10b981' : '#6b7280';
                requirements[3].style.color = validation.hasNumbers ? '#10b981' : '#6b7280';
                requirements[4].style.color = validation.hasSpecialChar ? '#10b981' : '#6b7280';
            }
        });
    }

    // Validation de la confirmation du mot de passe
    if (passwordConfirmation) {
        passwordConfirmation.addEventListener('input', function() {
            if (this.value !== password.value) {
                this.setCustomValidity('{{ __("messages.passwords_do_not_match") }}');
            } else {
                this.setCustomValidity('');
            }
        });
    }

    // Validation du format du téléphone
    if (telephone) {
        telephone.addEventListener('input', function() {
            // Nettoyer le numéro de téléphone
            let value = this.value.replace(/\s+/g, '');

            // Vérifier si le format est valide
            const phoneRegex = /^[+]?[0-9\-\(\)]+$/;
            if (!phoneRegex.test(value) && value.length > 0) {
                this.setCustomValidity('{{ __("messages.invalid_phone_number") }}');
            } else {
                this.setCustomValidity('');
            }
        });
    }

    // Validation de l'email
    if (email) {
        email.addEventListener('blur', function() {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(this.value) && this.value.length > 0) {
                this.setCustomValidity('{{ __("messages.invalid_email_address") }}');
            } else {
                this.setCustomValidity('');
            }
        });
    }

    // Validation du nom d'utilisateur
    if (username) {
        username.addEventListener('input', function() {
            const usernameRegex = /^[a-zA-Z0-9_\-\.]+$/;
            if (!usernameRegex.test(this.value) && this.value.length > 0) {
                this.setCustomValidity('{{ __("messages.invalid_username_format") }}');
            } else {
                this.setCustomValidity('');
            }
        });
    }

    // Validation du formulaire avant soumission
    if (form) {
        form.addEventListener('submit', function(e) {
            let isValid = true;

            // Vérifier que tous les champs requis sont remplis
            const requiredFields = form.querySelectorAll('[required]');
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('border-red-500');

                    // Créer un message d'erreur s'il n'existe pas
                    let errorMsg = field.parentElement.querySelector('.required-error');
                    if (!errorMsg) {
                        errorMsg = document.createElement('p');
                        errorMsg.className = 'mt-1 text-sm text-red-600 required-error';
                        errorMsg.textContent = '{{ __("messages.field_required") }}';
                        field.parentElement.appendChild(errorMsg);
                    }
                } else {
                    field.classList.remove('border-red-500');
                    const errorMsg = field.parentElement.querySelector('.required-error');
                    if (errorMsg) {
                        errorMsg.remove();
                    }
                }
            });

            // Vérifier la correspondance des mots de passe
            if (password.value !== passwordConfirmation.value) {
                isValid = false;
                passwordConfirmation.classList.add('border-red-500');
            }

            if (!isValid) {
                e.preventDefault();
                // Scroll vers le premier champ en erreur
                const firstError = form.querySelector('.border-red-500');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstError.focus();
                }
            }
        });
    }

    // Nettoyer les erreurs lors de la saisie
    const inputs = form.querySelectorAll('input, textarea, select');
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            this.classList.remove('border-red-500');
            const errorMsg = this.parentElement.querySelector('.required-error');
            if (errorMsg) {
                errorMsg.remove();
            }
        });
    });
});
</script>
@endpush
@endsection
