@extends('layouts.app')

@section('title', 'Detalles del Campo Dinámico')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-eye me-2 text-info"></i>
                Detalles del Campo: {{ $dynamicField->label }}
            </h1>
            <nav aria-label="breadcrumb" class="mt-2">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('modules.index') }}">Módulos</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('dynamic-fields.index') }}">Campos Dinámicos</a></li>
                    <li class="breadcrumb-item active">{{ $dynamicField->name }}</li>
                </ol>
            </nav>
        </div>
        <div>
            <div class="btn-group" role="group">
                <a href="{{ route('dynamic-fields.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Volver
                </a>
                <a href="{{ route('dynamic-fields.edit', $dynamicField) }}" class="btn btn-outline-primary">
                    <i class="fas fa-edit me-1"></i> Editar
                </a>
                <form action="{{ route('dynamic-fields.duplicate', $dynamicField) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-success" title="Duplicar campo">
                        <i class="fas fa-copy me-1"></i> Duplicar
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Basic Information -->
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Información General
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong class="text-muted d-block">Nombre del Campo:</strong>
                            <span class="badge bg-dark fs-6">{{ $dynamicField->name }}</span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong class="text-muted d-block">Etiqueta:</strong>
                            <span>{{ $dynamicField->label }}</span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong class="text-muted d-block">Tipo de Campo:</strong>
                            <span class="badge bg-info fs-6">
                                @php
                                    $typeLabels = [
                                        'text' => 'Texto',
                                        'textarea' => 'Área de Texto',
                                        'number' => 'Número',
                                        'email' => 'Email',
                                        'password' => 'Contraseña',
                                        'date' => 'Fecha',
                                        'datetime' => 'Fecha y Hora',
                                        'time' => 'Hora',
                                        'select' => 'Lista Desplegable',
                                        'checkbox' => 'Casilla de Verificación',
                                        'radio' => 'Botones de Radio',
                                        'file' => 'Archivo',
                                        'image' => 'Imagen',
                                        'url' => 'URL',
                                        'tel' => 'Teléfono'
                                    ];
                                @endphp
                                {{ $typeLabels[$dynamicField->type] ?? $dynamicField->type }}
                            </span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong class="text-muted d-block">Módulo:</strong>
                            <span class="badge bg-secondary fs-6">{{ ucfirst($dynamicField->module) }}</span>
                        </div>
                        @if($dynamicField->description)
                        <div class="col-12 mb-3">
                            <strong class="text-muted d-block">Descripción:</strong>
                            <p class="mb-0">{{ $dynamicField->description }}</p>
                        </div>
                        @endif
                        <div class="col-md-6 mb-3">
                            <strong class="text-muted d-block">Estado:</strong>
                            @if($dynamicField->is_active)
                                <span class="badge bg-success fs-6">
                                    <i class="fas fa-check me-1"></i> Activo
                                </span>
                            @else
                                <span class="badge bg-danger fs-6">
                                    <i class="fas fa-times me-1"></i> Inactivo
                                </span>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong class="text-muted d-block">Orden:</strong>
                            <span>{{ $dynamicField->sort_order }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Field Configuration -->
            <div class="card shadow mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-cogs me-2"></i>
                        Configuración del Campo
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if($dynamicField->placeholder)
                        <div class="col-md-6 mb-3">
                            <strong class="text-muted d-block">Placeholder:</strong>
                            <span>{{ $dynamicField->placeholder }}</span>
                        </div>
                        @endif
                        @if($dynamicField->default_value)
                        <div class="col-md-6 mb-3">
                            <strong class="text-muted d-block">Valor por Defecto:</strong>
                            <span>{{ $dynamicField->default_value }}</span>
                        </div>
                        @endif
                        @if($dynamicField->css_classes)
                        <div class="col-md-6 mb-3">
                            <strong class="text-muted d-block">Clases CSS:</strong>
                            <code>{{ $dynamicField->css_classes }}</code>
                        </div>
                        @endif
                        @if($dynamicField->group)
                        <div class="col-md-6 mb-3">
                            <strong class="text-muted d-block">Grupo:</strong>
                            <span class="badge bg-warning text-dark fs-6">{{ $dynamicField->group->name }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Options (for select/radio fields) -->
            @if(in_array($dynamicField->type, ['select', 'radio']) && $dynamicField->options)
            <div class="card shadow mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2"></i>
                        Opciones del Campo
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($dynamicField->options as $index => $option)
                        <div class="col-md-6 mb-2">
                            <div class="d-flex align-items-center">
                                <span class="badge bg-light text-dark me-2">{{ $index + 1 }}</span>
                                <span>{{ $option }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Validation Rules -->
            @if($dynamicField->validation_rules && !empty($dynamicField->validation_rules))
            <div class="card shadow mb-4">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fas fa-shield-alt me-2"></i>
                        Reglas de Validación
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @php
                            $rules = $dynamicField->validation_rules;
                        @endphp
                        
                        @if(isset($rules['required']))
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-circle text-danger me-2"></i>
                                <span>Campo Obligatorio</span>
                            </div>
                        </div>
                        @endif
                        
                        @if(isset($rules['unique']))
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-fingerprint text-info me-2"></i>
                                <span>Valor Único</span>
                            </div>
                        </div>
                        @endif
                        
                        @if(isset($rules['min_length']))
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-ruler text-primary me-2"></i>
                                <span>Longitud Mínima: {{ $rules['min_length'] }}</span>
                            </div>
                        </div>
                        @endif
                        
                        @if(isset($rules['max_length']))
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-ruler text-primary me-2"></i>
                                <span>Longitud Máxima: {{ $rules['max_length'] }}</span>
                            </div>
                        </div>
                        @endif
                        
                        @if(isset($rules['min_value']))
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-sort-numeric-down text-success me-2"></i>
                                <span>Valor Mínimo: {{ $rules['min_value'] }}</span>
                            </div>
                        </div>
                        @endif
                        
                        @if(isset($rules['max_value']))
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-sort-numeric-up text-success me-2"></i>
                                <span>Valor Máximo: {{ $rules['max_value'] }}</span>
                            </div>
                        </div>
                        @endif
                        
                        @if(isset($rules['pattern']))
                        <div class="col-12 mb-3">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-code text-secondary me-2 mt-1"></i>
                                <div>
                                    <strong>Patrón (Regex):</strong>
                                    <code class="d-block mt-1">{{ $rules['pattern'] }}</code>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Field Preview -->
            <div class="card shadow mb-4">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-eye me-2"></i>
                        Vista Previa del Campo
                    </h5>
                </div>
                <div class="card-body">
                    <div class="field-preview">
                        {!! $dynamicField->renderField('preview_value') !!}
                    </div>
                </div>
            </div>

            <!-- Usage Statistics -->
            <div class="card shadow mb-4">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-bar me-2"></i>
                        Estadísticas de Uso
                    </h5>
                </div>
                <div class="card-body">
                    @php
                        $usageCount = \App\Models\DynamicFieldValue::where('dynamic_field_id', $dynamicField->id)->count();
                        $uniqueModels = \App\Models\DynamicFieldValue::where('dynamic_field_id', $dynamicField->id)
                            ->distinct('model_type', 'model_id')
                            ->count();
                    @endphp
                    
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="h4 mb-0 text-primary">{{ $usageCount }}</div>
                            <small class="text-muted">Valores Totales</small>
                        </div>
                        <div class="col-6">
                            <div class="h4 mb-0 text-success">{{ $uniqueModels }}</div>
                            <small class="text-muted">Registros Únicos</small>
                        </div>
                    </div>
                    
                    @if($usageCount > 0)
                    <hr>
                    <div class="alert alert-info alert-sm mb-0">
                        <i class="fas fa-info-circle me-1"></i>
                        <small>Este campo está siendo utilizado. Ten cuidado al editarlo.</small>
                    </div>
                    @else
                    <hr>
                    <div class="alert alert-warning alert-sm mb-0">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        <small>Este campo aún no se ha utilizado en ningún registro.</small>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Metadata -->
            <div class="card shadow mb-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0 text-dark">
                        <i class="fas fa-info me-2"></i>
                        Información del Sistema
                    </h6>
                </div>
                <div class="card-body">
                    <small class="text-muted d-block mb-2">
                        <strong>Creado:</strong> 
                        {{ $dynamicField->created_at->format('d/m/Y H:i') }}
                    </small>
                    <small class="text-muted d-block mb-2">
                        <strong>Actualizado:</strong> 
                        {{ $dynamicField->updated_at->format('d/m/Y H:i') }}
                    </small>
                    <small class="text-muted d-block">
                        <strong>ID:</strong> 
                        <code>{{ $dynamicField->id }}</code>
                    </small>
                </div>
            </div>

            <!-- Actions -->
            <div class="card shadow">
                <div class="card-header bg-danger text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Zona de Peligro
                    </h6>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">
                        Esta acción eliminará permanentemente el campo y todos sus datos asociados.
                    </p>
                    
                    <form action="{{ route('dynamic-fields.destroy', $dynamicField) }}" 
                          method="POST" 
                          onsubmit="return confirm('¿Estás seguro de que deseas eliminar este campo? Esta acción no se puede deshacer.')">
                        @csrf
                        @method('DELETE')
                        
                        <button type="submit" 
                                class="btn btn-danger btn-sm w-100"
                                @if($usageCount > 0) disabled title="No se puede eliminar porque está en uso" @endif>
                            <i class="fas fa-trash me-1"></i>
                            @if($usageCount > 0)
                                No se puede eliminar (en uso)
                            @else
                                Eliminar Campo
                            @endif
                        </button>
                    </form>
                    
                    @if($usageCount > 0)
                    <small class="text-muted d-block mt-2">
                        <i class="fas fa-info-circle me-1"></i>
                        Para eliminar este campo, primero debes eliminar todos los registros que lo usan.
                    </small>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.field-preview .form-control,
.field-preview .form-select,
.field-preview .form-check-input {
    pointer-events: none;
    background-color: #f8f9fa;
}

.alert-sm {
    padding: 0.5rem;
    font-size: 0.875rem;
}

.badge.fs-6 {
    font-size: 0.875rem !important;
}
</style>
@endsection