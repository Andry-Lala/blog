@extends('layouts.dashboard')

@section('title', __('messages.notifications'))

@section('header')
    <h1 class="ml-4 text-2xl font-semibold text-gray-900">{{ __('messages.my_notifications') }}</h1>
@endsection

@section('content')
<div class="py-6">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900">{{ __('messages.notification_list') }}</h3>
                    <div class="flex items-center space-x-2">
                        <button onclick="markAllAsRead()" class="text-sm text-blue-600 hover:text-blue-800">
                            {{ __('messages.mark_all_read') }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="divide-y divide-gray-200">
                @if($notifications->count() > 0)
                    @foreach($notifications as $notification)
                        <div class="notification-item {{ $notification->is_read ? 'opacity-75' : '' }}"
                             data-id="{{ $notification->id }}"
                             onclick="showNotificationDetails({{ $notification->id }})"
                             class="px-6 py-4 hover:bg-gray-50 cursor-pointer transition-colors">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <i class="{{ $notification->icon }}"></i>
                                </div>
                                <div class="ml-3 flex-1">
                                    <div class="flex items-center justify-between">
                                        <h4 class="text-sm font-medium text-gray-900">
                                            {{ $notification->title }}
                                            @if(!$notification->is_read)
                                                <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ __('messages.new_notification') }}
                                                </span>
                                            @endif
                                        </h4>
                                        <div class="flex items-center space-x-2">
                                            <span class="text-xs text-gray-500">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </span>
                                            <button onclick="event.stopPropagation(); deleteNotification({{ $notification->id }})"
                                                    class="text-red-600 hover:text-red-800">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <p class="mt-1 text-sm text-gray-600">
                                        {{ $notification->message }}
                                    </p>
                                    @if($notification->related)
                                        <div class="mt-2">
                                            <a href="{{ getNotificationLink($notification) }}"
                                               class="text-sm text-blue-600 hover:text-blue-800"
                                               onclick="event.stopPropagation()">
                                                {{ __('messages.view_details') }} →
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
                        <h3 class="mt-2 text-sm font-medium text-gray-900">{{ __('messages.no_notifications') }}</h3>
                        <p class="mt-1 text-sm text-gray-500">{{ __('messages.no_notifications_currently') }}</p>
                    </div>
                @endif
            </div>
            {{-- La pagination n'est pas nécessaire pour les collections simples --}}
        </div>
    </div>
</div>

<!-- Modal pour les détails de notification -->
<div id="notificationModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900" id="modalTitle"></h3>
                <button onclick="closeNotificationModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="mb-4">
                <p class="text-sm text-gray-600" id="modalMessage"></p>
                <p class="text-xs text-gray-500 mt-2" id="modalDate"></p>
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
    // Optimisation : utiliser des variables globales pour éviter les sélecteurs répétés
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const notificationModal = document.getElementById('notificationModal');
    const modalTitle = document.getElementById('modalTitle');
    const modalMessage = document.getElementById('modalMessage');
    const modalDate = document.getElementById('modalDate');
    const modalActions = document.getElementById('modalActions');

    // Optimisation : utiliser un debounce pour les appels API fréquents
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Optimisation : précharger les détails des notifications visibles
    function preloadNotificationDetails() {
        const visibleNotifications = document.querySelectorAll('.notification-item[data-id]');
        visibleNotifications.forEach(item => {
            const notificationId = item.dataset.id;
            // Précharger uniquement si ce n'est pas déjà fait
            if (!item.dataset.preloaded) {
                fetch(`/notifications/${notificationId}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                }).then(response => response.json())
                  .then(data => {
                      item.dataset.notificationData = JSON.stringify(data.notification);
                      item.dataset.preloaded = 'true';
                  })
                  .catch(() => {}); // Ignorer les erreurs de préchargement
            }
        });
    }

    function showNotificationDetails(notificationId) {
        const notificationItem = document.querySelector(`[data-id="${notificationId}"]`);

        // Optimisation : utiliser les données préchargées si disponibles
        if (notificationItem && notificationItem.dataset.preloaded && notificationItem.dataset.notificationData) {
            const notification = JSON.parse(notificationItem.dataset.notificationData);
            displayNotificationModal(notification, { unread_count: getCurrentUnreadCount() });
        } else {
            // Fallback : charger les données via AJAX
            fetch(`/notifications/${notificationId}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.json())
            .then(data => {
                displayNotificationModal(data.notification, data);
            })
            .catch(error => {
                console.error('Erreur:', error);
                showToast('{{ __('messages.error_loading_notification') }}', 'error');
            });
        }
    }

    function displayNotificationModal(notification, data) {
        modalTitle.textContent = notification.title;
        modalMessage.textContent = notification.message;
        modalDate.textContent = new Date(notification.created_at).toLocaleString('fr-FR');

        modalActions.innerHTML = '';

        if (notification.related && notification.related_type === 'App\\Models\\Investment') {
            const viewButton = document.createElement('a');
            viewButton.href = `/investments/${notification.related_id}`;
            viewButton.className = 'inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500';
            viewButton.textContent = '{{ __('messages.view_investment') }}';
            modalActions.appendChild(viewButton);
        }

        const closeButton = document.createElement('button');
        closeButton.onclick = closeNotificationModal;
        closeButton.className = 'inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500';
        closeButton.textContent = '{{ __('messages.close') }}';
        modalActions.appendChild(closeButton);

        notificationModal.classList.remove('hidden');

        // Mettre à jour le compteur de notifications non lues
        if (data.unread_count !== undefined) {
            updateNotificationCount(data.unread_count);
        }
    }

    function closeNotificationModal() {
        notificationModal.classList.add('hidden');
    }

    // Optimisation : utiliser une fonction pour afficher les messages toast
    function showToast(message, type = 'info') {
        // Créer un élément toast simple
        const toast = document.createElement('div');
        toast.className = `fixed top-4 right-4 px-4 py-2 rounded-md text-white z-50 ${
            type === 'error' ? 'bg-red-500' :
            type === 'success' ? 'bg-green-500' :
            'bg-blue-500'
        }`;
        toast.textContent = message;
        document.body.appendChild(toast);

        setTimeout(() => {
            toast.remove();
        }, 3000);
    }

    function getCurrentUnreadCount() {
        const badge = document.querySelector('.notification-badge');
        return badge && !badge.classList.contains('hidden') ? parseInt(badge.textContent) : 0;
    }

    function markAsRead(notificationId) {
        fetch(`/notifications/${notificationId}/read`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
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
                showToast('{{ __('messages.notification_marked_as_read') }}', 'success');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            showToast('{{ __('messages.error_marking_as_read') }}', 'error');
        });
    }

    function markAllAsRead() {
        fetch('/notifications/read-all', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
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
            showToast('{{ __('messages.error_marking_all_as_read') }}', 'error');
        });
    }

    function deleteNotification(notificationId) {
        if (confirm('{{ __('messages.confirm_delete_notification') }}')) {
            fetch(`/notifications/${notificationId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
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
                    showToast('{{ __('messages.notification_deleted') }}', 'success');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                showToast('{{ __('messages.error_deleting') }}', 'error');
            });
        }
    }

    // Optimisation : debounce pour les mises à jour fréquentes du compteur
    const updateNotificationCount = debounce(function(count) {
        const badge = document.querySelector('.notification-badge');
        if (badge) {
            if (count > 0) {
                badge.textContent = count;
                badge.classList.remove('hidden');
            } else {
                badge.classList.add('hidden');
            }
        }
    }, 100);

    // Optimisation : précharger les détails après le chargement de la page
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(preloadNotificationDetails, 500);
    });

    // Optimisation : précharger lors du défilement
    let scrollTimeout;
    window.addEventListener('scroll', function() {
        clearTimeout(scrollTimeout);
        scrollTimeout = setTimeout(preloadNotificationDetails, 200);
    });
</script>
@endpush
