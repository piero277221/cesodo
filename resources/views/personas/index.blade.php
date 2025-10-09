@extends('layouts.app')

@section('title', 'Gestión de Personas')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">
                    <i class="fas fa-user-friends text-primary me-2"></i>
                    Gestión de Personas
                </h2>
                <a href="{{ route('personas.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>
                    Nueva Persona
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
                    <form method="GET" action="{{ route('personas.index') }}" class="row g-3">
                        <div class="col-md-6">
                            <label for="search" class="form-label">Buscar</label>
                            <input type="text" class="form-control" id="search" name="search"
                                   value="{{ request('search') }}"
                                   placeholder="Nombre, apellidos, documento...">
                        </div>
                        <div class="col-md-3">
                            <label for="tipo_documento" class="form-label">Tipo Documento</label>
                            <select class="form-select" id="tipo_documento" name="tipo_documento">
                                <option value="">Todos</option>
                                <option value="dni" {{ request('tipo_documento') == 'dni' ? 'selected' : '' }}>DNI</option>
                                <option value="ce" {{ request('tipo_documento') == 'ce' ? 'selected' : '' }}>CE</option>
                                <option value="pasaporte" {{ request('tipo_documento') == 'pasaporte' ? 'selected' : '' }}>Pasaporte</option>
                                <option value="ruc" {{ request('tipo_documento') == 'ruc' ? 'selected' : '' }}>RUC</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-outline-primary me-2">
                                <i class="fas fa-search"></i> Buscar
                            </button>
                            <a href="{{ route('personas.index') }}" class="btn btn-outline-secondary">
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
                                    <h3 class="mb-0">{{ isset($personas) ? (is_object($personas) && method_exists($personas, 'total') ? $personas->total() : count($personas)) : 0 }}</h3>
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
                                    <h3 class="mb-0">{{ isset($stats['con_trabajador']) ? $stats['con_trabajador'] : 0 }}</h3>
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
                                    <h3 class="mb-0">{{ isset($stats['sin_trabajador']) ? $stats['sin_trabajador'] : 0 }}</h3>
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
                                    <h3 class="mb-0">{{ isset($stats['nuevas_mes']) ? $stats['nuevas_mes'] : 0 }}</h3>
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
                    @if(!empty($personas) && count($personas) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>
                                            <a href="{{ route('personas.index', array_merge(request()->all(), ['sort' => 'id', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}"
                                               class="text-white text-decoration-none">
                                                ID
                                                <i class="fas fa-sort ms-1"></i>
                                            </a>
                                        </th>
                                        <th>
                                            <a href="{{ route('personas.index', array_merge(request()->all(), ['sort' => 'apellidos', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}"
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
                                    @foreach($personas as $persona)
                                        <tr>
                                            <td><strong>#{{ $persona->id }}</strong></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="me-3">
                                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                                             style="width: 40px; height: 40px;">
                                                            <i class="fas fa-user"></i>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold">{{ $persona->nombres ?? 'N/A' }} {{ $persona->apellidos ?? '' }}</div>
                                                        @if($persona->nacionalidad)
                                                            <small class="text-muted">{{ $persona->nacionalidad }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if($persona->numero_documento)
                                                    <div>
                                                        <span class="badge bg-info">{{ strtoupper($persona->tipo_documento ?? 'DOC') }}</span>
                                                        <div><small>{{ $persona->numero_documento }}</small></div>
                                                    </div>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($persona->correo)
                                                    <div><i class="fas fa-envelope text-muted me-1"></i>{{ $persona->correo }}</div>
                                                @endif
                                                @if($persona->celular)
                                                    <div><i class="fas fa-phone text-muted me-1"></i>{{ $persona->celular }}</div>
                                                @endif
                                            </td>
                                            <td>
                                                @if($persona->fecha_nacimiento)
                                                    <div><small class="text-muted">
                                                        <i class="fas fa-birthday-cake me-1"></i>
                                                        {{ \Carbon\Carbon::parse($persona->fecha_nacimiento)->format('d/m/Y') }}
                                                        ({{ \Carbon\Carbon::parse($persona->fecha_nacimiento)->age }} años)
                                                    </small></div>
                                                @endif
                                                @if($persona->sexo)
                                                    <span class="badge bg-secondary">
                                                        {{ $persona->sexo == 'M' ? 'Masculino' : ($persona->sexo == 'F' ? 'Femenino' : 'Otro') }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($persona->trabajador)
                                                    <div>
                                                        <span class="badge bg-success">
                                                            <i class="fas fa-check me-1"></i>
                                                            Trabajador
                                                        </span>
                                                        <div><small class="text-muted">{{ $persona->trabajador->area ?? 'Sin área' }}</small></div>
                                                    </div>
                                                @else
                                                    <span class="badge bg-warning text-dark">
                                                        <i class="fas fa-minus me-1"></i>
                                                        Sin asignar
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('personas.show', $persona) }}"
                                                       class="btn btn-sm btn-outline-info"
                                                       title="Ver detalles">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('personas.edit', $persona) }}"
                                                       class="btn btn-sm btn-outline-warning"
                                                       title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    @if(!$persona->trabajador)
                                                        <a href="{{ route('trabajadores.create', ['persona_id' => $persona->id]) }}"
                                                           class="btn btn-sm btn-outline-success"
                                                           title="Crear trabajador">
                                                            <i class="fas fa-user-plus"></i>
                                                        </a>
                                                    @else
                                                        <a href="{{ route('trabajadores.show', $persona->trabajador) }}"
                                                           class="btn btn-sm btn-outline-primary"
                                                           title="Ver trabajador">
                                                            <i class="fas fa-user-tie"></i>
                                                        </a>
                                                    @endif
                                                    <form method="POST" action="{{ route('personas.destroy', $persona) }}"
                                                          style="display: inline;"
                                                          onsubmit="return confirm('¿Está seguro de eliminar esta persona?')">
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
                        @if(is_object($personas) && method_exists($personas, 'links'))
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <div>
                                    <small class="text-muted">
                                        Mostrando {{ $personas->firstItem() ?? 0 }} a {{ $personas->lastItem() ?? 0 }}
                                        de {{ $personas->total() ?? 0 }} resultados
                                    </small>
                                </div>
                                <div>
                                    {{ $personas->appends(request()->query())->links() }}
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-user-friends fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">No hay personas registradas</h4>
                            <p class="text-muted mb-4">Comience agregando la primera persona al sistema</p>
                            <a href="{{ route('personas.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i>
                                Crear Primera Persona
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
