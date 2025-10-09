<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear permisos
        $permissions = [
            // Usuarios
            'ver-usuarios',
            'crear-usuarios',
            'editar-usuarios',
            'eliminar-usuarios',

            // Trabajadores
            'ver-trabajadores',
            'crear-trabajadores',
            'editar-trabajadores',
            'eliminar-trabajadores',

            // Proveedores
            'ver-proveedores',
            'crear-proveedores',
            'editar-proveedores',
            'eliminar-proveedores',

            // Productos
            'ver-productos',
            'crear-productos',
            'editar-productos',
            'eliminar-productos',

            // Inventario
            'ver-inventario',
            'gestionar-inventario',
            'ver-movimientos-inventario',
            'crear-movimientos-inventario',

            // Consumos
            'ver-consumos',
            'registrar-consumos',
            'editar-consumos',
            'eliminar-consumos',

            // Pedidos
            'ver-pedidos',
            'crear-pedidos',
            'editar-pedidos',
            'eliminar-pedidos',
            'aprobar-pedidos',

            // Reportes
            'ver-reportes',
            'exportar-reportes',

            // Dashboard
            'ver-dashboard',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Crear roles
        $adminRole = Role::create(['name' => 'Administrador']);
        $almaceneroRole = Role::create(['name' => 'Almacenero']);
        $supervisorRole = Role::create(['name' => 'Supervisor']);
        $personalRole = Role::create(['name' => 'Personal de Atención']);

        // Asignar permisos a roles

        // Administrador: todos los permisos
        $adminRole->givePermissionTo(Permission::all());

        // Almacenero: gestión de inventario, productos, proveedores
        $almaceneroRole->givePermissionTo([
            'ver-dashboard',
            'ver-productos', 'crear-productos', 'editar-productos',
            'ver-proveedores', 'crear-proveedores', 'editar-proveedores',
            'ver-inventario', 'gestionar-inventario', 'ver-movimientos-inventario', 'crear-movimientos-inventario',
            'ver-pedidos', 'crear-pedidos', 'editar-pedidos',
            'ver-reportes',
        ]);

        // Supervisor: consumos, reportes, trabajadores
        $supervisorRole->givePermissionTo([
            'ver-dashboard',
            'ver-trabajadores', 'crear-trabajadores', 'editar-trabajadores',
            'ver-consumos', 'registrar-consumos', 'editar-consumos',
            'ver-inventario',
            'ver-reportes', 'exportar-reportes',
        ]);

        // Personal de Atención: solo registro de consumos
        $personalRole->givePermissionTo([
            'ver-dashboard',
            'ver-trabajadores',
            'ver-consumos', 'registrar-consumos',
        ]);
    }
}
