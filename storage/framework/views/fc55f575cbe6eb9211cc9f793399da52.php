

<?php $__env->startSection('title', $post ? 'Edit post' : 'New post'); ?>
<?php $__env->startSection('page-title', $post ? 'Edit post' : 'New post'); ?>
<?php $__env->startSection('page-description', $post ? 'Update blog post' : 'Create a new blog post'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl">
    <div class="mb-6">
        <a href="<?php echo e(route('dashboard.blog')); ?>" class="text-[#937237] hover:underline flex items-center gap-2">
            <i data-feather="arrow-left" class="w-4 h-4"></i> Back to Blog
        </a>
    </div>

    <form action="<?php echo e($post ? route('dashboard.blog.update', $post) : route('dashboard.blog.store')); ?>" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
        <?php echo csrf_field(); ?>
        <?php if($post): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

        <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title *</label>
            <input type="text" id="title" name="title" value="<?php echo e(old('title', $post->title ?? '')); ?>" required
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
            <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
            <input type="text" id="slug" name="slug" value="<?php echo e(old('slug', $post->slug ?? '')); ?>" placeholder="Auto-generated from title if empty"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
            <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
            <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-1">Excerpt</label>
            <textarea id="excerpt" name="excerpt" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none <?php $__errorArgs = ['excerpt'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('excerpt', $post->excerpt ?? '')); ?></textarea>
            <?php $__errorArgs = ['excerpt'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
            <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Content *</label>
            <textarea id="content" name="content" rows="12" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none font-mono text-sm <?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('content', $post->content ?? '')); ?></textarea>
            <?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Featured image</label>
            <p class="text-xs text-gray-500 mb-2">Upload an image or enter a URL. JPEG, PNG, GIF, WebP; max 2 MB.</p>
            <div class="flex flex-wrap gap-4 items-start">
                <div class="space-y-2">
                    <input type="file" id="featured_image_file" name="featured_image_file" accept="image/jpeg,image/png,image/gif,image/webp"
                        class="block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-[#937237] file:text-white file:font-medium hover:file:bg-[#7a5d2e]">
                    <span class="text-xs text-gray-500">or use URL:</span>
                    <input type="text" id="featured_image" name="featured_image" value="<?php echo e(old('featured_image', ($post && $post->featured_image && str_starts_with($post->featured_image, 'http')) ? $post->featured_image : '')); ?>" placeholder="https://..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none text-sm">
                </div>
                <?php $imgUrl = $post ? $post->featured_image_url : null; ?>
                <?php if($imgUrl): ?>
                <div class="flex-shrink-0">
                    <img id="featured_image_preview" src="<?php echo e($imgUrl); ?>" alt="Featured" class="w-32 h-32 object-cover rounded-lg border border-gray-200">
                </div>
                <?php else: ?>
                <div class="flex-shrink-0 w-32 h-32 rounded-lg border border-dashed border-gray-300 flex items-center justify-center text-gray-400 text-xs" id="featured_image_placeholder">No image</div>
                <?php endif; ?>
            </div>
            <?php $__errorArgs = ['featured_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            <?php $__errorArgs = ['featured_image_file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select id="status" name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none">
                <option value="draft" <?php echo e(old('status', $post->status ?? 'draft') === 'draft' ? 'selected' : ''); ?>>Draft</option>
                <option value="published" <?php echo e(old('status', $post->status ?? '') === 'published' ? 'selected' : ''); ?>>Published</option>
            </select>
        </div>

        <div class="border-t border-gray-200 pt-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">SEO / Meta (optional)</h3>
            <div class="space-y-4">
                <div>
                    <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-1">Meta title</label>
                    <input type="text" id="meta_title" name="meta_title" value="<?php echo e(old('meta_title', $post->meta_title ?? '')); ?>" maxlength="255" placeholder="Used in &lt;title&gt; and social"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none">
                </div>
                <div>
                    <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-1">Meta description</label>
                    <textarea id="meta_description" name="meta_description" rows="2" maxlength="500" placeholder="Short description for search and social"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none"><?php echo e(old('meta_description', $post->meta_description ?? '')); ?></textarea>
                </div>
                <div>
                    <label for="meta_keywords" class="block text-sm font-medium text-gray-700 mb-1">Meta keywords</label>
                    <input type="text" id="meta_keywords" name="meta_keywords" value="<?php echo e(old('meta_keywords', $post->meta_keywords ?? '')); ?>" maxlength="255" placeholder="Comma-separated keywords"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none">
                </div>
            </div>
        </div>

        <div class="flex gap-3 pt-4">
            <button type="submit" class="px-6 py-2 bg-[#937237] hover:bg-[#7a5d2e] text-white rounded-lg font-medium transition-colors">
                <?php echo e($post ? 'Update' : 'Create'); ?> post
            </button>
            <a href="<?php echo e(route('dashboard.blog')); ?>" class="px-6 py-2 border border-gray-300 rounded-lg font-medium text-gray-700 hover:bg-gray-50 transition-colors">Cancel</a>
        </div>
    </form>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.getElementById('featured_image_file')?.addEventListener('change', function(e) {
    var file = e.target.files[0];
    var preview = document.getElementById('featured_image_preview');
    var placeholder = document.getElementById('featured_image_placeholder');
    if (!file || !file.type.startsWith('image/')) return;
    var reader = new FileReader();
    reader.onload = function() {
        if (preview) { preview.src = reader.result; preview.classList.remove('hidden'); }
        if (placeholder) {
            if (!preview) {
                var img = document.createElement('img');
                img.id = 'featured_image_preview';
                img.className = 'w-32 h-32 object-cover rounded-lg border border-gray-200';
                img.src = reader.result;
                img.alt = 'Preview';
                placeholder.parentNode.replaceChild(img, placeholder);
            } else { placeholder.classList.add('hidden'); }
        }
    };
    reader.readAsDataURL(file);
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ASUS\Desktop\laravel-backend\resources\views/dashboard/blog/form.blade.php ENDPATH**/ ?>