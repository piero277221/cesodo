<?php $__env->startSection('title', 'Trabajadores'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid fade-in">
    <!-- Header moderno con estadísticas -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-modern">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <div class="icon-shape me-3" style="background: var(--primary-color);">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div>
                                    <h1 class="h3 mb-1 text-primary">Gestión de Trabajadores</h1>
                                    <p class="text-muted mb-0">Administra el personal y sus asignaciones</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="<?php echo e(route('trabajadores.create')); ?>" class="btn btn-primary btn-lg">
                                <i class="fas fa-plus me-2"></i>
                                Nuevo Trabajador
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Estadísticas rápidas -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-modern h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape" style="background: var(--success-color);">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <div class="ms-3">
                            <div class="text-muted small">Trabajadores Activos</div>
                            <div class="h4 mb-0 text-success"><?php echo e($trabajadores->where('estado', 'activo')->count()); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-modern h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape" style="background: var(--info-color);">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="ms-3">
                            <div class="text-muted small">Áreas Diferentes</div>
                            <div class="h4 mb-0 text-info"><?php echo e($trabajadores->pluck('area')->unique()->count()); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-modern h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape" style="background: var(--warning-color);">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="ms-3">
                            <div class="text-muted small">Con Contrato</div>
                            <div class="h4 mb-0 text-warning"><?php echo e($trabajadores->where('tipo_contrato', '!=', null)->count()); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-modern h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape" style="background: var(--primary-color);">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="ms-3">
                            <div class="text-muted small">Total Trabajadores</div>
                            <div class="h4 mb-0"><?php echo e($trabajadores->count()); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Filtros y búsqueda modernos -->
    <div class="card border-0 shadow-modern mb-4">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-filter me-2"></i>
                Filtros de Búsqueda
            </h5>
        </div>
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('trabajadores.index')); ?>" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">Buscar</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" class="form-control" id="search" name="search"
                               value="<?php echo e(request('search')); ?>"
                               placeholder="Nombre, DNI, email, área...">
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="area" class="form-label">Área</label>
                    <select class="form-select" id="area" name="area">
                        <option value="">Todas las áreas</option>
                        <option value="Administración" <?php echo e(request('area') == 'Administración' ? 'selected' : ''); ?>>Administración</option>
                                <option value="Recursos Humanos" <?php echo e(request('area') == 'Recursos Humanos' ? 'selected' : ''); ?>>Recursos Humanos</option>
                                <option value="Finanzas" <?php echo e(request('area') == 'Finanzas' ? 'selected' : ''); ?>>Finanzas</option>
                                <option value="Operaciones" <?php echo e(request('area') == 'Operaciones' ? 'selected' : ''); ?>>Operaciones</option>
                                <option value="Ventas" <?php echo e(request('area') == 'Ventas' ? 'selected' : ''); ?>>Ventas</option>
                                <option value="Marketing" <?php echo e(request('area') == 'Marketing' ? 'selected' : ''); ?>>Marketing</option>
                                <option value="Tecnología" <?php echo e(request('area') == 'Tecnología' ? 'selected' : ''); ?>>Tecnología</option>
                                <option value="Logística" <?php echo e(request('area') == 'Logística' ? 'selected' : ''); ?>>Logística</option>
                                <option value="Calidad" <?php echo e(request('area') == 'Calidad' ? 'selected' : ''); ?>>Calidad</option>
                                <option value="Seguridad" <?php echo e(request('area') == 'Seguridad' ? 'selected' : ''); ?>>Seguridad</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="estado" class="form-label">Estado</label>
                            <select class="form-select" id="estado" name="estado">
                                <option value="">Todos</option>
                                <option value="Activo" <?php echo e(request('estado') == 'Activo' ? 'selected' : ''); ?>>Activo</option>
                                <option value="Inactivo" <?php echo e(request('estado') == 'Inactivo' ? 'selected' : ''); ?>>Inactivo</option>
                                <option value="Suspendido" <?php echo e(request('estado') == 'Suspendido' ? 'selected' : ''); ?>>Suspendido</option>
                                <option value="Vacaciones" <?php echo e(request('estado') == 'Vacaciones' ? 'selected' : ''); ?>>Vacaciones</option>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-outline-primary me-2">
                                <i class="fas fa-search"></i> Buscar
                            </button>
                            <a href="<?php echo e(route('trabajadores.index')); ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Estadísticas rápidas -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Total Trabajadores</h6>
                                    <h3 class="mb-0"><?php echo e(isset($trabajadores) ? (is_object($trabajadores) && method_exists($trabajadores, 'total') ? $trabajadores->total() : count($trabajadores)) : 0); ?></h3>
                                </div>
                                <div>
                                    <i class="fas fa-users fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Activos</h6>
                                    <h3 class="mb-0"><?php echo e(isset($stats['activos']) ? $stats['activos'] : 0); ?></h3>
                                </div>
                                <div>
                                    <i class="fas fa-check-circle fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">En Vacaciones</h6>
                                    <h3 class="mb-0"><?php echo e(isset($stats['vacaciones']) ? $stats['vacaciones'] : 0); ?></h3>
                                </div>
                                <div>
                                    <i class="fas fa-umbrella-beach fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Nuevos Este Mes</h6>
                                    <h3 class="mb-0"><?php echo e(isset($stats['nuevos_mes']) ? $stats['nuevos_mes'] : 0); ?></h3>
                                </div>
                                <div>
                                    <i class="fas fa-user-plus fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de trabajadores -->
            <div class="card">
                <div class="card-body">
                    <?php if(!empty($trabajadores) && count($trabajadores) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>
                                            <a href="<?php echo e(route('trabajadores.index', array_merge(request()->all(), ['sort' => 'id', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']))); ?>"
                                               class="text-white text-decoration-none">
                                                ID
                                                <i class="fas fa-sort ms-1"></i>
                                            </a>
                                        </th>
                                        <th>
                                            <a href="<?php echo e(route('trabajadores.index', array_merge(request()->all(), ['sort' => 'nombres', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']))); ?>"
                                               class="text-white text-decoration-none">
                                                Trabajador
                                                <i class="fas fa-sort ms-1"></i>
                                            </a>
                                        </th>
                                        <th>DNI</th>
                                        <th>Contacto</th>
                                        <th>Área/Cargo</th>
                                        <th>Fecha Ingreso</th>
                                        <th>Estado</th>
                                        <th width="180">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $trabajadores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trabajador): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><strong>#<?php echo e($trabajador->id); ?></strong></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="me-3">
                                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                                             style="width: 40px; height: 40px;">
                                                            <i class="fas fa-user"></i>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold"><?php echo e($trabajador->nombres ?? 'N/A'); ?> <?php echo e($trabajador->apellidos ?? ''); ?></div>
                                                        <?php if($trabajador->codigo): ?>
                                                            <small class="text-muted">Código: <?php echo e($trabajador->codigo); ?></small>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <?php if($trabajador->dni): ?>
                                                    <span class="badge bg-info"><?php echo e($trabajador->dni); ?></span>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($trabajador->email): ?>
                                                    <div><i class="fas fa-envelope text-muted me-1"></i><?php echo e($trabajador->email); ?></div>
                                                <?php endif; ?>
                                                <?php if($trabajador->telefono): ?>
                                                    <div><i class="fas fa-phone text-muted me-1"></i><?php echo e($trabajador->telefono); ?></div>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($trabajador->area): ?>
                                                    <div><span class="badge bg-secondary"><?php echo e($trabajador->area); ?></span></div>
                                                <?php endif; ?>
                                                <?php if($trabajador->cargo): ?>
                                                    <div><small class="text-muted"><?php echo e($trabajador->cargo); ?></small></div>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($trabajador->fecha_ingreso): ?>
                                                    <small><?php echo e(\Carbon\Carbon::parse($trabajador->fecha_ingreso)->format('d/m/Y')); ?></small>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php
                                                    $estado = $trabajador->estado ?? 'Activo';
                                                    $badgeClass = match($estado) {
                                                        'Activo' => 'bg-success',
                                                        'Inactivo' => 'bg-danger',
                                                        'Suspendido' => 'bg-warning',
                                                        'Vacaciones' => 'bg-info',
                                                        default => 'bg-secondary'
                                                    };
                                                ?>
                                                <span class="badge <?php echo e($badgeClass); ?>"><?php echo e($estado); ?></span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?php echo e(route('trabajadores.show', $trabajador)); ?>"
                                                       class="btn btn-sm btn-outline-info"
                                                       title="Ver detalles">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="<?php echo e(route('trabajadores.edit', $trabajador)); ?>"
                                                       class="btn btn-sm btn-outline-warning"
                                                       title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form method="POST" action="<?php echo e(route('trabajadores.destroy', $trabajador)); ?>"
                                                          style="display: inline;"
                                                          onsubmit="return confirm('¿Está seguro de eliminar este trabajador?')">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button type="submit"
                                                                class="btn btn-sm btn-outline-danger"
                                                                title="Eliminar">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        <?php if(is_object($trabajadores) && method_exists($trabajadores, 'links')): ?>
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <div>
                                    <small class="text-muted">
                                        Mostrando <?php echo e($trabajadores->firstItem() ?? 0); ?> a <?php echo e($trabajadores->lastItem() ?? 0); ?>

                                        de <?php echo e($trabajadores->total() ?? 0); ?> resultados
                                    </small>
                                </div>
                                <div>
                                    <?php echo e($trabajadores->appends(request()->query())->links()); ?>

                                </div>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">No hay trabajadores registrados</h4>
                            <p class="text-muted mb-4">Comience agregando el primer trabajador al sistema</p>
                            <a href="<?php echo e(route('trabajadores.create')); ?>" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i>
                                Crear Primer Trabajador
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cesodo4\resources\views/trabajadores/index.blade.php ENDPATH**/ ?>