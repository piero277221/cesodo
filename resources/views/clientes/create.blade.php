@extends('layouts.app')

@section('title', 'Nuevo Cliente')

@section('content')
<div class="container-fluid">
    <!-- Header con diseño CESODO -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">
                <i class="fas fa-user-plus me-2" style="color: #dc2626;"></i>
                Nuevo Cliente
            </h1>
            <p class="text-muted mb-0">Agrega un nuevo cliente al sistema</p>
        </div>
        <a href="{{ route('clientes.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Volver
        </a>
    </div>

    <form action="{{ route('clientes.store') }}" method="POST">
        @csrf

        <div class="row">
            <!-- Información Básica -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header py-3" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);">
                        <h6 class="mb-0 text-white fw-bold">
                            <i class="fas fa-id-card me-2"></i>Información Básica
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold" for="tipo">
                                Tipo de Cliente <span class="text-danger">*</span>
                            </label>
                            <select name="tipo" id="tipo" class="form-select @error('tipo') is-invalid @enderror" required>
                                <option value="">Seleccionar tipo...</option>
                                <option value="natural" {{ old('tipo') == 'natural' ? 'selected' : '' }}>Persona Natural</option>
                                <option value="juridica" {{ old('tipo') == 'juridica' ? 'selected' : '' }}>Persona Jurídica</option>
                            </select>
                            @error('tipo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold" for="nombre">
                                Nombre/Razón Social <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nombre" id="nombre"
                                   class="form-control @error('nombre') is-invalid @enderror"
                                   value="{{ old('nombre') }}" required>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold" for="rut">RUT</label>
                            <input type="text" name="rut" id="rut"
                                   class="form-control @error('rut') is-invalid @enderror"
                                   value="{{ old('rut') }}" placeholder="12345678-9">
                            @error('rut')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3" id="giro-group" style="display: none;">
                            <label class="form-label fw-semibold" for="giro">Giro/Actividad</label>
                            <input type="text" name="giro" id="giro"
                                   class="form-control @error('giro') is-invalid @enderror"
                                   value="{{ old('giro') }}" placeholder="Ej: Comercio al por menor">
                            @error('giro')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-0">
                            <label class="form-label fw-semibold" for="estado">
                                Estado <span class="text-danger">*</span>
                            </label>
                            <select name="estado" id="estado" class="form-select @error('estado') is-invalid @enderror" required>
                                <option value="activo" {{ old('estado', 'activo') == 'activo' ? 'selected' : '' }}>Activo</option>
                                <option value="inactivo" {{ old('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                                <option value="suspendido" {{ old('estado') == 'suspendido' ? 'selected' : '' }}>Suspendido</option>
                            </select>
                            @error('estado')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información de Contacto -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header py-3" style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);">
                        <h6 class="mb-0 text-white fw-bold">
                            <i class="fas fa-address-book me-2"></i>Información de Contacto
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold" for="email">Email</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-envelope" style="color: #dc2626;"></i>
                                </span>
                                <input type="email" name="email" id="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email') }}" placeholder="cliente@email.com">
                            </div>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold" for="telefono">Teléfono</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-phone" style="color: #dc2626;"></i>
                                </span>
                                <input type="text" name="telefono" id="telefono"
                                       class="form-control @error('telefono') is-invalid @enderror"
                                       value="{{ old('telefono') }}" placeholder="+56 9 1234 5678">
                            </div>
                            @error('telefono')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold" for="direccion">Dirección</label>
                            <textarea name="direccion" id="direccion" rows="2"
                                      class="form-control @error('direccion') is-invalid @enderror"
                                      placeholder="Dirección completa">{{ old('direccion') }}</textarea>
                            @error('direccion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold" for="ciudad">Ciudad</label>
                                <input type="text" name="ciudad" id="ciudad"
                                       class="form-control @error('ciudad') is-invalid @enderror"
                                       value="{{ old('ciudad') }}">
                                @error('ciudad')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold" for="region">Región</label>
                                <input type="text" name="region" id="region"
                                       class="form-control @error('region') is-invalid @enderror"
                                       value="{{ old('region') }}">
                                @error('region')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-0">
                            <label class="form-label fw-semibold" for="codigo_postal">Código Postal</label>
                            <input type="text" name="codigo_postal" id="codigo_postal"
                                   class="form-control @error('codigo_postal') is-invalid @enderror"
                                   value="{{ old('codigo_postal') }}">
                            @error('codigo_postal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Configuración de Crédito y Observaciones -->
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header py-3" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);">
                        <h6 class="mb-0 text-white fw-bold">
                            <i class="fas fa-credit-card me-2"></i>Configuración de Crédito
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold" for="limite_credito">Límite de Crédito</label>
                            <div class="input-group">
                                <span class="input-group-text fw-bold" style="background-color: #1a1a1a; color: white; border-color: #1a1a1a;">$</span>
                                <input type="number" name="limite_credito" id="limite_credito"
                                       class="form-control @error('limite_credito') is-invalid @enderror"
                                       value="{{ old('limite_credito', 0) }}" min="0" step="0.01">
                            </div>
                            @error('limite_credito')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>                                        <div class="form-group">
                                            <label class="form-control-label" for="dias_credito">Días de Crédito</label>
                                            <input type="number" name="dias_credito" id="dias_credito"
                                                   class="form-control @error('dias_credito') is-invalid @enderror"
                                                   value="{{ old('dias_credito', 30) }}" min="0" max="365">
                                            <small class="form-text text-muted">Días máximos para pago de facturas a crédito</small>
                                            @error('dias_credito')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0">Observaciones</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label class="form-control-label" for="observaciones">Notas Adicionales</label>
                                            <textarea name="observaciones" id="observaciones" rows="5"
                                                      class="form-control @error('observaciones') is-invalid @enderror"
                                                      placeholder="Cualquier información adicional sobre el cliente...">{{ old('observaciones') }}</textarea>
                                            @error('observaciones')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-2"></i>Cancelar
                                    </a>
                                    <button type="submit" class="btn bg-gradient-primary">
                                        <i class="fas fa-save me-2"></i>Guardar Cliente
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tipoSelect = document.getElementById('tipo');
    const giroGroup = document.getElementById('giro-group');

    // Mostrar/ocultar campo giro según tipo de cliente
    function toggleGiro() {
        if (tipoSelect.value === 'juridica') {
            giroGroup.style.display = 'block';
        } else {
            giroGroup.style.display = 'none';
        }
    }

    tipoSelect.addEventListener('change', toggleGiro);
    toggleGiro(); // Ejecutar al cargar la página

    // Validación simple de RUT chileno
    const rutInput = document.getElementById('rut');
    rutInput.addEventListener('blur', function() {
        const rut = this.value.replace(/\./g, '').replace('-', '');
        if (rut && !validarRUT(rut)) {
            this.setCustomValidity('RUT inválido');
            this.classList.add('is-invalid');
        } else {
            this.setCustomValidity('');
            this.classList.remove('is-invalid');
        }
    });

    function validarRUT(rut) {
        if (rut.length < 8) return false;

        const cuerpo = rut.slice(0, -1);
        const dv = rut.slice(-1).toUpperCase();

        let suma = 0;
        let multiplicador = 2;

        for (let i = cuerpo.length - 1; i >= 0; i--) {
            suma += parseInt(cuerpo[i]) * multiplicador;
            multiplicador = multiplicador === 7 ? 2 : multiplicador + 1;
        }

        const resto = suma % 11;
        const dvCalculado = resto === 0 ? '0' : resto === 1 ? 'K' : (11 - resto).toString();

        return dv === dvCalculado;
    }
});
</script>
@endpush
