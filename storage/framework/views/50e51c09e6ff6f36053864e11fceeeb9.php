<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', config('app.name')); ?></title>
    <?php echo $__env->yieldPushContent('head'); ?>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <?php echo $__env->yieldContent('content'); ?>
    <?php echo $__env->yieldPushContent('scripts'); ?>
    <script>
    (function(){var u=encodeURIComponent(window.location.href);var i=new Image(1,1);i.src="<?php echo e(url('/api/track')); ?>?url="+u;})();
    </script>
</body>
</html>
<?php /**PATH C:\Users\MUGDHA\Downloads\Downloads\Websites\Bihar foundation\bihar backend\resources\views/themes/lovable/layouts/app.blade.php ENDPATH**/ ?>