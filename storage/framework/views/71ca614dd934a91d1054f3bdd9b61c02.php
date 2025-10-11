<?php $__env->startSection('title', 'Productos'); ?>

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
                                    <i class="fas fa-box"></i>
                                </div>
                                <div>
                                    <h1 class="h3 mb-1 text-primary">Gestión de Productos</h1>
                                    <p class="text-muted mb-0">Administra el inventario y catálogo de productos</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="<?php echo e(route('productos.create')); ?>" class="btn btn-primary btn-lg">
                                <i class="fas fa-plus me-2"></i>
                                Nuevo Producto
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
                            <i class="fas fa-box-open"></i>
                        </div>
                        <div class="ms-3">
                            <div class="text-muted small">Productos Activos</div>
                            <div class="h4 mb-0 text-success"><?php echo e($estadisticas['activos'] ?? 0); ?></div>
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
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="ms-3">
                            <div class="text-muted small">Stock Bajo</div>
                            <div class="h4 mb-0 text-warning"><?php echo e($estadisticas['stock_bajo'] ?? 0); ?></div>
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
                            <i class="fas fa-tags"></i>
                        </div>
                        <div class="ms-3">
                            <div class="text-muted small">Categorías</div>
                            <div class="h4 mb-0 text-info"><?php echo e($estadisticas['categorias'] ?? 0); ?></div>
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
                            <i class="fas fa-boxes"></i>
                        </div>
                        <div class="ms-3">
                            <div class="text-muted small">Total Productos</div>
                            <div class="h4 mb-0"><?php echo e(count($productos)); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mensajes de estado -->
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

    <!-- Filtros de búsqueda modernos -->
    <div class="card border-0 shadow-modern mb-4">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-filter me-2"></i>
                Filtros de Búsqueda
            </h5>
        </div>
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('productos.index')); ?>" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">Buscar</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text"
                               class="form-control"
                               id="search"
                               name="search"
                               value="<?php echo e(request('search')); ?>"
                               placeholder="Código, nombre, descripción...">
                    </div>
                </div>

                        <div class="col-md-3">
                            <label for="categoria_id" class="form-label">Categoría</label>
                            <select class="form-select" id="categoria_id" name="categoria_id">
                                <option value="">Todas las categorías</option>
                                <?php if(isset($categorias) && $categorias->count() > 0): ?>
                                    <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($categoria->id); ?>"
                                                <?php echo e(request('categoria_id') == $categoria->id ? 'selected' : ''); ?>>
                                            <?php echo e($categoria->nombre); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label for="estado" class="form-label">Estado</label>
                            <select class="form-select" id="estado" name="estado">
                                <option value="">Todos</option>
                                <option value="activo" <?php echo e(request('estado') == 'activo' ? 'selected' : ''); ?>>Activo</option>
                                <option value="inactivo" <?php echo e(request('estado') == 'inactivo' ? 'selected' : ''); ?>>Inactivo</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label for="stock_estado" class="form-label">Stock</label>
                            <select class="form-select" id="stock_estado" name="stock_estado">
                                <option value="">Todos</option>
                                <option value="bajo" <?php echo e(request('stock_estado') == 'bajo' ? 'selected' : ''); ?>>Stock Bajo</option>
                                <option value="alto" <?php echo e(request('stock_estado') == 'alto' ? 'selected' : ''); ?>>Stock Normal</option>
                            </select>
                        </div>

                        <div class="col-md-1">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Estadísticas rápidas -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card bg-primary text-white shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Total Productos</h6>
                                    <h3 class="mb-0">
                                        <?php if(isset($productos) && is_object($productos) && method_exists($productos, 'total')): ?>
                                            <?php echo e($productos->total()); ?>

                                        <?php else: ?>
                                            0
                                        <?php endif; ?>
                                    </h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-box fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card bg-success text-white shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Productos Activos</h6>
                                    <h3 class="mb-0"><?php echo e($estadisticas['activos'] ?? 0); ?></h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-check-circle fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card bg-warning text-white shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Stock Bajo</h6>
                                    <h3 class="mb-0"><?php echo e($estadisticas['stock_bajo'] ?? 0); ?></h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-exclamation-triangle fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card bg-info text-white shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Categorías</h6>
                                    <h3 class="mb-0"><?php echo e($estadisticas['categorias'] ?? 0); ?></h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-tags fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de productos -->
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2"></i>
                        Lista de Productos
                    </h5>
                </div>
                <div class="card-body p-0">
                    <?php if(isset($productos) && ((is_object($productos) && $productos->count() > 0) || (is_array($productos) && count($productos) > 0))): ?>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="10%">Código</th>
                                        <th width="25%">Producto</th>
                                        <th width="15%">Categoría</th>
                                        <th width="10%">Precio</th>
                                        <th width="10%">Stock</th>
                                        <th width="10%">Estado</th>
                                        <th width="15%">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <?php if(is_object($productos) && method_exists($productos, 'firstItem')): ?>
                                                    <?php echo e($productos->firstItem() + $index); ?>

                                                <?php else: ?>
                                                    <?php echo e($index + 1); ?>

                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary"><?php echo e($producto->codigo); ?></span>
                                            </td>
                                            <td>
                                                <div>
                                                    <strong><?php echo e($producto->nombre); ?></strong>
                                                    <?php if($producto->descripcion): ?>
                                                        <br>
                                                        <small class="text-muted"><?php echo e(Str::limit($producto->descripcion, 50)); ?></small>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td>
                                                <?php if($producto->categoria): ?>
                                                    <span class="badge bg-info"><?php echo e($producto->categoria->nombre); ?></span>
                                                <?php else: ?>
                                                    <span class="text-muted">Sin categoría</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <strong>S/ <?php echo e(number_format($producto->precio_unitario, 2)); ?></strong>
                                                <br>
                                                <small class="text-muted"><?php echo e($producto->unidad_medida); ?></small>
                                            </td>
                                            <td>
                                                <?php
                                                    $stock = $producto->inventario->stock_disponible ?? 0;
                                                    $stockMinimo = $producto->stock_minimo;
                                                    $stockClass = $stock <= $stockMinimo ? 'text-danger' : 'text-success';
                                                ?>
                                                <span class="<?php echo e($stockClass); ?>">
                                                    <strong><?php echo e($stock); ?></strong>
                                                </span>
                                                <br>
                                                <small class="text-muted">Mín: <?php echo e($stockMinimo); ?></small>
                                            </td>
                                            <td>
                                                <?php if($producto->estado == 'activo'): ?>
                                                    <span class="badge bg-success">Activo</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Inactivo</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?php echo e(route('productos.show', $producto)); ?>"
                                                       class="btn btn-sm btn-outline-info"
                                                       title="Ver detalles">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="<?php echo e(route('productos.edit', $producto)); ?>"
                                                       class="btn btn-sm btn-outline-warning"
                                                       title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form method="POST"
                                                          action="<?php echo e(route('productos.destroy', $producto)); ?>"
                                                          style="display: inline;"
                                                          onsubmit="return confirm('¿Está seguro de eliminar este producto?')">
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
                        <?php if(isset($productos) && is_object($productos) && method_exists($productos, 'hasPages') && $productos->hasPages()): ?>
                            <div class="card-footer">
                                <?php echo e($productos->withQueryString()->links()); ?>

                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-box fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">No se encontraron productos</h5>
                            <p class="text-muted">No hay productos registrados o no coinciden con los filtros aplicados.</p>
                            <a href="<?php echo e(route('productos.create')); ?>" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i>
                                Crear primer producto
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
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit del formulario de filtros cuando cambian los selects
    const filterSelects = document.querySelectorAll('#categoria_id, #estado, #stock_estado');
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            this.closest('form').submit();
        });
    });

    // Limpiar búsqueda
    const searchInput = document.getElementById('search');
    if (searchInput) {
        const clearButton = document.createElement('button');
        clearButton.type = 'button';
        clearButton.className = 'btn btn-outline-secondary btn-sm ms-2';
        clearButton.innerHTML = '<i class="fas fa-times"></i>';
        clearButton.onclick = function() {
            searchInput.value = '';
            searchInput.closest('form').submit();
        };

        if (searchInput.value) {
            searchInput.parentNode.appendChild(clearButton);
        }
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cesodo4\resources\views/productos/index.blade.php ENDPATH**/ ?>