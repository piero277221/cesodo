@extends('layouts.app')

@section('title', 'Nueva Venta')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-cart-plus text-success me-2"></i>
                Nueva Venta
            </h1>
            <p class="text-muted mb-0">Registra una nueva venta al cliente</p>
        </div>
        <div>
            <a href="{{ route('ventas.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>
                Volver
            </a>
        </div>
    </div>

    <form method="POST" action="{{ route('ventas.store') }}" id="ventaForm">
        @csrf

        <div class="row">
            <!-- Formulario principal -->
            <div class="col-lg-8">
                <!-- Información del Cliente -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 bg-success text-white">
                        <h6 class="m-0 font-weight-bold">
                            <i class="fas fa-user me-2"></i>
                            Información del Cliente
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Cliente <span class="text-danger">*</span></label>
                                <select name="cliente_id" id="cliente_id" class="form-select @error('cliente_id') is-invalid @enderror" required>
                                    <option value="">Seleccione un cliente...</option>
                                    @foreach($clientes as $cliente)
                                        <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                            {{ $cliente->nombre }} - {{ $cliente->documento }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('cliente_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold">Fecha Venta <span class="text-danger">*</span></label>
                                <input type="date" name="fecha_venta" id="fecha_venta"
                                       class="form-control @error('fecha_venta') is-invalid @enderror"
                                       value="{{ old('fecha_venta', date('Y-m-d')) }}" required>
                                @error('fecha_venta')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold">Tipo Venta <span class="text-danger">*</span></label>
                                <select name="tipo_venta" id="tipo_venta" class="form-select @error('tipo_venta') is-invalid @enderror" required>
                                    <option value="contado" {{ old('tipo_venta') == 'contado' ? 'selected' : '' }}>Contado</option>
                                    <option value="credito" {{ old('tipo_venta') == 'credito' ? 'selected' : '' }}>Crédito</option>
                                    <option value="cortesia" {{ old('tipo_venta') == 'cortesia' ? 'selected' : '' }}>Cortesía</option>
                                </select>
                                @error('tipo_venta')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tipo Pago <span class="text-danger">*</span></label>
                                <select name="tipo_pago" id="tipo_pago" class="form-select @error('tipo_pago') is-invalid @enderror" required>
                                    <option value="efectivo" {{ old('tipo_pago') == 'efectivo' ? 'selected' : '' }}>Efectivo</option>
                                    <option value="tarjeta" {{ old('tipo_pago') == 'tarjeta' ? 'selected' : '' }}>Tarjeta</option>
                                    <option value="transferencia" {{ old('tipo_pago') == 'transferencia' ? 'selected' : '' }}>Transferencia</option>
                                    <option value="cheque" {{ old('tipo_pago') == 'cheque' ? 'selected' : '' }}>Cheque</option>
                                    <option value="mixto" {{ old('tipo_pago') == 'mixto' ? 'selected' : '' }}>Mixto</option>
                                </select>
                                @error('tipo_pago')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Observaciones</label>
                                <textarea name="observaciones" id="observaciones"
                                          class="form-control @error('observaciones') is-invalid @enderror"
                                          rows="2" placeholder="Observaciones adicionales...">{{ old('observaciones') }}</textarea>
                                @error('observaciones')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Productos -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 bg-primary text-white">
                        <h6 class="m-0 font-weight-bold">
                            <i class="fas fa-shopping-cart me-2"></i>
                            Productos de la Venta
                        </h6>
                    </div>
                    <div class="card-body">
                        <!-- Selector de producto -->
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label class="form-label fw-bold">Agregar Producto</label>
                                <select id="producto_selector" class="form-select">
                                    <option value="">Seleccione un producto...</option>
                                    @foreach($productos as $producto)
                                        <option value="{{ $producto->id }}"
                                                data-nombre="{{ $producto->nombre }}"
                                                data-precio="{{ $producto->precio_unitario }}"
                                                data-stock="{{ $producto->stock ?? 0 }}">
                                            {{ $producto->nombre }} - ${{ number_format($producto->precio_unitario, 2) }}
                                            (Stock: {{ $producto->stock ?? 0 }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label fw-bold">Cantidad</label>
                                <input type="number" id="cantidad_producto" class="form-control"
                                       min="1" step="0.01" value="1" placeholder="Cant.">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label fw-bold">&nbsp;</label>
                                <button type="button" onclick="agregarProducto()" class="btn btn-success w-100">
                                    <i class="fas fa-plus"></i> Agregar
                                </button>
                            </div>
                        </div>

                        <!-- Tabla de productos -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="tabla_productos">
                                <thead class="table-light">
                                    <tr>
                                        <th width="40%">Producto</th>
                                        <th width="15%" class="text-center">Cantidad</th>
                                        <th width="15%" class="text-end">Precio Unit.</th>
                                        <th width="20%" class="text-end">Subtotal</th>
                                        <th width="10%" class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="productos_body">
                                    <tr id="empty_row">
                                        <td colspan="5" class="text-center text-muted">
                                            <i class="fas fa-inbox fa-2x mb-2"></i>
                                            <p class="mb-0">No hay productos agregados</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        @error('productos')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="d-flex justify-content-between mb-4">
                    <a href="{{ route('ventas.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="fas fa-save me-2"></i>
                        Registrar Venta
                    </button>
                </div>
            </div>

            <!-- Resumen -->
            <div class="col-lg-4">
                <div class="card shadow sticky-top" style="top: 20px;">
                    <div class="card-header py-3 bg-info text-white">
                        <h6 class="m-0 font-weight-bold">
                            <i class="fas fa-calculator me-2"></i>
                            Resumen de Venta
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3 pb-2 border-bottom">
                            <span class="text-muted">Subtotal:</span>
                            <span class="fw-bold" id="resumen_subtotal">$0.00</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3 pb-2 border-bottom">
                            <span class="text-muted">Descuento:</span>
                            <span class="fw-bold text-danger" id="resumen_descuento">$0.00</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3 pb-2 border-bottom">
                            <span class="text-muted">Total Items:</span>
                            <span class="fw-bold" id="resumen_items">0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                            <span class="h5 mb-0 fw-bold">TOTAL:</span>
                            <span class="h4 mb-0 fw-bold text-success" id="resumen_total">$0.00</span>
                        </div>

                        <!-- Info adicional -->
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <small>Verifica los datos antes de registrar la venta</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@section('scripts')
<script>
let productosVenta = [];
let contadorProductos = 0;

function agregarProducto() {
    const selector = document.getElementById('producto_selector');
    const cantidad = parseFloat(document.getElementById('cantidad_producto').value);

    if (!selector.value) {
        alert('Por favor seleccione un producto');
        return;
    }

    if (!cantidad || cantidad <= 0) {
        alert('Por favor ingrese una cantidad válida');
        return;
    }

    const option = selector.options[selector.selectedIndex];
    const productoId = selector.value;
    const nombre = option.dataset.nombre;
    const precio = parseFloat(option.dataset.precio);
    const stock = parseFloat(option.dataset.stock);

    // Validar stock
    if (cantidad > stock) {
        alert(`Stock insuficiente. Disponible: ${stock}`);
        return;
    }

    // Verificar si el producto ya está agregado
    const existente = productosVenta.find(p => p.id == productoId);
    if (existente) {
        alert('Este producto ya fue agregado. Puede modificar la cantidad en la tabla.');
        return;
    }

    const subtotal = cantidad * precio;

    productosVenta.push({
        id: productoId,
        nombre: nombre,
        cantidad: cantidad,
        precio: precio,
        subtotal: subtotal,
        index: contadorProductos++
    });

    actualizarTabla();
    actualizarResumen();

    // Limpiar selector
    selector.value = '';
    document.getElementById('cantidad_producto').value = '1';
}

function eliminarProducto(index) {
    productosVenta = productosVenta.filter(p => p.index !== index);
    actualizarTabla();
    actualizarResumen();
}

function actualizarTabla() {
    const tbody = document.getElementById('productos_body');

    if (productosVenta.length === 0) {
        tbody.innerHTML = `
            <tr id="empty_row">
                <td colspan="5" class="text-center text-muted">
                    <i class="fas fa-inbox fa-2x mb-2"></i>
                    <p class="mb-0">No hay productos agregados</p>
                </td>
            </tr>
        `;
        return;
    }

    let html = '';
    productosVenta.forEach(producto => {
        html += `
            <tr>
                <td>${producto.nombre}</td>
                <td class="text-center">${producto.cantidad}</td>
                <td class="text-end">$${producto.precio.toFixed(2)}</td>
                <td class="text-end">$${producto.subtotal.toFixed(2)}</td>
                <td class="text-center">
                    <button type="button" onclick="eliminarProducto(${producto.index})"
                            class="btn btn-sm btn-danger">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
            <input type="hidden" name="productos[${producto.index}][id]" value="${producto.id}">
            <input type="hidden" name="productos[${producto.index}][cantidad]" value="${producto.cantidad}">
            <input type="hidden" name="productos[${producto.index}][precio_unitario]" value="${producto.precio}">
        `;
    });

    tbody.innerHTML = html;
}

function actualizarResumen() {
    const subtotal = productosVenta.reduce((sum, p) => sum + p.subtotal, 0);
    const items = productosVenta.reduce((sum, p) => sum + p.cantidad, 0);

    document.getElementById('resumen_subtotal').textContent = `$${subtotal.toFixed(2)}`;
    document.getElementById('resumen_descuento').textContent = '$0.00';
    document.getElementById('resumen_items').textContent = items.toFixed(2);
    document.getElementById('resumen_total').textContent = `$${subtotal.toFixed(2)}`;
}

// Validar formulario antes de enviar
document.getElementById('ventaForm').addEventListener('submit', function(e) {
    if (productosVenta.length === 0) {
        e.preventDefault();
        alert('Debe agregar al menos un producto a la venta');
        return false;
    }
});
</script>
@endsection
