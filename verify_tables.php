<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

echo "=== VERIFICANDO Y CREANDO TABLAS ===\n";

// Verificar si la tabla condiciones_salud existe
if (Schema::hasTable('condiciones_salud')) {
    echo "✓ Tabla 'condiciones_salud' ya existe\n";
} else {
    echo "✗ Tabla 'condiciones_salud' NO existe\n";
    echo "Ejecutando migraciones...\n";

    try {
        Artisan::call('migrate');
        echo "✓ Migraciones ejecutadas\n";

        if (Schema::hasTable('condiciones_salud')) {
            echo "✓ Tabla 'condiciones_salud' creada exitosamente\n";
        } else {
            echo "✗ Error: Tabla 'condiciones_salud' aún no existe\n";
        }
    } catch (Exception $e) {
        echo "Error ejecutando migraciones: " . $e->getMessage() . "\n";
    }
}

// Verificar otras tablas relacionadas
$tablas = ['menus', 'menu_items', 'menu_condiciones', 'menu_inventario_usado'];
foreach ($tablas as $tabla) {
    if (Schema::hasTable($tabla)) {
        echo "✓ Tabla '$tabla' existe\n";
    } else {
        echo "✗ Tabla '$tabla' NO existe\n";
    }
}

// Verificar datos en condiciones_salud
if (Schema::hasTable('condiciones_salud')) {
    $count = DB::table('condiciones_salud')->count();
    echo "Registros en condiciones_salud: $count\n";

    if ($count == 0) {
        echo "Insertando datos de ejemplo...\n";
        DB::table('condiciones_salud')->insert([
            [
                'nombre' => 'Diabetes',
                'descripcion' => 'Restricción de azúcares y carbohidratos refinados',
                'restricciones_alimentarias' => json_encode(['azucar', 'dulces', 'refrescos']),
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Hipertensión',
                'descripcion' => 'Restricción de sodio y alimentos procesados',
                'restricciones_alimentarias' => json_encode(['sal', 'embutidos', 'conservas']),
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Intolerancia al gluten',
                'descripcion' => 'Restricción de productos con gluten',
                'restricciones_alimentarias' => json_encode(['trigo', 'avena', 'cebada']),
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        echo "✓ Datos de ejemplo insertados\n";
    }
}

echo "=== VERIFICACIÓN COMPLETADA ===\n";
