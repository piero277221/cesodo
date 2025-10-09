@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Estadísticas y acciones -->
    <div class="row mb-4">
        <div class="col-12 mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Lista de Menús</h5>
                <a href="{{ route('menus.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus me-2"></i>Nuevo Menú
                </a>
            </div>
        </div>
        <div class="col-12">
            <div class="row g-3">
                <div class="col-xl-3 col-sm-6">
                    <div class="card border-0 shadow-xs h-100">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="icon icon-shape bg-gradient-primary shadow-primary text-white rounded-3 me-3">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="text-sm text-uppercase font-weight-bold text-muted">Menús Totales</div>
                                    <h4 class="font-weight-bold mb-1">{{ $estadisticas['total_menus'] }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6">
                    <div class="card border-0 shadow-xs h-100">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="icon icon-shape bg-gradient-success shadow-success text-white rounded-3 me-3">
                                    <i class="fas fa-play-circle"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="text-sm text-uppercase font-weight-bold text-muted">En Servicio</div>
                                    <h4 class="font-weight-bold mb-1">{{ $estadisticas['menus_activos'] }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6">
                    <div class="card border-0 shadow-xs h-100">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="icon icon-shape bg-gradient-info shadow-info text-white rounded-3 me-3">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="text-sm text-uppercase font-weight-bold text-muted">Planificados</div>
                                    <h4 class="font-weight-bold mb-1">{{ $estadisticas['menus_planificados'] }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                                <i class="fas fa-clock text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm stats-card h-100">
                <div class="card-body p-3">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <p class="text-sm mb-0 text-uppercase font-weight-bold">Costo Mes Actual</p>
                            <h5 class="font-weight-bolder mb-0">S/ {{ number_format($estadisticas['costo_total_mes'], 2) }}</h5>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                <i class="fas fa-dollar-sign text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido principal -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-transparent border-0 p-0">
            <!-- Filtros y búsqueda -->
            <form action="{{ route('menus.index') }}" method="GET" class="p-4">
                <div class="row g-3">
                    <div class="col-md-6 col-lg-3">
                        <div class="form-group">
                            <label class="form-label text-sm">Buscar por nombre</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" class="form-control border-start-0 ps-0"
                                       placeholder="Buscar menús..." name="search" value="{{ request('search') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="form-group">
                            <label class="form-label text-sm">Estado</label>
                            <select class="form-select form-select-sm" name="estado">
                                <option value="">Todos los estados</option>
                                <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activos</option>
                                <option value="planificado" {{ request('estado') == 'planificado' ? 'selected' : '' }}>Planificados</option>
                                <option value="completado" {{ request('estado') == 'completado' ? 'selected' : '' }}>Completados</option>
                                <option value="borrador" {{ request('estado') == 'borrador' ? 'selected' : '' }}>Borradores</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="form-group">
                            <label class="form-label text-sm">Fecha desde</label>
                            <input type="date" class="form-control form-control-sm"
                                   name="fecha_desde" value="{{ request('fecha_desde') }}">
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="form-group">
                            <label class="form-label text-sm">Fecha hasta</label>
                            <input type="date" class="form-control form-control-sm"
                                   name="fecha_hasta" value="{{ request('fecha_hasta') }}">
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div>
                        <button type="submit" class="btn btn-sm btn-primary me-2">
                            <i class="fas fa-filter me-2"></i>Filtrar
                        </button>
                        <a href="{{ route('menus.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Limpiar
                        </a>
                    </div>
                    <a href="{{ route('menus.create') }}" class="btn btn-sm btn-success">
                        <i class="fas fa-plus me-2"></i>Nuevo Menú
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body px-0 pb-0">
            @if($menus->isEmpty())
                <!-- Estado vacío -->
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-clipboard-list text-muted" style="font-size: 3.5rem;"></i>
                    </div>
                    <h5 class="text-muted font-weight-normal">No se encontraron menús</h5>
                    <p class="text-sm text-muted mb-4">
                        @if(request()->has('search') || request()->has('estado') || request()->has('fecha_desde') || request()->has('fecha_hasta'))
                            No hay resultados para los filtros seleccionados
                        @else
                            Aún no hay menús registrados en el sistema
                        @endif
                    </p>
                    <div>
                        @if(request()->has('search') || request()->has('estado') || request()->has('fecha_desde') || request()->has('fecha_hasta'))
                            <a href="{{ route('menus.index') }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-times me-2"></i>Limpiar filtros
                            </a>
                        @else
                            <a href="{{ route('menus.create') }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-plus me-2"></i>Crear primer menú
                            </a>
                        @endif
                    </div>
                </div>
            @else
                <!-- Tabla de menús -->
                                <div class="table-responsive">
                    <table class="table table-hover align-items-center mb-0">
                        <thead class="bg-primary">
                            <tr>
                                <th class="text-uppercase text-white text-xs font-weight-bold opacity-9 ps-3">Menú</th>
                                <th class="text-uppercase text-white text-xs font-weight-bold opacity-9">Platos</th>
                                <th class="text-uppercase text-white text-xs font-weight-bold opacity-9">Estado</th>
                                <th class="text-uppercase text-white text-xs font-weight-bold opacity-9">Periodo</th>
                                <th class="text-uppercase text-white text-xs font-weight-bold opacity-9">Costos</th>
                                <th class="text-uppercase text-white text-xs font-weight-bold opacity-9 text-center" width="150">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($menus as $menu)
                            <tr>
                                <td class="ps-3">
                                    <div class="d-flex px-2 py-2">
                                        <div class="d-flex flex-column">
                                            <h6 class="mb-1 text-sm">{{ $menu->nombre }}</h6>
                                            <div class="d-flex align-items-center">
                                                <span class="badge badge-sm bg-gray-100 text-dark me-2">{{ ucfirst($menu->tipo_menu) }}</span>
                                                @if($menu->descripcion)
                                                    <span class="text-xs text-muted">{{ Str::limit($menu->descripcion, 40) }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center px-3">
                                        <div class="me-2">
                                            <div class="progress" style="width: 40px; height: 4px;">
                                                <div class="progress-bar bg-{{ $menu->platos_disponibles > 0 ? 'success' : 'secondary' }}"
                                                     style="width: {{ ($menu->platos_disponibles / ($menu->platos_totales ?: 1)) * 100 }}%">
                                                </div>
                                            </div>
                                        </div>
                                        <span class="text-xs">{{ $menu->platos_disponibles }}/{{ $menu->platos_totales }}</span>
                                    </div>
                                </td>
                                <td>
                                    @if($menu->estado == 'activo')
                                        <span class="badge badge-sm bg-gradient-success">Activo</span>
                                    @elseif($menu->estado == 'planificado')
                                        <span class="badge badge-sm bg-gradient-info">Planificado</span>
                                    @elseif($menu->estado == 'borrador')
                                        <span class="badge badge-sm bg-gradient-warning">Borrador</span>
                                    @elseif($menu->estado == 'completado')
                                        <span class="badge badge-sm bg-gradient-dark">Completado</span>
                                    @else
                                        <span class="badge badge-sm bg-gradient-secondary">{{ ucfirst($menu->estado) }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="text-xs font-weight-bold mb-0">{{ $menu->platos_disponibles }} / {{ $menu->platos_totales }}</span>
                                        <span class="text-xs text-secondary">disponibles</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="text-xs font-weight-bold">{{ $menu->fecha_inicio ? \Carbon\Carbon::parse($menu->fecha_inicio)->format('d/m/Y') : '-' }}</span>
                                        <span class="text-xs text-secondary">{{ $menu->fecha_inicio ? \Carbon\Carbon::parse($menu->fecha_inicio)->format('H:i') : '' }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="text-xs font-weight-bold">{{ $menu->fecha_fin ? \Carbon\Carbon::parse($menu->fecha_fin)->format('d/m/Y') : '-' }}</span>
                                        <span class="text-xs text-secondary">{{ $menu->fecha_fin ? \Carbon\Carbon::parse($menu->fecha_fin)->format('H:i') : '' }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="text-xs font-weight-bold">S/ {{ number_format($menu->costo_estimado, 2) }}</span>
                                        @if($menu->costo_total != $menu->costo_estimado)
                                            <span class="text-xs text-secondary">Real: S/ {{ number_format($menu->costo_total, 2) }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route('menus.edit', $menu->id) }}"
                                           class="btn btn-link text-dark px-3 mb-0" title="Editar">
                                            <i class="fas fa-edit text-dark me-2"></i>Editar
                                        </a>
                                        <form action="{{ route('menus.destroy', $menu->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-link text-danger text-gradient px-3 mb-0"
                                                    onclick="return confirm('¿Está seguro que desea eliminar el menú?')"
                                                    title="Eliminar">
                                                <i class="far fa-trash-alt me-2"></i>Eliminar
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
                @if($menus instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    <div class="card-footer py-3">
                        <nav aria-label="Page navigation">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-sm text-secondary">
                                    Mostrando {{ $menus->firstItem() ?? 0 }} - {{ $menus->lastItem() ?? 0 }} de {{ $menus->total() ?? 0 }} menús
                                </div>
                                <div>
                                    {{ $menus->links('vendor.pagination.bootstrap-4') }}
                                </div>
                            </div>
                        </nav>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection

