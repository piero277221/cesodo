<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriasSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            ['nombre' => 'Carnes', 'descripcion' => 'Carnes rojas, blancas y procesadas', 'estado' => 'activo'],
            ['nombre' => 'Pescados y Mariscos', 'descripcion' => 'Productos del mar frescos y congelados', 'estado' => 'activo'],
            ['nombre' => 'Verduras', 'descripcion' => 'Verduras frescas y hortalizas', 'estado' => 'activo'],
            ['nombre' => 'Frutas', 'descripcion' => 'Frutas frescas de estación', 'estado' => 'activo'],
            ['nombre' => 'Lácteos', 'descripcion' => 'Leche, quesos, yogurt y derivados', 'estado' => 'activo'],
            ['nombre' => 'Abarrotes', 'descripcion' => 'Productos secos y envasados', 'estado' => 'activo'],
            ['nombre' => 'Condimentos', 'descripcion' => 'Especias, hierbas y sazonadores', 'estado' => 'activo'],
            ['nombre' => 'Bebidas', 'descripcion' => 'Bebidas alcohólicas y no alcohólicas', 'estado' => 'activo'],
            ['nombre' => 'Cereales y Granos', 'descripcion' => 'Arroz, quinua, menestras', 'estado' => 'activo'],
            ['nombre' => 'Aceites y Grasas', 'descripcion' => 'Aceites vegetales y mantecas', 'estado' => 'activo'],
            ['nombre' => 'Tubérculos', 'descripcion' => 'Papa, camote, yuca y similares', 'estado' => 'activo'],
            ['nombre' => 'Harinas', 'descripcion' => 'Harinas de trigo, maíz y otros', 'estado' => 'activo'],
        ];

        foreach ($categorias as $categoria) {
            DB::table('categorias')->insert([
                'nombre' => $categoria['nombre'],
                'descripcion' => $categoria['descripcion'],
                'estado' => $categoria['estado'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
