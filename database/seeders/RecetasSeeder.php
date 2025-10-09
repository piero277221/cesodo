<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RecetasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = \App\Models\User::first();

        if (!$user) {
            $user = \App\Models\User::create([
                'name' => 'Administrador',
                'email' => 'admin@cesodo.com',
                'password' => bcrypt('admin123'),
                'email_verified_at' => now(),
            ]);
        }

        // Verificar si hay productos disponibles
        $productos = \App\Models\Producto::take(10)->get();

        if ($productos->isEmpty()) {
            // Crear algunos productos básicos para las recetas
            $productosBasicos = [
                ['nombre' => 'Arroz', 'descripcion' => 'Arroz blanco'],
                ['nombre' => 'Pollo', 'descripcion' => 'Pollo fresco'],
                ['nombre' => 'Cebolla', 'descripcion' => 'Cebolla blanca'],
                ['nombre' => 'Tomate', 'descripcion' => 'Tomate fresco'],
                ['nombre' => 'Aceite', 'descripcion' => 'Aceite vegetal'],
                ['nombre' => 'Sal', 'descripcion' => 'Sal de mesa'],
                ['nombre' => 'Ajo', 'descripcion' => 'Ajo fresco'],
                ['nombre' => 'Papa', 'descripcion' => 'Papa blanca'],
                ['nombre' => 'Carne de Res', 'descripcion' => 'Carne de res fresca'],
                ['nombre' => 'Pescado', 'descripcion' => 'Pescado fresco']
            ];

            foreach ($productosBasicos as $producto) {
                $productos[] = \App\Models\Producto::create([
                    'nombre' => $producto['nombre'],
                    'descripcion' => $producto['descripcion'],
                    'codigo' => 'PROD' . rand(1000, 9999),
                    'precio' => rand(10, 100) / 10, // Precio entre 1.0 y 10.0
                    'estado' => 'activo'
                ]);
            }
        }

        // Crear recetas de ejemplo
        $recetas = [
            [
                'nombre' => 'Arroz con Pollo',
                'descripcion' => 'Delicioso arroz con pollo al estilo peruano',
                'pasos_preparacion' => [
                    'Cortar el pollo en presas medianas',
                    'Sofreír la cebolla y ajo en aceite',
                    'Agregar el pollo y dorar',
                    'Añadir el arroz y revolver',
                    'Agregar agua caliente y condimentos',
                    'Cocinar hasta que el arroz esté listo'
                ],
                'tipo_plato' => 'plato_principal',
                'porciones' => 4,
                'tiempo_preparacion' => 45,
                'dificultad' => 'intermedio',
                'es_especial' => false,
                'estado' => 'activo',
                'costo_aproximado' => 15.00,
                'created_by' => $user->id,
                'ingredientes' => [
                    ['producto' => 'Arroz', 'cantidad' => 2, 'unidad' => 'tazas', 'principal' => true],
                    ['producto' => 'Pollo', 'cantidad' => 500, 'unidad' => 'gramos', 'principal' => true],
                    ['producto' => 'Cebolla', 'cantidad' => 1, 'unidad' => 'unidades', 'principal' => false],
                    ['producto' => 'Ajo', 'cantidad' => 3, 'unidad' => 'dientes', 'principal' => false],
                    ['producto' => 'Aceite', 'cantidad' => 3, 'unidad' => 'cucharadas', 'principal' => false]
                ]
            ],
            [
                'nombre' => 'Lomo Saltado',
                'descripcion' => 'Plato típico peruano con carne, papas y verduras',
                'pasos_preparacion' => [
                    'Cortar la carne en tiras',
                    'Cortar las papas y freír',
                    'Saltear la carne a fuego alto',
                    'Agregar cebolla y tomate',
                    'Mezclar con las papas fritas',
                    'Servir con arroz'
                ],
                'tipo_plato' => 'plato_principal',
                'porciones' => 3,
                'tiempo_preparacion' => 30,
                'dificultad' => 'intermedio',
                'es_especial' => false,
                'estado' => 'activo',
                'costo_aproximado' => 18.00,
                'created_by' => $user->id,
                'ingredientes' => [
                    ['producto' => 'Carne de Res', 'cantidad' => 400, 'unidad' => 'gramos', 'principal' => true],
                    ['producto' => 'Papa', 'cantidad' => 3, 'unidad' => 'unidades', 'principal' => true],
                    ['producto' => 'Cebolla', 'cantidad' => 1, 'unidad' => 'unidades', 'principal' => false],
                    ['producto' => 'Tomate', 'cantidad' => 2, 'unidad' => 'unidades', 'principal' => false],
                    ['producto' => 'Aceite', 'cantidad' => 4, 'unidad' => 'cucharadas', 'principal' => false]
                ]
            ],
            [
                'nombre' => 'Ceviche de Pescado',
                'descripcion' => 'Ceviche fresco con pescado del día',
                'pasos_preparacion' => [
                    'Cortar el pescado en cubos',
                    'Agregar jugo de limón',
                    'Picar cebolla en juliana',
                    'Mezclar pescado con cebolla',
                    'Condimentar con sal y ají',
                    'Dejar reposar 15 minutos'
                ],
                'tipo_plato' => 'entrada',
                'porciones' => 4,
                'tiempo_preparacion' => 20,
                'dificultad' => 'facil',
                'es_especial' => true,
                'estado' => 'activo',
                'costo_aproximado' => 12.00,
                'created_by' => $user->id,
                'ingredientes' => [
                    ['producto' => 'Pescado', 'cantidad' => 500, 'unidad' => 'gramos', 'principal' => true],
                    ['producto' => 'Cebolla', 'cantidad' => 1, 'unidad' => 'unidades', 'principal' => false]
                ]
            ],
            [
                'nombre' => 'Ensalada Verde',
                'descripcion' => 'Ensalada fresca de verduras',
                'pasos_preparacion' => [
                    'Lavar las verduras',
                    'Cortar el tomate en rodajas',
                    'Picar la cebolla',
                    'Mezclar todo en un bowl',
                    'Aliñar con aceite y sal'
                ],
                'tipo_plato' => 'ensalada',
                'porciones' => 2,
                'tiempo_preparacion' => 10,
                'dificultad' => 'facil',
                'es_especial' => false,
                'estado' => 'activo',
                'costo_aproximado' => 5.00,
                'created_by' => $user->id,
                'ingredientes' => [
                    ['producto' => 'Tomate', 'cantidad' => 2, 'unidad' => 'unidades', 'principal' => true],
                    ['producto' => 'Cebolla', 'cantidad' => 0.5, 'unidad' => 'unidades', 'principal' => false],
                    ['producto' => 'Aceite', 'cantidad' => 1, 'unidad' => 'cucharadas', 'principal' => false]
                ]
            ]
        ];

        foreach ($recetas as $recetaData) {
            $ingredientes = $recetaData['ingredientes'];
            unset($recetaData['ingredientes']);

            $receta = \App\Models\Receta::create($recetaData);

            // Crear los ingredientes de la receta
            foreach ($ingredientes as $ingredienteData) {
                $producto = $productos->firstWhere('nombre', $ingredienteData['producto']);

                if ($producto) {
                    \App\Models\RecetaIngrediente::create([
                        'receta_id' => $receta->id,
                        'producto_id' => $producto->id,
                        'cantidad' => $ingredienteData['cantidad'],
                        'unidad_medida' => $ingredienteData['unidad'],
                        'es_principal' => $ingredienteData['principal']
                    ]);
                }
            }
        }

        $this->command->info('Se han creado ' . count($recetas) . ' recetas de ejemplo.');
    }
}
