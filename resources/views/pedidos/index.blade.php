@extends('layouts.app')

@section('title', 'Pedidos')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header con título y botón -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">
                    <i class="fas fa-shopping-cart text-primary me-2"></i>
                    Gestión de Pedidos
                </h2>
                <a href="{{ route('pedidos.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>
                    Nuevo Pedido
                </a>
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

            <!-- Filtros de búsqueda -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('pedidos.index') }}" class="row g-3">
                        <div class="col-md-4">
                            <label for="search" class="form-label">Buscar</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="search" 
                                   name="search" 
                                   value="{{ request('search') }}" 
                                   placeholder="Número de pedido, proveedor...">
                        </div>

                        <div class="col-md-3">
                            <label for="proveedor_id" class="form-label">Proveedor</label>
                            <select class="form-select" id="proveedor_id" name="proveedor_id">
                                <option value="">Todos los proveedores</option>
                                @if(isset($proveedores))
                                    @foreach($proveedores as $proveedor)
                                        <option value="{{ $proveedor->id }}" 
                                                {{ request('proveedor_id') == $proveedor->id ? 'selected' : '' }}>
                                            {{ $proveedor->razon_social }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="estado" class="form-label">Estado</label>
                            <select class="form-select" id="estado" name="estado">
                                <option value="">Todos</option>
                                <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="confirmado" {{ request('estado') == 'confirmado' ? 'selected' : '' }}>Confirmado</option>
                                <option value="entregado" {{ request('estado') == 'entregado' ? 'selected' : '' }}>Entregado</option>
                                <option value="cancelado" {{ request('estado') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="fas fa-search"></i> Buscar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Estadísticas rápidas -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card bg-warning text-white shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Pendientes</h6>
                                    <h3 class="mb-0">{{ $estadisticas['pendientes'] ?? 0 }}</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-clock fa-2x"></i>
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
                                    <h6 class="card-title">Confirmados</h6>
                                    <h3 class="mb-0">{{ $estadisticas['confirmados'] ?? 0 }}</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-check fa-2x"></i>
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
                                    <h6 class="card-title">Entregados</h6>
                                    <h3 class="mb-0">{{ $estadisticas['entregados'] ?? 0 }}</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-truck fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card bg-primary text-white shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Total Mes</h6>
                                    <h3 class="mb-0">S/ {{ number_format($estadisticas['total_mes'] ?? 0, 2) }}</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-dollar-sign fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de pedidos -->
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2"></i>
                        Lista de Pedidos
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if(isset($pedidos) && ((is_object($pedidos) && $pedidos->count() > 0) || (is_array($pedidos) && count($pedidos) > 0)))
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="15%">Número</th>
                                        <th width="25%">Proveedor</th>
                                        <th width="15%">Fecha Pedido</th>
                                        <th width="15%">Entrega Esperada</th>
                                        <th width="10%">Total</th>
                                        <th width="10%">Estado</th>
                                        <th width="15%">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pedidos as $index => $pedido)
                                        <tr>
                                            <td>
                                                @if(is_object($pedidos) && method_exists($pedidos, 'firstItem'))
                                                    {{ $pedidos->firstItem() + $index }}
                                                @else
                                                    {{ $index + 1 }}
                                                @endif
                                            </td>
                                            <td>
                                                <strong>{{ $pedido->numero_pedido }}</strong>
                                            </td>
                                            <td>
                                                @if($pedido->proveedor)
                                                    <div>
                                                        <strong>{{ $pedido->proveedor->razon_social }}</strong>
                                                        @if($pedido->proveedor->nombre_comercial)
                                                            <br><small class="text-muted">{{ $pedido->proveedor->nombre_comercial }}</small>
                                                        @endif
                                                    </div>
                                                @else
                                                    <span class="text-muted">Sin proveedor</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $pedido->fecha_pedido ? $pedido->fecha_pedido->format('d/m/Y') : '-' }}
                                            </td>
                                            <td>
                                                {{ $pedido->fecha_entrega_esperada ? $pedido->fecha_entrega_esperada->format('d/m/Y') : '-' }}
                                                @if($pedido->fecha_entrega_esperada && $pedido->fecha_entrega_esperada->isPast() && $pedido->estado !== 'entregado')
                                                    <br><small class="text-danger"><i class="fas fa-exclamation-triangle"></i> Retrasado</small>
                                                @endif
                                            </td>
                                            <td>
                                                <strong>S/ {{ number_format($pedido->total, 2) }}</strong>
                                            </td>
                                            <td>
                                                @switch($pedido->estado)
                                                    @case('pendiente')
                                                        <span class="badge bg-warning">Pendiente</span>
                                                        @break
                                                    @case('confirmado')
                                                        <span class="badge bg-info">Confirmado</span>
                                                        @break
                                                    @case('entregado')
                                                        <span class="badge bg-success">Entregado</span>
                                                        @break
                                                    @case('cancelado')
                                                        <span class="badge bg-danger">Cancelado</span>
                                                        @break
                                                    @default
                                                        <span class="badge bg-secondary">{{ ucfirst($pedido->estado) }}</span>
                                                @endswitch
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('pedidos.show', $pedido) }}" 
                                                       class="btn btn-sm btn-outline-info" 
                                                       title="Ver detalles">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    
                                                    @if($pedido->estado == 'pendiente')
                                                        <a href="{{ route('pedidos.edit', $pedido) }}" 
                                                           class="btn btn-sm btn-outline-warning" 
                                                           title="Editar">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        
                                                        <form method="POST" 
                                                              action="{{ route('pedidos.confirmar', $pedido) }}" 
                                                              style="display: inline;"
                                                              onsubmit="return confirm('¿Confirmar este pedido?')">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" 
                                                                    class="btn btn-sm btn-outline-success" 
                                                                    title="Confirmar">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                    
                                                    @if($pedido->estado == 'confirmado')
                                                        <form method="POST" 
                                                              action="{{ route('pedidos.entregar', $pedido) }}" 
                                                              style="display: inline;"
                                                              onsubmit="return confirm('¿Marcar como entregado?')">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" 
                                                                    class="btn btn-sm btn-outline-primary" 
                                                                    title="Entregar">
                                                                <i class="fas fa-truck"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                    
                                                    @if($pedido->estado == 'pendiente')
                                                        <form method="POST" 
                                                              action="{{ route('pedidos.destroy', $pedido) }}" 
                                                              style="display: inline;"
                                                              onsubmit="return confirm('¿Está seguro de eliminar este pedido?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" 
                                                                    class="btn btn-sm btn-outline-danger" 
                                                                    title="Eliminar">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        @if(isset($pedidos) && is_object($pedidos) && method_exists($pedidos, 'hasPages') && $pedidos->hasPages())
                            <div class="card-footer">
                                {{ $pedidos->withQueryString()->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">No se encontraron pedidos</h5>
                            <p class="text-muted">No hay pedidos registrados o no coinciden con los filtros aplicados.</p>
                            <a href="{{ route('pedidos.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i>
                                Crear primer pedido
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
    const filterSelects = document.querySelectorAll('#proveedor_id, #estado');
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            this.closest('form').submit();
        });
    });
});
</script>
@endpush
@endsection
