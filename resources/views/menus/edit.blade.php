@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="fas fa-edit text-warning me-2"></i>
            Editar Menú: {{ $menu->nombre }}
        </h2>
        <div class="d-flex gap-2">
            <a href="{{ route('menus.show', $menu) }}" class="btn btn-outline-info">
                <i class="fas fa-eye me-1"></i>
                Ver
            </a>
            <a href="{{ route('menus.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i>
                Volver
            </a>
        </div>
    </div>

    <form action="{{ route('menus.update', $menu) }}" method="POST" id="menuForm">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- Información Principal -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header bg-warning text-dark">
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
                                    <i class="fas fa-tag me-2 text-warning"></i>Nombre del Menú *
                                </label>
                                <input type="text" name="nombre"
                                       class="form-control @error('nombre') is-invalid @enderror"
                                       value="{{ old('nombre', $menu->nombre) }}"
                                       placeholder="Ej: Menú Semanal - Semana 1 Enero"
                                       required>
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Fechas -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-calendar me-2 text-warning"></i>Fecha de Inicio *
                                </label>
                                <input type="date" name="fecha_inicio"
                                       class="form-control @error('fecha_inicio') is-invalid @enderror"
                                       value="{{ old('fecha_inicio', $menu->fecha_inicio?->format('Y-m-d')) }}"
                                       required>
                                @error('fecha_inicio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-calendar-check me-2 text-warning"></i>Fecha de Fin *
                                </label>
                                <input type="date" name="fecha_fin"
                                       class="form-control @error('fecha_fin') is-invalid @enderror"
                                       value="{{ old('fecha_fin', $menu->fecha_fin?->format('Y-m-d')) }}"
                                       required>
                                @error('fecha_fin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Descripción -->
                            <div class="col-md-12">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-clipboard me-2 text-warning"></i>Descripción
                                </label>
                                <!-- Tipo de Menú -->
                                <div class="mt-2 mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-list-alt me-2 text-warning"></i>Tipo de Menú *
                                    </label>
                                    <select name="tipo_menu"
                                            class="form-select @error('tipo_menu') is-invalid @enderror"
                                            required>
                                        @if(isset($tiposMenu) && is_array($tiposMenu))
                                            @foreach($tiposMenu as $key => $label)
                                                <option value="{{ $key }}" {{ (old('tipo_menu', $menu->tipo_menu) == $key) ? 'selected' : '' }}>{{ $label }}</option>
                                            @endforeach
                                        @else
                                            <option value="semanal" {{ (old('tipo_menu', $menu->tipo_menu) == 'semanal') ? 'selected' : '' }}>Menú Semanal</option>
                                            <option value="semanal_especial" {{ (old('tipo_menu', $menu->tipo_menu) == 'semanal_especial') ? 'selected' : '' }}>Menú Semanal Especial</option>
                                        @endif
                                    </select>
                                    @error('tipo_menu')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                                <!-- Items del Menú existentes -->
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-list me-2"></i>
                            Items del Menú
                        </h5>
                    </div>
                    <div class="card-body">
                        <div id="menu-items-container">
                            @if($menu->items && $menu->items->count() > 0)
                                @foreach($menu->items as $index => $item)
                                    <div class="card menu-item mb-3" data-item-index="{{ $index + 1 }}">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0">
                                                <i class="fas fa-utensils me-2"></i>Item #<span class="item-number">{{ $index + 1 }}</span>
                                            </h6>
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="eliminarItem(this)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                        <div class="card-body">
                                            <div class="row g-3">
                                                <div class="col-md-12">
                                                    <label class="form-label fw-bold">Nombre del Plato:</label>
                                                    <input type="text" name="items[{{ $index }}][nombre]"
                                                           class="form-control"
                                                           value="{{ old("items.{$index}.nombre", $item->nombre) }}"
                                                           placeholder="Ej: Desayuno - Lunes">
                                                    <input type="hidden" name="items[{{ $index }}][id]" value="{{ $item->id }}">
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">Día:</label>
                                                    <select name="items[{{ $index }}][dia_semana]" class="form-select">
                                                        <option value="lunes" {{ old("items.{$index}.dia_semana", $item->dia_semana) == 'lunes' ? 'selected' : '' }}>Lunes</option>
                                                        <option value="martes" {{ old("items.{$index}.dia_semana", $item->dia_semana) == 'martes' ? 'selected' : '' }}>Martes</option>
                                                        <option value="miercoles" {{ old("items.{$index}.dia_semana", $item->dia_semana) == 'miercoles' ? 'selected' : '' }}>Miércoles</option>
                                                        <option value="jueves" {{ old("items.{$index}.dia_semana", $item->dia_semana) == 'jueves' ? 'selected' : '' }}>Jueves</option>
                                                        <option value="viernes" {{ old("items.{$index}.dia_semana", $item->dia_semana) == 'viernes' ? 'selected' : '' }}>Viernes</option>
                                                        <option value="sabado" {{ old("items.{$index}.dia_semana", $item->dia_semana) == 'sabado' ? 'selected' : '' }}>Sábado</option>
                                                        <option value="domingo" {{ old("items.{$index}.dia_semana", $item->dia_semana) == 'domingo' ? 'selected' : '' }}>Domingo</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">Comida:</label>
                                                    <select name="items[{{ $index }}][tipo_comida]" class="form-select">
                                                        <option value="desayuno" {{ old("items.{$index}.tipo_comida", $item->tipo_comida) == 'desayuno' ? 'selected' : '' }}>Desayuno</option>
                                                        <option value="almuerzo" {{ old("items.{$index}.tipo_comida", $item->tipo_comida) == 'almuerzo' ? 'selected' : '' }}>Almuerzo</option>
                                                        <option value="cena" {{ old("items.{$index}.tipo_comida", $item->tipo_comida) == 'cena' ? 'selected' : '' }}>Cena</option>
                                                        <option value="merienda" {{ old("items.{$index}.tipo_comida", $item->tipo_comida) == 'merienda' ? 'selected' : '' }}>Merienda</option>
                                                    </select>
                                                </div>

                                                <div class="col-12">
                                                    <label class="form-label fw-bold">Productos e Ingredientes:</label>
                                                    <div class="productos-container">
                                                        @if($item->productos && $item->productos->count() > 0)
                                                            @foreach($item->productos as $prodIndex => $menuProducto)
                                                                <div class="producto-item mb-2 p-2 border rounded">
                                                                    <div class="row g-2 align-items-end">
                                                                        <div class="col-md-6">
                                                                            <select name="items[{{ $index }}][productos][{{ $prodIndex }}][producto_id]"
                                                                                    class="form-select select-producto">
                                                                                <option value="">Seleccionar producto...</option>
                                                                                @foreach($productos as $producto)
                                                                                    <option value="{{ $producto->id }}"
                                                                                            data-codigo="{{ $producto->codigo }}"
                                                                                            data-unidad="{{ $producto->unidad_medida }}"
                                                                                            data-stock="{{ $producto->inventarios->sum('cantidad_disponible') }}"
                                                                                            {{ $menuProducto->producto_id == $producto->id ? 'selected' : '' }}>
                                                                                        [{{ $producto->codigo }}] {{ $producto->nombre }}
                                                                                        (Stock: {{ $producto->inventarios->sum('cantidad_disponible') }} {{ $producto->unidad_medida }})
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                            <input type="hidden" name="items[{{ $index }}][productos][{{ $prodIndex }}][id]" value="{{ $menuProducto->id }}">
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <input type="number" name="items[{{ $index }}][productos][{{ $prodIndex }}][cantidad]"
                                                                                   class="form-control" placeholder="Cantidad"
                                                                                   value="{{ $menuProducto->cantidad }}"
                                                                                   step="0.01" min="0">
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <span class="unidad-medida text-muted small">{{ $menuProducto->producto->unidad_medida ?? '' }}</span>
                                                                        </div>
                                                                        <div class="col-md-1">
                                                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                                                    onclick="eliminarProducto(this)">
                                                                                <i class="fas fa-trash"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                    <button type="button" class="btn btn-sm btn-outline-primary mt-2"
                                                            onclick="agregarProducto(this)">
                                                        <i class="fas fa-plus me-1"></i>Agregar Producto
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <div class="text-center mt-3">
                            <button type="button" class="btn btn-outline-primary" onclick="agregarItem()">
                                <i class="fas fa-plus me-2"></i>Agregar Item
                            </button>
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
                                    <div class="fw-bold" id="resumen-personas">{{ $menu->numero_personas ?? 1 }}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="bg-light p-2 rounded">
                                    <small class="text-muted">Porciones/Persona</small>
                                    <div class="fw-bold" id="resumen-porciones">{{ $menu->porciones_por_persona ?? 1 }}</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="bg-primary text-white p-2 rounded">
                                    <small>Total de Porciones</small>
                                    <div class="fw-bold fs-5" id="resumen-total">{{ ($menu->numero_personas ?? 1) * ($menu->porciones_por_persona ?? 1) }}</div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between">
                            <span>Items del menú:</span>
                            <span class="fw-bold" id="resumen-items">{{ $menu->items ? $menu->items->count() : 0 }}</span>
                        </div>

                        <div class="d-flex justify-content-between">
                            <span>Condiciones consideradas:</span>
                            <span class="fw-bold" id="resumen-condiciones">{{ $menu->condiciones ? $menu->condiciones->count() : 0 }}</span>
                        </div>

                        <div class="d-flex justify-content-between">
                            <span>Estado actual:</span>
                            <span class="fw-bold">
                                @switch($menu->estado ?? 'borrador')
                                    @case('borrador')
                                        <span class="badge bg-secondary">Borrador</span>
                                        @break
                                    @case('activo')
                                        <span class="badge bg-success">Activo</span>
                                        @break
                                    @case('preparado')
                                        <span class="badge bg-info">Preparado</span>
                                        @break
                                    @case('completado')
                                        <span class="badge bg-primary">Completado</span>
                                        @break
                                    @default
                                        <span class="badge bg-dark">{{ ucfirst($menu->estado ?? 'Sin estado') }}</span>
                                @endswitch
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Verificación de Inventario -->
                <div class="card mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">
                            <i class="fas fa-warehouse me-2"></i>
                            Verificación de Inventario
                        </h5>
                    </div>
                    <div class="card-body">
                        <div id="inventario-status">
                            <div class="text-center text-muted">
                                <i class="fas fa-info-circle fa-2x mb-2"></i>
                                <p>Verificar disponibilidad de inventario</p>
                            </div>
                        </div>

                        <button type="button" class="btn btn-outline-warning w-100 mt-2"
                                onclick="verificarInventario()" id="btn-verificar">
                            <i class="fas fa-search me-2"></i>Verificar Disponibilidad
                        </button>
                    </div>
                </div>

                <!-- Acciones -->
                <div class="card">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">
                            <i class="fas fa-save me-2"></i>
                            Guardar Cambios
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-warning" id="btn-guardar">
                                <i class="fas fa-save me-2"></i>Actualizar Menú
                            </button>

                            <a href="{{ route('menus.show', $menu) }}" class="btn btn-outline-info">
                                <i class="fas fa-eye me-2"></i>Ver Menú
                            </a>

                            <a href="{{ route('menus.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                        </div>

                        <div class="alert alert-warning mt-3">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <small>
                                <strong>Atención:</strong> Los cambios en productos pueden afectar
                                el inventario si el menú ya fue preparado.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Templates -->
<template id="menu-item-template">
    <div class="card menu-item mb-3" data-item-index="">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="mb-0">
                <i class="fas fa-utensils me-2"></i>Item #<span class="item-number"></span>
            </h6>
            <button type="button" class="btn btn-sm btn-outline-danger" onclick="eliminarItem(this)">
                <i class="fas fa-trash"></i>
            </button>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-12">
                    <label class="form-label fw-bold">Nombre del Plato:</label>
                    <input type="text" name="items[][nombre]" class="form-control"
                           placeholder="Ej: Desayuno - Lunes">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Día:</label>
                    <select name="items[][dia_semana]" class="form-select">
                        <option value="lunes">Lunes</option>
                        <option value="martes">Martes</option>
                        <option value="miercoles">Miércoles</option>
                        <option value="jueves">Jueves</option>
                        <option value="viernes">Viernes</option>
                        <option value="sabado">Sábado</option>
                        <option value="domingo">Domingo</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Comida:</label>
                    <select name="items[][tipo_comida]" class="form-select">
                        <option value="desayuno">Desayuno</option>
                        <option value="almuerzo">Almuerzo</option>
                        <option value="cena">Cena</option>
                        <option value="merienda">Merienda</option>
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label fw-bold">Productos e Ingredientes:</label>
                    <div class="productos-container">
                        <!-- Los productos se agregarán aquí -->
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary mt-2"
                            onclick="agregarProducto(this)">
                        <i class="fas fa-plus me-1"></i>Agregar Producto
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<template id="producto-template">
    <div class="producto-item mb-2 p-2 border rounded">
        <div class="row g-2 align-items-end">
            <div class="col-md-6">
                <select name="items[][productos][][producto_id]" class="form-select select-producto">
                    <option value="">Seleccionar producto...</option>
                    @foreach($productos as $producto)
                        <option value="{{ $producto->id }}"
                                data-codigo="{{ $producto->codigo }}"
                                data-unidad="{{ $producto->unidad_medida }}"
                                data-stock="{{ $producto->inventarios->sum('cantidad_disponible') }}">
                            [{{ $producto->codigo }}] {{ $producto->nombre }}
                            (Stock: {{ $producto->inventarios->sum('cantidad_disponible') }} {{ $producto->unidad_medida }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <input type="number" name="items[][productos][][cantidad]"
                       class="form-control" placeholder="Cantidad"
                       step="0.01" min="0">
            </div>
            <div class="col-md-2">
                <span class="unidad-medida text-muted small"></span>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-sm btn-outline-danger"
                        onclick="eliminarProducto(this)">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    </div>
</template>

@push('scripts')
<script>
let itemCounter = {!! json_encode($menu->items ? $menu->items->count() : 0) !!};

document.addEventListener('DOMContentLoaded', function() {
    // Eventos para actualizar resumen
    document.getElementById('numero_personas').addEventListener('input', actualizarResumen);
    document.getElementById('porciones_por_persona').addEventListener('input', actualizarResumen);
    document.querySelector('select[name="condiciones_salud[]"]').addEventListener('change', actualizarResumen);

    // Validar fechas
    document.querySelector('input[name="fecha_inicio"]').addEventListener('change', validarFechas);
    document.querySelector('input[name="fecha_fin"]').addEventListener('change', validarFechas);

    // Inicializar eventos en productos existentes
    document.querySelectorAll('.select-producto').forEach(select => {
        select.addEventListener('change', function() {
            const option = this.options[this.selectedIndex];
            const unidadSpan = this.closest('.producto-item').querySelector('.unidad-medida');
            unidadSpan.textContent = option.dataset.unidad || '';
        });
    });
});

function agregarItem() {
    const template = document.getElementById('menu-item-template');
    const clone = template.content.cloneNode(true);

    itemCounter++;
    const itemDiv = clone.querySelector('.menu-item');
    itemDiv.setAttribute('data-item-index', itemCounter);
    itemDiv.querySelector('.item-number').textContent = itemCounter;

    // Actualizar nombres de los inputs para el nuevo item
    const inputs = clone.querySelectorAll('input, select');
    inputs.forEach(input => {
        if (input.name) {
            input.name = input.name.replace('[]', `[${itemCounter - 1}]`);
        }
    });

    document.getElementById('menu-items-container').appendChild(clone);
    actualizarResumen();
}

function eliminarItem(button) {
    const item = button.closest('.menu-item');
    if (confirm('¿Está seguro de que desea eliminar este item del menú?')) {
        item.remove();
        renumerarItems();
        actualizarResumen();
    }
}

function renumerarItems() {
    const items = document.querySelectorAll('.menu-item');
    items.forEach((item, index) => {
        item.querySelector('.item-number').textContent = index + 1;
    });
}

function agregarProducto(button) {
    const template = document.getElementById('producto-template');
    const clone = template.content.cloneNode(true);

    const container = button.parentElement.querySelector('.productos-container');
    container.appendChild(clone);

    // Agregar evento para actualizar unidad de medida
    const selectProducto = clone.querySelector('.select-producto');
    selectProducto.addEventListener('change', function() {
        const option = this.options[this.selectedIndex];
        const unidadSpan = this.closest('.producto-item').querySelector('.unidad-medida');
        unidadSpan.textContent = option.dataset.unidad || '';
    });
}

function eliminarProducto(button) {
    if (confirm('¿Está seguro de que desea eliminar este producto?')) {
        const producto = button.closest('.producto-item');
        producto.remove();
    }
}

function actualizarResumen() {
    const personas = document.getElementById('numero_personas').value || 1;
    const porciones = document.getElementById('porciones_por_persona').value || 1;
    const total = parseFloat(personas) * parseFloat(porciones);
    const items = document.querySelectorAll('.menu-item').length;
    const condiciones = document.querySelector('select[name="condiciones_salud[]"]').selectedOptions.length;

    document.getElementById('resumen-personas').textContent = personas;
    document.getElementById('resumen-porciones').textContent = porciones;
    document.getElementById('resumen-total').textContent = total.toFixed(1);
    document.getElementById('resumen-items').textContent = items;
    document.getElementById('resumen-condiciones').textContent = condiciones;
}

function verificarInventario() {
    // Simulación de verificación
    document.getElementById('inventario-status').innerHTML = `
        <div class="text-center">
            <div class="spinner-border text-warning" role="status">
                <span class="visually-hidden">Verificando...</span>
            </div>
            <p class="mt-2">Verificando inventario...</p>
        </div>
    `;

    setTimeout(() => {
        document.getElementById('inventario-status').innerHTML = `
            <div class="alert alert-success">
                <i class="fas fa-check-circle me-2"></i>
                Inventario verificado
            </div>
        `;
    }, 2000);
}

function validarFechas() {
    const fechaInicio = new Date(document.querySelector('input[name="fecha_inicio"]').value);
    const fechaFin = new Date(document.querySelector('input[name="fecha_fin"]').value);

    if (fechaInicio && fechaFin && fechaInicio > fechaFin) {
        alert('La fecha de inicio no puede ser posterior a la fecha de fin.');
        document.querySelector('input[name="fecha_fin"]').value = '';
    }
}


// Confirmación antes de guardar
document.getElementById('menuForm').addEventListener('submit', function(e) {
    if (!confirm('¿Está seguro de que desea guardar los cambios en el menú?')) {
        e.preventDefault();
    }
});
</script>
@endpush
@endsection
