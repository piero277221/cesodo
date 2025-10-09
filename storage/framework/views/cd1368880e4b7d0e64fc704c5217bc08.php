<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startPush('styles'); ?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    /* ⚡ ELIMINACIÓN RADICAL DE ESPACIOS EN BLANCO */
    .container-fluid {
        margin: 0 !important;
        padding: 0 15px !important;
    }

    .dashboard-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        overflow: hidden;
    }
    .dashboard-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }
    .chart-container {
        position: relative;
        height: 300px;
    }
    .table-card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .animate-fade-in {
        animation: fadeIn 0.6s ease-in;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .welcome-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        margin-top: 0 !important;
    }
    .bg-gradient-primary {
        background: linear-gradient(45deg, #667eea, #764ba2);
    }
    .bg-gradient-success {
        background: linear-gradient(45deg, #00b894, #00cec9);
    }
    .bg-gradient-warning {
        background: linear-gradient(45deg, #fdcb6e, #e17055);
    }
    .bg-gradient-danger {
        background: linear-gradient(45deg, #fd79a8, #e84393);
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid" style="margin: 0; padding: 0 15px;">
    <?php if(isset($error)): ?>
        <div class="alert alert-danger">
            <h5><i class="fas fa-exclamation-triangle me-2"></i>Error en el Dashboard</h5>
            <p><?php echo e($error); ?></p>
        </div>
    <?php endif; ?>

    <!-- Header de Bienvenida -->
    <div class="welcome-header animate-fade-in">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="h2 mb-2">
                    <i class="fas fa-tachometer-alt me-3"></i>
                    Dashboard - Sistema SCM Cesodo
                </h1>
                <p class="mb-0 opacity-90">
                    Bienvenido de vuelta, <?php echo e(Auth::user()->name); ?>.
                    Panel de control y análisis del sistema.
                </p>
            </div>
            <div class="col-md-4 text-md-end">
                <div class="d-flex flex-column align-items-md-end">
                    <div class="h4 mb-1"><?php echo e(now()->locale('es')->translatedFormat('d/m/Y')); ?></div>
                    <div class="opacity-75"><?php echo e(now()->locale('es')->translatedFormat('l, j \d\e F')); ?></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Estadísticas Principales -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card dashboard-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-gradient-primary text-white me-3">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <div>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Consumos Hoy
                            </div>
                            <div class="h5 mb-0 font-weight-bold">
                                <?php echo e($stats['consumos_hoy'] ?? 0); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card dashboard-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-gradient-success text-white me-3">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Trabajadores Activos
                            </div>
                            <div class="h5 mb-0 font-weight-bold">
                                <?php echo e($stats['trabajadores_activos'] ?? 0); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card dashboard-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-gradient-warning text-white me-3">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div>
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Stock Bajo
                            </div>
                            <div class="h5 mb-0 font-weight-bold">
                                <?php echo e($stats['productos_stock_bajo'] ?? 0); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card dashboard-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-gradient-danger text-white me-3">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Pedidos Pendientes
                            </div>
                            <div class="h5 mb-0 font-weight-bold">
                                <?php echo e($stats['pedidos_pendientes'] ?? 0); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos y Tablas -->
    <div class="row">
        <!-- Gráfico de Consumos por Tipo -->
        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card dashboard-card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-chart-pie me-2"></i>Consumos de Hoy por Tipo
                    </h6>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="consumosChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráfico de Consumos de la Semana -->
        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card dashboard-card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-chart-line me-2"></i>Consumos de la Semana
                    </h6>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="semanaChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Accesos Rápidos a Módulos -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card dashboard-card">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-rocket me-2"></i>Accesos Rápidos
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ver-trabajadores')): ?>
                        <div class="col-md-2 col-sm-4 col-6 mb-3">
                            <a href="<?php echo e(route('trabajadores.index')); ?>" class="text-decoration-none">
                                <div class="text-center p-3 bg-light rounded hover-shadow">
                                    <i class="fas fa-users fa-2x text-primary mb-2"></i>
                                    <div class="small text-dark">Trabajadores</div>
                                </div>
                            </a>
                        </div>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ver-productos')): ?>
                        <div class="col-md-2 col-sm-4 col-6 mb-3">
                            <a href="<?php echo e(route('productos.index')); ?>" class="text-decoration-none">
                                <div class="text-center p-3 bg-light rounded hover-shadow">
                                    <i class="fas fa-box fa-2x text-success mb-2"></i>
                                    <div class="small text-dark">Productos</div>
                                </div>
                            </a>
                        </div>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ver-inventario')): ?>
                        <div class="col-md-2 col-sm-4 col-6 mb-3">
                            <a href="<?php echo e(route('inventarios.index')); ?>" class="text-decoration-none">
                                <div class="text-center p-3 bg-light rounded hover-shadow">
                                    <i class="fas fa-warehouse fa-2x text-info mb-2"></i>
                                    <div class="small text-dark">Inventario</div>
                                </div>
                            </a>
                        </div>
                        <?php endif; ?>

                        <div class="col-md-2 col-sm-4 col-6 mb-3">
                            <a href="<?php echo e(route('consumos.index')); ?>" class="text-decoration-none">
                                <div class="text-center p-3 bg-light rounded hover-shadow">
                                    <i class="fas fa-utensils fa-2x text-warning mb-2"></i>
                                    <div class="small text-dark">Consumos</div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-2 col-sm-4 col-6 mb-3">
                            <a href="<?php echo e(route('pedidos.index')); ?>" class="text-decoration-none">
                                <div class="text-center p-3 bg-light rounded hover-shadow">
                                    <i class="fas fa-shopping-cart fa-2x text-danger mb-2"></i>
                                    <div class="small text-dark">Pedidos</div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-2 col-sm-4 col-6 mb-3">
                            <a href="<?php echo e(route('kardex.index')); ?>" class="text-decoration-none">
                                <div class="text-center p-3 bg-light rounded hover-shadow">
                                    <i class="fas fa-clipboard-list fa-2x text-secondary mb-2"></i>
                                    <div class="small text-dark">Kardex</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Últimos Consumos -->
    <div class="row">
        <div class="col-12">
            <div class="card table-card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-history me-2"></i>Últimos Consumos Registrados
                    </h6>
                    <a href="<?php echo e(route('consumos.index')); ?>" class="btn btn-sm btn-primary">
                        Ver Todos <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body">
                    <?php if($ultimosConsumos && $ultimosConsumos->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Trabajador</th>
                                        <th>Tipo Comida</th>
                                        <th>Fecha</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $ultimosConsumos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $consumo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <?php if($consumo->trabajador): ?>
                                                <?php echo e($consumo->trabajador->nombre); ?> <?php echo e($consumo->trabajador->apellido); ?>

                                            <?php else: ?>
                                                <span class="text-muted">Trabajador no encontrado</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge
                                                <?php if($consumo->tipo_comida == 'desayuno'): ?> bg-warning
                                                <?php elseif($consumo->tipo_comida == 'almuerzo'): ?> bg-success
                                                <?php elseif($consumo->tipo_comida == 'cena'): ?> bg-info
                                                <?php else: ?> bg-secondary
                                                <?php endif; ?>">
                                                <?php echo e(ucfirst($consumo->tipo_comida)); ?>

                                            </span>
                                        </td>
                                        <td><?php echo e($consumo->fecha_consumo); ?></td>
                                        <td>
                                            <span class="badge bg-primary"><?php echo e(ucfirst($consumo->estado ?? 'completado')); ?></span>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No hay consumos registrados aún.</p>
                            <a href="<?php echo e(route('consumos.create')); ?>" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Registrar Primer Consumo
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
// Gráfico de consumos por tipo
const consumosData = <?php echo json_encode($consumosHoy, 15, 512) ?>;
const ctx1 = document.getElementById('consumosChart').getContext('2d');
new Chart(ctx1, {
    type: 'doughnut',
    data: {
        labels: consumosData.map(item => item.tipo_comida.charAt(0).toUpperCase() + item.tipo_comida.slice(1)),
        datasets: [{
            data: consumosData.map(item => item.total),
            backgroundColor: ['#fd7900', '#00b894', '#0984e3', '#6c5ce7'],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// Gráfico de consumos de la semana
const semanaData = <?php echo json_encode($consumosSemana, 15, 512) ?>;
const ctx2 = document.getElementById('semanaChart').getContext('2d');
new Chart(ctx2, {
    type: 'line',
    data: {
        labels: semanaData.map(item => item.dia),
        datasets: [{
            label: 'Consumos',
            data: semanaData.map(item => item.total),
            borderColor: '#667eea',
            backgroundColor: 'rgba(102, 126, 234, 0.1)',
            borderWidth: 3,
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cesodo4\resources\views/dashboard.blade.php ENDPATH**/ ?>