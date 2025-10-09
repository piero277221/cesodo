@extends('layouts.auth')

@section('title', 'Recuperar Contraseña - CESODO')

@section('content')
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
                        <i class="fas fa-key fa-4x text-white"></i>
                    </div>
                    <h1 class="display-4 fw-bold mb-3">Recuperar Acceso</h1>
                    <h2 class="h3 mb-4 opacity-90">Restablece tu Contraseña</h2>
                    <p class="lead mb-4 opacity-75">Te ayudamos a recuperar el acceso a tu cuenta</p>
                </div>

                <div class="row text-center g-4">
                    <div class="col-4">
                        <div class="bg-white bg-opacity-10 rounded-3 p-3 mb-2">
                            <i class="fas fa-envelope fa-2x mb-2"></i>
                        </div>
                        <p class="small mb-0 opacity-75">Notificación por Email</p>
                    </div>
                    <div class="col-4">
                        <div class="bg-white bg-opacity-10 rounded-3 p-3 mb-2">
                            <i class="fas fa-shield-alt fa-2x mb-2"></i>
                        </div>
                        <p class="small mb-0 opacity-75">Proceso Seguro</p>
                    </div>
                    <div class="col-4">
                        <div class="bg-white bg-opacity-10 rounded-3 p-3 mb-2">
                            <i class="fas fa-clock fa-2x mb-2"></i>
                        </div>
                        <p class="small mb-0 opacity-75">Rápido y Fácil</p>
                    </div>
                </div>

                <div class="mt-5 bg-white bg-opacity-10 rounded-3 py-3 px-4">
                    <small class="opacity-75 d-flex align-items-center justify-content-center">
                        <i class="fas fa-info-circle me-2"></i>
                        El enlace expirará en 60 minutos
                    </small>
                </div>
            </div>
        </div>

        <!-- Panel Derecho - Formulario de Recuperación -->
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
                    <h3 class="fw-bold text-neutral-800 mb-2">¿Olvidaste tu contraseña?</h3>
                    <p class="text-neutral-600">No te preocupes. Te enviaremos un enlace de recuperación a tu correo electrónico para que puedas crear una nueva contraseña.</p>
                </div>

                <!-- Alertas de estado -->
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <strong>¡Correo enviado!</strong><br>
                        {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <strong>Error:</strong> {{ $errors->first() }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Formulario de Recuperación -->
                <form method="POST" action="{{ route('password.email') }}" id="forgotForm">
                    @csrf

                    <!-- Campo Email -->
                    <div class="mb-4">
                        <label for="email" class="form-label fw-semibold">
                            <i class="fas fa-envelope text-primary me-2"></i>Correo Electrónico
                        </label>
                        <input type="email"
                               class="form-control form-control-lg @error('email') is-invalid @enderror"
                               id="email"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               autofocus
                               autocomplete="email"
                               placeholder="Ingresa tu correo electrónico">
                        @error('email')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            Introduce el correo electrónico asociado a tu cuenta
                        </div>
                    </div>

                    <!-- Botón de Enviar -->
                    <button type="submit" class="btn btn-primary btn-lg w-100 mb-4" id="forgotBtn">
                        <span class="spinner-border spinner-border-sm me-2 d-none" id="forgotSpinner"></span>
                        <i class="fas fa-paper-plane me-2" id="forgotIcon"></i>
                        <span id="forgotText">Enviar Enlace de Recuperación</span>
                    </button>

                    <!-- Enlaces adicionales -->
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('login') }}" class="text-decoration-none text-primary">
                            <i class="fas fa-arrow-left me-1"></i>
                            Volver al Login
                        </a>

                        <a href="{{ route('register') }}" class="text-decoration-none text-secondary">
                            <small>Crear cuenta nueva</small>
                        </a>
                    </div>
                </form>

                <!-- Información adicional -->
                <div class="mt-5 bg-light border-custom rounded-4 p-4">
                    <h6 class="fw-bold text-neutral-800 mb-3">
                        <i class="fas fa-question-circle text-primary me-2"></i>
                        ¿Necesitas ayuda?
                    </h6>
                    <div class="small text-neutral-600">
                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-primary bg-opacity-10 rounded-2 p-2 me-3">
                                <i class="fas fa-clock text-primary"></i>
                            </div>
                            <div>
                                <strong>Tiempo de expiración:</strong><br>
                                <span>El enlace será válido por 60 minutos</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-primary bg-opacity-10 rounded-2 p-2 me-3">
                                <i class="fas fa-envelope text-primary"></i>
                            </div>
                            <div>
                                <strong>Revisa spam:</strong><br>
                                <span>El correo podría llegar a tu carpeta de spam</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-start">
                            <div class="bg-primary bg-opacity-10 rounded-2 p-2 me-3">
                                <i class="fas fa-phone text-primary"></i>
                            </div>
                            <div>
                                <strong>¿No funciona?</strong><br>
                                <span>Contacta al administrador del sistema</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form submission loading state
    const forgotForm = document.getElementById('forgotForm');
    const forgotBtn = document.getElementById('forgotBtn');
    const forgotSpinner = document.getElementById('forgotSpinner');
    const forgotIcon = document.getElementById('forgotIcon');
    const forgotText = document.getElementById('forgotText');

    if (forgotForm) {
        forgotForm.addEventListener('submit', function() {
            forgotBtn.disabled = true;
            forgotSpinner.classList.remove('d-none');
            forgotIcon.classList.add('d-none');
            forgotText.textContent = 'Enviando enlace...';
        });
    }

    // Auto-focus en el campo email si hay error
    const emailField = document.getElementById('email');
    if (emailField && emailField.classList.contains('is-invalid')) {
        emailField.focus();
    }

    // Validación básica del email en tiempo real
    if (emailField) {
        emailField.addEventListener('input', function() {
            const email = this.value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (email && !emailRegex.test(email)) {
                this.classList.add('is-invalid');
                this.classList.remove('is-valid');
            } else if (email) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            } else {
                this.classList.remove('is-invalid', 'is-valid');
            }
        });
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
@endsection
