<?php

echo "=== INICIANDO REPARACIÓN DE BASE DE DATOS ===\n";

// Configuración de conexión directa a MySQL
$host = '127.0.0.1';
$dbname = 'scm_cesodo';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✓ Conexión establecida con la base de datos\n";

    // 1. Crear tabla condiciones_salud
    echo "Creando tabla condiciones_salud...\n";
    $sql = "
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
    ";
    $pdo->exec($sql);
    echo "✓ Tabla condiciones_salud creada\n";

    // 2. Verificar estructura de tabla menus
    echo "Verificando estructura de tabla menus...\n";
    $result = $pdo->query("SHOW COLUMNS FROM menus");
    $columns = $result->fetchAll(PDO::FETCH_COLUMN);

    // Agregar campos faltantes
    if (!in_array('nombre', $columns)) {
        $pdo->exec("ALTER TABLE `menus` ADD COLUMN `nombre` varchar(255) DEFAULT NULL AFTER `id`");
        echo "✓ Campo 'nombre' agregado a menus\n";
    }

    if (!in_array('fecha_inicio', $columns)) {
        $pdo->exec("ALTER TABLE `menus` ADD COLUMN `fecha_inicio` date DEFAULT NULL AFTER `nombre`");
        echo "✓ Campo 'fecha_inicio' agregado a menus\n";
    }

    if (!in_array('fecha_fin', $columns)) {
        $pdo->exec("ALTER TABLE `menus` ADD COLUMN `fecha_fin` date DEFAULT NULL AFTER `fecha_inicio`");
        echo "✓ Campo 'fecha_fin' agregado a menus\n";
    }

    if (!in_array('numero_personas', $columns)) {
        $pdo->exec("ALTER TABLE `menus` ADD COLUMN `numero_personas` int(11) DEFAULT 1 AFTER `descripcion`");
        echo "✓ Campo 'numero_personas' agregado a menus\n";
    }

    if (!in_array('porciones_por_persona', $columns)) {
        $pdo->exec("ALTER TABLE `menus` ADD COLUMN `porciones_por_persona` decimal(8,2) DEFAULT 1.00 AFTER `numero_personas`");
        echo "✓ Campo 'porciones_por_persona' agregado a menus\n";
    }

    if (!in_array('user_id', $columns)) {
        $pdo->exec("ALTER TABLE `menus` ADD COLUMN `user_id` bigint(20) unsigned DEFAULT NULL AFTER `estado`");
        echo "✓ Campo 'user_id' agregado a menus\n";
    }

    // 3. Actualizar enum de estado
    echo "Actualizando enum de estado...\n";
    $pdo->exec("ALTER TABLE `menus` MODIFY COLUMN `estado` enum('borrador','activo','preparado','completado') DEFAULT 'borrador'");
    echo "✓ Enum de estado actualizado\n";

    // 4. Verificar estructura de menu_items
    echo "Verificando estructura de menu_items...\n";
    $result = $pdo->query("SHOW COLUMNS FROM menu_items");
    $menuItemColumns = $result->fetchAll(PDO::FETCH_COLUMN);

    if (!in_array('dia_semana', $menuItemColumns)) {
        $pdo->exec("ALTER TABLE `menu_items` ADD COLUMN `dia_semana` enum('lunes','martes','miercoles','jueves','viernes','sabado','domingo') DEFAULT NULL AFTER `menu_id`");
        echo "✓ Campo 'dia_semana' agregado a menu_items\n";
    }

    if (!in_array('tipo_comida', $menuItemColumns)) {
        $pdo->exec("ALTER TABLE `menu_items` ADD COLUMN `tipo_comida` enum('desayuno','almuerzo','cena','merienda') DEFAULT NULL AFTER `dia_semana`");
        echo "✓ Campo 'tipo_comida' agregado a menu_items\n";
    }

    if (!in_array('nombre', $menuItemColumns)) {
        $pdo->exec("ALTER TABLE `menu_items` ADD COLUMN `nombre` varchar(255) DEFAULT NULL AFTER `tipo_comida`");
        echo "✓ Campo 'nombre' agregado a menu_items\n";
    }

    // 5. Crear tabla menu_condiciones
    echo "Creando tabla menu_condiciones...\n";
    $sql = "
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
    ";
    $pdo->exec($sql);
    echo "✓ Tabla menu_condiciones creada\n";

    // 6. Crear tabla menu_inventario_usado
    echo "Creando tabla menu_inventario_usado...\n";
    $sql = "
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
    ";
    $pdo->exec($sql);
    echo "✓ Tabla menu_inventario_usado creada\n";

    // 7. Insertar datos de ejemplo
    echo "Insertando datos de ejemplo...\n";
    $stmt = $pdo->query("SELECT COUNT(*) FROM condiciones_salud");
    $count = $stmt->fetchColumn();

    if ($count == 0) {
        $stmt = $pdo->prepare("
            INSERT INTO condiciones_salud (nombre, descripcion, restricciones_alimentarias, activo, created_at, updated_at)
            VALUES (?, ?, ?, ?, NOW(), NOW())
        ");

        $stmt->execute(['Diabetes', 'Restricción de azúcares y carbohidratos refinados',
                       json_encode(['azucar', 'dulces', 'refrescos']), 1]);
        $stmt->execute(['Hipertensión', 'Restricción de sodio y alimentos procesados',
                       json_encode(['sal', 'embutidos', 'conservas']), 1]);
        $stmt->execute(['Intolerancia al gluten', 'Restricción de productos con gluten',
                       json_encode(['trigo', 'avena', 'cebada']), 1]);

        echo "✓ Datos de ejemplo insertados (3 condiciones de salud)\n";
    } else {
        echo "✓ Ya existen datos en condiciones_salud ($count registros)\n";
    }

    // 8. Verificar que todo esté correcto
    echo "Verificando tablas creadas...\n";
    $tables = ['condiciones_salud', 'menu_condiciones', 'menu_inventario_usado'];
    foreach ($tables as $table) {
        $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
        if ($stmt->rowCount() > 0) {
            echo "✓ Tabla '$table' existe\n";
        } else {
            echo "✗ ERROR: Tabla '$table' NO existe\n";
        }
    }

    echo "\n=== REPARACIÓN COMPLETADA EXITOSAMENTE ===\n";
    echo "Ahora puedes acceder al módulo de menús sin problemas.\n";

} catch (PDOException $e) {
    echo "ERROR DE BASE DE DATOS: " . $e->getMessage() . "\n";
    echo "Línea: " . $e->getLine() . "\n";
} catch (Exception $e) {
    echo "ERROR GENERAL: " . $e->getMessage() . "\n";
    echo "Línea: " . $e->getLine() . "\n";
}
