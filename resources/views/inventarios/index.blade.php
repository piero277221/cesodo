@extends('layouts.app')

@section('title', 'Inven                        <div class="icon-shape" style="background: var(--primary-color);">
                            <i class="fas fa-warehouse"></i>
                        </div>io')

@section('content')
<div class="container-fluid fade-in">
    <!-- Header moderno con estadísticas -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-modern">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <div class="icon-shape" style="background: var(--primary-color); color: white;" class="me-3">
                                    <i class="fas fa-warehouse"></i>
                                </div>
                                <div>
                                    <h1 class="h3 mb-1 text-gradient">Control de Inventario</h1>
                                    <p class="text-muted mb-0">Gestiona el stock y movimientos de productos</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('inventarios.create') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-plus me-2"></i>
                                Nuevo Producto
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Estadísticas mejoradas -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-modern h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape" style="background: var(--primary-gradient);">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="ms-3">
                            <div class="text-muted small">Total Productos</div>
                            <div class="h4 mb-0">{{ isset($stats['total_productos']) ? $stats['total_productos'] : 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-modern h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape" style="background: var(--success-color);">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="ms-3">
                            <div class="text-muted small">Stock Disponible</div>
                                    <h3 class="mb-0">{{ isset($stats['stock_disponible']) ? $stats['stock_disponible'] : 0 }}</h3>
                                </div>
                                <div>
                                    <i class="fas fa-check-circle fa-2x opacity-75"></i>
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

            <!-- Filtros -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('inventarios.index') }}" class="row g-3">
                        <div class="col-md-4">
                            <label for="search" class="form-label">Buscar</label>
                            <input type="text" class="form-control" id="search" name="search"
                                   value="{{ request('search') }}"
                                   placeholder="Nombre, código...">
                        </div>
                        <div class="col-md-3">
                            <label for="categoria" class="form-label">Categoría</label>
                            <select class="form-select" id="categoria" name="categoria">
                                <option value="">Todas</option>
                                <option value="Alimentos" {{ request('categoria') == 'Alimentos' ? 'selected' : '' }}>Alimentos</option>
                                <option value="Bebidas" {{ request('categoria') == 'Bebidas' ? 'selected' : '' }}>Bebidas</option>
                                <option value="Limpieza" {{ request('categoria') == 'Limpieza' ? 'selected' : '' }}>Limpieza</option>
                                <option value="Otros" {{ request('categoria') == 'Otros' ? 'selected' : '' }}>Otros</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="stock_status" class="form-label">Estado de Stock</label>
                            <select class="form-select" id="stock_status" name="stock_status">
                                <option value="">Todos</option>
                                <option value="disponible" {{ request('stock_status') == 'disponible' ? 'selected' : '' }}>Disponible</option>
                                <option value="bajo" {{ request('stock_status') == 'bajo' ? 'selected' : '' }}>Stock Bajo</option>
                                <option value="sin_stock" {{ request('stock_status') == 'sin_stock' ? 'selected' : '' }}>Sin Stock</option>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-outline-primary me-2">
                                <i class="fas fa-search"></i> Buscar
                            </button>
                            <a href="{{ route('inventarios.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i>
                            </a>
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
                                        <th>Código</th>
                                        <th>Categoría</th>
                                        <th>Stock Actual</th>
                                        <th>Stock Mínimo</th>
                                        <th>Estado</th>
                                        <th>Última Actualización</th>
                                        <th width="200">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($inventarios as $inventario)
                                        <tr>
                                            <td>
                                                <div class="fw-bold">{{ $inventario->producto->nombre ?? $inventario->nombre ?? 'N/A' }}</div>
                                                @if(isset($inventario->producto->descripcion))
                                                    <small class="text-muted">{{ Str::limit($inventario->producto->descripcion, 40) }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                @if(isset($inventario->producto->codigo))
                                                    <span class="badge bg-info">{{ $inventario->producto->codigo }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if(isset($inventario->producto->categoria->nombre))
                                                    <span class="badge bg-secondary">{{ $inventario->producto->categoria->nombre }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $stock = $inventario->stock_actual ?? $inventario->cantidad ?? 0;
                                                    $stockMinimo = $inventario->producto->stock_minimo ?? 10;
                                                    $stockClass = $stock > $stockMinimo ? 'text-success' : ($stock > 0 ? 'text-warning' : 'text-danger');
                                                @endphp
                                                <span class="{{ $stockClass }} fw-bold fs-5">{{ $stock }}</span>
                                                @if(isset($inventario->unidad) || isset($inventario->producto->unidad))
                                                    <small class="text-muted">{{ $inventario->unidad ?? $inventario->producto->unidad ?? 'unid' }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="text-muted">{{ $inventario->producto->stock_minimo ?? 10 }}</span>
                                            </td>
                                            <td>
                                                @php
                                                    $stock = $inventario->stock_actual ?? $inventario->cantidad ?? 0;
                                                    $stockMinimo = $inventario->producto->stock_minimo ?? 10;

                                                    if ($stock == 0) {
                                                        $badge = 'bg-danger';
                                                        $texto = 'Sin Stock';
                                                    } elseif ($stock <= $stockMinimo) {
                                                        $badge = 'bg-warning';
                                                        $texto = 'Stock Bajo';
                                                    } else {
                                                        $badge = 'bg-success';
                                                        $texto = 'Disponible';
                                                    }
                                                @endphp
                                                <span class="badge {{ $badge }}">{{ $texto }}</span>
                                            </td>
                                            <td>
                                                @if($inventario->updated_at)
                                                    <small>{{ $inventario->updated_at->format('d/m/Y H:i') }}</small>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('inventarios.show', $inventario) }}"
                                                       class="btn btn-sm btn-outline-info"
                                                       title="Ver movimientos">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('inventarios.edit', $inventario) }}"
                                                       class="btn btn-sm btn-outline-warning"
                                                       title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button"
                                                            class="btn btn-sm btn-outline-success"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#entradaModal{{ $inventario->id }}"
                                                            title="Entrada">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                    <button type="button"
                                                            class="btn btn-sm btn-outline-danger"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#salidaModal{{ $inventario->id }}"
                                                            title="Salida">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
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
                            <p class="text-muted mb-4">Comience agregando productos al inventario</p>
                            <a href="{{ route('inventarios.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i>
                                Agregar Primer Producto
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
