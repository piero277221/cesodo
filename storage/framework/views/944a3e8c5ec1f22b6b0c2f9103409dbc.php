<?php $__env->startSection('title', 'Nuevo Proveedor'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-0">
                        <i class="fas fa-plus-circle text-primary me-2"></i>
                        Nuevo Proveedor
                    </h2>
                    <p class="text-muted mb-0">Registra un nuevo proveedor en el sistema</p>
                </div>
                <a href="<?php echo e(route('proveedores.index')); ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i>
                    Volver
                </a>
            </div>

            <?php if($errors->any()): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>¡Error!</strong> Por favor corrige los siguientes errores:
                    <ul class="mb-0 mt-2">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-info-circle me-2"></i>
                                Información del Proveedor
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="<?php echo e(route('proveedores.store')); ?>" method="POST">
                                <?php echo csrf_field(); ?>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="ruc" class="form-label">
                                            <i class="fas fa-id-card text-primary me-1"></i>
                                            RUC *
                                        </label>
                                        <input type="text"
                                               class="form-control <?php $__errorArgs = ['ruc'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               id="ruc"
                                               name="ruc"
                                               value="<?php echo e(old('ruc')); ?>"
                                               maxlength="11"
                                               placeholder="Ejm: 20123456789"
                                               required>
                                        <?php $__errorArgs = ['ruc'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        <div class="form-text">Ingresa el RUC del proveedor (11 dígitos)</div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="estado" class="form-label">
                                            <i class="fas fa-toggle-on text-primary me-1"></i>
                                            Estado *
                                        </label>
                                        <select class="form-select <?php $__errorArgs = ['estado'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                id="estado"
                                                name="estado"
                                                required>
                                            <option value="">Seleccionar estado</option>
                                            <option value="activo" <?php echo e(old('estado') == 'activo' ? 'selected' : ''); ?>>Activo</option>
                                            <option value="inactivo" <?php echo e(old('estado') == 'inactivo' ? 'selected' : ''); ?>>Inactivo</option>
                                        </select>
                                        <?php $__errorArgs = ['estado'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="razon_social" class="form-label">
                                        <i class="fas fa-building text-primary me-1"></i>
                                        Razón Social *
                                    </label>
                                    <input type="text"
                                           class="form-control <?php $__errorArgs = ['razon_social'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           id="razon_social"
                                           name="razon_social"
                                           value="<?php echo e(old('razon_social')); ?>"
                                           maxlength="255"
                                           placeholder="Ejm: EMPRESA PROVEEDORA S.A.C."
                                           required>
                                    <?php $__errorArgs = ['razon_social'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <div class="form-text">Nombre oficial de la empresa según registros públicos</div>
                                </div>

                                <div class="mb-3">
                                    <label for="nombre_comercial" class="form-label">
                                        <i class="fas fa-store text-primary me-1"></i>
                                        Nombre Comercial
                                    </label>
                                    <input type="text"
                                           class="form-control <?php $__errorArgs = ['nombre_comercial'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           id="nombre_comercial"
                                           name="nombre_comercial"
                                           value="<?php echo e(old('nombre_comercial')); ?>"
                                           maxlength="255"
                                           placeholder="Ejm: ProveMax">
                                    <?php $__errorArgs = ['nombre_comercial'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <div class="form-text">Nombre con el que opera comercialmente (opcional)</div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="telefono" class="form-label">
                                            <i class="fas fa-phone text-primary me-1"></i>
                                            Teléfono
                                        </label>
                                        <input type="tel"
                                               class="form-control <?php $__errorArgs = ['telefono'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               id="telefono"
                                               name="telefono"
                                               value="<?php echo e(old('telefono')); ?>"
                                               maxlength="20"
                                               placeholder="Ejm: 01-234-5678">
                                        <?php $__errorArgs = ['telefono'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">
                                            <i class="fas fa-envelope text-primary me-1"></i>
                                            Email
                                        </label>
                                        <input type="email"
                                               class="form-control <?php $__errorArgs = ['email'];
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
                                               maxlength="255"
                                               placeholder="Ejm: contacto@proveedor.com">
                                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="direccion" class="form-label">
                                        <i class="fas fa-map-marker-alt text-primary me-1"></i>
                                        Dirección
                                    </label>
                                    <textarea class="form-control <?php $__errorArgs = ['direccion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                              id="direccion"
                                              name="direccion"
                                              rows="3"
                                              placeholder="Ejm: Av. Los Proveedores 123, Distrito, Provincia, Departamento"><?php echo e(old('direccion')); ?></textarea>
                                    <?php $__errorArgs = ['direccion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="mb-4">
                                    <label for="contacto" class="form-label">
                                        <i class="fas fa-user-tie text-primary me-1"></i>
                                        Persona de Contacto
                                    </label>
                                    <input type="text"
                                           class="form-control <?php $__errorArgs = ['contacto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           id="contacto"
                                           name="contacto"
                                           value="<?php echo e(old('contacto')); ?>"
                                           maxlength="255"
                                           placeholder="Ejm: Juan Pérez - Gerente de Ventas">
                                    <?php $__errorArgs = ['contacto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <div class="form-text">Nombre y cargo de la persona de contacto principal</div>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <a href="<?php echo e(route('proveedores.index')); ?>" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-1"></i>
                                        Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i>
                                        Guardar Proveedor
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- Información de ayuda -->
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-lightbulb me-2"></i>
                                Información Importante
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <h6 class="text-primary">
                                    <i class="fas fa-star me-1"></i>
                                    Campos Obligatorios
                                </h6>
                                <ul class="list-unstyled mb-0">
                                    <li><i class="fas fa-check text-success me-1"></i> RUC (11 dígitos)</li>
                                    <li><i class="fas fa-check text-success me-1"></i> Razón Social</li>
                                    <li><i class="fas fa-check text-success me-1"></i> Estado</li>
                                </ul>
                            </div>

                            <div class="mb-3">
                                <h6 class="text-primary">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Consejos
                                </h6>
                                <ul class="list-unstyled mb-0 small">
                                    <li class="mb-2">
                                        <i class="fas fa-lightbulb text-warning me-1"></i>
                                        El RUC debe ser único en el sistema
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-lightbulb text-warning me-1"></i>
                                        Verifica que el email sea correcto para recibir comunicaciones
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-lightbulb text-warning me-1"></i>
                                        La persona de contacto facilitará las negociaciones
                                    </li>
                                </ul>
                            </div>

                            <div class="alert alert-light border-primary">
                                <i class="fas fa-shield-alt text-primary me-2"></i>
                                <strong>Seguridad:</strong> Toda la información será encriptada y protegida según nuestras políticas de seguridad.
                            </div>
                        </div>
                    </div>

                    <!-- Acciones rápidas -->
                    <div class="card mt-3">
                        <div class="card-header bg-secondary text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-bolt me-2"></i>
                                Acciones Rápidas
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="<?php echo e(route('proveedores.index')); ?>" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-list me-1"></i>
                                    Ver Todos los Proveedores
                                </a>
                                <button type="button" class="btn btn-outline-success btn-sm" onclick="limpiarFormulario()">
                                    <i class="fas fa-broom me-1"></i>
                                    Limpiar Formulario
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function limpiarFormulario() {
    if (confirm('¿Estás seguro de que quieres limpiar el formulario? Se perderán todos los datos ingresados.')) {
        document.querySelector('form').reset();
    }
}

// Validación de RUC en tiempo real
document.getElementById('ruc').addEventListener('input', function() {
    let ruc = this.value.replace(/\D/g, ''); // Solo números
    if (ruc.length > 11) {
        ruc = ruc.substring(0, 11);
    }
    this.value = ruc;

    // Validación visual
    if (ruc.length === 11) {
        this.classList.remove('is-invalid');
        this.classList.add('is-valid');
    } else {
        this.classList.remove('is-valid');
        if (ruc.length > 0) {
            this.classList.add('is-invalid');
        }
    }
});

// Auto-mayúsculas para razón social
document.getElementById('razon_social').addEventListener('input', function() {
    this.value = this.value.toUpperCase();
});

// Validación de email en tiempo real
document.getElementById('email').addEventListener('input', function() {
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (this.value === '') {
        this.classList.remove('is-valid', 'is-invalid');
    } else if (emailPattern.test(this.value)) {
        this.classList.remove('is-invalid');
        this.classList.add('is-valid');
    } else {
        this.classList.remove('is-valid');
        this.classList.add('is-invalid');
    }
});
</script>

<style>
.card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border-radius: 0.5rem;
}

.card-header {
    border-radius: 0.5rem 0.5rem 0 0 !important;
}

.form-control:focus, .form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.btn {
    border-radius: 0.375rem;
}

.alert {
    border-radius: 0.5rem;
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cesodo4\resources\views/proveedores/create.blade.php ENDPATH**/ ?>