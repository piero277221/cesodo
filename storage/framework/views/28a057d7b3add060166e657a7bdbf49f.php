<?php $__env->startSection('title', 'Editar Producto'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">
                    <i class="fas fa-edit text-warning me-2"></i>
                    Editar Producto: <?php echo e(isset($producto) ? $producto->nombre : 'Producto'); ?>

                </h2>
                <div>
                    <?php if(isset($producto)): ?>
                    <a href="<?php echo e(route('productos.show', $producto)); ?>" class="btn btn-info me-2">
                        <i class="fas fa-eye me-1"></i>
                        Ver Detalles
                    </a>
                    <?php endif; ?>
                    <a href="<?php echo e(route('productos.index')); ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>
                        Volver
                    </a>
                </div>
            </div>

            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <h6><i class="fas fa-exclamation-triangle me-1"></i> Errores de validación:</h6>
                    <ul class="mb-0">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if(isset($producto)): ?>
            <form action="<?php echo e(route('productos.update', $producto)); ?>" method="POST" id="editProductoForm">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="row">
                    <!-- Información Básica -->
                    <div class="col-lg-8 mb-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-header bg-warning text-dark">
                                <h5 class="mb-0">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Información del Producto
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="codigo" class="form-label">Código <span class="text-danger">*</span></label>
                                        <input type="text"
                                               class="form-control <?php $__errorArgs = ['codigo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               id="codigo"
                                               name="codigo"
                                               value="<?php echo e(old('codigo', $producto->codigo)); ?>"
                                               placeholder="Ej: PROD001"
                                               required>
                                        <?php $__errorArgs = ['codigo'];
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

                                    <div class="col-md-6 mb-3">
                                        <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                                        <input type="text"
                                               class="form-control <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               id="nombre"
                                               name="nombre"
                                               value="<?php echo e(old('nombre', $producto->nombre)); ?>"
                                               placeholder="Nombre del producto"
                                               required>
                                        <?php $__errorArgs = ['nombre'];
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

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="categoria_id" class="form-label">Categoría <span class="text-danger">*</span></label>
                                        <select class="form-select <?php $__errorArgs = ['categoria_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                id="categoria_id"
                                                name="categoria_id"
                                                required>
                                            <option value="">Seleccionar categoría</option>
                                            <?php if(isset($categorias)): ?>
                                                <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($categoria->id); ?>"
                                                        <?php echo e(old('categoria_id', $producto->categoria_id) == $categoria->id ? 'selected' : ''); ?>>
                                                        <?php echo e($categoria->nombre); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </select>
                                        <?php $__errorArgs = ['categoria_id'];
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

                                    <div class="col-md-6 mb-3">
                                        <label for="unidad_medida" class="form-label">Unidad de Medida <span class="text-danger">*</span></label>
                                        <select class="form-select <?php $__errorArgs = ['unidad_medida'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                id="unidad_medida"
                                                name="unidad_medida"
                                                required>
                                            <option value="">Seleccionar unidad</option>
                                            <option value="kg" <?php echo e(old('unidad_medida', $producto->unidad_medida) == 'kg' ? 'selected' : ''); ?>>Kilogramos (kg)</option>
                                            <option value="g" <?php echo e(old('unidad_medida', $producto->unidad_medida) == 'g' ? 'selected' : ''); ?>>Gramos (g)</option>
                                            <option value="l" <?php echo e(old('unidad_medida', $producto->unidad_medida) == 'l' ? 'selected' : ''); ?>>Litros (l)</option>
                                            <option value="ml" <?php echo e(old('unidad_medida', $producto->unidad_medida) == 'ml' ? 'selected' : ''); ?>>Mililitros (ml)</option>
                                            <option value="unidad" <?php echo e(old('unidad_medida', $producto->unidad_medida) == 'unidad' ? 'selected' : ''); ?>>Unidad</option>
                                            <option value="paquete" <?php echo e(old('unidad_medida', $producto->unidad_medida) == 'paquete' ? 'selected' : ''); ?>>Paquete</option>
                                            <option value="caja" <?php echo e(old('unidad_medida', $producto->unidad_medida) == 'caja' ? 'selected' : ''); ?>>Caja</option>
                                        </select>
                                        <?php $__errorArgs = ['unidad_medida'];
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

                                <div class="mb-3">
                                    <label for="descripcion" class="form-label">Descripción</label>
                                    <textarea class="form-control <?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                              id="descripcion"
                                              name="descripcion"
                                              rows="3"
                                              placeholder="Descripción detallada del producto"><?php echo e(old('descripcion', $producto->descripcion)); ?></textarea>
                                    <?php $__errorArgs = ['descripcion'];
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

                    <!-- Información Financiera -->
                    <div class="col-lg-4 mb-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-dollar-sign me-2"></i>
                                    Información Financiera
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="precio_unitario" class="form-label">Precio Unitario <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">S/</span>
                                        <input type="number"
                                               class="form-control <?php $__errorArgs = ['precio_unitario'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               id="precio_unitario"
                                               name="precio_unitario"
                                               value="<?php echo e(old('precio_unitario', $producto->precio_unitario)); ?>"
                                               step="0.01"
                                               min="0"
                                               placeholder="0.00"
                                               required>
                                        <?php $__errorArgs = ['precio_unitario'];
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

                                <div class="mb-3">
                                    <label for="stock_actual" class="form-label">Stock Actual</label>
                                    <input type="number"
                                           class="form-control <?php $__errorArgs = ['stock_actual'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           id="stock_actual"
                                           name="stock_actual"
                                           value="<?php echo e(old('stock_actual', $producto->stock_actual)); ?>"
                                           min="0"
                                           placeholder="0">
                                    <?php $__errorArgs = ['stock_actual'];
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
                                    <label for="stock_minimo" class="form-label">Stock Mínimo</label>
                                    <input type="number"
                                           class="form-control <?php $__errorArgs = ['stock_minimo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           id="stock_minimo"
                                           name="stock_minimo"
                                           value="<?php echo e(old('stock_minimo', $producto->stock_minimo)); ?>"
                                           min="0"
                                           placeholder="10">
                                    <?php $__errorArgs = ['stock_minimo'];
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
                                    <label for="stock_maximo" class="form-label">Stock Máximo</label>
                                    <input type="number"
                                           class="form-control <?php $__errorArgs = ['stock_maximo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           id="stock_maximo"
                                           name="stock_maximo"
                                           value="<?php echo e(old('stock_maximo', $producto->stock_maximo)); ?>"
                                           min="0"
                                           placeholder="100">
                                    <?php $__errorArgs = ['stock_maximo'];
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

                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           id="es_perecedero"
                                           name="es_perecedero"
                                           value="1"
                                           <?php echo e(old('es_perecedero', $producto->es_perecedero) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="es_perecedero">
                                        Producto perecedero
                                    </label>
                                </div>

                                <div class="mt-3">
                                    <label for="fecha_vencimiento" class="form-label">
                                        <i class="fas fa-calendar-times me-1 text-warning"></i>
                                        Fecha de Vencimiento
                                    </label>
                                    <input type="date"
                                           class="form-control <?php $__errorArgs = ['fecha_vencimiento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           id="fecha_vencimiento"
                                           name="fecha_vencimiento"
                                           value="<?php echo e(old('fecha_vencimiento', $producto->fecha_vencimiento ? $producto->fecha_vencimiento->format('Y-m-d') : '')); ?>"
                                           min="<?php echo e(date('Y-m-d')); ?>">
                                    <?php $__errorArgs = ['fecha_vencimiento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle"></i>
                                        Opcional. Si el producto no vence, dejar en blanco.
                                    </small>
                                    <?php if($producto->fecha_vencimiento): ?>
                                        <div class="mt-2">
                                            <?php if($producto->estaVencido()): ?>
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                                    <?php echo e($producto->tiempoVencimientoTexto()); ?>

                                                </span>
                                            <?php elseif($producto->estaProximoAVencer()): ?>
                                                <span class="badge bg-warning text-dark">
                                                    <i class="fas fa-clock me-1"></i>
                                                    <?php echo e($producto->tiempoVencimientoTexto()); ?>

                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check me-1"></i>
                                                    <?php echo e($producto->tiempoVencimientoTexto()); ?>

                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="mt-3">
                                    <label for="dias_alerta_vencimiento" class="form-label">
                                        <i class="fas fa-bell me-1 text-info"></i>
                                        Días de Alerta antes del Vencimiento
                                    </label>
                                    <input type="number"
                                           class="form-control <?php $__errorArgs = ['dias_alerta_vencimiento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           id="dias_alerta_vencimiento"
                                           name="dias_alerta_vencimiento"
                                           value="<?php echo e(old('dias_alerta_vencimiento', $producto->dias_alerta_vencimiento ?? 30)); ?>"
                                           min="1"
                                           max="365">
                                    <?php $__errorArgs = ['dias_alerta_vencimiento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle"></i>
                                        Días antes del vencimiento para recibir notificaciones (por defecto 30 días).
                                    </small>
                                </div>

                                <div class="mt-3">
                                    <label for="estado" class="form-label">Estado <span class="text-danger">*</span></label>
                                    <select class="form-select <?php $__errorArgs = ['estado'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="estado"
                                            name="estado"
                                            required>
                                        <option value="">Seleccionar estado</option>
                                        <option value="activo" <?php echo e(old('estado', $producto->estado) == 'activo' ? 'selected' : ''); ?>>Activo</option>
                                        <option value="inactivo" <?php echo e(old('estado', $producto->estado) == 'inactivo' ? 'selected' : ''); ?>>Inactivo</option>
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
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <a href="<?php echo e(route('productos.index')); ?>" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>
                                Cancelar
                            </a>

                            <div>
                                <button type="submit" class="btn btn-warning" id="btnActualizar">
                                    <i class="fas fa-save me-1"></i>
                                    Actualizar Producto
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <?php else: ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle me-2"></i>
                No se encontró el producto a editar.
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validación del formulario
    const form = document.getElementById('editProductoForm');
    const btnActualizar = document.getElementById('btnActualizar');

    if(form && btnActualizar) {
        form.addEventListener('submit', function(e) {
            btnActualizar.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Actualizando...';
            btnActualizar.disabled = true;
        });

        // Validación de stock mínimo vs máximo
        const stockMinimo = document.getElementById('stock_minimo');
        const stockMaximo = document.getElementById('stock_maximo');

        function validarStock() {
            const min = parseFloat(stockMinimo.value) || 0;
            const max = parseFloat(stockMaximo.value) || 0;

            if (min > 0 && max > 0 && min >= max) {
                stockMaximo.setCustomValidity('El stock máximo debe ser mayor al stock mínimo');
            } else {
                stockMaximo.setCustomValidity('');
            }
        }

        stockMinimo.addEventListener('change', validarStock);
        stockMaximo.addEventListener('change', validarStock);
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cesodo4\resources\views/productos/edit.blade.php ENDPATH**/ ?>