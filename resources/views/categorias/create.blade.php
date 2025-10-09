@extends('layouts.app')

@section('title', 'Nueva Categoría')

@push('styles')
<style>
    .categorias-header {
        background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%);
        color: white;
        padding: 2rem 0;
        margin-bottom: 2rem;
        border-radius: 0 0 1rem 1rem;
    }
    .card-categorias {
        border: none;
        border-radius: 15px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }
    .btn-categorias {
        background: #6f42c1;
        border: none;
        border-radius: 8px;
        padding: 0.6rem 1.5rem;
        color: white;
        transition: all 0.3s ease;
    }
    .btn-categorias:hover {
        background: #5a32a3;
        transform: translateY(-2px);
        color: white;
    }
    .form-floating .form-control:focus {
        border-color: #6f42c1;
        box-shadow: 0 0 0 0.25rem rgba(111, 66, 193, 0.25);
    }
    .form-floating .form-select:focus {
        border-color: #6f42c1;
        box-shadow: 0 0 0 0.25rem rgba(111, 66, 193, 0.25);
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="categorias-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="h2 mb-2">
                        <i class="fas fa-plus me-3"></i>
                        Nueva Categoría
                    </h1>
                    <p class="mb-0 opacity-90">
                        Crea una nueva categoría para organizar tus productos
                    </p>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="{{ route('categorias.index') }}" class="btn btn-outline-light">
                        <i class="fas fa-arrow-left me-2"></i>
                        Volver a Lista
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulario -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card card-categorias">
                    <div class="card-header bg-white border-0 pb-0">
                        <h5 class="mb-0">
                            <i class="fas fa-tag me-2 text-primary"></i>
                            Información de la Categoría
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <h6><i class="fas fa-exclamation-triangle me-2"></i>Errores en el formulario:</h6>
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('categorias.store') }}" method="POST" id="createCategoriaForm">
                            @csrf

                            <div class="row g-3">
                                <!-- Código -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text"
                                               class="form-control @error('codigo') is-invalid @enderror"
                                               id="codigo"
                                               name="codigo"
                                               value="{{ old('codigo') }}"
                                               placeholder="Código de la categoría"
                                               required>
                                        <label for="codigo">
                                            <i class="fas fa-barcode me-1"></i>
                                            Código *
                                        </label>
                                        @error('codigo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">
                                            Código único de identificación (ej: ELEC, HOGAR, OFIC)
                                        </small>
                                    </div>
                                </div>

                                <!-- Nombre -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text"
                                               class="form-control @error('nombre') is-invalid @enderror"
                                               id="nombre"
                                               name="nombre"
                                               value="{{ old('nombre') }}"
                                               placeholder="Nombre de la categoría"
                                               required>
                                        <label for="nombre">
                                            <i class="fas fa-tag me-1"></i>
                                            Nombre *
                                        </label>
                                        @error('nombre')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Descripción -->
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control @error('descripcion') is-invalid @enderror"
                                                  id="descripcion"
                                                  name="descripcion"
                                                  style="height: 100px;"
                                                  placeholder="Descripción de la categoría">{{ old('descripcion') }}</textarea>
                                        <label for="descripcion">
                                            <i class="fas fa-align-left me-1"></i>
                                            Descripción
                                        </label>
                                        @error('descripcion')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">
                                            Descripción opcional de la categoría
                                        </small>
                                    </div>
                                </div>

                                <!-- Estado -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select @error('estado') is-invalid @enderror"
                                                id="estado"
                                                name="estado"
                                                required>
                                            <option value="activo" {{ old('estado', 'activo') == 'activo' ? 'selected' : '' }}>
                                                Activo
                                            </option>
                                            <option value="inactivo" {{ old('estado') == 'inactivo' ? 'selected' : '' }}>
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
                                        <a href="{{ route('categorias.index') }}" class="btn btn-outline-secondary">
                                            <i class="fas fa-times me-2"></i>
                                            Cancelar
                                        </a>
                                        <button type="submit" class="btn btn-categorias" id="btnGuardar">
                                            <i class="fas fa-save me-2"></i>
                                            Guardar Categoría
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
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-generar código basado en nombre
    const nombreInput = document.getElementById('nombre');
    const codigoInput = document.getElementById('codigo');

    nombreInput.addEventListener('blur', function() {
        if (!codigoInput.value && this.value) {
            // Generar código automático basado en el nombre
            const nombre = this.value.trim();
            let codigo = '';

            // Tomar las primeras 4 letras de cada palabra
            const palabras = nombre.split(' ');
            palabras.forEach(palabra => {
                if (palabra.length > 0) {
                    codigo += palabra.substring(0, 2).toUpperCase();
                }
            });

            // Limitar a 6 caracteres máximo
            codigo = codigo.substring(0, 6);
            codigoInput.value = codigo;
        }
    });

    // Validación en tiempo real del código
    codigoInput.addEventListener('input', function() {
        this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
    });

    // Confirmación antes de enviar
    document.getElementById('createCategoriaForm').addEventListener('submit', function(e) {
        if (!confirm('¿Estás seguro de crear esta categoría?')) {
            e.preventDefault();
        }
    });
});
</script>
@endpush
@endsection
