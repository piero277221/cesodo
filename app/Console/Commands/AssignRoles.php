<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AssignRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'roles:assign';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign roles to users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Verificando y asignando roles...');

        // Usuario admin
        $admin = User::where('email', 'admin@cesodo.com')->first();
        if ($admin) {
            if (!$admin->hasRole('Administrador')) {
                $admin->assignRole('Administrador');
                $this->info('Rol Administrador asignado a admin@cesodo.com');
            } else {
                $this->info('admin@cesodo.com ya tiene rol Administrador');
            }
        }

        // Usuario almacenero
        $almacenero = User::where('email', 'almacenero@cesodo.com')->first();
        if ($almacenero) {
            if (!$almacenero->hasRole('Almacenero')) {
                $almacenero->assignRole('Almacenero');
                $this->info('Rol Almacenero asignado a almacenero@cesodo.com');
            } else {
                $this->info('almacenero@cesodo.com ya tiene rol Almacenero');
            }
        }

        // Usuario supervisor
        $supervisor = User::where('email', 'supervisor@cesodo.com')->first();
        if ($supervisor) {
            if (!$supervisor->hasRole('Supervisor')) {
                $supervisor->assignRole('Supervisor');
                $this->info('Rol Supervisor asignado a supervisor@cesodo.com');
            } else {
                $this->info('supervisor@cesodo.com ya tiene rol Supervisor');
            }
        }

        // Usuario personal
        $personal = User::where('email', 'personal@cesodo.com')->first();
        if ($personal) {
            if (!$personal->hasRole('Personal de Atención')) {
                $personal->assignRole('Personal de Atención');
                $this->info('Rol Personal de Atención asignado a personal@cesodo.com');
            } else {
                $this->info('personal@cesodo.com ya tiene rol Personal de Atención');
            }
        }

        $this->info('Proceso completado!');
    }
}
