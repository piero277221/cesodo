<!DOCTYPE html>
<html>
<head>
    <title>Debug Pedidos</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        .debug { background: #f0f0f0; padding: 15px; margin: 10px 0; border-radius: 5px; }
    </style>
</head>
<body>
    <h1>🔍 Debug del Módulo de Pedidos</h1>

    <div class="debug">
        <h3>Estado del Sistema:</h3>
        <p>✅ Controlador PedidoController cargado</p>
        <p>✅ Vista debug cargada correctamente</p>
        <p>📊 Pedidos encontrados: {{ $pedidos->count() }}</p>
        <p>🏢 Proveedores disponibles: {{ $proveedores->count() }}</p>
    </div>

    <div class="debug">
        <h3>Información de Variables:</h3>
        <p><strong>Tipo de $pedidos:</strong> {{ gettype($pedidos) }}</p>
        <p><strong>Tipo de $proveedores:</strong> {{ gettype($proveedores) }}</p>
    </div>

    <div class="debug">
        <h3>Acciones de Prueba:</h3>
        <a href="{{ route('pedidos.index') }}" style="background: #007bff; color: white; padding: 10px 15px; text-decoration: none; border-radius: 3px;">
            🔄 Recargar Vista Principal
        </a>
    </div>

    <div class="debug">
        <h3>Laravel Info:</h3>
        <p><strong>Laravel Version:</strong> {{ app()->version() }}</p>
        <p><strong>Environment:</strong> {{ app()->environment() }}</p>
        <p><strong>Debug Mode:</strong> {{ config('app.debug') ? 'ON' : 'OFF' }}</p>
    </div>
</body>
</html>
