<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Encabezado -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-primary">
                    <i class="fas fa-puzzle-piece me-2"></i>Campos Dinámicos
                    <?php if($module): ?>
                        <span class="badge bg-info ms-2"><?php echo e(ucfirst($module)); ?></span>
                    <?php endif; ?>
                </h2>
                <div class="btn-group">
                    <a href="<?php echo e(route('dynamic-fields.create', ['module' => $module])); ?>" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>Nuevo Campo
                    </a>
                    <a href="<?php echo e(route('dynamic-fields.form-builder')); ?>" class="btn btn-success">
                        <i class="fas fa-magic me-1"></i>Constructor Visual
                    </a>
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-filter me-1"></i>Filtrar por Módulo
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item <?php echo e(!$module ? 'active' : ''); ?>" href="<?php echo e(route('dynamic-fields.index')); ?>">
                                <i class="fas fa-list me-2"></i>Todos los módulos
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <?php $__currentLoopData = $availableModules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $moduleKey => $moduleName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><a class="dropdown-item <?php echo e($module == $moduleKey ? 'active' : ''); ?>"
                                   href="<?php echo e(route('dynamic-fields.index', ['module' => $moduleKey])); ?>">
                                <i class="fas fa-cube me-2"></i><?php echo e($moduleName); ?>

                            </a></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
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

            <!-- Estadísticas rápidas -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card border-primary">
                        <div class="card-body text-center">
                            <i class="fas fa-puzzle-piece fa-2x text-primary mb-2"></i>
                            <h5 class="card-title"><?php echo e($fields->total()); ?></h5>
                            <p class="card-text text-muted">Campos Totales</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card border-success">
                        <div class="card-body text-center">
                            <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                            <h5 class="card-title"><?php echo e($fields->where('is_active', true)->count()); ?></h5>
                            <p class="card-text text-muted">Campos Activos</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card border-info">
                        <div class="card-body text-center">
                            <i class="fas fa-layer-group fa-2x text-info mb-2"></i>
                            <h5 class="card-title"><?php echo e($groups->count()); ?></h5>
                            <p class="card-text text-muted">Grupos</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card border-warning">
                        <div class="card-body text-center">
                            <i class="fas fa-cubes fa-2x text-warning mb-2"></i>
                            <h5 class="card-title"><?php echo e(count($availableModules)); ?></h5>
                            <p class="card-text text-muted">Módulos Disponibles</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lista de campos -->
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list me-2"></i>Campos Dinámicos
                        <?php if($module): ?>
                            - <?php echo e($availableModules[$module] ?? ucfirst($module)); ?>

                        <?php endif; ?>
                    </h5>
                </div>
                <div class="card-body">
                    <?php if($fields->isEmpty()): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-puzzle-piece fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">No hay campos dinámicos</h5>
                            <p class="text-muted">
                                <?php if($module): ?>
                                    No hay campos creados para el módulo <?php echo e($availableModules[$module] ?? ucfirst($module)); ?>

                                <?php else: ?>
                                    No hay campos dinámicos creados en el sistema
                                <?php endif; ?>
                            </p>
                            <a href="<?php echo e(route('dynamic-fields.create', ['module' => $module])); ?>" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i>Crear Primer Campo
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle" id="fieldsTable">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 20px;">
                                            <i class="fas fa-arrows-alt text-muted" title="Arrastrar para reordenar"></i>
                                        </th>
                                        <th>Campo</th>
                                        <th>Módulo</th>
                                        <th>Tipo</th>
                                        <th>Grupo</th>
                                        <th>Estado</th>
                                        <th>Orden</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="sortableFields">
                                    <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr data-field-id="<?php echo e($field->id); ?>" data-sort-order="<?php echo e($field->sort_order); ?>">
                                        <td class="text-center">
                                            <i class="fas fa-grip-vertical text-muted drag-handle" style="cursor: move;"></i>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="me-2">
                                                    <?php
                                                        $typeIcons = [
                                                            'text' => 'fa-font',
                                                            'textarea' => 'fa-align-left',
                                                            'number' => 'fa-hashtag',
                                                            'email' => 'fa-envelope',
                                                            'password' => 'fa-lock',
                                                            'date' => 'fa-calendar',
                                                            'datetime' => 'fa-calendar-alt',
                                                            'time' => 'fa-clock',
                                                            'select' => 'fa-list',
                                                            'checkbox' => 'fa-check-square',
                                                            'radio' => 'fa-dot-circle',
                                                            'file' => 'fa-file',
                                                            'image' => 'fa-image',
                                                            'url' => 'fa-link',
                                                            'tel' => 'fa-phone'
                                                        ];
                                                    ?>
                                                    <i class="fas <?php echo e($typeIcons[$field->type] ?? 'fa-question'); ?> text-primary"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0"><?php echo e($field->label); ?></h6>
                                                    <small class="text-muted"><?php echo e($field->name); ?></small>
                                                    <?php if($field->is_required): ?>
                                                        <span class="badge bg-danger ms-1">Obligatorio</span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info"><?php echo e($availableModules[$field->module] ?? ucfirst($field->module)); ?></span>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary"><?php echo e(ucfirst($field->type)); ?></span>
                                        </td>
                                        <td>
                                            <?php if($field->group): ?>
                                                <span class="badge bg-primary"><?php echo e($field->group); ?></span>
                                            <?php else: ?>
                                                <span class="text-muted">Sin grupo</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($field->is_active): ?>
                                                <span class="badge bg-success">Activo</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Inactivo</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark"><?php echo e($field->sort_order); ?></span>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm">
                                                <a href="<?php echo e(route('dynamic-fields.show', $field)); ?>"
                                                   class="btn btn-outline-info" title="Ver">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="<?php echo e(route('dynamic-fields.edit', $field)); ?>"
                                                   class="btn btn-outline-primary" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-outline-secondary"
                                                        title="Duplicar" onclick="duplicateField(<?php echo e($field->id); ?>)">
                                                    <i class="fas fa-copy"></i>
                                                </button>
                                                <button type="button" class="btn btn-outline-danger"
                                                        title="Eliminar" onclick="deleteField(<?php echo e($field->id); ?>, '<?php echo e($field->label); ?>')">
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
                        <div class="d-flex justify-content-center">
                            <?php echo e($fields->links()); ?>

                        </div>
                    <?php endif; ?>
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
                <p>¿Estás seguro de que deseas eliminar el campo <strong id="fieldNameToDelete"></strong>?</p>
                <p class="text-warning">
                    <i class="fas fa-exclamation-triangle me-1"></i>
                    Esta acción eliminará también todos los valores asociados y no se puede deshacer.
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
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
// Función para eliminar campo
function deleteField(fieldId, fieldName) {
    document.getElementById('fieldNameToDelete').textContent = fieldName;
    document.getElementById('deleteForm').action = `/dynamic-fields/${fieldId}`;

    var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}

// Función para duplicar campo
function duplicateField(fieldId) {
    if (confirm('¿Deseas duplicar este campo? Se creará una copia que podrás editar.')) {
        // Crear form temporal para enviar POST
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/dynamic-fields/${fieldId}/duplicate`;

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

// Inicializar ordenamiento por arrastre
document.addEventListener('DOMContentLoaded', function() {
    const sortableElement = document.getElementById('sortableFields');

    if (sortableElement) {
        Sortable.create(sortableElement, {
            handle: '.drag-handle',
            animation: 150,
            onEnd: function(evt) {
                updateFieldOrder();
            }
        });
    }
});

// Actualizar orden de campos
function updateFieldOrder() {
    const rows = document.querySelectorAll('#sortableFields tr');
    const fieldsData = [];

    rows.forEach((row, index) => {
        fieldsData.push({
            id: parseInt(row.dataset.fieldId),
            sort_order: index
        });
    });

    // Enviar actualización al servidor
    fetch('/dynamic-fields/reorder', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
        },
        body: JSON.stringify({
            fields: fieldsData
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Mostrar mensaje de éxito brevemente
            showToast('Orden actualizado exitosamente', 'success');
        } else {
            showToast('Error al actualizar el orden', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Error de conexión', 'error');
    });
}

// Función para mostrar toast (notificación pequeña)
function showToast(message, type) {
    const toast = document.createElement('div');
    toast.className = `alert alert-${type === 'success' ? 'success' : 'danger'} position-fixed`;
    toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    toast.innerHTML = `
        ${message}
        <button type="button" class="btn-close" onclick="this.parentElement.remove()"></button>
    `;

    document.body.appendChild(toast);

    // Remover automáticamente después de 3 segundos
    setTimeout(() => {
        if (toast.parentElement) {
            toast.remove();
        }
    }, 3000);
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cesodo4\resources\views/dynamic-fields/index.blade.php ENDPATH**/ ?>