<div class="widget-container" data-widget-id="{{ $widget->widget_id }}">
    <div class="widget-header">
        <h6 class="widget-title mb-0">
            <i class="fas fa-shopping-cart me-2"></i>
            Pedidos Pendientes
            @if(isset($data['total_pendientes']) && $data['total_pendientes'] > 0)
                <span class="badge bg-warning ms-2">{{ $data['total_pendientes'] }}</span>
            @endif
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
        @if(isset($data['pedidos_pendientes']) && count($data['pedidos_pendientes']) > 0)
            <div class="pedidos-summary mb-3">
                <div class="row g-2">
                    <div class="col-6">
                        <div class="summary-card urgent">
                            <div class="summary-number">{{ $data['urgentes'] ?? 0 }}</div>
                            <div class="summary-label">Urgentes</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="summary-card normal">
                            <div class="summary-number">{{ $data['normales'] ?? 0 }}</div>
                            <div class="summary-label">Normales</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pedidos-list">
                @foreach($data['pedidos_pendientes'] as $pedido)
                <div class="pedido-item {{ $pedido->prioridad ?? 'normal' }}">
                    <div class="pedido-header">
                        <div class="pedido-id">
                            <strong>#{{ $pedido->id }}</strong>
                            @if($pedido->prioridad == 'urgent')
                                <span class="badge bg-danger ms-1">Urgente</span>
                            @endif
                        </div>
                        <div class="pedido-fecha">
                            {{ $pedido->created_at ? $pedido->created_at->format('d/m H:i') : 'N/A' }}
                        </div>
                    </div>

                    <div class="pedido-details">
                        <div class="pedido-cliente">
                            <i class="fas fa-user me-1"></i>
                            {{ $pedido->cliente->nombre ?? $pedido->cliente_nombre ?? 'Cliente no especificado' }}
                        </div>

                        @if($pedido->items_count ?? $pedido->detalles_count)
                        <div class="pedido-items">
                            <i class="fas fa-list me-1"></i>
                            {{ $pedido->items_count ?? $pedido->detalles_count }} productos
                        </div>
                        @endif

                        @if($pedido->total)
                        <div class="pedido-total">
                            <i class="fas fa-dollar-sign me-1"></i>
                            ${{ number_format($pedido->total, 0) }}
                        </div>
                        @endif
                    </div>

                    <div class="pedido-actions">
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-outline-success btn-sm" title="Completar">
                                <i class="fas fa-check"></i>
                            </button>
                            <button class="btn btn-outline-primary btn-sm" title="Ver detalles">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-outline-secondary btn-sm" title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="widget-footer mt-3">
                <div class="row g-2">
                    <div class="col-8">
                        <a href="{{ route('pedidos.index') }}" class="btn btn-sm btn-outline-primary w-100">
                            <i class="fas fa-list me-1"></i>
                            Ver todos los pedidos
                        </a>
                    </div>
                    <div class="col-4">
                        <a href="{{ route('pedidos.create') }}" class="btn btn-sm btn-success w-100">
                            <i class="fas fa-plus"></i>
                            Nuevo
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-check-circle text-success mb-2"></i>
                <p class="text-muted mb-1">No hay pedidos pendientes</p>
                <small class="text-muted">Todos los pedidos están al día</small>
                <div class="mt-3">
                    <a href="{{ route('pedidos.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus me-1"></i>
                        Crear nuevo pedido
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
.pedidos-summary {
    border-bottom: 1px solid #e9ecef;
    padding-bottom: 1rem;
}

.summary-card {
    text-align: center;
    padding: 1rem 0.5rem;
    border-radius: 8px;
    border: 1px solid #e9ecef;
}

.summary-card.urgent {
    background: linear-gradient(135deg, #fff5f5, #fee);
    border-color: #f8d7da;
}

.summary-card.normal {
    background: linear-gradient(135deg, #f0fff4, #f0f8ff);
    border-color: #d1ecf1;
}

.summary-number {
    font-size: 1.5rem;
    font-weight: 700;
    line-height: 1;
}

.summary-card.urgent .summary-number {
    color: #dc3545;
}

.summary-card.normal .summary-number {
    color: #28a745;
}

.summary-label {
    font-size: 0.75rem;
    color: #6c757d;
    margin-top: 0.25rem;
}

.pedidos-list {
    max-height: 300px;
    overflow-y: auto;
}

.pedido-item {
    padding: 1rem;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    margin-bottom: 0.75rem;
    background: #fff;
    transition: all 0.2s ease;
}

.pedido-item:hover {
    border-color: #007bff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.pedido-item.urgent {
    border-left: 4px solid #dc3545;
    background: #fff9f9;
}

.pedido-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.5rem;
}

.pedido-id {
    color: #212529;
}

.pedido-fecha {
    font-size: 0.875rem;
    color: #6c757d;
}

.pedido-details {
    display: grid;
    gap: 0.25rem;
    margin-bottom: 0.75rem;
}

.pedido-cliente,
.pedido-items,
.pedido-total {
    font-size: 0.875rem;
    color: #6c757d;
    display: flex;
    align-items: center;
}

.pedido-cliente {
    font-weight: 500;
    color: #495057;
}

.pedido-actions {
    display: flex;
    justify-content: flex-end;
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
.pedidos-list::-webkit-scrollbar {
    width: 4px;
}

.pedidos-list::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 2px;
}

.pedidos-list::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 2px;
}

/* Responsive adjustments */
@media (max-width: 576px) {
    .pedido-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.25rem;
    }

    .pedido-actions {
        justify-content: center;
        margin-top: 0.5rem;
    }

    .summary-card {
        padding: 0.75rem 0.5rem;
    }

    .summary-number {
        font-size: 1.25rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-refresh cada 2 minutos
    const widgetId = '{{ $widget->widget_id }}';
    setInterval(() => {
        updatePedidosPendientes(widgetId);
    }, 120000);

    // Manejadores de eventos para los botones de acción
    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-outline-success')) {
            // Completar pedido
            const pedidoItem = e.target.closest('.pedido-item');
            if (pedidoItem) {
                const pedidoId = extractPedidoId(pedidoItem);
                if (pedidoId && confirm('¿Marcar este pedido como completado?')) {
                    completarPedido(pedidoId);
                }
            }
        }
    });
});

function extractPedidoId(pedidoElement) {
    const idElement = pedidoElement.querySelector('.pedido-id strong');
    if (idElement) {
        return idElement.textContent.replace('#', '');
    }
    return null;
}

function completarPedido(pedidoId) {
    fetch(`/pedidos/${pedidoId}/completar`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Actualizar widget
            const widgetId = '{{ $widget->widget_id }}';
            updatePedidosPendientes(widgetId);
        }
    })
    .catch(error => console.error('Error completando pedido:', error));
}

function updatePedidosPendientes(widgetId) {
    const widget = document.querySelector(`[data-widget-id="${widgetId}"]`);
    if (!widget) return;

    fetch(`/dashboard/widgets/${widgetId}/data`)
        .then(response => response.json())
        .then(data => {
            if (data.html) {
                widget.querySelector('.widget-content').innerHTML = data.html;
            }
        })
        .catch(error => console.error('Error updating pedidos pendientes:', error));
}
</script>
