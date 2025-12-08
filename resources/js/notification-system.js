// Notification system
document.addEventListener('DOMContentLoaded', function() {
    loadNotifications();
    // Auto-refresh notifications every 30 seconds
    setInterval(loadNotifications, 30000);

    // Écouter les changements de langue
    window.addEventListener('languageChanged', function() {
        // Vider le cache des notifications et forcer le rechargement
        const listContainer = document.getElementById('notificationsList');
        if (listContainer) {
            listContainer.innerHTML = '<div class="px-4 py-8 text-center text-sm text-gray-500">{{ __("messages.loading") }}</div>';
        }
        // Forcer le rechargement immédiat
        setTimeout(() => {
            loadNotifications();
        }, 200);
    });
});

function loadNotifications() {
    fetch('/notifications/unread', {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
        }
    })
    .then(response => {
        // Check if response is HTML (likely a redirect to login)
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            throw new Error('Received HTML instead of JSON - likely authentication redirect');
        }
        return response.json();
    })
    .then(data => {
        updateNotificationBadge(data.count);
        updateNotificationsList(data.notifications);

        // Update Alpine.js unreadCount variable if Alpine is available
        if (window.Alpine && window.Alpine.store) {
            // Find the Alpine component and update unreadCount
            document.querySelectorAll('[x-data*="unreadCount"]').forEach(el => {
                if (el._x_dataStack && el._x_dataStack[0]) {
                    el._x_dataStack[0].unreadCount = data.count;
                }
            });
        }
    })
    .catch(error => {
        console.error('Error loading notifications:', error);
        // If it's an authentication error, we can silently fail or redirect
        if (error.message.includes('authentication')) {
            // Silently fail - the auth guard will handle redirect
            return;
        }
    });
}

function updateNotificationBadge(count) {
    const badges = document.querySelectorAll('.notification-badge');
    badges.forEach(badge => {
        if (badge) {
            if (count > 0) {
                badge.textContent = count > 99 ? '99+' : count;
                badge.classList.remove('hidden');
            } else {
                badge.classList.add('hidden');
            }
        }
    });

    // Also update Alpine.js data
    document.querySelectorAll('[x-data*="unreadCount"]').forEach(el => {
        if (el._x_dataStack && el._x_dataStack[0]) {
            el._x_dataStack[0].unreadCount = count;
        }
    });
}

function updateNotificationsList(notifications) {
    const listContainer = document.getElementById('notificationsList');
    if (!listContainer) return;

    if (notifications.length === 0) {
        const noNotificationsText = getTranslation('no_notifications');
        listContainer.innerHTML = `
            <div class="px-4 py-8 text-center text-sm text-gray-500">
                ${noNotificationsText}
            </div>
        `;
        return;
    }

    listContainer.innerHTML = notifications.map(notification => `
        <div class="px-4 py-3 hover:bg-gray-50 cursor-pointer border-b border-gray-100 last:border-b-0"
             onclick="viewNotification(${notification.id})">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class="${getNotificationIcon(notification.type)}"></i>
                </div>
                <div class="ml-3 flex-1">
                    <p class="text-sm font-medium text-gray-900">${notification.title}</p>
                    <p class="text-xs text-gray-600 mt-1">${notification.message}</p>
                    <p class="text-xs text-gray-500 mt-1">${formatTime(notification.created_at)}</p>
                </div>
            </div>
        </div>
    `).join('');
}

function getNotificationIcon(type) {
    const icons = {
        'success': 'fas fa-check-circle text-green-500',
        'error': 'fas fa-exclamation-circle text-red-500',
        'warning': 'fas fa-exclamation-triangle text-yellow-500',
        'info': 'fas fa-info-circle text-blue-500',
        'default': 'fas fa-bell text-gray-500'
    };
    return icons[type] || icons.default;
}

function formatTime(dateString) {
    const date = new Date(dateString);
    const now = new Date();
    const diff = Math.floor((now - date) / 1000); // diff in seconds

    const justNow = getTranslation('just_now');
    const minutesAgo = getTranslation('minutes_ago');
    const hoursAgo = getTranslation('hours_ago');
    const daysAgo = getTranslation('days_ago');

    // Obtenir la langue actuelle depuis l'HTML ou une variable globale
    const currentLang = document.documentElement.lang ||
                      (typeof window.currentLocale !== 'undefined' ? window.currentLocale : 'fr');

    if (diff < 60) return justNow;
    if (diff < 3600) {
        const minutes = Math.floor(diff / 60);
        // Forcer la traduction selon la langue actuelle
        if (currentLang === 'fr') {
            return `il y a ${minutes} minute${minutes > 1 ? 's' : ''}`;
        } else {
            return `${minutes} minute${minutes > 1 ? 's' : ''} ago`;
        }
    }
    if (diff < 86400) {
        const hours = Math.floor(diff / 3600);
        // Forcer la traduction selon la langue actuelle
        if (currentLang === 'fr') {
            return `il y a ${hours} heure${hours > 1 ? 's' : ''}`;
        } else {
            return `${hours} hour${hours > 1 ? 's' : ''} ago`;
        }
    }
    const days = Math.floor(diff / 86400);
    // Forcer la traduction selon la langue actuelle
    if (currentLang === 'fr') {
        if (days === 7) {
            return `il y a 1 semaine`;
        }
        return `il y a ${days} jour${days > 1 ? 's' : ''}`;
    } else {
        if (days === 7) {
            return `1 week ago`;
        }
        return `${days} day${days > 1 ? 's' : ''} ago`;
    }
}

function getTranslation(key) {
    // Récupérer les traductions depuis les données globales ou le HTML
    const translations = window.translations || {};
    return translations[key] || key;
}

function viewNotification(id) {
    window.location.href = `/notifications/${id}`;
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
            loadNotifications();
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// Authentication checks
(function() {
    fetch('/api/auth-check', {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
        }
    })
    .then(response => {
        if (!response.ok) {
            // If not authenticated, redirect immediately
            window.location.href = '/login';
        }
    })
    .catch(error => {
        console.error('Authentication check error:', error);
        // In case of error, redirect to login for security
        window.location.href = '/login';
    });
})();

// Prevent access via "Back" button after logout
window.addEventListener('pageshow', function(event) {
    // Check if the page is loaded from browser cache
    if (event.persisted) {
        // Force page reload from server
        window.location.reload();
    }
});

// Periodic authentication check
setInterval(function() {
    fetch('/api/auth-check', {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
        }
    })
    .then(response => {
        if (!response.ok) {
            // If response is not OK, redirect to login page
            window.location.href = '/login';
        }
    })
    .catch(error => {
        console.error('Authentication check error:', error);
        // In case of error, redirect to login for security
        window.location.href = '/login';
    });
}, 10000); // Check every 10 seconds for more security
