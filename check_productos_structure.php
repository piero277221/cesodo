<?php

require_once 'vendor/autoload.php';

echo "🔍 Verificando estructura de tablas...\n\n";

try {
    // Obtener todas las tablas
    $tables = collect(DB::select('SHOW TABLES'))->map(function($table) {
        return array_values((array)$table)[0];
    });

    echo "📋 Todas las tablas:\n";
    $tables->each(function($table) {
        echo "  - $table\n";
    });

    echo "\n📊 Estructura de la tabla 'productos':\n";
    $columns = DB::select('DESCRIBE productos');
    foreach($columns as $column) {
        echo "  - {$column->Field} ({$column->Type})\n";
    }

    // Buscar tablas relacionadas con inventario
    echo "\n🔎 Buscando tablas de inventario/stock:\n";
    $inventarioTables = $tables->filter(function($table) {
        return str_contains($table, 'stock') ||
               str_contains($table, 'inventario') ||
               str_contains($table, 'kardex');
    });

    if($inventarioTables->count() > 0) {
        $inventarioTables->each(function($table) {
            echo "  ✅ Encontrada: $table\n";
        });
    } else {
        echo "  ❌ No se encontraron tablas de inventario\n";
    }

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
