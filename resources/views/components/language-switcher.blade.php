<div x-data="{ open: false }" class="relative">
    <!-- Language selector button -->
    <button @click="open = !open"
            data-language-button
            class="flex items-center space-x-2 p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
        </svg>
        <span class="text-sm font-medium">{{ strtoupper(app()->getLocale()) }}</span>
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>

    <!-- Dropdown panel -->
    <div x-show="open"
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         @click.away="open = false"
         class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
        <div class="py-1" role="menu">
            <!-- French -->
            <button onclick="fastChangeLanguage('fr')"
                   class="{{ app()->getLocale() === 'fr' ? 'bg-blue-50 text-blue-900' : 'text-gray-700 hover:bg-gray-100' }} w-full text-left px-4 py-2 text-sm font-medium flex items-center space-x-3"
                   role="menuitem">
                <span class="text-lg">🇫🇷</span>
                <span>Français</span>
                @if(app()->getLocale() === 'fr')
                    <svg class="h-4 w-4 text-blue-600 ml-auto" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                @endif
            </button>

            <!-- English -->
            <button onclick="fastChangeLanguage('en')"
                   class="{{ app()->getLocale() === 'en' ? 'bg-blue-50 text-blue-900' : 'text-gray-700 hover:bg-gray-100' }} w-full text-left px-4 py-2 text-sm font-medium flex items-center space-x-3"
                   role="menuitem">
                <span class="text-lg">🇬🇧</span>
                <span>English</span>
                @if(app()->getLocale() === 'en')
                    <svg class="h-4 w-4 text-blue-600 ml-auto" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                @endif
            </button>
        </div>
    </div>
</div>

<script>
let isProcessing = false;

function fastChangeLanguage(locale) {
    if (isProcessing) return;
    isProcessing = true;

    const button = document.querySelector('[data-language-button]');
    if (button) {
        button.disabled = true;
        button.innerHTML = '<svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> <span class="text-sm font-medium">CHANGEMENT...</span>';
    }

    // Envoyer la requête de changement de langue et recharger la page
    sendLanguageUpdate(locale).then(() => {
        // Recharger la page pour appliquer toutes les traductions côté serveur
        window.location.reload();
    }).catch(error => {
        console.error('Language update error:', error);
        // En cas d'erreur, réactiver le bouton
        if (button) {
            button.disabled = false;
            updateLanguageDisplay(currentLocale);
        }
        isProcessing = false;
    });
}


function sendLanguageUpdate(locale) {
    // Envoyer la requête et retourner une Promise
    return fetch(`{{ route('language.switch', '__locale__') }}`.replace('__locale__', locale), {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Language switch failed');
        }
        return response.json();
    })
    .then(data => {
        console.log('Language changed successfully:', data);
        return data;
    })
    .catch(error => {
        console.error('Language update error:', error);
        throw error;
    });
}


</script>
