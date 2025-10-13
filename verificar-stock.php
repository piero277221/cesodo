<?php

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Support\Facades\DB;

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "📊 Verificación de Stock Agregado\n";
echo "==================================\n\n";

$inventarios = DB::table('inventarios')
    ->join('productos', 'inventarios.producto_id', '=', 'productos.id')
    ->select('productos.nombre', 'inventarios.stock_actual', 'inventarios.stock_disponible')
    ->orderBy('productos.nombre')
    ->limit(15)
    ->get();

foreach ($inventarios as $inv) {
    echo sprintf("%-30s → Stock: %5.0f unidades\n", $inv->nombre, $inv->stock_actual);
}

echo "\n==================================\n";
echo "Total registros: " . $inventarios->count() . "\n";

// Estadísticas
$stats = DB::table('inventarios')->selectRaw('
    COUNT(*) as total,
    MIN(stock_actual) as min_stock,
    MAX(stock_actual) as max_stock,
    AVG(stock_actual) as avg_stock
')->first();

echo "\n📈 Estadísticas:\n";
echo "   Total productos: {$stats->total}\n";
echo "   Stock mínimo: {$stats->min_stock}\n";
echo "   Stock máximo: {$stats->max_stock}\n";
echo "   Stock promedio: " . round($stats->avg_stock, 2) . "\n";
