@extends('layouts.app')

@section('title', 'Gestión de Contratos')

@push('styles')
<style>
/* Asegurar que los modales aparezcan correctamente */
.modal {
    z-index: 1055 !important;
}
.modal-backdrop {
    z-index: 1050 !important;
}
.modal-content {
    z-index: 1060 !important;
}
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-file-contract text-primary me-2"></i>
                        Gestión de Contratos
                    </h1>
                    <p class="text-muted mb-0">Administra todos los contratos del personal</p>
                </div>
                <div>
                    <a href="{{ route('contratos.por-vencer') }}" class="btn btn-warning me-2">
                        <i class="fas fa-clock me-2"></i>
                        Por Vencer ({{ $estadisticas['por_vencer'] }})
                    </a>
                    <a href="{{ route('contratos.templates.index') }}" class="btn btn-info me-2">
                        <i class="fas fa-file-alt me-2"></i>
                        Templates
                    </a>
                    <a href="{{ route('contratos.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>
                        Nuevo Contrato
                    </a>
                </div>
            </div>

            <!-- Estadísticas -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Contratos
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $estadisticas['total'] }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-file-contract fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Contratos Activos
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $estadisticas['activos'] }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Pendientes de Firma
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $estadisticas['pendientes_firma'] }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-signature fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Borradores
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $estadisticas['borradores'] }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-edit fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filtros -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-filter me-2"></i>
                        Filtros de Búsqueda
                    </h6>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('contratos.index') }}" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Buscar</label>
                            <input type="text" class="form-control" name="buscar"
                                   value="{{ request('buscar') }}"
                                   placeholder="Número, cargo, persona...">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Estado</label>
                            <select name="estado" class="form-select">
                                <option value="">Todos</option>
                                <option value="borrador" {{ request('estado') == 'borrador' ? 'selected' : '' }}>Borrador</option>
                                <option value="pendiente_firma" {{ request('estado') == 'pendiente_firma' ? 'selected' : '' }}>Pendiente Firma</option>
                                <option value="firmado" {{ request('estado') == 'firmado' ? 'selected' : '' }}>Firmado</option>
                                <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                                <option value="finalizado" {{ request('estado') == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                                <option value="rescindido" {{ request('estado') == 'rescindido' ? 'selected' : '' }}>Rescindido</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Tipo</label>
                            <select name="tipo_contrato" class="form-select">
                                <option value="">Todos</option>
                                @foreach(['indefinido' => 'Indefinido', 'temporal' => 'Temporal', 'obra_labor' => 'Obra o Labor', 'aprendizaje' => 'Aprendizaje', 'prestacion_servicios' => 'Prestación de Servicios'] as $key => $tipo)
                                    <option value="{{ $key }}" {{ request('tipo_contrato') == $key ? 'selected' : '' }}>
                                        {{ $tipo }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Modalidad</label>
                            <select name="modalidad" class="form-select">
                                <option value="">Todas</option>
                                @foreach(['completa' => 'Tiempo Completo', 'parcial' => 'Tiempo Parcial', 'flexible' => 'Horario Flexible'] as $key => $modalidad)
                                    <option value="{{ $key }}" {{ request('modalidad') == $key ? 'selected' : '' }}>
                                        {{ $modalidad }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Fecha Inicio</label>
                            <input type="date" class="form-control" name="fecha_inicio"
                                   value="{{ request('fecha_inicio') }}">
                        </div>

                        <div class="col-md-1">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabla de contratos -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-list me-2"></i>
                        Lista de Contratos
                    </h6>
                </div>
                <div class="card-body">
                    @if($contratos->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>
                                            <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'numero_contrato', 'sort_dir' => request('sort_dir') == 'asc' ? 'desc' : 'asc']) }}"
                                               class="text-white text-decoration-none">
                                                Número
                                                @if(request('sort_by') == 'numero_contrato')
                                                    <i class="fas fa-sort-{{ request('sort_dir') == 'asc' ? 'up' : 'down' }}"></i>
                                                @endif
                                            </a>
                                        </th>
                                        <th>Persona</th>
                                        <th>Cargo</th>
                                        <th>Tipo</th>
                                        <th>
                                            <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'fecha_inicio', 'sort_dir' => request('sort_dir') == 'asc' ? 'desc' : 'asc']) }}"
                                               class="text-white text-decoration-none">
                                                Fecha Inicio
                                                @if(request('sort_by') == 'fecha_inicio')
                                                    <i class="fas fa-sort-{{ request('sort_dir') == 'asc' ? 'up' : 'down' }}"></i>
                                                @endif
                                            </a>
                                        </th>
                                        <th>Salario</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($contratos as $contrato)
                                        <tr>
                                            <td>
                                                <strong>{{ $contrato->numero_contrato }}</strong>
                                            </td>
                                            <td>
                                                <div>
                                                    <strong>{{ $contrato->persona->nombre_completo }}</strong>
                                                </div>
                                                <small class="text-muted">{{ $contrato->persona->numero_documento }}</small>
                                            </td>
                                            <td>{{ $contrato->cargo }}</td>
                                            <td>
                                                <span class="badge bg-info">{{ $contrato->tipo_contrato_texto }}</span>
                                                <br>
                                                <small class="text-muted">{{ $contrato->modalidad_texto }}</small>
                                            </td>
                                            <td>
                                                {{ $contrato->fecha_inicio->format('d/m/Y') }}
                                                @if($contrato->fecha_fin)
                                                    <br>
                                                    <small class="text-muted">hasta {{ $contrato->fecha_fin->format('d/m/Y') }}</small>
                                                @endif
                                            </td>
                                            <td>{{ $contrato->salario_formateado }}</td>
                                            <td>
                                                <span class="badge bg-{{ $contrato->estado_badge }}">
                                                    {{ $contrato->estado_texto }}
                                                </span>
                                                @php
                                                    $diasRestantes = $contrato->diasRestantes();
                                                    $tiempoTexto = $contrato->tiempoRestanteTexto();
                                                @endphp
                                                @if($diasRestantes !== null && $diasRestantes <= 30)
                                                    <br>
                                                    <small class="text-warning">
                                                        <i class="fas fa-exclamation-triangle"></i>
                                                        {{ $tiempoTexto }} restantes
                                                    </small>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="{{ route('contratos.show', $contrato) }}"
                                                       class="btn btn-info" title="Ver detalles">
                                                        <i class="fas fa-eye"></i>
                                                    </a>

                                                    @if($contrato->puedeEditarse())
                                                        <a href="{{ route('contratos.edit', $contrato) }}"
                                                           class="btn btn-warning" title="Editar">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    @endif

                                                    <a href="{{ route('contratos.seleccionar-template', $contrato) }}"
                                                       class="btn btn-danger" title="Generar PDF">
                                                        <i class="fas fa-file-pdf"></i>
                                                    </a>

                                                    @if($contrato->estado !== 'activo')
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#deleteModal{{ $contrato->id }}"
                                                                title="Eliminar">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $contratos->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-file-contract fa-3x text-gray-300 mb-4"></i>
                            <h4 class="text-gray-500">No hay contratos registrados</h4>
                            <p class="text-gray-400 mb-4">Comienza creando el primer contrato del sistema</p>
                            <a href="{{ route('contratos.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>
                                Crear Primer Contrato
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modales de eliminación -->
@foreach($contratos as $contrato)
    @if($contrato->estado !== 'activo')
        <div class="modal fade" id="deleteModal{{ $contrato->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $contrato->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel{{ $contrato->id }}">Confirmar Eliminación</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>¿Está seguro de que desea eliminar el contrato <strong>{{ $contrato->numero_contrato }}</strong> de <strong>{{ $contrato->persona->nombre_completo }}</strong>?</p>
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Esta acción no se puede deshacer y eliminará todos los archivos asociados.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <form method="POST" action="{{ route('contratos.destroy', $contrato) }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Asegurar que los modales funcionen correctamente
    var modals = document.querySelectorAll('.modal');

    modals.forEach(function(modal) {
        modal.addEventListener('shown.bs.modal', function (e) {
            // Asegurar que el modal tenga el foco correcto
            this.focus();
        });

        modal.addEventListener('hidden.bs.modal', function (e) {
            // Limpiar el backdrop si queda residual
            document.querySelectorAll('.modal-backdrop').forEach(function(backdrop) {
                if (!document.querySelector('.modal.show')) {
                    backdrop.remove();
                }
            });
        });
    });

    // Manejar clicks en botones de eliminación
    document.querySelectorAll('[data-bs-toggle="modal"]').forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            var targetModalId = this.getAttribute('data-bs-target');
            var targetModal = document.querySelector(targetModalId);

            if (targetModal) {
                var modal = new bootstrap.Modal(targetModal);
                modal.show();
            }
        });
    });
});
</script>
@endpush
