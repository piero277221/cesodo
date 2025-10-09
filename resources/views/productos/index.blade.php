@extends('layouts.app')

@section('title', 'Productos')

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
                                <div class="icon-shape me-3" style="background: var(--primary-color);">
                                    <i class="fas fa-box"></i>
                                </div>
                                <div>
                                    <h1 class="h3 mb-1 text-primary">Gestión de Productos</h1>
                                    <p class="text-muted mb-0">Administra el inventario y catálogo de productos</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('productos.create') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-plus me-2"></i>
                                Nuevo Producto
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Estadísticas rápidas -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-modern h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape" style="background: var(--success-color);">
                            <i class="fas fa-box-open"></i>
                        </div>
                        <div class="ms-3">
                            <div class="text-muted small">Productos Activos</div>
                            <div class="h4 mb-0 text-success">{{ $estadisticas['activos'] ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-modern h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape" style="background: var(--warning-color);">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="ms-3">
                            <div class="text-muted small">Stock Bajo</div>
                            <div class="h4 mb-0 text-warning">{{ $estadisticas['stock_bajo'] ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-modern h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape" style="background: var(--info-color);">
                            <i class="fas fa-tags"></i>
                        </div>
                        <div class="ms-3">
                            <div class="text-muted small">Categorías</div>
                            <div class="h4 mb-0 text-info">{{ $estadisticas['categorias'] ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-modern h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape" style="background: var(--primary-color);">
                            <i class="fas fa-boxes"></i>
                        </div>
                        <div class="ms-3">
                            <div class="text-muted small">Total Productos</div>
                            <div class="h4 mb-0">{{ count($productos) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mensajes de estado -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filtros de búsqueda modernos -->
    <div class="card border-0 shadow-modern mb-4">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-filter me-2"></i>
                Filtros de Búsqueda
            </h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('productos.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">Buscar</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text"
                               class="form-control"
                               id="search"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Código, nombre, descripción...">
                    </div>
                </div>

                        <div class="col-md-3">
                            <label for="categoria_id" class="form-label">Categoría</label>
                            <select class="form-select" id="categoria_id" name="categoria_id">
                                <option value="">Todas las categorías</option>
                                @if(isset($categorias) && $categorias->count() > 0)
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id }}"
                                                {{ request('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                            {{ $categoria->nombre }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label for="estado" class="form-label">Estado</label>
                            <select class="form-select" id="estado" name="estado">
                                <option value="">Todos</option>
                                <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                                <option value="inactivo" {{ request('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label for="stock_estado" class="form-label">Stock</label>
                            <select class="form-select" id="stock_estado" name="stock_estado">
                                <option value="">Todos</option>
                                <option value="bajo" {{ request('stock_estado') == 'bajo' ? 'selected' : '' }}>Stock Bajo</option>
                                <option value="alto" {{ request('stock_estado') == 'alto' ? 'selected' : '' }}>Stock Normal</option>
                            </select>
                        </div>

                        <div class="col-md-1">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Estadísticas rápidas -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card bg-primary text-white shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Total Productos</h6>
                                    <h3 class="mb-0">
                                        @if(isset($productos) && is_object($productos) && method_exists($productos, 'total'))
                                            {{ $productos->total() }}
                                        @else
                                            0
                                        @endif
                                    </h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-box fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card bg-success text-white shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Productos Activos</h6>
                                    <h3 class="mb-0">{{ $estadisticas['activos'] ?? 0 }}</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-check-circle fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card bg-warning text-white shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Stock Bajo</h6>
                                    <h3 class="mb-0">{{ $estadisticas['stock_bajo'] ?? 0 }}</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-exclamation-triangle fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card bg-info text-white shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Categorías</h6>
                                    <h3 class="mb-0">{{ $estadisticas['categorias'] ?? 0 }}</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-tags fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de productos -->
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2"></i>
                        Lista de Productos
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if(isset($productos) && ((is_object($productos) && $productos->count() > 0) || (is_array($productos) && count($productos) > 0)))
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="10%">Código</th>
                                        <th width="25%">Producto</th>
                                        <th width="15%">Categoría</th>
                                        <th width="10%">Precio</th>
                                        <th width="10%">Stock</th>
                                        <th width="10%">Estado</th>
                                        <th width="15%">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($productos as $index => $producto)
                                        <tr>
                                            <td>
                                                @if(is_object($productos) && method_exists($productos, 'firstItem'))
                                                    {{ $productos->firstItem() + $index }}
                                                @else
                                                    {{ $index + 1 }}
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">{{ $producto->codigo }}</span>
                                            </td>
                                            <td>
                                                <div>
                                                    <strong>{{ $producto->nombre }}</strong>
                                                    @if($producto->descripcion)
                                                        <br>
                                                        <small class="text-muted">{{ Str::limit($producto->descripcion, 50) }}</small>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                @if($producto->categoria)
                                                    <span class="badge bg-info">{{ $producto->categoria->nombre }}</span>
                                                @else
                                                    <span class="text-muted">Sin categoría</span>
                                                @endif
                                            </td>
                                            <td>
                                                <strong>S/ {{ number_format($producto->precio_unitario, 2) }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $producto->unidad_medida }}</small>
                                            </td>
                                            <td>
                                                @php
                                                    $stock = $producto->inventario->stock_disponible ?? 0;
                                                    $stockMinimo = $producto->stock_minimo;
                                                    $stockClass = $stock <= $stockMinimo ? 'text-danger' : 'text-success';
                                                @endphp
                                                <span class="{{ $stockClass }}">
                                                    <strong>{{ $stock }}</strong>
                                                </span>
                                                <br>
                                                <small class="text-muted">Mín: {{ $stockMinimo }}</small>
                                            </td>
                                            <td>
                                                @if($producto->estado == 'activo')
                                                    <span class="badge bg-success">Activo</span>
                                                @else
                                                    <span class="badge bg-danger">Inactivo</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('productos.show', $producto) }}"
                                                       class="btn btn-sm btn-outline-info"
                                                       title="Ver detalles">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('productos.edit', $producto) }}"
                                                       class="btn btn-sm btn-outline-warning"
                                                       title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form method="POST"
                                                          action="{{ route('productos.destroy', $producto) }}"
                                                          style="display: inline;"
                                                          onsubmit="return confirm('¿Está seguro de eliminar este producto?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="btn btn-sm btn-outline-danger"
                                                                title="Eliminar">
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
                        @if(isset($productos) && is_object($productos) && method_exists($productos, 'hasPages') && $productos->hasPages())
                            <div class="card-footer">
                                {{ $productos->withQueryString()->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-box fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">No se encontraron productos</h5>
                            <p class="text-muted">No hay productos registrados o no coinciden con los filtros aplicados.</p>
                            <a href="{{ route('productos.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i>
                                Crear primer producto
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit del formulario de filtros cuando cambian los selects
    const filterSelects = document.querySelectorAll('#categoria_id, #estado, #stock_estado');
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            this.closest('form').submit();
        });
    });

    // Limpiar búsqueda
    const searchInput = document.getElementById('search');
    if (searchInput) {
        const clearButton = document.createElement('button');
        clearButton.type = 'button';
        clearButton.className = 'btn btn-outline-secondary btn-sm ms-2';
        clearButton.innerHTML = '<i class="fas fa-times"></i>';
        clearButton.onclick = function() {
            searchInput.value = '';
            searchInput.closest('form').submit();
        };

        if (searchInput.value) {
            searchInput.parentNode.appendChild(clearButton);
        }
    }
});
</script>
@endpush
@endsection
