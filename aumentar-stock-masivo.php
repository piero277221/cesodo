<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Producto;
use App\Models\Inventario;
use Carbon\Carbon;

echo "🔄 Agregando más stock a productos críticos...\n\n";

// Productos que necesitan más stock
$productos = [
    'Ají Amarillo Molido' => 100,  // Aumentar significativamente
    'Ajo Molido' => 100,
    'Pollo Entero' => 200,
    'Arroz Superior' => 500,
    'Culantro' => 100,
    'Sal' => 200,
    'Aceite Vegetal' => 200,
    'Arvejas' => 100,
    'Vinagre Blanco' => 100,
    'Aguaymanto' => 100,
    'Cubo MAGGI Sabor Gallina' => 1000,
    'Choclo' => 100,
];

foreach ($productos as $nombre => $cantidad) {
    $p = Producto::where('nombre', $nombre)->first();

    if (!$p) {
        echo "❌ Producto no encontrado: {$nombre}\n";
        continue;
    }

    $inv = Inventario::where('producto_id', $p->id)->first();

    if ($inv) {
        $stockAnterior = $inv->stock_disponible;
        $inv->update([
            'stock_actual' => $inv->stock_actual + $cantidad,
            'stock_disponible' => $inv->stock_disponible + $cantidad,
            'fecha_ultimo_movimiento' => Carbon::now()
        ]);
        $stockNuevo = $inv->stock_disponible;
        echo "✅ Actualizado: {$nombre}\n";
        echo "   Stock anterior: {$stockAnterior} → Stock nuevo: {$stockNuevo} (+{$cantidad})\n";
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
echo "\n📊 Ahora puedes crear un menú para hasta:\n";
echo "   - 50 personas por 7 días, o\n";
echo "   - 20 personas por 30 días\n";
