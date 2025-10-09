<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Consumo;
use App\Models\Trabajador;
use App\Models\User;

class ConsumoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        echo "Creando registros de consumos...\n";

        $trabajadores = Trabajador::all();
        $user = User::first();

        if ($trabajadores->isEmpty()) {
            echo "No hay trabajadores disponibles. Ejecute TrabajadorSeeder primero.\n";
            return;
        }

        if (!$user) {
            echo "No hay usuarios disponibles. Ejecute UserSeeder primero.\n";
            return;
        }

        $tiposComida = ['desayuno', 'almuerzo', 'cena', 'refrigerio'];

        // Crear consumos para los últimos 15 días
        for ($i = 0; $i < 15; $i++) {
            $fecha = now()->subDays($i);

            foreach ($trabajadores as $trabajador) {
                // Probabilidad del 80% de que el trabajador tenga consumo ese día
                if (rand(1, 100) <= 80) {
                    $tipoComida = $tiposComida[array_rand($tiposComida)];

                    // Verificar que no exista ya este consumo
                    $consumoExistente = Consumo::where('trabajador_id', $trabajador->id)
                        ->where('fecha_consumo', $fecha->format('Y-m-d'))
                        ->where('tipo_comida', $tipoComida)
                        ->first();

                    if (!$consumoExistente) {
                        Consumo::create([
                            'trabajador_id' => $trabajador->id,
                            'fecha_consumo' => $fecha->format('Y-m-d'),
                            'hora_consumo' => $this->getHoraPorTipoComida($tipoComida),
                            'tipo_comida' => $tipoComida,
                            'observaciones' => $this->getObservaciones($tipoComida),
                            'user_id' => $user->id,
                        ]);

                        echo "Consumo creado: {$trabajador->nombres} - {$tipoComida} - {$fecha->format('Y-m-d')}\n";
                    }
                }
            }
        }

        echo "Consumos completados!\n";
    }

    private function getHoraPorTipoComida($tipo)
    {
        switch ($tipo) {
            case 'desayuno':
                return '07:' . str_pad(rand(0, 59), 2, '0', STR_PAD_LEFT);
            case 'almuerzo':
                return '12:' . str_pad(rand(0, 59), 2, '0', STR_PAD_LEFT);
            case 'cena':
                return '18:' . str_pad(rand(0, 59), 2, '0', STR_PAD_LEFT);
            case 'refrigerio':
                return '15:' . str_pad(rand(0, 59), 2, '0', STR_PAD_LEFT);
            default:
                return '12:00';
        }
    }

    private function getObservaciones($tipo)
    {
        $observaciones = [
            'desayuno' => ['Desayuno completo', 'Solo bebida', 'Con frutas adicionales'],
            'almuerzo' => ['Menú completo', 'Sin postre', 'Doble ración', 'Dieta especial'],
            'cena' => ['Cena ligera', 'Menú completo', 'Sin bebida'],
            'refrigerio' => ['Fruta y bebida', 'Solo bebida', 'Galletas incluidas']
        ];

        $opciones = $observaciones[$tipo] ?? ['Sin observaciones'];
        return $opciones[array_rand($opciones)];
    }
}
