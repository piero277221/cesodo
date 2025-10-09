<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Inventario;
use App\Models\Producto;

class InventarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        echo "Creando registros de inventario...\n";

        $productos = Producto::all();

        foreach ($productos as $producto) {
            // Verificar si ya existe inventario para este producto
            $inventarioExistente = Inventario::where('producto_id', $producto->id)->first();

            if (!$inventarioExistente) {
                $stockActual = rand(50, 500);
                $stockReservado = rand(0, 10);

                Inventario::create([
                    'producto_id' => $producto->id,
                    'stock_actual' => $stockActual,
                    'stock_reservado' => $stockReservado,
                    'stock_disponible' => $stockActual - $stockReservado,
                    'fecha_ultimo_movimiento' => now()->subDays(rand(1, 30)),
                    'fecha_vencimiento' => now()->addDays(rand(30, 365)),
                    'lote' => 'LOTE-' . strtoupper(substr($producto->nombre, 0, 3)) . '-' . date('Y') . rand(100, 999),
                ]);

                echo "Inventario creado para: {$producto->nombre}\n";
            } else {
                echo "Inventario ya existe para: {$producto->nombre}\n";
            }
        }

        echo "Inventario completado!\n";
    }
}
