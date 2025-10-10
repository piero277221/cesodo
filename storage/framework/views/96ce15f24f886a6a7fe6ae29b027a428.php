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
                <a href="<?php echo e(route('personas.create')); ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>
                    Nueva Persona
                </a>
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
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Total Personas</h6>
                                    <h3 class="mb-0"><?php echo e(isset($personas) ? (is_object($personas) && method_exists($personas, 'total') ? $personas->total() : count($personas)) : 0); ?></h3>
                                </div>
                                <div>
                                    <i class="fas fa-user-friends fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Con Trabajador</h6>
                                    <h3 class="mb-0"><?php echo e(isset($stats['con_trabajador']) ? $stats['con_trabajador'] : 0); ?></h3>
                                </div>
                                <div>
                                    <i class="fas fa-user-check fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Sin Trabajador</h6>
                                    <h3 class="mb-0"><?php echo e(isset($stats['sin_trabajador']) ? $stats['sin_trabajador'] : 0); ?></h3>
                                </div>
                                <div>
                                    <i class="fas fa-user-minus fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Nuevas Este Mes</h6>
                                    <h3 class="mb-0"><?php echo e(isset($stats['nuevas_mes']) ? $stats['nuevas_mes'] : 0); ?></h3>
                                </div>
                                <div>
                                    <i class="fas fa-user-plus fa-2x opacity-75"></i>
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
                                                        <?php if($persona->nacionalidad): ?>
                                                            <small class="text-muted"><?php echo e($persona->nacionalidad); ?></small>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cesodo4\resources\views/personas/index.blade.php ENDPATH**/ ?>