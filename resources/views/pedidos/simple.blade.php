<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Pedidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .header-orange { background-color: #fd7900; color: white; }
        .bg-dark-custom { background-color: #2d3436; }
        .btn-orange { background-color: #fd7900; color: white; border: none; }
        .btn-orange:hover { background-color: #e66c00; color: white; }
        .btn-dark-custom { background-color: #2d3436; color: white; border: 1px solid white; }
        .btn-dark-custom:hover { background-color: #1e2426; color: white; }
    </style>
</head>
<body class="bg-light">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header header-orange d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-shopping-cart me-2"></i>Gestión de Pedidos
                        </h5>
                        <a href="{{ route('pedidos.create') }}" class="btn btn-dark-custom">
                            <i class="fas fa-plus me-1"></i>Nuevo Pedido
                        </a>
                    </div>
                    <div class="card-body bg-white">

                        <!-- Mensajes -->
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Filtros -->
                        <form method="GET" action="{{ route('pedidos.index') }}" class="mb-4">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="search"
                                           placeholder="Buscar por número o proveedor..."
                                           value="{{ request('search') }}">
                                </div>
                                <div class="col-md-2">
                                    <select class="form-select" name="estado">
                                        <option value="">Todos los estados</option>
                                        <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                        <option value="confirmado" {{ request('estado') == 'confirmado' ? 'selected' : '' }}>Confirmado</option>
                                        <option value="entregado" {{ request('estado') == 'entregado' ? 'selected' : '' }}>Entregado</option>
                                        <option value="cancelado" {{ request('estado') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-select" name="proveedor_id">
                                        <option value="">Todos los proveedores</option>
                                        @if(isset($proveedores))
                                            @foreach($proveedores as $proveedor)
                                                <option value="{{ $proveedor->id }}" {{ request('proveedor_id') == $proveedor->id ? 'selected' : '' }}>
                                                    {{ $proveedor->nombre }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input type="date" class="form-control" name="fecha_desde"
                                           value="{{ request('fecha_desde') }}">
                                </div>
                                <div class="col-md-2">
                                    <input type="date" class="form-control" name="fecha_hasta"
                                           value="{{ request('fecha_hasta') }}">
                                </div>
                                <div class="col-md-1">
                                    <button type="submit" class="btn btn-orange w-100">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>

                        <!-- Tabla de pedidos -->
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="bg-dark-custom text-white">
                                    <tr>
                                        <th>N° Pedido</th>
                                        <th>Proveedor</th>
                                        <th>Fecha Pedido</th>
                                        <th>Fecha Entrega</th>
                                        <th>Estado</th>
                                        <th>Total</th>
                                        <th>Usuario</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($pedidos) && count($pedidos) > 0)
                                        @foreach($pedidos as $pedido)
                                            <tr>
                                                <td><strong>{{ $pedido->numero_pedido ?? 'N/A' }}</strong></td>
                                                <td>{{ optional($pedido->proveedor)->nombre ?? 'N/A' }}</td>
                                                <td>{{ $pedido->fecha_pedido ? $pedido->fecha_pedido->format('d/m/Y') : 'N/A' }}</td>
                                                <td>{{ $pedido->fecha_entrega_esperada ? $pedido->fecha_entrega_esperada->format('d/m/Y') : 'N/A' }}</td>
                                                <td>
                                                    @switch($pedido->estado ?? 'pendiente')
                                                        @case('pendiente')
                                                            <span class="badge bg-warning">Pendiente</span>
                                                            @break
                                                        @case('confirmado')
                                                            <span class="badge bg-info">Confirmado</span>
                                                            @break
                                                        @case('entregado')
                                                            <span class="badge bg-success">Entregado</span>
                                                            @break
                                                        @case('cancelado')
                                                            <span class="badge bg-danger">Cancelado</span>
                                                            @break
                                                        @default
                                                            <span class="badge bg-secondary">Sin estado</span>
                                                    @endswitch
                                                </td>
                                                <td><strong>S/ {{ number_format($pedido->total ?? 0, 2) }}</strong></td>
                                                <td>{{ optional($pedido->user)->name ?? 'N/A' }}</td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('pedidos.show', $pedido->id) }}"
                                                           class="btn btn-sm btn-dark-custom" title="Ver">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('pedidos.edit', $pedido->id) }}"
                                                           class="btn btn-sm btn-orange" title="Editar">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        @if(($pedido->estado ?? 'pendiente') !== 'entregado')
                                                            <form action="{{ route('pedidos.destroy', $pedido->id) }}"
                                                                  method="POST" class="d-inline"
                                                                  onsubmit="return confirm('¿Está seguro de eliminar este pedido?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="8" class="text-center py-4">
                                                <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                                                <p class="text-muted">No hay pedidos registrados</p>
                                                <a href="{{ route('pedidos.create') }}" class="btn btn-orange">
                                                    <i class="fas fa-plus me-1"></i>Crear primer pedido
                                                </a>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        @if(isset($pedidos) && method_exists($pedidos, 'hasPages') && $pedidos->hasPages())
                            <div class="d-flex justify-content-center mt-3">
                                {{ $pedidos->appends(request()->query())->links() }}
                            </div>
                        @endif

                        <!-- Info de debug -->
                        <div class="mt-4 p-3" style="background-color: #f8f9fa; border-radius: 5px;">
                            <small class="text-muted">
                                <strong>Debug Info:</strong>
                                Pedidos cargados: {{ isset($pedidos) ? (is_countable($pedidos) ? count($pedidos) : 'No contable') : 'No definido' }} |
                                Proveedores: {{ isset($proveedores) ? count($proveedores) : 'No definido' }} |
                                Fecha: {{ date('Y-m-d H:i:s') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
