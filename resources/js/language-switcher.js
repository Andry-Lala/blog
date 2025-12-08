// Gestion du changement de langue avec rechargement de page
document.addEventListener('DOMContentLoaded', function() {
    // Écouter les clics sur les liens de langue
    document.addEventListener('click', function(e) {
        const target = e.target.closest('a[data-locale]');

        if (target) {
            e.preventDefault();

            const locale = target.getAttribute('data-locale');
            const url = target.href;

            // Faire une requête AJAX pour changer la langue
            fetch(url, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.reload) {
                    // Mettre à jour les traductions et recharger les notifications immédiatement
                    if (typeof window.updateTranslations === 'function') {
                        window.updateTranslations();
                    }

                    // Déclencher l'événement de changement de langue
                    const languageEvent = new CustomEvent('languageChanged', {
                        detail: { locale: data.locale }
                    });
                    window.dispatchEvent(languageEvent);

                    // Forcer le rechargement immédiat des notifications avec stratégie multiple
                    if (typeof window.loadNotifications === 'function') {
                        // Vider complètement le cache des notifications
                        const listContainer = document.getElementById('notificationsList');
                        if (listContainer) {
                            listContainer.innerHTML = '<div class="px-4 py-8 text-center text-sm text-gray-500">Chargement...</div>';
                        }

                        // Premier rechargement immédiat
                        setTimeout(() => {
                            window.loadNotifications();
                        }, 100);

                        // Deuxième rechargement après 500ms
                        setTimeout(() => {
                            window.loadNotifications();
                        }, 500);

                        // Troisième rechargement après 1s
                        setTimeout(() => {
                            window.loadNotifications();
                        }, 1000);

                        // Recharger la page si signal de forçage
                        if (data.force_notification_refresh) {
                            setTimeout(() => {
                                window.location.reload(true);
                            }, 1500);
                        } else {
                            // Recharger la page normalement
                            setTimeout(() => {
                                window.location.reload(true);
                            }, 2000);
                        }
                    } else {
                        // Recharger la page si pas de fonction de rechargement
                        setTimeout(() => {
                            window.location.reload(true);
                        }, 200);
                    }
                }
            })
            .catch(error => {
                console.error('Erreur lors du changement de langue:', error);
                // En cas d'erreur, recharger la page
                window.location.reload(true);
            });
        }
    });
});
