<?php $__env->startSection('title', 'Bihar Foundation Netherlands'); ?>

<?php $__env->startPush('head'); ?>
<meta name="description" content="Stichting Bihar Foundation Netherlands Chapter — community, culture, events, and initiatives connecting the Bihar diaspora in the Netherlands." />
<meta name="author" content="Bihar Foundation Netherlands" />
<meta property="og:title" content="Bihar Foundation Netherlands | Stichting Bihar Foundation Netherlands Chapter" />
<meta property="og:description" content="Stichting Bihar Foundation Netherlands Chapter — community, culture, events, and initiatives connecting the Bihar diaspora in the Netherlands." />
<meta property="og:type" content="website" />
<meta name="twitter:card" content="summary_large_image" />
<?php if(file_exists(public_path('themes/lovable/assets/hero-video.mp4'))): ?>
<link rel="preload" as="video" href="<?php echo e(asset('themes/lovable/assets/hero-video.mp4')); ?>" type="video/mp4" />
<?php endif; ?>
<?php $__env->stopPush(); ?>

<?php
$assetDir = public_path('themes/lovable/assets');
$css = is_dir($assetDir) ? glob($assetDir . '/index-*.css') : [];
$js = is_dir($assetDir) ? glob($assetDir . '/index-*.js') : [];
$routerBasename = str_starts_with(request()->path(), 'theme-preview') ? '/theme-preview' : '/home';
?>

<?php $__env->startPush('styles'); ?>
<?php $__currentLoopData = $css; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<link rel="stylesheet" crossorigin href="<?php echo e(asset('themes/lovable/assets/' . basename($file))); ?>">
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div id="root" data-router-basename="<?php echo e($routerBasename); ?>"></div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<?php $__currentLoopData = $js; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<script type="module" crossorigin src="<?php echo e(asset('themes/lovable/assets/' . basename($file))); ?>"></script>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('themes.lovable.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MUGDHA\Downloads\Downloads\Websites\Bihar foundation\bihar backend\resources\views/themes/lovable/home.blade.php ENDPATH**/ ?>