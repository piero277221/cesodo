<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <!-- Encabezado -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0" style="color: var(--cesodo-black); font-weight: 700;">Lista de Menús</h4>
        <a href="<?php echo e(route('menus.create')); ?>" class="btn btn-danger">
            <i class="fas fa-plus me-2"></i>Nuevo Menú
        </a>
    </div>

    <!-- Estadísticas -->
    <div class="row g-3 mb-4">
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm h-100" style="background: white;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-uppercase mb-1" style="color: #666; font-size: 0.75rem; font-weight: 600; letter-spacing: 0.5px;">Menús Totales</p>
                            <h3 class="mb-0" style="color: var(--cesodo-black); font-weight: 700;"><?php echo e($estadisticas['total_menus']); ?></h3>
                        </div>
                        <div class="d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: var(--cesodo-black); border-radius: 12px;">
                            <i class="fas fa-utensils" style="font-size: 1.5rem; color: white;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm h-100" style="background: white;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-uppercase mb-1" style="color: #666; font-size: 0.75rem; font-weight: 600; letter-spacing: 0.5px;">En Servicio</p>
                            <h3 class="mb-0" style="color: var(--cesodo-black); font-weight: 700;"><?php echo e($estadisticas['menus_activos']); ?></h3>
                        </div>
                        <div class="d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: var(--cesodo-red); border-radius: 12px;">
                            <i class="fas fa-play-circle" style="font-size: 1.5rem; color: white;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm h-100" style="background: white;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-uppercase mb-1" style="color: #666; font-size: 0.75rem; font-weight: 600; letter-spacing: 0.5px;">Planificados</p>
                            <h3 class="mb-0" style="color: var(--cesodo-black); font-weight: 700;"><?php echo e($estadisticas['menus_planificados']); ?></h3>
                        </div>
                        <div class="d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: #333; border-radius: 12px;">
                            <i class="fas fa-clock" style="font-size: 1.5rem; color: white;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido principal -->
    <div class="card border-0 shadow-sm" style="background: white;">
        <!-- Filtros y búsqueda -->
        <div class="card-body p-4">
            <form action="<?php echo e(route('menus.index')); ?>" method="GET">
                <div class="row g-3">
                    <div class="col-md-6 col-lg-3">
                        <label class="form-label" style="color: var(--cesodo-black); font-weight: 600; font-size: 0.875rem;">Buscar</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white" style="border-color: #dee2e6;">
                                <i class="fas fa-search" style="color: #666;"></i>
                            </span>
                            <input type="text" class="form-control" placeholder="Buscar menús..."
                                   name="search" value="<?php echo e(request('search')); ?>"
                                   style="border-left: none;">
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <label class="form-label" style="color: var(--cesodo-black); font-weight: 600; font-size: 0.875rem;">Estado</label>
                        <select class="form-select" name="estado">
                            <option value="">Todos los estados</option>
                            <option value="activo" <?php echo e(request('estado') == 'activo' ? 'selected' : ''); ?>>Activos</option>
                            <option value="planificado" <?php echo e(request('estado') == 'planificado' ? 'selected' : ''); ?>>Planificados</option>
                            <option value="completado" <?php echo e(request('estado') == 'completado' ? 'selected' : ''); ?>>Completados</option>
                            <option value="borrador" <?php echo e(request('estado') == 'borrador' ? 'selected' : ''); ?>>Borradores</option>
                        </select>
                    </div>
                    <div class="col-md-6 col-lg-2">
                        <label class="form-label" style="color: var(--cesodo-black); font-weight: 600; font-size: 0.875rem;">Desde</label>
                        <input type="date" class="form-control" name="fecha_desde" value="<?php echo e(request('fecha_desde')); ?>">
                    </div>
                    <div class="col-md-6 col-lg-2">
                        <label class="form-label" style="color: var(--cesodo-black); font-weight: 600; font-size: 0.875rem;">Hasta</label>
                        <input type="date" class="form-control" name="fecha_hasta" value="<?php echo e(request('fecha_hasta')); ?>">
                    </div>
                    <div class="col-lg-2">
                        <label class="form-label d-block" style="opacity: 0;">Acciones</label>
                        <button type="submit" class="btn btn-dark w-100">
                            <i class="fas fa-filter me-2"></i>Filtrar
                        </button>
                    </div>
                </div>

                <?php if(request()->hasAny(['search', 'estado', 'fecha_desde', 'fecha_hasta'])): ?>
                <div class="mt-3">
                    <a href="<?php echo e(route('menus.index')); ?>" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-times me-2"></i>Limpiar filtros
                    </a>
                </div>
                <?php endif; ?>
            </form>
        </div>

        <div class="card-body p-0">
            <?php if($menus->isEmpty()): ?>
                <!-- Estado vacío -->
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-clipboard-list" style="font-size: 4rem; color: #ccc;"></i>
                    </div>
                    <h5 style="color: var(--cesodo-black); font-weight: 600;">No se encontraron menús</h5>
                    <p class="text-muted mb-4">
                        <?php if(request()->has('search') || request()->has('estado') || request()->has('fecha_desde') || request()->has('fecha_hasta')): ?>
                            No hay resultados para los filtros seleccionados
                        <?php else: ?>
                            Aún no hay menús registrados en el sistema
                        <?php endif; ?>
                    </p>
                    <div>
                        <?php if(request()->has('search') || request()->has('estado') || request()->has('fecha_desde') || request()->has('fecha_hasta')): ?>
                            <a href="<?php echo e(route('menus.index')); ?>" class="btn btn-outline-dark">
                                <i class="fas fa-times me-2"></i>Limpiar filtros
                            </a>
                        <?php else: ?>
                            <a href="<?php echo e(route('menus.create')); ?>" class="btn btn-danger">
                                <i class="fas fa-plus me-2"></i>Crear primer menú
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else: ?>
                <!-- Tabla de menús -->
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead style="background: var(--cesodo-black);">
                            <tr>
                                <th class="ps-4 py-3" style="color: white; font-weight: 600; font-size: 0.8125rem; text-transform: uppercase; letter-spacing: 0.5px;">Menú</th>
                                <th class="py-3" style="color: white; font-weight: 600; font-size: 0.8125rem; text-transform: uppercase; letter-spacing: 0.5px;">Estado</th>
                                <th class="py-3" style="color: white; font-weight: 600; font-size: 0.8125rem; text-transform: uppercase; letter-spacing: 0.5px;">Platos</th>
                                <th class="py-3" style="color: white; font-weight: 600; font-size: 0.8125rem; text-transform: uppercase; letter-spacing: 0.5px;">Fecha Inicio</th>
                                <th class="py-3" style="color: white; font-weight: 600; font-size: 0.8125rem; text-transform: uppercase; letter-spacing: 0.5px;">Fecha Fin</th>
                                <th class="py-3" style="color: white; font-weight: 600; font-size: 0.8125rem; text-transform: uppercase; letter-spacing: 0.5px;">Costo</th>
                                <th class="text-center py-3 pe-4" style="color: white; font-weight: 600; font-size: 0.8125rem; text-transform: uppercase; letter-spacing: 0.5px;" width="180">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr style="border-bottom: 1px solid #f0f0f0;">
                                <td class="ps-4 py-3">
                                    <div>
                                        <h6 class="mb-1" style="color: var(--cesodo-black); font-weight: 600; font-size: 0.9375rem;"><?php echo e($menu->nombre); ?></h6>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge" style="background: #f5f5f5; color: var(--cesodo-black); font-weight: 500; font-size: 0.75rem;">
                                                <?php echo e(ucfirst($menu->tipo_menu)); ?>

                                            </span>
                                            <?php if($menu->descripcion): ?>
                                                <span style="color: #666; font-size: 0.8125rem;"><?php echo e(Str::limit($menu->descripcion, 40)); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <?php if($menu->estado == 'activo'): ?>
                                        <span class="badge px-3 py-2" style="background: var(--cesodo-red); color: white; font-weight: 500;">En Servicio</span>
                                    <?php elseif($menu->estado == 'planificado'): ?>
                                        <span class="badge px-3 py-2" style="background: #333; color: white; font-weight: 500;">Planificado</span>
                                    <?php elseif($menu->estado == 'borrador'): ?>
                                        <span class="badge px-3 py-2" style="background: #666; color: white; font-weight: 500;">Borrador</span>
                                    <?php elseif($menu->estado == 'completado'): ?>
                                        <span class="badge px-3 py-2" style="background: var(--cesodo-black); color: white; font-weight: 500;">Completado</span>
                                    <?php else: ?>
                                        <span class="badge px-3 py-2" style="background: #999; color: white; font-weight: 500;"><?php echo e(ucfirst($menu->estado)); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="flex-grow-1">
                                            <div class="progress" style="height: 6px; background: #f0f0f0; border-radius: 3px;">
                                                <div class="progress-bar"
                                                     style="width: <?php echo e(($menu->platos_disponibles / ($menu->platos_totales ?: 1)) * 100); ?>%; background: <?php echo e($menu->platos_disponibles > 0 ? 'var(--cesodo-red)' : '#ccc'); ?>;">
                                                </div>
                                            </div>
                                        </div>
                                        <span style="color: var(--cesodo-black); font-weight: 600; font-size: 0.875rem; white-space: nowrap;">
                                            <?php echo e($menu->platos_disponibles); ?>/<?php echo e($menu->platos_totales); ?>

                                        </span>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <div>
                                        <div style="color: var(--cesodo-black); font-weight: 600; font-size: 0.875rem;">
                                            <?php echo e($menu->fecha_inicio ? \Carbon\Carbon::parse($menu->fecha_inicio)->format('d/m/Y') : '-'); ?>

                                        </div>
                                        <?php if($menu->fecha_inicio): ?>
                                        <div style="color: #666; font-size: 0.8125rem;">
                                            <?php echo e(\Carbon\Carbon::parse($menu->fecha_inicio)->format('H:i')); ?>

                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <div>
                                        <div style="color: var(--cesodo-black); font-weight: 600; font-size: 0.875rem;">
                                            <?php echo e($menu->fecha_fin ? \Carbon\Carbon::parse($menu->fecha_fin)->format('d/m/Y') : '-'); ?>

                                        </div>
                                        <?php if($menu->fecha_fin): ?>
                                        <div style="color: #666; font-size: 0.8125rem;">
                                            <?php echo e(\Carbon\Carbon::parse($menu->fecha_fin)->format('H:i')); ?>

                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <div>
                                        <div style="color: var(--cesodo-black); font-weight: 600; font-size: 0.875rem;">
                                            S/ <?php echo e(number_format($menu->costo_estimado, 2)); ?>

                                        </div>
                                        <?php if($menu->costo_total != $menu->costo_estimado): ?>
                                            <div style="color: #666; font-size: 0.8125rem;">
                                                Real: S/ <?php echo e(number_format($menu->costo_total, 2)); ?>

                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="text-center py-3 pe-4">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="<?php echo e(route('menus.edit', $menu->id)); ?>"
                                           class="btn btn-sm btn-dark px-3"
                                           title="Editar">
                                            <i class="fas fa-edit me-1"></i>Editar
                                        </a>
                                        
                                        <!-- Dropdown de estado -->
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" title="Cambiar Estado">
                                                <i class="fas fa-exchange-alt me-1"></i>Estado
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><h6 class="dropdown-header">Cambiar a:</h6></li>
                                                <?php if($menu->estado !== 'borrador'): ?>
                                                <li>
                                                    <form action="<?php echo e(route('menus.cambiar-estado', $menu->id)); ?>" method="POST" class="d-inline">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('PATCH'); ?>
                                                        <input type="hidden" name="estado" value="borrador">
                                                        <button type="submit" class="dropdown-item">
                                                            <i class="fas fa-file text-secondary me-2"></i>Borrador
                                                        </button>
                                                    </form>
                                                </li>
                                                <?php endif; ?>
                                                <?php if($menu->estado !== 'planificado'): ?>
                                                <li>
                                                    <form action="<?php echo e(route('menus.cambiar-estado', $menu->id)); ?>" method="POST" class="d-inline">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('PATCH'); ?>
                                                        <input type="hidden" name="estado" value="planificado">
                                                        <button type="submit" class="dropdown-item">
                                                            <i class="fas fa-calendar-alt text-info me-2"></i>Planificado
                                                        </button>
                                                    </form>
                                                </li>
                                                <?php endif; ?>
                                                <?php if($menu->estado !== 'activo'): ?>
                                                <li>
                                                    <form action="<?php echo e(route('menus.cambiar-estado', $menu->id)); ?>" method="POST" class="d-inline">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('PATCH'); ?>
                                                        <input type="hidden" name="estado" value="activo">
                                                        <button type="submit" class="dropdown-item">
                                                            <i class="fas fa-check-circle text-success me-2"></i>Activo
                                                        </button>
                                                    </form>
                                                </li>
                                                <?php endif; ?>
                                                <?php if($menu->estado !== 'completado'): ?>
                                                <li>
                                                    <form action="<?php echo e(route('menus.cambiar-estado', $menu->id)); ?>" method="POST" class="d-inline">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('PATCH'); ?>
                                                        <input type="hidden" name="estado" value="completado">
                                                        <button type="submit" class="dropdown-item">
                                                            <i class="fas fa-flag-checkered text-dark me-2"></i>Completado
                                                        </button>
                                                    </form>
                                                </li>
                                                <?php endif; ?>
                                                <?php if($menu->estado !== 'cancelado'): ?>
                                                <li>
                                                    <form action="<?php echo e(route('menus.cambiar-estado', $menu->id)); ?>" method="POST" class="d-inline">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('PATCH'); ?>
                                                        <input type="hidden" name="estado" value="cancelado">
                                                        <button type="submit" class="dropdown-item">
                                                            <i class="fas fa-times-circle text-danger me-2"></i>Cancelado
                                                        </button>
                                                    </form>
                                                </li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                        
                                        <!-- Botón eliminar (solo si no está activo) -->
                                        <?php if($menu->estado !== 'activo'): ?>
                                        <form action="<?php echo e(route('menus.destroy', $menu->id)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit"
                                                    class="btn btn-sm btn-outline-danger px-3"
                                                    onclick="return confirm('¿Está seguro que desea eliminar este menú?')"
                                                    title="Eliminar">
                                                <i class="far fa-trash-alt me-1"></i>Eliminar
                                            </button>
                                        </form>
                                        <?php else: ?>
                                        <button type="button"
                                                class="btn btn-sm btn-outline-secondary px-3"
                                                disabled
                                                title="No se puede eliminar un menú activo. Cambia el estado primero.">
                                            <i class="far fa-trash-alt me-1"></i>Eliminar
                                        </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <?php if($menus instanceof \Illuminate\Pagination\LengthAwarePaginator && $menus->hasPages()): ?>
                    <div class="card-footer bg-white py-3 px-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div style="color: #666; font-size: 0.875rem;">
                                Mostrando <span style="font-weight: 600; color: var(--cesodo-black);"><?php echo e($menus->firstItem() ?? 0); ?></span>
                                a <span style="font-weight: 600; color: var(--cesodo-black);"><?php echo e($menus->lastItem() ?? 0); ?></span>
                                de <span style="font-weight: 600; color: var(--cesodo-black);"><?php echo e($menus->total() ?? 0); ?></span> menús
                            </div>
                            <div>
                                <?php echo e($menus->links('vendor.pagination.bootstrap-4')); ?>

                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cesodo4\resources\views/menus/index.blade.php ENDPATH**/ ?>