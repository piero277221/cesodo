@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Encabezado -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-primary">
                    <i class="fas fa-plus-circle me-2"></i>Crear Nuevo Rol
                </h2>
                <a href="{{ route('role-management.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Volver
                </a>
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

            <!-- Formulario de creación -->
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user-plus me-2"></i>Información del Rol
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('role-management.store') }}" method="POST" id="roleForm">
                        @csrf
                        
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
                                       value="{{ old('name') }}" 
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
                                          placeholder="Descripción opcional del rol y sus responsabilidades">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Asignación de permisos -->
                        <div class="card mt-4">
                            <div class="card-header bg-info text-white">
                                <h6 class="card-title mb-0">
                                    <i class="fas fa-key me-2"></i>Asignar Permisos
                                </h6>
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
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="clearAllPermissions()">
                                            <i class="fas fa-times me-1"></i>Limpiar Selección
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
                                                        <span class="badge bg-primary ms-auto me-2">{{ $modulePermissions->count() }}</span>
                                                    </div>
                                                </button>
                                            </h2>
                                            <div id="collapse{{ Str::slug($module) }}" 
                                                 class="accordion-collapse collapse" 
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
                                                                       {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
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
                            <a href="{{ route('role-management.index') }}" class="btn btn-light">
                                <i class="fas fa-times me-1"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Crear Rol
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
}

// Limpiar selección de permisos
function clearAllPermissions() {
    const checkboxes = document.querySelectorAll('.permission-checkbox');
    checkboxes.forEach(checkbox => checkbox.checked = false);
}

// Alternar permisos de un módulo específico
function toggleModulePermissions(module) {
    const accordionBody = document.querySelector('#collapse' + module + ' .accordion-body');
    const checkboxes = accordionBody.querySelectorAll('.permission-checkbox');
    
    // Verificar si todos están marcados
    const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);
    
    // Si todos están marcados, desmarcar todos; si no, marcar todos
    checkboxes.forEach(checkbox => checkbox.checked = !allChecked);
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

// Auto-expandir el primer acordeón si hay pocos módulos
document.addEventListener('DOMContentLoaded', function() {
    const accordionItems = document.querySelectorAll('.accordion-item');
    if (accordionItems.length <= 3) {
        accordionItems.forEach(item => {
            const collapseElement = item.querySelector('.accordion-collapse');
            const button = item.querySelector('.accordion-button');
            if (collapseElement && button) {
                collapseElement.classList.add('show');
                button.classList.remove('collapsed');
                button.setAttribute('aria-expanded', 'true');
            }
        });
    }
});
</script>
@endpush