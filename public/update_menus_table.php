<?php
// Script para agregar campos faltantes a la tabla menus

echo "Agregando campos faltantes a la tabla menus...<br>";

try {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=scm_cesodo;charset=utf8mb4", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verificar qué campos existen
    $result = $pdo->query("SHOW COLUMNS FROM menus");
    $columns = $result->fetchAll(PDO::FETCH_COLUMN);

    echo "Campos actuales en menus: " . implode(", ", $columns) . "<br><br>";

    // Agregar campos uno por uno si no existen
    if (!in_array('nombre', $columns)) {
        $pdo->exec("ALTER TABLE `menus` ADD COLUMN `nombre` varchar(255) DEFAULT NULL AFTER `id`");
        echo "✓ Campo 'nombre' agregado<br>";
    } else {
        echo "• Campo 'nombre' ya existe<br>";
    }

    if (!in_array('fecha_inicio', $columns)) {
        $pdo->exec("ALTER TABLE `menus` ADD COLUMN `fecha_inicio` date DEFAULT NULL AFTER `nombre`");
        echo "✓ Campo 'fecha_inicio' agregado<br>";
    } else {
        echo "• Campo 'fecha_inicio' ya existe<br>";
    }

    if (!in_array('fecha_fin', $columns)) {
        $pdo->exec("ALTER TABLE `menus` ADD COLUMN `fecha_fin` date DEFAULT NULL AFTER `fecha_inicio`");
        echo "✓ Campo 'fecha_fin' agregado<br>";
    } else {
        echo "• Campo 'fecha_fin' ya existe<br>";
    }

    if (!in_array('numero_personas', $columns)) {
        $pdo->exec("ALTER TABLE `menus` ADD COLUMN `numero_personas` int(11) DEFAULT 1 AFTER `descripcion`");
        echo "✓ Campo 'numero_personas' agregado<br>";
    } else {
        echo "• Campo 'numero_personas' ya existe<br>";
    }

    if (!in_array('porciones_por_persona', $columns)) {
        $pdo->exec("ALTER TABLE `menus` ADD COLUMN `porciones_por_persona` decimal(8,2) DEFAULT 1.00 AFTER `numero_personas`");
        echo "✓ Campo 'porciones_por_persona' agregado<br>";
    } else {
        echo "• Campo 'porciones_por_persona' ya existe<br>";
    }

    if (!in_array('user_id', $columns)) {
        $pdo->exec("ALTER TABLE `menus` ADD COLUMN `user_id` bigint(20) unsigned DEFAULT NULL AFTER `estado`");
        echo "✓ Campo 'user_id' agregado<br>";
    } else {
        echo "• Campo 'user_id' ya existe<br>";
    }

    // Modificar el enum de estado
    $pdo->exec("ALTER TABLE `menus` MODIFY COLUMN `estado` enum('borrador','activo','preparado','completado') DEFAULT 'borrador'");
    echo "✓ Enum de estado actualizado<br>";

    // Verificar campos finales
    $result = $pdo->query("SHOW COLUMNS FROM menus");
    $finalColumns = $result->fetchAll(PDO::FETCH_COLUMN);

    echo "<br>Campos finales en menus: " . implode(", ", $finalColumns) . "<br>";
    echo "<br><strong>✓ Actualización de tabla menus completada</strong><br>";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "<br>";
}
?>
