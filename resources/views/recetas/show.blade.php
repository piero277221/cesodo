@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="fas fa-utensils text-primary me-2"></i>
            {{ $receta->nombre }}
        </h2>
        <div>
            <a href="{{ route('recetas.edit', $receta) }}" class="btn btn-warning">
                <i class="fas fa-edit me-2"></i>
                Editar
            </a>
            <a href="{{ route('recetas.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>
                Volver al Listado
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <!-- Información Principal -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Información General
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong><i class="fas fa-bookmark text-primary me-2"></i>Tipo de Plato:</strong>
                            <span class="badge bg-info ms-2">
                                {{ str_replace('_', ' ', ucfirst($receta->tipo_plato)) }}
                            </span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong><i class="fas fa-signal text-primary me-2"></i>Dificultad:</strong>
                            <span class="badge 
                                @if($receta->dificultad == 'facil') bg-success
                                @elseif($receta->dificultad == 'media' || $receta->dificultad == 'intermedio') bg-warning
                                @else bg-danger
                                @endif ms-2">
                                {{ ucfirst($receta->dificultad) }}
                            </span>
                        </div>
                        <div class="col-md-4 mb-3">
                            <strong><i class="fas fa-clock text-primary me-2"></i>Tiempo:</strong>
                            <span class="ms-2">{{ $receta->tiempo_preparacion }} min</span>
                        </div>
                        <div class="col-md-4 mb-3">
                            <strong><i class="fas fa-users text-primary me-2"></i>Porciones:</strong>
                            <span class="ms-2">{{ $receta->porciones }}</span>
                        </div>
                        <div class="col-md-4 mb-3">
                            <strong><i class="fas fa-dollar-sign text-primary me-2"></i>Costo Aproximado:</strong>
                            <span class="ms-2">S/ {{ number_format($receta->costo_aproximado, 2) }}</span>
                        </div>
                    </div>

                    @if($receta->descripcion)
                        <div class="mt-3">
                            <strong><i class="fas fa-align-left text-primary me-2"></i>Descripción:</strong>
                            <p class="mt-2 text-muted">{{ $receta->descripcion }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Ingredientes -->
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2"></i>
                        Ingredientes ({{ $receta->ingredientes->count() }})
                    </h5>
                </div>
                <div class="card-body">
                    @if($receta->ingredientes->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Unidad</th>
                                        <th>Observaciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($receta->ingredientes as $ingrediente)
                                        <tr>
                                            <td>
                                                <i class="fas fa-box text-primary me-2"></i>
                                                {{ $ingrediente->producto->nombre }}
                                            </td>
                                            <td>{{ number_format($ingrediente->cantidad, 2) }}</td>
                                            <td>{{ $ingrediente->unidad_medida }}</td>
                                            <td>{{ $ingrediente->observaciones ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted mb-0">No hay ingredientes registrados.</p>
                    @endif
                </div>
            </div>

            <!-- Instrucciones -->
            <div class="card mb-4">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fas fa-tasks me-2"></i>
                        Instrucciones de Preparación
                    </h5>
                </div>
                <div class="card-body">
                    @if($receta->instrucciones)
                        <div class="recipe-instructions">
                            {!! nl2br(e($receta->instrucciones)) !!}
                        </div>
                    @else
                        <p class="text-muted mb-0">No hay instrucciones registradas.</p>
                    @endif
                </div>
            </div>

            <!-- Pasos de Preparación -->
            @if($receta->pasos_preparacion)
                @php
                    $pasos = json_decode($receta->pasos_preparacion, true);
                @endphp
                @if(is_array($pasos) && count($pasos) > 0)
                    <div class="card mb-4">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-shoe-prints me-2"></i>
                                Pasos de Preparación
                            </h5>
                        </div>
                        <div class="card-body">
                            <ol class="list-group list-group-numbered">
                                @foreach($pasos as $paso)
                                    <li class="list-group-item">{{ $paso }}</li>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                @endif
            @endif
        </div>

        <!-- Panel Lateral -->
        <div class="col-md-4">
            <!-- Estado y Metadatos -->
            <div class="card mb-4">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-cog me-2"></i>
                        Estado y Metadatos
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Estado:</strong>
                        <span class="badge {{ $receta->estado == 'activo' ? 'bg-success' : 'bg-secondary' }} ms-2">
                            {{ ucfirst($receta->estado) }}
                        </span>
                    </div>
                    
                    @if($receta->createdBy)
                        <div class="mb-3">
                            <strong>Creado por:</strong>
                            <p class="mb-0 text-muted">{{ $receta->createdBy->name }}</p>
                        </div>
                    @endif

                    <div class="mb-3">
                        <strong>Fecha de creación:</strong>
                        <p class="mb-0 text-muted">{{ $receta->created_at->format('d/m/Y H:i') }}</p>
                    </div>

                    <div>
                        <strong>Última actualización:</strong>
                        <p class="mb-0 text-muted">{{ $receta->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Notas Adicionales -->
            @if($receta->notas)
                <div class="card mb-4">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-sticky-note me-2"></i>
                            Notas
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">{{ $receta->notas }}</p>
                    </div>
                </div>
            @endif

            <!-- Ingredientes Especiales -->
            @if($receta->ingredientes_especiales)
                <div class="card mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">
                            <i class="fas fa-star me-2"></i>
                            Ingredientes Especiales
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">{{ $receta->ingredientes_especiales }}</p>
                    </div>
                </div>
            @endif

            <!-- Acciones -->
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Acciones
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('recetas.destroy', $receta) }}" method="POST" 
                          onsubmit="return confirm('¿Estás seguro de eliminar esta receta?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="fas fa-trash me-2"></i>
                            Eliminar Receta
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.recipe-instructions {
    font-size: 1rem;
    line-height: 1.8;
}

.list-group-numbered {
    counter-reset: section;
    list-style-type: none;
}

.list-group-numbered li {
    counter-increment: section;
    padding-left: 2rem;
    position: relative;
}

.list-group-numbered li:before {
    content: counter(section);
    position: absolute;
    left: 0.5rem;
    top: 50%;
    transform: translateY(-50%);
    background-color: #0d6efd;
    color: white;
    width: 1.5rem;
    height: 1.5rem;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 0.875rem;
}
</style>
@endsection
