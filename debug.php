<?php
// Debug simple para verificar conexión a base de datos
require __DIR__ . '/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

// Cargar configuración básica
$config = require __DIR__ . '/config/database.php';

$capsule = new Capsule;
$capsule->addConnection($config['connections']['mysql']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

try {
    // Conectar a la base de datos directamente
    $pdo = new PDO(
        "mysql:host=localhost;dbname=scm_cesodo", 
        "root", 
        "", 
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    
    echo "<h1>Debug Database Connection</h1>";
    echo "<p>✅ Conexión a base de datos exitosa</p>";
    
    // Verificar tabla trabajadores
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM trabajadores");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<p>📊 Total trabajadores en BD: " . $result['total'] . "</p>";
    
    // Mostrar trabajadores
    $stmt = $pdo->query("SELECT codigo, nombres, apellidos FROM trabajadores LIMIT 5");
    $trabajadores = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h3>Trabajadores en BD:</h3>";
    foreach($trabajadores as $trabajador) {
        echo "<p>• {$trabajador['codigo']} - {$trabajador['nombres']} {$trabajador['apellidos']}</p>";
    }
    
} catch(Exception $e) {
    echo "<h1>❌ Error de conexión</h1>";
    echo "<p>" . $e->getMessage() . "</p>";
}
?>
