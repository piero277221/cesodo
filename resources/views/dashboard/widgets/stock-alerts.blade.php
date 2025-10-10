<div class="widget-container" data-widget-id="{{ $widget->widget_id }}">
    <div class="widget-header">
        <h6 class="widget-title mb-0">
            <i class="fas fa-exclamation-triangle me-2 text-warning"></i>
            Alertas de Stock
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
        @if(isset($data['stock_alerts']) && count($data['stock_alerts']) > 0)
            <div class="alerts-summary mb-3">
                <div class="row g-2">
                    <div class="col-4">
                        <div class="alert-stat critical">
                            <div class="stat-number">{{ $data['critical_count'] ?? 0 }}</div>
                            <div class="stat-label">Crítico</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="alert-stat warning">
                            <div class="stat-number">{{ $data['warning_count'] ?? 0 }}</div>
                            <div class="stat-label">Advertencia</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="alert-stat info">
                            <div class="stat-number">{{ $data['info_count'] ?? 0 }}</div>
                            <div class="stat-label">Info</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="alerts-list">
                @foreach($data['stock_alerts'] as $alert)
                <div class="alert-item {{ $alert->priority ?? 'info' }}">
                    <div class="alert-icon">
                        <i class="fas {{ $alert->priority == 'critical' ? 'fa-times-circle' : ($alert->priority == 'warning' ? 'fa-exclamation-circle' : 'fa-info-circle') }}"></i>
                    </div>
                    <div class="alert-content">
                        <div class="alert-title">{{ $alert->producto ?? $alert->name ?? 'Producto' }}</div>
                        <div class="alert-description">
                            Stock actual: <strong>{{ $alert->stock_actual ?? 0 }}</strong>
                            @if($alert->stock_minimo)
                                | Mínimo: <strong>{{ $alert->stock_minimo }}</strong>
                            @endif
                        </div>
                        <div class="alert-category">
                            <span class="badge bg-light text-dark">{{ $alert->categoria ?? 'General' }}</span>
                        </div>
                    </div>
                    <div class="alert-actions">
                        <button class="btn btn-sm btn-outline-primary" onclick="viewProduct({{ $alert->id }})">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="widget-footer mt-3">
                <a href="{{ route('inventario.index') }}" class="btn btn-sm btn-outline-primary w-100">
                    <i class="fas fa-warehouse me-1"></i>
                    Ir a Inventario
                </a>
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-check-circle text-success mb-2"></i>
                <p class="text-muted mb-0">No hay alertas de stock</p>
                <small class="text-muted">Todos los productos tienen stock suficiente</small>
            </div>
        @endif
    </div>
</div>

<style>
.alerts-summary {
    border-bottom: 1px solid #e9ecef;
    padding-bottom: 1rem;
}

.alert-stat {
    text-align: center;
    padding: 0.75rem 0.5rem;
    border-radius: 8px;
    border: 1px solid #e9ecef;
}

.alert-stat.critical {
    background: linear-gradient(135deg, #fee, #fdd);
    border-color: #f8d7da;
}

.alert-stat.warning {
    background: linear-gradient(135deg, #fff3cd, #fef5d7);
    border-color: #ffeaa7;
}

.alert-stat.info {
    background: linear-gradient(135deg, #d1ecf1, #d7f1f9);
    border-color: #b8daff;
}

.stat-number {
    font-size: 1.25rem;
    font-weight: 700;
    line-height: 1;
}

.stat-label {
    font-size: 0.75rem;
    color: #6c757d;
    margin-top: 0.25rem;
}

.alerts-list {
    max-height: 250px;
    overflow-y: auto;
    margin: 1rem 0;
}

.alert-item {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    padding: 0.75rem;
    border-radius: 8px;
    margin-bottom: 0.5rem;
    border-left: 4px solid #6c757d;
    background: #f8f9fa;
    transition: all 0.2s ease;
}

.alert-item:hover {
    transform: translateX(4px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.alert-item.critical {
    border-left-color: #dc3545;
    background: #fff5f5;
}

.alert-item.warning {
    border-left-color: #ffc107;
    background: #fffdf0;
}

.alert-item.info {
    border-left-color: #17a2b8;
    background: #f0fdff;
}

.alert-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    flex-shrink: 0;
}

.alert-item.critical .alert-icon {
    color: #dc3545;
    background: rgba(220, 53, 69, 0.1);
}

.alert-item.warning .alert-icon {
    color: #ffc107;
    background: rgba(255, 193, 7, 0.1);
}

.alert-item.info .alert-icon {
    color: #17a2b8;
    background: rgba(23, 162, 184, 0.1);
}

.alert-content {
    flex: 1;
    min-width: 0;
}

.alert-title {
    font-weight: 600;
    font-size: 0.875rem;
    color: #212529;
    margin-bottom: 0.25rem;
}

.alert-description {
    font-size: 0.8rem;
    color: #6c757d;
    margin-bottom: 0.25rem;
}

.alert-category {
    margin-top: 0.25rem;
}

.alert-category .badge {
    font-size: 0.7rem;
}

.alert-actions {
    flex-shrink: 0;
}

.empty-state {
    text-align: center;
    padding: 2rem 1rem;
}

.empty-state i {
    font-size: 2.5rem;
    display: block;
}

.widget-footer {
    border-top: 1px solid #e9ecef;
    padding-top: 1rem;
}

/* Scrollbar styling */
.alerts-list::-webkit-scrollbar {
    width: 4px;
}

.alerts-list::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 2px;
}

.alerts-list::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 2px;
}

/* Responsive adjustments */
@media (max-width: 576px) {
    .alert-item {
        flex-direction: column;
        text-align: center;
    }

    .alert-actions {
        align-self: stretch;
    }

    .alerts-summary .row {
        --bs-gutter-x: 0.5rem;
    }
}
</style>

<script>
function viewProduct(productId) {
    // Función para ver detalles del producto
    window.location.href = `/inventario/${productId}`;
}

document.addEventListener('DOMContentLoaded', function() {
    // Auto-refresh cada 5 minutos
    const widgetId = '{{ $widget->widget_id }}';
    setInterval(() => {
        updateStockAlerts(widgetId);
    }, 300000);
});

function updateStockAlerts(widgetId) {
    const widget = document.querySelector(`[data-widget-id="${widgetId}"]`);
    if (!widget) return;

    fetch(`/dashboard/widgets/${widgetId}/data`)
        .then(response => response.json())
        .then(data => {
            if (data.html) {
                widget.querySelector('.widget-content').innerHTML = data.html;
            }
        })
        .catch(error => console.error('Error updating stock alerts:', error));
}
</script>
