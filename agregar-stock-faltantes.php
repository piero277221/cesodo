<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Producto;
use App\Models\Inventario;
use Carbon\Carbon;

$productos = [
    'Arroz Superior' => 100,
    'Cubo MAGGI Sabor Gallina' => 500,
    'Choclo' => 30,
];

echo "🔄 Agregando stock a productos faltantes...\n\n";

foreach ($productos as $nombre => $cantidad) {
    $p = Producto::where('nombre', $nombre)->first();
    
    if (!$p) {
        echo "❌ Producto no encontrado: {$nombre}\n";
        continue;
    }
    
    $inv = Inventario::where('producto_id', $p->id)->first();
    
    if ($inv) {
        $inv->update([
            'stock_actual' => $inv->stock_actual + $cantidad,
            'stock_disponible' => $inv->stock_disponible + $cantidad
        ]);
        echo "✅ Actualizado: {$nombre} (+{$cantidad} unidades) | Total: {$inv->stock_disponible}\n";
    } else {
        Inventario::create([
            'producto_id' => $p->id,
            'stock_actual' => $cantidad,
            'stock_disponible' => $cantidad,
            'stock_reservado' => 0,
            'lote' => 'LOTE-INICIAL-' . date('Ymd'),
            'fecha_vencimiento' => Carbon::now()->addMonths(6),
            'fecha_ultimo_movimiento' => Carbon::now()
        ]);
        echo "✅ Creado inventario: {$nombre} ({$cantidad} unidades)\n";
    }
}

echo "\n✅ Proceso completado!\n";
