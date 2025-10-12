<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;
use App\Models\Inventario;
use Carbon\Carbon;

class InventarioInicialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lista de productos y stock inicial sugerido
        $productosStock = [
            // Carnes
            'Pollo Entero' => ['cantidad' => 50, 'unidad' => 'unidad'],
            'Piernas de Pollo' => ['cantidad' => 100, 'unidad' => 'unidad'],
            'Pechuga de Pollo' => ['cantidad' => 50, 'unidad' => 'kg'],
            'Carne de Res' => ['cantidad' => 50, 'unidad' => 'kg'],
            'Carne Molida' => ['cantidad' => 30, 'unidad' => 'kg'],
            'Pescado Fresco' => ['cantidad' => 30, 'unidad' => 'kg'],

            // Cereales y Granos
            'Arroz Blanco' => ['cantidad' => 100, 'unidad' => 'kg'],
            'Arroz Integral' => ['cantidad' => 50, 'unidad' => 'kg'],
            'Quinua' => ['cantidad' => 30, 'unidad' => 'kg'],
            'Fideos' => ['cantidad' => 50, 'unidad' => 'kg'],
            'Lentejas' => ['cantidad' => 30, 'unidad' => 'kg'],
            'Frijoles' => ['cantidad' => 30, 'unidad' => 'kg'],

            // Verduras
            'Cebolla Roja' => ['cantidad' => 50, 'unidad' => 'kg'],
            'Cebolla Blanca' => ['cantidad' => 30, 'unidad' => 'kg'],
            'Tomate' => ['cantidad' => 50, 'unidad' => 'kg'],
            'Zanahoria' => ['cantidad' => 40, 'unidad' => 'kg'],
            'Papa' => ['cantidad' => 100, 'unidad' => 'kg'],
            'Camote' => ['cantidad' => 50, 'unidad' => 'kg'],
            'Yuca' => ['cantidad' => 40, 'unidad' => 'kg'],
            'Ajo' => ['cantidad' => 10, 'unidad' => 'kg'],
            'Culantro' => ['cantidad' => 20, 'unidad' => 'kg'],
            'Perejil' => ['cantidad' => 10, 'unidad' => 'kg'],
            'Lechuga' => ['cantidad' => 30, 'unidad' => 'unidad'],
            'Choclo Desgranado' => ['cantidad' => 30, 'unidad' => 'kg'],
            'Arvejas' => ['cantidad' => 30, 'unidad' => 'kg'],

            // Frutas
            'Limón' => ['cantidad' => 50, 'unidad' => 'kg'],
            'Naranja' => ['cantidad' => 40, 'unidad' => 'kg'],
            'Manzana' => ['cantidad' => 40, 'unidad' => 'kg'],
            'Plátano' => ['cantidad' => 50, 'unidad' => 'kg'],
            'Aguaymanto' => ['cantidad' => 20, 'unidad' => 'kg'],

            // Condimentos y Especias
            'Sal' => ['cantidad' => 50, 'unidad' => 'kg'],
            'Pimienta' => ['cantidad' => 5, 'unidad' => 'kg'],
            'Comino' => ['cantidad' => 5, 'unidad' => 'kg'],
            'Orégano' => ['cantidad' => 5, 'unidad' => 'kg'],
            'Ají Panca' => ['cantidad' => 10, 'unidad' => 'kg'],
            'Ají Amarillo' => ['cantidad' => 10, 'unidad' => 'kg'],
            'Ají Amarillo Molido' => ['cantidad' => 15, 'unidad' => 'kg'],
            'Ajo Molido' => ['cantidad' => 15, 'unidad' => 'kg'],
            'Cubo MAGGI® Sabor Gallina' => ['cantidad' => 500, 'unidad' => 'unidad'],

            // Aceites y Vinagres
            'Aceite Vegetal' => ['cantidad' => 50, 'unidad' => 'litro'],
            'Aceite de Oliva' => ['cantidad' => 20, 'unidad' => 'litro'],
            'Vinagre Blanco' => ['cantidad' => 30, 'unidad' => 'litro'],
            'Vinagre de Manzana' => ['cantidad' => 20, 'unidad' => 'litro'],

            // Lácteos
            'Leche Evaporada' => ['cantidad' => 100, 'unidad' => 'litro'],
            'Leche Fresca' => ['cantidad' => 50, 'unidad' => 'litro'],
            'Queso Fresco' => ['cantidad' => 30, 'unidad' => 'kg'],
            'Mantequilla' => ['cantidad' => 20, 'unidad' => 'kg'],
            'Yogurt Natural' => ['cantidad' => 50, 'unidad' => 'litro'],

            // Otros
            'Huevos' => ['cantidad' => 500, 'unidad' => 'unidad'],
            'Pan' => ['cantidad' => 200, 'unidad' => 'unidad'],
            'Azúcar' => ['cantidad' => 50, 'unidad' => 'kg'],
            'Harina' => ['cantidad' => 50, 'unidad' => 'kg'],
        ];

        echo "🔄 Iniciando carga de inventario...\n";

        $creados = 0;
        $actualizados = 0;
        $noEncontrados = 0;

        foreach ($productosStock as $nombreProducto => $datos) {
            $producto = Producto::where('nombre', $nombreProducto)->first();

            if (!$producto) {
                echo "⚠️  Producto no encontrado: {$nombreProducto}\n";
                $noEncontrados++;
                continue;
            }

            // Verificar si ya existe inventario
            $inventario = Inventario::where('producto_id', $producto->id)->first();

            if ($inventario) {
                // Actualizar stock existente
                $inventario->update([
                    'stock_actual' => $inventario->stock_actual + $datos['cantidad'],
                    'stock_disponible' => $inventario->stock_disponible + $datos['cantidad'],
                    'fecha_ultimo_movimiento' => Carbon::now(),
                    'lote' => 'LOTE-INICIAL-' . date('Ymd'),
                ]);
                echo "✅ Actualizado: {$nombreProducto} (+{$datos['cantidad']} {$datos['unidad']})\n";
                $actualizados++;
            } else {
                // Crear nuevo registro de inventario
                Inventario::create([
                    'producto_id' => $producto->id,
                    'stock_actual' => $datos['cantidad'],
                    'stock_disponible' => $datos['cantidad'],
                    'stock_reservado' => 0,
                    'lote' => 'LOTE-INICIAL-' . date('Ymd'),
                    'fecha_vencimiento' => Carbon::now()->addMonths(6),
                    'fecha_ultimo_movimiento' => Carbon::now(),
                ]);
                echo "✅ Creado: {$nombreProducto} ({$datos['cantidad']} {$datos['unidad']})\n";
                $creados++;
            }
        }

        echo "\n";
        echo "📊 Resumen:\n";
        echo "   - Inventarios creados: {$creados}\n";
        echo "   - Inventarios actualizados: {$actualizados}\n";
        echo "   - Productos no encontrados: {$noEncontrados}\n";
        echo "✅ Proceso completado!\n";
    }
}
