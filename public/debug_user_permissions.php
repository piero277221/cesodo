<?php
// Debug de permisos del usuario
require_once __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Auth;
use App\Models\User;

// Simular autenticación con el primer usuario admin
$user = User::where('email', 'admin@cesodo.com')->orWhere('name', 'like', '%admin%')->first();

if (!$user) {
    $user = User::first(); // Tomar el primer usuario disponible
}

if ($user) {
    Auth::login($user);

    echo "<h1>Debug de Permisos del Usuario</h1>";
    echo "<h2>Usuario Actual:</h2>";
    echo "<p>ID: " . $user->id . "</p>";
    echo "<p>Nombre: " . $user->name . "</p>";
    echo "<p>Email: " . $user->email . "</p>";

    echo "<h2>Roles:</h2>";
    if (method_exists($user, 'getRoleNames')) {
        foreach ($user->getRoleNames() as $role) {
            echo "<p>- " . $role . "</p>";
        }
    } else {
        echo "<p>No se puede obtener roles (método no disponible)</p>";
    }

    echo "<h2>Permisos:</h2>";
    $permissions = ['ver-productos', 'ver-trabajadores', 'ver-inventario', 'ver-proveedores'];

    foreach ($permissions as $permission) {
        if (method_exists($user, 'can')) {
            $hasPermission = $user->can($permission) ? 'SÍ' : 'NO';
            echo "<p>$permission: <strong>$hasPermission</strong></p>";
        } else {
            echo "<p>$permission: <strong>NO SE PUEDE VERIFICAR</strong></p>";
        }
    }

    echo "<h2>Blade @can Test:</h2>";
    echo "<p>Testing @can('ver-productos')...</p>";

    // Simular el comportamiento de @can
    if ($user->can('ver-productos')) {
        echo "<div style='background: green; color: white; padding: 10px;'>✓ El usuario PUEDE ver productos (debería ver módulo categorías)</div>";
    } else {
        echo "<div style='background: red; color: white; padding: 10px;'>✗ El usuario NO puede ver productos</div>";
    }

} else {
    echo "<h1>No se encontró ningún usuario</h1>";
}
?>
