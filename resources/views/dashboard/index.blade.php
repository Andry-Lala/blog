@extends('layouts.dashboard')

@section('title', 'Tableau de bord')

@section('header')
    <h1 class="ml-4 text-2xl font-semibold text-gray-900">Tableau de bord</h1>
@endsection

@section('content')
<div class="py-6">
    <div class="px-4 sm:px-6 lg:px-8">
                        <!-- Welcome section -->
                        <div class="mb-8">
                            <h2 class="text-2xl font-bold text-gray-900">
                                Bon retour, {{ $user->prenom }} {{ $user->nom }}!
                            </h2>
                            <p class="mt-1 text-sm text-gray-600">
                                Vue d'ensemble de votre plateforme d'investissement.
                            </p>
                            <div class="mt-4">
                                <a href="{{ route('informations.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium rounded-md transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Voir mes informations personnelles
                                </a>
                            </div>
                        </div>

                        <!-- Stats grid -->
                        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
                            <div class="bg-white overflow-hidden shadow rounded-lg">
                                <div class="p-5">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div class="w-8 h-8 bg-blue-400 rounded-md flex items-center justify-center">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="ml-5 w-0 flex-1">
                                            <dl>
                                                <dt class="text-sm font-medium text-gray-500 truncate">Total des investissements</dt>
                                                <dd class="text-lg font-medium text-gray-900">{{ $totalInvestments }}</dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-5 py-3">
                                    <div class="text-sm">
                                        <span class="text-gray-500">{{ number_format($totalAmount, 2, ',', ' ') }} Ar</span>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white overflow-hidden shadow rounded-lg">
                                <div class="p-5">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div class="w-8 h-8 bg-yellow-400 rounded-md flex items-center justify-center">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="ml-5 w-0 flex-1">
                                            <dl>
                                                <dt class="text-sm font-medium text-gray-500 truncate">En attente</dt>
                                                <dd class="text-lg font-medium text-gray-900">{{ $pendingInvestments }}</dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-5 py-3">
                                    <div class="text-sm">
                                        <span class="text-yellow-600 font-medium">En cours de validation</span>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white overflow-hidden shadow rounded-lg">
                                <div class="p-5">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div class="w-8 h-8 bg-green-400 rounded-md flex items-center justify-center">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="ml-5 w-0 flex-1">
                                            <dl>
                                                <dt class="text-sm font-medium text-gray-500 truncate">Validés</dt>
                                                <dd class="text-lg font-medium text-gray-900">{{ $validatedInvestments }}</dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-5 py-3">
                                    <div class="text-sm">
                                        <span class="text-green-600 font-medium">Approuvés</span>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white overflow-hidden shadow rounded-lg">
                                <div class="p-5">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div class="w-8 h-8 bg-purple-400 rounded-md flex items-center justify-center">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="ml-5 w-0 flex-1">
                                            <dl>
                                                <dt class="text-sm font-medium text-gray-500 truncate">Mes investissements</dt>
                                                <dd class="text-lg font-medium text-gray-900">{{ $userInvestments }}</dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-5 py-3">
                                    <div class="text-sm">
                                        <span class="text-gray-500">{{ number_format($userTotalAmount, 2, ',', ' ') }} Ar</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Charts and recent activity -->
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <!-- Chart -->
                            <div class="lg:col-span-2 bg-white shadow rounded-lg">
                                <div class="p-6">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                                        @if($user->role === 'administrateur')
                                            Aperçu global des investissements
                                        @else
                                            Vos investissements cette année
                                        @endif
                                    </h3>
                                    @if($user->role === 'administrateur')
                                        <!-- Tabs for switching between views -->
                                        <div class="mb-4 border-b border-gray-200">
                                            <nav class="-mb-px flex space-x-8">
                                                <button class="py-2 px-1 border-b-2 border-blue-400 font-medium text-sm text-blue-500" id="countTab" onclick="switchChart('count')">
                                                    Nombre d'investissements
                                                </button>
                                                <button class="py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-400 hover:text-gray-600 hover:border-gray-200" id="amountTab" onclick="switchChart('amount')">
                                                    Montants des investissements
                                                </button>
                                            </nav>
                                        </div>
                                    @endif
                                    <div class="h-64 bg-gray-50 rounded-lg p-4">
                                        <canvas id="investmentChart"></canvas>
                                    </div>
                                </div>
                            </div>

                            <!-- User Statistics (only for non-admins) -->
                            @if($user->role !== 'administrateur')
                                <div class="bg-white shadow rounded-lg">
                                    <div class="p-6">
                                        <h3 class="text-lg font-medium text-gray-900 mb-4">Vos statistiques</h3>
                                        <div class="space-y-4">
                                            <div class="flex items-center justify-between">
                                                <span class="text-sm text-gray-500">En attente</span>
                                                <span class="text-lg font-semibold text-yellow-500">{{ $userPendingCount }}</span>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <span class="text-sm text-gray-500">En cours</span>
                                                <span class="text-lg font-semibold text-blue-500">{{ $userProcessingCount }}</span>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <span class="text-sm text-gray-500">Validés</span>
                                                <span class="text-lg font-semibold text-green-500">{{ $userValidatedCount }}</span>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <span class="text-sm text-gray-500">Rejetés</span>
                                                <span class="text-lg font-semibold text-red-500">{{ $userRejectedCount }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Global Statistics (only for admins) -->
                            @if($user->role === 'administrateur')
                                <div class="bg-white shadow rounded-lg">
                                    <div class="p-6">
                                        <h3 class="text-lg font-medium text-gray-900 mb-4">Statistiques globales</h3>
                                        <div class="space-y-4">
                                            <div class="flex items-center justify-between">
                                                <span class="text-sm text-gray-500">Total clients</span>
                                                <span class="text-lg font-semibold text-blue-500">{{ $totalClients ?? 0 }}</span>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <span class="text-sm text-gray-500">Montants validés</span>
                                                <span class="text-lg font-semibold text-green-500">{{ number_format($totalValidatedAmount ?? 0, 2, ',', ' ') }} Ar</span>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <span class="text-sm text-gray-500">Montants en attente</span>
                                                <span class="text-lg font-semibold text-yellow-500">{{ number_format($totalPendingAmount ?? 0, 2, ',', ' ') }} Ar</span>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <span class="text-sm text-gray-500">Montants en cours</span>
                                                <span class="text-lg font-semibold text-blue-500">{{ number_format($totalProcessingAmount ?? 0, 2, ',', ' ') }} Ar</span>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <span class="text-sm text-gray-500">Montants rejetés</span>
                                                <span class="text-lg font-semibold text-red-500">{{ number_format($totalRejectedAmount ?? 0, 2, ',', ' ') }} Ar</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Recent activity -->
                            <div class="bg-white shadow rounded-lg">
                                <div class="p-6">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                                        @if($user->role === 'administrateur')
                                            Activité récente globale
                                        @else
                                            Votre activité récente
                                        @endif
                                    </h3>
                                    <div class="space-y-4">
                                        @if(($user->role === 'administrateur' ? $recentInvestments : $userRecentInvestments)->count() > 0)
                                            @foreach(($user->role === 'administrateur' ? $recentInvestments : $userRecentInvestments)->take(5) as $investment)
                                                <div class="flex items-start">
                                                    <div class="flex-shrink-0">
                                                        <div class="w-2 h-2
                                                            @if($investment->status === 'Validé') bg-green-300
                                                            @elseif($investment->status === 'Envoyé') bg-yellow-300
                                                            @elseif($investment->status === 'En cours de traitement') bg-blue-300
                                                            @else bg-red-300
                                                            @endif rounded-full mt-2 activity-dot"></div>
                                                    </div>
                                                    <div class="ml-3">
                                                        <p class="text-sm text-gray-900">
                                                            @if($user->role === 'administrateur')
                                                                Investissement de {{ $investment->user->prenom ?? '' }} {{ $investment->user->nom ?? '' }}
                                                            @else
                                                                Votre investissement
                                                            @endif
                                                            de {{ number_format($investment->amount, 2, ',', ' ') }} Ar
                                                            <span class="text-xs text-gray-500">({{ $investment->investment_type }})</span>
                                                        </p>
                                                        <p class="text-xs text-gray-500">
                                                            {{ $investment->created_at->diffForHumans() }}
                                                        </p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="text-center text-sm text-gray-500">
                                                @if($user->role === 'administrateur')
                                                    Aucune activité récente globale
                                                @else
                                                    Vous n'avez aucune activité récente
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Investment Suggestions Section (only for clients) -->
                        @if($user->role !== 'administrateur')
                            <div class="mt-8">
                                <div class="px-4 sm:px-6 lg:px-8">
                                    <div class="bg-white shadow rounded-lg">
                                        <div class="px-6 py-4 border-b border-gray-200">
                                            <h3 class="text-lg font-medium text-gray-900">Suggestions d'investissement</h3>
                                            <p class="mt-1 text-sm text-gray-600">Choisissez le type d'investissement qui vous correspond</p>
                                        </div>
                                        <div class="p-6">
                                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                                                @foreach($investmentTypes as $index => $type)
                                                    @php
                                                        $amountsInAriary = $type->getAmountsInAriary();
                                                        $colorSchemes = [
                                                            [
                                                                'gradient' => 'from-gray-100 to-gray-200',
                                                                'border' => 'border-gray-300',
                                                                'icon' => 'bg-gray-300',
                                                                'button' => 'bg-gray-500 hover:bg-gray-600'
                                                            ],
                                                            [
                                                                'gradient' => 'from-yellow-100 to-yellow-200',
                                                                'border' => 'border-yellow-300',
                                                                'icon' => 'bg-yellow-400',
                                                                'button' => 'bg-yellow-500 hover:bg-yellow-600'
                                                            ],
                                                            [
                                                                'gradient' => 'from-purple-100 to-purple-200',
                                                                'border' => 'border-purple-300',
                                                                'icon' => 'bg-purple-400',
                                                                'button' => 'bg-purple-500 hover:bg-purple-600'
                                                            ],
                                                            [
                                                                'gradient' => 'from-blue-100 to-blue-200',
                                                                'border' => 'border-blue-300',
                                                                'icon' => 'bg-blue-400',
                                                                'button' => 'bg-blue-500 hover:bg-blue-600'
                                                            ]
                                                        ];
                                                        $colorScheme = $colorSchemes[$index % count($colorSchemes)];
                                                    @endphp
                                                    <div class="bg-gradient-to-br {{ $colorScheme['gradient'] }} rounded-lg p-6 border {{ $colorScheme['border'] }} hover:shadow-lg transition-all duration-300 {{ $index === 3 ? 'relative' : '' }}">
                                                        @if($index === 3)
                                                            <div class="absolute top-2 right-2">
                                                                <span class="bg-red-400 text-white text-xs px-2 py-1 rounded-full font-semibold">Premium</span>
                                                            </div>
                                                        @endif
                                                        <div class="flex items-center justify-center w-12 h-12 {{ $colorScheme['icon'] }} rounded-full mb-4">
                                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                            </svg>
                                                        </div>
                                                        <h4 class="text-lg font-semibold text-gray-900 mb-2">{{ $type->name }}</h4>
                                                        <p class="text-sm text-gray-600 mb-4">{{ $type->description }}</p>
                                                        <div class="space-y-2 mb-4">
                                                            <div class="flex justify-between text-sm">
                                                                <span class="text-gray-500">Montant minimum:</span>
                                                                <span class="font-medium text-gray-900">{{ number_format($amountsInAriary['min_ariary'], 0, ',', ' ') }} Ar</span>
                                                            </div>
                                                            <div class="flex justify-between text-sm">
                                                                <span class="text-gray-500">Montant maximum:</span>
                                                                <span class="font-medium text-gray-900">
                                                                    @if($amountsInAriary['max_ariary'])
                                                                        {{ number_format($amountsInAriary['max_ariary'], 0, ',', ' ') }} Ar
                                                                    @else
                                                                        Illimité
                                                                    @endif
                                                                </span>
                                                            </div>
                                                            <div class="flex justify-between text-sm">
                                                                <span class="text-gray-500">Équivalent USD:</span>
                                                                <span class="font-medium text-gray-900">
                                                                    ${{ number_format($type->min_amount_usd, 0) }}
                                                                    @if($type->max_amount_usd)
                                                                        - ${{ number_format($type->max_amount_usd, 0) }}
                                                                    @else
                                                                        et plus
                                                                    @endif
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <a href="{{ route('investments.create') }}?type={{ $type->slug }}" class="w-full {{ $colorScheme['button'] }} text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors text-center block">
                                                            Investir
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Recent investments -->
                        <div class="mt-8 bg-white shadow rounded-lg">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900">
                                    @if($user->role === 'administrateur')
                                        Investissements récents globaux
                                    @else
                                        Vos investissements récents
                                    @endif
                                </h3>
                            </div>
                            <div class="divide-y divide-gray-200">
                                @if(($user->role === 'administrateur' ? $recentInvestments : $userRecentInvestments)->count() > 0)
                                    @foreach(($user->role === 'administrateur' ? $recentInvestments : $userRecentInvestments) as $investment)
                                        <div class="px-6 py-4">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <h4 class="text-sm font-medium text-gray-900">
                                                        @if($user->role === 'administrateur')
                                                            {{ $investment->first_name }} {{ $investment->last_name }} - {{ $investment->investment_type }}
                                                        @else
                                                            {{ $investment->investment_type }} - {{ $investment->operator }}
                                                        @endif
                                                    </h4>
                                                    <p class="text-sm text-gray-500">
                                                        {{ $investment->created_at->format('d/m/Y H:i') }}
                                                    </p>
                                                </div>
                                                <div class="flex items-center space-x-4 text-sm">
                                                    <span class="text-gray-900 font-medium">
                                                        {{ number_format($investment->amount, 2, ',', ' ') }} Ar
                                                    </span>
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                                        @if($investment->status === 'Validé') bg-green-50 text-green-600
                                                        @elseif($investment->status === 'Envoyé') bg-yellow-50 text-yellow-600
                                                        @elseif($investment->status === 'En cours de traitement') bg-blue-50 text-blue-600
                                                        @else bg-red-50 text-red-600
                                                        @endif">
                                                        {{ $investment->status }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="px-6 py-4 text-center text-sm text-gray-500">
                                        @if($user->role === 'administrateur')
                                            Aucun investissement récent global
                                        @else
                                            Vous n'avez aucun investissement récent
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
</div>
@endsection

@push('scripts')
<script>
    let investmentChart = null;
    let currentView = 'count';

    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('investmentChart').getContext('2d');

        // Données pour le graphique de nombre d'investissements
        const countData = {
            labels: @json($chartLabels ?? []),
            datasets: [
                {
                    label: 'Investissements Validés',
                    data: @json($userValidatedData ?? $validatedData ?? []),
                    backgroundColor: 'rgba(74, 222, 128, 0.2)',
                    borderColor: 'rgba(74, 222, 128, 1)',
                    borderWidth: 2,
                    tension: 0.4
                },
                {
                    label: 'Investissements en Attente',
                    data: @json($userPendingData ?? $pendingData ?? []),
                    backgroundColor: 'rgba(250, 204, 21, 0.3)',
                    borderColor: 'rgba(250, 204, 21, 1)',
                    borderWidth: 2,
                    tension: 0.4
                }
            ]
        };

        // Données pour le graphique de montants d'investissements (uniquement pour les admins)
        const amountData = {
            labels: @json($chartLabels ?? []),
            datasets: [
                {
                    label: 'Montants Validés',
                    data: @json($validatedAmountData ?? []),
                    backgroundColor: 'rgba(74, 222, 128, 0.2)',
                    borderColor: 'rgba(74, 222, 128, 1)',
                    borderWidth: 2,
                    tension: 0.4
                },
                {
                    label: 'Montants en Attente',
                    data: @json($pendingAmountData ?? []),
                    backgroundColor: 'rgba(250, 204, 21, 0.3)',
                    borderColor: 'rgba(250, 204, 21, 1)',
                    borderWidth: 2,
                    tension: 0.4
                }
            ]
        };

        // Configuration du graphique
        function createChart(data, isAmount = false) {
            return {
                type: 'line',
                data: data,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                color: '#475569',
                                font: {
                                    size: 12
                                }
                            }
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        if (isAmount) {
                                            label += new Intl.NumberFormat('fr-FR').format(context.parsed.y) + ' Ar';
                                        } else {
                                            label += context.parsed.y + ' investissements';
                                        }
                                    }
                                    return label;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)'
                            },
                            ticks: {
                                color: '#64748b'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)'
                            },
                            ticks: {
                                color: '#64748b',
                                callback: function(value) {
                                    if (isAmount) {
                                        return new Intl.NumberFormat('fr-FR', { notation: 'compact', compactDisplay: 'short' }).format(value) + ' Ar';
                                    }
                                    return value;
                                }
                            }
                        }
                    }
                }
            };
        }

        // Créer le graphique initial
        const isAdmin = @json($user->role === 'administrateur');
        const initialData = isAdmin ? countData : countData;
        investmentChart = new Chart(ctx, createChart(initialData, false));

        // Fonction pour basculer entre les vues (uniquement pour les admins)
        window.switchChart = function(view) {
            if (!isAdmin) return;

            currentView = view;

            // Mettre à jour les styles des onglets
            const countTab = document.getElementById('countTab');
            const amountTab = document.getElementById('amountTab');

            if (view === 'count') {
                countTab.className = 'py-2 px-1 border-b-2 border-blue-400 font-medium text-sm text-blue-500';
                amountTab.className = 'py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-400 hover:text-gray-600 hover:border-gray-200';
                investmentChart.data = countData;
                investmentChart.options = createChart(countData, false).options;
            } else {
                amountTab.className = 'py-2 px-1 border-b-2 border-blue-400 font-medium text-sm text-blue-500';
                countTab.className = 'py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-400 hover:text-gray-600 hover:border-gray-200';
                investmentChart.data = amountData;
                investmentChart.options = createChart(amountData, true).options;
            }

            investmentChart.update();
        };
    });
</script>
@endpush
