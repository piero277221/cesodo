<?php $__env->startSection('title', 'Configuraciones del Sistema'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1">
                                <i class="bi bi-sliders me-2"></i>
                                Configuraciones del Sistema
                            </h4>
                            <p class="text-muted mb-0">
                                <i class="bi bi-info-circle me-1"></i>
                                Personaliza y configura tu sistema de manera fácil
                            </p>
                        </div>
                        <div>
                            <span class="badge bg-success">
                                <i class="bi bi-check-circle me-1"></i>
                                Sistema Activo
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mensajes de éxito/error -->
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Tabs de Configuración -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <!-- Nav Tabs -->
                    <ul class="nav nav-tabs nav-fill border-bottom-0" role="tablist" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);">
                        <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link <?php echo e($tab === $key ? 'active' : ''); ?> text-white"
                                   href="?tab=<?php echo e($key); ?>"
                                   style="border: none; padding: 1.2rem 1.5rem; <?php echo e($tab === $key ? 'background: #dc3545; font-weight: 600;' : ''); ?>">
                                    <i class="bi <?php echo e($categoria['icono']); ?> me-2" style="font-size: 1.2rem;"></i>
                                    <div class="d-none d-md-inline">
                                        <div style="font-size: 0.95rem;"><?php echo e($categoria['nombre']); ?></div>
                                        <small class="d-block mt-1" style="opacity: 0.8; font-size: 0.75rem;"><?php echo e($categoria['descripcion']); ?></small>
                                    </div>
                                    <div class="d-inline d-md-none"><?php echo e(explode(' ', $categoria['nombre'])[0]); ?></div>
                                </a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content p-4">
                        <!-- Tab: Empresa -->
                        <?php if($tab === 'empresa'): ?>
                            <?php echo $__env->make('configuraciones.tabs.empresa', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        <?php endif; ?>

                        <!-- Tab: Sistema -->
                        <?php if($tab === 'sistema'): ?>
                            <?php echo $__env->make('configuraciones.tabs.sistema', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        <?php endif; ?>

                        <!-- Tab: Permisos -->
                        <?php if($tab === 'permisos'): ?>
                            <?php echo $__env->make('configuraciones.tabs.permisos', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        <?php endif; ?>

                        <!-- Tab: Notificaciones -->
                        <?php if($tab === 'notificaciones'): ?>
                            <?php echo $__env->make('configuraciones.tabs.notificaciones', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        <?php endif; ?>

                        <!-- Tab: Interfaz -->
                        <?php if($tab === 'interfaz'): ?>
                            <?php echo $__env->make('configuraciones.tabs.interfaz', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.nav-tabs .nav-link {
    transition: all 0.3s ease;
}

.nav-tabs .nav-link:hover:not(.active) {
    background: rgba(220, 53, 69, 0.1) !important;
    transform: translateY(-2px);
}

.nav-tabs .nav-link.active {
    border-bottom: 3px solid #dc3545 !important;
}

.card {
    transition: transform 0.2s, box-shadow 0.2s;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cesodo4\resources\views/configuraciones/index.blade.php ENDPATH**/ ?>