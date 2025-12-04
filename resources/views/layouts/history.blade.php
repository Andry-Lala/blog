<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Historique des investissements') - Unicorn Madagascar</title>
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

    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/notification-system.js', 'resources/js/notification-alpine.js'])
    <script src="{{ asset('js/ultimate-auth-guard.js') }}"></script>
</head>
<body class="bg-gray-50 text-gray-900">
    <div class="flex h-screen overflow-hidden">
        <!-- Mobile menu overlay -->
        <div id="mobileMenuOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden" onclick="toggleMobileMenu()"></div>
        <!-- Sidebar -->
        <aside id="mobileMenu" class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 transform -translate-x-full transition-transform duration-300 ease-in-out md:relative md:transform-none md:flex md:flex-shrink-0 md:translate-x-0">
            <div class="flex flex-col w-64">
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
                            Tableau de bord
                        </a>
                        <a href="{{ route('informations.index') }}" class="{{ request()->routeIs('informations.*') ? 'bg-blue-100 text-blue-900' : 'text-gray-600 hover:bg-gray-100 hover:text-blue-600' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <svg class="text-gray-400 group-hover:text-gray-500 mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Mes informations
                        </a>
                        <a href="{{ route('investments.index') }}" class="{{ request()->routeIs('investments.*') ? 'bg-blue-100 text-blue-900' : 'text-gray-600 hover:bg-gray-100 hover:text-blue-600' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <svg class="text-gray-400 group-hover:text-gray-500 mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-6 6"></path>
                            </svg>
                            Investissements
                        </a>
                        <a href="{{ route('investments.history') }}" class="{{ request()->routeIs('investments.history') ? 'bg-blue-100 text-blue-900' : 'text-gray-600 hover:bg-gray-100 hover:text-blue-600' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <svg class="text-gray-400 group-hover:text-gray-500 mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6 3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Historique
                        </a>
                        <a href="{{ route('investments.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Nouvel investissement
                        </a>
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
                        <div class="flex items-center space-x-4">
                            <button class="md:hidden p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500" aria-label="Ouvrir le menu" aria-expanded="false" onclick="toggleMobileMenu()">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>
                            </button>
                            @yield('header')
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
                                <button @click="notificationOpen = !notificationOpen" class="p-2 rounded-full text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 relative" aria-label="Notifications">
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
                                                <h3 class="text-sm font-medium text-gray-900">Notifications</h3>
                                                <a href="{{ route('notifications.index') }}" class="text-xs text-blue-600 hover:text-blue-800">
                                                    Voir tout
                                                </a>
                                            </div>
                                        </div>
                                        <div class="max-h-96 overflow-y-auto" id="notificationsList">
                                            <!-- Notifications will be loaded here -->
                                            <div class="px-4 py-8 text-center text-sm text-gray-500">
                                                Chargement...
                                            </div>
                                        </div>
                                        <div class="px-4 py-2 border-t border-gray-200">
                                            <button onclick="markAllAsRead()" class="w-full text-center text-xs text-blue-600 hover:text-blue-800">
                                                Tout marquer comme lu
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="relative">
                                <button class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" aria-label="Menu utilisateur" aria-expanded="false">
                                    <span class="sr-only">User menu</span>
                                    <div class="h-8 w-8 rounded-full bg-indigo-600 flex items-center justify-center">
                                        <span class="text-white font-medium">{{ strtoupper(substr(auth()->user()->prenom ?? auth()->user()->username ?? 'U', 0, 1)) }}</span>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>
                </header>
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
