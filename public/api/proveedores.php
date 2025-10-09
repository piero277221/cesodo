<?php
// API simple para proveedores
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

try {
    // Conectar a la base de datos
    $db = new PDO('sqlite:' . __DIR__ . '/../database/database.sqlite');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consultar proveedores activos
    $sql = "SELECT id, nombre FROM proveedores WHERE estado = 'activo' ORDER BY nombre";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $proveedores = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($proveedores);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error al cargar proveedores: ' . $e->getMessage()]);
}
?>
