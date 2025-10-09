<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Inventario;


class ProductosSeeder extends Seeder
{
    public function run()
    {
        $categorias = [
            'Alimentos Secos' => [
                ['nombre' => 'Arroz', 'precio' => 3.5],
                ['nombre' => 'Fideos (spaghetti, tallarín, cabello de ángel)', 'precio' => 4.0],
                ['nombre' => 'Papas', 'precio' => 2.0],
                ['nombre' => 'Yuca', 'precio' => 2.5],
                ['nombre' => 'Menestras (lentejas, frejoles, pallares, garbanzos)', 'precio' => 5.0],
                ['nombre' => 'Harina de trigo', 'precio' => 3.0],
                ['nombre' => 'Pan', 'precio' => 0.5],
                ['nombre' => 'Aceite vegetal', 'precio' => 8.0],
                ['nombre' => 'Sal', 'precio' => 1.0],
                ['nombre' => 'Azúcar', 'precio' => 2.5],
                ['nombre' => 'Pimienta', 'precio' => 1.5],
                ['nombre' => 'Comino', 'precio' => 1.5],
                ['nombre' => 'Condimentos básicos', 'precio' => 2.0],
                ['nombre' => 'Ajo', 'precio' => 2.0],
                ['nombre' => 'Cebolla', 'precio' => 2.0],
                ['nombre' => 'Tomate', 'precio' => 2.5],
                ['nombre' => 'Zanahoria', 'precio' => 1.5],
                ['nombre' => 'Pimiento', 'precio' => 2.0],
                ['nombre' => 'Verduras de hoja (espinaca, acelga, lechuga, col)', 'precio' => 3.0],
                ['nombre' => 'Frutas (plátano, manzana, naranja, papaya)', 'precio' => 4.0],
                ['nombre' => 'Huevos', 'precio' => 0.4],
                ['nombre' => 'Leche', 'precio' => 3.0],
                ['nombre' => 'Queso', 'precio' => 6.0],
                ['nombre' => 'Mantequilla', 'precio' => 4.0],
                ['nombre' => 'Yogurt', 'precio' => 2.5],
            ],
            'Proteínas' => [
                ['nombre' => 'Pollo entero', 'precio' => 18.0],
                ['nombre' => 'Pechuga de pollo', 'precio' => 12.0],
                ['nombre' => 'Pierna de pollo', 'precio' => 10.0],
                ['nombre' => 'Ala de pollo', 'precio' => 8.0],
                ['nombre' => 'Carne de res (molida, bistec, guiso)', 'precio' => 20.0],
                ['nombre' => 'Carne de cerdo', 'precio' => 16.0],
                ['nombre' => 'Pescado (bonito, jurel, merluza)', 'precio' => 14.0],
                ['nombre' => 'Mariscos', 'precio' => 22.0],
                ['nombre' => 'Embutidos (jamonada, hot dog, chorizo)', 'precio' => 9.0],
            ],
            'Bebidas' => [
                ['nombre' => 'Agua embotellada', 'precio' => 2.0],
                ['nombre' => 'Refrescos concentrados (maracuyá, chicha morada, hierba luisa, camu camu)', 'precio' => 3.0],
                ['nombre' => 'Café', 'precio' => 4.0],
                ['nombre' => 'Té e infusiones', 'precio' => 2.5],
            ],
            'Descartables y Envases' => [
                ['nombre' => 'Envases de plástico, tecnopor o biodegradables', 'precio' => 0.8],
                ['nombre' => 'Vasos descartables', 'precio' => 0.2],
                ['nombre' => 'Cucharas descartables', 'precio' => 0.1],
                ['nombre' => 'Tenedores descartables', 'precio' => 0.1],
                ['nombre' => 'Cuchillos descartables', 'precio' => 0.1],
                ['nombre' => 'Servilletas', 'precio' => 0.3],
                ['nombre' => 'Bolsas plásticas', 'precio' => 0.2],
                ['nombre' => 'Bolsas de papel', 'precio' => 0.3],
            ],
            'Limpieza e Higiene' => [
                ['nombre' => 'Detergente para vajilla', 'precio' => 3.0],
                ['nombre' => 'Desinfectantes (lejía, cloro, amonio cuaternario)', 'precio' => 4.0],
                ['nombre' => 'Jabón líquido antibacterial', 'precio' => 2.5],
                ['nombre' => 'Toallas de papel', 'precio' => 1.5],
                ['nombre' => 'Guantes descartables', 'precio' => 0.5],
                ['nombre' => 'Alcohol en gel', 'precio' => 2.0],
                ['nombre' => 'Bolsas de basura (negras y de colores para segregación)', 'precio' => 0.4],
            ],
            'Otros Esenciales' => [
                ['nombre' => 'Hielo', 'precio' => 1.0],
                ['nombre' => 'Film plástico', 'precio' => 2.0],
                ['nombre' => 'Papel aluminio', 'precio' => 2.5],
                ['nombre' => 'Especias y condimentos variados (orégano, laurel, sillao, ají panca, ají amarillo)', 'precio' => 2.0],
                ['nombre' => 'Panetón', 'precio' => 12.0],
                ['nombre' => 'Galletas', 'precio' => 3.0],
                ['nombre' => 'Snacks', 'precio' => 2.5],
            ],
        ];

        $codigo = 1;
        foreach ($categorias as $catNombre => $productos) {
            // Crear la categoría
            $cat = Categoria::create([
                'nombre' => $catNombre,
                'codigo' => 'CAT' . str_pad($codigo, 3, '0', STR_PAD_LEFT),
                'descripcion' => $catNombre,
                'estado' => 'activo',
            ]);
            foreach ($productos as $prod) {
                $producto = Producto::create([
                    'nombre' => $prod['nombre'],
                    'codigo' => 'PROD' . str_pad($codigo, 4, '0', STR_PAD_LEFT),
                    'categoria_id' => $cat->id,
                    'precio_unitario' => $prod['precio'],
                    'descripcion' => $prod['nombre'],
                    'estado' => 'activo',
                    'unidad_medida' => 'unidad',
                    'stock_minimo' => 5,
                ]);
                Inventario::create([
                    'producto_id' => $producto->id,
                    'stock_actual' => 50,
                    'stock_reservado' => 0,
                    'stock_disponible' => 50,
                    'fecha_ultimo_movimiento' => now()->toDateString()
                ]);
                $codigo++;
            }
        }
        $this->command->info('Productos y categorías creados exitosamente.');
    }
}
