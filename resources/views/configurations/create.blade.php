@extends('layouts.app')

@section('title', 'Nueva Configuración')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-plus text-success me-2"></i>
                        Nueva Configuración
                    </h1>
                    <p class="text-muted mb-0">Crear una nueva configuración del sistema</p>
                </div>
                <a href="{{ route('configurations.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Volver
                </a>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-success">
                                <i class="fas fa-plus me-2"></i>Datos de la Configuración
                            </h6>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('configurations.store') }}">
                                @csrf
                                
                                <!-- Información básica -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Clave <span class="text-danger">*</span></label>
                                            <input type="text" 
                                                   class="form-control @error('key') is-invalid @enderror" 
                                                   name="key" 
                                                   value="{{ old('key') }}" 
                                                   placeholder="ej: empresa_nombre" 
                                                   required>
                                            <div class="form-text">Identificador único de la configuración (sin espacios)</div>
                                            @error('key')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Tipo de Dato <span class="text-danger">*</span></label>
                                            <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                                                <option value="">Seleccionar tipo...</option>
                                                @foreach($types as $type)
                                                    <option value="{{ $type }}" {{ old('type') == $type ? 'selected' : '' }}>
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
                                                    <option value="{{ $module }}" {{ old('module') == $module ? 'selected' : '' }}>
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
                                                <option value="">Seleccionar categoría...</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category }}" {{ old('category') == $category ? 'selected' : '' }}>
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
                                        <!-- El contenido se generará dinámicamente según el tipo -->
                                        <input type="text" 
                                               class="form-control @error('value') is-invalid @enderror" 
                                               name="value" 
                                               value="{{ old('value') }}" 
                                               id="defaultValueInput">
                                    </div>
                                    <div class="form-text" id="valueHelp">Ingrese el valor para esta configuración</div>
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
                                              placeholder="Describe qué hace esta configuración y cómo se usa">{{ old('description') }}</textarea>
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
                                                       {{ old('editable', '1') ? 'checked' : '' }}>
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
                                                   value="{{ old('sort_order', 0) }}" 
                                                   min="0">
                                            <div class="form-text">Número para ordenar las configuraciones (0 = primero)</div>
                                            @error('sort_order')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Botones -->
                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-save me-2"></i>
                                            Crear Configuración
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
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-info-circle me-2"></i>
                                Información
                            </h6>
                        </div>
                        <div class="card-body">
                            <h6 class="text-primary">Tipos de Datos</h6>
                            <ul class="text-muted small">
                                <li><strong>String:</strong> Texto simple</li>
                                <li><strong>Number:</strong> Números enteros o decimales</li>
                                <li><strong>Boolean:</strong> Verdadero/Falso</li>
                                <li><strong>JSON:</strong> Objeto o array JSON</li>
                                <li><strong>Text:</strong> Texto largo (múltiples líneas)</li>
                                <li><strong>Date:</strong> Fechas</li>
                                <li><strong>Email:</strong> Direcciones de correo</li>
                                <li><strong>URL:</strong> Enlaces web</li>
                            </ul>

                            <hr>

                            <h6 class="text-primary">Convenciones</h6>
                            <ul class="text-muted small">
                                <li>Use guiones bajos para separar palabras en las claves</li>
                                <li>Prefije las claves con el módulo (ej: empresa_nombre)</li>
                                <li>Sea descriptivo en las claves</li>
                                <li>Use categorías para agrupar configuraciones relacionadas</li>
                            </ul>

                            <hr>

                            <h6 class="text-primary">Ejemplos</h6>
                            <div class="bg-light p-2 rounded">
                                <small>
                                    <strong>Clave:</strong> empresa_ruc<br>
                                    <strong>Tipo:</strong> string<br>
                                    <strong>Categoría:</strong> empresa<br>
                                    <strong>Valor:</strong> 20123456789
                                </small>
                            </div>
                        </div>
                    </div>
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
    const valueHelp = document.getElementById('valueHelp');
    
    function updateValueField() {
        const type = typeSelect.value;
        let html = '';
        let help = '';
        
        switch(type) {
            case 'boolean':
                html = `<div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="value" value="1" id="booleanValue">
                    <label class="form-check-label" for="booleanValue">Activado</label>
                </div>`;
                help = 'Marque para establecer como verdadero, deje sin marcar para falso';
                break;
                
            case 'number':
                html = `<input type="number" step="any" class="form-control" name="value" value="{{ old('value') }}" placeholder="0">`;
                help = 'Ingrese un número entero o decimal';
                break;
                
            case 'text':
                html = `<textarea class="form-control" name="value" rows="4" placeholder="Texto largo...">{{ old('value') }}</textarea>`;
                help = 'Ingrese texto de múltiples líneas';
                break;
                
            case 'json':
                html = `<textarea class="form-control font-monospace" name="value" rows="6" placeholder='{"key": "value"}'>{{ old('value') }}</textarea>`;
                help = 'Ingrese un objeto JSON válido';
                break;
                
            case 'date':
                html = `<input type="date" class="form-control" name="value" value="{{ old('value') }}">`;
                help = 'Seleccione una fecha';
                break;
                
            case 'email':
                html = `<input type="email" class="form-control" name="value" value="{{ old('value') }}" placeholder="usuario@ejemplo.com">`;
                help = 'Ingrese una dirección de correo electrónico válida';
                break;
                
            case 'url':
                html = `<input type="url" class="form-control" name="value" value="{{ old('value') }}" placeholder="https://ejemplo.com">`;
                help = 'Ingrese una URL válida';
                break;
                
            default:
                html = `<input type="text" class="form-control" name="value" value="{{ old('value') }}" placeholder="Valor...">`;
                help = 'Ingrese el valor para esta configuración';
        }
        
        valueContainer.innerHTML = html;
        valueHelp.textContent = help;
    }
    
    typeSelect.addEventListener('change', updateValueField);
    
    // Inicializar con el tipo seleccionado
    if (typeSelect.value) {
        updateValueField();
    }
});
</script>
@endpush
@endsection