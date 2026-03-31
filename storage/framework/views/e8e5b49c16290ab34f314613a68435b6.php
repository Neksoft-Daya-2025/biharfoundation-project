<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Admin Dashboard'); ?></title>
    <link rel="icon" type="image/png" href="<?php echo e(asset('assets/logo.png')); ?>">
    <?php if(file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot'))): ?>
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css']); ?>
    <?php else: ?>
        <script src="https://cdn.tailwindcss.com"></script>
    <?php endif; ?>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <?php echo $__env->yieldPushContent('styles'); ?>
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
                <img src="<?php echo e(asset('assets/logo.png')); ?>" alt="Logo" class="h-8 w-auto">
                <div>
                    <h1 class="font-bold text-gray-900">Dashboard</h1>
                    <p class="text-xs text-gray-500">Admin Panel</p>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
                <a href="<?php echo e(route('dashboard')); ?>" class="flex items-center gap-3 px-4 py-3 rounded-lg <?php echo e(request()->routeIs('dashboard') ? 'bg-[#937237] text-white' : 'text-gray-700 hover:bg-gray-100'); ?> transition-colors">
                    <i data-feather="layout" class="w-5 h-5"></i>
                    <span class="font-medium">Dashboard</span>
                </a>
                
                <a href="<?php echo e(route('dashboard.analytics')); ?>" class="flex items-center gap-3 px-4 py-3 rounded-lg <?php echo e(request()->routeIs('dashboard.analytics') ? 'bg-[#937237] text-white' : 'text-gray-700 hover:bg-gray-100'); ?> transition-colors">
                    <i data-feather="bar-chart-2" class="w-5 h-5"></i>
                    <span class="font-medium">Analytics</span>
                </a>

                <div class="pt-4 mt-4 border-t border-gray-200">
                    <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Management</p>
                    
                    <a href="<?php echo e(route('dashboard.orders')); ?>" class="flex items-center gap-3 px-4 py-3 rounded-lg <?php echo e(request()->routeIs('dashboard.orders*') ? 'bg-[#937237] text-white' : 'text-gray-700 hover:bg-gray-100'); ?> transition-colors">
                        <i data-feather="shopping-cart" class="w-5 h-5"></i>
                        <span class="font-medium">Orders</span>
                    </a>
                    
                    <a href="<?php echo e(route('dashboard.products')); ?>" class="flex items-center gap-3 px-4 py-3 rounded-lg <?php echo e(request()->routeIs('dashboard.products*') ? 'bg-[#937237] text-white' : 'text-gray-700 hover:bg-gray-100'); ?> transition-colors">
                        <i data-feather="package" class="w-5 h-5"></i>
                        <span class="font-medium">Products</span>
                    </a>

                    <a href="<?php echo e(route('dashboard.categories')); ?>" class="flex items-center gap-3 px-4 py-3 rounded-lg <?php echo e(request()->routeIs('dashboard.categories*') ? 'bg-[#937237] text-white' : 'text-gray-700 hover:bg-gray-100'); ?> transition-colors">
                        <i data-feather="folder" class="w-5 h-5"></i>
                        <span class="font-medium">Categories</span>
                    </a>
                    
                    <a href="<?php echo e(route('dashboard.blog')); ?>" class="flex items-center gap-3 px-4 py-3 rounded-lg <?php echo e(request()->routeIs('dashboard.blog*') ? 'bg-[#937237] text-white' : 'text-gray-700 hover:bg-gray-100'); ?> transition-colors">
                        <i data-feather="file-text" class="w-5 h-5"></i>
                        <span class="font-medium">Blog</span>
                    </a>
                    
                    <a href="<?php echo e(route('dashboard.events')); ?>" class="flex items-center gap-3 px-4 py-3 rounded-lg <?php echo e(request()->routeIs('dashboard.events*') ? 'bg-[#937237] text-white' : 'text-gray-700 hover:bg-gray-100'); ?> transition-colors">
                        <i data-feather="calendar" class="w-5 h-5"></i>
                        <span class="font-medium">Events</span>
                    </a>
                    
                    <a href="<?php echo e(route('dashboard.customers')); ?>" class="flex items-center gap-3 px-4 py-3 rounded-lg <?php echo e(request()->routeIs('dashboard.customers') ? 'bg-[#937237] text-white' : 'text-gray-700 hover:bg-gray-100'); ?> transition-colors">
                        <i data-feather="users" class="w-5 h-5"></i>
                        <span class="font-medium">Customers</span>
                    </a>

                    <a href="<?php echo e(url('/theme-preview')); ?>" target="_blank" rel="noopener noreferrer" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors">
                        <i data-feather="external-link" class="w-5 h-5"></i>
                        <span class="font-medium">Visit website</span>
                    </a>
                    
                    <a href="<?php echo e(route('dashboard.notifications')); ?>" class="flex items-center gap-3 px-4 py-3 rounded-lg <?php echo e(request()->routeIs('dashboard.notifications') ? 'bg-[#937237] text-white' : 'text-gray-700 hover:bg-gray-100'); ?> transition-colors relative">
                        <i data-feather="bell" class="w-5 h-5"></i>
                        <span class="font-medium">Notifications</span>
                        <span id="sidebar-notification-badge" class="hidden absolute right-4 top-1/2 -translate-y-1/2 min-w-[1.25rem] h-5 px-1.5 flex items-center justify-center bg-amber-500 text-white text-xs font-bold rounded-full">0</span>
                    </a>
                    
                    <a href="<?php echo e(route('dashboard.settings')); ?>" class="flex items-center gap-3 px-4 py-3 rounded-lg <?php echo e(request()->routeIs('dashboard.settings') ? 'bg-[#937237] text-white' : 'text-gray-700 hover:bg-gray-100'); ?> transition-colors">
                        <i data-feather="settings" class="w-5 h-5"></i>
                        <span class="font-medium">Settings</span>
                    </a>
                </div>
            </nav>

            <!-- User Section -->
            <div class="border-t border-gray-200 p-4">
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
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
                        <h2 class="text-xl font-bold text-gray-900"><?php echo $__env->yieldContent('page-title', 'Dashboard'); ?></h2>
                        <p class="text-sm text-gray-500"><?php echo $__env->yieldContent('page-description', 'Welcome back'); ?></p>
                    </div>
                    <div class="flex items-center gap-4">
                        <a href="<?php echo e(url('/theme-preview')); ?>" target="_blank" rel="noopener noreferrer" class="flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-700 hover:text-[#937237] hover:bg-gray-100 rounded-lg transition-colors" title="Visit website">
                            <i data-feather="external-link" class="w-4 h-4"></i>
                            <span class="hidden sm:inline">Visit website</span>
                        </a>
                        <a href="<?php echo e(route('dashboard.notifications')); ?>" class="relative p-2 text-gray-600 hover:text-[#937237] hover:bg-gray-100 rounded-lg transition-colors" title="Notifications">
                            <i data-feather="bell" class="w-5 h-5"></i>
                            <span id="header-notification-badge" class="hidden absolute -top-0.5 -right-0.5 min-w-[1.25rem] h-5 px-1 flex items-center justify-center bg-amber-500 text-white text-xs font-bold rounded-full">0</span>
                        </a>
                        <?php if(session('success')): ?>
                            <div class="px-4 py-2 bg-green-50 border border-green-200 rounded-lg text-green-800 text-sm">
                                <?php echo e(session('success')); ?>

                            </div>
                        <?php endif; ?>
                        <?php if(session('error')): ?>
                            <div class="px-4 py-2 bg-red-50 border border-red-200 rounded-lg text-red-800 text-sm">
                                <?php echo e(session('error')); ?>

                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="p-6">
            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>

    <script>
        feather.replace();
        (function() {
            function updateNotificationBadge() {
                fetch('/api/notifications/unread-count', { headers: { 'Accept': 'application/json' } })
                    .then(r => r.json())
                    .then(data => {
                        if (data.success && data.unread_count > 0) {
                            var badge = document.getElementById('header-notification-badge');
                            var sidebarBadge = document.getElementById('sidebar-notification-badge');
                            if (badge) { badge.textContent = data.unread_count > 99 ? '99+' : data.unread_count; badge.classList.remove('hidden'); }
                            if (sidebarBadge) { sidebarBadge.textContent = data.unread_count > 99 ? '99+' : data.unread_count; sidebarBadge.classList.remove('hidden'); }
                        } else {
                            var badge = document.getElementById('header-notification-badge');
                            var sidebarBadge = document.getElementById('sidebar-notification-badge');
                            if (badge) badge.classList.add('hidden');
                            if (sidebarBadge) sidebarBadge.classList.add('hidden');
                        }
                    })
                    .catch(function() {});
            }
            updateNotificationBadge();
            setInterval(updateNotificationBadge, 60000);
        })();
    </script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\MUGDHA\Downloads\New folder\backend-project-main\backend-project-main\resources\views/layouts/dashboard.blade.php ENDPATH**/ ?>