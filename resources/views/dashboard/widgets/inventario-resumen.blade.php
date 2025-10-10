<div class="widget-container" data-widget-id="{{ $widget->widget_id }}">
    <div class="widget-header">
        <h6 class="widget-title mb-0">
            <i class="fas fa-warehouse me-2"></i>
            Resumen de Inventario
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
        <div class="inventory-overview mb-3">
            <div class="row g-3">
                <div class="col-6">
                    <div class="overview-card total">
                        <div class="card-icon">
                            <i class="fas fa-boxes"></i>
                        </div>
                        <div class="card-info">
                            <div class="card-number">{{ $data['total_productos'] ?? 0 }}</div>
                            <div class="card-label">Total Productos</div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="overview-card value">
                        <div class="card-icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="card-info">
                            <div class="card-number">${{ number_format($data['valor_total'] ?? 0, 0) }}</div>
                            <div class="card-label">Valor Total</div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="overview-card low-stock">
                        <div class="card-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="card-info">
                            <div class="card-number">{{ $data['productos_bajo_stock'] ?? 0 }}</div>
                            <div class="card-label">Stock Bajo</div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="overview-card out-stock">
                        <div class="card-icon">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <div class="card-info">
                            <div class="card-number">{{ $data['productos_sin_stock'] ?? 0 }}</div>
                            <div class="card-label">Sin Stock</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(isset($data['categorias_resumen']) && count($data['categorias_resumen']) > 0)
        <div class="categories-section">
            <h6 class="section-title">
                <i class="fas fa-tags me-2"></i>
                Por Categorías
            </h6>
            <div class="categories-list">
                @foreach($data['categorias_resumen'] as $categoria)
                <div class="category-item">
                    <div class="category-info">
                        <div class="category-name">{{ $categoria->nombre ?? 'Sin categoría' }}</div>
                        <div class="category-stats">
                            <span class="stat-item">
                                <i class="fas fa-box me-1"></i>
                                {{ $categoria->productos_count ?? 0 }} productos
                            </span>
                            @if($categoria->stock_total)
                            <span class="stat-item">
                                <i class="fas fa-cubes me-1"></i>
                                {{ $categoria->stock_total }} unidades
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="category-status">
                        @if($categoria->productos_bajo_stock > 0)
                            <span class="badge bg-warning">{{ $categoria->productos_bajo_stock }} bajo stock</span>
                        @else
                            <span class="badge bg-success">OK</span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        @if(isset($data['movimientos_recientes']) && count($data['movimientos_recientes']) > 0)
        <div class="recent-movements">
            <h6 class="section-title">
                <i class="fas fa-exchange-alt me-2"></i>
                Movimientos Recientes
            </h6>
            <div class="movements-list">
                @foreach($data['movimientos_recientes']->take(3) as $movimiento)
                <div class="movement-item">
                    <div class="movement-type {{ $movimiento->tipo }}">
                        <i class="fas {{ $movimiento->tipo == 'entrada' ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i>
                    </div>
                    <div class="movement-info">
                        <div class="movement-product">{{ $movimiento->producto->nombre ?? 'N/A' }}</div>
                        <div class="movement-details">
                            {{ $movimiento->tipo == 'entrada' ? '+' : '-' }}{{ $movimiento->cantidad }}
                            <span class="movement-time">{{ $movimiento->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <div class="widget-footer mt-3">
            <div class="row g-2">
                <div class="col-4">
                    <a href="{{ route('inventario.index') }}" class="btn btn-sm btn-outline-primary w-100">
                        <i class="fas fa-list"></i>
                        <span class="d-none d-sm-inline ms-1">Lista</span>
                    </a>
                </div>
                <div class="col-4">
                    <a href="{{ route('inventario.create') }}" class="btn btn-sm btn-success w-100">
                        <i class="fas fa-plus"></i>
                        <span class="d-none d-sm-inline ms-1">Nuevo</span>
                    </a>
                </div>
                <div class="col-4">
                    <a href="{{ route('reportes.inventario') }}" class="btn btn-sm btn-outline-info w-100">
                        <i class="fas fa-chart-bar"></i>
                        <span class="d-none d-sm-inline ms-1">Reporte</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.inventory-overview {
    border-bottom: 1px solid #e9ecef;
    padding-bottom: 1rem;
}

.overview-card {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem;
    border-radius: 8px;
    transition: all 0.2s ease;
    cursor: pointer;
}

.overview-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.overview-card.total {
    background: linear-gradient(135deg, #007bff, #0056b3);
    color: white;
}

.overview-card.value {
    background: linear-gradient(135deg, #28a745, #1e7e34);
    color: white;
}

.overview-card.low-stock {
    background: linear-gradient(135deg, #ffc107, #e0a800);
    color: #212529;
}

.overview-card.out-stock {
    background: linear-gradient(135deg, #dc3545, #bd2130);
    color: white;
}

.card-icon {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    font-size: 1rem;
    flex-shrink: 0;
}

.overview-card.low-stock .card-icon {
    background: rgba(0, 0, 0, 0.1);
}

.card-info {
    flex: 1;
}

.card-number {
    font-size: 1.25rem;
    font-weight: 700;
    line-height: 1;
    margin-bottom: 0.25rem;
}

.card-label {
    font-size: 0.75rem;
    opacity: 0.9;
}

.section-title {
    color: #495057;
    margin-bottom: 0.75rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid #f1f1f1;
}

.categories-list {
    max-height: 150px;
    overflow-y: auto;
    margin-bottom: 1rem;
}

.category-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.5rem 0;
    border-bottom: 1px solid #f8f9fa;
}

.category-item:last-child {
    border-bottom: none;
}

.category-info {
    flex: 1;
}

.category-name {
    font-weight: 600;
    font-size: 0.875rem;
    color: #212529;
    margin-bottom: 0.25rem;
}

.category-stats {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.stat-item {
    font-size: 0.75rem;
    color: #6c757d;
}

.category-status .badge {
    font-size: 0.7rem;
}

.movements-list {
    max-height: 120px;
    overflow-y: auto;
}

.movement-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.5rem 0;
    border-bottom: 1px solid #f8f9fa;
}

.movement-item:last-child {
    border-bottom: none;
}

.movement-type {
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    font-size: 0.8rem;
    flex-shrink: 0;
}

.movement-type.entrada {
    background: #d4edda;
    color: #155724;
}

.movement-type.salida {
    background: #f8d7da;
    color: #721c24;
}

.movement-info {
    flex: 1;
    min-width: 0;
}

.movement-product {
    font-weight: 500;
    font-size: 0.8rem;
    color: #212529;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.movement-details {
    font-size: 0.75rem;
    color: #6c757d;
    display: flex;
    gap: 0.5rem;
}

.movement-time {
    opacity: 0.8;
}

.widget-footer {
    border-top: 1px solid #e9ecef;
    padding-top: 1rem;
}

/* Scrollbar styling */
.categories-list::-webkit-scrollbar,
.movements-list::-webkit-scrollbar {
    width: 3px;
}

.categories-list::-webkit-scrollbar-track,
.movements-list::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 2px;
}

.categories-list::-webkit-scrollbar-thumb,
.movements-list::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 2px;
}

/* Responsive adjustments */
@media (max-width: 576px) {
    .overview-card {
        padding: 0.5rem;
    }

    .card-icon {
        width: 28px;
        height: 28px;
    }

    .card-number {
        font-size: 1.1rem;
    }

    .category-stats {
        flex-direction: column;
        gap: 0.25rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-refresh cada 5 minutos
    const widgetId = '{{ $widget->widget_id }}';
    setInterval(() => {
        updateInventarioResumen(widgetId);
    }, 300000);
});

function updateInventarioResumen(widgetId) {
    const widget = document.querySelector(`[data-widget-id="${widgetId}"]`);
    if (!widget) return;

    fetch(`/dashboard/widgets/${widgetId}/data`)
        .then(response => response.json())
        .then(data => {
            if (data.html) {
                widget.querySelector('.widget-content').innerHTML = data.html;
            }
        })
        .catch(error => console.error('Error updating inventario resumen:', error));
}
</script>
