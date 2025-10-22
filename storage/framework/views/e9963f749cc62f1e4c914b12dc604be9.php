<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e(config('app.name', 'LawLite')); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <style>
        :root {
            --primary: #0b3d91;
            --accent: #ffd166;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;
            background: #f4f6f9;
            color: #1f2d3d;
        }

        .site-header {
            background: linear-gradient(90deg, var(--primary), #08306a);
            color: #fff;
        }

        .btn-accent {
            background: var(--accent);
            color: #102a43;
            border: none;
        }

        .hero {
            background: linear-gradient(180deg, rgba(11, 61, 145, 0.05), transparent);
            padding: 3.5rem 0;
        }
    </style>
</head>

<body>
    <?php echo $__env->make('components.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <main class="container py-4">
        <?php echo $__env->yieldContent('content'); ?>
    </main>
    <?php echo $__env->make('components.chat_ui', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('components.appointment_modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Pusher & Echo (optional - requires Pusher keys in .env) -->
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.3/dist/echo.iife.js"></script>
    <script>
        window.LAWLITE_USER_ID = <?php echo e(auth()->id() ?? 'null'); ?>;
        try {
            Pusher.logToConsole = false;
            const echo = new Echo({
                broadcaster: 'pusher',
                key: '<?php echo e(env('PUSHER_APP_KEY')); ?>',
                cluster: '<?php echo e(env('PUSHER_APP_CLUSTER')); ?>',
                forceTLS: true
            });

            if (window.LAWLITE_USER_ID) {
                echo.private('user.' + window.LAWLITE_USER_ID).listen('MessageSent', function(e) {
                    console.log('MessageSent event', e);
                    // Optionally update chat UI live
                });
            }
        } catch (e) {
            console.warn('Echo/Pusher not configured', e);
        }
    </script>
</body>

</html>
<?php /**PATH F:\Defence\LawLite\resources\views/layouts/app.blade.php ENDPATH**/ ?>