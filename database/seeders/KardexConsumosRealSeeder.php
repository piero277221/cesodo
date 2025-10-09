<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kardex;
use App\Models\Producto;
use App\Models\User;
use App\Models\Consumo;
use Carbon\Carbon;

class KardexConsumosRealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        echo "Creando movimientos de kardex basados en consumos reales...\n";

        $user = User::first();
        if (!$user) {
            echo "No hay usuarios en el sistema\n";
            return;
        }

        // Obtener productos de alimentos para consumos
        $productosAlimentos = Producto::whereHas('categoria', function($q) {
            $q->where('nombre', 'Alimentos');
        })->get();

        if ($productosAlimentos->isEmpty()) {
            echo "No hay productos de alimentos para consumos\n";
            return;
        }

        // Obtener consumos registrados
        $consumos = Consumo::orderBy('fecha_consumo')->get();

        if ($consumos->isEmpty()) {
            echo "No hay consumos registrados\n";
            return;
        }

        echo "Procesando " . $consumos->count() . " consumos registrados...\n";

        foreach ($productosAlimentos as $producto) {
            // 1. Entrada inicial al módulo de consumos
            $fechaInicial = $consumos->min('fecha_consumo');
            $cantidadInicial = 100; // Stock inicial para consumos
            $precioUnitario = $producto->precio ?: 25;

            Kardex::create([
                'producto_id' => $producto->id,
                'fecha' => $fechaInicial,
                'tipo_movimiento' => 'entrada',
                'modulo' => 'consumos',
                'concepto' => 'Transferencia inicial desde inventario',
                'numero_documento' => 'TRANS-INIT-' . str_pad($producto->id, 4, '0', STR_PAD_LEFT),
                'cantidad_entrada' => $cantidadInicial,
                'cantidad_salida' => 0,
                'precio_unitario' => $precioUnitario,
                'saldo_cantidad' => $cantidadInicial,
                'saldo_valor' => $cantidadInicial * $precioUnitario,
                'observaciones' => 'Stock inicial para módulo de consumos',
                'user_id' => $user->id,
            ]);

            echo "Stock inicial creado para {$producto->nombre}: {$cantidadInicial} unidades\n";
        }

        // 2. Crear salidas basadas en consumos reales agrupados por día
        $consumosPorDia = $consumos->groupBy(function($consumo) {
            return $consumo->fecha_consumo->format('Y-m-d');
        });

        foreach ($consumosPorDia as $fecha => $consumosDelDia) {
            $cantidadConsumidores = $consumosDelDia->count();

            // Por cada día, crear salidas proporcionales al número de consumidores
            foreach ($productosAlimentos as $producto) {
                // Cantidad base por persona según el tipo de producto
                $cantidadPorPersona = $this->getCantidadPorPersona($producto->nombre);
                $cantidadTotal = $cantidadConsumidores * $cantidadPorPersona;

                // Obtener el último saldo para este producto en consumos
                $ultimoKardex = Kardex::where('producto_id', $producto->id)
                    ->where('modulo', 'consumos')
                    ->where('fecha', '<=', $fecha)
                    ->orderBy('fecha', 'desc')
                    ->orderBy('id', 'desc')
                    ->first();

                if (!$ultimoKardex || $ultimoKardex->saldo_cantidad < $cantidadTotal) {
                    // Si no hay suficiente stock, hacer transferencia desde inventario
                    $cantidadTransferencia = max(50, $cantidadTotal * 2);
                    $precioUnitario = $ultimoKardex ? $ultimoKardex->precio_unitario : ($producto->precio ?: 25);

                    $nuevoSaldo = ($ultimoKardex ? $ultimoKardex->saldo_cantidad : 0) + $cantidadTransferencia;
                    $nuevoValor = $nuevoSaldo * $precioUnitario;

                    Kardex::create([
                        'producto_id' => $producto->id,
                        'fecha' => $fecha,
                        'tipo_movimiento' => 'entrada',
                        'modulo' => 'consumos',
                        'concepto' => 'Transferencia desde inventario',
                        'numero_documento' => 'TRANS-' . date('Ymd', strtotime($fecha)) . '-' . $producto->id,
                        'cantidad_entrada' => $cantidadTransferencia,
                        'cantidad_salida' => 0,
                        'precio_unitario' => $precioUnitario,
                        'saldo_cantidad' => $nuevoSaldo,
                        'saldo_valor' => $nuevoValor,
                        'observaciones' => "Transferencia para atender {$cantidadConsumidores} consumos",
                        'user_id' => $user->id,
                    ]);

                    echo "Transferencia realizada para {$producto->nombre}: {$cantidadTransferencia} unidades el {$fecha}\n";

                    // Actualizar saldos para el cálculo siguiente
                    $ultimoKardex = Kardex::where('producto_id', $producto->id)
                        ->where('modulo', 'consumos')
                        ->orderBy('fecha', 'desc')
                        ->orderBy('id', 'desc')
                        ->first();
                }

                // Crear salida por consumo
                if ($ultimoKardex && $ultimoKardex->saldo_cantidad >= $cantidadTotal) {
                    $nuevoSaldo = $ultimoKardex->saldo_cantidad - $cantidadTotal;
                    $precioPromedio = $ultimoKardex->saldo_cantidad > 0 ?
                        $ultimoKardex->saldo_valor / $ultimoKardex->saldo_cantidad :
                        $ultimoKardex->precio_unitario;
                    $nuevoValor = $nuevoSaldo * $precioPromedio;

                    Kardex::create([
                        'producto_id' => $producto->id,
                        'fecha' => $fecha,
                        'tipo_movimiento' => 'salida',
                        'modulo' => 'consumos',
                        'concepto' => 'Consumo de personal',
                        'numero_documento' => 'CONS-' . date('Ymd', strtotime($fecha)) . '-' . $producto->id,
                        'cantidad_entrada' => 0,
                        'cantidad_salida' => $cantidadTotal,
                        'precio_unitario' => $precioPromedio,
                        'saldo_cantidad' => $nuevoSaldo,
                        'saldo_valor' => $nuevoValor,
                        'observaciones' => "Consumo para {$cantidadConsumidores} personas",
                        'user_id' => $user->id,
                    ]);

                    echo "Consumo registrado para {$producto->nombre}: {$cantidadTotal} unidades el {$fecha}\n";
                }
            }
        }

        echo "Kardex de consumos completado basado en datos reales!\n";
    }

    /**
     * Obtener cantidad promedio por persona según el tipo de producto
     */
    private function getCantidadPorPersona($nombreProducto)
    {
        $nombreLower = strtolower($nombreProducto);

        if (strpos($nombreLower, 'arroz') !== false) {
            return 0.1; // 100g por persona
        } elseif (strpos($nombreLower, 'aceite') !== false) {
            return 0.02; // 20ml por persona
        } elseif (strpos($nombreLower, 'agua') !== false || strpos($nombreLower, 'mineral') !== false) {
            return 0.5; // 500ml por persona
        } elseif (strpos($nombreLower, 'café') !== false) {
            return 0.015; // 15g por persona
        } elseif (strpos($nombreLower, 'fideos') !== false) {
            return 0.08; // 80g por persona
        } else {
            return 0.05; // 50g por defecto
        }
    }
}
