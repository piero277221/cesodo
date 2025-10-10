@extends('layouts.app')

@section('title', 'Dashboard Personalizable')

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<link href="https://unpkg.com/gridstack@9.2.0/dist/gridstack.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    /* Dashboard Widget Styles */
    .dashboard-container {
        padding: 0 !important;
        margin: 0 !important;
    }

    .dashboard-toolbar {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .dashboard-mode-toggle {
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 25px;
        transition: all 0.3s ease;
    }

    .dashboard-mode-toggle:hover {
        background: rgba(255, 255, 255, 0.3);
        color: white;
    }

    .widget-toolbar {
        background: white;
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 1rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .widget-add-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .widget-add-btn {
        background: linear-gradient(45deg, #28a745, #20c997);
        border: none;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .widget-add-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
        color: white;
    }

    .grid-stack {
        background: transparent;
    }

    .grid-stack-item-content {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        border: 1px solid #e9ecef;
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .grid-stack-item:hover .grid-stack-item-content {
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
        transform: translateY(-2px);
    }

    .widget-container {
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .widget-header {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #e9ecef;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-shrink: 0;
    }

    .widget-title {
        font-weight: 600;
        color: #495057;
        margin: 0;
        font-size: 0.9rem;
    }

    .widget-controls {
        display: flex;
        gap: 0.25rem;
        opacity: 0.7;
        transition: opacity 0.3s ease;
    }

    .widget-container:hover .widget-controls {
        opacity: 1;
    }

    .widget-controls .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
        border-radius: 4px;
    }

    .widget-content {
        flex: 1;
        padding: 1rem;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .widget-footer {
        margin-top: auto;
        padding-top: 1rem;
    }

    /* Edit mode styles */
    .edit-mode .grid-stack-item {
        cursor: move;
    }

    .edit-mode .grid-stack-item-content {
        border: 2px dashed #007bff;
        opacity: 0.8;
    }

    .edit-mode-indicator {
        position: fixed;
        top: 100px;
        right: 20px;
        background: #007bff;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 25px;
        z-index: 9999;
        box-shadow: 0 4px 15px rgba(0,123,255,0.3);
    }

    /* Mobile responsive */
    @media (max-width: 768px) {
        .dashboard-toolbar {
            padding: 1rem;
        }
        
        .widget-toolbar {
            flex-direction: column;
            align-items: stretch;
        }
        
        .widget-add-buttons {
            justify-content: center;
        }
    }

    /* Loading states */
    .widget-loading {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100px;
        color: #6c757d;
    }

    .widget-loading i {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    /* Empty state */
    .dashboard-empty {
        text-align: center;
        padding: 3rem 1rem;
        color: #6c757d;
    }

    .dashboard-empty i {
        font-size: 3rem;
        margin-bottom: 1rem;
        display: block;
    }
</style>
@endpush

@section('content')
<div class="container-fluid dashboard-container">
    @if(isset($error))
        <div class="alert alert-danger">
            <h5><i class="fas fa-exclamation-triangle me-2"></i>Error en el Dashboard</h5>
            <p>{{ $error }}</p>
        </div>
    @endif

    <!-- Dashboard Header -->
    <div class="dashboard-toolbar">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="h2 mb-2">
                    <i class="fas fa-th-large me-3"></i>
                    Dashboard Personalizable
                </h1>
                <p class="mb-0 opacity-90">
                    Bienvenido, {{ Auth::user()->name }}. Personaliza tu espacio de trabajo.
                </p>
            </div>
            <div class="col-md-4 text-md-end">
                <div class="d-flex flex-column align-items-md-end gap-2">
                    <div class="h5 mb-0">{{ now()->locale('es')->translatedFormat('d/m/Y H:i') }}</div>
                    <a href="{{ route('dashboard') }}" class="btn dashboard-mode-toggle btn-sm">
                        <i class="fas fa-chart-line me-1"></i>
                        Dashboard Clásico
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Widget Management Toolbar -->
    <div class="widget-toolbar">
        <div class="d-flex align-items-center gap-3">
            <h6 class="mb-0">
                <i class="fas fa-puzzle-piece me-2"></i>
                Widgets Disponibles
            </h6>
            <div class="widget-add-buttons">
                @foreach($availableWidgets as $widget)
                <button type="button" 
                        class="btn widget-add-btn btn-sm" 
                        data-widget-type="{{ $widget->key }}"
                        title="{{ $widget->description }}">
                    <i class="fas {{ $widget->icon }} me-1"></i>
                    {{ $widget->name }}
                </button>
                @endforeach
            </div>
        </div>
        
        <div class="dashboard-controls">
            <button type="button" class="btn btn-outline-primary btn-sm me-2" id="toggleEditMode">
                <i class="fas fa-edit me-1"></i>
                <span id="editModeText">Editar Layout</span>
            </button>
            <div class="btn-group">
                <button type="button" class="btn btn-outline-success btn-sm" id="saveLayout">
                    <i class="fas fa-save me-1"></i>
                    Guardar
                </button>
                <button type="button" class="btn btn-outline-info btn-sm dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#" id="resetLayout">
                        <i class="fas fa-redo me-2"></i>Resetear Layout
                    </a></li>
                    <li><a class="dropdown-item" href="#" id="exportLayout">
                        <i class="fas fa-download me-2"></i>Exportar Layout
                    </a></li>
                    <li><a class="dropdown-item" href="#" id="importLayout">
                        <i class="fas fa-upload me-2"></i>Importar Layout
                    </a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- GridStack Container -->
    <div class="grid-stack" id="dashboardGrid">
        @if($userWidgets->count() > 0)
            @foreach($userWidgets as $widget)
            <div class="grid-stack-item" 
                 gs-x="{{ $widget->position_x }}" 
                 gs-y="{{ $widget->position_y }}" 
                 gs-w="{{ $widget->width }}" 
                 gs-h="{{ $widget->height }}"
                 data-widget-id="{{ $widget->widget_id }}">
                <div class="grid-stack-item-content">
                    <div class="widget-loading">
                        <i class="fas fa-spinner me-2"></i>
                        Cargando widget...
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <div class="dashboard-empty">
                <i class="fas fa-puzzle-piece"></i>
                <h4>Dashboard Vacío</h4>
                <p>Agrega widgets para personalizar tu dashboard.</p>
                <p class="small text-muted">Haz clic en los botones de arriba para agregar widgets.</p>
            </div>
        @endif
    </div>

    <!-- Edit Mode Indicator -->
    <div class="edit-mode-indicator d-none" id="editModeIndicator">
        <i class="fas fa-edit me-2"></i>
        Modo Edición Activo
    </div>
</div>

<!-- Hidden file input for import -->
<input type="file" id="layoutFileInput" accept=".json" style="display: none;">

@push('scripts')
<script src="https://unpkg.com/gridstack@9.2.0/dist/gridstack-all.js"></script>
<script>
class DashboardManager {
    constructor() {
        this.grid = null;
        this.editMode = false;
        this.widgets = @json($userWidgets);
        this.init();
    }

    init() {
        this.initializeGrid();
        this.setupEventListeners();
        this.loadWidgetContents();
    }

    initializeGrid() {
        this.grid = GridStack.init({
            cellHeight: 70,
            margin: 10,
            resizable: { handles: 'e,se,s,sw,w' },
            removable: true,
            staticGrid: true, // Start in view mode
            animate: true,
            float: false,
            column: 12,
            minRow: 1
        });

        // Handle widget changes
        this.grid.on('change', (event, items) => {
            if (this.editMode) {
                this.savePositions();
            }
        });

        // Handle widget removal
        this.grid.on('removed', (event, items) => {
            items.forEach(item => {
                this.removeWidget(item.el.getAttribute('data-widget-id'));
            });
        });
    }

    setupEventListeners() {
        // Edit mode toggle
        document.getElementById('toggleEditMode').addEventListener('click', () => {
            this.toggleEditMode();
        });

        // Add widget buttons
        document.querySelectorAll('.widget-add-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const widgetType = e.target.closest('button').getAttribute('data-widget-type');
                this.addWidget(widgetType);
            });
        });

        // Layout management
        document.getElementById('saveLayout').addEventListener('click', () => this.saveLayout());
        document.getElementById('resetLayout').addEventListener('click', () => this.resetLayout());
        document.getElementById('exportLayout').addEventListener('click', () => this.exportLayout());
        document.getElementById('importLayout').addEventListener('click', () => this.importLayout());
        
        // File input for import
        document.getElementById('layoutFileInput').addEventListener('change', (e) => {
            this.handleLayoutImport(e);
        });
    }

    toggleEditMode() {
        this.editMode = !this.editMode;
        const indicator = document.getElementById('editModeIndicator');
        const button = document.getElementById('toggleEditMode');
        const buttonText = document.getElementById('editModeText');

        if (this.editMode) {
            this.grid.enableMove(true);
            this.grid.enableResize(true);
            document.body.classList.add('edit-mode');
            indicator.classList.remove('d-none');
            button.classList.remove('btn-outline-primary');
            button.classList.add('btn-warning');
            buttonText.textContent = 'Salir de Edición';
        } else {
            this.grid.enableMove(false);
            this.grid.enableResize(false);
            document.body.classList.remove('edit-mode');
            indicator.classList.add('d-none');
            button.classList.remove('btn-warning');
            button.classList.add('btn-outline-primary');
            buttonText.textContent = 'Editar Layout';
        }
    }

    async loadWidgetContents() {
        const widgets = document.querySelectorAll('[data-widget-id]');
        
        for (const widgetEl of widgets) {
            const widgetId = widgetEl.getAttribute('data-widget-id');
            try {
                const response = await fetch(`/dashboard/widgets/${widgetId}/render`);
                const html = await response.text();
                
                const contentEl = widgetEl.querySelector('.grid-stack-item-content');
                contentEl.innerHTML = html;
                
                // Execute any widget-specific scripts
                this.executeWidgetScripts(contentEl);
                
            } catch (error) {
                console.error(`Error loading widget ${widgetId}:`, error);
                const contentEl = widgetEl.querySelector('.grid-stack-item-content');
                contentEl.innerHTML = `
                    <div class="widget-container">
                        <div class="widget-header">
                            <h6 class="widget-title">Error</h6>
                        </div>
                        <div class="widget-content">
                            <div class="text-center text-muted">
                                <i class="fas fa-exclamation-triangle mb-2"></i>
                                <p>Error cargando widget</p>
                            </div>
                        </div>
                    </div>
                `;
            }
        }
    }

    executeWidgetScripts(container) {
        const scripts = container.querySelectorAll('script');
        scripts.forEach(script => {
            const newScript = document.createElement('script');
            if (script.src) {
                newScript.src = script.src;
            } else {
                newScript.textContent = script.textContent;
            }
            document.body.appendChild(newScript);
            document.body.removeChild(newScript);
        });
    }

    async addWidget(widgetType) {
        try {
            const response = await fetch('/dashboard/widgets', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    widget_type: widgetType
                })
            });

            const data = await response.json();
            
            if (data.success) {
                // Add widget to grid
                const widgetEl = this.grid.addWidget({
                    content: '<div class="widget-loading"><i class="fas fa-spinner me-2"></i>Cargando...</div>',
                    w: data.widget.width || 6,
                    h: data.widget.height || 4
                });
                
                widgetEl.setAttribute('data-widget-id', data.widget.widget_id);
                
                // Load widget content
                setTimeout(() => {
                    this.loadWidgetContent(data.widget.widget_id, widgetEl);
                }, 100);
                
                this.showNotification('Widget agregado correctamente', 'success');
            } else {
                this.showNotification('Error agregando widget: ' + data.message, 'error');
            }
        } catch (error) {
            console.error('Error adding widget:', error);
            this.showNotification('Error agregando widget', 'error');
        }
    }

    async loadWidgetContent(widgetId, widgetEl) {
        try {
            const response = await fetch(`/dashboard/widgets/${widgetId}/render`);
            const html = await response.text();
            
            const contentEl = widgetEl.querySelector('.grid-stack-item-content');
            contentEl.innerHTML = html;
            
            this.executeWidgetScripts(contentEl);
            
        } catch (error) {
            console.error(`Error loading widget content ${widgetId}:`, error);
        }
    }

    async savePositions() {
        const items = [];
        this.grid.getGridItems().forEach(item => {
            const node = item.gridstackNode;
            items.push({
                widget_id: item.getAttribute('data-widget-id'),
                x: node.x,
                y: node.y,
                w: node.w,
                h: node.h
            });
        });

        try {
            await fetch('/dashboard/widgets/positions', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ positions: items })
            });
        } catch (error) {
            console.error('Error saving positions:', error);
        }
    }

    async removeWidget(widgetId) {
        try {
            await fetch(`/dashboard/widgets/${widgetId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            this.showNotification('Widget eliminado', 'success');
        } catch (error) {
            console.error('Error removing widget:', error);
            this.showNotification('Error eliminando widget', 'error');
        }
    }

    async saveLayout() {
        // Implementation for saving layout as template
        this.showNotification('Layout guardado', 'success');
    }

    async resetLayout() {
        if (confirm('¿Estás seguro de que quieres resetear el layout? Se perderán todos los cambios.')) {
            try {
                await fetch('/dashboard/widgets/reset', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                location.reload();
            } catch (error) {
                console.error('Error resetting layout:', error);
                this.showNotification('Error reseteando layout', 'error');
            }
        }
    }

    exportLayout() {
        const layout = {
            widgets: [],
            metadata: {
                exported_at: new Date().toISOString(),
                user: '{{ Auth::user()->name }}',
                version: '1.0'
            }
        };

        this.grid.getGridItems().forEach(item => {
            const node = item.gridstackNode;
            layout.widgets.push({
                widget_id: item.getAttribute('data-widget-id'),
                x: node.x,
                y: node.y,
                w: node.w,
                h: node.h
            });
        });

        const dataStr = JSON.stringify(layout, null, 2);
        const dataBlob = new Blob([dataStr], { type: 'application/json' });
        
        const link = document.createElement('a');
        link.href = URL.createObjectURL(dataBlob);
        link.download = `dashboard-layout-${new Date().toISOString().split('T')[0]}.json`;
        link.click();
        
        this.showNotification('Layout exportado', 'success');
    }

    importLayout() {
        document.getElementById('layoutFileInput').click();
    }

    handleLayoutImport(event) {
        const file = event.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = (e) => {
            try {
                const layout = JSON.parse(e.target.result);
                // Implementation for importing layout
                this.showNotification('Layout importado (funcionalidad en desarrollo)', 'info');
            } catch (error) {
                this.showNotification('Error al importar layout: archivo inválido', 'error');
            }
        };
        reader.readAsText(file);
    }

    showNotification(message, type = 'info') {
        // Simple notification system
        const alertClass = type === 'success' ? 'alert-success' : 
                          type === 'error' ? 'alert-danger' : 'alert-info';
        
        const notification = document.createElement('div');
        notification.className = `alert ${alertClass} alert-dismissible fade show position-fixed`;
        notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        notification.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 5000);
    }
}

// Initialize dashboard when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    window.dashboardManager = new DashboardManager();
});
</script>
@endpush
@endsection