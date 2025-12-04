@extends('layouts.dashboard')

@section('title', __('messages.my_investments'))

@section('header')
    <div class="ml-4 flex items-center">
        <h1 class="text-2xl font-semibold text-gray-900">{{ __('messages.my_investments') }}</h1>
    </div>
@endsection

@section('content')
<div class="py-6">
    <div class="px-4 sm:px-6 lg:px-8">
        <!-- Actions Header -->
        <div class="mb-6 flex items-center justify-between">
            <h2 class="text-lg font-medium text-gray-900">{{ __('messages.investment_list') }}</h2>
            <a href="{{ route('investments.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                {{ __('messages.new_investment') }}
            </a>
        </div>
        @if(session('success'))
            <div class="mb-4 bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-300" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 00016zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l2-2z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-600">{{ session('success') }}</p>
                    </div>
                    <div class="ml-auto pl-3">
                        <div class="-mx-1.5 -my-1.5">
                            <button type="button" class="inline-flex bg-green-50 rounded-md p-1.5 text-green-400 hover:bg-green-100 transition-colors">
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

        @if($investments->count() > 0)
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table id="investmentsTable" class="display min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.date') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.operator') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.type') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.amount') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.status') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($investments as $investment)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $investment->created_at->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $investment->operator }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $investment->investment_type }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($investment->amount, 2, ',', ' ') }} Ar</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($investment->status === 'Validé' || $investment->status === 'Approved')
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-50 text-green-600">{{ __('messages.approved') }}</span>
                                        @elseif($investment->status === 'Rejeté' || $investment->status === 'Rejected')
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-50 text-red-600">{{ __('messages.rejected') }}</span>
                                        @elseif($investment->status === 'En cours de traitement' || $investment->status === 'Processing')
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-50 text-yellow-600">{{ __('messages.processing') }}</span>
                                        @else
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-50 text-blue-600">{{ __('messages.pending') }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('investments.show', $investment) }}"
                                               class="text-blue-500 hover:text-blue-600" title="{{ __('messages.view_details') }}">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>

                                            @if($investment->status === 'Validé' || $investment->status === 'Approved')
                                                <button onclick="generateInvoice({{ $investment->id }})"
                                                        class="text-green-500 hover:text-green-600"
                                                        title="{{ __('messages.generate_invoice_pdf') }}">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
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
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">{{ __('messages.no_investments') }}</h3>
                <p class="mt-1 text-sm text-gray-500">{{ __('messages.start_first_investment') }}</p>
                <div class="mt-6">
                    <a href="{{ route('investments.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        {{ __('messages.create_investment') }}
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
// Fonction pour générer une facture
function generateInvoice(investmentId) {
    window.open(`/investments/${investmentId}/invoice`, '_blank');
}

// Initialiser DataTable quand le document est prêt
document.addEventListener('DOMContentLoaded', function() {
    // S'assurer que jQuery est chargé
    if (typeof $ !== 'undefined') {
        $(document).ready(function() {
            try {
                $('#investmentsTable').DataTable({
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
                    pageLength: 10,
                    responsive: true,
                    order: [[0, 'desc']],
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

                        // Ajouter des classes Tailwind pour le style
                        $('.dataTables_filter input').addClass('border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500');
                        $('.dataTables_length select').addClass('border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500');
                        $('.dataTables_paginate .pagination').addClass('flex items-center space-x-2');

                        // Améliorer l'affichage mobile
                        if ($(window).width() < 768) {
                            $('.dataTables_wrapper').addClass('text-sm');
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
<script src="{{ Vite::asset('resources/js/datatable-improvements.js') }}" defer></script>
</script>
@endpush
@endsection
