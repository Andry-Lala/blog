@extends('layouts.dashboard')

@section('title', 'Détails de la notification')

@section('header')
    <h1 class="ml-4 text-2xl font-semibold text-gray-900">Détails de la notification</h1>
@endsection

@section('content')
<div class="py-6">
    <div class="px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900">Détails</h3>
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('notifications.index') }}"
                           class="text-sm text-blue-600 hover:text-blue-800">
                            Retour à la liste
                        </a>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="{{ $notification->icon }} text-2xl"></i>
                    </div>
                    <div class="ml-4 flex-1">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="text-lg font-medium text-gray-900">
                                {{ $notification->title }}
                                @if(!$notification->is_read)
                                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                        Nouveau
                                    </span>
                                @endif
                            </h4>
                            <span class="text-sm text-gray-500">
                                {{ $notification->created_at->format('d/m/Y H:i') }}
                            </span>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4 mb-4">
                            <p class="text-gray-700">
                                {{ $notification->message }}
                            </p>
                        </div>

                        <div class="flex items-center justify-between mb-4">
                            <div class="text-sm text-gray-500">
                                Type: <span class="font-medium">{{ ucfirst($notification->type) }}</span>
                            </div>
                            <div class="text-sm text-gray-500">
                                Statut:
                                @if($notification->is_read)
                                    <span class="text-green-600 font-medium">Lu</span>
                                @else
                                    <span class="text-blue-600 font-medium">Non lu</span>
                                @endif
                            </div>
                        </div>

                        @if($notification->related)
                            <div class="border-t border-gray-200 pt-4">
                                <h5 class="text-sm font-medium text-gray-900 mb-2">Élément associé</h5>
                                <a href="{{ getNotificationLink($notification) }}"
                                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Voir les détails →
                                </a>
                            </div>
                        @endif

                        @if($notification->data && !empty($notification->data))
                            <div class="border-t border-gray-200 pt-4 mt-4">
                                <h5 class="text-sm font-medium text-gray-900 mb-2">Informations supplémentaires</h5>
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <pre class="text-xs text-gray-600 overflow-x-auto">{{ json_encode($notification->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-500">
                        ID: {{ $notification->id }}
                    </div>
                    <div class="flex items-center space-x-2">
                        @if(!$notification->is_read)
                            <form method="POST" action="{{ route('notifications.read', $notification->id) }}" class="inline">
                                @csrf
                                <button type="submit"
                                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    Marquer comme lu
                                </button>
                            </form>
                        @endif
                        <form method="POST" action="{{ route('notifications.destroy', $notification->id) }}"
                              class="inline"
                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette notification ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
