<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Producto;
use App\Models\Receta;
use App\Models\Inventario;

echo "📋 Verificando stock para receta 'Arroz con Pollo'...\n\n";

$receta = Receta::where('nombre', 'LIKE', '%arroz%pollo%')->with('ingredientes.producto.inventario')->first();

if (!$receta) {
    echo "❌ Receta no encontrada\n";
    exit;
}

echo "Receta: {$receta->nombre}\n";
echo "Porciones: {$receta->porciones}\n\n";

echo "Ingredientes necesarios:\n";
echo str_repeat("-", 80) . "\n";
printf("%-30s %-15s %-15s %s\n", "Producto", "Necesario", "Stock Actual", "Estado");
echo str_repeat("-", 80) . "\n";

$todosDisponibles = true;

foreach ($receta->ingredientes as $ingrediente) {
    $producto = $ingrediente->producto;
    $inventario = $producto->inventario;

    $stockDisponible = $inventario ? $inventario->stock_disponible : 0;
    $cantidadNecesaria = $ingrediente->cantidad;

    $estado = $stockDisponible >= $cantidadNecesaria ? "✅ OK" : "❌ FALTA";

    if ($stockDisponible < $cantidadNecesaria) {
        $todosDisponibles = false;
    }

    printf(
        "%-30s %8.2f %-6s %8.2f %-6s %s\n",
        substr($producto->nombre, 0, 28),
        $cantidadNecesaria,
        $ingrediente->unidad_medida,
        $stockDisponible,
        '',
        $estado
    );
}

echo str_repeat("-", 80) . "\n";

if ($todosDisponibles) {
    echo "\n✅ Todos los ingredientes están disponibles en stock!\n";
} else {
    echo "\n❌ Faltan algunos ingredientes en stock.\n";
}
