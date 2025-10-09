<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pedidos
        </h2>
    </x-slot>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm" style="background-color: #2d3436;">
                <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #fd7900; color: white;">
                    <h5 class="mb-0">
                        <i class="fas fa-eye me-2"></i>Detalle del Pedido: {{ $pedido->numero_pedido }}
                    </h5>
                    <div>
                        <a href="{{ route('pedidos.edit', $pedido) }}" class="btn" style="background-color: #2d3436; color: white; border: 1px solid white;">
                            <i class="fas fa-edit me-1"></i>Editar
                        </a>
                        <a href="{{ route('pedidos.index') }}" class="btn" style="background-color: #2d3436; color: white; border: 1px solid white;">
                            <i class="fas fa-arrow-left me-1"></i>Volver
                        </a>
                    </div>
                </div>
                <div class="card-body" style="background-color: white;">

                    <div class="row">
                        <!-- Información del pedido -->
                        <div class="col-md-6">
                            <h6 style="color: #fd7900; border-bottom: 2px solid #fd7900; padding-bottom: 5px;">
                                <i class="fas fa-info-circle me-2"></i>Información del Pedido
                            </h6>
                            <div class="row mb-3">
                                <div class="col-6"><strong>Número:</strong></div>
                                <div class="col-6">{{ $pedido->numero_pedido }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6"><strong>Estado:</strong></div>
                                <div class="col-6">
                                    @switch($pedido->estado)
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
                                    @endswitch
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6"><strong>Fecha Pedido:</strong></div>
                                <div class="col-6">{{ $pedido->fecha_pedido->format('d/m/Y') }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6"><strong>Fecha Entrega Esperada:</strong></div>
                                <div class="col-6">{{ $pedido->fecha_entrega_esperada->format('d/m/Y') }}</div>
                            </div>
                            @if($pedido->fecha_entrega_real)
                                <div class="row mb-3">
                                    <div class="col-6"><strong>Fecha Entrega Real:</strong></div>
                                    <div class="col-6">{{ $pedido->fecha_entrega_real->format('d/m/Y') }}</div>
                                </div>
                            @endif
                            <div class="row mb-3">
                                <div class="col-6"><strong>Total:</strong></div>
                                <div class="col-6"><strong style="color: #fd7900;">S/ {{ number_format($pedido->total, 2) }}</strong></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6"><strong>Usuario:</strong></div>
                                <div class="col-6">{{ $pedido->user->name ?? 'N/A' }}</div>
                            </div>
                        </div>

                        <!-- Información del proveedor -->
                        <div class="col-md-6">
                            <h6 style="color: #fd7900; border-bottom: 2px solid #fd7900; padding-bottom: 5px;">
                                <i class="fas fa-truck me-2"></i>Información del Proveedor
                            </h6>
                            <div class="row mb-3">
                                <div class="col-4"><strong>Nombre:</strong></div>
                                <div class="col-8">{{ $pedido->proveedor->nombre }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4"><strong>RUC:</strong></div>
                                <div class="col-8">{{ $pedido->proveedor->ruc }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4"><strong>Teléfono:</strong></div>
                                <div class="col-8">{{ $pedido->proveedor->telefono ?? 'N/A' }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4"><strong>Email:</strong></div>
                                <div class="col-8">{{ $pedido->proveedor->email ?? 'N/A' }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4"><strong>Dirección:</strong></div>
                                <div class="col-8">{{ $pedido->proveedor->direccion ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>

                    @if($pedido->observaciones)
                        <div class="row mt-4">
                            <div class="col-12">
                                <h6 style="color: #fd7900; border-bottom: 2px solid #fd7900; padding-bottom: 5px;">
                                    <i class="fas fa-comment me-2"></i>Observaciones
                                </h6>
                                <p class="text-muted">{{ $pedido->observaciones }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Detalle de productos -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 style="color: #fd7900; border-bottom: 2px solid #fd7900; padding-bottom: 5px;">
                                <i class="fas fa-box me-2"></i>Productos del Pedido
                            </h6>

                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead style="background-color: #2d3436; color: white;">
                                        <tr>
                                            <th>Código</th>
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>Precio Unitario</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pedido->detalles as $detalle)
                                            <tr>
                                                <td><strong>{{ $detalle->producto->codigo }}</strong></td>
                                                <td>{{ $detalle->producto->nombre }}</td>
                                                <td>{{ number_format($detalle->cantidad, 0) }}</td>
                                                <td>S/ {{ number_format($detalle->precio_unitario, 2) }}</td>
                                                <td><strong>S/ {{ number_format($detalle->subtotal, 2) }}</strong></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr style="background-color: #f8f9fa; font-weight: bold;">
                                            <td colspan="4" class="text-end">TOTAL:</td>
                                            <td style="color: #fd7900; font-size: 1.1em;">S/ {{ number_format($pedido->total, 2) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Información de auditoría -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card" style="background-color: #f8f9fa; border: none;">
                                <div class="card-body py-2">
                                    <small class="text-muted">
                                        <strong>Creado:</strong> {{ $pedido->created_at->format('d/m/Y H:i') }} |
                                        <strong>Última actualización:</strong> {{ $pedido->updated_at->format('d/m/Y H:i') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>