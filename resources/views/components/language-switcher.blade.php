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
// Traductions optimisées avec mapping direct
const translations = {
    en: {
        dashboard: 'Dashboard', investments: 'Investments', clients: 'Clients', notifications: 'Notifications',
        settings: 'Settings', profile: 'Profile', logout: 'Logout', welcome: 'Welcome',
        total_investments: 'Total Investments', pending_investments: 'Pending Investments', approved_investments: 'Approved Investments',
        investment_history: 'Investment History', create_investment: 'Create Investment', investment_amount: 'Investment Amount',
        investment_type: 'Investment Type', status: 'Status', pending: 'Pending', approved: 'Approved', rejected: 'Rejected',
        no_notifications: 'No notifications', mark_all_read: 'Mark all as read', new_notification: 'New',
        save: 'Save', cancel: 'Cancel', edit: 'Edit', delete: 'Delete', view: 'View',
        search: 'Search', filter: 'Filter', export: 'Export', close: 'Close', confirm: 'Confirm',
        yes: 'Yes', no: 'No', loading: 'Loading...', error: 'Error', success: 'Success'
    },
    fr: {
        dashboard: 'Tableau de bord', investments: 'Investissements', clients: 'Clients', notifications: 'Notifications',
        settings: 'Paramètres', profile: 'Profil', logout: 'Déconnexion', welcome: 'Bienvenue',
        total_investments: 'Total des investissements', pending_investments: 'Investissements en attente', approved_investments: 'Investissements approuvés',
        investment_history: 'Historique des investissements', create_investment: 'Créer un investissement', investment_amount: 'Montant de l\'investissement',
        investment_type: 'Type d\'investissement', status: 'Statut', pending: 'En attente', approved: 'Approuvé', rejected: 'Rejeté',
        no_notifications: 'Aucune notification', mark_all_read: 'Tout marquer comme lu', new_notification: 'Nouveau',
        save: 'Enregistrer', cancel: 'Annuler', edit: 'Modifier', delete: 'Supprimer', view: 'Voir',
        search: 'Rechercher', filter: 'Filtrer', export: 'Exporter', close: 'Fermer', confirm: 'Confirmer',
        yes: 'Oui', no: 'Non', loading: 'Chargement...', error: 'Erreur', success: 'Succès'
    }
};

// Cache pour les éléments déjà traités
const processedElements = new WeakSet();
let currentLocale = '{{ app()->getLocale() }}';
let isProcessing = false;

// Mapping rapide pour les traductions les plus courantes
const quickMap = {
    en: { 'Tableau de bord': 'Dashboard', 'Investissements': 'Investments', 'Clients': 'Clients', 'Notifications': 'Notifications',
          'Profil': 'Profile', 'Déconnexion': 'Logout', 'En attente': 'Pending', 'Approuvé': 'Approved',
          'Investissements en attente': 'Pending Investments', 'Investissements approuvés': 'Approved Investments',
          'Aucune notification': 'No notifications', 'Tout marquer comme lu': 'Mark all as read', 'Nouveau': 'New',
          'Enregistrer': 'Save', 'Annuler': 'Cancel', 'Modifier': 'Edit', 'Supprimer': 'Delete', 'Voir': 'View',
          'Statut': 'Status', 'Créer un investissement': 'Create Investment', 'Montant de l\'investissement': 'Investment Amount',
          'Type d\'investissement': 'Investment Type', 'Historique des investissements': 'Investment History' },
    fr: { 'Dashboard': 'Tableau de bord', 'Investments': 'Investissements', 'Clients': 'Clients', 'Notifications': 'Notifications',
          'Profile': 'Profil', 'Logout': 'Déconnexion', 'Pending': 'En attente', 'Approved': 'Approuvé',
          'Pending Investments': 'Investissements en attente', 'Approved Investments': 'Investissements approuvés',
          'No notifications': 'Aucune notification', 'Mark all as read': 'Tout marquer comme lu', 'New': 'Nouveau',
          'Save': 'Enregistrer', 'Cancel': 'Annuler', 'Edit': 'Modifier', 'Delete': 'Supprimer', 'View': 'Voir',
          'Status': 'Statut', 'Create Investment': 'Créer un investissement', 'Investment Amount': 'Montant de l\'investissement',
          'Investment Type': 'Type d\'investissement', 'Investment History': 'Historique des investissements' }
};

function fastChangeLanguage(locale) {
    if (isProcessing) return;
    isProcessing = true;

    const button = document.querySelector('[data-language-button]');
    if (button) {
        button.disabled = true;
        button.innerHTML = '<svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> <span class="text-sm font-medium">CHANGEMENT...</span>';
    }

    // Changement immédiat de la langue
    currentLocale = locale;

    // Mise à jour ultra-rapide avec requestAnimationFrame
    requestAnimationFrame(() => {
        // Utiliser le mapping rapide pour les traductions courantes
        const quickTranslations = quickMap[locale];
        if (quickTranslations) {
            updateTextsInstant(quickTranslations);
        } else {
            // Fallback sur les traductions complètes
            updateTextsInstant(translations[locale]);
        }

        // Mettre à jour le sélecteur
        updateLanguageDisplay(locale);

        // Envoyer la requête en arrière-plan (non bloquant)
        sendLanguageUpdate(locale);

        // Réactiver le bouton immédiatement
        if (button) {
            button.disabled = false;
            updateLanguageDisplay(locale);
        }

        isProcessing = false;

        // Message de confirmation rapide
        showFastToast(locale === 'fr' ? 'Langue changée en français' : 'Language changed to English');
    });
}

function updateTextsInstant(translations) {
    // Utiliser documentFragment pour meilleures performances
    const fragment = document.createDocumentFragment();
    const walker = document.createTreeWalker(
        document.body,
        NodeFilter.SHOW_TEXT,
        null,
        false
    );

    let textNode;
    const elementsToUpdate = [];

    // Parcourir tous les nœuds de texte
    while (textNode = walker.nextNode()) {
        const text = textNode.nodeValue.trim();
        if (text && translations[text] && !processedElements.has(textNode.parentNode)) {
            elementsToUpdate.push({
                element: textNode.parentNode,
                newText: translations[text]
            });
            processedElements.add(textNode.parentNode);
        }
    }

    // Appliquer les changements en lot
    requestAnimationFrame(() => {
        elementsToUpdate.forEach(({ element, newText }) => {
            if (element && element.textContent !== newText) {
                element.textContent = newText;
            }
        });
    });
}

function sendLanguageUpdate(locale) {
    // Envoyer la requête sans bloquer l'interface
    fetch(`{{ route('language.switch', '__locale__') }}`.replace('__locale__', locale), {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .catch(() => {
        // Silencieux en cas d'erreur
        console.log('Language update sent');
    });
}

function updateLanguageDisplay(locale) {
    const button = document.querySelector('[data-language-button]');
    if (button) {
        const flag = locale === 'fr' ? '🇫🇷' : '🇬🇧';
        const langCode = locale.toUpperCase();
        button.innerHTML = `<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path></svg> <span class="text-sm font-medium">${langCode}</span> <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>`;
        button.disabled = false;
    }
}

function showFastToast(message) {
    // Toast ultra-léger
    const toast = document.createElement('div');
    toast.className = 'fixed top-4 right-4 px-4 py-2 rounded-md text-white z-50 bg-green-500 shadow-lg transform transition-all duration-300';
    toast.textContent = message;
    toast.style.transform = 'translateX(100%)';
    document.body.appendChild(toast);

    // Animation d'entrée
    requestAnimationFrame(() => {
        toast.style.transform = 'translateX(0)';
    });

    // Auto-suppression rapide
    setTimeout(() => {
        toast.style.transform = 'translateX(100%)';
        setTimeout(() => toast.remove(), 300);
    }, 2000);
}

// Initialisation ultra-rapide
document.addEventListener('DOMContentLoaded', function() {
    // Précharger les traductions pour la langue actuelle
    const currentTranslations = quickMap[currentLocale] || translations[currentLocale];
    if (currentTranslations) {
        setTimeout(() => updateTextsInstant(currentTranslations), 100);
    }
});
</script>
