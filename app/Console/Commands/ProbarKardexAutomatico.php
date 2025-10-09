<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Consumo;
use App\Models\Trabajador;
use App\Models\User;
use App\Models\Kardex;

class ProbarKardexAutomatico extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kardex:probar-automatico';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Probar la funcionalidad automática del kardex al registrar un consumo';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== PRUEBA DE KARDEX AUTOMÁTICO ===');

        // Verificar datos iniciales
        $kardexInicial = Kardex::count();
        $this->info("Kardex inicial: {$kardexInicial} movimientos");

        // Obtener trabajador y usuario
        $trabajador = Trabajador::first();
        $user = User::first();

        if (!$trabajador || !$user) {
            $this->error('No hay trabajadores o usuarios disponibles');
            return;
        }

        $this->info("Trabajador: {$trabajador->nombres}");
        $this->info("Usuario: {$user->name}");

        // Crear consumo de prueba
        try {
            $consumo = Consumo::create([
                'trabajador_id' => $trabajador->id,
                'fecha_consumo' => now(),
                'hora_consumo' => now(),
                'tipo_comida' => 'almuerzo',
                'observaciones' => 'Prueba automática de kardex',
                'user_id' => $user->id,
            ]);

            $this->info("✅ Consumo creado con ID: {$consumo->id}");

            // Verificar si se crearon movimientos automáticos
            $kardexDespues = Kardex::count();
            $this->info("Kardex después: {$kardexDespues} movimientos");

            if ($kardexDespues > $kardexInicial) {
                $this->info('✅ ¡KARDEX AUTOMÁTICO FUNCIONANDO!');
                $movimientos = Kardex::with('producto')->latest()->take(5)->get();
                $this->info('Últimos movimientos creados:');
                foreach ($movimientos as $mov) {
                    $entrada = $mov->cantidad_entrada > 0 ? $mov->cantidad_entrada : '';
                    $salida = $mov->cantidad_salida > 0 ? $mov->cantidad_salida : '';
                    $this->line("- {$mov->producto->nombre}: {$mov->tipo_movimiento} E:{$entrada} S:{$salida} - {$mov->concepto}");
                }
            } else {
                $this->error('❌ No se crearon movimientos automáticos');

                // Información de debug
                $this->info('Debug: Verificando configuración...');
                $productosAlimentos = \App\Models\Producto::whereHas('categoria', function($q) {
                    $q->where('nombre', 'Alimentos');
                })->count();
                $this->info("Productos de alimentos disponibles: {$productosAlimentos}");
            }

        } catch (\Exception $e) {
            $this->error("ERROR: " . $e->getMessage());
            $this->error("Stack trace: " . $e->getTraceAsString());
        }
    }
}
