<?php

// Script para verificar permisos del usuario admin
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

$admin = User::where('email', 'admin@cesodo.com')->first();

if ($admin) {
    echo "Usuario encontrado: " . $admin->name . "\n";
    echo "Email: " . $admin->email . "\n";
    echo "Estado: " . $admin->estado . "\n";
    echo "Roles: " . implode(', ', $admin->getRoleNames()->toArray()) . "\n";

    $permisos = $admin->getAllPermissions()->pluck('name')->toArray();
    echo "Permisos (" . count($permisos) . "): \n";
    foreach ($permisos as $permiso) {
        echo "  - " . $permiso . "\n";
    }

    // Verificar específicamente el permiso de inventario
    if ($admin->can('ver-inventario')) {
        echo "\n✅ El usuario TIENE el permiso 'ver-inventario'\n";
    } else {
        echo "\n❌ El usuario NO TIENE el permiso 'ver-inventario'\n";
    }
} else {
    echo "Usuario admin@cesodo.com no encontrado\n";
}
