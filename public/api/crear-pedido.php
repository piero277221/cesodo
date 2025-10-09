<?php
// API para crear pedidos
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
    exit;
}

try {
    // Obtener datos JSON
    $input = json_decode(file_get_contents('php://input'), true);

    if (!$input) {
        throw new Exception('Datos inválidos');
    }

    // Validar datos requeridos
    if (!isset($input['proveedor_id']) || !isset($input['fecha_pedido']) || !isset($input['productos']) || empty($input['productos'])) {
        throw new Exception('Faltan datos requeridos');
    }

    // Conectar a la base de datos
    $db = new PDO('sqlite:' . __DIR__ . '/../database/database.sqlite');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Iniciar transacción
    $db->beginTransaction();

    // Generar número de pedido
    $stmt = $db->query("SELECT COUNT(*) + 1 as next_num FROM pedidos");
    $result = $stmt->fetch();
    $numero_pedido = 'PED-' . date('Y') . '-' . str_pad($result['next_num'], 4, '0', STR_PAD_LEFT);

    // Calcular total
    $total = 0;
    foreach ($input['productos'] as $producto) {
        $total += $producto['cantidad'] * $producto['precio_unitario'];
    }

    // Insertar pedido
    $sql = "INSERT INTO pedidos (numero_pedido, proveedor_id, fecha_pedido, estado, total, observaciones, created_at, updated_at)
            VALUES (?, ?, ?, 'pendiente', ?, ?, datetime('now'), datetime('now'))";
    $stmt = $db->prepare($sql);
    $stmt->execute([
        $numero_pedido,
        $input['proveedor_id'],
        $input['fecha_pedido'],
        $total,
        $input['observaciones'] ?? null
    ]);

    $pedido_id = $db->lastInsertId();

    // Insertar detalles del pedido
    $sql = "INSERT INTO detalle_pedidos (pedido_id, producto_id, cantidad, precio_unitario, subtotal, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, datetime('now'), datetime('now'))";
    $stmt = $db->prepare($sql);

    foreach ($input['productos'] as $producto) {
        $subtotal = $producto['cantidad'] * $producto['precio_unitario'];
        $stmt->execute([
            $pedido_id,
            $producto['producto_id'],
            $producto['cantidad'],
            $producto['precio_unitario'],
            $subtotal
        ]);
    }

    // Confirmar transacción
    $db->commit();

    echo json_encode([
        'success' => true,
        'pedido_id' => $pedido_id,
        'numero_pedido' => $numero_pedido,
        'total' => $total
    ]);

} catch (Exception $e) {
    // Revertir transacción en caso de error
    if (isset($db)) {
        $db->rollback();
    }

    http_response_code(500);
    echo json_encode(['error' => 'Error al crear pedido: ' . $e->getMessage()]);
}
?>
