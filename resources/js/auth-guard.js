// Protection ultime contre l'accès non autorisé via cache du navigateur
(function() {
    'use strict';

    // Fonction pour vérifier l'authentification immédiatement
    function checkAuth() {
        fetch('/api/auth-check', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            },
            cache: 'no-cache'
        })
        .then(response => {
            if (!response.ok) {
                // Si non authentifié, rediriger immédiatement
                window.location.href = '/login';
                return false;
            }
            return true;
        })
        .catch(error => {
            console.error('Erreur de vérification d\'authentification:', error);
            // En cas d'erreur, rediriger vers login par sécurité
            window.location.href = '/login';
            return false;
        });
    }

    // Vérification immédiate au chargement
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            checkAuth();
        });
    } else {
        // Si la page est déjà chargée, vérifier immédiatement
        checkAuth();
    }

    // Prévenir l'accès via le bouton "Retour"
    window.addEventListener('pageshow', function(event) {
        // Si la page est chargée depuis le cache du navigateur
        if (event.persisted) {
            console.log('Page chargée depuis le cache, vérification de l\'authentification...');
            // Forcer la vérification immédiate
            setTimeout(function() {
                checkAuth();
            }, 100);
        }
    });

    // Vérification périodique très fréquente
    setInterval(function() {
        checkAuth();
    }, 5000); // Toutes les 5 secondes pour une sécurité maximale

    // Désactiver le bouton "Retour" du navigateur
    window.addEventListener('popstate', function(event) {
        console.log('Tentative d\'accès via bouton Retour détectée...');
        checkAuth();
    });

    // Surveiller les changements d'onglets
    document.addEventListener('visibilitychange', function() {
        if (document.visibilityState === 'visible') {
            console.log('Onglet devenu visible, vérification de l\'authentification...');
            checkAuth();
        }
    });

    // Empêcher le clic droit sur les pages protégées
    document.addEventListener('contextmenu', function(e) {
        e.preventDefault();
        return false;
    });

    // Empêcher les raccourcis clavier pour revenir en arrière
    document.addEventListener('keydown', function(e) {
        // Alt + Flèche gauche ou Backspace
        if ((e.altKey && e.keyCode === 37) || e.keyCode === 8) {
            e.preventDefault();
            checkAuth();
        }
    });

    console.log('Protection d\'authentification activée');
})();
