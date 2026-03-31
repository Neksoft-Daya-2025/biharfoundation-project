<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - <?php echo e(config('app.name', "Malbi's Kitchen")); ?></title>
    <link rel="icon" type="image/png" href="<?php echo e(asset('assets/logo.png')); ?>">
    <?php if(file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot'))): ?>
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css']); ?>
    <?php else: ?>
        <script src="https://cdn.tailwindcss.com"></script>
    <?php endif; ?>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <style>
        :root { --teal: #0D7377; --teal-dark: #094B4F; --gold: #D4AF37; }
    </style>
</head>
<body class="bg-gradient-to-br from-amber-50 to-orange-50 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-8">
        <div class="text-center mb-8">
            <div class="flex justify-center mb-4">
                <img src="<?php echo e(asset('assets/logo.png')); ?>" alt="Logo" class="h-12 w-auto">
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2"><?php echo e(config('app.name', "Malbi's Kitchen")); ?></h1>
            <p class="text-gray-600">Admin Dashboard</p>
        </div>

        <?php if(config('admin.show_credentials_on_login')): ?>
            <div class="mb-6 p-4 bg-amber-50 border border-amber-200 rounded-lg">
                <p class="text-xs font-semibold text-amber-900 mb-2">Local access — sign in with:</p>
                <dl class="text-sm text-amber-950 space-y-1 font-mono">
                    <div class="flex gap-2"><dt class="text-amber-800 shrink-0">Email</dt><dd class="break-all"><?php echo e(config('admin.email')); ?></dd></div>
                    <div class="flex gap-2"><dt class="text-amber-800 shrink-0">Password</dt><dd><?php echo e(config('admin.password')); ?></dd></div>
                </dl>
                <p class="text-xs text-amber-800 mt-2">Set <code class="bg-amber-100 px-1 rounded">ADMIN_EMAIL</code> / <code class="bg-amber-100 px-1 rounded">ADMIN_PASSWORD</code> in <code class="bg-amber-100 px-1 rounded">.env</code>. Hide this box with <code class="bg-amber-100 px-1 rounded">ADMIN_SHOW_LOGIN_HINT=false</code>.</p>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <div class="flex items-center gap-2 text-red-800">
                    <i data-feather="alert-circle" class="w-5 h-5"></i>
                    <span class="text-sm font-medium"><?php echo e(session('error')); ?></span>
                </div>
            </div>
        <?php endif; ?>

        <?php if(session('success')): ?>
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                <div class="flex items-center gap-2 text-green-800">
                    <i data-feather="check-circle" class="w-5 h-5"></i>
                    <span class="text-sm font-medium"><?php echo e(session('success')); ?></span>
                </div>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('login.post')); ?>" class="space-y-6">
            <?php echo csrf_field(); ?>
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-900 mb-2">Email Address</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i data-feather="mail" class="w-5 h-5 text-gray-400"></i>
                    </div>
                    <input type="email" id="email" name="email" value="<?php echo e(old('email', config('admin.email'))); ?>" required autofocus
                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none transition-all"
                        placeholder="<?php echo e(config('admin.email')); ?>">
                </div>
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div>
                <label for="password" class="block text-sm font-semibold text-gray-900 mb-2">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i data-feather="lock" class="w-5 h-5 text-gray-400"></i>
                    </div>
                    <input type="password" id="password" name="password" required
                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none transition-all"
                        placeholder="Enter your password">
                </div>
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <button type="submit" class="w-full bg-[#937237] hover:bg-[#7a5d2e] text-white py-3 px-6 rounded-lg font-semibold hover:shadow-lg transition-all duration-300 flex items-center justify-center gap-2">
                <i data-feather="log-in" class="w-5 h-5"></i>
                <span>Login</span>
            </button>
        </form>

        <div class="mt-6 text-center space-y-1">
            <p class="text-xs text-gray-500"><i data-feather="shield" class="w-4 h-4 inline"></i> Secure admin access only</p>
            <p class="text-xs text-gray-500">After login you'll be taken to the <strong>Dashboard</strong> at <code class="bg-gray-100 px-1 rounded">/dashboard</code></p>
        </div>
    </div>
    <script>feather.replace();</script>
</body>
</html>
<?php /**PATH C:\Users\MUGDHA\Downloads\New folder\backend-project-main\backend-project-main\resources\views/auth/login.blade.php ENDPATH**/ ?>