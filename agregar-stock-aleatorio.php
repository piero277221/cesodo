<?php

/**
 * Script para agregar stock aleatorio entre 10 y 30 a todos los productos
 * Ejecutar: php agregar-stock-aleatorio.php
 */

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use App\Models\Producto;
use App\Models\Inventario;
use App\Models\MovimientoInventario;
use Carbon\Carbon;

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🚀 Iniciando actualización de stock aleatorio...\n";
echo "================================================\n\n";

try {
    DB::beginTransaction();

    $productos = Producto::where('estado', 'activo')->get();
    
    if ($productos->isEmpty()) {
        echo "❌ No se encontraron productos activos.\n";
        exit;
    }

    echo "📦 Total de productos a procesar: " . $productos->count() . "\n\n";

    $actualizados = 0;
    $creados = 0;
    $errores = 0;

    foreach ($productos as $producto) {
        try {
            // Generar cantidad aleatoria entre 10 y 30
            $cantidadAleatoria = rand(10, 30);

            // Buscar si ya existe inventario para este producto
            $inventario = Inventario::where('producto_id', $producto->id)->first();

            if ($inventario) {
                // Actualizar stock existente
                $stockAnterior = $inventario->stock_actual;
                $nuevoStock = $stockAnterior + $cantidadAleatoria;

                $inventario->update([
                    'stock_actual' => $nuevoStock,
                    'stock_disponible' => $nuevoStock - $inventario->stock_reservado,
                    'fecha_ultimo_movimiento' => Carbon::now()
                ]);

                echo "✅ {$producto->nombre}\n";
                echo "   Stock anterior: {$stockAnterior} → Stock nuevo: {$nuevoStock} (+{$cantidadAleatoria})\n\n";
                
                $actualizados++;
            } else {
                // Crear nuevo registro de inventario
                $inventario = Inventario::create([
                    'producto_id' => $producto->id,
                    'stock_actual' => $cantidadAleatoria,
                    'stock_reservado' => 0,
                    'stock_disponible' => $cantidadAleatoria,
                    'fecha_ultimo_movimiento' => Carbon::now()
                ]);

                echo "🆕 {$producto->nombre}\n";
                echo "   Stock inicial creado: {$cantidadAleatoria}\n\n";
                
                $creados++;
            }

            // Registrar movimiento de inventario
            MovimientoInventario::create([
                'producto_id' => $producto->id,
                'tipo_movimiento' => 'entrada',
                'cantidad' => $cantidadAleatoria,
                'precio_unitario' => $producto->precio_unitario,
                'precio_total' => $producto->precio_unitario * $cantidadAleatoria,
                'motivo' => 'ajuste_inventario',
                'observaciones' => 'Stock aleatorio agregado automáticamente (entre 10-30 unidades)',
                'user_id' => 1, // Usuario admin
                'fecha_movimiento' => Carbon::now(),
            ]);

        } catch (\Exception $e) {
            echo "❌ Error con {$producto->nombre}: {$e->getMessage()}\n\n";
            $errores++;
        }
    }

    DB::commit();

    echo "\n================================================\n";
    echo "✨ Proceso completado exitosamente!\n\n";
    echo "📊 Resumen:\n";
    echo "   - Inventarios actualizados: {$actualizados}\n";
    echo "   - Inventarios creados: {$creados}\n";
    echo "   - Errores: {$errores}\n";
    echo "   - Total procesado: " . ($actualizados + $creados) . "\n";
    echo "================================================\n";

} catch (\Exception $e) {
    DB::rollBack();
    echo "\n❌ ERROR GENERAL: {$e->getMessage()}\n";
    echo "Stack trace: {$e->getTraceAsString()}\n";
    exit(1);
}
