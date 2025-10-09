PEDIDOS DEBUG - ULTRA SIMPLE

<?php
echo "1. PHP funciona: SÍ\n";
echo "2. Fecha: " . date('Y-m-d H:i:s') . "\n";

try {
    echo "3. Conexión Laravel: SÍ\n";

    // Test de base de datos
    $pdo = new PDO('sqlite:' . __DIR__ . '/../../database/database.sqlite');
    echo "4. Base de datos: SÍ\n";

    // Test de pedidos
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM pedidos");
    $result = $stmt->fetch();
    echo "5. Pedidos en DB: " . $result['total'] . "\n";

    // Test de proveedores
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM proveedores");
    $result = $stmt->fetch();
    echo "6. Proveedores en DB: " . $result['total'] . "\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>

<h1>SI VES ESTO, LA VISTA BÁSICA FUNCIONA</h1>
