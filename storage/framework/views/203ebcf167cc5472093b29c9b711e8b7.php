<?php $__env->startSection('title', 'Crear Pedido'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid" style="margin: 0; padding: 0 15px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="fas fa-plus text-primary me-2"></i>
            Crear Nuevo Pedido
        </h2>
        <a href="<?php echo e(route('pedidos.index')); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>
            Volver al Listado
        </a>
    </div>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('pedidos.store')); ?>" method="POST" id="pedidoForm">
        <?php echo csrf_field(); ?>

        <!-- Información del Pedido -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Información del Pedido
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="proveedor_id" class="form-label">Proveedor *</label>
                            <select class="form-select <?php $__errorArgs = ['proveedor_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    id="proveedor_id" name="proveedor_id" required>
                                <option value="">Seleccione un proveedor</option>
                                <?php if(isset($proveedores)): ?>
                                    <?php $__currentLoopData = $proveedores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proveedor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($proveedor->id); ?>" <?php echo e(old('proveedor_id') == $proveedor->id ? 'selected' : ''); ?>>
                                            <?php echo e($proveedor->nombre); ?> - <?php echo e($proveedor->ruc); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </select>
                            <?php $__errorArgs = ['proveedor_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <label for="fecha_pedido" class="form-label">Fecha del Pedido *</label>
                            <input type="date" class="form-control <?php $__errorArgs = ['fecha_pedido'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   id="fecha_pedido" name="fecha_pedido"
                                   value="<?php echo e(old('fecha_pedido', date('Y-m-d'))); ?>" required>
                            <?php $__errorArgs = ['fecha_pedido'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="fecha_entrega_esperada" class="form-label">Fecha de Entrega Esperada *</label>
                            <input type="date" class="form-control <?php $__errorArgs = ['fecha_entrega_esperada'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   id="fecha_entrega_esperada" name="fecha_entrega_esperada"
                                   value="<?php echo e(old('fecha_entrega_esperada')); ?>" required>
                            <?php $__errorArgs = ['fecha_entrega_esperada'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <label for="estado" class="form-label">Estado *</label>
                            <select class="form-select <?php $__errorArgs = ['estado'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    id="estado" name="estado" required>
                                <option value="pendiente" <?php echo e(old('estado', 'pendiente') == 'pendiente' ? 'selected' : ''); ?>>Pendiente</option>
                                <option value="confirmado" <?php echo e(old('estado') == 'confirmado' ? 'selected' : ''); ?>>Confirmado</option>
                                <option value="entregado" <?php echo e(old('estado') == 'entregado' ? 'selected' : ''); ?>>Entregado</option>
                                <option value="cancelado" <?php echo e(old('estado') == 'cancelado' ? 'selected' : ''); ?>>Cancelado</option>
                            </select>
                            <?php $__errorArgs = ['estado'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="mb-3">
                            <label for="observaciones" class="form-label">Observaciones</label>
                            <textarea class="form-control <?php $__errorArgs = ['observaciones'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                      id="observaciones" name="observaciones" rows="3"
                                      placeholder="Observaciones adicionales del pedido"><?php echo e(old('observaciones')); ?></textarea>
                            <?php $__errorArgs = ['observaciones'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Productos del Pedido -->
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">
                    <i class="fas fa-box me-2"></i>
                    Productos del Pedido
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <button type="button" class="btn btn-success" onclick="agregarProducto()">
                        <i class="fas fa-plus me-2"></i>Agregar Producto
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="productosTable">
                        <thead class="table-dark">
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
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="3" class="text-end">Total:</th>
                                <th><span id="totalGeneral" class="text-success fw-bold">S/ 0.00</span></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <!-- Botones de Acción -->
        <div class="d-flex justify-content-end gap-2 mb-4">
            <a href="<?php echo e(route('pedidos.index')); ?>" class="btn btn-secondary">
                <i class="fas fa-times me-2"></i>Cancelar
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>Crear Pedido
            </button>
        </div>
    </form>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
let productoIndex = 0;
const productos = <?php echo json_encode($productos ?? [], 15, 512) ?>;

function agregarProducto() {
    const tbody = document.getElementById('productosBody');
    const tr = document.createElement('tr');

    tr.innerHTML = `
        <td>
            <select class="form-select" name="productos[${productoIndex}][producto_id]" required onchange="actualizarSubtotal(${productoIndex})">
                <option value="">Seleccione un producto</option>
                ${productos.map(producto =>
                    `<option value="${producto.id}" data-precio="${producto.precio_unitario || 0}">${producto.nombre} - ${producto.codigo || 'Sin código'}</option>`
                ).join('')}
            </select>
        </td>
        <td>
            <input type="number" class="form-control" name="productos[${productoIndex}][cantidad]"
                   step="0.01" min="0.01" required onchange="actualizarSubtotal(${productoIndex})"
                   placeholder="Cantidad">
        </td>
        <td>
            <input type="number" class="form-control" name="productos[${productoIndex}][precio_unitario]"
                   step="0.01" min="0.01" required onchange="actualizarSubtotal(${productoIndex})"
                   placeholder="Precio">
        </td>
        <td>
            <span class="subtotal fw-bold">S/ 0.00</span>
        </td>
        <td class="text-center">
            <button type="button" class="btn btn-sm btn-danger" onclick="eliminarProducto(this)" title="Eliminar producto">
                <i class="fas fa-trash"></i>
            </button>
        </td>
    `;

    tbody.appendChild(tr);

    // Auto-llenar precio si el producto tiene precio definido
    const selectProducto = tr.querySelector('select');
    const inputPrecio = tr.querySelector(`input[name="productos[${productoIndex}][precio_unitario]"]`);

    selectProducto.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const precio = selectedOption.getAttribute('data-precio');
        if (precio && precio > 0) {
            inputPrecio.value = precio;
            actualizarSubtotal(productoIndex);
        }
    });

    productoIndex++;
}

function eliminarProducto(button) {
    if (confirm('¿Está seguro de que desea eliminar este producto?')) {
        button.closest('tr').remove();
        actualizarTotal();
    }
}

function actualizarSubtotal(index) {
    const row = document.querySelector(`input[name="productos[${index}][cantidad]"]`).closest('tr');
    const cantidadInput = row.querySelector(`input[name="productos[${index}][cantidad]"]`);
    const precioInput = row.querySelector(`input[name="productos[${index}][precio_unitario]"]`);

    const cantidad = parseFloat(cantidadInput.value) || 0;
    const precio = parseFloat(precioInput.value) || 0;
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
        return false;
    }

    // Validar que todos los productos tengan datos completos
    let productosValidos = true;
    productos.forEach((row, index) => {
        const select = row.querySelector('select');
        const cantidad = row.querySelector('input[name*="cantidad"]');
        const precio = row.querySelector('input[name*="precio_unitario"]');

        if (!select.value || !cantidad.value || !precio.value) {
            productosValidos = false;
        }
    });

    if (!productosValidos) {
        e.preventDefault();
        alert('Todos los productos deben tener producto, cantidad y precio completos');
        return false;
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cesodo4\resources\views/pedidos/create.blade.php ENDPATH**/ ?>