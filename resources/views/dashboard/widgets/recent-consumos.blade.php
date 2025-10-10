<div class="widget-container" data-widget-id="{{ $widget->widget_id }}">
    <div class="widget-header">
        <h6 class="widget-title mb-0">
            <i class="fas fa-clock me-2"></i>
            Consumos Recientes
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
        @if(isset($data['recent_consumos']) && count($data['recent_consumos']) > 0)
            <div class="consumos-list">
                @foreach($data['recent_consumos'] as $consumo)
                <div class="consumo-item">
                    <div class="consumo-info">
                        <div class="consumo-header">
                            <span class="consumo-trabajador">{{ $consumo->trabajador->nombre ?? 'N/A' }}</span>
                            <span class="consumo-time">{{ $consumo->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="consumo-details">
                            <div class="consumo-menu">
                                <i class="fas fa-utensils me-1"></i>
                                {{ $consumo->menu->nombre ?? 'Menú no especificado' }}
                            </div>
                            <div class="consumo-estado">
                                <span class="badge {{ $consumo->estado == 'completado' ? 'bg-success' : ($consumo->estado == 'pendiente' ? 'bg-warning' : 'bg-secondary') }}">
                                    {{ ucfirst($consumo->estado) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @if($consumo->total)
                    <div class="consumo-amount">
                        <span class="amount-value">${{ number_format($consumo->total, 0) }}</span>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>

            <div class="widget-footer mt-3">
                <a href="{{ route('consumos.index') }}" class="btn btn-sm btn-outline-primary w-100">
                    <i class="fas fa-list me-1"></i>
                    Ver todos los consumos
                </a>
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-clock text-muted mb-2"></i>
                <p class="text-muted mb-0">No hay consumos recientes</p>
            </div>
        @endif
    </div>
</div>

<style>
.consumos-list {
    max-height: 300px;
    overflow-y: auto;
}

.consumo-item {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    padding: 0.75rem 0;
    border-bottom: 1px solid #f8f9fa;
    transition: background-color 0.2s ease;
}

.consumo-item:last-child {
    border-bottom: none;
}

.consumo-item:hover {
    background-color: #f8f9fa;
    margin: 0 -1rem;
    padding-left: 1rem;
    padding-right: 1rem;
}

.consumo-info {
    flex: 1;
    min-width: 0;
}

.consumo-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 0.25rem;
}

.consumo-trabajador {
    font-weight: 600;
    color: #212529;
    font-size: 0.875rem;
}

.consumo-time {
    font-size: 0.75rem;
    color: #6c757d;
}

.consumo-details {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.5rem;
}

.consumo-menu {
    font-size: 0.8rem;
    color: #6c757d;
    flex: 1;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.consumo-estado .badge {
    font-size: 0.7rem;
}

.consumo-amount {
    margin-left: 1rem;
}

.amount-value {
    font-weight: 600;
    color: #198754;
    font-size: 0.875rem;
}

.empty-state {
    text-align: center;
    padding: 2rem 1rem;
}

.empty-state i {
    font-size: 2rem;
    display: block;
}

.widget-footer {
    border-top: 1px solid #e9ecef;
    padding-top: 1rem;
}

/* Scrollbar styling */
.consumos-list::-webkit-scrollbar {
    width: 4px;
}

.consumos-list::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 2px;
}

.consumos-list::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 2px;
}

.consumos-list::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

/* Responsive adjustments */
@media (max-width: 576px) {
    .consumo-item {
        flex-direction: column;
        align-items: stretch;
    }

    .consumo-amount {
        margin-left: 0;
        margin-top: 0.5rem;
        text-align: right;
    }

    .consumo-details {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.25rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-refresh cada 2 minutos
    const widgetId = '{{ $widget->widget_id }}';
    setInterval(() => {
        updateRecentConsumos(widgetId);
    }, 120000);
});

function updateRecentConsumos(widgetId) {
    const widget = document.querySelector(`[data-widget-id="${widgetId}"]`);
    if (!widget) return;

    fetch(`/dashboard/widgets/${widgetId}/data`)
        .then(response => response.json())
        .then(data => {
            // Aquí se actualizaría el contenido del widget
            // Por simplicidad, recargamos el widget completo
            if (data.html) {
                widget.querySelector('.widget-content').innerHTML = data.html;
            }
        })
        .catch(error => console.error('Error updating recent consumos:', error));
}
</script>
