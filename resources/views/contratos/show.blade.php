@extends('layouts.app')

@section('title', 'Contrato #' . $contrato->numero_contrato)

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2 text-primary">
            <i class="fas fa-file-contract me-2"></i>
            Contrato #{{ $contrato->numero_contrato ?? 'Sin número' }}
        </h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="{{ route('contratos.edit', $contrato) }}" class="btn btn-outline-primary">
                    <i class="fas fa-edit me-1"></i>Editar
                </a>
                <a href="{{ route('contratos.seleccionar-template', $contrato) }}" class="btn btn-outline-success">
                    <i class="fas fa-file-pdf me-1"></i>Generar PDF
                </a>
                <a href="{{ route('contratos.templates.index') }}" class="btn btn-outline-info">
                    <i class="fas fa-file-alt me-1"></i>Templates
                </a>
            </div>
            <a href="{{ route('contratos.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>Volver
            </a>
        </div>
    </div>

    <!-- Estado y Acciones Rápidas -->
    <div class="row mb-4">
        <div class="col-md-8">
            <!-- Estado Actual -->
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-muted mb-1">Estado Actual</h6>
                            <span class="badge fs-6
                                @if($contrato->estado === 'activo') bg-success
                                @elseif($contrato->estado === 'borrador') bg-warning
                                @elseif($contrato->estado === 'enviado') bg-info
                                @elseif($contrato->estado === 'finalizado') bg-secondary
                                @else bg-dark
                                @endif">
                                <i class="fas fa-circle me-1"></i>
                                {{ ucfirst($contrato->estado) }}
                            </span>
                        </div>
                        <div>
                            @if($contrato->estado === 'borrador' || $contrato->estado === 'enviado')
                                <form action="{{ route('contratos.activar', $contrato) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm"
                                            onclick="return confirm('¿Está seguro de activar este contrato?')">
                                        <i class="fas fa-play me-1"></i>Activar
                                    </button>
                                </form>
                            @endif

                            @if($contrato->estado === 'activo')
                                <form action="{{ route('contratos.finalizar', $contrato) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-secondary btn-sm"
                                            onclick="return confirm('¿Está seguro de finalizar este contrato?')">
                                        <i class="fas fa-stop me-1"></i>Finalizar
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Información Rápida -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted mb-3">Resumen Rápido</h6>
                    <div class="small">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Creado:</span>
                            <span>{{ $contrato->created_at->format('d/m/Y') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span>Tipo:</span>
                            <span class="text-capitalize">{{ str_replace('_', ' ', $contrato->tipo_contrato) }}</span>
                        </div>
                        @if($contrato->fecha_fin)
                            <div class="d-flex justify-content-between mb-1">
                                <span>Días restantes:</span>
                                <span class="
                                    @if($contrato->fecha_fin->diffInDays(now()) <= 30) text-danger
                                    @elseif($contrato->fecha_fin->diffInDays(now()) <= 90) text-warning
                                    @else text-success
                                    @endif
                                ">
                                    {{ $contrato->fecha_fin->diffInDays(now()) }} días
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Información Principal -->
    <div class="row">
        <!-- Información de la Persona -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user me-2"></i>Información Personal
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <label class="form-label text-muted">Nombre Completo</label>
                            <p class="fw-bold mb-0">
                                {{ $contrato->persona->nombres }} {{ $contrato->persona->apellidos }}
                            </p>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label text-muted">Documento</label>
                            <p class="mb-0">{{ $contrato->persona->numero_documento }}</p>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label text-muted">Email</label>
                            <p class="mb-0">
                                @if($contrato->persona->correo)
                                    <a href="mailto:{{ $contrato->persona->correo }}">{{ $contrato->persona->correo }}</a>
                                @else
                                    <span class="text-muted">No registrado</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label text-muted">Teléfono</label>
                            <p class="mb-0">
                                @if($contrato->persona->celular)
                                    <a href="tel:{{ $contrato->persona->celular }}">{{ $contrato->persona->celular }}</a>
                                @else
                                    <span class="text-muted">No registrado</span>
                                @endif
                            </p>
                        </div>
                        @if($contrato->persona->trabajador)
                            <div class="col-12">
                                <div class="alert alert-info mb-0">
                                    <i class="fas fa-briefcase me-1"></i>
                                    <strong>Empleado:</strong> {{ $contrato->persona->trabajador->cargo ?? 'Sin cargo especificado' }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Información del Contrato -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-file-contract me-2"></i>Detalles del Contrato
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <label class="form-label text-muted">Tipo de Contrato</label>
                            <p class="mb-0 text-capitalize fw-bold">
                                {{ str_replace('_', ' ', $contrato->tipo_contrato) }}
                            </p>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label text-muted">Cargo</label>
                            <p class="mb-0 fw-bold">{{ $contrato->cargo }}</p>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label text-muted">Fecha de Inicio</label>
                            <p class="mb-0">{{ $contrato->fecha_inicio->format('d/m/Y') }}</p>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label text-muted">Fecha de Fin</label>
                            <p class="mb-0">
                                @if($contrato->fecha_fin)
                                    {{ $contrato->fecha_fin->format('d/m/Y') }}
                                    @if($contrato->estaVencido())
                                        <span class="badge bg-danger ms-1">Vencido</span>
                                    @elseif($contrato->estaProximoAVencer())
                                        <span class="badge bg-warning ms-1">Por vencer</span>
                                    @endif
                                @else
                                    <span class="text-muted">Indefinido</span>
                                @endif
                            </p>
                        </div>
                        @if($contrato->area_departamento)
                            <div class="col-sm-6 mb-3">
                                <label class="form-label text-muted">Departamento</label>
                                <p class="mb-0">{{ $contrato->area_departamento }}</p>
                            </div>
                        @endif
                        <div class="col-sm-6 mb-3">
                            <label class="form-label text-muted">Jornada Laboral</label>
                            <p class="mb-0 text-capitalize">{{ str_replace('_', ' ', $contrato->jornada_laboral) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Información Económica -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-dollar-sign me-2"></i>Información Económica
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label text-muted">Salario Base</label>
                            <p class="h5 text-success mb-0">
                                ${{ number_format($contrato->salario_base, 2) }}
                            </p>
                        </div>
                        @if($contrato->bonificaciones > 0)
                            <div class="col-md-3 mb-3">
                                <label class="form-label text-muted">Bonificaciones</label>
                                <p class="h6 text-info mb-0">
                                    +${{ number_format($contrato->bonificaciones, 2) }}
                                </p>
                            </div>
                        @endif
                        @if($contrato->descuentos > 0)
                            <div class="col-md-3 mb-3">
                                <label class="form-label text-muted">Descuentos</label>
                                <p class="h6 text-danger mb-0">
                                    -${{ number_format($contrato->descuentos, 2) }}
                                </p>
                            </div>
                        @endif
                        <div class="col-md-3 mb-3">
                            <label class="form-label text-muted">Salario Neto</label>
                            <p class="h4 text-primary mb-0 fw-bold">
                                ${{ number_format($contrato->salario_base + $contrato->bonificaciones - $contrato->descuentos, 2) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cláusulas y Observaciones -->
    @if($contrato->clausulas_especiales || $contrato->observaciones)
    <div class="row mb-4">
        @if($contrato->clausulas_especiales)
        <div class="col-lg-6 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-info text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-list-alt me-1"></i>Cláusulas Especiales
                    </h6>
                </div>
                <div class="card-body">
                    <p class="mb-0 text-justify">{{ $contrato->clausulas_especiales }}</p>
                </div>
            </div>
        </div>
        @endif

        @if($contrato->observaciones)
        <div class="col-lg-6 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-secondary text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-sticky-note me-1"></i>Observaciones
                    </h6>
                </div>
                <div class="card-body">
                    <p class="mb-0 text-justify">{{ $contrato->observaciones }}</p>
                </div>
            </div>
        </div>
        @endif
    </div>
    @endif

    <!-- Archivos -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-paperclip me-2"></i>Archivos del Contrato
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Archivo del Contrato -->
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted">
                                <i class="fas fa-file-contract me-1"></i>Archivo del Contrato
                            </h6>
                            @if($contrato->archivo_contrato)
                                <div class="d-flex align-items-center justify-content-between border rounded p-2">
                                    <div>
                                        <i class="fas fa-file-pdf text-danger me-2"></i>
                                        <span>{{ basename($contrato->archivo_contrato) }}</span>
                                    </div>
                                    <a href="{{ Storage::url($contrato->archivo_contrato) }}"
                                       class="btn btn-sm btn-outline-primary" target="_blank">
                                        <i class="fas fa-download me-1"></i>Descargar
                                    </a>
                                </div>
                            @else
                                <div class="alert alert-warning mb-0">
                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                    No se ha subido archivo del contrato
                                </div>
                            @endif
                        </div>

                        <!-- Contrato Firmado -->
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted">
                                <i class="fas fa-signature me-1"></i>Contrato Firmado
                            </h6>
                            @if($contrato->archivo_firmado)
                                <div class="d-flex align-items-center justify-content-between border rounded p-2">
                                    <div>
                                        <i class="fas fa-file-pdf text-success me-2"></i>
                                        <span>{{ basename($contrato->archivo_firmado) }}</span>
                                        <small class="text-muted d-block">
                                            Subido: {{ $contrato->fecha_firma ? $contrato->fecha_firma->format('d/m/Y H:i') : 'Sin fecha' }}
                                        </small>
                                    </div>
                                    <a href="{{ Storage::url($contrato->archivo_firmado) }}"
                                       class="btn btn-sm btn-outline-success" target="_blank">
                                        <i class="fas fa-download me-1"></i>Descargar
                                    </a>
                                </div>
                            @else
                                <div class="d-flex align-items-center justify-content-between border rounded p-2">
                                    <div class="text-muted">
                                        <i class="fas fa-clock me-1"></i>
                                        Pendiente de firma
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-secondary"
                                            data-bs-toggle="modal" data-bs-target="#subirFirmadoModal">
                                        <i class="fas fa-upload me-1"></i>Subir Firmado
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Documentos Adicionales -->
                    @if($contrato->documentos_adjuntos)
                        <div class="mt-3">
                            <h6 class="text-muted">
                                <i class="fas fa-files me-1"></i>Documentos Adicionales
                            </h6>
                            <div class="row">
                                @foreach(json_decode($contrato->documentos_adjuntos, true) ?? [] as $documento)
                                    <div class="col-md-4 mb-2">
                                        <div class="d-flex align-items-center justify-content-between border rounded p-2">
                                            <div class="text-truncate">
                                                <i class="fas fa-file me-1"></i>
                                                <small>{{ basename($documento) }}</small>
                                            </div>
                                            <a href="{{ Storage::url($documento) }}"
                                               class="btn btn-sm btn-outline-primary" target="_blank">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Historial de Cambios -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-history me-1"></i>Información del Sistema
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <small class="text-muted">Creado:</small>
                            <p class="mb-0">{{ $contrato->created_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                        <div class="col-md-4 mb-2">
                            <small class="text-muted">Última actualización:</small>
                            <p class="mb-0">{{ $contrato->updated_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para subir contrato firmado -->
<div class="modal fade" id="subirFirmadoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('contratos.subir-firmado', $contrato) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-signature me-2"></i>Subir Contrato Firmado
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="archivo_firmado_modal" class="form-label">
                            <i class="fas fa-file-pdf me-1"></i>Archivo del Contrato Firmado
                        </label>
                        <input type="file" class="form-control" id="archivo_firmado_modal"
                               name="archivo_firmado" accept=".pdf,.doc,.docx" required>
                        <div class="form-text">Formatos permitidos: PDF, DOC, DOCX (Máximo 5MB)</div>
                    </div>
                    <div class="mb-3">
                        <label for="fecha_firma_modal" class="form-label">
                            <i class="fas fa-calendar me-1"></i>Fecha de Firma
                        </label>
                        <input type="datetime-local" class="form-control" id="fecha_firma_modal"
                               name="fecha_firma" value="{{ now()->format('Y-m-d\TH:i') }}">
                    </div>
                    <div class="mb-3">
                        <label for="observaciones_firma" class="form-label">
                            <i class="fas fa-sticky-note me-1"></i>Observaciones
                        </label>
                        <textarea class="form-control" id="observaciones_firma" name="observaciones_firma"
                                  rows="2" placeholder="Observaciones sobre la firma..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-upload me-1"></i>Subir Contrato
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validación de archivo en el modal
    const archivoInput = document.getElementById('archivo_firmado_modal');

    archivoInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const maxSize = 5 * 1024 * 1024; // 5MB
            if (file.size > maxSize) {
                alert('El archivo excede el tamaño máximo de 5MB.');
                this.value = '';
            }
        }
    });
});
</script>
@endpush
@endsection
