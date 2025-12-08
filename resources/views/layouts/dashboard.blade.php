<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', __('messages.dashboard')) - Unicorn Madagascar</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/blog-logo.jpeg') }}">

    <!-- Prévenir la mise en cache -->
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, post-check=0, pre-check=0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="Thu, 01 Jan 1970 00:00:00 GMT">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.tailwindcss.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.tailwindcss.min.css">

    <style>
        /* Styles personnalisés pour les boutons DataTables */
        .btn {
            display: inline-block;
            padding: 0.375rem 0.75rem;
            margin-bottom: 0;
            font-size: 0.875rem;
            font-weight: 500;
            line-height: 1.5;
            text-align: center;
            text-decoration: none;
            vertical-align: middle;
            cursor: pointer;
            border: 1px solid transparent;
            border-radius: 0.375rem;
            transition: all 0.15s ease-in-out;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            line-height: 1.5;
            border-radius: 0.25rem;
        }

        .btn-primary {
            color: #fff;
            background-color: #3b82f6;
            border-color: #3b82f6;
        }

        .btn-primary:hover {
            color: #fff;
            background-color: #2563eb;
            border-color: #2563eb;
        }

        .btn-success {
            color: #fff;
            background-color: #10b981;
            border-color: #10b981;
        }

        .btn-success:hover {
            color: #fff;
            background-color: #059669;
            border-color: #059669;
        }

        .btn-danger {
            color: #fff;
            background-color: #ef4444;
            border-color: #ef4444;
        }

        .btn-danger:hover {
            color: #fff;
            background-color: #dc2626;
            border-color: #dc2626;
        }

        .mr-2 {
            margin-right: 0.5rem;
        }

        /* Styles pour DataTables */
        .row {
            display: flex;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
        }

        .col-md-6 {
            flex: 0 0 50%;
            max-width: 50%;
            padding-right: 15px;
            padding-left: 15px;
        }

        .text-right {
            text-align: right;
        }

        .mb-4 {
            margin-bottom: 1rem;
        }

        .mt-4 {
            margin-top: 1rem;
        }

        /* Styles pour les formulaires DataTables */
        .form-control {
            display: block;
            width: 100%;
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
            line-height: 1.5;
            color: #374151;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .form-control:focus {
            color: #374151;
            background-color: #fff;
            border-color: #3b82f6;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
        }

        .form-control-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            line-height: 1.5;
            border-radius: 0.25rem;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/notification-system.js', 'resources/js/notification-alpine.js'])
    <script src="{{ asset('js/ultimate-auth-guard.js') }}"></script>
</head>
<body class="bg-gray-50 text-gray-900">
    <div class="flex h-screen overflow-hidden">
        <!-- Mobile menu overlay -->
        <div id="mobileMenuOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden" onclick="toggleMobileMenu()"></div>
        <!-- Sidebar -->
        <aside id="mobileMenu" class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 transform -translate-x-full transition-transform duration-300 ease-in-out md:relative md:transform-none md:flex md:flex-shrink-0 md:translate-x-0">
            <div class="flex flex-col w-64 h-full">
                <div class="flex flex-col flex-grow pt-5 pb-4 overflow-y-auto bg-white border-r border-gray-200">
                    <div class="flex items-center flex-shrink-0 px-4">
                        <img src="{{ asset('images/blog-logo.jpeg') }}" alt="Unicorn Madagascar" class="h-8 w-auto rounded mr-2">
                        <span class="text-lg font-semibold text-gray-800">Unicorn Madagascar</span>
                    </div>
                    <nav class="mt-8 flex-1 px-2 space-y-1">
                        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'bg-blue-100 text-blue-900' : 'text-gray-600 hover:bg-gray-100 hover:text-blue-600' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <svg class="text-gray-500 mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            {{ __('messages.dashboard') }}
                        </a>
                        <a href="{{ route('informations.index') }}" class="{{ request()->routeIs('informations.*') ? 'bg-blue-100 text-blue-900' : 'text-gray-600 hover:bg-gray-100 hover:text-blue-600' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <svg class="text-gray-400 group-hover:text-gray-500 mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            {{ __('messages.profile') }}
                        </a>
                        <a href="{{ route('investments.index') }}" class="{{ request()->routeIs('investments.*') ? 'bg-blue-100 text-blue-900' : 'text-gray-600 hover:bg-gray-100 hover:text-blue-600' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <svg class="text-gray-400 group-hover:text-gray-500 mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            {{ __('messages.investments') }}
                        </a>
                        @if(Auth::user()->role === 'administrateur')
                            <a href="{{ route('investments.pending') }}" class="{{ request()->routeIs('investments.pending') ? 'bg-blue-100 text-blue-900' : 'text-gray-600 hover:bg-gray-100 hover:text-blue-600' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                                <svg class="text-gray-400 group-hover:text-gray-500 mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ __('messages.pending_investments') }}
                            </a>
                        @endif
                        @if(Auth::user()->role === 'administrateur')
                            <a href="{{ route('clients.index') }}" class="{{ request()->routeIs('clients.*') ? 'bg-blue-100 text-blue-900' : 'text-gray-600 hover:bg-gray-100 hover:text-blue-600' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                                <svg class="text-gray-400 group-hover:text-gray-500 mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1m0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                                {{ __('messages.manage_clients') }}
                            </a>
                            <a href="{{ route('admin.exchange-rates.index') }}" class="{{ request()->routeIs('admin.exchange-rates.*') ? 'bg-blue-100 text-blue-900' : 'text-gray-600 hover:bg-gray-100 hover:text-blue-600' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                                <svg class="text-gray-400 group-hover:text-gray-500 mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ __('messages.manage_rates') }}
                            </a>
                            <a href="{{ route('admin.avis.index') }}" class="{{ request()->routeIs('admin.avis.*') ? 'bg-blue-100 text-blue-900' : 'text-gray-600 hover:bg-gray-100 hover:text-blue-600' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                                <svg class="text-gray-400 group-hover:text-gray-500 mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h8m-8 4h6m2-8v10a2 2 0 01-2 2H7l-4 4V6a2 2 0 012-2h10a2 2 0 012 2z" />
                                </svg>
                                {{ __('messages.view_reviews') }}
                            </a>
                        @endif
                        <!-- Logout button -->
                        <form method="POST" action="{{ route('logout') }}" class="mt-auto">
                            @csrf
                            <button type="submit" class="w-full text-left text-gray-600 hover:bg-red-50 hover:text-red-600 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                                <svg class="text-gray-400 group-hover:text-red-500 mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                {{ __('messages.logout') }}
                            </button>
                        </form>
                    </nav>
                </div>
            </div>
        </aside>

        <!-- Main content -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Top header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between h-16">
                        <div class="flex items-center space-x-4 flex-1 min-w-0">
                            <button class="md:hidden p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500 flex-shrink-0" aria-label="{{ __('messages.open_menu') }}" aria-expanded="false" onclick="toggleMobileMenu()">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>
                            </button>
                            <div class="flex-1 min-w-0">
                                @yield('header')
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <!-- Language switcher -->
                            <x-language-switcher />

                            <!-- Notifications dropdown -->
                            <div class="relative" x-data="{
                                unreadCount: 0,
                                notificationOpen: false,
                                init() {
                                    window.loadNotifications();
                                    setInterval(() => window.loadNotifications(), 30000);
                                }
                            }">
                                <button @click="notificationOpen = !notificationOpen" class="p-2 rounded-full text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 relative" aria-label="{{ __('messages.notifications') }}">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                    </svg>
                                    <span class="notification-badge absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-400 ring-2 ring-white" x-show="unreadCount > 0" x-text="unreadCount > 99 ? '99+' : unreadCount"></span>
                                </button>

                                <!-- Dropdown panel -->
                                <div x-show="notificationOpen"
                                     x-transition:enter="transition ease-out duration-100"
                                     x-transition:enter-start="transform opacity-0 scale-95"
                                     x-transition:enter-end="transform opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="transform opacity-100 scale-100"
                                     x-transition:leave-end="transform opacity-0 scale-95"
                                     @click.away="notificationOpen = false"
                                     class="absolute right-0 mt-2 w-80 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                                    <div class="py-1">
                                        <div class="px-4 py-2 border-b border-gray-200">
                                            <div class="flex items-center justify-between">
                                                <h3 class="text-sm font-medium text-gray-900">{{ __('messages.notifications') }}</h3>
                                                <a href="{{ route('notifications.index') }}" class="text-xs text-blue-600 hover:text-blue-800">
                                                    {{ __('messages.view') }}
                                                </a>
                                            </div>
                                        </div>
                                        <div class="max-h-96 overflow-y-auto" id="notificationsList">
                                            <!-- Notifications will be loaded here -->
                                            <div class="px-4 py-8 text-center text-sm text-gray-500">
                                                {{ __('messages.loading') }}
                                            </div>
                                        </div>
                                        <div class="px-4 py-2 border-t border-gray-200">
                                            <button onclick="markAllAsRead()" class="w-full text-center text-xs text-blue-600 hover:text-blue-800">
                                                {{ __('messages.mark_all_read') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="relative">
                                <button class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" aria-label="Menu utilisateur" aria-expanded="false">
                                    <span class="sr-only">{{ __('messages.user_menu') }}</span>
                                    <div class="h-8 w-8 rounded-full bg-indigo-600 flex items-center justify-center">
                                        <span class="text-white font-medium">{{ strtoupper(substr(auth()->user()->prenom ?? auth()->user()->username ?? 'U', 0, 1)) }}</span>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main content area -->
            <main class="flex-1 overflow-y-auto bg-gray-50">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.tailwindcss.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.tailwindcss.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

    @stack('scripts')
    <script>
        // Injecter les traductions pour les notifications
        window.translations = {
            'no_notifications': "{{ __('messages.no_notifications') }}",
            'just_now': "{{ __('messages.just_now') }}",
            'minutes_ago': "{{ __('messages.minutes_ago') }}",
            'hours_ago': "{{ __('messages.hours_ago') }}",
            'days_ago': "{{ __('messages.days_ago') }}"
        };

        // Injecter la langue actuelle pour les traductions temporelles
        window.currentLocale = "{{ app()->getLocale() }}";

        // Fonction pour recharger les traductions
        window.updateTranslations = function() {
            fetch('{{ route("language.translations") }}', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                window.translations = data;
                // Recharger les notifications avec les nouvelles traductions
                if (typeof window.loadNotifications === 'function') {
                    window.loadNotifications();
                }
            })
            .catch(error => {
                console.error('Erreur lors du chargement des traductions:', error);
            });
        };
    </script>
    <script>
        // Mobile menu functionality - completely rewritten
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            const overlay = document.getElementById('mobileMenuOverlay');
            const body = document.body;

            console.log('Toggle menu called'); // Debug

            if (menu.classList.contains('-translate-x-full')) {
                // Open menu
                console.log('Opening menu'); // Debug
                menu.classList.remove('-translate-x-full');
                menu.classList.add('translate-x-0');
                overlay.classList.remove('hidden');
                body.classList.add('overflow-hidden');
            } else {
                // Close menu
                console.log('Closing menu'); // Debug
                menu.classList.add('-translate-x-full');
                menu.classList.remove('translate-x-0');
                overlay.classList.add('hidden');
                body.classList.remove('overflow-hidden');
            }
        }

        // Initialize menu state
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded'); // Debug

            // Close menu when clicking on overlay
            const overlay = document.getElementById('mobileMenuOverlay');
            if (overlay) {
                overlay.addEventListener('click', toggleMobileMenu);
            }

            // Handle menu links
            const mobileLinks = document.querySelectorAll('#mobileMenu a');
            mobileLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    console.log('Menu link clicked'); // Debug
                    // Only close menu on mobile screens
                    if (window.innerWidth < 768) {
                        setTimeout(() => toggleMobileMenu(), 100); // Small delay to allow navigation
                    }
                });
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 768) {
                    // Reset menu state for desktop
                    const menu = document.getElementById('mobileMenu');
                    const overlay = document.getElementById('mobileMenuOverlay');
                    const body = document.body;

                    menu.classList.add('-translate-x-full');
                    menu.classList.remove('translate-x-0');
                    overlay.classList.add('hidden');
                    body.classList.remove('overflow-hidden');
                }
            });
        });
    </script>
</body>
</html>
