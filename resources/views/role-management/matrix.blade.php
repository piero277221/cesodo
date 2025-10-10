@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Encabezado -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-primary">
                    <i class="fas fa-table me-2"></i>Matriz de Permisos
                </h2>
                <div class="btn-group">
                    <a href="{{ route('role-management.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Volver
                    </a>
                    <a href="{{ route('role-management.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>Nuevo Rol
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-1"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

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

            <!-- Descripción -->
            <div class="alert alert-info" role="alert">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Matriz Visual de Permisos:</strong> 
                Gestiona todos los permisos de roles de forma visual. Los cambios se aplicarán inmediatamente.
            </div>

            @if($roles->isEmpty() || $permissions->isEmpty())
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-exclamation-triangle fa-4x text-warning mb-3"></i>
                        <h5 class="text-muted">Datos insuficientes para mostrar la matriz</h5>
                        <p class="text-muted">
                            @if($roles->isEmpty())
                                No hay roles creados en el sistema.
                            @endif
                            @if($permissions->isEmpty())
                                No hay permisos disponibles en el sistema.
                            @endif
                        </p>
                        <div class="mt-3">
                            @if($roles->isEmpty())
                                <a href="{{ route('role-management.create') }}" class="btn btn-primary me-2">
                                    <i class="fas fa-plus me-1"></i>Crear Primer Rol
                                </a>
                            @endif
                            <a href="{{ route('role-management.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Volver al Listado
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <!-- Formulario de matriz de permisos -->
                <form action="{{ route('role-management.update-matrix') }}" method="POST" id="matrixForm">
                    @csrf
                    
                    <!-- Controles superiores -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h6 class="mb-0">Controles Rápidos:</h6>
                                    <div class="btn-group btn-group-sm mt-2" role="group">
                                        <button type="button" class="btn btn-outline-success" onclick="selectAll()">
                                            <i class="fas fa-check-double me-1"></i>Seleccionar Todo
                                        </button>
                                        <button type="button" class="btn btn-outline-danger" onclick="clearAll()">
                                            <i class="fas fa-times me-1"></i>Limpiar Todo
                                        </button>
                                        <button type="button" class="btn btn-outline-info" onclick="toggleView()">
                                            <i class="fas fa-eye me-1"></i>Cambiar Vista
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-4 text-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i>Guardar Cambios
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Matriz por módulos -->
                    @foreach($permissions as $module => $modulePermissions)
                    <div class="card mb-4 module-section">
                        <div class="card-header bg-primary text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">
                                    <i class="fas fa-cube me-2"></i>
                                    Módulo: <span class="text-capitalize">{{ $module }}</span>
                                    <span class="badge bg-light text-primary ms-2">{{ $modulePermissions->count() }} permisos</span>
                                </h6>
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-light btn-sm" 
                                            onclick="toggleModuleAll('{{ $module }}')">
                                        <i class="fas fa-toggle-on me-1"></i>Alternar Módulo
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0 matrix-table">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="min-width: 250px;">Permiso</th>
                                            @foreach($roles as $role)
                                            <th class="text-center" style="min-width: 120px;">
                                                <div class="d-flex flex-column align-items-center">
                                                    <span class="fw-bold">{{ $role->name }}</span>
                                                    <small class="text-muted">
                                                        {{ $role->permissions->count() }} permisos
                                                    </small>
                                                </div>
                                            </th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($modulePermissions as $permission)
                                        <tr>
                                            <td class="fw-bold">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-key text-muted me-2"></i>
                                                    {{ $permission->name }}
                                                </div>
                                            </td>
                                            @foreach($roles as $role)
                                            <td class="text-center">
                                                <div class="form-check d-flex justify-content-center">
                                                    <input class="form-check-input permission-matrix" 
                                                           type="checkbox" 
                                                           name="permissions[{{ $role->id }}][{{ $permission->id }}]"
                                                           value="1"
                                                           data-role="{{ $role->id }}"
                                                           data-permission="{{ $permission->id }}"
                                                           data-module="{{ $module }}"
                                                           {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                                </div>
                                            </td>
                                            @endforeach
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <!-- Botón de guardar flotante -->
                    <div class="sticky-bottom text-center mb-3">
                        <button type="submit" class="btn btn-primary btn-lg shadow">
                            <i class="fas fa-save me-1"></i>Guardar Todos los Cambios
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Variables para controlar el estado
let compactView = false;

// Seleccionar todos los permisos
function selectAll() {
    document.querySelectorAll('.permission-matrix').forEach(checkbox => {
        checkbox.checked = true;
    });
    updateCounters();
}

// Limpiar todos los permisos
function clearAll() {
    if (confirm('¿Estás seguro de que deseas limpiar todos los permisos? Esta acción afectará a todos los roles.')) {
        document.querySelectorAll('.permission-matrix').forEach(checkbox => {
            checkbox.checked = false;
        });
        updateCounters();
    }
}

// Alternar todos los permisos de un módulo
function toggleModuleAll(module) {
    const moduleCheckboxes = document.querySelectorAll(`[data-module="${module}"]`);
    const allChecked = Array.from(moduleCheckboxes).every(cb => cb.checked);
    
    moduleCheckboxes.forEach(checkbox => {
        checkbox.checked = !allChecked;
    });
    updateCounters();
}

// Cambiar vista (compacta/expandida)
function toggleView() {
    compactView = !compactView;
    const tables = document.querySelectorAll('.matrix-table');
    
    tables.forEach(table => {
        if (compactView) {
            table.classList.add('table-sm');
        } else {
            table.classList.remove('table-sm');
        }
    });
}

// Actualizar contadores de permisos
function updateCounters() {
    // Actualizar contadores por rol en la cabecera
    @foreach($roles as $role)
    const role{{ $role->id }}Count = document.querySelectorAll(`[data-role="{{ $role->id }}"]:checked`).length;
    // Aquí podrías actualizar un elemento específico si lo agregas al HTML
    @endforeach
}

// Confirmar cambios antes de enviar
document.getElementById('matrixForm').addEventListener('submit', function(e) {
    const changedCheckboxes = document.querySelectorAll('.permission-matrix');
    const totalChecked = Array.from(changedCheckboxes).filter(cb => cb.checked).length;
    
    if (totalChecked === 0) {
        if (!confirm('No hay permisos seleccionados. ¿Deseas continuar? Esto removerá todos los permisos de todos los roles.')) {
            e.preventDefault();
            return false;
        }
    }
    
    // Mostrar indicador de carga
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Guardando...';
    submitBtn.disabled = true;
});

// Añadir eventos para actualizar contadores en tiempo real
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.permission-matrix').forEach(checkbox => {
        checkbox.addEventListener('change', updateCounters);
    });
    
    // Actualizar contadores iniciales
    updateCounters();
});

// Atajos de teclado
document.addEventListener('keydown', function(e) {
    // Ctrl + S para guardar
    if (e.ctrlKey && e.key === 's') {
        e.preventDefault();
        document.getElementById('matrixForm').submit();
    }
    
    // Ctrl + A para seleccionar todo
    if (e.ctrlKey && e.key === 'a' && e.target.tagName !== 'INPUT') {
        e.preventDefault();
        selectAll();
    }
});
</script>

<style>
.matrix-table {
    font-size: 0.9rem;
}

.matrix-table th {
    position: sticky;
    top: 0;
    background-color: #f8f9fa;
    z-index: 10;
}

.matrix-table td {
    vertical-align: middle;
}

.form-check-input {
    transform: scale(1.2);
}

.sticky-bottom {
    position: sticky;
    bottom: 20px;
    z-index: 1000;
}

@media (max-width: 768px) {
    .matrix-table {
        font-size: 0.8rem;
    }
    
    .matrix-table th,
    .matrix-table td {
        padding: 0.5rem 0.25rem;
    }
}
</style>
@endpush