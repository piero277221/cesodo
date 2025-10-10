@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Encabezado -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-primary">
                    <i class="fas fa-plus-circle me-2"></i>Crear Campo Dinámico
                </h2>
                <a href="{{ route('dynamic-fields.index', ['module' => $module]) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Volver
                </a>
            </div>

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-1"></i>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Formulario de creación -->
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-puzzle-piece me-2"></i>Información del Campo
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('dynamic-fields.store') }}" method="POST" id="fieldForm">
                        @csrf

                        <!-- Información básica -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label fw-bold">
                                    <i class="fas fa-tag me-1"></i>Nombre del Campo *
                                </label>
                                <input type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       id="name"
                                       name="name"
                                       value="{{ old('name') }}"
                                       placeholder="Ej: telefono_contacto, fecha_vencimiento"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Solo letras, números y guiones bajos. Sin espacios.
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="label" class="form-label fw-bold">
                                    <i class="fas fa-font me-1"></i>Etiqueta Visible *
                                </label>
                                <input type="text"
                                       class="form-control @error('label') is-invalid @enderror"
                                       id="label"
                                       name="label"
                                       value="{{ old('label') }}"
                                       placeholder="Ej: Teléfono de Contacto, Fecha de Vencimiento"
                                       required>
                                @error('label')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="module" class="form-label fw-bold">
                                    <i class="fas fa-cube me-1"></i>Módulo *
                                </label>
                                <select class="form-select @error('module') is-invalid @enderror"
                                        id="module"
                                        name="module"
                                        required>
                                    <option value="">-- Seleccionar Módulo --</option>
                                    @foreach($availableModules as $moduleKey => $moduleName)
                                        <option value="{{ $moduleKey }}" {{ old('module', $module) == $moduleKey ? 'selected' : '' }}>
                                            {{ $moduleName }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('module')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="type" class="form-label fw-bold">
                                    <i class="fas fa-cog me-1"></i>Tipo de Campo *
                                </label>
                                <select class="form-select @error('type') is-invalid @enderror"
                                        id="type"
                                        name="type"
                                        required>
                                    <option value="">-- Seleccionar Tipo --</option>
                                    @foreach($fieldTypes as $typeKey => $typeName)
                                        <option value="{{ $typeKey }}" {{ old('type') == $typeKey ? 'selected' : '' }}>
                                            {{ $typeName }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Campo adicional -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="placeholder" class="form-label fw-bold">
                                    <i class="fas fa-i-cursor me-1"></i>Placeholder
                                </label>
                                <input type="text"
                                       class="form-control @error('placeholder') is-invalid @enderror"
                                       id="placeholder"
                                       name="placeholder"
                                       value="{{ old('placeholder') }}"
                                       placeholder="Texto de ayuda en el campo">
                                @error('placeholder')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="default_value" class="form-label fw-bold">
                                    <i class="fas fa-star me-1"></i>Valor por Defecto
                                </label>
                                <input type="text"
                                       class="form-control @error('default_value') is-invalid @enderror"
                                       id="default_value"
                                       name="default_value"
                                       value="{{ old('default_value') }}"
                                       placeholder="Valor inicial del campo">
                                @error('default_value')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Opciones para select/radio -->
                        <div id="optionsSection" class="card mb-3" style="display: none;">
                            <div class="card-header bg-info text-white">
                                <h6 class="card-title mb-0">
                                    <i class="fas fa-list me-2"></i>Opciones del Campo
                                </h6>
                            </div>
                            <div class="card-body">
                                <div id="optionsContainer">
                                    <div class="option-row mb-2">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <input type="text" name="options[0]" class="form-control" placeholder="Valor">
                                            </div>
                                            <div class="col-md-5">
                                                <input type="text" name="option_labels[0]" class="form-control" placeholder="Etiqueta">
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-outline-danger btn-sm remove-option">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-primary" id="addOption">
                                    <i class="fas fa-plus me-1"></i>Agregar Opción
                                </button>
                            </div>
                        </div>

                        <!-- Configuraciones adicionales -->
                        <div class="card mb-3">
                            <div class="card-header bg-secondary text-white">
                                <h6 class="card-title mb-0">
                                    <i class="fas fa-cogs me-2"></i>Configuraciones Adicionales
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1"
                                                   id="is_required" name="is_required"
                                                   {{ old('is_required') ? 'checked' : '' }}>
                                            <label class="form-check-label fw-bold" for="is_required">
                                                <i class="fas fa-exclamation-circle text-danger me-1"></i>
                                                Campo Obligatorio
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1"
                                                   id="is_active" name="is_active"
                                                   {{ old('is_active', '1') ? 'checked' : '' }}>
                                            <label class="form-check-label fw-bold" for="is_active">
                                                <i class="fas fa-eye text-success me-1"></i>
                                                Campo Activo
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="sort_order" class="form-label fw-bold">
                                            <i class="fas fa-sort-numeric-up me-1"></i>Orden
                                        </label>
                                        <input type="number"
                                               class="form-control @error('sort_order') is-invalid @enderror"
                                               id="sort_order"
                                               name="sort_order"
                                               value="{{ old('sort_order', 0) }}"
                                               min="0">
                                        @error('sort_order')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="help_text" class="form-label fw-bold">
                                        <i class="fas fa-question-circle me-1"></i>Texto de Ayuda
                                    </label>
                                    <textarea class="form-control @error('help_text') is-invalid @enderror"
                                              id="help_text"
                                              name="help_text"
                                              rows="2"
                                              placeholder="Texto de ayuda que aparecerá debajo del campo">{{ old('help_text') }}</textarea>
                                    @error('help_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('dynamic-fields.index', ['module' => $module]) }}" class="btn btn-light">
                                <i class="fas fa-times me-1"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Crear Campo
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let optionCounter = 1;

// Mostrar/ocultar sección de opciones según el tipo
document.getElementById('type').addEventListener('change', function() {
    const optionsSection = document.getElementById('optionsSection');
    const needsOptions = ['select', 'radio', 'checkbox'].includes(this.value);

    optionsSection.style.display = needsOptions ? 'block' : 'none';
});

// Agregar nueva opción
document.getElementById('addOption').addEventListener('click', function() {
    const container = document.getElementById('optionsContainer');
    const newRow = document.createElement('div');
    newRow.className = 'option-row mb-2';
    newRow.innerHTML = `
        <div class="row">
            <div class="col-md-5">
                <input type="text" name="options[${optionCounter}]" class="form-control" placeholder="Valor">
            </div>
            <div class="col-md-5">
                <input type="text" name="option_labels[${optionCounter}]" class="form-control" placeholder="Etiqueta">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-outline-danger btn-sm remove-option">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    `;
    container.appendChild(newRow);
    optionCounter++;
});

// Remover opción
document.addEventListener('click', function(e) {
    if (e.target.closest('.remove-option')) {
        const optionRow = e.target.closest('.option-row');
        if (document.querySelectorAll('.option-row').length > 1) {
            optionRow.remove();
        } else {
            alert('Debe mantener al menos una opción');
        }
    }
});

// Auto-generar nombre del campo basado en la etiqueta
document.getElementById('label').addEventListener('input', function() {
    const nameField = document.getElementById('name');
    if (!nameField.value) {
        const generatedName = this.value
            .toLowerCase()
            .replace(/[^a-z0-9\s]/g, '')
            .replace(/\s+/g, '_')
            .substring(0, 50);
        nameField.value = generatedName;
    }
});

// Validación del formulario
document.getElementById('fieldForm').addEventListener('submit', function(e) {
    const name = document.getElementById('name').value.trim();
    const label = document.getElementById('label').value.trim();
    const module = document.getElementById('module').value;
    const type = document.getElementById('type').value;

    if (!name || !label || !module || !type) {
        e.preventDefault();
        alert('Por favor completa todos los campos obligatorios');
        return false;
    }

    // Validar formato del nombre
    if (!/^[a-zA-Z0-9_]+$/.test(name)) {
        e.preventDefault();
        alert('El nombre del campo solo puede contener letras, números y guiones bajos');
        document.getElementById('name').focus();
        return false;
    }

    return true;
});

// Inicializar estado de opciones si hay valor previo
document.addEventListener('DOMContentLoaded', function() {
    const typeField = document.getElementById('type');
    if (typeField.value) {
        typeField.dispatchEvent(new Event('change'));
    }
});
</script>
@endpush
