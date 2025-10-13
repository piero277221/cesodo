<?php $__env->startSection('title', 'Gestión de Clientes'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Header con diseño CESODO -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 fw-bold" style="color: #1a1a1a;">
                <i class="fas fa-users me-2" style="color: #dc2626;"></i>
                Gestión de Clientes
            </h1>
            <p class="text-muted mb-0">Administra toda la información de tus clientes</p>
        </div>
        <div class="d-flex gap-2">
            <button onclick="exportClientes()" class="btn btn-outline-dark">
                <i class="fas fa-download me-2"></i>Exportar
            </button>
            <a href="<?php echo e(route('clientes.create')); ?>" class="btn" style="background-color: #dc2626; color: white; border: none;">
                <i class="fas fa-plus-circle me-2"></i>Nuevo Cliente
            </a>
        </div>
    </div>

    <!-- Estadísticas rápidas -->
    <div class="row mb-4">
        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card shadow-sm border-0" style="border-left: 4px solid #dc2626;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted text-uppercase mb-1" style="font-size: 0.75rem; font-weight: 600;">Total Clientes</p>
                            <h3 class="mb-0 fw-bold" style="color: #1a1a1a;"><?php echo e($clientes->total() ?? 0); ?></h3>
                        </div>
                        <div class="icon-box" style="background-color: #dc2626;">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card shadow-sm border-0" style="border-left: 4px solid #10b981;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted text-uppercase mb-1" style="font-size: 0.75rem; font-weight: 600;">Activos</p>
                            <h3 class="mb-0 fw-bold text-success"><?php echo e($clientes->where('estado', 'activo')->count() ?? 0); ?></h3>
                        </div>
                        <div class="icon-box" style="background-color: #10b981;">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card shadow-sm border-0" style="border-left: 4px solid #3b82f6;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted text-uppercase mb-1" style="font-size: 0.75rem; font-weight: 600;">Nuevos (Este mes)</p>
                            <h3 class="mb-0 fw-bold text-info"><?php echo e($clientes->where('created_at', '>=', now()->startOfMonth())->count() ?? 0); ?></h3>
                        </div>
                        <div class="icon-box" style="background-color: #3b82f6;">
                            <i class="fas fa-user-plus"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card shadow-sm border-0" style="border-left: 4px solid #1a1a1a;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted text-uppercase mb-1" style="font-size: 0.75rem; font-weight: 600;">Ventas del mes</p>
                            <h3 class="mb-0 fw-bold" style="color: #1a1a1a;">$<?php echo e(number_format(0, 0, ',', '.')); ?></h3>
                        </div>
                        <div class="icon-box" style="background-color: #1a1a1a;">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tarjeta principal con tabla -->
    <div class="card shadow-sm border-0">
        <!-- Filtros de búsqueda -->
        <div class="card-header py-3" style="background-color: #1a1a1a;">
            <h6 class="mb-0 text-white fw-bold">
                <i class="fas fa-filter me-2"></i>Filtros de Búsqueda
            </h6>
        </div>
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('clientes.index')); ?>">
                <div class="row g-3 align-items-end mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Buscar Cliente</label>
                        <div class="input-group">
                            <span class="input-group-text" style="background-color: #f8f9fa;">
                                <i class="fas fa-search" style="color: #dc2626;"></i>
                            </span>
                            <input type="text" name="search" class="form-control"
                                   placeholder="Nombre, email, teléfono o RUT..."
                                   value="<?php echo e(request('search')); ?>">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Tipo</label>
                        <select name="tipo" class="form-select">
                            <option value="">Todos los tipos</option>
                            <option value="natural" <?php echo e(request('tipo') == 'natural' ? 'selected' : ''); ?>>Persona Natural</option>
                            <option value="juridica" <?php echo e(request('tipo') == 'juridica' ? 'selected' : ''); ?>>Persona Jurídica</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Estado</label>
                        <select name="estado" class="form-select">
                            <option value="">Todos los estados</option>
                            <option value="activo" <?php echo e(request('estado') == 'activo' ? 'selected' : ''); ?>>Activo</option>
                            <option value="inactivo" <?php echo e(request('estado') == 'inactivo' ? 'selected' : ''); ?>>Inactivo</option>
                            <option value="suspendido" <?php echo e(request('estado') == 'suspendido' ? 'selected' : ''); ?>>Suspendido</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Ordenar por</label>
                        <select name="sort" class="form-select">
                            <option value="nombre" <?php echo e(request('sort') == 'nombre' ? 'selected' : ''); ?>>Nombre</option>
                            <option value="created_at" <?php echo e(request('sort') == 'created_at' ? 'selected' : ''); ?>>Fecha registro</option>
                            <option value="estado" <?php echo e(request('sort') == 'estado' ? 'selected' : ''); ?>>Estado</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-dark flex-fill">
                                <i class="fas fa-search me-1"></i> Buscar
                            </button>
                            <a href="<?php echo e(route('clientes.index')); ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-redo"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Tabla de clientes -->
        <div class="card-body pt-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead style="background-color: #1a1a1a;">
                        <tr>
                            <th class="text-white fw-semibold">Cliente</th>
                            <th class="text-white fw-semibold">Contacto</th>
                            <th class="text-white fw-semibold">Tipo</th>
                            <th class="text-white fw-semibold">Ventas</th>
                            <th class="text-white fw-semibold">Estado</th>
                            <th class="text-white fw-semibold text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="cliente-row">
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-3">
                                        <?php echo e(strtoupper(substr($cliente->nombre, 0, 2))); ?>

                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-semibold"><?php echo e($cliente->nombre); ?></h6>
                                        <?php if($cliente->rut): ?>
                                            <small class="text-muted">
                                                <i class="fas fa-id-card me-1"></i><?php echo e($cliente->rut); ?>

                                            </small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <?php if($cliente->email): ?>
                                        <p class="mb-1">
                                            <i class="fas fa-envelope me-1" style="color: #dc2626;"></i>
                                            <small><?php echo e($cliente->email); ?></small>
                                        </p>
                                    <?php endif; ?>
                                    <?php if($cliente->telefono): ?>
                                        <p class="mb-0">
                                            <i class="fas fa-phone me-1" style="color: #1a1a1a;"></i>
                                            <small><?php echo e($cliente->telefono); ?></small>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <?php if($cliente->tipo == 'natural'): ?>
                                    <span class="badge" style="background-color: #3b82f6; color: white;">
                                        <i class="fas fa-user me-1"></i>Natural
                                    </span>
                                <?php else: ?>
                                    <span class="badge" style="background-color: #f59e0b; color: white;">
                                        <i class="fas fa-building me-1"></i>Jurídica
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div>
                                    <span class="fw-bold" style="color: #1a1a1a;">$<?php echo e(number_format(0, 0, ',', '.')); ?></span>
                                    <br>
                                    <small class="text-muted">0 ventas</small>
                                </div>
                            </td>
                            <td>
                                <?php if($cliente->estado == 'activo'): ?>
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i>Activo
                                    </span>
                                <?php elseif($cliente->estado == 'inactivo'): ?>
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-times-circle me-1"></i>Inactivo
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark">
                                        <i class="fas fa-pause-circle me-1"></i>Suspendido
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="<?php echo e(route('clientes.show', $cliente)); ?>"
                                       class="btn btn-sm btn-outline-dark" title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?php echo e(route('clientes.edit', $cliente)); ?>"
                                       class="btn btn-sm btn-outline-dark" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="<?php echo e(route('clientes.destroy', $cliente)); ?>" method="POST"
                                          class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar este cliente?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm" style="background-color: #dc2626; color: white; border: none;" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="fas fa-users fa-4x text-muted mb-3"></i>
                                    <h5 class="text-muted">No hay clientes registrados</h5>
                                    <p class="text-muted">Comienza agregando tu primer cliente</p>
                                    <a href="<?php echo e(route('clientes.create')); ?>" class="btn" style="background-color: #dc2626; color: white;">
                                        <i class="fas fa-plus me-2"></i>Agregar Cliente
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <?php if($clientes->hasPages()): ?>
            <div class="d-flex justify-content-center mt-4">
                <?php echo e($clientes->appends(request()->query())->links()); ?>

            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
<style>
/* Estilos CESODO para clientes */
.icon-box {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
}

.avatar-circle {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: linear-gradient(135deg, #1a1a1a 0%, #dc2626 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 0.9rem;
    flex-shrink: 0;
}

.cliente-row {
    transition: all 0.2s ease;
}

.cliente-row:hover {
    background-color: #f8f9fa;
    transform: translateX(5px);
}

.table thead th {
    padding: 15px 12px;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
}

.table tbody td {
    padding: 15px 12px;
}

.btn-group .btn {
    transition: all 0.2s ease;
}

.btn-group .btn:hover {
    transform: translateY(-2px);
}

.badge {
    padding: 0.5rem 0.75rem;
    font-weight: 600;
    font-size: 0.75rem;
    border-radius: 6px;
}

.form-control:focus,
.form-select:focus {
    border-color: #dc2626;
    box-shadow: 0 0 0 0.2rem rgba(220, 38, 38, 0.25);
}

.card {
    transition: all 0.3s ease;
}

.card:hover {
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1) !important;
}

/* Animación de entrada */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.table tbody tr {
    animation: fadeInUp 0.4s ease forwards;
}

/* Responsive */
@media (max-width: 768px) {
    .icon-box {
        width: 40px;
        height: 40px;
        font-size: 1.2rem;
    }

    .avatar-circle {
        width: 35px;
        height: 35px;
        font-size: 0.8rem;
    }

    .btn-group {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('js'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Función para exportar clientes
    window.exportClientes = function() {
        alert('Función de exportación en desarrollo');
        // Aquí se implementaría la lógica de exportación
    };
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cesodo4\resources\views/clientes/index.blade.php ENDPATH**/ ?>