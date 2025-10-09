<?php
// Script para migrar datos existentes

echo "Migrando datos de campos antiguos a nuevos...<br>";

try {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=scm_cesodo;charset=utf8mb4", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verificar si hay datos en los campos antiguos
    $result = $pdo->query("SELECT id, semana_inicio, semana_fin, descripcion FROM menus WHERE semana_inicio IS NOT NULL OR semana_fin IS NOT NULL");
    $oldMenus = $result->fetchAll(PDO::FETCH_ASSOC);

    if (count($oldMenus) > 0) {
        echo "Encontrados " . count($oldMenus) . " menús con datos antiguos<br>";

        foreach ($oldMenus as $menu) {
            $id = $menu['id'];
            $fechaInicio = $menu['semana_inicio'];
            $fechaFin = $menu['semana_fin'];
            $descripcion = $menu['descripcion'];

            // Crear nombre basado en las fechas o usar descripción
            $nombre = !empty($descripcion) ? $descripcion : "Menú Semana " . date('W/Y', strtotime($fechaInicio));

            // Migrar datos
            $stmt = $pdo->prepare("UPDATE menus SET
                nombre = ?,
                fecha_inicio = ?,
                fecha_fin = ?,
                numero_personas = 1,
                porciones_por_persona = 1.00,
                user_id = 1
                WHERE id = ?");

            $stmt->execute([$nombre, $fechaInicio, $fechaFin, $id]);

            echo "✓ Menú ID $id migrado: '$nombre' ($fechaInicio - $fechaFin)<br>";
        }

        echo "<br>✓ Migración completada<br>";
    } else {
        echo "No hay datos para migrar<br>";

        // Crear un menú de ejemplo
        $stmt = $pdo->prepare("INSERT INTO menus (nombre, fecha_inicio, fecha_fin, descripcion, numero_personas, porciones_por_persona, estado, user_id, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");

        $fechaInicio = date('Y-m-d');
        $fechaFin = date('Y-m-d', strtotime('+6 days'));

        $stmt->execute([
            'Menú Semanal Ejemplo',
            $fechaInicio,
            $fechaFin,
            'Menú de ejemplo para probar el sistema',
            10,
            1.5,
            'borrador',
            1
        ]);

        echo "✓ Menú de ejemplo creado<br>";
    }

    // Mostrar datos finales
    $result = $pdo->query("SELECT id, nombre, fecha_inicio, fecha_fin, estado FROM menus");
    $finalMenus = $result->fetchAll(PDO::FETCH_ASSOC);

    echo "<br>Menús finales:<br>";
    foreach ($finalMenus as $menu) {
        echo "- ID: {$menu['id']}, Nombre: {$menu['nombre']}, Fechas: {$menu['fecha_inicio']} - {$menu['fecha_fin']}, Estado: {$menu['estado']}<br>";
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "<br>";
}

echo "<br><strong>Proceso completado</strong>";
?>
