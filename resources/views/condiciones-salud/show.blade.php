@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="fas fa-heartbeat text-info me-2"></i>
            {{ $condicionSalud->nombre }}
        </h2>
        <div class="d-flex gap-2">
            <a href="{{ route('condiciones-salud.edit', $condicionSalud) }}" class="btn btn-warning">
                <i class="fas fa-edit me-1"></i>
                Editar
            </a>
            <a href="{{ route('condiciones-salud.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i>
                Volver
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Información Principal -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Información General
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-info">Nombre:</label>
                            <p class="fs-5">{{ $condicionSalud->nombre }}</p>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-info">Estado:</label>
                            <p>
                                @if($condicionSalud->activo)
                                    <span class="badge bg-success fs-6">
                                        <i class="fas fa-check-circle me-1"></i>Activa
                                    </span>
                                @else
                                    <span class="badge bg-secondary fs-6">
                                        <i class="fas fa-times-circle me-1"></i>Inactiva
                                    </span>
                                @endif
                            </p>
                        </div>

                        @if($condicionSalud->descripcion)
                        <div class="col-12">
                            <label class="form-label fw-bold text-info">Descripción:</label>
                            <p class="text-muted">{{ $condicionSalud->descripcion }}</p>
                        </div>
                        @endif

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-info">Fecha de Creación:</label>
                            <p>{{ $condicionSalud->created_at->format('d/m/Y H:i') }}</p>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-info">Última Modificación:</label>
                            <p>{{ $condicionSalud->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Productos Restringidos -->
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-ban me-2"></i>
                        Productos Restringidos
                        <span class="badge bg-light text-dark ms-2">
                            {{ count($condicionSalud->restricciones_alimentarias ?? []) }}
                        </span>
                    </h5>
                </div>
                <div class="card-body">
                    @if(!empty($condicionSalud->restricciones_alimentarias))
                        <div class="row">
                            @foreach($productosRestringidos as $producto)
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-center p-2 border rounded">
                                        <div class="me-3">
                                            <i class="fas fa-box text-danger fa-lg"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ $producto->nombre }}</h6>
                                            <small class="text-muted">
                                                Código: {{ $producto->codigo }}
                                                @if($producto->categoria)
                                                    | Categoría: {{ $producto->categoria->nombre }}
                                                @endif
                                            </small>
                                        </div>
                                        <div>
                                            <span class="badge bg-danger">
                                                <i class="fas fa-ban"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-check-circle text-success fa-3x mb-3"></i>
                            <h5 class="text-muted">No hay productos restringidos</h5>
                            <p class="text-muted">Esta condición no tiene restricciones alimentarias específicas.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Estadísticas y Acciones -->
        <div class="col-lg-4">
            <!-- Estadísticas -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-bar me-2"></i>
                        Estadísticas
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3 text-center">
                        <div class="col-12">
                            <div class="bg-danger text-white p-3 rounded">
                                <i class="fas fa-ban fa-2x mb-2"></i>
                                <h4 class="mb-1">{{ count($condicionSalud->restricciones_alimentarias ?? []) }}</h4>
                                <small>Productos Restringidos</small>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="bg-info text-white p-3 rounded">
                                <i class="fas fa-utensils fa-2x mb-2"></i>
                                <h4 class="mb-1">{{ $condicionSalud->menus->count() }}</h4>
                                <small>Menús Configurados</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Acciones Rápidas -->
            <div class="card mb-4">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fas fa-bolt me-2"></i>
                        Acciones Rápidas
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('condiciones-salud.edit', $condicionSalud) }}"
                           class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>
                            Editar Condición
                        </a>

                        <a href="{{ route('menus.index') }}?condicion={{ $condicionSalud->id }}"
                           class="btn btn-info">
                            <i class="fas fa-utensils me-2"></i>
                            Ver Menús Relacionados
                        </a>

                        <button type="button" class="btn btn-outline-danger"
                                onclick="confirmarEliminacion()">
                            <i class="fas fa-trash me-2"></i>
                            Eliminar Condición
                        </button>
                    </div>
                </div>
            </div>

            <!-- Información Adicional -->
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-info me-2"></i>
                        Información Adicional
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-lightbulb me-2"></i>
                        <strong>Consejo:</strong> Las condiciones de salud son utilizadas
                        para filtrar automáticamente los productos en los menús,
                        asegurando que solo se incluyan ingredientes seguros.
                    </div>

                    @if($condicionSalud->menus->count() > 0)
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Atención:</strong> Esta condición está siendo utilizada
                            en {{ $condicionSalud->menus->count() }} menú(s).
                            Tenga cuidado al realizar modificaciones.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmación de Eliminación -->
<div class="modal fade" id="modalEliminar" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Confirmar Eliminación
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro de que desea eliminar la condición de salud <strong>{{ $condicionSalud->nombre }}</strong>?</p>

                @if($condicionSalud->menus->count() > 0)
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Atención:</strong> Esta condición está siendo utilizada en
                        {{ $condicionSalud->menus->count() }} menú(s). Al eliminarla,
                        se removerá de todos los menús asociados.
                    </div>
                @endif

                <p class="text-muted"><strong>Esta acción no se puede deshacer.</strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancelar
                </button>
                <form action="{{ route('condiciones-salud.destroy', $condicionSalud) }}"
                      method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function confirmarEliminacion() {
    const modal = new bootstrap.Modal(document.getElementById('modalEliminar'));
    modal.show();
}
</script>
@endpush
@endsection
