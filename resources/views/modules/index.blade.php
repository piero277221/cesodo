@extends('layouts.app')

@section('content')
<div class="min-h-screen" style="background: var(--gray-50);">
    <div class="container mx-auto px-4 py-4"> <!-- Reducido el padding vertical -->
        <!-- Header Ultra Compacto -->
        <div class="text-center mb-6"> <!-- Reducido el margen -->
            <h1 class="text-2xl font-bold mb-2" style="color: var(--gray-800);"> <!-- Título más pequeño -->
                <i class="bi bi-grid-3x3-gap me-2" style="color: var(--primary-color);"></i>
                Panel de Módulos del Sistema
            </h1>
            <p class="text-sm max-w-2xl mx-auto" style="color: var(--gray-600);"> <!-- Texto más pequeño -->
                Accede a todos los módulos de gestión de la concesionaria de comida desde aquí
            </p>
        </div>

        <!-- Módulos Grid - Forzar 3 columnas -->
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; max-width: 1200px; margin: 0 auto 2rem auto;">

            <!-- Dashboard -->
            <div class="module-card group">
                <a href="{{ route('dashboard') }}" class="block h-full">
                    <div class="module-icon" style="background: var(--primary-color);">
                        <i class="bi bi-speedometer2"></i>
                    </div>
                    <div class="module-content">
                        <h3 class="module-title">Dashboard</h3>
                        <p class="module-description">Panel principal con estadísticas y resumen del sistema</p>
                    </div>
                </a>
            </div>

            <!-- Gestión de Personal -->
            @can('ver-trabajadores')
            <div class="module-card group">
                <a href="{{ route('trabajadores.index') }}" class="block h-full">
                    <div class="module-icon" style="background: var(--success-color);">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="module-content">
                        <h3 class="module-title">Trabajadores</h3>
                        <p class="module-description">Gestión completa del personal y empleados</p>
                    </div>
                </a>
            </div>
            @endcan

            @can('ver-trabajadores')
            <div class="module-card group">
                <a href="{{ route('usuarios.index') }}" class="block h-full">
                    <div class="module-icon" style="background: var(--info-color);">
                        <i class="bi bi-person-gear"></i>
                    </div>
                    <div class="module-content">
                        <h3 class="module-title">Usuarios</h3>
                        <p class="module-description">Administración de usuarios del sistema</p>
                    </div>
                </a>
            </div>
            @endcan

            @can('ver-trabajadores')
            <div class="module-card group">
                <a href="{{ route('contratos.index') }}" class="block h-full">
                    <div class="module-icon" style="background: var(--warning-color);">
                        <i class="bi bi-file-earmark-text"></i>
                    </div>
                    <div class="module-content">
                        <h3 class="module-title">Contratos</h3>
                        <p class="module-description">Gestión de contratos laborales</p>
                    </div>
                </a>
            </div>
            @endcan

            @can('ver-trabajadores')
            <div class="module-card group">
                <a href="{{ route('personas.index') }}" class="block h-full">
                    <div class="module-icon" style="background: #0891b2;">
                        <i class="bi bi-person-vcard"></i>
                    </div>
                    <div class="module-content">
                        <h3 class="module-title">Personas</h3>
                        <p class="module-description">Registro de datos personales</p>
                    </div>
                </a>
            </div>
            @endcan

            <!-- Operaciones -->
            @can('ver-consumos')
            <div class="module-card group">
                <a href="{{ route('consumos.index') }}" class="block h-full">
                    <div class="module-icon" style="background: var(--warning-color);">
                        <i class="bi bi-journal-text"></i>
                    </div>
                    <div class="module-content">
                        <h3 class="module-title">Consumos</h3>
                        <p class="module-description">Control de consumos y gastos</p>
                    </div>
                </a>
            </div>
            @endcan

            <!-- Inventario y Productos -->
            @can('ver-inventario')
            <div class="module-card group">
                <a href="{{ route('inventarios.index') }}" class="block h-full">
                    <div class="module-icon bg-gradient-to-br from-indigo-500 to-indigo-600">
                        <i class="bi bi-boxes"></i>
                    </div>
                    <div class="module-content">
                        <h3 class="module-title">Inventario</h3>
                        <p class="module-description">Control de stock y almacén</p>
                    </div>
                </a>
            </div>
            @endcan

            @can('ver-inventario')
            <div class="module-card group">
                <a href="{{ route('menus.index') }}" class="block h-full">
                    <div class="module-icon bg-gradient-to-br from-pink-500 to-pink-600">
                        <i class="bi bi-calendar-week"></i>
                    </div>
                    <div class="module-content">
                        <h3 class="module-title">Menús</h3>
                        <p class="module-description">Planificación de menús semanales</p>
                    </div>
                </a>
            </div>
            @endcan

            @can('ver-inventario')
            <div class="module-card group">
                <a href="{{ route('recetas.index') }}" class="block h-full">
                    <div class="module-icon bg-gradient-to-br from-orange-500 to-orange-600">
                        <i class="bi bi-journal-bookmark"></i>
                    </div>
                    <div class="module-content">
                        <h3 class="module-title">Recetas</h3>
                        <p class="module-description">Gestión de recetas y platos</p>
                    </div>
                </a>
            </div>
            @endcan

            @can('ver-inventario')
            <div class="module-card group">
                <a href="{{ route('kardex.index') }}" class="block h-full">
                    <div class="module-icon bg-gradient-to-br from-cyan-500 to-cyan-600">
                        <i class="bi bi-clipboard-data"></i>
                    </div>
                    <div class="module-content">
                        <h3 class="module-title">Kardex</h3>
                        <p class="module-description">Historial de movimientos de inventario</p>
                    </div>
                </a>
            </div>
            @endcan

            @can('ver-productos')
            <div class="module-card group">
                <a href="{{ route('categorias.index') }}" class="block h-full">
                    <div class="module-icon" style="background: var(--warning-color);">
                        <i class="bi bi-tags"></i>
                    </div>
                    <div class="module-content">
                        <h3 class="module-title">Categorías</h3>
                        <p class="module-description">Gestión de categorías de productos</p>
                    </div>
                </a>
            </div>
            @endcan

            @can('ver-productos')
            <div class="module-card group">
                <a href="{{ route('productos.index') }}" class="block h-full">
                    <div class="module-icon" style="background: var(--success-color);">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <div class="module-content">
                        <h3 class="module-title">Productos</h3>
                        <p class="module-description">Catálogo y gestión de productos</p>
                    </div>
                </a>
            </div>
            @endcan

            @can('ver-proveedores')
            <div class="module-card group">
                <a href="{{ route('proveedores.index') }}" class="block h-full">
                    <div class="module-icon" style="background: var(--danger-color);">
                        <i class="bi bi-truck"></i>
                    </div>
                    <div class="module-content">
                        <h3 class="module-title">Proveedores</h3>
                        <p class="module-description">Gestión de proveedores y suministros</p>
                    </div>
                </a>
            </div>
            @endcan

            <!-- Comerciales - Nuevos Módulos -->
            <div class="module-card group new-module">
                <a href="{{ route('clientes.index') }}" class="block h-full">
                    <div class="module-icon" style="background: #8b5cf6;">
                        <i class="bi bi-people"></i>
                        <span class="new-badge">NUEVO</span>
                    </div>
                    <div class="module-content">
                        <h3 class="module-title">Clientes</h3>
                        <p class="module-description">Gestión completa de clientes</p>
                    </div>
                </a>
            </div>

            <div class="module-card group new-module">
                <a href="{{ route('ventas.index') }}" class="block h-full">
                    <div class="module-icon" style="background: var(--success-color);">
                        <i class="bi bi-receipt"></i>
                        <span class="new-badge">NUEVO</span>
                    </div>
                    <div class="module-content">
                        <h3 class="module-title">Ventas</h3>
                        <p class="module-description">Sistema de facturación y ventas</p>
                    </div>
                </a>
            </div>

            <div class="module-card group new-module">
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
