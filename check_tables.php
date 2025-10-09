<?php

require_once 'vendor/autoload.php';
require_once 'bootstrap/app.php';

use Illuminate\Support\Facades\DB;

try {
    $tables = DB::select('SHOW TABLES');
    echo "📋 Tablas disponibles:\n";
    foreach($tables as $table) {
        $tableName = array_values((array)$table)[0];
        echo "  - $tableName\n";
    }

    echo "\n📊 Estructura de la tabla 'consumos':\n";
    $columns = DB::select('DESCRIBE consumos');
    foreach($columns as $column) {
        echo "  - {$column->Field} ({$column->Type})\n";
    }

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
