@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="fas fa-file-medical text-danger me-2"></i>
            Detalle del Certificado Médico
        </h2>
        <div class="d-flex gap-2">
            <a href="{{ route('certificados-medicos.edit', $certificadosMedico) }}" class="btn btn-warning">
                <i class="fas fa-edit me-1"></i>Editar
            </a>
            <a href="{{ route('certificados-medicos.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>Volver
            </a>
        </div>
    </div>

    <!-- Estado del Certificado -->
    <div class="row mb-4">
        <div class="col-12">
            @if($certificadosMedico->estaVencido())
                <div class="alert alert-danger border-start border-danger border-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-times-circle fa-2x me-3"></i>
                        <div>
                            <h5 class="mb-1">Certificado Vencido</h5>
                            <p class="mb-0">
                                Este certificado venció hace <strong>{{ abs($certificadosMedico->diasRestantes()) }} días</strong>.
                                Por favor, solicite uno nuevo.
                            </p>
                        </div>
                    </div>
                </div>
            @elseif($certificadosMedico->estaProximoAVencer())
                <div class="alert alert-warning border-start border-warning border-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                        <div>
                            <h5 class="mb-1">Certificado Próximo a Vencer</h5>
                            <p class="mb-0">
                                Este certificado vence en <strong>{{ $certificadosMedico->diasRestantes() }} días</strong>.
                                Se recomienda renovarlo pronto.
                            </p>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-success border-start border-success border-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle fa-2x me-3"></i>
                        <div>
                            <h5 class="mb-1">Certificado Vigente</h5>
                            <p class="mb-0">
                                Este certificado es válido por <strong>{{ $certificadosMedico->diasRestantes() }} días más</strong>.
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="row">
        <!-- Información de la Persona -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0"><i class="fas fa-user me-2"></i>Información de la Persona</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong class="text-muted">Nombre Completo:</strong>
                        <p class="mb-0 fs-5">{{ $certificadosMedico->persona->nombre_completo }}</p>
                    </div>

                    <div class="row">
                        <div class="col-6 mb-3">
                            <strong class="text-muted">DNI:</strong>
                            <p class="mb-0">{{ $certificadosMedico->numero_documento }}</p>
                        </div>
                        <div class="col-6 mb-3">
                            <strong class="text-muted">Celular:</strong>
                            <p class="mb-0">
                                @if($certificadosMedico->persona->celular)
                                    <i class="fas fa-phone text-success me-1"></i>
                                    {{ $certificadosMedico->persona->celular }}
                                @else
                                    <span class="text-muted">No registrado</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <strong class="text-muted">Correo Electrónico:</strong>
                        <p class="mb-0">
                            @if($certificadosMedico->persona->correo)
                                <i class="fas fa-envelope text-primary me-1"></i>
                                {{ $certificadosMedico->persona->correo }}
                            @else
                                <span class="text-muted">No registrado</span>
                            @endif
                        </p>
                    </div>

                    @if($certificadosMedico->persona->direccion)
                        <div class="mb-3">
                            <strong class="text-muted">Dirección:</strong>
                            <p class="mb-0">{{ $certificadosMedico->persona->direccion }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Información del Certificado -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0"><i class="fas fa-file-medical me-2"></i>Datos del Certificado</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <strong class="text-muted">Fecha de Emisión:</strong>
                            <p class="mb-0">
                                <i class="fas fa-calendar-check text-success me-1"></i>
                                {{ $certificadosMedico->fecha_emision ? $certificadosMedico->fecha_emision->format('d/m/Y') : 'No registrada' }}
                            </p>
                        </div>
                        <div class="col-6 mb-3">
                            <strong class="text-muted">Fecha de Expiración:</strong>
                            <p class="mb-0">
                                <i class="fas fa-calendar-times text-danger me-1"></i>
                                {{ $certificadosMedico->fecha_expiracion ? $certificadosMedico->fecha_expiracion->format('d/m/Y') : 'No registrada' }}
                            </p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <strong class="text-muted">Estado:</strong>
                        <p class="mb-0">
                            @if($certificadosMedico->estaVencido())
                                <span class="badge bg-danger fs-6">
                                    <i class="fas fa-times-circle me-1"></i>Vencido
                                </span>
                            @elseif($certificadosMedico->estaProximoAVencer())
                                <span class="badge bg-warning text-dark fs-6">
                                    <i class="fas fa-exclamation-triangle me-1"></i>Por vencer
                                </span>
                            @else
                                <span class="badge bg-success fs-6">
                                    <i class="fas fa-check-circle me-1"></i>Vigente
                                </span>
                            @endif
                        </p>
                    </div>

                    <div class="mb-3">
                        <strong class="text-muted">Archivo Adjunto:</strong>
                        <p class="mb-0">
                            @if($certificadosMedico->archivo_certificado)
                                <a href="{{ route('certificados-medicos.descargar', $certificadosMedico) }}"
                                   class="btn btn-outline-info btn-sm">
                                    <i class="fas fa-download me-1"></i>
                                    Descargar Certificado
                                </a>
                            @else
                                <span class="text-muted">Sin archivo adjunto</span>
                            @endif
                        </p>
                    </div>

                    @if($certificadosMedico->observaciones)
                        <div class="mb-3">
                            <strong class="text-muted">Observaciones:</strong>
                            <p class="mb-0 bg-light p-3 rounded">{{ $certificadosMedico->observaciones }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Información Adicional -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Información Adicional</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <strong class="text-muted">Registrado el:</strong>
                            <p class="mb-0">{{ $certificadosMedico->created_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                        <div class="col-md-4">
                            <strong class="text-muted">Última actualización:</strong>
                            <p class="mb-0">{{ $certificadosMedico->updated_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                        <div class="col-md-4">
                            <strong class="text-muted">Notificación enviada:</strong>
                            <p class="mb-0">
                                @if($certificadosMedico->notificacion_enviada)
                                    <span class="badge bg-success">Sí</span>
                                @else
                                    <span class="badge bg-secondary">No</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Acciones -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="d-flex justify-content-between">
                <a href="{{ route('certificados-medicos.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Volver al Listado
                </a>
                <div class="d-flex gap-2">
                    @if($certificadosMedico->archivo_certificado)
                        <a href="{{ route('certificados-medicos.descargar', $certificadosMedico) }}"
                           class="btn btn-info">
                            <i class="fas fa-download me-1"></i>Descargar Archivo
                        </a>
                    @endif
                    <a href="{{ route('certificados-medicos.edit', $certificadosMedico) }}"
                       class="btn btn-warning">
                        <i class="fas fa-edit me-1"></i>Editar
                    </a>
                    <form method="POST" action="{{ route('certificados-medicos.destroy', $certificadosMedico) }}"
                          class="d-inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger"
                                onclick="return confirm('¿Está seguro de eliminar este certificado médico?')">
                            <i class="fas fa-trash me-1"></i>Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.border-4 {
    border-width: 4px !important;
}

.card-header {
    font-weight: 500;
}

.bg-light {
    background-color: #f8f9fa !important;
}
</style>
@endsection
