<?php $__env->startSection('title', 'Gestión de Usuarios'); ?>

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
                                    <i class="fas fa-users"></i>
                                </div>
                                <div>
                                    <h1 class="h3 mb-1 text-primary">Gestión de Usuarios</h1>
                                    <p class="text-muted mb-0">Administra los usuarios del sistema y sus permisos</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="<?php echo e(route('usuarios.create')); ?>" class="btn btn-primary btn-lg">
                                <i class="fas fa-plus me-2"></i>
                                Nuevo Usuario
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
                            <i class="fas fa-user-check"></i>
                        </div>
                        <div class="ms-3">
                            <div class="text-muted small">Usuarios Activos</div>
                            <div class="h4 mb-0 text-success"><?php echo e($usuarios->where('estado', 'activo')->count()); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-modern h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape" style="background: var(--danger-color);">
                            <i class="fas fa-user-times"></i>
                        </div>
                        <div class="ms-3">
                            <div class="text-muted small">Usuarios Inactivos</div>
                            <div class="h4 mb-0 text-danger"><?php echo e($usuarios->where('estado', 'inactivo')->count()); ?></div>
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
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <div class="ms-3">
                            <div class="text-muted small">Administradores</div>
                            <div class="h4 mb-0 text-info"><?php echo e($usuarios->filter(function($user) { return $user->hasRole('admin'); })->count()); ?></div>
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
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="ms-3">
                            <div class="text-muted small">Total Usuarios</div>
                            <div class="h4 mb-0 text-warning"><?php echo e($usuarios->count()); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros y búsqueda modernos -->
    <div class="card border-0 shadow-modern mb-4">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-filter me-2"></i>
                Filtros de Búsqueda
            </h5>
        </div>
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('usuarios.index')); ?>" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Buscar usuario</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" name="search" class="form-control"
                               placeholder="Nombre, email o DNI..."
                               value="<?php echo e(request('search')); ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Estado</label>
                    <select name="estado" class="form-select">
                        <option value="">Todos</option>
                        <option value="activo" <?php echo e(request('estado') == 'activo' ? 'selected' : ''); ?>>Activo</option>
                        <option value="inactivo" <?php echo e(request('estado') == 'inactivo' ? 'selected' : ''); ?>>Inactivo</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Rol</label>
                    <select name="rol" class="form-select">
                        <option value="">Todos los roles</option>
                        <?php $__currentLoopData = \Spatie\Permission\Models\Role::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rol): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($rol->name); ?>" <?php echo e(request('rol') == $rol->name ? 'selected' : ''); ?>>
                                <?php echo e(ucfirst($rol->name)); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="fas fa-search me-1"></i>
                                    Buscar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabla de usuarios -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-list me-2"></i>
                        Lista de Usuarios (<?php echo e($usuarios->total()); ?>)
                    </h6>
                </div>
                <div class="card-body">
                    <?php if($usuarios->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Usuario</th>
                                        <th>Información Personal</th>
                                        <th>Empleado</th>
                                        <th>Roles</th>
                                        <th>Estado</th>
                                        <th>Último Acceso</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usuario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3"
                                                         style="width: 40px; height: 40px;">
                                                        <i class="fas fa-user text-white"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold"><?php echo e($usuario->name); ?></div>
                                                        <small class="text-muted"><?php echo e($usuario->email); ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <?php if($usuario->persona): ?>
                                                    <div>
                                                        <small class="text-muted">DNI:</small> <?php echo e($usuario->persona->numero_documento); ?><br>
                                                        <small class="text-muted">Teléfono:</small> <?php echo e($usuario->persona->celular ?? 'N/A'); ?>

                                                    </div>
                                                <?php else: ?>
                                                    <span class="text-muted">No asignado</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($usuario->trabajador): ?>
                                                    <div>
                                                        <div class="fw-semibold"><?php echo e($usuario->trabajador->codigo); ?></div>
                                                        <small class="text-muted"><?php echo e($usuario->trabajador->cargo ?? 'Sin cargo'); ?></small>
                                                    </div>
                                                <?php else: ?>
                                                    <span class="text-muted">No es empleado</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php $__empty_1 = true; $__currentLoopData = $usuario->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rol): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                    <span class="badge bg-info me-1"><?php echo e($rol->name); ?></span>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                    <span class="text-muted">Sin roles</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($usuario->estado == 'activo'): ?>
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check me-1"></i>Activo
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">
                                                        <i class="fas fa-times me-1"></i>Inactivo
                                                    </span>
                                                <?php endif; ?>

                                                <?php if($usuario->cambiar_password): ?>
                                                    <br><small class="text-warning">
                                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                                        Debe cambiar contraseña
                                                    </small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($usuario->ultimo_acceso): ?>
                                                    <?php echo e($usuario->ultimo_acceso->format('d/m/Y H:i')); ?>

                                                <?php else: ?>
                                                    <span class="text-muted">Nunca</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?php echo e(route('usuarios.show', $usuario)); ?>"
                                                       class="btn btn-sm btn-outline-info"
                                                       title="Ver detalles">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="<?php echo e(route('usuarios.edit', $usuario)); ?>"
                                                       class="btn btn-sm btn-outline-primary"
                                                       title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button"
                                                            class="btn btn-sm btn-outline-warning"
                                                            title="Resetear contraseña"
                                                            onclick="resetPassword(<?php echo e($usuario->id); ?>)">
                                                        <i class="fas fa-key"></i>
                                                    </button>
                                                    <button type="button"
                                                            class="btn btn-sm btn-outline-danger"
                                                            title="Eliminar"
                                                            onclick="confirmarEliminacion(<?php echo e($usuario->id); ?>)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="text-muted">
                                Mostrando <?php echo e($usuarios->firstItem()); ?> a <?php echo e($usuarios->lastItem()); ?>

                                de <?php echo e($usuarios->total()); ?> resultados
                            </div>
                            <?php echo e($usuarios->withQueryString()->links()); ?>

                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No hay usuarios registrados</h5>
                            <p class="text-muted">Comienza creando el primer usuario del sistema</p>
                            <a href="<?php echo e(route('usuarios.create')); ?>" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>
                                Crear Primer Usuario
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para resetear contraseña -->
<div class="modal fade" id="resetPasswordModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-key text-warning me-2"></i>
                    Resetear Contraseña
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas resetear la contraseña de este usuario?</p>
                <p class="text-warning">
                    <i class="fas fa-exclamation-triangle me-1"></i>
                    Se generará una nueva contraseña temporal automáticamente.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="resetPasswordForm" method="POST" style="display: inline;">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-key me-1"></i>
                        Resetear Contraseña
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para eliminar -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-trash text-danger me-2"></i>
                    Eliminar Usuario
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas eliminar este usuario?</p>
                <p class="text-danger">
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
                        <i class="fas fa-trash me-1"></i>
                        Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function resetPassword(usuarioId) {
    const form = document.getElementById('resetPasswordForm');
    form.action = `/usuarios/${usuarioId}/reset-password`;

    const modal = new bootstrap.Modal(document.getElementById('resetPasswordModal'));
    modal.show();
}

function confirmarEliminacion(usuarioId) {
    const form = document.getElementById('deleteForm');
    // Usar la ruta con nombre de Laravel en lugar de construir la URL manualmente
    form.action = `<?php echo e(url('usuarios')); ?>/${usuarioId}`;

    console.log('URL de eliminación:', form.action);

    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cesodo4\resources\views/usuarios/index.blade.php ENDPATH**/ ?>