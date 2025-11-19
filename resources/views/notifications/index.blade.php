@extends('layouts.dashboard')

@section('title', 'Notifications')

@section('header')
    <h1 class="ml-4 text-2xl font-semibold text-gray-900 dark:text-white">Mes notifications</h1>
@endsection

@section('content')
<div class="py-6">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Liste des notifications</h3>
                    <div class="flex items-center space-x-2">
                        <button onclick="markAllAsRead()" class="text-sm text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300">
                            Tout marquer comme lu
                        </button>
                    </div>
                </div>
            </div>
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                @if($notifications->count() > 0)
                    @foreach($notifications as $notification)
                        <div class="notification-item {{ $notification->is_read ? 'opacity-75' : '' }}"
                             data-id="{{ $notification->id }}"
                             onclick="showNotificationDetails({{ $notification->id }})"
                             class="px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer transition-colors">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <i class="{{ $notification->icon }}"></i>
                                </div>
                                <div class="ml-3 flex-1">
                                    <div class="flex items-center justify-between">
                                        <h4 class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $notification->title }}
                                            @if(!$notification->is_read)
                                                <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                    Nouveau
                                                </span>
                                            @endif
                                        </h4>
                                        <div class="flex items-center space-x-2">
                                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </span>
                                            <button onclick="event.stopPropagation(); deleteNotification({{ $notification->id }})"
                                                    class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                        {{ $notification->message }}
                                    </p>
                                    @if($notification->related)
                                        <div class="mt-2">
                                            <a href="{{ getNotificationLink($notification) }}"
                                               class="text-sm text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300"
                                               onclick="event.stopPropagation()">
                                                Voir les détails →
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="px-6 py-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Aucune notification</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Vous n'avez aucune notification pour le moment.</p>
                    </div>
                @endif
            </div>
            @if($notifications->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $notifications->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal pour les détails de notification -->
<div id="notificationModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white" id="modalTitle"></h3>
                <button onclick="closeNotificationModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="mb-4">
                <p class="text-sm text-gray-600 dark:text-gray-400" id="modalMessage"></p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2" id="modalDate"></p>
            </div>
            <div id="modalActions" class="flex justify-end space-x-2">
                <!-- Actions dynamiques -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function showNotificationDetails(notificationId) {
        fetch(`/notifications/${notificationId}`)
            .then(response => response.json())
            .then(data => {
                const notification = data.notification;
                document.getElementById('modalTitle').textContent = notification.title;
                document.getElementById('modalMessage').textContent = notification.message;
                document.getElementById('modalDate').textContent = new Date(notification.created_at).toLocaleString('fr-FR');

                const modalActions = document.getElementById('modalActions');
                modalActions.innerHTML = '';

                if (notification.related && notification.related_type === 'App\\Models\\Investment') {
                    const viewButton = document.createElement('a');
                    viewButton.href = `/investments/${notification.related_id}`;
                    viewButton.className = 'inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500';
                    viewButton.textContent = 'Voir l\'investissement';
                    modalActions.appendChild(viewButton);
                }

                const closeButton = document.createElement('button');
                closeButton.onclick = closeNotificationModal;
                closeButton.className = 'inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600';
                closeButton.textContent = 'Fermer';
                modalActions.appendChild(closeButton);

                document.getElementById('notificationModal').classList.remove('hidden');

                // Mettre à jour le compteur de notifications non lues
                updateNotificationCount(data.unread_count);
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Une erreur est survenue lors du chargement des détails de la notification.');
            });
    }

    function closeNotificationModal() {
        document.getElementById('notificationModal').classList.add('hidden');
    }

    function markAsRead(notificationId) {
        fetch(`/notifications/${notificationId}/read`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const notificationItem = document.querySelector(`[data-id="${notificationId}"]`);
                if (notificationItem) {
                    notificationItem.classList.add('opacity-75');
                    const newBadge = notificationItem.querySelector('.bg-blue-100');
                    if (newBadge) {
                        newBadge.remove();
                    }
                }
                updateNotificationCount(data.unread_count);
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
        });
    }

    function markAllAsRead() {
        fetch('/notifications/read-all', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
        });
    }

    function deleteNotification(notificationId) {
        if (confirm('Êtes-vous sûr de vouloir supprimer cette notification ?')) {
            fetch(`/notifications/${notificationId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const notificationItem = document.querySelector(`[data-id="${notificationId}"]`);
                    if (notificationItem) {
                        notificationItem.remove();
                    }
                    updateNotificationCount(data.unread_count);
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
            });
        }
    }

    function updateNotificationCount(count) {
        const badge = document.querySelector('.notification-badge');
        if (badge) {
            if (count > 0) {
                badge.textContent = count;
                badge.classList.remove('hidden');
            } else {
                badge.classList.add('hidden');
            }
        }
    }
</script>
@endpush
