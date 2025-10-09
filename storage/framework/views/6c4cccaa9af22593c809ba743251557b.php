

<?php $__env->startSection('title', 'Pedidos'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header con título y botón -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">
                    <i class="fas fa-shopping-cart text-primary me-2"></i>
                    Gestión de Pedidos
                </h2>
                <a href="<?php echo e(route('pedidos.create')); ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>
                    Nuevo Pedido
                </a>
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

            <!-- Filtros de búsqueda -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <form method="GET" action="<?php echo e(route('pedidos.index')); ?>" class="row g-3">
                        <div class="col-md-4">
                            <label for="search" class="form-label">Buscar</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="search" 
                                   name="search" 
                                   value="<?php echo e(request('search')); ?>" 
                                   placeholder="Número de pedido, proveedor...">
                        </div>

                        <div class="col-md-3">
                            <label for="proveedor_id" class="form-label">Proveedor</label>
                            <select class="form-select" id="proveedor_id" name="proveedor_id">
                                <option value="">Todos los proveedores</option>
                                <?php if(isset($proveedores)): ?>
                                    <?php $__currentLoopData = $proveedores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proveedor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($proveedor->id); ?>" 
                                                <?php echo e(request('proveedor_id') == $proveedor->id ? 'selected' : ''); ?>>
                                            <?php echo e($proveedor->razon_social); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="estado" class="form-label">Estado</label>
                            <select class="form-select" id="estado" name="estado">
                                <option value="">Todos</option>
                                <option value="pendiente" <?php echo e(request('estado') == 'pendiente' ? 'selected' : ''); ?>>Pendiente</option>
                                <option value="confirmado" <?php echo e(request('estado') == 'confirmado' ? 'selected' : ''); ?>>Confirmado</option>
                                <option value="entregado" <?php echo e(request('estado') == 'entregado' ? 'selected' : ''); ?>>Entregado</option>
                                <option value="cancelado" <?php echo e(request('estado') == 'cancelado' ? 'selected' : ''); ?>>Cancelado</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="fas fa-search"></i> Buscar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Estadísticas rápidas -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card bg-warning text-white shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Pendientes</h6>
                                    <h3 class="mb-0"><?php echo e($estadisticas['pendientes'] ?? 0); ?></h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-clock fa-2x"></i>
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
                                    <h6 class="card-title">Confirmados</h6>
                                    <h3 class="mb-0"><?php echo e($estadisticas['confirmados'] ?? 0); ?></h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-check fa-2x"></i>
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
                                    <h6 class="card-title">Entregados</h6>
                                    <h3 class="mb-0"><?php echo e($estadisticas['entregados'] ?? 0); ?></h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-truck fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card bg-primary text-white shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Total Mes</h6>
                                    <h3 class="mb-0">S/ <?php echo e(number_format($estadisticas['total_mes'] ?? 0, 2)); ?></h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-dollar-sign fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de pedidos -->
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2"></i>
                        Lista de Pedidos
                    </h5>
                </div>
                <div class="card-body p-0">
                    <?php if(isset($pedidos) && ((is_object($pedidos) && $pedidos->count() > 0) || (is_array($pedidos) && count($pedidos) > 0))): ?>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="15%">Número</th>
                                        <th width="25%">Proveedor</th>
                                        <th width="15%">Fecha Pedido</th>
                                        <th width="15%">Entrega Esperada</th>
                                        <th width="10%">Total</th>
                                        <th width="10%">Estado</th>
                                        <th width="15%">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $pedidos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $pedido): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <?php if(is_object($pedidos) && method_exists($pedidos, 'firstItem')): ?>
                                                    <?php echo e($pedidos->firstItem() + $index); ?>

                                                <?php else: ?>
                                                    <?php echo e($index + 1); ?>

                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <strong><?php echo e($pedido->numero_pedido); ?></strong>
                                            </td>
                                            <td>
                                                <?php if($pedido->proveedor): ?>
                                                    <div>
                                                        <strong><?php echo e($pedido->proveedor->razon_social); ?></strong>
                                                        <?php if($pedido->proveedor->nombre_comercial): ?>
                                                            <br><small class="text-muted"><?php echo e($pedido->proveedor->nombre_comercial); ?></small>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php else: ?>
                                                    <span class="text-muted">Sin proveedor</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php echo e($pedido->fecha_pedido ? $pedido->fecha_pedido->format('d/m/Y') : '-'); ?>

                                            </td>
                                            <td>
                                                <?php echo e($pedido->fecha_entrega_esperada ? $pedido->fecha_entrega_esperada->format('d/m/Y') : '-'); ?>

                                                <?php if($pedido->fecha_entrega_esperada && $pedido->fecha_entrega_esperada->isPast() && $pedido->estado !== 'entregado'): ?>
                                                    <br><small class="text-danger"><i class="fas fa-exclamation-triangle"></i> Retrasado</small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <strong>S/ <?php echo e(number_format($pedido->total, 2)); ?></strong>
                                            </td>
                                            <td>
                                                <?php switch($pedido->estado):
                                                    case ('pendiente'): ?>
                                                        <span class="badge bg-warning">Pendiente</span>
                                                        <?php break; ?>
                                                    <?php case ('confirmado'): ?>
                                                        <span class="badge bg-info">Confirmado</span>
                                                        <?php break; ?>
                                                    <?php case ('entregado'): ?>
                                                        <span class="badge bg-success">Entregado</span>
                                                        <?php break; ?>
                                                    <?php case ('cancelado'): ?>
                                                        <span class="badge bg-danger">Cancelado</span>
                                                        <?php break; ?>
                                                    <?php default: ?>
                                                        <span class="badge bg-secondary"><?php echo e(ucfirst($pedido->estado)); ?></span>
                                                <?php endswitch; ?>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?php echo e(route('pedidos.show', $pedido)); ?>" 
                                                       class="btn btn-sm btn-outline-info" 
                                                       title="Ver detalles">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    
                                                    <?php if($pedido->estado == 'pendiente'): ?>
                                                        <a href="<?php echo e(route('pedidos.edit', $pedido)); ?>" 
                                                           class="btn btn-sm btn-outline-warning" 
                                                           title="Editar">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        
                                                        <form method="POST" 
                                                              action="<?php echo e(route('pedidos.confirmar', $pedido)); ?>" 
                                                              style="display: inline;"
                                                              onsubmit="return confirm('¿Confirmar este pedido?')">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('PATCH'); ?>
                                                            <button type="submit" 
                                                                    class="btn btn-sm btn-outline-success" 
                                                                    title="Confirmar">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                        </form>
                                                    <?php endif; ?>
                                                    
                                                    <?php if($pedido->estado == 'confirmado'): ?>
                                                        <form method="POST" 
                                                              action="<?php echo e(route('pedidos.entregar', $pedido)); ?>" 
                                                              style="display: inline;"
                                                              onsubmit="return confirm('¿Marcar como entregado?')">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('PATCH'); ?>
                                                            <button type="submit" 
                                                                    class="btn btn-sm btn-outline-primary" 
                                                                    title="Entregar">
                                                                <i class="fas fa-truck"></i>
                                                            </button>
                                                        </form>
                                                    <?php endif; ?>
                                                    
                                                    <?php if($pedido->estado == 'pendiente'): ?>
                                                        <form method="POST" 
                                                              action="<?php echo e(route('pedidos.destroy', $pedido)); ?>" 
                                                              style="display: inline;"
                                                              onsubmit="return confirm('¿Está seguro de eliminar este pedido?')">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('DELETE'); ?>
                                                            <button type="submit" 
                                                                    class="btn btn-sm btn-outline-danger" 
                                                                    title="Eliminar">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        <?php if(isset($pedidos) && is_object($pedidos) && method_exists($pedidos, 'hasPages') && $pedidos->hasPages()): ?>
                            <div class="card-footer">
                                <?php echo e($pedidos->withQueryString()->links()); ?>

                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">No se encontraron pedidos</h5>
                            <p class="text-muted">No hay pedidos registrados o no coinciden con los filtros aplicados.</p>
                            <a href="<?php echo e(route('pedidos.create')); ?>" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i>
                                Crear primer pedido
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
    const filterSelects = document.querySelectorAll('#proveedor_id, #estado');
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            this.closest('form').submit();
        });
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cesodo4\resources\views/pedidos/index.blade.php ENDPATH**/ ?>