@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Encabezado -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0" style="color: var(--cesodo-black); font-weight: 700;">Lista de Menús</h4>
        <a href="{{ route('menus.create') }}" class="btn btn-danger">
            <i class="fas fa-plus me-2"></i>Nuevo Menú
        </a>
    </div>

    <!-- Estadísticas -->
    <div class="row g-3 mb-4">
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm h-100" style="background: white;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-uppercase mb-1" style="color: #666; font-size: 0.75rem; font-weight: 600; letter-spacing: 0.5px;">Menús Totales</p>
                            <h3 class="mb-0" style="color: var(--cesodo-black); font-weight: 700;">{{ $estadisticas['total_menus'] }}</h3>
                        </div>
                        <div class="d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: var(--cesodo-black); border-radius: 12px;">
                            <i class="fas fa-utensils" style="font-size: 1.5rem; color: white;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm h-100" style="background: white;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-uppercase mb-1" style="color: #666; font-size: 0.75rem; font-weight: 600; letter-spacing: 0.5px;">En Servicio</p>
                            <h3 class="mb-0" style="color: var(--cesodo-black); font-weight: 700;">{{ $estadisticas['menus_activos'] }}</h3>
                        </div>
                        <div class="d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: var(--cesodo-red); border-radius: 12px;">
                            <i class="fas fa-play-circle" style="font-size: 1.5rem; color: white;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm h-100" style="background: white;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-uppercase mb-1" style="color: #666; font-size: 0.75rem; font-weight: 600; letter-spacing: 0.5px;">Planificados</p>
                            <h3 class="mb-0" style="color: var(--cesodo-black); font-weight: 700;">{{ $estadisticas['menus_planificados'] }}</h3>
                        </div>
                        <div class="d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: #333; border-radius: 12px;">
                            <i class="fas fa-clock" style="font-size: 1.5rem; color: white;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido principal -->
    <div class="card border-0 shadow-sm" style="background: white;">
        <!-- Filtros y búsqueda -->
        <div class="card-body p-4">
            <form action="{{ route('menus.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-6 col-lg-3">
                        <label class="form-label" style="color: var(--cesodo-black); font-weight: 600; font-size: 0.875rem;">Buscar</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white" style="border-color: #dee2e6;">
                                <i class="fas fa-search" style="color: #666;"></i>
                            </span>
                            <input type="text" class="form-control" placeholder="Buscar menús..." 
                                   name="search" value="{{ request('search') }}"
                                   style="border-left: none;">
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <label class="form-label" style="color: var(--cesodo-black); font-weight: 600; font-size: 0.875rem;">Estado</label>
                        <select class="form-select" name="estado">
                            <option value="">Todos los estados</option>
                            <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activos</option>
                            <option value="planificado" {{ request('estado') == 'planificado' ? 'selected' : '' }}>Planificados</option>
                            <option value="completado" {{ request('estado') == 'completado' ? 'selected' : '' }}>Completados</option>
                            <option value="borrador" {{ request('estado') == 'borrador' ? 'selected' : '' }}>Borradores</option>
                        </select>
                    </div>
                    <div class="col-md-6 col-lg-2">
                        <label class="form-label" style="color: var(--cesodo-black); font-weight: 600; font-size: 0.875rem;">Desde</label>
                        <input type="date" class="form-control" name="fecha_desde" value="{{ request('fecha_desde') }}">
                    </div>
                    <div class="col-md-6 col-lg-2">
                        <label class="form-label" style="color: var(--cesodo-black); font-weight: 600; font-size: 0.875rem;">Hasta</label>
                        <input type="date" class="form-control" name="fecha_hasta" value="{{ request('fecha_hasta') }}">
                    </div>
                    <div class="col-lg-2">
                        <label class="form-label d-block" style="opacity: 0;">Acciones</label>
                        <button type="submit" class="btn btn-dark w-100">
                            <i class="fas fa-filter me-2"></i>Filtrar
                        </button>
                    </div>
                </div>
                
                @if(request()->hasAny(['search', 'estado', 'fecha_desde', 'fecha_hasta']))
                <div class="mt-3">
                    <a href="{{ route('menus.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-times me-2"></i>Limpiar filtros
                    </a>
                </div>
                @endif
            </form>
        </div>

        <div class="card-body p-0">
            @if($menus->isEmpty())
                <!-- Estado vacío -->
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-clipboard-list" style="font-size: 4rem; color: #ccc;"></i>
                    </div>
                    <h5 style="color: var(--cesodo-black); font-weight: 600;">No se encontraron menús</h5>
                    <p class="text-muted mb-4">
                        @if(request()->has('search') || request()->has('estado') || request()->has('fecha_desde') || request()->has('fecha_hasta'))
                            No hay resultados para los filtros seleccionados
                        @else
                            Aún no hay menús registrados en el sistema
                        @endif
                    </p>
                    <div>
                        @if(request()->has('search') || request()->has('estado') || request()->has('fecha_desde') || request()->has('fecha_hasta'))
                            <a href="{{ route('menus.index') }}" class="btn btn-outline-dark">
                                <i class="fas fa-times me-2"></i>Limpiar filtros
                            </a>
                        @else
                            <a href="{{ route('menus.create') }}" class="btn btn-danger">
                                <i class="fas fa-plus me-2"></i>Crear primer menú
                            </a>
                        @endif
                    </div>
                </div>
            @else
                <!-- Tabla de menús -->
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead style="background: var(--cesodo-black);">
                            <tr>
                                <th class="ps-4 py-3" style="color: white; font-weight: 600; font-size: 0.8125rem; text-transform: uppercase; letter-spacing: 0.5px;">Menú</th>
                                <th class="py-3" style="color: white; font-weight: 600; font-size: 0.8125rem; text-transform: uppercase; letter-spacing: 0.5px;">Estado</th>
                                <th class="py-3" style="color: white; font-weight: 600; font-size: 0.8125rem; text-transform: uppercase; letter-spacing: 0.5px;">Platos</th>
                                <th class="py-3" style="color: white; font-weight: 600; font-size: 0.8125rem; text-transform: uppercase; letter-spacing: 0.5px;">Fecha Inicio</th>
                                <th class="py-3" style="color: white; font-weight: 600; font-size: 0.8125rem; text-transform: uppercase; letter-spacing: 0.5px;">Fecha Fin</th>
                                <th class="py-3" style="color: white; font-weight: 600; font-size: 0.8125rem; text-transform: uppercase; letter-spacing: 0.5px;">Costo</th>
                                <th class="text-center py-3 pe-4" style="color: white; font-weight: 600; font-size: 0.8125rem; text-transform: uppercase; letter-spacing: 0.5px;" width="180">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($menus as $menu)
                            <tr style="border-bottom: 1px solid #f0f0f0;">
                                <td class="ps-4 py-3">
                                    <div>
                                        <h6 class="mb-1" style="color: var(--cesodo-black); font-weight: 600; font-size: 0.9375rem;">{{ $menu->nombre }}</h6>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge" style="background: #f5f5f5; color: var(--cesodo-black); font-weight: 500; font-size: 0.75rem;">
                                                {{ ucfirst($menu->tipo_menu) }}
                                            </span>
                                            @if($menu->descripcion)
                                                <span style="color: #666; font-size: 0.8125rem;">{{ Str::limit($menu->descripcion, 40) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3">
                                    @if($menu->estado == 'activo')
                                        <span class="badge px-3 py-2" style="background: var(--cesodo-red); color: white; font-weight: 500;">En Servicio</span>
                                    @elseif($menu->estado == 'planificado')
                                        <span class="badge px-3 py-2" style="background: #333; color: white; font-weight: 500;">Planificado</span>
                                    @elseif($menu->estado == 'borrador')
                                        <span class="badge px-3 py-2" style="background: #666; color: white; font-weight: 500;">Borrador</span>
                                    @elseif($menu->estado == 'completado')
                                        <span class="badge px-3 py-2" style="background: var(--cesodo-black); color: white; font-weight: 500;">Completado</span>
                                    @else
                                        <span class="badge px-3 py-2" style="background: #999; color: white; font-weight: 500;">{{ ucfirst($menu->estado) }}</span>
                                    @endif
                                </td>
                                <td class="py-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="flex-grow-1">
                                            <div class="progress" style="height: 6px; background: #f0f0f0; border-radius: 3px;">
                                                <div class="progress-bar" 
                                                     style="width: {{ ($menu->platos_disponibles / ($menu->platos_totales ?: 1)) * 100 }}%; background: {{ $menu->platos_disponibles > 0 ? 'var(--cesodo-red)' : '#ccc' }};">
                                                </div>
                                            </div>
                                        </div>
                                        <span style="color: var(--cesodo-black); font-weight: 600; font-size: 0.875rem; white-space: nowrap;">
                                            {{ $menu->platos_disponibles }}/{{ $menu->platos_totales }}
                                        </span>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <div>
                                        <div style="color: var(--cesodo-black); font-weight: 600; font-size: 0.875rem;">
                                            {{ $menu->fecha_inicio ? \Carbon\Carbon::parse($menu->fecha_inicio)->format('d/m/Y') : '-' }}
                                        </div>
                                        @if($menu->fecha_inicio)
                                        <div style="color: #666; font-size: 0.8125rem;">
                                            {{ \Carbon\Carbon::parse($menu->fecha_inicio)->format('H:i') }}
                                        </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3">
                                    <div>
                                        <div style="color: var(--cesodo-black); font-weight: 600; font-size: 0.875rem;">
                                            {{ $menu->fecha_fin ? \Carbon\Carbon::parse($menu->fecha_fin)->format('d/m/Y') : '-' }}
                                        </div>
                                        @if($menu->fecha_fin)
                                        <div style="color: #666; font-size: 0.8125rem;">
                                            {{ \Carbon\Carbon::parse($menu->fecha_fin)->format('H:i') }}
                                        </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3">
                                    <div>
                                        <div style="color: var(--cesodo-black); font-weight: 600; font-size: 0.875rem;">
                                            S/ {{ number_format($menu->costo_estimado, 2) }}
                                        </div>
                                        @if($menu->costo_total != $menu->costo_estimado)
                                            <div style="color: #666; font-size: 0.8125rem;">
                                                Real: S/ {{ number_format($menu->costo_total, 2) }}
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-center py-3 pe-4">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('menus.edit', $menu->id) }}"
                                           class="btn btn-sm btn-dark px-3"
                                           title="Editar">
                                            <i class="fas fa-edit me-1"></i>Editar
                                        </a>
                                        <form action="{{ route('menus.destroy', $menu->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-sm btn-outline-danger px-3"
                                                    onclick="return confirm('¿Está seguro que desea eliminar este menú?')"
                                                    title="Eliminar">
                                                <i class="far fa-trash-alt me-1"></i>Eliminar
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
                @if($menus instanceof \Illuminate\Pagination\LengthAwarePaginator && $menus->hasPages())
                    <div class="card-footer bg-white py-3 px-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div style="color: #666; font-size: 0.875rem;">
                                Mostrando <span style="font-weight: 600; color: var(--cesodo-black);">{{ $menus->firstItem() ?? 0 }}</span> 
                                a <span style="font-weight: 600; color: var(--cesodo-black);">{{ $menus->lastItem() ?? 0 }}</span> 
                                de <span style="font-weight: 600; color: var(--cesodo-black);">{{ $menus->total() ?? 0 }}</span> menús
                            </div>
                            <div>
                                {{ $menus->links('vendor.pagination.bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection