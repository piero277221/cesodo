<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Inventarios
        </h2>
    </x-slot>

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<style>
    .form-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 0 30px rgba(0,0,0,0.1);
    }
    .form-header {
        background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
        color: white;
        border-radius: 15px 15px 0 0;
    }
    .btn-floating {
        border-radius: 50px;
        padding: 0.6rem 2rem;
    }
    .icon-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
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
                    <li class="breadcrumb-item active">Editar Inventario</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card form-card">
                <div class="card-header form-header">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle bg-white bg-opacity-20">
                            <i class="fas fa-edit fa-lg"></i>
                        </div>
                        <div>
                            <h4 class="mb-0">Editar Inventario</h4>
                            <small class="opacity-75">Modifique la información del inventario</small>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('inventarios.update', $inventario) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <!-- Información del Producto -->
                            <div class="col-12">
                                <div class="alert alert-info d-flex align-items-center">
                                    <i class="fas fa-box me-2"></i>
                                    <div>
                                        <strong>Producto:</strong> {{ $inventario->producto->nombre }}
                                        <span class="badge bg-primary ms-2">{{ $inventario->producto->codigo }}</span>
                                        <br><small class="text-muted">{{ $inventario->producto->categoria->nombre ?? 'Sin categoría' }}</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Stock Actual -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-cubes me-2 text-primary"></i>Stock Actual *
                                </label>
                                <input type="number" name="stock_actual"
                                       class="form-control @error('stock_actual') is-invalid @enderror"
                                       value="{{ old('stock_actual', $inventario->stock_actual) }}"
                                       step="0.01" min="0" required>
                                @error('stock_actual')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Cantidad total en inventario</small>
                            </div>

                            <!-- Stock Reservado -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-lock me-2 text-primary"></i>Stock Reservado
                                </label>
                                <input type="number" name="stock_reservado"
                                       class="form-control @error('stock_reservado') is-invalid @enderror"
                                       value="{{ old('stock_reservado', $inventario->stock_reservado) }}"
                                       step="0.01" min="0">
                                @error('stock_reservado')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Cantidad reservada para pedidos</small>
                            </div>

                            <!-- Fecha de Vencimiento -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-calendar-times me-2 text-primary"></i>Fecha de Vencimiento
                                </label>
                                <input type="date" name="fecha_vencimiento"
                                       class="form-control @error('fecha_vencimiento') is-invalid @enderror"
                                       value="{{ old('fecha_vencimiento', $inventario->fecha_vencimiento?->format('Y-m-d')) }}">
                                @error('fecha_vencimiento')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Solo para productos perecederos</small>
                            </div>

                            <!-- Lote -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-barcode me-2 text-primary"></i>Número de Lote
                                </label>
                                <input type="text" name="lote"
                                       class="form-control @error('lote') is-invalid @enderror"
                                       value="{{ old('lote', $inventario->lote) }}"
                                       maxlength="100"
                                       placeholder="Ej: L20240825-001">
                                @error('lote')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Identificación del lote o partida</small>
                            </div>

                            <!-- Stock Disponible (Solo lectura) -->
                            <div class="col-12">
                                <div class="alert alert-light">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>Stock Disponible Actual:</strong>
                                            <span class="text-success fs-5">{{ number_format($inventario->stock_disponible, 2) }}</span>
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Última Actualización:</strong>
                                            <span class="text-muted">{{ $inventario->fecha_ultimo_movimiento?->format('d/m/Y H:i') ?? 'Sin registro' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Información de cambios -->
                            <div class="col-12">
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <strong>Nota importante:</strong> Los cambios en el stock se registrarán como
                                    ajuste de inventario. Para movimientos específicos (entradas/salidas),
                                    utilice los botones correspondientes en la vista principal.
                                </div>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="row mt-4">
                            <div class="col-12 d-flex justify-content-end gap-2">
                                <a href="{{ route('inventarios.index') }}" class="btn btn-outline-secondary btn-floating">
                                    <i class="fas fa-times me-2"></i>Cancelar
                                </a>
                                <a href="{{ route('inventarios.show', $inventario) }}" class="btn btn-outline-info btn-floating">
                                    <i class="fas fa-eye me-2"></i>Ver Detalle
                                </a>
                                <button type="submit" class="btn btn-warning btn-floating">
                                    <i class="fas fa-save me-2"></i>Actualizar Inventario
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Calcular stock disponible automáticamente
document.addEventListener('DOMContentLoaded', function() {
    const stockActual = document.querySelector('input[name="stock_actual"]');
    const stockReservado = document.querySelector('input[name="stock_reservado"]');

    function actualizarInfo() {
        const actual = parseFloat(stockActual.value) || 0;
        const reservado = parseFloat(stockReservado.value) || 0;
        const disponible = actual - reservado;

        // Mostrar información en tiempo real
        let infoDiv = document.getElementById('stock-info');
        if (!infoDiv) {
            infoDiv = document.createElement('div');
            infoDiv.id = 'stock-info';
            infoDiv.className = 'alert alert-primary mt-2';
            stockReservado.parentNode.appendChild(infoDiv);
        }

        let statusClass = 'text-success';
        let statusText = '';
        if (disponible < 0) {
            statusClass = 'text-danger';
            statusText = ' (Stock insuficiente)';
        }

        infoDiv.innerHTML = `
            <small>
                <i class="fas fa-calculator me-2"></i>
                <strong>Nuevo Stock Disponible:</strong>
                <span class="${statusClass}">${disponible.toFixed(2)}${statusText}</span>
            </small>
        `;

        // Validar que el stock reservado no sea mayor al actual
        if (reservado > actual) {
            stockReservado.setCustomValidity('El stock reservado no puede ser mayor al stock actual');
        } else {
            stockReservado.setCustomValidity('');
        }
    }

    stockActual.addEventListener('input', actualizarInfo);
    stockReservado.addEventListener('input', actualizarInfo);

    // Ejecutar al cargar
    actualizarInfo();
});
</script>
@endpush

</x-app-layout>