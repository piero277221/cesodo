<?php
// Script para verificar permisos del usuario actual

use Illuminate\Support\Facades\Auth;

$user = Auth::user();

if (!$user) {
    echo "No hay usuario autenticado\n";
    exit;
}

echo "Usuario: " . $user->name . " (ID: " . $user->id . ")\n";
echo "Email: " . $user->email . "\n";

// Verificar si el usuario tiene permisos
if (method_exists($user, 'can')) {
    echo "Permiso 'ver-productos': " . ($user->can('ver-productos') ? 'SÍ' : 'NO') . "\n";

    // Verificar todos los permisos del usuario
    if (method_exists($user, 'getAllPermissions')) {
        $permisos = $user->getAllPermissions();
        echo "Permisos del usuario:\n";
        foreach ($permisos as $permiso) {
            echo "- " . $permiso->name . "\n";
        }
    }

    // Verificar roles
    if (method_exists($user, 'getRoleNames')) {
        $roles = $user->getRoleNames();
        echo "Roles del usuario:\n";
        foreach ($roles as $rol) {
            echo "- " . $rol . "\n";
        }
    }
} else {
    echo "El sistema de permisos no está configurado\n";
}
?>
