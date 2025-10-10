<?php $__env->startSection('title', 'Reportes - Inventario'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header con título y navegación -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">
                    <i class="fas fa-boxes text-success me-2"></i>
                    Reporte de Inventario
                </h2>
                <div class="btn-group" role="group">
                    <a href="<?php echo e(route('reportes.index')); ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>
                        Volver al Dashboard
                    </a>
                    <a href="<?php echo e(route('reportes.inventario.excel')); ?>" class="btn btn-success">
                        <i class="fas fa-file-excel me-1"></i>
                        Excel
                    </a>
                    <a href="<?php echo e(route('reportes.inventario.pdf')); ?>" class="btn btn-danger">
                        <i class="fas fa-file-pdf me-1"></i>
                        PDF
                    </a>
                </div>
            </div>

            <!-- Mensajes -->
            <?php if(session('info')): ?>
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="fas fa-info-circle me-2"></i>
                    <?php echo e(session('info')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Estadísticas de Inventario -->
            <div class="row mb-4">
                <div class="col-md-3 col-sm-6">
                    <div class="card text-center bg-primary text-white shadow-sm">
                        <div class="card-body">
                            <i class="fas fa-boxes fa-2x mb-2"></i>
                            <h4 class="mb-0"><?php echo e(number_format($inventarioStats['total_productos'])); ?></h4>
                            <small>Total Productos</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="card text-center bg-danger text-white shadow-sm">
                        <div class="card-body">
                            <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                            <h4 class="mb-0"><?php echo e(number_format($inventarioStats['productos_sin_stock'])); ?></h4>
                            <small>Sin Stock</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="card text-center bg-warning text-white shadow-sm">
                        <div class="card-body">
                            <i class="fas fa-exclamation-circle fa-2x mb-2"></i>
                            <h4 class="mb-0"><?php echo e(number_format($inventarioStats['productos_stock_bajo'])); ?></h4>
                            <small>Stock Bajo</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="card text-center bg-success text-white shadow-sm">
                        <div class="card-body">
                            <i class="fas fa-dollar-sign fa-2x mb-2"></i>
                            <h4 class="mb-0">S/ <?php echo e(number_format($inventarioStats['valor_total_inventario'], 2)); ?></h4>
                            <small>Valor Total</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filtros -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-filter me-2"></i>
                        Filtros de Búsqueda
                    </h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="<?php echo e(route('reportes.inventario')); ?>" class="row g-3">
                        <div class="col-md-4">
                            <label for="categoria" class="form-label">Categoría</label>
                            <select class="form-select" id="categoria" name="categoria">
                                <option value="">Todas las categorías</option>
                                <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($categoria); ?>"
                                            <?php echo e(request('categoria') == $categoria ? 'selected' : ''); ?>>
                                        <?php echo e($categoria); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="stock_minimo" class="form-label">Stock Menor o Igual a</label>
                            <input type="number"
                                   class="form-control"
                                   id="stock_minimo"
                                   name="stock_minimo"
                                   value="<?php echo e(request('stock_minimo')); ?>"
                                   placeholder="Ej: 10"
                                   min="0">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label d-block">&nbsp;</label>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-1"></i>
                                Buscar
                            </button>
                            <a href="<?php echo e(route('reportes.inventario')); ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-1"></i>
                                Limpiar
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabla de Productos -->
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-table me-2"></i>
                        Inventario de Productos (<?php echo e($productos->total()); ?> registros)
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>Código</th>
                                    <th>Producto</th>
                                    <th>Categoría</th>
                                    <th>Stock Actual</th>
                                    <th>Unidad</th>
                                    <th>Precio Unitario</th>
                                    <th>Valor Total</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td>
                                            <code><?php echo e($producto->codigo ?? 'N/A'); ?></code>
                                        </td>
                                        <td>
                                            <strong><?php echo e($producto->nombre); ?></strong>
                                            <?php if($producto->descripcion): ?>
                                                <br>
                                                <small class="text-muted"><?php echo e(Str::limit($producto->descripcion, 50)); ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary"><?php echo e($producto->categoria->nombre ?? 'Sin categoría'); ?></span>
                                        </td>
                                        <td>
                                            <span class="badge fs-6
                                                <?php if($producto->stock_actual == 0): ?> bg-danger
                                                <?php elseif($producto->stock_actual < 10): ?> bg-warning
                                                <?php else: ?> bg-success
                                                <?php endif; ?>">
                                                <?php echo e(number_format($producto->stock_actual, 2)); ?>

                                            </span>
                                        </td>
                                        <td><?php echo e($producto->unidad_medida); ?></td>
                                        <td>S/ <?php echo e(number_format($producto->precio_unitario, 2)); ?></td>
                                        <td>
                                            <strong>S/ <?php echo e(number_format($producto->stock_actual * $producto->precio_unitario, 2)); ?></strong>
                                        </td>
                                        <td>
                                            <?php if($producto->stock_actual == 0): ?>
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-times me-1"></i>
                                                    Sin Stock
                                                </span>
                                            <?php elseif($producto->stock_actual < 10): ?>
                                                <span class="badge bg-warning">
                                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                                    Stock Bajo
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check me-1"></i>
                                                    Disponible
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="8" class="text-center py-4 text-muted">
                                            <i class="fas fa-search fa-2x mb-2"></i>
                                            <br>
                                            No se encontraron productos con los filtros aplicados
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php if($productos->hasPages()): ?>
                    <div class="card-footer">
                        <?php echo e($productos->withQueryString()->links()); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cesodo4\resources\views/reportes/inventario.blade.php ENDPATH**/ ?>