

<?php $__env->startSection('title', 'Product Categories'); ?>
<?php $__env->startSection('page-title', 'Product Categories'); ?>
<?php $__env->startSection('page-description', 'Manage menu categories for products'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Product Categories</h2>
            <p class="text-sm text-gray-600 mt-1">Categories group products on the menu (e.g. Fish Dishes, Drinks).</p>
        </div>
        <a href="<?php echo e(route('dashboard.categories.create')); ?>" class="px-4 py-2 bg-[#937237] hover:bg-[#7a5d2e] text-white rounded-lg font-medium transition-colors flex items-center gap-2">
            <i data-feather="plus" class="w-4 h-4"></i>
            Add Category
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Slug</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Products</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Order</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Active</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900"><?php echo e($category->name); ?></td>
                        <td class="px-6 py-4 text-sm text-gray-600"><?php echo e($category->slug); ?></td>
                        <td class="px-6 py-4 text-sm text-gray-600"><?php echo e($category->products_count ?? $category->products()->count()); ?></td>
                        <td class="px-6 py-4 text-sm text-gray-600"><?php echo e($category->sort_order); ?></td>
                        <td class="px-6 py-4 text-sm"><?php echo e($category->is_active ? 'Yes' : 'No'); ?></td>
                        <td class="px-6 py-4 text-right text-sm space-x-2">
                            <a href="<?php echo e(route('dashboard.categories.edit', $category)); ?>" class="text-[#937237] hover:underline">Edit</a>
                            <form action="<?php echo e(route('dashboard.categories.destroy', $category)); ?>" method="POST" class="inline" onsubmit="return confirm('Delete this category? Products in it will need another category.');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">No categories yet. <a href="<?php echo e(route('dashboard.categories.create')); ?>" class="text-[#937237] hover:underline">Add one</a></td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ASUS\Desktop\laravel-backend\resources\views/dashboard/categories/index.blade.php ENDPATH**/ ?>