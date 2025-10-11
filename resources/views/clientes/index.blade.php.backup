@extends('layouts.app')

@section('title', 'Gestión de Clientes')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50">
    <!-- Header mejorado -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="container-fluid py-6">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="icon-shape bg-gradient-primary shadow text-center border-radius-md me-3">
                                <i class="bi bi-people text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                            <div>
                                <h1 class="h3 mb-0 text-dark font-weight-bold">Gestión de Clientes</h1>
                                <p class="mb-0 text-sm text-muted">Administra toda la información de tus clientes</p>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button onclick="exportClientes()" class="btn btn-outline-secondary">
                                <i class="bi bi-download me-2"></i>Exportar
                            </button>
                            <a href="{{ route('clientes.create') }}" class="btn btn-primary btn-modern">
                                <i class="bi bi-plus-circle me-2"></i>Nuevo Cliente
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid py-4">
        <!-- Estadísticas rápidas -->
        <div class="row mb-4">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card stats-card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Clientes</p>
                                    <h5 class="font-weight-bolder">{{ $clientes->total() ?? 0 }}</h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                    <i class="bi bi-people text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card stats-card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Activos</p>
                                    <h5 class="font-weight-bolder text-success">{{ $clientes->where('estado', 'activo')->count() ?? 0 }}</h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                    <i class="bi bi-check-circle text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card stats-card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Nuevos (Este mes)</p>
                                    <h5 class="font-weight-bolder text-info">{{ $clientes->where('created_at', '>=', now()->startOfMonth())->count() ?? 0 }}</h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-info shadow-info text-center rounded-circle">
                                    <i class="bi bi-person-plus text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card stats-card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Ventas del mes</p>
                                    <h5 class="font-weight-bolder text-warning">${{ number_format(0, 0, ',', '.') }}</h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                    <i class="bi bi-currency-dollar text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tarjeta principal -->
        <div class="card card-modern">
            <!-- Filtros de búsqueda mejorados -->
            <div class="card-header border-0 pb-0">
                <div class="row">
                    <div class="col-12">
                        <form method="GET" action="{{ route('clientes.index') }}" class="filter-form">
                            <div class="row g-3 align-items-end">
                                <div class="col-md-4">
                                    <label class="form-label text-sm font-weight-bold">Buscar Cliente</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                                        <input type="text" name="search" class="form-control"
                                               placeholder="Nombre, email, teléfono o RUT..."
                                               value="{{ request('search') }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label text-sm font-weight-bold">Tipo</label>
                                    <select name="tipo" class="form-select">
                                        <option value="">Todos los tipos</option>
                                        <option value="natural" {{ request('tipo') == 'natural' ? 'selected' : '' }}>Persona Natural</option>
                                        <option value="juridica" {{ request('tipo') == 'juridica' ? 'selected' : '' }}>Persona Jurídica</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label text-sm font-weight-bold">Estado</label>
                                    <select name="estado" class="form-select">
                                        <option value="">Todos los estados</option>
                                        <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                                        <option value="inactivo" {{ request('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                                        <option value="suspendido" {{ request('estado') == 'suspendido' ? 'selected' : '' }}>Suspendido</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label text-sm font-weight-bold">Ordenar por</label>
                                    <select name="sort" class="form-select">
                                        <option value="nombre" {{ request('sort') == 'nombre' ? 'selected' : '' }}>Nombre</option>
                                        <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Fecha registro</option>
                                        <option value="estado" {{ request('sort') == 'estado' ? 'selected' : '' }}>Estado</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <div class="d-flex gap-2 align-items-end h-100">
                                        <button type="submit" class="btn btn-primary btn-modern">
                                            <i class="bi bi-search me-1"></i> Buscar
                                        </button>
                                        <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary">
                                            <i class="bi bi-arrow-clockwise"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Tabla de clientes mejorada -->
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table table-modern align-items-center mb-0">
                        <thead>
                            <tr>
                                <th>Cliente</th>
                                <th>Contacto</th>
                                <th>Tipo</th>
                                <th>Ventas</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($clientes as $cliente)
                            <tr>
                                <td>
                                    <div class="d-flex px-2 py-1 align-items-center">
                                        <div class="avatar-modern me-3">
                                            {{ strtoupper(substr($cliente->nombre, 0, 2)) }}
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm font-weight-bold">{{ $cliente->nombre }}</h6>
                                            @if($cliente->rut)
                                                <p class="text-xs text-secondary mb-0">
                                                    <i class="bi bi-person-vcard me-1"></i>{{ $cliente->rut }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column justify-content-center">
                                        @if($cliente->email)
                                            <p class="text-sm mb-0">
                                                <i class="bi bi-envelope me-1 text-primary"></i>{{ $cliente->email }}
                                            </p>
                                        @endif
                                        @if($cliente->telefono)
                                            <p class="text-xs text-secondary mb-0">
                                                <i class="bi bi-telephone me-1"></i>{{ $cliente->telefono }}
                                            </p>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-modern {{ $cliente->tipo == 'natural' ? 'bg-info' : 'bg-warning' }}">
                                        <i class="bi bi-{{ $cliente->tipo == 'natural' ? 'person' : 'building' }} me-1"></i>
                                        {{ $cliente->tipo == 'natural' ? 'Natural' : 'Jurídica' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="text-sm font-weight-bold">${{ number_format(0, 0, ',', '.') }}</span>
                                        <span class="text-xs text-secondary">0 ventas</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-modern badge-{{ $cliente->estado }}">
                                        <i class="bi bi-{{ $cliente->estado == 'activo' ? 'check-circle' : ($cliente->estado == 'inactivo' ? 'x-circle' : 'pause-circle') }} me-1"></i>
                                        {{ ucfirst($cliente->estado) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn actions-dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-toggle="tooltip" title="Acciones">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-modern">

                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-2"></i>Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">
                                                {{ $cliente->ventas->first()->total_ventas ?? 0 }} ventas
                                            </h6>
                                            <p class="text-xs text-secondary mb-0">
                                                Total: ${{ number_format($cliente->ventas->first()->total_comprado ?? 0, 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-sm bg-gradient-{{ $cliente->estado == 'activo' ? 'success' : ($cliente->estado == 'suspendido' ? 'danger' : 'secondary') }}">
                                            {{ ucfirst($cliente->estado) }}
                                        </span>
                                    </td>
                                    <td class="align-middle">
                                        <div class="dropdown">
                                            <button class="btn btn-link text-secondary mb-0" type="button" id="dropdownMenuButton{{ $cliente->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-ellipsis-v text-xs"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $cliente->id }}">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('clientes.show', $cliente) }}">
                                                        <i class="fas fa-eye me-2"></i>Ver Detalles
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('clientes.edit', $cliente) }}">
                                                        <i class="fas fa-edit me-2"></i>Editar
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('clientes.estado-cuenta', $cliente) }}">
                                                        <i class="fas fa-file-invoice-dollar me-2"></i>Estado de Cuenta
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form action="{{ route('clientes.destroy', $cliente) }}" method="POST"
                                                          onsubmit="return confirm('¿Estás seguro de eliminar este cliente?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="fas fa-trash me-2"></i>Eliminar
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="fas fa-users fa-3x text-secondary mb-3"></i>
                                            <h5 class="text-secondary">No hay clientes registrados</h5>
                                            <p class="text-sm text-secondary">Comienza agregando tu primer cliente</p>
                                            <a href="{{ route('clientes.create') }}" class="btn bg-gradient-primary">
                                                <i class="fas fa-plus me-2"></i>Agregar Cliente
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    @if($clientes->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $clientes->appends(request()->query())->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
/* Estilos modernos para clientes */
.bg-gradient-to-br {
    background: linear-gradient(135deg, #f8fafc 0%, #ffffff 50%, #f1f5f9 100%);
}

.stats-card {
    transition: all 0.3s ease;
    border: none;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.stats-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

.card-modern {
    border: none;
    border-radius: 1rem;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    backdrop-filter: blur(10px);
    background: rgba(255, 255, 255, 0.95);
}

.btn-modern {
    border-radius: 0.75rem;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    text-transform: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.btn-modern:hover {
    transform: translateY(-1px);
    box-shadow: 0 8px 15px -3px rgba(0, 0, 0, 0.2);
}

.filter-form {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 1rem;
    margin-bottom: 1.5rem;
}

.form-control, .form-select {
    border-radius: 0.5rem;
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.input-group-text {
    border-radius: 0.5rem 0 0 0.5rem;
    background: #f8f9fa;
    border-color: #e9ecef;
}

.table-modern {
    border-radius: 0.75rem;
    overflow: hidden;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
}

.table-modern thead th {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.05em;
    border: none;
    padding: 1rem 0.75rem;
}

.table-modern tbody tr {
    transition: all 0.3s ease;
}

.table-modern tbody tr:hover {
    background-color: #f8f9fa;
    transform: scale(1.01);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.table-modern tbody td {
    padding: 1rem 0.75rem;
    vertical-align: middle;
    border-color: #e9ecef;
}

.badge-modern {
    padding: 0.5rem 0.75rem;
    border-radius: 0.5rem;
    font-weight: 600;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.025em;
}

.actions-dropdown {
    border: none;
    background: transparent;
    color: #6c757d;
    font-size: 1.25rem;
    transition: all 0.3s ease;
}

.actions-dropdown:hover {
    color: #495057;
    background: #f8f9fa;
    border-radius: 0.375rem;
}

.dropdown-menu-modern {
    border: none;
    border-radius: 0.75rem;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    padding: 0.5rem;
}

.dropdown-menu-modern .dropdown-item {
    border-radius: 0.5rem;
    padding: 0.5rem 0.75rem;
    transition: all 0.3s ease;
    font-weight: 500;
}

.dropdown-menu-modern .dropdown-item:hover {
    background: #f8f9fa;
    color: #495057;
    transform: translateX(2px);
}

.icon-shape {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.avatar-modern {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 0.875rem;
}

/* Animaciones */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.table-modern tbody tr {
    animation: fadeInUp 0.3s ease forwards;
}

.table-modern tbody tr:nth-child(even) {
    animation-delay: 0.1s;
}

.table-modern tbody tr:nth-child(odd) {
    animation-delay: 0.05s;
}

/* Estados de badge */
.badge-activo {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
}

.badge-inactivo {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
}

.badge-suspendido {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
}

/* Responsive improvements */
@media (max-width: 768px) {
    .table-responsive {
        border-radius: 0.75rem;
    }

    .filter-form {
        padding: 1rem;
    }

    .stats-card {
        margin-bottom: 1rem;
    }
}
</style>
@endpush

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit en cambio de filtros
    const filtros = document.querySelectorAll('select[name="tipo"], select[name="estado"]');
    filtros.forEach(filtro => {
        filtro.addEventListener('change', function() {
            this.form.submit();
        });
    });

    // Función para exportar clientes
    window.exportClientes = function() {
        const searchParams = new URLSearchParams(window.location.search);
        searchParams.set('export', 'excel');
        window.location.href = `{{ route('clientes.index') }}?${searchParams.toString()}`;
    };

    // Función para confirmar eliminación
    window.confirmarEliminacion = function(clienteId, clienteNombre) {
        document.getElementById('clienteNombre').textContent = clienteNombre;
        document.getElementById('deleteForm').action = `/clientes/${clienteId}`;
        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    };

    // Tooltip para acciones
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endpush
