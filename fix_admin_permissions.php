<?php

// Script para asignar rol administrador
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Spatie\Permission\Models\Role;

$admin = User::where('email', 'admin@cesodo.com')->first();

if ($admin) {
    echo "Usuario encontrado: " . $admin->name . "\n";

    // Verificar si existe el rol Administrador
    $rolAdmin = Role::where('name', 'Administrador')->first();

    if ($rolAdmin) {
        echo "Rol 'Administrador' encontrado\n";

        // Asignar rol al usuario
        $admin->assignRole('Administrador');
        echo "✅ Rol 'Administrador' asignado exitosamente\n";

        // Verificar permisos después de asignar el rol
        $permisos = $admin->fresh()->getAllPermissions()->pluck('name')->toArray();
        echo "Permisos después de asignar rol (" . count($permisos) . "):\n";

        if (count($permisos) > 0) {
            foreach (array_slice($permisos, 0, 10) as $permiso) {
                echo "  - " . $permiso . "\n";
            }
            if (count($permisos) > 10) {
                echo "  ... y " . (count($permisos) - 10) . " permisos más\n";
            }
        }

    } else {
        echo "❌ Rol 'Administrador' no encontrado\n";
        echo "Roles disponibles:\n";
        $roles = Role::all();
        foreach ($roles as $role) {
            echo "  - " . $role->name . "\n";
        }
    }
} else {
    echo "❌ Usuario admin@cesodo.com no encontrado\n";
}
