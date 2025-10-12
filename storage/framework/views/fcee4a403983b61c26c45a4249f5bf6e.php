

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="fas fa-utensils text-primary me-2"></i>
            <?php echo e($receta->nombre); ?>

        </h2>
        <div>
            <a href="<?php echo e(route('recetas.edit', $receta)); ?>" class="btn btn-warning">
                <i class="fas fa-edit me-2"></i>
                Editar
            </a>
            <a href="<?php echo e(route('recetas.index')); ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>
                Volver al Listado
            </a>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <!-- Información Principal -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Información General
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong><i class="fas fa-bookmark text-primary me-2"></i>Tipo de Plato:</strong>
                            <span class="badge bg-info ms-2">
                                <?php echo e(str_replace('_', ' ', ucfirst($receta->tipo_plato))); ?>

                            </span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong><i class="fas fa-signal text-primary me-2"></i>Dificultad:</strong>
                            <span class="badge 
                                <?php if($receta->dificultad == 'facil'): ?> bg-success
                                <?php elseif($receta->dificultad == 'media' || $receta->dificultad == 'intermedio'): ?> bg-warning
                                <?php else: ?> bg-danger
                                <?php endif; ?> ms-2">
                                <?php echo e(ucfirst($receta->dificultad)); ?>

                            </span>
                        </div>
                        <div class="col-md-4 mb-3">
                            <strong><i class="fas fa-clock text-primary me-2"></i>Tiempo:</strong>
                            <span class="ms-2"><?php echo e($receta->tiempo_preparacion); ?> min</span>
                        </div>
                        <div class="col-md-4 mb-3">
                            <strong><i class="fas fa-users text-primary me-2"></i>Porciones:</strong>
                            <span class="ms-2"><?php echo e($receta->porciones); ?></span>
                        </div>
                        <div class="col-md-4 mb-3">
                            <strong><i class="fas fa-dollar-sign text-primary me-2"></i>Costo Aproximado:</strong>
                            <span class="ms-2">S/ <?php echo e(number_format($receta->costo_aproximado, 2)); ?></span>
                        </div>
                    </div>

                    <?php if($receta->descripcion): ?>
                        <div class="mt-3">
                            <strong><i class="fas fa-align-left text-primary me-2"></i>Descripción:</strong>
                            <p class="mt-2 text-muted"><?php echo e($receta->descripcion); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Ingredientes -->
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2"></i>
                        Ingredientes (<?php echo e($receta->ingredientes->count()); ?>)
                    </h5>
                </div>
                <div class="card-body">
                    <?php if($receta->ingredientes->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Unidad</th>
                                        <th>Observaciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $receta->ingredientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ingrediente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <i class="fas fa-box text-primary me-2"></i>
                                                <?php echo e($ingrediente->producto->nombre); ?>

                                            </td>
                                            <td><?php echo e(number_format($ingrediente->cantidad, 2)); ?></td>
                                            <td><?php echo e($ingrediente->unidad_medida); ?></td>
                                            <td><?php echo e($ingrediente->observaciones ?? '-'); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-muted mb-0">No hay ingredientes registrados.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Instrucciones -->
            <div class="card mb-4">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fas fa-tasks me-2"></i>
                        Instrucciones de Preparación
                    </h5>
                </div>
                <div class="card-body">
                    <?php if($receta->instrucciones): ?>
                        <div class="recipe-instructions">
                            <?php echo nl2br(e($receta->instrucciones)); ?>

                        </div>
                    <?php else: ?>
                        <p class="text-muted mb-0">No hay instrucciones registradas.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Pasos de Preparación -->
            <?php if($receta->pasos_preparacion): ?>
                <?php
                    $pasos = json_decode($receta->pasos_preparacion, true);
                ?>
                <?php if(is_array($pasos) && count($pasos) > 0): ?>
                    <div class="card mb-4">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-shoe-prints me-2"></i>
                                Pasos de Preparación
                            </h5>
                        </div>
                        <div class="card-body">
                            <ol class="list-group list-group-numbered">
                                <?php $__currentLoopData = $pasos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="list-group-item"><?php echo e($paso); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ol>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <!-- Panel Lateral -->
        <div class="col-md-4">
            <!-- Estado y Metadatos -->
            <div class="card mb-4">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-cog me-2"></i>
                        Estado y Metadatos
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Estado:</strong>
                        <span class="badge <?php echo e($receta->estado == 'activo' ? 'bg-success' : 'bg-secondary'); ?> ms-2">
                            <?php echo e(ucfirst($receta->estado)); ?>

                        </span>
                    </div>
                    
                    <?php if($receta->createdBy): ?>
                        <div class="mb-3">
                            <strong>Creado por:</strong>
                            <p class="mb-0 text-muted"><?php echo e($receta->createdBy->name); ?></p>
                        </div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <strong>Fecha de creación:</strong>
                        <p class="mb-0 text-muted"><?php echo e($receta->created_at->format('d/m/Y H:i')); ?></p>
                    </div>

                    <div>
                        <strong>Última actualización:</strong>
                        <p class="mb-0 text-muted"><?php echo e($receta->updated_at->format('d/m/Y H:i')); ?></p>
                    </div>
                </div>
            </div>

            <!-- Notas Adicionales -->
            <?php if($receta->notas): ?>
                <div class="card mb-4">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-sticky-note me-2"></i>
                            Notas
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-0"><?php echo e($receta->notas); ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Ingredientes Especiales -->
            <?php if($receta->ingredientes_especiales): ?>
                <div class="card mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">
                            <i class="fas fa-star me-2"></i>
                            Ingredientes Especiales
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-0"><?php echo e($receta->ingredientes_especiales); ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Acciones -->
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Acciones
                    </h5>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('recetas.destroy', $receta)); ?>" method="POST" 
                          onsubmit="return confirm('¿Estás seguro de eliminar esta receta?');">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="fas fa-trash me-2"></i>
                            Eliminar Receta
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.recipe-instructions {
    font-size: 1rem;
    line-height: 1.8;
}

.list-group-numbered {
    counter-reset: section;
    list-style-type: none;
}

.list-group-numbered li {
    counter-increment: section;
    padding-left: 2rem;
    position: relative;
}

.list-group-numbered li:before {
    content: counter(section);
    position: absolute;
    left: 0.5rem;
    top: 50%;
    transform: translateY(-50%);
    background-color: #0d6efd;
    color: white;
    width: 1.5rem;
    height: 1.5rem;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 0.875rem;
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cesodo4\resources\views/recetas/show.blade.php ENDPATH**/ ?>