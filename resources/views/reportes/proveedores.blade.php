@extends('layouts.app')

@section('title', 'Reportes - Proveedores')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header con título y navegación -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">
                    <i class="fas fa-truck text-info me-2"></i>
                    Reporte de Proveedores
                </h2>
                <div class="btn-group" role="group">
                    <a href="{{ route('reportes.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>
                        Volver al Dashboard
                    </a>
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
                    <form method="GET" action="{{ route('reportes.proveedores') }}" class="row g-3">
                        <div class="col-md-8">
                            <label for="search" class="form-label">Buscar</label>
                            <input type="text"
                                   class="form-control"
                                   id="search"
                                   name="search"
                                   value="{{ request('search') }}"
                                   placeholder="Nombre, RUC o contacto del proveedor...">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label d-block">&nbsp;</label>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-1"></i>
                                Buscar
                            </button>
                            <a href="{{ route('reportes.proveedores') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-1"></i>
                                Limpiar
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabla de Proveedores -->
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-table me-2"></i>
                        Lista de Proveedores ({{ $proveedores->total() }} registros)
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>Proveedor</th>
                                    <th>RUC</th>
                                    <th>Contacto</th>
                                    <th>Dirección</th>
                                    <th>Total Pedidos</th>
                                    <th>Total Productos</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($proveedores as $proveedor)
                                    <tr>
                                        <td>
                                            <strong>{{ $proveedor->nombre }}</strong>
                                            @if($proveedor->email)
                                                <br>
                                                <small class="text-muted">
                                                    <i class="fas fa-envelope me-1"></i>
                                                    {{ $proveedor->email }}
                                                </small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($proveedor->ruc)
                                                <code>{{ $proveedor->ruc }}</code>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($proveedor->contacto)
                                                {{ $proveedor->contacto }}
                                                @if($proveedor->telefono)
                                                    <br>
                                                    <small class="text-muted">
                                                        <i class="fas fa-phone me-1"></i>
                                                        {{ $proveedor->telefono }}
                                                    </small>
                                                @endif
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($proveedor->direccion)
                                                <small>{{ Str::limit($proveedor->direccion, 50) }}</small>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-primary fs-6">
                                                {{ $proveedor->pedidos_count }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-success fs-6">
                                                {{ $proveedor->productos_count }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($proveedor->activo)
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check me-1"></i>
                                                    Activo
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">
                                                    <i class="fas fa-pause me-1"></i>
                                                    Inactivo
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">
                                            <i class="fas fa-search fa-2x mb-2"></i>
                                            <br>
                                            No se encontraron proveedores con los filtros aplicados
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($proveedores->hasPages())
                    <div class="card-footer">
                        {{ $proveedores->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
