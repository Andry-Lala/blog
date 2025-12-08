// Alpine.js notification component
document.addEventListener('alpine:init', () => {
    Alpine.data('notificationSystem', () => ({
        unreadCount: 0,
        notificationOpen: false,
        notifications: [],
        loading: true,

        init() {
            this.loadNotifications();
            // Auto-refresh notifications every 30 seconds
            setInterval(() => this.loadNotifications(), 30000);

            // Écouter les changements de langue
            window.addEventListener('languageChanged', () => {
                // Forcer le rechargement immédiat des notifications
                setTimeout(() => {
                    this.loadNotifications();
                }, 200);
            });
        },

        async loadNotifications() {
            this.loading = true;
            try {
                const response = await fetch('/notifications/unread', {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                    }
                });

                // Check if response is HTML (likely a redirect to login)
                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    throw new Error('Received HTML instead of JSON - likely authentication redirect');
                }

                const data = await response.json();
                this.unreadCount = data.count;
                this.notifications = data.notifications;
                this.loading = false;

                // Update DOM elements for backward compatibility
                this.updateNotificationBadge(data.count);
                this.updateNotificationsList(data.notifications);

            } catch (error) {
                console.error('Error loading notifications:', error);
                this.loading = false;

                // If it's an authentication error, we can silently fail or redirect
                if (error.message.includes('authentication') || error.message.includes('HTML')) {
                    // Silently fail - the auth guard will handle redirect
                    return;
                }
            }
        },

        updateNotificationBadge(count) {
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
        },

        updateNotificationsList(notifications) {
            const listContainer = document.getElementById('notificationsList');
            if (!listContainer) return;

            if (notifications.length === 0) {
                const noNotificationsText = this.getTranslation('no_notifications');
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
                            <i class="${this.getNotificationIcon(notification.type)}"></i>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-medium text-gray-900">${notification.title}</p>
                            <p class="text-xs text-gray-600 mt-1">${notification.message}</p>
                            <p class="text-xs text-gray-500 mt-1">${this.formatTime(notification.created_at)}</p>
                        </div>
                    </div>
                </div>
            `).join('');
        },

        getNotificationIcon(type) {
            const icons = {
                'success': 'fas fa-check-circle text-green-500',
                'error': 'fas fa-exclamation-circle text-red-500',
                'warning': 'fas fa-exclamation-triangle text-yellow-500',
                'info': 'fas fa-info-circle text-blue-500',
                'default': 'fas fa-bell text-gray-500'
            };
            return icons[type] || icons.default;
        },

        formatTime(dateString) {
            const date = new Date(dateString);
            const now = new Date();
            const diff = Math.floor((now - date) / 1000); // diff in seconds

            const justNow = this.getTranslation('just_now');
            const minutesAgo = this.getTranslation('minutes_ago');
            const hoursAgo = this.getTranslation('hours_ago');
            const daysAgo = this.getTranslation('days_ago');

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
        },

        getTranslation(key) {
            // Récupérer les traductions depuis les données globales ou le HTML
            const translations = window.translations || {};
            return translations[key] || key;
        },

        async markAllAsRead() {
            try {
                const response = await fetch('/notifications/read-all', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                const data = await response.json();
                if (data.success) {
                    this.loadNotifications();
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }
    }));
});
