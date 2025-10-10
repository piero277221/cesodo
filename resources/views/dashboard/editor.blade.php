@extends('layouts.app')

@section('title', 'Editor de Dashboard')

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/gridstack/8.4.0/gridstack.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gridstack/8.4.0/gridstack-all.min.js"></script>
<link href="{{ asset('css/dashboard-widgets.css') }}" rel="stylesheet">
<style>
    .editor-container {
        height: calc(100vh - 120px);
        overflow: hidden;
    }

    .editor-sidebar {
        background: #f8f9fa;
        border-right: 1px solid #e9ecef;
        height: 100%;
        overflow-y: auto;
        padding: 1rem;
    }

    .editor-main {
        height: 100%;
        overflow: auto;
        padding: 1rem;
        background: #f5f5f5;
    }

    .widget-palette {
        margin-bottom: 2rem;
    }

    .widget-palette-item {
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 0.75rem;
        cursor: grab;
        transition: all 0.2s ease;
        text-align: center;
    }

    .widget-palette-item:hover {
        border-color: #007bff;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }

    .widget-palette-item:active {
        cursor: grabbing;
    }

    .widget-palette-icon {
        font-size: 2rem;
        color: #007bff;
        margin-bottom: 0.5rem;
        display: block;
    }

    .widget-palette-name {
        font-weight: 600;
        font-size: 0.875rem;
        color: #495057;
        margin-bottom: 0.25rem;
    }

    .widget-palette-description {
        font-size: 0.75rem;
        color: #6c757d;
    }

    .grid-stack {
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 10px;
        min-height: 600px;
        padding: 10px;
    }

    .grid-stack-item-content {
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .widget-container {
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .widget-header {
        background: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
        padding: 0.75rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-shrink: 0;
        cursor: move;
    }

    .widget-title {
        font-size: 0.875rem;
        font-weight: 600;
        color: #495057;
        margin: 0;
    }

    .widget-controls {
        display: flex;
        gap: 0.25rem;
    }

    .widget-content {
        flex: 1;
        padding: 1rem;
        overflow: auto;
    }

    .editor-toolbar {
        background: white;
        border-bottom: 1px solid #e9ecef;
        padding: 1rem;
        position: sticky;
        top: 0;
        z-index: 100;
    }

    .layout-manager {
        margin-top: 2rem;
    }

    .layout-item {
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 6px;
        padding: 0.75rem;
        margin-bottom: 0.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .layout-name {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.25rem;
    }

    .layout-description {
        font-size: 0.75rem;
        color: #6c757d;
    }

    .layout-actions {
        display: flex;
        gap: 0.25rem;
    }

    .preview-mode {
        background: #e7f3ff;
        border: 2px dashed #007bff;
    }

    .empty-grid-message {
        text-align: center;
        color: #6c757d;
        padding: 4rem 2rem;
        border: 2px dashed #dee2e6;
        border-radius: 10px;
        margin: 2rem;
    }

    .property-panel {
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 1rem;
        margin-top: 1rem;
    }

    .property-group {
        margin-bottom: 1.5rem;
    }

    .property-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.5rem;
        display: block;
    }
</style>
@endpush

@section('content')
<div class="editor-toolbar">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-0">
                <i class="fas fa-palette me-2"></i>
                Editor de Dashboard
            </h4>
            <p class="text-muted mb-0">Personaliza tu dashboard arrastrando widgets desde la paleta</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-info btn-sm" id="previewModeBtn">
                <i class="fas fa-eye me-1"></i>
                Vista Previa
            </button>
            <button class="btn btn-outline-success btn-sm" id="saveLayoutBtn">
                <i class="fas fa-save me-1"></i>
                Guardar Layout
            </button>
            <button class="btn btn-outline-warning btn-sm" id="exportLayoutBtn">
                <i class="fas fa-download me-1"></i>
                Exportar
            </button>
            <button class="btn btn-outline-danger btn-sm" id="resetEditorBtn">
                <i class="fas fa-trash me-1"></i>
                Limpiar Todo
            </button>
            <a href="{{ route('dashboard.index') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-arrow-left me-1"></i>
                Volver al Dashboard
            </a>
        </div>
    </div>
</div>

<div class="editor-container">
    <div class="row h-100">
        <!-- Sidebar with Widget Palette -->
        <div class="col-md-3 editor-sidebar">
            <div class="widget-palette">
                <h6 class="mb-3">
                    <i class="fas fa-cubes me-2"></i>
                    Paleta de Widgets
                </h6>
                <div id="widgetPalette">
                    <!-- Widget palette items will be loaded here -->
                </div>
            </div>

            <div class="layout-manager">
                <h6 class="mb-3">
                    <i class="fas fa-layer-group me-2"></i>
                    Layouts Guardados
                </h6>
                <div id="savedLayouts">
                    <!-- Saved layouts will be loaded here -->
                </div>
                <button class="btn btn-outline-primary btn-sm w-100 mt-2" id="loadLayoutsBtn">
                    <i class="fas fa-refresh me-1"></i>
                    Actualizar Lista
                </button>
            </div>

            <div class="property-panel" id="propertyPanel" style="display: none;">
                <h6 class="mb-3">
                    <i class="fas fa-sliders-h me-2"></i>
                    Propiedades del Widget
                </h6>
                <div id="widgetProperties">
                    <!-- Widget properties will be shown here -->
                </div>
            </div>
        </div>

        <!-- Main Editor Area -->
        <div class="col-md-9 editor-main">
            <div class="grid-stack" id="editorGrid">
                <div class="empty-grid-message" id="emptyMessage">
                    <i class="fas fa-mouse-pointer fa-3x mb-3"></i>
                    <h5>Arrastra widgets aquí para comenzar</h5>
                    <p class="mb-0">Selecciona widgets de la paleta de la izquierda y arrástralos a esta área</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Widget Configuration Modal -->
<div class="modal fade" id="widgetConfigModal" tabindex="-1" aria-labelledby="widgetConfigModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="widgetConfigModalLabel">
                    <i class="fas fa-cog me-2"></i>
                    Configurar Widget
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="widgetConfigForm">
                    <div id="configFormFields">
                        <!-- Configuration fields will be generated dynamically -->
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="saveWidgetConfigBtn">
                    <i class="fas fa-save me-1"></i>
                    Guardar Configuración
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Save Layout Modal -->
<div class="modal fade" id="saveLayoutModal" tabindex="-1" aria-labelledby="saveLayoutModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="saveLayoutModalLabel">
                    <i class="fas fa-save me-2"></i>
                    Guardar Layout
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="saveLayoutForm">
                    <div class="mb-3">
                        <label for="layoutName" class="form-label">Nombre del Layout</label>
                        <input type="text" class="form-control" id="layoutName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="layoutDescription" class="form-label">Descripción (Opcional)</label>
                        <textarea class="form-control" id="layoutDescription" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="layoutIsPublic" name="is_public">
                            <label class="form-check-label" for="layoutIsPublic">
                                Compartir con otros usuarios
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="saveLayoutSubmitBtn">
                    <i class="fas fa-save me-1"></i>
                    Guardar Layout
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let editorGrid = null;
let selectedWidget = null;
let previewMode = false;
let widgetCounter = 0;

document.addEventListener('DOMContentLoaded', function() {
    initializeEditor();
    loadWidgetPalette();
    loadSavedLayouts();

    // Event listeners
    document.getElementById('previewModeBtn').addEventListener('click', togglePreviewMode);
    document.getElementById('saveLayoutBtn').addEventListener('click', showSaveLayoutModal);
    document.getElementById('exportLayoutBtn').addEventListener('click', exportLayout);
    document.getElementById('resetEditorBtn').addEventListener('click', resetEditor);
    document.getElementById('loadLayoutsBtn').addEventListener('click', loadSavedLayouts);
    document.getElementById('saveLayoutSubmitBtn').addEventListener('click', saveLayout);
    document.getElementById('saveWidgetConfigBtn').addEventListener('click', saveWidgetConfig);

    // Widget interaction handlers
    document.addEventListener('click', handleWidgetSelection);
    document.addEventListener('dragstart', handleDragStart);
    document.addEventListener('dragend', handleDragEnd);
});

function initializeEditor() {
    const gridElement = document.getElementById('editorGrid');
    if (!gridElement) return;

    editorGrid = GridStack.init({
        cellHeight: 60,
        margin: 10,
        animate: true,
        draggable: {
            handle: '.widget-header'
        },
        resizable: {
            handles: 'e,se,s,sw,w'
        },
        acceptWidgets: true
    }, gridElement);

    // Handle widget changes
    editorGrid.on('change', function(event, items) {
        updateEmptyMessage();
        if (items.length > 0) {
            console.log('Grid changed:', items);
        }
    });

    // Handle widget drops from palette
    editorGrid.on('dropped', function(event, previousWidget, newWidget) {
        handleWidgetDrop(newWidget);
    });
}

function loadWidgetPalette() {
    fetch('{{ route("dashboard.config") }}')
        .then(response => response.json())
        .then(data => {
            if (data.success && data.availableWidgets) {
                renderWidgetPalette(data.availableWidgets);
            }
        })
        .catch(error => console.error('Error loading widget palette:', error));
}

function renderWidgetPalette(widgetTypes) {
    const container = document.getElementById('widgetPalette');
    container.innerHTML = '';

    widgetTypes.forEach(type => {
        const paletteItem = document.createElement('div');
        paletteItem.className = 'widget-palette-item';
        paletteItem.draggable = true;
        paletteItem.setAttribute('data-widget-type', type.id);
        paletteItem.setAttribute('data-widget-name', type.name);
        paletteItem.innerHTML = `
            <i class="${type.icon} widget-palette-icon"></i>
            <div class="widget-palette-name">${type.name}</div>
            <div class="widget-palette-description">${type.description}</div>
        `;
        container.appendChild(paletteItem);
    });
}

function handleDragStart(event) {
    const target = event.target.closest('.widget-palette-item');
    if (target) {
        const widgetType = target.getAttribute('data-widget-type');
        const widgetName = target.getAttribute('data-widget-name');

        event.dataTransfer.setData('text/plain', JSON.stringify({
            type: 'widget-palette',
            widgetType: widgetType,
            widgetName: widgetName
        }));

        target.style.opacity = '0.5';
    }
}

function handleDragEnd(event) {
    const target = event.target.closest('.widget-palette-item');
    if (target) {
        target.style.opacity = '1';
    }
}

function handleWidgetDrop(newWidget) {
    // This is called when a widget is dropped onto the grid
    const widgetElement = newWidget.el;
    const widgetContent = widgetElement.querySelector('.grid-stack-item-content');

    // Create widget structure
    createWidgetFromPalette(widgetElement, widgetContent);
}

function createWidgetFromPalette(element, content) {
    const widgetId = 'temp_' + (++widgetCounter);

    element.setAttribute('data-widget-id', widgetId);

    content.innerHTML = `
        <div class="widget-container">
            <div class="widget-header">
                <h6 class="widget-title">Nuevo Widget</h6>
                <div class="widget-controls">
                    <button class="btn btn-sm btn-outline-secondary widget-config">
                        <i class="fas fa-cog"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger widget-remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="widget-content">
                <div class="text-center p-4">
                    <i class="fas fa-cube fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Widget de ejemplo</p>
                </div>
            </div>
        </div>
    `;

    updateEmptyMessage();
}

function updateEmptyMessage() {
    const emptyMessage = document.getElementById('emptyMessage');
    const hasWidgets = editorGrid.getGridItems().length > 0;

    if (emptyMessage) {
        emptyMessage.style.display = hasWidgets ? 'none' : 'block';
    }
}

function handleWidgetSelection(event) {
    if (previewMode) return;

    const widget = event.target.closest('[data-widget-id]');
    if (widget) {
        selectWidget(widget);
    }

    // Handle widget controls
    const configBtn = event.target.closest('.widget-config');
    const removeBtn = event.target.closest('.widget-remove');

    if (configBtn) {
        const widgetElement = configBtn.closest('[data-widget-id]');
        if (widgetElement) {
            configureWidget(widgetElement.getAttribute('data-widget-id'));
        }
    } else if (removeBtn) {
        const widgetElement = removeBtn.closest('[data-widget-id]');
        if (widgetElement && confirm('¿Eliminar este widget?')) {
            editorGrid.removeWidget(widgetElement);
            updateEmptyMessage();
        }
    }
}

function selectWidget(widget) {
    // Remove previous selection
    document.querySelectorAll('.grid-stack-item.selected').forEach(item => {
        item.classList.remove('selected');
    });

    // Add selection to current widget
    widget.classList.add('selected');
    selectedWidget = widget;

    // Show properties panel
    showWidgetProperties(widget);
}

function showWidgetProperties(widget) {
    const panel = document.getElementById('propertyPanel');
    const container = document.getElementById('widgetProperties');

    const widgetId = widget.getAttribute('data-widget-id');
    const gridItem = widget.getAttribute('gs-w') && widget.getAttribute('gs-h');

    container.innerHTML = `
        <div class="property-group">
            <label class="property-label">Identificador</label>
            <input type="text" class="form-control form-control-sm" value="${widgetId}" readonly>
        </div>

        <div class="property-group">
            <label class="property-label">Dimensiones</label>
            <div class="row">
                <div class="col-6">
                    <label class="form-label">Ancho</label>
                    <input type="number" class="form-control form-control-sm" id="widgetWidth"
                           value="${widget.getAttribute('gs-w') || 3}" min="1" max="12">
                </div>
                <div class="col-6">
                    <label class="form-label">Alto</label>
                    <input type="number" class="form-control form-control-sm" id="widgetHeight"
                           value="${widget.getAttribute('gs-h') || 3}" min="1" max="20">
                </div>
            </div>
        </div>

        <div class="property-group">
            <button class="btn btn-sm btn-primary w-100" onclick="applyWidgetProperties()">
                <i class="fas fa-check me-1"></i>
                Aplicar Cambios
            </button>
        </div>
    `;

    panel.style.display = 'block';
}

function applyWidgetProperties() {
    if (!selectedWidget) return;

    const width = document.getElementById('widgetWidth').value;
    const height = document.getElementById('widgetHeight').value;

    editorGrid.update(selectedWidget, {
        w: parseInt(width),
        h: parseInt(height)
    });
}

function togglePreviewMode() {
    previewMode = !previewMode;
    const btn = document.getElementById('previewModeBtn');
    const grid = document.getElementById('editorGrid');

    if (previewMode) {
        btn.innerHTML = '<i class="fas fa-edit me-1"></i> Modo Edición';
        btn.className = 'btn btn-warning btn-sm';
        grid.classList.add('preview-mode');
        editorGrid.disable();

        // Hide all widget controls
        document.querySelectorAll('.widget-controls').forEach(control => {
            control.style.display = 'none';
        });
    } else {
        btn.innerHTML = '<i class="fas fa-eye me-1"></i> Vista Previa';
        btn.className = 'btn btn-outline-info btn-sm';
        grid.classList.remove('preview-mode');
        editorGrid.enable();

        // Show all widget controls
        document.querySelectorAll('.widget-controls').forEach(control => {
            control.style.display = 'flex';
        });
    }
}

function showSaveLayoutModal() {
    new bootstrap.Modal(document.getElementById('saveLayoutModal')).show();
}

function saveLayout() {
    const form = document.getElementById('saveLayoutForm');
    const formData = new FormData(form);

    // Get current grid layout
    const widgets = editorGrid.getGridItems().map(item => ({
        widget_id: item.getAttribute('data-widget-id'),
        x: parseInt(item.getAttribute('gs-x')),
        y: parseInt(item.getAttribute('gs-y')),
        w: parseInt(item.getAttribute('gs-w')),
        h: parseInt(item.getAttribute('gs-h'))
    }));

    formData.append('widgets', JSON.stringify(widgets));

    fetch('{{ route("dashboard.layouts.save") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            bootstrap.Modal.getInstance(document.getElementById('saveLayoutModal')).hide();
            alert('Layout guardado exitosamente');
            loadSavedLayouts();
        } else {
            alert('Error al guardar layout: ' + (data.message || 'Error desconocido'));
        }
    })
    .catch(error => {
        console.error('Error saving layout:', error);
        alert('Error al guardar layout');
    });
}

function loadSavedLayouts() {
    const container = document.getElementById('savedLayouts');
    container.innerHTML = '<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Cargando...</div>';

    // Simulate loading saved layouts
    setTimeout(() => {
        container.innerHTML = `
            <div class="layout-item">
                <div>
                    <div class="layout-name">Layout por Defecto</div>
                    <div class="layout-description">Layout estándar del sistema</div>
                </div>
                <div class="layout-actions">
                    <button class="btn btn-sm btn-outline-primary" onclick="loadLayout('default')">
                        <i class="fas fa-upload"></i>
                    </button>
                </div>
            </div>
            <div class="text-muted text-center mt-3">
                <small>Los layouts guardados aparecerán aquí</small>
            </div>
        `;
    }, 1000);
}

function loadLayout(layoutId) {
    console.log('Loading layout:', layoutId);
    // Implementation for loading a specific layout
}

function exportLayout() {
    const widgets = editorGrid.getGridItems().map(item => ({
        widget_id: item.getAttribute('data-widget-id'),
        x: parseInt(item.getAttribute('gs-x')),
        y: parseInt(item.getAttribute('gs-y')),
        w: parseInt(item.getAttribute('gs-w')),
        h: parseInt(item.getAttribute('gs-h'))
    }));

    const layout = {
        name: 'Dashboard Layout',
        created_at: new Date().toISOString(),
        widgets: widgets
    };

    const blob = new Blob([JSON.stringify(layout, null, 2)], { type: 'application/json' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'dashboard-layout.json';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
}

function resetEditor() {
    if (confirm('¿Estás seguro de que quieres limpiar todo el editor?')) {
        editorGrid.removeAll();
        updateEmptyMessage();
        document.getElementById('propertyPanel').style.display = 'none';
        selectedWidget = null;
    }
}

function configureWidget(widgetId) {
    console.log('Configuring widget:', widgetId);
    new bootstrap.Modal(document.getElementById('widgetConfigModal')).show();
}

function saveWidgetConfig() {
    bootstrap.Modal.getInstance(document.getElementById('widgetConfigModal')).hide();
}
</script>
@endpush
