<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Inventarios
        </h2>
    </x-slot>

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<style>
    .filter-card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .table-responsive {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }
    .btn-floating {
        border-radius: 50px;
        padding: 0.5rem 1.5rem;
    }
    .animate-fade-in {
        animation: fadeIn 0.5s ease-in;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

<div class="container-fluid my-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('inventarios.index') }}">Inventario</a></li>
                    <li class="breadcrumb-item active">Movimientos</li>
                </ol>
            </nav>
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1">
                        <i class="fas fa-history text-primary me-2"></i>
                        Movimientos de Inventario
                    </h1>
                    <p class="text-muted mb-0">{{ $inventario->producto->nombre }}</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('inventarios.show', $inventario) }}" class="btn btn-info btn-floating">
                        <i class="fas fa-eye me-2"></i>Ver Detalle
                    </a>
                    <a href="{{ route('inventarios.index') }}" class="btn btn-outline-secondary btn-floating">
                        <i class="fas fa-arrow-left me-2"></i>Volver
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Información del Producto -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center">
                                <div class="avatar-lg bg-primary rounded-circle d-flex align-items-center justify-content-center me-3">
                                    <i class="fas fa-box fa-2x text-white"></i>
                                </div>
                                <div>
                                    <h4 class="mb-1">{{ $inventario->producto->nombre }}</h4>
                                    <div class="d-flex gap-3">
                                        <span class="badge bg-secondary">{{ $inventario->producto->codigo }}</span>
                                        <span class="badge bg-info">{{ $inventario->producto->categoria->nombre ?? 'Sin categoría' }}</span>
                                        <span class="text-muted">{{ $inventario->producto->unidad_medida }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row text-center">
                                <div class="col-4">
                                    <div class="text-muted small">Stock Actual</div>
                                    <div class="h5 mb-0">{{ number_format($inventario->stock_actual, 2) }}</div>
                                </div>
                                <div class="col-4">
                                    <div class="text-muted small">Disponible</div>
                                    <div class="h5 mb-0 text-success">{{ number_format($inventario->stock_disponible, 2) }}</div>
                                </div>
                                <div class="col-4">
                                    <div class="text-muted small">Reservado</div>
                                    <div class="h5 mb-0 text-warning">{{ number_format($inventario->stock_reservado, 2) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Movimientos -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2"></i>Historial de Movimientos
                    </h5>
                    <span class="badge bg-primary">{{ $movimientos->total() }} movimientos</span>
                </div>
                <div class="card-body p-0">
                    @if($movimientos->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Fecha/Hora</th>
                                        <th>Tipo</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                        <th>Total</th>
                                        <th>Motivo</th>
                                        <th>Documento</th>
                                        <th>Usuario</th>
                                        <th>Observaciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($movimientos as $movimiento)
                                        <tr>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <span class="fw-bold">{{ $movimiento->created_at->format('d/m/Y') }}</span>
                                                    <small class="text-muted">{{ $movimiento->created_at->format('H:i:s') }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                @if($movimiento->tipo_movimiento == 'entrada')
                                                    <span class="badge bg-success px-3 py-2">
                                                        <i class="fas fa-plus me-1"></i>Entrada
                                                    </span>
                                                @else
                                                    <span class="badge bg-primary px-3 py-2">
                                                        <i class="fas fa-minus me-1"></i>Salida
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="fw-bold {{ $movimiento->tipo_movimiento == 'entrada' ? 'text-success' : 'text-primary' }}">
                                                    {{ $movimiento->tipo_movimiento == 'entrada' ? '+' : '-' }}{{ number_format($movimiento->cantidad, 2) }}
                                                </span>
                                                <small class="d-block text-muted">{{ $inventario->producto->unidad_medida }}</small>
                                            </td>
                                            <td>
                                                @if($movimiento->precio_unitario)
                                                    <span class="fw-bold">S/. {{ number_format($movimiento->precio_unitario, 2) }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($movimiento->precio_total)
                                                    <span class="fw-bold text-success">S/. {{ number_format($movimiento->precio_total, 2) }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $motivoClass = [
                                                        'compra' => 'bg-success',
                                                        'venta' => 'bg-primary',
                                                        'devolucion' => 'bg-info',
                                                        'merma' => 'bg-warning',
                                                        'vencimiento' => 'bg-danger',
                                                        'ajuste_inventario' => 'bg-secondary',
                                                        'stock_inicial' => 'bg-dark',
                                                        'consumo_interno' => 'bg-warning',
                                                        'produccion' => 'bg-success'
                                                    ];
                                                    $badgeClass = $motivoClass[$movimiento->motivo] ?? 'bg-secondary';
                                                @endphp
                                                <span class="badge {{ $badgeClass }}">
                                                    {{ ucfirst(str_replace('_', ' ', $movimiento->motivo)) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($movimiento->documento_referencia)
                                                    <span class="badge bg-light text-dark">{{ $movimiento->documento_referencia }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm bg-secondary rounded-circle d-flex align-items-center justify-content-center me-2">
                                                        <i class="fas fa-user text-white"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold">{{ $movimiento->user->name }}</div>
                                                        <small class="text-muted">{{ $movimiento->user->email }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if($movimiento->observaciones)
                                                    <span class="text-truncate d-inline-block" style="max-width: 200px;"
                                                          title="{{ $movimiento->observaciones }}">
                                                        {{ $movimiento->observaciones }}
                                                    </span>
                                                @else
                                                    <span class="text-muted fst-italic">Sin observaciones</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        <div class="card-footer bg-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted">
                                        Mostrando {{ $movimientos->firstItem() }} a {{ $movimientos->lastItem() }}
                                        de {{ $movimientos->total() }} movimientos
                                    </small>
                                </div>
                                <div>
                                    {{ $movimientos->links() }}
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-history fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No hay movimientos registrados</h5>
                            <p class="text-muted mb-4">Los movimientos del producto aparecerán aquí</p>
                            <a href="{{ route('inventarios.show', $inventario) }}" class="btn btn-primary">
                                <i class="fas fa-eye me-2"></i>Ver Detalle del Producto
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>