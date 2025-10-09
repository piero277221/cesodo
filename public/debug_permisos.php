<?php
// Script para verificar permisos de usuario

session_start();

echo "<h2>Verificación de Permisos de Usuario</h2>";

try {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=scm_cesodo;charset=utf8mb4", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verificar sesión
    if (isset($_SESSION['auth']) || isset($_COOKIE['laravel_session'])) {
        echo "✓ Hay sesión activa<br>";
    } else {
        echo "❌ No hay sesión activa<br>";
    }

    // Verificar tabla de permisos
    $result = $pdo->query("SHOW TABLES LIKE 'permissions'");
    if ($result->rowCount() > 0) {
        echo "✓ Tabla 'permissions' existe<br>";

        // Buscar permiso ver-inventario
        $stmt = $pdo->prepare("SELECT * FROM permissions WHERE name = 'ver-inventario'");
        $stmt->execute();
        $permission = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($permission) {
            echo "✓ Permiso 'ver-inventario' existe (ID: {$permission['id']})<br>";
        } else {
            echo "❌ Permiso 'ver-inventario' NO existe<br>";

            // Crear el permiso si no existe
            $stmt = $pdo->prepare("INSERT INTO permissions (name, guard_name, created_at, updated_at) VALUES ('ver-inventario', 'web', NOW(), NOW())");
            $stmt->execute();
            echo "✓ Permiso 'ver-inventario' creado<br>";
        }
    } else {
        echo "❌ Tabla 'permissions' NO existe<br>";
    }

    // Verificar tabla de usuarios
    $result = $pdo->query("SHOW TABLES LIKE 'users'");
    if ($result->rowCount() > 0) {
        echo "✓ Tabla 'users' existe<br>";

        $result = $pdo->query("SELECT COUNT(*) FROM users");
        $count = $result->fetchColumn();
        echo "Usuarios registrados: $count<br>";

        if ($count > 0) {
            // Mostrar primer usuario
            $result = $pdo->query("SELECT id, name, email FROM users LIMIT 1");
            $user = $result->fetch(PDO::FETCH_ASSOC);
            echo "Primer usuario: {$user['name']} ({$user['email']})<br>";
        }
    } else {
        echo "❌ Tabla 'users' NO existe<br>";
    }

    // Verificar tabla model_has_permissions
    $result = $pdo->query("SHOW TABLES LIKE 'model_has_permissions'");
    if ($result->rowCount() > 0) {
        echo "✓ Tabla 'model_has_permissions' existe<br>";

        $result = $pdo->query("SELECT COUNT(*) FROM model_has_permissions");
        $count = $result->fetchColumn();
        echo "Asignaciones de permisos: $count<br>";
    } else {
        echo "❌ Tabla 'model_has_permissions' NO existe<br>";
    }

} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}

echo "<br><strong>Verificación de permisos completada</strong>";
?>
