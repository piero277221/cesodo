@extends('layouts.app')

@section('title', 'Editar Trabajador')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">
                    <i class="fas fa-user-edit text-warning me-2"></i>
                    Editar Trabajador
                </h2>
                <a href="{{ route('trabajadores.index') }}" class="btn btn-secondary">
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

            <form action="{{ route('trabajadores.update', $trabajador) }}" method="POST" id="editTrabajadorForm">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Información Personal -->
                    <div class="col-lg-6 mb-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-header bg-warning text-dark">
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
                                               value="{{ old('nombres', $trabajador->nombres) }}"
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
                                               value="{{ old('apellidos', $trabajador->apellidos) }}"
                                               required>
                                        @error('apellidos')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="dni" class="form-label">DNI <span class="text-danger">*</span></label>
                                        <input type="text"
                                               class="form-control @error('dni') is-invalid @enderror"
                                               id="dni"
                                               name="dni"
                                               value="{{ old('dni', $trabajador->dni) }}"
                                               maxlength="8"
                                               pattern="[0-9]{8}"
                                               required>
                                        @error('dni')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="codigo" class="form-label">Código de Empleado</label>
                                        <input type="text"
                                               class="form-control @error('codigo') is-invalid @enderror"
                                               id="codigo"
                                               name="codigo"
                                               value="{{ old('codigo', $trabajador->codigo) }}">
                                        @error('codigo')
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
                                               value="{{ old('fecha_nacimiento', $trabajador->fecha_nacimiento) }}">
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
                                            <option value="M" {{ old('sexo', $trabajador->sexo) == 'M' ? 'selected' : '' }}>Masculino</option>
                                            <option value="F" {{ old('sexo', $trabajador->sexo) == 'F' ? 'selected' : '' }}>Femenino</option>
                                        </select>
                                        @error('sexo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="direccion" class="form-label">Dirección</label>
                                    <textarea class="form-control @error('direccion') is-invalid @enderror"
                                              id="direccion"
                                              name="direccion"
                                              rows="2">{{ old('direccion', $trabajador->direccion) }}</textarea>
                                    @error('direccion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Información Laboral -->
                    <div class="col-lg-6 mb-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-briefcase me-2"></i>
                                    Información Laboral
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="area" class="form-label">Área <span class="text-danger">*</span></label>
                                        <select class="form-select @error('area') is-invalid @enderror"
                                                id="area"
                                                name="area"
                                                required>
                                            <option value="">Seleccionar área</option>
                                            <option value="Administración" {{ old('area', $trabajador->area) == 'Administración' ? 'selected' : '' }}>Administración</option>
                                            <option value="Recursos Humanos" {{ old('area', $trabajador->area) == 'Recursos Humanos' ? 'selected' : '' }}>Recursos Humanos</option>
                                            <option value="Finanzas" {{ old('area', $trabajador->area) == 'Finanzas' ? 'selected' : '' }}>Finanzas</option>
                                            <option value="Operaciones" {{ old('area', $trabajador->area) == 'Operaciones' ? 'selected' : '' }}>Operaciones</option>
                                            <option value="Ventas" {{ old('area', $trabajador->area) == 'Ventas' ? 'selected' : '' }}>Ventas</option>
                                            <option value="Marketing" {{ old('area', $trabajador->area) == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                                            <option value="Tecnología" {{ old('area', $trabajador->area) == 'Tecnología' ? 'selected' : '' }}>Tecnología</option>
                                            <option value="Logística" {{ old('area', $trabajador->area) == 'Logística' ? 'selected' : '' }}>Logística</option>
                                            <option value="Calidad" {{ old('area', $trabajador->area) == 'Calidad' ? 'selected' : '' }}>Calidad</option>
                                            <option value="Seguridad" {{ old('area', $trabajador->area) == 'Seguridad' ? 'selected' : '' }}>Seguridad</option>
                                        </select>
                                        @error('area')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="cargo" class="form-label">Cargo</label>
                                        <input type="text"
                                               class="form-control @error('cargo') is-invalid @enderror"
                                               id="cargo"
                                               name="cargo"
                                               value="{{ old('cargo', $trabajador->cargo) }}">
                                        @error('cargo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="fecha_ingreso" class="form-label">Fecha de Ingreso</label>
                                        <input type="date"
                                               class="form-control @error('fecha_ingreso') is-invalid @enderror"
                                               id="fecha_ingreso"
                                               name="fecha_ingreso"
                                               value="{{ old('fecha_ingreso', $trabajador->fecha_ingreso) }}">
                                        @error('fecha_ingreso')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="salario" class="form-label">Salario</label>
                                        <div class="input-group">
                                            <span class="input-group-text">S/</span>
                                            <input type="number"
                                                   class="form-control @error('salario') is-invalid @enderror"
                                                   id="salario"
                                                   name="salario"
                                                   value="{{ old('salario', $trabajador->salario) }}"
                                                   step="0.01"
                                                   min="0">
                                            @error('salario')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="estado" class="form-label">Estado</label>
                                        <select class="form-select @error('estado') is-invalid @enderror"
                                                id="estado"
                                                name="estado">
                                            <option value="Activo" {{ old('estado', $trabajador->estado) == 'Activo' ? 'selected' : '' }}>Activo</option>
                                            <option value="Inactivo" {{ old('estado', $trabajador->estado) == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                                            <option value="Suspendido" {{ old('estado', $trabajador->estado) == 'Suspendido' ? 'selected' : '' }}>Suspendido</option>
                                            <option value="Vacaciones" {{ old('estado', $trabajador->estado) == 'Vacaciones' ? 'selected' : '' }}>Vacaciones</option>
                                        </select>
                                        @error('estado')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="turno" class="form-label">Turno</label>
                                        <select class="form-select @error('turno') is-invalid @enderror"
                                                id="turno"
                                                name="turno">
                                            <option value="">Seleccionar turno</option>
                                            <option value="Mañana" {{ old('turno', $trabajador->turno) == 'Mañana' ? 'selected' : '' }}>Mañana</option>
                                            <option value="Tarde" {{ old('turno', $trabajador->turno) == 'Tarde' ? 'selected' : '' }}>Tarde</option>
                                            <option value="Noche" {{ old('turno', $trabajador->turno) == 'Noche' ? 'selected' : '' }}>Noche</option>
                                            <option value="Rotativo" {{ old('turno', $trabajador->turno) == 'Rotativo' ? 'selected' : '' }}>Rotativo</option>
                                        </select>
                                        @error('turno')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="observaciones" class="form-label">Observaciones</label>
                                    <textarea class="form-control @error('observaciones') is-invalid @enderror"
                                              id="observaciones"
                                              name="observaciones"
                                              rows="3">{{ old('observaciones', $trabajador->observaciones) }}</textarea>
                                    @error('observaciones')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                                    <div class="col-md-4 mb-3">
                                        <label for="telefono" class="form-label">Teléfono</label>
                                        <input type="tel"
                                               class="form-control @error('telefono') is-invalid @enderror"
                                               id="telefono"
                                               name="telefono"
                                               value="{{ old('telefono', $trabajador->telefono) }}">
                                        @error('telefono')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email"
                                               class="form-control @error('email') is-invalid @enderror"
                                               id="email"
                                               name="email"
                                               value="{{ old('email', $trabajador->email) }}">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="telefono_emergencia" class="form-label">Teléfono de Emergencia</label>
                                        <input type="tel"
                                               class="form-control @error('telefono_emergencia') is-invalid @enderror"
                                               id="telefono_emergencia"
                                               name="telefono_emergencia"
                                               value="{{ old('telefono_emergencia', $trabajador->telefono_emergencia) }}">
                                        @error('telefono_emergencia')
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
                                    <a href="{{ route('trabajadores.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times me-1"></i>
                                        Cancelar
                                    </a>
                                    <button type="reset" class="btn btn-outline-warning">
                                        <i class="fas fa-undo me-1"></i>
                                        Limpiar
                                    </button>
                                    <button type="submit" class="btn btn-warning">
                                        <i class="fas fa-save me-1"></i>
                                        Actualizar Trabajador
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

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-generar código de empleado basado en nombres
    const nombresInput = document.getElementById('nombres');
    const apellidosInput = document.getElementById('apellidos');
    const codigoInput = document.getElementById('codigo');

    function generarCodigo() {
        if (!codigoInput.value) {
            const nombres = nombresInput.value.trim();
            const apellidos = apellidosInput.value.trim();

            if (nombres && apellidos) {
                const inicialNombre = nombres.charAt(0).toUpperCase();
                const inicialApellido = apellidos.charAt(0).toUpperCase();
                const timestamp = Date.now().toString().slice(-4);

                codigoInput.value = inicialNombre + inicialApellido + timestamp;
            }
        }
    }

    nombresInput.addEventListener('blur', generarCodigo);
    apellidosInput.addEventListener('blur', generarCodigo);

    // Validación de DNI
    const dniInput = document.getElementById('dni');
    dniInput.addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '').slice(0, 8);
    });

    // Validación de teléfonos
    const telefonoInputs = document.querySelectorAll('input[type="tel"]');
    telefonoInputs.forEach(input => {
        input.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '').slice(0, 9);
        });
    });

    // Confirmación antes de enviar
    document.getElementById('editTrabajadorForm').addEventListener('submit', function(e) {
        if (!confirm('¿Está seguro de actualizar la información de este trabajador?')) {
            e.preventDefault();
        }
    });
});
</script>
@endsection
@endsection

                                        <div class="mb-3">
                                            <label for="nombres" class="form-label">
                                                Nombres <span class="text-danger">*</span>
                                            </label>
                                            <input type="text"
                                                   class="form-control @error('nombres') is-invalid @enderror"
                                                   id="nombres"
                                                   name="nombres"
                                                   value="{{ old('nombres', $trabajador->nombres) }}"
                                                   required>
                                            @error('nombres')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="apellidos" class="form-label">
                                                Apellidos <span class="text-danger">*</span>
                                            </label>
                                            <input type="text"
                                                   class="form-control @error('apellidos') is-invalid @enderror"
                                                   id="apellidos"
                                                   name="apellidos"
                                                   value="{{ old('apellidos', $trabajador->apellidos) }}"
                                                   required>
                                            @error('apellidos')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="dni" class="form-label">
                                                DNI <span class="text-danger">*</span>
                                            </label>
                                            <input type="text"
                                                   class="form-control @error('dni') is-invalid @enderror"
                                                   id="dni"
                                                   name="dni"
                                                   value="{{ old('dni', $trabajador->dni) }}"
                                                   maxlength="8"
                                                   pattern="[0-9]{8}"
                                                   required>
                                            @error('dni')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">Ingrese 8 dígitos</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Información Laboral -->
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-header bg-success text-white">
                                        <h5 class="mb-0"><i class="fas fa-briefcase me-2"></i>Información Laboral</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="area" class="form-label">
                                                Área <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select @error('area') is-invalid @enderror"
                                                    id="area"
                                                    name="area"
                                                    required>
                                                <option value="">Seleccionar área</option>
                                                <option value="Administración" {{ old('area', $trabajador->area) == 'Administración' ? 'selected' : '' }}>Administración</option>
                                                <option value="Almacén" {{ old('area', $trabajador->area) == 'Almacén' ? 'selected' : '' }}>Almacén</option>
                                                <option value="Ventas" {{ old('area', $trabajador->area) == 'Ventas' ? 'selected' : '' }}>Ventas</option>
                                                <option value="Logística" {{ old('area', $trabajador->area) == 'Logística' ? 'selected' : '' }}>Logística</option>
                                                <option value="Operaciones" {{ old('area', $trabajador->area) == 'Operaciones' ? 'selected' : '' }}>Operaciones</option>
                                                <option value="Sistemas" {{ old('area', $trabajador->area) == 'Sistemas' ? 'selected' : '' }}>Sistemas</option>
                                            </select>
                                            @error('area')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="cargo" class="form-label">
                                                Cargo <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select @error('cargo') is-invalid @enderror"
                                                    id="cargo"
                                                    name="cargo"
                                                    required>
                                                <option value="">Seleccionar cargo</option>
                                                <option value="Gerente" {{ old('cargo', $trabajador->cargo) == 'Gerente' ? 'selected' : '' }}>Gerente</option>
                                                <option value="Supervisor" {{ old('cargo', $trabajador->cargo) == 'Supervisor' ? 'selected' : '' }}>Supervisor</option>
                                                <option value="Jefe de Área" {{ old('cargo', $trabajador->cargo) == 'Jefe de Área' ? 'selected' : '' }}>Jefe de Área</option>
                                                <option value="Analista" {{ old('cargo', $trabajador->cargo) == 'Analista' ? 'selected' : '' }}>Analista</option>
                                                <option value="Auxiliar" {{ old('cargo', $trabajador->cargo) == 'Auxiliar' ? 'selected' : '' }}>Auxiliar</option>
                                                <option value="Almacenero" {{ old('cargo', $trabajador->cargo) == 'Almacenero' ? 'selected' : '' }}>Almacenero</option>
                                                <option value="Vendedor" {{ old('cargo', $trabajador->cargo) == 'Vendedor' ? 'selected' : '' }}>Vendedor</option>
                                                <option value="Operario" {{ old('cargo', $trabajador->cargo) == 'Operario' ? 'selected' : '' }}>Operario</option>
                                            </select>
                                            @error('cargo')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="estado" class="form-label">
                                                Estado <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select @error('estado') is-invalid @enderror"
                                                    id="estado"
                                                    name="estado"
                                                    required>
                                                <option value="">Seleccionar estado</option>
                                                <option value="activo" {{ old('estado', $trabajador->estado) == 'activo' ? 'selected' : '' }}>Activo</option>
                                                <option value="inactivo" {{ old('estado', $trabajador->estado) == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                                            </select>
                                            @error('estado')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="persona_id" class="form-label">
                                                Persona Asociada
                                            </label>
                                            <select class="form-select @error('persona_id') is-invalid @enderror"
                                                    id="persona_id"
                                                    name="persona_id">
                                                <option value="">Ninguna</option>
                                                @if(isset($personas))
                                                    @foreach($personas as $persona)
                                                        <option value="{{ $persona->id }}"
                                                                {{ old('persona_id', $trabajador->persona_id) == $persona->id ? 'selected' : '' }}>
                                                            {{ $persona->nombre }} {{ $persona->apellido }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('persona_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">Opcional: vincular con una persona existente</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('trabajadores.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times me-1"></i>Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i>Actualizar Trabajador
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Validación de DNI en tiempo real
        document.getElementById('dni').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            e.target.value = value;
        });

        // Validación de formulario
        document.querySelector('form').addEventListener('submit', function(e) {
            const dni = document.getElementById('dni').value;
            if (dni.length !== 8) {
                e.preventDefault();
                alert('El DNI debe tener exactamente 8 dígitos');
                document.getElementById('dni').focus();
                return;
            }
        });
    </script>
    @endpush
</x-app-layout>
