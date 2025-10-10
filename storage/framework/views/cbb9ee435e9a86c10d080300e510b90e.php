<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Encabezado -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-primary">
                    <i class="fas fa-edit me-2"></i>Editar Rol
                </h2>
                <div class="btn-group">
                    <a href="<?php echo e(route('role-management.show', $role)); ?>" class="btn btn-info">
                        <i class="fas fa-eye me-1"></i>Ver
                    </a>
                    <a href="<?php echo e(route('role-management.index')); ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Volver
                    </a>
                </div>
            </div>

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

            <!-- Información del rol -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h5 class="mb-1"><?php echo e($role->name); ?></h5>
                            <p class="text-muted mb-0">
                                <i class="fas fa-calendar me-1"></i>
                                Creado: <?php echo e($role->created_at->format('d/m/Y H:i')); ?>

                                <?php if($role->updated_at != $role->created_at): ?>
                                | <i class="fas fa-edit me-1"></i>Modificado: <?php echo e($role->updated_at->format('d/m/Y H:i')); ?>

                                <?php endif; ?>
                            </p>
                        </div>
                        <div class="col-md-4 text-end">
                            <span class="badge bg-info"><?php echo e($role->permissions->count()); ?> permisos</span>
                            <span class="badge bg-secondary"><?php echo e($role->users->count()); ?> usuarios</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulario de edición -->
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user-edit me-2"></i>Editar Información del Rol
                    </h5>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('role-management.update', $role)); ?>" method="POST" id="roleForm">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <!-- Información básica del rol -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label fw-bold">
                                    <i class="fas fa-tag me-1"></i>Nombre del Rol *
                                </label>
                                <input type="text"
                                       class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="name"
                                       name="name"
                                       value="<?php echo e(old('name', $role->name)); ?>"
                                       placeholder="Ej: Administrador, Editor, Supervisor"
                                       required>
                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    El nombre debe ser único y descriptivo del rol
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="description" class="form-label fw-bold">
                                    <i class="fas fa-align-left me-1"></i>Descripción
                                </label>
                                <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                          id="description"
                                          name="description"
                                          rows="3"
                                          placeholder="Descripción opcional del rol y sus responsabilidades"><?php echo e(old('description', $role->description ?? '')); ?></textarea>
                                <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <!-- Asignación de permisos -->
                        <div class="card mt-4">
                            <div class="card-header bg-info text-white">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="card-title mb-0">
                                        <i class="fas fa-key me-2"></i>Gestionar Permisos
                                    </h6>
                                    <span class="badge bg-light text-dark">
                                        <span id="selectedCount"><?php echo e($role->permissions->count()); ?></span> seleccionados
                                    </span>
                                </div>
                            </div>
                            <div class="card-body">
                                <?php if($permissions->isEmpty()): ?>
                                    <div class="text-center py-4">
                                        <i class="fas fa-lock fa-3x text-muted mb-3"></i>
                                        <h6 class="text-muted">No hay permisos disponibles</h6>
                                        <p class="text-muted">Los permisos se crearán automáticamente al usar el sistema</p>
                                    </div>
                                <?php else: ?>
                                    <!-- Controles de selección masiva -->
                                    <div class="mb-3">
                                        <button type="button" class="btn btn-sm btn-outline-primary me-2" onclick="selectAllPermissions()">
                                            <i class="fas fa-check-double me-1"></i>Seleccionar Todo
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary me-2" onclick="clearAllPermissions()">
                                            <i class="fas fa-times me-1"></i>Limpiar Selección
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-info" onclick="resetToOriginal()">
                                            <i class="fas fa-undo me-1"></i>Restaurar Original
                                        </button>
                                    </div>

                                    <!-- Permisos agrupados por módulo -->
                                    <div class="accordion" id="permissionsAccordion">
                                        <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module => $modulePermissions): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="heading<?php echo e(Str::slug($module)); ?>">
                                                <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapse<?php echo e(Str::slug($module)); ?>"
                                                        aria-expanded="false"
                                                        aria-controls="collapse<?php echo e(Str::slug($module)); ?>">
                                                    <div class="d-flex align-items-center w-100">
                                                        <i class="fas fa-cube me-2"></i>
                                                        <span class="fw-bold text-capitalize"><?php echo e($module); ?></span>
                                                        <span class="badge bg-primary ms-auto me-2">
                                                            <span id="module-<?php echo e(Str::slug($module)); ?>-count">
                                                                <?php echo e($modulePermissions->intersect($role->permissions)->count()); ?>

                                                            </span>/<?php echo e($modulePermissions->count()); ?>

                                                        </span>
                                                    </div>
                                                </button>
                                            </h2>
                                            <div id="collapse<?php echo e(Str::slug($module)); ?>"
                                                 class="accordion-collapse collapse <?php echo e($loop->first ? 'show' : ''); ?>"
                                                 aria-labelledby="heading<?php echo e(Str::slug($module)); ?>"
                                                 data-bs-parent="#permissionsAccordion">
                                                <div class="accordion-body">
                                                    <div class="row">
                                                        <?php $__currentLoopData = $modulePermissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div class="col-md-6 col-lg-4 mb-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input permission-checkbox"
                                                                       type="checkbox"
                                                                       value="<?php echo e($permission->id); ?>"
                                                                       id="permission_<?php echo e($permission->id); ?>"
                                                                       name="permissions[]"
                                                                       data-module="<?php echo e(Str::slug($module)); ?>"
                                                                       data-original="<?php echo e($role->hasPermissionTo($permission->name) ? 'true' : 'false'); ?>"
                                                                       <?php echo e($role->hasPermissionTo($permission->name) ? 'checked' : ''); ?>>
                                                                <label class="form-check-label" for="permission_<?php echo e($permission->id); ?>">
                                                                    <?php echo e($permission->name); ?>

                                                                </label>
                                                            </div>
                                                        </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </div>

                                                    <!-- Botón para seleccionar/deseleccionar todo el módulo -->
                                                    <div class="mt-3">
                                                        <button type="button" class="btn btn-sm btn-outline-info"
                                                                onclick="toggleModulePermissions('<?php echo e(Str::slug($module)); ?>')">
                                                            <i class="fas fa-toggle-on me-1"></i>Alternar Módulo
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="d-flex justify-content-between mt-4">
                            <div>
                                <a href="<?php echo e(route('role-management.index')); ?>" class="btn btn-light">
                                    <i class="fas fa-times me-1"></i>Cancelar
                                </a>
                                <button type="button" class="btn btn-outline-warning" onclick="resetToOriginal()">
                                    <i class="fas fa-undo me-1"></i>Deshacer Cambios
                                </button>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Actualizar Rol
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Seleccionar todos los permisos
function selectAllPermissions() {
    const checkboxes = document.querySelectorAll('.permission-checkbox');
    checkboxes.forEach(checkbox => checkbox.checked = true);
    updateCounters();
}

// Limpiar selección de permisos
function clearAllPermissions() {
    if (confirm('¿Deseas limpiar todos los permisos seleccionados?')) {
        const checkboxes = document.querySelectorAll('.permission-checkbox');
        checkboxes.forEach(checkbox => checkbox.checked = false);
        updateCounters();
    }
}

// Restaurar a la configuración original
function resetToOriginal() {
    const checkboxes = document.querySelectorAll('.permission-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = checkbox.dataset.original === 'true';
    });
    updateCounters();
}

// Alternar permisos de un módulo específico
function toggleModulePermissions(module) {
    const accordionBody = document.querySelector('#collapse' + module + ' .accordion-body');
    const checkboxes = accordionBody.querySelectorAll('.permission-checkbox');

    // Verificar si todos están marcados
    const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);

    // Si todos están marcados, desmarcar todos; si no, marcar todos
    checkboxes.forEach(checkbox => checkbox.checked = !allChecked);
    updateCounters();
}

// Actualizar contadores
function updateCounters() {
    // Contador total
    const totalSelected = document.querySelectorAll('.permission-checkbox:checked').length;
    document.getElementById('selectedCount').textContent = totalSelected;

    // Contadores por módulo
    const modules = {};
    document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
        const module = checkbox.dataset.module;
        if (!modules[module]) {
            modules[module] = { total: 0, selected: 0 };
        }
        modules[module].total++;
        if (checkbox.checked) {
            modules[module].selected++;
        }
    });

    // Actualizar badges de módulos
    Object.keys(modules).forEach(module => {
        const counter = document.getElementById(`module-${module}-count`);
        if (counter) {
            counter.textContent = modules[module].selected;
        }
    });
}

// Validación del formulario
document.getElementById('roleForm').addEventListener('submit', function(e) {
    const roleName = document.getElementById('name').value.trim();

    if (!roleName) {
        e.preventDefault();
        alert('El nombre del rol es obligatorio');
        document.getElementById('name').focus();
        return false;
    }

    return true;
});

// Eventos de cambio en checkboxes
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', updateCounters);
    });

    // Inicializar contadores
    updateCounters();

    // Marcar cambios no guardados
    let hasChanges = false;

    document.querySelectorAll('.permission-checkbox, #name, #description').forEach(input => {
        input.addEventListener('change', function() {
            hasChanges = true;
            document.title = '● ' + document.title.replace('● ', '');
        });
    });

    // Advertir sobre cambios no guardados
    window.addEventListener('beforeunload', function(e) {
        if (hasChanges) {
            e.preventDefault();
            e.returnValue = '';
        }
    });

    // Resetear flag al enviar formulario
    document.getElementById('roleForm').addEventListener('submit', function() {
        hasChanges = false;
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cesodo4\resources\views/role-management/edit.blade.php ENDPATH**/ ?>