<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AuthUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usuario Administrador
        User::firstOrCreate(
            ['email' => 'admin@cesodo.com'],
            [
                'name' => 'Administrador CESODO',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // Usuario normal
        User::firstOrCreate(
            ['email' => 'user@cesodo.com'],
            [
                'name' => 'Usuario CESODO',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // Gerente de Cocina
        User::firstOrCreate(
            ['email' => 'gerente@cesodo.com'],
            [
                'name' => 'Gerente de Cocina',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // Nutricionista
        User::firstOrCreate(
            ['email' => 'nutricionista@cesodo.com'],
            [
                'name' => 'Nutricionista CESODO',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Usuarios de autenticación creados correctamente.');
        $this->command->info('Credenciales de acceso:');
        $this->command->info('- Admin: admin@cesodo.com / password');
        $this->command->info('- Usuario: user@cesodo.com / password');
        $this->command->info('- Gerente: gerente@cesodo.com / password');
        $this->command->info('- Nutricionista: nutricionista@cesodo.com / password');
    }
}
