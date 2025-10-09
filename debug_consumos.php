<?php

require_once 'vendor/autoload.php';
require_once 'bootstrap/app.php';

$app = require_once 'bootstrap/app.php';

use App\Models\Consumo;
use App\Models\Trabajador;

echo "=== DEBUG MÓDULO CONSUMOS ===\n\n";

try {
    echo "1. Verificando conexión a base de datos...\n";
    $consumos = Consumo::count();
    echo "   ✓ Conexión exitosa. Total consumos: $consumos\n\n";

    echo "2. Verificando trabajadores...\n";
    $trabajadores = Trabajador::count();
    echo "   ✓ Total trabajadores: $trabajadores\n\n";

    echo "3. Verificando relaciones...\n";
    $consumoConRelaciones = Consumo::with(['trabajador', 'user'])->first();
    if ($consumoConRelaciones) {
        echo "   ✓ Consumo encontrado con ID: " . $consumoConRelaciones->id . "\n";
        echo "   ✓ Trabajador: " . ($consumoConRelaciones->trabajador ? $consumoConRelaciones->trabajador->nombres : 'NULL') . "\n";
        echo "   ✓ Usuario: " . ($consumoConRelaciones->user ? $consumoConRelaciones->user->name : 'NULL') . "\n";
    } else {
        echo "   ! No hay consumos registrados\n";
    }

    echo "\n4. Probando estadísticas...\n";
    $totalHoy = Consumo::whereDate('fecha_consumo', today())->count();
    $totalSemana = Consumo::whereBetween('fecha_consumo', [now()->startOfWeek(), now()->endOfWeek()])->count();
    echo "   ✓ Consumos hoy: $totalHoy\n";
    echo "   ✓ Consumos esta semana: $totalSemana\n";

} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "Archivo: " . $e->getFile() . "\n";
    echo "Línea: " . $e->getLine() . "\n";
}

echo "\n=== FIN DEBUG ===\n";
