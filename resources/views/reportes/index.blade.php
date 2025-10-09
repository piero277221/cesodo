@extends('layouts.app')

@section('title', 'Reportes - Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header con título -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">
                    <i class="fas fa-chart-bar text-primary me-2"></i>
                    Dashboard de Reportes
                </h2>
                <div class="btn-group" role="group">
                    <a href="{{ route('reportes.consumos') }}" class="btn btn-outline-primary">
                        <i class="fas fa-utensils me-1"></i>
                        Consumos
                    </a>
                    <a href="{{ route('reportes.inventario') }}" class="btn btn-outline-success">
                        <i class="fas fa-boxes me-1"></i>
                        Inventario
                    </a>
                    <a href="{{ route('reportes.proveedores') }}" class="btn btn-outline-info">
                        <i class="fas fa-truck me-1"></i>
                        Proveedores
                    </a>
                </div>
            </div>

            <!-- Estadísticas Generales -->
            <div class="row mb-4">
                <div class="col-md-2 col-sm-4 col-6">
                    <div class="card text-center bg-primary text-white shadow-sm">
                        <div class="card-body">
                            <i class="fas fa-utensils fa-2x mb-2"></i>
                            <h4 class="mb-0">{{ number_format($stats['total_consumos']) }}</h4>
                            <small>Total Consumos</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-4 col-6">
                    <div class="card text-center bg-success text-white shadow-sm">
                        <div class="card-body">
                            <i class="fas fa-box fa-2x mb-2"></i>
                            <h4 class="mb-0">{{ number_format($stats['total_productos']) }}</h4>
                            <small>Total Productos</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-4 col-6">
                    <div class="card text-center bg-info text-white shadow-sm">
                        <div class="card-body">
                            <i class="fas fa-users fa-2x mb-2"></i>
                            <h4 class="mb-0">{{ number_format($stats['total_trabajadores']) }}</h4>
                            <small>Total Trabajadores</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-4 col-6">
                    <div class="card text-center bg-warning text-white shadow-sm">
                        <div class="card-body">
                            <i class="fas fa-truck fa-2x mb-2"></i>
                            <h4 class="mb-0">{{ number_format($stats['total_proveedores']) }}</h4>
                            <small>Total Proveedores</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-4 col-6">
                    <div class="card text-center bg-secondary text-white shadow-sm">
                        <div class="card-body">
                            <i class="fas fa-shopping-cart fa-2x mb-2"></i>
                            <h4 class="mb-0">{{ number_format($stats['total_pedidos']) }}</h4>
                            <small>Total Pedidos</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Gráfico de Consumos por Mes -->
                <div class="col-lg-8 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-chart-line me-2"></i>
                                Consumos por Mes (Últimos 12 meses)
                            </h5>
                        </div>
                        <div class="card-body">
                            <canvas id="consumosChart" height="100"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Top Tipos de Comida -->
                <div class="col-lg-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-utensils me-2"></i>
                                Top 5 Tipos de Comida Más Consumidos
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                @forelse($topTiposComida as $index => $tipo)
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <small class="badge bg-primary me-2">{{ $index + 1 }}</small>
                                            <strong>{{ ucfirst($tipo->tipo_comida) }}</strong>
                                        </div>
                                        <span class="badge bg-success rounded-pill">
                                            {{ number_format($tipo->total_consumos) }}
                                        </span>
                                    </div>
                                @empty
                                    <div class="list-group-item text-center text-muted">
                                        <i class="fas fa-info-circle me-2"></i>
                                        No hay datos de consumos
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Top Trabajadores -->
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-user-tie me-2"></i>
                                Top 5 Trabajadores con Más Consumos
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                @forelse($topTrabajadores as $index => $trabajador)
                                    <div class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <small class="badge bg-info me-2">{{ $index + 1 }}</small>
                                                <strong>{{ $trabajador->apellidos }}, {{ $trabajador->nombres }}</strong>
                                            </div>
                                <div class="text-end">
                                                <span class="badge bg-primary">{{ $trabajador->total_consumos }} consumos</span>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="list-group-item text-center text-muted">
                                        <i class="fas fa-info-circle me-2"></i>
                                        No hay datos de consumos por trabajador
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Productos con Stock Bajo -->
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-warning text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Productos con Stock Bajo
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                @forelse($productosStockBajo as $producto)
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ $producto->nombre }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $producto->categoria->nombre ?? 'Sin categoría' }}</small>
                                        </div>
                                        <span class="badge bg-{{ $producto->stock_actual == 0 ? 'danger' : 'warning' }} rounded-pill">
                                            {{ $producto->stock_actual }} {{ $producto->unidad_medida }}
                                        </span>
                                    </div>
                                @empty
                                    <div class="list-group-item text-center text-success">
                                        <i class="fas fa-check-circle me-2"></i>
                                        Todos los productos tienen stock adecuado
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Datos de consumos por mes
    const consumosData = @json($consumosPorMes);

    // Preparar datos para el gráfico
    const labels = consumosData.map(item => {
        const meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun',
                      'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
        return meses[item.mes - 1] + ' ' + item.año;
    }).reverse();

    const datos = consumosData.map(item => item.total).reverse();

    // Crear gráfico
    const ctx = document.getElementById('consumosChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Número de Consumos',
                data: datos,
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            scales: {
                x: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Mes'
                    }
                },
                y: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Número de Consumos'
                    }
                }
            }
        }
    });
});
</script>
@endsection
