@extends('layouts.dashboard')

@section('title', __('messages.investment_details'))

@section('header')
    <div class="ml-4 flex items-center w-full">
        <div class="flex-1 min-w-0">
            <h1 class="text-xl sm:text-2xl font-semibold text-gray-900 truncate">
                {{ __('messages.investment_details') }}
            </h1>
        </div>
    </div>
@endsection

@section('content')
<div class="py-6">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Colonne principale -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Informations de l'investissement -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">{{ __('messages.investment_information') }}</h3>
                    </div>
                    <div class="p-6">
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">{{ __('messages.submission_date') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $investment->created_at->format('d/m/Y H:i') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">{{ __('messages.operator') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $investment->operator }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">{{ __('messages.investment_type') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $investment->investment_type }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">{{ __('messages.amount') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ number_format($investment->amount, 2, ',', ' ') }} Ar</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">{{ __('messages.status') }}</dt>
                                <dd class="mt-1">
                                    @if($investment->status === 'Validé')
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">{{ __('messages.approved') }}</span>
                                    @elseif($investment->status === 'Rejeté')
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">{{ __('messages.rejected') }}</span>
                                    @elseif($investment->status === 'En cours de traitement')
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">{{ __('messages.in_progress') }}</span>
                                    @else
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">{{ __('messages.submitted') }}</span>
                                    @endif
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">{{ __('messages.transaction_phone') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $investment->transaction_phone }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Informations personnelles -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">{{ __('messages.personal_details') }}</h3>
                    </div>
                    <div class="p-6">
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">{{ __('messages.last_name') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $investment->last_name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">{{ __('messages.first_name') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $investment->first_name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">{{ __('messages.phone') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $investment->phone }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">{{ __('messages.id_document_number') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $investment->id_number }}</dd>
                            </div>
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">{{ __('messages.address') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ nl2br($investment->address) }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Notes de l'administrateur -->
                @if($investment->admin_notes)
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">{{ __('messages.admin_notes') }}</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-sm text-gray-900">{{ nl2br($investment->admin_notes) }}</p>
                    </div>
                </div>
                @endif
            </div>

            <!-- Colonne latérale -->
            <div class="space-y-6">
                <!-- Documents -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">{{ __('messages.documents') }}</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <!-- Photo de la pièce d'identité -->
                        <div>
                            <h4 class="text-sm font-medium text-gray-900 mb-2">{{ __('messages.id_document_photo') }}</h4>
                            @if($investment->id_photo)
                                <img src="{{ route('investments.id_photo', $investment) }}" alt="{{ __('messages.id_document_photo') }}" class="w-full rounded-lg" style="max-height: 200px; object-fit: cover;">
                                <div class="mt-2">
                                    <a href="{{ route('investments.id_photo', $investment) }}" target="_blank" class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                        Voir en grand
                                    </a>
                                </div>
                            @else
                                <p class="text-sm text-gray-500">{{ __('messages.not_available') }}</p>
                            @endif
                        </div>

                        <!-- Preuve de transaction -->
                        <div>
                            <h4 class="text-sm font-medium text-gray-900 mb-2">{{ __('messages.transaction_proof') }}</h4>
                            @if($investment->transaction_proof)
                                <img src="{{ route('investments.transaction_proof', $investment) }}" alt="{{ __('messages.transaction_proof') }}" class="w-full rounded-lg" style="max-height: 200px; object-fit: cover;">
                                <div class="mt-2">
                                    <a href="{{ route('investments.transaction_proof', $investment) }}" target="_blank" class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                        Voir en grand
                                    </a>
                                </div>
                            @else
                                <p class="text-sm text-gray-500">{{ __('messages.not_available') }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Actions pour l'investissement -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">{{ __('messages.actions') }}</h3>
                    </div>
                    <div class="p-6 space-y-3">
                        <!-- Bouton générer facture pour les investissements validés -->
                        @if($investment->status === 'Validé')
                            <a href="{{ route('investments.invoice', $investment) }}"
                               target="_blank"
                               class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors inline-flex items-center justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                {{ __('messages.generate_invoice') }}
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Actions administrateur -->
                @if(auth()->user()->isAdmin && $investment->status !== 'Validé' && $investment->status !== 'Rejeté')
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">{{ __('messages.admin_actions') }}</h3>
                    </div>
                    <div class="p-6 space-y-3">
                        @if($investment->status === 'Envoyé')
                            <button type="button" onclick="openProcessModal()" class="w-full bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Mettre en cours de traitement
                            </button>
                        @endif

                        @if($investment->status === 'En cours de traitement')
                            <button type="button" onclick="openApproveModal()" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Approuver
                            </button>
                            <button type="button" onclick="openRejectModal()" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Rejeter
                            </button>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal pour traiter -->
@if(auth()->user()->isAdmin && $investment->status === 'Envoyé')
<div id="processModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ __('messages.process_request') }}</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">{{ __('messages.process_request_question') }}</p>
                <div class="mt-4">
                    <label for="admin_notes_process" class="block text-sm font-medium text-gray-700">{{ __('messages.optional_notes') }}</label>
                    <textarea id="admin_notes_process" name="admin_notes" rows="3" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>
            </div>
            <div class="items-center px-4 py-3">
                <form action="{{ route('investments.update', $investment) }}" method="POST" class="flex space-x-3">
                    @csrf
                    @method('PUT')
                    <button type="button" onclick="closeProcessModal()" class="flex-1 bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">Retour</button>
                    <button type="submit" class="flex-1 bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">Mettre en cours</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Modal pour approuver -->
@if(auth()->user()->isAdmin && $investment->status === 'En cours de traitement')
<div id="approveModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ __('messages.approve_investment') }}</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">{{ __('messages.approve_investment_question') }}</p>
                <div class="mt-4">
                    <label for="admin_notes_approve" class="block text-sm font-medium text-gray-700">{{ __('messages.optional_notes') }}</label>
                    <textarea id="admin_notes_approve" name="admin_notes" rows="3" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>
            </div>
            <div class="items-center px-4 py-3">
                <form action="{{ route('investments.approve', $investment) }}" method="POST" class="flex space-x-3">
                    @csrf
                    <button type="button" onclick="closeApproveModal()" class="flex-1 bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">Retour</button>
                    <button type="submit" class="flex-1 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">Approuver</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Modal pour rejeter -->
@if(auth()->user()->isAdmin && $investment->status === 'En cours de traitement')
<div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ __('messages.reject_investment') }}</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">{{ __('messages.reject_investment_question') }}</p>
                <div class="mt-4">
                    <label for="admin_notes_reject" class="block text-sm font-medium text-gray-700">{{ __('messages.rejection_reason') }} *</label>
                    <textarea id="admin_notes_reject" name="admin_notes" rows="3" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>
            </div>
            <div class="items-center px-4 py-3">
                <form action="{{ route('investments.reject', $investment) }}" method="POST" class="flex space-x-3">
                    @csrf
                    <button type="button" onclick="closeRejectModal()" class="flex-1 bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">Retour</button>
                    <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">Rejeter</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

<script>
function openProcessModal() {
    document.getElementById('processModal').classList.remove('hidden');
}

function closeProcessModal() {
    document.getElementById('processModal').classList.add('hidden');
}

function openApproveModal() {
    document.getElementById('approveModal').classList.remove('hidden');
}

function closeApproveModal() {
    document.getElementById('approveModal').classList.add('hidden');
}

function openRejectModal() {
    document.getElementById('rejectModal').classList.remove('hidden');
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
}
</script>
@endsection
