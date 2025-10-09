<?php $__env->startSection('title', 'Registro - CESODO'); ?>

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
                        <i class="fas fa-user-plus fa-4x text-white"></i>
                    </div>
                    <h1 class="display-4 fw-bold mb-3">Únete a CESODO</h1>
                    <h2 class="h3 mb-4 opacity-90">Registro de Usuario</h2>
                    <p class="lead mb-4 opacity-75">Crea tu cuenta para acceder al sistema</p>
                </div>

                <div class="row text-center g-4">
                    <div class="col-4">
                        <div class="bg-white bg-opacity-10 rounded-3 p-3 mb-2">
                            <i class="fas fa-shield-alt fa-2x mb-2"></i>
                        </div>
                        <p class="small mb-0 opacity-75">Seguridad</p>
                    </div>
                    <div class="col-4">
                        <div class="bg-white bg-opacity-10 rounded-3 p-3 mb-2">
                            <i class="fas fa-clock fa-2x mb-2"></i>
                        </div>
                        <p class="small mb-0 opacity-75">Acceso 24/7</p>
                    </div>
                    <div class="col-4">
                        <div class="bg-white bg-opacity-10 rounded-3 p-3 mb-2">
                            <i class="fas fa-support fa-2x mb-2"></i>
                        </div>
                        <p class="small mb-0 opacity-75">Soporte</p>
                    </div>
                </div>

                <div class="mt-5 bg-white bg-opacity-10 rounded-3 py-3 px-4">
                    <small class="opacity-75 d-flex align-items-center justify-content-center">
                        <i class="fas fa-lock me-2"></i>
                        Tus datos están protegidos
                    </small>
                </div>
            </div>
        </div>

        <!-- Panel Derecho - Formulario de Registro -->
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
                    <h3 class="fw-bold text-neutral-800 mb-2">Crear Nueva Cuenta</h3>
                    <p class="text-neutral-600">Completa los siguientes datos para registrarte</p>
                </div>

                <!-- Alertas de error -->
                <?php if($errors->any()): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <strong>Error:</strong> Por favor corrige los siguientes errores:
                        <ul class="mb-0 mt-2">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Formulario de Registro -->
                <form method="POST" action="<?php echo e(route('register')); ?>" id="registerForm">
                    <?php echo csrf_field(); ?>

                    <!-- Campo Nombre -->
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">
                            <i class="fas fa-user text-primary me-2"></i>Nombre Completo
                        </label>
                        <input type="text"
                               class="form-control form-control-lg <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               id="name"
                               name="name"
                               value="<?php echo e(old('name')); ?>"
                               required
                               autofocus
                               autocomplete="name"
                               placeholder="Ingresa tu nombre completo">
                        <?php $__errorArgs = ['name'];
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
                                   autocomplete="new-password"
                                   placeholder="Mínimo 8 caracteres">
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
                        <!-- Indicador de fortaleza de contraseña -->
                        <div class="mt-2">
                            <div class="progress" style="height: 4px;">
                                <div class="progress-bar" id="passwordStrength" role="progressbar" style="width: 0%"></div>
                            </div>
                            <small id="passwordHint" class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                La contraseña debe tener al menos 8 caracteres
                            </small>
                        </div>
                    </div>

                    <!-- Campo Confirmar Contraseña -->
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label fw-semibold">
                            <i class="fas fa-check-double text-primary me-2"></i>Confirmar Contraseña
                        </label>
                        <div class="input-group">
                            <input type="password"
                                   class="form-control form-control-lg <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   id="password_confirmation"
                                   name="password_confirmation"
                                   required
                                   autocomplete="new-password"
                                   placeholder="Repite tu contraseña">
                            <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirm">
                                <i class="fas fa-eye" id="eyeIconConfirm"></i>
                            </button>
                            <?php $__errorArgs = ['password_confirmation'];
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
                        <div class="mt-2">
                            <small id="passwordMatch" class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Las contraseñas deben coincidir
                            </small>
                        </div>
                    </div>

                    <!-- Términos y condiciones -->
                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="terms" required>
                            <label class="form-check-label text-sm" for="terms">
                                Acepto los <a href="#" class="text-primary text-decoration-none">términos y condiciones</a>
                                y la <a href="#" class="text-primary text-decoration-none">política de privacidad</a>
                            </label>
                        </div>
                    </div>

                    <!-- Botón de Registro -->
                    <button type="submit" class="btn btn-primary btn-lg w-100 mb-3" id="registerBtn">
                        <span class="spinner-border spinner-border-sm me-2 d-none" id="registerSpinner"></span>
                        <i class="fas fa-user-plus me-2" id="registerIcon"></i>
                        <span id="registerText">Crear Cuenta</span>
                    </button>

                    <!-- Link al login -->
                    <div class="text-center">
                        <p class="text-muted mb-0">
                            ¿Ya tienes una cuenta?
                            <a href="<?php echo e(route('login')); ?>" class="text-primary text-decoration-none fw-semibold">
                                Inicia sesión aquí
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle password visibility for main password
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

    // Toggle password visibility for confirmation
    const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');
    const passwordConfirmInput = document.getElementById('password_confirmation');
    const eyeIconConfirm = document.getElementById('eyeIconConfirm');

    if (togglePasswordConfirm) {
        togglePasswordConfirm.addEventListener('click', function() {
            const type = passwordConfirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordConfirmInput.setAttribute('type', type);

            if (type === 'password') {
                eyeIconConfirm.className = 'fas fa-eye';
            } else {
                eyeIconConfirm.className = 'fas fa-eye-slash';
            }
        });
    }

    // Password strength indicator
    const passwordStrength = document.getElementById('passwordStrength');
    const passwordHint = document.getElementById('passwordHint');

    if (passwordInput && passwordStrength) {
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            let feedback = '';

            if (password.length >= 8) strength += 25;
            if (/[a-z]/.test(password)) strength += 25;
            if (/[A-Z]/.test(password)) strength += 25;
            if (/[0-9]/.test(password) || /[^A-Za-z0-9]/.test(password)) strength += 25;

            passwordStrength.style.width = strength + '%';

            if (strength < 25) {
                passwordStrength.className = 'progress-bar bg-danger';
                feedback = 'Contraseña muy débil';
            } else if (strength < 50) {
                passwordStrength.className = 'progress-bar bg-warning';
                feedback = 'Contraseña débil';
            } else if (strength < 75) {
                passwordStrength.className = 'progress-bar bg-info';
                feedback = 'Contraseña buena';
            } else {
                passwordStrength.className = 'progress-bar bg-success';
                feedback = 'Contraseña fuerte';
            }

            passwordHint.innerHTML = `<i class="fas fa-info-circle me-1"></i>${feedback}`;
        });
    }

    // Password confirmation validation
    const passwordMatch = document.getElementById('passwordMatch');

    function checkPasswordMatch() {
        if (passwordInput && passwordConfirmInput && passwordMatch) {
            const password = passwordInput.value;
            const confirmPassword = passwordConfirmInput.value;

            if (confirmPassword === '') {
                passwordMatch.innerHTML = '<i class="fas fa-info-circle me-1"></i>Las contraseñas deben coincidir';
                passwordMatch.className = 'text-muted';
            } else if (password === confirmPassword) {
                passwordMatch.innerHTML = '<i class="fas fa-check me-1"></i>Las contraseñas coinciden';
                passwordMatch.className = 'text-success';
            } else {
                passwordMatch.innerHTML = '<i class="fas fa-times me-1"></i>Las contraseñas no coinciden';
                passwordMatch.className = 'text-danger';
            }
        }
    }

    if (passwordInput) passwordInput.addEventListener('input', checkPasswordMatch);
    if (passwordConfirmInput) passwordConfirmInput.addEventListener('input', checkPasswordMatch);

    // Form submission loading state
    const registerForm = document.getElementById('registerForm');
    const registerBtn = document.getElementById('registerBtn');
    const registerSpinner = document.getElementById('registerSpinner');
    const registerIcon = document.getElementById('registerIcon');
    const registerText = document.getElementById('registerText');

    if (registerForm) {
        registerForm.addEventListener('submit', function() {
            registerBtn.disabled = true;
            registerSpinner.classList.remove('d-none');
            registerIcon.classList.add('d-none');
            registerText.textContent = 'Creando cuenta...';
        });
    }

    // Auto-focus en el primer campo con error
    const firstError = document.querySelector('.is-invalid');
    if (firstError) {
        firstError.focus();
    }
});

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

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cesodo4\resources\views/auth/register.blade.php ENDPATH**/ ?>