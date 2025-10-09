<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CheckUser extends Command
{
    protected $signature = 'user:check';
    protected $description = 'Verificar usuarios en el sistema';

    public function handle()
    {
        $users = User::all();

        $this->info("Total de usuarios: " . $users->count());

        foreach ($users as $user) {
            $this->line("ID: {$user->id}, Nombre: {$user->name}, Email: {$user->email}");
        }

        // Crear usuario admin si no existe
        $admin = User::where('email', 'admin@cesodo.com')->first();

        if (!$admin) {
            $admin = User::create([
                'name' => 'Administrador Sistema',
                'email' => 'admin@cesodo.com',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]);

            $this->info("Usuario admin creado: admin@cesodo.com / admin123");
        } else {
            $this->info("Usuario admin ya existe: {$admin->email}");
        }

        // Asignar roles y permisos si existe Spatie
        if (class_exists('\Spatie\Permission\Models\Role')) {
            try {
                $adminRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Administrador']);

                $permissions = [
                    'ver-productos',
                    'crear-productos',
                    'editar-productos',
                    'eliminar-productos',
                    'ver-trabajadores',
                    'ver-inventario',
                    'ver-proveedores'
                ];

                foreach ($permissions as $permissionName) {
                    $permission = \Spatie\Permission\Models\Permission::firstOrCreate(['name' => $permissionName]);
                    $adminRole->givePermissionTo($permission);
                }

                $admin->assignRole($adminRole);
                $this->info("Roles y permisos asignados al usuario admin");

            } catch (\Exception $e) {
                $this->error("Error al asignar roles: " . $e->getMessage());
            }
        }

        return 0;
    }
}
