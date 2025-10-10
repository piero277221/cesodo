@extends('layouts.app')

@section('title', 'Panel de Módulos')

@section('content')
<div class="container-fluid py-4" style="background: var(--cesodo-gray-50); min-height: 100vh;">
    <!-- Header Mejorado -->
    <div class="text-center mb-5">
        <div class="d-inline-flex align-items-center justify-content-center mb-3"
             style="width: 80px; height: 80px; background: var(--cesodo-red); border-radius: 50%; box-shadow: var(--cesodo-shadow-lg);">
            <i class="bi bi-grid-3x3-gap text-white" style="font-size: 2rem;"></i>
        </div>

        <h1 class="display-5 fw-bold mb-3" style="color: var(--cesodo-black);">
            Panel de Módulos del Sistema
        </h1>

        <p class="lead text-muted mb-4 max-w-2xl mx-auto">
            Accede a todos los módulos de gestión de la concesionaria de comida desde aquí
        </p>

        <!-- Estadísticas rápidas -->
        <div class="row justify-content-center mb-4">
            <div class="col-auto">
                <div class="d-flex align-items-center gap-4">
                    <div class="text-center">
                        <div class="h4 mb-0 text-cesodo-red fw-bold">{{ auth()->user()->name }}</div>
                        <small class="text-muted">Usuario Actual</small>
                    </div>
                    <div class="vr"></div>
                    <div class="text-center">
                        <div class="h4 mb-0 text-cesodo-red fw-bold">{{ date('H:i') }}</div>
                        <small class="text-muted">Hora Actual</small>
                    </div>
                    <div class="vr"></div>
                    <div class="text-center">
                        <div class="h4 mb-0 text-cesodo-red fw-bold">{{ date('d/m/Y') }}</div>
                        <small class="text-muted">Fecha</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Módulos Grid -->
    <div class="row justify-content-center">

        <!-- Dashboard -->
        <x-module-card
            title="Dashboard"
            description="Panel principal con estadísticas y resumen del sistema"
            route="{{ route('dashboard') }}"
            icon="bi-speedometer2"
            color="primary"
        />

        <!-- Gestión de Personal -->
        <x-module-card
            title="Trabajadores"
            description="Gestión completa del personal y empleados"
            route="{{ route('trabajadores.index') }}"
            icon="bi-people"
            color="success"
            permission="ver-trabajadores"
        />

        <x-module-card
            title="Usuarios"
            description="Administración de usuarios del sistema"
            route="{{ route('usuarios.index') }}"
            icon="bi-person-gear"
            color="info"
            permission="ver-trabajadores"
        />

        <x-module-card
            title="Contratos"
            description="Gestión de contratos laborales"
            route="{{ route('contratos.index') }}"
            icon="bi-file-earmark-text"
            color="warning"
            permission="ver-trabajadores"
        />

        <x-module-card
            title="Personas"
            description="Registro de datos personales"
            route="{{ route('personas.index') }}"
            icon="bi-person-vcard"
            color="teal"
            permission="ver-trabajadores"
        />

        <!-- Operaciones -->
        <x-module-card
            title="Consumos"
            description="Control de consumos y gastos"
            route="{{ route('consumos.index') }}"
            icon="bi-journal-text"
            color="orange"
            permission="ver-consumos"
        />

        <!-- Inventario y Productos -->
        <x-module-card
            title="Inventario"
            description="Control de stock y almacén"
            route="{{ route('inventarios.index') }}"
            icon="bi-boxes"
            color="purple"
            permission="ver-inventario"
        />

                <x-module-card
            title="Menús"
            description="Planificación de menús semanales"
            route="{{ route('menus.index') }}"
            icon="bi-calendar-week"
            color="info"
            permission="ver-inventario"
        />

        <x-module-card
            title="Recetas"
            description="Gestión de recetas y platos"
            route="{{ route('recetas.index') }}"
            icon="bi-journal-bookmark"
            color="orange"
            permission="ver-inventario"
        />

        <!-- === INVENTARIO Y PRODUCTOS === -->
        <x-module-card
            title="Kardex"
            description="Historial de movimientos de inventario"
            route="{{ route('kardex.index') }}"
            icon="bi-clipboard-data"
            color="teal"
            permission="ver-inventario"
        />

        <x-module-card
            title="Categorías"
            description="Gestión de categorías de productos"
            route="{{ route('categorias.index') }}"
            icon="bi-tags"
            color="warning"
            permission="ver-productos"
        />

        <x-module-card
            title="Productos"
            description="Catálogo y gestión de productos"
            route="{{ route('productos.index') }}"
            icon="bi-box-seam"
            color="success"
            permission="ver-productos"
        />

        <!-- === COMERCIAL === -->
        <x-module-card
            title="Clientes"
            description="Gestión de clientes y contactos"
            route="{{ route('clientes.index') }}"
            icon="bi-people"
            color="info"
        />

        <x-module-card
            title="Ventas"
            description="Registro y control de ventas"
            route="{{ route('ventas.index') }}"
            icon="bi-receipt"
            color="success"
        />

        <x-module-card
            title="Pedidos"
            description="Gestión de pedidos y órdenes"
            route="{{ route('pedidos.index') }}"
            icon="bi-cart3"
            color="warning"
        />

        <!-- === COMPRAS === -->
        <x-module-card
            title="Proveedores"
            description="Gestión de proveedores y suministros"
            route="{{ route('proveedores.index') }}"
            icon="bi-truck"
            color="danger"
            permission="ver-proveedores"
        />

        <x-module-card
            title="Compras"
            description="Gestión de órdenes de compra"
            route="{{ route('compras.index') }}"
            icon="bi-bag"
            color="purple"
            permission="ver-proveedores"
        />

        <!-- === REPORTES === -->
        <x-module-card
            title="Reportes"
            description="Reportes y análisis del sistema"
            route="{{ route('reportes.index') }}"
            icon="bi-graph-up"
            color="primary"
        />

        <!-- === ADMINISTRACIÓN === -->
        <x-module-card
            title="Configuraciones"
            description="Configuración general del sistema"
            route="{{ route('configurations.index') }}"
            icon="bi-sliders"
            color="danger"
            permission="ver-configuraciones"
        />

        <x-module-card
            title="Gestión de Roles"
            description="Administración de roles y permisos"
            route="{{ route('role-management.index') }}"
            icon="bi-shield-lock"
            color="warning"
            permission="ver-configuraciones"
        />

        <x-module-card
            title="Campos Dinámicos"
            description="Configuración de campos personalizables"
            route="{{ route('dynamic-fields.index') }}"
            icon="bi-puzzle"
            color="info"
            permission="ver-configuraciones"
        />

        <x-module-card
            title="Plantillas de Contratos"
            description="Gestión de plantillas de contratos"
            route="{{ route('contratos.templates.index') }}"
            icon="bi-file-earmark-plus"
            color="teal"
            permission="ver-configuraciones"
        />
                    </div>
                            />

    </div>

    <!-- Footer -->
    <div class="text-center mt-5 py-4">
        <div class="text-muted">
            <small>
                © {{ date('Y') }} CESODO - Sistema de Gestión Integral
                <br>
                Desarrollado con ❤️ para optimizar tu gestión
            </small>
        </div>
    </div>
</div>
                <a href="{{ route('compras.index') }}" class="block h-full">
                    <div class="module-icon" style="background: var(--primary-color);">
                        <i class="bi bi-bag"></i>
                        <span class="new-badge">NUEVO</span>
                    </div>
                    <div class="module-content">
                        <h3 class="module-title">Compras</h3>
                        <p class="module-description">Gestión de compras y órdenes</p>
                    </div>
                </a>
            </div>

            <div class="module-card group">
                <a href="{{ route('pedidos.index') }}" class="block h-full">
                    <div class="module-icon" style="background: var(--warning-color);">
                        <i class="bi bi-cart3"></i>
                    </div>
                    <div class="module-content">
                        <h3 class="module-title">Pedidos</h3>
                        <p class="module-description">Gestión de pedidos internos</p>
                    </div>
                </a>
            </div>

            <!-- Reportes -->
            @can('ver-reportes')
            <div class="module-card group">
                <a href="{{ route('reportes.index') }}" class="block h-full">
                    <div class="module-icon" style="background: var(--gray-600);">
                        <i class="bi bi-graph-up"></i>
                    </div>
                    <div class="module-content">
                        <h3 class="module-title">Reportes</h3>
                        <p class="module-description">Informes y análisis del sistema</p>
                    </div>
                </a>
            </div>
            @endcan

            <!-- Configuraciones del Sistema -->
            @can('ver-configuraciones')
            <div class="module-card group">
                <a href="{{ route('configurations.index') }}" class="block h-full">
                    <div class="module-icon" style="background: linear-gradient(45deg, #6366f1, #8b5cf6);">
                        <i class="bi bi-gear-fill"></i>
                    </div>
                    <div class="module-content">
                        <h3 class="module-title">Configuraciones</h3>
                        <p class="module-description">Administración y configuración del sistema</p>
                    </div>
                </a>
            </div>
            @endcan

            <!-- Gestión Avanzada de Roles -->
            @can('ver-configuraciones')
            <div class="module-card group">
                <a href="{{ route('role-management.index') }}" class="block h-full">
                    <div class="module-icon" style="background: linear-gradient(45deg, #dc2626, #f59e0b);">
                        <i class="bi bi-shield-lock-fill"></i>
                    </div>
                    <div class="module-content">
                        <h3 class="module-title">Gestión de Roles</h3>
                        <p class="module-description">Administración avanzada de roles y permisos</p>
                    </div>
                </a>
            </div>
            @endcan

            <!-- Campos Dinámicos -->
            @can('ver-configuraciones')
            <div class="module-card group">
                <a href="{{ route('dynamic-fields.index') }}" class="block h-full">
                    <div class="module-icon" style="background: linear-gradient(45deg, #059669, #10b981);">
                        <i class="bi bi-puzzle-fill"></i>
                    </div>
                    <div class="module-content">
                        <h3 class="module-title">Campos Dinámicos</h3>
                        <p class="module-description">Sistema de extensibilidad para módulos</p>
                        <div class="mt-2">
                            <small class="text-primary">
                                <i class="fas fa-magic me-1"></i>
                                <a href="{{ route('dynamic-fields.form-builder') }}"
                                   class="text-decoration-none"
                                   onclick="event.stopPropagation(); window.location.href='{{ route('dynamic-fields.form-builder') }}'">
                                    Constructor Visual
                                </a>
                            </small>
                        </div>
                    </div>
                </a>
            </div>
            @endcan
        </div>

        <!-- Estadísticas rápidas - En 6 columnas más compactas -->
        <div style="display: grid; grid-template-columns: repeat(6, 1fr); gap: 0.75rem; max-width: 1200px; margin: 0 auto;">>
            <div class="stats-card">
                <div class="stats-icon" style="background: rgba(37, 99, 235, 0.1); color: var(--primary-color);">
                    <i class="bi bi-people"></i>
                </div>
                <div class="stats-content">
                    <h4 class="stats-number">{{ \App\Models\Trabajador::count() }}</h4>
                    <p class="stats-label">Trabajadores</p>
                </div>
            </div>

            <div class="stats-card">
                <div class="stats-icon" style="background: rgba(22, 163, 74, 0.1); color: var(--success-color);">
                    <i class="bi bi-box-seam"></i>
                </div>
                <div class="stats-content">
                    <h4 class="stats-number">{{ \App\Models\Producto::count() }}</h4>
                    <p class="stats-label">Productos</p>
                </div>
            </div>

            <div class="stats-card">
                <div class="stats-icon" style="background: rgba(139, 92, 246, 0.1); color: #8b5cf6;">
                    <i class="bi bi-people"></i>
                </div>
                <div class="stats-content">
                    <h4 class="stats-number">{{ \App\Models\Cliente::count() ?? 0 }}</h4>
                    <p class="stats-label">Clientes</p>
                </div>
            </div>

            <div class="stats-card">
                <div class="stats-icon" style="background: rgba(234, 88, 12, 0.1); color: var(--warning-color);">
                    <i class="bi bi-receipt"></i>
                </div>
                <div class="stats-content">
                    <h4 class="stats-number">{{ \App\Models\Venta::count() ?? 0 }}</h4>
                    <p class="stats-label">Ventas</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Variables CSS para asegurar compatibilidad */
:root {
    --primary-color: #2563eb;
    --success-color: #16a34a;
    --info-color: #0891b2;
    --warning-color: #ea580c;
    --danger-color: #dc2626;
    --gray-50: #f8fafc;
    --gray-600: #475569;
    --gray-800: #1e293b;
}

/* Estilos para las tarjetas de módulos - 3 columnas optimizado */
.module-card {
    background: white;
    border-radius: 0.5rem;
    box-shadow: 0 2px 4px -1px rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.06);
    transition: all 0.3s ease;
    transform: translateY(0);
    cursor: pointer;
    overflow: hidden;
    border: 1px solid #f3f4f6;
    height: 180px; /* Altura más cómoda para 3 columnas */
    width: 100%; /* Asegurar que use todo el ancho disponible */
    display: flex;
    flex-direction: column;
}

.module-card:hover {
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    transform: translateY(-2px);
}

.module-icon {
    height: 4.5rem; /* Más espacio para el ícono */
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.75rem; /* Íconos más grandes */
    position: relative;
    transition: transform 0.3s ease;
    flex-shrink: 0;
}

.module-card:hover .module-icon {
    transform: scale(1.05);
}

.new-badge {
    position: absolute;
    top: 8px;
    right: 8px;
    background: linear-gradient(45deg, #ff6b6b, #ff8e8e);
    color: white;
    font-size: 10px;
    font-weight: bold;
    padding: 2px 6px;
    border-radius: 8px;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

.module-content {
    padding: 1rem 0.75rem; /* Más padding para 3 columnas */
    transition: transform 0.3s ease;
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.module-card:hover .module-content {
    transform: translateY(-1px);
}

.module-title {
    font-size: 1rem; /* Texto más legible */
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.25rem;
    line-height: 1.2;
    text-align: center;
}

.module-description {
    font-size: 0.8rem; /* Más legible */
    color: #6b7280;
    line-height: 1.3;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-align: center;
}

.new-module {
    position: relative;
    animation: glow 3s ease-in-out infinite alternate;
}

@keyframes glow {
    from { box-shadow: 0 4px 20px rgba(139, 92, 246, 0.3); }
    to { box-shadow: 0 8px 30px rgba(139, 92, 246, 0.5); }
}

/* Estilos para las estadísticas - Versión ultra compacta */
.stats-card {
    background: white;
    border-radius: 0.5rem;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
    padding: 0.75rem; /* Reducido aún más */
    display: flex;
    align-items: center;
    gap: 0.5rem; /* Reducido */
    transition: box-shadow 0.3s ease;
    height: 70px; /* Altura más pequeña */
}

.stats-card:hover {
    box-shadow: 0 2px 4px -1px rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.06);
}

.stats-icon {
    width: 2rem; /* Reducido */
    height: 2rem;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.875rem; /* Reducido */
    flex-shrink: 0;
}

.stats-content {
    flex: 1;
    min-width: 0;
}

.stats-number {
    font-size: 1.1rem; /* Reducido */
    font-weight: bold;
    color: #1f2937;
    line-height: 1.1;
}

.stats-label {
    font-size: 0.65rem; /* Muy pequeño */
    color: #6b7280;
    line-height: 1.1;
}
</style>
@endsection
