<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/cesodo-theme.css')); ?>">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/gridstack/8.4.0/gridstack.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/gridstack/8.4.0/gridstack-all.min.js"></script>
<link href="<?php echo e(asset('css/dashboard-widgets.css')); ?>" rel="stylesheet">
<style>
    /* ⚡ ELIMINACIÓN RADICAL DE ESPACIOS EN BLANCO */
    .container-fluid {
        margin: 0 !important;
        padding: 0 15px !important;
    }

    .dashboard-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        overflow: hidden;
    }
    .dashboard-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }
    .chart-container {
        position: relative;
        height: 300px;
    }
    .table-card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .animate-fade-in {
        animation: fadeIn 0.6s ease-in;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .welcome-header {
        background: linear-gradient(135deg, var(--cesodo-black) 0%, var(--cesodo-red) 100%);
        color: white;
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        margin-top: 0 !important;
    }
    .bg-gradient-primary {
        background: linear-gradient(45deg, var(--cesodo-red), var(--cesodo-black));
    }
    .bg-gradient-success {
        background: linear-gradient(45deg, var(--cesodo-black), var(--cesodo-red));
    }
    .bg-gradient-warning {
        background: linear-gradient(45deg, var(--cesodo-red), var(--cesodo-black));
    }
    .bg-gradient-danger {
        background: linear-gradient(45deg, var(--cesodo-black), var(--cesodo-red));
    }

    /* Dashboard Widgets Styles */
    .dashboard-toggle {
        position: fixed;
        top: 80px;
        right: 20px;
        z-index: 1000;
        background: var(--cesodo-red);
        color: white;
        border: none;
        border-radius: 50px;
        padding: 10px 15px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        transition: all 0.3s ease;
    }

    .dashboard-toggle:hover {
        background: #0056b3;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.3);
    }

    .legacy-dashboard {
        display: block;
    }

    .modern-dashboard {
        display: none;
    }

    .dashboard-mode-legacy .legacy-dashboard {
        display: block;
    }

    .dashboard-mode-legacy .modern-dashboard {
        display: none;
    }

    .dashboard-mode-modern .legacy-dashboard {
        display: none;
    }

    .dashboard-mode-modern .modern-dashboard {
        display: block;
    }

    /* Widget Grid Styles */
    .grid-stack {
        background: transparent;
    }

    .grid-stack-item-content {
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .widget-container {
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .widget-header {
        background: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
        padding: 0.75rem 1rem;
        display: flex;
        justify-content: between;
        align-items: center;
        flex-shrink: 0;
    }

    .widget-title {
        font-size: 0.875rem;
        font-weight: 600;
        color: #495057;
    }

    .widget-controls {
        display: flex;
        gap: 0.25rem;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .widget-container:hover .widget-controls {
        opacity: 1;
    }

    .widget-content {
        flex: 1;
        padding: 1rem;
        overflow: auto;
    }

    .dashboard-toolbar {
        background: white;
        border-bottom: 1px solid #e9ecef;
        padding: 1rem 0;
        margin-bottom: 1rem;
    }

    .add-widget-btn {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1000;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: var(--cesodo-red);
        color: white;
        border: none;
        font-size: 1.5rem;
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        transition: all 0.3s ease;
    }

    .add-widget-btn:hover {
        background: var(--cesodo-black);
        transform: scale(1.1);
        box-shadow: 0 6px 20px rgba(26, 26, 26, 0.4);
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<!-- Dashboard Mode Toggle -->
<button class="dashboard-toggle" id="dashboardToggle" title="Cambiar vista del dashboard">
    <i class="fas fa-th-large me-2"></i>
    <span id="toggleText">Vista Moderna</span>
</button>

<div class="container-fluid dashboard-mode-legacy" id="dashboardContainer" style="margin: 0; padding: 0 15px;">
    <?php if(isset($error)): ?>
        <div class="alert alert-danger">
            <h5><i class="fas fa-exclamation-triangle me-2"></i>Error en el Dashboard</h5>
            <p><?php echo e($error); ?></p>
        </div>
    <?php endif; ?>

    <!-- Alertas de Notificaciones al Iniciar Sesión -->
    <?php
        $todasLasNotificaciones = app(App\Http\Controllers\NotificacionController::class)->obtenerNotificaciones();
        $notificacionesUrgentes = array_filter($todasLasNotificaciones, function($notif) {
            return $notif['prioridad'] === 'alta';
        });
        $notificacionesUrgentes = array_slice($notificacionesUrgentes, 0, 5);
    ?>

    <?php if(count($notificacionesUrgentes) > 0): ?>
        <div class="alert alert-danger alert-dismissible fade show mb-4 shadow-sm" role="alert" id="notificacionesAlerta">
            <div class="d-flex align-items-start">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle fa-2x me-3"></i>
                </div>
                <div class="flex-grow-1">
                    <h5 class="alert-heading mb-3">
                        <i class="fas fa-bell me-2"></i>Notificaciones Urgentes (<?php echo e(count($notificacionesUrgentes)); ?>)
                    </h5>
                    <ul class="mb-2 ps-3">
                        <?php $__currentLoopData = $notificacionesUrgentes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="mb-2">
                                <strong><?php echo e($notif['titulo']); ?></strong>: <?php echo e($notif['mensaje']); ?>

                                <a href="<?php echo e($notif['enlace']); ?>" class="alert-link ms-2">Ver detalles <i class="fas fa-arrow-right"></i></a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <hr>
                    <p class="mb-0">
                        <a href="<?php echo e(route('notificaciones.index')); ?>" class="alert-link fw-bold">
                            <i class="fas fa-list me-1"></i>Ver todas las notificaciones
                        </a>
                    </p>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Header de Bienvenida -->
    <div class="welcome-header animate-fade-in">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="h2 mb-2">
                    <i class="fas fa-tachometer-alt me-3"></i>
                    Dashboard - Sistema SCM Cesodo
                </h1>
                <p class="mb-0 opacity-90">
                    Bienvenido de vuelta, <?php echo e(Auth::user()->name); ?>.
                    Panel de control y análisis del sistema.
                </p>
            </div>
            <div class="col-md-4 text-md-end">
                <div class="d-flex flex-column align-items-md-end">
                    <div class="h4 mb-1"><?php echo e(now()->locale('es')->translatedFormat('d/m/Y')); ?></div>
                    <div class="opacity-75"><?php echo e(now()->locale('es')->translatedFormat('l, j \d\e F')); ?></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Estadísticas Principales -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card dashboard-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-cesodo-red text-white me-3">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <div>
                            <div class="text-xs font-weight-bold text-cesodo-red text-uppercase mb-1">
                                Consumos Hoy
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-cesodo-black">
                                <?php echo e($stats['consumos_hoy'] ?? 0); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card dashboard-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-cesodo-black text-white me-3">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <div class="text-xs font-weight-bold text-cesodo-black text-uppercase mb-1">
                                Trabajadores Activos
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-cesodo-black">
                                <?php echo e($stats['trabajadores_activos'] ?? 0); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card dashboard-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-cesodo-red text-white me-3">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div>
                            <div class="text-xs font-weight-bold text-cesodo-red text-uppercase mb-1">
                                Stock Bajo
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-cesodo-black">
                                <?php echo e($stats['productos_stock_bajo'] ?? 0); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card dashboard-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-cesodo-black text-white me-3">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <div class="text-xs font-weight-bold text-cesodo-black text-uppercase mb-1">
                                Pedidos Pendientes
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-cesodo-black">
                                <?php echo e($stats['pedidos_pendientes'] ?? 0); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos y Tablas -->
    <div class="row">
        <!-- Gráfico de Consumos por Tipo -->
        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card dashboard-card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-cesodo-red">
                        <i class="fas fa-chart-pie me-2"></i>Consumos de Hoy por Tipo
                    </h6>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="consumosChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráfico de Consumos de la Semana -->
        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card dashboard-card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-cesodo-red">
                        <i class="fas fa-chart-line me-2"></i>Consumos de la Semana
                    </h6>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="semanaChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Accesos Rápidos a Módulos -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card dashboard-card">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-cesodo-red">
                        <i class="fas fa-rocket me-2"></i>Accesos Rápidos
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ver-trabajadores')): ?>
                        <div class="col-md-2 col-sm-4 col-6 mb-3">
                            <a href="<?php echo e(route('trabajadores.index')); ?>" class="text-decoration-none">
                                <div class="text-center p-3 bg-light rounded hover-shadow">
                                    <i class="fas fa-users fa-2x text-cesodo-red mb-2"></i>
                                    <div class="small text-cesodo-black">Trabajadores</div>
                                </div>
                            </a>
                        </div>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ver-productos')): ?>
                        <div class="col-md-2 col-sm-4 col-6 mb-3">
                            <a href="<?php echo e(route('productos.index')); ?>" class="text-decoration-none">
                                <div class="text-center p-3 bg-light rounded hover-shadow">
                                    <i class="fas fa-box fa-2x text-cesodo-red mb-2"></i>
                                    <div class="small text-cesodo-black">Productos</div>
                                </div>
                            </a>
                        </div>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ver-inventario')): ?>
                        <div class="col-md-2 col-sm-4 col-6 mb-3">
                            <a href="<?php echo e(route('inventarios.index')); ?>" class="text-decoration-none">
                                <div class="text-center p-3 bg-light rounded hover-shadow">
                                    <i class="fas fa-warehouse fa-2x text-cesodo-black mb-2"></i>
                                    <div class="small text-cesodo-black">Inventario</div>
                                </div>
                            </a>
                        </div>
                        <?php endif; ?>

                        <div class="col-md-2 col-sm-4 col-6 mb-3">
                            <a href="<?php echo e(route('consumos.index')); ?>" class="text-decoration-none">
                                <div class="text-center p-3 bg-light rounded hover-shadow">
                                    <i class="fas fa-utensils fa-2x text-cesodo-red mb-2"></i>
                                    <div class="small text-cesodo-black">Consumos</div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-2 col-sm-4 col-6 mb-3">
                            <a href="<?php echo e(route('pedidos.index')); ?>" class="text-decoration-none">
                                <div class="text-center p-3 bg-light rounded hover-shadow">
                                    <i class="fas fa-shopping-cart fa-2x text-danger mb-2"></i>
                                    <div class="small text-dark">Pedidos</div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-2 col-sm-4 col-6 mb-3">
                            <a href="<?php echo e(route('kardex.index')); ?>" class="text-decoration-none">
                                <div class="text-center p-3 bg-light rounded hover-shadow">
                                    <i class="fas fa-clipboard-list fa-2x text-secondary mb-2"></i>
                                    <div class="small text-dark">Kardex</div>
                                </div>
                            </a>
                        </div>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ver-configuraciones')): ?>
                        <div class="col-md-2 col-sm-4 col-6 mb-3">
                            <a href="<?php echo e(route('configurations.index')); ?>" class="text-decoration-none">
                                <div class="text-center p-3 bg-light rounded hover-shadow">
                                    <i class="fas fa-cogs fa-2x text-purple mb-2" style="color: #8b5cf6 !important;"></i>
                                    <div class="small text-dark">Configuraciones</div>
                                </div>
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Últimos Consumos -->
    <div class="row">
        <div class="col-12">
            <div class="card table-card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-cesodo-red">
                        <i class="fas fa-history me-2"></i>Últimos Consumos Registrados
                    </h6>
                    <a href="<?php echo e(route('consumos.index')); ?>" class="btn btn-sm btn-cesodo-red">
                        Ver Todos <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body">
                    <?php if($ultimosConsumos && $ultimosConsumos->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Trabajador</th>
                                        <th>Tipo Comida</th>
                                        <th>Fecha</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $ultimosConsumos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $consumo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <?php if($consumo->trabajador): ?>
                                                <?php echo e($consumo->trabajador->nombre); ?> <?php echo e($consumo->trabajador->apellido); ?>

                                            <?php else: ?>
                                                <span class="text-muted">Trabajador no encontrado</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge
                                                <?php if($consumo->tipo_comida == 'desayuno'): ?> bg-cesodo-red
                                                <?php elseif($consumo->tipo_comida == 'almuerzo'): ?> bg-cesodo-black
                                                <?php elseif($consumo->tipo_comida == 'cena'): ?> bg-cesodo-red
                                                <?php else: ?> bg-cesodo-black
                                                <?php endif; ?> text-white">
                                                <?php echo e(ucfirst($consumo->tipo_comida)); ?>

                                            </span>
                                        </td>
                                        <td><?php echo e($consumo->fecha_consumo); ?></td>
                                        <td>
                                            <span class="badge bg-cesodo-black text-white"><?php echo e(ucfirst($consumo->estado ?? 'completado')); ?></span>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No hay consumos registrados aún.</p>
                            <a href="<?php echo e(route('consumos.create')); ?>" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Registrar Primer Consumo
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- MODERN DASHBOARD WITH WIDGETS -->
    <div class="modern-dashboard">
        <!-- Dashboard Toolbar -->
        <div class="dashboard-toolbar">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-0">
                        <i class="fas fa-tachometer-alt me-2"></i>
                        Dashboard Personalizable
                    </h4>
                    <p class="text-muted mb-0">Arrastra y organiza los widgets según tus necesidades</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary btn-sm" id="addWidgetBtn">
                        <i class="fas fa-plus me-1"></i>
                        Agregar Widget
                    </button>
                    <button class="btn btn-outline-secondary btn-sm" id="saveLayoutBtn">
                        <i class="fas fa-save me-1"></i>
                        Guardar Layout
                    </button>
                    <button class="btn btn-outline-warning btn-sm" id="resetLayoutBtn">
                        <i class="fas fa-refresh me-1"></i>
                        Restablecer
                    </button>
                </div>
            </div>
        </div>

        <!-- Widget Grid -->
        <div class="grid-stack" id="widgetGrid">
            <!-- Los widgets se cargarán dinámicamente -->
        </div>
    </div>
</div>

<!-- Add Widget Modal -->
<div class="modal fade" id="addWidgetModal" tabindex="-1" aria-labelledby="addWidgetModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addWidgetModalLabel">
                    <i class="fas fa-plus me-2"></i>
                    Agregar Nuevo Widget
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row" id="widgetTypesList">
                    <!-- Widget types will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Widget Configuration Modal -->
<div class="modal fade" id="configWidgetModal" tabindex="-1" aria-labelledby="configWidgetModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="configWidgetModalLabel">
                    <i class="fas fa-cog me-2"></i>
                    Configurar Widget
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="widgetConfigForm">
                    <div id="configFormFields">
                        <!-- Configuration fields will be generated dynamically -->
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="saveWidgetConfigBtn">
                    <i class="fas fa-save me-1"></i>
                    Guardar Configuración
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Save Layout Modal -->
<div class="modal fade" id="saveLayoutModal" tabindex="-1" aria-labelledby="saveLayoutModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="saveLayoutModalLabel">
                    <i class="fas fa-save me-2"></i>
                    Guardar Layout
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="saveLayoutForm">
                    <div class="mb-3">
                        <label for="layoutName" class="form-label">Nombre del Layout</label>
                        <input type="text" class="form-control" id="layoutName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="layoutDescription" class="form-label">Descripción (Opcional)</label>
                        <textarea class="form-control" id="layoutDescription" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="layoutIsPublic" name="is_public">
                            <label class="form-check-label" for="layoutIsPublic">
                                Compartir con otros usuarios
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="saveLayoutSubmitBtn">
                    <i class="fas fa-save me-1"></i>
                    Guardar Layout
                </button>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('js/dashboard-widgets.js')); ?>"></script>
<script>
// Dashboard Mode Management
let dashboardMode = localStorage.getItem('dashboard-mode') || 'legacy';
let widgetGrid = null;
let currentConfigWidget = null;

document.addEventListener('DOMContentLoaded', function() {
    initializeDashboard();

    // Dashboard toggle functionality
    document.getElementById('dashboardToggle').addEventListener('click', toggleDashboardMode);

    // Modern dashboard functionality
    document.getElementById('addWidgetBtn')?.addEventListener('click', showAddWidgetModal);
    document.getElementById('saveLayoutBtn')?.addEventListener('click', showSaveLayoutModal);
    document.getElementById('resetLayoutBtn')?.addEventListener('click', resetLayout);
    document.getElementById('saveWidgetConfigBtn')?.addEventListener('click', saveWidgetConfig);
    document.getElementById('saveLayoutSubmitBtn')?.addEventListener('click', saveLayout);

    // Widget management
    document.addEventListener('click', handleWidgetActions);
});

function initializeDashboard() {
    const container = document.getElementById('dashboardContainer');
    const toggleBtn = document.getElementById('dashboardToggle');
    const toggleText = document.getElementById('toggleText');

    if (dashboardMode === 'modern') {
        container.className = 'container-fluid dashboard-mode-modern';
        toggleText.textContent = 'Vista Clásica';
        initializeWidgetGrid();
    } else {
        container.className = 'container-fluid dashboard-mode-legacy';
        toggleText.textContent = 'Vista Moderna';
        initializeLegacyCharts();
    }
}

function toggleDashboardMode() {
    dashboardMode = dashboardMode === 'legacy' ? 'modern' : 'legacy';
    localStorage.setItem('dashboard-mode', dashboardMode);

    const container = document.getElementById('dashboardContainer');
    const toggleText = document.getElementById('toggleText');

    if (dashboardMode === 'modern') {
        container.className = 'container-fluid dashboard-mode-modern';
        toggleText.textContent = 'Vista Clásica';
        setTimeout(() => initializeWidgetGrid(), 100);
    } else {
        container.className = 'container-fluid dashboard-mode-legacy';
        toggleText.textContent = 'Vista Moderna';
        setTimeout(() => initializeLegacyCharts(), 100);
    }
}

function initializeLegacyCharts() {
    try {
        // Gráfico de consumos por tipo
        const consumosData = <?php echo json_encode($consumosHoy ?? []); ?>;
        const ctx1 = document.getElementById('consumosChart');
        if (ctx1 && consumosData.length > 0) {
            new Chart(ctx1.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: consumosData.map(item => item.tipo_comida.charAt(0).toUpperCase() + item.tipo_comida.slice(1)),
                    datasets: [{
                        data: consumosData.map(item => item.total),
                        backgroundColor: ['#dc2626', '#1a1a1a', '#b91c1c', '#2d2d2d'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }

        // Gráfico de consumos de la semana
        const semanaData = <?php echo json_encode($consumosSemana ?? []); ?>;
        const ctx2 = document.getElementById('semanaChart');
        if (ctx2 && semanaData.length > 0) {
            new Chart(ctx2.getContext('2d'), {
                type: 'line',
                data: {
                    labels: semanaData.map(item => item.dia),
                    datasets: [{
                        label: 'Consumos',
                        data: semanaData.map(item => item.total),
                        borderColor: '#dc2626',
                        backgroundColor: 'rgba(220, 38, 38, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    } catch (error) {
        console.error('Error initializing legacy charts:', error);
    }
}

function initializeWidgetGrid() {
    const gridElement = document.getElementById('widgetGrid');
    if (!gridElement) return;

    // Initialize GridStack
    widgetGrid = GridStack.init({
        cellHeight: 60,
        margin: 10,
        animate: true,
        draggable: {
            handle: '.widget-header'
        },
        resizable: {
            handles: 'e,se,s,sw,w'
        }
    }, gridElement);

    // Load user widgets
    loadUserWidgets();

    // Handle position changes
    widgetGrid.on('change', function(event, items) {
        updateWidgetPositions(items);
    });
}

function loadUserWidgets() {
    fetch('<?php echo e(route("dashboard.config")); ?>')
        .then(response => response.json())
        .then(data => {
            if (data.success && data.widgets) {
                data.widgets.forEach(widget => {
                    addWidgetToGrid(widget);
                });
            } else {
                // Load default widgets if no user widgets
                loadDefaultWidgets();
            }
        })
        .catch(error => {
            console.error('Error loading widgets:', error);
            loadDefaultWidgets();
        });
}

function loadDefaultWidgets() {
    const defaultWidgets = [
        { type_id: 1, x: 0, y: 0, w: 3, h: 2 }, // Stats
        { type_id: 2, x: 3, y: 0, w: 3, h: 2 }, // Quick Actions
        { type_id: 3, x: 0, y: 2, w: 6, h: 2 }, // Welcome Banner
        { type_id: 5, x: 0, y: 4, w: 3, h: 4 }, // Recent Consumos
        { type_id: 4, x: 3, y: 4, w: 3, h: 4 }, // Chart
    ];

    defaultWidgets.forEach(widget => {
        addWidget(widget.type_id, widget.x, widget.y, widget.w, widget.h);
    });
}

function addWidgetToGrid(widget) {
    const widgetElement = document.createElement('div');
    widgetElement.className = 'grid-stack-item';
    widgetElement.setAttribute('gs-id', widget.widget_id);
    widgetElement.setAttribute('gs-x', widget.col_position);
    widgetElement.setAttribute('gs-y', widget.row_position);
    widgetElement.setAttribute('gs-w', widget.width);
    widgetElement.setAttribute('gs-h', widget.height);

    const contentElement = document.createElement('div');
    contentElement.className = 'grid-stack-item-content';
    contentElement.innerHTML = '<div class="text-center p-4"><i class="fas fa-spinner fa-spin"></i> Cargando...</div>';

    widgetElement.appendChild(contentElement);
    widgetGrid.addWidget(widgetElement);

    // Load widget content
    loadWidgetContent(widget.widget_id, contentElement);
}

function loadWidgetContent(widgetId, container) {
    fetch(`<?php echo e(url('/dashboard/widgets')); ?>/${widgetId}/data`)
        .then(response => response.json())
        .then(data => {
            if (data.success && data.html) {
                container.innerHTML = data.html;
            } else {
                container.innerHTML = '<div class="alert alert-warning">Error cargando widget</div>';
            }
        })
        .catch(error => {
            console.error('Error loading widget content:', error);
            container.innerHTML = '<div class="alert alert-danger">Error de conexión</div>';
        });
}

function showAddWidgetModal() {
    fetch('<?php echo e(route("dashboard.config")); ?>')
        .then(response => response.json())
        .then(data => {
            if (data.success && data.availableWidgets) {
                renderWidgetTypes(data.availableWidgets);
                new bootstrap.Modal(document.getElementById('addWidgetModal')).show();
            }
        })
        .catch(error => console.error('Error loading widget types:', error));
}

function renderWidgetTypes(widgetTypes) {
    const container = document.getElementById('widgetTypesList');
    container.innerHTML = '';

    widgetTypes.forEach(type => {
        const col = document.createElement('div');
        col.className = 'col-md-6 mb-3';
        col.innerHTML = `
            <div class="card widget-type-card h-100" onclick="addWidget(${type.id})" style="cursor: pointer;">
                <div class="card-body text-center">
                    <i class="${type.icon} fa-2x mb-2 text-cesodo-red"></i>
                    <h6 class="card-title">${type.name}</h6>
                    <p class="card-text small text-muted">${type.description}</p>
                </div>
            </div>
        `;
        container.appendChild(col);
    });
}

function addWidget(typeId, x = null, y = null, w = 3, h = 3) {
    const formData = new FormData();
    formData.append('type_id', typeId);
    if (x !== null) {
        formData.append('col_position', x);
        formData.append('row_position', y);
        formData.append('width', w);
        formData.append('height', h);
    }

    fetch('<?php echo e(route("dashboard.widgets.add")); ?>', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            addWidgetToGrid(data.widget);
            bootstrap.Modal.getInstance(document.getElementById('addWidgetModal'))?.hide();
        } else {
            alert('Error al agregar widget: ' + (data.message || 'Error desconocido'));
        }
    })
    .catch(error => {
        console.error('Error adding widget:', error);
        alert('Error al agregar widget');
    });
}

function updateWidgetPositions(items) {
    const positions = items.map(item => ({
        widget_id: item.id,
        col_position: item.x,
        row_position: item.y,
        width: item.w,
        height: item.h
    }));

    fetch('<?php echo e(route("dashboard.widgets.positions")); ?>', {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ positions })
    })
    .catch(error => console.error('Error updating positions:', error));
}

function handleWidgetActions(event) {
    const target = event.target.closest('button');
    if (!target) return;

    if (target.classList.contains('widget-config')) {
        const widget = target.closest('[data-widget-id]');
        if (widget) {
            configureWidget(widget.getAttribute('data-widget-id'));
        }
    } else if (target.classList.contains('widget-remove')) {
        const widget = target.closest('[data-widget-id]');
        if (widget && confirm('¿Estás seguro de que quieres eliminar este widget?')) {
            removeWidget(widget.getAttribute('data-widget-id'));
        }
    } else if (target.classList.contains('widget-collapse')) {
        const widget = target.closest('[data-widget-id]');
        if (widget) {
            toggleWidgetCollapse(widget.getAttribute('data-widget-id'));
        }
    }
}

function configureWidget(widgetId) {
    currentConfigWidget = widgetId;
    // Load widget configuration form
    fetch(`<?php echo e(url('/dashboard/widgets')); ?>/${widgetId}/data`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                renderWidgetConfigForm(data.config || {});
                new bootstrap.Modal(document.getElementById('configWidgetModal')).show();
            }
        })
        .catch(error => console.error('Error loading widget config:', error));
}

function renderWidgetConfigForm(config) {
    const container = document.getElementById('configFormFields');
    container.innerHTML = '<p class="text-muted">Las opciones de configuración específicas del widget aparecerán aquí.</p>';
}

function removeWidget(widgetId) {
    fetch(`<?php echo e(url('/dashboard/widgets')); ?>/${widgetId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const element = document.querySelector(`[gs-id="${widgetId}"]`);
            if (element) {
                widgetGrid.removeWidget(element);
            }
        }
    })
    .catch(error => console.error('Error removing widget:', error));
}

function saveLayout() {
    const form = document.getElementById('saveLayoutForm');
    const formData = new FormData(form);

    fetch('<?php echo e(route("dashboard.layouts.save")); ?>', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            bootstrap.Modal.getInstance(document.getElementById('saveLayoutModal')).hide();
            alert('Layout guardado exitosamente');
        } else {
            alert('Error al guardar layout: ' + (data.message || 'Error desconocido'));
        }
    })
    .catch(error => console.error('Error saving layout:', error));
}

function resetLayout() {
    if (confirm('¿Estás seguro de que quieres restablecer el layout a la configuración por defecto?')) {
        fetch('<?php echo e(route("dashboard.reset")); ?>', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => console.error('Error resetting layout:', error));
    }
}

function showSaveLayoutModal() {
    new bootstrap.Modal(document.getElementById('saveLayoutModal')).show();
}

function saveWidgetConfig() {
    // Widget configuration save functionality
    if (currentConfigWidget) {
        bootstrap.Modal.getInstance(document.getElementById('configWidgetModal')).hide();
    }
}
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cesodo4\resources\views/dashboard.blade.php ENDPATH**/ ?>