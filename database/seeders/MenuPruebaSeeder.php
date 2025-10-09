<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;
use Carbon\Carbon;

class MenuPruebaSeeder extends Seeder
{
    public function run()
    {
        // Menú activo este mes
        Menu::create([
            'nombre' => 'Menú de Prueba 1',
            'descripcion' => 'Menú activo para este mes',
            'estado' => 'activo',
            'fecha_inicio' => Carbon::now(),
            'fecha_fin' => Carbon::now()->addDays(30),
            'costo_estimado' => 1500.00,
            'tipo_menu' => 'regular',
            'created_by' => 1
        ]);

        // Menú en borrador
        Menu::create([
            'nombre' => 'Menú de Prueba 2',
            'descripcion' => 'Menú en borrador',
            'estado' => 'borrador',
            'fecha_inicio' => Carbon::now()->addMonth(),
            'fecha_fin' => Carbon::now()->addMonth()->addDays(30),
            'costo_estimado' => 2000.00,
            'tipo_menu' => 'especial',
            'created_by' => 1
        ]);

        // Menú planificado
        Menu::create([
            'nombre' => 'Menú de Prueba 3',
            'descripcion' => 'Menú planificado',
            'estado' => 'planificado',
            'fecha_inicio' => Carbon::now()->addMonths(2),
            'fecha_fin' => Carbon::now()->addMonths(2)->addDays(30),
            'costo_estimado' => 2500.00,
            'tipo_menu' => 'regular',
            'created_by' => 1
        ]);
    }
}
