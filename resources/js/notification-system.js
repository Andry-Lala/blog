// Notification system
document.addEventListener('DOMContentLoaded', function() {
    loadNotifications();
    // Auto-refresh notifications every 30 seconds
    setInterval(loadNotifications, 30000);
});

function loadNotifications() {
    fetch('/notifications/unread')
        .then(response => response.json())
        .then(data => {
            updateNotificationBadge(data.count);
            updateNotificationsList(data.notifications);
        })
        .catch(error => {
            console.error('Error loading notifications:', error);
        });
}

function updateNotificationBadge(count) {
    const badge = document.querySelector('.notification-badge');
    if (badge) {
        if (count > 0) {
            badge.textContent = count > 99 ? '99+' : count;
            badge.classList.remove('hidden');
        } else {
            badge.classList.add('hidden');
        }
    }
}

function updateNotificationsList(notifications) {
    const listContainer = document.getElementById('notificationsList');
    if (!listContainer) return;

    if (notifications.length === 0) {
        listContainer.innerHTML = `
            <div class="px-4 py-8 text-center text-sm text-gray-500">
                No notifications
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

    if (diff < 60) return 'just now';
    if (diff < 3600) return `minutes ago ${Math.floor(diff / 60)}`;
    if (diff < 86400) return `hours ago ${Math.floor(diff / 3600)}`;
    return `days ago ${Math.floor(diff / 86400)}`;
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
