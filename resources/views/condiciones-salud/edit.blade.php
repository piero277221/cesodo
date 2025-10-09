@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="fas fa-edit text-warning me-2"></i>
            Editar Condición de Salud
        </h2>
        <div class="d-flex gap-2">
            <a href="{{ route('condiciones-salud.show', $condicionSalud) }}" class="btn btn-outline-info">
                <i class="fas fa-eye me-1"></i>
                Ver
            </a>
            <a href="{{ route('condiciones-salud.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i>
                Volver
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fas fa-heartbeat me-2"></i>
                        Información de la Condición
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('condiciones-salud.update', $condicionSalud) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <!-- Nombre -->
                            <div class="col-md-12">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-tag me-2 text-warning"></i>Nombre de la Condición *
                                </label>
                                <input type="text" name="nombre"
                                       class="form-control @error('nombre') is-invalid @enderror"
                                       value="{{ old('nombre', $condicionSalud->nombre) }}"
                                       placeholder="Ej: Diabetes, Hipertensión, Celiaquía"
                                       required>
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Descripción -->
                            <div class="col-md-12">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-clipboard me-2 text-warning"></i>Descripción
                                </label>
                                <textarea name="descripcion"
                                          class="form-control @error('descripcion') is-invalid @enderror"
                                          rows="3"
                                          placeholder="Describa las características de esta condición de salud">{{ old('descripcion', $condicionSalud->descripcion) }}</textarea>
                                @error('descripcion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Productos Restringidos -->
                            <div class="col-md-12">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-ban me-2 text-warning"></i>Productos Restringidos
                                </label>
                                <select name="restricciones_alimentarias[]"
                                        class="form-select @error('restricciones_alimentarias') is-invalid @enderror"
                                        multiple size="8">
                                    <option value="" disabled>Seleccione los productos que están restringidos para esta condición</option>
                                    @foreach($productos as $producto)
                                        <option value="{{ $producto->id }}"
                                                {{ in_array($producto->id, old('restricciones_alimentarias', $condicionSalud->restricciones_alimentarias ?? [])) ? 'selected' : '' }}>
                                            [{{ $producto->codigo }}] {{ $producto->nombre }}
                                            @if($producto->categoria)
                                                - {{ $producto->categoria->nombre }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('restricciones_alimentarias')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">
                                    Mantenga presionado Ctrl (Cmd en Mac) para seleccionar múltiples productos
                                </small>
                            </div>

                            <!-- Estado -->
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="activo"
                                           id="activo" value="1" {{ old('activo', $condicionSalud->activo) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold" for="activo">
                                        <i class="fas fa-toggle-on me-2 text-success"></i>Condición Activa
                                    </label>
                                    <div class="form-text">Las condiciones activas aparecerán disponibles en los menús</div>
                                </div>
                            </div>

                            <!-- Información adicional -->
                            <div class="col-12">
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <strong>Atención:</strong> Si modifica las restricciones alimentarias,
                                    esto podría afectar los menús existentes que ya están configurados para esta condición.
                                </div>
                            </div>

                            <!-- Información de fechas -->
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="alert alert-light">
                                            <small class="text-muted">
                                                <i class="fas fa-calendar-plus me-1"></i>
                                                <strong>Creado:</strong> {{ $condicionSalud->created_at->format('d/m/Y H:i') }}
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="alert alert-light">
                                            <small class="text-muted">
                                                <i class="fas fa-calendar-edit me-1"></i>
                                                <strong>Última modificación:</strong> {{ $condicionSalud->updated_at->format('d/m/Y H:i') }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="row mt-4">
                            <div class="col-12 d-flex justify-content-end gap-2">
                                <a href="{{ route('condiciones-salud.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-2"></i>Cancelar
                                </a>
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save me-2"></i>Actualizar Condición
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mejorar la experiencia del select múltiple
    const selectProductos = document.querySelector('select[name="restricciones_alimentarias[]"]');

    if (selectProductos) {
        // Agregar buscador
        const wrapper = selectProductos.parentElement;
        const searchInput = document.createElement('input');
        searchInput.type = 'text';
        searchInput.className = 'form-control mb-2';
        searchInput.placeholder = 'Buscar productos...';

        wrapper.insertBefore(searchInput, selectProductos);

        // Funcionalidad de búsqueda
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const options = selectProductos.querySelectorAll('option:not([disabled])');

            options.forEach(option => {
                const text = option.textContent.toLowerCase();
                option.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    }

    // Confirmación antes de guardar cambios
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const restricciones = selectProductos.selectedOptions.length;
        if (restricciones > 0) {
            const confirmMessage = `¿Está seguro de actualizar esta condición con ${restricciones} productos restringidos?`;
            if (!confirm(confirmMessage)) {
                e.preventDefault();
            }
        }
    });
});
</script>
@endpush
@endsection
