<?php $__env->startSection('title', 'Iniciar Sesión - CESODO'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid min-vh-100">
    <div class="row min-vh-100">
        <!-- Panel Izquierdo - Información del Sistema -->
        <div class="col-lg-6 d-none d-lg-flex align-items-center justify-content-center auth-panel-left position-relative">
            <!-- Patrón de fondo sutil -->
            <div class="position-absolute top-0 start-0 w-100 h-100"
                 style="background-image: radial-gradient(circle at 20% 80%, rgba(255,255,255,0.1) 0%, transparent 50%), radial-gradient(circle at 80% 20%, rgba(255,255,255,0.1) 0%, transparent 50%);"></div>

            <div class="text-white text-center position-relative z-1">
                <div class="mb-5">
                    <div class="bg-white bg-opacity-20 rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 120px; height: 120px;">
                        <i class="fas fa-utensils fa-4x text-white"></i>
                    </div>
                    <h1 class="display-4 fw-bold mb-3">CESODO</h1>
                    <h2 class="h3 mb-4 opacity-90">Sistema de Gestión</h2>
                    <p class="lead mb-4 opacity-75">Concesionaria de Alimentos</p>
                </div>

                <div class="row text-center g-4">
                    <div class="col-4">
                        <div class="bg-white bg-opacity-10 rounded-3 p-3 mb-2">
                            <i class="fas fa-clipboard-list fa-2x mb-2"></i>
                        </div>
                        <p class="small mb-0 opacity-75">Gestión de Menús</p>
                    </div>
                    <div class="col-4">
                        <div class="bg-white bg-opacity-10 rounded-3 p-3 mb-2">
                            <i class="fas fa-boxes fa-2x mb-2"></i>
                        </div>
                        <p class="small mb-0 opacity-75">Control de Inventarios</p>
                    </div>
                    <div class="col-4">
                        <div class="bg-white bg-opacity-10 rounded-3 p-3 mb-2">
                            <i class="fas fa-users fa-2x mb-2"></i>
                        </div>
                        <p class="small mb-0 opacity-75">Administración</p>
                    </div>
                </div>

                <div class="mt-5 bg-white bg-opacity-10 rounded-3 py-3 px-4">
                    <small class="opacity-75 d-flex align-items-center justify-content-center">
                        <i class="fas fa-shield-alt me-2"></i>
                        Sistema seguro y confiable
                    </small>
                </div>
            </div>
        </div>

        <!-- Panel Derecho - Formulario de Login -->
        <div class="col-lg-6 d-flex align-items-center justify-content-center auth-panel-right p-5">
            <div class="w-100" style="max-width: 440px;">
                <!-- Logo móvil -->
                <div class="text-center d-lg-none mb-5">
                    <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="fas fa-utensils text-white fa-2x"></i>
                    </div>
                    <h2 class="text-primary fw-bold mb-2">CESODO</h2>
                    <p class="text-neutral-600">Sistema de Gestión de Alimentos</p>
                </div>

                <!-- Encabezado del formulario -->
                <div class="text-center mb-5">
                    <h3 class="fw-bold text-neutral-800 mb-2">Bienvenido de vuelta</h3>
                    <p class="text-neutral-600">Ingresa tus credenciales para acceder al sistema</p>
                </div>

                <!-- Alertas de estado -->
                <?php if(session('status')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <?php echo e(session('status')); ?>

                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if($errors->any()): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <strong>Error:</strong> <?php echo e($errors->first()); ?>

                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Formulario de Login -->
                <form method="POST" action="<?php echo e(route('login')); ?>" id="loginForm">
                    <?php echo csrf_field(); ?>

                    <!-- Campo Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">
                            <i class="fas fa-envelope text-primary me-2"></i>Correo Electrónico
                        </label>
                        <input type="email"
                               class="form-control form-control-lg <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               id="email"
                               name="email"
                               value="<?php echo e(old('email')); ?>"
                               required
                               autofocus
                               autocomplete="username"
                               placeholder="usuario@ejemplo.com">
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-triangle me-1"></i><?php echo e($message); ?>

                            </div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Campo Contraseña -->
                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">
                            <i class="fas fa-lock text-primary me-2"></i>Contraseña
                        </label>
                        <div class="input-group">
                            <input type="password"
                                   class="form-control form-control-lg <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   id="password"
                                   name="password"
                                   required
                                   autocomplete="current-password"
                                   placeholder="Ingresa tu contraseña">
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <i class="fas fa-eye" id="eyeIcon"></i>
                            </button>
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-triangle me-1"></i><?php echo e($message); ?>

                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <!-- Recordar sesión y enlaces -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                            <label class="form-check-label text-muted" for="remember_me">
                                Recordarme
                            </label>
                        </div>

                        <?php if(Route::has('password.request')): ?>
                            <a href="<?php echo e(route('password.request')); ?>" class="text-decoration-none text-primary">
                                <small>¿Olvidaste tu contraseña?</small>
                            </a>
                        <?php endif; ?>
                    </div>

                    <!-- Botón de Login -->
                    <button type="submit" class="btn btn-primary btn-lg w-100 mb-3" id="loginBtn">
                        <span class="spinner-border spinner-border-sm me-2 d-none" id="loginSpinner"></span>
                        <i class="fas fa-sign-in-alt me-2" id="loginIcon"></i>
                        <span id="loginText">Iniciar Sesión</span>
                    </button>

                    <!-- Información adicional -->
                    <div class="text-center">
                        <small class="text-neutral-600">
                            <i class="fas fa-info-circle me-1"></i>
                            Si tienes problemas para acceder, contacta al administrador del sistema
                        </small>
                    </div>
                </form>

                <!-- Usuarios de demo (solo en desarrollo) -->
                <?php if(config('app.env') === 'local'): ?>
                    <div class="mt-4">
                        <hr class="my-4">
                        <div class="text-center">
                            <small class="text-neutral-600 d-block mb-3">Usuarios de prueba:</small>
                            <div class="row g-2">
                                <div class="col-6">
                                    <button type="button" class="btn btn-outline-primary btn-sm w-100" onclick="fillCredentials('admin@cesodo.com', 'password')">
                                        <i class="fas fa-user-shield me-1"></i>Admin
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button type="button" class="btn btn-outline-secondary btn-sm w-100" onclick="fillCredentials('user@cesodo.com', 'password')">
                                        <i class="fas fa-user me-1"></i>Usuario
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle password visibility
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    if (togglePassword) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            if (type === 'password') {
                eyeIcon.className = 'fas fa-eye';
            } else {
                eyeIcon.className = 'fas fa-eye-slash';
            }
        });
    }

    // Form submission loading state
    const loginForm = document.getElementById('loginForm');
    const loginBtn = document.getElementById('loginBtn');
    const loginSpinner = document.getElementById('loginSpinner');
    const loginIcon = document.getElementById('loginIcon');
    const loginText = document.getElementById('loginText');

    if (loginForm) {
        loginForm.addEventListener('submit', function() {
            loginBtn.disabled = true;
            loginSpinner.classList.remove('d-none');
            loginIcon.classList.add('d-none');
            loginText.textContent = 'Iniciando sesión...';
        });
    }

    // Auto-focus en el primer campo con error
    const firstError = document.querySelector('.is-invalid');
    if (firstError) {
        firstError.focus();
    }
});

// Función para llenar credenciales de demo (solo desarrollo)
<?php if(config('app.env') === 'local'): ?>
function fillCredentials(email, password) {
    document.getElementById('email').value = email;
    document.getElementById('password').value = password;
    document.getElementById('email').focus();
}
<?php endif; ?>

// Animación de entrada
document.addEventListener('DOMContentLoaded', function() {
    const formContainer = document.querySelector('.col-lg-6:last-child > div');
    if (formContainer) {
        formContainer.style.opacity = '0';
        formContainer.style.transform = 'translateY(20px)';

        setTimeout(() => {
            formContainer.style.transition = 'all 0.6s ease-out';
            formContainer.style.opacity = '1';
            formContainer.style.transform = 'translateY(0)';
        }, 100);
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cesodo4\resources\views/auth/login.blade.php ENDPATH**/ ?>