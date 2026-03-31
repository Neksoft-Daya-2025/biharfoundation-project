

<?php $__env->startSection('title', 'Home'); ?>

<?php $__env->startSection('content'); ?>
<div style="font-family: system-ui; max-width: 600px; margin: 4rem auto; padding: 2rem; text-align: center;">
    <h1 style="font-size: 1.5rem;">Default theme</h1>
    <p style="color: #666;">Replace this with your Lovable-converted views or switch to another theme in Dashboard → Settings → General.</p>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ASUS\Desktop\laravel-backend\resources\views/themes/default/home.blade.php ENDPATH**/ ?>