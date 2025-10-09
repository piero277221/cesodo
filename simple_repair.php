<?php
// Script simple para crear las tablas
echo "Conectando a la base de datos...\n";

$mysqli = new mysqli("127.0.0.1", "root", "", "scm_cesodo");

if ($mysqli->connect_error) {
    die("Error de conexión: " . $mysqli->connect_error);
}

echo "Conexión exitosa.\n";

// 1. Crear tabla condiciones_salud
echo "Creando tabla condiciones_salud...\n";
$sql = "CREATE TABLE IF NOT EXISTS `condiciones_salud` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `restricciones_alimentarias` json DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

if ($mysqli->query($sql)) {
    echo "✓ Tabla condiciones_salud creada\n";
} else {
    echo "Error: " . $mysqli->error . "\n";
}

// 2. Insertar datos de ejemplo
echo "Insertando datos de ejemplo...\n";
$sql = "INSERT IGNORE INTO `condiciones_salud` (`nombre`, `descripcion`, `restricciones_alimentarias`, `activo`, `created_at`, `updated_at`) VALUES
('Diabetes', 'Restricción de azúcares y carbohidratos refinados', '[\"azucar\", \"dulces\", \"refrescos\"]', 1, NOW(), NOW()),
('Hipertensión', 'Restricción de sodio y alimentos procesados', '[\"sal\", \"embutidos\", \"conservas\"]', 1, NOW(), NOW()),
('Intolerancia al gluten', 'Restricción de productos con gluten', '[\"trigo\", \"avena\", \"cebada\"]', 1, NOW(), NOW())";

if ($mysqli->query($sql)) {
    echo "✓ Datos insertados\n";
} else {
    echo "Error: " . $mysqli->error . "\n";
}

// 3. Crear tabla menu_condiciones
echo "Creando tabla menu_condiciones...\n";
$sql = "CREATE TABLE IF NOT EXISTS `menu_condiciones` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

if ($mysqli->query($sql)) {
    echo "✓ Tabla menu_condiciones creada\n";
} else {
    echo "Error: " . $mysqli->error . "\n";
}

// Verificar que las tablas existen
echo "\nVerificando tablas...\n";
$result = $mysqli->query("SHOW TABLES LIKE 'condiciones_salud'");
if ($result->num_rows > 0) {
    echo "✓ Tabla condiciones_salud existe\n";
} else {
    echo "✗ Tabla condiciones_salud NO existe\n";
}

$result = $mysqli->query("SHOW TABLES LIKE 'menu_condiciones'");
if ($result->num_rows > 0) {
    echo "✓ Tabla menu_condiciones existe\n";
} else {
    echo "✗ Tabla menu_condiciones NO existe\n";
}

// Contar registros
$result = $mysqli->query("SELECT COUNT(*) as count FROM condiciones_salud");
$row = $result->fetch_assoc();
echo "Registros en condiciones_salud: " . $row['count'] . "\n";

echo "\n=== PROCESO COMPLETADO ===\n";
$mysqli->close();
?>
