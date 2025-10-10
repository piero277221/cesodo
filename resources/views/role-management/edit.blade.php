@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Encabezado -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-primary">
                    <i class="fas fa-edit me-2"></i>Editar Rol
                </h2>
                <div class="btn-group">
                    <a href="{{ route('role-management.show', $role) }}" class="btn btn-info">
                        <i class="fas fa-eye me-1"></i>Ver
                    </a>
                    <a href="{{ route('role-management.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Volver
                    </a>
                </div>
            </div>

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-1"></i>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Información del rol -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h5 class="mb-1">{{ $role->name }}</h5>
                            <p class="text-muted mb-0">
                                <i class="fas fa-calendar me-1"></i>
                                Creado: {{ $role->created_at->format('d/m/Y H:i') }}
                                @if($role->updated_at != $role->created_at)
                                | <i class="fas fa-edit me-1"></i>Modificado: {{ $role->updated_at->format('d/m/Y H:i') }}
                                @endif
                            </p>
                        </div>
                        <div class="col-md-4 text-end">
                            <span class="badge bg-info">{{ $role->permissions->count() }} permisos</span>
                            <span class="badge bg-secondary">{{ $role->users->count() }} usuarios</span>
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
                    <form action="{{ route('role-management.update', $role) }}" method="POST" id="roleForm">
                        @csrf
                        @method('PUT')

                        <!-- Información básica del rol -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label fw-bold">
                                    <i class="fas fa-tag me-1"></i>Nombre del Rol *
                                </label>
                                <input type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       id="name"
                                       name="name"
                                       value="{{ old('name', $role->name) }}"
                                       placeholder="Ej: Administrador, Editor, Supervisor"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    El nombre debe ser único y descriptivo del rol
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="description" class="form-label fw-bold">
                                    <i class="fas fa-align-left me-1"></i>Descripción
                                </label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          id="description"
                                          name="description"
                                          rows="3"
                                          placeholder="Descripción opcional del rol y sus responsabilidades">{{ old('description', $role->description ?? '') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
                                        <span id="selectedCount">{{ $role->permissions->count() }}</span> seleccionados
                                    </span>
                                </div>
                            </div>
                            <div class="card-body">
                                @if($permissions->isEmpty())
                                    <div class="text-center py-4">
                                        <i class="fas fa-lock fa-3x text-muted mb-3"></i>
                                        <h6 class="text-muted">No hay permisos disponibles</h6>
                                        <p class="text-muted">Los permisos se crearán automáticamente al usar el sistema</p>
                                    </div>
                                @else
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
                                        @foreach($permissions as $module => $modulePermissions)
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="heading{{ Str::slug($module) }}">
                                                <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapse{{ Str::slug($module) }}"
                                                        aria-expanded="false"
                                                        aria-controls="collapse{{ Str::slug($module) }}">
                                                    <div class="d-flex align-items-center w-100">
                                                        <i class="fas fa-cube me-2"></i>
                                                        <span class="fw-bold text-capitalize">{{ $module }}</span>
                                                        <span class="badge bg-primary ms-auto me-2">
                                                            <span id="module-{{ Str::slug($module) }}-count">
                                                                {{ $modulePermissions->intersect($role->permissions)->count() }}
                                                            </span>/{{ $modulePermissions->count() }}
                                                        </span>
                                                    </div>
                                                </button>
                                            </h2>
                                            <div id="collapse{{ Str::slug($module) }}"
                                                 class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                                                 aria-labelledby="heading{{ Str::slug($module) }}"
                                                 data-bs-parent="#permissionsAccordion">
                                                <div class="accordion-body">
                                                    <div class="row">
                                                        @foreach($modulePermissions as $permission)
                                                        <div class="col-md-6 col-lg-4 mb-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input permission-checkbox"
                                                                       type="checkbox"
                                                                       value="{{ $permission->id }}"
                                                                       id="permission_{{ $permission->id }}"
                                                                       name="permissions[]"
                                                                       data-module="{{ Str::slug($module) }}"
                                                                       data-original="{{ $role->hasPermissionTo($permission->name) ? 'true' : 'false' }}"
                                                                       {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                                    {{ $permission->name }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    </div>

                                                    <!-- Botón para seleccionar/deseleccionar todo el módulo -->
                                                    <div class="mt-3">
                                                        <button type="button" class="btn btn-sm btn-outline-info"
                                                                onclick="toggleModulePermissions('{{ Str::slug($module) }}')">
                                                            <i class="fas fa-toggle-on me-1"></i>Alternar Módulo
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="d-flex justify-content-between mt-4">
                            <div>
                                <a href="{{ route('role-management.index') }}" class="btn btn-light">
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
@endsection

@push('scripts')
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
@endpush
