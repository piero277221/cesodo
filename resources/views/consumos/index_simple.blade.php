@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Gestión de Consumos</h3>
                    <div class="card-tools">
                        <a href="{{ route('consumos.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Nuevo Consumo
                        </a>
                    </div>
                </div>

                <!-- Estadísticas -->
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>{{ $totalHoy ?? 0 }}</h3>
                                    <p>Consumos Hoy</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-calendar-day"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $totalSemana ?? 0 }}</h3>
                                    <p>Total Semana</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-calendar-week"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>{{ $trabajadoresActivos ?? 0 }}</h3>
                                    <p>Trabajadores Activos</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3>{{ $totalRegistros ?? 0 }}</h3>
                                    <p>Total Registros</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-clipboard-list"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filtros -->
                    <form method="GET" class="row mb-3">
                        <div class="col-md-3">
                            <input type="text" name="search" class="form-control" placeholder="Buscar..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <input type="date" name="fecha_inicio" class="form-control" value="{{ request('fecha_inicio') }}">
                        </div>
                        <div class="col-md-2">
                            <input type="date" name="fecha_fin" class="form-control" value="{{ request('fecha_fin') }}">
                        </div>
                        <div class="col-md-2">
                            <select name="tipo_comida" class="form-control">
                                <option value="">Tipo de comida</option>
                                <option value="desayuno" {{ request('tipo_comida') == 'desayuno' ? 'selected' : '' }}>Desayuno</option>
                                <option value="almuerzo" {{ request('tipo_comida') == 'almuerzo' ? 'selected' : '' }}>Almuerzo</option>
                                <option value="cena" {{ request('tipo_comida') == 'cena' ? 'selected' : '' }}>Cena</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-info">
                                <i class="fas fa-search"></i> Filtrar
                            </button>
                            <a href="{{ route('consumos.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Limpiar
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Tabla -->
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Fecha/Hora</th>
                                    <th>Trabajador</th>
                                    <th>Tipo Comida</th>
                                    <th>Observaciones</th>
                                    <th>Registrado por</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($consumos ?? [] as $consumo)
                                    <tr>
                                        <td>
                                            <strong>{{ $consumo->fecha_consumo ? date('d/m/Y', strtotime($consumo->fecha_consumo)) : 'N/A' }}</strong><br>
                                            <small class="text-muted">{{ $consumo->hora_consumo ? date('H:i', strtotime($consumo->hora_consumo)) : 'N/A' }}</small>
                                        </td>
                                        <td>
                                            @if($consumo->trabajador)
                                                <strong>{{ $consumo->trabajador->nombres }} {{ $consumo->trabajador->apellidos }}</strong><br>
                                                <small class="text-muted">Código: {{ $consumo->trabajador->codigo }}</small>
                                            @else
                                                <span class="text-danger">Trabajador no encontrado</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $consumo->tipo_comida == 'desayuno' ? 'warning' : ($consumo->tipo_comida == 'almuerzo' ? 'success' : 'info') }}">
                                                <i class="{{ $iconos[$consumo->tipo_comida] ?? 'fas fa-utensils' }}"></i>
                                                {{ ucfirst($consumo->tipo_comida) }}
                                            </span>
                                        </td>
                                        <td>{{ $consumo->observaciones ?? 'Sin observaciones' }}</td>
                                        <td>
                                            @if($consumo->user)
                                                {{ $consumo->user->name }}
                                            @else
                                                <span class="text-muted">Sistema</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('consumos.show', $consumo) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('consumos.edit', $consumo) }}" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('consumos.destroy', $consumo) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Está seguro?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <div class="py-4">
                                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                                <h5 class="text-muted">No hay consumos registrados</h5>
                                                <p class="text-muted">Comience creando un nuevo registro de consumo.</p>
                                                <a href="{{ route('consumos.create') }}" class="btn btn-primary">
                                                    <i class="fas fa-plus"></i> Crear Primer Consumo
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Paginación -->
                @if(isset($consumos) && method_exists($consumos, 'links'))
                <div class="card-footer">
                    {{ $consumos->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
