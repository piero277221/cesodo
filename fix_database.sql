-- Crear tabla condiciones_salud si no existe
CREATE TABLE IF NOT EXISTS `condiciones_salud` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `restricciones_alimentarias` json DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Agregar campos a la tabla menus si no existen
ALTER TABLE `menus`
ADD COLUMN IF NOT EXISTS `nombre` varchar(255) DEFAULT NULL AFTER `id`,
ADD COLUMN IF NOT EXISTS `fecha_inicio` date DEFAULT NULL AFTER `nombre`,
ADD COLUMN IF NOT EXISTS `fecha_fin` date DEFAULT NULL AFTER `fecha_inicio`,
ADD COLUMN IF NOT EXISTS `numero_personas` int(11) DEFAULT 1 AFTER `descripcion`,
ADD COLUMN IF NOT EXISTS `porciones_por_persona` decimal(8,2) DEFAULT 1.00 AFTER `numero_personas`,
ADD COLUMN IF NOT EXISTS `user_id` bigint(20) unsigned DEFAULT NULL AFTER `estado`;

-- Modificar el enum de estado en menus
ALTER TABLE `menus` MODIFY COLUMN `estado` enum('borrador','activo','preparado','completado') DEFAULT 'borrador';

-- Agregar campos a menu_items si no existen
ALTER TABLE `menu_items`
ADD COLUMN IF NOT EXISTS `dia_semana` enum('lunes','martes','miercoles','jueves','viernes','sabado','domingo') DEFAULT NULL AFTER `menu_id`,
ADD COLUMN IF NOT EXISTS `tipo_comida` enum('desayuno','almuerzo','cena','merienda') DEFAULT NULL AFTER `dia_semana`,
ADD COLUMN IF NOT EXISTS `nombre` varchar(255) DEFAULT NULL AFTER `tipo_comida`;

-- Crear tabla menu_condiciones si no existe
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Crear tabla menu_inventario_usado si no existe
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar datos de ejemplo en condiciones_salud
INSERT IGNORE INTO `condiciones_salud` (`nombre`, `descripcion`, `restricciones_alimentarias`, `activo`, `created_at`, `updated_at`) VALUES
('Diabetes', 'Restricción de azúcares y carbohidratos refinados', JSON_ARRAY('azucar', 'dulces', 'refrescos'), 1, NOW(), NOW()),
('Hipertensión', 'Restricción de sodio y alimentos procesados', JSON_ARRAY('sal', 'embutidos', 'conservas'), 1, NOW(), NOW()),
('Intolerancia al gluten', 'Restricción de productos con gluten', JSON_ARRAY('trigo', 'avena', 'cebada'), 1, NOW(), NOW());
