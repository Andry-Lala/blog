// Protection absolue contre l'accès non autorisé via cache ou navigation
(function() {
    'use strict';

    // Configuration
    const config = {
        authCheckInterval: 2000, // 2 secondes pour vérification très fréquente
        maxRetries: 2,
        retryDelay: 500,
        lockoutDuration: 180000 // 3 minutes de blocage en cas d'échecs répétés
    };

    let authCheckCount = 0;
    let isLocked = false;
    let lockoutTimer = null;
    let lastCheckTime = 0;
    let isChecking = false;

    // Fonction pour vérifier l'authentification
    function checkAuth(force = false) {
        const now = Date.now();

        // Éviter les vérifications multiples simultanées
        if (isChecking && !force) {
            console.log('Vérification déjà en cours...');
            return false;
        }

        // Limiter la fréquence des vérifications
        if (!force && (now - lastCheckTime) < 1000) {
            console.log('Vérification trop fréquente - ignorée');
            return false;
        }

        if (isLocked && !force) {
            console.log('Vérification bloquée - tentative trop fréquente');
            return false;
        }

        isChecking = true;
        lastCheckTime = now;
        authCheckCount++;

        // Ajouter un timestamp pour éviter la mise en cache
        const timestamp = new Date().getTime();

        fetch(`/api/auth-check?t=${timestamp}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
                'Cache-Control': 'no-cache, no-store, must-revalidate',
                'Pragma': 'no-cache',
                'Expires': '0'
            },
            cache: 'no-cache',
            credentials: 'same-origin'
        })
        .then(response => {
            isChecking = false;

            if (!response.ok || response.status === 401) {
                handleAuthFailure('Session invalide ou expirée');
                return false;
            }

            // Réinitialiser le compteur en cas de succès
            authCheckCount = 0;
            clearLockout();

            console.log('Authentification vérifiée avec succès');
            return true;
        })
        .catch(error => {
            isChecking = false;
            console.error('Erreur de vérification d\'authentification:', error);
            handleAuthFailure('Erreur de connexion au serveur');
            return false;
        });
    }

    // Fonction pour gérer les échecs d'authentification
    function handleAuthFailure(reason) {
        authCheckCount++;

        if (authCheckCount >= config.maxRetries) {
            // Trop d'échecs - bloquer l'accès
            isLocked = true;
            startLockoutTimer();
            showLockoutMessage(reason);
        } else {
            // Rediriger immédiatement vers login
            redirectToLogin(reason);
        }
    }

    // Fonction pour rediriger vers login
    function redirectToLogin(reason) {
        // Empêcher la mise en cache de la page de login
        const loginUrl = '/login?reason=' + encodeURIComponent(reason) + '&timestamp=' + Date.now() + '&forced=1';

        // Nettoyer tout stockage local qui pourrait contenir des infos de session
        try {
            localStorage.clear();
            sessionStorage.clear();
        } catch (e) {
            console.warn('Impossible de nettoyer le stockage local:', e);
        }

        // Remplacer l'historique pour empêcher le retour
        window.location.replace(loginUrl);
    }

    // Fonction pour démarrer le timer de blocage
    function startLockoutTimer() {
        if (lockoutTimer) clearInterval(lockoutTimer);

        let remainingTime = config.lockoutDuration / 1000;

        lockoutTimer = setInterval(() => {
            remainingTime -= 1000;
            updateLockoutMessage(remainingTime);

            if (remainingTime <= 0) {
                clearLockout();
            }
        }, 1000);
    }

    // Fonction pour effacer le blocage
    function clearLockout() {
        isLocked = false;
        if (lockoutTimer) {
            clearInterval(lockoutTimer);
            lockoutTimer = null;
        }
        hideLockoutMessage();
    }

    // Fonction pour afficher le message de blocage
    function showLockoutMessage(reason) {
        const message = document.createElement('div');
        message.id = 'auth-lockout-message';
        message.className = 'fixed top-0 left-0 right-0 bg-red-600 text-white p-4 z-50 text-center';
        message.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background-color: #dc2626;
            color: white;
            padding: 1rem;
            z-index: 9999;
            font-family: system-ui, -apple-system, sans-serif;
            font-size: 14px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        `;
        message.innerHTML = `
            <div class="font-bold mb-2">⚠️ ACCÈS TEMPORAIREMENT BLOQUÉ</div>
            <div class="text-sm mb-2">${reason}</div>
            <div class="text-xs opacity-75">Veuillez patienter ${config.lockoutDuration / 60000} secondes avant de réessayer.</div>
            <div class="text-xs mt-2">Tentatives: ${authCheckCount}/${config.maxRetries}</div>
        `;

        document.body.appendChild(message);
        updateLockoutMessage(config.lockoutDuration / 1000);
    }

    // Fonction pour mettre à jour le message de blocage
    function updateLockoutMessage(remainingTime) {
        const message = document.getElementById('auth-lockout-message');
        if (message) {
            const minutes = Math.floor(remainingTime / 60000);
            const seconds = Math.floor((remainingTime % 60000) / 1000);

            const timeText = minutes > 0 ? `${minutes}m ${seconds}s` : `${seconds}s`;

            message.querySelector('.text-xs:last-child').textContent = `Veuillez patienter ${timeText} avant de réessayer.`;
        }
    }

    // Fonction pour cacher le message de blocage
    function hideLockoutMessage() {
        const message = document.getElementById('auth-lockout-message');
        if (message) {
            message.remove();
        }
    }

    // Vérification immédiate au chargement
    function immediateCheck() {
        checkAuth(true); // Forcer la vérification immédiate
    }

    // Surveillance continue de l'état de la page
    function monitorPageState() {
        // Vérifier si la page devient visible
        document.addEventListener('visibilitychange', function() {
            if (document.visibilityState === 'visible') {
                immediateCheck();
            }
        });

        // Vérifier les changements d'URL
        let lastUrl = window.location.href;
        setInterval(() => {
            if (window.location.href !== lastUrl) {
                lastUrl = window.location.href;
                immediateCheck();
            }
        }, 500);

        // Empêcher le bouton "Retour" avec une vérification immédiate
        window.addEventListener('popstate', function(event) {
            console.log('Tentative d\'accès via bouton Retour détectée');
            event.preventDefault();
            immediateCheck();
            // Forcer la redirection vers login si la vérification échoue
            setTimeout(() => {
                if (authCheckCount > 0) {
                    redirectToLogin('Accès non autorisé via navigation arrière');
                }
            }, 500);
        });

        // Gérer l'événement pageshow pour détecter le chargement depuis le cache
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                console.log('Page chargée depuis le cache du navigateur');
                // Forcer un rechargement complet depuis le serveur
                window.location.reload(true);
            }
        });

        // Empêcher les raccourcis clavier
        document.addEventListener('keydown', function(e) {
            // Alt + Flèche gauche ou Backspace (hors champs de formulaire)
            if (((e.altKey && e.keyCode === 37) || e.keyCode === 8) &&
                !['INPUT', 'TEXTAREA', 'SELECT'].includes(e.target.tagName)) {
                e.preventDefault();
                immediateCheck();
            }
        });

        // Empêcher le clic droit
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
            return false;
        });

        // Désactiver le drag and drop
        document.addEventListener('dragstart', function(e) {
            e.preventDefault();
            return false;
        });

        // Surveiller les tentatives de développement
        if (window.console && window.console.clear) {
            const originalConsole = {
                log: console.log.bind(console),
                warn: console.warn.bind(console),
                error: console.error.bind(console)
            };

            window.console = {
                log: function(...args) {
                    if (args[0] && args[0].includes('auth-check')) return;
                    originalConsole.log(...args);
                },
                warn: function(...args) {
                    if (args[0] && args[0].includes('auth-check')) return;
                    originalConsole.warn(...args);
                },
                error: function(...args) {
                    if (args[0] && args[0].includes('auth-check')) return;
                    originalConsole.error(...args);
                }
            };
        }
    }

    // Initialisation
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            immediateCheck();
            monitorPageState();
        });
    } else {
        immediateCheck();
        monitorPageState();
    }

    // Vérification périodique plus fréquente
    setInterval(() => {
        if (!isLocked && !isChecking) {
            checkAuth();
        }
    }, config.authCheckInterval);

    // Vérification supplémentaire toutes les 10 secondes pour plus de sécurité
    setInterval(() => {
        if (!isLocked && !isChecking) {
            checkAuth(true); // Forcer la vérification
        }
    }, 10000);

    console.log('Protection d\'authentification absolue activée');
})();
