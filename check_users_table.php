<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Columnas de la tabla users:\n";
$columns = DB::select('DESCRIBE users');
foreach($columns as $col) {
    echo "- {$col->Field} ({$col->Type})\n";
}
