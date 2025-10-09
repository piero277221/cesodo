@extends('layouts.app')

@section('title', 'Crear Movimiento de Kardex')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2 text-primary">
            <i class="fas fa-plus-circle me-2"></i>Crear Movimiento de Kardex
        </h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="{{ route('kardex.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Volver al Kardex
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-edit me-2"></i>Datos del Movimiento
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('kardex.store') }}" method="POST">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="producto_id" class="form-label">Producto *</label>
                                <select name="producto_id" id="producto_id" class="form-select @error('producto_id') is-invalid @enderror" required>
                                    <option value="">Seleccionar producto...</option>
                                    @foreach($productos as $producto)
                                        <option value="{{ $producto->id }}" {{ old('producto_id') == $producto->id ? 'selected' : '' }}>
                                            {{ $producto->nombre }} - {{ $producto->categoria->nombre ?? 'Sin categoría' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('producto_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="fecha" class="form-label">Fecha *</label>
                                <input type="date" class="form-control @error('fecha') is-invalid @enderror"
                                       id="fecha" name="fecha" value="{{ old('fecha', date('Y-m-d')) }}" required>
                                @error('fecha')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="tipo_movimiento" class="form-label">Tipo de Movimiento *</label>
                                <select name="tipo_movimiento" id="tipo_movimiento" class="form-select @error('tipo_movimiento') is-invalid @enderror" required>
                                    <option value="">Seleccionar tipo...</option>
                                    <option value="entrada" {{ old('tipo_movimiento') == 'entrada' ? 'selected' : '' }}>Entrada</option>
                                    <option value="salida" {{ old('tipo_movimiento') == 'salida' ? 'selected' : '' }}>Salida</option>
                                    <option value="ajuste" {{ old('tipo_movimiento') == 'ajuste' ? 'selected' : '' }}>Ajuste</option>
                                </select>
                                @error('tipo_movimiento')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="modulo" class="form-label">Módulo *</label>
                                <select name="modulo" id="modulo" class="form-select @error('modulo') is-invalid @enderror" required>
                                    <option value="">Seleccionar módulo...</option>
                                    <option value="inventario" {{ old('modulo') == 'inventario' ? 'selected' : '' }}>Inventario</option>
                                    <option value="consumos" {{ old('modulo') == 'consumos' ? 'selected' : '' }}>Consumos</option>
                                    <option value="compras" {{ old('modulo') == 'compras' ? 'selected' : '' }}>Compras</option>
                                </select>
                                @error('modulo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="concepto" class="form-label">Concepto *</label>
                                <input type="text" class="form-control @error('concepto') is-invalid @enderror"
                                       id="concepto" name="concepto" value="{{ old('concepto') }}"
                                       placeholder="Ej: Ajuste de inventario, Entrada por compra..." required>
                                @error('concepto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="numero_documento" class="form-label">Número de Documento</label>
                                <input type="text" class="form-control @error('numero_documento') is-invalid @enderror"
                                       id="numero_documento" name="numero_documento" value="{{ old('numero_documento') }}"
                                       placeholder="Ej: FAC-001, AJU-001...">
                                @error('numero_documento')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4" id="cantidad_entrada_group">
                                <label for="cantidad_entrada" class="form-label">Cantidad de Entrada</label>
                                <input type="number" class="form-control @error('cantidad_entrada') is-invalid @enderror"
                                       id="cantidad_entrada" name="cantidad_entrada" value="{{ old('cantidad_entrada') }}"
                                       min="0" step="1">
                                @error('cantidad_entrada')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4" id="cantidad_salida_group">
                                <label for="cantidad_salida" class="form-label">Cantidad de Salida</label>
                                <input type="number" class="form-control @error('cantidad_salida') is-invalid @enderror"
                                       id="cantidad_salida" name="cantidad_salida" value="{{ old('cantidad_salida') }}"
                                       min="0" step="1">
                                @error('cantidad_salida')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="precio_unitario" class="form-label">Precio Unitario</label>
                                <input type="number" class="form-control @error('precio_unitario') is-invalid @enderror"
                                       id="precio_unitario" name="precio_unitario" value="{{ old('precio_unitario') }}"
                                       min="0" step="0.01">
                                @error('precio_unitario')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="observaciones" class="form-label">Observaciones</label>
                            <textarea class="form-control @error('observaciones') is-invalid @enderror"
                                      id="observaciones" name="observaciones" rows="3"
                                      placeholder="Observaciones adicionales...">{{ old('observaciones') }}</textarea>
                            @error('observaciones')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary me-md-2">
                                <i class="fas fa-save me-1"></i>Guardar Movimiento
                            </button>
                            <a href="{{ route('kardex.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-1"></i>Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>Información del Producto
                    </h6>
                </div>
                <div class="card-body" id="producto-info">
                    <p class="text-muted">Seleccione un producto para ver su información y stock actual.</p>
                </div>
            </div>

            <div class="card shadow mt-3">
                <div class="card-header bg-warning text-dark">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-exclamation-triangle me-2"></i>Importante
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li><i class="fas fa-check text-success me-2"></i>Solo puede especificar entrada O salida, no ambas.</li>
                        <li><i class="fas fa-check text-success me-2"></i>Los movimientos de inventario afectan el stock real.</li>
                        <li><i class="fas fa-check text-success me-2"></i>Los movimientos de consumos solo registran el uso.</li>
                        <li><i class="fas fa-check text-success me-2"></i>Los movimientos de compras registran ingresos automáticamente.</li>
                        <li><i class="fas fa-check text-success me-2"></i>Los ajustes permiten corregir diferencias.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tipoMovimiento = document.getElementById('tipo_movimiento');
    const cantidadEntrada = document.getElementById('cantidad_entrada');
    const cantidadSalida = document.getElementById('cantidad_salida');
    const cantidadEntradaGroup = document.getElementById('cantidad_entrada_group');
    const cantidadSalidaGroup = document.getElementById('cantidad_salida_group');
    const productoSelect = document.getElementById('producto_id');
    const productoInfo = document.getElementById('producto-info');

    // Manejar cambio de tipo de movimiento
    tipoMovimiento.addEventListener('change', function() {
        const tipo = this.value;

        if (tipo === 'entrada') {
            cantidadEntradaGroup.style.display = 'block';
            cantidadSalidaGroup.style.display = 'none';
            cantidadEntrada.required = true;
            cantidadSalida.required = false;
            cantidadSalida.value = '';
        } else if (tipo === 'salida') {
            cantidadEntradaGroup.style.display = 'none';
            cantidadSalidaGroup.style.display = 'block';
            cantidadSalida.required = true;
            cantidadEntrada.required = false;
            cantidadEntrada.value = '';
        } else {
            cantidadEntradaGroup.style.display = 'block';
            cantidadSalidaGroup.style.display = 'block';
            cantidadEntrada.required = false;
            cantidadSalida.required = false;
        }
    });

    // Manejar cambio de producto
    productoSelect.addEventListener('change', function() {
        const productoId = this.value;

        if (productoId) {
            // Obtener información del producto
            fetch(`/api/productos/${productoId}/info`)
                .then(response => response.json())
                .then(data => {
                    productoInfo.innerHTML = `
                        <div class="mb-2">
                            <strong>Nombre:</strong> ${data.nombre}
                        </div>
                        <div class="mb-2">
                            <strong>Categoría:</strong> ${data.categoria || 'Sin categoría'}
                        </div>
                        <div class="mb-2">
                            <strong>Precio:</strong> S/ ${parseFloat(data.precio || 0).toFixed(2)}
                        </div>
                        <div class="mb-2">
                            <strong>Stock Actual:</strong>
                            <span class="badge ${data.stock > 0 ? 'bg-success' : 'bg-warning'}">${data.stock || 0}</span>
                        </div>
                    `;

                    // Auto-completar precio
                    document.getElementById('precio_unitario').value = data.precio || '';
                })
                .catch(error => {
                    console.error('Error:', error);
                    productoInfo.innerHTML = '<p class="text-danger">Error al cargar información del producto.</p>';
                });
        } else {
            productoInfo.innerHTML = '<p class="text-muted">Seleccione un producto para ver su información y stock actual.</p>';
        }
    });

    // Validar que no se llenen ambas cantidades
    cantidadEntrada.addEventListener('input', function() {
        if (this.value && this.value > 0) {
            cantidadSalida.value = '';
        }
    });

    cantidadSalida.addEventListener('input', function() {
        if (this.value && this.value > 0) {
            cantidadEntrada.value = '';
        }
    });

    // Trigger inicial
    tipoMovimiento.dispatchEvent(new Event('change'));
});
</script>
@endpush
