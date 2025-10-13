<?php $__env->startSection('title', 'Gestión de Personas'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">
                    <i class="fas fa-user-friends text-primary me-2"></i>
                    Gestión de Personas
                </h2>
                <div class="d-flex gap-2">
                    <button type="button" class="btn" style="background-color: #dc2626; color: white;" data-bs-toggle="modal" data-bs-target="#modalReporte">
                        <i class="fas fa-file-pdf me-1"></i>
                        Generar Reporte
                    </button>
                    <a href="<?php echo e(route('personas.create')); ?>" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>
                        Nueva Persona
                    </a>
                </div>
            </div>

            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-1"></i>
                    <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-1"></i>
                    <?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Filtros y búsqueda -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="<?php echo e(route('personas.index')); ?>" class="row g-3">
                        <div class="col-md-6">
                            <label for="search" class="form-label">Buscar</label>
                            <input type="text" class="form-control" id="search" name="search"
                                   value="<?php echo e(request('search')); ?>"
                                   placeholder="Nombre, apellidos, documento...">
                        </div>
                        <div class="col-md-3">
                            <label for="tipo_documento" class="form-label">Tipo Documento</label>
                            <select class="form-select" id="tipo_documento" name="tipo_documento">
                                <option value="">Todos</option>
                                <option value="dni" <?php echo e(request('tipo_documento') == 'dni' ? 'selected' : ''); ?>>DNI</option>
                                <option value="ce" <?php echo e(request('tipo_documento') == 'ce' ? 'selected' : ''); ?>>CE</option>
                                <option value="pasaporte" <?php echo e(request('tipo_documento') == 'pasaporte' ? 'selected' : ''); ?>>Pasaporte</option>
                                <option value="ruc" <?php echo e(request('tipo_documento') == 'ruc' ? 'selected' : ''); ?>>RUC</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-outline-primary me-2">
                                <i class="fas fa-search"></i> Buscar
                            </button>
                            <a href="<?php echo e(route('personas.index')); ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Estadísticas rápidas -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card border-cesodo-red">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title text-muted mb-2">Total Personas</h6>
                                    <h3 class="mb-0 fw-bold text-cesodo-black"><?php echo e(isset($personas) ? (is_object($personas) && method_exists($personas, 'total') ? $personas->total() : count($personas)) : 0); ?></h3>
                                </div>
                                <div>
                                    <i class="fas fa-user-friends fa-2x text-cesodo-red opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card border-cesodo-red">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title text-muted mb-2">Con Trabajador</h6>
                                    <h3 class="mb-0 fw-bold text-cesodo-black"><?php echo e(isset($stats['con_trabajador']) ? $stats['con_trabajador'] : 0); ?></h3>
                                </div>
                                <div>
                                    <i class="fas fa-user-check fa-2x text-cesodo-red opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card border-cesodo-red">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title text-muted mb-2">Sin Trabajador</h6>
                                    <h3 class="mb-0 fw-bold text-cesodo-black"><?php echo e(isset($stats['sin_trabajador']) ? $stats['sin_trabajador'] : 0); ?></h3>
                                </div>
                                <div>
                                    <i class="fas fa-user-minus fa-2x text-cesodo-red opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card border-cesodo-red">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title text-muted mb-2">Nuevas Este Mes</h6>
                                    <h3 class="mb-0 fw-bold text-cesodo-black"><?php echo e(isset($stats['nuevas_mes']) ? $stats['nuevas_mes'] : 0); ?></h3>
                                </div>
                                <div>
                                    <i class="fas fa-user-plus fa-2x text-cesodo-red opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de personas -->
            <div class="card">
                <div class="card-body">
                    <?php if(!empty($personas) && count($personas) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>
                                            <a href="<?php echo e(route('personas.index', array_merge(request()->all(), ['sort' => 'id', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']))); ?>"
                                               class="text-white text-decoration-none">
                                                ID
                                                <i class="fas fa-sort ms-1"></i>
                                            </a>
                                        </th>
                                        <th>
                                            <a href="<?php echo e(route('personas.index', array_merge(request()->all(), ['sort' => 'apellidos', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']))); ?>"
                                               class="text-white text-decoration-none">
                                                Persona
                                                <i class="fas fa-sort ms-1"></i>
                                            </a>
                                        </th>
                                        <th>Documento</th>
                                        <th>Contacto</th>
                                        <th>Información</th>
                                        <th>Trabajador</th>
                                        <th width="180">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $personas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $persona): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><strong>#<?php echo e($persona->id); ?></strong></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="me-3">
                                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                                             style="width: 40px; height: 40px;">
                                                            <i class="fas fa-user"></i>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold"><?php echo e($persona->nombres ?? 'N/A'); ?> <?php echo e($persona->apellidos ?? ''); ?></div>
                                                        <?php if($persona->pais): ?>
                                                            <small class="text-muted"><?php echo e($persona->pais); ?></small>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <?php if($persona->numero_documento): ?>
                                                    <div>
                                                        <span class="badge bg-info"><?php echo e(strtoupper($persona->tipo_documento ?? 'DOC')); ?></span>
                                                        <div><small><?php echo e($persona->numero_documento); ?></small></div>
                                                    </div>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($persona->correo): ?>
                                                    <div><i class="fas fa-envelope text-muted me-1"></i><?php echo e($persona->correo); ?></div>
                                                <?php endif; ?>
                                                <?php if($persona->celular): ?>
                                                    <div><i class="fas fa-phone text-muted me-1"></i><?php echo e($persona->celular); ?></div>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($persona->fecha_nacimiento): ?>
                                                    <div><small class="text-muted">
                                                        <i class="fas fa-birthday-cake me-1"></i>
                                                        <?php echo e(\Carbon\Carbon::parse($persona->fecha_nacimiento)->format('d/m/Y')); ?>

                                                        (<?php echo e(\Carbon\Carbon::parse($persona->fecha_nacimiento)->age); ?> años)
                                                    </small></div>
                                                <?php endif; ?>
                                                <?php if($persona->sexo): ?>
                                                    <span class="badge bg-secondary">
                                                        <?php echo e($persona->sexo == 'M' ? 'Masculino' : ($persona->sexo == 'F' ? 'Femenino' : 'Otro')); ?>

                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($persona->trabajador): ?>
                                                    <div>
                                                        <span class="badge bg-success">
                                                            <i class="fas fa-check me-1"></i>
                                                            Trabajador
                                                        </span>
                                                        <div><small class="text-muted"><?php echo e($persona->trabajador->area ?? 'Sin área'); ?></small></div>
                                                    </div>
                                                <?php else: ?>
                                                    <span class="badge bg-warning text-dark">
                                                        <i class="fas fa-minus me-1"></i>
                                                        Sin asignar
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?php echo e(route('personas.show', $persona)); ?>"
                                                       class="btn btn-sm btn-outline-info"
                                                       title="Ver detalles">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="<?php echo e(route('personas.edit', $persona)); ?>"
                                                       class="btn btn-sm btn-outline-warning"
                                                       title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <?php if(!$persona->trabajador): ?>
                                                        <a href="<?php echo e(route('trabajadores.create', ['persona_id' => $persona->id])); ?>"
                                                           class="btn btn-sm btn-outline-success"
                                                           title="Crear trabajador">
                                                            <i class="fas fa-user-plus"></i>
                                                        </a>
                                                    <?php else: ?>
                                                        <a href="<?php echo e(route('trabajadores.show', $persona->trabajador)); ?>"
                                                           class="btn btn-sm btn-outline-primary"
                                                           title="Ver trabajador">
                                                            <i class="fas fa-user-tie"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                    <form method="POST" action="<?php echo e(route('personas.destroy', $persona)); ?>"
                                                          style="display: inline;"
                                                          onsubmit="return confirm('¿Está seguro de eliminar esta persona?')">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button type="submit"
                                                                class="btn btn-sm btn-outline-danger"
                                                                title="Eliminar">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        <?php if(is_object($personas) && method_exists($personas, 'links')): ?>
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <div>
                                    <small class="text-muted">
                                        Mostrando <?php echo e($personas->firstItem() ?? 0); ?> a <?php echo e($personas->lastItem() ?? 0); ?>

                                        de <?php echo e($personas->total() ?? 0); ?> resultados
                                    </small>
                                </div>
                                <div>
                                    <?php echo e($personas->appends(request()->query())->links()); ?>

                                </div>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-user-friends fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">No hay personas registradas</h4>
                            <p class="text-muted mb-4">Comience agregando la primera persona al sistema</p>
                            <a href="<?php echo e(route('personas.create')); ?>" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i>
                                Crear Primera Persona
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Reporte -->
<div class="modal fade" id="modalReporte" tabindex="-1" aria-labelledby="modalReporteLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);">
                <h5 class="modal-title text-white fw-bold" id="modalReporteLabel">
                    <i class="fas fa-file-pdf me-2"></i>
                    Generar Reporte de Personas
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formReporte" method="POST" action="<?php echo e(route('personas.reporte.pdf')); ?>" target="_blank">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Instrucciones:</strong> Seleccione los filtros deseados para generar el reporte. El archivo PDF se descargará automáticamente.
                    </div>

                    <div class="row g-3">
                        <!-- Filtro por búsqueda -->
                        <div class="col-md-12">
                            <label for="reporte_search" class="form-label fw-semibold">
                                <i class="fas fa-search me-1" style="color: #dc2626;"></i>
                                Buscar por Nombre o Documento
                            </label>
                            <input type="text" class="form-control" id="reporte_search" name="search"
                                   placeholder="Ingrese nombre, apellidos o número de documento...">
                        </div>

                        <!-- Filtro por tipo de documento -->
                        <div class="col-md-6">
                            <label for="reporte_tipo_documento" class="form-label fw-semibold">
                                <i class="fas fa-id-card me-1" style="color: #dc2626;"></i>
                                Tipo de Documento
                            </label>
                            <select class="form-select" id="reporte_tipo_documento" name="tipo_documento">
                                <option value="">Todos los tipos</option>
                                <option value="dni">DNI</option>
                                <option value="ce">Carnet de Extranjería (CE)</option>
                                <option value="pasaporte">Pasaporte</option>
                                <option value="ruc">RUC</option>
                            </select>
                        </div>

                        <!-- Filtro por género -->
                        <div class="col-md-6">
                            <label for="reporte_genero" class="form-label fw-semibold">
                                <i class="fas fa-venus-mars me-1" style="color: #dc2626;"></i>
                                Género
                            </label>
                            <select class="form-select" id="reporte_genero" name="genero">
                                <option value="">Todos los géneros</option>
                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                                <option value="O">Otro</option>
                            </select>
                        </div>

                        <!-- Filtro por estado civil -->
                        <div class="col-md-6">
                            <label for="reporte_estado_civil" class="form-label fw-semibold">
                                <i class="fas fa-ring me-1" style="color: #dc2626;"></i>
                                Estado Civil
                            </label>
                            <select class="form-select" id="reporte_estado_civil" name="estado_civil">
                                <option value="">Todos los estados</option>
                                <option value="soltero">Soltero(a)</option>
                                <option value="casado">Casado(a)</option>
                                <option value="divorciado">Divorciado(a)</option>
                                <option value="viudo">Viudo(a)</option>
                                <option value="conviviente">Conviviente</option>
                            </select>
                        </div>

                        <!-- Filtro por relación laboral -->
                        <div class="col-md-6">
                            <label for="reporte_con_trabajador" class="form-label fw-semibold">
                                <i class="fas fa-briefcase me-1" style="color: #dc2626;"></i>
                                Relación Laboral
                            </label>
                            <select class="form-select" id="reporte_con_trabajador" name="con_trabajador">
                                <option value="">Todos</option>
                                <option value="si">Solo con relación laboral</option>
                                <option value="no">Sin relación laboral</option>
                            </select>
                        </div>

                        <!-- Filtro por rango de fechas -->
                        <div class="col-md-6">
                            <label for="reporte_fecha_inicio" class="form-label fw-semibold">
                                <i class="fas fa-calendar-alt me-1" style="color: #dc2626;"></i>
                                Fecha Registro Desde
                            </label>
                            <input type="date" class="form-control" id="reporte_fecha_inicio" name="fecha_inicio">
                        </div>

                        <div class="col-md-6">
                            <label for="reporte_fecha_fin" class="form-label fw-semibold">
                                <i class="fas fa-calendar-check me-1" style="color: #dc2626;"></i>
                                Fecha Registro Hasta
                            </label>
                            <input type="date" class="form-control" id="reporte_fecha_fin" name="fecha_fin">
                        </div>

                        <!-- Opciones de ordenamiento -->
                        <div class="col-md-6">
                            <label for="reporte_orden" class="form-label fw-semibold">
                                <i class="fas fa-sort me-1" style="color: #dc2626;"></i>
                                Ordenar Por
                            </label>
                            <select class="form-select" id="reporte_orden" name="orden">
                                <option value="apellidos">Apellidos (A-Z)</option>
                                <option value="nombres">Nombres (A-Z)</option>
                                <option value="created_at_desc">Fecha de Registro (Más Recientes)</option>
                                <option value="created_at_asc">Fecha de Registro (Más Antiguos)</option>
                                <option value="numero_documento">Número de Documento</option>
                            </select>
                        </div>

                        <!-- Opciones de visualización -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-eye me-1" style="color: #dc2626;"></i>
                                Incluir en el Reporte
                            </label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="incluir_foto" id="incluir_foto" checked>
                                <label class="form-check-label" for="incluir_foto">
                                    Fotografía
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="incluir_contacto" id="incluir_contacto" checked>
                                <label class="form-check-label" for="incluir_contacto">
                                    Información de Contacto
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="incluir_direccion" id="incluir_direccion" checked>
                                <label class="form-check-label" for="incluir_direccion">
                                    Dirección
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>
                        Cancelar
                    </button>
                    <button type="submit" class="btn" style="background-color: #dc2626; color: white;">
                        <i class="fas fa-download me-1"></i>
                        Descargar PDF
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cesodo4\resources\views/personas/index.blade.php ENDPATH**/ ?>