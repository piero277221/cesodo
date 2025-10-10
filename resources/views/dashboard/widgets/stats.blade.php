<div class="widget-container" data-widget-id="{{ $widget->widget_id }}">
    <div class="widget-header">
        <h6 class="widget-title">
            <i class="{{ $widget->widgetType->icon }} me-2"></i>
            {{ $widget->display_title }}
        </h6>
        <div class="widget-actions">
            @if(!$widget->is_collapsed)
            <button class="btn btn-sm btn-outline-secondary widget-refresh" title="Actualizar">
                <i class="fas fa-sync-alt"></i>
            </button>
            @endif
            <button class="btn btn-sm btn-outline-secondary widget-config" title="Configurar">
                <i class="fas fa-cog"></i>
            </button>
            <button class="btn btn-sm btn-outline-secondary widget-collapse" title="{{ $widget->is_collapsed ? 'Expandir' : 'Colapsar' }}">
                <i class="fas fa-{{ $widget->is_collapsed ? 'expand' : 'compress' }}"></i>
            </button>
            <button class="btn btn-sm btn-outline-danger widget-remove" title="Eliminar">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>

    @if(!$widget->is_collapsed)
    <div class="widget-content">
        @if($data)
            <div class="row">
                @if($config['show_consumos'] ?? true)
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="stat-card bg-primary text-white">
                        <div class="stat-icon">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <div class="stat-info">
                            <div class="stat-label">Consumos Hoy</div>
                            <div class="stat-value">{{ $data['consumos_hoy'] }}</div>
                        </div>
                    </div>
                </div>
                @endif

                @if($config['show_trabajadores'] ?? true)
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="stat-card bg-success text-white">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-info">
                            <div class="stat-label">Trabajadores Activos</div>
                            <div class="stat-value">{{ $data['trabajadores_activos'] }}</div>
                        </div>
                    </div>
                </div>
                @endif

                @if($config['show_stock'] ?? true)
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="stat-card bg-warning text-white">
                        <div class="stat-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="stat-info">
                            <div class="stat-label">Stock Bajo</div>
                            <div class="stat-value">{{ $data['productos_stock_bajo'] }}</div>
                        </div>
                    </div>
                </div>
                @endif

                @if($config['show_pedidos'] ?? true)
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="stat-card bg-danger text-white">
                        <div class="stat-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-info">
                            <div class="stat-label">Pedidos Pendientes</div>
                            <div class="stat-value">{{ $data['pedidos_pendientes'] }}</div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        @else
            <div class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Cargando...</span>
                </div>
                <p class="text-muted mt-2">Cargando estadísticas...</p>
            </div>
        @endif
    </div>
    @endif
</div>

<style>
.stat-card {
    border-radius: 10px;
    padding: 1rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    height: 100%;
    transition: transform 0.2s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
}

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.stat-info {
    flex: 1;
}

.stat-label {
    font-size: 0.875rem;
    opacity: 0.9;
    margin-bottom: 0.25rem;
}

.stat-value {
    font-size: 2rem;
    font-weight: bold;
    line-height: 1;
}
</style>
