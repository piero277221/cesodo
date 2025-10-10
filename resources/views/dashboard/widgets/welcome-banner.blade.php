<div class="widget-container" data-widget-id="{{ $widget->widget_id }}">
    <div class="widget-content p-0">
        <div class="welcome-banner @if($config['background_gradient'] ?? true) bg-gradient @endif">
            <div class="welcome-content">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="welcome-text">
                            <h1 class="welcome-title">
                                <i class="fas fa-tachometer-alt me-3"></i>
                                Dashboard - Sistema SCM Cesodo
                            </h1>
                            <p class="welcome-subtitle mb-0">
                                @if($config['show_user_name'] ?? true)
                                    Bienvenido de vuelta, {{ Auth::user()->name }}.
                                @endif
                                @if($config['custom_message'])
                                    {{ $config['custom_message'] }}
                                @else
                                    Panel de control y análisis del sistema.
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <div class="welcome-info">
                            @if($config['show_date'] ?? true)
                            <div class="welcome-date h4 mb-1">
                                {{ now()->locale('es')->translatedFormat('d/m/Y') }}
                            </div>
                            @endif
                            @if($config['show_time'] ?? true)
                            <div class="welcome-time opacity-75" id="currentTime">
                                {{ now()->locale('es')->translatedFormat('H:i:s') }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Widget Controls (minimized) -->
            <div class="widget-controls-mini">
                <button class="btn btn-sm btn-outline-light widget-config" title="Configurar">
                    <i class="fas fa-cog"></i>
                </button>
                <button class="btn btn-sm btn-outline-light widget-remove" title="Eliminar">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.welcome-banner {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 15px;
    padding: 2rem;
    position: relative;
    overflow: hidden;
    min-height: 120px;
}

.welcome-banner::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 200px;
    height: 200px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    opacity: 0.5;
}

.welcome-content {
    position: relative;
    z-index: 2;
}

.welcome-title {
    font-size: 1.75rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.welcome-subtitle {
    opacity: 0.9;
    font-size: 1rem;
}

.welcome-info {
    text-align: right;
}

.welcome-date {
    font-weight: 600;
}

.welcome-time {
    font-size: 0.9rem;
}

.widget-controls-mini {
    position: absolute;
    top: 1rem;
    right: 1rem;
    display: flex;
    gap: 0.5rem;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.widget-container:hover .widget-controls-mini {
    opacity: 1;
}

.widget-controls-mini .btn {
    border-color: rgba(255, 255, 255, 0.3);
    color: rgba(255, 255, 255, 0.8);
    padding: 0.25rem 0.5rem;
}

.widget-controls-mini .btn:hover {
    background: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.5);
    color: white;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .welcome-banner {
        padding: 1.5rem;
    }
    
    .welcome-title {
        font-size: 1.5rem;
    }
    
    .welcome-info {
        text-align: left;
        margin-top: 1rem;
    }
}
</style>

<script>
// Actualizar hora cada segundo si está configurado
@if($config['show_time'] ?? true)
setInterval(function() {
    const now = new Date();
    const timeString = now.toLocaleTimeString('es-ES');
    const timeElement = document.getElementById('currentTime');
    if (timeElement) {
        timeElement.textContent = timeString;
    }
}, 1000);
@endif
</script>