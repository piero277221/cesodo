<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Producto;
use App\Models\Inventario;

echo "=== DIAGNÓSTICO DE PRODUCTOS E INVENTARIOS ===\n\n";

echo "PRODUCTOS EXISTENTES:\n";
echo "==================\n";
$productos = Producto::with('categoria')->get();
foreach($productos as $p) {
    echo "ID: {$p->id} - Código: {$p->codigo} - Nombre: {$p->nombre}\n";
    echo "   Categoría: " . ($p->categoria ? $p->categoria->nombre : 'Sin categoría') . "\n";
    echo "   Estado: {$p->estado}\n\n";
}

echo "INVENTARIOS EXISTENTES:\n";
echo "======================\n";
$inventarios = Inventario::with('producto')->get();
foreach($inventarios as $i) {
    echo "Producto ID: {$i->producto_id}\n";
    echo "   Producto: " . ($i->producto ? $i->producto->nombre : 'Producto eliminado') . "\n";
    echo "   Stock actual: {$i->stock_actual}\n";
    echo "   Stock disponible: {$i->stock_disponible}\n\n";
}

echo "PRODUCTOS SIN INVENTARIO:\n";
echo "========================\n";
$productosConInventario = Inventario::pluck('producto_id')->toArray();
$productosSinInventario = Producto::with('categoria')
    ->whereNotIn('id', $productosConInventario)
    ->get();

if($productosSinInventario->count() > 0) {
    foreach($productosSinInventario as $p) {
        echo "ID: {$p->id} - Código: {$p->codigo} - Nombre: {$p->nombre}\n";
        echo "   Categoría: " . ($p->categoria ? $p->categoria->nombre : 'Sin categoría') . "\n\n";
    }
} else {
    echo "Todos los productos ya tienen inventario asignado.\n";
}

?>
