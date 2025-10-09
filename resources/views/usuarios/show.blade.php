@extends('layouts.app')

@section('title', 'Detalles del Usuario')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-user-circle text-primary me-2"></i>
                        {{ $usuario->name }}
                    </h1>
                    <p class="text-muted mb-0">
                        <i class="fas fa-envelope me-2"></i>{{ $usuario->email }}
                        @if($usuario->activo)
                            <span class="badge bg-success ms-2">Activo</span>
                        @else
                            <span class="badge bg-danger ms-2">Inactivo</span>
                        @endif
                    </p>
                </div>
                <div>
                    <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-warning me-2">
                        <i class="fas fa-edit me-2"></i>
                        Editar
                    </a>
                    <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Volver
                    </a>
                </div>
            </div>

            <div class="row">
                <!-- Información principal -->
                <div class="col-lg-8">
                    <!-- Datos básicos -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-id-card me-2"></i>
                                Información Personal
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Nombre Completo</label>
                                        <p class="fw-bold">{{ $usuario->name }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Email</label>
                                        <p class="fw-bold">
                                            <i class="fas fa-envelope text-info me-2"></i>{{ $usuario->email }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Código de Empleado</label>
                                        <p class="fw-bold">
                                            @if($usuario->codigo_empleado)
                                                <span class="badge bg-primary">{{ $usuario->codigo_empleado }}</span>
                                            @else
                                                <span class="text-muted">No asignado</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Estado de la Cuenta</label>
                                        <p class="fw-bold">
                                            @if($usuario->activo)
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check-circle me-1"></i>Activo
                                                </span>
                                            @else
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-times-circle me-1"></i>Inactivo
                                                </span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>

                            @if($usuario->observaciones)
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-0">
                                            <label class="form-label text-muted">Observaciones</label>
                                            <div class="bg-light p-3 rounded">
                                                {{ $usuario->observaciones }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Información de persona asociada -->
                    @if($usuario->persona)
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-info">
                                    <i class="fas fa-address-card me-2"></i>
                                    Persona Asociada
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label text-muted">Nombre Completo</label>
                                            <p class="fw-bold">{{ $usuario->persona->nombre_completo }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label text-muted">Documento</label>
                                            <p class="fw-bold">
                                                {{ $usuario->persona->tipo_documento }} - {{ $usuario->persona->numero_documento }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label text-muted">Teléfono</label>
                                            <p class="fw-bold">
                                                @if($usuario->persona->celular)
                                                    <i class="fas fa-phone text-success me-2"></i>{{ $usuario->persona->celular }}
                                                @else
                                                    <span class="text-muted">No registrado</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label text-muted">Email Personal</label>
                                            <p class="fw-bold">
                                                @if($usuario->persona->email)
                                                    <i class="fas fa-envelope text-primary me-2"></i>{{ $usuario->persona->email }}
                                                @else
                                                    <span class="text-muted">No registrado</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                @if($usuario->persona->direccion)
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mb-0">
                                                <label class="form-label text-muted">Dirección</label>
                                                <p class="fw-bold">
                                                    <i class="fas fa-map-marker-alt text-danger me-2"></i>{{ $usuario->persona->direccion }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Información de empleado asociado -->
                    @if($usuario->trabajador)
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-success">
                                    <i class="fas fa-user-tie me-2"></i>
                                    Empleado Asociado
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label text-muted">Código de Empleado</label>
                                            <p class="fw-bold">
                                                <span class="badge bg-success">{{ $usuario->trabajador->codigo }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label text-muted">Estado del Empleado</label>
                                            <p class="fw-bold">
                                                @if($usuario->trabajador->activo)
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check-circle me-1"></i>Activo
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger">
                                                        <i class="fas fa-times-circle me-1"></i>Inactivo
                                                    </span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label text-muted">Fecha de Ingreso</label>
                                            <p class="fw-bold">
                                                @if($usuario->trabajador->fecha_ingreso)
                                                    <i class="fas fa-calendar-alt text-info me-2"></i>
                                                    {{ $usuario->trabajador->fecha_ingreso->format('d/m/Y') }}
                                                @else
                                                    <span class="text-muted">No registrada</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label text-muted">Cargo</label>
                                            <p class="fw-bold">
                                                @if($usuario->trabajador->cargo)
                                                    {{ $usuario->trabajador->cargo }}
                                                @else
                                                    <span class="text-muted">No asignado</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Roles y permisos -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-warning">
                                <i class="fas fa-user-shield me-2"></i>
                                Roles y Permisos
                            </h6>
                        </div>
                        <div class="card-body">
                            @if($usuario->roles->isNotEmpty())
                                <div class="mb-3">
                                    <label class="form-label text-muted">Roles Asignados</label>
                                    <div>
                                        @foreach($usuario->roles as $rol)
                                            <span class="badge bg-primary me-2 mb-2">
                                                <i class="fas fa-shield-alt me-1"></i>{{ ucfirst($rol->name) }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>

                                @if($usuario->getAllPermissions()->isNotEmpty())
                                    <div class="mb-0">
                                        <label class="form-label text-muted">Permisos (a través de roles)</label>
                                        <div class="row">
                                            @foreach($usuario->getAllPermissions() as $permiso)
                                                <div class="col-md-6 mb-1">
                                                    <small class="text-success">
                                                        <i class="fas fa-check me-1"></i>{{ $permiso->name }}
                                                    </small>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div class="text-center">
                                    <i class="fas fa-user-slash fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No tiene roles asignados</p>
                                    <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-plus me-2"></i>Asignar Roles
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Panel lateral -->
                <div class="col-lg-4">
                    <!-- Estadísticas -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-chart-bar me-2"></i>
                                Estadísticas
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label text-muted">Cuenta creada</label>
                                <p class="fw-bold">
                                    <i class="fas fa-calendar-plus text-success me-2"></i>
                                    {{ $usuario->created_at->format('d/m/Y H:i') }}
                                    <br>
                                    <small class="text-muted">({{ $usuario->created_at->diffForHumans() }})</small>
                                </p>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted">Última actualización</label>
                                <p class="fw-bold">
                                    <i class="fas fa-edit text-info me-2"></i>
                                    {{ $usuario->updated_at->format('d/m/Y H:i') }}
                                    <br>
                                    <small class="text-muted">({{ $usuario->updated_at->diffForHumans() }})</small>
                                </p>
                            </div>

                            <div class="mb-0">
                                <label class="form-label text-muted">Último acceso</label>
                                <p class="fw-bold">
                                    @if($usuario->ultimo_acceso)
                                        <i class="fas fa-sign-in-alt text-primary me-2"></i>
                                        {{ $usuario->ultimo_acceso->format('d/m/Y H:i:s') }}
                                        <br>
                                        <small class="text-muted">({{ $usuario->ultimo_acceso->diffForHumans() }})</small>
                                    @else
                                        <i class="fas fa-user-clock text-warning me-2"></i>
                                        <span class="text-warning">Nunca ha accedido</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Estado de seguridad -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-danger">
                                <i class="fas fa-shield-alt me-2"></i>
                                Estado de Seguridad
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label text-muted">Cambio de contraseña</label>
                                <p class="fw-bold">
                                    @if($usuario->cambiar_password)
                                        <span class="badge bg-warning text-dark">
                                            <i class="fas fa-exclamation-triangle me-1"></i>
                                            Requerido en próximo acceso
                                        </span>
                                    @else
                                        <span class="badge bg-success">
                                            <i class="fas fa-check me-1"></i>
                                            No requerido
                                        </span>
                                    @endif
                                </p>
                            </div>

                            <div class="mb-0">
                                <label class="form-label text-muted">Verificación de email</label>
                                <p class="fw-bold">
                                    @if($usuario->email_verified_at)
                                        <span class="badge bg-success">
                                            <i class="fas fa-check-circle me-1"></i>
                                            Verificado
                                        </span>
                                        <br>
                                        <small class="text-muted">{{ $usuario->email_verified_at->format('d/m/Y H:i') }}</small>
                                    @else
                                        <span class="badge bg-warning text-dark">
                                            <i class="fas fa-clock me-1"></i>
                                            Pendiente
                                        </span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Acciones -->
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-warning">
                                <i class="fas fa-cogs me-2"></i>
                                Acciones
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-warning">
                                    <i class="fas fa-edit me-2"></i>
                                    Editar Usuario
                                </a>

                                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#resetPasswordModal">
                                    <i class="fas fa-key me-2"></i>
                                    Resetear Contraseña
                                </button>

                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#sendCredentialsModal">
                                    <i class="fas fa-envelope me-2"></i>
                                    Enviar Credenciales
                                </button>

                                @if($usuario->activo)
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deactivateModal">
                                        <i class="fas fa-user-lock me-2"></i>
                                        Desactivar Usuario
                                    </button>
                                @else
                                    <form method="POST" action="{{ route('usuarios.toggle', $usuario) }}">
                                        @csrf
                                        <input type="hidden" name="activo" value="1">
                                        <button type="submit" class="btn btn-success w-100">
                                            <i class="fas fa-user-check me-2"></i>
                                            Activar Usuario
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
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
                <p>¿Está seguro de que desea resetear la contraseña de <strong>{{ $usuario->name }}</strong>?</p>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Se generará una nueva contraseña temporal y se marcará para cambio obligatorio en el próximo acceso.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form method="POST" action="{{ route('usuarios.reset-password', $usuario) }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-key me-2"></i>
                        Resetear Contraseña
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para enviar credenciales -->
<div class="modal fade" id="sendCredentialsModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-envelope text-success me-2"></i>
                    Enviar Credenciales
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>¿Desea enviar las credenciales de acceso a <strong>{{ $usuario->name }}</strong>?</p>
                <p>Se enviará un correo a: <strong>{{ $usuario->email }}</strong></p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Solo se pueden enviar las credenciales si el usuario tiene contraseña temporal.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form method="POST" action="{{ route('usuarios.enviar-credenciales', $usuario) }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-envelope me-2"></i>
                        Enviar Credenciales
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para desactivar usuario -->
@if($usuario->activo)
<div class="modal fade" id="deactivateModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-user-lock text-danger me-2"></i>
                    Desactivar Usuario
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro de que desea desactivar a <strong>{{ $usuario->name }}</strong>?</p>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    El usuario no podrá acceder al sistema hasta que sea reactivado.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form method="POST" action="{{ route('usuarios.toggle', $usuario) }}" class="d-inline">
                    @csrf
                    <input type="hidden" name="activo" value="0">
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-user-lock me-2"></i>
                        Desactivar Usuario
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
