@extends('layouts.app')

@section('title', 'Nueva Compra')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="container-fluid py-4">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="icon-shape bg-gradient-info shadow text-center border-radius-md me-3">
                                <i class="bi bi-plus-circle text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                            <div>
                                <h1 class="h3 mb-0 text-dark font-weight-bold">Nueva Compra</h1>
                                <p class="mb-0 text-sm text-muted">Registra una nueva orden de compra</p>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('compras.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Volver
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid py-4">
        <form action="{{ route('compras.store') }}" method="POST" id="compraForm">
            @csrf
            <div class="row">
                <!-- Información básica -->
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header bg-white pb-0">
                            <h6 class="mb-0">Información de la Compra</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="numero_compra" class="form-label">Número de Compra</label>
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
                                    <label for="proveedor_id" class="form-label">Proveedor</label>
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
                                    <label for="fecha_compra" class="form-label">Fecha de Compra</label>
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

                                <div class="col-md-6 mb-3">
                                    <label for="fecha_entrega" class="form-label">Fecha de Entrega</label>
                                    <input type="date"
                                           class="form-control @error('fecha_entrega') is-invalid @enderror"
                                           id="fecha_entrega"
                                           name="fecha_entrega"
                                           value="{{ old('fecha_entrega') }}">
                                    @error('fecha_entrega')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="tipo_comprobante" class="form-label">Tipo de Comprobante</label>
                                    <select class="form-select @error('tipo_comprobante') is-invalid @enderror"
                                            id="tipo_comprobante"
                                            name="tipo_comprobante">
                                        <option value="">Seleccionar tipo</option>
                                        <option value="factura" {{ old('tipo_comprobante') == 'factura' ? 'selected' : '' }}>Factura</option>
                                        <option value="boleta" {{ old('tipo_comprobante') == 'boleta' ? 'selected' : '' }}>Boleta</option>
                                        <option value="ticket" {{ old('tipo_comprobante') == 'ticket' ? 'selected' : '' }}>Ticket</option>
                                    </select>
                                    @error('tipo_comprobante')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="numero_comprobante" class="form-label">Número de Comprobante</label>
                                    <input type="text"
                                           class="form-control @error('numero_comprobante') is-invalid @enderror"
                                           id="numero_comprobante"
                                           name="numero_comprobante"
                                           value="{{ old('numero_comprobante') }}">
                                    @error('numero_comprobante')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="observaciones" class="form-label">Observaciones</label>
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
                    <div class="card mb-4">
                        <div class="card-header bg-white pb-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Productos</h6>
                                <button type="button" class="btn btn-sm btn-info" onclick="agregarProducto()">
                                    <i class="bi bi-plus me-1"></i>Agregar Producto
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
                    <div class="card">
                        <div class="card-header bg-white pb-0">
                            <h6 class="mb-0">Resumen de Compra</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span id="subtotal-display">S/ 0.00</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Descuento:</span>
                                <div class="input-group input-group-sm">
                                    <input type="number"
                                           class="form-control text-end"
                                           id="descuento"
                                           name="descuento"
                                           value="{{ old('descuento', 0) }}"
                                           min="0"
                                           step="0.01"
                                           onchange="calcularTotal()">
                                    <span class="input-group-text">S/</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>IGV (18%):</span>
                                <span id="igv-display">S/ 0.00</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-3">
                                <strong>Total:</strong>
                                <strong id="total-display">S/ 0.00</strong>
                            </div>

                            <input type="hidden" id="subtotal" name="subtotal" value="0">
                            <input type="hidden" id="igv" name="igv" value="0">
                            <input type="hidden" id="total" name="total" value="0">

                            <div class="mb-3">
                                <label for="estado" class="form-label">Estado</label>
                                <select class="form-select" id="estado" name="estado">
                                    <option value="pendiente" {{ old('estado', 'pendiente') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="enviado" {{ old('estado') == 'enviado' ? 'selected' : '' }}>Enviado</option>
                                    <option value="recibido" {{ old('estado') == 'recibido' ? 'selected' : '' }}>Recibido</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="metodo_pago" class="form-label">Método de Pago</label>
                                <select class="form-select" id="metodo_pago" name="metodo_pago">
                                    <option value="">Seleccionar método</option>
                                    <option value="efectivo" {{ old('metodo_pago') == 'efectivo' ? 'selected' : '' }}>Efectivo</option>
                                    <option value="transferencia" {{ old('metodo_pago') == 'transferencia' ? 'selected' : '' }}>Transferencia</option>
                                    <option value="cheque" {{ old('metodo_pago') == 'cheque' ? 'selected' : '' }}>Cheque</option>
                                    <option value="credito" {{ old('metodo_pago') == 'credito' ? 'selected' : '' }}>Crédito</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="card mt-3">
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-info">
                                    <i class="bi bi-save me-2"></i>Guardar Compra
                                </button>
                                <a href="{{ route('compras.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-circle me-2"></i>Cancelar
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
    <div class="producto-item border rounded p-3 mb-3" data-index="">
        <div class="row">
            <div class="col-md-6 mb-2">
                <label class="form-label">Producto</label>
                <select class="form-select producto-select" name="productos[][producto_id]" required>
                    <option value="">Seleccionar producto</option>
                    @foreach($productos as $producto)
                        <option value="{{ $producto->id }}" data-precio="{{ $producto->precio_compra ?? $producto->precio_venta }}">
                            {{ $producto->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 mb-2">
                <label class="form-label">Cantidad</label>
                <input type="number" class="form-control cantidad-input" name="productos[][cantidad]" min="1" value="1" required>
            </div>
            <div class="col-md-3 mb-2">
                <label class="form-label">Precio</label>
                <input type="number" class="form-control precio-input" name="productos[][precio_unitario]" min="0" step="0.01" required>
            </div>
            <div class="col-md-1 mb-2 d-flex align-items-end">
                <button type="button" class="btn btn-danger btn-sm" onclick="eliminarProducto(this)">
                    <i class="bi bi-trash"></i>
                </button>
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

    // Actualizar el índice
    clone.querySelector('.producto-item').setAttribute('data-index', productoIndex);

    // Agregar event listeners
    const productoSelect = clone.querySelector('.producto-select');
    const cantidadInput = clone.querySelector('.cantidad-input');
    const precioInput = clone.querySelector('.precio-input');

    productoSelect.addEventListener('change', function() {
        const precio = this.options[this.selectedIndex].getAttribute('data-precio');
        precioInput.value = precio || 0;
        calcularTotal();
    });

    cantidadInput.addEventListener('input', calcularTotal);
    precioInput.addEventListener('input', calcularTotal);

    container.appendChild(clone);
    productoIndex++;
}

function eliminarProducto(button) {
    button.closest('.producto-item').remove();
    calcularTotal();
}

function calcularTotal() {
    let subtotal = 0;

    document.querySelectorAll('.producto-item').forEach(item => {
        const cantidad = parseFloat(item.querySelector('.cantidad-input').value) || 0;
        const precio = parseFloat(item.querySelector('.precio-input').value) || 0;
        subtotal += cantidad * precio;
    });

    const descuento = parseFloat(document.getElementById('descuento').value) || 0;
    const subtotalConDescuento = subtotal - descuento;
    const igv = subtotalConDescuento * 0.18;
    const total = subtotalConDescuento + igv;

    // Actualizar displays
    document.getElementById('subtotal-display').textContent = 'S/ ' + subtotal.toFixed(2);
    document.getElementById('igv-display').textContent = 'S/ ' + igv.toFixed(2);
    document.getElementById('total-display').textContent = 'S/ ' + total.toFixed(2);

    // Actualizar inputs ocultos
    document.getElementById('subtotal').value = subtotal.toFixed(2);
    document.getElementById('igv').value = igv.toFixed(2);
    document.getElementById('total').value = total.toFixed(2);
}

// Agregar un producto por defecto al cargar
document.addEventListener('DOMContentLoaded', function() {
    agregarProducto();
});
</script>

<style>
.stats-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 1rem;
    box-shadow: 0 8px 30px rgba(0,0,0,0.12);
}

.btn-modern {
    border-radius: 0.5rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

.card {
    border: none;
    border-radius: 1rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
}

.producto-item {
    background-color: #f8f9fa;
    transition: all 0.3s ease;
}

.producto-item:hover {
    background-color: #e9ecef;
}
</style>
@endsection
