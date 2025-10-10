@extends('layouts.app')

@section('title', 'Detalles de la Persona')

@push('styles')
<style>
    .hero-card {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        border: none;
        border-radius: 15px;
    }
    .stat-card {
        border: none;
        border-radius: 10px;
        transition: all 0.3s ease;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    }
    .animate-fade-in {
        animation: fadeIn 0.5s ease-in;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .badge-xl {
        font-size: 0.9rem;
        padding: 0.5rem 1rem;
    }
    .btn-floating {
        border-radius: 50px;
        padding: 0.75rem 1.5rem;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">
                    <i class="fas fa-user text-info me-2"></i>
                    Detalles de la Persona
                </h2>
                <div class="btn-group">
                    <a href="{{ route('personas.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>
                        Volver
                    </a>
                    <a href="{{ route('personas.edit', $persona) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-1"></i>
                        Editar
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-1"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Hero Card de la Persona -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card hero-card animate-fade-in">
                        <div class="card-body p-4">
                            <div class="row align-items-center">
                                <div class="col-lg-6">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-white bg-opacity-20 rounded-circle p-3 me-4">
                                            <i class="fas fa-user fa-2x"></i>
                                        </div>
                                        <div>
                                            <h2 class="mb-1">{{ $persona->nombres }} {{ $persona->apellidos }}</h2>
                                            <p class="mb-2 opacity-75">
                                                <i class="fas fa-id-card me-2"></i>{{ strtoupper($persona->tipo_documento ?? 'DOC') }}: {{ $persona->numero_documento ?? 'N/A' }}
                                            </p>
                                            <div class="d-flex gap-2">
                                                @if($persona->pais)
                                                    <span class="badge badge-xl bg-white text-dark">
                                                        <i class="fas fa-flag me-1"></i>{{ $persona->pais }}
                                                    </span>
                                                @endif
                                                @if($persona->fecha_nacimiento)
                                                    <span class="badge badge-xl bg-white text-dark">
                                                        <i class="fas fa-birthday-cake me-1"></i>{{ \Carbon\Carbon::parse($persona->fecha_nacimiento)->age }} años
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 text-lg-end">
                                    <div class="mb-3">
                                        @if($persona->trabajador)
                                            <span class="badge bg-success badge-xl">
                                                <i class="fas fa-user-tie me-1"></i>Trabajador Activo
                                            </span>
                                        @else
                                            <span class="badge bg-warning text-dark badge-xl">
                                                <i class="fas fa-user-clock me-1"></i>Sin Asignar
                                            </span>
                                        @endif
                                    </div>
                                    <div class="d-flex flex-wrap justify-content-lg-end gap-2">
                                        <a href="{{ route('personas.edit', $persona) }}" class="btn btn-light btn-floating">
                                            <i class="fas fa-edit me-2"></i>Editar
                                        </a>
                                        @if(!$persona->trabajador)
                                            <a href="{{ route('trabajadores.create', ['persona_id' => $persona->id]) }}" class="btn btn-success btn-floating">
                                                <i class="fas fa-user-plus me-2"></i>Crear Trabajador
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información de la Persona -->
            <div class="row mb-4">
                <!-- Información Personal -->
                <div class="col-md-6 mb-4">
                    <div class="card stat-card animate-fade-in h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-user me-2"></i>Información Personal
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-5">
                                    <strong><i class="fas fa-user text-muted me-2"></i>Nombres:</strong>
                                </div>
                                <div class="col-7">
                                    {{ $persona->nombres ?? 'No especificado' }}
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-5">
                                    <strong><i class="fas fa-user text-muted me-2"></i>Apellidos:</strong>
                                </div>
                                <div class="col-7">
                                    {{ $persona->apellidos ?? 'No especificado' }}
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-5">
                                    <strong><i class="fas fa-calendar text-muted me-2"></i>F. Nacimiento:</strong>
                                </div>
                                <div class="col-7">
                                    @if($persona->fecha_nacimiento)
                                        {{ \Carbon\Carbon::parse($persona->fecha_nacimiento)->format('d/m/Y') }}
                                        <small class="text-muted">({{ \Carbon\Carbon::parse($persona->fecha_nacimiento)->age }} años)</small>
                                    @else
                                        <span class="text-muted">No especificado</span>
                                    @endif
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-5">
                                    <strong><i class="fas fa-venus-mars text-muted me-2"></i>Sexo:</strong>
                                </div>
                                <div class="col-7">
                                    @if($persona->sexo)
                                        <span class="badge bg-secondary">
                                            {{ $persona->sexo == 'M' ? 'Masculino' : ($persona->sexo == 'F' ? 'Femenino' : 'Otro') }}
                                        </span>
                                    @else
                                        <span class="text-muted">No especificado</span>
                                    @endif
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-5">
                                    <strong><i class="fas fa-globe text-muted me-2"></i>País:</strong>
                                </div>
                                <div class="col-7">
                                    {{ $persona->pais ?? 'No especificado' }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-5">
                                    <strong><i class="fas fa-heart text-muted me-2"></i>Estado Civil:</strong>
                                </div>
                                <div class="col-7">
                                    {{ $persona->estado_civil ?? 'No especificado' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información de Documentos -->
                <div class="col-md-6 mb-4">
                    <div class="card stat-card animate-fade-in h-100">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-id-card me-2"></i>Documentos e Identificación
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-5">
                                    <strong><i class="fas fa-file-alt text-muted me-2"></i>Tipo:</strong>
                                </div>
                                <div class="col-7">
                                    @if($persona->tipo_documento)
                                        <span class="badge bg-info">{{ strtoupper($persona->tipo_documento) }}</span>
                                    @else
                                        <span class="text-muted">No especificado</span>
                                    @endif
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-5">
                                    <strong><i class="fas fa-hashtag text-muted me-2"></i>Número:</strong>
                                </div>
                                <div class="col-7">
                                    @if($persona->numero_documento)
                                        <span class="fw-bold">{{ $persona->numero_documento }}</span>
                                    @else
                                        <span class="text-muted">No especificado</span>
                                    @endif
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-5">
                                    <strong><i class="fas fa-calendar text-muted me-2"></i>Registrado:</strong>
                                </div>
                                <div class="col-7">
                                    <small class="text-muted">{{ $persona->created_at->format('d/m/Y H:i') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información de Contacto y Dirección -->
            <div class="row mb-4">
                <!-- Contacto -->
                <div class="col-md-6 mb-4">
                    <div class="card stat-card animate-fade-in">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-phone me-2"></i>Información de Contacto
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <i class="fas fa-phone fa-2x text-primary"></i>
                                        </div>
                                        <div>
                                            <strong>Teléfono/Celular</strong><br>
                                            <span class="text-muted">
                                                {{ $persona->celular ?? 'No especificado' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <i class="fas fa-envelope fa-2x text-success"></i>
                                        </div>
                                        <div>
                                            <strong>Correo Electrónico</strong><br>
                                            <span class="text-muted">
                                                {{ $persona->correo ?? 'No especificado' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dirección -->
                <div class="col-md-6 mb-4">
                    <div class="card stat-card animate-fade-in">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0">
                                <i class="fas fa-map-marker-alt me-2"></i>Ubicación
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-start">
                                <div class="me-3">
                                    <i class="fas fa-home fa-2x text-warning"></i>
                                </div>
                                <div>
                                    <strong>Dirección</strong><br>
                                    <span class="text-muted">
                                        {{ $persona->direccion ?? 'No especificado' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información del Trabajador (si existe) -->
            @if($persona->trabajador)
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card stat-card animate-fade-in">
                            <div class="card-header bg-dark text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-user-tie me-2"></i>Información del Trabajador
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <strong>Código:</strong><br>
                                        <span class="badge bg-secondary">{{ $persona->trabajador->codigo ?? 'N/A' }}</span>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <strong>Área:</strong><br>
                                        <span class="badge bg-info">{{ $persona->trabajador->area ?? 'N/A' }}</span>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <strong>Cargo:</strong><br>
                                        <span class="text-muted">{{ $persona->trabajador->cargo ?? 'N/A' }}</span>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <strong>Estado:</strong><br>
                                        @php
                                            $estado = $persona->trabajador->estado ?? 'Activo';
                                            $badgeClass = match($estado) {
                                                'Activo' => 'bg-success',
                                                'Inactivo' => 'bg-danger',
                                                'Suspendido' => 'bg-warning',
                                                'Vacaciones' => 'bg-info',
                                                default => 'bg-secondary'
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ $estado }}</span>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <a href="{{ route('trabajadores.show', $persona->trabajador) }}" class="btn btn-outline-primary">
                                            <i class="fas fa-external-link-alt me-1"></i>
                                            Ver Detalles del Trabajador
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Acciones Rápidas -->
            <div class="row">
                <div class="col-12">
                    <div class="card animate-fade-in">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">
                                <i class="fas fa-bolt text-warning me-2"></i>Acciones Rápidas
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <a href="{{ route('personas.edit', $persona) }}" class="btn btn-outline-primary w-100">
                                        <i class="fas fa-edit me-2"></i>
                                        Editar Persona
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    @if(!$persona->trabajador)
                                        <a href="{{ route('trabajadores.create', ['persona_id' => $persona->id]) }}" class="btn btn-outline-success w-100">
                                            <i class="fas fa-user-plus me-2"></i>
                                            Crear Trabajador
                                        </a>
                                    @else
                                        <a href="{{ route('trabajadores.show', $persona->trabajador) }}" class="btn btn-outline-info w-100">
                                            <i class="fas fa-user-tie me-2"></i>
                                            Ver Trabajador
                                        </a>
                                    @endif
                                </div>
                                <div class="col-md-3">
                                    <a href="{{ route('personas.create') }}" class="btn btn-outline-warning w-100">
                                        <i class="fas fa-plus me-2"></i>
                                        Nueva Persona
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="{{ route('personas.index') }}" class="btn btn-outline-secondary w-100">
                                        <i class="fas fa-list me-2"></i>
                                        Ver Todas
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animaciones al cargar
    const cards = document.querySelectorAll('.animate-fade-in');
    cards.forEach((card, index) => {
        setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
});
</script>
@endsection
@endsection
