<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('page-title', 'Dashboard Overview'); ?>
<?php $__env->startSection('page-description', 'Manage your operations'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
        <!-- Total Visitors -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Visitors</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2"><?php echo e(number_format($visitors_last_30 ?? 0)); ?></p>
                    <p class="text-xs text-gray-500 mt-1">Last 30 days</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                    <i data-feather="users" class="w-6 h-6 text-blue-600"></i>
                </div>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Orders</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2"><?php echo e(number_format($total_orders ?? 0)); ?></p>
                    <p class="text-xs text-gray-500 mt-1">All time</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                    <i data-feather="shopping-bag" class="w-6 h-6 text-green-600"></i>
                </div>
            </div>
        </div>

        <!-- Pending Orders -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Pending Orders</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2"><?php echo e(number_format($pending_orders ?? 0)); ?></p>
                    <p class="text-xs text-gray-500 mt-1">Awaiting action</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center">
                    <i data-feather="clock" class="w-6 h-6 text-purple-600"></i>
                </div>
            </div>
        </div>

        <!-- Revenue -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Revenue</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2"><?php echo e(format_money($revenue_this_month ?? 0)); ?></p>
                    <p class="text-xs text-gray-500 mt-1">This month</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center">
                    <i data-feather="dollar-sign" class="w-6 h-6 text-amber-600"></i>
                </div>
            </div>
        </div>

        <!-- Products -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Products</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2"><?php echo e(number_format($products_count ?? 0)); ?></p>
                    <p class="text-xs text-gray-500 mt-1">In catalog</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-teal-100 flex items-center justify-center">
                    <i data-feather="package" class="w-6 h-6 text-teal-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Quick Actions</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <a href="<?php echo e(route('dashboard.analytics')); ?>" class="flex items-center gap-4 p-4 rounded-lg border border-gray-200 hover:border-[#937237] hover:bg-amber-50/50 transition-all">
                <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                    <i data-feather="bar-chart-2" class="w-6 h-6 text-blue-600"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-900">View Analytics</p>
                    <p class="text-sm text-gray-500">Visitor statistics & insights</p>
                </div>
            </a>

            <a href="<?php echo e(route('dashboard.customers')); ?>" class="flex items-center gap-4 p-4 rounded-lg border border-gray-200 hover:border-[#937237] hover:bg-amber-50/50 transition-all">
                <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center">
                    <i data-feather="users" class="w-6 h-6 text-green-600"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-900">Customers</p>
                    <p class="text-sm text-gray-500">View and export customers</p>
                </div>
            </a>

            <a href="<?php echo e(route('dashboard.orders')); ?>" class="flex items-center gap-4 p-4 rounded-lg border border-gray-200 hover:border-[#937237] hover:bg-amber-50/50 transition-all">
                <div class="w-12 h-12 rounded-lg bg-indigo-100 flex items-center justify-center">
                    <i data-feather="shopping-cart" class="w-6 h-6 text-indigo-600"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-900">Orders</p>
                    <p class="text-sm text-gray-500">View and manage orders</p>
                </div>
            </a>

            <a href="<?php echo e(route('dashboard.products')); ?>" class="flex items-center gap-4 p-4 rounded-lg border border-gray-200 hover:border-[#937237] hover:bg-amber-50/50 transition-all">
                <div class="w-12 h-12 rounded-lg bg-teal-100 flex items-center justify-center">
                    <i data-feather="package" class="w-6 h-6 text-teal-600"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-900">Products</p>
                    <p class="text-sm text-gray-500">Manage products / menu</p>
                </div>
            </a>

            <a href="<?php echo e(route('dashboard.blog')); ?>" class="flex items-center gap-4 p-4 rounded-lg border border-gray-200 hover:border-[#937237] hover:bg-amber-50/50 transition-all">
                <div class="w-12 h-12 rounded-lg bg-slate-100 flex items-center justify-center">
                    <i data-feather="file-text" class="w-6 h-6 text-slate-600"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-900">Blog</p>
                    <p class="text-sm text-gray-500">Create and manage blog posts</p>
                </div>
            </a>

            <a href="<?php echo e(route('dashboard.settings')); ?>" class="flex items-center gap-4 p-4 rounded-lg border border-gray-200 hover:border-[#937237] hover:bg-amber-50/50 transition-all">
                <div class="w-12 h-12 rounded-lg bg-amber-100 flex items-center justify-center">
                    <i data-feather="settings" class="w-6 h-6 text-amber-600"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-900">Settings</p>
                    <p class="text-sm text-gray-500">App & SMTP configuration</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Active theme -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Public site theme</h3>
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Active theme</p>
                <p class="text-xl font-bold text-gray-900 mt-1"><?php echo e(config('themes.'.current_theme().'.name', current_theme())); ?></p>
                <p class="text-xs text-gray-500 mt-1">Used for the public site when you add routes.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="<?php echo e(route('theme.preview')); ?>" target="_blank" rel="noopener" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg font-medium transition-colors flex items-center gap-2 text-sm">
                    <i data-feather="eye" class="w-4 h-4"></i>
                    Preview theme
                </a>
                <a href="<?php echo e(route('dashboard.settings')); ?>" class="px-4 py-2 bg-[#937237] hover:bg-[#7a5d2e] text-white rounded-lg font-medium transition-colors flex items-center gap-2 text-sm">
                    <i data-feather="settings" class="w-4 h-4"></i>
                    Change theme
                </a>
            </div>
        </div>
    </div>

    <!-- System Info -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">System Information</h3>
        <div class="space-y-3">
            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                <span class="text-sm text-gray-600">Active theme</span>
                <span class="text-sm font-medium text-gray-900"><?php echo e(config('themes.'.current_theme().'.name', current_theme())); ?></span>
            </div>
            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                <span class="text-sm text-gray-600">Laravel Version</span>
                <span class="text-sm font-medium text-gray-900"><?php echo e(app()->version()); ?></span>
            </div>
            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                <span class="text-sm text-gray-600">PHP Version</span>
                <span class="text-sm font-medium text-gray-900"><?php echo e(PHP_VERSION); ?></span>
            </div>
            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                <span class="text-sm text-gray-600">Environment</span>
                <span class="text-sm font-medium text-gray-900"><?php echo e(config('app.env')); ?></span>
            </div>
            <div class="flex items-center justify-between py-2">
                <span class="text-sm text-gray-600">Debug Mode</span>
                <span class="text-sm font-medium <?php echo e(config('app.debug') ? 'text-red-600' : 'text-green-600'); ?>">
                    <?php echo e(config('app.debug') ? 'Enabled' : 'Disabled'); ?>

                </span>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ASUS\Desktop\laravel-backend\resources\views/dashboard.blade.php ENDPATH**/ ?>