

<?php $__env->startSection('title', 'Blog'); ?>
<?php $__env->startSection('page-title', 'Blog'); ?>
<?php $__env->startSection('page-description', 'Manage blog posts'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Blog posts</h2>
            <p class="text-sm text-gray-600 mt-1">Create, edit, and publish posts.</p>
        </div>
        <a href="<?php echo e(route('dashboard.blog.create')); ?>" class="px-4 py-2 bg-[#937237] hover:bg-[#7a5d2e] text-white rounded-lg font-medium transition-colors flex items-center gap-2">
            <i data-feather="plus" class="w-4 h-4"></i>
            New post
        </a>
    </div>

    <form method="GET" action="<?php echo e(route('dashboard.blog')); ?>" class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 flex flex-wrap items-center gap-4">
        <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search posts..."
            class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none w-64">
        <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#937237] outline-none">
            <option value="">All statuses</option>
            <option value="draft" <?php echo e(request('status') === 'draft' ? 'selected' : ''); ?>>Draft</option>
            <option value="published" <?php echo e(request('status') === 'published' ? 'selected' : ''); ?>>Published</option>
        </select>
        <button type="submit" class="px-4 py-2 bg-[#937237] hover:bg-[#7a5d2e] text-white rounded-lg font-medium transition-colors flex items-center gap-2">
            <i data-feather="search" class="w-4 h-4"></i> Filter
        </button>
    </form>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase w-16">Image</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Slug</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Published</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Updated</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <?php if($post->featured_image_url): ?>
                            <img src="<?php echo e($post->featured_image_url); ?>" alt="" class="w-12 h-12 object-cover rounded border border-gray-200">
                            <?php else: ?>
                            <span class="text-gray-400 text-xs">—</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-medium text-gray-900"><?php echo e($post->title); ?></span>
                            <?php if($post->excerpt): ?>
                            <p class="text-xs text-gray-500 mt-0.5"><?php echo e(Str::limit($post->excerpt, 60)); ?></p>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600"><?php echo e($post->slug); ?></td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-full text-xs font-medium <?php echo e($post->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'); ?>"><?php echo e($post->status); ?></span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600"><?php echo e($post->published_at ? $post->published_at->format('M d, Y') : '-'); ?></td>
                        <td class="px-6 py-4 text-sm text-gray-500"><?php echo e($post->updated_at->format('M d, Y')); ?></td>
                        <td class="px-6 py-4 text-right text-sm space-x-2">
                            <a href="<?php echo e(route('dashboard.blog.edit', $post)); ?>" class="text-[#937237] hover:underline">Edit</a>
                            <form action="<?php echo e(route('dashboard.blog.destroy', $post)); ?>" method="POST" class="inline" onsubmit="return confirm('Delete this post?');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">No posts yet. <a href="<?php echo e(route('dashboard.blog.create')); ?>" class="text-[#937237] hover:underline">Create one</a></td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if($posts->hasPages()): ?>
        <div class="px-6 py-4 border-t border-gray-200">
            <?php echo e($posts->withQueryString()->links()); ?>

        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ASUS\Desktop\laravel-backend\resources\views/dashboard/blog/index.blade.php ENDPATH**/ ?>