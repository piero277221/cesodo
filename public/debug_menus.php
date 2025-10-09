<?php
// Script de debug para menús

echo "<h2>Debug de Menús</h2>";

try {
    // Probar conexión a base de datos
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=scm_cesodo;charset=utf8mb4", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✓ Conexión a base de datos exitosa<br>";

    // Verificar tabla menus
    $result = $pdo->query("SHOW TABLES LIKE 'menus'");
    if ($result->rowCount() > 0) {
        echo "✓ Tabla 'menus' existe<br>";

        // Verificar estructura de tabla
        $result = $pdo->query("SHOW COLUMNS FROM menus");
        $columns = $result->fetchAll(PDO::FETCH_COLUMN);
        echo "Campos en menus: " . implode(", ", $columns) . "<br>";

        // Contar registros
        $result = $pdo->query("SELECT COUNT(*) FROM menus");
        $count = $result->fetchColumn();
        echo "Registros en menus: $count<br>";

        if ($count > 0) {
            // Mostrar algunos registros
            $result = $pdo->query("SELECT id, nombre, fecha_inicio, fecha_fin, estado FROM menus LIMIT 5");
            $menus = $result->fetchAll(PDO::FETCH_ASSOCzº);
            echo "<br>Primeros 5 menús:<br>";
            foreach ($menus as $menu) {
                echo "- ID: {$menu['id']}, Nombre: {$menu['nombre']}, Estado: {$menu['estado']}<br>";
            }
        }
    } else {
        echo "❌ Tabla 'menus' NO existe<br>";
    }

    // Verificar tabla users
    $result = $pdo->query("SHOW TABLES LIKE 'users'");
    if ($result->rowCount() > 0) {
        echo "✓ Tabla 'users' existe<br>";
    } else {
        echo "❌ Tabla 'users' NO existe<br>";
    }

    // Verificar tabla menu_items
    $result = $pdo->query("SHOW TABLES LIKE 'menu_items'");
    if ($result->rowCount() > 0) {
        echo "✓ Tabla 'menu_items' existe<br>";
    } else {
        echo "❌ Tabla 'menu_items' NO existe<br>";
    }

} catch (PDOException $e) {
    echo "❌ Error de base de datos: " . $e->getMessage() . "<br>";
}

// Verificar archivos Laravel
echo "<br><h3>Verificación de archivos Laravel:</h3>";

$files = [
    '../app/Http/Controllers/MenuController.php',
    '../resources/views/menus/index.blade.php',
    '../app/Models/Menu.php',
    '../routes/web.php'
];

foreach ($files as $file) {
    if (file_exists($file)) {
        echo "✓ $file existe<br>";
    } else {
        echo "❌ $file NO existe<br>";
    }
}

// Verificar permisos
echo "<br><h3>Verificación de permisos:</h3>";
$dirs = ['../storage/logs', '../storage/framework', '../storage/app'];
foreach ($dirs as $dir) {
    if (is_writable($dir)) {
        echo "✓ $dir es escribible<br>";
    } else {
        echo "❌ $dir NO es escribible<br>";
    }
}

echo "<br><strong>Debug completado</strong>";
?>
