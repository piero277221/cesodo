<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== REPARANDO BASE DE DATOS ===\n";

try {
    // Crear tabla condiciones_salud si no existe
    DB::statement("
        CREATE TABLE IF NOT EXISTS `condiciones_salud` (
          `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
          `nombre` varchar(255) NOT NULL,
          `descripcion` text DEFAULT NULL,
          `restricciones_alimentarias` json DEFAULT NULL,
          `activo` tinyint(1) NOT NULL DEFAULT 1,
          `created_at` timestamp NULL DEFAULT NULL,
          `updated_at` timestamp NULL DEFAULT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "✓ Tabla condiciones_salud creada\n";

    // Verificar si los campos existen antes de agregarlos
    $columns = DB::select("SHOW COLUMNS FROM menus");
    $columnNames = array_column($columns, 'Field');

    if (!in_array('nombre', $columnNames)) {
        DB::statement("ALTER TABLE `menus` ADD COLUMN `nombre` varchar(255) DEFAULT NULL AFTER `id`");
        echo "✓ Campo 'nombre' agregado a menus\n";
    }

    if (!in_array('fecha_inicio', $columnNames)) {
        DB::statement("ALTER TABLE `menus` ADD COLUMN `fecha_inicio` date DEFAULT NULL AFTER `nombre`");
        echo "✓ Campo 'fecha_inicio' agregado a menus\n";
    }

    if (!in_array('fecha_fin', $columnNames)) {
        DB::statement("ALTER TABLE `menus` ADD COLUMN `fecha_fin` date DEFAULT NULL AFTER `fecha_inicio`");
        echo "✓ Campo 'fecha_fin' agregado a menus\n";
    }

    if (!in_array('numero_personas', $columnNames)) {
        DB::statement("ALTER TABLE `menus` ADD COLUMN `numero_personas` int(11) DEFAULT 1 AFTER `descripcion`");
        echo "✓ Campo 'numero_personas' agregado a menus\n";
    }

    if (!in_array('porciones_por_persona', $columnNames)) {
        DB::statement("ALTER TABLE `menus` ADD COLUMN `porciones_por_persona` decimal(8,2) DEFAULT 1.00 AFTER `numero_personas`");
        echo "✓ Campo 'porciones_por_persona' agregado a menus\n";
    }

    if (!in_array('user_id', $columnNames)) {
        DB::statement("ALTER TABLE `menus` ADD COLUMN `user_id` bigint(20) unsigned DEFAULT NULL AFTER `estado`");
        echo "✓ Campo 'user_id' agregado a menus\n";
    }

    // Modificar el enum de estado
    DB::statement("ALTER TABLE `menus` MODIFY COLUMN `estado` enum('borrador','activo','preparado','completado') DEFAULT 'borrador'");
    echo "✓ Enum de estado actualizado en menus\n";

    // Verificar y agregar campos a menu_items
    $menuItemColumns = DB::select("SHOW COLUMNS FROM menu_items");
    $menuItemColumnNames = array_column($menuItemColumns, 'Field');

    if (!in_array('dia_semana', $menuItemColumnNames)) {
        DB::statement("ALTER TABLE `menu_items` ADD COLUMN `dia_semana` enum('lunes','martes','miercoles','jueves','viernes','sabado','domingo') DEFAULT NULL AFTER `menu_id`");
        echo "✓ Campo 'dia_semana' agregado a menu_items\n";
    }

    if (!in_array('tipo_comida', $menuItemColumnNames)) {
        DB::statement("ALTER TABLE `menu_items` ADD COLUMN `tipo_comida` enum('desayuno','almuerzo','cena','merienda') DEFAULT NULL AFTER `dia_semana`");
        echo "✓ Campo 'tipo_comida' agregado a menu_items\n";
    }

    if (!in_array('nombre', $menuItemColumnNames)) {
        DB::statement("ALTER TABLE `menu_items` ADD COLUMN `nombre` varchar(255) DEFAULT NULL AFTER `tipo_comida`");
        echo "✓ Campo 'nombre' agregado a menu_items\n";
    }

    // Crear tabla menu_condiciones
    DB::statement("
        CREATE TABLE IF NOT EXISTS `menu_condiciones` (
          `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
          `menu_id` bigint(20) unsigned NOT NULL,
          `condicion_salud_id` bigint(20) unsigned NOT NULL,
          `porciones` int(11) DEFAULT 1,
          `observaciones` text DEFAULT NULL,
          `created_at` timestamp NULL DEFAULT NULL,
          `updated_at` timestamp NULL DEFAULT NULL,
          PRIMARY KEY (`id`),
          UNIQUE KEY `menu_condiciones_menu_id_condicion_salud_id_unique` (`menu_id`,`condicion_salud_id`),
          KEY `menu_condiciones_menu_id_foreign` (`menu_id`),
          KEY `menu_condiciones_condicion_salud_id_foreign` (`condicion_salud_id`),
          CONSTRAINT `menu_condiciones_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE,
          CONSTRAINT `menu_condiciones_condicion_salud_id_foreign` FOREIGN KEY (`condicion_salud_id`) REFERENCES `condiciones_salud` (`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "✓ Tabla menu_condiciones creada\n";

    // Crear tabla menu_inventario_usado
    DB::statement("
        CREATE TABLE IF NOT EXISTS `menu_inventario_usado` (
          `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
          `menu_id` bigint(20) unsigned NOT NULL,
          `producto_id` bigint(20) unsigned NOT NULL,
          `cantidad_total_usada` decimal(10,3) DEFAULT 0.000,
          `cantidad_disponible_antes` decimal(10,3) DEFAULT 0.000,
          `cantidad_disponible_despues` decimal(10,3) DEFAULT 0.000,
          `fecha_uso` timestamp NULL DEFAULT NULL,
          `user_id` bigint(20) unsigned DEFAULT NULL,
          `created_at` timestamp NULL DEFAULT NULL,
          `updated_at` timestamp NULL DEFAULT NULL,
          PRIMARY KEY (`id`),
          KEY `menu_inventario_usado_menu_id_foreign` (`menu_id`),
          KEY `menu_inventario_usado_producto_id_foreign` (`producto_id`),
          KEY `menu_inventario_usado_user_id_foreign` (`user_id`),
          CONSTRAINT `menu_inventario_usado_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE,
          CONSTRAINT `menu_inventario_usado_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE,
          CONSTRAINT `menu_inventario_usado_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "✓ Tabla menu_inventario_usado creada\n";

    // Insertar datos de ejemplo
    $existingCount = DB::table('condiciones_salud')->count();
    if ($existingCount == 0) {
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
        echo "✓ Datos de ejemplo insertados en condiciones_salud\n";
    } else {
        echo "✓ Ya existen datos en condiciones_salud ($existingCount registros)\n";
    }

    echo "=== REPARACIÓN COMPLETADA EXITOSAMENTE ===\n";

} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "Línea: " . $e->getLine() . "\n";
}
