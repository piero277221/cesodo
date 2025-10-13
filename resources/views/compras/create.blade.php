@extends('layouts.app')

@section('title', 'Nueva Compra')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Mejorado -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="h3 mb-1 text-dark fw-bold">
                                <i class="fas fa-shopping-cart text-danger me-2"></i>
                                Nueva Compra
                            </h1>
                            <p class="text-muted mb-0 small">Registra una nueva orden de compra</p>
                        </div>
                        <a href="{{ route('compras.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Volver
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <form action="{{ route('compras.store') }}" method="POST" id="compraForm">
            @csrf
            <div class="row">
                <!-- Información básica -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-0">
                            <h5 class="mb-0 fw-bold text-dark">
                                <i class="fas fa-info-circle text-danger me-2"></i>
                                Información de la Compra
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="numero_compra" class="form-label fw-semibold">
                                        <i class="fas fa-hashtag me-1 text-muted"></i>Número de Compra
                                    </label>
                                    <input type="text"
                                           class="form-control @error('numero_compra') is-invalid @enderror"
                                           id="numero_compra"
                                           name="numero_compra"
                                           value="{{ old('numero_compra', 'COM-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT)) }}"
                                           required>
                                    @error('numero_compra')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="proveedor_id" class="form-label fw-semibold">
                                        <i class="fas fa-truck me-1 text-muted"></i>Proveedor
                                    </label>
                                    <select class="form-select @error('proveedor_id') is-invalid @enderror"
                                            id="proveedor_id"
                                            name="proveedor_id"
                                            required>
                                        <option value="">Seleccionar proveedor</option>
                                        @foreach($proveedores as $proveedor)
                                            <option value="{{ $proveedor->id }}" {{ old('proveedor_id') == $proveedor->id ? 'selected' : '' }}>
                                                {{ $proveedor->razon_social }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('proveedor_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="tipo_compra" class="form-label fw-semibold">
                                        <i class="fas fa-tags me-1 text-muted"></i>Tipo de Compra
                                    </label>
                                    <select class="form-select @error('tipo_compra') is-invalid @enderror"
                                            id="tipo_compra"
                                            name="tipo_compra"
                                            required>
                                        <option value="">Seleccionar tipo</option>
                                        <option value="productos" {{ old('tipo_compra', 'productos') == 'productos' ? 'selected' : '' }}>Productos</option>
                                        <option value="insumos" {{ old('tipo_compra') == 'insumos' ? 'selected' : '' }}>Insumos</option>
                                        <option value="equipos" {{ old('tipo_compra') == 'equipos' ? 'selected' : '' }}>Equipos</option>
                                        <option value="servicios" {{ old('tipo_compra') == 'servicios' ? 'selected' : '' }}>Servicios</option>
                                    </select>
                                    @error('tipo_compra')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="fecha_compra" class="form-label fw-semibold">
                                        <i class="fas fa-calendar me-1 text-muted"></i>Fecha de Compra
                                    </label>
                                    <input type="date"
                                           class="form-control @error('fecha_compra') is-invalid @enderror"
                                           id="fecha_compra"
                                           name="fecha_compra"
                                           value="{{ old('fecha_compra', date('Y-m-d')) }}"
                                           required>
                                    @error('fecha_compra')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="fecha_entrega_esperada" class="form-label fw-semibold">
                                        <i class="fas fa-calendar-check me-1 text-muted"></i>Fecha de Entrega Esperada
                                    </label>
                                    <input type="date"
                                           class="form-control @error('fecha_entrega_esperada') is-invalid @enderror"
                                           id="fecha_entrega_esperada"
                                           name="fecha_entrega_esperada"
                                           value="{{ old('fecha_entrega_esperada') }}">
                                    @error('fecha_entrega_esperada')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="observaciones" class="form-label fw-semibold">
                                    <i class="fas fa-comment me-1 text-muted"></i>Observaciones
                                </label>
                                <textarea class="form-control @error('observaciones') is-invalid @enderror"
                                          id="observaciones"
                                          name="observaciones"
                                          rows="3">{{ old('observaciones') }}</textarea>
                                @error('observaciones')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Productos -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 fw-bold text-dark">
                                    <i class="fas fa-box text-danger me-2"></i>Productos
                                </h5>
                                <button type="button" class="btn btn-danger btn-sm" onclick="agregarProducto()">
                                    <i class="fas fa-plus me-1"></i>Agregar Producto
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="productos-container">
                                <!-- Los productos se agregarán dinámicamente aquí -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Resumen -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm sticky-top" style="top: 20px;">
                        <div class="card-header bg-danger text-white border-0">
                            <h5 class="mb-0 fw-bold">
                                <i class="fas fa-calculator me-2"></i>Resumen de Compra
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="bg-light p-3 rounded mb-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Subtotal:</span>
                                    <span class="fw-bold" id="subtotal-display">S/ 0.00</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2 align-items-center">
                                    <span class="text-muted">Descuento:</span>
                                    <div class="input-group input-group-sm" style="max-width: 120px;">
                                        <input type="number"
                                               class="form-control form-control-sm text-end"
                                               id="descuento_total"
                                               name="descuento_total"
                                               value="{{ old('descuento_total', 0) }}"
                                               min="0"
                                               step="0.01"
                                               onchange="calcularTotal()">
                                        <span class="input-group-text">S/</span>
                                    </div>
                                </div>
                                <hr class="my-2">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted small">
                                        <i class="fas fa-info-circle me-1"></i>IGV incluido (18%):
                                    </span>
                                    <span class="text-muted small" id="igv-display">S/ 0.00</span>
                                </div>
                            </div>

                            <div class="bg-danger bg-opacity-10 p-3 rounded mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold text-dark h5 mb-0">Total:</span>
                                    <span class="fw-bold text-danger h4 mb-0" id="total-display">S/ 0.00</span>
                                </div>
                            </div>

                            <input type="hidden" id="subtotal" name="subtotal" value="0">
                            <input type="hidden" id="igv" name="igv" value="0">
                            <input type="hidden" id="total" name="total" value="0">
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="card border-0 shadow-sm mt-3">
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-danger btn-lg">
                                    <i class="fas fa-save me-2"></i>Guardar Compra
                                </button>
                                <a href="{{ route('compras.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-2"></i>Cancelar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Template para productos -->
<template id="producto-template">
    <div class="producto-item border rounded p-3 mb-3 bg-light" data-index="">
        <div class="row g-2">
            <div class="col-md-5 mb-2">
                <label class="form-label fw-semibold small">
                    <i class="fas fa-box me-1"></i>Producto
                </label>
                <select class="form-select form-select-sm producto-select" name="productos[INDEX][id]" required>
                    <option value="">Seleccionar producto</option>
                    @foreach($productos as $producto)
                        <option value="{{ $producto->id }}" data-precio="{{ $producto->precio_compra ?? $producto->precio_venta }}">
                            {{ $producto->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 mb-2">
                <label class="form-label fw-semibold small">
                    <i class="fas fa-sort-numeric-up me-1"></i>Cantidad
                </label>
                <input type="number" class="form-control form-control-sm cantidad-input" name="productos[INDEX][cantidad]" min="1" step="0.01" value="1" required>
            </div>
            <div class="col-md-3 mb-2">
                <label class="form-label fw-semibold small">
                    <i class="fas fa-dollar-sign me-1"></i>Precio (con IGV)
                </label>
                <input type="number" class="form-control form-control-sm precio-input" name="productos[INDEX][precio_unitario]" min="0" step="0.01" required>
            </div>
            <div class="col-md-2 mb-2 d-flex flex-column">
                <label class="form-label fw-semibold small">Subtotal</label>
                <div class="d-flex align-items-center justify-content-between">
                    <span class="subtotal-producto fw-bold text-danger">S/ 0.00</span>
                    <button type="button" class="btn btn-danger btn-sm" onclick="eliminarProducto(this)" title="Eliminar">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
let productoIndex = 0;

function agregarProducto() {
    const template = document.getElementById('producto-template');
    const container = document.getElementById('productos-container');
    const clone = template.content.cloneNode(true);

    // Actualizar el índice en el data-attribute
    clone.querySelector('.producto-item').setAttribute('data-index', productoIndex);
    
    // Reemplazar INDEX por el número de índice actual en todos los name attributes
    const inputs = clone.querySelectorAll('[name*="INDEX"]');
    inputs.forEach(input => {
        input.name = input.name.replace('INDEX', productoIndex);
    });

    // Agregar event listeners
    const productoSelect = clone.querySelector('.producto-select');
    const cantidadInput = clone.querySelector('.cantidad-input');
    const precioInput = clone.querySelector('.precio-input');

    productoSelect.addEventListener('change', function() {
        const precio = this.options[this.selectedIndex].getAttribute('data-precio');
        precioInput.value = precio || 0;
        calcularTotal();
    });

    cantidadInput.addEventListener('input', function() {
        actualizarSubtotalProducto(this.closest('.producto-item'));
        calcularTotal();
    });

    precioInput.addEventListener('input', function() {
        actualizarSubtotalProducto(this.closest('.producto-item'));
        calcularTotal();
    });

    container.appendChild(clone);
    productoIndex++;
}

function eliminarProducto(button) {
    button.closest('.producto-item').remove();
    calcularTotal();
}

function actualizarSubtotalProducto(item) {
    const cantidad = parseFloat(item.querySelector('.cantidad-input').value) || 0;
    const precio = parseFloat(item.querySelector('.precio-input').value) || 0;
    const subtotal = cantidad * precio;
    item.querySelector('.subtotal-producto').textContent = 'S/ ' + subtotal.toFixed(2);
}

function calcularTotal() {
    let total = 0;

    // Sumar todos los productos (precio con IGV incluido)
    document.querySelectorAll('.producto-item').forEach(item => {
        const cantidad = parseFloat(item.querySelector('.cantidad-input').value) || 0;
        const precio = parseFloat(item.querySelector('.precio-input').value) || 0;
        total += cantidad * precio;
    });

    const descuento = parseFloat(document.getElementById('descuento_total').value) || 0;
    const totalConDescuento = total - descuento;

    // Calcular IGV incluido en el total (IGV = total / 1.18 * 0.18)
    const igvIncluido = totalConDescuento - (totalConDescuento / 1.18);
    const subtotalSinIGV = totalConDescuento - igvIncluido;

    // Actualizar displays
    document.getElementById('subtotal-display').textContent = 'S/ ' + total.toFixed(2);
    document.getElementById('igv-display').textContent = 'S/ ' + igvIncluido.toFixed(2);
    document.getElementById('total-display').textContent = 'S/ ' + totalConDescuento.toFixed(2);

    // Actualizar inputs ocultos
    document.getElementById('subtotal').value = subtotalSinIGV.toFixed(2);
    document.getElementById('igv').value = igvIncluido.toFixed(2);
    document.getElementById('total').value = totalConDescuento.toFixed(2);
}

// Agregar un producto por defecto al cargar
document.addEventListener('DOMContentLoaded', function() {
    agregarProducto();
});
</script>

<style>
.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
}

.producto-item {
    transition: all 0.3s ease;
    border: 1px solid #dee2e6 !important;
}

.producto-item:hover {
    background-color: #fff !important;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.sticky-top {
    z-index: 1020;
}

.btn-danger {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    border: none;
}

.btn-danger:hover {
    background: linear-gradient(135deg, #c82333 0%, #bd2130 100%);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
}

.bg-danger.bg-opacity-10 {
    background-color: rgba(220, 53, 69, 0.1) !important;
}

.form-control:focus, .form-select:focus {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}
</style>
@endsection
