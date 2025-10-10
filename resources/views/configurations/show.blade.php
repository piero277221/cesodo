@extends('layouts.app')

@section('title', 'Detalles de Configuración')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-cog text-info me-2"></i>
                        Detalles de Configuración
                    </h1>
                    <p class="text-muted mb-0">
                        <code class="bg-light px-2 py-1 rounded">{{ $configuration->key }}</code>
                    </p>
                </div>
                <div>
                    @if($configuration->editable && !$configuration->is_system)
                        @can('editar-configuraciones')
                            <a href="{{ route('configurations.edit', $configuration) }}" class="btn btn-warning me-2">
                                <i class="fas fa-edit me-2"></i>
                                Editar
                            </a>
                        @endcan
                    @endif
                    <a href="{{ route('configurations.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Volver al Listado
                    </a>
                </div>
            </div>

            <div class="row">
                <!-- Información principal -->
                <div class="col-lg-8">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-info">
                                <i class="fas fa-info-circle me-2"></i>
                                Información General
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <dl class="row">
                                        <dt class="col-5">Clave:</dt>
                                        <dd class="col-7">
                                            <code class="bg-light px-2 py-1 rounded">{{ $configuration->key }}</code>
                                        </dd>

                                        <dt class="col-5">Tipo:</dt>
                                        <dd class="col-7">
                                            <span class="badge
                                                @switch($configuration->type)
                                                    @case('boolean') bg-success @break
                                                    @case('number') bg-primary @break
                                                    @case('json') bg-warning @break
                                                    @case('date') bg-info @break
                                                    @default bg-light text-dark
                                                @endswitch
                                            ">
                                                {{ ucfirst($configuration->type) }}
                                            </span>
                                        </dd>

                                        <dt class="col-5">Módulo:</dt>
                                        <dd class="col-7">
                                            @if($configuration->module)
                                                <span class="badge bg-info">{{ ucfirst($configuration->module) }}</span>
                                            @else
                                                <span class="text-muted">Sin módulo específico</span>
                                            @endif
                                        </dd>

                                        <dt class="col-5">Categoría:</dt>
                                        <dd class="col-7">
                                            <span class="badge bg-secondary">{{ ucfirst($configuration->category) }}</span>
                                        </dd>
                                    </dl>
                                </div>
                                <div class="col-md-6">
                                    <dl class="row">
                                        <dt class="col-5">Editable:</dt>
                                        <dd class="col-7">
                                            @if($configuration->editable)
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check me-1"></i>Sí
                                                </span>
                                            @else
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-times me-1"></i>No
                                                </span>
                                            @endif
                                        </dd>

                                        <dt class="col-5">Sistema:</dt>
                                        <dd class="col-7">
                                            @if($configuration->is_system)
                                                <span class="badge bg-warning">
                                                    <i class="fas fa-shield-alt me-1"></i>Sí
                                                </span>
                                            @else
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check me-1"></i>No
                                                </span>
                                            @endif
                                        </dd>

                                        <dt class="col-5">Orden:</dt>
                                        <dd class="col-7">{{ $configuration->sort_order }}</dd>

                                        <dt class="col-5">ID:</dt>
                                        <dd class="col-7">#{{ $configuration->id }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Valor actual -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-database me-2"></i>
                                Valor Actual
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Valor:</label>
                                @if($configuration->type === 'boolean')
                                    <div>
                                        <span class="badge fs-6 {{ $configuration->value ? 'bg-success' : 'bg-danger' }}">
                                            <i class="fas {{ $configuration->value ? 'fa-check' : 'fa-times' }} me-1"></i>
                                            {{ $configuration->value ? 'Verdadero (Activado)' : 'Falso (Desactivado)' }}
                                        </span>
                                    </div>
                                @elseif($configuration->type === 'json')
                                    <div class="bg-light p-3 rounded">
                                        <pre class="mb-0"><code>{{ json_encode(json_decode($configuration->value), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</code></pre>
                                    </div>
                                @elseif($configuration->type === 'text' && strlen($configuration->value) > 100)
                                    <div class="bg-light p-3 rounded">
                                        <div style="max-height: 200px; overflow-y: auto;">
                                            {{ $configuration->value }}
                                        </div>
                                    </div>
                                @else
                                    <div class="bg-light p-3 rounded">
                                        @if(empty($configuration->value))
                                            <span class="text-muted fst-italic">(Vacío)</span>
                                        @else
                                            <strong>{{ $configuration->value }}</strong>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            @if($configuration->type === 'json')
                                <div class="mt-3">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Los valores JSON se muestran formateados para mejor legibilidad
                                    </small>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if($configuration->description)
                        <!-- Descripción -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-success">
                                    <i class="fas fa-file-text me-2"></i>
                                    Descripción
                                </h6>
                            </div>
                            <div class="card-body">
                                <p class="mb-0">{{ $configuration->description }}</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Panel lateral -->
                <div class="col-lg-4">
                    <!-- Acciones rápidas -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-bolt me-2"></i>
                                Acciones Rápidas
                            </h6>
                        </div>
                        <div class="card-body">
                            @if($configuration->editable && !$configuration->is_system)
                                @can('editar-configuraciones')
                                    <a href="{{ route('configurations.edit', $configuration) }}"
                                       class="btn btn-warning btn-sm w-100 mb-2">
                                        <i class="fas fa-edit me-2"></i>
                                        Editar Configuración
                                    </a>
                                @endcan

                                @can('eliminar-configuraciones')
                                    <form method="POST"
                                          action="{{ route('configurations.destroy', $configuration) }}"
                                          onsubmit="return confirm('¿Estás seguro de eliminar esta configuración?')"
                                          class="mb-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm w-100">
                                            <i class="fas fa-trash me-2"></i>
                                            Eliminar Configuración
                                        </button>
                                    </form>
                                @endcan
                            @endif

                            <a href="{{ route('configurations.index') }}?module={{ $configuration->module }}"
                               class="btn btn-outline-info btn-sm w-100 mb-2">
                                <i class="fas fa-filter me-2"></i>
                                Ver del Mismo Módulo
                            </a>

                            <a href="{{ route('configurations.index') }}?category={{ $configuration->category }}"
                               class="btn btn-outline-secondary btn-sm w-100">
                                <i class="fas fa-tags me-2"></i>
                                Ver de Misma Categoría
                            </a>
                        </div>
                    </div>

                    <!-- Metadatos -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-info">
                                <i class="fas fa-clock me-2"></i>
                                Metadatos
                            </h6>
                        </div>
                        <div class="card-body">
                            <dl class="mb-0">
                                <dt class="small text-muted">Fecha de Creación:</dt>
                                <dd class="mb-2">
                                    <i class="fas fa-calendar-plus text-success me-1"></i>
                                    {{ $configuration->created_at->format('d/m/Y H:i:s') }}
                                </dd>

                                <dt class="small text-muted">Última Actualización:</dt>
                                <dd class="mb-2">
                                    <i class="fas fa-calendar-check text-warning me-1"></i>
                                    {{ $configuration->updated_at->format('d/m/Y H:i:s') }}
                                    @if($configuration->created_at->ne($configuration->updated_at))
                                        <br><small class="text-muted">({{ $configuration->updated_at->diffForHumans() }})</small>
                                    @endif
                                </dd>

                                @if($configuration->validation_rules)
                                    <dt class="small text-muted">Reglas de Validación:</dt>
                                    <dd class="mb-0">
                                        <div class="bg-light p-2 rounded small">
                                            <pre class="mb-0">{{ json_encode($configuration->validation_rules, JSON_PRETTY_PRINT) }}</pre>
                                        </div>
                                    </dd>
                                @endif
                            </dl>
                        </div>
                    </div>

                    <!-- Alertas de estado -->
                    @if($configuration->is_system)
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Configuración del Sistema:</strong> Esta es una configuración crítica del sistema. Los cambios pueden afectar el funcionamiento de la aplicación.
                        </div>
                    @endif

                    @if(!$configuration->editable)
                        <div class="alert alert-info">
                            <i class="fas fa-lock me-2"></i>
                            <strong>Solo Lectura:</strong> Esta configuración no puede ser modificada por usuarios finales.
                        </div>
                    @endif

                    @if($configuration->type === 'json')
                        <div class="alert alert-light">
                            <i class="fas fa-code me-2"></i>
                            <strong>Formato JSON:</strong> Esta configuración almacena datos en formato JSON. Asegúrate de mantener la sintaxis correcta al editarla.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
