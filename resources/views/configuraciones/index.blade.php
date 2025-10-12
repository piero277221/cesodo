@extends('layouts.app')

@section('title', 'Configuraciones del Sistema')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1">
                                <i class="bi bi-sliders me-2"></i>
                                Configuraciones del Sistema
                            </h4>
                            <p class="text-muted mb-0">
                                <i class="bi bi-info-circle me-1"></i>
                                Personaliza y configura tu sistema de manera fácil
                            </p>
                        </div>
                        <div>
                            <span class="badge bg-success">
                                <i class="bi bi-check-circle me-1"></i>
                                Sistema Activo
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mensajes de éxito/error -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Tabs de Configuración -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <!-- Nav Tabs -->
                    <ul class="nav nav-tabs nav-fill border-bottom-0" role="tablist" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);">
                        @foreach($categorias as $key => $categoria)
                            <li class="nav-item" role="presentation">
                                <a class="nav-link {{ $tab === $key ? 'active' : '' }} text-white"
                                   href="?tab={{ $key }}"
                                   style="border: none; padding: 1.2rem 1.5rem; {{ $tab === $key ? 'background: #dc3545; font-weight: 600;' : '' }}">
                                    <i class="bi {{ $categoria['icono'] }} me-2" style="font-size: 1.2rem;"></i>
                                    <div class="d-none d-md-inline">
                                        <div style="font-size: 0.95rem;">{{ $categoria['nombre'] }}</div>
                                        <small class="d-block mt-1" style="opacity: 0.8; font-size: 0.75rem;">{{ $categoria['descripcion'] }}</small>
                                    </div>
                                    <div class="d-inline d-md-none">{{ explode(' ', $categoria['nombre'])[0] }}</div>
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content p-4">
                        <!-- Tab: Empresa -->
                        @if($tab === 'empresa')
                            @include('configuraciones.tabs.empresa')
                        @endif

                        <!-- Tab: Sistema -->
                        @if($tab === 'sistema')
                            @include('configuraciones.tabs.sistema')
                        @endif

                        <!-- Tab: Permisos -->
                        @if($tab === 'permisos')
                            @include('configuraciones.tabs.permisos')
                        @endif

                        <!-- Tab: Notificaciones -->
                        @if($tab === 'notificaciones')
                            @include('configuraciones.tabs.notificaciones')
                        @endif

                        <!-- Tab: Interfaz -->
                        @if($tab === 'interfaz')
                            @include('configuraciones.tabs.interfaz')
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.nav-tabs .nav-link {
    transition: all 0.3s ease;
}

.nav-tabs .nav-link:hover:not(.active) {
    background: rgba(220, 53, 69, 0.1) !important;
    transform: translateY(-2px);
}

.nav-tabs .nav-link.active {
    border-bottom: 3px solid #dc3545 !important;
}

.card {
    transition: transform 0.2s, box-shadow 0.2s;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

/* Prevenir el loading infinito de imágenes */
img {
    image-rendering: auto;
    -webkit-image-rendering: auto;
}

img[src=""],
img:not([src]),
img[src="#"] {
    opacity: 0;
    visibility: hidden;
}

/* Loading states optimizados */
.logo-preview-container img,
.icon-preview-container img {
    transition: opacity 0.3s ease;
    background: #f8f9fa;
}

.logo-preview-container img[src*="default"],
.icon-preview-container img[src*="default"] {
    opacity: 1;
}

/* Evitar parpadeo */
form {
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}
</style>

<script>
// Prevenir loading infinito al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    // Forzar que las imágenes se carguen correctamente
    const images = document.querySelectorAll('img[id*="Preview"]');
    images.forEach(img => {
        if (!img.complete || img.naturalHeight === 0) {
            img.onerror = function() {
                console.log('Error loading image:', this.id);
                // No hacer nada, dejar la imagen por defecto
            };
        }
    });

    // Remover cualquier loading overlay que pueda quedar
    const loadingOverlays = document.querySelectorAll('#loadingOverlay, .loading-overlay');
    loadingOverlays.forEach(overlay => overlay.remove());
});
</script>
@endsection
