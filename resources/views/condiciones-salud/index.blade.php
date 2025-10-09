@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="fas fa-heartbeat text-danger me-2"></i>
            Condiciones de Salud
        </h2>
        <div class="d-flex gap-2">
            <a href="{{ route('menus.index') }}" class="btn btn-outline-success">
                <i class="fas fa-arrow-left me-1"></i>
                Volver a Menús
            </a>
            <a href="{{ route('condiciones-salud.create') }}" class="btn btn-danger">
                <i class="fas fa-plus me-1"></i>
                Nueva Condición
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-1"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Lista de Condiciones -->
    <div class="card">
        <div class="card-body">
            @if($condiciones->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Productos Restringidos</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($condiciones as $condicion)
                                <tr>
                                    <td>
                                        <div class="fw-bold">{{ $condicion->nombre }}</div>
                                    </td>
                                    <td>
                                        {{ Str::limit($condicion->descripcion, 100) ?: 'Sin descripción' }}
                                    </td>
                                    <td>
                                        @if($condicion->productos_restringidos->count() > 0)
                                            <div class="d-flex flex-wrap gap-1">
                                                @foreach($condicion->productos_restringidos->take(3) as $producto)
                                                    <span class="badge bg-warning text-dark">{{ $producto->nombre }}</span>
                                                @endforeach
                                                @if($condicion->productos_restringidos->count() > 3)
                                                    <span class="badge bg-secondary">+{{ $condicion->productos_restringidos->count() - 3 }} más</span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-muted">Sin restricciones</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($condicion->activo)
                                            <span class="badge bg-success">
                                                <i class="fas fa-check me-1"></i>Activo
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                <i class="fas fa-pause me-1"></i>Inactivo
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('condiciones-salud.show', $condicion) }}"
                                               class="btn btn-sm btn-outline-primary" title="Ver">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('condiciones-salud.edit', $condicion) }}"
                                               class="btn btn-sm btn-outline-warning" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" action="{{ route('condiciones-salud.destroy', $condicion) }}"
                                                  style="display: inline;" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        title="Eliminar"
                                                        onclick="return confirm('¿Eliminar esta condición de salud?')">
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
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div>
                        <small class="text-muted">
                            Mostrando {{ $condiciones->firstItem() }} a {{ $condiciones->lastItem() }}
                            de {{ $condiciones->total() }} condiciones
                        </small>
                    </div>
                    <div>
                        {{ $condiciones->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-heartbeat fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">No hay condiciones de salud registradas</h4>
                    <p class="text-muted mb-4">Agregue condiciones para crear menús especializados</p>
                    <a href="{{ route('condiciones-salud.create') }}" class="btn btn-danger">
                        <i class="fas fa-plus me-1"></i>
                        Crear Primera Condición
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
