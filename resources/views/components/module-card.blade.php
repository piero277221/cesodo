{{-- Componente de Tarjeta de Módulo --}}
@props([
    'title',
    'description' => '',
    'route' => '#',
    'icon' => 'bi-box',
    'color' => 'primary',
    'count' => null,
    'permission' => null
])

@php
// Paleta unificada: solo negro, rojo y blanco con variaciones
$colorClasses = [
    'primary' => 'bg-gradient-red',        // Rojo principal
    'success' => 'bg-gradient-black',      // Negro
    'info' => 'bg-gradient-red-light',     // Rojo claro
    'warning' => 'bg-gradient-red-dark',   // Rojo oscuro
    'danger' => 'bg-gradient-red',         // Rojo principal
    'purple' => 'bg-gradient-black-light', // Negro claro
    'orange' => 'bg-gradient-red-light',   // Rojo claro
    'teal' => 'bg-gradient-black'          // Negro
];
$bgClass = $colorClasses[$color] ?? $colorClasses['primary'];
@endphp

@if(!$permission || auth()->user()->can($permission))
<div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-4">
    <a href="{{ $route }}" class="text-decoration-none">
        <div class="card module-card h-100 {{ $bgClass }} animate-fade-in">
            <div class="card-body d-flex flex-column justify-content-between text-white position-relative overflow-hidden">
                <!-- Icono de fondo decorativo -->
                <div class="module-bg-icon">
                    <i class="{{ $icon }}"></i>
                </div>

                <!-- Contenido principal -->
                <div class="module-content">
                    <div class="d-flex align-items-center mb-3">
                        <div class="module-icon me-3">
                            <i class="{{ $icon }}"></i>
                        </div>
                        @if($count !== null)
                            <div class="module-count ms-auto">
                                <span class="badge bg-white text-dark fs-6 px-3 py-2">{{ $count }}</span>
                            </div>
                        @endif
                    </div>

                    <h5 class="card-title mb-2 fw-bold">{{ $title }}</h5>

                    @if($description)
                        <p class="card-text small opacity-90 mb-0">{{ $description }}</p>
                    @endif
                </div>

                <!-- Indicador de acceso -->
                <div class="module-arrow mt-3">
                    <i class="bi bi-arrow-right-circle fs-5"></i>
                </div>
            </div>

            <!-- Efecto hover -->
            <div class="module-overlay"></div>

            <!-- Overlay adicional para contraste -->
            <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(135deg, rgba(0,0,0,0.15) 0%, rgba(0,0,0,0.25) 100%); z-index: 1; pointer-events: none;"></div>
        </div>
    </a>
</div>
@endif

<style>
/* Gradientes para módulos */
/* Gradientes unificados - Solo paleta Negro, Rojo, Blanco */
.bg-gradient-red {
    background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%) !important;
    border: 2px solid #991b1b !important;
}

.bg-gradient-red-light {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
    border: 2px solid #b91c1c !important;
}

.bg-gradient-red-dark {
    background: linear-gradient(135deg, #b91c1c 0%, #991b1b 100%) !important;
    border: 2px solid #7f1d1d !important;
}

.bg-gradient-black {
    background: linear-gradient(135deg, #1a1a1a 0%, #0a0a0a 100%) !important;
    border: 2px solid #000000 !important;
}

.bg-gradient-black-light {
    background: linear-gradient(135deg, #2d2d2d 0%, #1a1a1a 100%) !important;
    border: 2px solid #0a0a0a !important;
}

/* Compatibilidad con nombres antiguos */
.bg-gradient-primary { background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%) !important; border: 2px solid #991b1b !important; }
.bg-gradient-success { background: linear-gradient(135deg, #1a1a1a 0%, #0a0a0a 100%) !important; border: 2px solid #000000 !important; }
.bg-gradient-info { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important; border: 2px solid #b91c1c !important; }
.bg-gradient-warning { background: linear-gradient(135deg, #b91c1c 0%, #991b1b 100%) !important; border: 2px solid #7f1d1d !important; }
.bg-gradient-danger { background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%) !important; border: 2px solid #991b1b !important; }
.bg-gradient-purple { background: linear-gradient(135deg, #2d2d2d 0%, #1a1a1a 100%) !important; border: 2px solid #0a0a0a !important; }
.bg-gradient-orange { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important; border: 2px solid #b91c1c !important; }
.bg-gradient-teal { background: linear-gradient(135deg, #1a1a1a 0%, #0a0a0a 100%) !important; border: 2px solid #000000 !important; }

/* Estilos de la tarjeta de módulo */
.module-card {
    border: none !important;
    border-radius: 16px !important;
    transition: all 0.3s ease !important;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.25), 0 8px 10px -6px rgba(0, 0, 0, 0.15) !important;
    position: relative;
    overflow: hidden;
    min-height: 200px;
    opacity: 1 !important;
}

.module-card:hover {
    transform: translateY(-8px) scale(1.02) !important;
    box-shadow: 0 20px 40px -5px rgba(0, 0, 0, 0.3), 0 10px 20px -5px rgba(0, 0, 0, 0.2) !important;
}

.module-card .card-body {
    padding: 2rem !important;
    min-height: 200px !important;
    position: relative !important;
    z-index: 15 !important;
}

/* Icono principal del módulo */
.module-icon {
    width: 60px !important;
    height: 60px !important;
    background: rgba(255, 255, 255, 0.35) !important;
    border-radius: 50% !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    backdrop-filter: blur(10px) !important;
    border: 3px solid rgba(255, 255, 255, 0.6) !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3) !important;
    position: relative !important;
    z-index: 25 !important;
}

.module-icon i {
    font-size: 1.75rem !important;
    color: white !important;
    text-shadow: 0 3px 8px rgba(0, 0, 0, 0.8), 0 1px 3px rgba(0, 0, 0, 0.6) !important;
}

/* Icono de fondo decorativo */
.module-bg-icon {
    position: absolute;
    top: -40px;
    right: -40px;
    width: 140px;
    height: 140px;
    opacity: 0.15;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1;
}

.module-bg-icon i {
    font-size: 7rem;
    color: white;
}

/* Contenido del módulo */
.module-content {
    position: relative !important;
    z-index: 20 !important;
    flex: 1 !important;
}

.module-card .card-title {
    color: white !important;
    text-shadow: 0 2px 8px rgba(0, 0, 0, 0.8), 0 1px 3px rgba(0, 0, 0, 0.6) !important;
    font-weight: 700 !important;
    font-size: 1.3rem !important;
    margin-bottom: 0.75rem !important;
    letter-spacing: 0.5px !important;
}

.module-card .card-text {
    color: rgba(255, 255, 255, 1) !important;
    text-shadow: 0 2px 6px rgba(0, 0, 0, 0.7), 0 1px 3px rgba(0, 0, 0, 0.5) !important;
    font-weight: 600 !important;
    line-height: 1.4 !important;
    font-size: 0.95rem !important;
}

/* Contador del módulo */
.module-count .badge {
    border-radius: var(--cesodo-radius-lg);
    font-weight: 600;
    box-shadow: var(--cesodo-shadow-sm);
}

/* Flecha de acceso */
.module-arrow {
    text-align: right;
    position: relative;
    z-index: 2;
    opacity: 0.8;
    transition: all var(--cesodo-transition-fast);
}

.module-card:hover .module-arrow {
    opacity: 1;
    transform: translateX(5px);
}

/* Overlay de hover */
.module-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.1);
    opacity: 0;
    transition: all var(--cesodo-transition-fast);
    z-index: 1;
}

.module-card:hover .module-overlay {
    opacity: 1;
}

/* Animaciones */
@keyframes moduleFloat {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-5px); }
}

.module-card:hover {
    animation: moduleFloat 2s ease-in-out infinite;
}

/* Responsive */
@media (max-width: 768px) {
    .module-card .card-body {
        padding: 1.5rem;
        min-height: 160px;
    }

    .module-icon {
        width: 40px;
        height: 40px;
    }

    .module-icon i {
        font-size: 1.25rem;
    }

    .module-bg-icon {
        width: 100px;
        height: 100px;
    }

    .module-bg-icon i {
        font-size: 5rem;
    }
}
</style>
