<?php

use App\Models\User;
use Spatie\Permission\Models\Role;

// Verificar si el usuario admin existe y tiene roles
$admin = User::where('email', 'admin@cesodo.com')->first();

if ($admin) {
    echo "Usuario admin encontrado: " . $admin->name . "\n";

    // Verificar roles actuales
    $roles = $admin->getRoleNames();
    echo "Roles actuales: " . $roles->implode(', ') . "\n";

    // Si no tiene el rol Administrador, asignárselo
    if (!$admin->hasRole('Administrador')) {
        $adminRole = Role::where('name', 'Administrador')->first();
        if ($adminRole) {
            $admin->assignRole('Administrador');
            echo "Rol Administrador asignado.\n";
        } else {
            echo "Rol Administrador no existe.\n";
        }
    } else {
        echo "Usuario ya tiene rol Administrador.\n";
    }

    // Verificar permisos
    $permissions = $admin->getAllPermissions();
    echo "Permisos: " . $permissions->pluck('name')->implode(', ') . "\n";

} else {
    echo "Usuario admin no encontrado.\n";
}
