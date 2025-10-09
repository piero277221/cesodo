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
                                            <option value="kg" {{ old('unidad_medida') == 'kg' ? 'selected' : '' }}>Kilogramo (kg)</option>
                                            <option value="lt" {{ old('unidad_medida') == 'lt' ? 'selected' : '' }}>Litro (lt)</option>
                                            <option value="unid" {{ old('unidad_medida') == 'unid' ? 'selected' : '' }}>Unidad (unid)</option>
                                            <option value="caja" {{ old('unidad_medida') == 'caja' ? 'selected' : '' }}>Caja</option>
                                            <option value="paquete" {{ old('unidad_medida') == 'paquete' ? 'selected' : '' }}>Paquete</option>
                                            <option value="docena" {{ old('unidad_medida') == 'docena' ? 'selected' : '' }}>Docena</option>
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
                                              rows="3">{{ old('descripcion') }}</textarea>
                                    @error('descripcion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Información de Precios e Inventario -->
                    <div class="col-lg-4 mb-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-dollar-sign me-2"></i>
                                    Precios e Inventario
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
                                           value="{{ old('stock_minimo', 5) }}"
                                           min="0"
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
                                           required>
                                    @error('cantidad_inicial')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Cantidad inicial en inventario</div>
                                </div>

                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Nota:</strong> Al crear el producto se generará automáticamente el registro de inventario con la cantidad inicial especificada.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('productos.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times me-1"></i>
                                        Cancelar
                                    </a>
                                    <button type="reset" class="btn btn-outline-warning">
                                        <i class="fas fa-undo me-1"></i>
                                        Limpiar
                                    </button>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save me-1"></i>
                                        Guardar Producto
                                    </button>
                                </div>
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
    // Auto-generar código basado en categoría y nombre
    const categoriaSelect = document.getElementById('categoria_id');
    const nombreInput = document.getElementById('nombre');
    const codigoInput = document.getElementById('codigo');

    function generateCodigo() {
        const categoriaId = categoriaSelect.value;
        const nombre = nombreInput.value;

        if (categoriaId && nombre && !codigoInput.value) {
            // Obtener las primeras 3 letras del nombre
            const prefix = nombre.substring(0, 3).toUpperCase();
            // Generar número aleatorio
            const suffix = Math.floor(Math.random() * 1000).toString().padStart(3, '0');
            codigoInput.value = prefix + suffix;
        }
    }

    categoriaSelect.addEventListener('change', generateCodigo);
    nombreInput.addEventListener('blur', generateCodigo);

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
