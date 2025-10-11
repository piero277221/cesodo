<?php
    $currentRoute = request()->route() ? request()->route()->getName() : '';
?>

<!-- Navbar principal -->
<nav x-data="{ open: false }" class="bg-cesodo-black border-b-4 border-cesodo-red fixed-top shadow-lg" style="height: var(--header-height); z-index: 1050; background: linear-gradient(135deg, var(--cesodo-black) 0%, var(--cesodo-black-light) 100%);">
    <!-- Incluir el tema CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('css/cesodo-theme.css')); ?>">
    <div class="w-full mx-auto px-1 h-full">
        <div class="flex items-center h-full" style="justify-content: flex-start;">
            <!-- Logo y Toggle Sidebar -->
            <div class="flex items-center flex-shrink-0" style="margin-left: -15px; margin-right: 15px;">
                <button id="sidebar-toggle" class="p-2 rounded-md lg:hidden">
                    <i class="bi bi-list"></i>
                </button>
                <a href="<?php echo e(route('modules.index')); ?>" class="flex items-center group transition-all duration-300">
                    <?php if (isset($component)) { $__componentOriginal8892e718f3d0d7a916180885c6f012e7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8892e718f3d0d7a916180885c6f012e7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.application-logo','data' => ['style' => 'width: 36px; height: 36px;','class' => 'block fill-current text-cesodo-red group-hover:scale-110 transition-transform duration-300']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('application-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['style' => 'width: 36px; height: 36px;','class' => 'block fill-current text-cesodo-red group-hover:scale-110 transition-transform duration-300']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8892e718f3d0d7a916180885c6f012e7)): ?>
<?php $attributes = $__attributesOriginal8892e718f3d0d7a916180885c6f012e7; ?>
<?php unset($__attributesOriginal8892e718f3d0d7a916180885c6f012e7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8892e718f3d0d7a916180885c6f012e7)): ?>
<?php $component = $__componentOriginal8892e718f3d0d7a916180885c6f012e7; ?>
<?php unset($__componentOriginal8892e718f3d0d7a916180885c6f012e7); ?>
<?php endif; ?>
                    <span class="ml-3 text-xl font-bold text-cesodo-white group-hover:text-cesodo-red transition-colors duration-300" style="font-family: var(--cesodo-font-family);">CESODO</span>
                </a>
            </div>

                    <!-- Container scrolleable con gradientes -->
                    <div class="nav-wrapper" style="overflow: visible;">
                        <div class="nav-gradient nav-gradient-left"></div>
                        <div id="nav-container" class="nav-container">
                            <div class="nav-inner">
                            <!-- Inicio y Dashboard -->
                            <?php if (isset($component)) { $__componentOriginalc295f12dca9d42f28a259237a5724830 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc295f12dca9d42f28a259237a5724830 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav-link','data' => ['href' => route('modules.index'),'active' => request()->routeIs('modules.*')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('modules.index')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('modules.*'))]); ?>
                                <i class="bi bi-grid-3x3-gap me-1"></i><?php echo e(__('Módulos')); ?>

                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $attributes = $__attributesOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__attributesOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $component = $__componentOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__componentOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>

                            <?php if (isset($component)) { $__componentOriginalc295f12dca9d42f28a259237a5724830 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc295f12dca9d42f28a259237a5724830 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav-link','data' => ['href' => route('dashboard'),'active' => request()->routeIs('dashboard')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('dashboard')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('dashboard'))]); ?>
                                <i class="bi bi-speedometer2 me-1"></i><?php echo e(__('Dashboard')); ?>

                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $attributes = $__attributesOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__attributesOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $component = $__componentOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__componentOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>

                            <!-- Enlace simple de Reportes para test -->
                            <?php if (isset($component)) { $__componentOriginalc295f12dca9d42f28a259237a5724830 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc295f12dca9d42f28a259237a5724830 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav-link','data' => ['href' => route('reportes.index'),'active' => request()->routeIs('reportes.*')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('reportes.index')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('reportes.*'))]); ?>
                                <i class="bi bi-graph-up me-1"></i><?php echo e(__('Reportes')); ?>

                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $attributes = $__attributesOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__attributesOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $component = $__componentOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__componentOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>

                            <!-- Grupo: Gestión de Personal -->
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['ver-trabajadores', 'ver-usuarios'])): ?>
                            <div class="nav-dropdown" id="dropdown-personal">
                                <button type="button" class="nav-dropdown-trigger <?php echo e(request()->routeIs(['trabajadores.*', 'usuarios.*', 'contratos.*', 'personas.*', 'certificados-medicos.*']) ? 'active' : ''); ?>"
                                        onclick="event.preventDefault(); event.stopPropagation(); toggleNav('dropdown-personal');">
                                    <i class="bi bi-people-fill me-1"></i><?php echo e(__('Personal')); ?>

                                    <i class="bi bi-chevron-down ms-1"></i>
                                </button>
                                <div class="nav-dropdown-menu" style="display: none;">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ver-trabajadores')): ?>
                                    <a href="<?php echo e(route('personas.index')); ?>" class="nav-dropdown-item <?php echo e(request()->routeIs('personas.*') ? 'active' : ''); ?>">
                                        <i class="bi bi-person-vcard me-1"></i><?php echo e(__('Personas')); ?>

                                    </a>
                                    <a href="<?php echo e(route('trabajadores.index')); ?>" class="nav-dropdown-item <?php echo e(request()->routeIs('trabajadores.*') ? 'active' : ''); ?>">
                                        <i class="bi bi-people me-1"></i><?php echo e(__('Trabajadores')); ?>

                                    </a>
                                    <a href="<?php echo e(route('contratos.index')); ?>" class="nav-dropdown-item <?php echo e(request()->routeIs('contratos.*') ? 'active' : ''); ?>">
                                        <i class="bi bi-file-earmark-text me-1"></i><?php echo e(__('Contratos')); ?>

                                    </a>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ver-inventario')): ?>
                                    <a href="<?php echo e(route('certificados-medicos.index')); ?>" class="nav-dropdown-item <?php echo e(request()->routeIs('certificados-medicos.*') ? 'active' : ''); ?>">
                                        <i class="bi bi-file-medical me-1"></i><?php echo e(__('Certificados Médicos')); ?>

                                    </a>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ver-usuarios')): ?>
                                    <a href="<?php echo e(route('usuarios.index')); ?>" class="nav-dropdown-item <?php echo e(request()->routeIs('usuarios.*') ? 'active' : ''); ?>">
                                        <i class="bi bi-person-gear me-1"></i><?php echo e(__('Usuarios')); ?>

                                    </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endif; ?>

                            <!-- Grupo: Inventario y Productos -->
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['ver-inventario', 'ver-productos'])): ?>
                            <div class="nav-dropdown nav-item-container" id="dropdown-inventario">
                                <button type="button" class="nav-dropdown-trigger d-inline-flex align-items-center gap-2 <?php echo e(request()->routeIs(['inventarios.*', 'productos.*', 'categorias.*', 'kardex.*']) ? 'active' : ''); ?>"
                                        onclick="event.preventDefault(); event.stopPropagation(); toggleNav('dropdown-inventario');">
                                    <i class="bi bi-boxes"></i>
                                    <span class="d-none d-lg-inline"><?php echo e(__('Inventario')); ?></span>
                                    <span class="d-lg-none" title="<?php echo e(__('Inventario')); ?>">
                                        <i class="bi bi-boxes-fill"></i>
                                    </span>
                                    <i class="bi bi-chevron-down"></i>
                                </button>
                                <div class="nav-dropdown-menu shadow-sm border" style="display: none; min-width: 220px;">
                                    <div class="py-2">
                                        <div class="px-3 pb-2 text-sm font-weight-bold border-bottom">
                                            <?php echo e(__('Gestión de Inventario')); ?>

                                        </div>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ver-productos')): ?>
                                        <a href="<?php echo e(route('categorias.index')); ?>" class="nav-dropdown-item d-flex align-items-center gap-2 <?php echo e(request()->routeIs('categorias.*') ? 'active' : ''); ?>">
                                            <i class="bi bi-tags"></i>
                                            <div>
                                                <span class="d-block"><?php echo e(__('Categorías')); ?></span>
                                                <small class="text-muted">Organiza tus productos</small>
                                            </div>
                                        </a>
                                        <a href="<?php echo e(route('productos.index')); ?>" class="nav-dropdown-item d-flex align-items-center gap-2 <?php echo e(request()->routeIs('productos.*') ? 'active' : ''); ?>">
                                            <i class="bi bi-box-seam"></i>
                                            <div>
                                                <span class="d-block"><?php echo e(__('Productos')); ?></span>
                                                <small class="text-muted">Catálogo de productos</small>
                                            </div>
                                        </a>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ver-inventario')): ?>
                                        <a href="<?php echo e(route('inventarios.index')); ?>" class="nav-dropdown-item d-flex align-items-center gap-2 <?php echo e(request()->routeIs('inventarios.*') ? 'active' : ''); ?>">
                                            <i class="bi bi-boxes"></i>
                                            <div>
                                                <span class="d-block"><?php echo e(__('Stock')); ?></span>
                                                <small class="text-muted">Control de existencias</small>
                                            </div>
                                        </a>
                                        <a href="<?php echo e(route('kardex.index')); ?>" class="nav-dropdown-item d-flex align-items-center gap-2 <?php echo e(request()->routeIs('kardex.*') ? 'active' : ''); ?>">
                                            <i class="bi bi-clipboard-data"></i>
                                            <div>
                                                <span class="d-block"><?php echo e(__('Kardex')); ?></span>
                                                <small class="text-muted">Movimientos de inventario</small>
                                            </div>
                                        </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>

                            <!-- Grupo: Operaciones y Producción -->
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['ver-consumos', 'ver-inventario'])): ?>
                            <div class="nav-dropdown" id="dropdown-operaciones">
                                <button type="button" class="nav-dropdown-trigger <?php echo e(request()->routeIs(['consumos.*', 'menus.*', 'recetas.*']) ? 'active' : ''); ?>"
                                        onclick="event.preventDefault(); event.stopPropagation(); toggleNav('dropdown-operaciones');">
                                    <i class="bi bi-calendar-week me-1"></i><?php echo e(__('Operaciones')); ?>

                                    <i class="bi bi-chevron-down ms-1"></i>
                                </button>
                                <div class="nav-dropdown-menu" style="display: none;">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ver-inventario')): ?>
                                    <a href="<?php echo e(route('menus.index')); ?>" class="nav-dropdown-item <?php echo e(request()->routeIs('menus.*') ? 'active' : ''); ?>">
                                        <i class="bi bi-calendar-week me-1"></i><?php echo e(__('Menús')); ?>

                                    </a>
                                    <a href="<?php echo e(route('recetas.index')); ?>" class="nav-dropdown-item <?php echo e(request()->routeIs('recetas.*') ? 'active' : ''); ?>">
                                        <i class="bi bi-journal-bookmark me-1"></i><?php echo e(__('Recetas')); ?>

                                    </a>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ver-consumos')): ?>
                                    <a href="<?php echo e(route('consumos.index')); ?>" class="nav-dropdown-item <?php echo e(request()->routeIs('consumos.*') ? 'active' : ''); ?>">
                                        <i class="bi bi-journal-text me-1"></i><?php echo e(__('Consumos')); ?>

                                    </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endif; ?>

                            <!-- Grupo: Comercial y Ventas -->
                            <div class="nav-dropdown" id="dropdown-comercial">
                                <button type="button" class="nav-dropdown-trigger <?php echo e(request()->routeIs(['clientes.*', 'ventas.*', 'pedidos.*']) ? 'active' : ''); ?>"
                                        onclick="event.preventDefault(); event.stopPropagation(); toggleNav('dropdown-comercial');">
                                    <i class="bi bi-cart3 me-1"></i><?php echo e(__('Comercial')); ?>

                                    <i class="bi bi-chevron-down ms-1"></i>
                                </button>
                                <div class="nav-dropdown-menu" style="display: none;">
                                    <div class="px-3 pb-2 text-sm font-weight-bold border-bottom">
                                        <?php echo e(__('Gestión Comercial')); ?>

                                    </div>
                                    <a href="<?php echo e(route('clientes.index')); ?>" class="nav-dropdown-item <?php echo e(request()->routeIs('clientes.*') ? 'active' : ''); ?>">
                                        <i class="bi bi-people me-1"></i><?php echo e(__('Clientes')); ?>

                                    </a>
                                    <a href="<?php echo e(route('ventas.index')); ?>" class="nav-dropdown-item <?php echo e(request()->routeIs('ventas.*') ? 'active' : ''); ?>">
                                        <i class="bi bi-receipt me-1"></i><?php echo e(__('Ventas')); ?>

                                    </a>
                                    <a href="<?php echo e(route('pedidos.index')); ?>" class="nav-dropdown-item <?php echo e(request()->routeIs('pedidos.*') ? 'active' : ''); ?>">
                                        <i class="bi bi-cart3 me-1"></i><?php echo e(__('Pedidos')); ?>

                                    </a>
                                </div>
                            </div>

                            <!-- Grupo: Compras y Proveedores -->
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ver-proveedores')): ?>
                            <div class="nav-dropdown" id="dropdown-compras">
                                <button type="button" class="nav-dropdown-trigger <?php echo e(request()->routeIs(['proveedores.*', 'compras.*']) ? 'active' : ''); ?>"
                                        onclick="event.preventDefault(); event.stopPropagation(); toggleNav('dropdown-compras');">
                                    <i class="bi bi-truck me-1"></i><?php echo e(__('Compras')); ?>

                                    <i class="bi bi-chevron-down ms-1"></i>
                                </button>
                                <div class="nav-dropdown-menu" style="display: none;">
                                    <div class="px-3 pb-2 text-sm font-weight-bold border-bottom">
                                        <?php echo e(__('Gestión de Compras')); ?>

                                    </div>
                                    <a href="<?php echo e(route('proveedores.index')); ?>" class="nav-dropdown-item <?php echo e(request()->routeIs('proveedores.*') ? 'active' : ''); ?>">
                                        <i class="bi bi-truck me-1"></i><?php echo e(__('Proveedores')); ?>

                                    </a>
                                    <a href="<?php echo e(route('compras.index')); ?>" class="nav-dropdown-item <?php echo e(request()->routeIs('compras.*') ? 'active' : ''); ?>">
                                        <i class="bi bi-bag me-1"></i><?php echo e(__('Órdenes de Compra')); ?>

                                    </a>
                                </div>
                            </div>
                            <?php endif; ?>

                            <!-- Grupo: Administración del Sistema -->
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ver-configuraciones')): ?>
                            <div class="nav-dropdown" id="dropdown-administracion">
                                <button type="button" class="nav-dropdown-trigger <?php echo e(request()->routeIs(['configurations.*', 'role-management.*', 'dynamic-fields.*', 'contratos.templates.*']) ? 'active' : ''); ?>"
                                        onclick="event.preventDefault(); event.stopPropagation(); toggleNav('dropdown-administracion');">
                                    <i class="bi bi-gear-fill me-1"></i><?php echo e(__('Administración')); ?>

                                    <i class="bi bi-chevron-down ms-1"></i>
                                </button>
                                <div class="nav-dropdown-menu shadow-sm border" style="display: none; min-width: 250px;">
                                    <div class="py-2">
                                        <div class="px-3 pb-2 text-sm font-weight-bold border-bottom">
                                            <?php echo e(__('Sistema y Configuración')); ?>

                                        </div>
                                        <a href="<?php echo e(route('configurations.index')); ?>" class="nav-dropdown-item d-flex align-items-center gap-2 <?php echo e(request()->routeIs('configurations.*') ? 'active' : ''); ?>">
                                            <i class="bi bi-sliders"></i>
                                            <div>
                                                <span class="d-block"><?php echo e(__('Configuraciones')); ?></span>
                                                <small class="text-muted">Parámetros del sistema</small>
                                            </div>
                                        </a>
                                        <a href="<?php echo e(route('role-management.index')); ?>" class="nav-dropdown-item d-flex align-items-center gap-2 <?php echo e(request()->routeIs('role-management.*') ? 'active' : ''); ?>">
                                            <i class="bi bi-shield-lock"></i>
                                            <div>
                                                <span class="d-block"><?php echo e(__('Gestión de Roles')); ?></span>
                                                <small class="text-muted">Roles y permisos</small>
                                            </div>
                                        </a>
                                        <a href="<?php echo e(route('dynamic-fields.index')); ?>" class="nav-dropdown-item d-flex align-items-center gap-2 <?php echo e(request()->routeIs('dynamic-fields.*') ? 'active' : ''); ?>">
                                            <i class="bi bi-puzzle"></i>
                                            <div>
                                                <span class="d-block"><?php echo e(__('Campos Dinámicos')); ?></span>
                                                <small class="text-muted">Extensibilidad de módulos</small>
                                            </div>
                                        </a>
                                        <a href="<?php echo e(route('contratos.templates.index')); ?>" class="nav-dropdown-item d-flex align-items-center gap-2 <?php echo e(request()->routeIs('contratos.templates.*') ? 'active' : ''); ?>">
                                            <i class="bi bi-file-earmark-plus"></i>
                                            <div>
                                                <span class="d-block"><?php echo e(__('Plantillas de Contratos')); ?></span>
                                                <small class="text-muted">Templates y documentos</small>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
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
            <div class="hidden sm:flex sm:items-center user-dropdown-right flex-shrink-0" style="margin-left: 20px;">
                <?php if (isset($component)) { $__componentOriginaldf8083d4a852c446488d8d384bbc7cbe = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dropdown','data' => ['align' => 'right','width' => '48']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dropdown'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['align' => 'right','width' => '48']); ?>
                     <?php $__env->slot('trigger', null, []); ?> 
                        <button class="inline-flex items-center px-4 py-2 border border-gray-200 text-sm leading-4 font-medium rounded-lg text-gray-600 bg-white hover:text-gray-800 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1 transition ease-in-out duration-150 shadow-sm">
                            <i class="bi bi-person-circle me-2 text-lg"></i>
                            <div><?php echo e(Auth::user()->name); ?></div>
                            <div class="ms-2">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                     <?php $__env->endSlot(); ?>

                     <?php $__env->slot('content', null, []); ?> 
                        <?php if (isset($component)) { $__componentOriginal68cb1971a2b92c9735f83359058f7108 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal68cb1971a2b92c9735f83359058f7108 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dropdown-link','data' => ['href' => route('profile.edit')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dropdown-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('profile.edit'))]); ?>
                            <?php echo e(__('Profile')); ?>

                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal68cb1971a2b92c9735f83359058f7108)): ?>
<?php $attributes = $__attributesOriginal68cb1971a2b92c9735f83359058f7108; ?>
<?php unset($__attributesOriginal68cb1971a2b92c9735f83359058f7108); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal68cb1971a2b92c9735f83359058f7108)): ?>
<?php $component = $__componentOriginal68cb1971a2b92c9735f83359058f7108; ?>
<?php unset($__componentOriginal68cb1971a2b92c9735f83359058f7108); ?>
<?php endif; ?>

                        <!-- Authentication -->
                        <form method="POST" action="<?php echo e(route('logout')); ?>">
                            <?php echo csrf_field(); ?>

                            <?php if (isset($component)) { $__componentOriginal68cb1971a2b92c9735f83359058f7108 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal68cb1971a2b92c9735f83359058f7108 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dropdown-link','data' => ['href' => route('logout'),'onclick' => 'event.preventDefault();
                                                this.closest(\'form\').submit();']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dropdown-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('logout')),'onclick' => 'event.preventDefault();
                                                this.closest(\'form\').submit();']); ?>
                                <?php echo e(__('Log Out')); ?>

                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal68cb1971a2b92c9735f83359058f7108)): ?>
<?php $attributes = $__attributesOriginal68cb1971a2b92c9735f83359058f7108; ?>
<?php unset($__attributesOriginal68cb1971a2b92c9735f83359058f7108); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal68cb1971a2b92c9735f83359058f7108)): ?>
<?php $component = $__componentOriginal68cb1971a2b92c9735f83359058f7108; ?>
<?php unset($__componentOriginal68cb1971a2b92c9735f83359058f7108); ?>
<?php endif; ?>
                        </form>
                     <?php $__env->endSlot(); ?>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe)): ?>
<?php $attributes = $__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe; ?>
<?php unset($__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldf8083d4a852c446488d8d384bbc7cbe)): ?>
<?php $component = $__componentOriginaldf8083d4a852c446488d8d384bbc7cbe; ?>
<?php unset($__componentOriginaldf8083d4a852c446488d8d384bbc7cbe); ?>
<?php endif; ?>
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
            <?php if (isset($component)) { $__componentOriginald69b52d99510f1e7cd3d80070b28ca18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-nav-link','data' => ['href' => route('modules.index'),'active' => request()->routeIs('modules.*')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('modules.index')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('modules.*'))]); ?>
                <i class="bi bi-grid-3x3-gap me-2"></i><?php echo e(__('Módulos')); ?>

             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $attributes = $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $component = $__componentOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginald69b52d99510f1e7cd3d80070b28ca18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-nav-link','data' => ['href' => route('dashboard'),'active' => request()->routeIs('dashboard')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('dashboard')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('dashboard'))]); ?>
                <i class="bi bi-speedometer2 me-2"></i><?php echo e(__('Dashboard')); ?>

             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $attributes = $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $component = $__componentOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>

            <!-- Personal -->
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['ver-trabajadores', 'ver-usuarios'])): ?>
            <div class="px-4 py-2">
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider"><?php echo e(__('Personal')); ?></div>
            </div>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ver-trabajadores')): ?>
            <?php if (isset($component)) { $__componentOriginald69b52d99510f1e7cd3d80070b28ca18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-nav-link','data' => ['href' => route('personas.index'),'active' => request()->routeIs('personas.*')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('personas.index')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('personas.*'))]); ?>
                <i class="bi bi-person-vcard me-2"></i><?php echo e(__('Personas')); ?>

             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $attributes = $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $component = $__componentOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginald69b52d99510f1e7cd3d80070b28ca18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-nav-link','data' => ['href' => route('trabajadores.index'),'active' => request()->routeIs('trabajadores.*')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('trabajadores.index')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('trabajadores.*'))]); ?>
                <i class="bi bi-people me-2"></i><?php echo e(__('Trabajadores')); ?>

             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $attributes = $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $component = $__componentOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginald69b52d99510f1e7cd3d80070b28ca18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-nav-link','data' => ['href' => route('contratos.index'),'active' => request()->routeIs('contratos.*')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('contratos.index')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('contratos.*'))]); ?>
                <i class="bi bi-file-earmark-text me-2"></i><?php echo e(__('Contratos')); ?>

             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $attributes = $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $component = $__componentOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ver-inventario')): ?>
            <?php if (isset($component)) { $__componentOriginald69b52d99510f1e7cd3d80070b28ca18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-nav-link','data' => ['href' => route('certificados-medicos.index'),'active' => request()->routeIs('certificados-medicos.*')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('certificados-medicos.index')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('certificados-medicos.*'))]); ?>
                <i class="bi bi-file-medical me-2"></i><?php echo e(__('Certificados Médicos')); ?>

             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $attributes = $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $component = $__componentOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ver-usuarios')): ?>
            <?php if (isset($component)) { $__componentOriginald69b52d99510f1e7cd3d80070b28ca18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-nav-link','data' => ['href' => route('usuarios.index'),'active' => request()->routeIs('usuarios.*')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('usuarios.index')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('usuarios.*'))]); ?>
                <i class="bi bi-person-gear me-2"></i><?php echo e(__('Usuarios')); ?>

             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $attributes = $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $component = $__componentOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
            <?php endif; ?>
            <?php endif; ?>

            <!-- Inventario -->
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['ver-inventario', 'ver-productos'])): ?>
            <div class="px-4 py-2">
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider"><?php echo e(__('Inventario')); ?></div>
            </div>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ver-productos')): ?>
            <?php if (isset($component)) { $__componentOriginald69b52d99510f1e7cd3d80070b28ca18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-nav-link','data' => ['href' => route('categorias.index'),'active' => request()->routeIs('categorias.*')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('categorias.index')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('categorias.*'))]); ?>
                <i class="bi bi-tags me-2"></i><?php echo e(__('Categorías')); ?>

             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $attributes = $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $component = $__componentOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginald69b52d99510f1e7cd3d80070b28ca18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-nav-link','data' => ['href' => route('productos.index'),'active' => request()->routeIs('productos.*')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('productos.index')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('productos.*'))]); ?>
                <i class="bi bi-box-seam me-2"></i><?php echo e(__('Productos')); ?>

             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $attributes = $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $component = $__componentOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ver-inventario')): ?>
            <?php if (isset($component)) { $__componentOriginald69b52d99510f1e7cd3d80070b28ca18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-nav-link','data' => ['href' => route('inventarios.index'),'active' => request()->routeIs('inventarios.*')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('inventarios.index')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('inventarios.*'))]); ?>
                <i class="bi bi-boxes me-2"></i><?php echo e(__('Stock')); ?>

             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $attributes = $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $component = $__componentOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginald69b52d99510f1e7cd3d80070b28ca18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-nav-link','data' => ['href' => route('kardex.index'),'active' => request()->routeIs('kardex.*')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('kardex.index')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('kardex.*'))]); ?>
                <i class="bi bi-clipboard-data me-2"></i><?php echo e(__('Kardex')); ?>

             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $attributes = $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $component = $__componentOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
            <?php endif; ?>
            <?php endif; ?>

            <!-- Operaciones -->
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['ver-consumos', 'ver-inventario'])): ?>
            <div class="px-4 py-2">
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider"><?php echo e(__('Operaciones')); ?></div>
            </div>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ver-inventario')): ?>
            <?php if (isset($component)) { $__componentOriginald69b52d99510f1e7cd3d80070b28ca18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-nav-link','data' => ['href' => route('menus.index'),'active' => request()->routeIs('menus.*')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('menus.index')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('menus.*'))]); ?>
                <i class="bi bi-calendar-week me-2"></i><?php echo e(__('Menús')); ?>

             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $attributes = $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $component = $__componentOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginald69b52d99510f1e7cd3d80070b28ca18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-nav-link','data' => ['href' => route('recetas.index'),'active' => request()->routeIs('recetas.*')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('recetas.index')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('recetas.*'))]); ?>
                <i class="bi bi-journal-bookmark me-2"></i><?php echo e(__('Recetas')); ?>

             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $attributes = $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $component = $__componentOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ver-consumos')): ?>
            <?php if (isset($component)) { $__componentOriginald69b52d99510f1e7cd3d80070b28ca18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-nav-link','data' => ['href' => route('consumos.index'),'active' => request()->routeIs('consumos.*')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('consumos.index')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('consumos.*'))]); ?>
                <i class="bi bi-journal-text me-2"></i><?php echo e(__('Consumos')); ?>

             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $attributes = $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $component = $__componentOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
            <?php endif; ?>
            <?php endif; ?>

            <!-- Comercial -->
            <div class="px-4 py-2">
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider"><?php echo e(__('Comercial')); ?></div>
            </div>
            <?php if (isset($component)) { $__componentOriginald69b52d99510f1e7cd3d80070b28ca18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-nav-link','data' => ['href' => route('clientes.index'),'active' => request()->routeIs('clientes.*')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('clientes.index')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('clientes.*'))]); ?>
                <i class="bi bi-people me-2"></i><?php echo e(__('Clientes')); ?>

             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $attributes = $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $component = $__componentOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginald69b52d99510f1e7cd3d80070b28ca18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-nav-link','data' => ['href' => route('ventas.index'),'active' => request()->routeIs('ventas.*')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('ventas.index')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('ventas.*'))]); ?>
                <i class="bi bi-receipt me-2"></i><?php echo e(__('Ventas')); ?>

             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $attributes = $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $component = $__componentOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginald69b52d99510f1e7cd3d80070b28ca18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-nav-link','data' => ['href' => route('pedidos.index'),'active' => request()->routeIs('pedidos.*')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('pedidos.index')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('pedidos.*'))]); ?>
                <i class="bi bi-cart3 me-2"></i><?php echo e(__('Pedidos')); ?>

             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $attributes = $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $component = $__componentOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>

            <!-- Compras -->
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ver-proveedores')): ?>
            <div class="px-4 py-2">
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider"><?php echo e(__('Compras')); ?></div>
            </div>
            <?php if (isset($component)) { $__componentOriginald69b52d99510f1e7cd3d80070b28ca18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-nav-link','data' => ['href' => route('proveedores.index'),'active' => request()->routeIs('proveedores.*')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('proveedores.index')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('proveedores.*'))]); ?>
                <i class="bi bi-truck me-2"></i><?php echo e(__('Proveedores')); ?>

             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $attributes = $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $component = $__componentOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginald69b52d99510f1e7cd3d80070b28ca18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-nav-link','data' => ['href' => route('compras.index'),'active' => request()->routeIs('compras.*')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('compras.index')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('compras.*'))]); ?>
                <i class="bi bi-bag me-2"></i><?php echo e(__('Órdenes de Compra')); ?>

             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $attributes = $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $component = $__componentOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
            <?php endif; ?>

            <!-- Reportes -->
            <div class="px-4 py-2">
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider"><?php echo e(__('Reportes')); ?></div>
            </div>
            <?php if (isset($component)) { $__componentOriginald69b52d99510f1e7cd3d80070b28ca18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-nav-link','data' => ['href' => route('reportes.index'),'active' => request()->routeIs('reportes.*')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('reportes.index')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('reportes.*'))]); ?>
                <i class="bi bi-graph-up me-2"></i><?php echo e(__('Dashboard de Reportes')); ?>

             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $attributes = $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $component = $__componentOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginald69b52d99510f1e7cd3d80070b28ca18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-nav-link','data' => ['href' => route('reportes.consumos'),'active' => request()->routeIs('reportes.consumos')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('reportes.consumos')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('reportes.consumos'))]); ?>
                <i class="bi bi-journal-text me-2"></i><?php echo e(__('Reportes de Consumos')); ?>

             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $attributes = $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $component = $__componentOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginald69b52d99510f1e7cd3d80070b28ca18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-nav-link','data' => ['href' => route('reportes.inventario'),'active' => request()->routeIs('reportes.inventario')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('reportes.inventario')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('reportes.inventario'))]); ?>
                <i class="bi bi-boxes me-2"></i><?php echo e(__('Reportes de Inventario')); ?>

             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $attributes = $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $component = $__componentOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginald69b52d99510f1e7cd3d80070b28ca18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-nav-link','data' => ['href' => route('reportes.ventas'),'active' => request()->routeIs('reportes.ventas')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('reportes.ventas')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('reportes.ventas'))]); ?>
                <i class="bi bi-receipt me-2"></i><?php echo e(__('Reportes de Ventas')); ?>

             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $attributes = $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $component = $__componentOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginald69b52d99510f1e7cd3d80070b28ca18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-nav-link','data' => ['href' => route('reportes.proveedores'),'active' => request()->routeIs('reportes.proveedores')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('reportes.proveedores')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('reportes.proveedores'))]); ?>
                <i class="bi bi-truck me-2"></i><?php echo e(__('Reportes de Proveedores')); ?>

             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $attributes = $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $component = $__componentOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>

            <!-- Administración -->
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ver-configuraciones')): ?>
            <div class="px-4 py-2">
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider"><?php echo e(__('Administración')); ?></div>
            </div>
            <?php if (isset($component)) { $__componentOriginald69b52d99510f1e7cd3d80070b28ca18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-nav-link','data' => ['href' => route('configurations.index'),'active' => request()->routeIs('configurations.*')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('configurations.index')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('configurations.*'))]); ?>
                <i class="bi bi-sliders me-2"></i><?php echo e(__('Configuraciones')); ?>

             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $attributes = $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $component = $__componentOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginald69b52d99510f1e7cd3d80070b28ca18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-nav-link','data' => ['href' => route('role-management.index'),'active' => request()->routeIs('role-management.*')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('role-management.index')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('role-management.*'))]); ?>
                <i class="bi bi-shield-lock me-2"></i><?php echo e(__('Gestión de Roles')); ?>

             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $attributes = $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $component = $__componentOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginald69b52d99510f1e7cd3d80070b28ca18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-nav-link','data' => ['href' => route('dynamic-fields.index'),'active' => request()->routeIs('dynamic-fields.*')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('dynamic-fields.index')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('dynamic-fields.*'))]); ?>
                <i class="bi bi-puzzle me-2"></i><?php echo e(__('Campos Dinámicos')); ?>

             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $attributes = $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $component = $__componentOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginald69b52d99510f1e7cd3d80070b28ca18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-nav-link','data' => ['href' => route('contratos.templates.index'),'active' => request()->routeIs('contratos.templates.*')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('contratos.templates.index')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('contratos.templates.*'))]); ?>
                <i class="bi bi-file-earmark-plus me-2"></i><?php echo e(__('Plantillas de Contratos')); ?>

             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $attributes = $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $component = $__componentOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
            <?php endif; ?>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800"><?php echo e(Auth::user()->name); ?></div>
                <div class="font-medium text-sm text-gray-500"><?php echo e(Auth::user()->email); ?></div>
            </div>

            <div class="mt-3 space-y-1">
                <?php if (isset($component)) { $__componentOriginald69b52d99510f1e7cd3d80070b28ca18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-nav-link','data' => ['href' => route('profile.edit')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('profile.edit'))]); ?>
                    <?php echo e(__('Profile')); ?>

                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $attributes = $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $component = $__componentOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>

                <!-- Authentication -->
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>

                    <?php if (isset($component)) { $__componentOriginald69b52d99510f1e7cd3d80070b28ca18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-nav-link','data' => ['href' => route('logout'),'onclick' => 'event.preventDefault();
                                        this.closest(\'form\').submit();']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('logout')),'onclick' => 'event.preventDefault();
                                        this.closest(\'form\').submit();']); ?>
                        <?php echo e(__('Log Out')); ?>

                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $attributes = $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $component = $__componentOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
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
<?php /**PATH C:\xampp\htdocs\cesodo4\resources\views/layouts/navigation.blade.php ENDPATH**/ ?>