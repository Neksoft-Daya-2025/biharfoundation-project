

<?php $__env->startSection('title', 'Home'); ?>

<?php $__env->startSection('content'); ?>
<div style="font-family: system-ui; max-width: 600px; margin: 4rem auto; padding: 2rem; text-align: center;">
    <h1 style="font-size: 1.5rem;">Lovable theme</h1>
    <p style="color: #666;">This is the Lovable theme placeholder. Replace these views and assets in <code>resources/views/themes/lovable/</code> and <code>public/themes/lovable/</code> with your converted Lovable site.</p>
    <p style="margin-top: 1rem; font-size: 0.875rem; color: #999;">Active theme: <strong><?php echo e(config('themes.'.current_theme().'.name')); ?></strong></p>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.lovable.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ASUS\Desktop\laravel-backend\resources\views/themes/lovable/home.blade.php ENDPATH**/ ?>