<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nuevo Pedido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .header-orange { background-color: #fd7900; color: white; }
        .bg-dark-custom { background-color: #2d3436; }
        .btn-orange { background-color: #fd7900; color: white; border: none; }
        .btn-orange:hover { background-color: #e66c00; color: white; }
        .btn-dark-custom { background-color: #2d3436; color: white; border: 1px solid white; }
        .btn-dark-custom:hover { background-color: #1e2426; color: white; }
    </style>
</head>
<body class="bg-light">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header header-orange d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-plus me-2"></i>Crear Nuevo Pedido
                        </h5>
                        <a href="{{ route('pedidos.index') }}" class="btn btn-dark-custom">
                            <i class="fas fa-arrow-left me-1"></i>Volver
                        </a>
                    </div>
                    <div class="card-body bg-white">

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('pedidos.store') }}" method="POST" id="pedidoForm">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="proveedor_id" class="form-label">Proveedor *</label>
                                        <select class="form-select @error('proveedor_id') is-invalid @enderror"
                                                id="proveedor_id" name="proveedor_id" required>
                                            <option value="">Seleccione un proveedor</option>
                                            @if(isset($proveedores))
                                                @foreach($proveedores as $proveedor)
                                                    <option value="{{ $proveedor->id }}" {{ old('proveedor_id') == $proveedor->id ? 'selected' : '' }}>
                                                        {{ $proveedor->nombre }} - {{ $proveedor->ruc }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="fecha_pedido" class="form-label">Fecha del Pedido *</label>
                                        <input type="date" class="form-control @error('fecha_pedido') is-invalid @enderror"
                                               id="fecha_pedido" name="fecha_pedido"
                                               value="{{ old('fecha_pedido', date('Y-m-d')) }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="fecha_entrega_esperada" class="form-label">Fecha de Entrega Esperada *</label>
                                        <input type="date" class="form-control @error('fecha_entrega_esperada') is-invalid @enderror"
                                               id="fecha_entrega_esperada" name="fecha_entrega_esperada"
                                               value="{{ old('fecha_entrega_esperada') }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="estado" class="form-label">Estado *</label>
                                        <select class="form-select @error('estado') is-invalid @enderror"
                                                id="estado" name="estado" required>
                                            <option value="pendiente" {{ old('estado') == 'pendiente' ? 'selected' : 'selected' }}>Pendiente</option>
                                            <option value="confirmado" {{ old('estado') == 'confirmado' ? 'selected' : '' }}>Confirmado</option>
                                            <option value="entregado" {{ old('estado') == 'entregado' ? 'selected' : '' }}>Entregado</option>
                                            <option value="cancelado" {{ old('estado') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="observaciones" class="form-label">Observaciones</label>
                                        <textarea class="form-control @error('observaciones') is-invalid @enderror"
                                                  id="observaciones" name="observaciones" rows="4"
                                                  placeholder="Observaciones adicionales del pedido">{{ old('observaciones') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <!-- Productos del pedido -->
                            <div class="row">
                                <div class="col-12">
                                    <h6 style="color: #fd7900;">
                                        <i class="fas fa-box me-2"></i>Productos del Pedido
                                    </h6>

                                    <div class="mb-3">
                                        <button type="button" class="btn btn-orange" onclick="agregarProducto()">
                                            <i class="fas fa-plus me-1"></i>Agregar Producto
                                        </button>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="productosTable">
                                            <thead class="bg-dark-custom text-white">
                                                <tr>
                                                    <th width="40%">Producto</th>
                                                    <th width="20%">Cantidad</th>
                                                    <th width="20%">Precio Unitario</th>
                                                    <th width="15%">Subtotal</th>
                                                    <th width="5%">Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody id="productosBody">
                                                <!-- Los productos se agregarán aquí dinámicamente -->
                                            </tbody>
                                            <tfoot>
                                                <tr style="background-color: #f8f9fa;">
                                                    <th colspan="3" class="text-end">Total:</th>
                                                    <th><span id="totalGeneral">S/ 0.00</span></th>
                                                    <th></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-orange">
                                        <i class="fas fa-save me-1"></i>Crear Pedido
                                    </button>
                                    <a href="{{ route('pedidos.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times me-1"></i>Cancelar
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    let productoIndex = 0;
    const productos = @json($productos ?? []);

    function agregarProducto() {
        const tbody = document.getElementById('productosBody');
        const tr = document.createElement('tr');

        tr.innerHTML = `
            <td>
                <select class="form-select" name="productos[${productoIndex}][producto_id]" required onchange="actualizarSubtotal(${productoIndex})">
                    <option value="">Seleccione un producto</option>
                    ${productos.map(producto =>
                        `<option value="${producto.id}">${producto.nombre} - ${producto.codigo}</option>`
                    ).join('')}
                </select>
            </td>
            <td>
                <input type="number" class="form-control" name="productos[${productoIndex}][cantidad]"
                       step="0.01" min="0.01" required onchange="actualizarSubtotal(${productoIndex})">
            </td>
            <td>
                <input type="number" class="form-control" name="productos[${productoIndex}][precio_unitario]"
                       step="0.01" min="0.01" required onchange="actualizarSubtotal(${productoIndex})">
            </td>
            <td>
                <span class="subtotal">S/ 0.00</span>
            </td>
            <td>
                <button type="button" class="btn btn-sm btn-danger" onclick="eliminarProducto(this)">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;

        tbody.appendChild(tr);
        productoIndex++;
    }

    function eliminarProducto(button) {
        button.closest('tr').remove();
        actualizarTotal();
    }

    function actualizarSubtotal(index) {
        const row = document.querySelector(`input[name="productos[${index}][cantidad]"]`).closest('tr');
        const cantidad = parseFloat(row.querySelector(`input[name="productos[${index}][cantidad]"]`).value) || 0;
        const precio = parseFloat(row.querySelector(`input[name="productos[${index}][precio_unitario]"]`).value) || 0;
        const subtotal = cantidad * precio;

        row.querySelector('.subtotal').textContent = `S/ ${subtotal.toFixed(2)}`;
        actualizarTotal();
    }

    function actualizarTotal() {
        const subtotals = document.querySelectorAll('.subtotal');
        let total = 0;

        subtotals.forEach(subtotal => {
            const valor = parseFloat(subtotal.textContent.replace('S/ ', '')) || 0;
            total += valor;
        });

        document.getElementById('totalGeneral').textContent = `S/ ${total.toFixed(2)}`;
    }

    // Agregar al menos un producto al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
        agregarProducto();
    });

    // Validar que haya al menos un producto antes de enviar
    document.getElementById('pedidoForm').addEventListener('submit', function(e) {
        const productos = document.querySelectorAll('#productosBody tr');
        if (productos.length === 0) {
            e.preventDefault();
            alert('Debe agregar al menos un producto al pedido');
        }
    });
    </script>
</body>
</html>
