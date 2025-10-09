<?php $__env->startSection('title', 'Nueva Categoría'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .categorias-header {
        background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%);
        color: white;
        padding: 2rem 0;
        margin-bottom: 2rem;
        border-radius: 0 0 1rem 1rem;
    }
    .card-categorias {
        border: none;
        border-radius: 15px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }
    .btn-categorias {
        background: #6f42c1;
        border: none;
        border-radius: 8px;
        padding: 0.6rem 1.5rem;
        color: white;
        transition: all 0.3s ease;
    }
    .btn-categorias:hover {
        background: #5a32a3;
        transform: translateY(-2px);
        color: white;
    }
    .form-floating .form-control:focus {
        border-color: #6f42c1;
        box-shadow: 0 0 0 0.25rem rgba(111, 66, 193, 0.25);
    }
    .form-floating .form-select:focus {
        border-color: #6f42c1;
        box-shadow: 0 0 0 0.25rem rgba(111, 66, 193, 0.25);
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="categorias-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="h2 mb-2">
                        <i class="fas fa-plus me-3"></i>
                        Nueva Categoría
                    </h1>
                    <p class="mb-0 opacity-90">
                        Crea una nueva categoría para organizar tus productos
                    </p>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="<?php echo e(route('categorias.index')); ?>" class="btn btn-outline-light">
                        <i class="fas fa-arrow-left me-2"></i>
                        Volver a Lista
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulario -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card card-categorias">
                    <div class="card-header bg-white border-0 pb-0">
                        <h5 class="mb-0">
                            <i class="fas fa-tag me-2 text-primary"></i>
                            Información de la Categoría
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger">
                                <h6><i class="fas fa-exclamation-triangle me-2"></i>Errores en el formulario:</h6>
                                <ul class="mb-0">
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <form action="<?php echo e(route('categorias.store')); ?>" method="POST" id="createCategoriaForm">
                            <?php echo csrf_field(); ?>

                            <div class="row g-3">
                                <!-- Código -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text"
                                               class="form-control <?php $__errorArgs = ['codigo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               id="codigo"
                                               name="codigo"
                                               value="<?php echo e(old('codigo')); ?>"
                                               placeholder="Código de la categoría"
                                               required>
                                        <label for="codigo">
                                            <i class="fas fa-barcode me-1"></i>
                                            Código *
                                        </label>
                                        <?php $__errorArgs = ['codigo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        <small class="form-text text-muted">
                                            Código único de identificación (ej: ELEC, HOGAR, OFIC)
                                        </small>
                                    </div>
                                </div>

                                <!-- Nombre -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text"
                                               class="form-control <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               id="nombre"
                                               name="nombre"
                                               value="<?php echo e(old('nombre')); ?>"
                                               placeholder="Nombre de la categoría"
                                               required>
                                        <label for="nombre">
                                            <i class="fas fa-tag me-1"></i>
                                            Nombre *
                                        </label>
                                        <?php $__errorArgs = ['nombre'];
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

                                <!-- Descripción -->
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control <?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                  id="descripcion"
                                                  name="descripcion"
                                                  style="height: 100px;"
                                                  placeholder="Descripción de la categoría"><?php echo e(old('descripcion')); ?></textarea>
                                        <label for="descripcion">
                                            <i class="fas fa-align-left me-1"></i>
                                            Descripción
                                        </label>
                                        <?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        <small class="form-text text-muted">
                                            Descripción opcional de la categoría
                                        </small>
                                    </div>
                                </div>

                                <!-- Estado -->
                                <div class="col-md-6">
                                    <div class="form-floating">
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
                                            <option value="activo" <?php echo e(old('estado', 'activo') == 'activo' ? 'selected' : ''); ?>>
                                                Activo
                                            </option>
                                            <option value="inactivo" <?php echo e(old('estado') == 'inactivo' ? 'selected' : ''); ?>>
                                                Inactivo
                                            </option>
                                        </select>
                                        <label for="estado">
                                            <i class="fas fa-toggle-on me-1"></i>
                                            Estado *
                                        </label>
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
                            </div>

                            <!-- Botones -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <a href="<?php echo e(route('categorias.index')); ?>" class="btn btn-outline-secondary">
                                            <i class="fas fa-times me-2"></i>
                                            Cancelar
                                        </a>
                                        <button type="submit" class="btn btn-categorias" id="btnGuardar">
                                            <i class="fas fa-save me-2"></i>
                                            Guardar Categoría
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-generar código basado en nombre
    const nombreInput = document.getElementById('nombre');
    const codigoInput = document.getElementById('codigo');

    nombreInput.addEventListener('blur', function() {
        if (!codigoInput.value && this.value) {
            // Generar código automático basado en el nombre
            const nombre = this.value.trim();
            let codigo = '';

            // Tomar las primeras 4 letras de cada palabra
            const palabras = nombre.split(' ');
            palabras.forEach(palabra => {
                if (palabra.length > 0) {
                    codigo += palabra.substring(0, 2).toUpperCase();
                }
            });

            // Limitar a 6 caracteres máximo
            codigo = codigo.substring(0, 6);
            codigoInput.value = codigo;
        }
    });

    // Validación en tiempo real del código
    codigoInput.addEventListener('input', function() {
        this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
    });

    // Confirmación antes de enviar
    document.getElementById('createCategoriaForm').addEventListener('submit', function(e) {
        if (!confirm('¿Estás seguro de crear esta categoría?')) {
            e.preventDefault();
        }
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cesodo4\resources\views/categorias/create.blade.php ENDPATH**/ ?>