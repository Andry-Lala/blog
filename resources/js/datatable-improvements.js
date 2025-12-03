// Améliorations pour les DataTables dans l'application
document.addEventListener('DOMContentLoaded', function() {
    // Attendre que jQuery et DataTables soient chargés
    setTimeout(function() {
        if (typeof $ !== 'undefined' && typeof $.fn.DataTable !== 'undefined') {
            console.log('Amélioration des DataTables initialisée');

            // Améliorer l'initialisation des DataTables
            $('.dataTable').each(function() {
                const table = $(this);
                const dataTable = table.DataTable();

                // Améliorer la responsive et le style
                dataTable.on('draw', function() {
                    // Améliorer les classes pour mobile
                    if ($(window).width() < 768) {
                        table.closest('.dataTables_wrapper').addClass('text-xs');
                    } else {
                        table.closest('.dataTables_wrapper').removeClass('text-xs');
                    }

                    // Améliorer l'accessibilité
                    table.find('.dataTables_info').addClass('text-sm text-gray-600');
                    table.find('.dataTables_filter input').attr('aria-label', 'Rechercher...');
                    table.find('.dataTables_length select').attr('aria-label', 'Nombre d\'entrées');
                });

                // Gérer les erreurs d'initialisation
                dataTable.on('error', function(e, settings, techNote) {
                    console.error('Erreur DataTable:', e, settings, techNote);

                    // Afficher un message d'erreur convivial
                    const errorDiv = $('<div class="alert alert-warning alert-dismissible fade show" role="alert">' +
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                        '<span aria-hidden="true">&times;</span>' +
                        '</button>' +
                        '<strong>Erreur:</strong> Impossible de charger les données. ' +
                        '<button class="btn btn-sm btn-primary ml-2" onclick="location.reload()">Réessayer</button>' +
                        '</div>');

                    table.before(errorDiv);

                    // Masquer la table en erreur
                    table.hide();

                    // Auto-suppression du message après 5 secondes
                    setTimeout(function() {
                        errorDiv.fadeOut(500, function() {
                            $(this).remove();
                        });
                    }, 5000);
                });
            });
        }
    }, 1000);
});

// Fonction pour améliorer l'affichage des messages DataTables
function improveDataTablesMessages() {
    if (typeof $ !== 'undefined') {
        // Messages français
        if (typeof $.fn.dataTableExt !== 'undefined') {
            $.extend(true, $.fn.dataTableExt.defaults.language, {
                "processing": "Traitement en cours...",
                "search": "Rechercher:",
                "lengthMenu": "Afficher _MENU_ entrées",
                "info": "Affichage de _START_ à _END_ sur _TOTAL_ entrées",
                "infoEmpty": "Affichage de 0 à 0 sur 0 entrées",
                "infoFiltered": "(filtré de _MAX_ sur _TOTAL_ entrées)",
                "zeroRecords": "Aucun enregistrement trouvé",
                "paginate": {
                    "first": "Premier",
                    "last": "Dernier",
                    "next": "Suivant",
                    "previous": "Précédent"
                }
            });
        }
    }
}

// Appeler les améliorations des messages
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', improveDataTablesMessages);
} else {
    improveDataTablesMessages();
}
