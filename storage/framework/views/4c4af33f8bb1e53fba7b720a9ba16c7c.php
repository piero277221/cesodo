<?php $__env->startSection('title', 'Gestión de Ventas'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-emerald-50">
    <!-- Header mejorado -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="container-fluid py-6">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="icon-shape bg-gradient-success shadow text-center border-radius-md me-3">
                                <i class="bi bi-receipt text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                            <div>
                                <h1 class="h3 mb-0 text-dark font-weight-bold">Sistema de Ventas</h1>
                                <p class="mb-0 text-sm text-muted">Gestiona facturación y ventas a clientes</p>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button onclick="exportVentas()" class="btn btn-outline-secondary">
                                <i class="bi bi-download me-2"></i>Exportar
                            </button>
                            <a href="<?php echo e(route('ventas.create')); ?>" class="btn btn-success btn-modern">
                                <i class="bi bi-plus-circle me-2"></i>Nueva Venta
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid py-4">
        <!-- Estadísticas rápidas -->
        <div class="row mb-4">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card stats-card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Ventas del día</p>
                                    <h5 class="font-weight-bolder">$<?php echo e(number_format(0, 0, ',', '.')); ?></h5>
                                    <p class="mb-0">
                                        <span class="text-success text-sm font-weight-bolder">0</span> ventas
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                    <i class="bi bi-calendar-day text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card stats-card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Del mes</p>
                                    <h5 class="font-weight-bolder text-success">$<?php echo e(number_format(0, 0, ',', '.')); ?></h5>
                                    <p class="mb-0">
                                        <span class="text-success text-sm font-weight-bolder">0</span> ventas
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                    <i class="bi bi-calendar-month text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card stats-card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Promedio venta</p>
                                    <h5 class="font-weight-bolder text-info">$<?php echo e(number_format(0, 0, ',', '.')); ?></h5>
                                    <p class="mb-0">
                                        <span class="text-info text-sm font-weight-bolder">por transacción</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-info shadow-info text-center rounded-circle">
                                    <i class="bi bi-graph-up text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card stats-card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Pendientes</p>
                                    <h5 class="font-weight-bolder text-warning">0</h5>
                                    <p class="mb-0">
                                        <span class="text-warning text-sm font-weight-bolder">por cobrar</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                    <i class="bi bi-clock text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tarjeta principal -->
        <div class="card card-modern">
            <!-- Filtros de búsqueda mejorados -->
            <div class="card-header border-0 pb-0">
                <div class="row">
                    <div class="col-12">
                        <form method="GET" action="<?php echo e(route('ventas.index')); ?>" class="filter-form">
                            <div class="row g-3 align-items-end">
                                <div class="col-md-3">
                                    <label class="form-label text-sm font-weight-bold">Buscar</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                                        <input type="text" name="search" class="form-control"
                                               placeholder="Número, cliente..."
                                               value="<?php echo e(request('search')); ?>">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label text-sm font-weight-bold">Estado</label>
                                    <select name="estado" class="form-select">
                                        <option value="">Todos</option>
                                        <option value="pendiente" <?php echo e(request('estado') == 'pendiente' ? 'selected' : ''); ?>>Pendiente</option>
                                        <option value="pagada" <?php echo e(request('estado') == 'pagada' ? 'selected' : ''); ?>>Pagada</option>
                                        <option value="anulada" <?php echo e(request('estado') == 'anulada' ? 'selected' : ''); ?>>Anulada</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label text-sm font-weight-bold">Desde</label>
                                    <input type="date" name="fecha_desde" class="form-control" value="<?php echo e(request('fecha_desde')); ?>">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label text-sm font-weight-bold">Hasta</label>
                                    <input type="date" name="fecha_hasta" class="form-control" value="<?php echo e(request('fecha_hasta')); ?>">
                                </div>
                                <div class="col-md-3">
                                    <div class="d-flex gap-2 align-items-end h-100">
                                        <button type="submit" class="btn btn-success btn-modern">
                                            <i class="bi bi-search me-1"></i> Buscar
                                        </button>
                                        <a href="<?php echo e(route('ventas.index')); ?>" class="btn btn-outline-secondary">
                                            <i class="bi bi-arrow-clockwise"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Tabla de ventas mejorada -->
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table table-modern align-items-center mb-0">
                        <thead>
                            <tr>
                                <th>Venta</th>
                                <th>Cliente</th>
                                <th>Fecha</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="bi bi-receipt text-muted" style="font-size: 3rem;"></i>
                                        <h6 class="text-muted mt-3">No hay ventas registradas</h6>
                                        <p class="text-sm text-muted mb-3">Comienza registrando tu primera venta</p>
                                        <a href="<?php echo e(route('ventas.create')); ?>" class="btn btn-success btn-modern">
                                            <i class="bi bi-plus-circle me-2"></i>Nueva Venta
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
<style>
/* Estilos modernos para ventas */
.bg-gradient-to-br {
    background: linear-gradient(135deg, #f0fdf4 0%, #ffffff 50%, #ecfdf5 100%);
}

.stats-card {
    transition: all 0.3s ease;
    border: none;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.stats-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

.card-modern {
    border: none;
    border-radius: 1rem;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    backdrop-filter: blur(10px);
    background: rgba(255, 255, 255, 0.95);
}

.btn-modern {
    border-radius: 0.75rem;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    text-transform: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.btn-modern:hover {
    transform: translateY(-1px);
    box-shadow: 0 8px 15px -3px rgba(0, 0, 0, 0.2);
}

.filter-form {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 1rem;
    margin-bottom: 1.5rem;
}

.form-control, .form-select {
    border-radius: 0.5rem;
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #10b981;
    box-shadow: 0 0 0 0.2rem rgba(16, 185, 129, 0.25);
}

.input-group-text {
    border-radius: 0.5rem 0 0 0.5rem;
    background: #f8f9fa;
    border-color: #e9ecef;
}

.table-modern {
    border-radius: 0.75rem;
    overflow: hidden;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
}

.table-modern thead th {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.05em;
    border: none;
    padding: 1rem 0.75rem;
}

.table-modern tbody tr {
    transition: all 0.3s ease;
}

.table-modern tbody tr:hover {
    background-color: #f8f9fa;
    transform: scale(1.01);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.table-modern tbody td {
    padding: 1rem 0.75rem;
    vertical-align: middle;
    border-color: #e9ecef;
}

.icon-shape {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('js'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit en cambio de filtros
    const filtros = document.querySelectorAll('select[name="estado"]');
    filtros.forEach(filtro => {
        filtro.addEventListener('change', function() {
            this.form.submit();
        });
    });

    // Función para exportar ventas
    window.exportVentas = function() {
        const searchParams = new URLSearchParams(window.location.search);
        searchParams.set('export', 'excel');
        window.location.href = `<?php echo e(route('ventas.index')); ?>?${searchParams.toString()}`;
    };
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cesodo4\resources\views/ventas/index.blade.php ENDPATH**/ ?>