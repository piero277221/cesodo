<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-file-contract text-primary me-2"></i>
                Templates de Contratos
            </h1>
            <p class="mb-0 text-muted">Gestiona los formatos personalizados para la generación de contratos</p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?php echo e(route('plantillas.generador')); ?>" class="btn btn-success">
                <i class="fas fa-magic me-1"></i>
                Generar Plantilla
            </a>
            <a href="<?php echo e(route('contratos.templates.create')); ?>" class="btn btn-primary">
                <i class="fas fa-upload me-1"></i>
                Subir Plantilla
            </a>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i><?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i><?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Nota informativa -->
    <div class="alert alert-info mb-4" role="alert">
        <div class="d-flex align-items-start">
            <i class="fas fa-info-circle text-primary me-3 mt-1"></i>
            <div>
                <h6 class="alert-heading mb-2">
                    <i class="fas fa-file-contract me-2"></i>Plantillas de Contratos
                </h6>
                <p class="mb-2">
                    <strong>Opción 1 - Generar:</strong> Usa nuestro generador visual para crear plantillas desde cero con editor tipo Word.<br>
                    <strong>Opción 2 - Subir:</strong> Sube un documento Word o PDF existente con marcadores (como <code>{{"{{nombre}}"}}</code>, <code>{{"{{cedula}}"}}</code>).
                </p>
                <p class="mb-2">
                    En ambos casos, el sistema reemplazará automáticamente los marcadores con los datos del empleado al generar contratos.
                </p>
                <small class="text-muted">
                    <i class="fas fa-lightbulb me-1"></i>
                    Los marcadores detectados se mostrarán después de crear o subir tu plantilla.
                </small>
            </div>
        </div>
    </div>

    <div class="row">
        <?php $__empty_1 = true; $__currentLoopData = $templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $template): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-lg-6 col-xl-4 mb-4">
                <div class="card h-100 shadow-sm <?php echo e($template->es_predeterminado ? 'border-primary' : ''); ?>">
                    <?php if($template->es_predeterminado): ?>
                        <div class="card-header bg-primary text-white py-2">
                            <small><i class="fas fa-star me-1"></i>Template Predeterminado</small>
                        </div>
                    <?php endif; ?>

                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="card-title mb-0"><?php echo e($template->nombre); ?></h5>
                            <span class="badge bg-<?php echo e($template->activo ? 'success' : 'secondary'); ?>">
                                <?php echo e($template->activo ? 'Activo' : 'Inactivo'); ?>

                            </span>
                        </div>

                        <?php if($template->descripcion): ?>
                            <p class="card-text text-muted small"><?php echo e($template->descripcion); ?></p>
                        <?php endif; ?>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small class="text-muted">
                                    <i class="fas fa-file-alt me-1"></i>
                                    Tipo: <?php echo e(strtoupper($template->tipo)); ?>

                                </small>
                                <small class="text-muted">
                                    <i class="fas fa-tags me-1"></i>
                                    <?php echo e(count($template->marcadores ?? [])); ?> marcadores
                                </small>
                            </div>

                            <?php if($template->creadoPor): ?>
                                <small class="text-muted">
                                    <i class="fas fa-user me-1"></i>
                                    Creado por: <?php echo e($template->creadoPor->name); ?>

                                </small>
                            <?php endif; ?>
                        </div>

                        <?php if($template->marcadores && count($template->marcadores) > 0): ?>
                            <div class="mb-3">
                                <small class="text-muted d-block mb-1">Marcadores detectados:</small>
                                <div class="d-flex flex-wrap gap-1">
                                    <?php $__currentLoopData = array_slice($template->marcadores, 0, 3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $marcador): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <span class="badge bg-light text-dark border"><?php echo e($marcador); ?></span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(count($template->marcadores) > 3): ?>
                                        <span class="badge bg-light text-muted">+<?php echo e(count($template->marcadores) - 3); ?> más</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="card-footer bg-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>
                                <?php echo e($template->created_at->format('d/m/Y')); ?>

                            </small>

                            <div class="btn-group" role="group">
                                <a href="<?php echo e(route('contratos.templates.preview', $template)); ?>"
                                   class="btn btn-sm btn-outline-info" title="Vista Previa">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <a href="<?php echo e(route('contratos.templates.edit', $template)); ?>"
                                   class="btn btn-sm btn-outline-primary" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <?php if(!$template->es_predeterminado): ?>
                                    <form action="<?php echo e(route('contratos.templates.set-default', $template)); ?>"
                                          method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-sm btn-outline-warning"
                                                title="Establecer como predeterminado">
                                            <i class="fas fa-star"></i>
                                        </button>
                                    </form>
                                <?php endif; ?>

                                <form action="<?php echo e(route('contratos.templates.destroy', $template)); ?>"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('¿Está seguro de eliminar este template?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <div class="mb-4">
                            <i class="fas fa-file-contract fa-4x text-muted"></i>
                        </div>
                        <h4 class="text-muted">No hay templates disponibles</h4>
                        <p class="text-muted mb-4">Crea tu primer template personalizado para generar contratos con tu formato.</p>
                        <a href="<?php echo e(route('contratos.templates.create')); ?>" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>
                            Crear Primer Template
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Información sobre marcadores -->
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-info-circle text-info me-2"></i>
                Información sobre Marcadores
            </h5>
        </div>
        <div class="card-body">
            <p class="mb-3">Los marcadores son variables que se reemplazan automáticamente con datos del contrato. Algunos ejemplos:</p>
            <div class="row">
                <div class="col-md-4">
                    <h6 class="text-primary">Datos del Trabajador</h6>
                    <ul class="list-unstyled small">
                        <li><code>{NOMBRE_TRABAJADOR}</code></li>
                        <li><code>{CEDULA_TRABAJADOR}</code></li>
                        <li><code>{EMAIL_TRABAJADOR}</code></li>
                        <li><code>{DIRECCION_TRABAJADOR}</code></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6 class="text-primary">Datos del Contrato</h6>
                    <ul class="list-unstyled small">
                        <li><code>{NUMERO_CONTRATO}</code></li>
                        <li><code>{CARGO}</code></li>
                        <li><code>{SALARIO_BASE}</code></li>
                        <li><code>{DEPARTAMENTO}</code></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6 class="text-primary">Fechas</h6>
                    <ul class="list-unstyled small">
                        <li><code>{FECHA_INICIO}</code></li>
                        <li><code>{FECHA_FIN}</code></li>
                        <li><code>{FECHA_ACTUAL}</code></li>
                        <li><code>{FECHA_ACTUAL_LETRAS}</code></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cesodo4\resources\views/contratos/templates/index.blade.php ENDPATH**/ ?>