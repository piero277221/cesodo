<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Services\ReniecService;

$service = new ReniecService();

echo "==============================================\n";
echo "PRUEBA DE API RENIEC PERÚ\n";
echo "==============================================\n\n";

// DNI de prueba (ejemplo real de Perú)
$dniPrueba = '41821256';

echo "Consultando DNI: {$dniPrueba}\n\n";

$resultado = $service->consultarDni($dniPrueba);

echo "Resultado:\n";
print_r($resultado);

echo "\n==============================================\n";
