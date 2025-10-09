<?php
require_once __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

echo "Estructura de la tabla menus:\n";
$columns = DB::select('SHOW COLUMNS FROM menus');
foreach ($columns as $column) {
    echo "- {$column->Field} ({$column->Type})\n";
}
?>
