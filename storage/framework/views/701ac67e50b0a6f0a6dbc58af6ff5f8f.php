<?php $__env->startSection('title', 'Editar Contrato #' . $contrato->numero_contrato); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2 text-primary">
            <i class="fas fa-edit me-2"></i>Editar Contrato #<?php echo e($contrato->numero_contrato ?? 'Sin número'); ?>

        </h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?php echo e(route('contratos.show', $contrato)); ?>" class="btn btn-outline-info">
                    <i class="fas fa-eye me-1"></i>Ver Contrato
                </a>
            </div>
            <a href="<?php echo e(route('contratos.index')); ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>Volver a Contratos
            </a>
        </div>
    </div>

    <!-- Alerta de Estado -->
    <?php if($contrato->estado === 'finalizado'): ?>
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Advertencia:</strong> Este contrato está finalizado. Los cambios deben ser realizados con precaución.
        </div>
    <?php elseif($contrato->estado === 'activo'): ?>
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            <strong>Información:</strong> Este contrato está activo. Los cambios importantes pueden requerir nueva firma.
        </div>
    <?php endif; ?>

    <!-- Formulario -->
    <div class="row">
        <div class="col-lg-8 col-xl-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-edit me-2"></i>Editar Información del Contrato
                    </h5>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('contratos.update', $contrato)); ?>" method="POST" enctype="multipart/form-data" id="contratoEditForm">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>                        <!-- Información Básica -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-muted border-bottom pb-2 mb-3">
                                    <i class="fas fa-info-circle me-1"></i>Información Básica
                                </h6>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="persona_id" class="form-label">
                                    <i class="fas fa-user me-1"></i>Persona/Empleado <span class="text-danger">*</span>
                                </label>
                                <select class="form-select <?php $__errorArgs = ['persona_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="persona_id" name="persona_id" required>
                                    <option value="">Seleccione una persona...</option>
                                    <?php $__currentLoopData = $personas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $persona): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($persona->id); ?>"
                                                <?php echo e(old('persona_id', $contrato->persona_id) == $persona->id ? 'selected' : ''); ?>>
                                            <?php echo e($persona->nombres); ?> <?php echo e($persona->apellidos); ?> - <?php echo e($persona->numero_documento); ?>

                                            <?php if($persona->trabajador): ?>
                                                (Empleado: <?php echo e($persona->trabajador->cargo ?? 'Sin cargo'); ?>)
                                            <?php endif; ?>
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['persona_id'];
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
                                <label for="tipo_contrato" class="form-label">
                                    <i class="fas fa-file-alt me-1"></i>Tipo de Contrato <span class="text-danger">*</span>
                                </label>
                                <select class="form-select <?php $__errorArgs = ['tipo_contrato'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="tipo_contrato" name="tipo_contrato" required>
                                    <option value="">Seleccione un tipo...</option>
                                    <option value="indefinido" <?php echo e(old('tipo_contrato', $contrato->tipo_contrato) == 'indefinido' ? 'selected' : ''); ?>>Indefinido</option>
                                    <option value="temporal" <?php echo e(old('tipo_contrato', $contrato->tipo_contrato) == 'temporal' ? 'selected' : ''); ?>>Temporal</option>
                                    <option value="obra_labor" <?php echo e(old('tipo_contrato', $contrato->tipo_contrato) == 'obra_labor' ? 'selected' : ''); ?>>Obra o Labor</option>
                                    <option value="aprendizaje" <?php echo e(old('tipo_contrato', $contrato->tipo_contrato) == 'aprendizaje' ? 'selected' : ''); ?>>Aprendizaje</option>
                                    <option value="prestacion_servicios" <?php echo e(old('tipo_contrato', $contrato->tipo_contrato) == 'prestacion_servicios' ? 'selected' : ''); ?>>Prestación de Servicios</option>
                                </select>
                                <?php $__errorArgs = ['tipo_contrato'];
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

                            <div class="col-md-4 mb-3">
                                <label for="numero_contrato" class="form-label">
                                    <i class="fas fa-hashtag me-1"></i>Número de Contrato
                                </label>
                                <input type="text" class="form-control <?php $__errorArgs = ['numero_contrato'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="numero_contrato" name="numero_contrato"
                                       value="<?php echo e(old('numero_contrato', $contrato->numero_contrato)); ?>"
                                       placeholder="Ej: CON-2024-001">
                                <?php $__errorArgs = ['numero_contrato'];
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

                            <div class="col-md-4 mb-3">
                                <label for="fecha_inicio" class="form-label">
                                    <i class="fas fa-calendar-plus me-1"></i>Fecha de Inicio <span class="text-danger">*</span>
                                </label>
                                <input type="date" class="form-control <?php $__errorArgs = ['fecha_inicio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="fecha_inicio" name="fecha_inicio"
                                       value="<?php echo e(old('fecha_inicio', $contrato->fecha_inicio?->format('Y-m-d'))); ?>" required>
                                <?php $__errorArgs = ['fecha_inicio'];
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

                            <div class="col-md-4 mb-3">
                                <label for="fecha_fin" class="form-label">
                                    <i class="fas fa-calendar-minus me-1"></i>Fecha de Fin
                                </label>
                                <input type="date" class="form-control <?php $__errorArgs = ['fecha_fin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="fecha_fin" name="fecha_fin"
                                       value="<?php echo e(old('fecha_fin', $contrato->fecha_fin?->format('Y-m-d'))); ?>">
                                <?php $__errorArgs = ['fecha_fin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <small class="form-text text-muted">Dejar vacío para contratos indefinidos</small>
                            </div>
                        </div>

                        <!-- Información Económica -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-muted border-bottom pb-2 mb-3">
                                    <i class="fas fa-dollar-sign me-1"></i>Información Económica
                                </h6>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="salario" class="form-label">
                                    <i class="fas fa-money-bill me-1"></i>Salario <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">S/</span>
                                    <input type="number" class="form-control <?php $__errorArgs = ['salario'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           id="salario" name="salario"
                                           value="<?php echo e(old('salario', $contrato->salario)); ?>"
                                           step="0.01" min="0" required>
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

                        <!-- Detalles del Trabajo -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-muted border-bottom pb-2 mb-3">
                                    <i class="fas fa-briefcase me-1"></i>Detalles del Trabajo
                                </h6>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="cargo" class="form-label">
                                    <i class="fas fa-user-tie me-1"></i>Cargo <span class="text-danger">*</span>
                                </label>
                                <select class="form-select <?php $__errorArgs = ['cargo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        id="cargo" name="cargo" required>
                                    <option value="">Seleccionar cargo...</option>
                                    <?php $__currentLoopData = $cargos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cargo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($cargo); ?>" <?php echo e(old('cargo', $contrato->cargo) == $cargo ? 'selected' : ''); ?>>
                                            <?php echo e($cargo); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

                            <div class="col-md-6 mb-3">
                                <label for="departamento" class="form-label">
                                    <i class="fas fa-building me-1"></i>Departamento
                                </label>
                                <select class="form-select <?php $__errorArgs = ['departamento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        id="departamento" name="departamento">
                                    <option value="">Seleccionar área...</option>
                                    <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($area); ?>" <?php echo e(old('departamento', $contrato->departamento) == $area ? 'selected' : ''); ?>>
                                            <?php echo e($area); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['departamento'];
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
                                <label for="jornada_laboral" class="form-label">
                                    <i class="fas fa-clock me-1"></i>Jornada Laboral <span class="text-danger">*</span>
                                </label>
                                <select class="form-select <?php $__errorArgs = ['jornada_laboral'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="jornada_laboral" name="jornada_laboral" required>
                                    <option value="">Seleccione una jornada...</option>
                                    <option value="completa" <?php echo e(old('jornada_laboral', $contrato->jornada_laboral) == 'completa' ? 'selected' : ''); ?>>Tiempo Completo</option>
                                    <option value="parcial" <?php echo e(old('jornada_laboral', $contrato->jornada_laboral) == 'parcial' ? 'selected' : ''); ?>>Tiempo Parcial</option>
                                    <option value="flexible" <?php echo e(old('jornada_laboral', $contrato->jornada_laboral) == 'flexible' ? 'selected' : ''); ?>>Horario Flexible</option>
                                </select>
                                <?php $__errorArgs = ['jornada_laboral'];
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

                        <!-- Términos y Condiciones -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-muted border-bottom pb-2 mb-3">
                                    <i class="fas fa-file-contract me-1"></i>Términos y Condiciones
                                </h6>
                            </div>

                            <div class="col-12 mb-3">
                                <label for="clausulas_especiales" class="form-label">
                                    <i class="fas fa-list-alt me-1"></i>Cláusulas Especiales
                                </label>
                                <textarea class="form-control <?php $__errorArgs = ['clausulas_especiales'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                          id="clausulas_especiales" name="clausulas_especiales" rows="4"
                                          placeholder="Escriba las cláusulas especiales del contrato..."><?php echo e(old('clausulas_especiales', $contrato->clausulas_especiales)); ?></textarea>
                                <?php $__errorArgs = ['clausulas_especiales'];
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

                            <div class="col-12 mb-3">
                                <label for="observaciones" class="form-label">
                                    <i class="fas fa-sticky-note me-1"></i>Observaciones
                                </label>
                                <textarea class="form-control <?php $__errorArgs = ['observaciones'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                          id="observaciones" name="observaciones" rows="3"
                                          placeholder="Observaciones adicionales..."><?php echo e(old('observaciones', $contrato->observaciones)); ?></textarea>
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

                        <!-- Archivos Actuales -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-muted border-bottom pb-2 mb-3">
                                    <i class="fas fa-paperclip me-1"></i>Archivos Actuales
                                </h6>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    <i class="fas fa-file-pdf me-1"></i>Archivo del Contrato Actual
                                </label>
                                <?php if($contrato->archivo_contrato): ?>
                                    <div class="d-flex align-items-center justify-content-between border rounded p-2 mb-2">
                                        <div>
                                            <i class="fas fa-file-pdf text-danger me-2"></i>
                                            <span><?php echo e(basename($contrato->archivo_contrato)); ?></span>
                                        </div>
                                        <div>
                                            <a href="<?php echo e(Storage::url($contrato->archivo_contrato)); ?>"
                                               class="btn btn-sm btn-outline-primary me-1" target="_blank">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                    onclick="confirmarEliminacion('archivo_contrato')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="alert alert-warning mb-2">
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        No hay archivo del contrato
                                    </div>
                                <?php endif; ?>

                                <input type="file" class="form-control <?php $__errorArgs = ['archivo_contrato'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="archivo_contrato" name="archivo_contrato" accept=".pdf,.doc,.docx">
                                <?php $__errorArgs = ['archivo_contrato'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <small class="form-text text-muted">Subir nuevo archivo (reemplazará el actual)</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    <i class="fas fa-signature me-1"></i>Contrato Firmado Actual
                                </label>
                                <?php if($contrato->archivo_firmado): ?>
                                    <div class="d-flex align-items-center justify-content-between border rounded p-2 mb-2">
                                        <div>
                                            <i class="fas fa-file-pdf text-success me-2"></i>
                                            <span><?php echo e(basename($contrato->archivo_firmado)); ?></span>
                                            <?php if($contrato->fecha_firma): ?>
                                                <small class="text-muted d-block">
                                                    Firmado: <?php echo e($contrato->fecha_firma->format('d/m/Y H:i')); ?>

                                                </small>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <a href="<?php echo e(Storage::url($contrato->archivo_firmado)); ?>"
                                               class="btn btn-sm btn-outline-success me-1" target="_blank">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                    onclick="confirmarEliminacion('archivo_firmado')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="alert alert-info mb-2">
                                        <i class="fas fa-info-circle me-1"></i>
                                        No hay contrato firmado
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Nuevos Archivos -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-muted border-bottom pb-2 mb-3">
                                    <i class="fas fa-upload me-1"></i>Subir Nuevos Archivos
                                </h6>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="documentos_adjuntos" class="form-label">
                                    <i class="fas fa-files me-1"></i>Documentos Adicionales
                                </label>
                                <input type="file" class="form-control <?php $__errorArgs = ['documentos_adjuntos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="documentos_adjuntos" name="documentos_adjuntos[]" multiple
                                       accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                <?php $__errorArgs = ['documentos_adjuntos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <small class="form-text text-muted">Múltiples archivos permitidos</small>
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="<?php echo e(route('contratos.show', $contrato)); ?>" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-1"></i>Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i>Actualizar Contrato
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Campos ocultos para eliminaciones -->
                        <input type="hidden" name="eliminar_archivo_contrato" id="eliminar_archivo_contrato" value="">
                        <input type="hidden" name="eliminar_archivo_firmado" id="eliminar_archivo_firmado" value="">
                    </form>
                </div>
            </div>
        </div>

        <!-- Panel de Información -->
        <div class="col-lg-4 col-xl-2">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-info-circle me-1"></i>Estado Actual
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-muted">Estado</h6>
                        <span class="badge fs-6
                            <?php if($contrato->estado === 'activo'): ?> bg-success
                            <?php elseif($contrato->estado === 'borrador'): ?> bg-warning
                            <?php elseif($contrato->estado === 'enviado'): ?> bg-info
                            <?php elseif($contrato->estado === 'finalizado'): ?> bg-secondary
                            <?php else: ?> bg-dark
                            <?php endif; ?>">
                            <?php echo e(ucfirst($contrato->estado)); ?>

                        </span>
                    </div>

                    <div class="mb-3">
                        <h6 class="text-muted">Creado</h6>
                        <p class="small mb-0"><?php echo e($contrato->created_at->format('d/m/Y')); ?></p>
                    </div>

                    <div class="mb-3">
                        <h6 class="text-muted">Última actualización</h6>
                        <p class="small mb-0"><?php echo e($contrato->updated_at->format('d/m/Y H:i')); ?></p>
                    </div>

                    <?php if($contrato->fecha_fin): ?>
                    <div class="mb-3">
                        <h6 class="text-muted">Días restantes</h6>
                        <?php
                            $diasRestantes = $contrato->diasRestantes();
                        ?>
                        <p class="small mb-0
                            <?php if($diasRestantes !== null && $diasRestantes <= 30): ?> text-danger
                            <?php elseif($diasRestantes !== null && $diasRestantes <= 90): ?> text-warning
                            <?php else: ?> text-success
                            <?php endif; ?>">
                            <?php echo e($diasRestantes ?? 0); ?> días
                        </p>
                    </div>
                    <?php endif; ?>

                    <div>
                        <h6 class="text-muted">Recordatorio</h6>
                        <p class="small text-muted">
                            <i class="fas fa-lightbulb text-warning me-1"></i>
                            Los cambios importantes pueden requerir nueva firma del contrato.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-completar datos de persona
    const personaSelect = document.getElementById('persona_id');
    const cargoSelect = document.getElementById('cargo');
    const departamentoSelect = document.getElementById('departamento');

    personaSelect.addEventListener('change', function() {
        if (this.value && this.value !== '<?php echo e($contrato->persona_id); ?>') {
            // Solo actualizar si se selecciona una persona diferente
            fetch(`<?php echo e(route('contratos.persona-data')); ?>?persona_id=${this.value}`)
                .then(response => response.json())
                .then(data => {
                    if (data.trabajador) {
                        if (confirm('¿Desea actualizar el cargo y departamento con los datos de la persona seleccionada?')) {
                            // Seleccionar el cargo si existe en la lista
                            if (data.trabajador.cargo) {
                                cargoSelect.value = data.trabajador.cargo;
                            }
                            // Seleccionar el área si existe en la lista
                            if (data.trabajador.area) {
                                departamentoSelect.value = data.trabajador.area;
                            }
                        }
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    });

    // Validación de fechas
    const fechaInicioInput = document.getElementById('fecha_inicio');
    const fechaFinInput = document.getElementById('fecha_fin');

    fechaInicioInput.addEventListener('change', function() {
        fechaFinInput.min = this.value;
    });

    fechaFinInput.addEventListener('change', function() {
        if (this.value && fechaInicioInput.value && this.value <= fechaInicioInput.value) {
            alert('La fecha de fin debe ser posterior a la fecha de inicio.');
            this.value = '';
        }
    });

    // Habilitar/deshabilitar fecha fin según tipo de contrato
    const tipoContratoSelect = document.getElementById('tipo_contrato');

    tipoContratoSelect.addEventListener('change', function() {
        if (this.value === 'indefinido') {
            fechaFinInput.disabled = true;
            fechaFinInput.value = '';
            fechaFinInput.required = false;
        } else {
            fechaFinInput.disabled = false;
            fechaFinInput.required = this.value === 'temporal' || this.value === 'obra_labor';
        }
    });

    // Trigger inicial para tipo de contrato
    if (tipoContratoSelect.value === 'indefinido') {
        fechaFinInput.disabled = true;
    }

    // Validación de archivos
    const archivoInput = document.getElementById('archivo_contrato');
    const documentosInput = document.getElementById('documentos_adjuntos');

    function validarArchivo(input, maxSize = 5) {
        const files = input.files;
        const maxSizeBytes = maxSize * 1024 * 1024; // Convertir MB a bytes

        for (let file of files) {
            if (file.size > maxSizeBytes) {
                alert(`El archivo ${file.name} excede el tamaño máximo de ${maxSize}MB.`);
                input.value = '';
                return false;
            }
        }
        return true;
    }

    archivoInput.addEventListener('change', function() {
        validarArchivo(this);
    });

    documentosInput.addEventListener('change', function() {
        validarArchivo(this);
    });
});

// Función para confirmar eliminación de archivos
function confirmarEliminacion(tipoArchivo) {
    if (confirm('¿Está seguro de que desea eliminar este archivo? Esta acción no se puede deshacer.')) {
        document.getElementById('eliminar_' + tipoArchivo).value = '1';

        // Mostrar mensaje de confirmación
        const mensaje = document.createElement('div');
        mensaje.className = 'alert alert-warning mt-2';
        mensaje.innerHTML = '<i class="fas fa-exclamation-triangle me-1"></i>Este archivo será eliminado al guardar los cambios.';

        // Insertar después del botón
        event.target.closest('.d-flex').after(mensaje);

        // Deshabilitar el botón
        event.target.disabled = true;
        event.target.classList.add('disabled');
    }
}
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cesodo4\resources\views/contratos/edit.blade.php ENDPATH**/ ?>