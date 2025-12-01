<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Inventario;
use App\Models\MovimientoInventario;

class AgregarProductosInventario extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inventario:agregar-receta';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Agrega ingredientes de receta a inventario';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Agregando ingredientes de receta al inventario...');

        // Obtener o crear categoría de Ingredientes
        $categoriaIngredientes = Categoria::firstOrCreate(
            ['nombre' => 'Ingredientes'],
            ['descripcion' => 'Ingredientes para preparación de alimentos']
        );

        // Definir ingredientes con cantidades
        $ingredientes = [
            // Carnes
            ['nombre' => 'Pollo - Piernas y Encuentros', 'cantidad' => 25, 'unidad' => 'unidades', 'precio' => 5.50],
            
            // Aceites y bases
            ['nombre' => 'Aceite Vegetal', 'cantidad' => 4, 'unidad' => 'litros', 'precio' => 8.00],
            
            // Cebolla y ajos
            ['nombre' => 'Cebolla Picada', 'cantidad' => 4, 'unidad' => 'kg', 'precio' => 2.50],
            ['nombre' => 'Ajo Molido', 'cantidad' => 1.5, 'unidad' => 'kg', 'precio' => 15.00],
            
            // Ají
            ['nombre' => 'Ají Amarillo Molido', 'cantidad' => 1.2, 'unidad' => 'kg', 'precio' => 12.00],
            ['nombre' => 'Ají Mirasol', 'cantidad' => 1.2, 'unidad' => 'kg', 'precio' => 10.00],
            
            // Hierbas
            ['nombre' => 'Culantro Licuado', 'cantidad' => 3, 'unidad' => 'litros', 'precio' => 4.50],
            ['nombre' => 'Culantro Picado', 'cantidad' => 4, 'unidad' => 'kg', 'precio' => 3.00],
            
            // Caldos y condimentos
            ['nombre' => 'Caldo de Pollo Concentrado', 'cantidad' => 8, 'unidad' => 'cubos', 'precio' => 1.50],
            ['nombre' => 'Sal', 'cantidad' => 2, 'unidad' => 'kg', 'precio' => 1.00],
            ['nombre' => 'Pimienta', 'cantidad' => 1, 'unidad' => 'kg', 'precio' => 20.00],
            ['nombre' => 'Comino', 'cantidad' => 0.5, 'unidad' => 'kg', 'precio' => 18.00],
            
            // Arroz y base
            ['nombre' => 'Arroz', 'cantidad' => 12, 'unidad' => 'kg', 'precio' => 3.50],
            ['nombre' => 'Agua', 'cantidad' => 12, 'unidad' => 'litros', 'precio' => 0.50],
            
            // Bebidas
            ['nombre' => 'Cerveza Negra', 'cantidad' => 3, 'unidad' => 'litros', 'precio' => 8.00],
            
            // Vegetales
            ['nombre' => 'Arvejas', 'cantidad' => 4, 'unidad' => 'kg', 'precio' => 6.00],
            ['nombre' => 'Zanahoria Picada', 'cantidad' => 4, 'unidad' => 'kg', 'precio' => 2.00],
            ['nombre' => 'Pimiento Rojo en Tiras', 'cantidad' => 4, 'unidad' => 'kg', 'precio' => 4.50],
            ['nombre' => 'Choclo Desgranado', 'cantidad' => 2, 'unidad' => 'kg', 'precio' => 5.00],
        ];

        $productosAgregados = 0;
        $productosActualizados = 0;

        foreach ($ingredientes as $ingrediente) {
            try {
                // Buscar o crear producto
                $producto = Producto::firstOrCreate(
                    ['nombre' => $ingrediente['nombre']],
                    [
                        'codigo' => strtoupper(str_replace(' ', '_', $ingrediente['nombre'])),
                        'categoria_id' => $categoriaIngredientes->id,
                        'unidad_medida' => $ingrediente['unidad'],
                        'precio_unitario' => $ingrediente['precio'],
                        'stock_minimo' => 1,
                        'estado' => 'activo',
                    ]
                );

                // Verificar si ya existe inventario
                $inventario = Inventario::where('producto_id', $producto->id)->first();

                if ($inventario) {
                    // Actualizar stock
                    $inventario->update(['stock_actual' => $ingrediente['cantidad']]);
                    $productosActualizados++;
                    $this->info("✓ Actualizado: {$producto->nombre} - {$ingrediente['cantidad']} {$ingrediente['unidad']}");
                } else {
                    // Crear nuevo inventario
                    Inventario::create([
                        'producto_id' => $producto->id,
                        'stock_actual' => $ingrediente['cantidad'],
                        'stock_minimo' => 1,
                        'ubicacion' => 'Almacén General',
                    ]);

                    $productosAgregados++;
                    $this->info("✓ Agregado: {$producto->nombre} - {$ingrediente['cantidad']} {$ingrediente['unidad']}");
                }
            } catch (\Exception $e) {
                $this->error("✗ Error al procesar {$ingrediente['nombre']}: {$e->getMessage()}");
            }
        }

        $this->info("\n═════════════════════════════════════════");
        $this->info("Productos agregados: {$productosAgregados}");
        $this->info("Productos actualizados: {$productosActualizados}");
        $this->info("Total: " . ($productosAgregados + $productosActualizados));
        $this->info("═════════════════════════════════════════");

        return 0;
    }
}
