@extends('layouts.app')

@section('title', 'Gestión de Recetas')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <!-- Header con título y botón -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-0">
                        <i class="fas fa-book text-primary"></i> Gestión de Recetas
                    </h2>
                    <p class="text-muted mb-0">Administre las recetas para la preparación de menús</p>
                </div>
                <a href="{{ route('recetas.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nueva Receta
                </a>
            </div>

            <!-- Filtros y búsqueda -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('recetas.index') }}" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Buscar</label>
                            <input type="text"
                                   name="search"
                                   class="form-control"
                                   placeholder="Nombre o descripción..."
                                   value="{{ request('search') }}">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Tipo de Plato</label>
                            <select name="tipo_plato" class="form-select">
                                <option value="">Todos</option>
                                <option value="entrada" {{ request('tipo_plato') == 'entrada' ? 'selected' : '' }}>Entrada</option>
                                <option value="plato_principal" {{ request('tipo_plato') == 'plato_principal' ? 'selected' : '' }}>Plato Principal</option>
                                <option value="postre" {{ request('tipo_plato') == 'postre' ? 'selected' : '' }}>Postre</option>
                                <option value="bebida" {{ request('tipo_plato') == 'bebida' ? 'selected' : '' }}>Bebida</option>
                                <option value="guarnicion" {{ request('tipo_plato') == 'guarnicion' ? 'selected' : '' }}>Guarnición</option>
                                <option value="sopa" {{ request('tipo_plato') == 'sopa' ? 'selected' : '' }}>Sopa</option>
                                <option value="ensalada" {{ request('tipo_plato') == 'ensalada' ? 'selected' : '' }}>Ensalada</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Dificultad</label>
                            <select name="dificultad" class="form-select">
                                <option value="">Todas</option>
                                <option value="facil" {{ request('dificultad') == 'facil' ? 'selected' : '' }}>Fácil</option>
                                <option value="intermedio" {{ request('dificultad') == 'intermedio' ? 'selected' : '' }}>Intermedio</option>
                                <option value="dificil" {{ request('dificultad') == 'dificil' ? 'selected' : '' }}>Difícil</option>
                                <option value="muy_dificil" {{ request('dificultad') == 'muy_dificil' ? 'selected' : '' }}>Muy Difícil</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Estado</label>
                            <select name="estado" class="form-select">
                                <option value="">Todos</option>
                                <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                                <option value="inactivo" {{ request('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="fas fa-search"></i> Filtrar
                                </button>
                                <a href="{{ route('recetas.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times"></i> Limpiar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Estadísticas rápidas -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="fas fa-book text-primary mb-2" style="font-size: 2rem;"></i>
                            <h5>{{ $recetas->total() }}</h5>
                            <small class="text-muted">Total Recetas</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="fas fa-check-circle text-success mb-2" style="font-size: 2rem;"></i>
                            <h5>{{ \App\Models\Receta::where('estado', 'activo')->count() }}</h5>
                            <small class="text-muted">Activas</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="fas fa-clock text-warning mb-2" style="font-size: 2rem;"></i>
                            <h5>{{ number_format(\App\Models\Receta::avg('tiempo_preparacion') ?? 0, 0) }} min</h5>
                            <small class="text-muted">Tiempo Promedio</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="fas fa-dollar-sign text-info mb-2" style="font-size: 2rem;"></i>
                            <h5>S/ {{ number_format(\App\Models\Receta::avg('costo_aproximado') ?? 0, 2) }}</h5>
                            <small class="text-muted">Costo Promedio</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lista de recetas -->
            @if($recetas->count() > 0)
                <div class="row">
                    @foreach($recetas as $receta)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100 shadow-sm hover-shadow">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0 text-truncate">{{ $receta->nombre }}</h6>
                                    <div class="d-flex gap-1">
                                        <span class="badge bg-secondary">
                                            {{ ucfirst(str_replace('_', ' ', $receta->tipo_plato)) }}
                                        </span>
                                        <span class="badge bg-{{ $receta->estado == 'activo' ? 'success' : 'warning' }}">
                                            {{ ucfirst($receta->estado) }}
                                        </span>
                                    </div>
                                </div>

                                <div class="card-body">
                                    @if($receta->descripcion)
                                        <p class="card-text text-muted small mb-3">
                                            {{ Str::limit($receta->descripcion, 80) }}
                                        </p>
                                    @endif

                                    <!-- Información principal -->
                                    <div class="row text-center mb-3">
                                        <div class="col-4">
                                            <div class="border-end">
                                                <small class="text-muted d-block">Porciones</small>
                                                <strong>{{ $receta->porciones }}</strong>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="border-end">
                                                <small class="text-muted d-block">Tiempo</small>
                                                <strong>{{ $receta->tiempo_preparacion }}min</strong>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <small class="text-muted d-block">Dificultad</small>
                                            <span class="badge bg-{{ $receta->dificultad == 'facil' ? 'success' : ($receta->dificultad == 'intermedio' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($receta->dificultad) }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Costo -->
                                    @if($receta->costo_aproximado)
                                        <div class="text-center mb-3">
                                            <span class="badge bg-success fs-6">
                                                Costo: S/ {{ number_format($receta->costo_aproximado, 2) }}
                                            </span>
                                        </div>
                                    @endif

                                    <!-- Ingredientes -->
                                    @if($receta->ingredientes->count() > 0)
                                        <div class="mb-3">
                                            <small class="text-muted d-block mb-2">Ingredientes ({{ $receta->ingredientes->count() }}):</small>
                                            <div class="d-flex flex-wrap gap-1">
                                                @foreach($receta->ingredientes->take(3) as $ingrediente)
                                                    <span class="badge bg-light text-dark">
                                                        {{ $ingrediente->producto->nombre }}
                                                    </span>
                                                @endforeach
                                                @if($receta->ingredientes->count() > 3)
                                                    <span class="badge bg-light text-dark">
                                                        +{{ $receta->ingredientes->count() - 3 }} más
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Creado por -->
                                    <small class="text-muted">
                                        <i class="fas fa-user"></i> {{ $receta->createdBy->name ?? 'Sistema' }}
                                        <br>
                                        <i class="fas fa-calendar"></i> {{ $receta->created_at->format('d/m/Y') }}
                                    </small>
                                </div>

                                <div class="card-footer">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('recetas.show', $receta) }}"
                                               class="btn btn-outline-primary"
                                               title="Ver receta">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('recetas.edit', $receta) }}"
                                               class="btn btn-outline-warning"
                                               title="Editar receta">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button"
                                                    class="btn btn-outline-info"
                                                    onclick="clonarReceta({{ $receta->id }})"
                                                    title="Clonar receta">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                        </div>

                                        <div class="dropdown">
                                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle"
                                                    type="button"
                                                    data-bs-toggle="dropdown">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <button class="dropdown-item" onclick="calcularCosto({{ $receta->id }})">
                                                        <i class="fas fa-calculator text-success"></i> Calcular Costo
                                                    </button>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item" onclick="verificarDisponibilidad({{ $receta->id }})">
                                                        <i class="fas fa-check-circle text-info"></i> Verificar Ingredientes
                                                    </button>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <button class="dropdown-item text-danger"
                                                            onclick="eliminarReceta({{ $receta->id }}, '{{ $receta->nombre }}')">
                                                        <i class="fas fa-trash"></i> Eliminar
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Paginación -->
                <div class="d-flex justify-content-center">
                    {{ $recetas->links() }}
                </div>
            @else
                <!-- Estado vacío -->
                <div class="text-center py-5">
                    <i class="fas fa-book text-muted" style="font-size: 4rem;"></i>
                    <h4 class="text-muted mt-3">No se encontraron recetas</h4>
                    @if(request()->hasAny(['search', 'tipo_plato', 'dificultad', 'estado']))
                        <p class="text-muted">Intenta ajustar los filtros de búsqueda.</p>
                        <a href="{{ route('recetas.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-times"></i> Limpiar Filtros
                        </a>
                    @else
                        <p class="text-muted">Comienza creando tu primera receta.</p>
                        <a href="{{ route('recetas.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Crear Primera Receta
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal para eliminar receta -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro de que desea eliminar la receta <strong id="recetaNombre"></strong>?</p>
                <p class="text-danger">
                    <i class="fas fa-exclamation-triangle"></i>
                    Esta acción no se puede deshacer.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Efectos hover para las cards
    document.querySelectorAll('.hover-shadow').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.transition = 'all 0.2s ease-in-out';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});

// Funciones para acciones de recetas
async function clonarReceta(recetaId) {
    if (confirm('¿Desea crear una copia de esta receta?')) {
        try {
            const response = await fetch(`/recetas/${recetaId}/clonar`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            });

            const data = await response.json();
            if (data.success) {
                window.location.href = `/recetas/${data.receta_id}/edit`;
            } else {
                alert('Error: ' + data.message);
            }
        } catch (error) {
            alert('Error al clonar la receta');
        }
    }
}

async function calcularCosto(recetaId) {
    try {
        const response = await fetch(`/recetas/${recetaId}/calcular-costo`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        });

        const data = await response.json();
        if (data.success) {
            alert(`Costo calculado: S/ ${data.costo.toFixed(2)}`);
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    } catch (error) {
        alert('Error al calcular el costo');
    }
}

async function verificarDisponibilidad(recetaId) {
    try {
        const response = await fetch(`/recetas/${recetaId}/verificar-disponibilidad`, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        });

        const data = await response.json();
        if (data.success) {
            if (data.disponible) {
                alert('✅ Todos los ingredientes están disponibles en inventario.');
            } else {
                let mensaje = '⚠️ Estado de ingredientes:\n\n';
                data.detalle.forEach(item => {
                    mensaje += `${item.producto}: ${item.requerido} ${item.unidad} ${item.suficiente ? '✅' : '❌'}\n`;
                    if (!item.suficiente) {
                        mensaje += `  Disponible: ${item.disponible}\n`;
                    }
                });
                alert(mensaje);
            }
        } else {
            alert('Error: ' + data.message);
        }
    } catch (error) {
        alert('Error al verificar disponibilidad');
    }
}

function eliminarReceta(recetaId, recetaNombre) {
    document.getElementById('recetaNombre').textContent = recetaNombre;
    document.getElementById('deleteForm').action = `/recetas/${recetaId}`;

    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}
</script>

<style>
.hover-shadow {
    transition: all 0.2s ease-in-out;
}
</style>
@endsection
