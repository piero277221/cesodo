<?php $__env->startSection('title', 'Categorías'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .categorias-header {
        background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%);
        color: white;
        padding: 2rem 0;
        margin-bottom: 2rem;
        border-radius: 0 0 1rem 1rem;
    }
    .card-categorias {
        border: none;
        border-radius: 15px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }
    .btn-categorias {
        background: #6f42c1;
        border: none;
        border-radius: 8px;
        padding: 0.6rem 1.5rem;
        color: white;
        transition: all 0.3s ease;
    }
    .btn-categorias:hover {
        background: #5a32a3;
        transform: translateY(-2px);
        color: white;
    }
    .badge-estado {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 500;
    }
    .badge-activo {
        background-color: #d4edda;
        color: #155724;
    }
    .badge-inactivo {
        background-color: #f8d7da;
        color: #721c24;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="categorias-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="h2 mb-2">
                        <i class="fas fa-tags me-3"></i>
                        Gestión de Categorías
                    </h1>
                    <p class="mb-0 opacity-90">
                        Administra las categorías de productos del sistema
                    </p>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="<?php echo e(route('categorias.create')); ?>" class="btn btn-light btn-lg">
                        <i class="fas fa-plus me-2"></i>
                        Nueva Categoría
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido -->
    <div class="container">
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

        <div class="card card-categorias">
            <div class="card-header bg-white border-0 pb-0">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h5 class="mb-0">
                            <i class="fas fa-list me-2 text-primary"></i>
                            Lista de Categorías
                        </h5>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <span class="text-muted">Total: <?php echo e($categorias->total()); ?> categorías</span>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <?php if($categorias->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 px-4 py-3">Código</th>
                                    <th class="border-0 py-3">Nombre</th>
                                    <th class="border-0 py-3">Descripción</th>
                                    <th class="border-0 py-3">Productos</th>
                                    <th class="border-0 py-3">Estado</th>
                                    <th class="border-0 py-3 text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="px-4 py-3">
                                            <span class="badge bg-secondary"><?php echo e($categoria->codigo); ?></span>
                                        </td>
                                        <td class="py-3">
                                            <strong><?php echo e($categoria->nombre); ?></strong>
                                        </td>
                                        <td class="py-3">
                                            <span class="text-muted">
                                                <?php echo e(Str::limit($categoria->descripcion ?? 'Sin descripción', 50)); ?>

                                            </span>
                                        </td>
                                        <td class="py-3">
                                            <span class="badge bg-info">
                                                <?php echo e($categoria->productos()->count()); ?> productos
                                            </span>
                                        </td>
                                        <td class="py-3">
                                            <span class="badge badge-estado <?php echo e($categoria->estado == 'activo' ? 'badge-activo' : 'badge-inactivo'); ?>">
                                                <?php echo e(ucfirst($categoria->estado)); ?>

                                            </span>
                                        </td>
                                        <td class="py-3 text-center">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="<?php echo e(route('categorias.show', $categoria)); ?>"
                                                   class="btn btn-outline-primary"
                                                   title="Ver detalles">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="<?php echo e(route('categorias.edit', $categoria)); ?>"
                                                   class="btn btn-outline-warning"
                                                   title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <?php if($categoria->productos()->count() == 0): ?>
                                                    <form action="<?php echo e(route('categorias.destroy', $categoria)); ?>"
                                                          method="POST"
                                                          class="d-inline"
                                                          onsubmit="return confirm('¿Estás seguro de eliminar esta categoría?')">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button type="submit"
                                                                class="btn btn-outline-danger"
                                                                title="Eliminar">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                <?php else: ?>
                                                    <button class="btn btn-outline-secondary"
                                                            disabled
                                                            title="No se puede eliminar - tiene productos asociados">
                                                        <i class="fas fa-lock"></i>
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    <?php if($categorias->hasPages()): ?>
                        <div class="card-footer bg-white border-0">
                            <?php echo e($categorias->links()); ?>

                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fas fa-tags fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted">No hay categorías registradas</h5>
                        <p class="text-muted">Comienza creando tu primera categoría</p>
                        <a href="<?php echo e(route('categorias.create')); ?>" class="btn btn-categorias">
                            <i class="fas fa-plus me-2"></i>
                            Crear Primera Categoría
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cesodo4\resources\views/categorias/index.blade.php ENDPATH**/ ?>