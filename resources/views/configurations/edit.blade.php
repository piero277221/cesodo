@extends('layouts.app')

@section('title', 'Editar Configuración')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-edit text-warning me-2"></i>
                        Editar Configuración
                    </h1>
                    <p class="text-muted mb-0">Modificar configuración: <code>{{ $configuration->key }}</code></p>
                </div>
                <div>
                    <a href="{{ route('configurations.show', $configuration) }}" class="btn btn-outline-info me-2">
                        <i class="fas fa-eye me-2"></i>
                        Ver Detalles
                    </a>
                    <a href="{{ route('configurations.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Volver
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-warning">
                                <i class="fas fa-edit me-2"></i>Datos de la Configuración
                            </h6>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('configurations.update', $configuration) }}">
                                @csrf
                                @method('PUT')

                                <!-- Información básica -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Clave <span class="text-danger">*</span></label>
                                            <input type="text"
                                                   class="form-control @error('key') is-invalid @enderror"
                                                   name="key"
                                                   value="{{ old('key', $configuration->key) }}"
                                                   required>
                                            <div class="form-text">Identificador único de la configuración</div>
                                            @error('key')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Tipo de Dato <span class="text-danger">*</span></label>
                                            <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                                                @foreach($types as $type)
                                                    <option value="{{ $type }}" {{ old('type', $configuration->type) == $type ? 'selected' : '' }}>
                                                        {{ ucfirst($type) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Módulo</label>
                                            <select name="module" class="form-select @error('module') is-invalid @enderror">
                                                <option value="">Sin módulo específico</option>
                                                @foreach($modules as $module)
                                                    <option value="{{ $module }}" {{ old('module', $configuration->module) == $module ? 'selected' : '' }}>
                                                        {{ ucfirst($module) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('module')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Categoría <span class="text-danger">*</span></label>
                                            <select name="category" class="form-select @error('category') is-invalid @enderror" required>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category }}" {{ old('category', $configuration->category) == $category ? 'selected' : '' }}>
                                                        {{ ucfirst($category) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Valor -->
                                <div class="mb-3">
                                    <label class="form-label">Valor</label>
                                    <div id="valueContainer">
                                        @if($configuration->type === 'boolean')
                                            <div class="form-check form-switch">
                                                <input class="form-check-input"
                                                       type="checkbox"
                                                       name="value"
                                                       value="1"
                                                       id="booleanValue"
                                                       {{ old('value', $configuration->value) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="booleanValue">Activado</label>
                                            </div>
                                        @elseif($configuration->type === 'text' || $configuration->type === 'json')
                                            <textarea class="form-control @if($configuration->type === 'json') font-monospace @endif @error('value') is-invalid @enderror"
                                                      name="value"
                                                      rows="{{ $configuration->type === 'json' ? '6' : '4' }}"
                                                      placeholder="{{ $configuration->type === 'json' ? '{"key": "value"}' : 'Texto largo...' }}">{{ old('value', $configuration->value) }}</textarea>
                                        @elseif($configuration->type === 'number')
                                            <input type="number"
                                                   step="any"
                                                   class="form-control @error('value') is-invalid @enderror"
                                                   name="value"
                                                   value="{{ old('value', $configuration->value) }}">
                                        @elseif($configuration->type === 'date')
                                            <input type="date"
                                                   class="form-control @error('value') is-invalid @enderror"
                                                   name="value"
                                                   value="{{ old('value', $configuration->value) }}">
                                        @elseif($configuration->type === 'email')
                                            <input type="email"
                                                   class="form-control @error('value') is-invalid @enderror"
                                                   name="value"
                                                   value="{{ old('value', $configuration->value) }}">
                                        @elseif($configuration->type === 'url')
                                            <input type="url"
                                                   class="form-control @error('value') is-invalid @enderror"
                                                   name="value"
                                                   value="{{ old('value', $configuration->value) }}">
                                        @else
                                            <input type="text"
                                                   class="form-control @error('value') is-invalid @enderror"
                                                   name="value"
                                                   value="{{ old('value', $configuration->value) }}">
                                        @endif
                                    </div>
                                    @error('value')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Descripción -->
                                <div class="mb-3">
                                    <label class="form-label">Descripción</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror"
                                              name="description"
                                              rows="3"
                                              placeholder="Describe qué hace esta configuración y cómo se usa">{{ old('description', $configuration->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Opciones avanzadas -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input"
                                                       type="checkbox"
                                                       name="editable"
                                                       value="1"
                                                       id="editable"
                                                       {{ old('editable', $configuration->editable) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="editable">
                                                    <i class="fas fa-edit text-primary me-2"></i>
                                                    Editable por usuarios
                                                </label>
                                            </div>
                                            <div class="form-text">Si está marcado, los usuarios podrán modificar esta configuración</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Orden de Visualización</label>
                                            <input type="number"
                                                   class="form-control @error('sort_order') is-invalid @enderror"
                                                   name="sort_order"
                                                   value="{{ old('sort_order', $configuration->sort_order) }}"
                                                   min="0">
                                            <div class="form-text">Número para ordenar las configuraciones</div>
                                            @error('sort_order')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Botones -->
                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-warning">
                                            <i class="fas fa-save me-2"></i>
                                            Actualizar Configuración
                                        </button>
                                        <a href="{{ route('configurations.index') }}" class="btn btn-secondary ms-2">
                                            <i class="fas fa-times me-2"></i>
                                            Cancelar
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Panel de información -->
                <div class="col-lg-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-info-circle me-2"></i>
                                Información Actual
                            </h6>
                        </div>
                        <div class="card-body">
                            <dl class="row">
                                <dt class="col-4">ID:</dt>
                                <dd class="col-8">{{ $configuration->id }}</dd>

                                <dt class="col-4">Creada:</dt>
                                <dd class="col-8">{{ $configuration->created_at->format('d/m/Y H:i') }}</dd>

                                <dt class="col-4">Actualizada:</dt>
                                <dd class="col-8">{{ $configuration->updated_at->format('d/m/Y H:i') }}</dd>

                                <dt class="col-4">Sistema:</dt>
                                <dd class="col-8">
                                    @if($configuration->is_system)
                                        <span class="badge bg-warning">Sí</span>
                                    @else
                                        <span class="badge bg-success">No</span>
                                    @endif
                                </dd>
                            </dl>
                        </div>
                    </div>

                    @if($configuration->is_system)
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Configuración del Sistema:</strong> Esta configuración es crítica para el funcionamiento del sistema.
                        </div>
                    @endif

                    @if(!$configuration->editable)
                        <div class="alert alert-info">
                            <i class="fas fa-lock me-2"></i>
                            <strong>No Editable:</strong> Esta configuración no puede ser modificada por usuarios finales.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.querySelector('select[name="type"]');
    const valueContainer = document.getElementById('valueContainer');

    function updateValueField() {
        const type = typeSelect.value;
        const currentValue = '{{ old('value', $configuration->value) }}';
        let html = '';

        switch(type) {
            case 'boolean':
                const checked = currentValue ? 'checked' : '';
                html = `<div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="value" value="1" id="booleanValue" ${checked}>
                    <label class="form-check-label" for="booleanValue">Activado</label>
                </div>`;
                break;

            case 'number':
                html = `<input type="number" step="any" class="form-control" name="value" value="${currentValue}">`;
                break;

            case 'text':
                html = `<textarea class="form-control" name="value" rows="4">${currentValue}</textarea>`;
                break;

            case 'json':
                html = `<textarea class="form-control font-monospace" name="value" rows="6">${currentValue}</textarea>`;
                break;

            case 'date':
                html = `<input type="date" class="form-control" name="value" value="${currentValue}">`;
                break;

            case 'email':
                html = `<input type="email" class="form-control" name="value" value="${currentValue}">`;
                break;

            case 'url':
                html = `<input type="url" class="form-control" name="value" value="${currentValue}">`;
                break;

            default:
                html = `<input type="text" class="form-control" name="value" value="${currentValue}">`;
        }

        valueContainer.innerHTML = html;
    }

    typeSelect.addEventListener('change', updateValueField);
});
</script>
@endpush
@endsection
