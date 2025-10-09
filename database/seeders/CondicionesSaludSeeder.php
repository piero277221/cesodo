<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CondicionSalud;

class CondicionesSaludSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $condiciones = [
            [
                'nombre' => 'Diabetes',
                'descripcion' => 'Restricciones para personas con diabetes mellitus',
                'restricciones_alimentarias' => json_encode([
                    'evitar' => ['azúcar refinada', 'dulces', 'bebidas azucaradas'],
                    'preferir' => ['alimentos integrales', 'verduras', 'proteínas magras']
                ]),
                'activo' => true
            ],
            [
                'nombre' => 'Hipertensión',
                'descripcion' => 'Restricciones para personas con presión arterial alta',
                'restricciones_alimentarias' => json_encode([
                    'evitar' => ['sal en exceso', 'alimentos procesados', 'embutidos'],
                    'preferir' => ['frutas', 'verduras', 'granos enteros']
                ]),
                'activo' => true
            ],
            [
                'nombre' => 'Intolerancia al Gluten',
                'descripcion' => 'Para personas con celiaquía o sensibilidad al gluten',
                'restricciones_alimentarias' => json_encode([
                    'evitar' => ['trigo', 'cebada', 'centeno', 'avena contaminada'],
                    'preferir' => ['arroz', 'quinoa', 'maíz', 'frutas y verduras']
                ]),
                'activo' => true
            ],
            [
                'nombre' => 'Intolerancia a la Lactosa',
                'descripcion' => 'Para personas que no pueden digerir la lactosa',
                'restricciones_alimentarias' => json_encode([
                    'evitar' => ['leche', 'quesos frescos', 'helados', 'cremas'],
                    'preferir' => ['leches vegetales', 'quesos madurados', 'yogurt sin lactosa']
                ]),
                'activo' => true
            ],
            [
                'nombre' => 'Enfermedad Renal',
                'descripcion' => 'Restricciones para personas con problemas renales',
                'restricciones_alimentarias' => json_encode([
                    'evitar' => ['exceso de proteínas', 'potasio alto', 'fósforo'],
                    'preferir' => ['control de líquidos', 'proteínas de calidad', 'carbohidratos complejos']
                ]),
                'activo' => true
            ],
            [
                'nombre' => 'Colesterol Alto',
                'descripcion' => 'Para personas con hipercolesterolemia',
                'restricciones_alimentarias' => json_encode([
                    'evitar' => ['grasas saturadas', 'grasas trans', 'colesterol dietético'],
                    'preferir' => ['grasas insaturadas', 'fibra soluble', 'esteroles vegetales']
                ]),
                'activo' => true
            ]
        ];

        foreach ($condiciones as $condicion) {
            CondicionSalud::create($condicion);
        }

        echo "Se han creado " . count($condiciones) . " condiciones de salud de ejemplo.\n";
    }
}
