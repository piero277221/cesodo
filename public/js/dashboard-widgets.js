/**
 * Dashboard Widgets Management System
 * Advanced JavaScript functionality for the dashboard widgets
 */

class DashboardManager {
    constructor() {
        this.grid = null;
        this.widgets = new Map();
        this.currentMode = localStorage.getItem('dashboard-mode') || 'legacy';
        this.autoRefreshInterval = null;

        this.init();
    }

    init() {
        this.bindEvents();
        this.initializeMode();
        this.startAutoRefresh();
    }

    bindEvents() {
        // Dashboard mode toggle
        const toggleBtn = document.getElementById('dashboardToggle');
        if (toggleBtn) {
            toggleBtn.addEventListener('click', () => this.toggleMode());
        }

        // Widget management buttons
        document.addEventListener('click', (e) => this.handleWidgetActions(e));

        // Auto-save on widget changes
        document.addEventListener('widgetChanged', () => this.autoSave());
    }

    initializeMode() {
        if (this.currentMode === 'modern') {
            this.switchToModernMode();
        } else {
            this.switchToLegacyMode();
        }
    }

    toggleMode() {
        this.currentMode = this.currentMode === 'legacy' ? 'modern' : 'legacy';
        localStorage.setItem('dashboard-mode', this.currentMode);

        if (this.currentMode === 'modern') {
            this.switchToModernMode();
        } else {
            this.switchToLegacyMode();
        }
    }

    switchToLegacyMode() {
        const container = document.getElementById('dashboardContainer');
        const toggleText = document.getElementById('toggleText');

        if (container) {
            container.className = 'container-fluid dashboard-mode-legacy';
        }

        if (toggleText) {
            toggleText.textContent = 'Vista Moderna';
        }

        // Initialize legacy charts after a short delay
        setTimeout(() => this.initializeLegacyCharts(), 100);
    }

    switchToModernMode() {
        const container = document.getElementById('dashboardContainer');
        const toggleText = document.getElementById('toggleText');

        if (container) {
            container.className = 'container-fluid dashboard-mode-modern';
        }

        if (toggleText) {
            toggleText.textContent = 'Vista Clásica';
        }

        // Initialize widget grid after a short delay
        setTimeout(() => this.initializeWidgetGrid(), 100);
    }

    initializeLegacyCharts() {
        // Implementation for legacy chart initialization
        // This will be called when switching to legacy mode
        console.log('Initializing legacy charts...');
    }

    initializeWidgetGrid() {
        const gridElement = document.getElementById('widgetGrid');
        if (!gridElement) return;

        // Initialize GridStack
        this.grid = GridStack.init({
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

        // Bind grid events
        this.grid.on('change', (event, items) => {
            this.onWidgetPositionChange(items);
        });

        this.grid.on('removed', (event, items) => {
            this.onWidgetRemoved(items);
        });

        // Load user widgets
        this.loadUserWidgets();
    }

    async loadUserWidgets() {
        try {
            const response = await fetch('/dashboard/config');
            const data = await response.json();

            if (data.success && data.widgets) {
                // Clear existing widgets
                if (this.grid) {
                    this.grid.removeAll();
                }

                // Add each widget to the grid
                for (const widget of data.widgets) {
                    await this.addWidgetToGrid(widget);
                }
            } else {
                // Load default widgets if no user widgets exist
                this.loadDefaultWidgets();
            }
        } catch (error) {
            console.error('Error loading user widgets:', error);
            this.showError('Error al cargar widgets del usuario');
        }
    }

    loadDefaultWidgets() {
        const defaultWidgets = [
            { type_id: 1, x: 0, y: 0, w: 3, h: 2 }, // Stats
            { type_id: 2, x: 3, y: 0, w: 3, h: 2 }, // Quick Actions
            { type_id: 3, x: 0, y: 2, w: 6, h: 2 }, // Welcome Banner
            { type_id: 5, x: 0, y: 4, w: 3, h: 4 }, // Recent Consumos
            { type_id: 4, x: 3, y: 4, w: 3, h: 4 }, // Chart
        ];

        defaultWidgets.forEach(widget => {
            this.addWidget(widget.type_id, widget.x, widget.y, widget.w, widget.h);
        });
    }

    async addWidgetToGrid(widget) {
        // Create widget element
        const widgetElement = document.createElement('div');
        widgetElement.className = 'grid-stack-item widget-fade-in';
        widgetElement.setAttribute('gs-id', widget.widget_id || widget.id);
        widgetElement.setAttribute('gs-x', widget.col_position || widget.x || 0);
        widgetElement.setAttribute('gs-y', widget.row_position || widget.y || 0);
        widgetElement.setAttribute('gs-w', widget.width || widget.w || 3);
        widgetElement.setAttribute('gs-h', widget.height || widget.h || 3);

        // Create content container
        const contentElement = document.createElement('div');
        contentElement.className = 'grid-stack-item-content';

        // Add loading state
        contentElement.innerHTML = `
            <div class="widget-loading">
                <div class="spinner-border spinner-border-sm" role="status"></div>
                <span>Cargando widget...</span>
            </div>
        `;

        widgetElement.appendChild(contentElement);

        // Add to grid
        if (this.grid) {
            this.grid.addWidget(widgetElement);
        }

        // Load widget content
        try {
            await this.loadWidgetContent(widget.widget_id || widget.id, contentElement);
        } catch (error) {
            this.showWidgetError(contentElement, 'Error al cargar contenido');
        }

        // Store widget reference
        this.widgets.set(widget.widget_id || widget.id, {
            element: widgetElement,
            config: widget.config || {},
            type: widget.type || 'unknown'
        });

        return widgetElement;
    }

    async loadWidgetContent(widgetId, container) {
        try {
            const response = await fetch(`/dashboard/widgets/${widgetId}/data`);
            const data = await response.json();

            if (data.success && data.html) {
                container.innerHTML = data.html;

                // Trigger custom event for widget loaded
                container.dispatchEvent(new CustomEvent('widgetLoaded', {
                    detail: { widgetId, data }
                }));
            } else {
                throw new Error(data.message || 'Error al cargar widget');
            }
        } catch (error) {
            console.error('Error loading widget content:', error);
            this.showWidgetError(container, error.message);
        }
    }

    showWidgetError(container, message) {
        container.innerHTML = `
            <div class="widget-error">
                <i class="fas fa-exclamation-triangle"></i>
                <p>${message}</p>
                <button class="btn btn-sm btn-outline-primary" onclick="dashboardManager.retryLoadWidget('${container.closest('[gs-id]').getAttribute('gs-id')}')">
                    <i class="fas fa-retry"></i> Reintentar
                </button>
            </div>
        `;
    }

    async retryLoadWidget(widgetId) {
        const widget = this.widgets.get(widgetId);
        if (widget) {
            const container = widget.element.querySelector('.grid-stack-item-content');
            container.innerHTML = `
                <div class="widget-loading">
                    <div class="spinner-border spinner-border-sm" role="status"></div>
                    <span>Reintentando...</span>
                </div>
            `;

            await this.loadWidgetContent(widgetId, container);
        }
    }

    async addWidget(typeId, x = null, y = null, w = 3, h = 3) {
        try {
            const formData = new FormData();
            formData.append('type_id', typeId);

            if (x !== null) {
                formData.append('col_position', x);
                formData.append('row_position', y);
                formData.append('width', w);
                formData.append('height', h);
            }

            const response = await fetch('/dashboard/widgets', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            const data = await response.json();

            if (data.success) {
                await this.addWidgetToGrid(data.widget);

                // Close add widget modal if exists
                const modal = bootstrap.Modal.getInstance(document.getElementById('addWidgetModal'));
                if (modal) {
                    modal.hide();
                }

                this.showSuccess('Widget agregado exitosamente');
            } else {
                throw new Error(data.message || 'Error al agregar widget');
            }
        } catch (error) {
            console.error('Error adding widget:', error);
            this.showError('Error al agregar widget: ' + error.message);
        }
    }

    onWidgetPositionChange(items) {
        if (!items || items.length === 0) return;

        const positions = items.map(item => ({
            widget_id: item.id,
            col_position: item.x,
            row_position: item.y,
            width: item.w,
            height: item.h
        }));

        this.updateWidgetPositions(positions);
    }

    async updateWidgetPositions(positions) {
        try {
            await fetch('/dashboard/widgets/positions', {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ positions })
            });
        } catch (error) {
            console.error('Error updating positions:', error);
        }
    }

    onWidgetRemoved(items) {
        items.forEach(item => {
            this.widgets.delete(item.id);
        });
    }

    handleWidgetActions(event) {
        const target = event.target.closest('button');
        if (!target) return;

        if (target.classList.contains('widget-config')) {
            const widget = target.closest('[data-widget-id]') || target.closest('[gs-id]');
            if (widget) {
                const widgetId = widget.getAttribute('data-widget-id') || widget.getAttribute('gs-id');
                this.configureWidget(widgetId);
            }
        } else if (target.classList.contains('widget-remove')) {
            const widget = target.closest('[data-widget-id]') || target.closest('[gs-id]');
            if (widget && confirm('¿Estás seguro de que quieres eliminar este widget?')) {
                const widgetId = widget.getAttribute('data-widget-id') || widget.getAttribute('gs-id');
                this.removeWidget(widgetId);
            }
        } else if (target.classList.contains('widget-collapse')) {
            const widget = target.closest('[data-widget-id]') || target.closest('[gs-id]');
            if (widget) {
                const widgetId = widget.getAttribute('data-widget-id') || widget.getAttribute('gs-id');
                this.toggleWidgetCollapse(widgetId);
            }
        }
    }

    async removeWidget(widgetId) {
        try {
            const response = await fetch(`/dashboard/widgets/${widgetId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            const data = await response.json();

            if (data.success) {
                const element = document.querySelector(`[gs-id="${widgetId}"]`);
                if (element && this.grid) {
                    this.grid.removeWidget(element);
                }

                this.widgets.delete(widgetId);
                this.showSuccess('Widget eliminado exitosamente');
            } else {
                throw new Error(data.message || 'Error al eliminar widget');
            }
        } catch (error) {
            console.error('Error removing widget:', error);
            this.showError('Error al eliminar widget');
        }
    }

    async configureWidget(widgetId) {
        // Implementation for widget configuration
        console.log('Configuring widget:', widgetId);
        // This would open a configuration modal
    }

    async toggleWidgetCollapse(widgetId) {
        try {
            const response = await fetch(`/dashboard/widgets/${widgetId}/toggle-collapsed`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            const data = await response.json();

            if (data.success) {
                const widget = this.widgets.get(widgetId);
                if (widget) {
                    const content = widget.element.querySelector('.widget-content');
                    if (content) {
                        content.classList.toggle('collapsed');
                    }
                }
            }
        } catch (error) {
            console.error('Error toggling widget collapse:', error);
        }
    }

    startAutoRefresh() {
        // Auto-refresh widgets every 5 minutes
        this.autoRefreshInterval = setInterval(() => {
            this.refreshAllWidgets();
        }, 300000); // 5 minutes
    }

    async refreshAllWidgets() {
        if (this.currentMode !== 'modern') return;

        for (const [widgetId, widget] of this.widgets) {
            try {
                const container = widget.element.querySelector('.grid-stack-item-content');
                await this.loadWidgetContent(widgetId, container);
            } catch (error) {
                console.error(`Error refreshing widget ${widgetId}:`, error);
            }
        }
    }

    autoSave() {
        // Auto-save functionality
        clearTimeout(this.autoSaveTimeout);
        this.autoSaveTimeout = setTimeout(() => {
            console.log('Auto-saving dashboard state...');
            // Implementation for auto-save
        }, 2000);
    }

    showSuccess(message) {
        this.showNotification(message, 'success');
    }

    showError(message) {
        this.showNotification(message, 'error');
    }

    showNotification(message, type = 'info') {
        // Create and show a toast notification
        const toast = document.createElement('div');
        toast.className = `toast align-items-center text-white bg-${type === 'success' ? 'success' : (type === 'error' ? 'danger' : 'info')} border-0`;
        toast.setAttribute('role', 'alert');
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-${type === 'success' ? 'check' : (type === 'error' ? 'exclamation-triangle' : 'info')} me-2"></i>
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;

        // Add to toast container or create one
        let container = document.getElementById('toastContainer');
        if (!container) {
            container = document.createElement('div');
            container.id = 'toastContainer';
            container.className = 'toast-container position-fixed top-0 end-0 p-3';
            document.body.appendChild(container);
        }

        container.appendChild(toast);

        // Show toast
        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();

        // Remove from DOM after hiding
        toast.addEventListener('hidden.bs.toast', () => {
            toast.remove();
        });
    }

    destroy() {
        if (this.autoRefreshInterval) {
            clearInterval(this.autoRefreshInterval);
        }

        if (this.autoSaveTimeout) {
            clearTimeout(this.autoSaveTimeout);
        }

        if (this.grid) {
            this.grid.destroy();
        }

        this.widgets.clear();
    }
}

// Initialize dashboard manager when DOM is loaded
let dashboardManager;

document.addEventListener('DOMContentLoaded', function() {
    dashboardManager = new DashboardManager();
});

// Cleanup on page unload
window.addEventListener('beforeunload', function() {
    if (dashboardManager) {
        dashboardManager.destroy();
    }
});

// Export for global access
window.DashboardManager = DashboardManager;
window.dashboardManager = dashboardManager;
