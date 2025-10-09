@extends('layouts.app')

@section('title', 'Reportes - Inventario')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header con título y navegación -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">
                    <i class="fas fa-boxes text-success me-2"></i>
                    Reporte de Inventario
                </h2>
                <div class="btn-group" role="group">
                    <a href="{{ route('reportes.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>
                        Volver al Dashboard
                    </a>
                    <a href="{{ route('reportes.inventario.excel') }}" class="btn btn-success">
                        <i class="fas fa-file-excel me-1"></i>
                        Excel
                    </a>
                    <a href="{{ route('reportes.inventario.pdf') }}" class="btn btn-danger">
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

            <!-- Estadísticas de Inventario -->
            <div class="row mb-4">
                <div class="col-md-3 col-sm-6">
                    <div class="card text-center bg-primary text-white shadow-sm">
                        <div class="card-body">
                            <i class="fas fa-boxes fa-2x mb-2"></i>
                            <h4 class="mb-0">{{ number_format($inventarioStats['total_productos']) }}</h4>
                            <small>Total Productos</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="card text-center bg-danger text-white shadow-sm">
                        <div class="card-body">
                            <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                            <h4 class="mb-0">{{ number_format($inventarioStats['productos_sin_stock']) }}</h4>
                            <small>Sin Stock</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="card text-center bg-warning text-white shadow-sm">
                        <div class="card-body">
                            <i class="fas fa-exclamation-circle fa-2x mb-2"></i>
                            <h4 class="mb-0">{{ number_format($inventarioStats['productos_stock_bajo']) }}</h4>
                            <small>Stock Bajo</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="card text-center bg-success text-white shadow-sm">
                        <div class="card-body">
                            <i class="fas fa-dollar-sign fa-2x mb-2"></i>
                            <h4 class="mb-0">S/ {{ number_format($inventarioStats['valor_total_inventario'], 2) }}</h4>
                            <small>Valor Total</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filtros -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-filter me-2"></i>
                        Filtros de Búsqueda
                    </h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('reportes.inventario') }}" class="row g-3">
                        <div class="col-md-4">
                            <label for="categoria" class="form-label">Categoría</label>
                            <select class="form-select" id="categoria" name="categoria">
                                <option value="">Todas las categorías</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria }}"
                                            {{ request('categoria') == $categoria ? 'selected' : '' }}>
                                        {{ $categoria }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="stock_minimo" class="form-label">Stock Menor o Igual a</label>
                            <input type="number"
                                   class="form-control"
                                   id="stock_minimo"
                                   name="stock_minimo"
                                   value="{{ request('stock_minimo') }}"
                                   placeholder="Ej: 10"
                                   min="0">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label d-block">&nbsp;</label>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-1"></i>
                                Buscar
                            </button>
                            <a href="{{ route('reportes.inventario') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-1"></i>
                                Limpiar
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabla de Productos -->
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-table me-2"></i>
                        Inventario de Productos ({{ $productos->total() }} registros)
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>Código</th>
                                    <th>Producto</th>
                                    <th>Categoría</th>
                                    <th>Stock Actual</th>
                                    <th>Unidad</th>
                                    <th>Precio Unitario</th>
                                    <th>Valor Total</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($productos as $producto)
                                    <tr>
                                        <td>
                                            <code>{{ $producto->codigo ?? 'N/A' }}</code>
                                        </td>
                                        <td>
                                            <strong>{{ $producto->nombre }}</strong>
                                            @if($producto->descripcion)
                                                <br>
                                                <small class="text-muted">{{ Str::limit($producto->descripcion, 50) }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">{{ $producto->categoria->nombre ?? 'Sin categoría' }}</span>
                                        </td>
                                        <td>
                                            <span class="badge fs-6
                                                @if($producto->stock_actual == 0) bg-danger
                                                @elseif($producto->stock_actual < 10) bg-warning
                                                @else bg-success
                                                @endif">
                                                {{ number_format($producto->stock_actual, 2) }}
                                            </span>
                                        </td>
                                        <td>{{ $producto->unidad_medida }}</td>
                                        <td>S/ {{ number_format($producto->precio_unitario, 2) }}</td>
                                        <td>
                                            <strong>S/ {{ number_format($producto->stock_actual * $producto->precio_unitario, 2) }}</strong>
                                        </td>
                                        <td>
                                            @if($producto->stock_actual == 0)
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-times me-1"></i>
                                                    Sin Stock
                                                </span>
                                            @elseif($producto->stock_actual < 10)
                                                <span class="badge bg-warning">
                                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                                    Stock Bajo
                                                </span>
                                            @else
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check me-1"></i>
                                                    Disponible
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4 text-muted">
                                            <i class="fas fa-search fa-2x mb-2"></i>
                                            <br>
                                            No se encontraron productos con los filtros aplicados
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($productos->hasPages())
                    <div class="card-footer">
                        {{ $productos->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
