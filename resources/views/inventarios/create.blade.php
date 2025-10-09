@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="fas fa-plus-circle text-primary me-2"></i>
            Crear Nuevo Producto en Inventario
        </h2>
        <a href="{{ route('inventarios.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>
            Volver
        </a>
    </div>

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<style>
    .form-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 0 30px rgba(0,0,0,0.1);
    }
    .form-header {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
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

    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('inventarios.index') }}">Inventario</a></li>
                    <li class="breadcrumb-item active">Nuevo Producto</li>
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
                            <i class="fas fa-boxes fa-lg"></i>
                        </div>
                        <div>
                            <h4 class="mb-0">Agregar Producto al Inventario</h4>
                            <small class="opacity-75">Complete la información del producto</small>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('inventarios.store') }}" method="POST">
                        @csrf

                        <div class="row g-3">
                            <!-- Producto -->
                            <div class="col-md-12">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-box me-2 text-primary"></i>Producto *
                                </label>
                                @if(count($productos) > 0)
                                    <select name="producto_id" class="form-select @error('producto_id') is-invalid @enderror" required>
                                        <option value="">Seleccione un producto</option>
                                        @foreach($productos as $producto)
                                            <option value="{{ $producto->id }}"
                                                    {{ old('producto_id') == $producto->id ? 'selected' : '' }}>
                                                [{{ $producto->codigo }}] {{ $producto->nombre }} - {{ $producto->categoria->nombre ?? 'Sin categoría' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('producto_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                @else
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Todos los productos ya tienen registros de inventario.
                                        <a href="{{ route('inventarios.index') }}" class="alert-link">Ver inventarios existentes</a>
                                    </div>
                                @endif
                            </div>

                            <!-- Stock Actual -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-cubes me-2 text-primary"></i>Stock Inicial *
                                </label>
                                <input type="number" name="stock_actual"
                                       class="form-control @error('stock_actual') is-invalid @enderror"
                                       value="{{ old('stock_actual') }}"
                                       step="0.01" min="0" required>
                                @error('stock_actual')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Cantidad inicial en inventario</small>
                            </div>

                            <!-- Stock Reservado -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-lock me-2 text-primary"></i>Stock Reservado
                                </label>
                                <input type="number" name="stock_reservado"
                                       class="form-control @error('stock_reservado') is-invalid @enderror"
                                       value="{{ old('stock_reservado', 0) }}"
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
                                       value="{{ old('fecha_vencimiento') }}"
                                       min="{{ date('Y-m-d', strtotime('+1 day')) }}">
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
                                       value="{{ old('lote') }}"
                                       maxlength="100"
                                       placeholder="Ej: L20240825-001">
                                @error('lote')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Identificación del lote o partida</small>
                            </div>

                            <!-- Información adicional -->
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Información:</strong> El stock disponible se calculará automáticamente
                                    restando el stock reservado del stock actual.
                                </div>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="row mt-4">
                            <div class="col-12 d-flex justify-content-end gap-2">
                                <a href="{{ route('inventarios.index') }}" class="btn btn-outline-secondary btn-floating">
                                    <i class="fas fa-times me-2"></i>Cancelar
                                </a>
                                @if(count($productos) > 0)
                                    <button type="submit" class="btn btn-primary btn-floating">
                                        <i class="fas fa-save me-2"></i>Agregar al Inventario
                                    </button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
            infoDiv.className = 'alert alert-light mt-2';
            stockReservado.parentNode.appendChild(infoDiv);
        }

        infoDiv.innerHTML = `
            <small>
                <i class="fas fa-calculator me-2"></i>
                <strong>Stock Disponible:</strong> ${disponible.toFixed(2)}
                ${disponible < 0 ? '<span class="text-danger">(Stock insuficiente)</span>' : ''}
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

</div>
@endsection
