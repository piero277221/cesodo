-- Crear categoria si no existe
INSERT IGNORE INTO categorias (nombre, descripcion, codigo, estado, created_at, updated_at) VALUES
('Alimentos', 'Productos alimenticios', 'ALI', 'activo', NOW(), NOW());

-- Obtener el ID de la categoria
SET @categoria_id = (SELECT id FROM categorias WHERE codigo = 'ALI' LIMIT 1);

-- Crear productos adicionales
INSERT IGNORE INTO productos (nombre, codigo, descripcion, categoria_id, unidad_medida, precio_unitario, stock_minimo, estado, created_at, updated_at) VALUES
('Arroz Extra', 'ARR001', 'Arroz extra de primera calidad', @categoria_id, 'kg', 3.50, 50, 'activo', NOW(), NOW()),
('Aceite Vegetal', 'ACE001', 'Aceite vegetal 1 litro', @categoria_id, 'l', 8.50, 20, 'activo', NOW(), NOW()),
('Azúcar Blanca', 'AZU001', 'Azúcar blanca refinada', @categoria_id, 'kg', 2.80, 30, 'activo', NOW(), NOW());
