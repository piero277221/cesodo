<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;
use Carbon\Carbon;

class MenusTableSeeder extends Seeder
{
    public function run()
    {
        // Crear algunos menús de ejemplo
        $menus = [
            [
                'nombre' => 'Menú Semana 1',
                'descripcion' => 'Menú variado para la primera semana',
                'fecha_inicio' => Carbon::now(),
                'fecha_fin' => Carbon::now()->addDays(7),
                'estado' => 'activo',
                'costo_estimado' => 1500.00,
                'tipo_menu' => 'semanal',
                'created_by' => 1
            ],
            [
                'nombre' => 'Menú Semana 2',
                'descripcion' => 'Menú variado para la segunda semana',
                'fecha_inicio' => Carbon::now()->addWeeks(1),
                'fecha_fin' => Carbon::now()->addWeeks(2),
                'estado' => 'borrador',
                'costo_estimado' => 1600.00,
                'tipo_menu' => 'semanal',
                'created_by' => 1
            ],
            [
                'nombre' => 'Menú Especial',
                'descripcion' => 'Menú para eventos especiales',
                'fecha_inicio' => Carbon::now()->addWeeks(3),
                'fecha_fin' => Carbon::now()->addWeeks(4),
                'estado' => 'borrador',
                'costo_estimado' => 800.00,
                'tipo_menu' => 'especial',
                'created_by' => 1
            ]
        ];

        foreach ($menus as $menu) {
            Menu::create($menu);
        }
    }
}
