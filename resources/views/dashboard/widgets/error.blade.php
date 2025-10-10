<div class="widget-container" data-widget-id="{{ $widgetId }}">
    <div class="widget-header">
        <h6 class="widget-title mb-0">
            <i class="fas fa-exclamation-triangle me-2 text-danger"></i>
            Error en Widget
        </h6>
        <div class="widget-controls">
            <button class="btn btn-sm btn-outline-danger widget-remove" title="Eliminar">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    
    <div class="widget-content">
        <div class="error-state text-center">
            <i class="fas fa-exclamation-triangle text-danger mb-3" style="font-size: 2rem;"></i>
            <h6 class="text-danger">Error al cargar widget</h6>
            <p class="text-muted small mb-3">{{ $error }}</p>
            <button class="btn btn-sm btn-outline-primary" onclick="location.reload()">
                <i class="fas fa-redo me-1"></i>
                Recargar página
            </button>
        </div>
    </div>
</div>

<style>
.error-state {
    padding: 2rem 1rem;
}
</style>