<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            CategoriaSeeder::class,
            CategoriasSeeder::class,  // Categorías de productos
            ProductosPeruanosSeeder::class,  // Productos e ingredientes peruanos
            ProveedoresSeeder::class,  // Proveedores
            ClientesSeeder::class,  // Clientes
            PersonasSeeder::class,  // Personas
            MenusTableSeeder::class,
            MenuPruebaSeeder::class,
        ]);
    }
}
