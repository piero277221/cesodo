<?php $__env->startSection('title', 'Kardex General'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2 text-primary">
            <i class="fas fa-clipboard-list me-2"></i>Kardex - Control de Inventarios
        </h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?php echo e(route('kardex.create')); ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>Nuevo Movimiento
                </a>
                <a href="<?php echo e(route('kardex.reporte')); ?>" class="btn btn-outline-success">
                    <i class="fas fa-file-excel me-1"></i>Exportar
                </a>
            </div>
        </div>
    </div>

    <!-- Filtros de Módulo -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-filter me-2"></i>Seleccionar Módulo
                    </h6>
                </div>
                <div class="card-body">
                    <div class="btn-group w-100" role="group">
                        <a href="<?php echo e(route('kardex.index', ['modulo' => 'inventario'] + request()->except('modulo'))); ?>"
                           class="btn <?php echo e($modulo == 'inventario' ? 'btn-primary' : 'btn-outline-primary'); ?>">
                            <i class="fas fa-boxes me-1"></i>Inventario
                        </a>
                        <a href="<?php echo e(route('kardex.index', ['modulo' => 'compras'] + request()->except('modulo'))); ?>"
                           class="btn <?php echo e($modulo == 'compras' ? 'btn-success' : 'btn-outline-success'); ?>">
                            <i class="fas fa-shopping-cart me-1"></i>Compras
                        </a>
                        <a href="<?php echo e(route('kardex.index', ['modulo' => 'consumos'] + request()->except('modulo'))); ?>"
                           class="btn <?php echo e($modulo == 'consumos' ? 'btn-warning' : 'btn-outline-warning'); ?>">
                            <i class="fas fa-utensils me-1"></i>Consumos
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Estadísticas -->
    <?php if(isset($estadisticas)): ?>
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Movimientos
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($estadisticas['total_movimientos'] ?? 0); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Ingresos
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($estadisticas['total_ingresos'] ?? 0); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-arrow-up fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Egresos
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($estadisticas['total_egresos'] ?? 0); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-arrow-down fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Productos Únicos
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($estadisticas['productos_unicos'] ?? 0); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-cube fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Filtros -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-search me-2"></i>Filtros de Búsqueda
            </h6>
        </div>
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('kardex.index')); ?>" class="row g-3">
                <input type="hidden" name="modulo" value="<?php echo e($modulo); ?>">

                <div class="col-md-3">
                    <label class="form-label">Producto</label>
                    <select name="producto_id" class="form-select">
                        <option value="">Todos los productos</option>
                        <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($producto->id); ?>" <?php echo e(request('producto_id') == $producto->id ? 'selected' : ''); ?>>
                                <?php echo e($producto->nombre); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Tipo de Movimiento</label>
                    <select name="tipo_movimiento" class="form-select">
                        <option value="">Todos</option>
                        <option value="entrada" <?php echo e(request('tipo_movimiento') == 'entrada' ? 'selected' : ''); ?>>Entrada</option>
                        <option value="salida" <?php echo e(request('tipo_movimiento') == 'salida' ? 'selected' : ''); ?>>Salida</option>
                        <option value="ajuste" <?php echo e(request('tipo_movimiento') == 'ajuste' ? 'selected' : ''); ?>>Ajuste</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Categoría</label>
                    <select name="categoria_id" class="form-select">
                        <option value="">Todas</option>
                        <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($categoria->id); ?>" <?php echo e(request('categoria_id') == $categoria->id ? 'selected' : ''); ?>>
                                <?php echo e($categoria->nombre); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Fecha Desde</label>
                    <input type="date" class="form-control" name="fecha_desde" value="<?php echo e(request('fecha_desde')); ?>">
                </div>

                <div class="col-md-2">
                    <label class="form-label">Fecha Hasta</label>
                    <input type="date" class="form-control" name="fecha_hasta" value="<?php echo e(request('fecha_hasta')); ?>">
                </div>

                <div class="col-md-1">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de movimientos -->
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-list me-2"></i>Movimientos de Kardex - <?php echo e(ucfirst($modulo)); ?>

            </h6>
        </div>
        <div class="card-body">
            <?php if($movimientos->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Fecha</th>
                                <th>Producto</th>
                                <th>Tipo</th>
                                <th>Concepto</th>
                                <th>Documento</th>
                                <th class="text-center">Entrada</th>
                                <th class="text-center">Salida</th>
                                <th class="text-center">Precio Unit.</th>
                                <th class="text-center">Saldo Cant.</th>
                                <th class="text-center">Saldo Valor</th>
                                <th>Usuario</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $movimientos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $movimiento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <small><?php echo e($movimiento->fecha->format('d/m/Y')); ?></small>
                                    </td>
                                    <td>
                                        <strong><?php echo e($movimiento->producto->nombre ?? 'N/A'); ?></strong>
                                        <?php if($movimiento->producto->categoria): ?>
                                            <br><small class="text-muted"><?php echo e($movimiento->producto->categoria->nombre); ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($movimiento->tipo_movimiento == 'entrada'): ?>
                                            <span class="badge bg-success">
                                                <i class="fas fa-arrow-up me-1"></i>Entrada
                                            </span>
                                        <?php elseif($movimiento->tipo_movimiento == 'salida'): ?>
                                            <span class="badge bg-warning">
                                                <i class="fas fa-arrow-down me-1"></i>Salida
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-info">
                                                <i class="fas fa-adjust me-1"></i>Ajuste
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php echo e($movimiento->concepto); ?>

                                        <?php if($movimiento->observaciones): ?>
                                            <br><small class="text-muted"><?php echo e($movimiento->observaciones); ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <code><?php echo e($movimiento->numero_documento ?? 'N/A'); ?></code>
                                    </td>
                                    <td class="text-center">
                                        <?php if($movimiento->cantidad_entrada > 0): ?>
                                            <span class="text-success fw-bold">+<?php echo e(number_format($movimiento->cantidad_entrada)); ?></span>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if($movimiento->cantidad_salida > 0): ?>
                                            <span class="text-warning fw-bold">-<?php echo e(number_format($movimiento->cantidad_salida)); ?></span>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if($movimiento->precio_unitario): ?>
                                            <small>S/ <?php echo e(number_format($movimiento->precio_unitario, 2)); ?></small>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <strong class="<?php echo e($movimiento->saldo_cantidad >= 0 ? 'text-success' : 'text-danger'); ?>">
                                            <?php echo e(number_format($movimiento->saldo_cantidad)); ?>

                                        </strong>
                                    </td>
                                    <td class="text-center">
                                        <?php if($movimiento->saldo_valor): ?>
                                            <small class="<?php echo e($movimiento->saldo_valor >= 0 ? 'text-success' : 'text-danger'); ?>">
                                                S/ <?php echo e(number_format($movimiento->saldo_valor, 2)); ?>

                                            </small>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <small><?php echo e($movimiento->user->name ?? 'Sistema'); ?></small>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="d-flex justify-content-center mt-4">
                    <?php echo e($movimientos->appends(request()->query())->links()); ?>

                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-clipboard-list fa-3x text-gray-300 mb-4"></i>
                    <h4 class="text-gray-500">No hay movimientos registrados</h4>
                    <p class="text-gray-400 mb-4">No se encontraron movimientos para los filtros seleccionados</p>

                    <?php if($modulo == 'compras'): ?>
                        <p class="text-muted">Los movimientos de compras se registran automáticamente al crear compras.</p>
                    <?php elseif($modulo == 'consumos'): ?>
                        <p class="text-muted">Los movimientos de consumos se registran automáticamente al crear consumos.</p>
                    <?php else: ?>
                        <p class="text-muted">Los movimientos de inventario se registran automáticamente al actualizar el stock.</p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit form when module changes
    const moduleButtons = document.querySelectorAll('[href*="modulo="]');
    moduleButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            // Let the normal navigation happen
        });
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cesodo4\resources\views/kardex/index.blade.php ENDPATH**/ ?>