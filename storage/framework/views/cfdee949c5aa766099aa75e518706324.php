<?php $__env->startSection('title', 'Nueva Persona'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/cesodo-theme.css')); ?>">
<style>
    .fecha-nacimiento-enhanced {
        transition: all 0.3s ease;
    }

    .fecha-nacimiento-enhanced:focus {
        border-color: var(--cesodo-red);
        box-shadow: 0 0 0 0.2rem rgba(220, 38, 38, 0.25);
    }

    .edad-feedback {
        background: linear-gradient(90deg, var(--cesodo-red-lighter), transparent);
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        border-left: 3px solid var(--cesodo-red);
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">
                    <i class="fas fa-user-plus text-cesodo-red me-2"></i>
                    Nueva Persona
                </h2>
                <a href="<?php echo e(route('personas.index')); ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>
                    Volver
                </a>
            </div>

            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <h6><i class="fas fa-exclamation-triangle me-1"></i> Errores de validación:</h6>
                    <ul class="mb-0">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('personas.store')); ?>" method="POST" id="createPersonaForm">
                <?php echo csrf_field(); ?>

                <div class="row">
                    <!-- Información Personal -->
                    <div class="col-lg-6 mb-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-header bg-cesodo-red text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-user me-2"></i>
                                    Información Personal
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nombres" class="form-label">Nombres <span class="text-danger">*</span></label>
                                        <input type="text"
                                               class="form-control <?php $__errorArgs = ['nombres'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               id="nombres"
                                               name="nombres"
                                               value="<?php echo e(old('nombres')); ?>"
                                               required>
                                        <?php $__errorArgs = ['nombres'];
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
                                        <label for="apellidos" class="form-label">Apellidos <span class="text-danger">*</span></label>
                                        <input type="text"
                                               class="form-control <?php $__errorArgs = ['apellidos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               id="apellidos"
                                               name="apellidos"
                                               value="<?php echo e(old('apellidos')); ?>"
                                               required>
                                        <?php $__errorArgs = ['apellidos'];
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

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="fecha_nacimiento" class="form-label">
                                            <i class="fas fa-calendar-alt text-cesodo-red me-1"></i>
                                            Fecha de Nacimiento
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-cesodo-red text-white">
                                                <i class="fas fa-birthday-cake"></i>
                                            </span>
                                            <input type="date"
                                                   class="form-control fecha-nacimiento-enhanced <?php $__errorArgs = ['fecha_nacimiento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                   id="fecha_nacimiento"
                                                   name="fecha_nacimiento"
                                                   value="<?php echo e(old('fecha_nacimiento')); ?>"
                                                   max="<?php echo e(date('Y-m-d')); ?>"
                                                   min="<?php echo e(date('Y-m-d', strtotime('-120 years'))); ?>"
                                                   onchange="calcularEdad()"
                                                   title="Selecciona la fecha de nacimiento">
                                        </div>
                                        <div id="edad_display" class="form-text text-cesodo-black mt-1" style="display: none;">
                                            <i class="fas fa-info-circle me-1"></i>
                                            <span id="edad_texto"></span>
                                        </div>
                                        <?php $__errorArgs = ['fecha_nacimiento'];
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
                                        <label for="sexo" class="form-label">Sexo</label>
                                        <select class="form-select <?php $__errorArgs = ['sexo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                id="sexo"
                                                name="sexo">
                                            <option value="">Seleccionar</option>
                                            <option value="M" <?php echo e(old('sexo') == 'M' ? 'selected' : ''); ?>>Masculino</option>
                                            <option value="F" <?php echo e(old('sexo') == 'F' ? 'selected' : ''); ?>>Femenino</option>
                                            <option value="O" <?php echo e(old('sexo') == 'O' ? 'selected' : ''); ?>>Otro</option>
                                        </select>
                                        <?php $__errorArgs = ['sexo'];
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

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nacionalidad" class="form-label">Nacionalidad</label>
                                        <input type="text"
                                               class="form-control <?php $__errorArgs = ['nacionalidad'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               id="nacionalidad"
                                               name="nacionalidad"
                                               value="<?php echo e(old('nacionalidad', 'Peruana')); ?>">
                                        <?php $__errorArgs = ['nacionalidad'];
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
                                        <label for="estado_civil" class="form-label">Estado Civil</label>
                                        <select class="form-select <?php $__errorArgs = ['estado_civil'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                id="estado_civil"
                                                name="estado_civil">
                                            <option value="">Seleccionar</option>
                                            <option value="Soltero(a)" <?php echo e(old('estado_civil') == 'Soltero(a)' ? 'selected' : ''); ?>>Soltero(a)</option>
                                            <option value="Casado(a)" <?php echo e(old('estado_civil') == 'Casado(a)' ? 'selected' : ''); ?>>Casado(a)</option>
                                            <option value="Divorciado(a)" <?php echo e(old('estado_civil') == 'Divorciado(a)' ? 'selected' : ''); ?>>Divorciado(a)</option>
                                            <option value="Viudo(a)" <?php echo e(old('estado_civil') == 'Viudo(a)' ? 'selected' : ''); ?>>Viudo(a)</option>
                                            <option value="Conviviente" <?php echo e(old('estado_civil') == 'Conviviente' ? 'selected' : ''); ?>>Conviviente</option>
                                        </select>
                                        <?php $__errorArgs = ['estado_civil'];
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
                                    <label for="direccion" class="form-label">Dirección</label>
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
                                              rows="2"><?php echo e(old('direccion')); ?></textarea>
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
                            </div>
                        </div>
                    </div>

                    <!-- Información de Documentos -->
                    <div class="col-lg-6 mb-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-header bg-cesodo-black text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-id-card me-2"></i>
                                    Documentos e Identificación
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="tipo_documento" class="form-label">Tipo de Documento <span class="text-danger">*</span></label>
                                        <select class="form-select <?php $__errorArgs = ['tipo_documento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                id="tipo_documento"
                                                name="tipo_documento"
                                                required>
                                            <option value="">Seleccionar tipo</option>
                                            <option value="dni" <?php echo e(old('tipo_documento') == 'dni' ? 'selected' : ''); ?>>DNI</option>
                                            <option value="ce" <?php echo e(old('tipo_documento') == 'ce' ? 'selected' : ''); ?>>Carnet de Extranjería</option>
                                            <option value="pasaporte" <?php echo e(old('tipo_documento') == 'pasaporte' ? 'selected' : ''); ?>>Pasaporte</option>
                                            <option value="ruc" <?php echo e(old('tipo_documento') == 'ruc' ? 'selected' : ''); ?>>RUC</option>
                                            <option value="otros" <?php echo e(old('tipo_documento') == 'otros' ? 'selected' : ''); ?>>Otros</option>
                                        </select>
                                        <?php $__errorArgs = ['tipo_documento'];
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
                                        <label for="numero_documento" class="form-label">Número de Documento <span class="text-danger">*</span></label>
                                        <input type="text"
                                               class="form-control <?php $__errorArgs = ['numero_documento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               id="numero_documento"
                                               name="numero_documento"
                                               value="<?php echo e(old('numero_documento')); ?>"
                                               required>
                                        <?php $__errorArgs = ['numero_documento'];
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

                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Información:</strong>
                                    <ul class="mb-0 mt-2">
                                        <li><strong>DNI:</strong> 8 dígitos para peruanos</li>
                                        <li><strong>CE:</strong> Carnet de extranjería</li>
                                        <li><strong>Pasaporte:</strong> Documento internacional</li>
                                        <li><strong>RUC:</strong> 11 dígitos para empresas</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Información de Contacto -->
                    <div class="col-lg-12 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header bg-cesodo-red text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-phone me-2"></i>
                                    Información de Contacto
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="celular" class="form-label">Teléfono/Celular</label>
                                        <input type="tel"
                                               class="form-control <?php $__errorArgs = ['celular'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               id="celular"
                                               name="celular"
                                               value="<?php echo e(old('celular')); ?>">
                                        <?php $__errorArgs = ['celular'];
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
                                        <label for="correo" class="form-label">Correo Electrónico</label>
                                        <input type="email"
                                               class="form-control <?php $__errorArgs = ['correo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               id="correo"
                                               name="correo"
                                               value="<?php echo e(old('correo')); ?>">
                                        <?php $__errorArgs = ['correo'];
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
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="<?php echo e(route('personas.index')); ?>" class="btn btn-secondary">
                                        <i class="fas fa-times me-1"></i>
                                        Cancelar
                                    </a>
                                    <button type="reset" class="btn btn-outline-warning">
                                        <i class="fas fa-undo me-1"></i>
                                        Limpiar
                                    </button>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save me-1"></i>
                                        Guardar Persona
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validación de DNI
    const tipoDocumento = document.getElementById('tipo_documento');
    const numeroDocumento = document.getElementById('numero_documento');

    function validarDocumento() {
        const tipo = tipoDocumento.value;
        numeroDocumento.removeAttribute('maxlength');
        numeroDocumento.removeAttribute('pattern');

        switch(tipo) {
            case 'dni':
                numeroDocumento.setAttribute('maxlength', '8');
                numeroDocumento.setAttribute('pattern', '[0-9]{8}');
                numeroDocumento.setAttribute('placeholder', '12345678');
                break;
            case 'ruc':
                numeroDocumento.setAttribute('maxlength', '11');
                numeroDocumento.setAttribute('pattern', '[0-9]{11}');
                numeroDocumento.setAttribute('placeholder', '12345678901');
                break;
            case 'ce':
                numeroDocumento.setAttribute('maxlength', '12');
                numeroDocumento.setAttribute('placeholder', '001234567');
                break;
            case 'pasaporte':
                numeroDocumento.setAttribute('maxlength', '15');
                numeroDocumento.setAttribute('placeholder', 'ABC123456');
                break;
            default:
                numeroDocumento.setAttribute('placeholder', 'Número de documento');
        }
    }

    tipoDocumento.addEventListener('change', validarDocumento);

    // Validación de solo números para DNI y RUC
    numeroDocumento.addEventListener('input', function() {
        const tipo = tipoDocumento.value;
        if (tipo === 'dni' || tipo === 'ruc') {
            this.value = this.value.replace(/\D/g, '');
        }
    });

    // Validación de teléfono
    const celularInput = document.getElementById('celular');
    celularInput.addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '').slice(0, 9);
    });

    // Confirmación antes de enviar
    document.getElementById('createPersonaForm').addEventListener('submit', function(e) {
        if (!confirm('¿Está seguro de crear esta persona?')) {
            e.preventDefault();
        }
    });
});

// Funciones para mejorar la fecha de nacimiento
function calcularEdad() {
    const fechaNacimiento = document.getElementById('fecha_nacimiento').value;
    const edadDisplay = document.getElementById('edad_display');
    const edadTexto = document.getElementById('edad_texto');

    if (fechaNacimiento) {
        const hoy = new Date();
        const nacimiento = new Date(fechaNacimiento);
        let edad = hoy.getFullYear() - nacimiento.getFullYear();
        const mes = hoy.getMonth() - nacimiento.getMonth();

        if (mes < 0 || (mes === 0 && hoy.getDate() < nacimiento.getDate())) {
            edad--;
        }

        if (edad >= 0 && edad <= 120) {
            let textoEdad = `Edad: ${edad} años`;
            let categoria = '';

            if (edad < 18) {
                categoria = ' (Menor de edad)';
            } else if (edad >= 65) {
                categoria = ' (Adulto mayor)';
            }

            edadTexto.textContent = textoEdad + categoria;
            edadDisplay.style.display = 'block';
            edadDisplay.className = 'form-text text-cesodo-black mt-1 edad-feedback';
        } else if (edad < 0) {
            edadTexto.textContent = 'Fecha futura no válida';
            edadDisplay.style.display = 'block';
            edadDisplay.className = 'form-text text-danger mt-1';
        } else {
            edadTexto.textContent = 'Edad no realista (más de 120 años)';
            edadDisplay.style.display = 'block';
            edadDisplay.className = 'form-text text-danger mt-1';
        }
    } else {
        edadDisplay.style.display = 'none';
    }
}
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cesodo4\resources\views/personas/create.blade.php ENDPATH**/ ?>