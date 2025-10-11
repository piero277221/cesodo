<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientesSeeder extends Seeder
{
    public function run(): void
    {
        $clientes = [
            ['ruc_dni' => '20501234567', 'tipo_documento' => 'ruc', 'razon_social' => 'Restaurante El Señorío SAC', 'nombre_comercial' => 'El Señorío', 'telefono' => '014445566', 'email' => 'contacto@elseniorio.com', 'direccion' => 'Av. La Mar 1234, Miraflores', 'distrito' => 'Miraflores', 'provincia' => 'Lima', 'departamento' => 'Lima', 'contacto_principal' => 'Luis Gonzales', 'telefono_contacto' => '987654321', 'tipo_cliente' => 'empresa', 'activo' => true, 'descuento_habitual' => 5.00, 'limite_credito' => 5000.00, 'dias_credito' => 15],
            ['ruc_dni' => '20501234568', 'tipo_documento' => 'ruc', 'razon_social' => 'Comedor Popular San Juan EIRL', 'nombre_comercial' => 'San Juan', 'telefono' => '014445567', 'email' => 'sanjuan@gmail.com', 'direccion' => 'Jr. Los Olivos 456, SJL', 'distrito' => 'San Juan de Lurigancho', 'provincia' => 'Lima', 'departamento' => 'Lima', 'contacto_principal' => 'María Castro', 'telefono_contacto' => '987654322', 'tipo_cliente' => 'empresa', 'activo' => true, 'descuento_habitual' => 3.00, 'limite_credito' => 3000.00, 'dias_credito' => 10],
            ['ruc_dni' => '72345678', 'tipo_documento' => 'dni', 'razon_social' => 'García Pérez, Ana', 'nombre_comercial' => null, 'telefono' => '987654323', 'email' => 'ana.garcia@email.com', 'direccion' => 'Av. Los Pinos 789, Lima', 'distrito' => 'Lima', 'provincia' => 'Lima', 'departamento' => 'Lima', 'contacto_principal' => 'Ana García', 'telefono_contacto' => '987654323', 'tipo_cliente' => 'persona', 'activo' => true, 'descuento_habitual' => 0.00, 'limite_credito' => 0.00, 'dias_credito' => 0],
            ['ruc_dni' => '20501234569', 'tipo_documento' => 'ruc', 'razon_social' => 'Hotel Costa del Sol SAC', 'nombre_comercial' => 'Costa del Sol', 'telefono' => '014445568', 'email' => 'compras@costahotel.com', 'direccion' => 'Av. Costanera 100, San Miguel', 'distrito' => 'San Miguel', 'provincia' => 'Lima', 'departamento' => 'Lima', 'contacto_principal' => 'Pedro Vargas', 'telefono_contacto' => '987654324', 'tipo_cliente' => 'empresa', 'activo' => true, 'descuento_habitual' => 8.00, 'limite_credito' => 10000.00, 'dias_credito' => 30],
            ['ruc_dni' => '72345679', 'tipo_documento' => 'dni', 'razon_social' => 'Rodríguez Sánchez, Carlos', 'nombre_comercial' => null, 'telefono' => '987654325', 'email' => 'carlos.rodriguez@email.com', 'direccion' => 'Jr. Las Flores 234, Surco', 'distrito' => 'Santiago de Surco', 'provincia' => 'Lima', 'departamento' => 'Lima', 'contacto_principal' => 'Carlos Rodríguez', 'telefono_contacto' => '987654325', 'tipo_cliente' => 'persona', 'activo' => true, 'descuento_habitual' => 0.00, 'limite_credito' => 0.00, 'dias_credito' => 0],
            ['ruc_dni' => '20501234570', 'tipo_documento' => 'ruc', 'razon_social' => 'Cevichería La Mar SAC', 'nombre_comercial' => 'La Mar', 'telefono' => '014445569', 'email' => 'pedidos@lamarcevicheria.com', 'direccion' => 'Av. La Mar 770, Miraflores', 'distrito' => 'Miraflores', 'provincia' => 'Lima', 'departamento' => 'Lima', 'contacto_principal' => 'José Acurio', 'telefono_contacto' => '987654326', 'tipo_cliente' => 'empresa', 'activo' => true, 'descuento_habitual' => 7.00, 'limite_credito' => 8000.00, 'dias_credito' => 20],
            ['ruc_dni' => '20501234571', 'tipo_documento' => 'ruc', 'razon_social' => 'Municipalidad Distrital de Ate', 'nombre_comercial' => 'Muni Ate', 'telefono' => '014445570', 'email' => 'compras@muniate.gob.pe', 'direccion' => 'Av. Separadora Industrial 2050, Ate', 'distrito' => 'Ate', 'provincia' => 'Lima', 'departamento' => 'Lima', 'contacto_principal' => 'Juana Quispe', 'telefono_contacto' => '987654327', 'tipo_cliente' => 'gobierno', 'activo' => true, 'descuento_habitual' => 0.00, 'limite_credito' => 20000.00, 'dias_credito' => 60],
            ['ruc_dni' => '72345680', 'tipo_documento' => 'dni', 'razon_social' => 'Torres López, María', 'nombre_comercial' => null, 'telefono' => '987654328', 'email' => 'maria.torres@email.com', 'direccion' => 'Av. Universitaria 456, Los Olivos', 'distrito' => 'Los Olivos', 'provincia' => 'Lima', 'departamento' => 'Lima', 'contacto_principal' => 'María Torres', 'telefono_contacto' => '987654328', 'tipo_cliente' => 'persona', 'activo' => true, 'descuento_habitual' => 0.00, 'limite_credito' => 0.00, 'dias_credito' => 0],
        ];

        foreach ($clientes as $cliente) {
            DB::table('clientes')->insert(array_merge($cliente, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
