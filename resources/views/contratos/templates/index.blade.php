@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-file-contract text-primary me-2"></i>
                Templates de Contratos
            </h1>
            <p class="mb-0 text-muted">Gestiona los formatos personalizados para la generación de contratos</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('plantillas.generador') }}" class="btn btn-success">
                <i class="fas fa-magic me-1"></i>
                Generar Plantilla
            </a>
            <a href="{{ route('contratos.templates.create') }}" class="btn btn-primary">
                <i class="fas fa-upload me-1"></i>
                Subir Plantilla
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Nota informativa -->
    <div class="alert alert-info mb-4" role="alert">
        <div class="d-flex align-items-start">
            <i class="fas fa-info-circle text-primary me-3 mt-1"></i>
            <div>
                <h6 class="alert-heading mb-2">
                    <i class="fas fa-file-contract me-2"></i>Plantillas de Contratos
                </h6>
                <p class="mb-2">
                    <strong>Opción 1 - Generar:</strong> Usa nuestro generador visual para crear plantillas desde cero con editor tipo Word.<br>
                    <strong>Opción 2 - Subir:</strong> Sube un documento Word o PDF existente con marcadores (como <code>@{{"{{nombre}}"}}</code>, <code>@{{"{{cedula}}"}}</code>).
                </p>
                <p class="mb-2">
                    En ambos casos, el sistema reemplazará automáticamente los marcadores con los datos del empleado al generar contratos.
                </p>
                <small class="text-muted">
                    <i class="fas fa-lightbulb me-1"></i>
                    Los marcadores detectados se mostrarán después de crear o subir tu plantilla.
                </small>
            </div>
        </div>
    </div>

    <div class="row">
        @forelse($templates as $template)
            <div class="col-lg-6 col-xl-4 mb-4">
                <div class="card h-100 shadow-sm {{ $template->es_predeterminado ? 'border-primary' : '' }}">
                    @if($template->es_predeterminado)
                        <div class="card-header bg-primary text-white py-2">
                            <small><i class="fas fa-star me-1"></i>Template Predeterminado</small>
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="card-title mb-0">{{ $template->nombre }}</h5>
                            <span class="badge bg-{{ $template->activo ? 'success' : 'secondary' }}">
                                {{ $template->activo ? 'Activo' : 'Inactivo' }}
                            </span>
                        </div>

                        @if($template->descripcion)
                            <p class="card-text text-muted small">{{ $template->descripcion }}</p>
                        @endif

                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small class="text-muted">
                                    <i class="fas fa-file-alt me-1"></i>
                                    Tipo: {{ strtoupper($template->tipo) }}
                                </small>
                                <small class="text-muted">
                                    <i class="fas fa-tags me-1"></i>
                                    {{ count($template->marcadores ?? []) }} marcadores
                                </small>
                            </div>

                            @if($template->creadoPor)
                                <small class="text-muted">
                                    <i class="fas fa-user me-1"></i>
                                    Creado por: {{ $template->creadoPor->name }}
                                </small>
                            @endif
                        </div>

                        @if($template->marcadores && count($template->marcadores) > 0)
                            <div class="mb-3">
                                <small class="text-muted d-block mb-1">Marcadores detectados:</small>
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach(array_slice($template->marcadores, 0, 3) as $marcador)
                                        <span class="badge bg-light text-dark border">{{ $marcador }}</span>
                                    @endforeach
                                    @if(count($template->marcadores) > 3)
                                        <span class="badge bg-light text-muted">+{{ count($template->marcadores) - 3 }} más</span>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="card-footer bg-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>
                                {{ $template->created_at->format('d/m/Y') }}
                            </small>

                            <div class="btn-group" role="group">
                                <a href="{{ route('contratos.templates.preview', $template) }}"
                                   class="btn btn-sm btn-outline-info" title="Vista Previa">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <a href="{{ route('contratos.templates.edit', $template) }}"
                                   class="btn btn-sm btn-outline-primary" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>

                                @if(!$template->es_predeterminado)
                                    <form action="{{ route('contratos.templates.set-default', $template) }}"
                                          method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-warning"
                                                title="Establecer como predeterminado">
                                            <i class="fas fa-star"></i>
                                        </button>
                                    </form>
                                @endif

                                <form action="{{ route('contratos.templates.destroy', $template) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('¿Está seguro de eliminar este template?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <div class="mb-4">
                            <i class="fas fa-file-contract fa-4x text-muted"></i>
                        </div>
                        <h4 class="text-muted">No hay templates disponibles</h4>
                        <p class="text-muted mb-4">Crea tu primer template personalizado para generar contratos con tu formato.</p>
                        <a href="{{ route('contratos.templates.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>
                            Crear Primer Template
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Información sobre marcadores -->
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-info-circle text-info me-2"></i>
                Información sobre Marcadores
            </h5>
        </div>
        <div class="card-body">
            <p class="mb-3">Los marcadores son variables que se reemplazan automáticamente con datos del contrato. Algunos ejemplos:</p>
            <div class="row">
                <div class="col-md-4">
                    <h6 class="text-primary">Datos del Trabajador</h6>
                    <ul class="list-unstyled small">
                        <li><code>{NOMBRE_TRABAJADOR}</code></li>
                        <li><code>{CEDULA_TRABAJADOR}</code></li>
                        <li><code>{EMAIL_TRABAJADOR}</code></li>
                        <li><code>{DIRECCION_TRABAJADOR}</code></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6 class="text-primary">Datos del Contrato</h6>
                    <ul class="list-unstyled small">
                        <li><code>{NUMERO_CONTRATO}</code></li>
                        <li><code>{CARGO}</code></li>
                        <li><code>{SALARIO_BASE}</code></li>
                        <li><code>{DEPARTAMENTO}</code></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6 class="text-primary">Fechas</h6>
                    <ul class="list-unstyled small">
                        <li><code>{FECHA_INICIO}</code></li>
                        <li><code>{FECHA_FIN}</code></li>
                        <li><code>{FECHA_ACTUAL}</code></li>
                        <li><code>{FECHA_ACTUAL_LETRAS}</code></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
