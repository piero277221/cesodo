@extends('layouts.app')

@section('title', 'Editar Usuario')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-user-edit text-primary me-2"></i>
                        Editar Usuario: {{ $usuario->name }}
                    </h1>
                    <p class="text-muted mb-0">Modifica la información del usuario del sistema</p>
                </div>
                <div>
                    <a href="{{ route('usuarios.show', $usuario) }}" class="btn btn-info me-2">
                        <i class="fas fa-eye me-2"></i>
                        Ver Detalles
                    </a>
                    <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Volver
                    </a>
                </div>
            </div>

            <div class="row">
                <!-- Formulario principal -->
                <div class="col-lg-8">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-user-cog me-2"></i>
                                Información del Usuario
                            </h6>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('usuarios.update', $usuario) }}" id="userEditForm">
                                @csrf
                                @method('PUT')

                                <!-- Información básica -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Nombre Completo *</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                   id="name" name="name" value="{{ old('name', $usuario->name) }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email *</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                   id="email" name="email" value="{{ old('email', $usuario->email) }}" required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Relaciones -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="persona_id" class="form-label">Persona Asociada</label>
                                            <select name="persona_id" id="persona_id" class="form-select">
                                                <option value="">Ninguna</option>
                                                @foreach($personas as $persona)
                                                    <option value="{{ $persona->id }}"
                                                            {{ old('persona_id', $usuario->persona_id) == $persona->id ? 'selected' : '' }}>
                                                        {{ $persona->nombre_completo }} - {{ $persona->numero_documento }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="trabajador_id" class="form-label">Empleado Asociado</label>
                                            <select name="trabajador_id" id="trabajador_id" class="form-select">
                                                <option value="">Ninguno</option>
                                                @foreach($trabajadores as $trabajador)
                                                    <option value="{{ $trabajador->id }}"
                                                            {{ old('trabajador_id', $usuario->trabajador_id) == $trabajador->id ? 'selected' : '' }}>
                                                        {{ $trabajador->codigo }} - {{ $trabajador->persona ? $trabajador->persona->nombre_completo : $trabajador->nombre_completo }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Código empleado y estado -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="codigo_empleado" class="form-label">Código de Empleado</label>
                                            <input type="text" class="form-control" id="codigo_empleado"
                                                   name="codigo_empleado" value="{{ old('codigo_empleado', $usuario->codigo_empleado) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Estado de la Cuenta</label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="activo"
                                                       name="activo" value="1"
                                                       {{ old('activo', $usuario->activo ?? true) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="activo">
                                                    Cuenta Activa
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Configuración de contraseña -->
                                <div class="card border-warning mb-4">
                                    <div class="card-header bg-warning text-dark">
                                        <h6 class="mb-0">
                                            <i class="fas fa-key me-2"></i>
                                            Configuración de Contraseña
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input" type="checkbox" id="cambiar_password"
                                                           name="cambiar_password" value="1"
                                                           {{ old('cambiar_password', $usuario->cambiar_password) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="cambiar_password">
                                                        Forzar cambio de contraseña en el próximo acceso
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <button type="button" class="btn btn-warning btn-sm"
                                                        onclick="resetPassword({{ $usuario->id }})">
                                                    <i class="fas fa-redo me-2"></i>
                                                    Resetear Contraseña
                                                </button>
                                            </div>
                                        </div>

                                        @if($usuario->ultimo_acceso)
                                            <div class="text-muted small">
                                                <i class="fas fa-clock me-1"></i>
                                                Último acceso: {{ $usuario->ultimo_acceso->format('d/m/Y H:i:s') }}
                                            </div>
                                        @else
                                            <div class="text-warning small">
                                                <i class="fas fa-exclamation-triangle me-1"></i>
                                                El usuario nunca ha accedido al sistema
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Roles -->
                                <div class="card border-info mb-4">
                                    <div class="card-header bg-info text-white">
                                        <h6 class="mb-0">
                                            <i class="fas fa-user-shield me-2"></i>
                                            Roles y Permisos
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            @foreach($roles as $rol)
                                                <div class="col-md-4 mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                               id="rol_{{ $rol->id }}" name="roles[]" value="{{ $rol->name }}"
                                                               {{ $usuario->hasRole($rol->name) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="rol_{{ $rol->id }}">
                                                            <span class="badge bg-secondary me-2">{{ ucfirst($rol->name) }}</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        @if($usuario->roles->isNotEmpty())
                                            <div class="mt-3">
                                                <small class="text-muted">
                                                    <strong>Roles actuales:</strong>
                                                    @foreach($usuario->roles as $rol)
                                                        <span class="badge bg-primary me-1">{{ ucfirst($rol->name) }}</span>
                                                    @endforeach
                                                </small>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Observaciones -->
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="observaciones" class="form-label">Observaciones</label>
                                            <textarea class="form-control" id="observaciones" name="observaciones"
                                                      rows="3" placeholder="Notas adicionales sobre el usuario...">{{ old('observaciones', $usuario->observaciones) }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-2"></i>
                                            Guardar Cambios
                                        </button>
                                        <a href="{{ route('usuarios.show', $usuario) }}" class="btn btn-info ms-2">
                                            <i class="fas fa-eye me-2"></i>
                                            Ver Detalles
                                        </a>
                                        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary ms-2">
                                            <i class="fas fa-times me-2"></i>
                                            Cancelar
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Panel de información -->
                <div class="col-lg-4">
                    <!-- Información del usuario -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-info-circle me-2"></i>
                                Información del Usuario
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <strong>ID:</strong> {{ $usuario->id }}<br>
                                <strong>Creado:</strong> {{ $usuario->created_at->format('d/m/Y H:i') }}<br>
                                <strong>Actualizado:</strong> {{ $usuario->updated_at->format('d/m/Y H:i') }}
                            </div>

                            @if($usuario->persona)
                                <div class="mb-3">
                                    <h6 class="text-info">Persona Asociada</h6>
                                    <strong>Nombre:</strong> {{ $usuario->persona->nombre_completo }}<br>
                                    <strong>DNI:</strong> {{ $usuario->persona->numero_documento }}<br>
                                    <strong>Teléfono:</strong> {{ $usuario->persona->celular ?: 'No registrado' }}
                                </div>
                            @endif

                            @if($usuario->trabajador)
                                <div class="mb-3">
                                    <h6 class="text-success">Empleado Asociado</h6>
                                    <strong>Código:</strong> {{ $usuario->trabajador->codigo }}<br>
                                    <strong>Estado:</strong>
                                    @if($usuario->trabajador->activo)
                                        <span class="badge bg-success">Activo</span>
                                    @else
                                        <span class="badge bg-danger">Inactivo</span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Estadísticas de acceso -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-success">
                                <i class="fas fa-chart-line me-2"></i>
                                Estadísticas de Acceso
                            </h6>
                        </div>
                        <div class="card-body">
                            @if($usuario->ultimo_acceso)
                                <div class="mb-2">
                                    <strong>Último acceso:</strong><br>
                                    <span class="text-muted">{{ $usuario->ultimo_acceso->format('d/m/Y H:i:s') }}</span>
                                    <br>
                                    <small class="text-muted">
                                        ({{ $usuario->ultimo_acceso->diffForHumans() }})
                                    </small>
                                </div>
                            @else
                                <div class="text-center">
                                    <i class="fas fa-user-clock fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">El usuario nunca ha accedido al sistema</p>
                                </div>
                            @endif

                            @if($usuario->cambiar_password)
                                <div class="alert alert-warning small mb-0">
                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                    Debe cambiar la contraseña en el próximo acceso
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Acciones rápidas -->
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-warning">
                                <i class="fas fa-bolt me-2"></i>
                                Acciones Rápidas
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-warning btn-sm"
                                        onclick="resetPassword({{ $usuario->id }})">
                                    <i class="fas fa-key me-2"></i>
                                    Resetear Contraseña
                                </button>

                                <button type="button" class="btn btn-info btn-sm"
                                        onclick="enviarCredenciales({{ $usuario->id }})">
                                    <i class="fas fa-envelope me-2"></i>
                                    Enviar Credenciales
                                </button>

                                @if($usuario->activo)
                                    <button type="button" class="btn btn-danger btn-sm"
                                            onclick="toggleUsuario({{ $usuario->id }}, false)">
                                        <i class="fas fa-user-lock me-2"></i>
                                        Desactivar Usuario
                                    </button>
                                @else
                                    <button type="button" class="btn btn-success btn-sm"
                                            onclick="toggleUsuario({{ $usuario->id }}, true)">
                                        <i class="fas fa-user-check me-2"></i>
                                        Activar Usuario
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function resetPassword(userId) {
    if (confirm('¿Está seguro de que desea resetear la contraseña de este usuario?')) {
        fetch(`/usuarios/${userId}/reset-password`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(`Contraseña reseteada exitosamente. Nueva contraseña: ${data.new_password}`);
                // Marcar que debe cambiar contraseña
                document.getElementById('cambiar_password').checked = true;
            } else {
                alert('Error al resetear la contraseña: ' + (data.message || 'Error desconocido'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al resetear la contraseña');
        });
    }
}

function enviarCredenciales(userId) {
    if (confirm('¿Desea enviar las credenciales por correo electrónico?')) {
        fetch(`/usuarios/${userId}/enviar-credenciales`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Credenciales enviadas exitosamente');
            } else {
                alert('Error al enviar credenciales: ' + (data.message || 'Error desconocido'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al enviar credenciales');
        });
    }
}

function toggleUsuario(userId, activate) {
    const action = activate ? 'activar' : 'desactivar';
    if (confirm(`¿Está seguro de que desea ${action} este usuario?`)) {
        fetch(`/usuarios/${userId}/toggle`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ activo: activate })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(`Usuario ${action} exitosamente`);
                location.reload();
            } else {
                alert(`Error al ${action} usuario: ` + (data.message || 'Error desconocido'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert(`Error al ${action} usuario`);
        });
    }
}
</script>
@endsection
