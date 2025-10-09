<!DOCTYPE html>
<html>
<head>
    <title>Debug Pedidos</title>
</head>
<body>
    <h1>Debug Módulo de Pedidos</h1>

    <h2>Test 1: ¿La vista se carga?</h2>
    <p>✅ SÍ - Esta vista se está mostrando</p>

    <h2>Test 2: ¿Hay datos de pedidos?</h2>
    @if(isset($pedidos))
        <p>✅ Variable $pedidos existe</p>
        <p>Total de pedidos: {{ $pedidos->count() }}</p>

        @if($pedidos->count() > 0)
            <h3>Lista de pedidos:</h3>
            <ul>
            @foreach($pedidos as $pedido)
                <li>ID: {{ $pedido->id }} - Proveedor: {{ $pedido->proveedor->nombre ?? 'Sin proveedor' }} - Total: ${{ $pedido->total }}</li>
            @endforeach
            </ul>
        @else
            <p>❌ No hay pedidos en la base de datos</p>
        @endif
    @else
        <p>❌ Variable $pedidos NO existe</p>
    @endif

    <h2>Test 3: ¿Hay datos de proveedores?</h2>
    @if(isset($proveedores))
        <p>✅ Variable $proveedores existe</p>
        <p>Total de proveedores: {{ $proveedores->count() }}</p>
    @else
        <p>❌ Variable $proveedores NO existe</p>
    @endif

    <h2>Test 4: Verificación directa</h2>
    <p>Fecha actual: {{ date('Y-m-d H:i:s') }}</p>

    <a href="/scm-cesodo/pedidos/create">Ir a crear pedido</a>
</body>
</html>
