@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Encabezado -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-primary">
                    <i class="fas fa-chart-bar me-2"></i>Estadísticas de Roles y Permisos
                </h2>
                <div class="btn-group">
                    <a href="{{ route('role-management.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Volver
                    </a>
                    <button type="button" class="btn btn-info" onclick="refreshStats()">
                        <i class="fas fa-sync me-1"></i>Actualizar
                    </button>
                </div>
            </div>

            <!-- Tarjetas de estadísticas generales -->
            <div class="row mb-4">
                <div class="col-xl-3 col-lg-6 mb-3">
                    <div class="card border-primary h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-users-cog fa-3x text-primary mb-3"></i>
                            <h3 class="fw-bold text-primary">{{ $stats['total_roles'] }}</h3>
                            <h6 class="text-muted">Total de Roles</h6>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 mb-3">
                    <div class="card border-info h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-key fa-3x text-info mb-3"></i>
                            <h3 class="fw-bold text-info">{{ $stats['total_permissions'] }}</h3>
                            <h6 class="text-muted">Total de Permisos</h6>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 mb-3">
                    <div class="card border-success h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-user-check fa-3x text-success mb-3"></i>
                            <h3 class="fw-bold text-success">{{ $stats['roles_with_users'] }}</h3>
                            <h6 class="text-muted">Roles Activos</h6>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 mb-3">
                    <div class="card border-warning h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-crown fa-3x text-warning mb-3"></i>
                            <h3 class="fw-bold text-warning">
                                @if($stats['most_used_role'])
                                    {{ $stats['most_used_role']->users_count }}
                                @else
                                    0
                                @endif
                            </h3>
                            <h6 class="text-muted">
                                @if($stats['most_used_role'])
                                    {{ $stats['most_used_role']->name }}
                                @else
                                    Sin roles
                                @endif
                            </h6>
                            <small class="text-muted">Rol más usado</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Gráfico de permisos por módulo -->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-chart-pie me-2"></i>Distribución de Permisos por Módulo
                            </h5>
                        </div>
                        <div class="card-body">
                            @if($stats['permissions_by_module']->isEmpty())
                                <div class="text-center py-5">
                                    <i class="fas fa-chart-bar fa-4x text-muted mb-3"></i>
                                    <h6 class="text-muted">No hay datos para mostrar</h6>
                                    <p class="text-muted">Los permisos se crearán automáticamente al usar el sistema</p>
                                </div>
                            @else
                                <div class="row">
                                    @foreach($stats['permissions_by_module'] as $module => $count)
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="d-flex align-items-center p-3 border rounded">
                                            <div class="me-3">
                                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                    <i class="fas fa-cube"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-0 text-capitalize">{{ $module }}</h6>
                                                <div class="d-flex align-items-center">
                                                    <span class="badge bg-primary me-2">{{ $count }}</span>
                                                    <div class="progress flex-grow-1" style="height: 8px;">
                                                        <div class="progress-bar" role="progressbar"
                                                             style="width: {{ ($count / $stats['total_permissions']) * 100 }}%">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                                <!-- Gráfico de barras simple -->
                                <div class="mt-4">
                                    <canvas id="permissionsChart" width="400" height="200"></canvas>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Panel de información adicional -->
                <div class="col-lg-4">
                    <!-- Resumen rápido -->
                    <div class="card mb-4">
                        <div class="card-header bg-info text-white">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-info-circle me-2"></i>Resumen Rápido
                            </h6>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2">
                                    <i class="fas fa-check text-success me-2"></i>
                                    <strong>{{ number_format(($stats['roles_with_users'] / max($stats['total_roles'], 1)) * 100, 1) }}%</strong>
                                    de roles están en uso
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-percentage text-info me-2"></i>
                                    <strong>{{ number_format($stats['total_permissions'] / max($stats['total_roles'], 1), 1) }}</strong>
                                    permisos promedio por rol
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-layer-group text-primary me-2"></i>
                                    <strong>{{ $stats['permissions_by_module']->count() }}</strong>
                                    módulos diferentes
                                </li>
                                @if($stats['most_used_role'])
                                <li>
                                    <i class="fas fa-star text-warning me-2"></i>
                                    <strong>{{ $stats['most_used_role']->name }}</strong>
                                    es el rol más popular
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div>

                    <!-- Recomendaciones -->
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-lightbulb me-2"></i>Recomendaciones
                            </h6>
                        </div>
                        <div class="card-body">
                            @php
                                $recommendations = [];

                                if ($stats['total_roles'] == 0) {
                                    $recommendations[] = ['type' => 'warning', 'text' => 'Crea tu primer rol para comenzar a gestionar permisos'];
                                }

                                if ($stats['total_roles'] > 0 && $stats['roles_with_users'] == 0) {
                                    $recommendations[] = ['type' => 'info', 'text' => 'Asigna usuarios a los roles creados'];
                                }

                                if ($stats['total_roles'] > 10) {
                                    $recommendations[] = ['type' => 'primary', 'text' => 'Considera consolidar roles similares'];
                                }

                                if ($stats['permissions_by_module']->count() > 5) {
                                    $recommendations[] = ['type' => 'success', 'text' => 'Usa la matriz de permisos para una gestión visual'];
                                }

                                if (empty($recommendations)) {
                                    $recommendations[] = ['type' => 'success', 'text' => '¡Todo se ve bien! Sistema de roles funcionando correctamente'];
                                }
                            @endphp

                            @foreach($recommendations as $recommendation)
                            <div class="alert alert-{{ $recommendation['type'] }} py-2 px-3 mb-2">
                                <small>{{ $recommendation['text'] }}</small>
                            </div>
                            @endforeach

                            <div class="mt-3">
                                <h6 class="fw-bold mb-2">Acciones Rápidas:</h6>
                                <div class="d-grid gap-2">
                                    <a href="{{ route('role-management.create') }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-plus me-1"></i>Crear Rol
                                    </a>
                                    <a href="{{ route('role-management.matrix') }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-table me-1"></i>Matriz de Permisos
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla detallada (opcional, se puede expandir) -->
            <div class="card mt-4" id="detailedStats" style="display: none;">
                <div class="card-header bg-secondary text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-table me-2"></i>Estadísticas Detalladas
                    </h6>
                </div>
                <div class="card-body">
                    <!-- Aquí se podría agregar una tabla con estadísticas más detalladas -->
                    <p class="text-muted">Estadísticas detalladas disponibles próximamente...</p>
                </div>
            </div>

            <!-- Botón para mostrar/ocultar estadísticas detalladas -->
            <div class="text-center mt-3">
                <button type="button" class="btn btn-outline-secondary" onclick="toggleDetailedStats()">
                    <i class="fas fa-chevron-down me-1" id="toggleIcon"></i>
                    <span id="toggleText">Mostrar Estadísticas Detalladas</span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Datos para el gráfico
const moduleData = @json($stats['permissions_by_module']);
const moduleNames = Object.keys(moduleData);
const moduleCounts = Object.values(moduleData);

// Crear gráfico de barras
if (moduleNames.length > 0) {
    const ctx = document.getElementById('permissionsChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: moduleNames.map(name => name.charAt(0).toUpperCase() + name.slice(1)),
            datasets: [{
                label: 'Permisos por Módulo',
                data: moduleCounts,
                backgroundColor: [
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(255, 206, 86, 0.8)',
                    'rgba(75, 192, 192, 0.8)',
                    'rgba(153, 102, 255, 0.8)',
                    'rgba(255, 159, 64, 0.8)',
                    'rgba(201, 203, 207, 0.8)'
                ].slice(0, moduleNames.length),
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(201, 203, 207, 1)'
                ].slice(0, moduleNames.length),
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'Distribución de Permisos'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
}

// Función para actualizar estadísticas
function refreshStats() {
    location.reload();
}

// Función para mostrar/ocultar estadísticas detalladas
function toggleDetailedStats() {
    const detailedStats = document.getElementById('detailedStats');
    const toggleIcon = document.getElementById('toggleIcon');
    const toggleText = document.getElementById('toggleText');

    if (detailedStats.style.display === 'none') {
        detailedStats.style.display = 'block';
        toggleIcon.className = 'fas fa-chevron-up me-1';
        toggleText.textContent = 'Ocultar Estadísticas Detalladas';
    } else {
        detailedStats.style.display = 'none';
        toggleIcon.className = 'fas fa-chevron-down me-1';
        toggleText.textContent = 'Mostrar Estadísticas Detalladas';
    }
}

// Animaciones para las tarjetas de estadísticas
document.addEventListener('DOMContentLoaded', function() {
    // Animar números en las tarjetas
    const numberElements = document.querySelectorAll('.card-body h3');

    numberElements.forEach(element => {
        const finalNumber = parseInt(element.textContent);
        if (finalNumber > 0) {
            let currentNumber = 0;
            const increment = Math.ceil(finalNumber / 30);

            const timer = setInterval(() => {
                currentNumber += increment;
                if (currentNumber >= finalNumber) {
                    currentNumber = finalNumber;
                    clearInterval(timer);
                }
                element.textContent = currentNumber;
            }, 50);
        }
    });
});
</script>
@endpush
