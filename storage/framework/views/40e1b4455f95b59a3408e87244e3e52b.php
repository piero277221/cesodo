<?php $__env->startSection('title', 'Reportes - Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header con título -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">
                    <i class="fas fa-chart-bar text-primary me-2"></i>
                    Dashboard de Reportes
                </h2>
                <div class="btn-group" role="group">
                    <a href="<?php echo e(route('reportes.consumos')); ?>" class="btn btn-outline-primary">
                        <i class="fas fa-utensils me-1"></i>
                        Consumos
                    </a>
                    <a href="<?php echo e(route('reportes.inventario')); ?>" class="btn btn-outline-success">
                        <i class="fas fa-boxes me-1"></i>
                        Inventario
                    </a>
                    <a href="<?php echo e(route('reportes.proveedores')); ?>" class="btn btn-outline-info">
                        <i class="fas fa-truck me-1"></i>
                        Proveedores
                    </a>
                </div>
            </div>

            <!-- Estadísticas Generales -->
            <div class="row mb-4">
                <div class="col-md-2 col-sm-4 col-6">
                    <div class="card text-center bg-primary text-white shadow-sm">
                        <div class="card-body">
                            <i class="fas fa-utensils fa-2x mb-2"></i>
                            <h4 class="mb-0"><?php echo e(number_format($stats['total_consumos'])); ?></h4>
                            <small>Total Consumos</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-4 col-6">
                    <div class="card text-center bg-success text-white shadow-sm">
                        <div class="card-body">
                            <i class="fas fa-box fa-2x mb-2"></i>
                            <h4 class="mb-0"><?php echo e(number_format($stats['total_productos'])); ?></h4>
                            <small>Total Productos</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-4 col-6">
                    <div class="card text-center bg-info text-white shadow-sm">
                        <div class="card-body">
                            <i class="fas fa-users fa-2x mb-2"></i>
                            <h4 class="mb-0"><?php echo e(number_format($stats['total_trabajadores'])); ?></h4>
                            <small>Total Trabajadores</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-4 col-6">
                    <div class="card text-center bg-warning text-white shadow-sm">
                        <div class="card-body">
                            <i class="fas fa-truck fa-2x mb-2"></i>
                            <h4 class="mb-0"><?php echo e(number_format($stats['total_proveedores'])); ?></h4>
                            <small>Total Proveedores</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-4 col-6">
                    <div class="card text-center bg-secondary text-white shadow-sm">
                        <div class="card-body">
                            <i class="fas fa-shopping-cart fa-2x mb-2"></i>
                            <h4 class="mb-0"><?php echo e(number_format($stats['total_pedidos'])); ?></h4>
                            <small>Total Pedidos</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Gráfico de Consumos por Mes -->
                <div class="col-lg-8 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-chart-line me-2"></i>
                                Consumos por Mes (Últimos 12 meses)
                            </h5>
                        </div>
                        <div class="card-body">
                            <canvas id="consumosChart" height="100"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Top Tipos de Comida -->
                <div class="col-lg-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-utensils me-2"></i>
                                Top 5 Tipos de Comida Más Consumidos
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                <?php $__empty_1 = true; $__currentLoopData = $topTiposComida; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <small class="badge bg-primary me-2"><?php echo e($index + 1); ?></small>
                                            <strong><?php echo e(ucfirst($tipo->tipo_comida)); ?></strong>
                                        </div>
                                        <span class="badge bg-success rounded-pill">
                                            <?php echo e(number_format($tipo->total_consumos)); ?>

                                        </span>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <div class="list-group-item text-center text-muted">
                                        <i class="fas fa-info-circle me-2"></i>
                                        No hay datos de consumos
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Top Trabajadores -->
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-user-tie me-2"></i>
                                Top 5 Trabajadores con Más Consumos
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                <?php $__empty_1 = true; $__currentLoopData = $topTrabajadores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $trabajador): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <div class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <small class="badge bg-info me-2"><?php echo e($index + 1); ?></small>
                                                <strong><?php echo e($trabajador->apellidos); ?>, <?php echo e($trabajador->nombres); ?></strong>
                                            </div>
                                <div class="text-end">
                                                <span class="badge bg-primary"><?php echo e($trabajador->total_consumos); ?> consumos</span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <div class="list-group-item text-center text-muted">
                                        <i class="fas fa-info-circle me-2"></i>
                                        No hay datos de consumos por trabajador
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Productos con Stock Bajo -->
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-warning text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Productos con Stock Bajo
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                <?php $__empty_1 = true; $__currentLoopData = $productosStockBajo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong><?php echo e($producto->nombre); ?></strong>
                                            <br>
                                            <small class="text-muted"><?php echo e($producto->categoria->nombre ?? 'Sin categoría'); ?></small>
                                        </div>
                                        <span class="badge bg-<?php echo e($producto->stock_actual == 0 ? 'danger' : 'warning'); ?> rounded-pill">
                                            <?php echo e($producto->stock_actual); ?> <?php echo e($producto->unidad_medida); ?>

                                        </span>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <div class="list-group-item text-center text-success">
                                        <i class="fas fa-check-circle me-2"></i>
                                        Todos los productos tienen stock adecuado
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Datos de consumos por mes
    const consumosData = <?php echo json_encode($consumosPorMes, 15, 512) ?>;

    // Preparar datos para el gráfico
    const labels = consumosData.map(item => {
        const meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun',
                      'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
        return meses[item.mes - 1] + ' ' + item.año;
    }).reverse();

    const datos = consumosData.map(item => item.total).reverse();

    // Crear gráfico
    const ctx = document.getElementById('consumosChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Número de Consumos',
                data: datos,
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            scales: {
                x: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Mes'
                    }
                },
                y: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Número de Consumos'
                    }
                }
            }
        }
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cesodo4\resources\views/reportes/index.blade.php ENDPATH**/ ?>