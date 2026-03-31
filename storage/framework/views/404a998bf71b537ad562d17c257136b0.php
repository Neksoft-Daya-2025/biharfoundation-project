<?php $__env->startSection('title', 'Products'); ?>
<?php $__env->startSection('page-title', 'Products'); ?>
<?php $__env->startSection('page-description', 'Manage menu / products'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Products</h2>
            <p class="text-sm text-gray-600 mt-1">Add, edit, or remove products. Select multiple for bulk actions.</p>
        </div>
        <a href="<?php echo e(route('dashboard.products.create')); ?>" class="px-4 py-2 bg-[#937237] hover:bg-[#7a5d2e] text-white rounded-lg font-medium transition-colors flex items-center gap-2">
            <i data-feather="plus" class="w-4 h-4"></i>
            Add Product
        </a>
    </div>

    <!-- Bulk action bar (shown when selection exists) -->
    <div id="bulk-bar" class="hidden bg-[#937237] text-white rounded-xl shadow-sm border border-[#7a5d2e] p-4 flex items-center justify-between">
        <span class="font-medium" id="bulk-count">0 selected</span>
        <div class="flex items-center gap-3">
            <button type="button" onclick="bulkView()" class="px-4 py-2 bg-white/20 hover:bg-white/30 rounded-lg font-medium transition-colors flex items-center gap-2">
                <i data-feather="eye" class="w-4 h-4"></i> View
            </button>
            <button type="button" onclick="bulkEdit()" class="px-4 py-2 bg-white/20 hover:bg-white/30 rounded-lg font-medium transition-colors flex items-center gap-2">
                <i data-feather="edit-2" class="w-4 h-4"></i> Edit
            </button>
            <button type="button" onclick="bulkDelete()" class="px-4 py-2 bg-red-500/80 hover:bg-red-500 rounded-lg font-medium transition-colors flex items-center gap-2">
                <i data-feather="trash-2" class="w-4 h-4"></i> Delete
            </button>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left w-12">
                            <input type="checkbox" id="select-all" aria-label="Select all" class="rounded border-gray-300 text-[#937237] focus:ring-[#937237]">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Popular</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Available</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Order</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50" data-product-id="<?php echo e($product->id); ?>">
                        <td class="px-4 py-4 w-12">
                            <input type="checkbox" class="product-checkbox rounded border-gray-300 text-[#937237] focus:ring-[#937237]" value="<?php echo e($product->id); ?>" aria-label="Select <?php echo e($product->name); ?>">
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-medium text-gray-900"><?php echo e($product->name); ?></span>
                            <?php if($product->description): ?>
                            <p class="text-xs text-gray-500 mt-0.5"><?php echo e(Str::limit($product->description, 50)); ?></p>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600"><?php echo e($product->productCategory?->name ?? '—'); ?></td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900"><?php echo e(format_money($product->price)); ?></td>
                        <td class="px-6 py-4 text-sm"><?php echo e($product->is_popular ? 'Yes' : 'No'); ?></td>
                        <td class="px-6 py-4 text-sm"><?php echo e($product->is_available ? 'Yes' : 'No'); ?></td>
                        <td class="px-6 py-4 text-sm text-gray-600"><?php echo e($product->sort_order); ?></td>
                        <td class="px-6 py-4 text-right text-sm space-x-2">
                            <a href="<?php echo e(route('dashboard.products.show', $product)); ?>" class="text-gray-600 hover:text-[#937237] hover:underline">View</a>
                            <a href="<?php echo e(route('dashboard.products.edit', $product)); ?>" class="text-[#937237] hover:underline">Edit</a>
                            <form action="<?php echo e(route('dashboard.products.destroy', $product)); ?>" method="POST" class="inline" onsubmit="return confirm('Delete this product?');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-gray-500">No products yet. <a href="<?php echo e(route('dashboard.products.create')); ?>" class="text-[#937237] hover:underline">Add one</a></td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<form id="bulk-delete-form" method="POST" action="<?php echo e(route('dashboard.products.bulk-destroy')); ?>" class="hidden">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="ids" id="bulk-delete-ids" value="">
</form>

<?php $__env->startPush('scripts'); ?>
<script>
(function() {
    const selectAll = document.getElementById('select-all');
    const checkboxes = document.querySelectorAll('.product-checkbox');
    const bulkBar = document.getElementById('bulk-bar');
    const bulkCount = document.getElementById('bulk-count');

    function updateBulkBar() {
        const checked = document.querySelectorAll('.product-checkbox:checked');
        const n = checked.length;
        if (n === 0) {
            bulkBar.classList.add('hidden');
        } else {
            bulkBar.classList.remove('hidden');
            bulkCount.textContent = n === 1 ? '1 selected' : n + ' selected';
        }
    }

    function getSelectedIds() {
        return Array.from(document.querySelectorAll('.product-checkbox:checked')).map(cb => cb.value);
    }

    if (selectAll) {
        selectAll.addEventListener('change', function() {
            checkboxes.forEach(cb => { cb.checked = this.checked; });
            updateBulkBar();
        });
    }
    checkboxes.forEach(cb => cb.addEventListener('change', updateBulkBar));

    window.bulkView = function() {
        const ids = getSelectedIds();
        if (ids.length === 0) return;
        window.location.href = '<?php echo e(url("dashboard/products")); ?>/' + ids[0];
    };
    window.bulkEdit = function() {
        const ids = getSelectedIds();
        if (ids.length === 0) return;
        window.location.href = '<?php echo e(url("dashboard/products")); ?>/' + ids[0] + '/edit';
    };
    window.bulkDelete = function() {
        const ids = getSelectedIds();
        if (ids.length === 0) return;
        const msg = ids.length === 1 ? 'Delete this product?' : 'Delete ' + ids.length + ' selected products?';
        if (!confirm(msg)) return;
        document.getElementById('bulk-delete-ids').value = ids.join(',');
        document.getElementById('bulk-delete-form').submit();
    };
})();
if (typeof feather !== 'undefined') feather.replace();
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MUGDHA\Downloads\New folder\backend-project-main\backend-project-main\resources\views/dashboard/products.blade.php ENDPATH**/ ?>