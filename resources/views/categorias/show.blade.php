@extends('layouts.app')

@section('title', 'Detalle de Categoría')

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
    .badge-estado {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 500;
    }
    .badge-activo {
        background-color: #d4edda;
        color: #155724;
    }
    .badge-inactivo {
        background-color: #f8d7da;
        color: #721c24;
    }
    .info-item {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 1rem;
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
                        <i class="fas fa-tag me-3"></i>
                        {{ $categoria->nombre }}
                    </h1>
                    <p class="mb-0 opacity-90">
                        Información detallada de la categoría
                    </p>
                </div>
                <div class="col-md-4 text-md-end">
                    <div class="d-flex gap-2 justify-content-md-end">
                        <a href="{{ route('categorias.edit', $categoria) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>
                            Editar
                        </a>
                        <a href="{{ route('categorias.index') }}" class="btn btn-outline-light">
                            <i class="fas fa-arrow-left me-2"></i>
                            Lista
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido -->
    <div class="container">
        <div class="row">
            <!-- Información Principal -->
            <div class="col-lg-8 mb-4">
                <div class="card card-categorias">
                    <div class="card-header bg-white border-0 pb-0">
                        <h5 class="mb-0">
                            <i class="fas fa-info-circle me-2 text-primary"></i>
                            Información de la Categoría
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label class="form-label text-muted mb-1">Código</label>
                                    <div class="fw-bold">
                                        <span class="badge bg-secondary fs-6">{{ $categoria->codigo }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label class="form-label text-muted mb-1">Estado</label>
                                    <div>
                                        <span class="badge badge-estado {{ $categoria->estado == 'activo' ? 'badge-activo' : 'badge-inactivo' }}">
                                            {{ ucfirst($categoria->estado) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="info-item">
                            <label class="form-label text-muted mb-1">Nombre</label>
                            <div class="fw-bold fs-5">{{ $categoria->nombre }}</div>
                        </div>

                        @if($categoria->descripcion)
                            <div class="info-item">
                                <label class="form-label text-muted mb-1">Descripción</label>
                                <div>{{ $categoria->descripcion }}</div>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label class="form-label text-muted mb-1">Fecha de Creación</label>
                                    <div>{{ $categoria->created_at->format('d/m/Y H:i') }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label class="form-label text-muted mb-1">Última Actualización</label>
                                    <div>{{ $categoria->updated_at->format('d/m/Y H:i') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel Lateral -->
            <div class="col-lg-4 mb-4">
                <div class="card card-categorias">
                    <div class="card-header bg-white border-0 pb-0">
                        <h5 class="mb-0">
                            <i class="fas fa-chart-bar me-2 text-success"></i>
                            Estadísticas
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <div class="display-4 text-primary mb-2">{{ $productos_count }}</div>
                            <div class="text-muted">Productos Asociados</div>
                        </div>

                        @if($productos_count > 0)
                            <div class="d-grid gap-2">
                                <a href="{{ route('productos.index', ['categoria' => $categoria->id]) }}"
                                   class="btn btn-outline-primary">
                                    <i class="fas fa-boxes me-2"></i>
                                    Ver Productos
                                </a>
                            </div>
                        @else
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                No hay productos asociados a esta categoría.
                            </div>
                        @endif

                        <hr>

                        <div class="d-grid gap-2">
                            <a href="{{ route('categorias.edit', $categoria) }}"
                               class="btn btn-warning">
                                <i class="fas fa-edit me-2"></i>
                                Editar Categoría
                            </a>

                            @if($productos_count == 0)
                                <form action="{{ route('categorias.destroy', $categoria) }}"
                                      method="POST"
                                      onsubmit="return confirm('¿Estás seguro de eliminar esta categoría?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger w-100">
                                        <i class="fas fa-trash me-2"></i>
                                        Eliminar Categoría
                                    </button>
                                </form>
                            @else
                                <button class="btn btn-outline-secondary" disabled>
                                    <i class="fas fa-lock me-2"></i>
                                    No se puede eliminar
                                </button>
                                <small class="text-muted text-center">
                                    Tiene productos asociados
                                </small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
