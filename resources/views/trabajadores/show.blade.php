@extends('layouts.app')

@section('title', 'Detalles del Trabajador')

@push('styles')
<style>
    .hero-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
                    Detalles del Trabajador
                </h2>
                <div class="btn-group">
                    <a href="{{ route('trabajadores.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>
                        Volver
                    </a>
                    <a href="{{ route('trabajadores.edit', $trabajador) }}" class="btn btn-warning">
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

            <!-- Hero Card del Trabajador -->
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
                                            <h2 class="mb-1">{{ $trabajador->nombres }} {{ $trabajador->apellidos }}</h2>
                                            <p class="mb-2 opacity-75">
                                                <i class="fas fa-briefcase me-2"></i>{{ $trabajador->cargo ?? 'Sin cargo' }}
                                            </p>
                                            <div class="d-flex gap-2">
                                                @if($trabajador->codigo)
                                                    <span class="badge badge-xl bg-white text-dark">
                                                        <i class="fas fa-id-badge me-1"></i>{{ $trabajador->codigo }}
                                                    </span>
                                                @endif
                                                @if($trabajador->dni)
                                                    <span class="badge badge-xl bg-white text-dark">
                                                        <i class="fas fa-id-card me-1"></i>{{ $trabajador->dni }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 text-lg-end">
                                    @php
                                        $estado = $trabajador->estado ?? 'Activo';
                                        $badgeClass = match($estado) {
                                            'Activo' => 'bg-success',
                                            'Inactivo' => 'bg-danger',
                                            'Suspendido' => 'bg-warning',
                                            'Vacaciones' => 'bg-info',
                                            default => 'bg-secondary'
                                        };
                                    @endphp
                                    <div class="mb-3">
                                        <span class="badge {{ $badgeClass }} badge-xl">
                                            <i class="fas fa-circle me-1"></i>{{ $estado }}
                                        </span>
                                    </div>
                                    <div class="d-flex flex-wrap justify-content-lg-end gap-2">
                                        <a href="{{ route('trabajadores.edit', $trabajador) }}" class="btn btn-light btn-floating">
                                            <i class="fas fa-edit me-2"></i>Editar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información del Trabajador -->
            <div class="row mb-4">
                <!-- Información Personal -->
                <div class="col-md-6 mb-4">
                    <div class="card stat-card animate-fade-in h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-id-card me-2"></i>Información Personal
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-5">
                                    <strong><i class="fas fa-user text-muted me-2"></i>Nombres:</strong>
                                </div>
                                <div class="col-7">
                                    {{ $trabajador->nombres ?? 'No especificado' }}
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-5">
                                    <strong><i class="fas fa-user text-muted me-2"></i>Apellidos:</strong>
                                </div>
                                <div class="col-7">
                                    {{ $trabajador->apellidos ?? 'No especificado' }}
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-5">
                                    <strong><i class="fas fa-id-card text-muted me-2"></i>DNI:</strong>
                                </div>
                                <div class="col-7">
                                    @if($trabajador->dni)
                                        <span class="badge bg-info">{{ $trabajador->dni }}</span>
                                    @else
                                        <span class="text-muted">No especificado</span>
                                    @endif
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-5">
                                    <strong><i class="fas fa-calendar text-muted me-2"></i>F. Nacimiento:</strong>
                                </div>
                                <div class="col-7">
                                    @if($trabajador->fecha_nacimiento)
                                        {{ \Carbon\Carbon::parse($trabajador->fecha_nacimiento)->format('d/m/Y') }}
                                        <small class="text-muted">({{ \Carbon\Carbon::parse($trabajador->fecha_nacimiento)->age }} años)</small>
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
                                    @if($trabajador->sexo)
                                        <span class="badge bg-secondary">
                                            {{ $trabajador->sexo == 'M' ? 'Masculino' : 'Femenino' }}
                                        </span>
                                    @else
                                        <span class="text-muted">No especificado</span>
                                    @endif
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-5">
                                    <strong><i class="fas fa-map-marker-alt text-muted me-2"></i>Dirección:</strong>
                                </div>
                                <div class="col-7">
                                    {{ $trabajador->direccion ?? 'No especificado' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información Laboral -->
                <div class="col-md-6 mb-4">
                    <div class="card stat-card animate-fade-in h-100">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-briefcase me-2"></i>Información Laboral
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-5">
                                    <strong><i class="fas fa-building text-muted me-2"></i>Área:</strong>
                                </div>
                                <div class="col-7">
                                    @if($trabajador->area)
                                        <span class="badge bg-info">{{ $trabajador->area }}</span>
                                    @else
                                        <span class="text-muted">No especificado</span>
                                    @endif
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-5">
                                    <strong><i class="fas fa-user-tie text-muted me-2"></i>Cargo:</strong>
                                </div>
                                <div class="col-7">
                                    {{ $trabajador->cargo ?? 'No especificado' }}
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-5">
                                    <strong><i class="fas fa-calendar-plus text-muted me-2"></i>F. Ingreso:</strong>
                                </div>
                                <div class="col-7">
                                    @if($trabajador->fecha_ingreso)
                                        {{ \Carbon\Carbon::parse($trabajador->fecha_ingreso)->format('d/m/Y') }}
                                        <small class="text-muted">({{ \Carbon\Carbon::parse($trabajador->fecha_ingreso)->diffForHumans() }})</small>
                                    @else
                                        <span class="text-muted">No especificado</span>
                                    @endif
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-5">
                                    <strong><i class="fas fa-money-bill text-muted me-2"></i>Salario:</strong>
                                </div>
                                <div class="col-7">
                                    @if($trabajador->salario)
                                        <span class="text-success fw-bold">S/ {{ number_format($trabajador->salario, 2) }}</span>
                                    @else
                                        <span class="text-muted">No especificado</span>
                                    @endif
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-5">
                                    <strong><i class="fas fa-clock text-muted me-2"></i>Turno:</strong>
                                </div>
                                <div class="col-7">
                                    @if($trabajador->turno)
                                        <span class="badge bg-warning text-dark">{{ $trabajador->turno }}</span>
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
                                    <small class="text-muted">{{ $trabajador->created_at->format('d/m/Y H:i') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información de Contacto -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card stat-card animate-fade-in">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-phone me-2"></i>Información de Contacto
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <i class="fas fa-phone fa-2x text-primary"></i>
                                        </div>
                                        <div>
                                            <strong>Teléfono</strong><br>
                                            <span class="text-muted">
                                                {{ $trabajador->telefono ?? 'No especificado' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <i class="fas fa-envelope fa-2x text-success"></i>
                                        </div>
                                        <div>
                                            <strong>Email</strong><br>
                                            <span class="text-muted">
                                                {{ $trabajador->email ?? 'No especificado' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <i class="fas fa-exclamation-triangle fa-2x text-warning"></i>
                                        </div>
                                        <div>
                                            <strong>Emergencia</strong><br>
                                            <span class="text-muted">
                                                {{ $trabajador->telefono_emergencia ?? 'No especificado' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Observaciones -->
            @if($trabajador->observaciones)
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card stat-card animate-fade-in">
                            <div class="card-header bg-warning text-dark">
                                <h5 class="mb-0">
                                    <i class="fas fa-sticky-note me-2"></i>Observaciones
                                </h5>
                            </div>
                            <div class="card-body">
                                <p class="mb-0">{{ $trabajador->observaciones }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Contratos Asociados -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card stat-card animate-fade-in">
                        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="fas fa-file-contract me-2"></i>Contratos Asociados
                            </h5>
                            <button type="button" class="btn btn-light btn-sm" id="cargarContratosBtn">
                                <i class="fas fa-sync-alt me-1"></i>Cargar Contratos
                            </button>
                        </div>
                        <div class="card-body">
                            <div id="contratosLoading" class="text-center py-4" style="display: none;">
                                <i class="fas fa-spinner fa-spin fa-2x text-info"></i>
                                <p class="mt-2 text-muted">Cargando contratos...</p>
                            </div>

                            <div id="contratosContainer">
                                <div class="text-center py-4 text-muted">
                                    <i class="fas fa-file-contract fa-3x mb-3"></i>
                                    <p>Haga clic en "Cargar Contratos" para ver la información de contratos asociados a este trabajador.</p>
                                </div>
                            </div>

                            <!-- Template para mostrar contratos -->
                            <div id="contratoTemplate" style="display: none;">
                                <div class="contrato-item border rounded p-3 mb-3">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <h6 class="contrato-numero text-primary mb-2"></h6>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <small class="text-muted">Cargo:</small><br>
                                                    <span class="contrato-cargo fw-bold"></span>
                                                </div>
                                                <div class="col-md-6">
                                                    <small class="text-muted">Departamento:</small><br>
                                                    <span class="contrato-departamento"></span>
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <small class="text-muted">Salario Base:</small><br>
                                                    <span class="contrato-salario text-success fw-bold"></span>
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <small class="text-muted">Modalidad:</small><br>
                                                    <span class="contrato-modalidad"></span>
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <small class="text-muted">Fecha de Inicio:</small><br>
                                                    <span class="contrato-fecha-inicio"></span>
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <small class="text-muted">Estado:</small><br>
                                                    <span class="contrato-estado"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <div class="btn-group-vertical gap-2">
                                                <button type="button" class="btn btn-outline-info btn-sm ver-contrato-btn">
                                                    <i class="fas fa-eye me-1"></i>Ver Contrato
                                                </button>
                                                <button type="button" class="btn btn-outline-success btn-sm descargar-contrato-btn">
                                                    <i class="fas fa-download me-1"></i>Descargar PDF
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
                                    <a href="{{ route('trabajadores.edit', $trabajador) }}" class="btn btn-outline-primary w-100">
                                        <i class="fas fa-edit me-2"></i>
                                        Editar Trabajador
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="{{ route('trabajadores.create') }}" class="btn btn-outline-success w-100">
                                        <i class="fas fa-user-plus me-2"></i>
                                        Nuevo Trabajador
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="{{ route('trabajadores.index') }}" class="btn btn-outline-info w-100">
                                        <i class="fas fa-list me-2"></i>
                                        Ver Todos
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <form method="POST" action="{{ route('trabajadores.destroy', $trabajador) }}"
                                          style="display: inline;"
                                          onsubmit="return confirm('¿Está seguro de eliminar este trabajador?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger w-100">
                                            <i class="fas fa-trash me-2"></i>
                                            Eliminar
                                        </button>
                                    </form>
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

    // Funcionalidad de contratos
    const cargarContratosBtn = document.getElementById('cargarContratosBtn');
    const contratosLoading = document.getElementById('contratosLoading');
    const contratosContainer = document.getElementById('contratosContainer');
    const contratoTemplate = document.getElementById('contratoTemplate');

    cargarContratosBtn.addEventListener('click', async function() {
        try {
            // Mostrar loading
            contratosLoading.style.display = 'block';
            contratosContainer.innerHTML = '';
            cargarContratosBtn.disabled = true;

            // Hacer petición a la API
            const response = await fetch(`{{ route('trabajadores.contratos', $trabajador->id) }}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            const data = await response.json();

            // Ocultar loading
            contratosLoading.style.display = 'none';

            if (data.success && data.contratos && data.contratos.length > 0) {
                // Mostrar contratos
                mostrarContratos(data.contratos);
            } else {
                // No hay contratos
                contratosContainer.innerHTML = `
                    <div class="text-center py-4 text-muted">
                        <i class="fas fa-file-contract fa-3x mb-3 opacity-50"></i>
                        <p><strong>No se encontraron contratos</strong></p>
                        <p>Este trabajador no tiene contratos asociados en el sistema.</p>
                        <a href="{{ route('contratos.create') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-plus me-1"></i>Crear Nuevo Contrato
                        </a>
                    </div>
                `;
            }

        } catch (error) {
            console.error('Error al cargar contratos:', error);
            contratosLoading.style.display = 'none';
            contratosContainer.innerHTML = `
                <div class="text-center py-4 text-danger">
                    <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                    <p><strong>Error al cargar contratos</strong></p>
                    <p>Hubo un problema al cargar la información de contratos.</p>
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="location.reload()">
                        <i class="fas fa-redo me-1"></i>Reintentar
                    </button>
                </div>
            `;
        } finally {
            cargarContratosBtn.disabled = false;
        }
    });

    function mostrarContratos(contratos) {
        let htmlContratos = '';

        if (contratos.length === 0) {
            contratosContainer.innerHTML = `
                <div class="text-center py-4 text-muted">
                    <i class="fas fa-file-contract fa-3x mb-3 opacity-50"></i>
                    <p>No hay contratos registrados para este trabajador.</p>
                </div>
            `;
            return;
        }

        contratos.forEach(contrato => {
            const contratoHtml = `
                <div class="contrato-item border rounded p-3 mb-3 ${contrato.estado === 'activo' ? 'border-success' : ''}">
                    <div class="row">
                        <div class="col-md-8">
                            <h6 class="text-primary mb-2">
                                <i class="fas fa-file-contract me-1"></i>
                                Contrato ${contrato.numero_contrato}
                                ${contrato.estado === 'activo' ? '<span class="badge bg-success ms-2">ACTIVO</span>' : ''}
                            </h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="text-muted">Cargo:</small><br>
                                    <span class="fw-bold">${contrato.cargo || 'No especificado'}</span>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted">Departamento:</small><br>
                                    <span>${contrato.area_departamento || 'No especificado'}</span>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <small class="text-muted">Salario Base:</small><br>
                                    <span class="text-success fw-bold">S/. ${parseFloat(contrato.salario_base || 0).toFixed(2)}</span>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <small class="text-muted">Modalidad:</small><br>
                                    <span>${contrato.modalidad || 'No especificada'}</span>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <small class="text-muted">Fecha de Inicio:</small><br>
                                    <span>${contrato.fecha_inicio_formatted || 'No especificada'}</span>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <small class="text-muted">Estado:</small><br>
                                    ${contrato.estado_badge}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="btn-group-vertical gap-2">
                                <button type="button" class="btn btn-outline-info btn-sm" onclick="verContrato(${contrato.id})">
                                    <i class="fas fa-eye me-1"></i>Ver Contrato
                                </button>
                                ${contrato.puede_descargar ? `
                                <button type="button" class="btn btn-outline-success btn-sm" onclick="descargarContrato(${contrato.id})">
                                    <i class="fas fa-download me-1"></i>Descargar PDF
                                </button>
                                ` : `
                                <button type="button" class="btn btn-outline-secondary btn-sm" disabled title="Contrato no disponible para descarga">
                                    <i class="fas fa-download me-1"></i>No Disponible
                                </button>
                                `}
                            </div>
                        </div>
                    </div>
                </div>
            `;
            htmlContratos += contratoHtml;
        });

        // Agregar resumen al final
        const resumenHtml = `
            <div class="mt-4 p-3 bg-light rounded">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Total de Contratos:</strong> ${contratos.length}
                    </div>
                    <div class="col-md-6">
                        <strong>Contratos Activos:</strong> ${contratos.filter(c => c.estado === 'activo').length}
                    </div>
                </div>
            </div>
        `;

        contratosContainer.innerHTML = htmlContratos + resumenHtml;
    }

    // Funciones globales para los botones
    window.verContrato = function(contratoId) {
        const url = `{{ url('contratos') }}/${contratoId}`;
        window.open(url, '_blank');
    };

    window.descargarContrato = function(contratoId) {
        const url = `{{ url('contratos') }}/${contratoId}/pdf`;
        window.open(url, '_blank');
    };
});
</script>
@endsection
