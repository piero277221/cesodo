<div class="row">
    <div class="col-12 mb-4">
        <div class="alert alert-info">
            <i class="bi bi-info-circle-fill me-2"></i>
            <strong>¿Qué son los permisos?</strong><br>
            Los permisos controlan qué puede ver y hacer cada rol de usuario en el sistema.
            Si un rol no tiene permiso para un módulo, ese módulo no aparecerá en el menú para ese usuario.
        </div>
    </div>
</div>

<?php if($roles && $permisos): ?>
    <form action="<?php echo e(route('configuraciones.update-permissions')); ?>" method="POST">
        <?php echo csrf_field(); ?>

        <!-- Selector de Rol -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-person-badge me-2"></i>
                            Seleccionar Rol
                        </h5>
                    </div>
                    <div class="card-body">
                        <select name="role_id" id="roleSelect" class="form-select form-select-lg" onchange="loadRolePermissions(this.value)">
                            <option value="">-- Seleccione un rol --</option>
                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rol): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($rol->id); ?>" data-permissions='<?php echo json_encode($rol->permissions->pluck("name"), 15, 512) ?>'>
                                    <?php echo e($rol->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>

                        <div class="mt-3">
                            <small class="text-muted">
                                <i class="bi bi-lightbulb me-1"></i>
                                <strong>Tip:</strong> Cada rol representa un tipo de usuario (Admin, Usuario, Supervisor, etc.)
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="bi bi-shield-check me-2"></i>
                            Acciones Rápidas
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="btn-group w-100" role="group">
                            <button type="button" class="btn btn-outline-success" onclick="selectAllPermissions()">
                                <i class="bi bi-check-all me-2"></i>
                                Seleccionar Todos
                            </button>
                            <button type="button" class="btn btn-outline-danger" onclick="deselectAllPermissions()">
                                <i class="bi bi-x-circle me-2"></i>
                                Desmarcar Todos
                            </button>
                        </div>

                        <div class="mt-3">
                            <div class="alert alert-warning mb-0">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                <strong>Importante:</strong> Los cambios se aplicarán inmediatamente al guardar.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Permisos por Módulo -->
        <div id="permissionsContainer" style="display: none;">
            <div class="row">
                <?php $__currentLoopData = $permisos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $modulo => $permisosModulo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100 border-0 shadow-sm hover-card">
                            <div class="card-header text-white position-relative" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); padding: 1rem;">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <?php
                                            $iconos = [
                                                'usuarios' => 'people-fill',
                                                'productos' => 'box-seam-fill',
                                                'consumos' => 'clipboard-data-fill',
                                                'menus' => 'calendar3',
                                                'trabajadores' => 'person-badge-fill',
                                                'proveedores' => 'truck',
                                                'configuraciones' => 'gear-fill',
                                                'reportes' => 'graph-up-arrow',
                                                'categorias' => 'tags-fill',
                                                'inventario' => 'box-fill',
                                                'personas' => 'person-fill',
                                                'certificados' => 'file-medical-fill',
                                                'recetas' => 'journal-text',
                                                'contratos' => 'file-text-fill',
                                                'roles' => 'shield-lock-fill',
                                                'pedidos' => 'cart-fill',
                                                'clientes' => 'person-circle',
                                                'ventas' => 'cash-coin',
                                                'compras' => 'bag-fill',
                                            ];
                                            $icono = $iconos[$modulo] ?? 'circle-fill';

                                            // Nombres en español
                                            $nombresModulos = [
                                                'usuarios' => 'Usuarios',
                                                'productos' => 'Productos',
                                                'consumos' => 'Consumos',
                                                'menus' => 'Menús',
                                                'trabajadores' => 'Trabajadores',
                                                'proveedores' => 'Proveedores',
                                                'configuraciones' => 'Configuraciones',
                                                'reportes' => 'Reportes',
                                                'categorias' => 'Categorías',
                                                'inventario' => 'Inventario',
                                                'personas' => 'Personas',
                                                'certificados' => 'Certificados Médicos',
                                                'recetas' => 'Recetas',
                                                'contratos' => 'Contratos',
                                                'roles' => 'Roles y Permisos',
                                                'pedidos' => 'Pedidos',
                                                'clientes' => 'Clientes',
                                                'ventas' => 'Ventas',
                                                'compras' => 'Compras',
                                            ];
                                            $nombreModulo = $nombresModulos[$modulo] ?? ucfirst($modulo);
                                        ?>
                                        <i class="bi bi-<?php echo e($icono); ?> me-2" style="font-size: 1.5rem;"></i>
                                        <h6 class="mb-0 fw-bold"><?php echo e($nombreModulo); ?></h6>
                                    </div>
                                    <span class="badge bg-white text-danger"><?php echo e(count($permisosModulo)); ?></span>
                                </div>
                            </div>
                            <div class="card-body" style="padding: 1.25rem;">
                                <!-- Select all para este módulo -->
                                <div class="form-check mb-3 pb-3 border-bottom d-flex align-items-center" style="background: #f8f9fa; padding: 0.875rem 1rem; border-radius: 6px; margin: -0.25rem -0.25rem 1rem -0.25rem; cursor: pointer; min-height: 55px;">
                                    <input class="form-check-input module-select-all"
                                           type="checkbox"
                                           id="module_<?php echo e($modulo); ?>"
                                           data-module="<?php echo e($modulo); ?>"
                                           onchange="toggleModulePermissions('<?php echo e($modulo); ?>', this.checked)"
                                           style="cursor: pointer; width: 1.25em; height: 1.25em; margin: 0; flex-shrink: 0;">
                                    <label class="form-check-label fw-bold d-flex align-items-center ms-3" for="module_<?php echo e($modulo); ?>" style="cursor: pointer; user-select: none; margin: 0;">
                                        <i class="bi bi-check-all me-2 text-success" style="font-size: 1.2rem;"></i>
                                        <span>Todos los permisos del módulo</span>
                                    </label>
                                </div>

                                <!-- Permisos individuales -->
                                <div class="permissions-list">
                                    <?php $__currentLoopData = $permisosModulo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permiso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="form-check mb-2 permission-item d-flex align-items-center" style="padding: 0.75rem 1rem; border-radius: 6px; transition: all 0.2s; cursor: pointer; min-height: 50px;">
                                            <input class="form-check-input permission-checkbox module-permission-<?php echo e($modulo); ?>"
                                                   type="checkbox"
                                                   name="permissions[]"
                                                   value="<?php echo e($permiso->name); ?>"
                                                   id="permission_<?php echo e($permiso->id); ?>"
                                                   onchange="updateModuleSelectAll('<?php echo e($modulo); ?>')"
                                                   style="cursor: pointer; width: 1.25em; height: 1.25em; margin: 0; flex-shrink: 0;">
                                            <label class="form-check-label d-flex align-items-center ms-3" for="permission_<?php echo e($permiso->id); ?>" style="cursor: pointer; width: 100%; user-select: none; margin: 0;">
                                                <?php
                                                    // Extraer la acción del permiso (ver, crear, editar, eliminar)
                                                    $partes = explode('-', $permiso->name);
                                                    $accion = $partes[0] ?? '';

                                                    // Traducir acciones al español
                                                    $accionesEspanol = [
                                                        'ver' => 'Ver',
                                                        'crear' => 'Crear',
                                                        'editar' => 'Editar',
                                                        'eliminar' => 'Eliminar',
                                                        'gestionar' => 'Gestionar',
                                                        'exportar' => 'Exportar',
                                                        'importar' => 'Importar',
                                                    ];

                                                    $nombrePermiso = $accionesEspanol[$accion] ?? ucfirst($accion);

                                                    // Iconos según la acción
                                                    $iconosAccion = [
                                                        'ver' => 'eye-fill',
                                                        'crear' => 'plus-circle-fill',
                                                        'editar' => 'pencil-square',
                                                        'eliminar' => 'trash-fill',
                                                        'gestionar' => 'gear-fill',
                                                        'exportar' => 'download',
                                                        'importar' => 'upload',
                                                    ];

                                                    $iconoPermiso = $iconosAccion[$accion] ?? 'check-circle-fill';

                                                    // Colores según la acción
                                                    $coloresAccion = [
                                                        'ver' => '#0d6efd',
                                                        'crear' => '#198754',
                                                        'editar' => '#ffc107',
                                                        'eliminar' => '#dc3545',
                                                        'gestionar' => '#6610f2',
                                                        'exportar' => '#0dcaf0',
                                                        'importar' => '#fd7e14',
                                                    ];

                                                    $colorAccion = $coloresAccion[$accion] ?? '#6c757d';
                                                ?>
                                                <i class="bi bi-<?php echo e($iconoPermiso); ?> me-2" style="color: <?php echo e($colorAccion); ?>; font-size: 1.1rem;"></i>
                                                <span class="fw-semibold" style="color: #2d3748;"><?php echo e($nombrePermiso); ?></span>
                                            </label>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <!-- Botón Guardar -->
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="bi bi-info-circle text-info me-2"></i>
                                    <span class="text-muted">Los cambios se aplicarán inmediatamente</span>
                                </div>
                                <button type="submit" class="btn btn-danger btn-lg">
                                    <i class="bi bi-save me-2"></i>
                                    Guardar Permisos
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <style>
    .hover-card {
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1.5rem rgba(220, 53, 69, 0.3) !important;
        border-color: rgba(220, 53, 69, 0.2);
    }

    .form-check-input {
        cursor: pointer;
        border-width: 2px;
        transition: all 0.2s;
    }

    .form-check-input:checked {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .form-check-input:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
    }

    .form-check-input:hover {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.15rem rgba(220, 53, 69, 0.15);
    }

    .module-select-all:checked {
        background-color: #198754;
        border-color: #198754;
    }

    .module-select-all:focus {
        border-color: #198754;
        box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25);
    }

    .module-select-all:hover {
        border-color: #198754;
        box-shadow: 0 0 0 0.15rem rgba(25, 135, 84, 0.15);
    }

    .permissions-list {
        max-height: 350px;
        overflow-y: auto;
        padding-right: 0.5rem;
    }

    .permissions-list::-webkit-scrollbar {
        width: 6px;
    }

    .permissions-list::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }

    .permissions-list::-webkit-scrollbar-thumb {
        background: #dc3545;
        border-radius: 3px;
    }

    .permissions-list::-webkit-scrollbar-thumb:hover {
        background: #c82333;
    }

    .permission-item {
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
    }

    .permission-item:hover {
        background-color: #f8f9fa !important;
        transform: translateX(3px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .permission-item .form-check-input:checked ~ label {
        color: #198754;
        font-weight: 600;
    }

    .permission-item .form-check-input:checked ~ label .bi {
        transform: scale(1.1);
        transition: transform 0.2s;
    }

    .card-header h6 {
        font-size: 1.1rem;
        letter-spacing: 0.3px;
    }

    /* Mejorar visibilidad del label completo como clickable */
    .form-check-label {
        cursor: pointer;
        user-select: none;
    }

    /* Efecto de selección activa */
    .permission-item.active {
        background-color: #e7f4e7 !important;
        border-left: 4px solid #198754 !important;
        padding-left: calc(1rem - 4px) !important;
    }

    /* Estado indeterminado para checkbox "Todos" */
    .form-check-input:indeterminate {
        background-color: #ffc107;
        border-color: #ffc107;
    }

    /* Ajustar el input del checkbox para que no tenga margen flotante */
    .form-check-input {
        float: none !important;
        margin-left: 0 !important;
    }
    </style>

    <script>
    // Cargar permisos del rol seleccionado
    function loadRolePermissions(roleId) {
        const container = document.getElementById('permissionsContainer');
        const select = document.getElementById('roleSelect');

        if (!roleId) {
            container.style.display = 'none';
            return;
        }

        // Obtener permisos del rol seleccionado
        const option = select.options[select.selectedIndex];
        const rolePermissions = JSON.parse(option.getAttribute('data-permissions') || '[]');

        // Desmarcar todos
        document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
            checkbox.checked = false;
            // Remover clase active del contenedor padre
            checkbox.closest('.permission-item')?.classList.remove('active');
        });

        // Marcar los permisos del rol
        rolePermissions.forEach(permission => {
            const checkbox = document.querySelector(`input[value="${permission}"]`);
            if (checkbox) {
                checkbox.checked = true;
                // Añadir clase active al contenedor padre
                checkbox.closest('.permission-item')?.classList.add('active');
            }
        });

        // Actualizar checkboxes "Seleccionar todos" de cada módulo
        document.querySelectorAll('.module-select-all').forEach(moduleCheckbox => {
            const module = moduleCheckbox.getAttribute('data-module');
            updateModuleSelectAll(module);
        });

        container.style.display = 'block';
    }

    // Seleccionar todos los permisos
    function selectAllPermissions() {
        document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
            checkbox.checked = true;
            checkbox.closest('.permission-item')?.classList.add('active');
        });
        document.querySelectorAll('.module-select-all').forEach(checkbox => {
            checkbox.checked = true;
        });
    }

    // Desmarcar todos los permisos
    function deselectAllPermissions() {
        document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
            checkbox.checked = false;
            checkbox.closest('.permission-item')?.classList.remove('active');
        });
        document.querySelectorAll('.module-select-all').forEach(checkbox => {
            checkbox.checked = false;
        });
    }

    // Toggle permisos de un módulo completo
    function toggleModulePermissions(module, checked) {
        document.querySelectorAll(`.module-permission-${module}`).forEach(checkbox => {
            checkbox.checked = checked;
            if (checked) {
                checkbox.closest('.permission-item')?.classList.add('active');
            } else {
                checkbox.closest('.permission-item')?.classList.remove('active');
            }
        });
    }

    // Actualizar checkbox "Seleccionar todos" del módulo
    function updateModuleSelectAll(module) {
        const moduleCheckboxes = document.querySelectorAll(`.module-permission-${module}`);
        const moduleSelectAll = document.querySelector(`#module_${module}`);

        if (!moduleSelectAll) return;

        const allChecked = Array.from(moduleCheckboxes).every(cb => cb.checked);
        const someChecked = Array.from(moduleCheckboxes).some(cb => cb.checked);

        moduleSelectAll.checked = allChecked;
        moduleSelectAll.indeterminate = someChecked && !allChecked;
    }

    // Añadir event listeners para feedback visual al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
        // Listener para todos los checkboxes de permisos
        document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    this.closest('.permission-item')?.classList.add('active');
                } else {
                    this.closest('.permission-item')?.classList.remove('active');
                }
            });
        });

        // Hacer clickable toda el área del permission-item
        document.querySelectorAll('.permission-item').forEach(item => {
            item.addEventListener('click', function(e) {
                // Evitar doble click si se clickea directamente el checkbox o label
                if (e.target.tagName === 'INPUT' || e.target.tagName === 'LABEL' || e.target.closest('label')) {
                    return;
                }
                const checkbox = this.querySelector('.form-check-input');
                if (checkbox) {
                    checkbox.checked = !checkbox.checked;
                    checkbox.dispatchEvent(new Event('change'));
                }
            });
        });
    });
    </script>
<?php else: ?>
    <div class="alert alert-warning">
        <i class="bi bi-exclamation-triangle me-2"></i>
        No se pudieron cargar los roles y permisos del sistema.
    </div>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\cesodo4\resources\views/configuraciones/tabs/permisos.blade.php ENDPATH**/ ?>