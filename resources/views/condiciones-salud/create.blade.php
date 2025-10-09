@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="fas fa-plus-circle text-danger me-2"></i>
            Nueva Condición de Salud
        </h2>
        <a href="{{ route('condiciones-salud.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>
            Volver
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-heartbeat me-2"></i>
                        Información de la Condición
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('condiciones-salud.store') }}" method="POST">
                        @csrf

                        <div class="row g-3">
                            <!-- Nombre -->
                            <div class="col-md-12">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-tag me-2 text-danger"></i>Nombre de la Condición *
                                </label>
                                <input type="text" name="nombre"
                                       class="form-control @error('nombre') is-invalid @enderror"
                                       value="{{ old('nombre') }}"
                                       placeholder="Ej: Diabetes, Hipertensión, Celiaquía"
                                       required>
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Descripción -->
                            <div class="col-md-12">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-clipboard me-2 text-danger"></i>Descripción
                                </label>
                                <textarea name="descripcion"
                                          class="form-control @error('descripcion') is-invalid @enderror"
                                          rows="3"
                                          placeholder="Describa las características de esta condición de salud">{{ old('descripcion') }}</textarea>
                                @error('descripcion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Productos Restringidos -->
                            <div class="col-md-12">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-ban me-2 text-danger"></i>Productos Restringidos
                                </label>
                                <select name="restricciones_alimentarias[]"
                                        class="form-select @error('restricciones_alimentarias') is-invalid @enderror"
                                        multiple size="8">
                                    <option value="" disabled>Seleccione los productos que están restringidos para esta condición</option>
                                    @foreach($productos as $producto)
                                        <option value="{{ $producto->id }}"
                                                {{ in_array($producto->id, old('restricciones_alimentarias', [])) ? 'selected' : '' }}>
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
                                           id="activo" value="1" {{ old('activo', true) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold" for="activo">
                                        <i class="fas fa-toggle-on me-2 text-success"></i>Condición Activa
                                    </label>
                                    <div class="form-text">Las condiciones activas aparecerán disponibles en los menús</div>
                                </div>
                            </div>

                            <!-- Información adicional -->
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Información:</strong> Los productos restringidos no aparecerán
                                    como opciones cuando se creen menús para personas con esta condición de salud.
                                </div>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="row mt-4">
                            <div class="col-12 d-flex justify-content-end gap-2">
                                <a href="{{ route('condiciones-salud.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-2"></i>Cancelar
                                </a>
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-save me-2"></i>Crear Condición
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
});
</script>
@endpush
@endsection
