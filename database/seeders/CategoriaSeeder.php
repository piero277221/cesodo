<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [
            [
                'nombre' => 'Cereales y Granos',
                'descripcion' => 'Arroz, quinoa, avena, cebada, etc.',
                'estado' => 'activo'
            ],
            [
                'nombre' => 'Carnes y Aves',
                'descripcion' => 'Pollo, res, cerdo, pescado, etc.',
                'estado' => 'activo'
            ],
            [
                'nombre' => 'Verduras y Hortalizas',
                'descripcion' => 'Tomate, cebolla, zanahoria, lechuga, etc.',
                'estado' => 'activo'
            ],
            [
                'nombre' => 'Frutas',
                'descripcion' => 'Manzana, plátano, naranja, uva, etc.',
                'estado' => 'activo'
            ],
            [
                'nombre' => 'Lácteos',
                'descripcion' => 'Leche, queso, yogurt, mantequilla, etc.',
                'estado' => 'activo'
            ],
            [
                'nombre' => 'Condimentos y Especias',
                'descripcion' => 'Sal, azúcar, ají, comino, orégano, etc.',
                'estado' => 'activo'
            ],
            [
                'nombre' => 'Aceites y Grasas',
                'descripcion' => 'Aceite vegetal, manteca, aceite de oliva, etc.',
                'estado' => 'activo'
            ],
            [
                'nombre' => 'Bebidas',
                'descripcion' => 'Jugos, gaseosas, agua, café, té, etc.',
                'estado' => 'activo'
            ],
            [
                'nombre' => 'Productos de Limpieza',
                'descripcion' => 'Detergente, desinfectante, papel higiénico, etc.',
                'estado' => 'activo'
            ],
            [
                'nombre' => 'Utensilios de Cocina',
                'descripcion' => 'Platos, vasos, cubiertos, servilletas, etc.',
                'estado' => 'activo'
            ]
        ];

        foreach ($categorias as $categoria) {
            Categoria::create($categoria);
        }
    }
}
