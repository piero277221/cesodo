<?php

// Test directo del módulo de consumos
echo "<h1>Test Módulo Consumos</h1>";
echo "<hr>";

// Incluir Laravel
require_once '../vendor/autoload.php';

$app = require_once '../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// Test básico
echo "<h2>1. Test Conexión Base de Datos</h2>";
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=scm_cesodo', 'root', '');
    echo "<p style='color: green;'>✓ Conexión a BD exitosa</p>";

    // Test tabla consumos
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM consumos");
    $result = $stmt->fetch();
    echo "<p style='color: blue;'>Total consumos: " . $result['total'] . "</p>";

    // Test tabla trabajadores
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM trabajadores");
    $result = $stmt->fetch();
    echo "<p style='color: blue;'>Total trabajadores: " . $result['total'] . "</p>";

} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error BD: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<h2>2. Test Ruta Consumos</h2>";
echo "<a href='/scm-cesodo/public/consumos' target='_blank'>→ Ir a Módulo Consumos</a>";
echo "<br><br>";
echo "<a href='/scm-cesodo/public/consumos/create' target='_blank'>→ Crear Nuevo Consumo</a>";

echo "<hr>";
echo "<h3>Debug Info</h3>";
echo "<p>Hora actual: " . date('Y-m-d H:i:s') . "</p>";
echo "<p>Directorio: " . __DIR__ . "</p>";
echo "<p>PHP Version: " . phpversion() . "</p>";
