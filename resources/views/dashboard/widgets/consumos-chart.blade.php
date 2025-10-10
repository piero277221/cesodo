<div class="widget-container" data-widget-id="{{ $widget->widget_id }}">
    <div class="widget-header">
        <h6 class="widget-title mb-0">
            <i class="fas fa-chart-line me-2"></i>
            Gráfico de Consumos
        </h6>
        <div class="widget-controls">
            <button class="btn btn-sm btn-outline-secondary widget-config" title="Configurar">
                <i class="fas fa-cog"></i>
            </button>
            <button class="btn btn-sm btn-outline-secondary widget-collapse" title="Minimizar">
                <i class="fas fa-minus"></i>
            </button>
            <button class="btn btn-sm btn-outline-danger widget-remove" title="Eliminar">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>

    <div class="widget-content">
        <div class="chart-container">
            <canvas id="consumosChart{{ $widget->widget_id }}" width="400" height="200"></canvas>
        </div>

        <div class="chart-legend mt-3">
            <div class="row">
                <div class="col-6">
                    <div class="legend-item">
                        <span class="legend-color bg-primary"></span>
                        <span class="legend-label">Hoy</span>
                        <span class="legend-value" id="todayValue{{ $widget->widget_id }}">{{ $data['today'] ?? 0 }}</span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="legend-item">
                        <span class="legend-color bg-success"></span>
                        <span class="legend-label">Promedio</span>
                        <span class="legend-value" id="avgValue{{ $widget->widget_id }}">{{ number_format($data['average'] ?? 0, 1) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.chart-container {
    position: relative;
    height: 200px;
    padding: 1rem 0;
}

.chart-legend {
    border-top: 1px solid #e9ecef;
    padding-top: 1rem;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.legend-color {
    width: 12px;
    height: 12px;
    border-radius: 2px;
}

.legend-label {
    font-size: 0.875rem;
    color: #6c757d;
}

.legend-value {
    font-weight: 600;
    font-size: 0.875rem;
    margin-left: auto;
}

.chart-loading {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 200px;
    color: #6c757d;
}

/* Responsive adjustments */
@media (max-width: 576px) {
    .chart-container {
        height: 150px;
    }

    .legend-item {
        font-size: 0.8rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chartId = 'consumosChart{{ $widget->widget_id }}';
    const chartElement = document.getElementById(chartId);

    if (chartElement && typeof Chart !== 'undefined') {
        // Datos del gráfico desde el backend
        const chartData = @json($data['chart_data'] ?? []);
        const labels = @json($data['labels'] ?? []);

        const ctx = chartElement.getContext('2d');
        const chart = new Chart(ctx, {
            type: '{{ $config['chart_type'] ?? 'line' }}',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Consumos',
                    data: chartData,
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13, 110, 253, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });

        // Actualizar cada 5 minutos
        setInterval(() => {
            updateChartData(chart, '{{ $widget->widget_id }}');
        }, 300000);
    } else {
        // Mostrar mensaje de carga si Chart.js no está disponible
        chartElement.parentElement.innerHTML = '<div class="chart-loading"><i class="fas fa-chart-line me-2"></i>Cargando gráfico...</div>';
    }
});

function updateChartData(chart, widgetId) {
    // Función para actualizar datos del gráfico vía AJAX
    fetch(`/dashboard/widgets/${widgetId}/data`)
        .then(response => response.json())
        .then(data => {
            if (data.chart_data && data.labels) {
                chart.data.labels = data.labels;
                chart.data.datasets[0].data = data.chart_data;
                chart.update();

                // Actualizar leyenda
                document.getElementById(`todayValue${widgetId}`).textContent = data.today || 0;
                document.getElementById(`avgValue${widgetId}`).textContent = (data.average || 0).toFixed(1);
            }
        })
        .catch(error => console.error('Error updating chart:', error));
}
</script>
