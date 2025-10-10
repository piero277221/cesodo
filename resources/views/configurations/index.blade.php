@extends('layouts.app')

@section('title', 'Configuraciones del Sistema')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-cogs text-primary me-2"></i>
                        Configuraciones del Sistema
                    </h1>
                    <p class="text-muted mb-0">Administra las configuraciones generales del sistema</p>
                </div>
                <div>
                    @can('crear-configuraciones')
                        <a href="{{ route('configurations.create') }}" class="btn btn-primary me-2">
                            <i class="fas fa-plus me-2"></i>
                            Nueva Configuración
                        </a>
                    @endcan
                    <a href="{{ route('configurations.export') }}" class="btn btn-outline-info">
                        <i class="fas fa-download me-2"></i>
                        Exportar
                    </a>
                </div>
            </div>

            <!-- Filtros -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-filter me-2"></i>Filtros
                    </h6>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('configurations.index') }}" class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Módulo</label>
                            <select name="module" class="form-select">
                                <option value="all" {{ $module == 'all' ? 'selected' : '' }}>Todos los módulos</option>
                                @foreach($modules as $mod)
                                    <option value="{{ $mod }}" {{ $module == $mod ? 'selected' : '' }}>
                                        {{ ucfirst($mod) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Categoría</label>
                            <select name="category" class="form-select">
                                <option value="all" {{ $category == 'all' ? 'selected' : '' }}>Todas las categorías</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}" {{ $category == $cat ? 'selected' : '' }}>
                                        {{ ucfirst($cat) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="fas fa-search me-1"></i>
                                    Filtrar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabla de configuraciones -->
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-list me-2"></i>Configuraciones
                        <span class="badge bg-primary ms-2">{{ $configurations->total() }}</span>
                    </h6>
                </div>
                <div class="card-body p-0">
                    @if($configurations->count() > 0)
                        <div class="table-responsive">
                            <form method="POST" action="{{ route('configurations.bulk-update') }}" id="bulkUpdateForm">
                                @csrf
                                <table class="table table-hover mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="border-0 px-4 py-3">Clave</th>
                                            <th class="border-0 py-3">Módulo</th>
                                            <th class="border-0 py-3">Categoría</th>
                                            <th class="border-0 py-3">Tipo</th>
                                            <th class="border-0 py-3">Valor Actual</th>
                                            <th class="border-0 py-3">Descripción</th>
                                            <th class="border-0 py-3 text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($configurations as $config)
                                            <tr>
                                                <td class="px-4 py-3">
                                                    <div class="d-flex align-items-center">
                                                        @if($config->is_system)
                                                            <i class="fas fa-lock text-warning me-2" title="Configuración del sistema"></i>
                                                        @elseif(!$config->editable)
                                                            <i class="fas fa-ban text-danger me-2" title="No editable"></i>
                                                        @endif
                                                        <code class="bg-light px-2 py-1 rounded">{{ $config->key }}</code>
                                                    </div>
                                                </td>
                                                <td class="py-3">
                                                    @if($config->module)
                                                        <span class="badge bg-info">{{ ucfirst($config->module) }}</span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td class="py-3">
                                                    <span class="badge bg-secondary">{{ ucfirst($config->category) }}</span>
                                                </td>
                                                <td class="py-3">
                                                    <span class="badge
                                                        @switch($config->type)
                                                            @case('boolean') bg-success @break
                                                            @case('number') bg-primary @break
                                                            @case('json') bg-warning @break
                                                            @case('date') bg-info @break
                                                            @default bg-light text-dark
                                                        @endswitch
                                                    ">
                                                        {{ $config->type }}
                                                    </span>
                                                </td>
                                                <td class="py-3" style="max-width: 200px;">
                                                    @if($config->editable && !$config->is_system)
                                                        @if($config->type === 'boolean')
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input"
                                                                       type="checkbox"
                                                                       name="configurations[{{ $config->id }}][value]"
                                                                       {{ $config->value ? 'checked' : '' }}>
                                                            </div>
                                                        @elseif($config->type === 'text')
                                                            <textarea class="form-control form-control-sm"
                                                                      name="configurations[{{ $config->id }}][value]"
                                                                      rows="2">{{ $config->value }}</textarea>
                                                        @else
                                                            <input type="text"
                                                                   class="form-control form-control-sm"
                                                                   name="configurations[{{ $config->id }}][value]"
                                                                   value="{{ $config->value }}">
                                                        @endif
                                                    @else
                                                        <span class="text-truncate d-block">
                                                            @if($config->type === 'boolean')
                                                                <span class="badge {{ $config->value ? 'bg-success' : 'bg-danger' }}">
                                                                    {{ $config->value ? 'Sí' : 'No' }}
                                                                </span>
                                                            @else
                                                                {{ Str::limit($config->value, 50) }}
                                                            @endif
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="py-3" style="max-width: 250px;">
                                                    <small class="text-muted">{{ Str::limit($config->description, 100) }}</small>
                                                </td>
                                                <td class="py-3 text-center">
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('configurations.show', $config) }}"
                                                           class="btn btn-outline-info btn-sm"
                                                           title="Ver detalles">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        @if($config->editable && !$config->is_system)
                                                            @can('editar-configuraciones')
                                                                <a href="{{ route('configurations.edit', $config) }}"
                                                                   class="btn btn-outline-warning btn-sm"
                                                                   title="Editar">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                            @endcan
                                                            @can('eliminar-configuraciones')
                                                                <form method="POST"
                                                                      action="{{ route('configurations.destroy', $config) }}"
                                                                      class="d-inline"
                                                                      onsubmit="return confirm('¿Estás seguro de eliminar esta configuración?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                            class="btn btn-outline-danger btn-sm"
                                                                            title="Eliminar">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            @endcan
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                @if($configurations->where('editable', true)->where('is_system', false)->count() > 0)
                                    <div class="p-3 bg-light border-top">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-save me-2"></i>
                                            Guardar Cambios Masivos
                                        </button>
                                    </div>
                                @endif
                            </form>
                        </div>

                        <!-- Paginación -->
                        @if($configurations->hasPages())
                            <div class="p-3 border-top">
                                {{ $configurations->withQueryString()->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-cogs fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No hay configuraciones</h5>
                            <p class="text-muted">No se encontraron configuraciones que coincidan con los filtros aplicados.</p>
                            @can('crear-configuraciones')
                                <a href="{{ route('configurations.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>
                                    Crear Primera Configuración
                                </a>
                            @endcan
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit form on filter change
    document.querySelectorAll('select[name="module"], select[name="category"]').forEach(function(select) {
        select.addEventListener('change', function() {
            this.form.submit();
        });
    });
});
</script>
@endpush
@endsection
