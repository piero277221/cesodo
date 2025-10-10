@extends('layouts.app')

@section('title', 'Editar Campo Dinámico')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-edit me-2 text-primary"></i>
                Editar Campo Dinámico
            </h1>
            <nav aria-label="breadcrumb" class="mt-2">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('modules.index') }}">Módulos</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('dynamic-fields.index') }}">Campos Dinámicos</a></li>
                    <li class="breadcrumb-item active">Editar Campo</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('dynamic-fields.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Volver
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-cogs me-2"></i>
                        Configuración del Campo: {{ $dynamicField->label }}
                    </h5>
                </div>

                <form action="{{ route('dynamic-fields.update', $dynamicField) }}" method="POST" id="editFieldForm">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        <div class="row">
                            <!-- Basic Information -->
                            <div class="col-md-8">
                                <div class="form-section mb-4">
                                    <h6 class="text-primary border-bottom pb-2 mb-3">
                                        <i class="fas fa-info-circle me-2"></i>Información Básica
                                    </h6>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="name" class="form-label">Nombre del Campo <span class="text-danger">*</span></label>
                                            <input type="text"
                                                   class="form-control @error('name') is-invalid @enderror"
                                                   id="name"
                                                   name="name"
                                                   value="{{ old('name', $dynamicField->name) }}"
                                                   placeholder="ej: telefono_personal">
                                            <small class="text-muted">Nombre único para el campo (snake_case)</small>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="label" class="form-label">Etiqueta <span class="text-danger">*</span></label>
                                            <input type="text"
                                                   class="form-control @error('label') is-invalid @enderror"
                                                   id="label"
                                                   name="label"
                                                   value="{{ old('label', $dynamicField->label) }}"
                                                   placeholder="ej: Teléfono Personal">
                                            <small class="text-muted">Texto que se mostrará al usuario</small>
                                            @error('label')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="type" class="form-label">Tipo de Campo <span class="text-danger">*</span></label>
                                            <select class="form-select @error('type') is-invalid @enderror"
                                                    id="type"
                                                    name="type">
                                                <option value="">Seleccionar tipo...</option>
                                                @foreach(['text' => 'Texto', 'textarea' => 'Área de Texto', 'number' => 'Número', 'email' => 'Email', 'password' => 'Contraseña', 'date' => 'Fecha', 'datetime' => 'Fecha y Hora', 'time' => 'Hora', 'select' => 'Lista Desplegable', 'checkbox' => 'Casilla de Verificación', 'radio' => 'Botones de Radio', 'file' => 'Archivo', 'image' => 'Imagen', 'url' => 'URL', 'tel' => 'Teléfono'] as $value => $label)
                                                    <option value="{{ $value }}" {{ old('type', $dynamicField->type) == $value ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="module" class="form-label">Módulo <span class="text-danger">*</span></label>
                                            <select class="form-select @error('module') is-invalid @enderror"
                                                    id="module"
                                                    name="module">
                                                <option value="">Seleccionar módulo...</option>
                                                @foreach(['trabajadores' => 'Trabajadores', 'clientes' => 'Clientes', 'contratos' => 'Contratos', 'inventario' => 'Inventario', 'compras' => 'Compras', 'pedidos' => 'Pedidos'] as $value => $label)
                                                    <option value="{{ $value }}" {{ old('module', $dynamicField->module) == $value ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('module')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="description" class="form-label">Descripción</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror"
                                                  id="description"
                                                  name="description"
                                                  rows="2"
                                                  placeholder="Descripción opcional del campo">{{ old('description', $dynamicField->description) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Field Options (for select/radio) -->
                                <div class="form-section mb-4" id="optionsSection" style="display: none;">
                                    <h6 class="text-primary border-bottom pb-2 mb-3">
                                        <i class="fas fa-list me-2"></i>Opciones del Campo
                                    </h6>

                                    <div id="optionsContainer">
                                        <!-- Options will be dynamically added here -->
                                    </div>

                                    <button type="button" class="btn btn-outline-primary btn-sm" id="addOption">
                                        <i class="fas fa-plus me-1"></i> Agregar Opción
                                    </button>
                                </div>

                                <!-- Validation Rules -->
                                <div class="form-section mb-4">
                                    <h6 class="text-primary border-bottom pb-2 mb-3">
                                        <i class="fas fa-shield-alt me-2"></i>Reglas de Validación
                                    </h6>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input"
                                                       type="checkbox"
                                                       id="required"
                                                       name="validation_rules[required]"
                                                       {{ isset(old('validation_rules', $dynamicField->validation_rules ?? [])['required']) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="required">
                                                    Campo Obligatorio
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input"
                                                       type="checkbox"
                                                       id="unique"
                                                       name="validation_rules[unique]"
                                                       {{ isset(old('validation_rules', $dynamicField->validation_rules ?? [])['unique']) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="unique">
                                                    Valor Único
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3" id="lengthRules" style="display: none;">
                                        <div class="col-md-6">
                                            <label for="min_length" class="form-label">Longitud Mínima</label>
                                            <input type="number"
                                                   class="form-control"
                                                   id="min_length"
                                                   name="validation_rules[min_length]"
                                                   value="{{ old('validation_rules.min_length', $dynamicField->validation_rules['min_length'] ?? '') }}"
                                                   min="0">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="max_length" class="form-label">Longitud Máxima</label>
                                            <input type="number"
                                                   class="form-control"
                                                   id="max_length"
                                                   name="validation_rules[max_length]"
                                                   value="{{ old('validation_rules.max_length', $dynamicField->validation_rules['max_length'] ?? '') }}"
                                                   min="1">
                                        </div>
                                    </div>

                                    <div class="row mb-3" id="numericRules" style="display: none;">
                                        <div class="col-md-6">
                                            <label for="min_value" class="form-label">Valor Mínimo</label>
                                            <input type="number"
                                                   class="form-control"
                                                   id="min_value"
                                                   name="validation_rules[min_value]"
                                                   value="{{ old('validation_rules.min_value', $dynamicField->validation_rules['min_value'] ?? '') }}"
                                                   step="any">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="max_value" class="form-label">Valor Máximo</label>
                                            <input type="number"
                                                   class="form-control"
                                                   id="max_value"
                                                   name="validation_rules[max_value]"
                                                   value="{{ old('validation_rules.max_value', $dynamicField->validation_rules['max_value'] ?? '') }}"
                                                   step="any">
                                        </div>
                                    </div>

                                    <div class="mb-3" id="patternRule" style="display: none;">
                                        <label for="pattern" class="form-label">Patrón (Regex)</label>
                                        <input type="text"
                                               class="form-control"
                                               id="pattern"
                                               name="validation_rules[pattern]"
                                               value="{{ old('validation_rules.pattern', $dynamicField->validation_rules['pattern'] ?? '') }}"
                                               placeholder="ej: ^[0-9]{10}$ para teléfono de 10 dígitos">
                                        <small class="text-muted">Expresión regular para validación personalizada</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Sidebar -->
                            <div class="col-md-4">
                                <!-- Field Preview -->
                                <div class="card border-info mb-4">
                                    <div class="card-header bg-info text-white">
                                        <h6 class="mb-0">
                                            <i class="fas fa-eye me-2"></i>Vista Previa
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div id="fieldPreview">
                                            <!-- Preview will be updated dynamically -->
                                        </div>
                                    </div>
                                </div>

                                <!-- Field Configuration -->
                                <div class="card border-secondary mb-4">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">
                                            <i class="fas fa-cog me-2"></i>Configuración Adicional
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="placeholder" class="form-label">Placeholder</label>
                                            <input type="text"
                                                   class="form-control"
                                                   id="placeholder"
                                                   name="placeholder"
                                                   value="{{ old('placeholder', $dynamicField->placeholder) }}"
                                                   placeholder="Texto de ayuda...">
                                        </div>

                                        <div class="mb-3">
                                            <label for="default_value" class="form-label">Valor por Defecto</label>
                                            <input type="text"
                                                   class="form-control"
                                                   id="default_value"
                                                   name="default_value"
                                                   value="{{ old('default_value', $dynamicField->default_value) }}">
                                        </div>

                                        <div class="mb-3">
                                            <label for="css_classes" class="form-label">Clases CSS</label>
                                            <input type="text"
                                                   class="form-control"
                                                   id="css_classes"
                                                   name="css_classes"
                                                   value="{{ old('css_classes', $dynamicField->css_classes) }}"
                                                   placeholder="ej: form-control-lg">
                                        </div>

                                        <div class="mb-3">
                                            <label for="group_id" class="form-label">Grupo</label>
                                            <select class="form-select" id="group_id" name="group_id">
                                                <option value="">Sin grupo</option>
                                                @foreach(\App\Models\DynamicFieldGroup::orderBy('name')->get() as $group)
                                                    <option value="{{ $group->id }}" {{ old('group_id', $dynamicField->group_id) == $group->id ? 'selected' : '' }}>
                                                        {{ $group->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input"
                                                   type="checkbox"
                                                   id="is_active"
                                                   name="is_active"
                                                   {{ old('is_active', $dynamicField->is_active) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_active">
                                                Campo Activo
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-light">
                        <div class="d-flex justify-content-between">
                            <div>
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Los campos marcados con <span class="text-danger">*</span> son obligatorios
                                </small>
                            </div>
                            <div>
                                <a href="{{ route('dynamic-fields.index') }}" class="btn btn-outline-secondary me-2">
                                    <i class="fas fa-times me-1"></i> Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Guardar Cambios
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Options Template (hidden) -->
<template id="optionTemplate">
    <div class="option-row mb-2 d-flex align-items-center">
        <input type="text" class="form-control me-2" name="options[]" placeholder="Valor de la opción" required>
        <button type="button" class="btn btn-outline-danger btn-sm remove-option">
            <i class="fas fa-times"></i>
        </button>
    </div>
</template>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('type');
    const optionsSection = document.getElementById('optionsSection');
    const lengthRules = document.getElementById('lengthRules');
    const numericRules = document.getElementById('numericRules');
    const patternRule = document.getElementById('patternRule');
    const optionsContainer = document.getElementById('optionsContainer');
    const addOptionBtn = document.getElementById('addOption');
    const fieldPreview = document.getElementById('fieldPreview');

    // Initialize existing options if editing a select/radio field
    const existingOptions = @json($dynamicField->options ?? []);

    function toggleSections() {
        const selectedType = typeSelect.value;

        // Show/hide options section
        if (['select', 'radio'].includes(selectedType)) {
            optionsSection.style.display = 'block';
            if (existingOptions.length === 0) {
                addOption(); // Add one option by default
            }
        } else {
            optionsSection.style.display = 'none';
            optionsContainer.innerHTML = '';
        }

        // Show/hide validation rules based on type
        if (['text', 'textarea', 'email', 'password', 'url', 'tel'].includes(selectedType)) {
            lengthRules.style.display = 'block';
            numericRules.style.display = 'none';
        } else if (['number'].includes(selectedType)) {
            lengthRules.style.display = 'none';
            numericRules.style.display = 'block';
        } else {
            lengthRules.style.display = 'none';
            numericRules.style.display = 'none';
        }

        // Show pattern rule for text-based fields
        if (['text', 'email', 'password', 'url', 'tel'].includes(selectedType)) {
            patternRule.style.display = 'block';
        } else {
            patternRule.style.display = 'none';
        }

        updatePreview();
    }

    function addOption(value = '') {
        const template = document.getElementById('optionTemplate');
        const optionElement = template.content.cloneNode(true);
        const input = optionElement.querySelector('input[name="options[]"]');
        const removeBtn = optionElement.querySelector('.remove-option');

        if (value) {
            input.value = value;
        }

        removeBtn.addEventListener('click', function() {
            this.closest('.option-row').remove();
            updatePreview();
        });

        input.addEventListener('input', updatePreview);
        optionsContainer.appendChild(optionElement);
        updatePreview();
    }

    function updatePreview() {
        const type = typeSelect.value;
        const label = document.getElementById('label').value || 'Campo de Ejemplo';
        const placeholder = document.getElementById('placeholder').value;
        const required = document.getElementById('required').checked;

        let previewHTML = `<label class="form-label">${label}${required ? ' <span class="text-danger">*</span>' : ''}</label>`;

        switch (type) {
            case 'text':
            case 'email':
            case 'password':
            case 'url':
            case 'tel':
                previewHTML += `<input type="${type}" class="form-control" placeholder="${placeholder}" disabled>`;
                break;
            case 'textarea':
                previewHTML += `<textarea class="form-control" placeholder="${placeholder}" disabled></textarea>`;
                break;
            case 'number':
                previewHTML += `<input type="number" class="form-control" placeholder="${placeholder}" disabled>`;
                break;
            case 'date':
            case 'datetime-local':
            case 'time':
                previewHTML += `<input type="${type}" class="form-control" disabled>`;
                break;
            case 'select':
                previewHTML += '<select class="form-select" disabled><option>Seleccionar...</option>';
                optionsContainer.querySelectorAll('input[name="options[]"]').forEach(input => {
                    if (input.value.trim()) {
                        previewHTML += `<option>${input.value}</option>`;
                    }
                });
                previewHTML += '</select>';
                break;
            case 'radio':
                optionsContainer.querySelectorAll('input[name="options[]"]').forEach((input, index) => {
                    if (input.value.trim()) {
                        previewHTML += `
                            <div class="form-check">
                                <input class="form-check-input" type="radio" disabled>
                                <label class="form-check-label">${input.value}</label>
                            </div>`;
                    }
                });
                break;
            case 'checkbox':
                previewHTML += `
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" disabled>
                        <label class="form-check-label">${label}</label>
                    </div>`;
                break;
            case 'file':
            case 'image':
                previewHTML += `<input type="file" class="form-control" disabled>`;
                break;
            default:
                previewHTML += '<p class="text-muted">Selecciona un tipo de campo</p>';
        }

        fieldPreview.innerHTML = previewHTML;
    }

    // Initialize existing options
    if (existingOptions.length > 0) {
        existingOptions.forEach(option => addOption(option));
    }

    // Event listeners
    typeSelect.addEventListener('change', toggleSections);
    addOptionBtn.addEventListener('click', () => addOption());

    // Update preview on input changes
    ['label', 'placeholder', 'required'].forEach(id => {
        const element = document.getElementById(id);
        if (element) {
            element.addEventListener('input', updatePreview);
            element.addEventListener('change', updatePreview);
        }
    });

    // Initialize
    toggleSections();
});
</script>
@endsection
