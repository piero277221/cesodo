<?php
// API simple para pedidos
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

try {
    // Conectar a la base de datos
    $db = new PDO('sqlite:' . __DIR__ . '/../database/database.sqlite');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consultar pedidos con proveedores
    $sql = "
        SELECT
            p.id,
            p.numero_pedido,
            p.fecha_pedido,
            p.estado,
            p.total,
            pr.nombre as proveedor_nombre
        FROM pedidos p
        LEFT JOIN proveedores pr ON p.proveedor_id = pr.id
        ORDER BY p.created_at DESC
        LIMIT 50
    ";

    $stmt = $db->prepare($sql);
    $stmt->execute();
    $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Formatear datos
    $result = [];
    foreach ($pedidos as $pedido) {
        $result[] = [
            'id' => $pedido['id'],
            'numero_pedido' => $pedido['numero_pedido'],
            'proveedor' => $pedido['proveedor_nombre'] ?? 'Sin proveedor',
            'fecha_pedido' => date('d/m/Y', strtotime($pedido['fecha_pedido'])),
            'estado' => ucfirst($pedido['estado']),
            'total' => number_format($pedido['total'], 2)
        ];
    }

    echo json_encode($result);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error al cargar pedidos: ' . $e->getMessage()]);
}
?>
