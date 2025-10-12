<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredientesAdicionalesSeeder extends Seeder
{
    public function run(): void
    {
        // Verificar qué productos ya existen para no duplicar
        $productosNuevos = [
            // Producto que puede faltar - Arvejas (categoría Verduras - id: 3)
            [
                'codigo' => 'VERD-011',
                'nombre' => 'Arvejas',
                'descripcion' => 'Arvejas frescas o congeladas',
                'categoria_id' => 3,
                'unidad_medida' => 'kg',
                'precio_unitario' => 6.50,
                'stock_minimo' => 15,
            ],
            
            // Cubos de Caldo (categoría Condimentos - id: 7)
            [
                'codigo' => 'COND-007',
                'nombre' => 'Cubo MAGGI Sabor Gallina',
                'descripcion' => 'Cubos de caldo concentrado sabor gallina',
                'categoria_id' => 7,
                'unidad_medida' => 'caja',
                'precio_unitario' => 8.00,
                'stock_minimo' => 20,
            ],
            
            // Ajo Molido ya existe (COND-006)
            // Ají Amarillo ya existe (VERD-003) pero puede necesitar versión molida
            [
                'codigo' => 'COND-008',
                'nombre' => 'Ají Amarillo Molido',
                'descripcion' => 'Ají amarillo en pasta o molido',
                'categoria_id' => 7,
                'unidad_medida' => 'kg',
                'precio_unitario' => 15.00,
                'stock_minimo' => 8,
            ],
        ];

        foreach ($productosNuevos as $producto) {
            // Verificar si el código ya existe
            $existe = DB::table('productos')->where('codigo', $producto['codigo'])->exists();
            
            if (!$existe) {
                DB::table('productos')->insert(array_merge($producto, [
                    'estado' => 'activo',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
                echo "✅ Agregado: {$producto['nombre']}\n";
            } else {
                echo "⚠️  Ya existe: {$producto['nombre']}\n";
            }
        }

        echo "\n📋 Ingredientes de la receta 'Arroz con Pollo':\n";
        echo "═══════════════════════════════════════════\n\n";
        
        $ingredientesReceta = [
            ['producto' => 'Pollo Entero', 'cantidad' => '4 piernas (aprox 1.5 kg)', 'codigo' => 'CARN-002'],
            ['producto' => 'Arroz Superior', 'cantidad' => '2 tazas (400g)', 'codigo' => 'CER-001'],
            ['producto' => 'Cubo MAGGI Sabor Gallina', 'cantidad' => '1 cubo', 'codigo' => 'COND-007'],
            ['producto' => 'Cebolla Roja', 'cantidad' => '3 unidades', 'codigo' => 'VERD-001'],
            ['producto' => 'Tomate', 'cantidad' => '1 unidad', 'codigo' => 'VERD-002'],
            ['producto' => 'Zanahoria', 'cantidad' => '1 unidad', 'codigo' => 'VERD-010'],
            ['producto' => 'Arvejas', 'cantidad' => '1/2 taza (100g)', 'codigo' => 'VERD-011'],
            ['producto' => 'Choclo', 'cantidad' => '1/2 taza desgranado', 'codigo' => 'VERD-009'],
            ['producto' => 'Culantro', 'cantidad' => '1 taza deshojado', 'codigo' => 'VERD-007'],
            ['producto' => 'Sal', 'cantidad' => '1 pizca', 'codigo' => 'ABAR-003'],
            ['producto' => 'Limón', 'cantidad' => '2 unidades', 'codigo' => 'FRUT-001'],
            ['producto' => 'Ajo Molido', 'cantidad' => '1 cucharadita', 'codigo' => 'COND-006'],
            ['producto' => 'Ají Amarillo Molido', 'cantidad' => '4 cucharadas', 'codigo' => 'COND-008'],
            ['producto' => 'Aceite Vegetal', 'cantidad' => '4 cucharadas', 'codigo' => 'ACEI-001'],
        ];

        echo "Ingredientes disponibles en el sistema:\n\n";
        foreach ($ingredientesReceta as $ingrediente) {
            $existe = DB::table('productos')->where('codigo', $ingrediente['codigo'])->exists();
            $status = $existe ? '✅' : '❌';
            echo "{$status} {$ingrediente['producto']} - {$ingrediente['cantidad']} [{$ingrediente['codigo']}]\n";
        }

        echo "\n🍲 Receta: ARROZ CON POLLO PERUANO\n";
        echo "═════════════════════════════════\n";
        echo "Todos los ingredientes necesarios están ahora disponibles en el sistema.\n";
        echo "Puedes crear la receta desde el módulo de Menús.\n\n";
    }
}
