@extends('layouts.app')

@section('title', 'Inventario')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">
                    <i class="fas fa-warehouse text-info me-2"></i>
                    Inventario
                </h2>
                <a href="{{ route('inventarios.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>
                    Nuevo Producto
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-1"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Estadísticas rápidas -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Total Productos</h6>
                                    <h3 class="mb-0">{{ isset($stats['total_productos']) ? $stats['total_productos'] : 0 }}</h3>
                                </div>
                                <div>
                                    <i class="fas fa-box fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Stock Disponible</h6>
                                    <h3 class="mb-0">{{ isset($stats['stock_total']) ? number_format($stats['stock_total'], 0) : 0 }}</h3>
                                </div>
                                <div>
                                    <i class="fas fa-cubes fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Stock Bajo</h6>
                                    <h3 class="mb-0">{{ isset($stats['stock_bajo']) ? $stats['stock_bajo'] : 0 }}</h3>
                                </div>
                                <div>
                                    <i class="fas fa-exclamation-triangle fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card bg-danger text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Sin Stock</h6>
                                    <h3 class="mb-0">{{ isset($stats['sin_stock']) ? $stats['sin_stock'] : 0 }}</h3>
                                </div>
                                <div>
                                    <i class="fas fa-times-circle fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filtros de búsqueda -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('inventarios.index') }}">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Buscar Producto</label>
                                <input type="text" name="search" class="form-control"
                                       placeholder="Nombre o código del producto..."
                                       value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Categoría</label>
                                <select name="categoria" class="form-select">
                                    <option value="">Todas las categorías</option>
                                    @if(isset($categorias))
                                        @foreach($categorias as $categoria)
                                            <option value="{{ $categoria->id }}"
                                                    {{ request('categoria') == $categoria->id ? 'selected' : '' }}>
                                                {{ $categoria->nombre }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Estado Stock</label>
                                <select name="stock_status" class="form-select">
                                    <option value="">Todos</option>
                                    <option value="disponible" {{ request('stock_status') == 'disponible' ? 'selected' : '' }}>
                                        Con Stock
                                    </option>
                                    <option value="bajo" {{ request('stock_status') == 'bajo' ? 'selected' : '' }}>
                                        Stock Bajo
                                    </option>
                                    <option value="sin_stock" {{ request('stock_status') == 'sin_stock' ? 'selected' : '' }}>
                                        Sin Stock
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i> Filtrar
                                    </button>
                                    <a href="{{ route('inventarios.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times"></i> Limpiar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabla de inventario -->
            <div class="card">
                <div class="card-body">
                    @if(!empty($inventarios) && count($inventarios) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Producto</th>
                                        <th>Categoría</th>
                                        <th>Stock Actual</th>
                                        <th>Stock Mínimo</th>
                                        <th>Unidad</th>
                                        <th>Estado</th>
                                        <th>Última Actualización</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($inventarios as $inventario)
                                        <tr>
                                            <td>
                                                <div>
                                                    <strong>{{ $inventario->producto->nombre ?? 'N/A' }}</strong>
                                                    @if(isset($inventario->producto->descripcion))
                                                        <br><small class="text-muted">{{ $inventario->producto->descripcion }}</small>
                                                    @endif
                                                    <br><small class="text-primary">
                                                        @if(isset($inventario->producto->codigo))
                                                            Código: {{ $inventario->producto->codigo }}
                                                        @else
                                                            Sin código
                                                        @endif
                                                    </small>
                                                </div>
                                            </td>
                                            <td>
                                                @if(isset($inventario->producto->categoria))
                                                    <span class="badge bg-secondary">{{ $inventario->producto->categoria->nombre }}</span>
                                                @else
                                                    <span class="text-muted">Sin categoría</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="fw-bold fs-5">{{ number_format($inventario->stock_actual, 0) }}</span>
                                            </td>
                                            <td>
                                                {{ number_format($inventario->stock_minimo, 0) }}
                                            </td>
                                            <td>
                                                @if(isset($inventario->unidad) || isset($inventario->producto->unidad))
                                                    {{ $inventario->unidad ?? $inventario->producto->unidad }}
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $stock_actual = $inventario->stock_actual;
                                                    $stock_minimo = $inventario->stock_minimo;
                                                @endphp
                                                @if($stock_actual <= 0)
                                                    <span class="badge bg-danger">Sin Stock</span>
                                                @elseif($stock_actual <= $stock_minimo)
                                                    <span class="badge bg-warning text-dark">Stock Bajo</span>
                                                @else
                                                    <span class="badge bg-success">Disponible</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($inventario->updated_at)
                                                    {{ $inventario->updated_at->format('d/m/Y H:i') }}
                                                @else
                                                    <span class="text-muted">No disponible</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('inventarios.show', $inventario) }}"
                                                       class="btn btn-sm btn-outline-info" title="Ver detalles">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('inventarios.edit', $inventario) }}"
                                                       class="btn btn-sm btn-outline-warning" title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    @if(Route::has('inventarios.movimientos'))
                                                        <a href="{{ route('inventarios.movimientos', $inventario) }}"
                                                           class="btn btn-sm btn-outline-secondary" title="Ver movimientos">
                                                            <i class="fas fa-history"></i>
                                                        </a>
                                                    @endif
                                                    <form action="{{ route('inventarios.destroy', $inventario) }}"
                                                          method="POST" style="display: inline;"
                                                          onsubmit="return confirm('¿Está seguro de eliminar este inventario?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
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
                        @if(is_object($inventarios) && method_exists($inventarios, 'links'))
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <div>
                                    <small class="text-muted">
                                        Mostrando {{ $inventarios->firstItem() ?? 0 }} a {{ $inventarios->lastItem() ?? 0 }}
                                        de {{ $inventarios->total() ?? 0 }} resultados
                                    </small>
                                </div>
                                <div>
                                    {{ $inventarios->appends(request()->query())->links() }}
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-warehouse fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">No hay productos en inventario</h4>
                            <p class="text-muted mb-4">
                                @if(request()->hasAny(['search', 'categoria', 'stock_status']))
                                    No se encontraron productos que coincidan con los filtros aplicados.
                                @else
                                    Comience agregando productos al inventario.
                                @endif
                            </p>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('inventarios.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-1"></i>
                                    Agregar Primer Producto
                                </a>
                                @if(request()->hasAny(['search', 'categoria', 'stock_status']))
                                    <a href="{{ route('inventarios.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-1"></i>
                                        Limpiar Filtros
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
