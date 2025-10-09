<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pedido;
use App\Models\DetallePedido;
use App\Models\Proveedor;
use App\Models\Producto;
use App\Models\User;

class PedidosSeeder extends Seeder
{
    public function run()
    {
        $proveedores = Proveedor::all();
        $productos = Producto::all();
        $users = User::all();

        if ($proveedores->isEmpty() || $productos->isEmpty() || $users->isEmpty()) {
            $this->command->info('Se necesitan proveedores, productos y usuarios para crear pedidos');
            return;
        }

        $pedidos = [
            [
                'proveedor_id' => $proveedores->random()->id,
                'fecha_pedido' => now()->subDays(10),
                'fecha_entrega_esperada' => now()->subDays(5),
                'fecha_entrega_real' => now()->subDays(5),
                'estado' => 'entregado',
                'observaciones' => 'Pedido urgente para reposición de stock',
                'user_id' => $users->first()->id,
                'productos' => [
                    ['producto_id' => $productos->random()->id, 'cantidad' => 50, 'precio_unitario' => 15.50],
                    ['producto_id' => $productos->random()->id, 'cantidad' => 30, 'precio_unitario' => 8.75],
                ]
            ],
            [
                'proveedor_id' => $proveedores->random()->id,
                'fecha_pedido' => now()->subDays(7),
                'fecha_entrega_esperada' => now()->addDays(3),
                'estado' => 'confirmado',
                'observaciones' => 'Pedido para promoción de fin de mes',
                'user_id' => $users->first()->id,
                'productos' => [
                    ['producto_id' => $productos->random()->id, 'cantidad' => 100, 'precio_unitario' => 12.00],
                    ['producto_id' => $productos->random()->id, 'cantidad' => 75, 'precio_unitario' => 18.25],
                    ['producto_id' => $productos->random()->id, 'cantidad' => 25, 'precio_unitario' => 45.00],
                ]
            ],
            [
                'proveedor_id' => $proveedores->random()->id,
                'fecha_pedido' => now()->subDays(3),
                'fecha_entrega_esperada' => now()->addDays(7),
                'estado' => 'pendiente',
                'observaciones' => 'Productos para nueva línea de ventas',
                'user_id' => $users->first()->id,
                'productos' => [
                    ['producto_id' => $productos->random()->id, 'cantidad' => 60, 'precio_unitario' => 22.50],
                    ['producto_id' => $productos->random()->id, 'cantidad' => 40, 'precio_unitario' => 16.80],
                ]
            ],
            [
                'proveedor_id' => $proveedores->random()->id,
                'fecha_pedido' => now()->subDays(15),
                'fecha_entrega_esperada' => now()->subDays(10),
                'fecha_entrega_real' => now()->subDays(8),
                'estado' => 'entregado',
                'observaciones' => 'Reposición mensual de productos básicos',
                'user_id' => $users->first()->id,
                'productos' => [
                    ['producto_id' => $productos->random()->id, 'cantidad' => 200, 'precio_unitario' => 5.25],
                    ['producto_id' => $productos->random()->id, 'cantidad' => 150, 'precio_unitario' => 7.50],
                    ['producto_id' => $productos->random()->id, 'cantidad' => 80, 'precio_unitario' => 13.75],
                ]
            ],
            [
                'proveedor_id' => $proveedores->random()->id,
                'fecha_pedido' => now()->subDays(2),
                'fecha_entrega_esperada' => now()->addDays(5),
                'estado' => 'pendiente',
                'observaciones' => 'Pedido especial para cliente corporativo',
                'user_id' => $users->first()->id,
                'productos' => [
                    ['producto_id' => $productos->random()->id, 'cantidad' => 120, 'precio_unitario' => 28.00],
                ]
            ],
        ];

        foreach ($pedidos as $pedidoData) {
            $productos_pedido = $pedidoData['productos'];
            unset($pedidoData['productos']);

            // Calcular total
            $total = 0;
            foreach ($productos_pedido as $prod) {
                $total += $prod['cantidad'] * $prod['precio_unitario'];
            }
            $pedidoData['total'] = $total;

            // Crear pedido
            $pedido = Pedido::create($pedidoData);

            // Crear detalles
            foreach ($productos_pedido as $prod) {
                DetallePedido::create([
                    'pedido_id' => $pedido->id,
                    'producto_id' => $prod['producto_id'],
                    'cantidad' => $prod['cantidad'],
                    'precio_unitario' => $prod['precio_unitario'],
                ]);
            }
        }

        $this->command->info('Se han creado 5 pedidos de ejemplo');
    }
}
