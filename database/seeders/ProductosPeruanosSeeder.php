<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductosPeruanosSeeder extends Seeder
{
    public function run(): void
    {
        $productos = [
            // CARNES (categoria_id: 1)
            ['codigo' => 'CARN-001', 'nombre' => 'Lomo de Res', 'descripcion' => 'Corte fino de res para saltados', 'categoria_id' => 1, 'unidad_medida' => 'kg', 'precio_unitario' => 32.00, 'stock_minimo' => 10],
            ['codigo' => 'CARN-002', 'nombre' => 'Pollo Entero', 'descripcion' => 'Pollo fresco nacional', 'categoria_id' => 1, 'unidad_medida' => 'kg', 'precio_unitario' => 12.50, 'stock_minimo' => 15],
            ['codigo' => 'CARN-003', 'nombre' => 'Carne Molida', 'descripcion' => 'Carne molida especial', 'categoria_id' => 1, 'unidad_medida' => 'kg', 'precio_unitario' => 18.00, 'stock_minimo' => 10],
            ['codigo' => 'CARN-004', 'nombre' => 'Chancho (Cerdo)', 'descripcion' => 'Carne de cerdo para chicharrón', 'categoria_id' => 1, 'unidad_medida' => 'kg', 'precio_unitario' => 22.00, 'stock_minimo' => 8],
            ['codigo' => 'CARN-005', 'nombre' => 'Pato', 'descripcion' => 'Pato fresco para arroz con pato', 'categoria_id' => 1, 'unidad_medida' => 'kg', 'precio_unitario' => 28.00, 'stock_minimo' => 5],

            // PESCADOS Y MARISCOS (categoria_id: 2)
            ['codigo' => 'PESC-001', 'nombre' => 'Corvina', 'descripcion' => 'Pescado fresco para ceviche', 'categoria_id' => 2, 'unidad_medida' => 'kg', 'precio_unitario' => 35.00, 'stock_minimo' => 8],
            ['codigo' => 'PESC-002', 'nombre' => 'Lenguado', 'descripcion' => 'Lenguado fresco', 'categoria_id' => 2, 'unidad_medida' => 'kg', 'precio_unitario' => 45.00, 'stock_minimo' => 5],
            ['codigo' => 'PESC-003', 'nombre' => 'Conchas Negras', 'descripcion' => 'Conchas frescas para ceviche', 'categoria_id' => 2, 'unidad_medida' => 'kg', 'precio_unitario' => 120.00, 'stock_minimo' => 3],
            ['codigo' => 'PESC-004', 'nombre' => 'Langostinos', 'descripcion' => 'Langostinos jumbo', 'categoria_id' => 2, 'unidad_medida' => 'kg', 'precio_unitario' => 85.00, 'stock_minimo' => 5],
            ['codigo' => 'PESC-005', 'nombre' => 'Pulpo', 'descripcion' => 'Pulpo fresco para anticuchos', 'categoria_id' => 2, 'unidad_medida' => 'kg', 'precio_unitario' => 65.00, 'stock_minimo' => 4],
            ['codigo' => 'PESC-006', 'nombre' => 'Calamar', 'descripcion' => 'Calamar fresco', 'categoria_id' => 2, 'unidad_medida' => 'kg', 'precio_unitario' => 28.00, 'stock_minimo' => 6],

            // VERDURAS (categoria_id: 3)
            ['codigo' => 'VERD-001', 'nombre' => 'Cebolla Roja', 'descripcion' => 'Cebolla morada para ceviche', 'categoria_id' => 3, 'unidad_medida' => 'kg', 'precio_unitario' => 3.50, 'stock_minimo' => 20],
            ['codigo' => 'VERD-002', 'nombre' => 'Tomate', 'descripcion' => 'Tomate italiano', 'categoria_id' => 3, 'unidad_medida' => 'kg', 'precio_unitario' => 4.00, 'stock_minimo' => 15],
            ['codigo' => 'VERD-003', 'nombre' => 'Ají Amarillo', 'descripcion' => 'Ají amarillo fresco', 'categoria_id' => 3, 'unidad_medida' => 'kg', 'precio_unitario' => 12.00, 'stock_minimo' => 10],
            ['codigo' => 'VERD-004', 'nombre' => 'Ají Limo', 'descripcion' => 'Ají limo para ceviche', 'categoria_id' => 3, 'unidad_medida' => 'kg', 'precio_unitario' => 15.00, 'stock_minimo' => 5],
            ['codigo' => 'VERD-005', 'nombre' => 'Ají Panca', 'descripcion' => 'Ají panca seco', 'categoria_id' => 3, 'unidad_medida' => 'kg', 'precio_unitario' => 18.00, 'stock_minimo' => 5],
            ['codigo' => 'VERD-006', 'nombre' => 'Pimiento', 'descripcion' => 'Pimientos rojos y verdes', 'categoria_id' => 3, 'unidad_medida' => 'kg', 'precio_unitario' => 5.50, 'stock_minimo' => 10],
            ['codigo' => 'VERD-007', 'nombre' => 'Culantro', 'descripcion' => 'Cilantro fresco en atado', 'categoria_id' => 3, 'unidad_medida' => 'atado', 'precio_unitario' => 1.50, 'stock_minimo' => 30],
            ['codigo' => 'VERD-008', 'nombre' => 'Huacatay', 'descripcion' => 'Hierba aromática peruana', 'categoria_id' => 3, 'unidad_medida' => 'atado', 'precio_unitario' => 2.00, 'stock_minimo' => 20],
            ['codigo' => 'VERD-009', 'nombre' => 'Choclo', 'descripcion' => 'Maíz peruano grande', 'categoria_id' => 3, 'unidad_medida' => 'kg', 'precio_unitario' => 6.00, 'stock_minimo' => 15],
            ['codigo' => 'VERD-010', 'nombre' => 'Zanahoria', 'descripcion' => 'Zanahoria fresca', 'categoria_id' => 3, 'unidad_medida' => 'kg', 'precio_unitario' => 2.80, 'stock_minimo' => 20],

            // FRUTAS (categoria_id: 4)
            ['codigo' => 'FRUT-001', 'nombre' => 'Limón', 'descripcion' => 'Limón verde para ceviche', 'categoria_id' => 4, 'unidad_medida' => 'kg', 'precio_unitario' => 4.50, 'stock_minimo' => 25],
            ['codigo' => 'FRUT-002', 'nombre' => 'Rocoto', 'descripcion' => 'Rocoto fresco', 'categoria_id' => 4, 'unidad_medida' => 'kg', 'precio_unitario' => 8.00, 'stock_minimo' => 8],
            ['codigo' => 'FRUT-003', 'nombre' => 'Aguaymanto', 'descripcion' => 'Fruta exótica peruana', 'categoria_id' => 4, 'unidad_medida' => 'kg', 'precio_unitario' => 12.00, 'stock_minimo' => 5],

            // LÁCTEOS (categoria_id: 5)
            ['codigo' => 'LACT-001', 'nombre' => 'Leche Evaporada', 'descripcion' => 'Leche Gloria entera', 'categoria_id' => 5, 'unidad_medida' => 'lata', 'precio_unitario' => 4.20, 'stock_minimo' => 50],
            ['codigo' => 'LACT-002', 'nombre' => 'Queso Fresco', 'descripcion' => 'Queso fresco artesanal', 'categoria_id' => 5, 'unidad_medida' => 'kg', 'precio_unitario' => 18.00, 'stock_minimo' => 10],
            ['codigo' => 'LACT-003', 'nombre' => 'Mantequilla', 'descripcion' => 'Mantequilla con sal', 'categoria_id' => 5, 'unidad_medida' => 'kg', 'precio_unitario' => 22.00, 'stock_minimo' => 8],

            // ABARROTES (categoria_id: 6)
            ['codigo' => 'ABAR-001', 'nombre' => 'Fideos Spaghetti', 'descripcion' => 'Fideos Don Vittorio', 'categoria_id' => 6, 'unidad_medida' => 'kg', 'precio_unitario' => 6.50, 'stock_minimo' => 30],
            ['codigo' => 'ABAR-002', 'nombre' => 'Azúcar Blanca', 'descripcion' => 'Azúcar rubia', 'categoria_id' => 6, 'unidad_medida' => 'kg', 'precio_unitario' => 3.80, 'stock_minimo' => 40],
            ['codigo' => 'ABAR-003', 'nombre' => 'Sal', 'descripcion' => 'Sal de mesa', 'categoria_id' => 6, 'unidad_medida' => 'kg', 'precio_unitario' => 1.50, 'stock_minimo' => 30],
            ['codigo' => 'ABAR-004', 'nombre' => 'Vinagre Blanco', 'descripcion' => 'Vinagre de alcohol', 'categoria_id' => 6, 'unidad_medida' => 'lt', 'precio_unitario' => 3.20, 'stock_minimo' => 20],
            ['codigo' => 'ABAR-005', 'nombre' => 'Salsa de Soya', 'descripcion' => 'Sillao Soyandina', 'categoria_id' => 6, 'unidad_medida' => 'lt', 'precio_unitario' => 8.50, 'stock_minimo' => 15],

            // CONDIMENTOS (categoria_id: 7)
            ['codigo' => 'COND-001', 'nombre' => 'Comino Molido', 'descripcion' => 'Comino en polvo', 'categoria_id' => 7, 'unidad_medida' => 'kg', 'precio_unitario' => 25.00, 'stock_minimo' => 5],
            ['codigo' => 'COND-002', 'nombre' => 'Pimienta Negra', 'descripcion' => 'Pimienta molida', 'categoria_id' => 7, 'unidad_medida' => 'kg', 'precio_unitario' => 35.00, 'stock_minimo' => 5],
            ['codigo' => 'COND-003', 'nombre' => 'Orégano', 'descripcion' => 'Orégano seco', 'categoria_id' => 7, 'unidad_medida' => 'kg', 'precio_unitario' => 18.00, 'stock_minimo' => 5],
            ['codigo' => 'COND-004', 'nombre' => 'Palillo (Cúrcuma)', 'descripcion' => 'Palillo en polvo', 'categoria_id' => 7, 'unidad_medida' => 'kg', 'precio_unitario' => 22.00, 'stock_minimo' => 5],

            // BEBIDAS (categoria_id: 8)
            ['codigo' => 'BEB-001', 'nombre' => 'Chicha Morada', 'descripcion' => 'Chicha morada preparada', 'categoria_id' => 8, 'unidad_medida' => 'lt', 'precio_unitario' => 3.50, 'stock_minimo' => 20],
            ['codigo' => 'BEB-002', 'nombre' => 'Inca Kola', 'descripcion' => 'Gaseosa nacional 1.5L', 'categoria_id' => 8, 'unidad_medida' => 'botella', 'precio_unitario' => 4.50, 'stock_minimo' => 30],
            ['codigo' => 'BEB-003', 'nombre' => 'Pisco Quebranta', 'descripcion' => 'Pisco puro quebranta', 'categoria_id' => 8, 'unidad_medida' => 'botella', 'precio_unitario' => 45.00, 'stock_minimo' => 10],

            // CEREALES Y GRANOS (categoria_id: 9)
            ['codigo' => 'CER-001', 'nombre' => 'Arroz Superior', 'descripcion' => 'Arroz extra Costeño', 'categoria_id' => 9, 'unidad_medida' => 'kg', 'precio_unitario' => 4.20, 'stock_minimo' => 50],
            ['codigo' => 'CER-002', 'nombre' => 'Quinua', 'descripcion' => 'Quinua blanca peruana', 'categoria_id' => 9, 'unidad_medida' => 'kg', 'precio_unitario' => 15.00, 'stock_minimo' => 15],
            ['codigo' => 'CER-003', 'nombre' => 'Lentejas', 'descripcion' => 'Lentejas importadas', 'categoria_id' => 9, 'unidad_medida' => 'kg', 'precio_unitario' => 8.50, 'stock_minimo' => 20],
            ['codigo' => 'CER-004', 'nombre' => 'Frijol Canario', 'descripcion' => 'Frijol peruano', 'categoria_id' => 9, 'unidad_medida' => 'kg', 'precio_unitario' => 9.00, 'stock_minimo' => 15],

            // ACEITES Y GRASAS (categoria_id: 10)
            ['codigo' => 'ACEI-001', 'nombre' => 'Aceite Vegetal', 'descripcion' => 'Aceite Primor 1L', 'categoria_id' => 10, 'unidad_medida' => 'lt', 'precio_unitario' => 8.50, 'stock_minimo' => 25],
            ['codigo' => 'ACEI-002', 'nombre' => 'Aceite de Oliva', 'descripcion' => 'Aceite extra virgen', 'categoria_id' => 10, 'unidad_medida' => 'lt', 'precio_unitario' => 35.00, 'stock_minimo' => 8],

            // TUBÉRCULOS (categoria_id: 11)
            ['codigo' => 'TUB-001', 'nombre' => 'Papa Blanca', 'descripcion' => 'Papa Huayro', 'categoria_id' => 11, 'unidad_medida' => 'kg', 'precio_unitario' => 2.50, 'stock_minimo' => 50],
            ['codigo' => 'TUB-002', 'nombre' => 'Papa Amarilla', 'descripcion' => 'Papa amarilla Tumbay', 'categoria_id' => 11, 'unidad_medida' => 'kg', 'precio_unitario' => 4.00, 'stock_minimo' => 30],
            ['codigo' => 'TUB-003', 'nombre' => 'Camote', 'descripcion' => 'Camote anaranjado', 'categoria_id' => 11, 'unidad_medida' => 'kg', 'precio_unitario' => 3.20, 'stock_minimo' => 20],
            ['codigo' => 'TUB-004', 'nombre' => 'Yuca', 'descripcion' => 'Yuca fresca', 'categoria_id' => 11, 'unidad_medida' => 'kg', 'precio_unitario' => 2.80, 'stock_minimo' => 25],

            // HARINAS (categoria_id: 12)
            ['codigo' => 'HAR-001', 'nombre' => 'Harina de Trigo', 'descripcion' => 'Harina Nicolini sin preparar', 'categoria_id' => 12, 'unidad_medida' => 'kg', 'precio_unitario' => 3.50, 'stock_minimo' => 30],
            ['codigo' => 'HAR-002', 'nombre' => 'Harina de Maíz', 'descripcion' => 'Harina de maíz morado', 'categoria_id' => 12, 'unidad_medida' => 'kg', 'precio_unitario' => 5.00, 'stock_minimo' => 15],
        ];

        foreach ($productos as $producto) {
            DB::table('productos')->insert([
                'codigo' => $producto['codigo'],
                'nombre' => $producto['nombre'],
                'descripcion' => $producto['descripcion'],
                'categoria_id' => $producto['categoria_id'],
                'unidad_medida' => $producto['unidad_medida'],
                'precio_unitario' => $producto['precio_unitario'],
                'stock_minimo' => $producto['stock_minimo'],
                'estado' => 'activo',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
