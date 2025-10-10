<?php $__env->startSection('title', 'Configuraciones del Sistema'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-cogs text-primary me-2"></i>
                        Configuraciones del Sistema
                    </h1>
                    <p class="text-muted mb-0">Administra las configuraciones generales del sistema</p>
                </div>
                <div>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('crear-configuraciones')): ?>
                        <a href="<?php echo e(route('configurations.create')); ?>" class="btn btn-primary me-2">
                            <i class="fas fa-plus me-2"></i>
                            Nueva Configuración
                        </a>
                    <?php endif; ?>
                    <a href="<?php echo e(route('configurations.export')); ?>" class="btn btn-outline-info">
                        <i class="fas fa-download me-2"></i>
                        Exportar
                    </a>
                </div>
            </div>

            <!-- Filtros -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-filter me-2"></i>Filtros
                    </h6>
                </div>
                <div class="card-body">
                    <form method="GET" action="<?php echo e(route('configurations.index')); ?>" class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Módulo</label>
                            <select name="module" class="form-select">
                                <option value="all" <?php echo e($module == 'all' ? 'selected' : ''); ?>>Todos los módulos</option>
                                <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($mod); ?>" <?php echo e($module == $mod ? 'selected' : ''); ?>>
                                        <?php echo e(ucfirst($mod)); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Categoría</label>
                            <select name="category" class="form-select">
                                <option value="all" <?php echo e($category == 'all' ? 'selected' : ''); ?>>Todas las categorías</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($cat); ?>" <?php echo e($category == $cat ? 'selected' : ''); ?>>
                                        <?php echo e(ucfirst($cat)); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="fas fa-search me-1"></i>
                                    Filtrar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabla de configuraciones -->
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-list me-2"></i>Configuraciones
                        <span class="badge bg-primary ms-2"><?php echo e($configurations->total()); ?></span>
                    </h6>
                </div>
                <div class="card-body p-0">
                    <?php if($configurations->count() > 0): ?>
                        <div class="table-responsive">
                            <form method="POST" action="<?php echo e(route('configurations.bulk-update')); ?>" id="bulkUpdateForm">
                                <?php echo csrf_field(); ?>
                                <table class="table table-hover mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="border-0 px-4 py-3">Clave</th>
                                            <th class="border-0 py-3">Módulo</th>
                                            <th class="border-0 py-3">Categoría</th>
                                            <th class="border-0 py-3">Tipo</th>
                                            <th class="border-0 py-3">Valor Actual</th>
                                            <th class="border-0 py-3">Descripción</th>
                                            <th class="border-0 py-3 text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $configurations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $config): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td class="px-4 py-3">
                                                    <div class="d-flex align-items-center">
                                                        <?php if($config->is_system): ?>
                                                            <i class="fas fa-lock text-warning me-2" title="Configuración del sistema"></i>
                                                        <?php elseif(!$config->editable): ?>
                                                            <i class="fas fa-ban text-danger me-2" title="No editable"></i>
                                                        <?php endif; ?>
                                                        <code class="bg-light px-2 py-1 rounded"><?php echo e($config->key); ?></code>
                                                    </div>
                                                </td>
                                                <td class="py-3">
                                                    <?php if($config->module): ?>
                                                        <span class="badge bg-info"><?php echo e(ucfirst($config->module)); ?></span>
                                                    <?php else: ?>
                                                        <span class="text-muted">-</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="py-3">
                                                    <span class="badge bg-secondary"><?php echo e(ucfirst($config->category)); ?></span>
                                                </td>
                                                <td class="py-3">
                                                    <span class="badge
                                                        <?php switch($config->type):
                                                            case ('boolean'): ?> bg-success <?php break; ?>
                                                            <?php case ('number'): ?> bg-primary <?php break; ?>
                                                            <?php case ('json'): ?> bg-warning <?php break; ?>
                                                            <?php case ('date'): ?> bg-info <?php break; ?>
                                                            <?php default: ?> bg-light text-dark
                                                        <?php endswitch; ?>
                                                    ">
                                                        <?php echo e($config->type); ?>

                                                    </span>
                                                </td>
                                                <td class="py-3" style="max-width: 200px;">
                                                    <?php if($config->editable && !$config->is_system): ?>
                                                        <?php if($config->type === 'boolean'): ?>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input"
                                                                       type="checkbox"
                                                                       name="configurations[<?php echo e($config->id); ?>][value]"
                                                                       <?php echo e($config->value ? 'checked' : ''); ?>>
                                                            </div>
                                                        <?php elseif($config->type === 'text'): ?>
                                                            <textarea class="form-control form-control-sm"
                                                                      name="configurations[<?php echo e($config->id); ?>][value]"
                                                                      rows="2"><?php echo e($config->value); ?></textarea>
                                                        <?php else: ?>
                                                            <input type="text"
                                                                   class="form-control form-control-sm"
                                                                   name="configurations[<?php echo e($config->id); ?>][value]"
                                                                   value="<?php echo e($config->value); ?>">
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                        <span class="text-truncate d-block">
                                                            <?php if($config->type === 'boolean'): ?>
                                                                <span class="badge <?php echo e($config->value ? 'bg-success' : 'bg-danger'); ?>">
                                                                    <?php echo e($config->value ? 'Sí' : 'No'); ?>

                                                                </span>
                                                            <?php else: ?>
                                                                <?php echo e(Str::limit($config->value, 50)); ?>

                                                            <?php endif; ?>
                                                        </span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="py-3" style="max-width: 250px;">
                                                    <small class="text-muted"><?php echo e(Str::limit($config->description, 100)); ?></small>
                                                </td>
                                                <td class="py-3 text-center">
                                                    <div class="btn-group" role="group">
                                                        <a href="<?php echo e(route('configurations.show', $config)); ?>"
                                                           class="btn btn-outline-info btn-sm"
                                                           title="Ver detalles">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <?php if($config->editable && !$config->is_system): ?>
                                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('editar-configuraciones')): ?>
                                                                <a href="<?php echo e(route('configurations.edit', $config)); ?>"
                                                                   class="btn btn-outline-warning btn-sm"
                                                                   title="Editar">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                            <?php endif; ?>
                                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('eliminar-configuraciones')): ?>
                                                                <form method="POST"
                                                                      action="<?php echo e(route('configurations.destroy', $config)); ?>"
                                                                      class="d-inline"
                                                                      onsubmit="return confirm('¿Estás seguro de eliminar esta configuración?')">
                                                                    <?php echo csrf_field(); ?>
                                                                    <?php echo method_field('DELETE'); ?>
                                                                    <button type="submit"
                                                                            class="btn btn-outline-danger btn-sm"
                                                                            title="Eliminar">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>

                                <?php if($configurations->where('editable', true)->where('is_system', false)->count() > 0): ?>
                                    <div class="p-3 bg-light border-top">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-save me-2"></i>
                                            Guardar Cambios Masivos
                                        </button>
                                    </div>
                                <?php endif; ?>
                            </form>
                        </div>

                        <!-- Paginación -->
                        <?php if($configurations->hasPages()): ?>
                            <div class="p-3 border-top">
                                <?php echo e($configurations->withQueryString()->links()); ?>

                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-cogs fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No hay configuraciones</h5>
                            <p class="text-muted">No se encontraron configuraciones que coincidan con los filtros aplicados.</p>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('crear-configuraciones')): ?>
                                <a href="<?php echo e(route('configurations.create')); ?>" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>
                                    Crear Primera Configuración
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit form on filter change
    document.querySelectorAll('select[name="module"], select[name="category"]').forEach(function(select) {
        select.addEventListener('change', function() {
            this.form.submit();
        });
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cesodo4\resources\views/configurations/index.blade.php ENDPATH**/ ?>