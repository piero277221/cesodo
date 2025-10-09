@php
    $currentRoute = request()->route() ? request()->route()->getName() : '';
@endphp

<!-- Navbar principal -->
<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 fixed-top" style="height: var(--header-height); z-index: 1050;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full">
        <div class="flex justify-between items-center h-full">
            <!-- Logo y Toggle Sidebar -->
            <div class="flex items-center">
                <button id="sidebar-toggle" class="p-2 rounded-md lg:hidden">
                    <i class="bi bi-list"></i>
                </button>
                <a href="{{ route('modules.index') }}" class="flex items-center">
                    <x-application-logo style="width: 32px; height: 32px;" class="block fill-current text-gray-800" />
                    <span class="ml-2 text-lg font-semibold">CESODO</span>
                </a>
            </div>

                    <!-- Container scrolleable con gradientes -->
                    <div class="nav-wrapper" style="overflow: visible;">
                        <div class="nav-gradient nav-gradient-left"></div>
                        <div id="nav-container" class="nav-container">
                            <div class="nav-inner">
                            <!-- Módulos y Dashboard (sin agrupar) -->
                            <x-nav-link :href="route('modules.index')" :active="request()->routeIs('modules.*')">
                                <i class="bi bi-grid-3x3-gap me-1"></i>{{ __('Módulos') }}
                            </x-nav-link>

                            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                                <i class="bi bi-speedometer2 me-1"></i>{{ __('Dashboard') }}
                            </x-nav-link>

                            <!-- Grupo: Gestión de Personal -->
                            <div class="nav-dropdown" id="dropdown-personal">
                                <button type="button" class="nav-dropdown-trigger {{ request()->routeIs(['trabajadores.*', 'usuarios.*', 'contratos.*', 'personas.*']) ? 'active' : '' }}"
                                        onclick="event.preventDefault(); event.stopPropagation(); toggleNav('dropdown-personal');">
                                    <i class="bi bi-people-fill me-1"></i>{{ __('Personal') }}
                                    <i class="bi bi-chevron-down ms-1"></i>
                                </button>
                                <div class="nav-dropdown-menu" style="display: none;">
                                    <a href="{{ route('personas.index') }}" class="nav-dropdown-item {{ request()->routeIs('personas.*') ? 'active' : '' }}">
                                        <i class="bi bi-person-vcard me-1"></i>{{ __('Personas') }}
                                    </a>
                                    <a href="{{ route('trabajadores.index') }}" class="nav-dropdown-item {{ request()->routeIs('trabajadores.*') ? 'active' : '' }}">
                                        <i class="bi bi-people me-1"></i>{{ __('Trabajadores') }}
                                    </a>
                                    <a href="{{ route('usuarios.index') }}" class="nav-dropdown-item {{ request()->routeIs('usuarios.*') ? 'active' : '' }}">
                                        <i class="bi bi-person-gear me-1"></i>{{ __('Usuarios') }}
                                    </a>
                                    <a href="{{ route('contratos.index') }}" class="nav-dropdown-item {{ request()->routeIs('contratos.*') ? 'active' : '' }}">
                                        <i class="bi bi-file-earmark-text me-1"></i>{{ __('Contratos') }}
                                    </a>
                                </div>
                            </div>

                            <!-- Grupo: Inventario y Productos -->
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
                                    </div>
                                </div>
                            </div>

                            <!-- Grupo: Operaciones -->
                            <div class="nav-dropdown" id="dropdown-operaciones">
                                <button type="button" class="nav-dropdown-trigger {{ request()->routeIs(['consumos.*', 'menus.*', 'recetas.*']) ? 'active' : '' }}"
                                        onclick="event.preventDefault(); event.stopPropagation(); toggleNav('dropdown-operaciones');">
                                    <i class="bi bi-calendar-week me-1"></i>{{ __('Operaciones') }}
                                    <i class="bi bi-chevron-down ms-1"></i>
                                </button>
                                <div class="nav-dropdown-menu" style="display: none;">
                                    <a href="{{ route('menus.index') }}" class="nav-dropdown-item {{ request()->routeIs('menus.*') ? 'active' : '' }}">
                                        <i class="bi bi-calendar-week me-1"></i>{{ __('Menús') }}
                                    </a>
                                    <a href="{{ route('recetas.index') }}" class="nav-dropdown-item {{ request()->routeIs('recetas.*') ? 'active' : '' }}">
                                        <i class="bi bi-journal-bookmark me-1"></i>{{ __('Recetas') }}
                                    </a>
                                    <a href="{{ route('consumos.index') }}" class="nav-dropdown-item {{ request()->routeIs('consumos.*') ? 'active' : '' }}">
                                        <i class="bi bi-journal-text me-1"></i>{{ __('Consumos') }}
                                    </a>
                                </div>
                            </div>

                            <!-- Grupo: Comercial -->
                            <div class="nav-dropdown" id="dropdown-comercial">
                                <button type="button" class="nav-dropdown-trigger {{ request()->routeIs(['clientes.*', 'ventas.*', 'pedidos.*']) ? 'active' : '' }}"
                                        onclick="event.preventDefault(); event.stopPropagation(); toggleNav('dropdown-comercial');">
                                    <i class="bi bi-cart3 me-1"></i>{{ __('Comercial') }}
                                    <i class="bi bi-chevron-down ms-1"></i>
                                </button>
                                <div class="nav-dropdown-menu" style="display: none;">
                                    <a href="{{ route('clientes.index') }}" class="nav-dropdown-item {{ request()->routeIs('clientes.*') ? 'active' : '' }}">
                                        <i class="bi bi-people me-1"></i>{{ __('Clientes') }}
                                    </a>
                                    <a href="{{ route('pedidos.index') }}" class="nav-dropdown-item {{ request()->routeIs('pedidos.*') ? 'active' : '' }}">
                                        <i class="bi bi-cart3 me-1"></i>{{ __('Pedidos') }}
                                    </a>
                                    <a href="{{ route('ventas.index') }}" class="nav-dropdown-item {{ request()->routeIs('ventas.*') ? 'active' : '' }}">
                                        <i class="bi bi-receipt me-1"></i>{{ __('Ventas') }}
                                    </a>
                                </div>
                            </div>

                            <!-- Grupo: Compras -->
                            <div class="nav-dropdown" id="dropdown-compras">
                                <button type="button" class="nav-dropdown-trigger {{ request()->routeIs(['proveedores.*', 'compras.*']) ? 'active' : '' }}"
                                        onclick="event.preventDefault(); event.stopPropagation(); toggleNav('dropdown-compras');">
                                    <i class="bi bi-truck me-1"></i>{{ __('Compras') }}
                                    <i class="bi bi-chevron-down ms-1"></i>
                                </button>
                                <div class="nav-dropdown-menu" style="display: none;">
                                    <a href="{{ route('proveedores.index') }}" class="nav-dropdown-item {{ request()->routeIs('proveedores.*') ? 'active' : '' }}">
                                        <i class="bi bi-truck me-1"></i>{{ __('Proveedores') }}
                                    </a>
                                    <a href="{{ route('compras.index') }}" class="nav-dropdown-item {{ request()->routeIs('compras.*') ? 'active' : '' }}">
                                        <i class="bi bi-bag me-1"></i>{{ __('Órdenes de Compra') }}
                                    </a>
                                </div>
                            </div>

                            <!-- Reportes (sin agrupar) -->
                            <x-nav-link :href="route('reportes.index')" :active="request()->routeIs('reportes.*')">
                                <i class="bi bi-graph-up me-1"></i>{{ __('Reportes') }}
                            </x-nav-link>
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

            <!-- Settings Dropdown - Esquina derecha -->
            <div class="hidden sm:flex sm:items-center user-dropdown-right">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2 border border-gray-200 text-sm leading-4 font-medium rounded-lg text-gray-600 bg-white hover:text-gray-800 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1 transition ease-in-out duration-150 shadow-sm">
                            <i class="bi bi-person-circle me-2 text-lg"></i>
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-2">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
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
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
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

<!-- CSS Mejorado para Navegación Horizontal -->
<style>
    /* Contenedor principal de navegación */
    .nav-wrapper {
        position: relative;
        max-width: 900px;
        width: 100%;
        margin: 0 8px;
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
        gap: 24px;
        white-space: nowrap;
        min-width: max-content;
        padding: 0 20px;
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

    /* Botones de scroll mejorados */
    .nav-scroll-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: white;
        border: 2px solid #e5e7eb;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
        z-index: 3;
        color: #6b7280;
    }

    .nav-scroll-btn:hover {
        background: #f8fafc;
        border-color: #d1d5db;
        color: #374151;
        transform: translateY(-50%) scale(1.05);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
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
        .nav-wrapper {
            max-width: 700px;
        }
    }

    @media (max-width: 992px) {
        .nav-wrapper {
            max-width: 500px;
        }

        .nav-inner {
            gap: 16px;
        }
    }

    /* Animación suave al hacer hover en los enlaces */
    .nav-inner a {
        transition: all 0.2s ease;
        border-radius: 6px;
        padding: 8px 12px !important;
    }

    .nav-inner a:hover {
        background-color: #f1f5f9;
        transform: translateY(-1px);
    }

    /* Estilos para dropdowns */
    .nav-dropdown {
        position: relative;
        display: inline-block;
    }

    .nav-dropdown-trigger {
        background: none;
        border: none;
        color: #6b7280;
        padding: 8px 12px;
        border-radius: 6px;
        transition: all 0.2s ease;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        display: flex;
        align-items: center;
        text-decoration: none;
        white-space: nowrap;
        font-family: inherit;
    }

    .nav-dropdown-trigger:hover {
        color: #374151;
        background-color: #f1f5f9;
        transform: translateY(-1px);
    }

    .nav-dropdown-trigger.active {
        color: #2563eb;
        background-color: rgba(37, 99, 235, 0.1);
    }

    .nav-dropdown-menu {
        position: absolute; /* Será cambiado a fixed por JS */
        top: calc(100% + 8px);
        left: 0;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        z-index: 999999; /* Z-index muy alto */
        min-width: 200px;
        padding: 8px 0;
        display: none; /* Por defecto oculto */
        max-height: 300px; /* Altura máxima */
        overflow-y: auto; /* Scroll si es necesario */
        white-space: nowrap;
    }

    .nav-dropdown-item {
        display: flex;
        align-items: center;
        padding: 8px 16px;
        color: #6b7280;
        text-decoration: none;
        font-size: 14px;
        transition: all 0.2s ease;
        margin: 2px 8px;
        border-radius: 4px;
    }

    .nav-dropdown-item:hover {
        color: #374151;
        background-color: #f3f4f6;
        text-decoration: none;
    }

    .nav-dropdown-item.active {
        color: #2563eb;
        background-color: rgba(37, 99, 235, 0.1);
    }

    .nav-dropdown-item i {
        width: 16px;
        margin-right: 8px;
        flex-shrink: 0;
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
});

</script>
