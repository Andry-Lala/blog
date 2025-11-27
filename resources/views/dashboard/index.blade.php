@extends('layouts.dashboard')

@section('title', __('messages.dashboard'))

@section('header')
    <h1 class="ml-4 text-2xl font-semibold text-gray-900">{{ __('messages.dashboard') }}</h1>
@endsection

@section('content')
<div class="py-6">
    <div class="px-4 sm:px-6 lg:px-8">
                        <!-- Welcome section -->
                        <div class="mb-8">
                            <h2 class="text-2xl font-bold text-gray-900">
                                {{ __('messages.welcome') }}, {{ $user->prenom }} {{ $user->nom }}!
                            </h2>
                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('messages.overview') }} {{ __('messages.of_your_investment_platform') }}.
                            </p>
                            <div class="mt-4">
                                <a href="{{ route('informations.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium rounded-md transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    {{ __('messages.personal_info') }}
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
                                                <dt class="text-sm font-medium text-gray-500 truncate">
                                                    @if($user->role === 'administrateur')
                                                        {{ __('messages.total_investments') }}
                                                    @else
                                                        {{ __('messages.my_investments') }}
                                                    @endif
                                                </dt>
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
                                                <dt class="text-sm font-medium text-gray-500 truncate">{{ __('messages.pending') }}</dt>
                                                <dd class="text-lg font-medium text-gray-900">{{ $pendingInvestments }}</dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-5 py-3">
                                    <div class="text-sm">
                                        <span class="text-yellow-600 font-medium">{{ __('messages.in_validation') }}</span>
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
                                                <dt class="text-sm font-medium text-gray-500 truncate">
                                                    @if($user->role === 'administrateur')
                                                        {{ __('messages.validated') }}
                                                    @else
                                                        {{ __('messages.my_validated') }}
                                                    @endif
                                                </dt>
                                                <dd class="text-lg font-medium text-gray-900">{{ $validatedInvestments }}</dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-5 py-3">
                                    <div class="text-sm">
                                        <span class="text-green-600 font-medium">{{ __('messages.approved') }}</span>
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
                                                <dt class="text-sm font-medium text-gray-500 truncate">{{ __('messages.my_investments') }}</dt>
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
                                            {{ __('messages.global_investment_overview') }}
                                        @else
                                            {{ __('messages.your_investments_this_year') }}
                                        @endif
                                    </h3>
                                    @if($user->role === 'administrateur')
                                        <!-- Tabs for switching between views -->
                                        <div class="mb-4 border-b border-gray-200">
                                            <nav class="-mb-px flex space-x-8">
                                                <button class="py-2 px-1 border-b-2 border-blue-400 font-medium text-sm text-blue-500" id="countTab" onclick="switchChart('count')">
                                                    {{ __('messages.investment_count') }}
                                                </button>
                                                <button class="py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-400 hover:text-gray-600 hover:border-gray-200" id="amountTab" onclick="switchChart('amount')">
                                                    {{ __('messages.investment_amounts') }}
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
                                        <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('messages.your_statistics') }}</h3>
                                        <div class="space-y-4">
                                            <div class="flex items-center justify-between">
                                                <span class="text-sm text-gray-500">{{ __('messages.pending') }}</span>
                                                <span class="text-lg font-semibold text-yellow-500">{{ $userPendingCount }}</span>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <span class="text-sm text-gray-500">{{ __('messages.processing') }}</span>
                                                <span class="text-lg font-semibold text-blue-500">{{ $userProcessingCount }}</span>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <span class="text-sm text-gray-500">{{ __('messages.validated') }}</span>
                                                <span class="text-lg font-semibold text-green-500">{{ $userValidatedCount }}</span>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <span class="text-sm text-gray-500">{{ __('messages.rejected') }}</span>
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
                                        <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('messages.global_statistics') }}</h3>
                                        <div class="space-y-4">
                                            <div class="flex items-center justify-between">
                                                <span class="text-sm text-gray-500">{{ __('messages.total_clients') }}</span>
                                                <span class="text-sm font-semibold text-blue-500">{{ $totalClients ?? 0 }}</span>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <span class="text-sm text-gray-500">Montants validés</span>
                                                <span class="text-sm font-semibold text-green-500">{{ number_format($totalValidatedAmount ?? 0, 2, ',', ' ') }} Ar</span>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <span class="text-sm text-gray-500">Montants en attente</span>
                                                <span class="text-sm font-semibold text-yellow-500">{{ number_format($totalPendingAmount ?? 0, 2, ',', ' ') }} Ar</span>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <span class="text-sm text-gray-500">Montants en cours</span>
                                                <span class="text-sm font-semibold text-blue-500">{{ number_format($totalProcessingAmount ?? 0, 2, ',', ' ') }} Ar</span>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <span class="text-sm text-gray-500">Montants rejetés</span>
                                                <span class="text-sm font-semibold text-red-500">{{ number_format($totalRejectedAmount ?? 0, 2, ',', ' ') }} Ar</span>
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
                                            {{ __('messages.recent_global_activity') }}
                                        @else
                                            {{ __('messages.your_recent_activity') }}
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
                                                                {{ __('messages.investment_of') }} {{ $investment->user->prenom ?? '' }} {{ $investment->user->nom ?? '' }}
                                                            @else
                                                                {{ __('messages.your_investment') }}
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
                                                    {{ __('messages.no_recent_global_activity') }}
                                                @else
                                                    {{ __('messages.no_recent_activity') }}
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
                                            <h3 class="text-lg font-medium text-gray-900">{{ __('messages.investment_suggestions') }}</h3>
                                            <p class="mt-1 text-sm text-gray-600">{{ __('messages.choose_investment_type') }}</p>
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
                                                                <span class="bg-red-400 text-white text-xs px-2 py-1 rounded-full font-semibold">{{ __('messages.premium') }}</span>
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
                                                                <span class="text-gray-500">{{ __('messages.minimum_amount') }}</span>
                                                                <span class="font-medium text-gray-900">{{ number_format($amountsInAriary['min_ariary'], 0, ',', ' ') }} Ar</span>
                                                            </div>
                                                            <div class="flex justify-between text-sm">
                                                                <span class="text-gray-500">{{ __('messages.maximum_amount') }}</span>
                                                                <span class="font-medium text-gray-900">
                                                                    @if($amountsInAriary['max_ariary'])
                                                                        {{ number_format($amountsInAriary['max_ariary'], 0, ',', ' ') }} Ar
                                                                    @else
                                                                        {{ __('messages.unlimited') }}
                                                                    @endif
                                                                </span>
                                                            </div>
                                                            <div class="flex justify-between text-sm">
                                                                <span class="text-gray-500">{{ __('messages.usd_equivalent') }}</span>
                                                                <span class="font-medium text-gray-900">
                                                                    ${{ number_format($type->min_amount_usd, 0) }}
                                                                    @if($type->max_amount_usd)
                                                                        - ${{ number_format($type->max_amount_usd, 0) }}
                                                                    @else
                                                                        {{ __('messages.and_more') }}
                                                                    @endif
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <a href="{{ route('investments.create') }}?type={{ $type->slug }}" class="w-full {{ $colorScheme['button'] }} text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors text-center block">
                                                            {{ __('messages.invest') }}
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
                                        {{ __('messages.recent_global_investments') }}
                                    @else
                                        {{ __('messages.your_recent_investments') }}
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
                                            {{ __('messages.no_recent_global_investments') }}
                                        @else
                                            {{ __('messages.no_recent_investments') }}
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
        const ctx = document.getElementById('investmentChart');
        if (!ctx) {
            console.error('Canvas element not found!');
            return;
        }

        const chartContext = ctx.getContext('2d');
        if (!chartContext) {
            console.error('Could not get canvas context!');
            return;
        }

        const isAdmin = @json($user->role === 'administrateur');

        // Préparer les données de base pour tous les utilisateurs
        const baseDatasets = [
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
        ];

        // Ajouter les datasets supplémentaires uniquement pour l'admin
        let datasets = [...baseDatasets];
        if (isAdmin) {
            datasets.push({
                label: 'Investissements en Cours',
                data: @json($processingData ?? []),
                backgroundColor: 'rgba(59, 130, 246, 0.2)',
                borderColor: 'rgba(59, 130, 246, 1)',
                borderWidth: 2,
                tension: 0.4
            });

            datasets.push({
                label: 'Investissements Rejetés',
                data: @json($rejectedData ?? []),
                backgroundColor: 'rgba(239, 68, 68, 0.2)',
                borderColor: 'rgba(239, 68, 68, 1)',
                borderWidth: 2,
                tension: 0.4
            });
        }

        const countData = {
            labels: @json($chartLabels ?? []),
            datasets: datasets
        };

        // Configuration simplifiée du graphique
        const chartConfig = {
            type: 'line',
            data: countData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            color: '#475569',
                            font: { size: 12 }
                        }
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    x: {
                        grid: { color: 'rgba(0, 0, 0, 0.1)' },
                        ticks: { color: '#64748b' }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0, 0, 0, 0.1)' },
                        ticks: {
                            color: '#64748b',
                            precision: 0
                        }
                    }
                }
            }
        };

        // Vérifier que Chart.js est disponible
        if (typeof Chart === 'undefined') {
            console.error('Chart.js is not loaded!');
            return;
        }

        try {
            investmentChart = new Chart(chartContext, chartConfig);
            console.log('Chart created successfully for', isAdmin ? 'admin' : 'client');
        } catch (error) {
            console.error('Error creating chart:', error);
        }

        // Fonction pour basculer entre les vues (uniquement pour les admins)
        window.switchChart = function(view) {
            if (!isAdmin) return;

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

            const countTab = document.getElementById('countTab');
            const amountTab = document.getElementById('amountTab');

            if (view === 'count') {
                countTab.className = 'py-2 px-1 border-b-2 border-blue-400 font-medium text-sm text-blue-500';
                amountTab.className = 'py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-400 hover:text-gray-600 hover:border-gray-200';
                investmentChart.data = countData;
            } else {
                amountTab.className = 'py-2 px-1 border-b-2 border-blue-400 font-medium text-sm text-blue-500';
                countTab.className = 'py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-400 hover:text-gray-600 hover:border-gray-200';
                investmentChart.data = amountData;
            }

            investmentChart.update();
        };
    });
</script>
@endpush
