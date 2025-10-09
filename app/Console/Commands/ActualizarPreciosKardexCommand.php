<?php

namespace App\Console\Commands;

use App\Models\Kardex;
use App\Models\Producto;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ActualizarPreciosKardexCommand extends Command
{
    protected $signature = 'kardex:actualizar-precios {--D|dry-run : Mostrar los cambios sin aplicarlos}';
    protected $description = 'Actualiza los precios en el kardex basándose en los precios actuales de los productos';

    public function handle()
    {
        $this->info('Iniciando actualización de precios en el kardex...');

        // Obtener todos los productos con sus precios actuales
        $productos = Producto::select('id', 'nombre', 'precio_unitario')->get();

        $this->info('Se encontraron ' . $productos->count() . ' productos para procesar.');

        $totalActualizaciones = 0;
        $errores = [];

        try {
            DB::beginTransaction();

            foreach ($productos as $producto) {
                $this->info("\nProcesando producto: {$producto->nombre}");

                // Obtener movimientos del kardex para este producto
                $movimientos = Kardex::where('producto_id', $producto->id)
                    ->orderBy('fecha', 'asc')
                    ->orderBy('id', 'asc')
                    ->get();

                if ($movimientos->isEmpty()) {
                    $this->warn("No hay movimientos para el producto {$producto->nombre}");
                    continue;
                }

                $saldoCantidad = 0;

                foreach ($movimientos as $movimiento) {
                    $precioAnterior = $movimiento->precio_unitario;

                    // Actualizar cantidad
                    $saldoCantidad += ($movimiento->cantidad_entrada - $movimiento->cantidad_salida);

                    // Calcular nuevo saldo valor
                    $nuevoSaldoValor = $saldoCantidad * $producto->precio_unitario;

                    if ($this->option('dry-run')) {
                        $this->info("  [Simulación] Movimiento ID {$movimiento->id}:");
                        $this->info("    - Precio anterior: S/ " . number_format($precioAnterior, 2));
                        $this->info("    - Nuevo precio: S/ " . number_format($producto->precio_unitario, 2));
                        $this->info("    - Nuevo saldo valor: S/ " . number_format($nuevoSaldoValor, 2));
                    } else {
                        $movimiento->update([
                            'precio_unitario' => $producto->precio_unitario,
                            'saldo_cantidad' => $saldoCantidad,
                            'saldo_valor' => $nuevoSaldoValor
                        ]);
                        $totalActualizaciones++;
                    }
                }
            }

            if (!$this->option('dry-run')) {
                DB::commit();
                $this->info("\n¡Actualización completada!");
                $this->info("Total de movimientos actualizados: {$totalActualizaciones}");
            } else {
                DB::rollBack();
                $this->info("\n[Simulación completada]");
                $this->info("Se actualizarían {$totalActualizaciones} movimientos");
            }

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("\nError durante la actualización: " . $e->getMessage());
            return 1;
        }

        if (!empty($errores)) {
            $this->warn("\nSe encontraron los siguientes errores:");
            foreach ($errores as $error) {
                $this->warn("- {$error}");
            }
        }

        return 0;
    }
}
