@extends('layouts.app')

@section('title', 'Debug Pedidos')

@section('content')
<div class="container">
    <h1>Debug - Módulo de Pedidos</h1>

    <div class="alert alert-info">
        <h4>Estado del Sistema:</h4>
        <ul>
            <li>Laravel Version: {{ app()->version() }}</li>
            <li>PHP Version: {{ phpversion() }}</li>
            <li>Ruta actual: {{ Request::url() }}</li>
            <li>Método: {{ Request::method() }}</li>
        </ul>
    </div>

    <div class="alert alert-success">
        <h4>Modelos disponibles:</h4>
        <ul>
            <li>Pedidos en BD: {{ \App\Models\Pedido::count() }}</li>
            <li>Proveedores en BD: {{ \App\Models\Proveedor::count() }}</li>
            <li>Productos en BD: {{ \App\Models\Producto::count() ?? 'N/A' }}</li>
        </ul>
    </div>

    <div class="alert alert-warning">
        <h4>Variables de la vista:</h4>
        <ul>
            @if(isset($pedidos))
                <li>Variable $pedidos está definida: {{ is_object($pedidos) ? $pedidos->count() : count($pedidos) }} registros</li>
            @else
                <li>Variable $pedidos NO está definida</li>
            @endif

            @if(isset($totalPedidos))
                <li>Total pedidos: {{ $totalPedidos }}</li>
            @else
                <li>Variable $totalPedidos NO está definida</li>
            @endif
        </ul>
    </div>

    <div class="mt-4">
        <a href="{{ route('pedidos.index') }}" class="btn btn-primary">Ir a Pedidos (Ruta Laravel)</a>
        <a href="/cesodo/public/pedidos" class="btn btn-secondary">Ir a Pedidos (URL directa)</a>
    </div>
</div>
@endsection
