<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usuario Administrador
        $admin = User::create([
            'name' => 'Administrador Sistema',
            'email' => 'admin@cesodo.com',
            'password' => Hash::make('admin123'),
            'dni' => '12345678',
            'telefono' => '987654321',
            'estado' => 'activo',
        ]);
        $admin->assignRole('Administrador');

        // Usuario Almacenero
        $almacenero = User::create([
            'name' => 'Juan Pérez',
            'email' => 'almacenero@cesodo.com',
            'password' => Hash::make('almacen123'),
            'dni' => '87654321',
            'telefono' => '987654322',
            'estado' => 'activo',
        ]);
        $almacenero->assignRole('Almacenero');

        // Usuario Supervisor
        $supervisor = User::create([
            'name' => 'María García',
            'email' => 'supervisor@cesodo.com',
            'password' => Hash::make('super123'),
            'dni' => '11223344',
            'telefono' => '987654323',
            'estado' => 'activo',
        ]);
        $supervisor->assignRole('Supervisor');

        // Usuario Personal de Atención
        $personal = User::create([
            'name' => 'Carlos López',
            'email' => 'personal@cesodo.com',
            'password' => Hash::make('personal123'),
            'dni' => '44332211',
            'telefono' => '987654324',
            'estado' => 'activo',
        ]);
        $personal->assignRole('Personal de Atención');
    }
}
