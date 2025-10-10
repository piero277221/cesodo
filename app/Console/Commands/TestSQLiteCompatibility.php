<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\DatabaseHelper;
use App\Models\Consumo;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TestSQLiteCompatibility extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:sqlite-compatibility';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test SQLite compatibility for date functions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Probando compatibilidad con SQLite...');

        try {
            // Probar la función que causaba el error original
            $consumosPorMes = Consumo::select(
                DB::raw(DatabaseHelper::yearExpression('fecha_consumo') . ' as año'),
                DB::raw(DatabaseHelper::monthExpression('fecha_consumo') . ' as mes'),
                DB::raw('COUNT(*) as total')
            )
            ->where('fecha_consumo', '>=', Carbon::now()->subMonths(12))
            ->groupBy('año', 'mes')
            ->orderBy('año', 'desc')
            ->orderBy('mes', 'desc')
            ->get();

            $this->info('✅ Consulta de consumos por mes ejecutada exitosamente');
            $this->table(['Año', 'Mes', 'Total'], $consumosPorMes->toArray());

            // Probar otras funciones
            $this->info('Probando otras funciones de fecha...');

            $yearExpr = DatabaseHelper::yearExpression('created_at');
            $monthExpr = DatabaseHelper::monthExpression('created_at');

            $this->info("Expresión de año: {$yearExpr}");
            $this->info("Expresión de mes: {$monthExpr}");

            $this->info('✅ Todas las pruebas pasaron exitosamente');

        } catch (\Exception $e) {
            $this->error('❌ Error en las pruebas:');
            $this->error($e->getMessage());
            $this->error($e->getTraceAsString());
            return 1;
        }

        return 0;
    }
}
