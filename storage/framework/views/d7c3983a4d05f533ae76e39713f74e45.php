<?php $__env->startSection('title', $event ? 'Edit Event' : 'Add Event'); ?>
<?php $__env->startSection('page-title', $event ? 'Edit Event' : 'Add Event'); ?>
<?php $__env->startSection('page-description', $event ? 'Update event details' : 'Create a new event'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl">
    <div class="mb-6">
        <a href="<?php echo e(route('dashboard.events')); ?>" class="text-[#937237] hover:underline flex items-center gap-2">
            <i data-feather="arrow-left" class="w-4 h-4"></i> Back to Events
        </a>
    </div>

    <form action="<?php echo e($event ? route('dashboard.events.update', $event) : route('dashboard.events.store')); ?>" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
        <?php echo csrf_field(); ?>
        <?php if($event): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

        <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title *</label>
            <input type="text" id="title" name="title" value="<?php echo e(old('title', $event->title ?? '')); ?>" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
            <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea id="description" name="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('description', $event->description ?? '')); ?></textarea>
            <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="start_at" class="block text-sm font-medium text-gray-700 mb-1">Start date & time *</label>
                <input type="datetime-local" id="start_at" name="start_at" value="<?php echo e(old('start_at', $event ? $event->start_at?->format('Y-m-d\TH:i') : '')); ?>" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none <?php $__errorArgs = ['start_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                <?php $__errorArgs = ['start_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div>
                <label for="end_at" class="block text-sm font-medium text-gray-700 mb-1">End date & time</label>
                <input type="datetime-local" id="end_at" name="end_at" value="<?php echo e(old('end_at', $event && $event->end_at ? $event->end_at->format('Y-m-d\TH:i') : '')); ?>"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none">
                <?php $__errorArgs = ['end_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>

        <div>
            <label for="venue" class="block text-sm font-medium text-gray-700 mb-1">Venue</label>
            <input type="text" id="venue" name="venue" value="<?php echo e(old('venue', $event->venue ?? '')); ?>" placeholder="e.g. Main Hall"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none">
        </div>

        <div>
            <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
            <textarea id="address" name="address" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none"><?php echo e(old('address', $event->address ?? '')); ?></textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="price_per_ticket" class="block text-sm font-medium text-gray-700 mb-1">Price per ticket (<?php echo e(currency_symbol()); ?>)</label>
                <input type="number" id="price_per_ticket" name="price_per_ticket" step="0.01" min="0" value="<?php echo e(old('price_per_ticket', $event->price_per_ticket ?? 0)); ?>"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none">
                <p class="text-xs text-gray-500 mt-1">0 = Free event</p>
            </div>
            <div>
                <label for="max_attendees" class="block text-sm font-medium text-gray-700 mb-1">Max attendees</label>
                <input type="number" id="max_attendees" name="max_attendees" min="0" value="<?php echo e(old('max_attendees', $event->max_attendees ?? '')); ?>" placeholder="Leave empty for unlimited"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Event image</label>
            <?php if($event && $event->image): ?>
            <div class="mb-3">
                <img src="<?php echo e($event->image_url); ?>" alt="<?php echo e($event->title); ?>" class="h-40 w-auto rounded-lg border border-gray-200 object-cover">
                <p class="text-xs text-gray-500 mt-1">Current image. Upload a new file or paste a URL below to replace.</p>
            </div>
            <?php endif; ?>
            <div class="space-y-2">
                <div>
                    <label for="image_upload" class="block text-xs font-medium text-gray-600 mb-1">Upload image</label>
                    <input type="file" id="image_upload" name="image_upload" accept="image/jpeg,image/png,image/gif,image/webp"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-[#937237] file:text-white file:cursor-pointer hover:file:bg-[#7a5d2e]">
                    <p class="text-xs text-gray-500 mt-1">JPEG, PNG, GIF or WebP. Max 5 MB.</p>
                    <?php $__errorArgs = ['image_upload'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div>
                    <label for="image" class="block text-xs font-medium text-gray-600 mb-1">Or use image URL</label>
                    <input type="text" id="image" name="image" value="<?php echo e(old('image', $event && $event->image && (str_starts_with($event->image, 'http://') || str_starts_with($event->image, 'https://')) ? $event->image : '')); ?>" placeholder="https://..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none text-sm">
                    <p class="text-xs text-gray-500 mt-1">Leave empty to keep current image. Upload takes priority over URL if both are set.</p>
                </div>
            </div>
        </div>

        <div>
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select id="status" name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none">
                <option value="draft" <?php echo e(old('status', $event->status ?? 'draft') === 'draft' ? 'selected' : ''); ?>>Draft</option>
                <option value="published" <?php echo e(old('status', $event->status ?? '') === 'published' ? 'selected' : ''); ?>>Published</option>
                <option value="cancelled" <?php echo e(old('status', $event->status ?? '') === 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
            </select>
            <p class="text-xs text-gray-500 mt-1">Published events appear on the public events page</p>
        </div>

        <div>
            <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1">Sort order</label>
            <input type="number" id="sort_order" name="sort_order" min="0" value="<?php echo e(old('sort_order', $event->sort_order ?? 0)); ?>"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none">
        </div>

        <div class="flex gap-3 pt-4">
            <button type="submit" class="px-6 py-2 bg-[#937237] hover:bg-[#7a5d2e] text-white rounded-lg font-medium transition-colors">
                <?php echo e($event ? 'Update Event' : 'Create Event'); ?>

            </button>
            <?php if($event): ?>
            <a href="<?php echo e(route('dashboard.events.show', $event)); ?>" class="px-6 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors">Cancel</a>
            <?php endif; ?>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>feather.replace();</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ASUS\Desktop\laravel-backend\resources\views/dashboard/events/form.blade.php ENDPATH**/ ?>