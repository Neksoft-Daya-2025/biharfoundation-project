<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard')</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/logo.png') }}">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('styles')
    <style>
        :root {
            --primary: #937237;
            --primary-dark: #7a5d2e;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Sidebar -->
    <aside class="fixed inset-y-0 left-0 w-64 bg-white border-r border-gray-200 z-50">
        <div class="flex flex-col h-full">
            <!-- Logo -->
            <div class="flex items-center gap-3 px-6 py-5 border-b border-gray-200">
                <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="h-8 w-auto">
                <div>
                    <h1 class="font-bold text-gray-900">Dashboard</h1>
                    <p class="text-xs text-gray-500">Admin Panel</p>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-[#937237] text-white' : 'text-gray-700 hover:bg-gray-100' }} transition-colors">
                    <i data-feather="layout" class="w-5 h-5"></i>
                    <span class="font-medium">Dashboard</span>
                </a>
                
                <a href="{{ route('dashboard.analytics') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('dashboard.analytics') ? 'bg-[#937237] text-white' : 'text-gray-700 hover:bg-gray-100' }} transition-colors">
                    <i data-feather="bar-chart-2" class="w-5 h-5"></i>
                    <span class="font-medium">Analytics</span>
                </a>

                <div class="pt-4 mt-4 border-t border-gray-200">
                    <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Management</p>
                    
                    <a href="{{ route('dashboard.orders') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('dashboard.orders*') ? 'bg-[#937237] text-white' : 'text-gray-700 hover:bg-gray-100' }} transition-colors">
                        <i data-feather="shopping-cart" class="w-5 h-5"></i>
                        <span class="font-medium">Orders</span>
                    </a>
                    
                    <a href="{{ route('dashboard.products') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('dashboard.products*') ? 'bg-[#937237] text-white' : 'text-gray-700 hover:bg-gray-100' }} transition-colors">
                        <i data-feather="package" class="w-5 h-5"></i>
                        <span class="font-medium">Products</span>
                    </a>

                    <a href="{{ route('dashboard.categories') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('dashboard.categories*') ? 'bg-[#937237] text-white' : 'text-gray-700 hover:bg-gray-100' }} transition-colors">
                        <i data-feather="folder" class="w-5 h-5"></i>
                        <span class="font-medium">Categories</span>
                    </a>
                    
                    <a href="{{ route('dashboard.blog') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('dashboard.blog*') ? 'bg-[#937237] text-white' : 'text-gray-700 hover:bg-gray-100' }} transition-colors">
                        <i data-feather="file-text" class="w-5 h-5"></i>
                        <span class="font-medium">Blog</span>
                    </a>
                    
                    <a href="{{ route('dashboard.events') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('dashboard.events*') ? 'bg-[#937237] text-white' : 'text-gray-700 hover:bg-gray-100' }} transition-colors">
                        <i data-feather="calendar" class="w-5 h-5"></i>
                        <span class="font-medium">Events</span>
                    </a>
                    
                    <a href="{{ route('dashboard.customers') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('dashboard.customers') ? 'bg-[#937237] text-white' : 'text-gray-700 hover:bg-gray-100' }} transition-colors">
                        <i data-feather="users" class="w-5 h-5"></i>
                        <span class="font-medium">Customers</span>
                    </a>

                    <a href="{{ url('/theme-preview') }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors">
                        <i data-feather="external-link" class="w-5 h-5"></i>
                        <span class="font-medium">Visit website</span>
                    </a>
                    
                    <a href="{{ route('dashboard.notifications') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('dashboard.notifications') ? 'bg-[#937237] text-white' : 'text-gray-700 hover:bg-gray-100' }} transition-colors relative">
                        <i data-feather="bell" class="w-5 h-5"></i>
                        <span class="font-medium">Notifications</span>
                        <span id="sidebar-notification-badge" class="hidden absolute right-4 top-1/2 -translate-y-1/2 min-w-[1.25rem] h-5 px-1.5 flex items-center justify-center bg-amber-500 text-white text-xs font-bold rounded-full">0</span>
                    </a>
                    
                    <a href="{{ route('dashboard.settings') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('dashboard.settings') ? 'bg-[#937237] text-white' : 'text-gray-700 hover:bg-gray-100' }} transition-colors">
                        <i data-feather="settings" class="w-5 h-5"></i>
                        <span class="font-medium">Settings</span>
                    </a>
                </div>
            </nav>

            <!-- User Section -->
            <div class="border-t border-gray-200 p-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors">
                        <i data-feather="log-out" class="w-5 h-5"></i>
                        <span class="font-medium">Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="ml-64">
        <!-- Top Bar -->
        <header class="bg-white border-b border-gray-200 sticky top-0 z-40">
            <div class="px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">@yield('page-title', 'Dashboard')</h2>
                        <p class="text-sm text-gray-500">@yield('page-description', 'Welcome back')</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <a href="{{ url('/theme-preview') }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-700 hover:text-[#937237] hover:bg-gray-100 rounded-lg transition-colors" title="Visit website">
                            <i data-feather="external-link" class="w-4 h-4"></i>
                            <span class="hidden sm:inline">Visit website</span>
                        </a>
                        <div class="relative" id="notification-bell-root">
                            <button
                                type="button"
                                id="notification-bell-btn"
                                class="relative p-2 text-gray-600 hover:text-[#937237] hover:bg-gray-100 rounded-lg transition-colors"
                                title="Notifications"
                                aria-label="Notifications"
                                aria-expanded="false"
                                aria-haspopup="true"
                            >
                                <i data-feather="bell" class="w-5 h-5"></i>
                                <span id="header-notification-badge" class="hidden absolute -top-0.5 -right-0.5 min-w-[1.25rem] h-5 px-1 flex items-center justify-center bg-amber-500 text-white text-xs font-bold rounded-full">0</span>
                            </button>
                            <div
                                id="notification-bell-panel"
                                class="hidden absolute right-0 mt-2 w-[min(24rem,calc(100vw-2rem))] bg-white rounded-xl shadow-xl border border-gray-200 z-50 overflow-hidden"
                                role="menu"
                            >
                                <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                                    <p class="text-sm font-semibold text-gray-900">Notifications</p>
                                    <span id="notification-bell-unread-label" class="text-xs text-amber-600 font-medium hidden"></span>
                                </div>
                                <div id="notification-bell-list" class="max-h-80 overflow-y-auto">
                                    <p class="px-4 py-6 text-sm text-gray-500 text-center">Loading...</p>
                                </div>
                                <div class="px-4 py-3 border-t border-gray-100 bg-gray-50">
                                    <a href="{{ route('dashboard.notifications') }}" class="block text-center text-sm font-medium text-[#937237] hover:underline">
                                        View all notifications
                                    </a>
                                </div>
                            </div>
                        </div>
                        @if(session('success'))
                            <div class="px-4 py-2 bg-green-50 border border-green-200 rounded-lg text-green-800 text-sm">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="px-4 py-2 bg-red-50 border border-red-200 rounded-lg text-red-800 text-sm">
                                {{ session('error') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="p-6">
            @yield('content')
        </main>
    </div>

    <script>
        feather.replace();
        (function() {
            window.getCsrfToken = function() {
                var meta = document.querySelector('meta[name="csrf-token"]');
                return meta ? meta.content : '';
            };

            window.syncNotificationBadges = function(unreadCount) {
                document.dispatchEvent(new CustomEvent('notifications:updated', {
                    detail: { unread_count: unreadCount }
                }));
            };

            window.markNotificationRead = function(id) {
                return fetch('/api/notifications/' + id + '/read', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': window.getCsrfToken(),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    if (data.success && typeof data.unread_count !== 'undefined') {
                        window.syncNotificationBadges(data.unread_count);
                    }
                    return data;
                });
            };

            window.openNotification = function(id, link) {
                var detailUrl = '{{ url('/dashboard/notifications') }}/' + id;
                window.markNotificationRead(id).then(function(data) {
                    if (data.success) {
                        window.location.href = link || detailUrl;
                    }
                });
            };

            window.setNotificationBadgeCount = function(count) {
                var badge = document.getElementById('header-notification-badge');
                var sidebarBadge = document.getElementById('sidebar-notification-badge');
                count = Number(count) || 0;

                if (count > 0) {
                    var label = count > 99 ? '99+' : String(count);
                    if (badge) { badge.textContent = label; badge.classList.remove('hidden'); }
                    if (sidebarBadge) { sidebarBadge.textContent = label; sidebarBadge.classList.remove('hidden'); }
                } else {
                    if (badge) badge.classList.add('hidden');
                    if (sidebarBadge) sidebarBadge.classList.add('hidden');
                }
            };

            window.updateNotificationBadge = function() {
                fetch('/api/notifications/unread-count', { headers: { 'Accept': 'application/json' } })
                    .then(function(r) { return r.json(); })
                    .then(function(data) {
                        if (data.success) {
                            window.setNotificationBadgeCount(data.unread_count);
                        }
                    })
                    .catch(function() {});
            };

            document.addEventListener('notifications:updated', function(event) {
                if (event.detail && typeof event.detail.unread_count !== 'undefined') {
                    window.setNotificationBadgeCount(event.detail.unread_count);
                } else {
                    window.updateNotificationBadge();
                }
            });

            window.updateNotificationBadge();
            setInterval(window.updateNotificationBadge, 60000);

            (function initNotificationBell() {
                var root = document.getElementById('notification-bell-root');
                var btn = document.getElementById('notification-bell-btn');
                var panel = document.getElementById('notification-bell-panel');
                var list = document.getElementById('notification-bell-list');
                var unreadLabel = document.getElementById('notification-bell-unread-label');
                if (!root || !btn || !panel || !list) return;

                function escapeHtml(value) {
                    return String(value)
                        .replace(/&/g, '&amp;')
                        .replace(/</g, '&lt;')
                        .replace(/>/g, '&gt;')
                        .replace(/"/g, '&quot;');
                }

                function closePanel() {
                    panel.classList.add('hidden');
                    btn.setAttribute('aria-expanded', 'false');
                }

                function openPanel() {
                    panel.classList.remove('hidden');
                    btn.setAttribute('aria-expanded', 'true');
                    loadBellNotifications();
                }

                function loadBellNotifications() {
                    list.innerHTML = '<p class="px-4 py-6 text-sm text-gray-500 text-center">Loading...</p>';

                    fetch('/api/notifications?filter=unread&per_page=8', {
                        headers: { 'Accept': 'application/json' }
                    })
                    .then(function(r) { return r.json(); })
                    .then(function(data) {
                        if (!data.success) return;

                        if (unreadLabel) {
                            if ((data.unread_count || 0) > 0) {
                                unreadLabel.textContent = data.unread_count + ' unread';
                                unreadLabel.classList.remove('hidden');
                            } else {
                                unreadLabel.classList.add('hidden');
                            }
                        }

                        if (!data.notifications || data.notifications.length === 0) {
                            list.innerHTML = '<p class="px-4 py-8 text-sm text-gray-500 text-center">No unread notifications</p>';
                            return;
                        }

                        list.innerHTML = data.notifications.map(function(n) {
                            var link = (n.data && n.data.link) ? n.data.link : '';
                            return `
                                <button
                                    type="button"
                                    class="w-full text-left px-4 py-3 hover:bg-gray-50 border-b border-gray-100 last:border-b-0 transition-colors"
                                    data-notification-id="${n.id}"
                                    data-notification-link="${escapeHtml(link)}"
                                >
                                    <p class="text-sm font-semibold text-gray-900 line-clamp-1">${escapeHtml(n.title)}</p>
                                    ${n.message ? `<p class="text-xs text-gray-600 mt-1 line-clamp-2">${escapeHtml(n.message)}</p>` : ''}
                                    <p class="text-xs text-gray-400 mt-1">${escapeHtml(n.created_at_human)}</p>
                                </button>
                            `;
                        }).join('');
                    })
                    .catch(function() {
                        list.innerHTML = '<p class="px-4 py-6 text-sm text-red-500 text-center">Could not load notifications</p>';
                    });
                }

                btn.addEventListener('click', function(event) {
                    event.stopPropagation();
                    if (panel.classList.contains('hidden')) {
                        openPanel();
                    } else {
                        closePanel();
                    }
                });

                list.addEventListener('click', function(event) {
                    var item = event.target.closest('[data-notification-id]');
                    if (!item) return;
                    var id = item.getAttribute('data-notification-id');
                    var link = item.getAttribute('data-notification-link') || '';
                    window.openNotification(id, link || null);
                });

                document.addEventListener('click', function(event) {
                    if (!root.contains(event.target)) {
                        closePanel();
                    }
                });

                document.addEventListener('notifications:updated', function() {
                    if (!panel.classList.contains('hidden')) {
                        loadBellNotifications();
                    }
                });
            })();
        })();
    </script>
    @stack('scripts')
</body>
</html>
