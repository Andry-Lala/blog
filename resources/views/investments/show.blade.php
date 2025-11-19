@extends('layouts.dashboard')

@section('title', 'Détails de l\'Investissement')

@section('header')
    <div class="ml-4 flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900">Détails de l'Investissement</h1>
        {{-- <a href="{{ route('investments.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Retour
        </a> --}}
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
                        <h3 class="text-lg font-medium text-gray-900">Informations de l'investissement</h3>
                    </div>
                    <div class="p-6">
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Date de soumission</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $investment->created_at->format('d/m/Y H:i') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Opérateur</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $investment->operator }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Type d'investissement</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $investment->investment_type }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Montant</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ number_format($investment->amount, 2, ',', ' ') }} Ar</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Statut</dt>
                                <dd class="mt-1">
                                    @if($investment->status === 'Validé')
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Validé</span>
                                    @elseif($investment->status === 'Rejeté')
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Rejeté</span>
                                    @elseif($investment->status === 'En cours de traitement')
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">En cours</span>
                                    @else
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Envoyé</span>
                                    @endif
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Téléphone transaction</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $investment->transaction_phone }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Informations personnelles -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Informations personnelles</h3>
                    </div>
                    <div class="p-6">
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Nom</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $investment->last_name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Prénom</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $investment->first_name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Téléphone</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $investment->phone }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Numéro pièce d'identité</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $investment->id_number }}</dd>
                            </div>
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Adresse</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ nl2br($investment->address) }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Notes de l'administrateur -->
                @if($investment->admin_notes)
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Notes de l'administrateur</h3>
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
                        <h3 class="text-lg font-medium text-gray-900">Documents</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <!-- Photo de la pièce d'identité -->
                        <div>
                            <h4 class="text-sm font-medium text-gray-900 mb-2">Photo de la pièce d'identité</h4>
                            @if($investment->id_photo)
                                <img src="{{ route('investments.id_photo', $investment) }}" alt="Photo pièce d'identité" class="w-full rounded-lg" style="max-height: 200px; object-fit: cover;">
                                <div class="mt-2">
                                    <a href="{{ route('investments.id_photo', $investment) }}" target="_blank" class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                        Voir en grand
                                    </a>
                                </div>
                            @else
                                <p class="text-sm text-gray-500">Non disponible</p>
                            @endif
                        </div>

                        <!-- Preuve de transaction -->
                        <div>
                            <h4 class="text-sm font-medium text-gray-900 mb-2">Preuve de transaction</h4>
                            @if($investment->transaction_proof)
                                <img src="{{ route('investments.transaction_proof', $investment) }}" alt="Preuve de transaction" class="w-full rounded-lg" style="max-height: 200px; object-fit: cover;">
                                <div class="mt-2">
                                    <a href="{{ route('investments.transaction_proof', $investment) }}" target="_blank" class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                        Voir en grand
                                    </a>
                                </div>
                            @else
                                <p class="text-sm text-gray-500">Non disponible</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Actions administrateur -->
                @if(auth()->user()->isAdmin && $investment->status !== 'Validé' && $investment->status !== 'Rejeté')
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Actions administrateur</h3>
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
            <h3 class="text-lg leading-6 font-medium text-gray-900">Traiter la demande</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">Voulez-vous mettre cette demande en cours de traitement ?</p>
                <div class="mt-4">
                    <label for="admin_notes_process" class="block text-sm font-medium text-gray-700">Notes (optionnel)</label>
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
            <h3 class="text-lg leading-6 font-medium text-gray-900">Approuver l'investissement</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">Êtes-vous sûr de vouloir approuver cet investissement ?</p>
                <div class="mt-4">
                    <label for="admin_notes_approve" class="block text-sm font-medium text-gray-700">Notes (optionnel)</label>
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
            <h3 class="text-lg leading-6 font-medium text-gray-900">Rejeter l'investissement</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">Êtes-vous sûr de vouloir rejeter cet investissement ?</p>
                <div class="mt-4">
                    <label for="admin_notes_reject" class="block text-sm font-medium text-gray-700">Motif du rejet *</label>
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
