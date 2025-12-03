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
                    // Recharger uniquement la page actuelle
                    window.location.reload(true);
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
