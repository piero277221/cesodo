@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="fas fa-file-medical text-danger me-2"></i>
            Nuevo Certificado Médico
        </h2>
        <a href="{{ route('certificados-medicos.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i>
            Volver
        </a>
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
            <!-- Paso 1: Buscar Persona por DNI -->
            <div id="buscar-persona-section">
                <h5 class="card-title mb-4">
                    <span class="badge bg-danger me-2">1</span>
                    Buscar Persona por DNI
                </h5>
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label">DNI <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" id="dni_buscar" class="form-control" 
                                   placeholder="Ingrese 8 dígitos" maxlength="8" 
                                   pattern="[0-9]{8}" required>
                            <button type="button" id="btn-buscar-persona" class="btn btn-primary">
                                <i class="fas fa-search me-1"></i>Buscar
                            </button>
                        </div>
                        <small class="text-muted">La persona debe estar registrada en el sistema</small>
                    </div>
                </div>

                <!-- Resultado de la búsqueda -->
                <div id="persona-encontrada" class="alert alert-success d-none">
                    <h6><i class="fas fa-user-check me-2"></i>Persona Encontrada:</h6>
                    <div class="row">
                        <div class="col-md-4">
                            <strong>Nombre Completo:</strong><br>
                            <span id="persona-nombre"></span>
                        </div>
                        <div class="col-md-3">
                            <strong>DNI:</strong><br>
                            <span id="persona-dni"></span>
                        </div>
                        <div class="col-md-3">
                            <strong>Celular:</strong><br>
                            <span id="persona-celular"></span>
                        </div>
                        <div class="col-md-2 text-end">
                            <button type="button" id="btn-cambiar-persona" class="btn btn-sm btn-warning">
                                <i class="fas fa-redo me-1"></i>Buscar otra persona
                            </button>
                        </div>
                    </div>
                </div>

                <div id="persona-no-encontrada" class="alert alert-danger d-none">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>No se encontró ninguna persona con ese DNI.</strong>
                    <br>
                    <small>Por favor, verifica el número o registra primero a la persona en el módulo de Personas.</small>
                </div>
            </div>

            <hr class="my-4">

            <!-- Paso 2: Formulario de Certificado -->
            <form id="form-certificado" method="POST" action="{{ route('certificados-medicos.store') }}" 
                  enctype="multipart/form-data" class="d-none">
                @csrf
                
                <input type="hidden" name="persona_id" id="persona_id" required>
                <input type="hidden" name="numero_documento" id="numero_documento" required>

                <h5 class="card-title mb-4">
                    <span class="badge bg-danger me-2">2</span>
                    Datos del Certificado Médico
                </h5>

                <div class="row g-3">
                    <!-- Archivo del Certificado -->
                    <div class="col-md-6">
                        <label for="archivo_certificado" class="form-label">
                            Archivo del Certificado <span class="text-danger">*</span>
                        </label>
                        <input type="file" 
                               class="form-control @error('archivo_certificado') is-invalid @enderror" 
                               id="archivo_certificado" 
                               name="archivo_certificado" 
                               accept=".pdf,.jpg,.jpeg,.png"
                               required>
                        <small class="text-muted">Formatos: PDF, JPG, PNG (máx. 5MB)</small>
                        @error('archivo_certificado')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        
                        <!-- Vista previa -->
                        <div id="archivo-preview" class="mt-2 d-none">
                            <div class="alert alert-info">
                                <i class="fas fa-file me-2"></i>
                                <span id="archivo-nombre"></span>
                                <span id="archivo-tamano" class="ms-2 text-muted"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Fecha de Emisión -->
                    <div class="col-md-3">
                        <label for="fecha_emision" class="form-label">
                            Fecha de Emisión <span class="text-danger">*</span>
                        </label>
                        <input type="date" 
                               class="form-control @error('fecha_emision') is-invalid @enderror" 
                               id="fecha_emision" 
                               name="fecha_emision" 
                               value="{{ old('fecha_emision') }}"
                               max="{{ date('Y-m-d') }}"
                               required>
                        @error('fecha_emision')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Fecha de Expiración -->
                    <div class="col-md-3">
                        <label for="fecha_expiracion" class="form-label">
                            Fecha de Expiración <span class="text-danger">*</span>
                        </label>
                        <input type="date" 
                               class="form-control @error('fecha_expiracion') is-invalid @enderror" 
                               id="fecha_expiracion" 
                               name="fecha_expiracion" 
                               value="{{ old('fecha_expiracion') }}"
                               min="{{ date('Y-m-d', strtotime('+1 day')) }}"
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
                                  placeholder="Observaciones adicionales sobre el certificado médico">{{ old('observaciones') }}</textarea>
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
                        <i class="fas fa-save me-1"></i>Guardar Certificado
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dniBuscar = document.getElementById('dni_buscar');
    const btnBuscarPersona = document.getElementById('btn-buscar-persona');
    const personaEncontrada = document.getElementById('persona-encontrada');
    const personaNoEncontrada = document.getElementById('persona-no-encontrada');
    const formCertificado = document.getElementById('form-certificado');
    const btnCambiarPersona = document.getElementById('btn-cambiar-persona');
    const archivoInput = document.getElementById('archivo_certificado');

    // Buscar persona por DNI
    btnBuscarPersona.addEventListener('click', function() {
        const dni = dniBuscar.value.trim();
        
        if (dni.length !== 8 || !/^\d+$/.test(dni)) {
            alert('Por favor, ingrese un DNI válido de 8 dígitos');
            return;
        }

        btnBuscarPersona.disabled = true;
        btnBuscarPersona.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Buscando...';

        fetch('{{ route("certificados-medicos.buscar-persona") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ dni: dni })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Mostrar información de la persona
                document.getElementById('persona-nombre').textContent = data.persona.nombre_completo;
                document.getElementById('persona-dni').textContent = data.persona.numero_documento;
                document.getElementById('persona-celular').textContent = data.persona.celular || 'No registrado';
                
                // Llenar campos ocultos
                document.getElementById('persona_id').value = data.persona.id;
                document.getElementById('numero_documento').value = data.persona.numero_documento;
                
                // Mostrar resultado exitoso y formulario
                personaEncontrada.classList.remove('d-none');
                personaNoEncontrada.classList.add('d-none');
                formCertificado.classList.remove('d-none');
                dniBuscar.disabled = true;
            } else {
                // Mostrar error
                personaNoEncontrada.classList.remove('d-none');
                personaEncontrada.classList.add('d-none');
                formCertificado.classList.add('d-none');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al buscar la persona. Por favor, intente nuevamente.');
        })
        .finally(() => {
            btnBuscarPersona.disabled = false;
            btnBuscarPersona.innerHTML = '<i class="fas fa-search me-1"></i>Buscar';
        });
    });

    // Cambiar persona
    btnCambiarPersona.addEventListener('click', function() {
        dniBuscar.value = '';
        dniBuscar.disabled = false;
        personaEncontrada.classList.add('d-none');
        personaNoEncontrada.classList.add('d-none');
        formCertificado.classList.add('d-none');
        dniBuscar.focus();
    });

    // Buscar con Enter
    dniBuscar.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            btnBuscarPersona.click();
        }
    });

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
    const fechaEmision = document.getElementById('fecha_emision');
    const fechaExpiracion = document.getElementById('fecha_expiracion');

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

<style>
#dni_buscar:focus {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}

.alert-success {
    border-left: 4px solid #28a745;
}

.alert-danger {
    border-left: 4px solid #dc3545;
}

.badge {
    font-size: 1rem;
    padding: 0.5rem 0.75rem;
}
</style>
@endsection
