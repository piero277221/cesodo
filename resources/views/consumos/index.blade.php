@extends('layouts.app')

@section('title', 'Consumos')

@s                        <div cla                        <div class="icon-shape" style="background: var(--primary-color);">
                            <i class="fas fa-calendar-day"></i>
                        </div>"icon-shape" style="background: var(--success-color);">
                            <i class="fas fa-utensils"></i>
                        </div>ion('content')
<div class                        <div class="icon-shape" style="background: var(--info-color);">
                            <i class="fas fa-chart-pie"></i>
                        </div>ontainer-fluid fade-in">
    <!-- Header moderno con estadísticas -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-modern">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <div class="icon-shape" style="background: var(--primary-color); color: white;" class="me-3">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <div>
                                    <h1 class="h3 mb-1 text-gradient">Control de Consumos</h1>
                                    <p class="text-muted mb-0">Registra y monitorea el consumo de productos</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#nuevoConsumoModal">
                                <i class="fas fa-plus me-2"></i>
                                Registrar Consumo
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Estadísticas rápidas -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-modern h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape" style="background: var(--info-gradient);">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <div class="ms-3">
                            <div class="text-muted small">Consumos Hoy</div>
                            <div class="h4 mb-0 text-info">12</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-modern h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape" style="background: var(--success-gradient);">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="ms-3">
                            <div class="text-muted small">Completados</div>
                            <div class="h4 mb-0 text-success">156</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-modern h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape" style="background: var(--warning-color);">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="ms-3">
                            <div class="text-muted small">Pendientes</div>
                            <div class="h4 mb-0 text-warning">8</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-modern h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape" style="background: var(--primary-gradient);">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <div class="ms-3">
                            <div class="text-muted small">Total Mes</div>
                            <div class="h4 mb-0">487</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros de búsqueda -->
    <div class="card border-0 shadow-modern mb-4">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-filter me-2"></i>
                Filtros de Búsqueda
            </h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Fecha Desde</label>
                    <input type="date" class="form-control" name="fecha_desde">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Fecha Hasta</label>
                    <input type="date" class="form-control" name="fecha_hasta">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Producto</label>
                    <select class="form-select" name="producto">
                        <option value="">Todos los productos</option>
                        <option value="1">Producto A</option>
                        <option value="2">Producto B</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Estado</label>
                    <select class="form-select" name="estado">
                        <option value="">Todos</option>
                        <option value="completado">Completado</option>
                        <option value="pendiente">Pendiente</option>
                    </select>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-2"></i>
                        Buscar
                    </button>
                    <button type="button" class="btn btn-outline-secondary ms-2">
                        <i class="fas fa-redo me-2"></i>
                        Limpiar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de consumos -->
    <div class="card border-0 shadow-modern">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2"></i>
                        Lista de Consumos
                    </h5>
                </div>
                <div class="col-auto">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-download me-1"></i>
                            Exportar
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-print me-1"></i>
                            Imprimir
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Trabajador</th>
                            <th>Área</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#001</td>
                            <td>15/11/2024</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="icon-shape bg-light text-dark me-2" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                        <i class="fas fa-box"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">Papel A4</div>
                                        <small class="text-muted">PAP-001</small>
                                    </div>
                                </div>
                            </td>
                            <td>50 unidades</td>
                            <td>Juan Pérez</td>
                            <td>
                                <span class="badge bg-info">Administración</span>
                            </td>
                            <td>
                                <span class="badge estado-completado">Completado</span>
                            </td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Acciones">
                                    <button type="button" class="btn btn-outline-primary btn-sm" title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-warning btn-sm" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-danger btn-sm" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>#002</td>
                            <td>15/11/2024</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="icon-shape bg-light text-dark me-2" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                        <i class="fas fa-tools"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">Herramientas</div>
                                        <small class="text-muted">HER-001</small>
                                    </div>
                                </div>
                            </td>
                            <td>3 unidades</td>
                            <td>María García</td>
                            <td>
                                <span class="badge bg-success">Mantenimiento</span>
                            </td>
                            <td>
                                <span class="badge estado-pendiente">Pendiente</span>
                            </td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Acciones">
                                    <button type="button" class="btn btn-outline-primary btn-sm" title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-warning btn-sm" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-danger btn-sm" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Mostrando 1-2 de 2 registros
                </div>
                <nav>
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item disabled">
                            <span class="page-link">Anterior</span>
                        </li>
                        <li class="page-item active">
                            <span class="page-link">1</span>
                        </li>
                        <li class="page-item disabled">
                            <span class="page-link">Siguiente</span>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Modal para nuevo consumo -->
<div class="modal fade" id="nuevoConsumoModal" tabindex="-1" aria-labelledby="nuevoConsumoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: var(--primary-color); color: white;">
                <h5 class="modal-title" id="nuevoConsumoModalLabel">
                    <i class="fas fa-plus me-2"></i>
                    Registrar Nuevo Consumo
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Producto</label>
                            <select class="form-select" required>
                                <option value="">Seleccionar producto...</option>
                                <option value="1">Papel A4</option>
                                <option value="2">Herramientas</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Cantidad</label>
                            <input type="number" class="form-control" min="1" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Trabajador</label>
                            <select class="form-select" required>
                                <option value="">Seleccionar trabajador...</option>
                                <option value="1">Juan Pérez</option>
                                <option value="2">María García</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Área</label>
                            <select class="form-select" required>
                                <option value="">Seleccionar área...</option>
                                <option value="administracion">Administración</option>
                                <option value="mantenimiento">Mantenimiento</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Observaciones</label>
                            <textarea class="form-control" rows="3" placeholder="Observaciones adicionales..."></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>
                    Cancelar
                </button>
                <button type="button" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>
                    Registrar Consumo
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .card {
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-2px);
    }

    .icon-shape {
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-1px);
    }

    .table tbody tr:hover {
        transform: scale(1.002);
    }
</style>
@endpush
