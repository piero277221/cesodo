@php
    $currentRoute = request()->route() ? request()->route()->getName() : '';
@endphp

<!-- Navbar principal -->
<nav x-data="{ open: false }" class="bg-cesodo-black border-b-4 border-cesodo-red fixed-top shadow-lg" style="height: var(--header-height); z-index: 1050; background: linear-gradient(135deg, var(--cesodo-black) 0%, var(--cesodo-black-light) 100%);">
    <!-- Incluir el tema CSS -->
    <link rel="stylesheet" href="{{ asset('css/cesodo-theme.css') }}">
    <div class="w-full mx-auto px-1 h-full">
        <div class="flex items-center h-full" style="justify-content: flex-start;">
            <!-- Logo y Toggle Sidebar -->
            <div class="flex items-center flex-shrink-0" style="margin-left: -15px; margin-right: 15px;">
                <button id="sidebar-toggle" class="p-2 rounded-md lg:hidden">
                    <i class="bi bi-list"></i>
                </button>
                <a href="{{ route('modules.index') }}" class="flex items-center group transition-all duration-300">
                    <x-application-logo style="width: 36px; height: 36px;" class="block fill-current text-cesodo-red group-hover:scale-110 transition-transform duration-300" />
                    <span class="ml-3 text-xl font-bold text-cesodo-white group-hover:text-cesodo-red transition-colors duration-300" style="font-family: var(--cesodo-font-family);">CESODO</span>
                </a>
            </div>

                    <!-- Container scrolleable con gradientes -->
                    <div class="nav-wrapper" style="overflow: visible;">
                        <div class="nav-gradient nav-gradient-left"></div>
                        <div id="nav-container" class="nav-container">
                            <div class="nav-inner">
                            <!-- Inicio y Dashboard -->
                            <x-nav-link :href="route('modules.index')" :active="request()->routeIs('modules.*')">
                                <i class="bi bi-grid-3x3-gap me-1"></i>{{ __('Módulos') }}
                            </x-nav-link>

                            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                                <i class="bi bi-speedometer2 me-1"></i>{{ __('Dashboard') }}
                            </x-nav-link>

                            <!-- Enlace simple de Reportes para test -->
                            <x-nav-link :href="route('reportes.index')" :active="request()->routeIs('reportes.*')">
                                <i class="bi bi-graph-up me-1"></i>{{ __('Reportes') }}
                            </x-nav-link>

                            <!-- Grupo: Gestión de Personal -->
                            @canany(['ver-trabajadores', 'ver-usuarios'])
                            <div class="nav-dropdown" id="dropdown-personal">
                                <button type="button" class="nav-dropdown-trigger {{ request()->routeIs(['trabajadores.*', 'usuarios.*', 'contratos.*', 'personas.*', 'certificados-medicos.*']) ? 'active' : '' }}"
                                        onclick="event.preventDefault(); event.stopPropagation(); toggleNav('dropdown-personal');">
                                    <i class="bi bi-people-fill me-1"></i>{{ __('Personal') }}
                                    <i class="bi bi-chevron-down ms-1"></i>
                                </button>
                                <div class="nav-dropdown-menu" style="display: none;">
                                    @can('ver-trabajadores')
                                    <a href="{{ route('personas.index') }}" class="nav-dropdown-item {{ request()->routeIs('personas.*') ? 'active' : '' }}">
                                        <i class="bi bi-person-vcard me-1"></i>{{ __('Personas') }}
                                    </a>
                                    <a href="{{ route('trabajadores.index') }}" class="nav-dropdown-item {{ request()->routeIs('trabajadores.*') ? 'active' : '' }}">
                                        <i class="bi bi-people me-1"></i>{{ __('Trabajadores') }}
                                    </a>
                                    <a href="{{ route('contratos.index') }}" class="nav-dropdown-item {{ request()->routeIs('contratos.*') ? 'active' : '' }}">
                                        <i class="bi bi-file-earmark-text me-1"></i>{{ __('Contratos') }}
                                    </a>
                                    @endcan
                                    @can('ver-inventario')
                                    <a href="{{ route('certificados-medicos.index') }}" class="nav-dropdown-item {{ request()->routeIs('certificados-medicos.*') ? 'active' : '' }}">
                                        <i class="bi bi-file-medical me-1"></i>{{ __('Certificados Médicos') }}
                                    </a>
                                    @endcan
                                    @can('ver-usuarios')
                                    <a href="{{ route('usuarios.index') }}" class="nav-dropdown-item {{ request()->routeIs('usuarios.*') ? 'active' : '' }}">
                                        <i class="bi bi-person-gear me-1"></i>{{ __('Usuarios') }}
                                    </a>
                                    @endcan
                                </div>
                            </div>
                            @endcanany

                            <!-- Grupo: Inventario y Productos -->
                            @canany(['ver-inventario', 'ver-productos'])
                            <div class="nav-dropdown nav-item-container" id="dropdown-inventario">
                                <button type="button" class="nav-dropdown-trigger d-inline-flex align-items-center gap-2 {{ request()->routeIs(['inventarios.*', 'productos.*', 'categorias.*', 'kardex.*']) ? 'active' : '' }}"
                                        onclick="event.preventDefault(); event.stopPropagation(); toggleNav('dropdown-inventario');">
                                    <i class="bi bi-boxes"></i>
                                    <span class="d-none d-lg-inline">{{ __('Inventario') }}</span>
                                    <span class="d-lg-none" title="{{ __('Inventario') }}">
                                        <i class="bi bi-boxes-fill"></i>
                                    </span>
                                    <i class="bi bi-chevron-down"></i>
                                </button>
                                <div class="nav-dropdown-menu shadow-sm border" style="display: none; min-width: 220px;">
                                    <div class="py-2">
                                        <div class="px-3 pb-2 text-sm font-weight-bold border-bottom">
                                            {{ __('Gestión de Inventario') }}
                                        </div>
                                        @can('ver-productos')
                                        <a href="{{ route('categorias.index') }}" class="nav-dropdown-item d-flex align-items-center gap-2 {{ request()->routeIs('categorias.*') ? 'active' : '' }}">
                                            <i class="bi bi-tags"></i>
                                            <div>
                                                <span class="d-block">{{ __('Categorías') }}</span>
                                                <small class="text-muted">Organiza tus productos</small>
                                            </div>
                                        </a>
                                        <a href="{{ route('productos.index') }}" class="nav-dropdown-item d-flex align-items-center gap-2 {{ request()->routeIs('productos.*') ? 'active' : '' }}">
                                            <i class="bi bi-box-seam"></i>
                                            <div>
                                                <span class="d-block">{{ __('Productos') }}</span>
                                                <small class="text-muted">Catálogo de productos</small>
                                            </div>
                                        </a>
                                        @endcan
                                        @can('ver-inventario')
                                        <a href="{{ route('inventarios.index') }}" class="nav-dropdown-item d-flex align-items-center gap-2 {{ request()->routeIs('inventarios.*') ? 'active' : '' }}">
                                            <i class="bi bi-boxes"></i>
                                            <div>
                                                <span class="d-block">{{ __('Stock') }}</span>
                                                <small class="text-muted">Control de existencias</small>
                                            </div>
                                        </a>
                                        <a href="{{ route('kardex.index') }}" class="nav-dropdown-item d-flex align-items-center gap-2 {{ request()->routeIs('kardex.*') ? 'active' : '' }}">
                                            <i class="bi bi-clipboard-data"></i>
                                            <div>
                                                <span class="d-block">{{ __('Kardex') }}</span>
                                                <small class="text-muted">Movimientos de inventario</small>
                                            </div>
                                        </a>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                            @endcanany

                            <!-- Grupo: Operaciones y Producción -->
                            @canany(['ver-consumos', 'ver-inventario'])
                            <div class="nav-dropdown" id="dropdown-operaciones">
                                <button type="button" class="nav-dropdown-trigger {{ request()->routeIs(['consumos.*', 'menus.*', 'recetas.*']) ? 'active' : '' }}"
                                        onclick="event.preventDefault(); event.stopPropagation(); toggleNav('dropdown-operaciones');">
                                    <i class="bi bi-calendar-week me-1"></i>{{ __('Operaciones') }}
                                    <i class="bi bi-chevron-down ms-1"></i>
                                </button>
                                <div class="nav-dropdown-menu" style="display: none;">
                                    @can('ver-inventario')
                                    <a href="{{ route('menus.index') }}" class="nav-dropdown-item {{ request()->routeIs('menus.*') ? 'active' : '' }}">
                                        <i class="bi bi-calendar-week me-1"></i>{{ __('Menús') }}
                                    </a>
                                    <a href="{{ route('recetas.index') }}" class="nav-dropdown-item {{ request()->routeIs('recetas.*') ? 'active' : '' }}">
                                        <i class="bi bi-journal-bookmark me-1"></i>{{ __('Recetas') }}
                                    </a>
                                    @endcan
                                    @can('ver-consumos')
                                    <a href="{{ route('consumos.index') }}" class="nav-dropdown-item {{ request()->routeIs('consumos.*') ? 'active' : '' }}">
                                        <i class="bi bi-journal-text me-1"></i>{{ __('Consumos') }}
                                    </a>
                                    @endcan
                                </div>
                            </div>
                            @endcanany

                            <!-- Grupo: Comercial y Ventas -->
                            <div class="nav-dropdown" id="dropdown-comercial">
                                <button type="button" class="nav-dropdown-trigger {{ request()->routeIs(['clientes.*', 'ventas.*', 'pedidos.*']) ? 'active' : '' }}"
                                        onclick="event.preventDefault(); event.stopPropagation(); toggleNav('dropdown-comercial');">
                                    <i class="bi bi-cart3 me-1"></i>{{ __('Comercial') }}
                                    <i class="bi bi-chevron-down ms-1"></i>
                                </button>
                                <div class="nav-dropdown-menu" style="display: none;">
                                    <div class="px-3 pb-2 text-sm font-weight-bold border-bottom">
                                        {{ __('Gestión Comercial') }}
                                    </div>
                                    <a href="{{ route('clientes.index') }}" class="nav-dropdown-item {{ request()->routeIs('clientes.*') ? 'active' : '' }}">
                                        <i class="bi bi-people me-1"></i>{{ __('Clientes') }}
                                    </a>
                                    <a href="{{ route('ventas.index') }}" class="nav-dropdown-item {{ request()->routeIs('ventas.*') ? 'active' : '' }}">
                                        <i class="bi bi-receipt me-1"></i>{{ __('Ventas') }}
                                    </a>
                                    <a href="{{ route('pedidos.index') }}" class="nav-dropdown-item {{ request()->routeIs('pedidos.*') ? 'active' : '' }}">
                                        <i class="bi bi-cart3 me-1"></i>{{ __('Pedidos') }}
                                    </a>
                                </div>
                            </div>

                            <!-- Grupo: Compras y Proveedores -->
                            @can('ver-proveedores')
                            <div class="nav-dropdown" id="dropdown-compras">
                                <button type="button" class="nav-dropdown-trigger {{ request()->routeIs(['proveedores.*', 'compras.*']) ? 'active' : '' }}"
                                        onclick="event.preventDefault(); event.stopPropagation(); toggleNav('dropdown-compras');">
                                    <i class="bi bi-truck me-1"></i>{{ __('Compras') }}
                                    <i class="bi bi-chevron-down ms-1"></i>
                                </button>
                                <div class="nav-dropdown-menu" style="display: none;">
                                    <div class="px-3 pb-2 text-sm font-weight-bold border-bottom">
                                        {{ __('Gestión de Compras') }}
                                    </div>
                                    <a href="{{ route('proveedores.index') }}" class="nav-dropdown-item {{ request()->routeIs('proveedores.*') ? 'active' : '' }}">
                                        <i class="bi bi-truck me-1"></i>{{ __('Proveedores') }}
                                    </a>
                                    <a href="{{ route('compras.index') }}" class="nav-dropdown-item {{ request()->routeIs('compras.*') ? 'active' : '' }}">
                                        <i class="bi bi-bag me-1"></i>{{ __('Órdenes de Compra') }}
                                    </a>
                                </div>
                            </div>
                            @endcan

                            <!-- Grupo: Administración del Sistema -->
                            @can('ver-configuraciones')
                            <div class="nav-dropdown" id="dropdown-administracion">
                                <button type="button" class="nav-dropdown-trigger {{ request()->routeIs(['configuraciones.*', 'configurations.*', 'role-management.*', 'dynamic-fields.*', 'contratos.templates.*']) ? 'active' : '' }}"
                                        onclick="event.preventDefault(); event.stopPropagation(); toggleNav('dropdown-administracion');">
                                    <i class="bi bi-gear-fill me-1"></i>{{ __('Administración') }}
                                    <i class="bi bi-chevron-down ms-1"></i>
                                </button>
                                <div class="nav-dropdown-menu shadow-sm border" style="display: none; min-width: 250px;">
                                    <div class="py-2">
                                        <div class="px-3 pb-2 text-sm font-weight-bold border-bottom">
                                            {{ __('Sistema y Configuración') }}
                                        </div>
                                        <a href="{{ route('configuraciones.index') }}" class="nav-dropdown-item d-flex align-items-center gap-2 {{ request()->routeIs('configuraciones.*') ? 'active' : '' }}">
                                            <i class="bi bi-sliders"></i>
                                            <div>
                                                <span class="d-block">{{ __('Configuraciones') }}</span>
                                                <small class="text-muted">Empresa, Sistema y Permisos</small>
                                            </div>
                                        </a>
                                        <a href="{{ route('role-management.index') }}" class="nav-dropdown-item d-flex align-items-center gap-2 {{ request()->routeIs('role-management.*') ? 'active' : '' }}">
                                            <i class="bi bi-shield-lock"></i>
                                            <div>
                                                <span class="d-block">{{ __('Gestión de Roles') }}</span>
                                                <small class="text-muted">Roles y permisos</small>
                                            </div>
                                        </a>
                                        <a href="{{ route('dynamic-fields.index') }}" class="nav-dropdown-item d-flex align-items-center gap-2 {{ request()->routeIs('dynamic-fields.*') ? 'active' : '' }}">
                                            <i class="bi bi-puzzle"></i>
                                            <div>
                                                <span class="d-block">{{ __('Campos Dinámicos') }}</span>
                                                <small class="text-muted">Extensibilidad de módulos</small>
                                            </div>
                                        </a>
                                        <a href="{{ route('contratos.templates.index') }}" class="nav-dropdown-item d-flex align-items-center gap-2 {{ request()->routeIs('contratos.templates.*') ? 'active' : '' }}">
                                            <i class="bi bi-file-earmark-plus"></i>
                                            <div>
                                                <span class="d-block">{{ __('Plantillas de Contratos') }}</span>
                                                <small class="text-muted">Templates y documentos</small>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endcan
                            </div>
                        </div>
                        <div class="nav-gradient nav-gradient-right"></div>
                    </div>

                    <!-- Botón scroll derecha -->
                    <button id="scroll-right" class="nav-scroll-btn nav-scroll-right" style="display: none;">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </div>
            </div>

            <!-- Hamburger - Esquina derecha móvil -->
            <div class="flex items-center sm:hidden ms-auto">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-700 transition duration-150 ease-in-out border border-gray-200">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <!-- Navegación principal -->
            <x-responsive-nav-link :href="route('modules.index')" :active="request()->routeIs('modules.*')">
                <i class="bi bi-grid-3x3-gap me-2"></i>{{ __('Módulos') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                <i class="bi bi-speedometer2 me-2"></i>{{ __('Dashboard') }}
            </x-responsive-nav-link>

            <!-- Personal -->
            @canany(['ver-trabajadores', 'ver-usuarios'])
            <div class="px-4 py-2">
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Personal') }}</div>
            </div>
            @can('ver-trabajadores')
            <x-responsive-nav-link :href="route('personas.index')" :active="request()->routeIs('personas.*')">
                <i class="bi bi-person-vcard me-2"></i>{{ __('Personas') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('trabajadores.index')" :active="request()->routeIs('trabajadores.*')">
                <i class="bi bi-people me-2"></i>{{ __('Trabajadores') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('contratos.index')" :active="request()->routeIs('contratos.*')">
                <i class="bi bi-file-earmark-text me-2"></i>{{ __('Contratos') }}
            </x-responsive-nav-link>
            @endcan
            @can('ver-inventario')
            <x-responsive-nav-link :href="route('certificados-medicos.index')" :active="request()->routeIs('certificados-medicos.*')">
                <i class="bi bi-file-medical me-2"></i>{{ __('Certificados Médicos') }}
            </x-responsive-nav-link>
            @endcan
            @can('ver-usuarios')
            <x-responsive-nav-link :href="route('usuarios.index')" :active="request()->routeIs('usuarios.*')">
                <i class="bi bi-person-gear me-2"></i>{{ __('Usuarios') }}
            </x-responsive-nav-link>
            @endcan
            @endcanany

            <!-- Inventario -->
            @canany(['ver-inventario', 'ver-productos'])
            <div class="px-4 py-2">
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Inventario') }}</div>
            </div>
            @can('ver-productos')
            <x-responsive-nav-link :href="route('categorias.index')" :active="request()->routeIs('categorias.*')">
                <i class="bi bi-tags me-2"></i>{{ __('Categorías') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('productos.index')" :active="request()->routeIs('productos.*')">
                <i class="bi bi-box-seam me-2"></i>{{ __('Productos') }}
            </x-responsive-nav-link>
            @endcan
            @can('ver-inventario')
            <x-responsive-nav-link :href="route('inventarios.index')" :active="request()->routeIs('inventarios.*')">
                <i class="bi bi-boxes me-2"></i>{{ __('Stock') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('kardex.index')" :active="request()->routeIs('kardex.*')">
                <i class="bi bi-clipboard-data me-2"></i>{{ __('Kardex') }}
            </x-responsive-nav-link>
            @endcan
            @endcanany

            <!-- Operaciones -->
            @canany(['ver-consumos', 'ver-inventario'])
            <div class="px-4 py-2">
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Operaciones') }}</div>
            </div>
            @can('ver-inventario')
            <x-responsive-nav-link :href="route('menus.index')" :active="request()->routeIs('menus.*')">
                <i class="bi bi-calendar-week me-2"></i>{{ __('Menús') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('recetas.index')" :active="request()->routeIs('recetas.*')">
                <i class="bi bi-journal-bookmark me-2"></i>{{ __('Recetas') }}
            </x-responsive-nav-link>
            @endcan
            @can('ver-consumos')
            <x-responsive-nav-link :href="route('consumos.index')" :active="request()->routeIs('consumos.*')">
                <i class="bi bi-journal-text me-2"></i>{{ __('Consumos') }}
            </x-responsive-nav-link>
            @endcan
            @endcanany

            <!-- Comercial -->
            <div class="px-4 py-2">
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Comercial') }}</div>
            </div>
            <x-responsive-nav-link :href="route('clientes.index')" :active="request()->routeIs('clientes.*')">
                <i class="bi bi-people me-2"></i>{{ __('Clientes') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('ventas.index')" :active="request()->routeIs('ventas.*')">
                <i class="bi bi-receipt me-2"></i>{{ __('Ventas') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('pedidos.index')" :active="request()->routeIs('pedidos.*')">
                <i class="bi bi-cart3 me-2"></i>{{ __('Pedidos') }}
            </x-responsive-nav-link>

            <!-- Compras -->
            @can('ver-proveedores')
            <div class="px-4 py-2">
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Compras') }}</div>
            </div>
            <x-responsive-nav-link :href="route('proveedores.index')" :active="request()->routeIs('proveedores.*')">
                <i class="bi bi-truck me-2"></i>{{ __('Proveedores') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('compras.index')" :active="request()->routeIs('compras.*')">
                <i class="bi bi-bag me-2"></i>{{ __('Órdenes de Compra') }}
            </x-responsive-nav-link>
            @endcan

            <!-- Reportes -->
            <div class="px-4 py-2">
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Reportes') }}</div>
            </div>
            <x-responsive-nav-link :href="route('reportes.index')" :active="request()->routeIs('reportes.*')">
                <i class="bi bi-graph-up me-2"></i>{{ __('Dashboard de Reportes') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('reportes.consumos')" :active="request()->routeIs('reportes.consumos')">
                <i class="bi bi-journal-text me-2"></i>{{ __('Reportes de Consumos') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('reportes.inventario')" :active="request()->routeIs('reportes.inventario')">
                <i class="bi bi-boxes me-2"></i>{{ __('Reportes de Inventario') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('reportes.ventas')" :active="request()->routeIs('reportes.ventas')">
                <i class="bi bi-receipt me-2"></i>{{ __('Reportes de Ventas') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('reportes.proveedores')" :active="request()->routeIs('reportes.proveedores')">
                <i class="bi bi-truck me-2"></i>{{ __('Reportes de Proveedores') }}
            </x-responsive-nav-link>

            <!-- Administración -->
            @can('ver-configuraciones')
            <div class="px-4 py-2">
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Administración') }}</div>
            </div>
            <x-responsive-nav-link :href="route('configuraciones.index')" :active="request()->routeIs('configuraciones.*')">
                <i class="bi bi-sliders me-2"></i>{{ __('Configuraciones') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('role-management.index')" :active="request()->routeIs('role-management.*')">
                <i class="bi bi-shield-lock me-2"></i>{{ __('Gestión de Roles') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('dynamic-fields.index')" :active="request()->routeIs('dynamic-fields.*')">
                <i class="bi bi-puzzle me-2"></i>{{ __('Campos Dinámicos') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('contratos.templates.index')" :active="request()->routeIs('contratos.templates.*')">
                <i class="bi bi-file-earmark-plus me-2"></i>{{ __('Plantillas de Contratos') }}
            </x-responsive-nav-link>
            @endcan
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

<!-- Icono de Notificaciones - Posición Fija Esquina Superior Derecha -->
<div id="notificaciones-fixed-container" style="position: fixed; top: 15px; right: 140px; z-index: 1100;">
    <div class="relative">
        <button onclick="toggleNotificaciones()"
                class="relative inline-flex items-center justify-center rounded-full text-white transition-all duration-300 shadow-lg hover:shadow-xl"
                style="width: 48px; height: 48px; background: linear-gradient(135deg, var(--cesodo-red) 0%, #c82333 100%); border: 3px solid white;"
                title="Notificaciones">
            <i class="fas fa-bell" style="font-size: 20px;"></i>
            <span id="notificaciones-badge"
                  class="absolute inline-flex items-center justify-center font-bold leading-none text-white rounded-full animate-pulse"
                  style="display: none; top: -5px; right: -5px; min-width: 22px; height: 22px; background: #dc3545; font-size: 11px; padding: 2px 6px; border: 2px solid white; box-shadow: 0 2px 8px rgba(220, 53, 69, 0.5);">0</span>
        </button>

        <!-- Dropdown de notificaciones -->
        <div id="notificaciones-dropdown"
             class="hidden absolute bg-white rounded-lg shadow-2xl border border-gray-200"
             style="right: 0; top: 58px; width: 420px; max-height: 550px; overflow-y: auto; z-index: 1101;">
            <div class="p-4 border-b border-gray-200 bg-gradient-to-r from-red-50 to-white rounded-t-lg">
                <div class="flex justify-between items-center">
                    <h3 class="font-bold text-gray-800 text-lg">
                        <i class="fas fa-bell me-2 text-red-600"></i>Notificaciones
                    </h3>
                    <span id="notificaciones-count" class="text-xs px-3 py-1 bg-red-100 text-red-700 rounded-full font-semibold">0 nuevas</span>
                </div>
            </div>
            <div id="notificaciones-lista" class="divide-y divide-gray-100">
                <!-- Las notificaciones se cargarán aquí -->
                <div class="p-6 text-center text-gray-500">
                    <i class="fas fa-spinner fa-spin mb-3 text-2xl text-red-600"></i>
                    <p class="text-sm font-medium">Cargando notificaciones...</p>
                </div>
            </div>
            <div class="p-3 border-t border-gray-200 bg-gray-50 rounded-b-lg text-center">
                <a href="{{ route('notificaciones.index') }}"
                   class="inline-flex items-center text-sm font-semibold transition-colors duration-200"
                   style="color: var(--cesodo-red);"
                   onmouseover="this.style.color='var(--cesodo-black)'"
                   onmouseout="this.style.color='var(--cesodo-red)'">
                    <i class="fas fa-list me-2"></i>Ver todas las notificaciones
                    <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Menú de Usuario - Posición Fija Esquina Superior Derecha -->
<div id="user-menu-fixed-container" style="position: fixed; top: 15px; right: 80px; z-index: 1100;">
    <div class="relative" x-data="{ open: false }" @click.outside="open = false">
        <button @click="open = !open"
                class="user-menu-button inline-flex items-center justify-center rounded-lg text-gray-600 bg-white shadow-sm border border-gray-200"
                style="width: 48px; height: 48px;"
                title="Menú de usuario: {{ Auth::user()->name }}">
            <i class="fas fa-ellipsis-v text-xl"></i>
        </button>

        <!-- Dropdown -->
        <div x-show="open"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-75"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5"
             style="display: none; z-index: 1101;"
             @click="open = false">
            <!-- Header con info del usuario -->
            <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
                <div class="flex items-center">
                    <i class="bi bi-person-circle text-3xl text-gray-600 me-3"></i>
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                    </div>
                </div>
            </div>
            <!-- Opciones -->
            <div class="py-1">
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    <i class="bi bi-person me-2"></i>{{ __('Profile') }}
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); this.closest('form').submit();"
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="bi bi-box-arrow-right me-2"></i>{{ __('Log Out') }}
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- CSS Mejorado para Navegación Horizontal -->
<style>
    /* Contenedor principal de navegación */
    .nav-wrapper {
        position: relative;
        width: 100%;
        max-width: none; /* Sin límite de ancho */
        margin: 0;
        flex: 1; /* Tomar todo el espacio disponible */
    }

    /* Container scrolleable */
    .nav-container {
        display: flex;
        overflow-x: auto;
        overflow-y: visible; /* Cambio para permitir dropdowns */
        scroll-behavior: smooth;
        scrollbar-width: none; /* Firefox */
        -ms-overflow-style: none; /* IE/Edge */
        cursor: grab;
        user-select: none;
        padding: 4px 0;
        position: relative;
        z-index: 1;
        touch-action: pan-x;
    }

    .nav-container::-webkit-scrollbar {
        display: none; /* Chrome, Safari */
    }

    .nav-container.dragging {
        cursor: grabbing;
        scroll-behavior: auto;
    }

    /* Inner container para los enlaces */
    .nav-inner {
        display: flex;
        align-items: center;
        gap: 32px; /* Mucho más espacio entre elementos */
        white-space: nowrap;
        min-width: max-content;
        padding: 0 30px; /* Más padding para respirar */
        justify-content: flex-start;
    }

    /* Gradientes para indicar más contenido */
    .nav-gradient {
        position: absolute;
        top: 0;
        bottom: 0;
        width: 20px;
        z-index: 2;
        pointer-events: none;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .nav-gradient-left {
        left: 0;
        background: linear-gradient(to right, rgba(255,255,255,1) 0%, rgba(255,255,255,0) 100%);
    }

    .nav-gradient-right {
        right: 0;
        background: linear-gradient(to left, rgba(255,255,255,1) 0%, rgba(255,255,255,0) 100%);
    }

    .nav-wrapper.show-left-gradient .nav-gradient-left,
    .nav-wrapper.show-right-gradient .nav-gradient-right {
        opacity: 1;
    }

    /* Estilos para botones de scroll mejorados */
    .nav-scroll-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: var(--cesodo-white);
        border: 2px solid var(--cesodo-red);
        box-shadow: var(--cesodo-shadow-lg);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all var(--cesodo-transition-fast);
        z-index: 3;
        color: var(--cesodo-red);
    }

    .nav-scroll-btn:hover {
        background: var(--cesodo-red);
        border-color: var(--cesodo-red);
        color: var(--cesodo-white);
        transform: translateY(-50%) scale(1.1);
        box-shadow: var(--cesodo-shadow-xl);
    }

    .nav-scroll-btn:active {
        transform: translateY(-50%) scale(0.95);
    }

    .nav-scroll-left {
        left: -16px;
    }

    .nav-scroll-right {
        right: -16px;
    }

    /* Indicador visual para drag */
    .nav-container::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 50%;
        transform: translateX(-50%);
        width: 40px;
        height: 3px;
        background: #e5e7eb;
        border-radius: 2px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .nav-container:hover::after {
        opacity: 1;
    }

    .nav-container.dragging::after {
        background: #3b82f6;
        opacity: 1;
    }

    /* Mejoras responsivas */
    @media (max-width: 1200px) {
        .nav-inner {
            gap: 24px; /* Menos espacio en pantallas medianas */
            padding: 0 20px;
        }
    }

    @media (max-width: 992px) {
        .nav-inner {
            gap: 16px; /* Más compacto en móviles */
            padding: 0 15px;
        }

        .nav-inner a {
            padding: 8px 12px !important;
        }

        .nav-dropdown-trigger {
            padding: 8px 12px;
        }
    }

    /* Animación suave al hacer hover en los enlaces */
    .nav-inner a {
        transition: all var(--cesodo-transition-fast);
        border-radius: var(--cesodo-radius-lg);
        padding: 10px 16px !important;
        font-size: 14px;
        line-height: 1.5;
        margin: 0;
        flex-shrink: 0;
        color: var(--cesodo-white) !important;
        text-decoration: none;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        font-weight: 500;
        font-family: var(--cesodo-font-family);
    }

    .nav-inner a:hover {
        background: var(--cesodo-red) !important;
        color: var(--cesodo-white) !important;
        border-color: var(--cesodo-red);
        transform: translateY(-2px);
        box-shadow: var(--cesodo-shadow-lg);
    }

    .nav-inner a.router-link-active,
    .nav-inner a:focus {
        background: var(--cesodo-red) !important;
        color: var(--cesodo-white) !important;
        border-color: var(--cesodo-red);
        box-shadow: var(--cesodo-shadow-md);
    }

    /* Estilos para dropdowns */
    .nav-dropdown {
        position: relative;
        display: inline-block;
    }

    .nav-dropdown-trigger {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: var(--cesodo-white);
        padding: 10px 16px;
        border-radius: var(--cesodo-radius-lg);
        transition: all var(--cesodo-transition-fast);
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        display: flex;
        align-items: center;
        text-decoration: none;
        white-space: nowrap;
        font-family: var(--cesodo-font-family);
        line-height: 1.5;
        margin: 0;
        flex-shrink: 0;
        backdrop-filter: blur(10px);
    }

    .nav-dropdown-trigger:hover {
        color: var(--cesodo-white);
        background: var(--cesodo-red);
        border-color: var(--cesodo-red);
        transform: translateY(-2px);
        box-shadow: var(--cesodo-shadow-lg);
    }

    .nav-dropdown-trigger.active {
        color: var(--cesodo-white);
        background: var(--cesodo-red);
        border-color: var(--cesodo-red);
        box-shadow: var(--cesodo-shadow-md);
    }

    .nav-dropdown-menu {
        position: absolute;
        top: calc(100% + 12px);
        left: 0;
        background: #ffffff !important;
        border: 2px solid #dc2626 !important;
        border-radius: 12px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        z-index: 999999;
        min-width: 240px;
        padding: 12px 0;
        display: none;
        max-height: 400px;
        overflow-y: auto;
        white-space: nowrap;
        backdrop-filter: blur(20px);
        animation: fadeIn 0.2s ease-out;
    }

    .nav-dropdown-item {
        display: flex !important;
        align-items: center !important;
        padding: 12px 16px !important;
        color: #1a1a1a !important;
        text-decoration: none !important;
        font-size: 14px !important;
        font-weight: 500 !important;
        transition: all 0.2s ease !important;
        margin: 4px 12px !important;
        border-radius: 8px !important;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
    }

    .nav-dropdown-item:hover {
        color: var(--cesodo-white);
        background: var(--cesodo-red);
        text-decoration: none;
        transform: translateX(4px);
        box-shadow: var(--cesodo-shadow-md);
    }

    .nav-dropdown-item.active {
        color: var(--cesodo-white);
        background: var(--cesodo-red);
        box-shadow: var(--cesodo-shadow-sm);
    }

    .nav-dropdown-item i {
        width: 16px;
        margin-right: 8px;
        flex-shrink: 0;
    }

    /* Estilos específicos para elementos dentro de dropdowns */
    .nav-dropdown-menu .text-muted {
        color: #6b7280 !important;
    }

    .nav-dropdown-menu .font-weight-bold {
        color: #1a1a1a !important;
    }

    .nav-dropdown-menu small {
        color: #6b7280 !important;
    }

    .nav-dropdown-menu .border-bottom {
        border-color: #d1d5db !important;
    }

    /* Asegurar que todos los elementos de texto sean visibles */
    .nav-dropdown-menu span,
    .nav-dropdown-menu div,
    .nav-dropdown-menu .d-block,
    .nav-dropdown-menu .text-sm,
    .nav-dropdown-menu .font-weight-bold {
        color: #1a1a1a !important;
    }

    /* Sobreescribir Bootstrap text-muted específicamente */
    .nav-dropdown-menu .text-muted,
    .nav-dropdown-menu small.text-muted {
        color: #6b7280 !important;
    }

    /* Iconos del menú */
    .nav-dropdown-menu i {
        color: #1a1a1a !important;
    }

    /* Sobreescribir cualquier estilo de Bootstrap */
    .nav-dropdown-menu a,
    .nav-dropdown-menu a:link,
    .nav-dropdown-menu a:visited {
        color: #1a1a1a !important;
        text-decoration: none !important;
    }

    /* FORZAR VISIBILIDAD - Máxima prioridad */
    .nav-dropdown-menu .nav-dropdown-item,
    .nav-dropdown-menu .nav-dropdown-item *,
    .nav-dropdown-menu a.nav-dropdown-item,
    .nav-dropdown-menu a.nav-dropdown-item * {
        color: #1a1a1a !important;
        opacity: 1 !important;
        visibility: visible !important;
    }

    /* DEPURACIÓN: Forzar color rojo para verificar que el CSS se aplica */
    .nav-dropdown-menu .nav-dropdown-item {
        background: #f8f9fa !important;
        color: #dc2626 !important; /* Texto en rojo temporalmente */
        border-left: 3px solid #dc2626 !important;
    }

    /* Excepciones para text-muted */
    .nav-dropdown-menu .text-muted,
    .nav-dropdown-menu small {
        color: #6b7280 !important;
    }

    /* Responsive para dropdowns */
    @media (max-width: 768px) {
        .nav-dropdown-menu {
            position: fixed;
            left: 50%;
            transform: translateX(-50%);
            min-width: 240px;
        }
    }

    /* Estilos para el icono de notificaciones fijo */
    #notificaciones-fixed-container button {
        transition: all 0.3s ease;
    }

    #notificaciones-fixed-container button:hover {
        transform: scale(1.1) rotate(15deg);
    }

    #notificaciones-fixed-container button:active {
        transform: scale(0.95);
    }

    @keyframes bellRing {
        0%, 100% { transform: rotate(0deg); }
        10%, 30%, 50%, 70%, 90% { transform: rotate(-10deg); }
        20%, 40%, 60%, 80% { transform: rotate(10deg); }
    }

    #notificaciones-fixed-container button:hover i {
        animation: bellRing 0.5s ease-in-out;
    }

    /* Responsive - Ajustar posición en pantallas pequeñas */
    @media (max-width: 768px) {
        #notificaciones-fixed-container {
            right: 15px !important;
            top: 12px !important;
        }

        #notificaciones-fixed-container button {
            width: 42px !important;
            height: 42px !important;
        }

        #notificaciones-dropdown {
            width: calc(100vw - 30px) !important;
            max-width: 380px !important;
        }
    }

    /* Asegurar que el dropdown esté por encima de todo */
    #notificaciones-dropdown {
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    }

    /* Estilo para las notificaciones dentro del dropdown */
    #notificaciones-lista > div {
        transition: background-color 0.2s ease;
    }

    #notificaciones-lista > div:hover {
        background-color: #f9fafb;
    }

    /* Estilo para el botón de menú de usuario (3 puntos) */
    .user-menu-button {
        transition: background-color 0.2s ease, color 0.2s ease !important;
    }

    .user-menu-button:hover {
        background-color: var(--cesodo-black) !important;
        color: white !important;
    }

    .user-menu-button:hover i {
        color: white !important;
    }

    /* Responsive - Ajustar posición en pantallas pequeñas */
    @media (max-width: 768px) {
        #user-menu-fixed-container {
            right: 15px !important;
            top: 12px !important;
        }
    }
</style>

<!-- JavaScript Mejorado para Navegación -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Esperar un poco más para asegurar que todo esté cargado
    setTimeout(function() {
        const navContainer = document.getElementById('nav-container');
        const navWrapper = navContainer?.parentElement;
        const scrollLeftBtn = document.getElementById('scroll-left');
        const scrollRightBtn = document.getElementById('scroll-right');

        if (!navContainer || !navWrapper) {
            console.log('Elementos de navegación no encontrados');
            return;
        }

    let isDown = false;
    let startX = 0;
    let scrollLeft = 0;
    let isDragging = false;

    // Función para actualizar gradientes y botones
    function updateScrollIndicators() {
        const scrollLeftPos = navContainer.scrollLeft;
        const maxScroll = navContainer.scrollWidth - navContainer.clientWidth;
        const hasOverflow = navContainer.scrollWidth > navContainer.clientWidth;

        // Mostrar/ocultar gradientes
        if (hasOverflow) {
            navWrapper.classList.toggle('show-left-gradient', scrollLeftPos > 5);
            navWrapper.classList.toggle('show-right-gradient', scrollLeftPos < maxScroll - 5);

            // Mostrar/ocultar botones
            scrollLeftBtn.style.display = scrollLeftPos > 5 ? 'flex' : 'none';
            scrollRightBtn.style.display = scrollLeftPos < maxScroll - 5 ? 'flex' : 'none';
        } else {
            navWrapper.classList.remove('show-left-gradient', 'show-right-gradient');
            scrollLeftBtn.style.display = 'none';
            scrollRightBtn.style.display = 'none';
        }
    }

    // Eventos para drag mejorado
    navContainer.addEventListener('mousedown', (e) => {
        // Solo permitir drag en espacios vacíos, no en enlaces o dropdowns
        if (e.target.closest('a') || e.target.closest('button') || e.target.closest('.nav-dropdown')) return;

        isDown = true;
        isDragging = false;
        navContainer.classList.add('dragging');
        navContainer.style.cursor = 'grabbing';
        startX = e.pageX - navContainer.offsetLeft;
        scrollLeft = navContainer.scrollLeft;
        e.preventDefault();
    });

    // Prevenir click en enlaces durante/después del drag
    navContainer.addEventListener('click', (e) => {
        if (isDragging) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            return false;
        }
    }, true);

    // Mejorar la detección de enlaces
    navContainer.addEventListener('pointerdown', (e) => {
        if (e.target.closest('a')) {
            navContainer.style.cursor = 'pointer';
        }
    });

    navContainer.addEventListener('pointerup', (e) => {
        if (!isDragging && e.target.closest('a')) {
            // Permitir navegación normal
            return true;
        }
    });    // Eventos para botones de scroll con animación
    scrollLeftBtn.addEventListener('click', () => {
        navContainer.scrollBy({
            left: -250,
            behavior: 'smooth'
        });
    });

    scrollRightBtn.addEventListener('click', () => {
        navContainer.scrollBy({
            left: 250,
            behavior: 'smooth'
        });
    });

    // Scroll con rueda del mouse mejorado
    navContainer.addEventListener('wheel', (e) => {
        if (navContainer.scrollWidth > navContainer.clientWidth) {
            e.preventDefault();
            const scrollAmount = e.deltaY > 0 ? 60 : -60;
            navContainer.scrollBy({
                left: scrollAmount,
                behavior: 'smooth'
            });
        }
    });

    // Soporte para touch en dispositivos móviles
    let touchStartX = 0;
    let touchScrollLeft = 0;

    navContainer.addEventListener('touchstart', (e) => {
        touchStartX = e.touches[0].clientX;
        touchScrollLeft = navContainer.scrollLeft;
    });

    navContainer.addEventListener('touchmove', (e) => {
        if (!touchStartX) return;

        const touchX = e.touches[0].clientX;
        const diff = touchStartX - touchX;
        navContainer.scrollLeft = touchScrollLeft + diff;
    });

    navContainer.addEventListener('touchend', () => {
        touchStartX = 0;
    });

    // Event listeners para actualizar indicadores
    navContainer.addEventListener('scroll', updateScrollIndicators);
    window.addEventListener('resize', updateScrollIndicators);

    // Inicializar
    setTimeout(updateScrollIndicators, 100);

    // Resto del código de drag
    document.addEventListener('mouseleave', () => {
        isDown = false;
        navContainer.classList.remove('dragging');
        navContainer.style.cursor = 'grab';
        isDragging = false;
    });

    document.addEventListener('mouseup', (e) => {
        if (isDown) {
            isDown = false;
            navContainer.classList.remove('dragging');
            navContainer.style.cursor = 'grab';

            // Si hubo drag significativo, prevenir click en enlaces
            if (isDragging) {
                setTimeout(() => { isDragging = false; }, 50);
            }
        }
    });

    navContainer.addEventListener('mousemove', (e) => {
        if (!isDown) return;

        e.preventDefault();
        const x = e.pageX - navContainer.offsetLeft;
        const walk = (x - startX) * 1.2;

        // Marcar como dragging si el movimiento es significativo
        if (Math.abs(walk) > 5) {
            isDragging = true;
        }

        navContainer.scrollLeft = scrollLeft - walk;
    });
    }, 100); // Esperar 100ms para que el DOM esté completamente listo
});

// Función para manejar dropdowns - definida globalmente
function toggleNav(id) {
    // Obtener el dropdown
    var dropdown = document.getElementById(id);
    if (!dropdown) return;

    var menu = dropdown.querySelector('.nav-dropdown-menu');
    var chevron = dropdown.querySelector('.bi-chevron-down');
    var trigger = dropdown.querySelector('.nav-dropdown-trigger');

    // Cerrar todos los otros dropdowns
    document.querySelectorAll('.nav-dropdown').forEach(function(d) {
        if (d.id !== id) {
            var otherMenu = d.querySelector('.nav-dropdown-menu');
            var otherChevron = d.querySelector('.bi-chevron-down');
            if (otherMenu) otherMenu.style.display = 'none';
            if (otherChevron) otherChevron.style.transform = 'rotate(0deg)';
        }
    });

    // Toggle el dropdown actual
    if (menu.style.display === 'none' || menu.style.display === '') {
        // Calcular posición exacta del trigger
        var rect = trigger.getBoundingClientRect();

        // Posicionar el menú usando coordenadas fijas
        menu.style.position = 'fixed';
        menu.style.top = (rect.bottom + 8) + 'px';
        menu.style.left = rect.left + 'px';
        menu.style.display = 'block';

        if (chevron) chevron.style.transform = 'rotate(180deg)';

        console.log('Dropdown abierto:', id, 'en posición:', rect.left, rect.bottom + 8);
    } else {
        menu.style.display = 'none';
        if (chevron) chevron.style.transform = 'rotate(0deg)';

        console.log('Dropdown cerrado:', id);
    }
}

// Cerrar dropdowns al hacer click fuera
document.addEventListener('click', function(e) {
    if (!e.target.closest('.nav-dropdown')) {
        document.querySelectorAll('.nav-dropdown').forEach(function(d) {
            var menu = d.querySelector('.nav-dropdown-menu');
            var chevron = d.querySelector('.bi-chevron-down');
            if (menu) menu.style.display = 'none';
            if (chevron) chevron.style.transform = 'rotate(0deg)';
        });
    }

    // Cerrar notificaciones al hacer click fuera
    if (!e.target.closest('#notificaciones-fixed-container')) {
        const dropdown = document.getElementById('notificaciones-dropdown');
        if (dropdown) {
            dropdown.classList.add('hidden');
        }
    }
});

// Sistema de Notificaciones
function toggleNotificaciones() {
    const dropdown = document.getElementById('notificaciones-dropdown');
    dropdown.classList.toggle('hidden');

    if (!dropdown.classList.contains('hidden')) {
        cargarNotificaciones();
    }
}

function cargarNotificaciones() {
    fetch('{{ route("notificaciones.obtener") }}')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                mostrarNotificaciones(data.notificaciones, data.total);
            }
        })
        .catch(error => {
            console.error('Error al cargar notificaciones:', error);
            document.getElementById('notificaciones-lista').innerHTML = `
                <div class="p-4 text-center text-red-500">
                    <i class="fas fa-exclamation-triangle mb-2"></i>
                    <p class="text-sm">Error al cargar notificaciones</p>
                </div>
            `;
        });
}

function mostrarNotificaciones(notificaciones, total) {
    const lista = document.getElementById('notificaciones-lista');
    const badge = document.getElementById('notificaciones-badge');
    const count = document.getElementById('notificaciones-count');

    // Actualizar contador
    if (total > 0) {
        badge.textContent = total > 99 ? '99+' : total;
        badge.style.display = 'inline-flex';
        count.textContent = `${total} nueva${total !== 1 ? 's' : ''}`;
    } else {
        badge.style.display = 'none';
        count.textContent = 'Sin notificaciones';
    }

    // Mostrar notificaciones
    if (notificaciones.length === 0) {
        lista.innerHTML = `
            <div class="p-4 text-center text-gray-500">
                <i class="fas fa-check-circle text-3xl mb-2 text-green-500"></i>
                <p class="text-sm">No hay notificaciones pendientes</p>
            </div>
        `;
        return;
    }

    lista.innerHTML = notificaciones.map(notif => `
        <a href="${notif.enlace}" class="block p-3 hover:bg-gray-50 transition-colors">
            <div class="flex items-start">
                <div class="flex-shrink-0 mt-1">
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-${notif.color}-100">
                        <i class="fas ${notif.icono} text-${notif.color}-600"></i>
                    </span>
                </div>
                <div class="ml-3 flex-1">
                    <p class="text-sm font-medium text-gray-900">${notif.titulo}</p>
                    <p class="text-sm text-gray-600 mt-1">${notif.mensaje}</p>
                    <p class="text-xs text-gray-400 mt-1">
                        <i class="far fa-clock"></i> ${formatearFecha(notif.fecha)}
                    </p>
                </div>
                ${notif.prioridad === 'alta' ? '<span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">Urgente</span>' : ''}
            </div>
        </a>
    `).join('');
}

function formatearFecha(fecha) {
    const date = new Date(fecha);
    const now = new Date();
    const diff = date - now;
    const days = Math.floor(diff / (1000 * 60 * 60 * 24));
    const hours = Math.floor(diff / (1000 * 60 * 60));

    if (days < 0) return 'Vencido';
    if (days === 0) {
        if (hours === 0) return 'Menos de 1 hora';
        return `${hours} hora${hours !== 1 ? 's' : ''}`;
    }
    return `${days} día${days !== 1 ? 's' : ''}`;
}

// Cargar notificaciones al iniciar
document.addEventListener('DOMContentLoaded', function() {
    cargarNotificaciones();

    // Actualizar cada 5 minutos
    setInterval(cargarNotificaciones, 300000);
});

</script>

