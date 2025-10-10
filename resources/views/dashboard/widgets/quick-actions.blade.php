<div class="widget-container" data-widget-id="{{ $widget->widget_id }}">
    <div class="widget-header">
        <h6 class="widget-title">
            <i class="{{ $widget->widgetType->icon }} me-2"></i>
            {{ $widget->display_title }}
        </h6>
        <div class="widget-actions">
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
        @if($data && count($data) > 0)
            <div class="quick-actions-grid" style="grid-template-columns: repeat({{ $config['items_per_row'] ?? 6 }}, 1fr);">
                @foreach($data as $action)
                <a href="{{ $action['url'] }}" class="quick-action-item text-decoration-none">
                    <div class="action-card bg-{{ $action['color'] ?? 'primary' }}">
                        @if($config['show_icons'] ?? true)
                        <div class="action-icon">
                            <i class="{{ $action['icon'] }} fa-2x"></i>
                        </div>
                        @endif
                        <div class="action-title">{{ $action['title'] }}</div>
                    </div>
                </a>
                @endforeach
            </div>
        @else
            <div class="text-center py-4">
                <i class="fas fa-info-circle fa-2x text-muted mb-3"></i>
                <p class="text-muted">No hay acciones rápidas disponibles para tu rol.</p>
                <small class="text-muted">Las acciones se muestran según tus permisos en el sistema.</small>
            </div>
        @endif
    </div>
    @endif
</div>

<style>
.quick-actions-grid {
    display: grid;
    gap: 1rem;
    padding: 0.5rem 0;
}

.quick-action-item {
    transition: transform 0.2s ease;
}

.quick-action-item:hover {
    transform: translateY(-3px);
}

.action-card {
    padding: 1.5rem 1rem;
    border-radius: 10px;
    text-align: center;
    color: white;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.75rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transition: all 0.2s ease;
}

.action-card:hover {
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    color: white;
}

.action-icon {
    opacity: 0.9;
}

.action-title {
    font-size: 0.875rem;
    font-weight: 600;
    line-height: 1.2;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .quick-actions-grid {
        grid-template-columns: repeat(3, 1fr) !important;
    }

    .action-card {
        padding: 1rem 0.5rem;
    }

    .action-icon i {
        font-size: 1.5rem !important;
    }

    .action-title {
        font-size: 0.75rem;
    }
}

@media (max-width: 576px) {
    .quick-actions-grid {
        grid-template-columns: repeat(2, 1fr) !important;
    }
}
</style>
