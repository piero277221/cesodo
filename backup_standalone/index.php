<?php
// Punto de entrada directo para el módulo de pedidos
require_once __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

// Simular una request a /pedidos
$_SERVER['REQUEST_URI'] = '/pedidos';
$_SERVER['REQUEST_METHOD'] = $_SERVER['REQUEST_METHOD'] ?? 'GET';

$request = Illuminate\Http\Request::create('/pedidos', $_SERVER['REQUEST_METHOD'], $_REQUEST);

try {
    $response = $app->handle($request);
    $response->send();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    echo "<br><a href='/scm-cesodo/public/index.php/auto-login'>Usar enlace de respaldo</a>";
}
?>
