@extends('layouts.app')


<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="fas fa-utensils text-primary me-2"></i>
            Nueva Receta
        </h2>
        <a href="{{ route('recetas.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>
            Volver al Listado
        </a>
    </div>

    <form action="{{ route('recetas.store') }}" method="POST" id="recetaForm">
        @csrf

        <div class="row">
            <div class="col-md-8">
                <!-- Información Principal -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            Información de la Receta
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nombre" class="form-label">Nombre de la Receta *</label>
                                <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                                       id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="tiempo_preparacion" class="form-label">Tiempo de Preparación (min) *</label>
                                <input type="number" class="form-control @error('tiempo_preparacion') is-invalid @enderror"
                                       id="tiempo_preparacion" name="tiempo_preparacion"
                                       value="{{ old('tiempo_preparacion') }}" required min="1">
                                @error('tiempo_preparacion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="porciones" class="form-label">Porciones *</label>
                                <input type="number" class="form-control @error('porciones') is-invalid @enderror"
                                       id="porciones" name="porciones" value="{{ old('porciones') }}" required min="1">
                                @error('porciones')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="tipo_plato" class="form-label">Tipo de Plato *</label>
                                <select class="form-select @error('tipo_plato') is-invalid @enderror"
                                        id="tipo_plato" name="tipo_plato" required>
                                    <option value="">Seleccione un tipo...</option>
                                    <option value="entrada" {{ old('tipo_plato') == 'entrada' ? 'selected' : '' }}>Entrada</option>
                                    <option value="plato_principal" {{ old('tipo_plato') == 'plato_principal' ? 'selected' : '' }}>Plato Principal</option>
                                    <option value="postre" {{ old('tipo_plato') == 'postre' ? 'selected' : '' }}>Postre</option>
                                    <option value="bebida" {{ old('tipo_plato') == 'bebida' ? 'selected' : '' }}>Bebida</option>
                                    <option value="guarnicion" {{ old('tipo_plato') == 'guarnicion' ? 'selected' : '' }}>Guarnición</option>
                                </select>
                                @error('tipo_plato')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="dificultad" class="form-label">Dificultad *</label>
                                <select class="form-select @error('dificultad') is-invalid @enderror"
                                        id="dificultad" name="dificultad" required>
                                    <option value="facil" {{ old('dificultad') == 'facil' ? 'selected' : '' }}>Fácil</option>
                                    <option value="media" {{ old('dificultad') == 'media' ? 'selected' : '' }}>Media</option>
                                    <option value="dificil" {{ old('dificultad') == 'dificil' ? 'selected' : '' }}>Difícil</option>
                                </select>
                                @error('dificultad')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="descripcion" class="form-label">Descripción (incluye aquí los ingredientes)</label>
                                <textarea class="form-control @error('descripcion') is-invalid @enderror"
                                          id="descripcion" name="descripcion" rows="4"
                                          placeholder="Escribe la descripción de la receta. Puedes incluir los ingredientes aquí y se extraerán automáticamente...">{{ old('descripcion') }}</textarea>
                                <button type="button" class="btn btn-outline-success mt-2" id="analizar-ingredientes">
                                    <i class="fas fa-search me-2"></i>Analizar ingredientes desde descripción
                                </button>
                                @error('descripcion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="instrucciones" class="form-label">Instrucciones Generales *</label>
                                <textarea class="form-control @error('instrucciones') is-invalid @enderror"
                                          id="instrucciones" name="instrucciones" rows="3" required>{{ old('instrucciones') }}</textarea>
                                @error('instrucciones')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="pasos_preparacion" class="form-label">Pasos de Preparación *</label>
                                <div id="pasos-container">
                                    @if(old('pasos_preparacion'))
                                        @foreach(old('pasos_preparacion') as $index => $paso)
                                            <div class="input-group mb-2">
                                                <span class="input-group-text">{{ $index + 1 }}</span>
                                                <input type="text" class="form-control"
                                                       name="pasos_preparacion[]" value="{{ $paso }}" required>
                                                <button type="button" class="btn btn-danger eliminar-paso">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="input-group mb-2">
                                            <span class="input-group-text">1</span>
                                            <input type="text" class="form-control"
                                                   name="pasos_preparacion[]" required>
                                            <button type="button" class="btn btn-danger eliminar-paso">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    @endif
                                </div>
                                <button type="button" class="btn btn-outline-primary mt-2" id="agregar-paso">
                                    <i class="fas fa-plus me-2"></i>Agregar Paso
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ingredientes -->
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-carrot me-2"></i>
                            Ingredientes
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Las cantidades deben ser especificadas según la unidad de medida del producto.
                        </div>


                        <div id="ingredientes-advertencias"></div>
                        <div id="ingredientes-container">
                            <!-- Aquí se llenarán los ingredientes detectados automáticamente -->
                            </div>

                        <button type="button" class="btn btn-outline-success" id="agregar-ingrediente">
                            <i class="fas fa-plus me-2"></i>Agregar Ingrediente
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <!-- Configuración Adicional -->
                <div class="card mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-cog me-2"></i>
                            Configuración Adicional
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="estado" class="form-label">Estado *</label>
                            <select class="form-select @error('estado') is-invalid @enderror"
                                    id="estado" name="estado" required>
                                <option value="">Seleccione un estado...</option>
                                <option value="activo" {{ old('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                                <option value="inactivo" {{ old('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                            @error('estado')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="es_especial"
                                   name="es_especial" {{ old('es_especial') ? 'checked' : '' }}>
                            <label class="form-check-label" for="es_especial">
                                Es una receta especial
                            </label>
                        </div>

                        <div class="mb-3">
                            <label for="ingredientes_especiales" class="form-label">
                                Ingredientes Especiales o Alérgenos
                            </label>
                            <input type="text" class="form-control" id="ingredientes_especiales"
                                   name="ingredientes_especiales" value="{{ old('ingredientes_especiales') }}">
                            <div class="form-text">
                                Separe los ingredientes con comas
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="notas" class="form-label">Notas</label>
                            <textarea class="form-control @error('notas') is-invalid @enderror"
                                    id="notas" name="notas" rows="3">{{ old('notas') }}</textarea>
                            @error('notas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="observaciones" class="form-label">Observaciones</label>
                            <textarea class="form-control" id="observaciones"
                                      name="observaciones" rows="3">{{ old('observaciones') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Información de Costos -->
                <div class="card">
                    <div class="card-header bg-warning">
                        <h5 class="mb-0">
                            <i class="fas fa-dollar-sign me-2"></i>
                            Información de Costos
                        </h5>
                    </div>
                    <div class="card-body">
                        <div id="costos-container">
                            <p class="mb-2">Costo total de ingredientes:
                                <strong>$<span id="costo-total">0.00</span></strong>
                            </p>
                            <p class="mb-2">Costo por porción:
                                <strong>$<span id="costo-porcion">0.00</span></strong>
                            </p>
                            <div class="mb-3">
                                <label for="costo_aproximado" class="form-label">Costo Aproximado *</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" id="costo_aproximado" name="costo_aproximado"
                                           value="{{ old('costo_aproximado', '0.00') }}"
                                           step="0.01" min="0" max="9999.99" required readonly>
                                    @error('costo_aproximado')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="text-muted">Este campo se calcula automáticamente según los ingredientes seleccionados</small>
                            </div>
                        </div>
                        <!-- Botón Guardar Receta debajo de Costo Aproximado -->
                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Guardar Receta
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
window.PRECIOS_PRODUCTOS = @json($productos->pluck('precio_unitario', 'id'));
window.productos = @json($productos->map->only(['id','nombre','unidad_medida'])->values());
</script>
<script>
$(document).ready(function() {
    // Función para actualizar números de paso
    function actualizarNumerosPasos() {
        $('#pasos-container .input-group-text').each(function(index) {
            $(this).text(index + 1);
        });
    }

    // Agregar paso
    $('#agregar-paso').click(function() {
        const numPasos = $('#pasos-container .input-group').length;
        const nuevoPaso = `
            <div class="input-group mb-2">
                <span class="input-group-text">${numPasos + 1}</span>
                <input type="text" class="form-control" name="pasos_preparacion[]" required>
                <button type="button" class="btn btn-danger eliminar-paso">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
        $('#pasos-container').append(nuevoPaso);
    });

    // Eliminar paso
    $(document).on('click', '.eliminar-paso', function() {
        if ($('#pasos-container .input-group').length > 1) {
            $(this).closest('.input-group').remove();
            actualizarNumerosPasos();
        }
    });

    // Plantilla para nueva fila de ingrediente
    function getIngredienteTemplate(index) {
        return `
            <div class="row g-3 mb-3 ingrediente-row">
                <div class="col-md-4">
                    <label class="form-label">Producto *</label>
                    <select class="form-select producto-select" name="ingredientes[${index}][producto_id]" required>
                        <option value="">Seleccione un producto...</option>
                        @foreach($productos as $producto)
                            <option value="{{ $producto->id }}" data-unidad="{{ $producto->unidad_medida }}">
                                {{ $producto->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Cantidad *</label>
                    <input type="number" class="form-control cantidad-input"
                           name="ingredientes[${index}][cantidad]" step="0.01" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Unidad *</label>
                    <select class="form-select" name="ingredientes[${index}][unidad]" required>
                        <option value="">Seleccione una unidad...</option>
                        <option value="kg">Kilogramos (kg)</option>
                        <option value="g">Gramos (g)</option>
                        <option value="l">Litros (l)</option>
                        <option value="ml">Mililitros (ml)</option>
                        <option value="unidad">Unidades</option>
                        <option value="pieza">Piezas</option>
                        <option value="cucharada">Cucharadas</option>
                        <option value="cucharadita">Cucharaditas</option>
                        <option value="taza">Tazas</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label d-block">&nbsp;</label>
                    <button type="button" class="btn btn-danger eliminar-ingrediente">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
    }

    // Agregar ingrediente
    $('#agregar-ingrediente').click(function() {
        const numIngredientes = $('.ingrediente-row').length;
        $('#ingredientes-container').append(getIngredienteTemplate(numIngredientes));
    });

    // Eliminar ingrediente
    $(document).on('click', '.eliminar-ingrediente', function() {
        $(this).closest('.ingrediente-row').remove();
        actualizarCostos();
    });

    // Sugerir unidad de medida al seleccionar producto
    $(document).on('change', '.producto-select', function() {
        const unidad = $(this).find('option:selected').data('unidad');
        const unidadSelect = $(this).closest('.ingrediente-row').find('select[name*="[unidad]"]');

        // Convertir la unidad del producto al formato del select
        let unidadNormalizada = unidad;
        switch(unidad) {
            case 'kilogramos': unidadNormalizada = 'kg'; break;
            case 'gramos': unidadNormalizada = 'g'; break;
            case 'litros': unidadNormalizada = 'l'; break;
            case 'mililitros': unidadNormalizada = 'ml'; break;
            case 'unidades': unidadNormalizada = 'unidad'; break;
            case 'piezas': unidadNormalizada = 'pieza'; break;
            case 'cucharadas': unidadNormalizada = 'cucharada'; break;
            case 'cucharaditas': unidadNormalizada = 'cucharadita'; break;
            case 'tazas': unidadNormalizada = 'taza'; break;
        }

        // Seleccionar la unidad normalizada
        if (unidadNormalizada) {
            unidadSelect.val(unidadNormalizada);
        }
        actualizarCostos();
    });

    // Actualizar costos cuando cambia una cantidad
    $(document).on('input', '.cantidad-input', function() {
        actualizarCostos();
    });

    // Actualizar costos cuando cambian las porciones
    $('#porciones').on('input change', function() {
        actualizarCostos();
    });

    // Función para calcular y actualizar costos
    function actualizarCostos() {
        let costoTotal = 0;
        $('.ingrediente-row').each(function() {
            const cantidad = parseFloat($(this).find('.cantidad-input').val()) || 0;
            const productoId = $(this).find('.producto-select').val();
            if (productoId && window.PRECIOS_PRODUCTOS[productoId] !== undefined) {
                const precio = parseFloat(window.PRECIOS_PRODUCTOS[productoId]) || 0;
                costoTotal += cantidad * precio;
            }
        });

        const porciones = parseFloat($('#porciones').val()) || 1;
        const costoPorcion = porciones > 0 ? costoTotal / porciones : 0;

        $('#costo-total').text(costoTotal.toFixed(2));
        $('#costo-porcion').text(costoPorcion.toFixed(2));
        $('#costo_aproximado').val(costoTotal.toFixed(2));
    }

    // Agregar primer ingrediente si no hay ninguno
    if ($('.ingrediente-row').length === 0) {
        $('#agregar-ingrediente').click();
    }


    // Analizar ingredientes automáticamente desde la descripción
    $('#analizar-ingredientes').click(function() {
        var texto = $('#descripcion').val();
        if (!texto.trim()) {
            alert('Por favor, ingresa texto en la descripción para analizar ingredientes.');
            return;
        }
        $.ajax({
            url: "{{ route('recetas.analizarIngredientes') }}",
            method: 'POST',
            data: {
                texto_receta: texto,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                var cont = $('#ingredientes-container');
                cont.empty();
                var adv = $('#ingredientes-advertencias');
                adv.empty();
                if (response.advertencias && response.advertencias.length > 0) {
                    adv.html('<div class="alert alert-warning">' + response.advertencias.join('<br>') + '</div>');
                }
                if (response.ingredientes && response.ingredientes.length > 0) {
                    response.ingredientes.forEach(function(ing, idx) {
                        var productosOptions = '<option value="">Seleccione un producto...</option>';
                        window.productos.forEach(function(prod) {
                            var selected = ing.producto_id == prod.id ? 'selected' : '';
                            productosOptions += `<option value="${prod.id}" ${selected} data-unidad="${prod.unidad_medida}">${prod.nombre}</option>`;
                        });
                        var row = `<div class="row g-3 mb-3 ingrediente-row">
                            <div class="col-md-4">
                                <label class="form-label">Producto *</label>
                                <select class="form-select producto-select" name="ingredientes[${idx}][producto_id]" required>${productosOptions}</select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Cantidad *</label>
                                <input type="number" class="form-control cantidad-input" name="ingredientes[${idx}][cantidad]" value="${ing.cantidad}" step="0.01" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Unidad *</label>
                                <select class="form-select" name="ingredientes[${idx}][unidad]" required>
                                    <option value="unidad" ${ing.unidad === 'unidad' ? 'selected' : ''}>Unidades</option>
                                    <option value="kg" ${ing.unidad === 'kg' ? 'selected' : ''}>Kilogramos (kg)</option>
                                    <option value="g" ${ing.unidad === 'g' ? 'selected' : ''}>Gramos (g)</option>
                                    <option value="l" ${ing.unidad === 'l' ? 'selected' : ''}>Litros (l)</option>
                                    <option value="ml" ${ing.unidad === 'ml' ? 'selected' : ''}>Mililitros (ml)</option>
                                    <option value="pieza" ${ing.unidad === 'pieza' ? 'selected' : ''}>Piezas</option>
                                    <option value="cucharada" ${ing.unidad === 'cucharada' ? 'selected' : ''}>Cucharadas</option>
                                    <option value="cucharadita" ${ing.unidad === 'cucharadita' ? 'selected' : ''}>Cucharaditas</option>
                                    <option value="taza" ${ing.unidad === 'taza' ? 'selected' : ''}>Tazas</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label d-block">&nbsp;</label>
                                <button type="button" class="btn btn-danger eliminar-ingrediente">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>`;
                        cont.append(row);
                    });
                }
                actualizarCostos();
            },
            error: function(xhr) {
                alert('Error al analizar ingredientes.');
            }
        });
    });

    // Detectar cuando el usuario termine de escribir en descripción para mostrar botón de análisis
    let descripcionTimer;
    $('#descripcion').on('input', function() {
        clearTimeout(descripcionTimer);
        const texto = $(this).val().trim();

        if (texto.length > 20) { // Si hay al menos 20 caracteres
            // Mostrar el botón de análisis más prominente
            $('#analizar-ingredientes').removeClass('btn-outline-success').addClass('btn-success').fadeIn();

            // Opcional: Análisis automático después de 3 segundos sin escribir
            descripcionTimer = setTimeout(function() {
                if (texto.length > 50 && $('#ingredientes-container').children().length === 0) {
                    // Solo auto-analizar si no hay ingredientes ya cargados y hay suficiente texto
                    $('#analizar-ingredientes').click();
                }
            }, 3000);
        } else {
            $('#analizar-ingredientes').removeClass('btn-success').addClass('btn-outline-success');
        }
    });

    // Actualizar costos al cargar la página
    actualizarCostos();
});
</script>
@endpush
