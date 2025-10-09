<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Agregando columnas faltantes a la tabla users...\n";

try {
    // Agregar las columnas una por una
    DB::statement('ALTER TABLE users ADD COLUMN persona_id BIGINT UNSIGNED NULL AFTER estado');
    echo "✓ Columna persona_id agregada\n";

    DB::statement('ALTER TABLE users ADD COLUMN trabajador_id BIGINT UNSIGNED NULL AFTER persona_id');
    echo "✓ Columna trabajador_id agregada\n";

    DB::statement('ALTER TABLE users ADD COLUMN codigo_empleado VARCHAR(20) NULL AFTER trabajador_id');
    echo "✓ Columna codigo_empleado agregada\n";

    DB::statement('ALTER TABLE users ADD COLUMN ultimo_acceso TIMESTAMP NULL AFTER codigo_empleado');
    echo "✓ Columna ultimo_acceso agregada\n";

    DB::statement('ALTER TABLE users ADD COLUMN cambiar_password BOOLEAN DEFAULT FALSE AFTER ultimo_acceso');
    echo "✓ Columna cambiar_password agregada\n";

    DB::statement('ALTER TABLE users ADD COLUMN observaciones TEXT NULL AFTER cambiar_password');
    echo "✓ Columna observaciones agregada\n";

    echo "\n¡Todas las columnas fueron agregadas exitosamente!\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
