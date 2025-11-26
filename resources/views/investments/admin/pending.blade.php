@extends('layouts.dashboard')

@section('title', 'Investissements en attente de validation')

@section('header')
    <div class="ml-4 flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900">Investissements en attente de validation</h1>
        <div class="flex space-x-3">
            <a href="{{ route('investments.index') }}" class="text-gray-500 hover:text-gray-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
        </div>
    </div>
@endsection

@section('content')
<div class="py-6">
    <div class="px-4 sm:px-6 lg:px-8">
        <!-- Messages de succès -->
        @if(session('success'))
            <div class="mb-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 00016zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l2-2z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                    <div class="ml-auto pl-3">
                        <div class="-mx-1.5 -my-1.5">
                            <button type="button" class="inline-flex bg-green-50 rounded-md p-1.5 text-green-500 hover:bg-green-100 transition-colors">
                                <span class="sr-only">Dismiss</span>
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Cartes de statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Investissements en attente</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $statistics['total_pending_count'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Montant total en attente</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ number_format($statistics['total_pending_amount'], 0, ',', ' ') }} Ar</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tableau des investissements en attente -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Liste des investissements en attente</h3>
                <div class="flex items-center space-x-2">
                    <label for="filter" class="text-sm text-gray-700">Filtrer par:</label>
                    <select id="filter" class="block w-40 px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="all">Tous</option>
                        <option value="amount-asc">Montant croissant</option>
                        <option value="amount-desc">Montant décroissant</option>
                        <option value="date-asc">Date croissante</option>
                        <option value="date-desc">Date décroissante</option>
                    </select>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200" id="pendingInvestmentsTable">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Opérateur</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($pendingInvestments as $investment)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $investment->user->prenom }} {{ $investment->user->nom }}</div>
                                    <div class="text-sm text-gray-500">{{ $investment->user->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $investment->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $investment->operator }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $investment->investment_type }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-gray-900">
                                        {{ number_format($investment->amount, 0, ',', ' ') }} Ar
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('investments.show', $investment) }}"
                                           class="text-blue-600 hover:text-blue-800" title="Voir les détails">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        <button type="button" class="text-yellow-600 hover:text-yellow-800"
                                                title="Mettre en cours de traitement"
                                                onclick="openProcessModal({{ $investment->id }})">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-1.756.426-1.756 2.924 0-3.35a1.724 1.724 0 00-1.066-2.573c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                        </button>
                                        <button type="button" class="text-green-600 hover:text-green-800"
                                                title="Approuver directement"
                                                onclick="openApproveModal({{ $investment->id }}, '{{ $investment->user->prenom }} {{ $investment->user->nom }}', {{ $investment->amount }})">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </button>
                                        <button type="button" class="text-red-600 hover:text-red-800"
                                                title="Rejeter directement"
                                                onclick="openRejectModal({{ $investment->id }}, '{{ $investment->user->prenom }} {{ $investment->user->nom }}', {{ $investment->amount }})">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                    Aucun investissement en attente pour le moment.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($pendingInvestments->hasPages())
                <div class="bg-white px-4 py-3 sm:px-6">
                    {{ $pendingInvestments->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modals pour chaque investissement -->
@foreach($pendingInvestments as $investment)
    <!-- Modal pour traiter -->
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden" id="processModal{{ $investment->id }}">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Mettre en cours de traitement</h3>
                <div class="mt-2 px-7">
                    <p class="text-sm text-gray-500">Voulez-vous mettre cette demande d'investissement de {{ number_format($investment->amount, 0, ',', ' ') }} Ar en cours de traitement ?</p>
                </div>
            </div>
            <form action="{{ route('investments.update', $investment) }}" method="POST" class="mt-5">
                @csrf
                @method('PUT')
                <div class="px-7">
                    <div class="mb-4">
                        <label for="admin_notes_process_{{ $investment->id }}" class="block text-sm font-medium text-gray-700">Notes (optionnel)</label>
                        <textarea id="admin_notes_process_{{ $investment->id }}" name="admin_notes" rows="3"
                                  class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>
                </div>
                <div class="px-7 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse rounded-b-lg">
                    <button type="button" onclick="closeProcessModal({{ $investment->id }})"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-gray-600 text-base font-medium text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Annuler
                    </button>
                    <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-yellow-600 text-base font-medium text-white hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Mettre en cours
                    </button>
                </div>
            </form>
        </div>
    </div>
@endforeach

<!-- Modal pour approuver directement -->
<div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden" id="approveModal">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Approuver l'investissement</h3>
            <div class="mt-2 px-7">
                <p class="text-sm text-gray-500" id="approveMessage">Êtes-vous sûr de vouloir approuver cet investissement ?</p>
            </div>
        </div>
        <form id="approveForm" method="POST" class="mt-5">
            @csrf
            <input type="hidden" name="_method" value="POST">
            <div class="px-7">
                <div class="mb-4">
                    <label for="admin_notes_approve" class="block text-sm font-medium text-gray-700">Notes (optionnel)</label>
                    <textarea id="admin_notes_approve" name="admin_notes" rows="3"
                              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>
            </div>
            <div class="px-7 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse rounded-b-lg">
                <button type="button" onclick="closeApproveModal()"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-gray-600 text-base font-medium text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Annuler
                </button>
                <button type="submit"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Approuver
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal pour rejeter directement -->
<div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden" id="rejectModal">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Rejeter l'investissement</h3>
            <div class="mt-2 px-7">
                <p class="text-sm text-gray-500" id="rejectMessage">Êtes-vous sûr de vouloir rejeter cet investissement ?</p>
            </div>
        </div>
        <form id="rejectForm" method="POST" class="mt-5">
            @csrf
            <input type="hidden" name="_method" value="POST">
            <div class="px-7">
                <div class="mb-4">
                    <label for="admin_notes_reject" class="block text-sm font-medium text-gray-700">Motif du rejet *</label>
                    <textarea id="admin_notes_reject" name="admin_notes" rows="3" required
                              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>
            </div>
            <div class="px-7 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse rounded-b-lg">
                <button type="button" onclick="closeRejectModal()"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-gray-600 text-base font-medium text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Annuler
                </button>
                <button type="submit"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Rejeter
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fonction de filtrage
    const filterSelect = document.getElementById('filter');
    const tableBody = document.querySelector('#pendingInvestmentsTable tbody');
    const rows = Array.from(tableBody.querySelectorAll('tr'));

    filterSelect.addEventListener('change', function() {
        const filterValue = this.value;

        if (filterValue === 'all') {
            // Réinitialiser l'ordre original
            rows.forEach(row => tableBody.appendChild(row));
        } else {
            // Trier selon le filtre sélectionné
            const sortedRows = [...rows].sort((a, b) => {
                const aValue = a.querySelector('td:nth-child(5)').textContent.trim(); // Montant
                const bValue = b.querySelector('td:nth-child(5)').textContent.trim();
                const aDate = a.querySelector('td:nth-child(2)').textContent.trim(); // Date
                const bDate = b.querySelector('td:nth-child(2)').textContent.trim();

                // Extraire les valeurs numériques des montants
                const aAmount = parseInt(aValue.replace(/[^0-9]/g, ''));
                const bAmount = parseInt(bValue.replace(/[^0-9]/g, ''));

                switch(filterValue) {
                    case 'amount-asc':
                        return aAmount - bAmount;
                    case 'amount-desc':
                        return bAmount - aAmount;
                    case 'date-asc':
                        return new Date(aDate) - new Date(bDate);
                    case 'date-desc':
                        return new Date(bDate) - new Date(aDate);
                    default:
                        return 0;
                }
            });

            // Fonctions pour gérer les modals
            function openProcessModal(investmentId) {
                document.getElementById('processModal' + investmentId).classList.remove('hidden');
            }

            function closeProcessModal(investmentId) {
                document.getElementById('processModal' + investmentId).classList.add('hidden');
            }

            function openApproveModal(investmentId, clientName, amount) {
                document.getElementById('approveMessage').textContent =
                    `Êtes-vous sûr de vouloir approuver l'investissement de ${number_format(amount, 0, ',', ' ')} Ar de ${clientName} ?`;
                document.getElementById('approveForm').action = `/investments/${investmentId}/approve`;
                document.getElementById('approveModal').classList.remove('hidden');
            }

            function closeApproveModal() {
                document.getElementById('approveModal').classList.add('hidden');
                document.getElementById('admin_notes_approve').value = '';
            }

            function openRejectModal(investmentId, clientName, amount) {
                document.getElementById('rejectMessage').textContent =
                    `Êtes-vous sûr de vouloir rejeter l'investissement de ${number_format(amount, 0, ',', ' ')} Ar de ${clientName} ?`;
                document.getElementById('rejectForm').action = `/investments/${investmentId}/reject`;
                document.getElementById('rejectModal').classList.remove('hidden');
            }

            function closeRejectModal() {
                document.getElementById('rejectModal').classList.add('hidden');
                document.getElementById('admin_notes_reject').value = '';
            }

            // Vider et réinsérer les lignes triées
            rows.forEach(row => row.remove());
            sortedRows.forEach(row => tableBody.appendChild(row));
        }
    });
});
</script>
@endsection
