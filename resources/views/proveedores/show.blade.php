<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Proveedores
        </h2>
    </x-slot>

@section('title', 'Proveedor: ' . $proveedor->razon_social . ' - Sistema SCM')

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<style>
    .proveedores-header {
        background: #2d3436;
        color: white;
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
    }
    .card-proveedores {
        border: none;
        border-radius: 15px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }
    .btn-proveedores {
        background: #fd7900;
        border: none;
        border-radius: 8px;
        padding: 0.6rem 1.5rem;
        color: white;
        transition: all 0.3s ease;
    }
    .btn-proveedores:hover {
        background: #e6690a;
        transform: translateY(-2px);
        color: white;
    }
    .info-card {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .stat-item {
        text-align: center;
        padding: 1rem;
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
</style>
@endpush

<div class="container-fluid py-4">
    <!-- Header -->
    <div class="proveedores-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="h2 mb-2">
                    <i class="fas fa-truck me-3"></i>
                    {{ $proveedor->razon_social }}
                </h1>
                <p class="mb-0 opacity-90">
                    RUC: {{ $proveedor->ruc }}
                    @if($proveedor->nombre_comercial)
                        • {{ $proveedor->nombre_comercial }}
                    @endif
                </p>
            </div>
            <div class="col-md-4 text-md-end">
                <div class="d-flex gap-2 justify-content-md-end">
                    <a href="{{ route('proveedores.edit', $proveedor) }}" class="btn btn-outline-light">
                        <i class="fas fa-edit me-2"></i>
                        Editar
                    </a>
                    <a href="{{ route('proveedores.index') }}" class="btn btn-outline-light">
                        <i class="fas fa-arrow-left me-2"></i>
                        Volver
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Información del Proveedor -->
        <div class="col-lg-8">
            <div class="card-proveedores">
                <div class="card-body p-4">
                    <h5 class="text-primary mb-4">
                        <i class="fas fa-info-circle me-2"></i>
                        Información del Proveedor
                    </h5>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted">RUC</label>
                            <div class="p-2 bg-light rounded">
                                <span class="badge bg-warning text-dark">{{ $proveedor->ruc }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted">Estado</label>
                            <div class="p-2 bg-light rounded">
                                <span class="badge {{ $proveedor->estado === 'activo' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ ucfirst($proveedor->estado) }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted">Razón Social</label>
                            <div class="p-2 bg-light rounded">
                                {{ $proveedor->razon_social }}
                            </div>
                        </div>
                        @if($proveedor->nombre_comercial)
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted">Nombre Comercial</label>
                            <div class="p-2 bg-light rounded">
                                {{ $proveedor->nombre_comercial }}
                            </div>
                        </div>
                        @endif
                        @if($proveedor->direccion)
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted">Dirección</label>
                            <div class="p-2 bg-light rounded">
                                <i class="fas fa-map-marker-alt me-2 text-muted"></i>
                                {{ $proveedor->direccion }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Información de Contacto -->
            @if($proveedor->contacto || $proveedor->telefono || $proveedor->email)
            <div class="card-proveedores mt-4">
                <div class="card-body p-4">
                    <h5 class="text-primary mb-4">
                        <i class="fas fa-address-book me-2"></i>
                        Información de Contacto
                    </h5>

                    <div class="row g-3">
                        @if($proveedor->contacto)
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted">Persona de Contacto</label>
                            <div class="p-2 bg-light rounded">
                                <i class="fas fa-user me-2 text-muted"></i>
                                {{ $proveedor->contacto }}
                            </div>
                        </div>
                        @endif
                        @if($proveedor->telefono)
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted">Teléfono</label>
                            <div class="p-2 bg-light rounded">
                                <i class="fas fa-phone me-2 text-muted"></i>
                                <a href="tel:{{ $proveedor->telefono }}" class="text-decoration-none">
                                    {{ $proveedor->telefono }}
                                </a>
                            </div>
                        </div>
                        @endif
                        @if($proveedor->email)
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted">Email</label>
                            <div class="p-2 bg-light rounded">
                                <i class="fas fa-envelope me-2 text-muted"></i>
                                <a href="mailto:{{ $proveedor->email }}" class="text-decoration-none">
                                    {{ $proveedor->email }}
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <!-- Últimos Pedidos -->
            @if($proveedor->pedidos->count() > 0)
            <div class="card-proveedores mt-4">
                <div class="card-body p-4">
                    <h5 class="text-primary mb-4">
                        <i class="fas fa-shopping-cart me-2"></i>
                        Últimos Pedidos
                    </h5>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Código</th>
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($proveedor->pedidos as $pedido)
                                <tr>
                                    <td>
                                        <span class="fw-bold">#{{ $pedido->codigo }}</span>
                                    </td>
                                    <td>{{ $pedido->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ ucfirst($pedido->estado) }}</span>
                                    </td>
                                    <td class="fw-bold">S/. {{ number_format($pedido->total ?? 0, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Estadísticas -->
        <div class="col-lg-4">
            <div class="card-proveedores">
                <div class="card-body p-4">
                    <h5 class="text-primary mb-4">
                        <i class="fas fa-chart-bar me-2"></i>
                        Estadísticas
                    </h5>

                    <div class="row g-3">
                        <div class="col-12">
                            <div class="stat-item">
                                <div class="h3 mb-1 text-primary">{{ $proveedor->pedidos()->count() }}</div>
                                <small class="text-muted">Total de Pedidos</small>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="stat-item">
                                <div class="h3 mb-1 text-success">
                                    {{ $proveedor->pedidos()->where('estado', 'entregado')->count() }}
                                </div>
                                <small class="text-muted">Pedidos Entregados</small>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="stat-item">
                                <div class="h3 mb-1 text-warning">
                                    {{ $proveedor->pedidos()->whereIn('estado', ['pendiente', 'confirmado'])->count() }}
                                </div>
                                <small class="text-muted">Pedidos Pendientes</small>
                            </div>
                        </div>
                    </div>

                    <!-- Acciones Rápidas -->
                    <div class="mt-4">
                        <h6 class="text-muted mb-3">Acciones Rápidas</h6>
                        <div class="d-grid gap-2">
                            <a href="{{ route('proveedores.edit', $proveedor) }}" class="btn btn-proveedores">
                                <i class="fas fa-edit me-2"></i>
                                Editar Proveedor
                            </a>
                            @if($proveedor->email)
                            <a href="mailto:{{ $proveedor->email }}" class="btn btn-outline-primary">
                                <i class="fas fa-envelope me-2"></i>
                                Enviar Email
                            </a>
                            @endif
                            @if($proveedor->telefono)
                            <a href="tel:{{ $proveedor->telefono }}" class="btn btn-outline-success">
                                <i class="fas fa-phone me-2"></i>
                                Llamar
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>