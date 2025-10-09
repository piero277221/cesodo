<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pedidos
        </h2>
    </x-slot>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm" style="background-color: #2d3436;">
                <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #fd7900; color: white;">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2"></i>Editar Pedido: {{ $pedido->numero_pedido }}
                    </h5>
                    <div>
                        <a href="{{ route('pedidos.show', $pedido) }}" class="btn" style="background-color: #2d3436; color: white; border: 1px solid white;">
                            <i class="fas fa-eye me-1"></i>Ver
                        </a>
                        <a href="{{ route('pedidos.index') }}" class="btn" style="background-color: #2d3436; color: white; border: 1px solid white;">
                            <i class="fas fa-arrow-left me-1"></i>Volver
                        </a>
                    </div>
                </div>
                <div class="card-body" style="background-color: white;">

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('pedidos.update', $pedido) }}" method="POST" id="pedidoForm">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Información básica del pedido -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="proveedor_id" class="form-label">Proveedor *</label>
                                    <select class="form-select @error('proveedor_id') is-invalid @enderror"
                                            id="proveedor_id" name="proveedor_id" required>
                                        <option value="">Seleccione un proveedor</option>
                                        @foreach($proveedores as $proveedor)
                                            <option value="{{ $proveedor->id }}"
                                                {{ (old('proveedor_id', $pedido->proveedor_id) == $proveedor->id) ? 'selected' : '' }}>
                                                {{ $proveedor->nombre }} - {{ $proveedor->ruc }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('proveedor_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="fecha_pedido" class="form-label">Fecha del Pedido *</label>
                                    <input type="date" class="form-control @error('fecha_pedido') is-invalid @enderror"
                                           id="fecha_pedido" name="fecha_pedido"
                                           value="{{ old('fecha_pedido', $pedido->fecha_pedido->format('Y-m-d')) }}" required>
                                    @error('fecha_pedido')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="fecha_entrega_esperada" class="form-label">Fecha de Entrega Esperada *</label>
                                    <input type="date" class="form-control @error('fecha_entrega_esperada') is-invalid @enderror"
                                           id="fecha_entrega_esperada" name="fecha_entrega_esperada"
                                           value="{{ old('fecha_entrega_esperada', $pedido->fecha_entrega_esperada->format('Y-m-d')) }}" required>
                                    @error('fecha_entrega_esperada')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="fecha_entrega_real" class="form-label">Fecha de Entrega Real</label>
                                    <input type="date" class="form-control @error('fecha_entrega_real') is-invalid @enderror"
                                           id="fecha_entrega_real" name="fecha_entrega_real"
                                           value="{{ old('fecha_entrega_real', $pedido->fecha_entrega_real?->format('Y-m-d')) }}">
                                    @error('fecha_entrega_real')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="estado" class="form-label">Estado *</label>
                                    <select class="form-select @error('estado') is-invalid @enderror"
                                            id="estado" name="estado" required>
                                        <option value="pendiente" {{ old('estado', $pedido->estado) == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                        <option value="confirmado" {{ old('estado', $pedido->estado) == 'confirmado' ? 'selected' : '' }}>Confirmado</option>
                                        <option value="entregado" {{ old('estado', $pedido->estado) == 'entregado' ? 'selected' : '' }}>Entregado</option>
                                        <option value="cancelado" {{ old('estado', $pedido->estado) == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                                    </select>
                                    @error('estado')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="observaciones" class="form-label">Observaciones</label>
                                    <textarea class="form-control @error('observaciones') is-invalid @enderror"
                                              id="observaciones" name="observaciones" rows="7"
                                              placeholder="Observaciones adicionales del pedido">{{ old('observaciones', $pedido->observaciones) }}</textarea>
                                    @error('observaciones')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                                    <button type="button" class="btn" style="background-color: #fd7900; color: white;"
                                            onclick="agregarProducto()">
                                        <i class="fas fa-plus me-1"></i>Agregar Producto
                                    </button>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered" id="productosTable">
                                        <thead style="background-color: #2d3436; color: white;">
                                            <tr>
                                                <th width="40%">Producto</th>
                                                <th width="20%">Cantidad</th>
                                                <th width="20%">Precio Unitario</th>
                                                <th width="15%">Subtotal</th>
                                                <th width="5%">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody id="productosBody">
                                            @foreach($pedido->detalles as $index => $detalle)
                                                <tr>
                                                    <td>
                                                        <select class="form-select" name="productos[{{ $index }}][producto_id]" required onchange="actualizarSubtotal({{ $index }})">
                                                            <option value="">Seleccione un producto</option>
                                                            @foreach($productos as $producto)
                                                                <option value="{{ $producto->id }}"
                                                                    {{ $detalle->producto_id == $producto->id ? 'selected' : '' }}>
                                                                    {{ $producto->nombre }} - {{ $producto->codigo }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control" name="productos[{{ $index }}][cantidad]"
                                                               step="0.01" min="0.01" value="{{ $detalle->cantidad }}" required
                                                               onchange="actualizarSubtotal({{ $index }})">
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control" name="productos[{{ $index }}][precio_unitario]"
                                                               step="0.01" min="0.01" value="{{ $detalle->precio_unitario }}" required
                                                               onchange="actualizarSubtotal({{ $index }})">
                                                    </td>
                                                    <td>
                                                        <span class="subtotal">S/ {{ number_format($detalle->subtotal, 2) }}</span>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-danger" onclick="eliminarProducto(this)">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr style="background-color: #f8f9fa;">
                                                <th colspan="3" class="text-end">Total:</th>
                                                <th><span id="totalGeneral">S/ {{ number_format($pedido->total, 2) }}</span></th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <button type="submit" class="btn" style="background-color: #fd7900; color: white;">
                                    <i class="fas fa-save me-1"></i>Actualizar Pedido
                                </button>
                                <a href="{{ route('pedidos.show', $pedido) }}" class="btn btn-secondary">
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

@endsection

@section('scripts')
<script>
let productoIndex = {{ count($pedido->detalles) }};
const productos = {!! json_encode($productos) !!};

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

// Validar que haya al menos un producto antes de enviar
document.getElementById('pedidoForm').addEventListener('submit', function(e) {
    const productos = document.querySelectorAll('#productosBody tr');
    if (productos.length === 0) {
        e.preventDefault();
        alert('Debe agregar al menos un producto al pedido');
    }
});
</script>
</x-app-layout>