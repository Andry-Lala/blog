@extends('layouts.dashboard')

@section('title', __('messages.manage_clients'))

@section('header')
    <div class="ml-4 flex items-center">
        <h1 class="text-2xl font-semibold text-gray-900">{{ __('messages.manage_clients') }}</h1>
    </div>
@endsection

@section('content')
<div class="py-6">
    <div class="px-4 sm:px-6 lg:px-8">
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

        @if($clientsWithInvestments->count() > 0)
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table id="investmentsAdminTable" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.client') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.investment_count') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.validated_amounts') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.last_investment') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($clientsWithInvestments as $client)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $client['first_name'] }} {{ $client['last_name'] }}</div>
                                        <div class="text-sm text-gray-500">{{ $client['email'] }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ $client['validated_investments_count'] }} {{ __('messages.investment') }}(s)
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-green-600">
                                            {{ number_format($client['total_validated_amount'], 0, ',', ' ') }} Ar
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        @if($client['last_investment_date'])
                                            {{ $client['last_investment_date']->format('d/m/Y H:i') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('investments.user', $client['id']) }}"
                                               class="text-blue-600 hover:text-blue-800" title="{{ __('messages.view_all_client_investments') }}">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                            @if($client['validated_investments_count'] > 0)
                                                <button type="button" class="text-green-600 hover:text-green-800"
                                                        title="{{ __('messages.view_investment_details') }}"
                                                        onclick="toggleInvestments({{ $client['id'] }})">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                                    </svg>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Section séparée pour les détails des investissements -->
                <div id="investments-details" class="hidden mt-6">
                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <div class="px-4 py-5 sm:px-6">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ __('messages.validated_investments_details') }}</h3>
                            <button onclick="closeInvestmentsDetails()" class="float-right text-gray-500 hover:text-gray-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="px-4 py-3 sm:px-6">
                            <div id="investments-details-content" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <!-- Le contenu sera injecté ici par JavaScript -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">{{ __('messages.no_validated_investments') }}</h3>
                <p class="mt-1 text-sm text-gray-500">{{ __('messages.no_validated_investments_description') }}</p>
            </div>
        @endif
    </div>
</div>

<!-- Fonction JavaScript pour afficher/masquer les détails -->
<script>
function toggleInvestments(clientId) {
    const detailsSection = document.getElementById('investments-details');
    const detailsContent = document.getElementById('investments-details-content');

    // Trouver les données du client
    const clients = @json($clientsWithInvestments);
    const client = clients.find(c => c.id == clientId);

    if (client) {
        // Vider le contenu existant
        detailsContent.innerHTML = '';

        // Ajouter les détails des investissements
        client.investments.forEach(investment => {
            const investmentCard = `
                <div class="border border-gray-200 rounded-lg p-3 bg-white">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <div class="text-sm font-medium text-gray-900">${investment.investment_type}</div>
                            <div class="text-xs text-gray-500">${investment.operator}</div>
                        </div>
                        <div class="text-sm font-semibold text-green-600">
                            ${new Intl.NumberFormat('fr-FR').format(investment.amount)} Ar
                        </div>
                    </div>
                    <div class="text-xs text-gray-500">
                        ${new Date(investment.created_at).toLocaleDateString('fr-FR')} ${new Date(investment.created_at).toLocaleTimeString('fr-FR')}
                    </div>
                    <div class="mt-2">
                        <a href="/investments/${investment.id}" class="text-blue-500 hover:text-blue-700 text-xs">{{ __('messages.view_details') }}</a>
                    </div>
                </div>
            `;
            detailsContent.innerHTML += investmentCard;
        });

        // Afficher la section des détails
        detailsSection.classList.remove('hidden');

        // Faire défiler jusqu'à la section des détails
        detailsSection.scrollIntoView({ behavior: 'smooth' });
    }
}

function closeInvestmentsDetails() {
    const detailsSection = document.getElementById('investments-details');
    detailsSection.classList.add('hidden');
}
</script>

<!-- Les modaux ne sont plus nécessaires avec cette nouvelle vue de gestion par client -->

@push('scripts')
<script>
// Initialiser DataTable quand le document est prêt
document.addEventListener('DOMContentLoaded', function() {
    // S'assurer que jQuery est chargé
    if (typeof $ !== 'undefined') {
        $(document).ready(function() {
            try {
                $('#investmentsAdminTable').DataTable({
                    language: {
                        url: app()->getLocale() === 'fr' ? '//cdn.datatables.net/plug-ins/1.13.7/i18n/fr-FR.json' : '//cdn.datatables.net/plug-ins/1.13.7/i18n/en-GB.json',
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
                    order: [[2, 'desc']], // Trier par montant total validé (décroissant)
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
            } catch (error) {
                console.error('Erreur lors de l\'initialisation du DataTable:', error);
            }
        });
    } else {
        console.error('jQuery n\'est pas chargé');
    }
});
</script>
@endpush
@endsection
