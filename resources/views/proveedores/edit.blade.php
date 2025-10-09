<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Proveedores
        </h2>
    </x-slot>

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<style>
    .proveedores-header {
        background: #2d3436;
        color: white;
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
    }
    .card-proveedores {
        border: none;
        border-radius: 15px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }
    .btn-proveedores {
        background: #fd7900;
        border: none;
        border-radius: 8px;
        padding: 0.6rem 1.5rem;
        color: white;
        transition: all 0.3s ease;
    }
    .btn-proveedores:hover {
        background: #e6690a;
        transform: translateY(-2px);
        color: white;
    }
    .form-floating .form-control:focus {
        border-color: #fd7900;
        box-shadow: 0 0 0 0.25rem rgba(253, 121, 0, 0.25);
    }
    .form-floating .form-select:focus {
        border-color: #fd7900;
        box-shadow: 0 0 0 0.25rem rgba(253, 121, 0, 0.25);
    }
</style>
@endpush

<div class="container-fluid py-4">
    <!-- Header -->
    <div class="proveedores-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="h2 mb-2">
                    <i class="fas fa-edit me-3"></i>
                    Editar Proveedor
                </h1>
                <p class="mb-0 opacity-90">
                    Modifica la información del proveedor: {{ $proveedor->razon_social }}
                </p>
            </div>
            <div class="col-md-4 text-md-end">
                <div class="d-flex gap-2 justify-content-md-end">
                    <a href="{{ route('proveedores.show', $proveedor) }}" class="btn btn-outline-light">
                        <i class="fas fa-eye me-2"></i>
                        Ver
                    </a>
                    <a href="{{ route('proveedores.index') }}" class="btn btn-outline-light">
                        <i class="fas fa-list me-2"></i>
                        Lista
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulario -->
    <div class="row justify-content-center">
        <div class="col-xl-10">
            <div class="card-proveedores">
                <div class="card-body p-4">
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h5 class="text-primary">
                                <i class="fas fa-info-circle me-2"></i>
                                Información del Proveedor
                            </h5>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('proveedores.update', $proveedor) }}">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <!-- RUC -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('ruc') is-invalid @enderror"
                                           id="ruc" name="ruc" value="{{ old('ruc', $proveedor->ruc) }}"
                                           placeholder="RUC" maxlength="11" required>
                                    <label for="ruc">
                                        <i class="fas fa-id-card me-1"></i>
                                        RUC *
                                    </label>
                                    @error('ruc')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Razón Social -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('razon_social') is-invalid @enderror"
                                           id="razon_social" name="razon_social" value="{{ old('razon_social', $proveedor->razon_social) }}"
                                           placeholder="Razón social" required>
                                    <label for="razon_social">
                                        <i class="fas fa-building me-1"></i>
                                        Razón Social *
                                    </label>
                                    @error('razon_social')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Nombre Comercial -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('nombre_comercial') is-invalid @enderror"
                                           id="nombre_comercial" name="nombre_comercial" value="{{ old('nombre_comercial', $proveedor->nombre_comercial) }}"
                                           placeholder="Nombre comercial">
                                    <label for="nombre_comercial">
                                        <i class="fas fa-store me-1"></i>
                                        Nombre Comercial
                                    </label>
                                    @error('nombre_comercial')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Teléfono -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="tel" class="form-control @error('telefono') is-invalid @enderror"
                                           id="telefono" name="telefono" value="{{ old('telefono', $proveedor->telefono) }}"
                                           placeholder="Teléfono">
                                    <label for="telefono">
                                        <i class="fas fa-phone me-1"></i>
                                        Teléfono
                                    </label>
                                    @error('telefono')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                           id="email" name="email" value="{{ old('email', $proveedor->email) }}"
                                           placeholder="Email">
                                    <label for="email">
                                        <i class="fas fa-envelope me-1"></i>
                                        Email
                                    </label>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Contacto -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('contacto') is-invalid @enderror"
                                           id="contacto" name="contacto" value="{{ old('contacto', $proveedor->contacto) }}"
                                           placeholder="Persona de contacto">
                                    <label for="contacto">
                                        <i class="fas fa-user me-1"></i>
                                        Persona de Contacto
                                    </label>
                                    @error('contacto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Dirección -->
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control @error('direccion') is-invalid @enderror"
                                              id="direccion" name="direccion" style="height: 100px;"
                                              placeholder="Dirección">{{ old('direccion', $proveedor->direccion) }}</textarea>
                                    <label for="direccion">
                                        <i class="fas fa-map-marker-alt me-1"></i>
                                        Dirección
                                    </label>
                                    @error('direccion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Estado -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select @error('estado') is-invalid @enderror"
                                            id="estado" name="estado" required>
                                        <option value="activo" {{ old('estado', $proveedor->estado) == 'activo' ? 'selected' : '' }}>
                                            Activo
                                        </option>
                                        <option value="inactivo" {{ old('estado', $proveedor->estado) == 'inactivo' ? 'selected' : '' }}>
                                            Inactivo
                                        </option>
                                    </select>
                                    <label for="estado">
                                        <i class="fas fa-toggle-on me-1"></i>
                                        Estado *
                                    </label>
                                    @error('estado')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex gap-2 justify-content-end">
                                    <a href="{{ route('proveedores.show', $proveedor) }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-2"></i>
                                        Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-proveedores">
                                        <i class="fas fa-save me-2"></i>
                                        Actualizar Proveedor
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Formatear RUC automáticamente
    const rucInput = document.getElementById('ruc');
    if (rucInput) {
        rucInput.addEventListener('input', function(e) {
            // Solo permitir números
            this.value = this.value.replace(/[^0-9]/g, '');

            // Limitar a 11 dígitos
            if (this.value.length > 11) {
                this.value = this.value.slice(0, 11);
            }
        });
    }
});
</script>
@endpush

</x-app-layout>