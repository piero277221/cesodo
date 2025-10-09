@extends('layouts.app')

@section('title', 'Kardex - ' . $producto->nombre)

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2 text-primary">
            <i class="fas fa-cube me-2"></i>Kardex - {{ $producto->nombre }}
        </h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="{{ route('kardex.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Volver al Kardex General
                </a>
                <a href="{{ route('kardex.producto.export', $producto) }}" class="btn btn-outline-success">
                    <i class="fas fa-file-excel me-1"></i>Exportar
                </a>
            </div>
        </div>
    </div>

    <!-- Información del Producto -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>Información del Producto
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nombre:</strong> {{ $producto->nombre }}</p>
                            <p><strong>Categoría:</strong> {{ $producto->categoria->nombre ?? 'Sin categoría' }}</p>
                            <p><strong>Unidad:</strong> {{ $producto->unidad ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Precio:</strong> S/ {{ number_format($producto->precio ?? 0, 2) }}</p>
                            <p><strong>Stock Actual:</strong>
                                <span class="badge {{ $saldoActual['cantidad'] > 0 ? 'bg-success' : 'bg-warning' }}">
                                    {{ number_format($saldoActual['cantidad']) }}
                                </span>
                            </p>
                            <p><strong>Valor Total:</strong> S/ {{ number_format($saldoActual['valor'], 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2"></i>Estadísticas
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h4 class="text-success">{{ number_format($estadisticasProducto['total_entradas']) }}</h4>
                                <small class="text-muted">Entradas</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="text-warning">{{ number_format($estadisticasProducto['total_salidas']) }}</h4>
                            <small class="text-muted">Salidas</small>
                        </div>
                    </div>
                    <hr>
                    <div class="text-center">
                        <p class="mb-1"><strong>Total Movimientos:</strong> {{ $estadisticasProducto['movimientos_count'] }}</p>
                        <p class="mb-0"><strong>Módulo:</strong> <span class="badge bg-secondary">{{ ucfirst($modulo) }}</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros por Módulo -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-filter me-2"></i>Filtros por Módulo
                    </h6>
                </div>
                <div class="card-body">
                    <div class="btn-group w-100" role="group">
                        <a href="{{ route('kardex.producto', ['producto' => $producto, 'modulo' => 'inventario'] + request()->except('modulo')) }}"
                           class="btn {{ $modulo == 'inventario' ? 'btn-primary' : 'btn-outline-primary' }}">
                            <i class="fas fa-boxes me-1"></i>Inventario
                        </a>
                        <a href="{{ route('kardex.producto', ['producto' => $producto, 'modulo' => 'compras'] + request()->except('modulo')) }}"
                           class="btn {{ $modulo == 'compras' ? 'btn-success' : 'btn-outline-success' }}">
                            <i class="fas fa-shopping-cart me-1"></i>Compras
                        </a>
                        <a href="{{ route('kardex.producto', ['producto' => $producto, 'modulo' => 'consumos'] + request()->except('modulo')) }}"
                           class="btn {{ $modulo == 'consumos' ? 'btn-warning' : 'btn-outline-warning' }}">
                            <i class="fas fa-utensils me-1"></i>Consumos
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros de Fechas -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-calendar me-2"></i>Filtros por Fecha
            </h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('kardex.producto', $producto) }}" class="row g-3">
                <input type="hidden" name="modulo" value="{{ $modulo }}">

                <div class="col-md-3">
                    <label class="form-label">Tipo de Movimiento</label>
                    <select name="tipo_movimiento" class="form-select">
                        <option value="">Todos</option>
                        <option value="entrada" {{ request('tipo_movimiento') == 'entrada' ? 'selected' : '' }}>Entrada</option>
                        <option value="salida" {{ request('tipo_movimiento') == 'salida' ? 'selected' : '' }}>Salida</option>
                        <option value="ajuste" {{ request('tipo_movimiento') == 'ajuste' ? 'selected' : '' }}>Ajuste</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Fecha Desde</label>
                    <input type="date" class="form-control" name="fecha_desde" value="{{ request('fecha_desde') }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Fecha Hasta</label>
                    <input type="date" class="form-control" name="fecha_hasta" value="{{ request('fecha_hasta') }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-1"></i>Filtrar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Histórico de Movimientos -->
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-history me-2"></i>Histórico de Movimientos
            </h6>
        </div>
        <div class="card-body">
            @if($movimientos->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th width="10%">Fecha</th>
                                <th width="10%">Tipo</th>
                                <th width="20%">Concepto</th>
                                <th width="10%">Documento</th>
                                <th width="8%" class="text-center">Entrada</th>
                                <th width="8%" class="text-center">Salida</th>
                                <th width="10%" class="text-center">Precio Unit.</th>
                                <th width="8%" class="text-center">Saldo Cant.</th>
                                <th width="10%" class="text-center">Saldo Valor</th>
                                <th width="6%">Usuario</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($movimientos as $movimiento)
                                <tr>
                                    <td>
                                        <small>{{ $movimiento->fecha->format('d/m/Y') }}</small>
                                        <br><small class="text-muted">{{ $movimiento->created_at->format('H:i') }}</small>
                                    </td>
                                    <td>
                                        @if($movimiento->tipo_movimiento == 'entrada')
                                            <span class="badge bg-success">
                                                <i class="fas fa-arrow-up me-1"></i>Entrada
                                            </span>
                                        @elseif($movimiento->tipo_movimiento == 'salida')
                                            <span class="badge bg-warning">
                                                <i class="fas fa-arrow-down me-1"></i>Salida
                                            </span>
                                        @else
                                            <span class="badge bg-info">
                                                <i class="fas fa-adjust me-1"></i>Ajuste
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $movimiento->concepto }}</strong>
                                        @if($movimiento->observaciones)
                                            <br><small class="text-muted">{{ $movimiento->observaciones }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($movimiento->numero_documento)
                                            <code>{{ $movimiento->numero_documento }}</code>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($movimiento->cantidad_entrada > 0)
                                            <span class="text-success fw-bold">+{{ number_format($movimiento->cantidad_entrada) }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($movimiento->cantidad_salida > 0)
                                            <span class="text-warning fw-bold">-{{ number_format($movimiento->cantidad_salida) }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($movimiento->precio_unitario)
                                            <small>S/ {{ number_format($movimiento->precio_unitario, 2) }}</small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <strong class="{{ $movimiento->saldo_cantidad >= 0 ? 'text-success' : 'text-danger' }}">
                                            {{ number_format($movimiento->saldo_cantidad) }}
                                        </strong>
                                    </td>
                                    <td class="text-center">
                                        @if($movimiento->saldo_valor)
                                            <small class="{{ $movimiento->saldo_valor >= 0 ? 'text-success' : 'text-danger' }}">
                                                S/ {{ number_format($movimiento->saldo_valor, 2) }}
                                            </small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small>{{ $movimiento->user->name ?? 'Sistema' }}</small>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($movimientos->count() >= 20)
                    <div class="alert alert-info mt-3">
                        <i class="fas fa-info-circle me-2"></i>
                        Mostrando los movimientos más recientes. Use los filtros para buscar movimientos específicos.
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <i class="fas fa-clipboard-list fa-3x text-gray-300 mb-4"></i>
                    <h4 class="text-gray-500">No hay movimientos registrados</h4>
                    <p class="text-gray-400 mb-4">No se encontraron movimientos para este producto en el módulo {{ $modulo }}</p>

                    @if($modulo == 'compras')
                        <p class="text-muted">Los movimientos aparecerán automáticamente cuando se registren compras.</p>
                    @elseif($modulo == 'consumos')
                        <p class="text-muted">Los movimientos aparecerán automáticamente cuando se registren consumos.</p>
                    @else
                        <p class="text-muted">Los movimientos aparecerán cuando se actualice el inventario.</p>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Highlight current saldo if it's negative
    const saldos = document.querySelectorAll('.text-danger');
    saldos.forEach(function(element) {
        if (element.textContent.includes('-')) {
            element.closest('tr').classList.add('table-warning');
        }
    });
});
</script>
@endpush
