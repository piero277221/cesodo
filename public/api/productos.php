<?php
// API simple para productos
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

try {
    // Conectar a la base de datos
    $db = new PDO('sqlite:' . __DIR__ . '/../database/database.sqlite');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consultar productos activos
    $sql = "SELECT id, nombre, precio FROM productos WHERE estado = 'activo' ORDER BY nombre";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($productos);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error al cargar productos: ' . $e->getMessage()]);
}
?>
