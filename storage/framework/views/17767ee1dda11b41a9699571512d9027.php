<?php $__env->startSection('title', 'Crear Usuario'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-user-plus text-primary me-2"></i>
                        Crear Nuevo Usuario
                    </h1>
                    <p class="text-muted mb-0">Genera automáticamente credenciales basadas en información de personas y empleados</p>
                </div>
                <div>
                    <a href="<?php echo e(route('usuarios.index')); ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Volver
                    </a>
                </div>
            </div>

            <div class="row">
                <!-- Formulario principal -->
                <div class="col-lg-8">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-user-cog me-2"></i>
                                Información del Usuario
                            </h6>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="<?php echo e(route('usuarios.store')); ?>" id="userForm">
                                <?php echo csrf_field(); ?>

                                <!-- Método de creación -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <label class="form-label fw-bold">Método de Creación</label>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="metodo_creacion"
                                                           id="desde_persona" value="persona" checked>
                                                    <label class="form-check-label" for="desde_persona">
                                                        <i class="fas fa-id-card text-info me-2"></i>
                                                        Desde Persona
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="metodo_creacion"
                                                           id="desde_empleado" value="empleado">
                                                    <label class="form-check-label" for="desde_empleado">
                                                        <i class="fas fa-user-tie text-success me-2"></i>
                                                        Desde Empleado
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="metodo_creacion"
                                                           id="manual" value="manual">
                                                    <label class="form-check-label" for="manual">
                                                        <i class="fas fa-keyboard text-warning me-2"></i>
                                                        Manual
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Selección de Persona -->
                                <div id="persona_section" class="mb-4">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <label class="form-label">Seleccionar Persona</label>
                                            <select name="persona_id" id="persona_id" class="form-select">
                                                <option value="">Seleccione una persona...</option>
                                                <?php $__currentLoopData = $personas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $persona): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($persona->id); ?>"
                                                            data-nombre="<?php echo e($persona->nombre_completo); ?>"
                                                            data-email="<?php echo e($persona->email_sugerido); ?>"
                                                            data-dni="<?php echo e($persona->numero_documento); ?>"
                                                            data-telefono="<?php echo e($persona->celular); ?>">
                                                        <?php echo e($persona->nombre_completo); ?> - <?php echo e($persona->numero_documento); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">&nbsp;</label>
                                            <div class="d-grid">
                                                <button type="button" class="btn btn-info" onclick="cargarDatosPersona()">
                                                    <i class="fas fa-download me-2"></i>
                                                    Cargar Datos
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Selección de Empleado -->
                                <div id="empleado_section" class="mb-4" style="display: none;">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <label class="form-label">Seleccionar Empleado</label>
                                            <select name="trabajador_id" id="trabajador_id" class="form-select">
                                                <option value="">Seleccione un empleado...</option>
                                                <?php $__currentLoopData = $trabajadores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trabajador): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($trabajador->id); ?>"
                                                            data-codigo="<?php echo e($trabajador->codigo); ?>"
                                                            data-nombre="<?php echo e($trabajador->persona ? $trabajador->persona->nombre_completo : $trabajador->nombre_completo); ?>"
                                                            data-persona-id="<?php echo e($trabajador->persona_id); ?>">
                                                        <?php echo e($trabajador->codigo); ?> - <?php echo e($trabajador->persona ? $trabajador->persona->nombre_completo : $trabajador->nombre_completo); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">&nbsp;</label>
                                            <div class="d-grid">
                                                <button type="button" class="btn btn-success" onclick="cargarDatosEmpleado()">
                                                    <i class="fas fa-download me-2"></i>
                                                    Cargar Datos
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <!-- Datos del usuario -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Nombre Completo *</label>
                                            <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                   id="name" name="name" value="<?php echo e(old('name')); ?>" required>
                                            <?php $__errorArgs = ['name'];
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
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                   id="email" name="email" value="<?php echo e(old('email')); ?>">
                                            <div class="form-text">Si se deja vacío, se generará automáticamente</div>
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
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="dni" class="form-label">DNI</label>
                                            <input type="text" class="form-control" id="dni" name="dni"
                                                   value="<?php echo e(old('dni')); ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="telefono" class="form-label">Teléfono</label>
                                            <input type="text" class="form-control" id="telefono" name="telefono"
                                                   value="<?php echo e(old('telefono')); ?>" readonly>
                                        </div>
                                    </div>
                                </div>

                                <!-- Opciones de contraseña -->
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="generar_credenciales"
                                                       name="generar_credenciales" value="1" checked>
                                                <label class="form-check-label" for="generar_credenciales">
                                                    <i class="fas fa-key text-primary me-2"></i>
                                                    Generar contraseña automáticamente
                                                </label>
                                            </div>
                                            <div class="form-text">
                                                Se generará una contraseña temporal basada en las iniciales y DNI del usuario
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Roles -->
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Roles del Sistema</label>
                                            <div class="row">
                                                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rol): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="col-md-4 mb-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                   id="rol_<?php echo e($rol->id); ?>" name="roles[]" value="<?php echo e($rol->name); ?>">
                                                            <label class="form-check-label" for="rol_<?php echo e($rol->id); ?>">
                                                                <?php echo e(ucfirst($rol->name)); ?>

                                                            </label>
                                                        </div>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Observaciones -->
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="observaciones" class="form-label">Observaciones</label>
                                            <textarea class="form-control" id="observaciones" name="observaciones"
                                                      rows="3" placeholder="Notas adicionales sobre el usuario..."><?php echo e(old('observaciones')); ?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-2"></i>
                                            Crear Usuario
                                        </button>
                                        <a href="<?php echo e(route('usuarios.index')); ?>" class="btn btn-secondary ms-2">
                                            <i class="fas fa-times me-2"></i>
                                            Cancelar
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Panel de información -->
                <div class="col-lg-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-info-circle me-2"></i>
                                Información
                            </h6>
                        </div>
                        <div class="card-body">
                            <h6 class="text-primary">Generación Automática</h6>
                            <p class="text-muted small">
                                El sistema puede generar automáticamente:
                            </p>
                            <ul class="text-muted small">
                                <li><strong>Email:</strong> nombre.apellido@cesodo.com</li>
                                <li><strong>Contraseña:</strong> Iniciales + últimos 4 dígitos del DNI</li>
                                <li><strong>Usuario:</strong> Requiere cambio de contraseña al primer login</li>
                            </ul>

                            <hr>

                            <h6 class="text-success">Desde Empleado</h6>
                            <p class="text-muted small">
                                Automáticamente vincula la persona asociada al empleado y usa su código como referencia.
                            </p>

                            <hr>

                            <h6 class="text-info">Desde Persona</h6>
                            <p class="text-muted small">
                                Carga los datos personales directamente desde el registro de la persona.
                            </p>
                        </div>
                    </div>

                    <!-- Vista previa de credenciales -->
                    <div class="card shadow" id="preview_card" style="display: none;">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-success">
                                <i class="fas fa-eye me-2"></i>
                                Vista Previa
                            </h6>
                        </div>
                        <div class="card-body">
                            <div id="preview_content">
                                <!-- Se llenará con JavaScript -->
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
    // Cambio de método de creación
    document.querySelectorAll('input[name="metodo_creacion"]').forEach(radio => {
        radio.addEventListener('change', function() {
            toggleSections(this.value);
        });
    });

    // Eventos para generar vista previa
    document.getElementById('name').addEventListener('input', generarVistaPrevia);
    document.getElementById('email').addEventListener('input', generarVistaPrevia);
    document.getElementById('generar_credenciales').addEventListener('change', generarVistaPrevia);
});

function toggleSections(metodo) {
    const personaSection = document.getElementById('persona_section');
    const empleadoSection = document.getElementById('empleado_section');

    personaSection.style.display = metodo === 'persona' ? 'block' : 'none';
    empleadoSection.style.display = metodo === 'empleado' ? 'block' : 'none';

    if (metodo === 'manual') {
        limpiarFormulario();
    }
}

function cargarDatosPersona() {
    const personaSelect = document.getElementById('persona_id');
    const selectedOption = personaSelect.options[personaSelect.selectedIndex];

    if (selectedOption.value) {
        document.getElementById('name').value = selectedOption.dataset.nombre;
        document.getElementById('email').value = selectedOption.dataset.email;
        document.getElementById('dni').value = selectedOption.dataset.dni;
        document.getElementById('telefono').value = selectedOption.dataset.telefono;

        generarVistaPrevia();
    }
}

function cargarDatosEmpleado() {
    const trabajadorSelect = document.getElementById('trabajador_id');
    const selectedOption = trabajadorSelect.options[trabajadorSelect.selectedIndex];

    if (selectedOption.value) {
        // Cargar datos del empleado via AJAX
        fetch(`/usuarios/trabajador-data?trabajador_id=${selectedOption.value}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('name').value = data.nombre_completo;
                document.getElementById('email').value = data.email_sugerido || '';
                document.getElementById('dni').value = data.dni || '';
                document.getElementById('telefono').value = data.telefono || '';

                // Si el empleado tiene persona asociada, seleccionarla también
                if (data.persona_id) {
                    document.getElementById('persona_id').value = data.persona_id;
                }

                generarVistaPrevia();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al cargar datos del empleado');
            });
    }
}

function limpiarFormulario() {
    document.getElementById('name').value = '';
    document.getElementById('email').value = '';
    document.getElementById('dni').value = '';
    document.getElementById('telefono').value = '';
    document.getElementById('persona_id').value = '';
    document.getElementById('trabajador_id').value = '';

    document.getElementById('preview_card').style.display = 'none';
}

function generarVistaPrevia() {
    const nombre = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const dni = document.getElementById('dni').value;
    const generarCredenciales = document.getElementById('generar_credenciales').checked;

    if (nombre) {
        let emailFinal = email;
        let passwordFinal = '';

        // Generar email si no se proporciona
        if (!email && nombre) {
            const partes = nombre.toLowerCase().split(' ');
            if (partes.length >= 2) {
                emailFinal = `${partes[0]}.${partes[1]}@cesodo.com`;
            }
        }

        // Generar contraseña si está marcado
        if (generarCredenciales && nombre && dni) {
            const iniciales = nombre.split(' ').map(n => n.charAt(0).toUpperCase()).join('');
            const ultimosDigitos = dni.slice(-4);
            passwordFinal = iniciales + ultimosDigitos;
        }

        const previewContent = `
            <div class="mb-2">
                <strong>Nombre:</strong><br>
                <span class="text-muted">${nombre}</span>
            </div>
            <div class="mb-2">
                <strong>Email:</strong><br>
                <span class="text-muted">${emailFinal || 'No generado'}</span>
            </div>
            ${passwordFinal ? `
            <div class="mb-2">
                <strong>Contraseña temporal:</strong><br>
                <span class="badge bg-warning text-dark">${passwordFinal}</span>
            </div>
            ` : ''}
            <div class="mt-3">
                <small class="text-info">
                    <i class="fas fa-info-circle me-1"></i>
                    El usuario deberá cambiar la contraseña en su primer acceso
                </small>
            </div>
        `;

        document.getElementById('preview_content').innerHTML = previewContent;
        document.getElementById('preview_card').style.display = 'block';
    } else {
        document.getElementById('preview_card').style.display = 'none';
    }
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cesodo4\resources\views/usuarios/create.blade.php ENDPATH**/ ?>