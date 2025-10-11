@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="fas fa-file-medical text-danger me-2"></i>
            Editar Certificado Médico
        </h2>
        <div class="d-flex gap-2">
            <a href="{{ route('certificados-medicos.show', $certificadosMedico) }}" class="btn btn-outline-primary">
                <i class="fas fa-eye me-1"></i>Ver
            </a>
            <a href="{{ route('certificados-medicos.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>Volver
            </a>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error:</strong>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <!-- Información de la Persona (no editable) -->
            <div class="alert alert-info mb-4">
                <h6><i class="fas fa-user me-2"></i>Información de la Persona</h6>
                <div class="row">
                    <div class="col-md-4">
                        <strong>Nombre Completo:</strong><br>
                        {{ $certificadosMedico->persona->nombre_completo }}
                    </div>
                    <div class="col-md-2">
                        <strong>DNI:</strong><br>
                        {{ $certificadosMedico->numero_documento }}
                    </div>
                    <div class="col-md-3">
                        <strong>Celular:</strong><br>
                        {{ $certificadosMedico->persona->celular ?? 'No registrado' }}
                    </div>
                    <div class="col-md-3">
                        <strong>Correo:</strong><br>
                        {{ $certificadosMedico->persona->correo ?? 'No registrado' }}
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('certificados-medicos.update', $certificadosMedico) }}"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <!-- Archivo Actual -->
                    <div class="col-md-6">
                        <label class="form-label">Archivo Actual</label>
                        @if($certificadosMedico->archivo_certificado)
                            <div class="alert alert-success">
                                <i class="fas fa-file-pdf me-2"></i>
                                <strong>{{ basename($certificadosMedico->archivo_certificado) }}</strong>
                                <a href="{{ route('certificados-medicos.descargar', $certificadosMedico) }}"
                                   class="btn btn-sm btn-outline-primary ms-2">
                                    <i class="fas fa-download"></i> Descargar
                                </a>
                            </div>
                        @else
                            <p class="text-muted">Sin archivo adjunto</p>
                        @endif
                    </div>

                    <!-- Nuevo Archivo (opcional) -->
                    <div class="col-md-6">
                        <label for="archivo_certificado" class="form-label">
                            Nuevo Archivo (opcional)
                        </label>
                        <input type="file"
                               class="form-control @error('archivo_certificado') is-invalid @enderror"
                               id="archivo_certificado"
                               name="archivo_certificado"
                               accept=".pdf,.jpg,.jpeg,.png">
                        <small class="text-muted">Formatos: PDF, JPG, PNG (máx. 5MB)</small>
                        @error('archivo_certificado')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <!-- Vista previa -->
                        <div id="archivo-preview" class="mt-2 d-none">
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Nuevo archivo seleccionado:</strong><br>
                                <span id="archivo-nombre"></span>
                                <span id="archivo-tamano" class="ms-2 text-muted"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Fecha de Emisión -->
                    <div class="col-md-6">
                        <label for="fecha_emision" class="form-label">
                            Fecha de Emisión <span class="text-danger">*</span>
                        </label>
                        <input type="date"
                               class="form-control @error('fecha_emision') is-invalid @enderror"
                               id="fecha_emision"
                               name="fecha_emision"
                               value="{{ old('fecha_emision', $certificadosMedico->fecha_emision?->format('Y-m-d')) }}"
                               max="{{ date('Y-m-d') }}"
                               required>
                        @error('fecha_emision')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Fecha de Expiración -->
                    <div class="col-md-6">
                        <label for="fecha_expiracion" class="form-label">
                            Fecha de Expiración <span class="text-danger">*</span>
                        </label>
                        <input type="date"
                               class="form-control @error('fecha_expiracion') is-invalid @enderror"
                               id="fecha_expiracion"
                               name="fecha_expiracion"
                               value="{{ old('fecha_expiracion', $certificadosMedico->fecha_expiracion?->format('Y-m-d')) }}"
                               required>
                        @error('fecha_expiracion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Observaciones -->
                    <div class="col-12">
                        <label for="observaciones" class="form-label">Observaciones</label>
                        <textarea class="form-control @error('observaciones') is-invalid @enderror"
                                  id="observaciones"
                                  name="observaciones"
                                  rows="3"
                                  maxlength="1000"
                                  placeholder="Observaciones adicionales sobre el certificado médico">{{ old('observaciones', $certificadosMedico->observaciones) }}</textarea>
                        <small class="text-muted">Opcional - Máximo 1000 caracteres</small>
                        @error('observaciones')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('certificados-medicos.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-1"></i>Cancelar
                    </a>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-save me-1"></i>Actualizar Certificado
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const archivoInput = document.getElementById('archivo_certificado');
    const fechaEmision = document.getElementById('fecha_emision');
    const fechaExpiracion = document.getElementById('fecha_expiracion');

    // Vista previa del archivo
    archivoInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('archivo-preview');

        if (file) {
            const sizeInMB = (file.size / (1024 * 1024)).toFixed(2);
            document.getElementById('archivo-nombre').textContent = file.name;
            document.getElementById('archivo-tamano').textContent = `(${sizeInMB} MB)`;
            preview.classList.remove('d-none');
        } else {
            preview.classList.add('d-none');
        }
    });

    // Validación de fechas
    fechaEmision.addEventListener('change', function() {
        if (this.value) {
            const minExpiracion = new Date(this.value);
            minExpiracion.setDate(minExpiracion.getDate() + 1);
            fechaExpiracion.min = minExpiracion.toISOString().split('T')[0];
        }
    });
});
</script>
@endpush
@endsection
