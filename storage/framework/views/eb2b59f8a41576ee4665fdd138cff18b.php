<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="fas fa-plus-circle text-success me-2"></i>
            Nuevo Menú Semanal
        </h2>
        <a href="<?php echo e(route('menus.index')); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>
            Volver
        </a>
    </div>

    <form action="<?php echo e(route('menus.store')); ?>" method="POST" id="menuForm">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="estado" value="PROGRAMADO">

        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            Información del Menú
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <!-- Nombre del Menú -->
                            <div class="col-md-12">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-tag me-2 text-success"></i>Nombre del Menú *
                                </label>
                                <input type="text" name="nombre"
                                       class="form-control <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       value="<?php echo e(old('nombre')); ?>"
                                       placeholder="Ej: Menú Semanal - Semana 1 Enero"
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

                            <!-- Fechas -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-calendar me-2 text-success"></i>Fecha de Inicio *
                                </label>
                                <input type="date" name="fecha_inicio"
                                       class="form-control <?php $__errorArgs = ['fecha_inicio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       value="<?php echo e(old('fecha_inicio')); ?>"
                                       required>
                                <?php $__errorArgs = ['fecha_inicio'];
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

                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-calendar-check me-2 text-success"></i>Fecha de Fin *
                                </label>
                                <input type="date" name="fecha_fin"
                                       class="form-control <?php $__errorArgs = ['fecha_fin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       value="<?php echo e(old('fecha_fin')); ?>"
                                       required>
                                <?php $__errorArgs = ['fecha_fin'];
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

                            <!-- Descripción -->
                            <div class="col-md-12">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-clipboard me-2 text-success"></i>Descripción
                                </label>
                                <textarea name="descripcion"
                                          class="form-control <?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                          rows="3"
                                          placeholder="Describa las características especiales de este menú"><?php echo e(old('descripcion')); ?></textarea>
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

                            <!-- Tipo de Menú -->
                            <div class="col-md-12">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-list-alt me-2 text-success"></i>Tipo de Menú *
                                </label>
                                <select name="tipo_menu"
                                        class="form-select <?php $__errorArgs = ['tipo_menu'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        required>
                                    <option value="semanal">Menú Semanal</option>
                                    <option value="semanal_especial">Menú Semanal Especial</option>
                                </select>
                                <?php $__errorArgs = ['tipo_menu'];
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

                            <!-- Selección de Días -->
                            <div class="col-md-12">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-calendar-week me-2 text-success"></i>Días de la Semana *
                                </label>
                                <div class="row g-2">
                                    <?php
                                        $diasSemana = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'];
                                    ?>
                                    <?php $__currentLoopData = $diasSemana; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-auto">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                       name="dias_seleccionados[]"
                                                       value="<?php echo e($dia); ?>"
                                                       id="dia-<?php echo e($dia); ?>"
                                                       <?php echo e(in_array($dia, old('dias_seleccionados', [])) ? 'checked' : ''); ?>>
                                                <label class="form-check-label" for="dia-<?php echo e($dia); ?>">
                                                    <?php echo e(ucfirst($dia)); ?>

                                                </label>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                                <?php $__errorArgs = ['dias_seleccionados'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Selección de Tipos de Comida -->
                            <div class="col-md-12">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-utensils me-2 text-success"></i>Tipos de Comida *
                                </label>
                                <div class="row g-2">
                                    <?php
                                        $tiposComida = ['desayuno', 'almuerzo', 'cena'];
                                    ?>
                                    <?php $__currentLoopData = $tiposComida; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-auto">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                       name="tipos_comida[]"
                                                       value="<?php echo e($tipo); ?>"
                                                       id="tipo-<?php echo e($tipo); ?>"
                                                       <?php echo e(in_array($tipo, old('tipos_comida', [])) ? 'checked' : ''); ?>>
                                                <label class="form-check-label" for="tipo-<?php echo e($tipo); ?>">
                                                    <?php echo e(ucfirst($tipo)); ?>

                                                </label>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                                <?php $__errorArgs = ['tipos_comida'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Número de Personas -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-users me-2 text-success"></i>Número de Personas *
                                </label>
                                <input type="number" name="numero_personas" id="numero_personas"
                                       class="form-control <?php $__errorArgs = ['numero_personas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       value="<?php echo e(old('numero_personas', 1)); ?>"
                                       min="1" max="1000"
                                       required>
                                <?php $__errorArgs = ['numero_personas'];
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

                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-utensils me-2 text-success"></i>Porciones por Persona *
                                </label>
                                <input type="number" name="porciones_por_persona" id="porciones_por_persona"
                                       class="form-control <?php $__errorArgs = ['porciones_por_persona'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       value="<?php echo e(old('porciones_por_persona', 1)); ?>"
                                       min="1" max="10" step="0.5"
                                       required>
                                <?php $__errorArgs = ['porciones_por_persona'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <small class="text-muted">Puede usar decimales (ej: 1.5)</small>
                            </div>

                            <!-- Tabla de Menú -->
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="tabla-menu">
                                        <thead>
                                            <tr>
                                                <th>DÍA</th>
                                                <!-- Los encabezados se generarán dinámicamente -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- El contenido se generará dinámicamente -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Condiciones de Salud -->
                            <div class="col-md-12">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-heartbeat me-2 text-success"></i>Condiciones de Salud a Considerar
                                </label>
                                <select name="condiciones_salud[]"
                                        class="form-select <?php $__errorArgs = ['condiciones_salud'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        multiple size="4">
                                    <?php if(isset($condicionesSalud) && $condicionesSalud->count() > 0): ?>
                                        <?php $__currentLoopData = $condicionesSalud; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $condicion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($condicion->id); ?>"
                                                    <?php echo e(in_array($condicion->id, old('condiciones_salud', [])) ? 'selected' : ''); ?>>
                                                <?php echo e($condicion->nombre); ?>

                                                <?php if($condicion->descripcion): ?>
                                                    - <?php echo e(Str::limit($condicion->descripcion, 50)); ?>

                                                <?php endif; ?>
                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <option value="" disabled>No hay condiciones de salud registradas</option>
                                    <?php endif; ?>
                                </select>
                                <?php $__errorArgs = ['condiciones_salud'];
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
                                    Las condiciones seleccionadas filtrarán automáticamente los productos disponibles
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel Lateral -->
            <div class="col-lg-4">
                <!-- Resumen -->
                <div class="card mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-calculator me-2"></i>
                            Resumen del Menú
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-2 text-center">
                            <div class="col-6">
                                <div class="bg-light p-2 rounded">
                                    <small class="text-muted">Personas</small>
                                    <div class="fw-bold" id="resumen-personas">1</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="bg-light p-2 rounded">
                                    <small class="text-muted">Porciones/Persona</small>
                                    <div class="fw-bold" id="resumen-porciones">1</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="bg-primary text-white p-2 rounded">
                                    <small>Total de Porciones</small>
                                    <div class="fw-bold fs-5" id="resumen-total">1</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Acciones -->
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-save me-2"></i>
                            Guardar Menú
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-2"></i>Guardar Menú
                            </button>
                            <a href="<?php echo e(route('menus.index')); ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php
    $estados = ['planificado', 'preparado', 'servido', 'cancelado'];
    $diasSemana = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'];
    $tiposComida = ['desayuno', 'almuerzo', 'cena', 'refrigerio'];
?>

<?php $__env->startPush('scripts'); ?>
<script>
// Definir las constantes para los valores de los enums
const ESTADOS = <?php echo json_encode($estados, 15, 512) ?>;
const DIAS_SEMANA = <?php echo json_encode($diasSemana, 15, 512) ?>;
const TIPOS_COMIDA = <?php echo json_encode($tiposComida, 15, 512) ?>;

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('menuForm');
    const numPersonasInput = document.getElementById('numero_personas');
    const porcionesInput = document.getElementById('porciones_por_persona');
    const fechaInicioInput = document.querySelector('input[name="fecha_inicio"]');

    // Actualizar fechas programadas cuando cambie la fecha de inicio
    fechaInicioInput.addEventListener('change', function() {
        document.querySelectorAll('input[name$="[fecha_programada]"]').forEach(input => {
            input.value = this.value;
        });
    });

    // Sincronizar selección de recetas con campos ocultos
    document.addEventListener('change', function(e) {
        if (e.target.matches('select[name^="recetas["]')) {
            const container = e.target.closest('.menu-plato-container');
            const recetaIdInput = container.querySelector('.receta-id-input');
            recetaIdInput.value = e.target.value;
        }
    });

    // Función para actualizar la tabla del menú
    function actualizarTablaMenu() {
        const diasSeleccionados = Array.from(document.querySelectorAll('input[name="dias_seleccionados[]"]:checked')).map(cb => JSON.stringify(cb.value));
        const tiposComidaSeleccionados = Array.from(document.querySelectorAll('input[name="tipos_comida[]"]:checked')).map(cb => JSON.stringify(cb.value));
        const tablaMenu = document.getElementById('tabla-menu');
        const tbody = tablaMenu.querySelector('tbody');
        tbody.innerHTML = '';

        // Actualizar encabezados
        const thead = tablaMenu.querySelector('thead tr');
        thead.innerHTML = `
            <th>DÍA</th>
            ${tiposComidaSeleccionados.map(tipo =>
                `<th>${JSON.parse(tipo).charAt(0).toUpperCase() + JSON.parse(tipo).slice(1)}</th>`
            ).join('')}
            <th>ACCIONES</th>
        `;

        // Generar filas
        diasSeleccionados.forEach(diaJson => {
            const dia = JSON.parse(diaJson);
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td class="fw-bold">${dia.charAt(0).toUpperCase() + dia.slice(1)}</td>
                ${tiposComidaSeleccionados.map(tipoJson => {
                    const tipo = JSON.parse(tipoJson);
                    return `
                    <td>
                        <div class="menu-plato-container">
                            <select name="recetas[${dia}][${tipo}]" class="form-select">
                                <option value="">Seleccione una receta</option>
                                <?php $__currentLoopData = $recetas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $receta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($receta->id); ?>"><?php echo e($receta->nombre); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <input type="hidden" name="menu_platos[${dia}][${tipo}][receta_id]" class="receta-id-input">
                            <input type="hidden" name="menu_platos[${dia}][${tipo}][dia_semana]" value="${dia}">
                            <input type="hidden" name="menu_platos[${dia}][${tipo}][tipo_comida]" value="${tipo}">
                            <input type="hidden" name="menu_platos[${dia}][${tipo}][estado]" value="planificado">
                            <input type="hidden" name="menu_platos[${dia}][${tipo}][porciones_planificadas]" value="1">
                            <input type="hidden" name="menu_platos[${dia}][${tipo}][fecha_programada]" value="<?php echo e(date('Y-m-d')); ?>">
                        </div>
                    </td>
                `}).join('')}
                <td>
                    <button type="button" class="btn btn-info btn-sm verificar-ingredientes" data-dia="${dia}">
                        <i class="fas fa-clipboard-check"></i>
                        Verificar
                    </button>
                </td>
            `;
            tbody.appendChild(tr);
        });

        actualizarResumen();
    }

    // Función para actualizar el resumen
    function actualizarResumen() {
        const personas = parseInt(numPersonasInput.value) || 1;
        const porciones = parseFloat(porcionesInput.value) || 1;
        const total = personas * porciones;

        document.getElementById('resumen-personas').textContent = personas;
        document.getElementById('resumen-porciones').textContent = porciones;
        document.getElementById('resumen-total').textContent = total.toFixed(1);
    }

    // Función para verificar ingredientes
    function verificarIngredientes(dia) {
        const recetas = {};
        document.querySelectorAll(`select[name^="recetas[${dia}]"]`).forEach(select => {
            if (select.value) {
                const tipo = select.name.match(/\[(.*?)\]\[(.*?)\]/)[2];
                recetas[tipo] = select.value;
            }
        });

        if (Object.keys(recetas).length === 0) {
            alert('Seleccione al menos una receta para verificar ingredientes.');
            return;
        }

        fetch('/menus/verificar-ingredientes', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                recetas,
                numero_personas: numPersonasInput.value
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('✅ Todos los ingredientes están disponibles');
            } else {
                alert('⚠️ Faltan ingredientes:\n\n' + data.faltantes.join('\n'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al verificar ingredientes');
        });
    }

    // Event Listeners
    document.querySelectorAll('input[name="dias_seleccionados[]"], input[name="tipos_comida[]"]')
        .forEach(checkbox => checkbox.addEventListener('change', actualizarTablaMenu));

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('verificar-ingredientes')) {
            verificarIngredientes(e.target.dataset.dia);
        }
    });

    [numPersonasInput, porcionesInput].forEach(input => {
        input.addEventListener('input', actualizarResumen);
    });

    // Validar fechas
    const fechaInicio = document.querySelector('input[name="fecha_inicio"]');
    const fechaFin = document.querySelector('input[name="fecha_fin"]');

    [fechaInicio, fechaFin].forEach(input => {
        input.addEventListener('change', function() {
            if (fechaInicio.value && fechaFin.value) {
                if (new Date(fechaInicio.value) > new Date(fechaFin.value)) {
                    alert('La fecha de inicio no puede ser posterior a la fecha de fin.');
                    fechaFin.value = '';
                }
            }
        });
    });

    // Inicializar la tabla
    actualizarTablaMenu();
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cesodo4\resources\views/menus/create.blade.php ENDPATH**/ ?>