<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Encabezado -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-primary">
                    <i class="fas fa-eye me-2"></i>Detalles del Rol
                </h2>
                <div class="btn-group">
                    <a href="<?php echo e(route('role-management.edit', $role)); ?>" class="btn btn-primary">
                        <i class="fas fa-edit me-1"></i>Editar
                    </a>
                    <a href="<?php echo e(route('role-management.index')); ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Volver
                    </a>
                </div>
            </div>

            <!-- Información básica del rol -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>Información General
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="mb-3"><?php echo e($role->name); ?></h4>
                            <div class="mb-3">
                                <strong><i class="fas fa-hashtag me-1"></i>ID:</strong> <?php echo e($role->id); ?>

                            </div>
                            <div class="mb-3">
                                <strong><i class="fas fa-shield-alt me-1"></i>Guard:</strong>
                                <span class="badge bg-info"><?php echo e($role->guard_name); ?></span>
                            </div>
                            <?php if($role->description): ?>
                            <div class="mb-3">
                                <strong><i class="fas fa-align-left me-1"></i>Descripción:</strong>
                                <p class="text-muted mt-1"><?php echo e($role->description); ?></p>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <div class="row text-center">
                                <div class="col-6">
                                    <div class="card border-info">
                                        <div class="card-body">
                                            <i class="fas fa-key fa-2x text-info mb-2"></i>
                                            <h5 class="card-title"><?php echo e($role->permissions->count()); ?></h5>
                                            <p class="card-text text-muted">Permisos</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card border-secondary">
                                        <div class="card-body">
                                            <i class="fas fa-users fa-2x text-secondary mb-2"></i>
                                            <h5 class="card-title"><?php echo e($role->users->count()); ?></h5>
                                            <p class="card-text text-muted">Usuarios</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="row">
                        <div class="col-md-6">
                            <small class="text-muted">
                                <i class="fas fa-calendar-plus me-1"></i>
                                <strong>Creado:</strong> <?php echo e($role->created_at->format('d/m/Y H:i:s')); ?>

                                (<?php echo e($role->created_at->diffForHumans()); ?>)
                            </small>
                        </div>
                        <div class="col-md-6">
                            <?php if($role->updated_at != $role->created_at): ?>
                            <small class="text-muted">
                                <i class="fas fa-calendar-edit me-1"></i>
                                <strong>Última modificación:</strong> <?php echo e($role->updated_at->format('d/m/Y H:i:s')); ?>

                                (<?php echo e($role->updated_at->diffForHumans()); ?>)
                            </small>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Permisos del rol -->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-key me-2"></i>Permisos Asignados
                                <span class="badge bg-light text-dark ms-2"><?php echo e($role->permissions->count()); ?></span>
                            </h5>
                        </div>
                        <div class="card-body">
                            <?php if($role->permissions->isEmpty()): ?>
                                <div class="text-center py-4">
                                    <i class="fas fa-lock fa-3x text-muted mb-3"></i>
                                    <h6 class="text-muted">Sin permisos asignados</h6>
                                    <p class="text-muted">Este rol no tiene permisos específicos asignados</p>
                                    <a href="<?php echo e(route('role-management.edit', $role)); ?>" class="btn btn-primary">
                                        <i class="fas fa-plus me-1"></i>Asignar Permisos
                                    </a>
                                </div>
                            <?php else: ?>
                                <!-- Permisos agrupados por módulo -->
                                <?php $__currentLoopData = $allPermissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module => $modulePermissions): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $roleModulePermissions = $modulePermissions->intersect($role->permissions);
                                    ?>
                                    <?php if($roleModulePermissions->isNotEmpty()): ?>
                                    <div class="mb-4">
                                        <h6 class="border-bottom pb-2 mb-3">
                                            <i class="fas fa-cube me-2 text-primary"></i>
                                            <span class="text-capitalize"><?php echo e($module); ?></span>
                                            <span class="badge bg-primary"><?php echo e($roleModulePermissions->count()); ?>/<?php echo e($modulePermissions->count()); ?></span>
                                        </h6>
                                        <div class="row">
                                            <?php $__currentLoopData = $roleModulePermissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="col-md-6 col-lg-4 mb-2">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-check text-success me-2"></i>
                                                    <span class="text-truncate" title="<?php echo e($permission->name); ?>">
                                                        <?php echo e($permission->name); ?>

                                                    </span>
                                                </div>
                                            </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Usuarios con este rol -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header bg-secondary text-white">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-users me-2"></i>Usuarios Asignados
                                <span class="badge bg-light text-dark ms-2"><?php echo e($role->users->count()); ?></span>
                            </h6>
                        </div>
                        <div class="card-body">
                            <?php if($role->users->isEmpty()): ?>
                                <div class="text-center py-3">
                                    <i class="fas fa-user-slash fa-2x text-muted mb-2"></i>
                                    <p class="text-muted mb-0">Sin usuarios asignados</p>
                                </div>
                            <?php else: ?>
                                <div class="list-group list-group-flush">
                                    <?php $__currentLoopData = $role->users->take(10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="list-group-item d-flex align-items-center px-0">
                                        <div class="avatar bg-primary text-white rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                            <?php echo e(substr($user->name, 0, 2)); ?>

                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="fw-bold"><?php echo e($user->name); ?></div>
                                            <small class="text-muted"><?php echo e($user->email); ?></small>
                                        </div>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>

                                <?php if($role->users->count() > 10): ?>
                                <div class="text-center mt-2">
                                    <small class="text-muted">
                                        Y <?php echo e($role->users->count() - 10); ?> usuarios más...
                                    </small>
                                </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Acciones adicionales -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-tools me-2"></i>Acciones Avanzadas
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-outline-info btn-sm"
                                        onclick="cloneRole(<?php echo e($role->id); ?>)">
                                    <i class="fas fa-copy me-1"></i>Clonar Rol
                                </button>

                                <a href="<?php echo e(route('role-management.matrix')); ?>" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-table me-1"></i>Ver en Matriz
                                </a>

                                <button type="button" class="btn btn-outline-warning btn-sm"
                                        onclick="exportRoleData()">
                                    <i class="fas fa-download me-1"></i>Exportar Datos
                                </button>

                                <?php if($role->users->count() === 0): ?>
                                <button type="button" class="btn btn-outline-danger btn-sm"
                                        onclick="deleteRole(<?php echo e($role->id); ?>, '<?php echo e($role->name); ?>')">
                                    <i class="fas fa-trash me-1"></i>Eliminar Rol
                                </button>
                                <?php else: ?>
                                <button type="button" class="btn btn-outline-danger btn-sm" disabled title="No se puede eliminar un rol con usuarios asignados">
                                    <i class="fas fa-trash me-1"></i>No se puede eliminar
                                </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmación para eliminar -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas eliminar el rol <strong id="roleNameToDelete"></strong>?</p>
                <p class="text-warning">
                    <i class="fas fa-exclamation-triangle me-1"></i>
                    Esta acción no se puede deshacer y removerá todos los permisos asociados.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i>Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Función para eliminar rol
function deleteRole(roleId, roleName) {
    document.getElementById('roleNameToDelete').textContent = roleName;
    document.getElementById('deleteForm').action = `/role-management/${roleId}`;

    var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}

// Función para clonar rol
function cloneRole(roleId) {
    if (confirm('¿Deseas clonar este rol? Se creará una copia que podrás editar.')) {
        // Crear form temporal para enviar POST
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/role-management/${roleId}/clone`;

        // Token CSRF
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '<?php echo e(csrf_token()); ?>';
        form.appendChild(csrfToken);

        document.body.appendChild(form);
        form.submit();
    }
}

// Función para exportar datos del rol
function exportRoleData() {
    const roleData = {
        id: <?php echo e($role->id); ?>,
        name: '<?php echo e($role->name); ?>',
        permissions: <?php echo json_encode($role->permissions->pluck('name'), 15, 512) ?>,
        users_count: <?php echo e($role->users->count()); ?>,
        created_at: '<?php echo e($role->created_at->toISOString()); ?>'
    };

    const dataStr = JSON.stringify(roleData, null, 2);
    const dataUri = 'data:application/json;charset=utf-8,'+ encodeURIComponent(dataStr);

    const exportFileDefaultName = `rol_${roleData.name.toLowerCase().replace(/\s+/g, '_')}_${new Date().toISOString().split('T')[0]}.json`;

    const linkElement = document.createElement('a');
    linkElement.setAttribute('href', dataUri);
    linkElement.setAttribute('download', exportFileDefaultName);
    linkElement.click();
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cesodo4\resources\views/role-management/show.blade.php ENDPATH**/ ?>