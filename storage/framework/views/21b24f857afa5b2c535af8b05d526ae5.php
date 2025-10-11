<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo $__env->yieldContent('title', 'CESODO - Sistema de Gestión'); ?></title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo e(asset('favicon.ico')); ?>">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        :root {
            --bs-primary: #1a365d;
            --bs-primary-rgb: 26, 54, 93;
            --bs-secondary: #4a5568;
            --bs-success: #38a169;
            --bs-danger: #e53e3e;
            --bs-warning: #d69e2e;
            --bs-info: #3182ce;
            --primary-dark: #2c5282;
            --primary-light: #bee3f8;
            --accent: #ed8936;
            --neutral-50: #f8fafc;
            --neutral-100: #f1f5f9;
            --neutral-200: #e2e8f0;
            --neutral-800: #1a202c;
        }

        body {
            font-family: 'Figtree', sans-serif;
            background-color: var(--neutral-100);
            min-height: 100vh;
        }

        .btn-primary {
            background-color: var(--bs-primary);
            border: 2px solid var(--bs-primary);
            color: white;
            font-weight: 600;
            border-radius: 8px;
            padding: 12px 24px;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(26, 54, 93, 0.2);
        }

        .form-control:focus {
            border-color: var(--bs-primary);
            box-shadow: 0 0 0 3px rgba(26, 54, 93, 0.1);
        }

        .form-control-lg {
            padding: 14px 16px;
            border-radius: 8px;
            border: 2px solid var(--neutral-200);
            background-color: white;
            transition: all 0.2s ease;
            font-size: 16px;
        }

        .form-control-lg:focus {
            border-color: var(--bs-primary);
            background-color: var(--neutral-50);
        }

        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            background-color: white;
        }

        .alert {
            border: none;
            border-radius: 12px;
            padding: 16px 20px;
            border-left: 4px solid;
        }

        .alert-success {
            background-color: #f0fff4;
            color: var(--bs-success);
            border-left-color: var(--bs-success);
        }

        .alert-danger {
            background-color: #fef2f2;
            color: var(--bs-danger);
            border-left-color: var(--bs-danger);
        }

        .input-group .btn {
            border-radius: 0 8px 8px 0;
            border: 2px solid var(--neutral-200);
            border-left: none;
            background-color: var(--neutral-50);
            color: var(--bs-secondary);
        }

        .input-group .btn:hover {
            background-color: var(--neutral-100);
            color: var(--bs-primary);
        }

        .input-group .form-control {
            border-radius: 8px 0 0 8px;
        }

        .text-primary {
            color: var(--bs-primary) !important;
        }

        .bg-primary {
            background-color: var(--bs-primary) !important;
        }

        .btn-outline-primary {
            color: var(--bs-primary);
            border: 2px solid var(--bs-primary);
            background-color: transparent;
            font-weight: 600;
        }

        .btn-outline-primary:hover {
            background-color: var(--bs-primary);
            border-color: var(--bs-primary);
            color: white;
        }

        .btn-outline-secondary {
            color: var(--bs-secondary);
            border: 2px solid var(--neutral-200);
            background-color: var(--neutral-50);
        }

        .btn-outline-secondary:hover {
            background-color: var(--bs-secondary);
            border-color: var(--bs-secondary);
            color: white;
        }

        .form-check-input:checked {
            background-color: var(--bs-primary);
            border-color: var(--bs-primary);
        }

        /* Responsive adjustments */
        @media (max-width: 991px) {
            .container-fluid .row {
                background: white;
                border-radius: 16px;
                margin: 20px;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            }

            body {
                background-color: var(--neutral-100);
            }
        }

        /* Loading spinner */
        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
        }

        /* Logo animations */
        .fa-utensils {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        /* Custom shadows and borders */
        .shadow-custom {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .border-custom {
            border: 1px solid var(--neutral-200);
        }

        /* Panel styling */
        .auth-panel-left {
            background-color: var(--bs-primary);
            position: relative;
        }

        .auth-panel-right {
            background-color: white;
        }

        /* Text colors */
        .text-neutral-600 {
            color: #718096;
        }

        .text-neutral-800 {
            color: var(--neutral-800);
        }
    </style>

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body>
    <div id="app">
        <?php echo $__env->yieldContent('content'); ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Scripts -->
    <script>
        // Prevenir el envío múltiple de formularios
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const submitBtn = form.querySelector('button[type="submit"]');
                    if (submitBtn && !submitBtn.disabled) {
                        setTimeout(() => {
                            submitBtn.disabled = true;
                        }, 100);
                    }
                });
            });

            // Auto-hide alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    if (alert && alert.querySelector('.btn-close')) {
                        alert.querySelector('.btn-close').click();
                    }
                }, 5000);
            });
        });

        // Error handling global
        window.addEventListener('error', function(e) {
            console.error('Error en la página de autenticación:', e);
        });

        // Mostrar/ocultar contraseña
        function togglePasswordVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\cesodo4\resources\views/layouts/auth.blade.php ENDPATH**/ ?>