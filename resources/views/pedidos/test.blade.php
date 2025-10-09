<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pedidos
        </h2>
    </x-slot>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Test de Integración - Módulo de Pedidos</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-success">
                        <h5>✅ El módulo de pedidos está integrado correctamente!</h5>
                        <p>Esta página se muestra dentro del layout principal del sistema.</p>
                        <hr>
                        <p class="mb-0">
                            <strong>Usuario actual:</strong> {{ Auth::check() ? Auth::user()->name : 'No autenticado' }}<br>
                            <strong>Ruta actual:</strong> {{ request()->path() }}<br>
                            <strong>Layout:</strong> layouts.app
                        </p>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <h6>Navegación disponible:</h6>
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <a href="{{ route('dashboard') }}">Dashboard</a>
                                </li>
                                <li class="list-group-item">
                                    <a href="{{ route('productos.index') }}">Productos</a>
                                </li>
                                <li class="list-group-item">
                                    <a href="{{ route('proveedores.index') }}">Proveedores</a>
                                </li>
                                <li class="list-group-item">
                                    <strong>Pedidos (actual)</strong>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6>Pruebas de funcionalidad:</h6>
                            <div class="btn-group-vertical d-grid gap-2">
                                <a href="{{ route('pedidos.index') }}" class="btn btn-primary">
                                    Ir a Lista de Pedidos
                                </a>
                                <a href="{{ route('pedidos.create') }}" class="btn btn-success">
                                    Crear Nuevo Pedido
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>