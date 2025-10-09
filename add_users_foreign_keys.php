<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Agregando foreign keys a la tabla users...\n";

try {
    // Verificar si las tablas personas y trabajadores existen
    $personasExists = DB::select("SHOW TABLES LIKE 'personas'");
    $trabajadoresExists = DB::select("SHOW TABLES LIKE 'trabajadores'");

    if (!empty($personasExists)) {
        DB::statement('ALTER TABLE users ADD CONSTRAINT users_persona_id_foreign FOREIGN KEY (persona_id) REFERENCES personas(id) ON DELETE SET NULL');
        echo "✓ Foreign key para persona_id agregada\n";
    } else {
        echo "⚠ Tabla personas no existe, omitiendo foreign key\n";
    }

    if (!empty($trabajadoresExists)) {
        DB::statement('ALTER TABLE users ADD CONSTRAINT users_trabajador_id_foreign FOREIGN KEY (trabajador_id) REFERENCES trabajadores(id) ON DELETE SET NULL');
        echo "✓ Foreign key para trabajador_id agregada\n";
    } else {
        echo "⚠ Tabla trabajadores no existe, omitiendo foreign key\n";
    }

    echo "\n¡Foreign keys configuradas exitosamente!\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    // Si hay error por foreign key duplicada, intentar continuar
    if (strpos($e->getMessage(), 'Duplicate key name') !== false) {
        echo "(El foreign key ya existe, continuando...)\n";
    }
}
