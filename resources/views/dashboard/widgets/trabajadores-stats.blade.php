<div class="widget-container" data-widget-id="{{ $widget->widget_id }}">
    <div class="widget-header">
        <h6 class="widget-title mb-0">
            <i class="fas fa-users me-2"></i>
            Estadísticas de Trabajadores
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
        <div class="stats-grid mb-3">
            <div class="row g-3">
                <div class="col-6">
                    <div class="stat-card active">
                        <div class="stat-icon">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <div class="stat-info">
                            <div class="stat-number">{{ $data['trabajadores_activos'] ?? 0 }}</div>
                            <div class="stat-label">Activos Hoy</div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="stat-card total">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-info">
                            <div class="stat-number">{{ $data['total_trabajadores'] ?? 0 }}</div>
                            <div class="stat-label">Total</div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="stat-card consumo">
                        <div class="stat-icon">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <div class="stat-info">
                            <div class="stat-number">{{ $data['consumos_hoy'] ?? 0 }}</div>
                            <div class="stat-label">Consumos</div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="stat-card average">
                        <div class="stat-icon">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <div class="stat-info">
                            <div class="stat-number">{{ number_format($data['promedio_consumo'] ?? 0, 1) }}</div>
                            <div class="stat-label">Promedio</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(isset($data['top_trabajadores']) && count($data['top_trabajadores']) > 0)
        <div class="top-workers">
            <h6 class="section-title">
                <i class="fas fa-trophy me-2"></i>
                Top Trabajadores ({{ $config['period'] ?? 'Hoy' }})
            </h6>
            <div class="workers-list">
                @foreach($data['top_trabajadores'] as $index => $trabajador)
                <div class="worker-item">
                    <div class="worker-rank">
                        @if($index == 0)
                            <i class="fas fa-trophy text-warning"></i>
                        @elseif($index == 1)
                            <i class="fas fa-medal text-secondary"></i>
                        @elseif($index == 2)
                            <i class="fas fa-award text-warning"></i>
                        @else
                            <span class="rank-number">{{ $index + 1 }}</span>
                        @endif
                    </div>
                    <div class="worker-info">
                        <div class="worker-name">{{ $trabajador->nombre ?? 'N/A' }}</div>
                        <div class="worker-details">
                            <span class="worker-area">{{ $trabajador->area ?? 'Sin área' }}</span>
                            <span class="worker-consumos">{{ $trabajador->consumos_count ?? 0 }} consumos</span>
                        </div>
                    </div>
                    <div class="worker-amount">
                        @if($trabajador->total_consumido)
                            <span class="amount-value">${{ number_format($trabajador->total_consumido, 0) }}</span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <div class="widget-footer mt-3">
            <div class="row g-2">
                <div class="col-6">
                    <a href="{{ route('trabajadores.index') }}" class="btn btn-sm btn-outline-primary w-100">
                        <i class="fas fa-users me-1"></i>
                        Trabajadores
                    </a>
                </div>
                <div class="col-6">
                    <a href="{{ route('reportes.trabajadores') }}" class="btn btn-sm btn-outline-success w-100">
                        <i class="fas fa-chart-line me-1"></i>
                        Reportes
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.stats-grid {
    margin-bottom: 1rem;
}

.stat-card {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem;
    border-radius: 10px;
    transition: all 0.2s ease;
    cursor: pointer;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.stat-card.active {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
}

.stat-card.total {
    background: linear-gradient(135deg, #007bff, #6610f2);
    color: white;
}

.stat-card.consumo {
    background: linear-gradient(135deg, #fd7e14, #e83e8c);
    color: white;
}

.stat-card.average {
    background: linear-gradient(135deg, #6f42c1, #6610f2);
    color: white;
}

.stat-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    font-size: 1.2rem;
}

.stat-info {
    flex: 1;
}

.stat-number {
    font-size: 1.5rem;
    font-weight: 700;
    line-height: 1;
    margin-bottom: 0.25rem;
}

.stat-label {
    font-size: 0.8rem;
    opacity: 0.9;
}

.section-title {
    color: #495057;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid #e9ecef;
}

.workers-list {
    max-height: 200px;
    overflow-y: auto;
}

.worker-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem;
    margin-bottom: 0.5rem;
    background: #f8f9fa;
    border-radius: 8px;
    transition: background-color 0.2s ease;
}

.worker-item:hover {
    background: #e9ecef;
}

.worker-rank {
    width: 32px;
    text-align: center;
    font-weight: 600;
}

.rank-number {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 24px;
    height: 24px;
    background: #6c757d;
    color: white;
    border-radius: 50%;
    font-size: 0.8rem;
}

.worker-info {
    flex: 1;
    min-width: 0;
}

.worker-name {
    font-weight: 600;
    font-size: 0.875rem;
    color: #212529;
    margin-bottom: 0.25rem;
}

.worker-details {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.worker-area,
.worker-consumos {
    font-size: 0.75rem;
    color: #6c757d;
}

.worker-area {
    background: #e9ecef;
    padding: 0.125rem 0.5rem;
    border-radius: 12px;
}

.worker-amount {
    font-weight: 600;
    color: #28a745;
    font-size: 0.875rem;
}

.widget-footer {
    border-top: 1px solid #e9ecef;
    padding-top: 1rem;
}

/* Scrollbar styling */
.workers-list::-webkit-scrollbar {
    width: 4px;
}

.workers-list::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 2px;
}

.workers-list::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 2px;
}

/* Responsive adjustments */
@media (max-width: 576px) {
    .stat-card {
        padding: 0.75rem;
    }

    .stat-icon {
        width: 32px;
        height: 32px;
    }

    .stat-number {
        font-size: 1.25rem;
    }

    .worker-item {
        flex-direction: column;
        text-align: center;
        gap: 0.5rem;
    }

    .worker-details {
        justify-content: center;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-refresh cada 3 minutos
    const widgetId = '{{ $widget->widget_id }}';
    setInterval(() => {
        updateTrabajadoresStats(widgetId);
    }, 180000);

    // Click handlers para las tarjetas de estadísticas
    document.querySelectorAll('.stat-card').forEach(card => {
        card.addEventListener('click', function() {
            // Opcional: añadir funcionalidad al hacer clic en las estadísticas
        });
    });
});

function updateTrabajadoresStats(widgetId) {
    const widget = document.querySelector(`[data-widget-id="${widgetId}"]`);
    if (!widget) return;

    fetch(`/dashboard/widgets/${widgetId}/data`)
        .then(response => response.json())
        .then(data => {
            if (data.html) {
                widget.querySelector('.widget-content').innerHTML = data.html;
            }
        })
        .catch(error => console.error('Error updating trabajadores stats:', error));
}
</script>
