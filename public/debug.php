<?php
// Mostrar errores PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>Debug Consumos - Errores PHP Habilitados</h1>";
echo "<hr>";

// Incluir Laravel
require_once '../vendor/autoload.php';

echo "<p style='color: green;'>✓ Autoload cargado</p>";

try {
    $app = require_once '../bootstrap/app.php';
    echo "<p style='color: green;'>✓ App Laravel inicializada</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error al inicializar Laravel: " . $e->getMessage() . "</p>";
    exit;
}

// Test del modelo Consumo
try {
    $consumos = \App\Models\Consumo::count();
    echo "<p style='color: green;'>✓ Modelo Consumo funcional: $consumos registros</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error en modelo Consumo: " . $e->getMessage() . "</p>";
}

// Test del modelo Trabajador
try {
    $trabajadores = \App\Models\Trabajador::count();
    echo "<p style='color: green;'>✓ Modelo Trabajador funcional: $trabajadores registros</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error en modelo Trabajador: " . $e->getMessage() . "</p>";
}

// Test del controlador
try {
    $controller = new \App\Http\Controllers\ConsumoController();
    echo "<p style='color: green;'>✓ ConsumoController instanciado correctamente</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error en ConsumoController: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<h2>Acceso directo al módulo:</h2>";
echo "<a href='/scm-cesodo/public/consumos' style='background: #007cba; color: white; padding: 10px; text-decoration: none; border-radius: 5px;'>🔗 Abrir Módulo de Consumos</a>";
?>
