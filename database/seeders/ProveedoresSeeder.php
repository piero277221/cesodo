<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProveedoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $proveedores = [
            ['ruc' => '20512345671', 'razon_social' => 'Distribuidora de Carnes La Granja SAC', 'nombre_comercial' => 'La Granja', 'telefono' => '014567890', 'email' => 'ventas@lagranja.com.pe', 'direccion' => 'Av. Colonial 1234, Lima', 'contacto' => 'Carlos Méndez', 'estado' => 'activo'],
            ['ruc' => '20512345672', 'razon_social' => 'Pescados y Mariscos del Pacífico EIRL', 'nombre_comercial' => 'Pacífico Fresco', 'telefono' => '014567891', 'email' => 'pedidos@pacifico.com.pe', 'direccion' => 'Terminal Pesquero Ventanilla, Callao', 'contacto' => 'María Torres', 'estado' => 'activo'],
            ['ruc' => '20512345673', 'razon_social' => 'Mercado Central de Verduras SAC', 'nombre_comercial' => 'Verde Perú', 'telefono' => '014567892', 'email' => 'ventas@verdeperu.com', 'direccion' => 'Mercado Central, Jr. Ucayali 789, Lima', 'contacto' => 'Juan Quispe', 'estado' => 'activo'],
            ['ruc' => '20512345674', 'razon_social' => 'Abarrotes Mayoristas Unidos SA', 'nombre_comercial' => 'AMU', 'telefono' => '014567893', 'email' => 'contacto@amu.com.pe', 'direccion' => 'Av. Argentina 456, Callao', 'contacto' => 'Roberto Silva', 'estado' => 'activo'],
            ['ruc' => '20512345675', 'razon_social' => 'Gloria SA', 'nombre_comercial' => 'Gloria', 'telefono' => '014567894', 'email' => 'ventas@gloria.com.pe', 'direccion' => 'Av. República de Panamá 2461, Lima', 'contacto' => 'Ana Rodríguez', 'estado' => 'activo'],
            ['ruc' => '20512345676', 'razon_social' => 'Condimentos del Perú SAC', 'nombre_comercial' => 'Condimentos Perú', 'telefono' => '014567895', 'email' => 'ventas@condimentosperu.com', 'direccion' => 'Av. Universitaria 234, Lima', 'contacto' => 'Pedro García', 'estado' => 'activo'],
            ['ruc' => '20512345677', 'razon_social' => 'Alicorp SAA', 'nombre_comercial' => 'Alicorp', 'telefono' => '014567896', 'email' => 'atencion@alicorp.com.pe', 'direccion' => 'Av. Néstor Gambetta 5150, Callao', 'contacto' => 'Luis Martínez', 'estado' => 'activo'],
            ['ruc' => '20512345678', 'razon_social' => 'Bebidas del Perú SA', 'nombre_comercial' => 'Arca Continental', 'telefono' => '014567897', 'email' => 'ventas@arcacontinental.com', 'direccion' => 'Av. Industrial 567, Lima', 'contacto' => 'Carmen Flores', 'estado' => 'activo'],
            ['ruc' => '20512345679', 'razon_social' => 'Cereales y Granos Andinos EIRL', 'nombre_comercial' => 'Granos Andinos', 'telefono' => '014567898', 'email' => 'contacto@granosandinos.com', 'direccion' => 'Av. Los Incas 890, Cusco', 'contacto' => 'José Huamán', 'estado' => 'activo'],
            ['ruc' => '20512345680', 'razon_social' => 'Distribuidora de Licores Premium SAC', 'nombre_comercial' => 'Licores Premium', 'telefono' => '014567899', 'email' => 'ventas@licorespremium.com', 'direccion' => 'Av. Caminos del Inca 123, Santiago de Surco', 'contacto' => 'Ricardo Pérez', 'estado' => 'activo'],
        ];

        foreach ($proveedores as $proveedor) {
            DB::table('proveedores')->insert(array_merge($proveedor, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
