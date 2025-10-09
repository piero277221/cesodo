<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== ESTRUCTURA DE LA TABLA MENUS ===\n\n";

try {
    $columns = DB::select('DESCRIBE menus');
    echo "COLUMNAS EXISTENTES:\n";
    echo "===================\n";
    foreach($columns as $col) {
        echo "- {$col->Field} ({$col->Type})\n";
    }

    echo "\nVERIFICANDO SI EXISTE 'costo_total':\n";
    $costTotalExists = false;
    foreach($columns as $col) {
        if($col->Field === 'costo_total') {
            $costTotalExists = true;
            break;
        }
    }

    if($costTotalExists) {
        echo "✅ La columna 'costo_total' SÍ existe\n";
    } else {
        echo "❌ La columna 'costo_total' NO existe\n";
        echo "   Necesita ser agregada o reemplazada por otra columna\n";
    }

} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
}

?>
