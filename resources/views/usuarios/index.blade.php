@extends('layouts.app')

@section('title', 'Gestión de Usuarios')

@section('content')
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
                            <a href="{{ route('usuarios.create') }}" class="btn btn-primary btn-lg">
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
                            <div class="h4 mb-0 text-success">{{ $usuarios->where('estado', 'activo')->count() }}</div>
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
                            <div class="h4 mb-0 text-danger">{{ $usuarios->where('estado', 'inactivo')->count() }}</div>
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
                            <div class="h4 mb-0 text-info">{{ $usuarios->filter(function($user) { return $user->hasRole('admin'); })->count() }}</div>
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
                            <div class="h4 mb-0 text-warning">{{ $usuarios->count() }}</div>
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
            <form method="GET" action="{{ route('usuarios.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Buscar usuario</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" name="search" class="form-control"
                               placeholder="Nombre, email o DNI..."
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Estado</label>
                    <select name="estado" class="form-select">
                        <option value="">Todos</option>
                        <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                        <option value="inactivo" {{ request('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Rol</label>
                    <select name="rol" class="form-select">
                        <option value="">Todos los roles</option>
                        @foreach(\Spatie\Permission\Models\Role::all() as $rol)
                            <option value="{{ $rol->name }}" {{ request('rol') == $rol->name ? 'selected' : '' }}>
                                {{ ucfirst($rol->name) }}
                                    </option>
                                @endforeach
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
                        Lista de Usuarios ({{ $usuarios->total() }})
                    </h6>
                </div>
                <div class="card-body">
                    @if($usuarios->count() > 0)
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
                                    @foreach($usuarios as $usuario)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3"
                                                         style="width: 40px; height: 40px;">
                                                        <i class="fas fa-user text-white"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold">{{ $usuario->name }}</div>
                                                        <small class="text-muted">{{ $usuario->email }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if($usuario->persona)
                                                    <div>
                                                        <small class="text-muted">DNI:</small> {{ $usuario->persona->numero_documento }}<br>
                                                        <small class="text-muted">Teléfono:</small> {{ $usuario->persona->celular ?? 'N/A' }}
                                                    </div>
                                                @else
                                                    <span class="text-muted">No asignado</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($usuario->trabajador)
                                                    <div>
                                                        <div class="fw-semibold">{{ $usuario->trabajador->codigo }}</div>
                                                        <small class="text-muted">{{ $usuario->trabajador->cargo ?? 'Sin cargo' }}</small>
                                                    </div>
                                                @else
                                                    <span class="text-muted">No es empleado</span>
                                                @endif
                                            </td>
                                            <td>
                                                @forelse($usuario->roles as $rol)
                                                    <span class="badge bg-info me-1">{{ $rol->name }}</span>
                                                @empty
                                                    <span class="text-muted">Sin roles</span>
                                                @endforelse
                                            </td>
                                            <td>
                                                @if($usuario->estado == 'activo')
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check me-1"></i>Activo
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">
                                                        <i class="fas fa-times me-1"></i>Inactivo
                                                    </span>
                                                @endif

                                                @if($usuario->cambiar_password)
                                                    <br><small class="text-warning">
                                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                                        Debe cambiar contraseña
                                                    </small>
                                                @endif
                                            </td>
                                            <td>
                                                @if($usuario->ultimo_acceso)
                                                    {{ $usuario->ultimo_acceso->format('d/m/Y H:i') }}
                                                @else
                                                    <span class="text-muted">Nunca</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('usuarios.show', $usuario) }}"
                                                       class="btn btn-sm btn-outline-info"
                                                       title="Ver detalles">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('usuarios.edit', $usuario) }}"
                                                       class="btn btn-sm btn-outline-primary"
                                                       title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button"
                                                            class="btn btn-sm btn-outline-warning"
                                                            title="Resetear contraseña"
                                                            onclick="resetPassword({{ $usuario->id }})">
                                                        <i class="fas fa-key"></i>
                                                    </button>
                                                    <button type="button"
                                                            class="btn btn-sm btn-outline-danger"
                                                            title="Eliminar"
                                                            onclick="confirmarEliminacion({{ $usuario->id }})">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="text-muted">
                                Mostrando {{ $usuarios->firstItem() }} a {{ $usuarios->lastItem() }}
                                de {{ $usuarios->total() }} resultados
                            </div>
                            {{ $usuarios->withQueryString()->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No hay usuarios registrados</h5>
                            <p class="text-muted">Comienza creando el primer usuario del sistema</p>
                            <a href="{{ route('usuarios.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>
                                Crear Primer Usuario
                            </a>
                        </div>
                    @endif
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
                    @csrf
                    @method('PUT')
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
                    @csrf
                    @method('DELETE')
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
    form.action = `{{ url('usuarios') }}/${usuarioId}`;

    console.log('URL de eliminación:', form.action);

    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}
</script>
@endsection
