<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Encabezado -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-primary">
                    <i class="fas fa-users-cog me-2"></i>Gestión Avanzada de Roles
                </h2>
                <div class="btn-group">
                    <a href="<?php echo e(route('role-management.create')); ?>" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>Crear Rol
                    </a>
                    <a href="<?php echo e(route('role-management.matrix')); ?>" class="btn btn-info">
                        <i class="fas fa-table me-1"></i>Matriz de Permisos
                    </a>
                    <a href="<?php echo e(route('role-management.stats')); ?>" class="btn btn-success">
                        <i class="fas fa-chart-bar me-1"></i>Estadísticas
                    </a>
                </div>
            </div>

            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-1"></i><?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-1"></i>
                    <ul class="mb-0">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Card de Roles -->
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list me-2"></i>Roles del Sistema
                    </h5>
                </div>
                <div class="card-body">
                    <?php if($roles->isEmpty()): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-users-slash fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">No hay roles registrados</h5>
                            <p class="text-muted">Comienza creando tu primer rol del sistema</p>
                            <a href="<?php echo e(route('role-management.create')); ?>" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i>Crear Primer Rol
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Rol</th>
                                        <th>Permisos</th>
                                        <th>Usuarios Asignados</th>
                                        <th>Creado</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                    <?php echo e(substr($role->name, 0, 2)); ?>

                                                </div>
                                                <div>
                                                    <h6 class="mb-0"><?php echo e($role->name); ?></h6>
                                                    <small class="text-muted">ID: <?php echo e($role->id); ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info"><?php echo e($role->permissions->count()); ?> permisos</span>
                                            <?php if($role->permissions->isNotEmpty()): ?>
                                                <button class="btn btn-sm btn-link p-0 ms-2" data-bs-toggle="popover"
                                                        data-bs-trigger="hover" data-bs-html="true"
                                                        data-bs-content="<ul class='list-unstyled mb-0'><?php $__currentLoopData = $role->permissions->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($permission->name); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> <?php if($role->permissions->count() > 5): ?><li><em>y <?php echo e($role->permissions->count() - 5); ?> más...</em></li><?php endif; ?></ul>">
                                                    <i class="fas fa-info-circle text-muted"></i>
                                                </button>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary"><?php echo e($role->users->count()); ?> usuarios</span>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <?php echo e($role->created_at->format('d/m/Y H:i')); ?>

                                            </small>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm">
                                                <a href="<?php echo e(route('role-management.show', $role)); ?>" class="btn btn-outline-info" title="Ver">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="<?php echo e(route('role-management.edit', $role)); ?>" class="btn btn-outline-primary" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-outline-secondary" title="Clonar"
                                                        onclick="cloneRole(<?php echo e($role->id); ?>)">
                                                    <i class="fas fa-copy"></i>
                                                </button>
                                                <?php if($role->users->count() === 0): ?>
                                                <button type="button" class="btn btn-outline-danger" title="Eliminar"
                                                        onclick="deleteRole(<?php echo e($role->id); ?>, '<?php echo e($role->name); ?>')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Resumen de permisos por módulo -->
            <?php if($permissions->isNotEmpty()): ?>
            <div class="card shadow mt-4">
                <div class="card-header bg-info text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-sitemap me-2"></i>Permisos por Módulo
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module => $modulePermissions): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-4 mb-3">
                            <div class="card border-light">
                                <div class="card-body text-center">
                                    <h6 class="card-title text-capitalize"><?php echo e($module); ?></h6>
                                    <span class="badge bg-primary"><?php echo e($modulePermissions->count()); ?> permisos</span>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
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
                    Esta acción no se puede deshacer.
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
// Inicializar popovers
var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
    return new bootstrap.Popover(popoverTriggerEl)
})

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
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cesodo4\resources\views/role-management/index.blade.php ENDPATH**/ ?>