@extends('layouts.app')

@section('title', 'Nuevo Producto')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">
                    <i class="fas fa-plus-circle text-success me-2"></i>
                    Nuevo Producto
                </h2>
                <a href="{{ route('productos.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>
                    Volver
                </a>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <h6><i class="fas fa-exclamation-triangle me-1"></i> Errores de validación:</h6>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('productos.store') }}" method="POST" id="createProductoForm">
                @csrf

                <div class="row">
                    <!-- Información Básica -->
                    <div class="col-lg-8 mb-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-header bg-primary text-white">
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
                                               class="form-control @error('codigo') is-invalid @enderror"
                                               id="codigo"
                                               name="codigo"
                                               value="{{ old('codigo') }}"
                                               placeholder="Ej: PROD001"
                                               required>
                                        @error('codigo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                                        <input type="text"
                                               class="form-control @error('nombre') is-invalid @enderror"
                                               id="nombre"
                                               name="nombre"
                                               value="{{ old('nombre') }}"
                                               placeholder="Nombre del producto"
                                               required>
                                        @error('nombre')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="categoria_id" class="form-label">Categoría <span class="text-danger">*</span></label>
                                        <select class="form-select @error('categoria_id') is-invalid @enderror"
                                                id="categoria_id"
                                                name="categoria_id"
                                                required>
                                            <option value="">Seleccionar categoría</option>
                                            @if(isset($categorias))
                                                @foreach($categorias as $categoria)
                                                    <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                                        {{ $categoria->nombre }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('categoria_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="unidad_medida" class="form-label">Unidad de Medida <span class="text-danger">*</span></label>
                                        <select class="form-select @error('unidad_medida') is-invalid @enderror"
                                                id="unidad_medida"
                                                name="unidad_medida"
                                                required>
                                            <option value="">Seleccionar unidad</option>
                                            <option value="kg" {{ old('unidad_medida') == 'kg' ? 'selected' : '' }}>Kilogramos (kg)</option>
                                            <option value="g" {{ old('unidad_medida') == 'g' ? 'selected' : '' }}>Gramos (g)</option>
                                            <option value="l" {{ old('unidad_medida') == 'l' ? 'selected' : '' }}>Litros (l)</option>
                                            <option value="ml" {{ old('unidad_medida') == 'ml' ? 'selected' : '' }}>Mililitros (ml)</option>
                                            <option value="unidad" {{ old('unidad_medida') == 'unidad' ? 'selected' : '' }}>Unidad</option>
                                            <option value="paquete" {{ old('unidad_medida') == 'paquete' ? 'selected' : '' }}>Paquete</option>
                                            <option value="caja" {{ old('unidad_medida') == 'caja' ? 'selected' : '' }}>Caja</option>
                                        </select>
                                        @error('unidad_medida')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="descripcion" class="form-label">Descripción</label>
                                    <textarea class="form-control @error('descripcion') is-invalid @enderror"
                                              id="descripcion"
                                              name="descripcion"
                                              rows="3"
                                              placeholder="Descripción detallada del producto">{{ old('descripcion') }}</textarea>
                                    @error('descripcion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                                               class="form-control @error('precio_unitario') is-invalid @enderror"
                                               id="precio_unitario"
                                               name="precio_unitario"
                                               value="{{ old('precio_unitario') }}"
                                               step="0.01"
                                               min="0"
                                               placeholder="0.00"
                                               required>
                                        @error('precio_unitario')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="stock_minimo" class="form-label">Stock Mínimo <span class="text-danger">*</span></label>
                                    <input type="number"
                                           class="form-control @error('stock_minimo') is-invalid @enderror"
                                           id="stock_minimo"
                                           name="stock_minimo"
                                           value="{{ old('stock_minimo', 10) }}"
                                           min="0"
                                           placeholder="10"
                                           required>
                                    @error('stock_minimo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="cantidad_inicial" class="form-label">Cantidad Inicial <span class="text-danger">*</span></label>
                                    <input type="number"
                                           class="form-control @error('cantidad_inicial') is-invalid @enderror"
                                           id="cantidad_inicial"
                                           name="cantidad_inicial"
                                           value="{{ old('cantidad_inicial', 0) }}"
                                           min="0"
                                           placeholder="0"
                                           required>
                                    @error('cantidad_inicial')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Stock inicial del producto en inventario</div>
                                </div>

                                <div class="mb-3">
                                    <label for="stock_maximo" class="form-label">Stock Máximo</label>
                                    <input type="number"
                                           class="form-control @error('stock_maximo') is-invalid @enderror"
                                           id="stock_maximo"
                                           name="stock_maximo"
                                           value="{{ old('stock_maximo', 100) }}"
                                           min="0"
                                           placeholder="100">
                                    @error('stock_maximo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           id="es_perecedero"
                                           name="es_perecedero"
                                           value="1"
                                           {{ old('es_perecedero') ? 'checked' : '' }}>
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
                                           class="form-control @error('fecha_vencimiento') is-invalid @enderror"
                                           id="fecha_vencimiento"
                                           name="fecha_vencimiento"
                                           value="{{ old('fecha_vencimiento') }}"
                                           min="{{ date('Y-m-d') }}">
                                    @error('fecha_vencimiento')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle"></i>
                                        Opcional. Si el producto no vence, dejar en blanco.
                                    </small>
                                </div>

                                <div class="mt-3">
                                    <label for="dias_alerta_vencimiento" class="form-label">
                                        <i class="fas fa-bell me-1 text-info"></i>
                                        Días de Alerta antes del Vencimiento
                                    </label>
                                    <input type="number"
                                           class="form-control @error('dias_alerta_vencimiento') is-invalid @enderror"
                                           id="dias_alerta_vencimiento"
                                           name="dias_alerta_vencimiento"
                                           value="{{ old('dias_alerta_vencimiento', 30) }}"
                                           min="1"
                                           max="365">
                                    @error('dias_alerta_vencimiento')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle"></i>
                                        Días antes del vencimiento para recibir notificaciones (por defecto 30 días).
                                    </small>
                                </div>

                                <div class="mt-3">
                                    <label for="estado" class="form-label">Estado <span class="text-danger">*</span></label>
                                    <select class="form-select @error('estado') is-invalid @enderror"
                                            id="estado"
                                            name="estado"
                                            required>
                                        <option value="">Seleccionar estado</option>
                                        <option value="activo" {{ old('estado', 'activo') == 'activo' ? 'selected' : '' }}>Activo</option>
                                        <option value="inactivo" {{ old('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                                    </select>
                                    @error('estado')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('productos.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>
                                Cancelar
                            </a>

                            <div>
                                <button type="submit" class="btn btn-success" id="btnGuardar">
                                    <i class="fas fa-save me-1"></i>
                                    Guardar Producto
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validación del formulario
    const form = document.getElementById('createProductoForm');
    const btnGuardar = document.getElementById('btnGuardar');

    form.addEventListener('submit', function(e) {
        btnGuardar.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Guardando...';
        btnGuardar.disabled = true;
    });

    // Auto-generar código si está vacío
    const nombreInput = document.getElementById('nombre');
    const codigoInput = document.getElementById('codigo');

    nombreInput.addEventListener('blur', function() {
        if (!codigoInput.value && this.value) {
            // Generar código basado en el nombre
            let codigo = this.value.substring(0, 4).toUpperCase().replace(/[^A-Z]/g, '');
            codigo += Math.floor(Math.random() * 999).toString().padStart(3, '0');
            codigoInput.value = codigo;
        }
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

    // Validación de precio
    const precioInput = document.getElementById('precio_unitario');
    precioInput.addEventListener('input', function() {
        if (this.value < 0) {
            this.value = 0;
        }
    });

    // Confirmación antes de enviar
    document.getElementById('createProductoForm').addEventListener('submit', function(e) {
        if (!confirm('¿Está seguro de crear este producto?')) {
            e.preventDefault();
        }
    });
});
</script>
@endpush
@endsection
