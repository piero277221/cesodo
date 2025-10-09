<?php $__env->startSection('title', 'Inven                        <div class="icon-shape" style="background: var(--primary-color);">
                            <i class="fas fa-warehouse"></i>
                        </div>io'); ?>

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
                                <div class="icon-shape" style="background: var(--primary-color); color: white;" class="me-3">
                                    <i class="fas fa-warehouse"></i>
                                </div>
                                <div>
                                    <h1 class="h3 mb-1 text-gradient">Control de Inventario</h1>
                                    <p class="text-muted mb-0">Gestiona el stock y movimientos de productos</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="<?php echo e(route('inventarios.create')); ?>" class="btn btn-primary btn-lg">
                                <i class="fas fa-plus me-2"></i>
                                Nuevo Producto
                            </a>
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

    <!-- Estadísticas mejoradas -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-modern h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape" style="background: var(--primary-gradient);">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="ms-3">
                            <div class="text-muted small">Total Productos</div>
                            <div class="h4 mb-0"><?php echo e(isset($stats['total_productos']) ? $stats['total_productos'] : 0); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-modern h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape" style="background: var(--success-color);">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="ms-3">
                            <div class="text-muted small">Stock Disponible</div>
                                    <h3 class="mb-0"><?php echo e(isset($stats['stock_disponible']) ? $stats['stock_disponible'] : 0); ?></h3>
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
                                    <h6 class="card-title">Stock Bajo</h6>
                                    <h3 class="mb-0"><?php echo e(isset($stats['stock_bajo']) ? $stats['stock_bajo'] : 0); ?></h3>
                                </div>
                                <div>
                                    <i class="fas fa-exclamation-triangle fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card bg-danger text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Sin Stock</h6>
                                    <h3 class="mb-0"><?php echo e(isset($stats['sin_stock']) ? $stats['sin_stock'] : 0); ?></h3>
                                </div>
                                <div>
                                    <i class="fas fa-times-circle fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filtros -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="<?php echo e(route('inventarios.index')); ?>" class="row g-3">
                        <div class="col-md-4">
                            <label for="search" class="form-label">Buscar</label>
                            <input type="text" class="form-control" id="search" name="search"
                                   value="<?php echo e(request('search')); ?>"
                                   placeholder="Nombre, código...">
                        </div>
                        <div class="col-md-3">
                            <label for="categoria" class="form-label">Categoría</label>
                            <select class="form-select" id="categoria" name="categoria">
                                <option value="">Todas</option>
                                <option value="Alimentos" <?php echo e(request('categoria') == 'Alimentos' ? 'selected' : ''); ?>>Alimentos</option>
                                <option value="Bebidas" <?php echo e(request('categoria') == 'Bebidas' ? 'selected' : ''); ?>>Bebidas</option>
                                <option value="Limpieza" <?php echo e(request('categoria') == 'Limpieza' ? 'selected' : ''); ?>>Limpieza</option>
                                <option value="Otros" <?php echo e(request('categoria') == 'Otros' ? 'selected' : ''); ?>>Otros</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="stock_status" class="form-label">Estado de Stock</label>
                            <select class="form-select" id="stock_status" name="stock_status">
                                <option value="">Todos</option>
                                <option value="disponible" <?php echo e(request('stock_status') == 'disponible' ? 'selected' : ''); ?>>Disponible</option>
                                <option value="bajo" <?php echo e(request('stock_status') == 'bajo' ? 'selected' : ''); ?>>Stock Bajo</option>
                                <option value="sin_stock" <?php echo e(request('stock_status') == 'sin_stock' ? 'selected' : ''); ?>>Sin Stock</option>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-outline-primary me-2">
                                <i class="fas fa-search"></i> Buscar
                            </button>
                            <a href="<?php echo e(route('inventarios.index')); ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabla de inventario -->
            <div class="card">
                <div class="card-body">
                    <?php if(!empty($inventarios) && count($inventarios) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Producto</th>
                                        <th>Código</th>
                                        <th>Categoría</th>
                                        <th>Stock Actual</th>
                                        <th>Stock Mínimo</th>
                                        <th>Estado</th>
                                        <th>Última Actualización</th>
                                        <th width="200">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $inventarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inventario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <div class="fw-bold"><?php echo e($inventario->producto->nombre ?? $inventario->nombre ?? 'N/A'); ?></div>
                                                <?php if(isset($inventario->producto->descripcion)): ?>
                                                    <small class="text-muted"><?php echo e(Str::limit($inventario->producto->descripcion, 40)); ?></small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if(isset($inventario->producto->codigo)): ?>
                                                    <span class="badge bg-info"><?php echo e($inventario->producto->codigo); ?></span>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if(isset($inventario->producto->categoria->nombre)): ?>
                                                    <span class="badge bg-secondary"><?php echo e($inventario->producto->categoria->nombre); ?></span>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php
                                                    $stock = $inventario->stock_actual ?? $inventario->cantidad ?? 0;
                                                    $stockMinimo = $inventario->producto->stock_minimo ?? 10;
                                                    $stockClass = $stock > $stockMinimo ? 'text-success' : ($stock > 0 ? 'text-warning' : 'text-danger');
                                                ?>
                                                <span class="<?php echo e($stockClass); ?> fw-bold fs-5"><?php echo e($stock); ?></span>
                                                <?php if(isset($inventario->unidad) || isset($inventario->producto->unidad)): ?>
                                                    <small class="text-muted"><?php echo e($inventario->unidad ?? $inventario->producto->unidad ?? 'unid'); ?></small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="text-muted"><?php echo e($inventario->producto->stock_minimo ?? 10); ?></span>
                                            </td>
                                            <td>
                                                <?php
                                                    $stock = $inventario->stock_actual ?? $inventario->cantidad ?? 0;
                                                    $stockMinimo = $inventario->producto->stock_minimo ?? 10;

                                                    if ($stock == 0) {
                                                        $badge = 'bg-danger';
                                                        $texto = 'Sin Stock';
                                                    } elseif ($stock <= $stockMinimo) {
                                                        $badge = 'bg-warning';
                                                        $texto = 'Stock Bajo';
                                                    } else {
                                                        $badge = 'bg-success';
                                                        $texto = 'Disponible';
                                                    }
                                                ?>
                                                <span class="badge <?php echo e($badge); ?>"><?php echo e($texto); ?></span>
                                            </td>
                                            <td>
                                                <?php if($inventario->updated_at): ?>
                                                    <small><?php echo e($inventario->updated_at->format('d/m/Y H:i')); ?></small>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?php echo e(route('inventarios.show', $inventario)); ?>"
                                                       class="btn btn-sm btn-outline-info"
                                                       title="Ver movimientos">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="<?php echo e(route('inventarios.edit', $inventario)); ?>"
                                                       class="btn btn-sm btn-outline-warning"
                                                       title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button"
                                                            class="btn btn-sm btn-outline-success"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#entradaModal<?php echo e($inventario->id); ?>"
                                                            title="Entrada">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                    <button type="button"
                                                            class="btn btn-sm btn-outline-danger"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#salidaModal<?php echo e($inventario->id); ?>"
                                                            title="Salida">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        <?php if(is_object($inventarios) && method_exists($inventarios, 'links')): ?>
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <div>
                                    <small class="text-muted">
                                        Mostrando <?php echo e($inventarios->firstItem() ?? 0); ?> a <?php echo e($inventarios->lastItem() ?? 0); ?>

                                        de <?php echo e($inventarios->total() ?? 0); ?> resultados
                                    </small>
                                </div>
                                <div>
                                    <?php echo e($inventarios->appends(request()->query())->links()); ?>

                                </div>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-warehouse fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">No hay productos en inventario</h4>
                            <p class="text-muted mb-4">Comience agregando productos al inventario</p>
                            <a href="<?php echo e(route('inventarios.create')); ?>" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i>
                                Agregar Primer Producto
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cesodo4\resources\views/inventarios/index.blade.php ENDPATH**/ ?>