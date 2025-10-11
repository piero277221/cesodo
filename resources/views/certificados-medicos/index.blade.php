@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="fas fa-file-medical text-danger me-2"></i>
            Certificados Médicos
        </h2>
        <a href="{{ route('certificados-medicos.create') }}" class="btn btn-danger">
            <i class="fas fa-plus me-1"></i>
            Nuevo Certificado
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-1"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-1"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('certificados-medicos.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Buscar</label>
                    <input type="text" name="search" class="form-control" 
                           placeholder="DNI, nombre o apellido"
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Estado</label>
                    <select name="estado" class="form-select">
                        <option value="">Todos</option>
                        <option value="vigente" {{ request('estado') == 'vigente' ? 'selected' : '' }}>Vigentes</option>
                        <option value="proximo_vencer" {{ request('estado') == 'proximo_vencer' ? 'selected' : '' }}>Próximos a vencer</option>
                        <option value="vencido" {{ request('estado') == 'vencido' ? 'selected' : '' }}>Vencidos</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-1"></i>Buscar
                    </button>
                    <a href="{{ route('certificados-medicos.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-1"></i>Limpiar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Lista de Certificados -->
    <div class="card">
        <div class="card-body">
            @if($certificados->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>DNI</th>
                                <th>Persona</th>
                                <th>Fecha Emisión</th>
                                <th>Fecha Expiración</th>
                                <th>Estado</th>
                                <th>Archivo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($certificados as $certificado)
                                <tr class="{{ $certificado->estaVencido() ? 'table-danger' : ($certificado->estaProximoAVencer() ? 'table-warning' : '') }}">
                                    <td class="fw-bold">{{ $certificado->numero_documento }}</td>
                                    <td>
                                        <div class="fw-bold">{{ $certificado->persona->nombre_completo }}</div>
                                        @if($certificado->persona->celular)
                                            <small class="text-muted">
                                                <i class="fas fa-phone"></i> {{ $certificado->persona->celular }}
                                            </small>
                                        @endif
                                    </td>
                                    <td>{{ $certificado->fecha_emision ? $certificado->fecha_emision->format('d/m/Y') : '-' }}</td>
                                    <td>
                                        <div>{{ $certificado->fecha_expiracion ? $certificado->fecha_expiracion->format('d/m/Y') : '-' }}</div>
                                        @if($certificado->fecha_expiracion)
                                            @php
                                                $dias = $certificado->diasRestantes();
                                            @endphp
                                            @if($dias < 0)
                                                <small class="text-danger">
                                                    <i class="fas fa-exclamation-triangle"></i> Vencido hace {{ abs($dias) }} días
                                                </small>
                                            @elseif($dias <= 30)
                                                <small class="text-warning">
                                                    <i class="fas fa-clock"></i> Vence en {{ $dias }} días
                                                </small>
                                            @else
                                                <small class="text-success">
                                                    <i class="fas fa-check"></i> Vigente ({{ $dias }} días)
                                                </small>
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        @if($certificado->estaVencido())
                                            <span class="badge bg-danger">
                                                <i class="fas fa-times-circle me-1"></i>Vencido
                                            </span>
                                        @elseif($certificado->estaProximoAVencer())
                                            <span class="badge bg-warning text-dark">
                                                <i class="fas fa-exclamation-triangle me-1"></i>Por vencer
                                            </span>
                                        @else
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle me-1"></i>Vigente
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($certificado->archivo_certificado)
                                            <a href="{{ route('certificados-medicos.descargar', $certificado) }}"
                                               class="btn btn-sm btn-outline-info" title="Descargar archivo">
                                                <i class="fas fa-download"></i> Descargar
                                            </a>
                                        @else
                                            <span class="text-muted">Sin archivo</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('certificados-medicos.show', $certificado) }}"
                                               class="btn btn-sm btn-outline-primary" title="Ver">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('certificados-medicos.edit', $certificado) }}"
                                               class="btn btn-sm btn-outline-warning" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" action="{{ route('certificados-medicos.destroy', $certificado) }}"
                                                  style="display: inline;" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        title="Eliminar"
                                                        onclick="return confirm('¿Eliminar este certificado médico?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $certificados->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-file-medical text-muted" style="font-size: 4rem;"></i>
                    <p class="text-muted mt-3">No hay certificados médicos registrados</p>
                    <a href="{{ route('certificados-medicos.create') }}" class="btn btn-danger">
                        <i class="fas fa-plus me-1"></i>Registrar primer certificado
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.table-hover tbody tr:hover {
    background-color: rgba(0, 0, 0, 0.02);
}
</style>
@endsection
