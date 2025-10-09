<?php

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

// Obtener el primer usuario (probablemente el admin)
$user = User::first();

if (!$user) {
    echo "No hay usuarios en el sistema\n";
    return;
}

echo "Usuario encontrado: " . $user->name . " (ID: " . $user->id . ")\n";

// Verificar si existe el permiso
$permiso = Permission::where('name', 'ver-productos')->first();
if (!$permiso) {
    echo "El permiso 'ver-productos' no existe, creándolo...\n";
    $permiso = Permission::create(['name' => 'ver-productos']);
}

// Verificar si el usuario tiene el permiso
if (!$user->hasPermissionTo('ver-productos')) {
    echo "Asignando permiso 'ver-productos' al usuario...\n";
    $user->givePermissionTo('ver-productos');
} else {
    echo "El usuario ya tiene el permiso 'ver-productos'\n";
}

// Verificar si existe el rol de administrador
$adminRole = Role::where('name', 'Administrador')->first();
if (!$adminRole) {
    echo "El rol 'Administrador' no existe, creándolo...\n";
    $adminRole = Role::create(['name' => 'Administrador']);
    $adminRole->givePermissionTo($permiso);
}

// Asignar rol de administrador si no lo tiene
if (!$user->hasRole('Administrador')) {
    echo "Asignando rol 'Administrador' al usuario...\n";
    $user->assignRole('Administrador');
} else {
    echo "El usuario ya tiene el rol 'Administrador'\n";
}

echo "Configuración completada.\n";
?>
