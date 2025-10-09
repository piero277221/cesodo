<?php

use Illuminate\Database\Seeder;
use App\Models\Proveedor;
use App\Models\Producto;
use App\Models\Categoria;

class PedidosFixSeeder extends Seeder
{
    public function run()
    {
        // Crear categoría si no existe
        $categoria = Categoria::firstOrCreate([
            'nombre' => 'Alimentos'
        ], [
            'descripcion' => 'Productos alimenticios',
            'codigo' => 'ALI'
        ]);

        // Crear productos adicionales
        $productos = [
            [
                'nombre' => 'Arroz Extra',
                'codigo' => 'ARR001',
                'descripcion' => 'Arroz extra de primera calidad',
                'categoria_id' => $categoria->id,
                'unidad_medida' => 'kg',
                'precio_unitario' => 3.50,
                'stock_minimo' => 50,
                'estado' => 'activo'
            ],
            [
                'nombre' => 'Aceite Vegetal',
                'codigo' => 'ACE001',
                'descripcion' => 'Aceite vegetal 1 litro',
                'categoria_id' => $categoria->id,
                'unidad_medida' => 'l',
                'precio_unitario' => 8.50,
                'stock_minimo' => 20,
                'estado' => 'activo'
            ],
            [
                'nombre' => 'Azúcar Blanca',
                'codigo' => 'AZU001',
                'descripcion' => 'Azúcar blanca refinada',
                'categoria_id' => $categoria->id,
                'unidad_medida' => 'kg',
                'precio_unitario' => 2.80,
                'stock_minimo' => 30,
                'estado' => 'activo'
            ]
        ];

        foreach ($productos as $producto) {
            Producto::firstOrCreate(
                ['codigo' => $producto['codigo']],
                $producto
            );
        }

        echo "Datos para pedidos creados exitosamente\n";
    }
}
