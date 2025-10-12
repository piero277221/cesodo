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

@if($roles && $permisos)
    <form action="{{ route('configuraciones.update-permissions') }}" method="POST">
        @csrf

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
                            @foreach($roles as $rol)
                                <option value="{{ $rol->id }}" data-permissions='@json($rol->permissions->pluck("name"))'>
                                    {{ $rol->name }}
                                </option>
                            @endforeach
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
                @foreach($permisos as $modulo => $permisosModulo)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100 border-0 shadow-sm hover-card">
                            <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);">
                                <h6 class="mb-0">
                                    <i class="bi bi-{{ 
                                        $modulo === 'usuarios' ? 'people' :
                                        ($modulo === 'productos' ? 'box-seam' :
                                        ($modulo === 'consumos' ? 'clipboard-data' :
                                        ($modulo === 'menus' ? 'calendar3' :
                                        ($modulo === 'trabajadores' ? 'person-badge' :
                                        ($modulo === 'proveedores' ? 'truck' :
                                        ($modulo === 'configuraciones' ? 'gear' :
                                        ($modulo === 'reportes' ? 'graph-up' :
                                        ($modulo === 'categorias' ? 'tags' :
                                        ($modulo === 'inventario' ? 'box' :
                                        ($modulo === 'personas' ? 'person' :
                                        ($modulo === 'certificados' ? 'file-medical' :
                                        ($modulo === 'recetas' ? 'journal-text' :
                                        ($modulo === 'contratos' ? 'file-text' :
                                        'circle')))))))))))))) 
                                    }} me-2"></i>
                                    {{ ucfirst($modulo) }}
                                </h6>
                            </div>
                            <div class="card-body">
                                <!-- Select all para este módulo -->
                                <div class="form-check mb-3 pb-2 border-bottom">
                                    <input class="form-check-input module-select-all" 
                                           type="checkbox" 
                                           id="module_{{ $modulo }}"
                                           data-module="{{ $modulo }}"
                                           onchange="toggleModulePermissions('{{ $modulo }}', this.checked)">
                                    <label class="form-check-label fw-bold" for="module_{{ $modulo }}">
                                        <i class="bi bi-check-all me-1"></i>
                                        Todos los permisos
                                    </label>
                                </div>

                                <!-- Permisos individuales -->
                                <div class="permissions-list">
                                    @foreach($permisosModulo as $permiso)
                                        <div class="form-check mb-2">
                                            <input class="form-check-input permission-checkbox module-permission-{{ $modulo }}" 
                                                   type="checkbox" 
                                                   name="permissions[]" 
                                                   value="{{ $permiso->name }}" 
                                                   id="permission_{{ $permiso->id }}"
                                                   onchange="updateModuleSelectAll('{{ $modulo }}')">
                                            <label class="form-check-label" for="permission_{{ $permiso->id }}">
                                                <i class="bi bi-{{ 
                                                    str_contains($permiso->name, 'ver') ? 'eye' :
                                                    (str_contains($permiso->name, 'crear') ? 'plus-circle' :
                                                    (str_contains($permiso->name, 'editar') ? 'pencil' :
                                                    (str_contains($permiso->name, 'eliminar') ? 'trash' : 'check')))
                                                }} me-1"></i>
                                                {{ ucfirst(str_replace('-', ' ', explode('-', $permiso->name)[0])) }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
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
    }

    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.2) !important;
    }

    .form-check-input:checked {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .permissions-list {
        max-height: 300px;
        overflow-y: auto;
    }

    .permissions-list::-webkit-scrollbar {
        width: 6px;
    }

    .permissions-list::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .permissions-list::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 3px;
    }

    .permissions-list::-webkit-scrollbar-thumb:hover {
        background: #555;
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
        });
        
        // Marcar los permisos del rol
        rolePermissions.forEach(permission => {
            const checkbox = document.querySelector(`input[value="${permission}"]`);
            if (checkbox) {
                checkbox.checked = true;
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
        });
        document.querySelectorAll('.module-select-all').forEach(checkbox => {
            checkbox.checked = true;
        });
    }

    // Desmarcar todos los permisos
    function deselectAllPermissions() {
        document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
            checkbox.checked = false;
        });
        document.querySelectorAll('.module-select-all').forEach(checkbox => {
            checkbox.checked = false;
        });
    }

    // Toggle permisos de un módulo completo
    function toggleModulePermissions(module, checked) {
        document.querySelectorAll(`.module-permission-${module}`).forEach(checkbox => {
            checkbox.checked = checked;
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
    </script>
@else
    <div class="alert alert-warning">
        <i class="bi bi-exclamation-triangle me-2"></i>
        No se pudieron cargar los roles y permisos del sistema.
    </div>
@endif
