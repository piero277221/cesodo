@extends('layouts.app')

@section('title', 'Panel de Módulos')

@section('content')
<div class="container-fluid py-4" style="background: var(--cesodo-gray-50); min-height: 100vh;">
    <!-- Header Mejorado -->
    <div class="text-center mb-5">
        <div class="d-inline-flex align-items-center justify-content-center mb-3"
             style="width: 80px; height: 80px; background: #dc2626; border-radius: 50%; box-shadow: 0 10px 25px rgba(220, 38, 38, 0.3);">
            <i class="bi bi-grid-3x3-gap text-white" style="font-size: 2rem;"></i>
        </div>

        <h1 class="display-5 fw-bold mb-3" style="color: #1a1a1a;">
            Panel de Módulos del Sistema
        </h1>

        <p class="lead mb-4 max-w-2xl mx-auto" style="color: #6b7280;">
            Accede a todos los módulos de gestión de la concesionaria de comida desde aquí
        </p>

        <!-- Estadísticas rápidas -->
        <div class="row justify-content-center mb-4">
            <div class="col-auto">
                <div class="d-flex align-items-center" style="gap: 2rem; background: white; padding: 1.5rem 3rem; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                    <div class="text-center">
                        <div class="h4 mb-0 fw-bold" style="color: #dc2626;">{{ auth()->user()->name }}</div>
                        <small style="color: #6b7280; font-weight: 500;">Usuario Actual</small>
                    </div>
                    <div class="vr" style="height: 40px; opacity: 0.3;"></div>
                    <div class="text-center">
                        <div class="h4 mb-0 fw-bold" style="color: #dc2626;">{{ now()->setTimezone('America/Lima')->format('H:i') }}</div>
                        <small style="color: #6b7280; font-weight: 500;">Hora Perú</small>
                    </div>
                    <div class="vr" style="height: 40px; opacity: 0.3;"></div>
                    <div class="text-center">
                        <div class="h4 mb-0 fw-bold" style="color: #dc2626;">{{ now()->setTimezone('America/Lima')->format('d/m/Y') }}</div>
                        <small style="color: #6b7280; font-weight: 500;">Fecha</small>
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

        <!-- === GESTIÓN DE PERSONAL === -->
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

        <!-- === OPERACIONES === -->
        <x-module-card
            title="Consumos"
            description="Control de consumos y gastos"
            route="{{ route('consumos.index') }}"
            icon="bi-journal-text"
            color="orange"
            permission="ver-consumos"
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
            title="Inventario"
            description="Control de stock y almacén"
            route="{{ route('inventarios.index') }}"
            icon="bi-boxes"
            color="purple"
            permission="ver-inventario"
        />

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

<style>
/* Forzar visibilidad de tarjetas de módulos */
.module-card {
    opacity: 1 !important;
    visibility: visible !important;
}

/* Gradientes con paleta Negro, Rojo, Blanco unificada */
.bg-gradient-primary { background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%) !important; }
.bg-gradient-success { background: linear-gradient(135deg, #1a1a1a 0%, #0a0a0a 100%) !important; }
.bg-gradient-info { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important; }
.bg-gradient-warning { background: linear-gradient(135deg, #b91c1c 0%, #991b1b 100%) !important; }
.bg-gradient-danger { background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%) !important; }
.bg-gradient-purple { background: linear-gradient(135deg, #2d2d2d 0%, #1a1a1a 100%) !important; }
.bg-gradient-orange { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important; }
.bg-gradient-teal { background: linear-gradient(135deg, #1a1a1a 0%, #0a0a0a 100%) !important; }

/* Texto visible siempre */
.module-card .card-title,
.module-card .card-text {
    color: white !important;
    text-shadow: 0 2px 8px rgba(0, 0, 0, 0.8) !important;
}

/* Iconos visibles */
.module-icon i {
    color: white !important;
    text-shadow: 0 2px 8px rgba(0, 0, 0, 0.8) !important;
}
</style>
@endsection
