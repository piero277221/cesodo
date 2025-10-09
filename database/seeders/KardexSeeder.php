<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kardex;
use App\Models\Producto;
use App\Models\User;
use App\Models\Inventario;
use Carbon\Carbon;

class KardexSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener el primer usuario
        $user = User::first();
        if (!$user) {
            return;
        }

        // Obtener algunos productos
        $productos = Producto::take(5)->get();

        if ($productos->isEmpty()) {
            return;
        }

        $fechaInicio = Carbon::now()->subDays(30);

        foreach ($productos as $producto) {
            $saldoCantidad = 0;
            $saldoValor = 0;
            $fechaMovimiento = $fechaInicio->copy();

            // Crear movimiento inicial de entrada
            $cantidadEntrada = rand(50, 200);
            $precioUnitario = $producto->precio ?: rand(10, 100);
            $saldoCantidad = $cantidadEntrada;
            $saldoValor = $saldoCantidad * $precioUnitario;

            Kardex::create([
                'producto_id' => $producto->id,
                'fecha' => $fechaMovimiento,
                'tipo_movimiento' => 'entrada',
                'concepto' => 'Inventario inicial',
                'numero_documento' => 'INV-' . str_pad($producto->id, 4, '0', STR_PAD_LEFT),
                'cantidad_entrada' => $cantidadEntrada,
                'cantidad_salida' => 0,
                'precio_unitario' => $precioUnitario,
                'saldo_cantidad' => $saldoCantidad,
                'saldo_valor' => $saldoValor,
                'observaciones' => 'Movimiento de inventario inicial del sistema',
                'modulo' => 'inventario',
                'user_id' => $user->id,
            ]);

            // Crear varios movimientos adicionales
            for ($i = 1; $i <= rand(5, 15); $i++) {
                $fechaMovimiento->addDays(rand(1, 3));

                // Decidir tipo de movimiento (70% salidas, 20% entradas, 10% ajustes)
                $random = rand(1, 100);
                if ($random <= 70 && $saldoCantidad > 10) {
                    // Salida
                    $cantidadSalida = rand(1, min(20, $saldoCantidad - 5));
                    $saldoCantidad -= $cantidadSalida;
                    $precio = $saldoCantidad > 0 ? $saldoValor / ($saldoCantidad + $cantidadSalida) : $precioUnitario;
                    $saldoValor = $saldoCantidad * $precio;

                    $conceptos = [
                        'Venta directa',
                        'Consumo interno',
                        'Salida por pedido',
                        'Transferencia a sucursal',
                        'Muestra para cliente'
                    ];

                    Kardex::create([
                        'producto_id' => $producto->id,
                        'fecha' => $fechaMovimiento->copy(),
                        'tipo_movimiento' => 'salida',
                        'concepto' => $conceptos[array_rand($conceptos)],
                        'numero_documento' => 'SAL-' . str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT),
                        'cantidad_entrada' => 0,
                        'cantidad_salida' => $cantidadSalida,
                        'precio_unitario' => $precio,
                        'saldo_cantidad' => $saldoCantidad,
                        'saldo_valor' => $saldoValor,
                        'modulo' => 'inventario',
                        'user_id' => $user->id,
                    ]);

                } elseif ($random <= 90) {
                    // Entrada
                    $cantidadEntrada = rand(10, 50);
                    $nuevoPrecio = $precioUnitario * (1 + (rand(-10, 20) / 100)); // Variación de precio

                    // Calcular nuevo precio promedio ponderado
                    if ($saldoCantidad > 0) {
                        $precioPromedio = (($saldoValor) + ($cantidadEntrada * $nuevoPrecio)) / ($saldoCantidad + $cantidadEntrada);
                    } else {
                        $precioPromedio = $nuevoPrecio;
                    }

                    $saldoCantidad += $cantidadEntrada;
                    $saldoValor = $saldoCantidad * $precioPromedio;

                    $conceptos = [
                        'Compra a proveedor',
                        'Devolución de cliente',
                        'Transferencia desde sucursal',
                        'Producción interna',
                        'Ajuste por inventario físico'
                    ];

                    Kardex::create([
                        'producto_id' => $producto->id,
                        'fecha' => $fechaMovimiento->copy(),
                        'tipo_movimiento' => 'entrada',
                        'concepto' => $conceptos[array_rand($conceptos)],
                        'numero_documento' => 'ENT-' . str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT),
                        'cantidad_entrada' => $cantidadEntrada,
                        'cantidad_salida' => 0,
                        'precio_unitario' => $precioPromedio,
                        'saldo_cantidad' => $saldoCantidad,
                        'saldo_valor' => $saldoValor,
                        'modulo' => 'inventario',
                        'user_id' => $user->id,
                    ]);

                } else {
                    // Ajuste
                    $diferencia = rand(-5, 5);
                    if ($saldoCantidad + $diferencia >= 0) {
                        $saldoCantidad += $diferencia;
                        $precio = $saldoCantidad > 0 ? $saldoValor / ($saldoCantidad - $diferencia) : $precioUnitario;
                        $saldoValor = $saldoCantidad * $precio;

                        Kardex::create([
                            'producto_id' => $producto->id,
                            'fecha' => $fechaMovimiento->copy(),
                            'tipo_movimiento' => 'ajuste',
                            'concepto' => $diferencia > 0 ? 'Ajuste positivo por inventario físico' : 'Ajuste negativo por inventario físico',
                            'numero_documento' => 'AJU-' . str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT),
                            'cantidad_entrada' => $diferencia > 0 ? $diferencia : 0,
                            'cantidad_salida' => $diferencia < 0 ? abs($diferencia) : 0,
                            'precio_unitario' => $precio,
                            'saldo_cantidad' => $saldoCantidad,
                            'saldo_valor' => $saldoValor,
                            'observaciones' => 'Ajuste realizado después de inventario físico',
                            'modulo' => 'inventario',
                            'user_id' => $user->id,
                        ]);
                    }
                }
            }

            // Actualizar el inventario del producto
            $inventario = Inventario::firstOrNew(['producto_id' => $producto->id]);
            $inventario->stock_actual = $saldoCantidad;
            $inventario->fecha_ultimo_movimiento = $fechaMovimiento;
            $inventario->save();
        }
    }
}
