@extends('layouts.app')

@section('title', 'Proveedores')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">
                    <i class="fas fa-truck text-primary me-2"></i>
                    Proveedores
                </h2>
                <a href="{{ route('proveedores.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>
                    Nuevo Proveedor
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-1"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-1"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Filtros y búsqueda -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('proveedores.index') }}" class="row g-3">
                        <div class="col-md-4">
                            <label for="search" class="form-label">Buscar</label>
                            <input type="text" class="form-control" id="search" name="search"
                                   value="{{ request('search') }}"
                                   placeholder="Nombre, RUC, email...">
                        </div>
                        <div class="col-md-3">
                            <label for="estado" class="form-label">Estado</label>
                            <select class="form-select" id="estado" name="estado">
                                <option value="">Todos</option>
                                <option value="Activo" {{ request('estado') == 'Activo' ? 'selected' : '' }}>Activo</option>
                                <option value="Inactivo" {{ request('estado') == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="tipo" class="form-label">Tipo</label>
                            <select class="form-select" id="tipo" name="tipo">
                                <option value="">Todos</option>
                                <option value="Productos" {{ request('tipo') == 'Productos' ? 'selected' : '' }}>Productos</option>
                                <option value="Servicios" {{ request('tipo') == 'Servicios' ? 'selected' : '' }}>Servicios</option>
                                <option value="Materiales" {{ request('tipo') == 'Materiales' ? 'selected' : '' }}>Materiales</option>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-outline-primary me-2">
                                <i class="fas fa-search"></i> Buscar
                            </button>
                            <a href="{{ route('proveedores.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabla de proveedores -->
            <div class="card">
                <div class="card-body">
                    @if(!empty($proveedores) && count($proveedores) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>
                                            <a href="{{ route('proveedores.index', array_merge(request()->all(), ['sort' => 'id', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}"
                                               class="text-white text-decoration-none">
                                                ID
                                                <i class="fas fa-sort ms-1"></i>
                                            </a>
                                        </th>
                                        <th>
                                            <a href="{{ route('proveedores.index', array_merge(request()->all(), ['sort' => 'nombre', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}"
                                               class="text-white text-decoration-none">
                                                Nombre
                                                <i class="fas fa-sort ms-1"></i>
                                            </a>
                                        </th>
                                        <th>RUC/DNI</th>
                                        <th>Contacto</th>
                                        <th>Tipo</th>
                                        <th>Estado</th>
                                        <th>Fecha Registro</th>
                                        <th width="180">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($proveedores as $proveedor)
                                        <tr>
                                            <td><strong>#{{ $proveedor->id }}</strong></td>
                                            <td>
                                                <div class="fw-bold">{{ $proveedor->nombre ?? $proveedor->razon_social ?? 'N/A' }}</div>
                                                @if($proveedor->descripcion)
                                                    <small class="text-muted">{{ Str::limit($proveedor->descripcion, 50) }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                @if($proveedor->ruc)
                                                    <span class="badge bg-info">{{ $proveedor->ruc }}</span>
                                                @elseif($proveedor->dni)
                                                    <span class="badge bg-secondary">{{ $proveedor->dni }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($proveedor->email)
                                                    <i class="fas fa-envelope text-muted me-1"></i>{{ $proveedor->email }}<br>
                                                @endif
                                                @if($proveedor->telefono)
                                                    <i class="fas fa-phone text-muted me-1"></i>{{ $proveedor->telefono }}
                                                @endif
                                            </td>
                                            <td>
                                                @if($proveedor->tipo)
                                                    <span class="badge bg-primary">{{ $proveedor->tipo }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $estado = $proveedor->estado ?? 'Activo';
                                                    $badgeClass = $estado === 'Activo' ? 'bg-success' : 'bg-danger';
                                                @endphp
                                                <span class="badge {{ $badgeClass }}">{{ $estado }}</span>
                                            </td>
                                            <td>
                                                @if($proveedor->created_at)
                                                    <small>{{ $proveedor->created_at->format('d/m/Y H:i') }}</small>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('proveedores.show', $proveedor) }}"
                                                       class="btn btn-sm btn-outline-info"
                                                       title="Ver detalles">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('proveedores.edit', $proveedor) }}"
                                                       class="btn btn-sm btn-outline-warning"
                                                       title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form method="POST" action="{{ route('proveedores.destroy', $proveedor) }}"
                                                          style="display: inline;"
                                                          onsubmit="return confirm('¿Está seguro de eliminar este proveedor?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="btn btn-sm btn-outline-danger"
                                                                title="Eliminar">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        @if(is_object($proveedores) && method_exists($proveedores, 'links'))
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <div>
                                    <small class="text-muted">
                                        Mostrando {{ $proveedores->firstItem() ?? 0 }} a {{ $proveedores->lastItem() ?? 0 }}
                                        de {{ $proveedores->total() ?? 0 }} resultados
                                    </small>
                                </div>
                                <div>
                                    {{ $proveedores->appends(request()->query())->links() }}
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-truck fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">No hay proveedores registrados</h4>
                            <p class="text-muted mb-4">Comience agregando el primer proveedor al sistema</p>
                            <a href="{{ route('proveedores.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i>
                                Crear Primer Proveedor
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
