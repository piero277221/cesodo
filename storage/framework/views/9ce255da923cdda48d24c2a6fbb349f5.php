<?php $__env->startSection('title', 'Nuevo Trabajador'); ?>

<?php $__env->startSection('content'); ?>
<style>
/* ELIMINAR COMPLETAMENTE TODOS LOS EFECTOS DE BLUR Y TRANSICIONES */

/* Eliminar todos los efectos de blur, transiciones y sombras en inputs */
.form-control,
.form-select,
.input-group-text,
.btn,
input,
textarea,
select,
.card,
.card-body,
.card-header,
.container-fluid,
.row,
.col-lg-6,
.col-md-6,
.mb-3,
.mb-4,
div,
span,
label {
    filter: none !important;
    backdrop-filter: none !important;
    transition: none !important;
    box-shadow: none !important;
    -webkit-transition: none !important;
    -moz-transition: none !important;
    -o-transition: none !important;
    -ms-transition: none !important;
    -webkit-filter: none !important;
    -moz-filter: none !important;
    -o-filter: none !important;
    -ms-filter: none !important;
    -webkit-backdrop-filter: none !important;
    -moz-backdrop-filter: none !important;
    -o-backdrop-filter: none !important;
    -ms-backdrop-filter: none !important;
}

/* Eliminar efectos en focus y hover */
.form-control:focus,
.form-control:hover,
.form-select:focus,
.form-select:hover,
input:focus,
input:hover,
textarea:focus,
textarea:hover,
select:focus,
select:hover,
.btn:focus,
.btn:hover,
.card:hover,
.card:focus {
    filter: none !important;
    backdrop-filter: none !important;
    transition: none !important;
    box-shadow: none !important;
    -webkit-box-shadow: none !important;
    -moz-box-shadow: none !important;
    transform: none !important;
    -webkit-transform: none !important;
    -moz-transform: none !important;
    -webkit-filter: none !important;
    -moz-filter: none !important;
    -o-filter: none !important;
    -ms-filter: none !important;
    -webkit-backdrop-filter: none !important;
    -moz-backdrop-filter: none !important;
    -o-backdrop-filter: none !important;
    -ms-backdrop-filter: none !important;
}

/* Eliminar efectos en active */
.form-control:active,
.form-select:active,
input:active,
textarea:active,
select:active,
.btn:active {
    filter: none !important;
    backdrop-filter: none !important;
    transition: none !important;
    box-shadow: none !important;
    transform: none !important;
    -webkit-filter: none !important;
    -moz-filter: none !important;
    -o-filter: none !important;
    -ms-filter: none !important;
    -webkit-backdrop-filter: none !important;
    -moz-backdrop-filter: none !important;
    -o-backdrop-filter: none !important;
    -ms-backdrop-filter: none !important;
}

/* Estilos para campos readonly/disabled */
.readonly-field,
.readonly-field:focus,
.readonly-field:hover {
    background-color: #f8f9fa !important;
    color: #6c757d !important;
    border-color: #dee2e6 !important;
    cursor: not-allowed !important;
}

.readonly-field:disabled {
    opacity: 0.8 !important;
}

/* Estado editable resaltado */
#estado {
    border: 2px solid #28a745 !important;
    background-color: #f8fff9 !important;
}

#estado:focus {
    border-color: #198754 !important;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25) !important;
}

/* Eliminar efectos globales que puedan interferir */
* {
    filter: none !important;
    backdrop-filter: none !important;
    -webkit-filter: none !important;
    -moz-filter: none !important;
    -o-filter: none !important;
    -ms-filter: none !important;
    -webkit-backdrop-filter: none !important;
    -moz-backdrop-filter: none !important;
    -o-backdrop-filter: none !important;
    -ms-backdrop-filter: none !important;
}

/* Eliminar específicamente las clases de modern-styles.css */
.transition-modern,
.card.transition-modern,
.btn.transition-modern {
    transition: none !important;
    -webkit-transition: none !important;
    -moz-transition: none !important;
    -o-transition: none !important;
    -ms-transition: none !important;
}

/* Eliminar variables CSS que causen efectos */
:root {
    --transition-modern: none !important;
}

/* Mantener solo el borde de Bootstrap para focus SIN efectos */
.form-control:focus {
    border-color: #86b7fe !important;
    outline: 0 !important;
    box-shadow: none !important;
    filter: none !important;
    backdrop-filter: none !important;
}

/* Eliminar cualquier efecto de sombra en las cards */
.card {
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;
}

.card.shadow-sm {
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;
}
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">
                    <i class="fas fa-user-plus text-success me-2"></i>
                    Nuevo Trabajador
                </h2>
                <a href="<?php echo e(route('trabajadores.index')); ?>" class="btn btn-secondary">
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

            <!-- Alerta informativa sobre el sistema de personas -->
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <h6><i class="fas fa-info-circle me-2"></i>Sistema Integrado de Personas</h6>
                <p class="mb-2">
                    <strong>¿Cómo funciona?</strong>
                    <br>1. Ingresa el DNI de la persona en el campo correspondiente
                    <br>2. Haz clic en el botón de búsqueda <i class="fas fa-search"></i> o presiona Enter
                    <br>3. Si la persona ya está registrada, sus datos se cargarán automáticamente
                    <br>4. Si no existe, podrás registrar los datos manualmente
                </p>
                <small class="text-muted">
                    <i class="fas fa-lightbulb"></i>
                    <strong>Consejo:</strong> Registra primero a las personas en el módulo "Personas" para aprovechar esta funcionalidad.
                </small>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>

            <form action="<?php echo e(route('trabajadores.store')); ?>" method="POST" id="createTrabajadorForm" onsubmit="validarAntesDeEnviar(event)">
                <?php echo csrf_field(); ?>

                <div class="row">
                    <!-- Información Personal -->
                    <div class="col-lg-6 mb-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-header bg-primary text-white">
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
                                        <label for="dni" class="form-label">DNI <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text"
                                                   class="form-control <?php $__errorArgs = ['dni'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                   id="dni"
                                                   name="dni"
                                                   value="<?php echo e(old('dni')); ?>"
                                                   maxlength="8"
                                                   pattern="[0-9]{8}"
                                                   placeholder="Ingrese DNI"
                                                   required>
                                            <button type="button" class="btn btn-outline-primary" id="buscarPersonaBtn">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                        <div id="personaStatus" class="mt-1"></div>
                                        <?php $__errorArgs = ['dni'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        <small class="text-muted">Ingrese el DNI y presione el botón de búsqueda para autocompletar datos</small>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="telefono" class="form-label">Teléfono</label>
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
                                               value="<?php echo e(old('telefono')); ?>">
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
                                </div>

                                <!-- Campo oculto para almacenar el ID de la persona -->
                                <input type="hidden" id="persona_id" name="persona_id" value="<?php echo e(old('persona_id')); ?>">

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
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
                                           value="<?php echo e(old('email')); ?>">
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
                                              rows="3"><?php echo e(old('direccion')); ?></textarea>
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

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                                        <div class="input-group">
                                            <input type="date"
                                                   class="form-control <?php $__errorArgs = ['fecha_nacimiento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                   id="fecha_nacimiento"
                                                   name="fecha_nacimiento"
                                                   value="<?php echo e(old('fecha_nacimiento')); ?>">
                                            <span class="input-group-text" id="edadDisplay" style="display: none;">
                                                <i class="fas fa-birthday-cake me-1"></i>
                                                <span id="edadTexto"></span>
                                            </span>
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
                                            <option value="">Seleccionar...</option>
                                            <option value="Masculino" <?php echo e(old('sexo') == 'Masculino' ? 'selected' : ''); ?>>Masculino</option>
                                            <option value="Femenino" <?php echo e(old('sexo') == 'Femenino' ? 'selected' : ''); ?>>Femenino</option>
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
                            </div>
                        </div>
                    </div>

                    <!-- Información Laboral -->
                    <div class="col-lg-6 mb-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-briefcase me-2"></i>
                                    Información Laboral
                                </h5>
                                <small class="text-white-50">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Campos auto-completados desde contrato (solo Estado editable)
                                </small>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="codigo" class="form-label">Código <span class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control <?php $__errorArgs = ['codigo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> readonly-field"
                                           id="codigo"
                                           name="codigo"
                                           value="<?php echo e(old('codigo')); ?>"
                                           required>
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
                                </div>

                                <div class="mb-3">
                                    <label for="area" class="form-label">Área <span class="text-danger">*</span></label>
                                    <select class="form-select <?php $__errorArgs = ['area'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> readonly-field"
                                            id="area"
                                            name="area"
                                            required>
                                        <option value="">Seleccionar área...</option>
                                        <option value="Administración" <?php echo e(old('area') == 'Administración' ? 'selected' : ''); ?>>Administración</option>
                                        <option value="Recursos Humanos" <?php echo e(old('area') == 'Recursos Humanos' ? 'selected' : ''); ?>>Recursos Humanos</option>
                                        <option value="Finanzas" <?php echo e(old('area') == 'Finanzas' ? 'selected' : ''); ?>>Finanzas</option>
                                        <option value="Operaciones" <?php echo e(old('area') == 'Operaciones' ? 'selected' : ''); ?>>Operaciones</option>
                                        <option value="Ventas" <?php echo e(old('area') == 'Ventas' ? 'selected' : ''); ?>>Ventas</option>
                                        <option value="Marketing" <?php echo e(old('area') == 'Marketing' ? 'selected' : ''); ?>>Marketing</option>
                                        <option value="Tecnología" <?php echo e(old('area') == 'Tecnología' ? 'selected' : ''); ?>>Tecnología</option>
                                        <option value="Logística" <?php echo e(old('area') == 'Logística' ? 'selected' : ''); ?>>Logística</option>
                                        <option value="Calidad" <?php echo e(old('area') == 'Calidad' ? 'selected' : ''); ?>>Calidad</option>
                                        <option value="Seguridad" <?php echo e(old('area') == 'Seguridad' ? 'selected' : ''); ?>>Seguridad</option>
                                    </select>
                                    <?php $__errorArgs = ['area'];
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

                                <div class="mb-3">
                                    <label for="cargo" class="form-label">Cargo <span class="text-danger">*</span></label>
                                    <select class="form-select <?php $__errorArgs = ['cargo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> readonly-field"
                                            id="cargo"
                                            name="cargo"
                                            required>
                                        <option value="">Seleccionar cargo...</option>
                                        <option value="Gerente" <?php echo e(old('cargo') == 'Gerente' ? 'selected' : ''); ?>>Gerente</option>
                                        <option value="Jefe de Área" <?php echo e(old('cargo') == 'Jefe de Área' ? 'selected' : ''); ?>>Jefe de Área</option>
                                        <option value="Supervisor" <?php echo e(old('cargo') == 'Supervisor' ? 'selected' : ''); ?>>Supervisor</option>
                                        <option value="Analista" <?php echo e(old('cargo') == 'Analista' ? 'selected' : ''); ?>>Analista</option>
                                        <option value="Asistente" <?php echo e(old('cargo') == 'Asistente' ? 'selected' : ''); ?>>Asistente</option>
                                        <option value="Operario" <?php echo e(old('cargo') == 'Operario' ? 'selected' : ''); ?>>Operario</option>
                                        <option value="Técnico" <?php echo e(old('cargo') == 'Técnico' ? 'selected' : ''); ?>>Técnico</option>
                                        <option value="Especialista" <?php echo e(old('cargo') == 'Especialista' ? 'selected' : ''); ?>>Especialista</option>
                                        <option value="Coordinador" <?php echo e(old('cargo') == 'Coordinador' ? 'selected' : ''); ?>>Coordinador</option>
                                        <option value="Auxiliar" <?php echo e(old('cargo') == 'Auxiliar' ? 'selected' : ''); ?>>Auxiliar</option>
                                    </select>
                                    <?php $__errorArgs = ['cargo'];
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

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="fecha_ingreso" class="form-label">Fecha de Ingreso <span class="text-danger">*</span></label>
                                        <input type="date"
                                               class="form-control <?php $__errorArgs = ['fecha_ingreso'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> readonly-field"
                                               id="fecha_ingreso"
                                               name="fecha_ingreso"
                                               value="<?php echo e(old('fecha_ingreso', date('Y-m-d'))); ?>"
                                               readonly
                                               required>
                                        <?php $__errorArgs = ['fecha_ingreso'];
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
                                        <label for="salario" class="form-label">Salario</label>
                                        <div class="input-group">
                                            <span class="input-group-text">S/</span>
                                            <input type="number"
                                                   class="form-control <?php $__errorArgs = ['salario'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> readonly-field"
                                                   id="salario"
                                                   name="salario"
                                                   value="<?php echo e(old('salario')); ?>"
                                                   step="0.01"
                                                   min="0"
                                                   readonly>
                                        </div>
                                        <?php $__errorArgs = ['salario'];
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
                                    <label for="estado" class="form-label">
                                        Estado <span class="text-danger">*</span>
                                        <small class="badge bg-warning ms-2">
                                            <i class="fas fa-edit"></i> EDITABLE
                                        </small>
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
                                        <option value="Activo" <?php echo e(old('estado', 'Activo') == 'Activo' ? 'selected' : ''); ?>>Activo</option>
                                        <option value="Inactivo" <?php echo e(old('estado') == 'Inactivo' ? 'selected' : ''); ?>>Inactivo</option>
                                        <option value="Suspendido" <?php echo e(old('estado') == 'Suspendido' ? 'selected' : ''); ?>>Suspendido</option>
                                        <option value="Vacaciones" <?php echo e(old('estado') == 'Vacaciones' ? 'selected' : ''); ?>>Vacaciones</option>
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

                                <div class="mb-3">
                                    <label for="observaciones" class="form-label">Observaciones</label>
                                    <textarea class="form-control <?php $__errorArgs = ['observaciones'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                              id="observaciones"
                                              name="observaciones"
                                              rows="4"
                                              placeholder="Información adicional..."><?php echo e(old('observaciones')); ?></textarea>
                                    <?php $__errorArgs = ['observaciones'];
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

                <!-- Información del Contrato (se muestra automáticamente cuando se encuentra la persona) -->
                <div class="row" id="contratoInfo" style="display: none;">
                    <div class="col-12 mb-4">
                        <div class="card shadow-sm border-info">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-file-contract me-2"></i>
                                    Información del Contrato Asociado
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-info" role="alert">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Contrato encontrado:</strong> La información laboral se llenará automáticamente basada en el contrato activo de esta persona.
                                </div>

                                <div class="row" id="contratoDetalles">
                                    <!-- Los detalles del contrato se cargarán aquí dinámicamente -->
                                </div>

                                <div class="text-center mt-3">
                                    <button type="button" class="btn btn-outline-info btn-sm" id="verContratoBtn" style="display: none;">
                                        <i class="fas fa-eye me-1"></i>
                                        Ver Contrato Completo
                                    </button>
                                    <button type="button" class="btn btn-outline-success btn-sm ms-2" id="descargarContratoBtn" style="display: none;">
                                        <i class="fas fa-download me-1"></i>
                                        Descargar PDF
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-body text-center">
                                <button type="submit" class="btn btn-success btn-lg me-3">
                                    <i class="fas fa-save me-2"></i>
                                    Guardar Trabajador
                                </button>
                                <a href="<?php echo e(route('trabajadores.index')); ?>" class="btn btn-secondary btn-lg">
                                    <i class="fas fa-times me-2"></i>
                                    Cancelar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Definir las URLs base para JavaScript
window.AppConfig = {
    baseUrl: '<?php echo e(url('/')); ?>',
    apiUrl: '<?php echo e(url('/api')); ?>'
};

document.addEventListener('DOMContentLoaded', function() {
    // Elementos del DOM
    const dniInput = document.getElementById('dni');
    const telefonoInput = document.getElementById('telefono');
    const salarioInput = document.getElementById('salario');
    const areaSelect = document.getElementById('area');
    const cargoSelect = document.getElementById('cargo');
    const codigoInput = document.getElementById('codigo');
    const buscarPersonaBtn = document.getElementById('buscarPersonaBtn');
    const personaStatus = document.getElementById('personaStatus');

    function generarCodigo() {
        const area = areaSelect.value;
        const cargo = cargoSelect.value;

        if (area && cargo) {
            const areaCode = area.substring(0, 3).toUpperCase();
            const cargoCode = cargo.substring(0, 3).toUpperCase();
            const randomNum = Math.floor(Math.random() * 1000).toString().padStart(3, '0');

            codigoInput.value = areaCode + '-' + cargoCode + '-' + randomNum;
        }
    }

    // Función para buscar persona por documento (dentro del DOMContentLoaded)
    async function buscarPersonaPorDocumento(documento) {
        console.log('=== INICIO BÚSQUEDA PERSONA ===');
        console.log('Documento a buscar:', documento);

        if (!documento || documento.length !== 8) {
            console.warn('Documento inválido:', documento);
            personaStatus.innerHTML = '<small class="text-warning"><i class="fas fa-exclamation-triangle"></i> Ingrese un DNI válido de 8 dígitos</small>';
            return;
        }

        try {
            buscarPersonaBtn.disabled = true;
            buscarPersonaBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            personaStatus.innerHTML = '<small class="text-info"><i class="fas fa-search"></i> Buscando persona...</small>';

            const url = `<?php echo e(route('trabajadores.buscar-persona-documento')); ?>?documento=${documento}`;
            console.log('URL de búsqueda:', url);

            const response = await fetch(url, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            console.log('Response status:', response.status);
            console.log('Response ok:', response.ok);

            // Obtener el texto de la respuesta primero
            const responseText = await response.text();
            console.log('Response text:', responseText);

            if (!response.ok) {
                console.error('Response no ok:', response.status, response.statusText);
                throw new Error(`HTTP ${response.status}: ${response.statusText} - ${responseText}`);
            }

            // Intentar parsear como JSON
            let data;
            try {
                data = JSON.parse(responseText);
            } catch (jsonError) {
                console.error('Error parsing JSON:', jsonError);
                console.error('Response text:', responseText);
                throw new Error('Respuesta del servidor no es JSON válido: ' + responseText.substring(0, 100) + '...');
            }

            console.log('Datos recibidos:', data);

            if (data.success && data.persona) {
                console.log('Persona encontrada:', data.persona);
                // Llenar campos con información de la persona
                llenarCamposPersona(data.persona);

                // Mostrar información del contrato si existe
                if (data.contrato_activo) {
                    console.log('Contrato activo encontrado:', data.contrato_activo);
                    mostrarInformacionContrato(data.contrato_activo);
                }

                personaStatus.innerHTML = `<small class="text-success"><i class="fas fa-check-circle"></i> Persona encontrada${data.contrato_activo ? ' (con contrato activo)' : ''}</small>`;

            } else {
                console.warn('Búsqueda sin éxito:', data);
                personaStatus.innerHTML = `<small class="text-danger"><i class="fas fa-times-circle"></i> ${data.message}</small>`;
                limpiarCampos();
            }

        } catch (error) {
            console.error('Error completo:', error);
            console.error('Error message:', error.message);
            console.error('Error stack:', error.stack);
            personaStatus.innerHTML = `<small class="text-danger"><i class="fas fa-times-circle"></i> Error al buscar la persona: ${error.message}</small>`;
            limpiarCampos();
        } finally {
            buscarPersonaBtn.disabled = false;
            buscarPersonaBtn.innerHTML = '<i class="fas fa-search"></i>';
            console.log('=== FIN BÚSQUEDA PERSONA ===');
        }
    }

    // Event listeners

    // Búsqueda de persona
    buscarPersonaBtn.addEventListener('click', function() {
        const dni = dniInput.value.trim();
        buscarPersonaPorDocumento(dni);
    });

    // Validación del DNI y búsqueda automática
    dniInput.addEventListener('input', function() {
        // Solo permitir números
        this.value = this.value.replace(/[^0-9]/g, '');
        if (this.value.length > 8) {
            this.value = this.value.slice(0, 8);
        }

        // Limpiar campos si se cambia el DNI
        if (this.value.length !== 8) {
            limpiarCampos();
            personaStatus.innerHTML = '';
        }
    });

    dniInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            const dni = this.value.trim();
            buscarPersonaPorDocumento(dni);
        }
    });

    // Validación del teléfono
    telefonoInput.addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9+\-\s()]/g, '');
    });

    // Validación del salario
    if (salarioInput) {
        salarioInput.addEventListener('input', function() {
            if (this.value < 0) {
                this.value = 0;
            }
        });
    }

    // Auto-generar código
    areaSelect.addEventListener('change', generarCodigo);
    cargoSelect.addEventListener('change', generarCodigo);

    // Calcular edad cuando se cambie la fecha de nacimiento manualmente
    const fechaNacimientoInput = document.getElementById('fecha_nacimiento');
    if (fechaNacimientoInput) {
        fechaNacimientoInput.addEventListener('change', function() {
            calcularYMostrarEdad(this.value);
        });
    }

    // Validación del formulario antes de enviar
    document.getElementById('createTrabajadorForm').addEventListener('submit', function(e) {
        const requiredFields = this.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });

        if (!isValid) {
            e.preventDefault();
            alert('Por favor, complete todos los campos obligatorios.');
        }
    });
});
</script>

<script>
// ============= FUNCIONES GLOBALES =============

// Función para llenar campos de la persona
function llenarCamposPersona(persona) {
    try {
        console.log('=== LLENANDO CAMPOS PERSONA ===');
        console.log('Datos de la persona:', persona);
        
        document.getElementById('nombres').value = persona.nombres || '';
        document.getElementById('apellidos').value = persona.apellidos || '';
        document.getElementById('telefono').value = persona.celular || '';
        document.getElementById('email').value = persona.correo || '';
        document.getElementById('direccion').value = persona.direccion || '';

        // Llenar fecha de nacimiento y calcular edad
        if (persona.fecha_nacimiento) {
            // Convertir fecha ISO a formato YYYY-MM-DD para input date
            let fechaFormateada = persona.fecha_nacimiento;
            if (fechaFormateada.includes('T')) {
                fechaFormateada = fechaFormateada.split('T')[0];
            }

            document.getElementById('fecha_nacimiento').value = fechaFormateada;
            calcularYMostrarEdad(fechaFormateada);
        }

        document.getElementById('persona_id').value = persona.id;

        // Mapear el sexo de la base de datos (M, F, O) al formato del select (Masculino, Femenino)
        if (persona.sexo) {
            console.log('Sexo recibido de la BD:', persona.sexo);
            const sexoSelect = document.getElementById('sexo');
            let sexoMapeado = '';
            
            // Convertir de formato BD a formato del select
            if (persona.sexo === 'M' || persona.sexo === 'Masculino') {
                sexoMapeado = 'Masculino';
            } else if (persona.sexo === 'F' || persona.sexo === 'Femenino') {
                sexoMapeado = 'Femenino';
            } else {
                sexoMapeado = persona.sexo; // Por si viene en otro formato
            }
            
            console.log('Sexo mapeado para el select:', sexoMapeado);
            sexoSelect.value = sexoMapeado;
            console.log('Valor del select después de asignar:', sexoSelect.value);
        }

        // Deshabilitar campos que vienen de la persona
        const camposPersona = ['nombres', 'apellidos', 'telefono', 'email', 'direccion', 'fecha_nacimiento'];
        camposPersona.forEach(campo => {
            const elemento = document.getElementById(campo);
            if (elemento) {
                elemento.readOnly = true;
                elemento.classList.add('bg-light');
                elemento.setAttribute('title', 'Campo cargado automáticamente desde el registro de la persona');
            }
        });
        
        // Para el select de sexo, usamos disabled en lugar de readOnly
        const sexoSelect = document.getElementById('sexo');
        if (sexoSelect && persona.sexo) {
            sexoSelect.disabled = true;
            sexoSelect.classList.add('bg-light');
            sexoSelect.setAttribute('title', 'Campo cargado automáticamente desde el registro de la persona');
            // Crear un campo hidden para enviar el valor
            let hiddenSexo = document.getElementById('sexo_hidden');
            if (!hiddenSexo) {
                hiddenSexo = document.createElement('input');
                hiddenSexo.type = 'hidden';
                hiddenSexo.id = 'sexo_hidden';
                hiddenSexo.name = 'sexo';
                sexoSelect.parentNode.appendChild(hiddenSexo);
            }
            hiddenSexo.value = sexoSelect.value;
            sexoSelect.removeAttribute('name'); // Quitar name del select para que no se envíe
        }
        
        console.log('=== FIN LLENADO CAMPOS PERSONA ===');
    } catch (error) {
        console.error('Error al llenar campos:', error);
        throw error; // Re-lanzar para que sea capturado por el catch principal
    }
}

// Función para calcular y mostrar la edad
function calcularYMostrarEdad(fechaNacimiento) {
    try {
        if (!fechaNacimiento) {
            document.getElementById('edadDisplay').style.display = 'none';
            return;
        }

        const hoy = new Date();
        const nacimiento = new Date(fechaNacimiento);

        // Verificar que la fecha es válida
        if (isNaN(nacimiento.getTime())) {
            console.warn('Fecha de nacimiento inválida:', fechaNacimiento);
            document.getElementById('edadDisplay').style.display = 'none';
            return;
        }

        let edad = hoy.getFullYear() - nacimiento.getFullYear();
        const mesActual = hoy.getMonth();
        const mesNacimiento = nacimiento.getMonth();

        // Ajustar la edad si aún no cumplió años este año
        if (mesActual < mesNacimiento || (mesActual === mesNacimiento && hoy.getDate() < nacimiento.getDate())) {
            edad--;
        }

        document.getElementById('edadTexto').textContent = `${edad} años`;
        document.getElementById('edadDisplay').style.display = 'inline-flex';
    } catch (error) {
        console.error('Error al calcular edad:', error);
        document.getElementById('edadDisplay').style.display = 'none';
    }
}

// Variable global para el contrato actual
let contratoActual = null;

// Función para mostrar información del contrato
function mostrarInformacionContrato(contrato) {
    console.log('=== MOSTRANDO INFORMACIÓN DEL CONTRATO ===');
    console.log('Contrato recibido:', contrato);

    contratoActual = contrato;
    const contratoInfo = document.getElementById('contratoInfo');
    const verContratoBtn = document.getElementById('verContratoBtn');
    const descargarContratoBtn = document.getElementById('descargarContratoBtn');

    if (!contratoInfo) {
        console.error('Elemento contratoInfo no encontrado');
        return;
    }

    // Mostrar información básica del contrato
    contratoInfo.innerHTML = `
        <div class="alert alert-success">
            <h6><i class="fas fa-file-contract"></i> Contrato Activo Encontrado</h6>
            <p class="mb-1"><strong>Número:</strong> ${contrato.numero_contrato || 'N/A'}</p>
            <p class="mb-1"><strong>Cargo:</strong> ${contrato.cargo || 'N/A'}</p>
            <p class="mb-1"><strong>Área:</strong> ${contrato.area_departamento || contrato.departamento || 'N/A'}</p>
            <p class="mb-0"><strong>Salario:</strong> S/ ${contrato.salario_base || 'N/A'}</p>
        </div>
    `;
    contratoInfo.style.display = 'block';

    // Auto-completar campos laborales inmediatamente
    console.log('Llenando campos laborales...');

    // Llenar área
    if (contrato.area_departamento || contrato.departamento) {
        const areaValue = contrato.area_departamento || contrato.departamento;
        console.log('Área del contrato:', areaValue);

        const areaSelect = document.getElementById('area');
        let opcionEncontrada = false;

        // Buscar si existe la opción
        Array.from(areaSelect.options).forEach(opt => {
            if (opt.value.toLowerCase() === areaValue.toLowerCase()) {
                areaSelect.value = opt.value;
                opcionEncontrada = true;
                console.log('Área encontrada en opciones:', opt.value);
            }
        });

        // Si no existe, crear la opción dinámicamente
        if (!opcionEncontrada && areaValue) {
            console.log('Creando nueva opción para área:', areaValue);
            const nuevaOpcion = document.createElement('option');
            nuevaOpcion.value = areaValue;
            nuevaOpcion.textContent = areaValue;
            nuevaOpcion.selected = true;
            areaSelect.appendChild(nuevaOpcion);
        }

        areaSelect.style.backgroundColor = '#f8f9fa';
        areaSelect.style.cursor = 'not-allowed';
        areaSelect.setAttribute('title', 'Campo completado automáticamente desde el contrato activo');

        // Prevenir cambios accidentales
        areaSelect.addEventListener('mousedown', (e) => {
            e.preventDefault();
            alert('Este campo fue completado automáticamente desde el contrato. No se puede modificar.');
        });
    }

    // Llenar cargo
    if (contrato.cargo) {
        console.log('Cargo del contrato:', contrato.cargo);

        const cargoSelect = document.getElementById('cargo');
        let opcionEncontrada = false;

        // Buscar si existe la opción
        Array.from(cargoSelect.options).forEach(opt => {
            if (opt.value.toLowerCase() === contrato.cargo.toLowerCase()) {
                cargoSelect.value = opt.value;
                opcionEncontrada = true;
                console.log('Cargo encontrado en opciones:', opt.value);
            }
        });

        // Si no existe, crear la opción dinámicamente
        if (!opcionEncontrada) {
            console.log('Creando nueva opción para cargo:', contrato.cargo);
            const nuevaOpcion = document.createElement('option');
            nuevaOpcion.value = contrato.cargo;
            nuevaOpcion.textContent = contrato.cargo;
            nuevaOpcion.selected = true;
            cargoSelect.appendChild(nuevaOpcion);
        }

        cargoSelect.style.backgroundColor = '#f8f9fa';
        cargoSelect.style.cursor = 'not-allowed';
        cargoSelect.setAttribute('title', 'Campo completado automáticamente desde el contrato activo');

        // Prevenir cambios accidentales
        cargoSelect.addEventListener('mousedown', (e) => {
            e.preventDefault();
            alert('Este campo fue completado automáticamente desde el contrato. No se puede modificar.');
        });
    }

    // Llenar fecha de ingreso
    if (contrato.fecha_inicio) {
        let fechaFormateada = contrato.fecha_inicio;
        if (fechaFormateada.includes('T')) {
            fechaFormateada = fechaFormateada.split('T')[0];
        }

        const fechaIngresoInput = document.getElementById('fecha_ingreso');
        fechaIngresoInput.value = fechaFormateada;
        fechaIngresoInput.style.backgroundColor = '#f8f9fa';
        fechaIngresoInput.setAttribute('title', 'Campo completado automáticamente desde el contrato activo');
        console.log('Fecha de ingreso completada:', fechaFormateada);
    }

    // Llenar salario
    if (contrato.salario_base) {
        const salarioInput = document.getElementById('salario');
        salarioInput.value = contrato.salario_base;
        salarioInput.style.backgroundColor = '#f8f9fa';
        salarioInput.setAttribute('title', 'Campo completado automáticamente desde el contrato activo');
        console.log('Salario completado:', contrato.salario_base);
    }

    // Llenar estado
    if (contrato.estado) {
        const estadoSelect = document.getElementById('estado');
        // Mapear estado del contrato a estado del trabajador
        const mapeoEstados = {
            'activo': 'Activo',
            'finalizado': 'Inactivo',
            'suspendido': 'Suspendido'
        };

        const estadoTrabajador = mapeoEstados[contrato.estado.toLowerCase()] || 'Activo';
        estadoSelect.value = estadoTrabajador;
        estadoSelect.style.backgroundColor = '#f8f9fa';
        estadoSelect.setAttribute('title', 'Campo completado automáticamente desde el contrato activo');
        console.log('Estado completado:', estadoTrabajador);
    }

    // Generar código después de un pequeño delay para asegurar que área y cargo estén cargados
    setTimeout(() => {
        console.log('=== GENERANDO CÓDIGO ===');
        const areaValue = document.getElementById('area').value;
        const cargoValue = document.getElementById('cargo').value;

        console.log('Área para código:', areaValue);
        console.log('Cargo para código:', cargoValue);

        if (areaValue && cargoValue) {
            const areaCode = areaValue.substring(0, 2).toUpperCase();
            const cargoCode = cargoValue.substring(0, 2).toUpperCase();
            const randomNum = Math.floor(Math.random() * 100).toString().padStart(2, '0');
            const codigoGenerado = areaCode + cargoCode + randomNum;

            const codigoInput = document.getElementById('codigo');
            codigoInput.value = codigoGenerado;
            codigoInput.style.backgroundColor = '#f8f9fa';
            codigoInput.style.cursor = 'not-allowed';
            codigoInput.setAttribute('title', 'Código generado automáticamente desde el contrato activo');

            // Prevenir cambios accidentales
            codigoInput.addEventListener('keydown', (e) => {
                e.preventDefault();
                alert('Este código fue generado automáticamente. No se puede modificar.');
            });
            codigoInput.addEventListener('paste', (e) => {
                e.preventDefault();
                alert('Este código fue generado automáticamente. No se puede modificar.');
            });

            console.log('Código generado:', codigoGenerado);
        } else {
            console.log('No se puede generar código - Área:', areaValue, 'Cargo:', cargoValue);

            // Si no hay área o cargo, generar código basado en información disponible
            if (contrato.numero_contrato) {
                const codigoInput = document.getElementById('codigo');
                const codigoBasico = 'EMP' + contrato.numero_contrato.replace(/[^0-9]/g, '').substring(0,4);
                codigoInput.value = codigoBasico;
                codigoInput.style.backgroundColor = '#f8f9fa';
                codigoInput.style.cursor = 'not-allowed';
                codigoInput.setAttribute('title', 'Código generado automáticamente desde el número de contrato');

                // Prevenir cambios accidentales
                codigoInput.addEventListener('keydown', (e) => {
                    e.preventDefault();
                    alert('Este código fue generado automáticamente. No se puede modificar.');
                });
                codigoInput.addEventListener('paste', (e) => {
                    e.preventDefault();
                    alert('Este código fue generado automáticamente. No se puede modificar.');
                });

                console.log('Código básico generado:', codigoBasico);
            }
        }
        console.log('=== FIN DEL SEGUNDO TIMER ===');
    }, 300);

    // Agregar indicador visual de que los campos fueron llenados automáticamente (después de un delay mayor)
    setTimeout(() => {
        console.log('Agregando badges AUTO...');
        const camposLaborales = ['codigo', 'cargo', 'area', 'salario', 'fecha_ingreso', 'estado'];
        camposLaborales.forEach(campo => {
            const elemento = document.getElementById(campo);
            console.log(`Verificando campo ${campo}:`, elemento?.value, 'backgroundColor:', elemento?.style.backgroundColor);

            if (elemento && (elemento.style.backgroundColor === 'rgb(248, 249, 250)' || elemento.value)) {
                // Para los campos que tienen valor pero no necesariamente el fondo (como código generado)
                if (campo === 'codigo' && elemento.value && !elemento.style.backgroundColor) {
                    elemento.style.backgroundColor = '#f8f9fa';
                    elemento.setAttribute('title', 'Código generado automáticamente');
                }

                const label = elemento.closest('.mb-3').querySelector('label');
                if (label && !label.querySelector('.auto-filled-badge')) {
                    const badge = document.createElement('small');
                    badge.className = 'auto-filled-badge badge bg-info ms-2';
                    badge.textContent = 'AUTO';
                    badge.title = 'Campo completado automáticamente desde el contrato';
                    label.appendChild(badge);
                    console.log('Badge AUTO agregado para:', campo);
                }
            }
        });
    }, 500);

    // Función de respaldo final para asegurar que todos los campos estén completos
    setTimeout(() => {
        console.log('=== VERIFICACIÓN FINAL ===');

        // Verificar y completar área si está vacía
        const areaSelect = document.getElementById('area');
        if (areaSelect.value === '' || areaSelect.value === 'Seleccionar área...') {
            const areaValue = contrato.departamento || contrato.area_departamento || 'Operaciones';
            console.log('Forzando área:', areaValue);

            // Buscar o crear opción
            let opcionEncontrada = false;
            Array.from(areaSelect.options).forEach(opt => {
                if (opt.value.toLowerCase() === areaValue.toLowerCase()) {
                    areaSelect.value = opt.value;
                    opcionEncontrada = true;
                }
            });

            if (!opcionEncontrada) {
                const nuevaOpcion = document.createElement('option');
                nuevaOpcion.value = areaValue;
                nuevaOpcion.textContent = areaValue;
                nuevaOpcion.selected = true;
                areaSelect.appendChild(nuevaOpcion);
            }

            areaSelect.style.backgroundColor = '#f8f9fa';
            areaSelect.setAttribute('title', 'Campo completado automáticamente desde el contrato activo');
        }

        // Verificar y completar cargo si está vacío
        const cargoSelect = document.getElementById('cargo');
        if (cargoSelect.value === '' || cargoSelect.value === 'Seleccionar cargo...') {
            const cargoValue = contrato.cargo || 'Empleado';
            console.log('Forzando cargo:', cargoValue);

            // Buscar o crear opción
            let opcionEncontrada = false;
            Array.from(cargoSelect.options).forEach(opt => {
                if (opt.value.toLowerCase() === cargoValue.toLowerCase()) {
                    cargoSelect.value = opt.value;
                    opcionEncontrada = true;
                }
            });

            if (!opcionEncontrada) {
                const nuevaOpcion = document.createElement('option');
                nuevaOpcion.value = cargoValue;
                nuevaOpcion.textContent = cargoValue;
                nuevaOpcion.selected = true;
                cargoSelect.appendChild(nuevaOpcion);
            }

            cargoSelect.style.backgroundColor = '#f8f9fa';
            cargoSelect.setAttribute('title', 'Campo completado automáticamente desde el contrato activo');
        }

        // Verificar y generar código si está vacío
        const codigoInput = document.getElementById('codigo');
        if (!codigoInput.value || codigoInput.value.trim() === '') {
            const areaVal = document.getElementById('area').value;
            const cargoVal = document.getElementById('cargo').value;

            if (areaVal && cargoVal) {
                const areaCode = areaVal.substring(0, 3).toUpperCase();
                const cargoCode = cargoVal.substring(0, 3).toUpperCase();
                const randomNum = Math.floor(Math.random() * 1000).toString().padStart(3, '0');
                const codigoFinal = areaCode + '-' + cargoCode + '-' + randomNum;

                codigoInput.value = codigoFinal;
                console.log('Código final generado:', codigoFinal);
            } else {
                const codigoBasico = 'EMP-' + Date.now().toString().slice(-6);
                codigoInput.value = codigoBasico;
                console.log('Código básico generado:', codigoBasico);
            }

            codigoInput.style.backgroundColor = '#f8f9fa';
            codigoInput.setAttribute('title', 'Código generado automáticamente');
        }

        console.log('=== FIN VERIFICACIÓN ===');
    }, 800);

    // Mostrar botones de acción
    verContratoBtn.style.display = 'inline-block';
    descargarContratoBtn.style.display = 'inline-block';

    // Configurar eventos de los botones
    verContratoBtn.onclick = () => verContrato(contrato.id);
    descargarContratoBtn.onclick = () => descargarContrato(contrato.id);
}

// Función para ver contrato
function verContrato(contratoId) {
    const url = `<?php echo e(url('contratos')); ?>/${contratoId}`;
    window.open(url, '_blank');
}

// Función para descargar contrato en PDF
function descargarContrato(contratoId) {
    const url = `<?php echo e(route('contratos.pdf', ['contrato' => '__ID__'])); ?>`.replace('__ID__', contratoId);
    window.open(url, '_blank');
}

// Función para limpiar campos
function limpiarCampos() {
    const camposPersona = ['nombres', 'apellidos', 'telefono', 'email', 'direccion', 'fecha_nacimiento', 'sexo'];
    camposPersona.forEach(campo => {
        const elemento = document.getElementById(campo);
        if (elemento) {
            elemento.value = '';
            elemento.readOnly = false;
            elemento.disabled = false;
            elemento.classList.remove('bg-light');
            elemento.removeAttribute('title');
            
            // Si es el select de sexo, restaurar el atributo name
            if (campo === 'sexo' && elemento.tagName === 'SELECT') {
                elemento.name = 'sexo';
                // Eliminar campo hidden si existe
                const hiddenSexo = document.getElementById('sexo_hidden');
                if (hiddenSexo) {
                    hiddenSexo.remove();
                }
            }
        }
    });

    // Limpiar también campos laborales auto-completados
    const camposLaborales = ['codigo', 'cargo', 'area', 'salario', 'fecha_ingreso', 'estado'];
    camposLaborales.forEach(campo => {
        const elemento = document.getElementById(campo);
        if (elemento && elemento.style.backgroundColor === 'rgb(248, 249, 250)') {
            elemento.style.backgroundColor = '';
            elemento.removeAttribute('title');

            // Remover badge de auto-completado
            const label = elemento.closest('.mb-3').querySelector('label');
            if (label) {
                const badge = label.querySelector('.auto-filled-badge');
                if (badge) {
                    badge.remove();
                }
            }

            // Para el código, limpiarlo completamente si fue auto-generado
            if (campo === 'codigo') {
                elemento.value = '';
            }
        }
    });

    document.getElementById('persona_id').value = '';
    const contratoInfo = document.getElementById('contratoInfo');
    if (contratoInfo) {
        contratoInfo.style.display = 'none';
    }
    contratoActual = null;
}

// Función para validar antes de enviar el formulario
function validarAntesDeEnviar(event) {
    console.log('=== VALIDANDO ANTES DE ENVIAR ===');

    // Verificar valores de campos críticos
    const codigo = document.getElementById('codigo').value;
    const area = document.getElementById('area').value;
    const cargo = document.getElementById('cargo').value;
    const sexo = document.getElementById('sexo').value;

    console.log('Código:', codigo, '(length:', codigo.length, ')');
    console.log('Área:', area);
    console.log('Cargo:', cargo);
    console.log('Sexo:', sexo);

    // Verificar que el código no exceda 20 caracteres
    if (codigo.length > 20) {
        alert('Error: El código no puede tener más de 20 caracteres. Actual: ' + codigo.length);
        event.preventDefault();
        return false;
    }

    // Verificar que área y cargo no estén vacíos
    if (!area || area === '') {
        alert('Error: El campo área es obligatorio');
        event.preventDefault();
        return false;
    }

    if (!cargo || cargo === '') {
        alert('Error: El campo cargo es obligatorio');
        event.preventDefault();
        return false;
    }

    // Verificar que el sexo sea válido
    if (sexo && sexo !== 'Masculino' && sexo !== 'Femenino') {
        alert('Error: El sexo debe ser "Masculino" o "Femenino". Actual: "' + sexo + '"');
        event.preventDefault();
        return false;
    }

    console.log('Validación exitosa, enviando formulario...');
    return true;
}

// ============= FIN DEL PRIMER SCRIPT =============
</script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cesodo4\resources\views/trabajadores/create.blade.php ENDPATH**/ ?>