@extends('layouts.app')

@section('title', 'Reportes - Consumos')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header con título y navegación -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">
                    <i class="fas fa-utensils text-primary me-2"></i>
                    Reporte de Consumos
                </h2>
                <div class="btn-group" role="group">
                    <a href="{{ route('reportes.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>
                        Volver al Dashboard
                    </a>
                    <a href="{{ route('reportes.consumos.excel') }}" class="btn btn-success">
                        <i class="fas fa-file-excel me-1"></i>
                        Excel
                    </a>
                    <a href="{{ route('reportes.consumos.pdf') }}" class="btn btn-danger">
                        <i class="fas fa-file-pdf me-1"></i>
                        PDF
                    </a>
                </div>
            </div>

            <!-- Mensajes -->
            @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="fas fa-info-circle me-2"></i>
                    {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Filtros -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-filter me-2"></i>
                        Filtros de Búsqueda
                    </h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('reportes.consumos') }}" class="row g-3">
                        <div class="col-md-3">
                            <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                            <input type="date"
                                   class="form-control"
                                   id="fecha_inicio"
                                   name="fecha_inicio"
                                   value="{{ request('fecha_inicio') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="fecha_fin" class="form-label">Fecha Fin</label>
                            <input type="date"
                                   class="form-control"
                                   id="fecha_fin"
                                   name="fecha_fin"
                                   value="{{ request('fecha_fin') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="tipo_comida" class="form-label">Tipo de Comida</label>
                            <select class="form-select" id="tipo_comida" name="tipo_comida">
                                <option value="">Todos los tipos</option>
                                @foreach($tiposComida as $tipo)
                                    <option value="{{ $tipo }}"
                                            {{ request('tipo_comida') == $tipo ? 'selected' : '' }}>
                                        {{ ucfirst($tipo) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="trabajador_id" class="form-label">Trabajador</label>
                            <select class="form-select" id="trabajador_id" name="trabajador_id">
                                <option value="">Todos los trabajadores</option>
                                @foreach($trabajadores as $trabajador)
                                    <option value="{{ $trabajador->id }}"
                                            {{ request('trabajador_id') == $trabajador->id ? 'selected' : '' }}>
                                        {{ $trabajador->apellidos }}, {{ $trabajador->nombres }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-1"></i>
                                Buscar
                            </button>
                            <a href="{{ route('reportes.consumos') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-1"></i>
                                Limpiar Filtros
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabla de Consumos -->
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-table me-2"></i>
                        Lista de Consumos ({{ $consumos->total() }} registros)
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Trabajador</th>
                                    <th>Tipo de Comida</th>
                                    <th>Observaciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($consumos as $consumo)
                                    <tr>
                                        <td>
                                            <i class="fas fa-calendar text-muted me-1"></i>
                                            {{ $consumo->fecha_consumo->format('d/m/Y') }}
                                        </td>
                                        <td>
                                            <i class="fas fa-clock text-muted me-1"></i>
                                            {{ $consumo->hora_consumo ? $consumo->hora_consumo->format('H:i') : '-' }}
                                        </td>
                                        <td>
                                            <i class="fas fa-user text-muted me-1"></i>
                                            {{ $consumo->trabajador->apellidos }}, {{ $consumo->trabajador->nombres }}
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">
                                                {{ ucfirst($consumo->tipo_comida) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($consumo->observaciones)
                                                <small class="text-muted">{{ $consumo->observaciones }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">
                                            <i class="fas fa-search fa-2x mb-2"></i>
                                            <br>
                                            No se encontraron consumos con los filtros aplicados
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($consumos->hasPages())
                    <div class="card-footer">
                        {{ $consumos->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
