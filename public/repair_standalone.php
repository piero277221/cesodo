<!DOCTYPE html>
<html>
<head>
    <title>Reparar Base de Datos</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f5f5f5; }
        .container { max-width: 800px; background: white; padding: 20px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .success { color: green; }
        .error { color: red; }
        .info { color: blue; }
        pre { background: #f0f0f0; padding: 10px; border-radius: 3px; overflow-x: auto; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔧 Reparación de Base de Datos - Módulo Menús</h1>

        <?php
        echo "<div class='info'>Iniciando proceso de reparación...</div><br>";

        // Configuración de conexión
        $host = '127.0.0.1';
        $dbname = 'scm_cesodo';
        $username = 'root';
        $password = '';

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "<div class='success'>✓ Conexión establecida con la base de datos</div>";

            // 1. Crear tabla condiciones_salud
            echo "<h3>Paso 1: Crear tabla condiciones_salud</h3>";
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
            echo "<div class='success'>✓ Tabla condiciones_salud creada exitosamente</div>";

            // 2. Insertar datos de ejemplo
            echo "<h3>Paso 2: Insertar datos de ejemplo</h3>";
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM condiciones_salud");
            $stmt->execute();
            $count = $stmt->fetchColumn();

            if ($count == 0) {
                $stmt = $pdo->prepare("
                    INSERT INTO condiciones_salud (nombre, descripcion, restricciones_alimentarias, activo, created_at, updated_at)
                    VALUES (?, ?, ?, ?, NOW(), NOW())
                ");

                $stmt->execute(['Diabetes', 'Restricción de azúcares y carbohidratos refinados',
                               '["azucar", "dulces", "refrescos"]', 1]);
                $stmt->execute(['Hipertensión', 'Restricción de sodio y alimentos procesados',
                               '["sal", "embutidos", "conservas"]', 1]);
                $stmt->execute(['Intolerancia al gluten', 'Restricción de productos con gluten',
                               '["trigo", "avena", "cebada"]', 1]);

                echo "<div class='success'>✓ Datos de ejemplo insertados (3 condiciones de salud)</div>";
            } else {
                echo "<div class='info'>ℹ Ya existen datos en condiciones_salud ($count registros)</div>";
            }

            // 3. Crear tabla menu_condiciones
            echo "<h3>Paso 3: Crear tabla menu_condiciones</h3>";
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
            echo "<div class='success'>✓ Tabla menu_condiciones creada exitosamente</div>";

            // 4. Verificación final
            echo "<h3>Paso 4: Verificación final</h3>";
            $tables = ['condiciones_salud', 'menu_condiciones'];
            foreach ($tables as $table) {
                $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
                if ($stmt->rowCount() > 0) {
                    echo "<div class='success'>✓ Tabla '$table' existe</div>";
                } else {
                    echo "<div class='error'>✗ ERROR: Tabla '$table' NO existe</div>";
                }
            }

            // Mostrar resumen
            echo "<h3>Resumen de registros:</h3>";
            $stmt = $pdo->query("SELECT COUNT(*) FROM condiciones_salud");
            $count = $stmt->fetchColumn();
            echo "<div class='info'>• condiciones_salud: $count registros</div>";

            $stmt = $pdo->query("SELECT COUNT(*) FROM menu_condiciones");
            $count = $stmt->fetchColumn();
            echo "<div class='info'>• menu_condiciones: $count registros</div>";

            echo "<br><div class='success'><h2>🎉 REPARACIÓN COMPLETADA EXITOSAMENTE</h2></div>";
            echo "<div class='info'>Ahora puedes acceder al módulo de menús sin problemas.</div>";
            echo "<div class='info'><a href='/scm-cesodo/public/menus' style='color: blue; text-decoration: underline;'>Ir al módulo de menús</a></div>";

        } catch (PDOException $e) {
            echo "<div class='error'><h3>❌ ERROR DE BASE DE DATOS</h3>";
            echo "Mensaje: " . htmlspecialchars($e->getMessage()) . "<br>";
            echo "Código: " . $e->getCode() . "</div>";

            echo "<div class='info'><h4>Solución alternativa:</h4>";
            echo "1. Abrir phpMyAdmin<br>";
            echo "2. Seleccionar la base de datos 'scm_cesodo'<br>";
            echo "3. Ejecutar las consultas del archivo 'EJECUTAR_EN_PHPMYADMIN.txt'</div>";

        } catch (Exception $e) {
            echo "<div class='error'><h3>❌ ERROR GENERAL</h3>";
            echo "Mensaje: " . htmlspecialchars($e->getMessage()) . "</div>";
        }
        ?>

        <br>
        <hr>
        <div style="font-size: 12px; color: #666;">
            <strong>Archivo:</strong> repair_standalone.php<br>
            <strong>Fecha:</strong> <?php echo date('Y-m-d H:i:s'); ?>
        </div>
    </div>
</body>
</html>
