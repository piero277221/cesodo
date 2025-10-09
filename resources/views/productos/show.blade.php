@extends('layouts.app')

@section('title', 'Detalles del Producto')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">
                    <i class="fas fa-box text-info me-2"></i>
                    Detalles del Producto
                </h2>
                <div>
                    @if(isset($producto))
                    <a href="{{ route('productos.edit', $producto) }}" class="btn btn-warning me-2">
                        <i class="fas fa-edit me-1"></i>
                        Editar
                    </a>
                    @endif
                    <a href="{{ route('productos.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>
                        Volver al Listado
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(isset($producto))
            <div class="row">
                <!-- Información Principal -->
                <div class="col-lg-8 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-info-circle me-2"></i>
                                Información General
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td class="fw-bold text-muted">Código:</td>
                                            <td>
                                                <span class="badge bg-primary">{{ $producto->codigo }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold text-muted">Nombre:</td>
                                            <td class="fw-bold">{{ $producto->nombre }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold text-muted">Categoría:</td>
                                            <td>
                                                @if($producto->categoria)
                                                    <span class="badge bg-secondary">{{ $producto->categoria->nombre }}</span>
                                                @else
                                                    <span class="text-muted">Sin categoría</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold text-muted">Unidad de Medida:</td>
                                            <td>
                                                <span class="badge bg-success">{{ strtoupper($producto->unidad_medida) }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold text-muted">Estado:</td>
                                            <td>
                                                @if($producto->activo)
                                                    <span class="badge bg-success">Activo</span>
                                                @else
                                                    <span class="badge bg-danger">Inactivo</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold text-muted">Perecedero:</td>
                                            <td>
                                                @if($producto->es_perecedero)
                                                    <span class="badge bg-warning">Sí</span>
                                                @else
                                                    <span class="badge bg-secondary">No</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td class="fw-bold text-muted">Precio Unitario:</td>
                                            <td class="fw-bold text-success">S/ {{ number_format($producto->precio_unitario, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold text-muted">Stock Mínimo:</td>
                                            <td>{{ $producto->stock_minimo ?? 'No definido' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold text-muted">Stock Máximo:</td>
                                            <td>{{ $producto->stock_maximo ?? 'No definido' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold text-muted">Fecha Creación:</td>
                                            <td>{{ $producto->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold text-muted">Última Actualización:</td>
                                            <td>{{ $producto->updated_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            @if($producto->descripcion)
                            <div class="mt-4">
                                <h6 class="fw-bold text-muted">Descripción:</h6>
                                <div class="p-3 bg-light rounded">
                                    {{ $producto->descripcion }}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Panel de Control Rápido -->
                <div class="col-lg-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0">
                                <i class="fas fa-cogs me-2"></i>
                                Acciones Rápidas
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('productos.edit', $producto) }}" class="btn btn-warning">
                                    <i class="fas fa-edit me-2"></i>
                                    Editar Producto
                                </a>

                                @if($producto->inventarios->count() > 0)
                                <a href="{{ route('inventarios.index', ['producto' => $producto->id]) }}" class="btn btn-info">
                                    <i class="fas fa-warehouse me-2"></i>
                                    Ver en Inventario
                                </a>
                                @endif

                                <button class="btn btn-success" onclick="window.print()">
                                    <i class="fas fa-print me-2"></i>
                                    Imprimir Detalles
                                </button>

                                <button class="btn btn-danger" onclick="confirmarEliminacion()">
                                    <i class="fas fa-trash me-2"></i>
                                    Eliminar Producto
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Estado de Stock -->
                    @if($producto->inventarios->count() > 0)
                    <div class="card shadow-sm mt-4">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-warehouse me-2"></i>
                                Estado de Inventario
                            </h5>
                        </div>
                        <div class="card-body">
                            @foreach($producto->inventarios as $inventario)
                            <div class="text-center mb-3">
                                <h3 class="text-primary mb-1">{{ $inventario->cantidad_disponible }}</h3>
                                <p class="text-muted mb-1">{{ $producto->unidad_medida }} disponibles</p>

                                @if($producto->stock_minimo && $inventario->cantidad_disponible <= $producto->stock_minimo)
                                    <div class="alert alert-warning mb-0" role="alert">
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        Stock bajo
                                    </div>
                                @elseif($producto->stock_maximo && $inventario->cantidad_disponible >= $producto->stock_maximo)
                                    <div class="alert alert-info mb-0" role="alert">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Stock alto
                                    </div>
                                @else
                                    <div class="alert alert-success mb-0" role="alert">
                                        <i class="fas fa-check-circle me-1"></i>
                                        Stock normal
                                    </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @else
                    <div class="card shadow-sm mt-4">
                        <div class="card-body text-center">
                            <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                            <h6 class="text-muted">Sin stock en inventario</h6>
                            <a href="{{ route('inventarios.create', ['producto' => $producto->id]) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus me-1"></i>
                                Agregar al Inventario
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Historial de Movimientos -->
            @if($producto->inventarios->count() > 0)
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-history me-2"></i>
                        Últimos Movimientos
                    </h5>
                </div>
                <div class="card-body">
                    @php
                        $movimientos = collect();
                        foreach($producto->inventarios as $inventario) {
                            $movimientos = $movimientos->merge($inventario->movimientos ?? collect());
                        }
                        $movimientos = $movimientos->sortByDesc('created_at')->take(10);
                    @endphp

                    @if($movimientos->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Tipo</th>
                                        <th>Cantidad</th>
                                        <th>Motivo</th>
                                        <th>Usuario</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($movimientos as $movimiento)
                                    <tr>
                                        <td>{{ $movimiento->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            @if($movimiento->tipo_movimiento == 'entrada')
                                                <span class="badge bg-success">Entrada</span>
                                            @elseif($movimiento->tipo_movimiento == 'salida')
                                                <span class="badge bg-danger">Salida</span>
                                            @else
                                                <span class="badge bg-info">{{ ucfirst($movimiento->tipo_movimiento) }}</span>
                                            @endif
                                        </td>
                                        <td class="fw-bold">{{ $movimiento->cantidad }} {{ $producto->unidad_medida }}</td>
                                        <td>{{ $movimiento->motivo ?? 'Sin especificar' }}</td>
                                        <td>{{ $movimiento->user->name ?? 'Sistema' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No hay movimientos registrados para este producto.</p>
                        </div>
                    @endif
                </div>
            </div>
            @endif

            @else
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle me-2"></i>
                No se encontró el producto solicitado.
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal de confirmación de eliminación -->
<div class="modal fade" id="modalEliminar" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Confirmar Eliminación
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro de que desea eliminar este producto?</p>
                @if(isset($producto))
                <div class="alert alert-warning">
                    <strong>Producto:</strong> {{ $producto->nombre }}<br>
                    <strong>Código:</strong> {{ $producto->codigo }}
                </div>
                @endif
                <p class="text-danger"><strong>Esta acción no se puede deshacer.</strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                @if(isset($producto))
                <form action="{{ route('productos.destroy', $producto) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i>
                        Eliminar Definitivamente
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function confirmarEliminacion() {
    const modal = new bootstrap.Modal(document.getElementById('modalEliminar'));
    modal.show();
}

// Print styles
window.addEventListener('beforeprint', function() {
    document.body.classList.add('printing');
});

window.addEventListener('afterprint', function() {
    document.body.classList.remove('printing');
});
</script>

<style>
@media print {
    .btn, .card-header, nav, footer, .modal {
        display: none !important;
    }

    .card {
        border: 1px solid #ddd !important;
        box-shadow: none !important;
    }

    .container-fluid {
        padding: 0 !important;
    }

    h2 {
        color: #000 !important;
    }
}
</style>
@endpush
@endsection
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
