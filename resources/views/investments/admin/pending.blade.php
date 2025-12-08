@extends('layouts.dashboard')

@section('title', __('messages.pending_investments_validation'))

@section('header')
    <div class="ml-4 flex items-center justify-between w-full">
        <div class="flex-1 min-w-0">
            <h1 class="text-xl sm:text-2xl font-semibold text-gray-900 truncate pr-2">
                {{ __('messages.pending_investments_validation') }}
            </h1>
        </div>
        <div class="flex space-x-3 flex-shrink-0">
            <a href="{{ route('investments.index') }}" class="text-gray-500 hover:text-gray-700" title="{{ __('messages.back') }}">
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
                                <dt class="text-sm font-medium text-gray-500 truncate">{{ __('messages.pending_investments') }}</dt>
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
                                <dt class="text-sm font-medium text-gray-500 truncate">{{ __('messages.total_pending_amount') }}</dt>
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
                <h3 class="text-lg leading-6 font-medium text-gray-900">{{ __('messages.pending_investments_list') }}</h3>
                <div class="flex items-center space-x-2">
                    <label for="filter" class="text-sm text-gray-700">{{ __('messages.filter_by') }}:</label>
                    <select id="filter" class="block w-40 px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="all">{{ __('messages.all') }}</option>
                        <option value="amount-asc">{{ __('messages.amount_ascending') }}</option>
                        <option value="amount-desc">{{ __('messages.amount_descending') }}</option>
                        <option value="date-asc">{{ __('messages.date_ascending') }}</option>
                        <option value="date-desc">{{ __('messages.date_descending') }}</option>
                    </select>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200" id="pendingInvestmentsTable">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.clients') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.date') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.operator') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.type') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.amount') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.actions') }}</th>
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
                                           class="text-blue-600 hover:text-blue-800" title="{{ __('messages.view_details') }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        <button type="button" class="text-yellow-600 hover:text-yellow-800"
                                                title="{{ __('messages.put_in_processing') }}"
                                                onclick="openProcessModal({{ $investment->id }})">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-1.756.426-1.756 2.924 0-3.35a1.724 1.724 0 00-1.066-2.573c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                        </button>
                                        <button type="button" class="text-green-600 hover:text-green-800"
                                                title="{{ __('messages.approve_directly') }}"
                                                onclick="openApproveModal({{ $investment->id }}, '{{ $investment->user->prenom }} {{ $investment->user->nom }}', {{ $investment->amount }})">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </button>
                                        <button type="button" class="text-red-600 hover:text-red-800"
                                                title="{{ __('messages.reject_directly') }}"
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
                                    {{ __('messages.no_pending_investments') }}
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
                <h3 class="text-lg leading-6 font-medium text-gray-900">{{ __('messages.put_in_processing') }}</h3>
                <div class="mt-2 px-7">
                    <p class="text-sm text-gray-500">{{ __('messages.process_investment_question') }}</p>
                </div>
            </div>
            <form action="{{ route('investments.update', $investment) }}" method="POST" class="mt-5">
                @csrf
                @method('PUT')
                <div class="px-7">
                    <div class="mb-4">
                        <label for="admin_notes_process_{{ $investment->id }}" class="block text-sm font-medium text-gray-700">{{ __('messages.optional_notes') }}</label>
                        <textarea id="admin_notes_process_{{ $investment->id }}" name="admin_notes" rows="3"
                                  class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>
                </div>
                <div class="px-7 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse rounded-b-lg">
                    <button type="button" onclick="closeProcessModal({{ $investment->id }})"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-gray-600 text-base font-medium text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:ml-3 sm:w-auto sm:text-sm">
                        {{ __('messages.cancel') }}
                    </button>
                    <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-yellow-600 text-base font-medium text-white hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 sm:ml-3 sm:w-auto sm:text-sm">
                        {{ __('messages.put_in_progress') }}
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
            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ __('messages.approve_investment') }}</h3>
            <div class="mt-2 px-7">
                <p class="text-sm text-gray-500" id="approveMessage">{{ __('messages.approve_investment_question') }}</p>
            </div>
        </div>
        <form id="approveForm" method="POST" class="mt-5">
            @csrf
            <input type="hidden" name="_method" value="POST">
            <div class="px-7">
                <div class="mb-4">
                    <label for="admin_notes_approve" class="block text-sm font-medium text-gray-700">{{ __('messages.optional_notes') }}</label>
                    <textarea id="admin_notes_approve" name="admin_notes" rows="3"
                              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>
            </div>
            <div class="px-7 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse rounded-b-lg">
                <button type="button" onclick="closeApproveModal()"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-gray-600 text-base font-medium text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:ml-3 sm:w-auto sm:text-sm">
                    {{ __('messages.cancel') }}
                </button>
                <button type="submit"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                    {{ __('messages.approve') }}
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal pour rejeter directement -->
<div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden" id="rejectModal">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ __('messages.reject_investment') }}</h3>
            <div class="mt-2 px-7">
                <p class="text-sm text-gray-500" id="rejectMessage">{{ __('messages.reject_investment_question') }}</p>
            </div>
        </div>
        <form id="rejectForm" method="POST" class="mt-5">
            @csrf
            <input type="hidden" name="_method" value="POST">
            <div class="px-7">
                <div class="mb-4">
                    <label for="admin_notes_reject" class="block text-sm font-medium text-gray-700">{{ __('messages.rejection_reason') }} *</label>
                    <textarea id="admin_notes_reject" name="admin_notes" rows="3" required
                              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>
            </div>
            <div class="px-7 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse rounded-b-lg">
                <button type="button" onclick="closeRejectModal()"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-gray-600 text-base font-medium text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:ml-3 sm:w-auto sm:text-sm">
                    {{ __('messages.cancel') }}
                </button>
                <button type="submit"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                    {{ __('messages.reject') }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Fonctions pour gérer les modals
function openProcessModal(investmentId) {
    document.getElementById('processModal' + investmentId).classList.remove('hidden');
}

function closeProcessModal(investmentId) {
    document.getElementById('processModal' + investmentId).classList.add('hidden');
}

function openApproveModal(investmentId, clientName, amount) {
    const message = app()->getLocale() === 'fr'
        ? `Êtes-vous sûr de vouloir approuver l'investissement de ${number_format(amount, 0, ',', ' ')} Ar de ${clientName} ?`
        : `Are you sure you want to approve investment of ${number_format(amount, 0, ',', ' ')} Ar from ${clientName}?`;
    document.getElementById('approveMessage').textContent = message;
    document.getElementById('approveForm').action = `/investments/${investmentId}/approve`;
    document.getElementById('approveModal').classList.remove('hidden');
}

function closeApproveModal() {
    document.getElementById('approveModal').classList.add('hidden');
    document.getElementById('admin_notes_approve').value = '';
}

function openRejectModal(investmentId, clientName, amount) {
    const message = app()->getLocale() === 'fr'
        ? `Êtes-vous sûr de vouloir rejeter l'investissement de ${number_format(amount, 0, ',', ' ')} Ar de ${clientName} ?`
        : `Are you sure you want to reject investment of ${number_format(amount, 0, ',', ' ')} Ar from ${clientName}?`;
    document.getElementById('rejectMessage').textContent = message;
    document.getElementById('rejectForm').action = `/investments/${investmentId}/reject`;
    document.getElementById('rejectModal').classList.remove('hidden');
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
    document.getElementById('admin_notes_reject').value = '';
}

// Initialiser DataTable quand le document est prêt
document.addEventListener('DOMContentLoaded', function() {
    // S'assurer que jQuery est chargé
    if (typeof $ !== 'undefined') {
        $(document).ready(function() {
            try {
                // Initialiser le DataTable
                const table = $('#pendingInvestmentsTable').DataTable({
                    language: {
                        url: app()->getLocale() === 'fr' ? '{{ asset('assets/js/datatables/i18n/fr-FR.json') }}' : '{{ asset('assets/js/datatables/i18n/en-GB.json') }}',
                        search: "{{ __('messages.search_placeholder') }}",
                        lengthMenu: "{{ __('messages.show') }} _MENU_ {{ __('messages.entries') }}",
                        info: "{{ __('messages.showing_to_of_total_entries') }}",
                        paginate: {
                            first: '<i class="fas fa-angle-double-left"></i>',
                            last: '<i class="fas fa-angle-double-right"></i>',
                            next: '<i class="fas fa-angle-right"></i>',
                            previous: '<i class="fas fa-angle-left"></i>'
                        }
                    },
                    pageLength: 25,
                    responsive: true,
                    order: [[1, 'desc']], // Trier par date (décroissant) par défaut
                    dom: '<"row mb-4"<"col-md-6"l><"col-md-6 text-right"B>>rt<"row mt-4"<"col-md-6"i><"col-md-6"p>>',
                    buttons: [
                        {
                            extend: 'excel',
                            text: '<i class="fas fa-file-excel"></i> {{ __('messages.excel') }}',
                            className: 'btn btn-success btn-sm mr-2'
                        },
                        {
                            extend: 'pdf',
                            text: '<i class="fas fa-file-pdf"></i> {{ __('messages.pdf') }}',
                            className: 'btn btn-danger btn-sm mr-2'
                        },
                        {
                            extend: 'print',
                            text: '<i class="fas fa-print"></i> {{ __('messages.print') }}',
                            className: 'btn btn-primary btn-sm'
                        }
                    ],
                    initComplete: function() {
                        // Améliorer le design de la recherche
                        $('.dataTables_filter label').contents().filter(function() {
                            return this.nodeType === 3;
                        }).remove();

                        // Ajouter des classes Bootstrap pour le style
                        $('.dataTables_filter input').addClass('form-control form-control-sm');
                        $('.dataTables_length select').addClass('form-control form-control-sm');
                        $('.dataTables_paginate .pagination').addClass('pagination-sm');
                    }
                });

                // Fonction de filtrage personnalisé
                const filterSelect = document.getElementById('filter');
                filterSelect.addEventListener('change', function() {
                    const filterValue = this.value;

                    if (filterValue === 'all') {
                        // Réinitialiser l'ordre par défaut
                        table.order([1, 'desc']).draw();
                    } else {
                        // Trier selon le filtre sélectionné
                        switch(filterValue) {
                            case 'amount-asc':
                                table.order([4, 'asc']).draw(); // Colonne montant (index 4)
                                break;
                            case 'amount-desc':
                                table.order([4, 'desc']).draw(); // Colonne montant (index 4)
                                break;
                            case 'date-asc':
                                table.order([1, 'asc']).draw(); // Colonne date (index 1)
                                break;
                            case 'date-desc':
                                table.order([1, 'desc']).draw(); // Colonne date (index 1)
                                break;
                            default:
                                table.order([1, 'desc']).draw();
                        }
                    }
                });

            } catch (error) {
                console.error('Erreur lors de l\'initialisation du DataTable:', error);
            }
        });
    } else {
        console.error('jQuery n\'est pas chargé');
    }
});
</script>
@endsection
