@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="fas fa-calendar-week text-success me-2"></i>
            Menús Semanales
        </h2>
        <div class="d-flex gap-2">
            <a href="{{ route('condiciones-salud.index') }}" class="btn btn-outline-info">
                <i class="fas fa-heartbeat me-1"></i>
                Condiciones de Salud
            </a>
            <a href="{{ route('menus.create') }}" class="btn btn-success">
                <i class="fas fa-plus me-1"></i>
                Nuevo Menú Semanal
            </a>
        </div>
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

    <!-- Estadísticas -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $menus->total() }}</h4>
                            <small>Total Menús</small>
                        </div>
                        <i class="fas fa-utensils fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $menus->where('estado', 'publicado')->count() }}</h4>
                            <small>Publicados</small>
                        </div>
                        <i class="fas fa-check-circle fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $menus->where('estado', 'borrador')->count() }}</h4>
                            <small>Borradores</small>
                        </div>
                        <i class="fas fa-edit fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $menus->sum('total_porciones') }}</h4>
                            <small>Total Porciones</small>
                        </div>
                        <i class="fas fa-users fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de Menús -->
    <div class="card">
        <div class="card-body">
            @if($menus->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Semana</th>
                                <th>Descripción</th>
                                <th>Porciones</th>
                                <th>Condiciones Especiales</th>
                                <th>Estado</th>
                                <th>Creado por</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($menus as $menu)
                                <tr>
                                    <td>
                                        <div class="fw-bold">
                                            {{ $menu->semana_inicio->format('d/m/Y') }} -
                                            {{ $menu->semana_fin->format('d/m/Y') }}
                                        </div>
                                        <small class="text-muted">
                                            {{ $menu->semana_inicio->diffForHumans() }}
                                        </small>
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ $menu->descripcion ?: 'Sin descripción' }}</div>
                                        <small class="text-muted">{{ $menu->items->count() }} comidas planificadas</small>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="badge bg-primary mb-1">
                                                <i class="fas fa-users me-1"></i>
                                                {{ $menu->porciones_normales }} normales
                                            </span>
                                            @if($menu->porciones_especiales > 0)
                                                <span class="badge bg-warning">
                                                    <i class="fas fa-heartbeat me-1"></i>
                                                    {{ $menu->porciones_especiales }} especiales
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if($menu->condiciones->count() > 0)
                                            @foreach($menu->condiciones as $condicion)
                                                <span class="badge bg-info me-1">
                                                    {{ $condicion->nombre }} ({{ $condicion->pivot->porciones }})
                                                </span>
                                            @endforeach
                                        @else
                                            <span class="text-muted">Ninguna</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($menu->estado === 'publicado')
                                            <span class="badge bg-success">
                                                <i class="fas fa-check me-1"></i>Publicado
                                            </span>
                                        @else
                                            <span class="badge bg-warning">
                                                <i class="fas fa-edit me-1"></i>Borrador
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $menu->user->name ?? 'Sistema' }}
                                        <br>
                                        <small class="text-muted">{{ $menu->created_at->format('d/m/Y H:i') }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('menus.show', $menu) }}"
                                               class="btn btn-sm btn-outline-primary" title="Ver">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('menus.edit', $menu) }}"
                                               class="btn btn-sm btn-outline-warning" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @if($menu->estado === 'publicado')
                                                <a href="{{ route('menus.preparar', $menu) }}"
                                                   class="btn btn-sm btn-outline-success" title="Preparar"
                                                   onclick="return confirm('¿Confirmar preparación del menú? Esto descontará del inventario.')">
                                                    <i class="fas fa-utensils"></i>
                                                </a>
                                                <a href="{{ route('menus.reporte', $menu) }}"
                                                   class="btn btn-sm btn-outline-info" title="Reporte">
                                                    <i class="fas fa-chart-bar"></i>
                                                </a>
                                            @endif
                                            <form method="POST" action="{{ route('menus.destroy', $menu) }}"
                                                  style="display: inline;" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        title="Eliminar"
                                                        onclick="return confirm('¿Eliminar este menú?')">
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
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div>
                        <small class="text-muted">
                            Mostrando {{ $menus->firstItem() }} a {{ $menus->lastItem() }}
                            de {{ $menus->total() }} menús
                        </small>
                    </div>
                    <div>
                        {{ $menus->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-calendar-week fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">No hay menús semanales</h4>
                    <p class="text-muted mb-4">Comience creando su primer menú semanal</p>
                    <a href="{{ route('menus.create') }}" class="btn btn-success">
                        <i class="fas fa-plus me-1"></i>
                        Crear Primer Menú
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
