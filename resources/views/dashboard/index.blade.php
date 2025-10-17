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
                                Voici ce qui se passe avec votre blog aujourd'hui.
                            </p>
                        </div>

                        <!-- Stats grid -->
                        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
                            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                                <div class="p-5">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div class="w-8 h-8 bg-indigo-500 rounded-md flex items-center justify-center">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="ml-5 w-0 flex-1">
                                            <dl>
                                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total des articles</dt>
                                                <dd class="text-lg font-medium text-gray-900 dark:text-white">42</dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700 px-5 py-3">
                                    <div class="text-sm">
                                        <span class="text-green-600 dark:text-green-400 font-medium">+18%</span>
                                        <span class="text-gray-500 dark:text-gray-400"> depuis le mois dernier</span>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                                <div class="p-5">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="ml-5 w-0 flex-1">
                                            <dl>
                                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total des vues</dt>
                                                <dd class="text-lg font-medium text-gray-900 dark:text-white">3,847</dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700 px-5 py-3">
                                    <div class="text-sm">
                                        <span class="text-green-600 dark:text-green-400 font-medium">+31%</span>
                                        <span class="text-gray-500 dark:text-gray-400"> depuis le mois dernier</span>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                                <div class="p-5">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="ml-5 w-0 flex-1">
                                            <dl>
                                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Commentaires</dt>
                                                <dd class="text-lg font-medium text-gray-900 dark:text-white">156</dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700 px-5 py-3">
                                    <div class="text-sm">
                                        <span class="text-green-600 dark:text-green-400 font-medium">+14%</span>
                                        <span class="text-gray-500 dark:text-gray-400"> depuis le mois dernier</span>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                                <div class="p-5">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div class="w-8 h-8 bg-red-500 rounded-md flex items-center justify-center">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="ml-5 w-0 flex-1">
                                            <dl>
                                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">J'aime</dt>
                                                <dd class="text-lg font-medium text-gray-900 dark:text-white">523</dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700 px-5 py-3">
                                    <div class="text-sm">
                                        <span class="text-green-600 dark:text-green-400 font-medium">+8%</span>
                                        <span class="text-gray-500 dark:text-gray-400"> depuis le mois dernier</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Charts and recent activity -->
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <!-- Chart -->
                            <div class="lg:col-span-2 bg-white dark:bg-gray-800 shadow rounded-lg">
                                <div class="p-6">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Aperçu du trafic</h3>
                                    <div class="h-64 flex items-center justify-center bg-gray-50 dark:bg-gray-700 rounded-lg">
                                        <div class="text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                            </svg>
                                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Espace réservé au graphique</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Recent activity -->
                            <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                                <div class="p-6">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Activité récente</h3>
                                    <div class="space-y-4">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0">
                                                <div class="w-2 h-2 bg-green-400 rounded-full mt-2 activity-dot"></div>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm text-gray-900 dark:text-white">Nouveau commentaire sur "Création d'applications web modernes"</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">il y a 30 minutes</p>
                                            </div>
                                        </div>
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0">
                                                <div class="w-2 h-2 bg-blue-400 rounded-full mt-2 activity-dot"></div>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm text-gray-900 dark:text-white">Publié "Plongée en profondeur dans React Hooks"</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">il y a 2 heures</p>
                                            </div>
                                        </div>
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0">
                                                <div class="w-2 h-2 bg-yellow-400 rounded-full mt-2 activity-dot"></div>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm text-gray-900 dark:text-white">Mis à jour "Meilleures pratiques Tailwind CSS"</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">il y a 4 heures</p>
                                            </div>
                                        </div>
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0">
                                                <div class="w-2 h-2 bg-purple-400 rounded-full mt-2 activity-dot"></div>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm text-gray-900 dark:text-white">Pic d'inscriptions d'utilisateurs</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">il y a 6 heures</p>
                                            </div>
                                        </div>
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0">
                                                <div class="w-2 h-2 bg-red-400 rounded-full mt-2 activity-dot"></div>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm text-gray-900 dark:text-white">47 commentaires indésirables supprimés</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">il y a 1 jour</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Recent posts -->
                        <div class="mt-8 bg-white dark:bg-gray-800 shadow rounded-lg">
                            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Articles récents</h3>
                            </div>
                            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                                <div class="px-6 py-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900 dark:text-white">Création d'applications web modernes avec Laravel</h4>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Publié il y a 3 jours</p>
                                        </div>
                                        <div class="flex items-center space-x-4 text-sm text-gray-500 dark:text-gray-400">
                                            <span>2.8k vues</span>
                                            <span>47 commentaires</span>
                                            <span>124 j'aime</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="px-6 py-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900 dark:text-white">Plongée en profondeur dans React Hooks</h4>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Publié il y a 2 heures</p>
                                        </div>
                                        <div class="flex items-center space-x-4 text-sm text-gray-500 dark:text-gray-400">
                                            <span>1.5k vues</span>
                                            <span>28 commentaires</span>
                                            <span>89 j'aime</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="px-6 py-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900 dark:text-white">Meilleures pratiques Tailwind CSS</h4>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Mis à jour il y a 4 heures</p>
                                        </div>
                                        <div class="flex items-center space-x-4 text-sm text-gray-500 dark:text-gray-400">
                                            <span>3.2k vues</span>
                                            <span>93 commentaires</span>
                                            <span>167 j'aime</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="px-6 py-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900 dark:text-white">Fonctionnalités JavaScript ES2024</h4>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Publié il y a 1 jour</p>
                                        </div>
                                        <div class="flex items-center space-x-4 text-sm text-gray-500 dark:text-gray-400">
                                            <span>987 vues</span>
                                            <span>19 commentaires</span>
                                            <span>56 j'aime</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="px-6 py-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900 dark:text-white">Principes de conception d'API</h4>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Publié il y a 5 jours</p>
                                        </div>
                                        <div class="flex items-center space-x-4 text-sm text-gray-500 dark:text-gray-400">
                                            <span>1.9k vues</span>
                                            <span>34 commentaires</span>
                                            <span>78 j'aime</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
</div>
@endsection