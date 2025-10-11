@extends('layouts.app')

@section('title', 'Crear Nuevo Contrato')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2 text-primary">
            <i class="fas fa-file-contract me-2"></i>Crear Nuevo Contrato
        </h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('contratos.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>Volver a Contratos
            </a>
        </div>
    </div>

    <!-- Formulario -->
    <div class="row">
        <div class="col-lg-8 col-xl-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-plus-circle me-2"></i>Información del Contrato
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('contratos.store') }}" method="POST" enctype="multipart/form-data" id="contratoForm">
                        @csrf

                        <!-- Información Básica -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-muted border-bottom pb-2 mb-3">
                                    <i class="fas fa-info-circle me-1"></i>Información Básica
                                </h6>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="persona_id" class="form-label">
                                    <i class="fas fa-user me-1"></i>Persona/Empleado <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('persona_id') is-invalid @enderror" id="persona_id" name="persona_id" required>
                                    <option value="">Seleccione una persona...</option>
                                    @foreach($personas as $persona)
                                        <option value="{{ $persona->id }}" {{ old('persona_id') == $persona->id ? 'selected' : '' }}>
                                            {{ $persona->nombres }} {{ $persona->apellidos }} - {{ $persona->numero_documento }}
                                            @if($persona->trabajador)
                                                (Empleado: {{ $persona->trabajador->cargo ?? 'Sin cargo' }})
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('persona_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="tipo_contrato" class="form-label">
                                    <i class="fas fa-file-alt me-1"></i>Tipo de Contrato <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('tipo_contrato') is-invalid @enderror" id="tipo_contrato" name="tipo_contrato" required>
                                    <option value="">Seleccione un tipo...</option>
                                    <option value="temporal" {{ old('tipo_contrato') == 'temporal' ? 'selected' : '' }}>Temporal</option>
                                    <option value="obra_labor" {{ old('tipo_contrato') == 'obra_labor' ? 'selected' : '' }}>Obra o Labor</option>
                                    <option value="aprendizaje" {{ old('tipo_contrato') == 'aprendizaje' ? 'selected' : '' }}>Aprendizaje</option>
                                    <option value="prestacion_servicios" {{ old('tipo_contrato') == 'prestacion_servicios' ? 'selected' : '' }}>Prestación de Servicios</option>
                                </select>
                                @error('tipo_contrato')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="numero_contrato" class="form-label">
                                    <i class="fas fa-hashtag me-1"></i>Número de Contrato
                                    <small class="badge bg-info">AUTO</small>
                                </label>
                                <input type="text" class="form-control bg-light @error('numero_contrato') is-invalid @enderror"
                                       id="numero_contrato" name="numero_contrato" value="{{ old('numero_contrato') }}"
                                       placeholder="Se generará automáticamente" readonly>
                                @error('numero_contrato')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle"></i> Se asignará automáticamente al guardar
                                </small>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="fecha_inicio" class="form-label">
                                    <i class="fas fa-calendar-plus me-1"></i>Fecha de Inicio <span class="text-danger">*</span>
                                </label>
                                <input type="date" class="form-control @error('fecha_inicio') is-invalid @enderror"
                                       id="fecha_inicio" name="fecha_inicio" value="{{ old('fecha_inicio') }}" required>
                                @error('fecha_inicio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="fecha_fin" class="form-label">
                                    <i class="fas fa-calendar-minus me-1"></i>Fecha de Fin
                                </label>
                                <input type="date" class="form-control @error('fecha_fin') is-invalid @enderror"
                                       id="fecha_fin" name="fecha_fin" value="{{ old('fecha_fin') }}">
                                @error('fecha_fin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Dejar vacío para contratos indefinidos</small>
                            </div>
                        </div>

                        <!-- Información Económica -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-muted border-bottom pb-2 mb-3">
                                    <i class="fas fa-dollar-sign me-1"></i>Información Económica
                                </h6>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="salario" class="form-label">
                                    <i class="fas fa-money-bill me-1"></i>Salario <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">S/</span>
                                    <input type="number" class="form-control @error('salario') is-invalid @enderror"
                                           id="salario" name="salario" value="{{ old('salario') }}"
                                           step="0.01" min="0" required>
                                </div>
                                @error('salario')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Detalles del Trabajo -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-muted border-bottom pb-2 mb-3">
                                    <i class="fas fa-briefcase me-1"></i>Detalles del Trabajo
                                </h6>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="cargo" class="form-label">
                                    <i class="fas fa-user-tie me-1"></i>Cargo <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('cargo') is-invalid @enderror"
                                        id="cargo" name="cargo" required>
                                    <option value="">Seleccionar cargo...</option>
                                    @foreach($cargos as $cargo)
                                        <option value="{{ $cargo }}" {{ old('cargo') == $cargo ? 'selected' : '' }}>
                                            {{ $cargo }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('cargo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="departamento" class="form-label">
                                    <i class="fas fa-building me-1"></i>Departamento
                                </label>
                                <select class="form-select @error('departamento') is-invalid @enderror"
                                        id="departamento" name="departamento">
                                    <option value="">Seleccionar área...</option>
                                    @foreach($areas as $area)
                                        <option value="{{ $area }}" {{ old('departamento') == $area ? 'selected' : '' }}>
                                            {{ $area }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('departamento')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="jornada_laboral" class="form-label">
                                    <i class="fas fa-clock me-1"></i>Jornada Laboral <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('jornada_laboral') is-invalid @enderror" id="jornada_laboral" name="jornada_laboral" required>
                                    <option value="">Seleccione una jornada...</option>
                                    <option value="completa" {{ old('jornada_laboral') == 'completa' ? 'selected' : '' }}>Tiempo Completo</option>
                                    <option value="parcial" {{ old('jornada_laboral') == 'parcial' ? 'selected' : '' }}>Tiempo Parcial</option>
                                    <option value="flexible" {{ old('jornada_laboral') == 'flexible' ? 'selected' : '' }}>Horario Flexible</option>
                                </select>
                                @error('jornada_laboral')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="lugar_trabajo" class="form-label">
                                    <i class="fas fa-map-marker-alt me-1"></i>Lugar de Trabajo
                                </label>
                                <input type="text" class="form-control @error('lugar_trabajo') is-invalid @enderror"
                                       id="lugar_trabajo_display" 
                                       placeholder="Seleccione departamento, provincia y distrito"
                                       readonly>
                                <input type="hidden" id="lugar_trabajo" name="lugar_trabajo" value="{{ old('lugar_trabajo') }}">
                                @error('lugar_trabajo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="mt-2">
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#ubicacionModal">
                                        <i class="fas fa-map-marked-alt me-1"></i>Seleccionar Ubicación
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Términos y Condiciones -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-muted border-bottom pb-2 mb-3">
                                    <i class="fas fa-file-contract me-1"></i>Términos y Condiciones
                                </h6>
                            </div>

                            <div class="col-12 mb-3">
                                <label for="clausulas_especiales" class="form-label">
                                    <i class="fas fa-list-alt me-1"></i>Cláusulas Especiales
                                </label>
                                <textarea class="form-control @error('clausulas_especiales') is-invalid @enderror"
                                          id="clausulas_especiales" name="clausulas_especiales" rows="4"
                                          placeholder="Escriba las cláusulas especiales del contrato...">{{ old('clausulas_especiales') }}</textarea>
                                @error('clausulas_especiales')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label for="observaciones" class="form-label">
                                    <i class="fas fa-sticky-note me-1"></i>Observaciones
                                </label>
                                <textarea class="form-control @error('observaciones') is-invalid @enderror"
                                          id="observaciones" name="observaciones" rows="3"
                                          placeholder="Observaciones adicionales...">{{ old('observaciones') }}</textarea>
                                @error('observaciones')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Archivos -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-muted border-bottom pb-2 mb-3">
                                    <i class="fas fa-paperclip me-1"></i>Archivos Adjuntos
                                </h6>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="archivo_contrato" class="form-label">
                                    <i class="fas fa-file-pdf me-1"></i>Archivo del Contrato
                                </label>
                                <input type="file" class="form-control @error('archivo_contrato') is-invalid @enderror"
                                       id="archivo_contrato" name="archivo_contrato" accept=".pdf,.doc,.docx">
                                @error('archivo_contrato')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Formatos permitidos: PDF, DOC, DOCX (Máximo 5MB)</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="documentos_adjuntos" class="form-label">
                                    <i class="fas fa-files me-1"></i>Documentos Adicionales
                                </label>
                                <input type="file" class="form-control @error('documentos_adjuntos') is-invalid @enderror"
                                       id="documentos_adjuntos" name="documentos_adjuntos[]" multiple
                                       accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                @error('documentos_adjuntos')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Múltiples archivos permitidos</small>
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-end gap-2">
                                    <button type="button" class="btn btn-outline-secondary" onclick="window.history.back()">
                                        <i class="fas fa-times me-1"></i>Cancelar
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i>Crear Contrato
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Panel de Información -->
        <div class="col-lg-4 col-xl-2">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-info-circle me-1"></i>Información
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-muted">Datos Automáticos</h6>
                        <p class="small mb-2">
                            <i class="fas fa-magic text-primary me-1"></i>
                            Los datos de la persona se completarán automáticamente al seleccionarla.
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6 class="text-muted">Estados del Contrato</h6>
                        <div class="small">
                            <div class="mb-1">
                                <span class="badge bg-warning">Borrador</span> - Inicial
                            </div>
                            <div class="mb-1">
                                <span class="badge bg-info">Enviado</span> - En revisión
                            </div>
                            <div class="mb-1">
                                <span class="badge bg-success">Activo</span> - Vigente
                            </div>
                            <div class="mb-1">
                                <span class="badge bg-secondary">Finalizado</span> - Terminado
                            </div>
                        </div>
                    </div>

                    <div>
                        <h6 class="text-muted">Recordatorio</h6>
                        <p class="small text-muted">
                            <i class="fas fa-lightbulb text-warning me-1"></i>
                            Asegúrese de revisar todos los datos antes de crear el contrato.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-completar datos de persona
    const personaSelect = document.getElementById('persona_id');
    const cargoSelect = document.getElementById('cargo');
    const departamentoSelect = document.getElementById('departamento');

    personaSelect.addEventListener('change', function() {
        if (this.value) {
            // Hacer petición AJAX para obtener datos de la persona
            fetch(`{{ route('contratos.persona-data') }}?persona_id=${this.value}`)
                .then(response => response.json())
                .then(data => {
                    if (data.trabajador) {
                        // Seleccionar el cargo si existe en la lista
                        if (data.trabajador.cargo) {
                            cargoSelect.value = data.trabajador.cargo;
                        }
                        // Seleccionar el área si existe en la lista
                        if (data.trabajador.area) {
                            departamentoSelect.value = data.trabajador.area;
                        }
                    }
                })
                .catch(error => console.error('Error:', error));
        } else {
            // Limpiar selecciones cuando no hay persona seleccionada
            cargoSelect.value = '';
            departamentoSelect.value = '';
        }
    });

    // Validación de fechas
    const fechaInicioInput = document.getElementById('fecha_inicio');
    const fechaFinInput = document.getElementById('fecha_fin');

    fechaInicioInput.addEventListener('change', function() {
        fechaFinInput.min = this.value;
    });

    fechaFinInput.addEventListener('change', function() {
        if (this.value && fechaInicioInput.value && this.value <= fechaInicioInput.value) {
            alert('La fecha de fin debe ser posterior a la fecha de inicio.');
            this.value = '';
        }
    });

    // Habilitar/deshabilitar fecha fin según tipo de contrato
    const tipoContratoSelect = document.getElementById('tipo_contrato');

    tipoContratoSelect.addEventListener('change', function() {
        if (this.value === 'indefinido') {
            fechaFinInput.disabled = true;
            fechaFinInput.value = '';
            fechaFinInput.required = false;
        } else {
            fechaFinInput.disabled = false;
            fechaFinInput.required = this.value === 'temporal' || this.value === 'obra_labor';
        }
    });

    // Validación de archivos
    const archivoInput = document.getElementById('archivo_contrato');
    const documentosInput = document.getElementById('documentos_adjuntos');

    function validarArchivo(input, maxSize = 5) {
        const files = input.files;
        const maxSizeBytes = maxSize * 1024 * 1024; // Convertir MB a bytes

        for (let file of files) {
            if (file.size > maxSizeBytes) {
                alert(`El archivo ${file.name} excede el tamaño máximo de ${maxSize}MB.`);
                input.value = '';
                return false;
            }
        }
        return true;
    }

    archivoInput.addEventListener('change', function() {
        validarArchivo(this);
    });

    documentosInput.addEventListener('change', function() {
        validarArchivo(this);
    });
});
</script>

<!-- Modal de Selección de Ubicación -->
<div class="modal fade" id="ubicacionModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-map-marked-alt me-2"></i>Seleccionar Ubicación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Departamento</label>
                        <select class="form-select" id="departamento_select">
                            <option value="">Seleccione...</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Provincia</label>
                        <select class="form-select" id="provincia_select" disabled>
                            <option value="">Seleccione departamento primero</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Distrito</label>
                        <select class="form-select" id="distrito_select" disabled>
                            <option value="">Seleccione provincia primero</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="confirmarUbicacion">Confirmar</button>
            </div>
        </div>
    </div>
</div>

<script>
// Datos de ubicaciones del Perú (simplificado - principales departamentos)
const ubicacionesPeru = {
    "Amazonas": {
        "Chachapoyas": ["Chachapoyas", "Asunción", "Balsas", "Cheto", "Chiliquín"],
        "Bagua": ["Bagua", "Aramango", "Copallin", "El Parco", "Imaza"]
    },
    "Áncash": {
        "Huaraz": ["Huaraz", "Cochabamba", "Colcabamba", "Huanchay", "Independencia"],
        "Casma": ["Casma", "Buena Vista Alta", "Comandante Noel", "Yautan"]
    },
    "Apurímac": {
        "Abancay": ["Abancay", "Chacoche", "Circa", "Curahuasi", "Huanipaca"],
        "Andahuaylas": ["Andahuaylas", "Andarapa", "Chiara", "Huancarama"]
    },
    "Arequipa": {
        "Arequipa": ["Arequipa", "Alto Selva Alegre", "Cayma", "Cerro Colorado", "Characato", "Miraflores", "Paucarpata", "Sachaca", "Yanahuara"],
        "Camaná": ["Camaná", "José María Quimper", "Mariano Nicolás Valcárcel", "Mariscal Cáceres"]
    },
    "Ayacucho": {
        "Huamanga": ["Ayacucho", "Acocro", "Acos Vinchos", "Carmen Alto", "Chiara"],
        "Huanta": ["Huanta", "Ayahuanco", "Huamanguilla", "Iguain", "Luricocha"]
    },
    "Cajamarca": {
        "Cajamarca": ["Cajamarca", "Asunción", "Chetilla", "Cospan", "Encañada", "Jesús", "Los Baños del Inca"],
        "Jaén": ["Jaén", "Bellavista", "Chontali", "Colasay", "Huabal"]
    },
    "Callao": {
        "Callao": ["Callao", "Bellavista", "Carmen de la Legua Reynoso", "La Perla", "La Punta", "Ventanilla"]
    },
    "Cusco": {
        "Cusco": ["Cusco", "Ccorca", "Poroy", "San Jerónimo", "San Sebastián", "Santiago", "Saylla", "Wanchaq"],
        "Urubamba": ["Urubamba", "Chinchero", "Huayllabamba", "Machupicchu", "Maras", "Ollantaytambo"]
    },
    "Huancavelica": {
        "Huancavelica": ["Huancavelica", "Acobambilla", "Acoria", "Conayca", "Cuenca"],
        "Tayacaja": ["Pampas", "Acostambo", "Acraquia", "Ahuaycha"]
    },
    "Huánuco": {
        "Huánuco": ["Huánuco", "Amarilis", "Chinchao", "Churubamba", "Margos", "Pillco Marca"],
        "Leoncio Prado": ["Rupa Rupa", "Daniel Alomía Robles", "Hermilio Valdizán", "José Crespo y Castillo"]
    },
    "Ica": {
        "Ica": ["Ica", "La Tinguiña", "Los Aquijes", "Ocucaje", "Pachacutec", "Parcona", "Pueblo Nuevo"],
        "Chincha": ["Chincha Alta", "Alto Larán", "Chavín", "Chincha Baja", "El Carmen"]
    },
    "Junín": {
        "Huancayo": ["Huancayo", "Carhuacallanga", "Chacapampa", "Chicche", "Chilca", "El Tambo", "Hualhuas"],
        "Tarma": ["Tarma", "Acobamba", "Huaricolca", "Huasahuasi", "La Unión"]
    },
    "La Libertad": {
        "Trujillo": ["Trujillo", "El Porvenir", "Florencia de Mora", "Huanchaco", "La Esperanza", "Laredo", "Moche", "Salaverry", "Víctor Larco Herrera"],
        "Ascope": ["Ascope", "Chicama", "Chocope", "Magdalena de Cao", "Paiján"]
    },
    "Lambayeque": {
        "Chiclayo": ["Chiclayo", "Cayaltí", "Chongoyape", "Eten", "José Leonardo Ortiz", "La Victoria", "Lagunas", "Monsefú", "Pátapo", "Picsi", "Pimentel", "Pomalca", "Pucalá", "Reque", "Santa Rosa"],
        "Lambayeque": ["Lambayeque", "Chóchope", "Illimo", "Jayanca", "Mórrope", "Motupe"]
    },
    "Lima": {
        "Lima": ["Lima", "Ancón", "Ate", "Barranco", "Breña", "Carabayllo", "Chaclacayo", "Chorrillos", "Cieneguilla", "Comas", "El Agustino", "Independencia", "Jesús María", "La Molina", "La Victoria", "Lince", "Los Olivos", "Lurigancho", "Lurín", "Magdalena del Mar", "Miraflores", "Pachacámac", "Pucusana", "Pueblo Libre", "Puente Piedra", "Punta Hermosa", "Punta Negra", "Rímac", "San Bartolo", "San Borja", "San Isidro", "San Juan de Lurigancho", "San Juan de Miraflores", "San Luis", "San Martín de Porres", "San Miguel", "Santa Anita", "Santa María del Mar", "Santa Rosa", "Santiago de Surco", "Surquillo", "Villa El Salvador", "Villa María del Triunfo"],
        "Huaral": ["Huaral", "Atavillos Alto", "Atavillos Bajo", "Aucallama", "Chancay", "Ihuarí"]
    },
    "Loreto": {
        "Maynas": ["Iquitos", "Alto Nanay", "Fernando Lores", "Indiana", "Las Amazonas", "Mazan", "Napo", "Punchana", "Torres Causana"],
        "Requena": ["Requena", "Alto Tapiche", "Capelo", "Emilio San Martín", "Maquia"]
    },
    "Madre de Dios": {
        "Tambopata": ["Tambopata", "Inambari", "Las Piedras", "Laberinto"],
        "Manu": ["Manu", "Fitzcarrald", "Madre de Dios", "Huepetuhe"]
    },
    "Moquegua": {
        "Mariscal Nieto": ["Moquegua", "Carumas", "Cuchumbaya", "Samegua", "San Cristóbal", "Torata"],
        "Ilo": ["Ilo", "El Algarrobal", "Pacocha"]
    },
    "Pasco": {
        "Pasco": ["Chaupimarca", "Huachón", "Huariaca", "Huayllay", "Ninacaca"],
        "Daniel Alcides Carrión": ["Yanahuanca", "Chacayán", "Goyllarisquizga", "Paucar"]
    },
    "Piura": {
        "Piura": ["Piura", "Castilla", "Catacaos", "Cura Mori", "El Tallán", "La Arena", "La Unión", "Las Lomas", "Tambo Grande"],
        "Sullana": ["Sullana", "Bellavista", "Ignacio Escudero", "Lancones", "Marcavelica", "Miguel Checa"]
    },
    "Puno": {
        "Puno": ["Puno", "Acora", "Amantaní", "Atuncolla", "Capachica", "Chucuito", "Coata", "Huata", "Mañazo", "Paucarcolla", "Pichacani", "Platería", "San Antonio", "Tiquillaca", "Vilque"],
        "Juliaca": ["Juliaca"]
    },
    "San Martín": {
        "Moyobamba": ["Moyobamba", "Calzada", "Habana", "Jepelacio", "Soritor", "Yantalo"],
        "Rioja": ["Rioja", "Awajún", "Elías Soplin Vargas", "Nueva Cajamarca", "Pardo Miguel"]
    },
    "Tacna": {
        "Tacna": ["Tacna", "Alto de la Alianza", "Calana", "Ciudad Nueva", "Inclán", "Pachia", "Palca", "Pocollay"],
        "Tarata": ["Tarata", "Estique", "Estique Pampa", "Sitajara", "Susapaya", "Tarucachi"]
    },
    "Tumbes": {
        "Tumbes": ["Tumbes", "Corrales", "La Cruz", "Pampas de Hospital", "San Jacinto", "San Juan de la Virgen"],
        "Zarumilla": ["Zarumilla", "Aguas Verdes", "Matapalo", "Papayal"]
    },
    "Ucayali": {
        "Coronel Portillo": ["Callería", "Campoverde", "Iparia", "Masisea", "Yarinacocha"],
        "Atalaya": ["Raymondi", "Sepahua", "Tahuania", "Yurua"]
    }
};

document.addEventListener('DOMContentLoaded', function() {
    const depSelect = document.getElementById('departamento_select');
    const provSelect = document.getElementById('provincia_select');
    const distSelect = document.getElementById('distrito_select');
    const confirmarBtn = document.getElementById('confirmarUbicacion');

    // Cargar departamentos
    Object.keys(ubicacionesPeru).sort().forEach(dep => {
        const option = document.createElement('option');
        option.value = dep;
        option.textContent = dep;
        depSelect.appendChild(option);
    });

    // Evento departamento
    depSelect.addEventListener('change', function() {
        provSelect.innerHTML = '<option value="">Seleccione...</option>';
        distSelect.innerHTML = '<option value="">Seleccione provincia primero</option>';
        distSelect.disabled = true;
        
        if (this.value) {
            provSelect.disabled = false;
            Object.keys(ubicacionesPeru[this.value]).sort().forEach(prov => {
                const option = document.createElement('option');
                option.value = prov;
                option.textContent = prov;
                provSelect.appendChild(option);
            });
        } else {
            provSelect.disabled = true;
        }
    });

    // Evento provincia
    provSelect.addEventListener('change', function() {
        distSelect.innerHTML = '<option value="">Seleccione...</option>';
        
        if (this.value && depSelect.value) {
            distSelect.disabled = false;
            ubicacionesPeru[depSelect.value][this.value].sort().forEach(dist => {
                const option = document.createElement('option');
                option.value = dist;
                option.textContent = dist;
                distSelect.appendChild(option);
            });
        } else {
            distSelect.disabled = true;
        }
    });

    // Confirmar selección
    confirmarBtn.addEventListener('click', function() {
        const dep = depSelect.value;
        const prov = provSelect.value;
        const dist = distSelect.value;

        if (!dep || !prov || !dist) {
            alert('Por favor seleccione departamento, provincia y distrito');
            return;
        }

        const ubicacion = `${dist}, ${prov}, ${dep}`;
        document.getElementById('lugar_trabajo').value = ubicacion;
        document.getElementById('lugar_trabajo_display').value = ubicacion;

        // Cerrar modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('ubicacionModal'));
        modal.hide();
    });
});
</script>
@endpush
@endsection
