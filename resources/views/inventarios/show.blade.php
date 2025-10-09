<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Inventarios
        </h2>
    </x-slot>

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<style>
    .detail-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 0 30px rgba(0,0,0,0.1);
    }
    .detail-header {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        border-radius: 15px 15px 0 0;
    }
    .btn-floating {
        border-radius: 50px;
        padding: 0.6rem 2rem;
    }
    .icon-circle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 20px;
    }
    .info-item {
        border-left: 4px solid #007bff;
        padding-left: 1rem;
        margin-bottom: 1rem;
    }
    .stock-metric {
        text-align: center;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 10px;
        margin-bottom: 1rem;
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
                    <li class="breadcrumb-item active">Detalle</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card detail-card">
                <div class="card-header detail-header">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle bg-white bg-opacity-20">
                            <i class="fas fa-eye fa-2x"></i>
                        </div>
                        <div>
                            <h3 class="mb-1">Detalle del Inventario</h3>
                            <p class="mb-0 opacity-75">Información completa del producto en inventario</p>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <!-- Información del Producto -->
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">
                                        <i class="fas fa-box me-2"></i>Información del Producto
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="info-item">
                                        <strong>Nombre:</strong><br>
                                        <span class="h5">{{ $inventario->producto->nombre }}</span>
                                    </div>

                                    <div class="info-item">
                                        <strong>Código:</strong><br>
                                        <span class="badge bg-secondary fs-6">{{ $inventario->producto->codigo }}</span>
                                    </div>

                                    <div class="info-item">
                                        <strong>Categoría:</strong><br>
                                        <span class="badge bg-info fs-6">{{ $inventario->producto->categoria->nombre ?? 'Sin categoría' }}</span>
                                    </div>

                                    <div class="info-item">
                                        <strong>Descripción:</strong><br>
                                        {{ $inventario->producto->descripcion ?? 'Sin descripción' }}
                                    </div>

                                    <div class="info-item">
                                        <strong>Unidad de Medida:</strong><br>
                                        {{ $inventario->producto->unidad_medida }}
                                    </div>

                                    <div class="info-item">
                                        <strong>Precio de Venta:</strong><br>
                                        <span class="h5 text-success">S/. {{ number_format($inventario->producto->precio_venta, 2) }}</span>
                                    </div>

                                    @if($inventario->producto->stock_minimo)
                                        <div class="info-item">
                                            <strong>Stock Mínimo:</strong><br>
                                            <span class="text-warning fw-bold">{{ number_format($inventario->producto->stock_minimo, 2) }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Información del Stock -->
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0">
                                        <i class="fas fa-cubes me-2"></i>Información del Stock
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="stock-metric">
                                                <i class="fas fa-boxes fa-2x text-primary mb-2"></i>
                                                <h4 class="mb-1">{{ number_format($inventario->stock_actual, 2) }}</h4>
                                                <small class="text-muted">Stock Actual</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="stock-metric">
                                                <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                                                <h4 class="mb-1">{{ number_format($inventario->stock_disponible, 2) }}</h4>
                                                <small class="text-muted">Stock Disponible</small>
                                            </div>
                                        </div>
                                        @if($inventario->stock_reservado > 0)
                                        <div class="col-md-6">
                                            <div class="stock-metric">
                                                <i class="fas fa-lock fa-2x text-warning mb-2"></i>
                                                <h4 class="mb-1">{{ number_format($inventario->stock_reservado, 2) }}</h4>
                                                <small class="text-muted">Stock Reservado</small>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="col-md-6">
                                            <div class="stock-metric">
                                                <i class="fas fa-dollar-sign fa-2x text-info mb-2"></i>
                                                <h4 class="mb-1">S/. {{ number_format($inventario->stock_disponible * $inventario->producto->precio_venta, 2) }}</h4>
                                                <small class="text-muted">Valor en Stock</small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Estado del Stock -->
                                    <div class="mt-3">
                                        @php
                                            if ($inventario->stock_disponible <= 0) {
                                                $statusClass = 'danger';
                                                $statusText = 'Agotado';
                                                $statusIcon = 'times-circle';
                                            } elseif ($inventario->producto->stock_minimo && $inventario->stock_disponible <= $inventario->producto->stock_minimo) {
                                                $statusClass = 'warning';
                                                $statusText = 'Stock Bajo';
                                                $statusIcon = 'exclamation-triangle';
                                            } else {
                                                $statusClass = 'success';
                                                $statusText = 'Stock Normal';
                                                $statusIcon = 'check-circle';
                                            }
                                        @endphp
                                        <div class="alert alert-{{ $statusClass }} text-center">
                                            <i class="fas fa-{{ $statusIcon }} fa-2x mb-2"></i>
                                            <h5 class="mb-0">{{ $statusText }}</h5>
                                        </div>
                                    </div>

                                    <!-- Información de Vencimiento -->
                                    @if($inventario->fecha_vencimiento)
                                        <div class="info-item">
                                            <strong>Fecha de Vencimiento:</strong><br>
                                            @php
                                                $diasVencimiento = now()->diffInDays($inventario->fecha_vencimiento, false);
                                                if ($diasVencimiento < 0) {
                                                    $vencimientoClass = 'danger';
                                                    $vencimientoText = 'Vencido (' . abs($diasVencimiento) . ' días)';
                                                } elseif ($diasVencimiento <= 30) {
                                                    $vencimientoClass = 'warning';
                                                    $vencimientoText = 'Vence en ' . $diasVencimiento . ' días';
                                                } else {
                                                    $vencimientoClass = 'success';
                                                    $vencimientoText = 'Vence en ' . $diasVencimiento . ' días';
                                                }
                                            @endphp
                                            <span class="badge bg-{{ $vencimientoClass }} fs-6">
                                                {{ $inventario->fecha_vencimiento->format('d/m/Y') }}
                                            </span>
                                            <br><small class="text-{{ $vencimientoClass }}">{{ $vencimientoText }}</small>
                                        </div>
                                    @endif

                                    @if($inventario->lote)
                                        <div class="info-item">
                                            <strong>Lote:</strong><br>
                                            <span class="badge bg-secondary">{{ $inventario->lote }}</span>
                                        </div>
                                    @endif

                                    <div class="info-item">
                                        <strong>Última Actualización:</strong><br>
                                        <i class="fas fa-clock me-2"></i>
                                        {{ $inventario->fecha_ultimo_movimiento?->format('d/m/Y H:i') ?? 'Sin registro' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Últimos Movimientos -->
                    @if($movimientos->count() > 0)
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card bg-light">
                                <div class="card-header bg-secondary text-white">
                                    <h5 class="mb-0">
                                        <i class="fas fa-history me-2"></i>Últimos Movimientos
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-sm">
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
                                                                <span class="badge bg-success">
                                                                    <i class="fas fa-plus me-1"></i>Entrada
                                                                </span>
                                                            @else
                                                                <span class="badge bg-primary">
                                                                    <i class="fas fa-minus me-1"></i>Salida
                                                                </span>
                                                            @endif
                                                        </td>
                                                        <td>{{ number_format($movimiento->cantidad, 2) }}</td>
                                                        <td>{{ ucfirst(str_replace('_', ' ', $movimiento->motivo)) }}</td>
                                                        <td>{{ $movimiento->user->name }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="text-center mt-3">
                                        <a href="{{ route('inventarios.movimientos', $inventario) }}" class="btn btn-outline-secondary">
                                            <i class="fas fa-list me-2"></i>Ver Todos los Movimientos
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Botones de Acción -->
                    <div class="row mt-4">
                        <div class="col-12 d-flex justify-content-between">
                            <div>
                                <a href="{{ route('inventarios.index') }}" class="btn btn-outline-secondary btn-floating">
                                    <i class="fas fa-arrow-left me-2"></i>Volver al Inventario
                                </a>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-success btn-floating" onclick="modalEntrada()">
                                    <i class="fas fa-plus me-2"></i>Entrada
                                </button>
                                <button type="button" class="btn btn-primary btn-floating" onclick="modalSalida()">
                                    <i class="fas fa-minus me-2"></i>Salida
                                </button>
                                <a href="{{ route('inventarios.edit', $inventario) }}" class="btn btn-warning btn-floating">
                                    <i class="fas fa-edit me-2"></i>Editar
                                </a>
                                <a href="{{ route('inventarios.movimientos', $inventario) }}" class="btn btn-info btn-floating">
                                    <i class="fas fa-history me-2"></i>Movimientos
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Entrada de Stock -->
<div class="modal fade" id="entradaModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="fas fa-plus me-2"></i>Entrada de Stock
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="entradaForm">
                <div class="modal-body">
                    <div class="alert alert-info">
                        <strong>Producto:</strong> {{ $inventario->producto->nombre }}<br>
                        <strong>Stock Actual:</strong> {{ number_format($inventario->stock_disponible, 2) }}
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Cantidad *</label>
                        <input type="number" class="form-control" name="cantidad" step="0.01" min="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Precio Unitario</label>
                        <input type="number" class="form-control" name="precio_unitario" step="0.01" min="0">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Motivo *</label>
                        <select class="form-select" name="motivo" required>
                            <option value="">Seleccionar motivo</option>
                            <option value="compra">Compra</option>
                            <option value="devolucion">Devolución</option>
                            <option value="ajuste_inventario">Ajuste de Inventario</option>
                            <option value="produccion">Producción</option>
                            <option value="otro">Otro</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Documento de Referencia</label>
                        <input type="text" class="form-control" name="documento_referencia" placeholder="Factura, guía, etc.">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Observaciones</label>
                        <textarea class="form-control" name="observaciones" rows="3" placeholder="Observaciones adicionales"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-2"></i>Registrar Entrada
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para Salida de Stock -->
<div class="modal fade" id="salidaModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-minus me-2"></i>Salida de Stock
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="salidaForm">
                <div class="modal-body">
                    <div class="alert alert-info">
                        <strong>Producto:</strong> {{ $inventario->producto->nombre }}<br>
                        <strong>Stock Disponible:</strong> {{ number_format($inventario->stock_disponible, 2) }}
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Cantidad *</label>
                        <input type="number" class="form-control" name="cantidad" step="0.01" min="0.01" max="{{ $inventario->stock_disponible }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Motivo *</label>
                        <select class="form-select" name="motivo" required>
                            <option value="">Seleccionar motivo</option>
                            <option value="venta">Venta</option>
                            <option value="consumo_interno">Consumo Interno</option>
                            <option value="merma">Merma</option>
                            <option value="vencimiento">Vencimiento</option>
                            <option value="ajuste_inventario">Ajuste de Inventario</option>
                            <option value="otro">Otro</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Documento de Referencia</label>
                        <input type="text" class="form-control" name="documento_referencia" placeholder="Boleta, factura, etc.">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Observaciones</label>
                        <textarea class="form-control" name="observaciones" rows="3" placeholder="Observaciones adicionales"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Registrar Salida
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function modalEntrada() {
    const modal = new bootstrap.Modal(document.getElementById('entradaModal'));
    document.getElementById('entradaForm').reset();
    modal.show();
}

function modalSalida() {
    const modal = new bootstrap.Modal(document.getElementById('salidaModal'));
    document.getElementById('salidaForm').reset();
    modal.show();
}

// Manejar formulario de entrada
document.getElementById('entradaForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    try {
        const response = await fetch(`/inventarios/{{ $inventario->id }}/entrada`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });

        const result = await response.json();

        if (result.success) {
            bootstrap.Modal.getInstance(document.getElementById('entradaModal')).hide();
            Swal.fire('Éxito', result.message, 'success').then(() => {
                location.reload();
            });
        } else {
            Swal.fire('Error', 'Ocurrió un error al registrar la entrada', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        Swal.fire('Error', 'Ocurrió un error al procesar la solicitud', 'error');
    }
});

// Manejar formulario de salida
document.getElementById('salidaForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    try {
        const response = await fetch(`/inventarios/{{ $inventario->id }}/salida`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });

        const result = await response.json();

        if (result.success) {
            bootstrap.Modal.getInstance(document.getElementById('salidaModal')).hide();
            Swal.fire('Éxito', result.message, 'success').then(() => {
                location.reload();
            });
        } else {
            Swal.fire('Error', 'Ocurrió un error al registrar la salida', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        Swal.fire('Error', 'Ocurrió un error al procesar la solicitud', 'error');
    }
});
</script>
@endpush

</x-app-layout>