@extends('layouts.dashboard')

@section('title', 'Tableau de bord')

@section('header')
    <h1 class="ml-4 text-2xl font-semibold text-gray-900 dark:text-white">Tableau de bord</h1>
@endsection

@section('content')
<div class="py-6">
    <div class="px-4 sm:px-6 lg:px-8">
                        <!-- Welcome section -->
                        <div class="mb-8">
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                                Bon retour, {{ $user->prenom }} {{ $user->nom }}!
                            </h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                Vue d'ensemble de votre plateforme d'investissement.
                            </p>
                            <div class="mt-4">
                                <a href="{{ route('informations.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Voir mes informations personnelles
                                </a>
                            </div>
                        </div>

                        <!-- Stats grid -->
                        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
                            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                                <div class="p-5">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div class="w-8 h-8 bg-indigo-500 rounded-md flex items-center justify-center">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="ml-5 w-0 flex-1">
                                            <dl>
                                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total des investissements</dt>
                                                <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $totalInvestments }}</dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700 px-5 py-3">
                                    <div class="text-sm">
                                        <span class="text-gray-500 dark:text-gray-400">{{ number_format($totalAmount, 2, ',', ' ') }} Ar</span>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
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
                                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">En attente</dt>
                                                <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $pendingInvestments }}</dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700 px-5 py-3">
                                    <div class="text-sm">
                                        <span class="text-yellow-600 dark:text-yellow-400 font-medium">En cours de validation</span>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                                <div class="p-5">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="ml-5 w-0 flex-1">
                                            <dl>
                                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Validés</dt>
                                                <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $validatedInvestments }}</dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700 px-5 py-3">
                                    <div class="text-sm">
                                        <span class="text-green-600 dark:text-green-400 font-medium">Approuvés</span>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                                <div class="p-5">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="ml-5 w-0 flex-1">
                                            <dl>
                                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Mes investissements</dt>
                                                <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $userInvestments }}</dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700 px-5 py-3">
                                    <div class="text-sm">
                                        <span class="text-gray-500 dark:text-gray-400">{{ number_format($userTotalAmount, 2, ',', ' ') }} Ar</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Charts and recent activity -->
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <!-- Chart -->
                            <div class="lg:col-span-2 bg-white dark:bg-gray-800 shadow rounded-lg">
                                <div class="p-6">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                                        @if($user->role === 'administrateur')
                                            Aperçu global des investissements
                                        @else
                                            Vos investissements cette année
                                        @endif
                                    </h3>
                                    <div class="h-64 bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                        <canvas id="investmentChart"></canvas>
                                    </div>
                                </div>
                            </div>

                            <!-- User Statistics (only for non-admins) -->
                            @if($user->role !== 'administrateur')
                                <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                                    <div class="p-6">
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Vos statistiques</h3>
                                        <div class="space-y-4">
                                            <div class="flex items-center justify-between">
                                                <span class="text-sm text-gray-500 dark:text-gray-400">En attente</span>
                                                <span class="text-lg font-semibold text-yellow-600 dark:text-yellow-400">{{ $userPendingCount }}</span>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <span class="text-sm text-gray-500 dark:text-gray-400">En cours</span>
                                                <span class="text-lg font-semibold text-blue-600 dark:text-blue-400">{{ $userProcessingCount }}</span>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <span class="text-sm text-gray-500 dark:text-gray-400">Validés</span>
                                                <span class="text-lg font-semibold text-green-600 dark:text-green-400">{{ $userValidatedCount }}</span>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <span class="text-sm text-gray-500 dark:text-gray-400">Rejetés</span>
                                                <span class="text-lg font-semibold text-red-600 dark:text-red-400">{{ $userRejectedCount }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Recent activity -->
                            <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                                <div class="p-6">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
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
                                                            @if($investment->status === 'Validé') bg-green-400
                                                            @elseif($investment->status === 'Envoyé') bg-yellow-400
                                                            @elseif($investment->status === 'En cours de traitement') bg-blue-400
                                                            @else bg-red-400
                                                            @endif rounded-full mt-2 activity-dot"></div>
                                                    </div>
                                                    <div class="ml-3">
                                                        <p class="text-sm text-gray-900 dark:text-white">
                                                            @if($user->role === 'administrateur')
                                                                Investissement de {{ $investment->user->prenom ?? '' }} {{ $investment->user->nom ?? '' }}
                                                            @else
                                                                Votre investissement
                                                            @endif
                                                            de {{ number_format($investment->amount, 2, ',', ' ') }} Ar
                                                            <span class="text-xs text-gray-500 dark:text-gray-400">({{ $investment->investment_type }})</span>
                                                        </p>
                                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                                            {{ $investment->created_at->diffForHumans() }}
                                                        </p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="text-center text-sm text-gray-500 dark:text-gray-400">
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

                        <!-- Recent investments -->
                        <div class="mt-8 bg-white dark:bg-gray-800 shadow rounded-lg">
                            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                                    @if($user->role === 'administrateur')
                                        Investissements récents globaux
                                    @else
                                        Vos investissements récents
                                    @endif
                                </h3>
                            </div>
                            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                                @if(($user->role === 'administrateur' ? $recentInvestments : $userRecentInvestments)->count() > 0)
                                    @foreach(($user->role === 'administrateur' ? $recentInvestments : $userRecentInvestments) as $investment)
                                        <div class="px-6 py-4">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <h4 class="text-sm font-medium text-gray-900 dark:text-white">
                                                        @if($user->role === 'administrateur')
                                                            {{ $investment->first_name }} {{ $investment->last_name }} - {{ $investment->investment_type }}
                                                        @else
                                                            {{ $investment->investment_type }} - {{ $investment->operator }}
                                                        @endif
                                                    </h4>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                                        {{ $investment->created_at->format('d/m/Y H:i') }}
                                                    </p>
                                                </div>
                                                <div class="flex items-center space-x-4 text-sm">
                                                    <span class="text-gray-900 dark:text-white font-medium">
                                                        {{ number_format($investment->amount, 2, ',', ' ') }} Ar
                                                    </span>
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                                        @if($investment->status === 'Validé') bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100
                                                        @elseif($investment->status === 'Envoyé') bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100
                                                        @elseif($investment->status === 'En cours de traitement') bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100
                                                        @else bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100
                                                        @endif">
                                                        {{ $investment->status }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
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
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('investmentChart').getContext('2d');

        // Données réelles pour le graphique provenant du contrôleur
        const investmentData = {
            labels: @json($chartLabels ?? []),
            datasets: [
                {
                    label: 'Investissements Validés',
                    data: @json($userValidatedData ?? $validatedData ?? []),
                    backgroundColor: 'rgba(34, 197, 94, 0.2)',
                    borderColor: 'rgba(34, 197, 94, 1)',
                    borderWidth: 2,
                    tension: 0.4
                },
                {
                    label: 'Investissements en Attente',
                    data: @json($userPendingData ?? $pendingData ?? []),
                    backgroundColor: 'rgba(250, 204, 21, 0.2)',
                    borderColor: 'rgba(250, 204, 21, 1)',
                    borderWidth: 2,
                    tension: 0.4
                }
            ]
        };

        // Configuration du graphique
        const config = {
            type: 'line',
            data: investmentData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            color: document.documentElement.classList.contains('dark') ? '#fff' : '#374151',
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
                                    label += context.parsed.y + ' investissements';
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            color: document.documentElement.classList.contains('dark') ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)'
                        },
                        ticks: {
                            color: document.documentElement.classList.contains('dark') ? '#9CA3AF' : '#6B7280'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: document.documentElement.classList.contains('dark') ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)'
                        },
                        ticks: {
                            color: document.documentElement.classList.contains('dark') ? '#9CA3AF' : '#6B7280'
                        }
                    }
                }
            }
        };

        // Créer le graphique
        new Chart(ctx, config);
    });
</script>
@endpush
