<?php $__env->startSection('title', 'Gestión de Consumos'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Header del módulo -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-utensils text-primary me-2"></i>
                Gestión de Consumos
            </h1>
            <p class="text-muted mb-0">Administre los registros de consumo de alimentos de los trabajadores</p>
        </div>
        <div>
            <a href="<?php echo e(route('consumos.create')); ?>" class="btn btn-primary shadow-sm">
                <i class="fas fa-plus me-2"></i>
                Nuevo Consumo
            </a>
        </div>
    </div>

    <!-- Tarjetas de estadísticas mejoradas -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-primary shadow h-100 py-2 hover-shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Consumos Hoy
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo e($totalHoy ?? 0); ?>

                            </div>
                            <div class="text-xs text-muted mt-1">
                                <i class="fas fa-calendar-day me-1"></i>
                                <?php echo e(date('d/m/Y')); ?>

                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="icon-circle bg-primary">
                                <i class="fas fa-calendar-day text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-success shadow h-100 py-2 hover-shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Semana
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo e($totalSemana ?? 0); ?>

                            </div>
                            <div class="text-xs text-muted mt-1">
                                <i class="fas fa-calendar-week me-1"></i>
                                Semana actual
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="icon-circle bg-success">
                                <i class="fas fa-calendar-week text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-info shadow h-100 py-2 hover-shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Trabajadores Activos
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo e($trabajadoresActivos ?? 0); ?>

                            </div>
                            <div class="text-xs text-muted mt-1">
                                <i class="fas fa-users me-1"></i>
                                Con consumos registrados
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="icon-circle bg-info">
                                <i class="fas fa-users text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-warning shadow h-100 py-2 hover-shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Registros
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo e($totalRegistros ?? 0); ?>

                            </div>
                            <div class="text-xs text-muted mt-1">
                                <i class="fas fa-clipboard-list me-1"></i>
                                Histórico completo
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="icon-circle bg-warning">
                                <i class="fas fa-clipboard-list text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tarjeta principal con filtros y tabla -->
    <div class="card shadow border-0">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-table me-2"></i>
                        Listado de Consumos
                    </h6>
                </div>
                <div class="col-auto">
                    <small class="text-muted">
                        <?php if(isset($consumos) && method_exists($consumos, 'total')): ?>
                            Mostrando <?php echo e($consumos->firstItem() ?? 0); ?> - <?php echo e($consumos->lastItem() ?? 0); ?> de <?php echo e($consumos->total()); ?> registros
                        <?php endif; ?>
                    </small>
                </div>
            </div>
        </div>

        <!-- Panel de filtros mejorado -->
        <div class="card-body border-bottom">
            <form method="GET" action="<?php echo e(route('consumos.index')); ?>">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label text-sm font-weight-bold">Buscar</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" name="search" class="form-control"
                                   placeholder="Nombre, apellido o código..."
                                   value="<?php echo e(request('search')); ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label text-sm font-weight-bold">Fecha Inicio</label>
                        <input type="date" name="fecha_inicio" class="form-control"
                               value="<?php echo e(request('fecha_inicio')); ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label text-sm font-weight-bold">Fecha Fin</label>
                        <input type="date" name="fecha_fin" class="form-control"
                               value="<?php echo e(request('fecha_fin')); ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label text-sm font-weight-bold">Tipo Comida</label>
                        <select name="tipo_comida" class="form-select">
                            <option value="">Todos</option>
                            <option value="desayuno" <?php echo e(request('tipo_comida') == 'desayuno' ? 'selected' : ''); ?>>
                                Desayuno
                            </option>
                            <option value="almuerzo" <?php echo e(request('tipo_comida') == 'almuerzo' ? 'selected' : ''); ?>>
                                Almuerzo
                            </option>
                            <option value="cena" <?php echo e(request('tipo_comida') == 'cena' ? 'selected' : ''); ?>>
                                Cena
                            </option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label text-sm font-weight-bold">Trabajador</label>
                        <select name="trabajador_id" class="form-select">
                            <option value="">Todos</option>
                            <?php $__currentLoopData = $trabajadores ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trabajador): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($trabajador->id); ?>"
                                        <?php echo e(request('trabajador_id') == $trabajador->id ? 'selected' : ''); ?>>
                                    <?php echo e($trabajador->nombres); ?> <?php echo e($trabajador->apellidos); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <label class="form-label text-sm font-weight-bold">&nbsp;</label>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-filter"></i>
                            </button>
                            <a href="<?php echo e(route('consumos.index')); ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Tabla responsiva mejorada -->
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 text-xs font-weight-bold text-primary text-uppercase">
                                <i class="fas fa-calendar me-1"></i>Fecha/Hora
                            </th>
                            <th class="border-0 text-xs font-weight-bold text-primary text-uppercase">
                                <i class="fas fa-user me-1"></i>Trabajador
                            </th>
                            <th class="border-0 text-xs font-weight-bold text-primary text-uppercase">
                                <i class="fas fa-utensils me-1"></i>Tipo Comida
                            </th>
                            <th class="border-0 text-xs font-weight-bold text-primary text-uppercase">
                                <i class="fas fa-comment me-1"></i>Observaciones
                            </th>
                            <th class="border-0 text-xs font-weight-bold text-primary text-uppercase">
                                <i class="fas fa-user-shield me-1"></i>Registrado por
                            </th>
                            <th class="border-0 text-xs font-weight-bold text-primary text-uppercase text-center">
                                <i class="fas fa-cogs me-1"></i>Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $consumos ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $consumo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="border-bottom">
                                <td class="py-3">
                                    <div class="d-flex flex-column">
                                        <span class="font-weight-bold text-dark">
                                            <?php echo e($consumo->fecha_consumo ? date('d/m/Y', strtotime($consumo->fecha_consumo)) : 'N/A'); ?>

                                        </span>
                                        <small class="text-muted">
                                            <i class="fas fa-clock me-1"></i>
                                            <?php echo e($consumo->hora_consumo ? date('H:i', strtotime($consumo->hora_consumo)) : 'N/A'); ?>

                                        </small>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <?php if($consumo->trabajador): ?>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-3">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                            <div>
                                                <div class="font-weight-bold text-dark">
                                                    <?php echo e($consumo->trabajador->nombres); ?> <?php echo e($consumo->trabajador->apellidos); ?>

                                                </div>
                                                <small class="text-muted">
                                                    Código: <?php echo e($consumo->trabajador->codigo); ?>

                                                </small>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <span class="badge badge-danger">Trabajador no encontrado</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3">
                                    <span class="badge badge-pill badge-<?php echo e($consumo->tipo_comida == 'desayuno' ? 'warning' : ($consumo->tipo_comida == 'almuerzo' ? 'success' : 'info')); ?> px-3 py-2">
                                        <i class="<?php echo e($iconos[$consumo->tipo_comida] ?? 'fas fa-utensils'); ?> me-1"></i>
                                        <?php echo e(ucfirst($consumo->tipo_comida)); ?>

                                    </span>
                                </td>
                                <td class="py-3">
                                    <span class="text-muted">
                                        <?php echo e(Str::limit($consumo->observaciones ?? 'Sin observaciones', 50)); ?>

                                    </span>
                                </td>
                                <td class="py-3">
                                    <?php if($consumo->user): ?>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-xs bg-success rounded-circle d-flex align-items-center justify-content-center me-2">
                                                <i class="fas fa-user-shield text-white"></i>
                                            </div>
                                            <span class="text-dark"><?php echo e($consumo->user->name); ?></span>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted">
                                            <i class="fas fa-robot me-1"></i>Sistema
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3 text-center">
                                    <div class="btn-group" role="group">
                                        <a href="<?php echo e(route('consumos.show', $consumo)); ?>"
                                           class="btn btn-outline-info btn-sm"
                                           title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?php echo e(route('consumos.edit', $consumo)); ?>"
                                           class="btn btn-outline-warning btn-sm"
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="<?php echo e(route('consumos.destroy', $consumo)); ?>"
                                              method="POST"
                                              style="display: inline;"
                                              onsubmit="return confirm('¿Está seguro de que desea eliminar este consumo?')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit"
                                                    class="btn btn-outline-danger btn-sm"
                                                    title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="empty-state">
                                        <div class="empty-state-icon mb-3">
                                            <i class="fas fa-inbox fa-4x text-muted"></i>
                                        </div>
                                        <h5 class="text-muted mb-2">No hay consumos registrados</h5>
                                        <p class="text-muted mb-4">
                                            <?php if(request()->hasAny(['search', 'fecha_inicio', 'fecha_fin', 'tipo_comida', 'trabajador_id'])): ?>
                                                No se encontraron consumos que coincidan con los filtros aplicados.
                                            <?php else: ?>
                                                Comience creando el primer registro de consumo.
                                            <?php endif; ?>
                                        </p>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="<?php echo e(route('consumos.create')); ?>" class="btn btn-primary">
                                                <i class="fas fa-plus me-1"></i>
                                                Crear Primer Consumo
                                            </a>
                                            <?php if(request()->hasAny(['search', 'fecha_inicio', 'fecha_fin', 'tipo_comida', 'trabajador_id'])): ?>
                                                <a href="<?php echo e(route('consumos.index')); ?>" class="btn btn-outline-secondary">
                                                    <i class="fas fa-times me-1"></i>
                                                    Limpiar Filtros
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Paginación mejorada -->
        <?php if(isset($consumos) && method_exists($consumos, 'links')): ?>
            <div class="card-footer bg-white border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        Mostrando <?php echo e($consumos->firstItem() ?? 0); ?> - <?php echo e($consumos->lastItem() ?? 0); ?>

                        de <?php echo e($consumos->total()); ?> registros
                    </div>
                    <div>
                        <?php echo e($consumos->links()); ?>

                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Estilos CSS personalizados -->
<style>
.border-left-primary {
    border-left: 4px solid #4e73df !important;
}
.border-left-success {
    border-left: 4px solid #1cc88a !important;
}
.border-left-info {
    border-left: 4px solid #36b9cc !important;
}
.border-left-warning {
    border-left: 4px solid #f6c23e !important;
}

.hover-shadow:hover {
    box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.15) !important;
    transform: translateY(-2px);
    transition: all 0.3s ease;
}

.icon-circle {
    width: 3rem;
    height: 3rem;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.avatar-sm {
    width: 2.5rem;
    height: 2.5rem;
}

.avatar-xs {
    width: 1.5rem;
    height: 1.5rem;
}

.empty-state {
    padding: 2rem;
}

.badge-pill {
    border-radius: 50rem;
}

.table th {
    border-top: none;
    font-size: 0.75rem;
    letter-spacing: 0.05em;
    padding: 1rem 0.75rem;
}

.table td {
    padding: 0.75rem;
    vertical-align: middle;
}

.btn-group .btn {
    margin: 0 1px;
}

.form-label {
    margin-bottom: 0.25rem;
    font-size: 0.875rem;
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cesodo4\resources\views/consumos/index_new.blade.php ENDPATH**/ ?>