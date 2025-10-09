<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class FixUserPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix user permissions for products module';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Arreglando permisos de usuario...');

        // Obtener el primer usuario (probablemente el admin)
        $user = User::first();

        if (!$user) {
            $this->error("No hay usuarios en el sistema");
            return;
        }

        $this->info("Usuario encontrado: " . $user->name . " (ID: " . $user->id . ")");

        // Verificar si existe el permiso
        $permiso = Permission::where('name', 'ver-productos')->first();
        if (!$permiso) {
            $this->info("El permiso 'ver-productos' no existe, creándolo...");
            $permiso = Permission::create(['name' => 'ver-productos']);
        }

        // Verificar si el usuario tiene el permiso
        if (!$user->hasPermissionTo('ver-productos')) {
            $this->info("Asignando permiso 'ver-productos' al usuario...");
            $user->givePermissionTo('ver-productos');
        } else {
            $this->info("El usuario ya tiene el permiso 'ver-productos'");
        }

        // Verificar si existe el rol de administrador
        $adminRole = Role::where('name', 'Administrador')->first();
        if (!$adminRole) {
            $this->info("El rol 'Administrador' no existe, creándolo...");
            $adminRole = Role::create(['name' => 'Administrador']);
            $adminRole->givePermissionTo($permiso);
        }

        // Asignar rol de administrador si no lo tiene
        if (!$user->hasRole('Administrador')) {
            $this->info("Asignando rol 'Administrador' al usuario...");
            $user->assignRole('Administrador');
        } else {
            $this->info("El usuario ya tiene el rol 'Administrador'");
        }

        $this->info('Configuración completada exitosamente.');

        // Verificar permisos finales
        $this->info("Verificando permisos finales:");
        $this->info("- Tiene permiso 'ver-productos': " . ($user->can('ver-productos') ? 'SÍ' : 'NO'));
        $this->info("- Roles: " . implode(', ', $user->getRoleNames()->toArray()));
    }
}
