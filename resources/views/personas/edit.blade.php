@extends('layouts.app')

@section('title', 'Editar Persona')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">
                    <i class="fas fa-user-edit text-warning me-2"></i>
                    Editar Persona
                </h2>
                <a href="{{ route('personas.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>
                    Volver
                </a>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <h6><i class="fas fa-exclamation-triangle me-1"></i> Errores de validación:</h6>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('personas.update', $persona->id) }}" method="POST" id="editPersonaForm">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Información Personal -->
                    <div class="col-lg-6 mb-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-user me-2"></i>
                                    Información Personal
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nombres" class="form-label">Nombres <span class="text-danger">*</span></label>
                                        <input type="text"
                                               class="form-control @error('nombres') is-invalid @enderror"
                                               id="nombres"
                                               name="nombres"
                                               value="{{ old('nombres', $persona->nombres) }}"
                                               required>
                                        @error('nombres')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="apellidos" class="form-label">Apellidos <span class="text-danger">*</span></label>
                                        <input type="text"
                                               class="form-control @error('apellidos') is-invalid @enderror"
                                               id="apellidos"
                                               name="apellidos"
                                               value="{{ old('apellidos', $persona->apellidos) }}"
                                               required>
                                        @error('apellidos')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                                        <input type="date"
                                               class="form-control @error('fecha_nacimiento') is-invalid @enderror"
                                               id="fecha_nacimiento"
                                               name="fecha_nacimiento"
                                               value="{{ old('fecha_nacimiento', $persona->fecha_nacimiento) }}">
                                        @error('fecha_nacimiento')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="sexo" class="form-label">Sexo</label>
                                        <select class="form-select @error('sexo') is-invalid @enderror"
                                                id="sexo"
                                                name="sexo">
                                            <option value="">Seleccionar</option>
                                            <option value="M" {{ old('sexo', $persona->sexo) == 'M' ? 'selected' : '' }}>Masculino</option>
                                            <option value="F" {{ old('sexo', $persona->sexo) == 'F' ? 'selected' : '' }}>Femenino</option>
                                            <option value="O" {{ old('sexo', $persona->sexo) == 'O' ? 'selected' : '' }}>Otro</option>
                                        </select>
                                        @error('sexo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nacionalidad" class="form-label">Nacionalidad</label>
                                        <input type="text"
                                               class="form-control @error('nacionalidad') is-invalid @enderror"
                                               id="nacionalidad"
                                               name="nacionalidad"
                                               value="{{ old('nacionalidad', $persona->nacionalidad ?? 'Peruana') }}">
                                        @error('nacionalidad')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="estado_civil" class="form-label">Estado Civil</label>
                                        <select class="form-select @error('estado_civil') is-invalid @enderror"
                                                id="estado_civil"
                                                name="estado_civil">
                                            <option value="">Seleccionar</option>
                                            <option value="Soltero(a)" {{ old('estado_civil', $persona->estado_civil) == 'Soltero(a)' ? 'selected' : '' }}>Soltero(a)</option>
                                            <option value="Casado(a)" {{ old('estado_civil', $persona->estado_civil) == 'Casado(a)' ? 'selected' : '' }}>Casado(a)</option>
                                            <option value="Divorciado(a)" {{ old('estado_civil', $persona->estado_civil) == 'Divorciado(a)' ? 'selected' : '' }}>Divorciado(a)</option>
                                            <option value="Viudo(a)" {{ old('estado_civil', $persona->estado_civil) == 'Viudo(a)' ? 'selected' : '' }}>Viudo(a)</option>
                                            <option value="Conviviente" {{ old('estado_civil', $persona->estado_civil) == 'Conviviente' ? 'selected' : '' }}>Conviviente</option>
                                        </select>
                                        @error('estado_civil')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="direccion" class="form-label">Dirección</label>
                                    <textarea class="form-control @error('direccion') is-invalid @enderror"
                                              id="direccion"
                                              name="direccion"
                                              rows="2">{{ old('direccion', $persona->direccion) }}</textarea>
                                    @error('direccion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Información de Documentos -->
                    <div class="col-lg-6 mb-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-id-card me-2"></i>
                                    Documentos e Identificación
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="tipo_documento" class="form-label">Tipo de Documento <span class="text-danger">*</span></label>
                                        <select class="form-select @error('tipo_documento') is-invalid @enderror"
                                                id="tipo_documento"
                                                name="tipo_documento"
                                                required>
                                            <option value="">Seleccionar tipo</option>
                                            <option value="dni" {{ old('tipo_documento', strtolower($persona->tipo_documento)) == 'dni' ? 'selected' : '' }}>DNI</option>
                                            <option value="ce" {{ old('tipo_documento', strtolower($persona->tipo_documento)) == 'ce' ? 'selected' : '' }}>Carnet de Extranjería</option>
                                            <option value="pasaporte" {{ old('tipo_documento', strtolower($persona->tipo_documento)) == 'pasaporte' ? 'selected' : '' }}>Pasaporte</option>
                                            <option value="ruc" {{ old('tipo_documento', strtolower($persona->tipo_documento)) == 'ruc' ? 'selected' : '' }}>RUC</option>
                                            <option value="otros" {{ old('tipo_documento', strtolower($persona->tipo_documento)) == 'otros' ? 'selected' : '' }}>Otros</option>
                                        </select>
                                        @error('tipo_documento')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="numero_documento" class="form-label">Número de Documento <span class="text-danger">*</span></label>
                                        <input type="text"
                                               class="form-control @error('numero_documento') is-invalid @enderror"
                                               id="numero_documento"
                                               name="numero_documento"
                                               value="{{ old('numero_documento', $persona->numero_documento) }}"
                                               required>
                                        @error('numero_documento')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Información:</strong>
                                    <ul class="mb-0 mt-2">
                                        <li><strong>DNI:</strong> 8 dígitos para peruanos</li>
                                        <li><strong>CE:</strong> Carnet de extranjería</li>
                                        <li><strong>Pasaporte:</strong> Documento internacional</li>
                                        <li><strong>RUC:</strong> 11 dígitos para empresas</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Información de Contacto -->
                    <div class="col-lg-12 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-phone me-2"></i>
                                    Información de Contacto
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="celular" class="form-label">Teléfono/Celular</label>
                                        <input type="tel"
                                               class="form-control @error('celular') is-invalid @enderror"
                                               id="celular"
                                               name="celular"
                                               value="{{ old('celular', $persona->celular) }}">
                                        @error('celular')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="correo" class="form-label">Correo Electrónico</label>
                                        <input type="email"
                                               class="form-control @error('correo') is-invalid @enderror"
                                               id="correo"
                                               name="correo"
                                               value="{{ old('correo', $persona->correo) }}">
                                        @error('correo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('personas.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times me-1"></i>
                                        Cancelar
                                    </a>
                                    <button type="reset" class="btn btn-outline-warning">
                                        <i class="fas fa-undo me-1"></i>
                                        Restablecer
                                    </button>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save me-1"></i>
                                        Actualizar Persona
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validación de DNI
    const tipoDocumento = document.getElementById('tipo_documento');
    const numeroDocumento = document.getElementById('numero_documento');

    function validarDocumento() {
        const tipo = tipoDocumento.value;
        numeroDocumento.removeAttribute('maxlength');
        numeroDocumento.removeAttribute('pattern');

        switch(tipo) {
            case 'dni':
                numeroDocumento.setAttribute('maxlength', '8');
                numeroDocumento.setAttribute('pattern', '[0-9]{8}');
                numeroDocumento.setAttribute('placeholder', '12345678');
                break;
            case 'ruc':
                numeroDocumento.setAttribute('maxlength', '11');
                numeroDocumento.setAttribute('pattern', '[0-9]{11}');
                numeroDocumento.setAttribute('placeholder', '12345678901');
                break;
            case 'ce':
                numeroDocumento.setAttribute('maxlength', '12');
                numeroDocumento.setAttribute('placeholder', '001234567');
                break;
            case 'pasaporte':
                numeroDocumento.setAttribute('maxlength', '15');
                numeroDocumento.setAttribute('placeholder', 'ABC123456');
                break;
            default:
                numeroDocumento.setAttribute('placeholder', 'Número de documento');
        }
    }

    tipoDocumento.addEventListener('change', validarDocumento);

    // Validación de solo números para DNI y RUC
    numeroDocumento.addEventListener('input', function() {
        const tipo = tipoDocumento.value;
        if (tipo === 'dni' || tipo === 'ruc') {
            this.value = this.value.replace(/\D/g, '');
        }
    });

    // Validación de teléfono
    const celularInput = document.getElementById('celular');
    celularInput.addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '').slice(0, 9);
    });

    // Confirmación antes de enviar
    document.getElementById('editPersonaForm').addEventListener('submit', function(e) {
        if (!confirm('¿Está seguro de actualizar los datos de esta persona?')) {
            e.preventDefault();
        }
    });

    // Ejecutar validación inicial para mostrar placeholder correcto
    validarDocumento();
});
</script>
@endpush
@endsection
