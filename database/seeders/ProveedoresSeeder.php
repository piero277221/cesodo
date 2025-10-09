<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Proveedor;

class ProveedoresSeeder extends Seeder
{
    public function run()
    {
        $proveedores = [
            [
                'ruc' => '20123456789',
                'razon_social' => 'Distribuidora Alimentos San Martín S.A.C.',
                'nombre_comercial' => 'Distribuidora San Martín',
                'telefono' => '01-234-5678',
                'email' => 'ventas@sanmartin.com',
                'direccion' => 'Av. Industrial 123, Lima, Perú',
                'contacto' => 'Carlos Mendoza',
                'estado' => 'activo'
            ],
            [
                'ruc' => '20987654321',
                'razon_social' => 'Comercial La Victoria E.I.R.L.',
                'nombre_comercial' => 'La Victoria',
                'telefono' => '01-987-6543',
                'email' => 'info@lavictoria.pe',
                'direccion' => 'Jr. Los Proveedores 456, San Isidro, Lima',
                'contacto' => 'María González',
                'estado' => 'activo'
            ],
            [
                'ruc' => '20456789123',
                'razon_social' => 'Importaciones Del Norte S.A.',
                'nombre_comercial' => 'Del Norte',
                'telefono' => '074-123-456',
                'email' => 'compras@delnorte.com',
                'direccion' => 'Av. Grau 789, Trujillo, La Libertad',
                'contacto' => 'José Ramírez',
                'estado' => 'activo'
            ],
            [
                'ruc' => '20789123456',
                'razon_social' => 'Productos de Limpieza Central S.R.L.',
                'nombre_comercial' => 'Central Limpieza',
                'telefono' => '01-555-7890',
                'email' => 'central@limpieza.pe',
                'direccion' => 'Av. Argentina 321, Callao, Lima',
                'contacto' => 'Ana Torres',
                'estado' => 'activo'
            ],
            [
                'ruc' => '20321654987',
                'razon_social' => 'Bebidas Premium Distribución S.A.C.',
                'nombre_comercial' => 'Premium Drinks',
                'telefono' => '01-777-4444',
                'email' => 'ventas@premiumdrinks.pe',
                'direccion' => 'Av. El Sol 147, Miraflores, Lima',
                'contacto' => 'Roberto Silva',
                'estado' => 'activo'
            ],
            [
                'ruc' => '20147258369',
                'razon_social' => 'Suministros Industriales Perú S.A.',
                'nombre_comercial' => 'SIP',
                'telefono' => '01-666-3333',
                'email' => 'contacto@sip.com.pe',
                'direccion' => 'Av. Colonial 852, San Miguel, Lima',
                'contacto' => 'Patricia Vega',
                'estado' => 'inactivo'
            ]
        ];

        foreach ($proveedores as $proveedorData) {
            Proveedor::create($proveedorData);
        }

        $this->command->info('Proveedores de ejemplo creados exitosamente.');
    }
}
