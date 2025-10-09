@extends('layouts.app')

@section('title', 'Cliente: ' . $cliente->nombre)

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0">{{ $cliente->nombre }}</h5>
                            <p class="text-sm mb-0">
                                {{ $cliente->tipo == 'natural' ? 'Persona Natural' : 'Persona Jurídica' }}
                                @if($cliente->rut) - RUT: {{ $cliente->rut }} @endif
                            </p>
                        </div>
                        <div class="d-flex gap-2">
                            <span class="badge badge-lg bg-gradient-{{ $cliente->estado == 'activo' ? 'success' : ($cliente->estado == 'suspendido' ? 'danger' : 'secondary') }}">
                                {{ ucfirst($cliente->estado) }}
                            </span>
                            <a href="{{ route('clientes.edit', $cliente) }}" class="btn bg-gradient-primary">
                                <i class="fas fa-edit me-2"></i>Editar
                            </a>
                            <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Volver
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Información del Cliente -->
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">Información Personal</h6>
                        </div>
                        <div class="card-body">
                            <div class="info-item mb-3">
                                <label class="text-sm font-weight-bold">Nombre/Razón Social:</label>
                                <p class="text-sm mb-0">{{ $cliente->nombre }}</p>
                            </div>

                            @if($cliente->rut)
                            <div class="info-item mb-3">
                                <label class="text-sm font-weight-bold">RUT:</label>
                                <p class="text-sm mb-0">{{ $cliente->rut }}</p>
                            </div>
                            @endif

                            @if($cliente->giro && $cliente->tipo == 'juridica')
                            <div class="info-item mb-3">
                                <label class="text-sm font-weight-bold">Giro:</label>
                                <p class="text-sm mb-0">{{ $cliente->giro }}</p>
                            </div>
                            @endif

                            <div class="info-item mb-3">
                                <label class="text-sm font-weight-bold">Tipo:</label>
                                <span class="badge badge-sm bg-gradient-{{ $cliente->tipo == 'natural' ? 'info' : 'warning' }}">
                                    {{ $cliente->tipo == 'natural' ? 'Persona Natural' : 'Persona Jurídica' }}
                                </span>
                            </div>

                            <div class="info-item mb-3">
                                <label class="text-sm font-weight-bold">Estado:</label>
                                <span class="badge badge-sm bg-gradient-{{ $cliente->estado == 'activo' ? 'success' : ($cliente->estado == 'suspendido' ? 'danger' : 'secondary') }}">
                                    {{ ucfirst($cliente->estado) }}
                                </span>
                            </div>

                            <div class="info-item mb-3">
                                <label class="text-sm font-weight-bold">Cliente desde:</label>
                                <p class="text-sm mb-0">{{ $cliente->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Información de Contacto -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">Información de Contacto</h6>
                        </div>
                        <div class="card-body">
                            @if($cliente->email)
                            <div class="info-item mb-3">
                                <label class="text-sm font-weight-bold">Email:</label>
                                <p class="text-sm mb-0">
                                    <a href="mailto:{{ $cliente->email }}">{{ $cliente->email }}</a>
                                </p>
                            </div>
                            @endif

                            @if($cliente->telefono)
                            <div class="info-item mb-3">
                                <label class="text-sm font-weight-bold">Teléfono:</label>
                                <p class="text-sm mb-0">
                                    <a href="tel:{{ $cliente->telefono }}">{{ $cliente->telefono }}</a>
                                </p>
                            </div>
                            @endif

                            @if($cliente->direccion)
                            <div class="info-item mb-3">
                                <label class="text-sm font-weight-bold">Dirección:</label>
                                <p class="text-sm mb-0">{{ $cliente->direccion }}</p>
                            </div>
                            @endif

                            @if($cliente->ciudad || $cliente->region)
                            <div class="info-item mb-3">
                                <label class="text-sm font-weight-bold">Ubicación:</label>
                                <p class="text-sm mb-0">
                                    @if($cliente->ciudad){{ $cliente->ciudad }}@endif
                                    @if($cliente->ciudad && $cliente->region), @endif
                                    @if($cliente->region){{ $cliente->region }}@endif
                                </p>
                            </div>
                            @endif

                            @if($cliente->codigo_postal)
                            <div class="info-item mb-3">
                                <label class="text-sm font-weight-bold">Código Postal:</label>
                                <p class="text-sm mb-0">{{ $cliente->codigo_postal }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Configuración de Crédito -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">Configuración de Crédito</h6>
                        </div>
                        <div class="card-body">
                            <div class="info-item mb-3">
                                <label class="text-sm font-weight-bold">Límite de Crédito:</label>
                                <p class="text-sm mb-0">${{ number_format($cliente->limite_credito ?? 0, 0, ',', '.') }}</p>
                            </div>

                            <div class="info-item mb-3">
                                <label class="text-sm font-weight-bold">Días de Crédito:</label>
                                <p class="text-sm mb-0">{{ $cliente->dias_credito ?? 0 }} días</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Estadísticas -->
                <div class="col-md-8">
                    <!-- Resumen de Ventas -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Ventas</p>
                                                <h5 class="font-weight-bolder mb-0">
                                                    {{ $estadisticas['total_ventas'] }}
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                                <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Gastado</p>
                                                <h5 class="font-weight-bolder mb-0">
                                                    ${{ number_format($estadisticas['total_gastado'], 0, ',', '.') }}
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                                                <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Promedio Compra</p>
                                                <h5 class="font-weight-bolder mb-0">
                                                    ${{ number_format($estadisticas['promedio_compra'], 0, ',', '.') }}
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                                                <i class="ni ni-chart-bar-32 text-lg opacity-10" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Saldo Pendiente</p>
                                                <h5 class="font-weight-bolder mb-0 {{ $estadisticas['saldo_pendiente'] > 0 ? 'text-danger' : 'text-success' }}">
                                                    ${{ number_format($estadisticas['saldo_pendiente'], 0, ',', '.') }}
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div class="icon icon-shape bg-gradient-{{ $estadisticas['saldo_pendiente'] > 0 ? 'warning' : 'success' }} shadow text-center border-radius-md">
                                                <i class="ni ni-credit-card text-lg opacity-10" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Últimas Ventas -->
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">Últimas Ventas</h6>
                            <a href="{{ route('clientes.estado-cuenta', $cliente) }}" class="btn btn-sm bg-gradient-info">
                                <i class="fas fa-file-invoice-dollar me-2"></i>Ver Estado de Cuenta
                            </a>
                        </div>
                        <div class="card-body">
                            @if($cliente->ventas->count() > 0)
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Número
                                            </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Fecha
                                            </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Tipo
                                            </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Total
                                            </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Estado
                                            </th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($cliente->ventas as $venta)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <h6 class="mb-0 text-sm">{{ $venta->numero_venta }}</h6>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-sm mb-0">{{ $venta->fecha_venta->format('d/m/Y') }}</p>
                                            </td>
                                            <td>
                                                <span class="badge badge-sm bg-gradient-{{ $venta->tipo_venta == 'contado' ? 'success' : 'info' }}">
                                                    {{ ucfirst($venta->tipo_venta) }}
                                                </span>
                                            </td>
                                            <td>
                                                <h6 class="text-sm mb-0">${{ number_format($venta->total, 0, ',', '.') }}</h6>
                                            </td>
                                            <td>
                                                <span class="badge badge-sm bg-gradient-{{ $venta->estado_pago == 'pagado' ? 'success' : ($venta->estado_pago == 'parcial' ? 'warning' : 'danger') }}">
                                                    {{ ucfirst($venta->estado_pago) }}
                                                </span>
                                            </td>
                                            <td class="align-middle">
                                                <a href="{{ route('ventas.show', $venta) }}" class="btn btn-link text-dark text-sm mb-0">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="text-center py-4">
                                <i class="fas fa-shopping-cart fa-3x text-secondary mb-3"></i>
                                <h6 class="text-secondary">No hay ventas registradas</h6>
                                <p class="text-sm text-secondary">Este cliente aún no ha realizado compras</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Observaciones -->
                    @if($cliente->observaciones)
                    <div class="card mt-4">
                        <div class="card-header">
                            <h6 class="mb-0">Observaciones</h6>
                        </div>
                        <div class="card-body">
                            <p class="text-sm mb-0">{{ $cliente->observaciones }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
