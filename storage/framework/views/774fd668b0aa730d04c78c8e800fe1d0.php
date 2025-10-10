<?php $__env->startSection('title', 'Panel de Módulos'); ?>

<?php $__env->startSection('content'); ?>
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
                        <div class="h4 mb-0 fw-bold" style="color: #dc2626;"><?php echo e(auth()->user()->name); ?></div>
                        <small style="color: #6b7280; font-weight: 500;">Usuario Actual</small>
                    </div>
                    <div class="vr" style="height: 40px; opacity: 0.3;"></div>
                    <div class="text-center">
                        <div class="h4 mb-0 fw-bold" style="color: #dc2626;"><?php echo e(now()->setTimezone('America/Lima')->format('H:i')); ?></div>
                        <small style="color: #6b7280; font-weight: 500;">Hora Perú</small>
                    </div>
                    <div class="vr" style="height: 40px; opacity: 0.3;"></div>
                    <div class="text-center">
                        <div class="h4 mb-0 fw-bold" style="color: #dc2626;"><?php echo e(now()->setTimezone('America/Lima')->format('d/m/Y')); ?></div>
                        <small style="color: #6b7280; font-weight: 500;">Fecha</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Módulos Grid -->
    <div class="row justify-content-center">

        <!-- Dashboard -->
        <?php if (isset($component)) { $__componentOriginal51af8fcedb96b90eb762c804b9e96d95 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal51af8fcedb96b90eb762c804b9e96d95 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.module-card','data' => ['title' => 'Dashboard','description' => 'Panel principal con estadísticas y resumen del sistema','route' => ''.e(route('dashboard')).'','icon' => 'bi-speedometer2','color' => 'primary']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('module-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Dashboard','description' => 'Panel principal con estadísticas y resumen del sistema','route' => ''.e(route('dashboard')).'','icon' => 'bi-speedometer2','color' => 'primary']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal51af8fcedb96b90eb762c804b9e96d95)): ?>
<?php $attributes = $__attributesOriginal51af8fcedb96b90eb762c804b9e96d95; ?>
<?php unset($__attributesOriginal51af8fcedb96b90eb762c804b9e96d95); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal51af8fcedb96b90eb762c804b9e96d95)): ?>
<?php $component = $__componentOriginal51af8fcedb96b90eb762c804b9e96d95; ?>
<?php unset($__componentOriginal51af8fcedb96b90eb762c804b9e96d95); ?>
<?php endif; ?>

        <!-- === GESTIÓN DE PERSONAL === -->
        <?php if (isset($component)) { $__componentOriginal51af8fcedb96b90eb762c804b9e96d95 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal51af8fcedb96b90eb762c804b9e96d95 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.module-card','data' => ['title' => 'Trabajadores','description' => 'Gestión completa del personal y empleados','route' => ''.e(route('trabajadores.index')).'','icon' => 'bi-people','color' => 'success','permission' => 'ver-trabajadores']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('module-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Trabajadores','description' => 'Gestión completa del personal y empleados','route' => ''.e(route('trabajadores.index')).'','icon' => 'bi-people','color' => 'success','permission' => 'ver-trabajadores']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal51af8fcedb96b90eb762c804b9e96d95)): ?>
<?php $attributes = $__attributesOriginal51af8fcedb96b90eb762c804b9e96d95; ?>
<?php unset($__attributesOriginal51af8fcedb96b90eb762c804b9e96d95); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal51af8fcedb96b90eb762c804b9e96d95)): ?>
<?php $component = $__componentOriginal51af8fcedb96b90eb762c804b9e96d95; ?>
<?php unset($__componentOriginal51af8fcedb96b90eb762c804b9e96d95); ?>
<?php endif; ?>

        <?php if (isset($component)) { $__componentOriginal51af8fcedb96b90eb762c804b9e96d95 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal51af8fcedb96b90eb762c804b9e96d95 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.module-card','data' => ['title' => 'Usuarios','description' => 'Administración de usuarios del sistema','route' => ''.e(route('usuarios.index')).'','icon' => 'bi-person-gear','color' => 'info','permission' => 'ver-trabajadores']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('module-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Usuarios','description' => 'Administración de usuarios del sistema','route' => ''.e(route('usuarios.index')).'','icon' => 'bi-person-gear','color' => 'info','permission' => 'ver-trabajadores']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal51af8fcedb96b90eb762c804b9e96d95)): ?>
<?php $attributes = $__attributesOriginal51af8fcedb96b90eb762c804b9e96d95; ?>
<?php unset($__attributesOriginal51af8fcedb96b90eb762c804b9e96d95); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal51af8fcedb96b90eb762c804b9e96d95)): ?>
<?php $component = $__componentOriginal51af8fcedb96b90eb762c804b9e96d95; ?>
<?php unset($__componentOriginal51af8fcedb96b90eb762c804b9e96d95); ?>
<?php endif; ?>

        <?php if (isset($component)) { $__componentOriginal51af8fcedb96b90eb762c804b9e96d95 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal51af8fcedb96b90eb762c804b9e96d95 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.module-card','data' => ['title' => 'Contratos','description' => 'Gestión de contratos laborales','route' => ''.e(route('contratos.index')).'','icon' => 'bi-file-earmark-text','color' => 'warning','permission' => 'ver-trabajadores']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('module-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Contratos','description' => 'Gestión de contratos laborales','route' => ''.e(route('contratos.index')).'','icon' => 'bi-file-earmark-text','color' => 'warning','permission' => 'ver-trabajadores']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal51af8fcedb96b90eb762c804b9e96d95)): ?>
<?php $attributes = $__attributesOriginal51af8fcedb96b90eb762c804b9e96d95; ?>
<?php unset($__attributesOriginal51af8fcedb96b90eb762c804b9e96d95); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal51af8fcedb96b90eb762c804b9e96d95)): ?>
<?php $component = $__componentOriginal51af8fcedb96b90eb762c804b9e96d95; ?>
<?php unset($__componentOriginal51af8fcedb96b90eb762c804b9e96d95); ?>
<?php endif; ?>

        <?php if (isset($component)) { $__componentOriginal51af8fcedb96b90eb762c804b9e96d95 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal51af8fcedb96b90eb762c804b9e96d95 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.module-card','data' => ['title' => 'Personas','description' => 'Registro de datos personales','route' => ''.e(route('personas.index')).'','icon' => 'bi-person-vcard','color' => 'teal','permission' => 'ver-trabajadores']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('module-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Personas','description' => 'Registro de datos personales','route' => ''.e(route('personas.index')).'','icon' => 'bi-person-vcard','color' => 'teal','permission' => 'ver-trabajadores']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal51af8fcedb96b90eb762c804b9e96d95)): ?>
<?php $attributes = $__attributesOriginal51af8fcedb96b90eb762c804b9e96d95; ?>
<?php unset($__attributesOriginal51af8fcedb96b90eb762c804b9e96d95); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal51af8fcedb96b90eb762c804b9e96d95)): ?>
<?php $component = $__componentOriginal51af8fcedb96b90eb762c804b9e96d95; ?>
<?php unset($__componentOriginal51af8fcedb96b90eb762c804b9e96d95); ?>
<?php endif; ?>

        <!-- === OPERACIONES === -->
        <?php if (isset($component)) { $__componentOriginal51af8fcedb96b90eb762c804b9e96d95 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal51af8fcedb96b90eb762c804b9e96d95 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.module-card','data' => ['title' => 'Consumos','description' => 'Control de consumos y gastos','route' => ''.e(route('consumos.index')).'','icon' => 'bi-journal-text','color' => 'orange','permission' => 'ver-consumos']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('module-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Consumos','description' => 'Control de consumos y gastos','route' => ''.e(route('consumos.index')).'','icon' => 'bi-journal-text','color' => 'orange','permission' => 'ver-consumos']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal51af8fcedb96b90eb762c804b9e96d95)): ?>
<?php $attributes = $__attributesOriginal51af8fcedb96b90eb762c804b9e96d95; ?>
<?php unset($__attributesOriginal51af8fcedb96b90eb762c804b9e96d95); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal51af8fcedb96b90eb762c804b9e96d95)): ?>
<?php $component = $__componentOriginal51af8fcedb96b90eb762c804b9e96d95; ?>
<?php unset($__componentOriginal51af8fcedb96b90eb762c804b9e96d95); ?>
<?php endif; ?>

        <?php if (isset($component)) { $__componentOriginal51af8fcedb96b90eb762c804b9e96d95 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal51af8fcedb96b90eb762c804b9e96d95 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.module-card','data' => ['title' => 'Menús','description' => 'Planificación de menús semanales','route' => ''.e(route('menus.index')).'','icon' => 'bi-calendar-week','color' => 'info','permission' => 'ver-inventario']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('module-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Menús','description' => 'Planificación de menús semanales','route' => ''.e(route('menus.index')).'','icon' => 'bi-calendar-week','color' => 'info','permission' => 'ver-inventario']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal51af8fcedb96b90eb762c804b9e96d95)): ?>
<?php $attributes = $__attributesOriginal51af8fcedb96b90eb762c804b9e96d95; ?>
<?php unset($__attributesOriginal51af8fcedb96b90eb762c804b9e96d95); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal51af8fcedb96b90eb762c804b9e96d95)): ?>
<?php $component = $__componentOriginal51af8fcedb96b90eb762c804b9e96d95; ?>
<?php unset($__componentOriginal51af8fcedb96b90eb762c804b9e96d95); ?>
<?php endif; ?>

        <?php if (isset($component)) { $__componentOriginal51af8fcedb96b90eb762c804b9e96d95 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal51af8fcedb96b90eb762c804b9e96d95 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.module-card','data' => ['title' => 'Recetas','description' => 'Gestión de recetas y platos','route' => ''.e(route('recetas.index')).'','icon' => 'bi-journal-bookmark','color' => 'orange','permission' => 'ver-inventario']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('module-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Recetas','description' => 'Gestión de recetas y platos','route' => ''.e(route('recetas.index')).'','icon' => 'bi-journal-bookmark','color' => 'orange','permission' => 'ver-inventario']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal51af8fcedb96b90eb762c804b9e96d95)): ?>
<?php $attributes = $__attributesOriginal51af8fcedb96b90eb762c804b9e96d95; ?>
<?php unset($__attributesOriginal51af8fcedb96b90eb762c804b9e96d95); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal51af8fcedb96b90eb762c804b9e96d95)): ?>
<?php $component = $__componentOriginal51af8fcedb96b90eb762c804b9e96d95; ?>
<?php unset($__componentOriginal51af8fcedb96b90eb762c804b9e96d95); ?>
<?php endif; ?>

        <!-- === INVENTARIO Y PRODUCTOS === -->
        <?php if (isset($component)) { $__componentOriginal51af8fcedb96b90eb762c804b9e96d95 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal51af8fcedb96b90eb762c804b9e96d95 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.module-card','data' => ['title' => 'Inventario','description' => 'Control de stock y almacén','route' => ''.e(route('inventarios.index')).'','icon' => 'bi-boxes','color' => 'purple','permission' => 'ver-inventario']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('module-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Inventario','description' => 'Control de stock y almacén','route' => ''.e(route('inventarios.index')).'','icon' => 'bi-boxes','color' => 'purple','permission' => 'ver-inventario']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal51af8fcedb96b90eb762c804b9e96d95)): ?>
<?php $attributes = $__attributesOriginal51af8fcedb96b90eb762c804b9e96d95; ?>
<?php unset($__attributesOriginal51af8fcedb96b90eb762c804b9e96d95); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal51af8fcedb96b90eb762c804b9e96d95)): ?>
<?php $component = $__componentOriginal51af8fcedb96b90eb762c804b9e96d95; ?>
<?php unset($__componentOriginal51af8fcedb96b90eb762c804b9e96d95); ?>
<?php endif; ?>

        <?php if (isset($component)) { $__componentOriginal51af8fcedb96b90eb762c804b9e96d95 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal51af8fcedb96b90eb762c804b9e96d95 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.module-card','data' => ['title' => 'Kardex','description' => 'Historial de movimientos de inventario','route' => ''.e(route('kardex.index')).'','icon' => 'bi-clipboard-data','color' => 'teal','permission' => 'ver-inventario']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('module-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Kardex','description' => 'Historial de movimientos de inventario','route' => ''.e(route('kardex.index')).'','icon' => 'bi-clipboard-data','color' => 'teal','permission' => 'ver-inventario']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal51af8fcedb96b90eb762c804b9e96d95)): ?>
<?php $attributes = $__attributesOriginal51af8fcedb96b90eb762c804b9e96d95; ?>
<?php unset($__attributesOriginal51af8fcedb96b90eb762c804b9e96d95); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal51af8fcedb96b90eb762c804b9e96d95)): ?>
<?php $component = $__componentOriginal51af8fcedb96b90eb762c804b9e96d95; ?>
<?php unset($__componentOriginal51af8fcedb96b90eb762c804b9e96d95); ?>
<?php endif; ?>

        <?php if (isset($component)) { $__componentOriginal51af8fcedb96b90eb762c804b9e96d95 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal51af8fcedb96b90eb762c804b9e96d95 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.module-card','data' => ['title' => 'Categorías','description' => 'Gestión de categorías de productos','route' => ''.e(route('categorias.index')).'','icon' => 'bi-tags','color' => 'warning','permission' => 'ver-productos']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('module-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Categorías','description' => 'Gestión de categorías de productos','route' => ''.e(route('categorias.index')).'','icon' => 'bi-tags','color' => 'warning','permission' => 'ver-productos']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal51af8fcedb96b90eb762c804b9e96d95)): ?>
<?php $attributes = $__attributesOriginal51af8fcedb96b90eb762c804b9e96d95; ?>
<?php unset($__attributesOriginal51af8fcedb96b90eb762c804b9e96d95); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal51af8fcedb96b90eb762c804b9e96d95)): ?>
<?php $component = $__componentOriginal51af8fcedb96b90eb762c804b9e96d95; ?>
<?php unset($__componentOriginal51af8fcedb96b90eb762c804b9e96d95); ?>
<?php endif; ?>

        <?php if (isset($component)) { $__componentOriginal51af8fcedb96b90eb762c804b9e96d95 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal51af8fcedb96b90eb762c804b9e96d95 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.module-card','data' => ['title' => 'Productos','description' => 'Catálogo y gestión de productos','route' => ''.e(route('productos.index')).'','icon' => 'bi-box-seam','color' => 'success','permission' => 'ver-productos']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('module-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Productos','description' => 'Catálogo y gestión de productos','route' => ''.e(route('productos.index')).'','icon' => 'bi-box-seam','color' => 'success','permission' => 'ver-productos']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal51af8fcedb96b90eb762c804b9e96d95)): ?>
<?php $attributes = $__attributesOriginal51af8fcedb96b90eb762c804b9e96d95; ?>
<?php unset($__attributesOriginal51af8fcedb96b90eb762c804b9e96d95); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal51af8fcedb96b90eb762c804b9e96d95)): ?>
<?php $component = $__componentOriginal51af8fcedb96b90eb762c804b9e96d95; ?>
<?php unset($__componentOriginal51af8fcedb96b90eb762c804b9e96d95); ?>
<?php endif; ?>

        <!-- === COMERCIAL === -->
        <?php if (isset($component)) { $__componentOriginal51af8fcedb96b90eb762c804b9e96d95 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal51af8fcedb96b90eb762c804b9e96d95 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.module-card','data' => ['title' => 'Clientes','description' => 'Gestión de clientes y contactos','route' => ''.e(route('clientes.index')).'','icon' => 'bi-people','color' => 'info']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('module-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Clientes','description' => 'Gestión de clientes y contactos','route' => ''.e(route('clientes.index')).'','icon' => 'bi-people','color' => 'info']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal51af8fcedb96b90eb762c804b9e96d95)): ?>
<?php $attributes = $__attributesOriginal51af8fcedb96b90eb762c804b9e96d95; ?>
<?php unset($__attributesOriginal51af8fcedb96b90eb762c804b9e96d95); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal51af8fcedb96b90eb762c804b9e96d95)): ?>
<?php $component = $__componentOriginal51af8fcedb96b90eb762c804b9e96d95; ?>
<?php unset($__componentOriginal51af8fcedb96b90eb762c804b9e96d95); ?>
<?php endif; ?>

        <?php if (isset($component)) { $__componentOriginal51af8fcedb96b90eb762c804b9e96d95 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal51af8fcedb96b90eb762c804b9e96d95 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.module-card','data' => ['title' => 'Ventas','description' => 'Registro y control de ventas','route' => ''.e(route('ventas.index')).'','icon' => 'bi-receipt','color' => 'success']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('module-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Ventas','description' => 'Registro y control de ventas','route' => ''.e(route('ventas.index')).'','icon' => 'bi-receipt','color' => 'success']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal51af8fcedb96b90eb762c804b9e96d95)): ?>
<?php $attributes = $__attributesOriginal51af8fcedb96b90eb762c804b9e96d95; ?>
<?php unset($__attributesOriginal51af8fcedb96b90eb762c804b9e96d95); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal51af8fcedb96b90eb762c804b9e96d95)): ?>
<?php $component = $__componentOriginal51af8fcedb96b90eb762c804b9e96d95; ?>
<?php unset($__componentOriginal51af8fcedb96b90eb762c804b9e96d95); ?>
<?php endif; ?>

        <?php if (isset($component)) { $__componentOriginal51af8fcedb96b90eb762c804b9e96d95 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal51af8fcedb96b90eb762c804b9e96d95 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.module-card','data' => ['title' => 'Pedidos','description' => 'Gestión de pedidos y órdenes','route' => ''.e(route('pedidos.index')).'','icon' => 'bi-cart3','color' => 'warning']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('module-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Pedidos','description' => 'Gestión de pedidos y órdenes','route' => ''.e(route('pedidos.index')).'','icon' => 'bi-cart3','color' => 'warning']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal51af8fcedb96b90eb762c804b9e96d95)): ?>
<?php $attributes = $__attributesOriginal51af8fcedb96b90eb762c804b9e96d95; ?>
<?php unset($__attributesOriginal51af8fcedb96b90eb762c804b9e96d95); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal51af8fcedb96b90eb762c804b9e96d95)): ?>
<?php $component = $__componentOriginal51af8fcedb96b90eb762c804b9e96d95; ?>
<?php unset($__componentOriginal51af8fcedb96b90eb762c804b9e96d95); ?>
<?php endif; ?>

        <!-- === COMPRAS === -->
        <?php if (isset($component)) { $__componentOriginal51af8fcedb96b90eb762c804b9e96d95 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal51af8fcedb96b90eb762c804b9e96d95 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.module-card','data' => ['title' => 'Proveedores','description' => 'Gestión de proveedores y suministros','route' => ''.e(route('proveedores.index')).'','icon' => 'bi-truck','color' => 'danger','permission' => 'ver-proveedores']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('module-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Proveedores','description' => 'Gestión de proveedores y suministros','route' => ''.e(route('proveedores.index')).'','icon' => 'bi-truck','color' => 'danger','permission' => 'ver-proveedores']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal51af8fcedb96b90eb762c804b9e96d95)): ?>
<?php $attributes = $__attributesOriginal51af8fcedb96b90eb762c804b9e96d95; ?>
<?php unset($__attributesOriginal51af8fcedb96b90eb762c804b9e96d95); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal51af8fcedb96b90eb762c804b9e96d95)): ?>
<?php $component = $__componentOriginal51af8fcedb96b90eb762c804b9e96d95; ?>
<?php unset($__componentOriginal51af8fcedb96b90eb762c804b9e96d95); ?>
<?php endif; ?>

        <?php if (isset($component)) { $__componentOriginal51af8fcedb96b90eb762c804b9e96d95 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal51af8fcedb96b90eb762c804b9e96d95 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.module-card','data' => ['title' => 'Compras','description' => 'Gestión de órdenes de compra','route' => ''.e(route('compras.index')).'','icon' => 'bi-bag','color' => 'purple','permission' => 'ver-proveedores']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('module-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Compras','description' => 'Gestión de órdenes de compra','route' => ''.e(route('compras.index')).'','icon' => 'bi-bag','color' => 'purple','permission' => 'ver-proveedores']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal51af8fcedb96b90eb762c804b9e96d95)): ?>
<?php $attributes = $__attributesOriginal51af8fcedb96b90eb762c804b9e96d95; ?>
<?php unset($__attributesOriginal51af8fcedb96b90eb762c804b9e96d95); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal51af8fcedb96b90eb762c804b9e96d95)): ?>
<?php $component = $__componentOriginal51af8fcedb96b90eb762c804b9e96d95; ?>
<?php unset($__componentOriginal51af8fcedb96b90eb762c804b9e96d95); ?>
<?php endif; ?>

        <!-- === REPORTES === -->
        <?php if (isset($component)) { $__componentOriginal51af8fcedb96b90eb762c804b9e96d95 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal51af8fcedb96b90eb762c804b9e96d95 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.module-card','data' => ['title' => 'Reportes','description' => 'Reportes y análisis del sistema','route' => ''.e(route('reportes.index')).'','icon' => 'bi-graph-up','color' => 'primary']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('module-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Reportes','description' => 'Reportes y análisis del sistema','route' => ''.e(route('reportes.index')).'','icon' => 'bi-graph-up','color' => 'primary']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal51af8fcedb96b90eb762c804b9e96d95)): ?>
<?php $attributes = $__attributesOriginal51af8fcedb96b90eb762c804b9e96d95; ?>
<?php unset($__attributesOriginal51af8fcedb96b90eb762c804b9e96d95); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal51af8fcedb96b90eb762c804b9e96d95)): ?>
<?php $component = $__componentOriginal51af8fcedb96b90eb762c804b9e96d95; ?>
<?php unset($__componentOriginal51af8fcedb96b90eb762c804b9e96d95); ?>
<?php endif; ?>

        <!-- === ADMINISTRACIÓN === -->
        <?php if (isset($component)) { $__componentOriginal51af8fcedb96b90eb762c804b9e96d95 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal51af8fcedb96b90eb762c804b9e96d95 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.module-card','data' => ['title' => 'Configuraciones','description' => 'Configuración general del sistema','route' => ''.e(route('configurations.index')).'','icon' => 'bi-sliders','color' => 'danger','permission' => 'ver-configuraciones']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('module-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Configuraciones','description' => 'Configuración general del sistema','route' => ''.e(route('configurations.index')).'','icon' => 'bi-sliders','color' => 'danger','permission' => 'ver-configuraciones']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal51af8fcedb96b90eb762c804b9e96d95)): ?>
<?php $attributes = $__attributesOriginal51af8fcedb96b90eb762c804b9e96d95; ?>
<?php unset($__attributesOriginal51af8fcedb96b90eb762c804b9e96d95); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal51af8fcedb96b90eb762c804b9e96d95)): ?>
<?php $component = $__componentOriginal51af8fcedb96b90eb762c804b9e96d95; ?>
<?php unset($__componentOriginal51af8fcedb96b90eb762c804b9e96d95); ?>
<?php endif; ?>

        <?php if (isset($component)) { $__componentOriginal51af8fcedb96b90eb762c804b9e96d95 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal51af8fcedb96b90eb762c804b9e96d95 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.module-card','data' => ['title' => 'Gestión de Roles','description' => 'Administración de roles y permisos','route' => ''.e(route('role-management.index')).'','icon' => 'bi-shield-lock','color' => 'warning','permission' => 'ver-configuraciones']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('module-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Gestión de Roles','description' => 'Administración de roles y permisos','route' => ''.e(route('role-management.index')).'','icon' => 'bi-shield-lock','color' => 'warning','permission' => 'ver-configuraciones']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal51af8fcedb96b90eb762c804b9e96d95)): ?>
<?php $attributes = $__attributesOriginal51af8fcedb96b90eb762c804b9e96d95; ?>
<?php unset($__attributesOriginal51af8fcedb96b90eb762c804b9e96d95); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal51af8fcedb96b90eb762c804b9e96d95)): ?>
<?php $component = $__componentOriginal51af8fcedb96b90eb762c804b9e96d95; ?>
<?php unset($__componentOriginal51af8fcedb96b90eb762c804b9e96d95); ?>
<?php endif; ?>

        <?php if (isset($component)) { $__componentOriginal51af8fcedb96b90eb762c804b9e96d95 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal51af8fcedb96b90eb762c804b9e96d95 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.module-card','data' => ['title' => 'Campos Dinámicos','description' => 'Configuración de campos personalizables','route' => ''.e(route('dynamic-fields.index')).'','icon' => 'bi-puzzle','color' => 'info','permission' => 'ver-configuraciones']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('module-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Campos Dinámicos','description' => 'Configuración de campos personalizables','route' => ''.e(route('dynamic-fields.index')).'','icon' => 'bi-puzzle','color' => 'info','permission' => 'ver-configuraciones']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal51af8fcedb96b90eb762c804b9e96d95)): ?>
<?php $attributes = $__attributesOriginal51af8fcedb96b90eb762c804b9e96d95; ?>
<?php unset($__attributesOriginal51af8fcedb96b90eb762c804b9e96d95); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal51af8fcedb96b90eb762c804b9e96d95)): ?>
<?php $component = $__componentOriginal51af8fcedb96b90eb762c804b9e96d95; ?>
<?php unset($__componentOriginal51af8fcedb96b90eb762c804b9e96d95); ?>
<?php endif; ?>

        <?php if (isset($component)) { $__componentOriginal51af8fcedb96b90eb762c804b9e96d95 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal51af8fcedb96b90eb762c804b9e96d95 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.module-card','data' => ['title' => 'Plantillas de Contratos','description' => 'Gestión de plantillas de contratos','route' => ''.e(route('contratos.templates.index')).'','icon' => 'bi-file-earmark-plus','color' => 'teal','permission' => 'ver-configuraciones']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('module-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Plantillas de Contratos','description' => 'Gestión de plantillas de contratos','route' => ''.e(route('contratos.templates.index')).'','icon' => 'bi-file-earmark-plus','color' => 'teal','permission' => 'ver-configuraciones']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal51af8fcedb96b90eb762c804b9e96d95)): ?>
<?php $attributes = $__attributesOriginal51af8fcedb96b90eb762c804b9e96d95; ?>
<?php unset($__attributesOriginal51af8fcedb96b90eb762c804b9e96d95); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal51af8fcedb96b90eb762c804b9e96d95)): ?>
<?php $component = $__componentOriginal51af8fcedb96b90eb762c804b9e96d95; ?>
<?php unset($__componentOriginal51af8fcedb96b90eb762c804b9e96d95); ?>
<?php endif; ?>

    </div>

    <!-- Footer -->
    <div class="text-center mt-5 py-4">
        <div class="text-muted">
            <small>
                © <?php echo e(date('Y')); ?> CESODO - Sistema de Gestión Integral
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cesodo4\resources\views/modules/index.blade.php ENDPATH**/ ?>